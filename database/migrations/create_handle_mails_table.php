<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHandleMailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('handle_mails', function (Blueprint $table) {
            $table->id();
            $table->text('page');
            $table->text('name')->nullable();
            $table->text('email')->nullable();
            $table->text('phone')->nullable();
            $table->text('text')->nullable();
            $table->text('data')->nullable();
            $table->string('ip')->nullable();
            $table->text('ip_info')->nullable();
            $table->string('status')->nullable();
            $table->string('spam')->nullable()->default(0);
            $table->mediumText('history')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('handle_mails');
    }
}
