<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExpenseCategory extends Model
{
    use SoftDeletes;

    public $table = 'expense_categories';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'created_at',
        'updated_at',
        'deleted_at',
        'expense_category_desc',
        'expense_category_display',
    ];

    public function expenseCategoryExpenses()
    {
        return $this->hasMany(Expense::class, 'expense_category_id', 'id');
    }
}
