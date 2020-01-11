<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class timeschedulesetup extends Model
{
    protected $table = 'timeschedulesetup';
    public $primaryKey = 'sched_ID';
    public $timestamps = true;
    protected $fillable = ['time_in','time_out', 'set_day', 'room_ID','device_ID','created_at','updated_at'];
}
