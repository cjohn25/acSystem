<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDataReading extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_reading', function (Blueprint $table) {
            $table->bigIncrements('id');   
            $table->integer('device_ID')->unsigned();
            $table->integer('room_ID')->unsigned();
            $table->integer('user_ID')->unsigned();
            $table->foreign('room_ID')
            ->references('id')
            ->on('rooms')
            ->onDelete('cascade'); 
            $table->foreign('user_ID')
            ->references('id')
            ->on('users')
            ->onDelete('cascade');
            $table->string('status');
            $table->string('power');
            $table->string('voltage');  
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent();
        });
    }
 
    public function down()
    {
        Schema::dropIfExists('data_reading');
    }
}
