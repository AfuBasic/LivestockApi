<?php

// Ahmed Adisa

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateTblLivestockTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_livestock_type', function (Blueprint $table) {
            if(!Schema::hasTable('tbl_livestock_type')){
               Schema::create('tbl_livestock_type', function (Blueprint $table) {
                    $table->increments('id');
                    $table->string('name');
               });
            }
        });

        DB::table('tbl_livestock_type')->insert([
            ['name' => 'sheep'],
            ['name' => 'goat']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_livestock_type');
    }
}
