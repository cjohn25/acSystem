<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{ 
       //Table Name
       protected $table ='logs';
       //Primary Key
       public $primaryKey = 'id';
       //TimeStamp
       public $timestamps = true;
       protected $fillable = [
           'message',
           'action', 
           'created_at', 
           'updated_at'
       ];
 
}
