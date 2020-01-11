<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{ 
      //Table Name
      protected $table ='device';
      //Primary Key
      public $primaryKey = 'device_ID';
      //TimeStamp
      public $timestamps = true;
      protected $fillable = [
          'name',
          'desc',
          'mac_add',
          'Installed',
          'location', 
          'created_at', 
          'updated_at'
      ];
}
