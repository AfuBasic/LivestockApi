<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use \Livestock247\Constants\Database;


class AddUsedToActivationCode extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(Database::ACTIVATION_CODE, function (Blueprint $table) {
            $table->boolean('used');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(Database::ACTIVATION_CODE, function (Blueprint $table) {
            $table->dropColumn('used');
        });
    }
}
