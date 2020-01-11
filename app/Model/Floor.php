<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Floor extends Model
{
    //Table Name
    protected $table ='floors';
    //Primary Key
    public $primaryKey = 'floorID';
    //TimeStamp
    public $timestamps = true;
    
    protected $fillable = [
        'Name',
        'status', 
        'room_ID', 
        'created_at', 
        'updated_at'
    ];
}
