<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTable extends Migration
{
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->increments('id');

            $table->decimal('expense_money', 15, 2);

            $table->date('expense_date');

            $table->timestamps();

            $table->softDeletes();
        });
    }
}
