<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');

            $table->string('description');

            $table->bigInteger('amount');

            $table->string('debit_account_id', 128)->nullable();
            $table->string('credit_account_id', 128)->nullable();

            $table->string('import_id', 128);

            $table->timestamp('date');

            $table->timestamps();

            $table->foreign('debit_account_id')
                    ->references('id')
                    ->on('accounts')
                    ->onDelete('set null');

            $table->foreign('credit_account_id')
                    ->references('id')
                    ->on('accounts')
                    ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
