<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbl_employee_details extends Model
{
     protected $table='tbl_employee_details';
     protected $primaryKey = 'code';

     public function department()
    {
        return $this->belongsTo('App\tbl_department','code','emp_deparment');
    }

     public function designation()
    {
        return $this->belongsTo('App\tbl_designation','code','emp_designation');
    }





}
