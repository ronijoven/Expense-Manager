<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Role;
use App\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UsersController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $users = User::all();

        $site_details = ExpenseController::getSiteDetails();
        $name = $site_details["name"];
        $roletitle = $site_details["roletitle"];
        $id = $site_details["id"];
        return view('admin.users.index', compact('users','name','roletitle','id'));
    }

    public function create()
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::all()->pluck('title', 'id');
        $site_details = ExpenseController::getSiteDetails();
        $expense_categories = $site_details["expense_categories"];
        $name = $site_details["name"];
        $roletitle = $site_details["roletitle"];
        $id = $site_details["id"];

        return view('admin.users.create', compact('roles','users','name','roletitle','id'));
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->all());
        $user->roles()->sync($request->input('roles', []));

        return redirect()->route('admin.users.index');
    }

    public function edit(User $user)
    {
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $site_details = ExpenseController::getSiteDetails();
        $name = $site_details["name"];
        $roletitle = $site_details["roletitle"];
        $id = $site_details["id"];
        $roles = Role::all()->pluck('title', 'id');
        $user->load('roles');

        return view('admin.users.edit', compact('roles', 'user','name','roletitle','id'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->all());
        $user->roles()->sync($request->input('roles', []));

        return redirect()->route('admin.users.index');
    }

    public function show(User $user)
    {
        abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->load('roles');

        return view('admin.users.show', compact('user'));
    }

    public function destroy(User $user)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->delete();

        return back();
    }

    public function massDestroy(MassDestroyUserRequest $request)
    {
        User::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function editItem(Request $request, $id){
        $data =Data::where('id', $id)->first();
        $data->name = $request->get('val_1');
        $data->email = $request->get('val_2');
        $role=2;
        $data->save();
        return $data;
    }

}
