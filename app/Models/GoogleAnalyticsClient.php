<?php

namespace App\Models;

use Cache;
use File;
use Google_Client;
use Google_Service_Analytics;
use Illuminate\Support\Collection;

class GoogleAnalyticsClient
{
    /**
     * @var Google_Service_Analytics $service
     */
    protected $service;

    /**
     * @var integer $viewId
     */
    protected $viewId;

    /**
     * GoogleAnalyticsClient constructor.
     */
    public function __construct()
    {
        $this->setService(config('analytics.service_account_credentials_json'));
        $this->setViewId(env('ANALYTICS_VIEW_ID', null));
    }

    /**
     * Login google api and get Google Analytics service connection
     * @param string $credentialPath is a JSON file path
     */
    public function setService($credentialPath)
    {
        try {
            $client = new Google_Client();
            $client->setScopes([Google_Service_Analytics::ANALYTICS_READONLY]);
            $client->setAuthConfig($credentialPath);
            $this->service = new Google_Service_Analytics($client);
        } catch (\Exception $e) {
            $this->service = null;
        }
    }

    /**
     * @param string $viewId
     */
    public function setViewId($viewId)
    {
        $this->viewId = $viewId;
    }

    /**
     * @param string $dataType can be blows ga, rt
     * @param array $params
     * @return null
     */
    public function query($dataType = 'ga', $params = [])
    {
        switch($dataType) {
            case 'ga':
                if(count($params) > 0) {
                    try {
                        $result = $this->service->data_ga->get(
                            "ga:{$this->viewId}",
                            date('Y-m-d', ($params['startTime'] ?? time())),
                            date('Y-m-d', ($params['endTime'] ?? time())),
                            ($params['metrics'] ?? ''),
                            $others = ($params['others'] ?? [])
                        );

                        while ($nextLink = $result->getNextLink()) {
                            if (isset($others['max-results']) && count($result->rows) >= $others['max-results']) {
                                break;
                            }
                            $options = [];
                            parse_str(substr($nextLink, strpos($nextLink, '?') + 1), $options);
                            $response = $this->service->data_ga->call('get', [$options], 'Google_Service_Analytics_GaData');
                            if ($response->rows) {
                                $result->rows = array_merge($result->rows, $response->rows);
                            }
                            $result->nextLink = $response->nextLink;
                        }
                    } catch (\Exception $e) {
                        $result = null;
                    }
                }
                break;
            case 'rt':
                if(is_string($params) || (is_array($params) && count($params) > 0)) {
                    $result = $this->service->data_realtime->get(
                        "ga:{$this->viewId}",
                        is_string($params) ? $params : ($params['metrics'] ?? '')
                    );
                }
                break;
        }

        return $result ?? null;
    }

    /**
     * @return string
     */
    public function getActiveVisitors()
    {
        $response = Cache::remember('activeVisitors', 1, function() {
            return $this->query('rt', [
                'metrics' => 'rt:activeVisitors'
            ]);
        });

        return $response->totalsForAllResults['rt:activeVisitors'] ?? '-';
    }

    /**
     * @return integer|string
     */
    public function getTodayTotalVisitors()
    {
        $response = Cache::remember('todayTotalVisitors', 10, function() {
            return $this->query('ga', [
                'startTime' => strtotime("-1 days"),
                'endTime' => time(),
                'metrics' => 'ga:users',
                'others' => [
                    'dimensions' => 'ga:date'
                ]
            ]);
        });

        $visitorAmount = collect($response->rows ?? [])->map(function($item) {
            return (int) $item[1];
        });

        return $visitorAmount->count() > 0 ? $visitorAmount->last() : '-';
    }

    /**
     * @param int $days
     * @param int $decimals
     * @return string
     */
    public function getPageViewsPerSession($days = 30, $decimals = 2)
    {
        $response = Cache::remember('pageViewsPerSession', config('analytics.cache_lifetime_in_minutes'), function() use ($days) {
            return $this->query('ga', [
                'startTime' => strtotime("-{$days} days"),
                'endTime' => time(),
                'metrics' => 'ga:pageviewsPerSession'
            ]);
        });

        return isset($response[0][0]) ? number_format($response[0][0], $decimals) : '-';
    }

    /**
     * @param int $days
     * @return string
     */
    public function getAvgTimeOnPage($days = 30)
    {
        $response = Cache::remember('avgTimeOnPage', config('analytics.cache_lifetime_in_minutes'), function() use ($days) {
            return $this->query('ga', [
                'startTime' => strtotime("-{$days} days"),
                'endTime' => time(),
                'metrics' => 'ga:avgTimeOnPage'
            ]);
        });

        return isset($response[0][0]) ? gmdate('H:i:s', $response[0][0]) : '--:--:--';
    }

    /**
     * @param int $days
     * @param int $decimals
     * @return string
     */
    public function getExitRate($days = 30, $decimals = 2)
    {
        $response = Cache::remember('exitRate', config('analytics.cache_lifetime_in_minutes'), function() use ($days) {
            return $this->query('ga', [
                'startTime' => strtotime("-{$days} days"),
                'endTime' => time(),
                'metrics' => 'ga:exitRate'
            ]);
        });

        return isset($response[0][0]) ? number_format($response[0][0], $decimals) : '-';
    }

    /**
     * @param int $days
     * @param int $maxResults
     * @return Collection
     */
    public function getTopBrowsers($days = 30, $maxResults = 3)
    {
        $response = Cache::remember('topBrowsers', config('analytics.cache_lifetime_in_minutes'), function() use ($days) {
            return $this->query('ga', [
                'startTime' => strtotime("-{$days} days"),
                'endTime' => time(),
                'metrics' => 'ga:sessions',
                'others' => [
                    'dimensions' => 'ga:browser',
                    'sort' => '-ga:sessions',
                ]
            ]);
        });

        $browsers = collect($response->rows ?? [])->map(function($item) {
            return [
                'browser' => $item[0],
                'sessions' => (int) $item[1],
            ];
        });
        if ($browsers->count() <= $maxResults) {
            return $browsers;
        }

        return $browsers
            ->take($maxResults - 1)
            ->push([
                'browser' => 'Others',
                'sessions' => $browsers->splice($maxResults - 1)->sum('sessions'),
            ]);
    }

    /**
     * @param int $days
     * @return Collection
     */
    public function getReferrerKeyword($days = 30)
    {
        $response = Cache::remember('referrerKeyword', 10, function() use ($days) {
            return $this->query('ga', [
                'startTime' => strtotime("-{$days} days"),
                'endTime' => time(),
                'metrics' => 'ga:users',
                'others' => [
                    'dimensions' => 'ga:keyword'
                ]
            ]);
        });

        $keywords = collect($response->rows ?? [])->map(function($item) {
            switch($item[0]) {
                case '(not set)':
                    $keyword = '(not provided)';
                    break;
                default:
                    $keyword = $item[0];
            }

            return [
                'keyword' => $keyword,
                'count' => number_format($item[1], 0),
            ];
        });

        return $keywords;
    }

    /**
     * @param int $days
     */
    public function putSourceMedium($days = 30)
    {
        $response = Cache::remember('sourceMedium', config('analytics.cache_lifetime_in_minutes'), function() use ($days) {
            return $this->query('ga', [
                'startTime' => strtotime("-{$days} days"),
                'endTime' => time(),
                'metrics' => 'ga:sessions',
                'others' => [
                    'dimensions' => 'ga:sourceMedium',
                    'sort' => '-ga:sessions',
                ]
            ]);
        });

        $sourceData = collect($response->rows ?? [])->map(function($item) {
            return [
                'source' => $item[0] == '(direct) / (none)' ? 'Direct 直接' : $item[0],
                'count' => $item[1]
            ];
        })->toJson(JSON_UNESCAPED_UNICODE);

        File::put(public_path('admin/data/live-analytics-traffic.json'), $sourceData);
    }

    /**
     * @param int $days
     */
    public function putSourceCountry($days = 30)
    {
        $response = Cache::remember('sourceCountry', config('analytics.cache_lifetime_in_minutes'), function() use ($days) {
            return $this->query('ga', [
                'startTime' => strtotime("-{$days} days"),
                'endTime' => time(),
                'metrics' => 'ga:sessions',
                'others' => [
                    'dimensions' => 'ga:country'
                ]
            ]);
        });

        $sourceCountryData = collect($response->rows ?? [])->mapWithKeys(function($item) {
            return [$item[0] => $item[1]];
        })->toArray();

        try {
            $mapCollection = collect(json_decode(File::get(public_path('admin/data/template-analytics-country.json')), true))
                ->filter(function($item) use ($sourceCountryData) {
                    if(array_key_exists($item['name'], $sourceCountryData)) {
                        return true;
                    }
                    return false;
                })
                ->values()
                ->map(function($item) use ($sourceCountryData) {
                    $item['value'] = $sourceCountryData[$item['name']];
                    return $item;
                })
                ->toJson(JSON_UNESCAPED_UNICODE);

            File::put(public_path('admin/data/live-analytics-country.json'), $mapCollection);
        } catch (\Exception $e) {}
    }
}