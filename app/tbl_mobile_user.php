<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class tbl_mobile_user extends Model
{
   

    protected $table= 'tbl_mobile_user';
    protected $primaryKey = 'code';

    protected $fillable = [
        'name', 'designation', 'mobile_no'
    ];

     protected $hidden = [
        'password'
    ];
}
