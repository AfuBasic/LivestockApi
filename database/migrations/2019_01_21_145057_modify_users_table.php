<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Livestock247\Constants\Database;

class ModifyUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(Database::USERS, function (Blueprint $table) {
            $table->string("firstname");
            $table->string("lastname");
            $table->string("phone");
            $table->enum('gender',['male','female']);
            $table->string('state');
            $table->string('contact_address');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(Database::USERS, function (Blueprint $table) {
            $table->dropColumn("firstname");
            $table->dropColumn("lastname");
            $table->dropColumn("phone");
            $table->dropColumn('gender',['male','female']);
            $table->dropColumn('state');
            $table->dropColumn('contact_address');
        });
    }
}
