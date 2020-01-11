<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class calendarEvents extends Model
{
    //
    protected $table = 'events';
    public $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = ['title','color','start_date','end_date'];
}
