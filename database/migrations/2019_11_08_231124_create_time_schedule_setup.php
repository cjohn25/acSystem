<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimeScheduleSetup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timeScheduleSetup', function (Blueprint $table) {
            $table->increments('sched_ID');  
            $table->string('time_in'); 
            $table->string('time_out'); 
            $table->string('set_day');  
            $table->integer('room_ID')->unsigned();
            $table->foreign('room_ID')
            ->references('id')
            ->on('rooms')
            ->onDelete('cascade');
            $table->integer('device_ID')->unsigned();
            $table->foreign('device_ID')
            ->references('device_ID')
            ->on('device')
            ->onDelete('cascade');
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
        Schema::dropIfExists('timeScheduleSetup');
    }
}
