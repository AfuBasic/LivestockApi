<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Livestock247\Constants\Database;

class MigrationToFixTblAccountDefaultColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(Database::ACCOUNTS, function (Blueprint $table) {
            $table->integer('business_category')->default('0')->change();
            $table->integer('business_type')->default('0')->change();
            $table->integer('bank_id')->default('0')->change();
            $table->string('bank_account_no')->default('0')->change();
            $table->integer('status')->default('0')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(Database::ACCOUNTS, function (Blueprint $table) {
            $table->integer('business_category')->nullable()->change();
            $table->integer('business_type')->nullable()->change();
            $table->integer('bank_id')->nullable()->change();
            $table->string('bank_account_no')->nullable()->change();
            $table->integer('status')->nullable()->change();
        });
    }
}
