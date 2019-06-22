<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Livestock247\Constants\Database;

class ModifyPaymentLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(Database::PAYMENT_LOG, function (Blueprint $table){
            $table->string('access_code')->nullable()->change();
            $table->string('update_time')->nullable();
            $table->string('gateway_reference');
            $table->text('gateway_other_details');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(Database::PAYMENT_LOG, function (Blueprint $table){
            $table->dropColumn('access_code');
            $table->dropColumn('update_time')->nullable();
            $table->dropColumn('gateway_reference');
            $table->dropColumn('gateway_other_details');
        });
    }
}
