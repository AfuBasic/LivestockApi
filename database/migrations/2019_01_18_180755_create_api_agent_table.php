<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Livestock247\Constants\Database;

class CreateApiAgentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Database::API_AGENTS, function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('agent_id', 50);
            $table->string('api_token', 100);
            $table->string('private_key', 100);
            $table->enum('status', ['enabled','disabled'])->default('enabled')->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Database::API_AGENTS);
    }
}
