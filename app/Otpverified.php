<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Otpverified extends Model
{
	 protected $table='tbl_otp_verified';
    protected $primaryKey = 'code';
	
    //use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    public function verifiedOtpCount($mobile_no,$mobile_otp) 
    {
        //$customUsername = 'mobile_no';
        $count= $this->where('mobile_no', $mobile_no)->where('mobile_otp', $mobile_otp)->where('status', 0)->count();
        if($count>0){
            $this->where('mobile_no', $mobile_no)->where('mobile_otp', $mobile_otp)->update(['status'=>1]); 

            return $count; 
        }else{
            return $count;   
        }
    }

   
}
