<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\tbl_attendance_entry;
use App\tbl_employee_details;
use App\tbl_of_holiday;
use App\tbl_employee_wise_shift_allocation;
use App\tbl_shift;
use App\tbl_years;
use App\tbl_type_of_leave;
use App\tbl_designation_wise_leave_assign;
use App\tbl_employee_leave_taken;
use DB;

class AttendanceReportController extends Controller
{

    public function attendance_report(){

        return view('attendance_report');
    }

    public function list_attendance_report(Request $request){

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
                 $from_dt = date('Y-m-d', strtotime(trim(str_replace('/', '-', $request->from_date))));
                 $to_dt = date('Y-m-d', strtotime(trim(str_replace('/', '-', $request->to_date))));

            $allattendance =  tbl_attendance_entry::join('tbl_employee_details','tbl_employee_details.code','tbl_attendance_entry.emp_code')
                ->join('tbl_department','tbl_department.code','tbl_employee_details.emp_deparment')
                ->join('tbl_designation','tbl_designation.code','tbl_employee_details.emp_designation')
                ->select('tbl_attendance_entry.*','tbl_employee_details.emp_name','tbl_department.department','tbl_designation.designation',DB::raw('DATE_FORMAT(tbl_attendance_entry.current_att_date, "%d/%m/%Y") as current_att_datett'),'tbl_attendance_entry.att_status','tbl_employee_details.emp_id','tbl_attendance_entry.code')
                        ->where(function($q) use ($search) {
                    //$q->orwhere('department', 'like', '%' . $search . '%');
                    
                });

                 if ($request->employee != '') {
                    $allattendance = $allattendance->where('tbl_attendance_entry.emp_code', '=', $request->employee);
                  }
                  if ($request->department != '') {
                    $allattendance = $allattendance->where('tbl_employee_details.emp_deparment', '=', $request->department);
                  }
                  if ($request->designation != '') {
                    $allattendance = $allattendance->where('tbl_employee_details.emp_designation', '=', $request->designation);
                  }
                  if ($request->from_date != '') {
                    $allattendance = $allattendance->where(DB::raw("DATE(tbl_attendance_entry.current_att_date)"), '>=', $from_dt);
                  }
                  if ($request->to_date != '') {
                    $allattendance = $allattendance->where(DB::raw("DATE(tbl_attendance_entry.current_att_date)"), '<=', $to_dt);
                  }
                            
                 // print_r($allattendance);die;

                $record = $allattendance;

                for ($i = 0; $i < count($order); $i ++) {
                $record = $record->orderBy($request->columns [$order [$i] ['column']] ['data'], strtoupper($order [$i] ['dir']));
                  }
                $filtered_count = $allattendance->count();
                $page_displayed = $record->offset($offset)->limit($length)->get();

                $count = $offset + 1;
                foreach ($page_displayed as $singledata) {
                    $nestedData['id'] = $count;
                    $nestedData['emp_name'] = $singledata->emp_name;
                    $nestedData['department'] = $singledata->department;
                    $nestedData['designation'] = $singledata->designation;
                    $nestedData['current_att_date'] = $singledata->current_att_datett;
                    $nestedData['emp_id'] = $singledata->emp_id;

                   if($singledata->in_date_time == '' || $singledata->in_date_time == null){

                     $in_time = '';

                   }else{
                     $in_time = date('H:i:s', strtotime($singledata->in_date_time));
                     // echo $in_time;die;
                   }

                  if($singledata->out_date_time == '' || $singledata->out_date_time == null){

                     $out_time = '';

                   }else{
                     $out_time = date('H:i:s', strtotime($singledata->out_date_time));
                   }
                    
                    $nestedData['in_date_time'] = $in_time;
                    $nestedData['out_date_time'] = $out_time;

                    if($singledata->att_status == 0){

                        $p="No Status";
                        $q=0;
                    }else if($singledata->att_status == 1){

                         $p="IN";
                         $q=1;
                    }else{

                        $p="OUT";
                        $q=1;

                    }
                     $nestedData['att_status'] = $p;

                    if($singledata->att_status == 2){

                      $datein = $singledata->in_date_time;
                      $dateout =$singledata->out_date_time;
                      $dateintimestamp = strtotime($datein);
                      $dateouttimestamp = strtotime($dateout);
                      $diff = $dateouttimestamp - $dateintimestamp;
                      $diffhms= gmdate("H:i", $diff);
                      
                      }else{
                         $diffhms = '';
                      } 

                   $nestedData['working_time'] = $diffhms;

                    $edit_button = $delete_button =  $singledata->code;
                    $nestedData['action'] = array('e' => $edit_button, 'd' => $delete_button,'location_status' => $q);

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

    public function get_all_employee(Request $request){

          $statusCode = 200;
          if (!$request->ajax()) {

            $statusCode = 400;
            $response = array('error' => 'Error occered in Json call.');
            return response()->json($response, $statusCode);
          }
          try {

            $employees = tbl_employee_details::pluck('emp_name', 'code');

            $response = array(
              'options' => $employees, 'status' => 1
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

    public function get_att_lat_lang(Request $request){

          $code=$request->att_code;
        
         $result=tbl_attendance_entry::where('code',$code)->select('att_lat','att_long','att_lat_out','att_long_out')->first();
         
         $response = array(
                'result' => $result,   
            );


         return response()->json($response);



    }

    public function monthly_attendance_report(){

        return view('monthly_attendance_report');
    }

    public function get_designation_wise_employee(Request $request ){

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
       // dd($request->all());
        // echo $term;die;
        $personnelResult = [];

        $term = trim($request->q);
         $deg_code = $request->deg;
         // echo $term;die;
        if (empty($term)) {
          return \Response::json([]);
        }

          $searchPersonnel = tbl_employee_details::where('emp_name', 'like', '%' . $term . '%');

          if( $deg_code != ''){
           $searchPersonnel = $searchPersonnel->where('emp_designation',$deg_code);
          }

         $searchPersonnel = $searchPersonnel->select('emp_name', 'code');

        //  $searchPersonnel = tbl_employee_details::where('emp_designation',$deg_code)
        //  ->select('emp_name', 'code')
        //   ->where(function ($query) {
        //     $query->where('emp_name', 'like', '%' . $term . '%')
        //           ->orWhere('emp_id', 'like', '%' . $term . '%');
        // });

         

       

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

          // $statusCode = 200;
          // if (!$request->ajax()) {

          //   $statusCode = 400;
          //   $response = array('error' => 'Error occered in Json call.');
          //   return response()->json($response, $statusCode);
          // }
          // try {

          //   $designation_code=$request->deg;

          //   $emps = tbl_employee_details::where('emp_designation',$designation_code)->pluck('emp_name', 'code');

          //   $response = array(
          //     'options' => $emps, 'status' => 1
          //   );
          // }
          // catch (\Exception $e) {
          //   $response = array(
          //     'exception' => true,
          //     'exception_message' => $e->getMessage(),
          //   );
          //   $statusCode = 400;
          // } finally {
          //   return response()->json($response, $statusCode);
          // }

    }

    public function list_tbl_monthly_attendance_entry(Request $request){

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

                    $designation_code=$request->designation_code;
                    $employee_code=$request->employee_code;
                    $year=$request->year;
                    $month=$request->month;
                    $no_day=cal_days_in_month(CAL_GREGORIAN,$month,$year);
                   // echo $d;die;
                    $list=array();
                   
                    for($d=1; $d<=$no_day; $d++)
                    {
                        $time=mktime(12, 0, 0, $month, $d, $year);          
                        if (date('m', $time)==$month){    
                              $list_date_day['date'] = date('Y-m-d', $time);
                              $list_date_day['day'] = date('D', $time);
                          }

                          $list[] =$list_date_day;

                    }
                      $record = $list;

                    // echo "<pre>";
                    // print_r($record);
                    // echo "</pre>";die;


                  

                    // for ($i = 0; $i < count($order); $i ++) {
                    // $record = $record->orderBy($request->columns [$order [$i] ['column']] ['data'], strtoupper($order [$i] ['dir']));
                    //   }

                    $filtered_count = count($list);
                   // echo $filtered_count;die;

                  //  $page_displayed = $record->offset($offset)->limit($length)->get();

                   // $count = $offset + 1;
                    foreach ($record as $singledata) {
                       // $nestedData['id'] = $count;
                      // echo $singledata['date'] ; die;
                        $nestedData['date'] = date('d/m/Y', strtotime($singledata['date']));
                        $nestedData['day'] = $singledata['day'];

                       // $standerd_time=tbl_shift::where('code', $employee_code)->select('in_time','out_time')->first();

                        $result=tbl_attendance_entry::join('tbl_shift','tbl_shift.code','tbl_attendance_entry.shift_code')->where(DB::raw("DATE(tbl_attendance_entry.current_att_date)"), '=', $singledata['date'])->where('tbl_attendance_entry.emp_code', $employee_code)->select('tbl_attendance_entry.in_date_time','tbl_attendance_entry.out_date_time','tbl_attendance_entry.att_status','tbl_attendance_entry.current_att_date','tbl_shift.shift_in_time','tbl_shift.shift_out_time')->get();

                        if( $result->count()  > 0){

                            if($result[0]->att_status == 0){
                                 
                                 $nestedData['in_time'] = '';
                                 $nestedData['out_time'] = '';
                                 $nestedData['standerd_in_time'] = '';
                                 $nestedData['standerd_out_time'] = '';
                                  $nestedData['late_arrival'] = '';
                                 $nestedData['early_departure'] = '';
                               
                                 $nestedData['worked_time'] = '';

                                 $holiday =  tbl_of_holiday::where(DB::raw("DATE(holiday_date)"), '=', $singledata['date'])->select('description')->get();
                                 if($holiday->count() > 0){
                                    
                                     $nestedData['att_status'] =  $holiday[0]->description;
                                     $presentAbsent=1;

                                 }else{
                                     $nestedData['att_status'] = 'P';
                                     $presentAbsent=1;

                                 }


                            }else if($result[0]->att_status == 1){

                                $nestedData['in_time'] =  date('H:i:s', strtotime($result[0]->in_date_time));
                                $nestedData['out_time'] = '';

                                 $nestedData['standerd_in_time'] = $result[0]->shift_in_time;
                                 $nestedData['standerd_out_time'] = '';

                                  $emp_in_time = strtotime(date('H:i:s', strtotime($result[0]->in_date_time)));
                                  $shift_in_time = strtotime($result[0]->shift_in_time);

                                  if($emp_in_time >  $shift_in_time ){
                                   $diff_uu = $emp_in_time - $shift_in_time;
                                  $diffhms_late= gmdate("H:i", $diff_uu);

                                  }else{
                                     $diffhms_late="00:00";
                                   

                                  }
                                 
                                 $nestedData['late_arrival'] = $diffhms_late;
                                 $nestedData['early_departure'] = '';
                                 $nestedData['worked_time'] = '';

                                 $holiday =  tbl_of_holiday::where(DB::raw("DATE(holiday_date)"), '=', $singledata['date'])->select('description')->get();
                                 if($holiday->count() > 0){
                                    
                                     $nestedData['att_status'] =  $holiday[0]->description;
                                     $presentAbsent=1;

                                 }else{
                                     $nestedData['att_status'] = 'P';
                                     $presentAbsent=1;

                                 }
                            }

                            else if($result[0]->att_status == 2){
                                 $nestedData['in_time'] =  date('H:i:s', strtotime($result[0]->in_date_time));
                                 $nestedData['out_time'] =  date('H:i:s', strtotime($result[0]->out_date_time));

                                 $nestedData['standerd_in_time'] = $result[0]->shift_in_time;
                                 $nestedData['standerd_out_time'] = $result[0]->shift_out_time;


                                   $emp_in_time = strtotime(date('H:i:s', strtotime($result[0]->in_date_time)));
                                  $shift_in_time = strtotime($result[0]->shift_in_time);

                                  $emp_out_time = strtotime(date('H:i:s', strtotime($result[0]->out_date_time)));
                                  $shift_out_time = strtotime($result[0]->shift_out_time);

                                  if($emp_in_time >  $shift_in_time ){
                                   $diff_uu = $emp_in_time - $shift_in_time;
                                  $diffhms_late= gmdate("H:i", $diff_uu);

                                  }else{
                                     $diffhms_late="00:00";
                                   

                                  }

                                  if($emp_out_time <  $shift_out_time ){
                                   $diff_uuu = $shift_out_time - $emp_out_time;
                                  $diffhms_early= gmdate("H:i", $diff_uuu);

                                  }else{
                                     $diffhms_early="00:00";
                                   

                                  }
                                 


                                 $nestedData['late_arrival'] = $diffhms_late;
                                 $nestedData['early_departure'] = $diffhms_early;

                                 $holiday =  tbl_of_holiday::where(DB::raw("DATE(holiday_date)"), '=', $singledata['date'])->select('description')->get();
                                 if($holiday->count() > 0){

                                    
                                     $nestedData['att_status'] =  $holiday[0]->description;
                                     $presentAbsent=1;

                                 }else{
                                     $nestedData['att_status'] = 'P';
                                     $presentAbsent=1;

                                 }

                                  $dateintimestamp = strtotime($result[0]->in_date_time);
                                  $dateouttimestamp = strtotime($result[0]->out_date_time);
                                  $diff = $dateouttimestamp - $dateintimestamp;
                                  $diffhms= gmdate("H:i", $diff);
                                  $nestedData['worked_time'] = $diffhms;
                            }


                        }else{

                                 $nestedData['in_time'] = '';
                                 $nestedData['out_time'] = '';
                                 $nestedData['standerd_in_time'] = '';
                                 $nestedData['standerd_out_time'] = '';
                                 $nestedData['late_arrival'] = '';
                                 $nestedData['early_departure'] ='';

                              $nestedData['worked_time'] = '';

                               $holiday =  tbl_of_holiday::where(DB::raw("DATE(holiday_date)"), '=', $singledata['date'])->select('description')->get();
                                 if($holiday->count() > 0){
                                    
                                     $nestedData['att_status'] =  $holiday[0]->description;
                                     $presentAbsent=1;


                                 }else{
                                   if( $singledata['date'] <= date('Y-m-d') ) {

                                    $leavee=tbl_employee_leave_taken::join('tbl_type_of_leave','tbl_type_of_leave.code','tbl_employee_leave_taken.type_of_leave_code')->where('tbl_employee_leave_taken.emp_code',$employee_code)->where(DB::raw("DATE(tbl_employee_leave_taken.leave_date)"), '=', $singledata['date'])->select('tbl_type_of_leave.type_of_leave')->get();
                                    if($leavee->count() > 0){

                                          $nestedData['att_status'] = $leavee[0]->type_of_leave;
                                          $presentAbsent=0;

                                    }else{

                                         $nestedData['att_status'] = 'A';
                                         $presentAbsent=0;

                                    }

                                    

                                   }else{
                                     $presentAbsent=1;
                                     $nestedData['att_status'] = 'No Status';

                                   }
                                    

                                 }

                        }

                        $nestedData['action'] = array('presentAbsent' => $presentAbsent,'e' => $employee_code, 'd' => $designation_code,'leave_date'=>$singledata['date']);


                       // $count++;
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

    public function get_all_leave_details(Request $request){


          $statusCode = 200;
          if (!$request->ajax()) {

            $statusCode = 400;
            $response = array('error' => 'Error occered in Json call.');
            return response()->json($response, $statusCode);
          }
          try {

            $leavearray=array();

              $leave_date=date_create($request->leave_date);
             $converted_leave_date =  date_format($leave_date,"d/m/Y");

            $employee_details = tbl_employee_details::join('tbl_designation','tbl_designation.code','tbl_employee_details.emp_designation')->join('tbl_department','tbl_department.code','tbl_employee_details.emp_deparment')->where('tbl_employee_details.code',$request->emp_code)->select('tbl_employee_details.emp_name','tbl_department.department','tbl_designation.designation','tbl_employee_details.emp_id')->first();

            $deg_code =tbl_employee_details::where('code',$request->emp_code)->select('emp_designation')->first();

           // echo $deg_code->emp_designation;die;

            $result = tbl_designation_wise_leave_assign::join('tbl_type_of_leave','tbl_type_of_leave.code','tbl_designation_wise_leave_assign.type_of_leave_code')->where('tbl_designation_wise_leave_assign.designation_code',$deg_code->emp_designation)->select('tbl_type_of_leave.type_of_leave','tbl_designation_wise_leave_assign.no_of_leave','tbl_designation_wise_leave_assign.type_of_leave_code')->get();

            foreach ($result as $key => $value) {
               
              $total_leave =  $value->no_of_leave;
              $totalleavetaken = tbl_employee_leave_taken::where('emp_code' , $request->emp_code)->where('type_of_leave_code',$value->type_of_leave_code)->where('year',date('Y'))->count();
              $leaveavl= $total_leave - $totalleavetaken;

              $result[$key]['leave_available'] =$leaveavl;

             // array_push($leavearray, $leaveavl);


            }

            // echo "<pre>";
            // print_r($result);
            // echo "</pre>";die;

            $all_leave = tbl_designation_wise_leave_assign::join('tbl_type_of_leave','tbl_type_of_leave.code','tbl_designation_wise_leave_assign.type_of_leave_code')->where('tbl_designation_wise_leave_assign.designation_code',$deg_code->emp_designation)->pluck('tbl_type_of_leave.type_of_leave','tbl_type_of_leave.code');

            $response=array('total_leave'=>$result,'all_leave'=>$all_leave,'leave_available'=>$leavearray,'employee_details'=>$employee_details,'converted_leave_date'=>$converted_leave_date);
           
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

    public function save_leave_employee(Request $request){

          $statusCode = 200;
          if (!$request->ajax()) {

            $statusCode = 400;
            $response = array('error' => 'Error occered in Json call.');
            return response()->json($response, $statusCode);
          }
          try {

            $result=tbl_employee_leave_taken::where(DB::raw("DATE(leave_date)"), '=', $request->leave_date)->where('emp_code',$request->emp_code)->count();
            if( $result > 0){

                $dltData=tbl_employee_leave_taken::where(DB::raw("DATE(leave_date)"), '=', $request->leave_date)->where('emp_code',$request->emp_code)->delete();

            }

           

            $emp_code =$request->emp_code;
            $des_code =$request->des_code;
            $leave_date =$request->leave_date;
            $leave_code =$request->leave_code;
            //strtotime(date('H:i:s', strtotime($result[0]->in_date_time)));
             $year = strtotime($leave_date);

             $yeardd=date("Y",$year);


           $leave=new tbl_employee_leave_taken();
           $leave->emp_code =  $emp_code;
           $leave->leave_date =  $leave_date;
           $leave->type_of_leave_code =  $leave_code;
           $leave->year =  $yeardd;

           if($leave->save()){

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

    public function countAbsentPresentHolidayLeave(Request $request)
    {
         $statusCode = 200;
                    if (!$request->ajax()) {
                        $statusCode = 400;
                        $response = array('error' => 'Error occured in form submit.');
                        return response()->json($response, $statusCode);
                    }
                   
                    try{
                   
                    $data = array();

                    $totpresent = 0;
                    $totabsent = 0;
                    $totholiday = 0;
                    $totleave = 0;

                    $designation_code=$request->designation_code;
                    $employee_code=$request->employee_code;
                    $year=$request->year;
                    $month=$request->month;
                    $no_day=cal_days_in_month(CAL_GREGORIAN,$month,$year);
                   // echo $d;die;
                    $list=array();
                   
                    for($d=1; $d<=$no_day; $d++)
                    {
                        $time=mktime(12, 0, 0, $month, $d, $year);          
                        if (date('m', $time)==$month){    
                              $list_date_day['date'] = date('Y-m-d', $time);
                              $list_date_day['day'] = date('D', $time);
                          }

                          $list[] =$list_date_day;

                    }
                      $record = $list;

                  

                    $filtered_count = count($list);
                  
                    foreach ($record as $singledata) {
                    
                      
                     

                        $result=tbl_attendance_entry::join('tbl_shift','tbl_shift.code','tbl_attendance_entry.shift_code')->where(DB::raw("DATE(tbl_attendance_entry.current_att_date)"), '=', $singledata['date'])->where('tbl_attendance_entry.emp_code', $employee_code)->select('tbl_attendance_entry.in_date_time','tbl_attendance_entry.out_date_time','tbl_attendance_entry.att_status','tbl_attendance_entry.current_att_date','tbl_shift.shift_in_time','tbl_shift.shift_out_time')->get();

                        if( $result->count()  > 0){

                            if($result[0]->att_status == 0){
                                 
                             

                                 $holiday =  tbl_of_holiday::where(DB::raw("DATE(holiday_date)"), '=', $singledata['date'])->select('description')->get();
                                 if($holiday->count() > 0){
                                    
                                     $nestedData['att_status'] =  $holiday[0]->description;
                                     $presentAbsent=1;
                                     $totholiday = $totholiday + 1;


                                 }else{
                                     $nestedData['att_status'] = 'P';
                                     $presentAbsent=1;
                                      $totpresent= $totpresent+1;



                                 }


                            }else if($result[0]->att_status == 1){

                           

                                 $holiday =  tbl_of_holiday::where(DB::raw("DATE(holiday_date)"), '=', $singledata['date'])->select('description')->get();
                                 if($holiday->count() > 0){
                                    
                                  
                                      $totholiday =  $totholiday + 1;

                                 }else{
                                    
                                      $totpresent =  $totpresent + 1;

                                 }
                            }

                            else if($result[0]->att_status == 2){
                                

                                 


                                 $holiday =  tbl_of_holiday::where(DB::raw("DATE(holiday_date)"), '=', $singledata['date'])->select('description')->get();
                                 if($holiday->count() > 0){

                                      $totholiday =  $totholiday + 1;

                                 }else{
                                   
                                     $totpresent =  $totpresent + 1;


                                 }

                                 
                            }


                        }else{

                               
                               $holiday =  tbl_of_holiday::where(DB::raw("DATE(holiday_date)"), '=', $singledata['date'])->select('description')->get();
                                 if($holiday->count() > 0){
                                    
                                   
                                      $totholiday = $totholiday + 1;


                                 }else{
                                   if( $singledata['date'] <= date('Y-m-d') ) {

                                    $leavee=tbl_employee_leave_taken::join('tbl_type_of_leave','tbl_type_of_leave.code','tbl_employee_leave_taken.type_of_leave_code')->where('tbl_employee_leave_taken.emp_code',$employee_code)->where(DB::raw("DATE(tbl_employee_leave_taken.leave_date)"), '=', $singledata['date'])->select('tbl_type_of_leave.type_of_leave')->get();
                                    if($leavee->count() > 0){

                                         
                                           $totleave =  $totleave + 1;

                                    }else{

                                       
                                         $totabsent =  $totabsent + 1;

                                    }

                                   }else{
                                     $presentAbsent=1;
                                   
                                   }  

                                 }
                        }
                    }
                    $response = array(
                       
                       // 'record_details' => $data,
                        'totabsent' => $totabsent,
                        'totleave' => $totleave,
                        'totpresent' => $totpresent,
                        'totholiday' => $totholiday,
                         'totworking_day' => $no_day,
                       

                        
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
    
}
