<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\tbl_department;
use App\tbl_designation;
use App\tbl_employee_details;
use App\tbl_mobile_user;
use DB;
use Validator;

class UserController extends Controller
{
    public function user_details(){
        return view('user_details');
    }
    public function add_user(){
        return view('user_entry');
    }


    public function get_all_employee_name(Request $request){

         $statusCode = 200;
    if (!$request->ajax()) {
      $statusCode = 400;
      $response = array('error' => 'Error occured in Ajax Call.');
      return response()->json($response, $statusCode);
    }
    else {
      $term = trim($request->q);
      $validator1 = \Validator::make(compact('term'), [
          'term' => 'required',
          ], [
          'term.required' => 'Employee Name is Requred.',
          
      ]);
      $this->validateWith($validator1);

      try {
        // echo $term;die;
        $personnelResult = [];

        $term = trim($request->q);
        // echo $term;die;
        if (empty($term)) {
          return \Response::json([]);
        }

        $searchPersonnel = tbl_employee_details::where('emp_name', 'like', '%' . $term . '%')->select('emp_name', 'code');

        $searchPersonnel = $searchPersonnel->get();

        $nestedData = array();
        foreach ($searchPersonnel as $searchPersonnel) {
          $personnelResult['emp_name'] = $searchPersonnel["emp_name"];
          $personnelResult['code'] = $searchPersonnel["code"];
          $nestedData[] = $personnelResult;
        }
        $response = array('options' => $nestedData);
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

    public function user_save_update(Request $request){

    $statusCode = 200;
    if (!$request->ajax()) {
        $statusCode = 400;
        $response = array('error' => 'Error occured in form submit.');
        return response()->json($response, $statusCode);
    }
        $this->validate($request,[
            'name'=>"required|regex:/^([a-zA-Z]+\s?)*$/",
            'mob_no'=>"required|digits:10",
            'designation'=>"required",
            'emp_type'=>"required",
            'employee'=>"required",
               ],[
            'name.required' => 'Name is Required',
            'name.regex' => 'Only Alphabate and Space Allowed in Name',
            'mob_no.required' => 'Mobile Number is Required',
            'mob_no.digits' => 'Mobile Number must be 10 Digits',
            'designation.required' => 'Designation is Required',
            'emp_type.required' => 'Employee Type is Required',
            'employee.required' => 'Employee is Required',
           ]);


        try{
               if(isset($request->editcd)){
                $user=tbl_mobile_user::find($request->editcd);
               }else{
                $user=new tbl_mobile_user();
               }

               $user->name=$request->name;
               $user->emp_code=$request->employee;
               $user->emp_type=$request->emp_type;
               $user->designation=$request->designation;
               $user->mobile_no=$request->mob_no;

               if($user->save()){
                if(isset($request->editcd)){
                    $response = array(
                        'status' => 2,
                    );
                    }else{
                        $response = array(
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

    public function list_user(Request $request){

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

                    $alluser =  tbl_mobile_user::join('tbl_employee_details','tbl_employee_details.code','tbl_mobile_user.emp_code')
                    ->whereIn('tbl_mobile_user.emp_type',[1,2])
                    ->select('tbl_mobile_user.code','tbl_employee_details.emp_name','tbl_mobile_user.emp_type','tbl_mobile_user.mobile_no','tbl_mobile_user.designation','tbl_mobile_user.name','tbl_mobile_user.status')
                            ->where(function($q) use ($search) {
                        $q->orwhere('tbl_employee_details.emp_name', 'like', '%' . $search . '%');
                         $q->orwhere('tbl_mobile_user.name', 'like', '%' . $search . '%');
                        $q->orwhere('tbl_mobile_user.mobile_no', 'like', '%' . $search . '%');
                        $q->orwhere('tbl_mobile_user.designation', 'like', '%' . $search . '%');
                        
                    });

                    $record = $alluser;

                    for ($i = 0; $i < count($order); $i ++) {
                    $record = $record->orderBy($request->columns [$order [$i] ['column']] ['data'], strtoupper($order [$i] ['dir']));
                      }

                    $filtered_count = $alluser->count();
                    $page_displayed = $record->offset($offset)->limit($length)->get();

                    $count = $offset + 1;
                    foreach ($page_displayed as $singledata) {
                        $nestedData['id'] = $count;
                        $nestedData['name'] = $singledata->name;
                        $nestedData['mobile_no'] = $singledata->mobile_no;
                        $nestedData['designation'] = $singledata->designation;
                        $nestedData['emp_name'] = $singledata->emp_name;

                        if($singledata->emp_type == 1){
                            $p="Supervisor";
                        }else{
                            $p="Worker";
                        }

                         $nestedData['emp_type'] = $p;

                        $status = $singledata->status;
                         
                        if($status == 1){
                            $q=1;
                        }else{
                            $q=2;
                        }
                      

                        $edit_button = $delete_button =  $singledata->code;
                        $nestedData['action'] = array('e' => $edit_button, 'd' => $delete_button, 'status'=>$q);

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


    public function active_deactive_user(Request $request){

         $statuscode = 200;
      $this->validate($request, [
        'user_code' => "required|integer",
        'status' => "required",
        ], [
        'user_code.required' => 'User Code is Required',
        'status.required' => 'Status is Required',
        'user_code.integer' => 'User Code as a Integer',
      ]);
  
      try {

        $status=$request->status;
        $user_code=$request->user_code;

        if($status == 1){

           $result=tbl_mobile_user::where('code', $user_code)->update(['status'=>0]);

            $response = array('status' => 1);

        }else{

            $result=tbl_mobile_user::where('code', $user_code)->update(['status'=>1]);
             $response = array('status' => 2);

        }

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


    public function user_edit(Request $request){

         $this->validate($request, [
            'user_code' => 'required|integer',
                ], [        
            'user_code.required' => 'User Code is required',
            'user_code.integer' => 'User Code Accepted Only Integer',
        ]); 

        
        try{
        $user_code = $request->user_code;

        if($user_code!=0){
          $edit_data=tbl_mobile_user::join('tbl_employee_details','tbl_employee_details.code','tbl_mobile_user.emp_code')
          ->where('tbl_mobile_user.code','=',$user_code)
          ->select('tbl_mobile_user.*','tbl_employee_details.emp_name')
          ->first();  
        }else{
          $edit_data=array();
        }
       
       } catch (\Exception $e) {
            $response = array(
                'exception' => true,
                'exception_message' => $e->getMessage(),
            );
            $statusCode = 400;
        } finally {
           return  view('user_entry')->with('user_data',$edit_data);
        } 


    }
}
