<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Data_Reading extends Model
{
    // //Table Name
    protected $table ='data_reading';
    //Primary Key
    public $primaryKey = 'id';
    //TimeStamp
    public $timestamps = true;
    protected $fillable = [
        'device_ID',
        'room_ID',
        'user_ID',
        'status',
        'voltage', 
        'power', 
        'created_at', 
        'updated_at'
    ];
}
