@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.show') }} {{ trans('cruds.expenseCategory.title') }}
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('admin.expense-categories.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.expenseCategory.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $expenseCategory->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.expenseCategory.fields.expense_category_desc') }}
                                    </th>
                                    <td>
                                        {{ $expenseCategory->expense_category_desc }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.expenseCategory.fields.expense_category_display') }}
                                    </th>
                                    <td>
                                        {{ $expenseCategory->expense_category_display }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('admin.expense-categories.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.relatedData') }}
                </div>
                <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
                    <li role="presentation">
                        <a href="#expense_category_expenses" aria-controls="expense_category_expenses" role="tab" data-toggle="tab">
                            {{ trans('cruds.expense.title') }}
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane" role="tabpanel" id="expense_category_expenses">
                        @includeIf('admin.expenseCategories.relationships.expenseCategoryExpenses', ['expenses' => $expenseCategory->expenseCategoryExpenses])
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection