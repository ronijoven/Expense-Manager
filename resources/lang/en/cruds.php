<?php

return [
    'userManagement'    => [
        'title'          => 'User management',
        'title_singular' => 'User management',
    ],
    'permission'        => [
        'title'          => 'Permissions',
        'title_singular' => 'Permission',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => '',
            'title'             => 'Title',
            'title_helper'      => '',
            'created_at'        => 'Created at',
            'created_at_helper' => '',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => '',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => '',
        ],
    ],
    'role'              => [
        'title'          => 'Roles',
        'title_singular' => 'Role',
        'fields'         => [
            'id'                      => 'ID',
            'id_helper'               => '',
            'title'                   => 'Display Name',
            'title_helper'            => 'Enter Role',
            'permissions'             => 'Permissions',
            'permissions_helper'      => 'Enter Permission',
            'created_at'              => 'Created at',
            'created_at_helper'       => '',
            'updated_at'              => 'Updated at',
            'updated_at_helper'       => '',
            'deleted_at'              => 'Deleted at',
            'deleted_at_helper'       => '',
            'role_description'        => 'Description',
            'role_description_helper' => 'Enter Role Description',
        ],
    ],
    'user'              => [
        'title'          => 'Users',
        'title_singular' => 'User',
        'fields'         => [
            'id'                    => 'ID',
            'id_helper'             => '',
            'name'                  => 'Name',
            'name_helper'           => '',
            'email'                 => 'Email',
            'email_helper'          => '',
            'password'              => 'Password',
            'password_helper'       => '',
            'roles'                 => 'Role',
            'roles_helper'          => '',
            'remember_token'        => 'Remember Token',
            'remember_token_helper' => '',
            'created_at'            => 'Created at',
            'created_at_helper'     => '',
            'updated_at'            => 'Updated at',
            'updated_at_helper'     => '',
            'deleted_at'            => 'Deleted at',
            'deleted_at_helper'     => '',
        ],
    ],
    'expenseCategory'   => [
        'title'          => 'Expense Category',
        'title_singular' => 'Expense Category',
        'fields'         => [
            'id'                              => 'ID',
            'id_helper'                       => '',
            'expense_category_desc'           => 'Description',
            'expense_category_desc_helper'    => 'Enter Full Description of Category',
            'created_at'                      => 'Created at',
            'created_at_helper'               => '',
            'updated_at'                      => 'Updated at',
            'updated_at_helper'               => '',
            'deleted_at'                      => 'Deleted at',
            'deleted_at_helper'               => '',
            'expense_category_display'        => 'Display Name',
            'expense_category_display_helper' => 'Enter Display Name of Category',
        ],
    ],
    'expenseManagement' => [
        'title'          => 'Expense Management',
        'title_singular' => 'Expense Management',
    ],
    'expense'           => [
        'title'          => 'Expense',
        'title_singular' => 'Expense',
        'fields'         => [
            'id'                      => 'ID',
            'id_helper'               => '',
            'expense_category'        => 'Expense Category',
            'expense_category_helper' => '',
            'expense_money'           => 'Amount',
            'expense_money_helper'    => 'Enter Amount of Expense',
            'created_at'              => 'Created at',
            'created_at_helper'       => '',
            'updated_at'              => 'Updated at',
            'updated_at_helper'       => '',
            'deleted_at'              => 'Deleted at',
            'deleted_at_helper'       => '',
            'expense_date'            => 'Entry Date',
            'expense_date_helper'     => 'Enter Date of Entry',
        ],
    ],
];