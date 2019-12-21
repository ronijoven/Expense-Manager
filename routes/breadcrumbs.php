<?php

Breadcrumbs::register('expense', function ($breadcrumbs) {
     $breadcrumbs->push('Expense', route('admin.expenses.index'));
});

Breadcrumbs::register('expense-category', function ($breadcrumbs) {
    $breadcrumbs->push('Expense Category', route('admin.expense-categories.index'));
});

Breadcrumbs::register('user', function ($breadcrumbs) {
    $breadcrumbs->push('User', route('admin.users.index'));
});

Breadcrumbs::register('rolename', function ($breadcrumbs) {
    $breadcrumbs->push('Roles', route('admin.roles.index'));
});
