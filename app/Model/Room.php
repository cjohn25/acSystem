<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{ 
      //Table Name
      protected $table ='rooms';
      //Primary Key
      public $primaryKey = 'id';
      //TimeStamp
      public $timestamps = true;
      protected $fillable = [
          'roomName',
          'status', 
          'device_ID', 
          'isDeleted',
          'routeName' ,
          'power',
          'voltage',
          'created_at' , 
          'updated_at'
      ];

}
