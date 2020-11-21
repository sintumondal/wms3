<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbl_supervisor_wise_worker extends Model
{

    protected $table='tbl_supervisor_wise_worker';
    protected $primaryKey = 'code';

     public function employee()
    {
        return $this->hasMany('App\tbl_employee_details','emp_designation','code');
    }
    
}
