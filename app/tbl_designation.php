<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbl_designation extends Model
{
    protected $table='tbl_designation';
    protected $primaryKey = 'code';

     public function employee()
    {
        return $this->hasMany('App\tbl_employee_details','emp_designation','code');
    }
}
