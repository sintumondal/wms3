<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbl_department extends Model
{
    protected $table='tbl_department';
    protected $primaryKey = 'code';

     public function employee()
    {
        return $this->hasMany('App\tbl_employee_details','emp_deparment','code');
    }
}
