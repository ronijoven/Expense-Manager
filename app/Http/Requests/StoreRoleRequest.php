<?php

namespace App\Http\Requests;

use App\Role;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreRoleRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('role_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'title'            => [
                'min:5',
                'max:30',
                'required',
            ],
            'permissions.*'    => [
                'integer',
            ],
            'permissions'      => [
                'required',
                'array',
            ],
            'role_description' => [
                'min:5',
                'max:255',
            ],
        ];
    }
}
