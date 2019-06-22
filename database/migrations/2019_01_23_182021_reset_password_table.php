<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Livestock247\Constants\Database;

class ResetPasswordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Database::PASSWORD_RESET,function(Blueprint $table){
           $table->increments('id');
           $table->string('email');
           $table->longText('hash');
           $table->timestamp('created_at')->useCurrent();
           $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Database::PASSWORD_RESET);
    }
}
