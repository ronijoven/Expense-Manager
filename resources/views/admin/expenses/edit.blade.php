@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.edit') }} {{ trans('cruds.expense.title_singular') }}
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{ route("admin.expenses.update", [$expense->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group {{ $errors->has('expense_category') ? 'has-error' : '' }}">
                            <label class="required" for="expense_category_id">{{ trans('cruds.expense.fields.expense_category') }}</label>
                            <select class="form-control select2" name="expense_category_id" id="expense_category_id" required>
                                @foreach($expense_categories as $id => $expense_category)
                                    <option value="{{ $id }}" {{ ($expense->expense_category ? $expense->expense_category->id : old('expense_category_id')) == $id ? 'selected' : '' }}>{{ $expense_category }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('expense_category_id'))
                                <span class="help-block" role="alert">{{ $errors->first('expense_category_id') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.expense.fields.expense_category_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('expense_money') ? 'has-error' : '' }}">
                            <label class="required" for="expense_money">{{ trans('cruds.expense.fields.expense_money') }}</label>
                            <input class="form-control" type="number" name="expense_money" id="expense_money" value="{{ old('expense_money', $expense->expense_money) }}" step="0.01" required>
                            @if($errors->has('expense_money'))
                                <span class="help-block" role="alert">{{ $errors->first('expense_money') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.expense.fields.expense_money_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('expense_date') ? 'has-error' : '' }}">
                            <label class="required" for="expense_date">{{ trans('cruds.expense.fields.expense_date') }}</label>
                            <input class="form-control date" type="text" name="expense_date" id="expense_date" value="{{ old('expense_date', $expense->expense_date) }}" required>
                            @if($errors->has('expense_date'))
                                <span class="help-block" role="alert">{{ $errors->first('expense_date') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.expense.fields.expense_date_helper') }}</span>
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