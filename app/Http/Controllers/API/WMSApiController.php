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
use App\tbl_attendance_entry;
use App\User;
use DB;
use Image;
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
                 $user_code = Auth::user()->emp_code;
                 $user_data= tbl_employee_details::join('tbl_mobile_user','tbl_mobile_user.emp_code','tbl_employee_details.code')
                 ->where('tbl_employee_details.code', $user_code)
                 ->select('tbl_mobile_user.designation','tbl_mobile_user.name','tbl_mobile_user.mobile_no','tbl_employee_details.*')->first();
                $success['token'] = $user->createToken('appToken')->accessToken;
               //After successfull authentication, notice how I return json parameters
                return response()->json([
                  'success' => true,
                  'token' => $success,
                  'user' => $user_data,
                  
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

    public function get_all_data_employee_array(Request $request){


         $statusCode = 200;
    try {

        $worker_details =array();
        $supervisor_details =array();

     
       //$mob_user_code = $request->user()->code;
       $emp_type = $request->user()->emp_type;
       $emp_code = $request->user()->emp_code;

       if($emp_type == 1){

        $worker_code=tbl_supervisor_wise_worker::where('supervisor_code', $emp_code)->select('worker_code')->get();
       
         $worker_details_all= tbl_employee_details::join('tbl_designation','tbl_designation.code','tbl_employee_details.emp_designation')->wherein('tbl_employee_details.code',$worker_code)->select('tbl_employee_details.*','tbl_designation.designation')->get();

         foreach( $worker_details_all as $key => $singledata){


                $worker_details[$key]['code'] =  $singledata->code;
                 $worker_details[$key]['emp_id'] = $singledata->emp_id;
                 $worker_details[$key]['emp_name'] =  $singledata->emp_name;
                  $worker_details[$key]['father_name'] =  $singledata->father_name;
                 $worker_details[$key]['mother_name'] = $singledata->mother_name;
                 $worker_details[$key]['emp_type'] =  $singledata->emp_type;

                  $supervisor_details[$key]['profile_image'] = "workersupervisor_photo/".$singledata->profile_image;
                 $supervisor_details[$key]['profile_image_thumb'] = "workersupervisor_photo/thumb/".$singledata->profile_image;
                 $worker_details[$key]['emp_designation'] = $singledata->designation;
                 $worker_details[$key]['emp_deparment'] =  $singledata->emp_deparment;
                  $worker_details[$key]['dob'] =  $singledata->dob;
                 $worker_details[$key]['gender'] = $singledata->gender;
                 $worker_details[$key]['blood_group'] =  $singledata->blood_group;

                  $worker_details[$key]['phno'] =  $singledata->phno;
                 $worker_details[$key]['hqualification'] = $singledata->hqualification;
                 $worker_details[$key]['email'] =  $singledata->email;
                  $worker_details[$key]['pan_no'] =  $singledata->pan_no;
                 $worker_details[$key]['marital_status'] = $singledata->marital_status;
                 $worker_details[$key]['spouse_name'] =  $singledata->spouse_name;

                 $worker_details[$key]['noofchildren'] =  $singledata->noofchildren;
                 $worker_details[$key]['contact_person'] = $singledata->contact_person;
                 $worker_details[$key]['emg_address'] =  $singledata->emg_address;
                  $worker_details[$key]['emg_phno'] =  $singledata->emg_phno;
                 $worker_details[$key]['emg_alt_phno'] = $singledata->emg_alt_phno;
                 $worker_details[$key]['relationship'] =  $singledata->relationship;

                  $worker_details[$key]['c_address'] =  $singledata->c_address;
                 $worker_details[$key]['c_dist'] = $singledata->c_dist;
                 $worker_details[$key]['c_state'] =  $singledata->c_state;
                  $worker_details[$key]['c_pin'] =  $singledata->c_pin;
                 $worker_details[$key]['p_address'] = $singledata->p_address;
                 $worker_details[$key]['p_dist'] =  $singledata->p_dist;

                  $worker_details[$key]['p_state'] =  $singledata->p_state;
                 $worker_details[$key]['p_pin'] = $singledata->p_pin;
                 $worker_details[$key]['joining_date'] =  $singledata->joining_date;
                  $worker_details[$key]['salary_per_day'] =  $singledata->salary_per_day;
                 $worker_details[$key]['status'] = $singledata->status;
                






            $result=tbl_attendance_entry::where('emp_code',$singledata->code)->where('current_att_date',date('Y-m-d'))->select('in_date_time','out_date_time','att_status')->get();
            if($result->count() >0 ){
                 $cntt=$result->count();

                 $worker_details[$key]['in_date_time'] = $result[$cntt - 1]->in_date_time;
                 $worker_details[$key]['out_date_time'] = $result[$cntt - 1]->out_date_time;
                 $worker_details[$key]['att_status'] = $result[$cntt - 1]->att_status;

            }else{

                $worker_details[$key]['in_date_time'] = '';
                $worker_details[$key]['out_date_time'] = '';
                $worker_details[$key]['att_status'] = '';

            }



         }

         $supervisor_details_all=tbl_employee_details::join('tbl_designation','tbl_designation.code','tbl_employee_details.emp_designation')->where('tbl_employee_details.code',$emp_code)->select('tbl_employee_details.*','tbl_designation.designation')->get();

         foreach( $supervisor_details_all as $key => $singledata){


                $supervisor_details[$key]['code'] =  $singledata->code;
                 $supervisor_details[$key]['emp_id'] = $singledata->emp_id;
                 $supervisor_details[$key]['emp_name'] =  $singledata->emp_name;
                  $supervisor_details[$key]['father_name'] =  $singledata->father_name;
                 $supervisor_details[$key]['mother_name'] = $singledata->mother_name;
                 $supervisor_details[$key]['emp_type'] =  $singledata->emp_type;

                 $supervisor_details[$key]['profile_image'] = "workersupervisor_photo/".$singledata->profile_image;
                 $supervisor_details[$key]['profile_image_thumb'] = "workersupervisor_photo/thumb/".$singledata->profile_image;
                 $supervisor_details[$key]['emp_designation'] = $singledata->designation;
                 $supervisor_details[$key]['emp_deparment'] =  $singledata->emp_deparment;
                  $supervisor_details[$key]['dob'] =  $singledata->dob;
                 $supervisor_details[$key]['gender'] = $singledata->gender;
                 $supervisor_details[$key]['blood_group'] =  $singledata->blood_group;

                  $supervisor_details[$key]['phno'] =  $singledata->phno;
                 $supervisor_details[$key]['hqualification'] = $singledata->hqualification;
                 $supervisor_details[$key]['email'] =  $singledata->email;
                  $supervisor_details[$key]['pan_no'] =  $singledata->pan_no;
                 $supervisor_details[$key]['marital_status'] = $singledata->marital_status;
                 $supervisor_details[$key]['spouse_name'] =  $singledata->spouse_name;

                 $supervisor_details[$key]['noofchildren'] =  $singledata->noofchildren;
                 $supervisor_details[$key]['contact_person'] = $singledata->contact_person;
                 $supervisor_details[$key]['emg_address'] =  $singledata->emg_address;
                  $supervisor_details[$key]['emg_phno'] =  $singledata->emg_phno;
                 $supervisor_details[$key]['emg_alt_phno'] = $singledata->emg_alt_phno;
                 $supervisor_details[$key]['relationship'] =  $singledata->relationship;

                  $supervisor_details[$key]['c_address'] =  $singledata->c_address;
                 $supervisor_details[$key]['c_dist'] = $singledata->c_dist;
                 $supervisor_details[$key]['c_state'] =  $singledata->c_state;
                  $supervisor_details[$key]['c_pin'] =  $singledata->c_pin;
                 $supervisor_details[$key]['p_address'] = $singledata->p_address;
                 $supervisor_details[$key]['p_dist'] =  $singledata->p_dist;

                  $supervisor_details[$key]['p_state'] =  $singledata->p_state;
                 $supervisor_details[$key]['p_pin'] = $singledata->p_pin;
                 $supervisor_details[$key]['joining_date'] =  $singledata->joining_date;
                  $supervisor_details[$key]['salary_per_day'] =  $singledata->salary_per_day;
                 $supervisor_details[$key]['status'] = $singledata->status;

            $result=tbl_attendance_entry::where('emp_code',$singledata->code)->where('current_att_date',date('Y-m-d'))->select('in_date_time','out_date_time','att_status')->get();
            if($result->count() >0 ){
                $cnt=$result->count();

                $supervisor_details[$key]['in_date_time'] = $result[$cnt - 1]->in_date_time;
                 $supervisor_details[$key]['out_date_time'] = $result[$cnt - 1]->out_date_time;
                  $supervisor_details[$key]['att_status'] = $result[$cnt - 1]->att_status;

            }else{

                $supervisor_details[$key]['in_date_time'] = '';
                 $supervisor_details[$key]['out_date_time'] = '';
                  $supervisor_details[$key]['att_status'] = '';

            }



         }

       }else if($emp_type == 2){

        //$worker_details_all= tbl_employee_details::where('tbl_employee_details.code',$emp_code)->get();

          $worker_details_all= tbl_employee_details::join('tbl_designation','tbl_designation.code','tbl_employee_details.emp_designation')->where('tbl_employee_details.code',$emp_code)->select('tbl_employee_details.*','tbl_designation.designation')->get();

          foreach( $worker_details_all as $key => $singledata){

             $worker_details[$key]['code'] =  $singledata->code;
                 $worker_details[$key]['emp_id'] = $singledata->emp_id;
                 $worker_details[$key]['emp_name'] =  $singledata->emp_name;
                  $worker_details[$key]['father_name'] =  $singledata->father_name;
                 $worker_details[$key]['mother_name'] = $singledata->mother_name;
                 $worker_details[$key]['emp_type'] =  $singledata->emp_type;

                  $supervisor_details[$key]['profile_image'] = "workersupervisor_photo/".$singledata->profile_image;
                 $supervisor_details[$key]['profile_image_thumb'] = "workersupervisor_photo/thumb/".$singledata->profile_image;
                 $worker_details[$key]['emp_designation'] = $singledata->designation;
                 $worker_details[$key]['emp_deparment'] =  $singledata->emp_deparment;
                  $worker_details[$key]['dob'] =  $singledata->dob;
                 $worker_details[$key]['gender'] = $singledata->gender;
                 $worker_details[$key]['blood_group'] =  $singledata->blood_group;

                  $worker_details[$key]['phno'] =  $singledata->phno;
                 $worker_details[$key]['hqualification'] = $singledata->hqualification;
                 $worker_details[$key]['email'] =  $singledata->email;
                  $worker_details[$key]['pan_no'] =  $singledata->pan_no;
                 $worker_details[$key]['marital_status'] = $singledata->marital_status;
                 $worker_details[$key]['spouse_name'] =  $singledata->spouse_name;

                 $worker_details[$key]['noofchildren'] =  $singledata->noofchildren;
                 $worker_details[$key]['contact_person'] = $singledata->contact_person;
                 $worker_details[$key]['emg_address'] =  $singledata->emg_address;
                  $worker_details[$key]['emg_phno'] =  $singledata->emg_phno;
                 $worker_details[$key]['emg_alt_phno'] = $singledata->emg_alt_phno;
                 $worker_details[$key]['relationship'] =  $singledata->relationship;

                  $worker_details[$key]['c_address'] =  $singledata->c_address;
                 $worker_details[$key]['c_dist'] = $singledata->c_dist;
                 $worker_details[$key]['c_state'] =  $singledata->c_state;
                  $worker_details[$key]['c_pin'] =  $singledata->c_pin;
                 $worker_details[$key]['p_address'] = $singledata->p_address;
                 $worker_details[$key]['p_dist'] =  $singledata->p_dist;

                  $worker_details[$key]['p_state'] =  $singledata->p_state;
                 $worker_details[$key]['p_pin'] = $singledata->p_pin;
                 $worker_details[$key]['joining_date'] =  $singledata->joining_date;
                  $worker_details[$key]['salary_per_day'] =  $singledata->salary_per_day;
                 $worker_details[$key]['status'] = $singledata->status;

            $result=tbl_attendance_entry::where('emp_code',$singledata->code)->where('current_att_date',date('Y-m-d'))->select('in_date_time','out_date_time','att_status')->get();
            if($result->count() >0 ){
                 $cnttt=$result->count();

                $worker_details[$key]['in_date_time'] = $result[$cnttt-1]->in_date_time;
                 $worker_details[$key]['out_date_time'] = $result[$cnttt-1]->out_date_time;
                  $worker_details[$key]['att_status'] = $result[$cnttt-1]->att_status;

            }else{

                $worker_details[$key]['in_date_time'] = '';
                 $worker_details[$key]['out_date_time'] = '';
                  $worker_details[$key]['att_status'] = '';

            }



         }

         $supervisor_details='';
       }

       $response=array('worker_details'=> $worker_details,'supervisor_details'=>$supervisor_details);
     
   


    } catch (\Exception $e) {
      $response = array(
        'exception' => true,
        'exception_message' => $e->getMessage(),
      );
      $statusCode = 400;
    } finally {
      return response()->json($response, $statusCode);
    }

    }

    public function get_all_data_employee(Request $request){

          $statusCode = 200;
    try {

     
       //$mob_user_code = $request->user()->code;
       $emp_type = $request->user()->emp_type;
       $emp_code = $request->user()->emp_code;

       if($emp_type == 1){

        $worker_code=tbl_supervisor_wise_worker::where('supervisor_code', $emp_code)->select('worker_code')->get();
       
         $worker_details= tbl_employee_details::wherein('tbl_employee_details.code',$worker_code)->get();

         foreach( $worker_details as $key => $singledata){

            $result=tbl_attendance_entry::where('emp_code',$singledata->code)->where('current_att_date',date('Y-m-d'))->select('in_date_time','out_date_time','att_status')->get();
            if($result->count() >0 ){
                 $cntt=$result->count();

                 $worker_details[$key]['in_date_time'] = $result[$cntt - 1]->in_date_time;
                 $worker_details[$key]['out_date_time'] = $result[$cntt - 1]->out_date_time;
                 $worker_details[$key]['att_status'] = $result[$cntt - 1]->att_status;

            }else{

                $worker_details[$key]['in_date_time'] = '';
                $worker_details[$key]['out_date_time'] = '';
                $worker_details[$key]['att_status'] = '';

            }



         }

         $supervisor_details=tbl_employee_details::where('tbl_employee_details.code',$emp_code)->get();

         foreach( $supervisor_details as $key => $singledata){

            $result=tbl_attendance_entry::where('emp_code',$singledata->code)->where('current_att_date',date('Y-m-d'))->select('in_date_time','out_date_time','att_status')->get();
            if($result->count() >0 ){
                $cnt=$result->count();

                $supervisor_details[$key]['in_date_time'] = $result[$cnt - 1]->in_date_time;
                 $supervisor_details[$key]['out_date_time'] = $result[$cnt - 1]->out_date_time;
                  $supervisor_details[$key]['att_status'] = $result[$cnt - 1]->att_status;

            }else{

                $supervisor_details[$key]['in_date_time'] = '';
                 $supervisor_details[$key]['out_date_time'] = '';
                  $supervisor_details[$key]['att_status'] = '';

            }



         }

       }else if($emp_type == 2){

        $worker_details= tbl_employee_details::where('tbl_employee_details.code',$emp_code)->get();

          foreach( $worker_details as $key => $singledata){

            $result=tbl_attendance_entry::where('emp_code',$singledata->code)->where('current_att_date',date('Y-m-d'))->select('in_date_time','out_date_time','att_status')->get();
            if($result->count() >0 ){
                 $cnttt=$result->count();

                $worker_details[$key]['in_date_time'] = $result[$cnttt-1]->in_date_time;
                 $worker_details[$key]['out_date_time'] = $result[$cnttt-1]->out_date_time;
                  $worker_details[$key]['att_status'] = $result[$cnttt-1]->att_status;

            }else{

                $worker_details[$key]['in_date_time'] = '';
                 $worker_details[$key]['out_date_time'] = '';
                  $worker_details[$key]['att_status'] = '';

            }



         }

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
   /*Image upload for Users
   Request $request
   Return JSONArray
   */

 public function upload_image(Request $request){
          $statusCode = 200;
    try {
       $user_code = $request->emp_code;
		 $imageName='gg';
            if (!empty($request->file('photo'))) {
                $file_upload = $request->file('photo');
                $file_ext = $file_upload->getClientOriginalExtension();
                $filename_upload = date("dmYhms") . rand(10001, 99999) . "." . $file_ext;
                $destination_path= "user_photo";
                $file_upload->move($destination_path, $filename_upload);
                $imageName = $filename_upload;
            }
		$data_upload=tbl_mobile_user::where('emp_code',$user_code)->update(['userImage'=>$imageName]);

        if($data_upload != ''){
                      $response = array(
                      'status' => 1,
                  );
            }else{
                       
                       $response = array(
                       'status' => 0,
                      );

                }
       
      
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

    public function uplaod_worker_supervisor_photo(Request $request){

             $statusCode = 200;
            try {
               $emp_code = $request->emp_code;
                 $imageName='';
                   if (!empty($request->file('photo'))) {
                       $file_upload = $request->file('photo');
                       $file_ext = $file_upload->getClientOriginalExtension();
                       $filename_upload = date("dmYhms") . rand(10001, 99999) . "." . $file_ext;
                       $destination_path= "workersupervisor_photo";
                       $file_upload->move($destination_path, $filename_upload);
                       $imageName = $filename_upload;

                        $input['imagename'] =  $filename_upload;

                         $destinationPath = public_path('workersupervisor_photo/thumb');
                        $img = Image::make($file_upload->path());
                        $img->resize(20, 20, function ($constraint) {
                            $constraint->aspectRatio();
                        })->save($destinationPath.'/'.$input['imagename']);

                        // $destinationPath = public_path('/workersupervisor_photo/thumb');
                        //     $img = Image::make($file_upload->path());
                        //     $img->resize(100, 100, function ($constraint) {
                        //         $constraint->aspectRatio();
                        //     })->save($destinationPath.'/'.$filename_upload);


                   }
                $data_upload=tbl_employee_details::where('code',$emp_code)->update(['profile_image'=>$imageName]);

                if($data_upload != ''){
                     $response = array(
                     'status' => 1,
                     'image_name'=> $imageName
                     );
                }else{
                       
                       $response = array(
                       'status' => 0,
                      );

                }
               
              
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

    public function employee_attendance_entry(Request $request){

          $statusCode = 200;
            try {
               $emp_code = $request->emp_code;
               $att_entry_detailss=array();
                $employee_image_detailss=array();
                 $imageName='pppoo.jpg';
                    // if (!empty($request->file('photo'))) {
                    //     $file_upload = $request->file('photo');
                    //     $file_ext = $file_upload->getClientOriginalExtension();
                    //     $filename_upload = date("dmYhms") . rand(10001, 99999) . "." . $file_ext;
                    //     $destination_path= "employee_attendance_photo";
                    //     $file_upload->move($destination_path, $filename_upload);
                    //     $imageName = $filename_upload;
                    // }

                 $result = tbl_attendance_entry::where('emp_code',$emp_code)->where('current_att_date',date('Y-m-d'))->select('in_date_time','out_date_time','emp_image','emp_image_out')->get();
                  if($result->count() > 0){

                     $att_code = tbl_attendance_entry::where('emp_code',$emp_code)->where('current_att_date',date('Y-m-d'))->select('code')->first();

                    if($result[0]->in_date_time == null || $result[0]->in_date_time == ''){

                     $update_data=tbl_attendance_entry::where('emp_code',$emp_code)->where('current_att_date',date('Y-m-d'))->update(['emp_image'=>$imageName]);
                       // unlink(public_path('employee_attendance_photo/' . $result[0]->emp_image));

                    $att_entry_details=array('emp_code'=>$emp_code,'attendance_image_name'=>$imageName,'attendance_entry_code'=>$att_code->code);

                     $att_entry_detailss[]=$att_entry_details;
                  
                     $employee_image_name=tbl_employee_details::where('code',$emp_code)->select('profile_image')->first();
                    $employee_image_details=array('employee_image_name'=>$employee_image_name->profile_image);

                     $employee_image_detailss[]=$employee_image_details;

                    $response=array('att_entry_details'=>$att_entry_detailss,'employee_image_details'=>$employee_image_detailss,'status'=>2);


                    }else{

                        if($result[0]->out_date_time == null || $result[0]->out_date_time == ''){

                     $update_data=tbl_attendance_entry::where('emp_code',$emp_code)->where('current_att_date',date('Y-m-d'))->update(['emp_image_out'=>$imageName]);
                       // unlink(public_path('employee_attendance_photo/' . $result[0]->emp_image));

                    $att_entry_details=array('emp_code'=>$emp_code,'attendance_image_name'=>$imageName,'attendance_entry_code'=>$att_code->code);

                     $att_entry_detailss[]=$att_entry_details;
                  
                     $employee_image_name=tbl_employee_details::where('code',$emp_code)->select('profile_image')->first();
                    $employee_image_details=array('employee_image_name'=>$employee_image_name->profile_image);

                     $employee_image_detailss[]=$employee_image_details;

                    $response=array('att_entry_details'=>$att_entry_detailss,'employee_image_details'=>$employee_image_detailss,'status'=>2);




                        }else{

                             $response=array('att_entry_details'=>"In & Out Time Exist",'employee_image_details'=>"In & Out Time Exist",'status'=>0);

                        }





                       

                    }



                  }else{

                      $attendance_entry=new tbl_attendance_entry();
                        $attendance_entry->emp_code=$emp_code;
                        $attendance_entry->emp_image=$imageName;
                        $attendance_entry->current_att_date=date('Y-m-d');
                       

                        if($attendance_entry->save()){

                             $att_entry_details=array('emp_code'=>$emp_code,'attendance_image_name'=>$imageName,'attendance_entry_code'=>$attendance_entry->code);
                             $att_entry_detailss[]=$att_entry_details;
                          
                             $employee_image_name=tbl_employee_details::where('code',$emp_code)->select('profile_image')->first();
                            $employee_image_details=array('employee_image_name'=>$employee_image_name->profile_image);

                             $employee_image_detailss[]=$employee_image_details;

                            $response=array('att_entry_details'=>$att_entry_detailss,'employee_image_details'=>$employee_image_detailss,'status'=>1);

                       }else{

                        $response=array('status'=>4);

                       }

                  }


              


              
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

    public function employee_attendance_update(Request $request){

           $statusCode = 200;
            try {
               $emp_att_code = $request->emp_att_code;
                $date_time = $request->date_time;
                $att_lat = $request->att_lat;
                $att_long = $request->att_long;

                $result=tbl_attendance_entry::where('code',$emp_att_code)->select('in_date_time','att_status','emp_image','emp_image_out')->first();

                if(($result->in_date_time == null || $result->in_date_time == '') && $result->att_status == 0){

                    $update_result=tbl_attendance_entry::where('code',$emp_att_code)->where('current_att_date',date('Y-m-d'))->update(['in_date_time'=>$date_time,'att_status'=>1,'att_lat'=>$att_lat,'att_long'=>$att_long]);

                     // unlink(public_path('employee_attendance_photo/' . $result->emp_image));

                }else{
                    
                    $update_result=tbl_attendance_entry::where('code',$emp_att_code)->where('current_att_date',date('Y-m-d'))->update(['out_date_time'=>$date_time,'att_status'=>2,'att_lat_out'=>$att_lat,'att_long_out'=>$att_long]);

                     // unlink(public_path('employee_attendance_photo/' . $result->emp_image_out));

                }

              

               if($update_result != ''){

                $response=array('status'=>1);
               }else{
                $response=array('status'=>0);
               }


              
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
