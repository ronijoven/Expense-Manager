@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.edit') }} {{ trans('cruds.role.title_singular') }}
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{ route("admin.roles.update", [$role->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                            <label class="required" for="title">{{ trans('cruds.role.fields.title') }}</label>
                            <input class="form-control" type="text" name="title" id="title" value="{{ old('title', $role->title) }}" required>
                            @if($errors->has('title'))
                                <span class="help-block" role="alert">{{ $errors->first('title') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.role.fields.title_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('permissions') ? 'has-error' : '' }}">
                            <label class="required" for="permissions">{{ trans('cruds.role.fields.permissions') }}</label>
                            <div style="padding-bottom: 4px">
                                <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                                <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                            </div>
                            <select class="form-control select2" name="permissions[]" id="permissions" multiple required>
                                @foreach($permissions as $id => $permissions)
                                    <option value="{{ $id }}" {{ (in_array($id, old('permissions', [])) || $role->permissions->contains($id)) ? 'selected' : '' }}>{{ $permissions }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('permissions'))
                                <span class="help-block" role="alert">{{ $errors->first('permissions') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.role.fields.permissions_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('role_description') ? 'has-error' : '' }}">
                            <label for="role_description">{{ trans('cruds.role.fields.role_description') }}</label>
                            <input class="form-control" type="text" name="role_description" id="role_description" value="{{ old('role_description', $role->role_description) }}">
                            @if($errors->has('role_description'))
                                <span class="help-block" role="alert">{{ $errors->first('role_description') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.role.fields.role_description_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-danger" type="submit">
                                {{ trans('global.save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>



        </div>
    </div>
</div>
@endsection