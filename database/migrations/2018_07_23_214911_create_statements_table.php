<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statements', function (Blueprint $table) {
            $table->increments('id');

            $table->string('format', 32);
            $table->string('path');

            $table->string('title');
            $table->string('filename');

            $table->date('period_start');
            $table->date('period_end');

            // $table->string('guid', 128);

            $table->unsignedInteger('organization_id');

            $table->timestamp('imported_at')->nullable();
            $table->timestamps();

            $table->foreign('organization_id')
                    ->references('id')
                    ->on('organizations')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('statements');
    }
}
