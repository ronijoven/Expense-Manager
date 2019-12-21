<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpenseCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('expense_categories', function (Blueprint $table) {
            $table->increments('id');

            $table->string('expense_category_desc')->nullable();

            $table->string('expense_category_display');

            $table->timestamps();

            $table->softDeletes();
        });
    }
}
