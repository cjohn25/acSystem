<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //
       //Table Name
       protected $table ='roles';
       //Primary Key
       public $primaryKey = 'typeID';
       //TimeStamp
       public $timestamps = true;
       protected $fillable = [
           'typeID',
           'position', 
           'created_at', 
           'updated_at'
       ];

       
       public function users()
       {
           return $this->belongsToMany('App\Models\Accounts');
       }
}
