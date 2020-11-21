<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Otpverified;
use App\tbl_mobile_user;
use App\tbl_designation;
use App\tbl_employee_details;
use App\tbl_supervisor_wise_worker;
use App\User;
use DB;
use Validator;

class WMSApiController extends Controller
{

  public function mobile_no_verified_and_otp_send(Request $request)
    {
        $mobile_no= request('mobile_no');
        $Moduser=new User();
        $totCount=$Moduser->getTotalCount($mobile_no);
       
        if($totCount > 0){

                //$mob_otp=rand(10001, 99999);
                $mob_otp=12345;
                $OTPSave=new Otpverified();
                $OTPSave->mobile_no=$mobile_no;
                $OTPSave->mobile_otp=$mob_otp;

                if($OTPSave->save()){
                   
                    return response()->json([
                        'success' => true,
                        'otp_code'=>$OTPSave->code,
                        'mobile_otp' => $mob_otp,
                        'mobile_no' => $mobile_no
                    ]);

               }
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Invalid Mobile No.',
            ], 401);
        }


    }

    public function otp_verified_and_login(Request $request)
    {
        $mobile_no= request('mobile_no');
        $mobile_otp= request('mobile_otp');
        $OTPSave=new Otpverified();

        $totCount=$OTPSave->verifiedOtpCount($mobile_no,$mobile_otp);

        if($totCount > 0){
            $getPassword=new User();
            $getUserData=$getPassword->findForPassport($mobile_no);
         
    
           if(Auth::loginUsingId($getUserData->code)){ 
                $user = Auth::user();
                $success['token'] = $user->createToken('appToken')->accessToken;
               //After successfull authentication, notice how I return json parameters
                return response()->json([
                  'success' => true,
                  'token' => $success,
                  'user' => $user,
                  
              ]);
            } else {
          
              return response()->json([
                'success' => false,
                'message' => 'Invalid Email or Password',
            ], 401);
            }
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Invalid OTP!',
            ], 401);
        }


    }

    public function get_all_data_employee(Request $request){

          $statusCode = 200;
    try {

     
       //$mob_user_code = $request->user()->code;
       $emp_type = $request->user()->emy_type;
       $emp_code = $request->user()->emp_code;

       if($emp_type == 1){

        $worker_code=tbl_supervisor_wise_worker::where('supervisor_code', $emp_code)->select('worker_code')->get();


         $worker_details= tbl_employee_details::wherein('code',$worker_code)->get();
         $supervisor_details=tbl_employee_details::where('code',$emp_code)->get();

       }else if($emp_type == 2){

        $worker_details= tbl_employee_details::where('code',$emp_code)->get();
         $supervisor_details='';
       }

       $response=array('worker_details'=> $worker_details,'supervisor_details'=>$supervisor_details);
     
   
      // $response = array(
      //   "name" => $result2->name,
      //   "user_code" => $result2->code,
      //   "username" => $result2->name,
      //   "designation" => $result2->designation,
      //   "mobile_no" => $result2->mobile_no,
      //   "imie_no" => $result2->imie_no,
      //   "user_type" => $user_typ,
      //   'msg' => 'Mobile User Successfuly Login.',
      //   'status' => 1,
      // );
    }
    catch (\Exception $e) {
      $response = array(
        'exception' => true,
        'exception_message' => $e->getMessage(),
      );
      $statusCode = 400;
    } finally {
      return response()->json($response, $statusCode);
    }

    }
   

    
}
