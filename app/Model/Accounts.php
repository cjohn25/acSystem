<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Accounts extends Model
{
    //
    protected $table = "users";
    //Primary Key
    public $primaryKey = 'id';
    //Timestamps
    public $timestamps = true;    
    protected $fillable = [
        'name',
        'email', 
        'typeID',
        'password', 
        'created_at',
        'typeID',
        'updated_at'
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];
 
    // public function role(){
    //     return $this->belongsToMany('App\Type');
    // } 
    public function roles()
    {
        return $this->belongsToMany('App\Models\Role');
    }

}
