<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Livestock247\Constants\Database;

class CreateTblChippingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(Database::CHIPPING, function (Blueprint $table) {
            if(!Schema::hasTable(Database::CHIPPING)){
                Schema::create(Database::CHIPPING, function (Blueprint $table) {
                    $table->bigIncrements('id');
                    $table->bigInteger('uid')->default(0);
                    $table->bigInteger('order_id')->default(0);
                    $table->bigInteger('invoice_id')->default(0);
                    $table->string('chip_no');
                    $table->integer('pole_no')->default(0);
                    $table->integer('status');
                    $table->timestamps();
                    $table->softDeletes();
                });
            }

            $table->softDeletes();
            $table->bigInteger('order_id')->default(0)->change();
            $table->bigInteger('invoice_id')->after('order_id')->default(0);
            $table->renameColumn('log_time','created_at');
            $table->renameColumn('pole_id','pole_no');
            $table->timestamp('updated_at')->after('log_time')->useCurrent();
            $table->bigInteger('uid')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Database::CHIPPING);
    }
}
