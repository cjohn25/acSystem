<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRooms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('roomName')->default('');  
            $table->integer('device_ID')->unsigned();
            $table->foreign('device_ID')->references('device_ID')->on('device')->onDelete('cascade');
            $table->boolean('status')->default(false);
            $table->string('routeName');
            $table->string('power')->default(0);
            $table->string('voltage')->default(0);
            $table->boolean('isDeleted')->default(false);
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rooms');
    }
}
