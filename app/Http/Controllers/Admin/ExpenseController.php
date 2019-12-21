<?php

namespace App\Http\Controllers\Admin;

use App\Expense;
use App\ExpenseCategory;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyExpenseRequest;
use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;
use App\Data;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ExpenseController extends Controller
{

    public function index()
    {
        abort_if(Gate::denies('expense_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $site_details = self::getSiteDetails();
        $expenses = $site_details["expenses"];
        $name = $site_details["name"];
        $roletitle = $site_details["roletitle"];
        $id = $site_details["id"];
        $expense_categories = $site_details["expense_categories"];
        return view('admin.expenses.index', compact("expenses","name","roletitle","id","expense_categories"));
    }

    public function create()
    {
        abort_if(Gate::denies('expense_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $site_details = self::getSiteDetails();
        $expense_categories = $site_details["xpense_categories"];
        $name = $site_details["name"];
        $roletitle = $site_details["roletitle"];
        $id = $site_details["id"];
        return view('admin.expenses.create', compact('expense_categories','name','roletitle','id'));
    }

    public function store(StoreExpenseRequest $request)
    {
        $expense = Expense::create($request->all());

        return redirect()->route('admin.expenses.index');
    }

    public function edit(Expense $expense)
    {
        abort_if(Gate::denies('expense_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $expense_categories = ExpenseCategory::all()->pluck('expense_category_desc', 'id')->prepend(trans('global.pleaseSelect'), '');

        $expense->load('expense_category');

        return view('admin.expenses.edit', compact('expense_categories', 'expense'));
    }

    public function readItems() {
        $data = Data::all ();
        return $data;
    }

    public function update(UpdateExpenseRequest $request, Expense $expense)
    {
        $expense->update($request->all());

        return redirect()->route('admin.expenses.index');
    }

    public function show(Expense $expense)
    {
        abort_if(Gate::denies('expense_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $expense->load('expense_category');
        $site_details = self::getSiteDetails();
        $name = $site_details["name"];
        $roletitle = $site_details["roletitle"];
        $id = $site_details["id"];
        return view('admin.expenses.show', compact('expense','id','name','roletitle'));
    }

    public function destroy(Expense $expense)
    {
        abort_if(Gate::denies('expense_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $expense->delete();

        return back();
    }

    public function massDestroy(MassDestroyExpenseRequest $request)
    {
        Expense::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function editItem(Request $request, $id){
        $data =Data::where('id', $id)->first();
        $data->expense_category_id = $request->get('val_1');
        $data->expense_money = $request->get('val_2');
        $data->expense_date = $request->get('val_3');
        $data->save();
        return $data;
    }

    public static function getSiteDetails() {
        //session(["site_details"=>null]);
        if (session('site_details') !== null) {
            $site_details = session("site_details");
        } else {
            $expense_categories = ExpenseCategory::all()->pluck('expense_category_desc', 'id')->prepend(trans('global.pleaseSelect'), '');
            $expenses = Expense::all();
            $user = auth()->user();
            $id = $user->id;
            $roles = json_decode($user->roles,true);
            $roletitle = $roles[0]["title"];
            $name = $user->name;
            $site_details = array(
                "expenses" => $expenses,
                "name"=> $name,
                "roletitle" => $roletitle,
                "id"=>$id,
                "expense_categories"=>$expense_categories,
            );
            session(["site_details"=>$site_details]);
        }
        return $site_details;
    }



}
