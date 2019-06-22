<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Livestock247\Constants\Database;

class CreateTblLivestockInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(Database::LIVESTOCK_INVOICE, function (Blueprint $table) {
            if(!Schema::hasTable(Database::LIVESTOCK_INVOICE)){
                Schema::create(Database::LIVESTOCK_INVOICE, function (Blueprint $table) {
                    $table->bigIncrements('id');
                    $table->bigInteger('uid');
                    $table->date('invoice_date');
                    $table->string('invoice_no');
                    $table->integer('total_qty')->nullable($value = true);
                    $table->integer('tp_type');
                    $table->decimal('livestock_cost');
                    $table->decimal('mtn_chip');
                    $table->decimal('phone');
                    $table->decimal('sms');
                    $table->decimal('tp_cost');
                    $table->decimal('margin');
                    $table->decimal('agent');
                    $table->decimal('bank_charges');
                    $table->decimal('total');
                    $table->decimal('inv_total');
                    $table->decimal('inv_vat');
                    $table->decimal('inv_amount');
                    $table->integer('status');
                    $table->timestamp('log_time');
                    $table->softDeletes();
                });
            }

            $table->softDeletes();
            $table->bigInteger('total_qty')->after('invoice_no')->default(0);
            $table->renameColumn('log_time','created_at');
            $table->bigInteger('uid')->change();
            $table->integer('status')->default(0)->change();
            $table->integer('tp_type')->default(0)->change();
            $table->decimal('livestock_cost',18,2)->default(0.00)->change();
            $table->decimal('margin',18,2)->default(0.00)->change();
            $table->decimal('agent',18,2)->default(0.00)->change();
            $table->decimal('total',18,2)->default(0.00)->change();
            $table->decimal('inv_total',18,2)->default(0.00)->change();
            $table->decimal('inv_vat',18,2)->default(0.00)->change();
            $table->decimal('inv_amount',18,2)->default(0.00)->change();
            $table->dropColumn(['livestock_type', 'weight', 'sex', 'breed', 'qty', 'order_id', 'delivery_period', 'delivery_location', 'delivery_date']);
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
        Schema::dropIfExists(Database::LIVESTOCK_INVOICE);
    }
}
