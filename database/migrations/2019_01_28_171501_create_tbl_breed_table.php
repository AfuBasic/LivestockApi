<?php

// Ahmed Adisa

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateTblBreedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_breed', function (Blueprint $table) {
            if(!Schema::hasTable('tbl_breed')){
               Schema::create('tbl_breed', function (Blueprint $table) {
                    $table->increments('id');
                    $table->string('name');
                    $table->integer('livestock_type');
               });
            }
        });

        DB::table('tbl_breed')->insert([
            [
                'name' => 'Uda',
                'livestock_type' => 2
            ],

            [
                'name' => 'Yankasa',
                'livestock_type' => 2
            ],

            [
                'name' => 'Balami',
                'livestock_type' => 2
            ],

            [
                'name' => 'Sokoto Red',
                'livestock_type' => 3
            ]
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
