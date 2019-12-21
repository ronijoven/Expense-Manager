@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.edit') }} {{ trans('cruds.expenseCategory.title_singular') }}
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{ route("admin.expense-categories.update", [$expenseCategory->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group {{ $errors->has('expense_category_desc') ? 'has-error' : '' }}">
                            <label for="expense_category_desc">{{ trans('cruds.expenseCategory.fields.expense_category_desc') }}</label>
                            <input class="form-control" type="text" name="expense_category_desc" id="expense_category_desc" value="{{ old('expense_category_desc', $expenseCategory->expense_category_desc) }}">
                            @if($errors->has('expense_category_desc'))
                                <span class="help-block" role="alert">{{ $errors->first('expense_category_desc') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.expenseCategory.fields.expense_category_desc_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('expense_category_display') ? 'has-error' : '' }}">
                            <label class="required" for="expense_category_display">{{ trans('cruds.expenseCategory.fields.expense_category_display') }}</label>
                            <input class="form-control" type="text" name="expense_category_display" id="expense_category_display" value="{{ old('expense_category_display', $expenseCategory->expense_category_display) }}" required>
                            @if($errors->has('expense_category_display'))
                                <span class="help-block" role="alert">{{ $errors->first('expense_category_display') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.expenseCategory.fields.expense_category_display_helper') }}</span>
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