<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\tbl_department;
use App\tbl_designation;
use App\tbl_employee_details;
use App\tbl_allowance;
use App\tbl_employee_allowance_entry;
use App\tbl_designation_wise_allowance;
use DB;

class EmployeeController extends Controller
{
    public function employee_details(){

        return view('employee_details');
    }
    public function add_employee(){

        return view('employee_entry');
    }

    public function get_all_designation(Request $request){

          $statusCode = 200;
          if (!$request->ajax()) {

            $statusCode = 400;
            $response = array('error' => 'Error occered in Json call.');
            return response()->json($response, $statusCode);
          }
          try {

            $designations = tbl_designation::pluck('designation', 'code');

            $response = array(
              'options' => $designations, 'status' => 1
            );
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

    public function get_all_department(Request $request){

          $statusCode = 200;
          if (!$request->ajax()) {

            $statusCode = 400;
            $response = array('error' => 'Error occered in Json call.');
            return response()->json($response, $statusCode);
          }
          try {

            $departments = tbl_department::pluck('department', 'code');

            $response = array(
              'options' => $departments, 'status' => 1
            );
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

    public function personaldetails_save_update(Request $request){


      $statusCode = 200;
      if (!$request->ajax()) {
          $statusCode = 400;
          $response = array('error' => 'Error occured in form submit.');
          return response()->json($response, $statusCode);
      }
          $this->validate($request,[
             'emp_name'=>"required|regex:/^([a-zA-Z]+\s?)*$/",
             'f_name'=>"required|regex:/^([a-zA-Z]+\s?)*$/",
             'm_name'=>"required|regex:/^([a-zA-Z]+\s?)*$/",
             'dob'=>"required|date_format:d/m/Y",
             'gender'=>"required",
             'marital_status'=>"required",
             'blood_group'=>"nullable",
             'spouse_name'=>"nullable|regex:/^([a-zA-Z]+\s?)*$/",
             'noofchildren'=>"nullable|digits:1",
             'hqualification'=>"nullable|regex: /^([a-zA-Z0-9]+\s?)*$/",
             ],
             [
              'emp_name.required' => 'Employee Name is Required',
              'emp_name.regex' => 'Only Alphabate and Space Allowed in Employee Name',
              'f_name.required' => "Father's Name is Required",
              'f_name.regex' => "Only Alphabate and Space Allowed in Father's Name",
              'm_name.required' => "Mother's Name is Required",
              'm_name.regex' => "Only Alphabate and Space Allowed in Mothers's Name",
              'gender.required' => 'Gender is required',
              'dob.required' => 'Date of Birth is Required',
               'dob.date_format' => 'Date format of Date of Birth is not Valid',
              'marital_status.required' => 'Marital Status is Required',
              'spouse_name.regex' => "Only Alphabate and Space Allowed in Spouse Name",
              'hqualification.regex' => "Only Alphanumeric and Space Allowed in Highest Qualification",
              'noofchildren.digits' => "No of Children Should be in 1 Digits",
             

             ]);

        
          try{
                 
                 if(isset($request->personalcode)){
                  $personal_save=tbl_employee_details::find($request->personalcode);
                 }else{
                    $personal_save=new tbl_employee_details();
                   $maxValue = tbl_employee_details::select('emp_id')->where('code', DB::raw("(select max(code) from tbl_employee_details )"))->get();
                   if($maxValue->count() == 0){
                    $personal_save->emp_id=600000;
                   }else{
                    $personal_save->emp_id=$maxValue[0]->emp_id + 1;
                   }
                  
                 }

                 $personal_save->dob=$request->dob;
                 $personal_save->emp_name=$request->emp_name;
                 $personal_save->father_name=$request->f_name;
                 $personal_save->mother_name=$request->m_name;
                 $personal_save->gender=$request->gender;
                 $personal_save->marital_status=$request->marital_status;
                 $personal_save->blood_group=$request->blood_group;
                 $personal_save->spouse_name=$request->spouse_name;
                 $personal_save->noofchildren=$request->noofchildren;
                 $personal_save->hqualification=$request->hqualification;
                
                 if($personal_save->save()){
                  if(isset($request->personalcode)){
                      // echo $request->code;die;
                      $response = array(
                        'code' => $personal_save->code,
                          'status' => 2,
                      );
                      }else{
                          $response = array(
                            'code' => $personal_save->code,
                              'status' => 1,
                          );
                      }
                 }else{
                     $response = array(
                         'status' => 3,
                     );
                 }
              }
             catch(\Exception $e){
                 $response = array(
                     'exception' => true,
                     'exception_message' => $e->getMessage(),
                 );
                 $statuscode=400;
              } finally{
                return response()->json($response, $statusCode);
             }

    }

    public function get_personal_details(Request $request){

         $statuscode = 200;
      $this->validate($request, [
        'code' => "required|integer",
        ], [
        'code.required' => 'Personal Code is Required',
        'code.integer' => 'Personal Code as a Integer',
      ]);
  
      try {
        $personal_dtl =tbl_employee_details::select('code',  'dob' , 'emp_name','father_name',  'gender', 'mother_name', 'blood_group', 'hqualification', 'marital_status', 'spouse_name', 'noofchildren')->where('code', '=', $request->code)->first();

        $response = array('personal_dtl' => $personal_dtl);
      }
      catch (\Exception $e) {
        $response = array(
          'exception' => true,
          'exception_message' => $e->getMessage(),
        );
        $statuscode = 400;
      } finally {
        $res = response()->json($response, $statuscode);
      }
      return $res;


    }

    public function contactdetails_save_update(Request $request){


                $statusCode = 200;
                if (!$request->ajax()) {
                    $statusCode = 400;
                    $response = array('error' => 'Error occured in form submit.');
                    return response()->json($response, $statusCode);
                }
                    $this->validate($request,[
                      'mob_no'=>"required|digits:10",
                      'email'=>"required|email",
                      'c_state'=>"required|regex:/^([a-zA-Z0-9]+\s?)*$/",
                      'c_dist'=>"required|regex:/^([a-zA-Z0-9]+\s?)*$/",
                      'c_address'=>"required|regex: /^([a-zA-Z0-9]+\s?)*$/",
                      'c_pin'=>"required|digits:6",
                      'p_state'=>"required|regex:/^([a-zA-Z0-9]+\s?)*$/",
                      'p_dist'=>"required|regex:/^([a-zA-Z0-9]+\s?)*$/",
                      'p_address'=>"required|regex: /^([a-zA-Z0-9]+\s?)*$/",
                      'p_pin'=>"required|digits:6",
                      'contact_person'=>"required|regex:/^([a-zA-Z]+\s?)*$/",
                      'relationship'=>"required|regex:/^([a-zA-Z]+\s?)*$/",
                      'emg_address'=>"required|regex: /^([a-zA-Z0-9]+\s?)*$/",
                      'emg_mob_no'=>"required|digits:10",
                    
                       ],
                       [
                        'mob_no.required' => 'Mobile Number is Required',
                        'mob_no.digits' => 'Mobile Number Must be in 10 Digits',
                        'email.required' => 'Email ID is Required',
                        'email.email' => 'Email ID is not Valid',
                        'c_state.required' => " Present State is Required",
                        'c_dist.required' => " Present District is Required",
                        'c_address.required' => 'Present Address is Required',
                        'c_pin.required' => 'Present Pin is Required',
                        'p_state.required' => "Permanent State is Required",
                        'p_dist.required' => "Permanent District is Required",
                        'p_address.required' => ' Permanent Address is Required',
                        'p_pin.required' => 'Permanent Pin is Required',

                        'c_state.regex' => "Only Alphanumeric and Space Allowed in Present State",
                        'c_dist.regex' => "Only Alphanumeric and Space Allowed in Present District",
                        'c_address.regex' => 'Only Alphanumeric and Space Allowed in Present Address',
                        'c_pin.digits' => 'Present Pin should be in 6 Digits',
                        'p_state.regex' => "Only Alphanumeric and Space Allowed in Permanent State ",
                        'p_dist.regex' => "Only Alphanumeric and Space Allowed in Permanent District",
                        'p_address.regex' => 'Only Alphanumeric and Space Allowed in Permanent Address',
                        'p_pin.digits' => 'Permanent Pin should be in 6 Digits',
                        'contact_person.required' => "Contact Person is Required",
                        'contact_person.regex' => "Only Alphabate and Space Allowed in Contact Person",
                        'relationship.required' => "Relationship with Contact Person is Required",
                        'relationship.regex' => "Only Alphabate and Space Allowed in Relationship with Contact Person",
                        'emg_address.required' => "Emergency Address is Required",
                        'emg_address.regex' => 'Only Alphanumeric and Space Allowed in Emergency Address',
                        'emg_mob_no.required' => "Emergency Mobile Number is Required",
                        'emg_mob_no.digits' => "Emergency Mobile Number must be in 10 Digits",

                       ]);
              
              
                    try{
                    
                           $contact_save=tbl_employee_details::find($request->contactcode);
                           $contact_save->phno=$request->mob_no;
                           $contact_save->email=$request->email;
                           $contact_save->c_state=$request->c_state;
                           $contact_save->c_dist=$request->c_dist;
                           $contact_save->c_address=$request->c_address;
                           $contact_save->c_pin=$request->c_pin;
                           $contact_save->p_state=$request->p_state;
                           $contact_save->p_dist=$request->p_dist;
                           $contact_save->p_address=$request->p_address;
                           $contact_save->p_pin=$request->p_pin;
                           $contact_save->contact_person=$request->contact_person;
                           $contact_save->relationship=$request->relationship;
                           $contact_save->emg_address=$request->emg_address;
                           $contact_save->emg_phno=$request->emg_mob_no;
                          
                           if($contact_save->save()){
                            if(isset($request->contactcode)){
        
                                // echo $request->code;die;
                                $response = array(
                                     'code' => $contact_save->code,
                                    'status' => 1,
                                );
                                }else{
                                    $response = array(
                                     'code' => $contact_save->code,
                                        'status' => 2,
                                    );
                                }
                           }else{
                               $response = array(
                                   'status' => 3,
                               );
                           }
                  
                      }
                       catch(\Exception $e){
                           $response = array(
                               'exception' => true,
                               'exception_message' => $e->getMessage(),
                           );
                           $statuscode=400;
                        } finally{
                          return response()->json($response, $statusCode);
                       }


    }

      public function get_contact_details(Request $request){

        $statuscode = 200;
      $this->validate($request, [
        'code' => "required|integer",
        ], [
        'code.required' => 'Contact Code is Required',
        'code.integer' => 'Contact Code as a Integer',
      ]);
  
      try {
        $contact_dtl =tbl_employee_details::select('code',  'phno' , 'email','c_state',  'c_dist', 'c_address', 'c_pin', 'p_state', 'p_dist', 'p_address', 'p_pin','contact_person','relationship','emg_address','emg_phno')->where('code', '=', $request->code)->first();

        $response = array('contact_dtl' => $contact_dtl);
      }
      catch (\Exception $e) {
        $response = array(
          'exception' => true,
          'exception_message' => $e->getMessage(),
        );
        $statuscode = 400;
      } finally {
        $res = response()->json($response, $statuscode);
      }
      return $res;




      }

      public function workingdetails_save_update(Request $request){

                $statusCode = 200;
                if (!$request->ajax()) {
                    $statusCode = 400;
                    $response = array('error' => 'Error occured in form submit.');
                    return response()->json($response, $statusCode);
                }
                    $this->validate($request,[
                      'emp_type'=>"required",
                      'emp_designation'=>"required",
                      'emp_deparment'=>"required",
                      'joining_date'=>"required|date_format:d/m/Y",
                      'per_day_salary'=>"required|integer",
                      
                    
                       ],
                       [
                        'emp_type.required' => 'Employee Type is Required',
                        'emp_designation.required' => 'Designation is Required',
                        'emp_deparment.required' => " Department is Required",
                        'joining_date.required' => " Joining Date is Required",
                        'joining_date.date_format' => 'Date format of Joining Date is not Valid',
                        'per_day_salary.required' => 'Per Day Salary is Required',
                        'per_day_salary.integer' => 'Per Day Salary Must be in Digits',

                       ]);
              
              
                    try{


                     $result=tbl_designation_wise_allowance::join('tbl_allowance','tbl_allowance.code','tbl_designation_wise_allowance.allowance_code')->where('tbl_designation_wise_allowance.designation_code',$request->emp_designation)->select('tbl_allowance.name_of_allowance')->get();

                    // print_r($result);die;
                    
                           $working_save=tbl_employee_details::find($request->workingcode);
                           $working_save->emp_type=$request->emp_type;
                           $working_save->emp_designation=$request->emp_designation;
                           $working_save->emp_deparment=$request->emp_deparment;
                           $working_save->joining_date=$request->joining_date;
                           $working_save->salary_per_day=$request->per_day_salary;
                           
                          
                           if($working_save->save()){
                            if(isset($request->workingcode)){

                                // echo $working_save->code;die;
                                $response = array(
                                    'code' => $working_save->code,
                                    'allowance_all' => $result,
                                    'status' => 1,
                                );
                                }else{

                                   

                                    $response = array(
                                     'code' => $working_save->code,
                                      'allowance_all' => $result,
                                        'status' => 2,
                                    );
                                }
                           }else{
                               $response = array(
                                   'status' => 3,
                               );
                           }
                  
                      }
                       catch(\Exception $e){
                           $response = array(
                               'exception' => true,
                               'exception_message' => $e->getMessage(),
                           );
                           $statuscode=400;
                        } finally{
                          return response()->json($response, $statusCode);
                       }


      }

       public function list_employee(Request $request){

                     $statusCode = 200;
                    if (!$request->ajax()) {
                        $statusCode = 400;
                        $response = array('error' => 'Error occured in form submit.');
                        return response()->json($response, $statusCode);
                    }
                   
                    try{
                    $draw = $request->draw;
                    $offset = $request->start;
                    $length = $request->length;
                    $search = $request->search ["value"];
                    $order = $request->order;
                    $data = array();

                    $allemployee =  tbl_employee_details::leftjoin('tbl_designation','tbl_designation.code','tbl_employee_details.emp_designation')
                    ->leftjoin('tbl_department','tbl_department.code','tbl_employee_details.emp_deparment')
                    ->select('tbl_employee_details.code','tbl_employee_details.emp_name','tbl_designation.designation','tbl_department.department','tbl_employee_details.emp_type','tbl_employee_details.c_address','tbl_employee_details.phno')
                            ->where(function($q) use ($search) {
                        $q->orwhere('tbl_designation.designation', 'like', '%' . $search . '%');
                        $q->orwhere('tbl_department.department', 'like', '%' . $search . '%');
                        $q->orwhere('tbl_employee_details.emp_name', 'like', '%' . $search . '%');
                        
                    });



                    $record = $allemployee;

                    for ($i = 0; $i < count($order); $i ++) {
                    $record = $record->orderBy($request->columns [$order [$i] ['column']] ['data'], strtoupper($order [$i] ['dir']));
                      }

                    $filtered_count = $allemployee->count();
                    $page_displayed = $record->offset($offset)->limit($length)->get();

                      


                    $count = $offset + 1;
                    foreach ($page_displayed as $singledata) {
                        $nestedData['id'] = $count;
                        $nestedData['emp_name'] = $singledata->emp_name;
                        $nestedData['designation'] = $singledata->designation;
                        $nestedData['department'] = $singledata->department;

                        if($singledata->emp_type == 1){
                          $p="Supervisor";
                        }else if($singledata->emp_type == 2){
                          $p="Worker";
                        }
                        $nestedData['emp_type'] = $p;
                        $nestedData['c_address'] = $singledata->c_address;
                        $nestedData['phno'] = $singledata->phno;


                        $edit_button = $delete_button =  $singledata->code;
                        $nestedData['action'] = array('e' => $edit_button, 'd' => $delete_button);


                        $count++;
                        $data[] = $nestedData;
                    }
                    $response = array(
                        "draw" => $draw,
                        "recordsTotal" => $filtered_count,
                        "recordsFiltered" => $filtered_count,
                        'record_details' => $data
                    );
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

       public function employee_edit(Request $request){

        $employee_code=$request->employee_code;
        return view('employee_entry')->with('emp_cdd',$employee_code);


       }

       public function get_working_details(Request $request){

          $statuscode = 200;
      $this->validate($request, [
        'code' => "required|integer",
        ], [
        'code.required' => 'Working Code is Required',
        'code.integer' => 'Working Code as a Integer',
      ]);
  
      try {
        $working_dtl =tbl_employee_details::select('code',  'emp_type' , 'emp_designation','emp_deparment',  'joining_date', 'salary_per_day')->where('code', '=', $request->code)->first();

        $response = array('working_dtl' => $working_dtl);
      }
      catch (\Exception $e) {
        $response = array(
          'exception' => true,
          'exception_message' => $e->getMessage(),
        );
        $statuscode = 400;
      } finally {
        $res = response()->json($response, $statuscode);
      }
      return $res;



       }

       public function employee_delete(Request $request){

            $statusCode = 200;
        
        if (!$request->ajax()) {
            $statusCode = 400;
            $response = array('error' => 'Error occured in form submit.');
            return response()->json($response, $statusCode);
        }

        $this->validate($request, [
            'dlt_code' => 'required|integer',
                ], [
            'dlt_code.required' => 'Delete Code is required',
            'dlt_code.integer' => 'Delete Code Accepted Only Integer',
        ]);


        try {

            $result=tbl_employee_allowance_entry::where('emp_code',$request->dlt_code)->delete();
            $dlt_data = tbl_employee_details::where('code', '=', $request->dlt_code); 
            if (!empty($dlt_data)) {//Should be changed #30
                $dlt_data = $dlt_data->delete();
            }
            $response = array(
                'status' => 1 //Should be changed #32
            );
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

       public function view_employee_details(Request $request){

        $statuscode=200;
        if (!$request->ajax()) {
            $statusCode = 400;
            $response = array('error' => 'Error occured in form submit.');
            return response()->json($response, $statusCode);
        }
       
        try {

            $employeedetails =tbl_employee_details::leftjoin('tbl_designation','tbl_designation.code','tbl_employee_details.emp_designation')
            ->leftjoin('tbl_department','tbl_department.code','tbl_employee_details.emp_deparment')
            ->select('phno' , 'email','c_state',  'c_dist', 'c_address', 'c_pin', 'p_state', 'p_dist', 'p_address', 'p_pin','contact_person','relationship','emg_address','emg_phno','dob' , 'emp_name','father_name',  'gender', 'mother_name', 'blood_group', 'hqualification', 'marital_status', 'spouse_name', 'noofchildren','tbl_designation.designation','tbl_department.department','emp_type','joining_date','salary_per_day')
            ->where('tbl_employee_details.code', '=', $request->code)->first();

                    $response=$employeedetails;
                }

            catch(\Exception $e){
                $response = array(
                    'exception' => true,
                    'exception_message' => $e->getMessage(),
                );
                $statuscode=400;
            } finally{
                return response()->json($response, $statuscode);
            }


    }

      public static function get_all_allowance(){

        $result=tbl_allowance::select('name_of_allowance','code','allowance_type')->get();
        return $result;

     }

     public function salarydetails_save_update(Request $request){

          $statusCode = 200;
                if (!$request->ajax()) {
                    $statusCode = 400;
                    $response = array('error' => 'Error occured in form submit.');
                    return response()->json($response, $statusCode);
                }
                    // $this->validate($request,[
                    //   'emp_type'=>"required",
                    //   'emp_designation'=>"required",
                    //   'emp_deparment'=>"required",
                    //   'joining_date'=>"required|date_format:d/m/Y",
                    //   'per_day_salary'=>"required|integer",
                      
                    
                    //    ],
                    //    [
                    //     'emp_type.required' => 'Employee Type is Required',
                    //     'emp_designation.required' => 'Designation is Required',
                    //     'emp_deparment.required' => " Department is Required",
                    //     'joining_date.required' => " Joining Date is Required",
                    //     'joining_date.date_format' => 'Date format of Joining Date is not Valid',
                    //     'per_day_salary.required' => 'Per Day Salary is Required',
                    //     'per_day_salary.integer' => 'Per Day Salary Must be in Digits',

                    //    ]);
              
              
                    try{

                      //  dd($request->all());
                      //  echo $request->salarycode;die;

                          $emp_code = $request->salarycode ;

                          $result=tbl_employee_allowance_entry::where('emp_code',$emp_code)->delete();

                          $exparr1=explode(',', $request->arr1);
                          $exparr2=explode(',', $request->arr2);

                          $exparr3=explode(',', $request->arr_month_day);
                          $exparr4=explode(',', $request->fixed_persentage);
                          $exparr5=explode(',', $request->all_allowance);
                          $aarylength=count($exparr1);

                             for ($i = 0; $i < $aarylength ; $i++) {
 
                                   $salary_save= new tbl_employee_allowance_entry();
                                   $salary_save->emp_code=$request->salarycode;
                                   $salary_save->salary_type=$exparr3[$i];
                                   $salary_save->allowance_code= $exparr1[$i];
                                   $salary_save->amount= $exparr2[$i];
                                   $salary_save->fixed_persentage= $exparr4[$i];
                                   $salary_save->on_allowance_code= $exparr5[$i];

                                  $res = $salary_save->save(); 
                                
                             }
                          
                           if($res){
                            if(isset($request->salarycode)){
        
                                // echo $request->code;die;
                                $response = array(
                                    // 'code' => $working_save->code,
                                    'status' => 1,
                                );
                                }else{
                                    $response = array(
                                    // 'code' => $working_save->code,
                                        'status' => 2,
                                    );
                                }
                           }else{
                               $response = array(
                                   'status' => 3,
                               );
                           }
                  
                      }
                       catch(\Exception $e){
                           $response = array(
                               'exception' => true,
                               'exception_message' => $e->getMessage(),
                           );
                           $statuscode=400;
                        } finally{
                          return response()->json($response, $statusCode);
                       }



     }

         public function get_salary_details(Request $request){

             //echo $request->code;die;
            $statuscode = 200;
              $this->validate($request, [
                'code' => "required|integer",
                ], [
                'code.required' => 'Salary Code is Required',
                'code.integer' => 'Salary Code as a Integer',
              ]);
          
              try {
                $salary_dtl =tbl_employee_allowance_entry::join('tbl_allowance','tbl_allowance.code','tbl_employee_allowance_entry.allowance_code')->where('tbl_employee_allowance_entry.emp_code', '=', $request->code)->select('tbl_employee_allowance_entry.code',  'tbl_employee_allowance_entry.emp_code' , 'tbl_employee_allowance_entry.salary_type','tbl_employee_allowance_entry.allowance_code',  'tbl_employee_allowance_entry.amount','tbl_allowance.name_of_allowance','tbl_employee_allowance_entry.fixed_persentage','tbl_employee_allowance_entry.on_allowance_code')->get();

                $response = array('salary_dtl' => $salary_dtl);
              }
              catch (\Exception $e) {
                $response = array(
                  'exception' => true,
                  'exception_message' => $e->getMessage(),
                );
                $statuscode = 400;
              } finally {
                $res = response()->json($response, $statuscode);
              }
              return $res;



         }


}
