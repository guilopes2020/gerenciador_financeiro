<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->string('email', 100)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 300);
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('entries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_user');
            $table->string('category');
            $table->dateTime('created');
            $table->string('description', 191);
            $table->float('value');
            $table->timestamps();
        });

        Schema::create('outgoings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_user');
            $table->string('category');
            $table->dateTime('created');
            $table->string('description', 191);
            $table->tinyInteger('paga')->default(0);
            $table->float('value');
            $table->dateTime('vencimento');
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
        Schema::dropIfExists('users');
        Schema::dropIfExists('entries');
        Schema::dropIfExists('outgoings');
        
    }
}
