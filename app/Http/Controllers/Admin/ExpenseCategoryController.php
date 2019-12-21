<?php

namespace App\Http\Controllers\Admin;

use App\ExpenseCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyExpenseCategoryRequest;
use App\Http\Requests\StoreExpenseCategoryRequest;
use App\Http\Requests\UpdateExpenseCategoryRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ExpenseCategoryController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('expense_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $expenseCategories = ExpenseCategory::all();
        $site_details = ExpenseController::getSiteDetails();
        $name = $site_details["name"];
        $roletitle = $site_details["roletitle"];
        $id = $site_details["id"];
        return view('admin.expenseCategories.index', compact('expenseCategories','name','roletitle'));
    }

    public function create()
    {
        abort_if(Gate::denies('expense_category_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $site_details = ExpenseController::getSiteDetails();
        $name = $site_details["name"];
        $roletitle = $site_details["roletitle"];
        $id = $site_details["id"];

        return view('admin.expenseCategories.create',compact('name','roletitle','id'));
    }

    public function store(StoreExpenseCategoryRequest $request)
    {
        $expenseCategory = ExpenseCategory::create($request->all());

        return redirect()->route('admin.expense-categories.index');
    }

    public function edit(ExpenseCategory $expenseCategory)
    {
        abort_if(Gate::denies('expense_category_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        abort_if(Gate::denies('expense_category_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $site_details = ExpenseController::getSiteDetails();
        $name = $site_details["name"];
        $roletitle = $site_details["roletitle"];
        $expenseCategories = ExpenseCategory::all();
        $id = $site_details["id"];
        return view('admin.expenseCategories.edit', compact('expenseCategory','name','roletitle'));
    }

    public function update(UpdateExpenseCategoryRequest $request, ExpenseCategory $expenseCategory)
    {
        $expenseCategory->update($request->all());

        return redirect()->route('admin.expense-categories.index');
    }

    public function show(ExpenseCategory $expenseCategory)
    {
        abort_if(Gate::denies('expense_category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $expenseCategory->load('expenseCategoryExpenses');
        abort_if(Gate::denies('expense_category_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $site_details = ExpenseController::getSiteDetails();
        $name = $site_details["name"];
        $roletitle = $site_details["roletitle"];
        $id = $site_details["id"];
        return view('admin.expenseCategories.show', compact('expenseCategory','expenseCategory','name','roletitle'));
    }

    public function destroy(ExpenseCategory $expenseCategory)
    {
        abort_if(Gate::denies('expense_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $expenseCategory->delete();

        return back();
    }

    public function massDestroy(MassDestroyExpenseCategoryRequest $request)
    {
        ExpenseCategory::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function updateItem(Request $request, $id){
        $data =Data::where('id', $id)->first();
        $data->expense_category_display = $request->get('val_1');
        $data->expense_category_desc = $request->get('val_2');
        $role=2;
        $data->save();
        return $data;
    }

    public function editItem(Request $request, $id){
        $data =Data::where('id', $id)->first();
        $data->expense_category_display = $request->get('val_1');
        $data->expense_category_desc = $request->get('val_2');
        $role=2;
        $data->save();
        return $data;
    }
}
