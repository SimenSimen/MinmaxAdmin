@extends('admin.default.edit')

@section('action-buttons')
@if($adminData->can('roleShow'))
<div class="float-right">
    <a class="btn btn-sm btn-light" href="{{ route('admin.index', [$pageData->uri]) }}" title="@lang('admin.form.back_list')">
        <i class="icon-undo2"></i><span class="ml-1 d-none d-md-inline-block">@lang('admin.form.back_list')</span>
    </a>
</div>
@endif
@endsection

@section('forms')
    @inject('modelPresenter', 'App\Presenters\Admin\RolePresenter')

    <fieldset id="baseFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>主要設定</legend>

        {!! $modelPresenter->getFieldSelect($formData, 'guard', true) !!}

        {!! $modelPresenter->getFieldText($formData, 'name', true, ['size' => 4]) !!}

        {!! $modelPresenter->getFieldText($formData, 'display_name', true, ['size' => 4]) !!}

        {!! $modelPresenter->getFieldText($formData, 'description') !!}

    </fieldset>

    <fieldset class="mt-4" id="advFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>進階選項</legend>

        {!! $modelPresenter->getFieldRadio($formData, 'active', true, ['inline' => true]) !!}

    </fieldset>

    <fieldset class="mt-4" id="advFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>權限設定</legend>

        <div class="form-group row">
            <div class="col">
                <select class="multiSelect" name="PermissionRole[]" multiple="">
                    @foreach($permissionData as $groupItem)
                    <optgroup label="{{ explode(' [', $groupItem->first()->display_name)[0] }}">
                        @foreach($groupItem as $permissionItem)
                        <option value="{{ $permissionItem->id }}" {{ $formData->perms->map(function($item, $key) { return $item->name; })->search($permissionItem->name) !== false ? 'selected' : '' }}>{{ $permissionItem->display_name }}</option>
                        @endforeach
                    </optgroup>
                    @endforeach
                </select>
                <div class="button-multiselect-box mt-1">
                    <a class="select-all btn btn-secondary btn-sm" href="#">選取全部</a>
                    <a class="deselect-all btn btn-secondary btn-sm" href="#">清除選取</a>
                </div>
            </div>
        </div>

    </fieldset>

    <div class="text-center my-4 form-btn-group">
        <input class="btn btn-main" type="submit" id="submitBut" value="@lang('admin.form.button.send')">
        <input class="btn btn-default" type="reset" value="@lang('admin.form.button.reset')">
    </div>
@endsection