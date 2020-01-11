<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class User_Roles extends Model
{     protected $table ='user_roles';
    //Primary Key
    public $primaryKey = 'userRole_id';
    //TimeStamp
    public $timestamps = true;
    protected $fillable = [
        'user_ID',
        'role_ID', 
        'created_at' , 
        'updated_at'
    ];
}
