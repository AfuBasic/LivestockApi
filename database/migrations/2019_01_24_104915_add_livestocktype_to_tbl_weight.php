<?php
//Created By Esther Akowe

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLivestocktypeToTblWeight extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_weight', function (Blueprint $table) {
            $table->tinyInteger('livestock_type');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_weight', function (Blueprint $table) {
             $table->tinyInteger('livestock_type');
        });
    }
}