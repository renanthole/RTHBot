<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->string('img_url')->nullable();
            $table->string('instancia')->nullable();
            $table->string('token')->nullable();
            $table->string('session_id')->nullable();
            $table->boolean('business')->default(false);
            $table->boolean('connected')->nullable();
            $table->timestamp('connected_at')->nullable();
            $table->boolean('smartphone_connected')->nullable();
            $table->timestamp('smartphone_connected_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('devices');
    }
}
