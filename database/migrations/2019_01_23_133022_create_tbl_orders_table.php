<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Livestock247\Constants\Database;

class CreateTblOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(Database::ORDER, function (Blueprint $table) {
            if(!Schema::hasTable(Database::ORDER)){
                Schema::create(Database::ORDER, function (Blueprint $table) {
                    $table->bigIncrements('id');
                    $table->bigInteger('uid');
                    $table->date('order_date');
                    $table->string('invoice_id');
                    $table->integer('livestock_type');
                    $table->integer('weight');
                    $table->integer('sex');
                    $table->integer('breed');
                    $table->integer('delivery_period');
                    $table->integer('delivery_location');
                    $table->date('delivery_date');
                    $table->integer('qty');
                    $table->integer('tp_type');
                    $table->text('address');
                    $table->integer('status');
                    $table->softDeletes();
                });
            }

            $table->softDeletes();
            $table->integer('sex')->default(0)->change();
            $table->integer('breed')->default(0)->change();
            $table->integer('status')->default(0)->change();
            $table->renameColumn('order_no','invoice_no');
            $table->renameColumn('log_time','created_at');
            $table->dropColumn(['tp_type','buy_from']);
            $table->timestamp('updated_at')->after('log_time')->useCurrent();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Database::ORDER);
    }
}
