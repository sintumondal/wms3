<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\tbl_attendance_entry;
use App\tbl_employee_details;
use App\tbl_allowance;
use App\tbl_designation_wise_allowance;
use App\tbl_employee_allowance_entry;
use App\tbl_of_holiday;
use App\tbl_employee_leave_taken;
use App\tbl_month_year_designation_salary_generation;
use App\tbl_employee_salary_generation;
use App\Exports\SalaryDetailsExport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use DB;

class SalaryReportController extends Controller
{
    public function salary_sheet(){

        return view('salary_report');
    }

    public function designation_wise_salary(Request $request){

         $statusCode = 200;
          if (!$request->ajax()) {

            $statusCode = 400;
            $response = array('error' => 'Error occered in Json call.');
            return response()->json($response, $statusCode);
          }
          try {

           

            //  dd($request->all());

            $year=$request->year;
            $month=$request->month;
            $designation=$request->designation;

            $month_year=$year."-".$month;

            $no_day=cal_days_in_month(CAL_GREGORIAN,$month,$year);

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


          //  echo $month_year;die;

          //  $result=tbl_attendance_entry::where('current_att_date', 'like',$month_year . '%')->get();

          // echo $result->count();die;

            $data=array();

             $all_present_absent_holiday_leave=array();

            $result=tbl_employee_details::where('emp_designation',$designation)->get();

            foreach ($result as $key => $value) {

                        $totpresent = 0;
                        $totabsent = 0;
                        $totholiday = 0;
                        $totleave = 0;


                     foreach ($record as $singledata) {
                    
                      
                     

                        $result1=tbl_attendance_entry::join('tbl_shift','tbl_shift.code','tbl_attendance_entry.shift_code')->where(DB::raw("DATE(tbl_attendance_entry.current_att_date)"), '=', $singledata['date'])->where('tbl_attendance_entry.emp_code', $value->code)->select('tbl_attendance_entry.in_date_time','tbl_attendance_entry.out_date_time','tbl_attendance_entry.att_status','tbl_attendance_entry.current_att_date','tbl_shift.shift_in_time','tbl_shift.shift_out_time')->get();

                        if( $result1->count()  > 0){

                            if($result1[0]->att_status == 0){
                                 
                             

                                 $holiday =  tbl_of_holiday::where(DB::raw("DATE(holiday_date)"), '=', $singledata['date'])->select('description')->get();
                                 if($holiday->count() > 0){
                                    
                                    // $nestedData['att_status'] =  $holiday[0]->description;
                                     $presentAbsent=1;
                                     $totholiday = $totholiday + 1;


                                 }else{
                                   //  $nestedData['att_status'] = 'P';
                                     $presentAbsent=1;
                                      $totpresent= $totpresent+1;



                                 }


                            }else if($result1[0]->att_status == 1){

                           

                                 $holiday =  tbl_of_holiday::where(DB::raw("DATE(holiday_date)"), '=', $singledata['date'])->select('description')->get();
                                 if($holiday->count() > 0){
                                    
                                  
                                      $totholiday =  $totholiday + 1;

                                 }else{
                                    
                                      $totpresent =  $totpresent + 1;

                                 }
                            }

                            else if($result1[0]->att_status == 2){
                                

                                 


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

                                    $leavee=tbl_employee_leave_taken::join('tbl_type_of_leave','tbl_type_of_leave.code','tbl_employee_leave_taken.type_of_leave_code')->where('tbl_employee_leave_taken.emp_code', $value->code)->where(DB::raw("DATE(tbl_employee_leave_taken.leave_date)"), '=', $singledata['date'])->select('tbl_type_of_leave.type_of_leave')->get();
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


                        $prnt_abs_holi_leave['present_day']=$totpresent;
                        $prnt_abs_holi_leave['absent_day']=$totabsent;
                        $prnt_abs_holi_leave['holi_day']=$totholiday;
                        $prnt_abs_holi_leave['leave_day']=$totleave;
                         $prnt_abs_holi_leave['working_day']=$no_day;


                         
                         unset($all_present_absent_holiday_leave);
                         $all_present_absent_holiday_leave=array();

                        $all_present_absent_holiday_leave[] =  $prnt_abs_holi_leave;


                /////////////////////////////////////////


                  $nestedData['emp_id'] =  $value->emp_id;
                  $nestedData['emp_name'] =  $value->emp_name;
                   $nestedData['all_present_absent_holiday_leave_day'] =  $all_present_absent_holiday_leave;

                  $all_allowance=tbl_designation_wise_allowance::join('tbl_allowance','tbl_allowance.code','tbl_designation_wise_allowance.allowance_code')->where('designation_code',$value->emp_designation)->select('tbl_allowance.name_of_allowance','tbl_allowance.code','tbl_allowance.allowance_type')->get();

                   $total_allowance=$all_allowance->count();
                   
                   $allow_addition=array();
                   $allow_deduction=array();
                   $amt_addition = array();
                   $amt_deduction = array();
                   $allow_type=array();
                   
                   $gross=0;
                   $net=0;

                  foreach ($all_allowance as $key1 => $value1){




                    $cal_allowance=tbl_employee_allowance_entry::where('emp_code',$value->code)->where('allowance_code',$value1->code)->first();
                    //print_r( $cal_allowance);die;

                    if($cal_allowance->salary_type == 1){

                        if($cal_allowance->fixed_persentage == 1){

                            $amount=$cal_allowance->amount;
                        }else if($cal_allowance->fixed_persentage == 2){

                            $persentage=tbl_employee_allowance_entry::where('allowance_code',$cal_allowance->on_allowance_code)->where('emp_code',$value->code)->select('amount')->first();

                            $amount=($cal_allowance->amount * $persentage->amount)/100;

                        }else{
                            
                            $amount=$cal_allowance->amount;

                        }

                    }else if($cal_allowance->salary_type == 2){

                         if($cal_allowance->fixed_persentage == 1){

                            $amount=30 * $cal_allowance->amount;
                        }else if($cal_allowance->fixed_persentage == 2){

                            $persentage=tbl_employee_allowance_entry::where('allowance_code',$cal_allowance->on_allowance_code)->where('emp_code',$value->code)->select('amount')->first();

                            $amount= (30 * $cal_allowance->amount * $persentage->amount)/100;

                        }else{
                            
                            $amount=30 * $cal_allowance->amount;

                        }


                    }

                    if($value1->allowance_type == 1){

                      //  echo "hh"; die;

                         $allow_arr_addition['name_allowance']= $value1->name_of_allowance;
                         $allow_arr_addition['type_allowance']= $value1->allowance_type;
                         $allow_addition[]= $allow_arr_addition;

                         $amt_arr_addition['amount']= $amount;
                         $amt_arr_addition['type_amt_allowance']= $value1->allowance_type;
                         $amt_addition[]= $amt_arr_addition;

                         $gross=$gross+$amount;


                    }else{


                         $allow_arr_deduction['name_allowance']= $value1->name_of_allowance;
                         $allow_arr_deduction['type_allowance']= $value1->allowance_type;
                         $allow_deduction[]= $allow_arr_deduction;

                         $amt_arr_deduction['amount']= $amount;
                         $amt_arr_deduction['type_amt_allowance']= $value1->allowance_type;
                         $amt_deduction[]= $amt_arr_deduction;

                         $net = $net + $amount;


                    }

                     // array_push($allow,$value1->name_of_allowance);
                     // array_push($amt,$amount);
                      array_push($allow_type, $value1->allowance_type);

                      

                  }

                     $nestedData['allowance_addition'] =  $allow_addition;
                     $nestedData['allowance_deduction'] =  $allow_deduction;
                     $nestedData['amount_addition'] =  $amt_addition;
                     $nestedData['amount_deduction'] =  $amt_deduction;
                      //$nestedData['amount'] =   $amt;
                      $nestedData['total_allowance'] = $total_allowance;
                      $nestedData['allowance_type'] = $allow_type;
                      $nestedData['gross'] =  $gross;

                      $nestedData['total_deduction'] =  $net;
                      $nestedData['net'] =  $gross - $net;

                  $noDaysWork=tbl_attendance_entry::where('emp_code',$value->code)->where('current_att_date', 'like',$month_year . '%')->count();
                    $nestedData['noDaysWork'] =  $noDaysWork;

                   $data[] = $nestedData;
              
            }

            $response=array('record' => $data);


            
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

    public function save_salary_generate(Request $request){

          $statusCode = 200;
        if (!$request->ajax()) {
            $statusCode = 400;
            $response = array('error' => 'Error occured in form submit.');
            return response()->json($response, $statusCode);
        }

 
        try{


            $designation = $request->designation;
            $year = $request->year;
            //echo $year;die;
            $month = $request->month;
            $header = $request->header;
            $data = $request->data;

            $string_version_header = implode(',', $header);
            $string_version_data = implode("&",array_map(function($a) {return implode("~",$a);},$data));


           // echo $string_version_data;die;

             $tbl_month_year_designation_salary_generation = new tbl_month_year_designation_salary_generation();

               $tbl_month_year_designation_salary_generation->year = $year;
               $tbl_month_year_designation_salary_generation->month = $month;
               $tbl_month_year_designation_salary_generation->designation_code = $designation;

               if($tbl_month_year_designation_salary_generation->save()){
                     
                $employee_salary_generation = new tbl_employee_salary_generation(); 

                $employee_salary_generation->year_month_designation_code = $tbl_month_year_designation_salary_generation->code;
                 $employee_salary_generation->table_head = $string_version_header;
                  $employee_salary_generation->table_data = $string_version_data;


                  if( $employee_salary_generation->save()){

                     $response =array('status' =>1);
                  }else{
                    $response =array('status' =>0);
                  }

               


               }


           // print_r($data);die;
           
            
        }  catch(\Exception $e){
            $response = array(
                'exception' => true,
                'exception_message' => $e->getMessage(),
            );
            $statuscode=400;
         } finally{
           return response()->json($response, $statusCode);
        }

    }

    public function salary_generated_list(){

        return view('salary_generated_details');

    }

    public function list_salary_generated_details(Request $request){

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

            $allgeneratedsalary =  tbl_month_year_designation_salary_generation::join('tbl_designation','tbl_designation.code','tbl_month_year_designation_salary_generation.designation_code')->select('tbl_month_year_designation_salary_generation.code','tbl_month_year_designation_salary_generation.year','tbl_month_year_designation_salary_generation.month','tbl_designation.designation')
                    ->where(function($q) use ($search) {
                $q->orwhere('tbl_designation.designation', 'like', '%' . $search . '%');
                
            });



            $record = $allgeneratedsalary;

            for ($i = 0; $i < count($order); $i ++) {
            $record = $record->orderBy($request->columns [$order [$i] ['column']] ['data'], strtoupper($order [$i] ['dir']));
              }

            $filtered_count = $allgeneratedsalary->count();
            $page_displayed = $record->offset($offset)->limit($length)->get();

            $count = $offset + 1;
            foreach ($page_displayed as $singledata) {
                $nestedData['id'] = $count;
                $nestedData['year'] = $singledata->year;
                $nestedData['month'] = $singledata->month;
                $nestedData['designation'] = $singledata->designation;

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

    public function regenerate_salary_details(Request $request){

           $this->validate($request, [
            'regenerate_salary_code' => 'required|integer',
                ], [        
            'regenerate_salary_code.required' => 'Regenerate Salary Code is required',
            'regenerate_salary_code.integer' => 'Regenerate Salary Code Accepted Only Integer',
           ]); 

        
        try{
        $regenerate_salary_code = $request->regenerate_salary_code;

      //  echo  $regenerate_salary_code ;die;

        
          $edit_data=tbl_month_year_designation_salary_generation::where('code','=',$regenerate_salary_code)->first();  

          $encode_edit_data=json_encode($edit_data);

         // dd($encode_edit_data);
       
       
       } catch (\Exception $e) {
            $response = array(
                'exception' => true,
                'exception_message' => $e->getMessage(),
            );
            $statusCode = 400;
        } finally {
           return  view('salary_report')->with('regenerate_salary_data',$encode_edit_data);
        } 


    }

    public function salary_generate_excel_report(Request $request){

        $salary_generate_excel_code=$request->salary_generate_excel_code;
  
        
        return Excel::download(new SalaryDetailsExport($salary_generate_excel_code), 'SalaryDetailsExport.xlsx');
    }

    public function salary_generate_pdf_report(Request $request){

         $salary_data_array=array();
         $salary_data_array1=array();
         $table_head_array = array();
         $table_head_array1 = array();

        $salary_data = tbl_employee_salary_generation::where('year_month_designation_code',$request->salary_generate_pdf_code)->select('table_data')->first();

        $salary_head = tbl_employee_salary_generation::where('year_month_designation_code',$request->salary_generate_pdf_code)->select('table_head')->first();

        $first_export_data =explode("&", $salary_data->table_data);

        foreach ($first_export_data as $key => $value) {

            unset($salary_data_array);
            $salary_data_array = array();

             $second_export_data =explode("~", $value);

              foreach ($second_export_data as $key => $value1) {
                   array_push($salary_data_array, $value1);
              }

               array_push($salary_data_array1, $salary_data_array);  
        }


            array_push($table_head_array1, ['','','','','','','','ADDITION','','','DEDUCTION','','','']);

            

             $export_head =explode(",", $salary_head->table_head);

            foreach ( $export_head as $key => $value) {

               array_push($table_head_array, $value);  
               
            }
             array_push($table_head_array1, $table_head_array);

             $final_salary_array = array('table_data' => $salary_data_array1,'table_head'=>$table_head_array1);

            $pdf = PDF::loadView('salary_report_pdf', $final_salary_array)->setPaper('A4', 'landscape');
            return $pdf->download('SalaryReport.pdf');

    }

    public function pay_slip_generate(Request $request){

         $salary_data_array=array();
         $salary_data_array1=array();
         $table_head_array = array();
         $table_head_array1 = array();
         $alldata = [];
         $pay_slip_generate_code = $request->pay_slip_generate_code;


        $month_year_designation = tbl_month_year_designation_salary_generation::join('tbl_designation','tbl_designation.code','tbl_month_year_designation_salary_generation.designation_code')->select('tbl_month_year_designation_salary_generation.code','tbl_month_year_designation_salary_generation.year','tbl_month_year_designation_salary_generation.month','tbl_designation.designation')->first();

        $pay_slip_generate_data = tbl_employee_salary_generation::where('year_month_designation_code',$request->pay_slip_generate_code)->select('table_data')->first();

        $pay_slip_generate_head = tbl_employee_salary_generation::where('year_month_designation_code',$request->pay_slip_generate_code)->select('table_head')->first();


         $first_export_data =explode("&", $pay_slip_generate_data->table_data);

        foreach ($first_export_data as $key => $value) {

            unset($salary_data_array);
            $salary_data_array = array();

             $second_export_data =explode("~", $value);

              foreach ($second_export_data as $key => $value1) {
                   array_push($salary_data_array, $value1);
              }

               array_push($salary_data_array1, $salary_data_array);  
        }


           // array_push($table_head_array1, ['','','','','','','','ADDITION','','','DEDUCTION','','','']);

            

             $export_head =explode(",", $pay_slip_generate_head->table_head);

            foreach ( $export_head as $key => $value) {

               array_push($table_head_array, $value);  
               
            }
           //  array_push($table_head_array1, $table_head_array);
             
           $arr_count =  count($table_head_array);
          // $i=0;
             foreach ($salary_data_array1 as $key => $value) {

              foreach ($value as $key1 => $value1) {
                 
                 $nestedData[$table_head_array[$key1]] = $value1;
              }

              $alldata[]=$nestedData;
               
             }

            // print_r($alldata);die;

            $response = array('alldatasalaryslip' => $alldata,'month_year_designation' => $month_year_designation);
        
              $pdf = PDF::loadView('salary_slip_pdf', $response)->setPaper('a4', 'landscape');
              return $pdf->download('salary_slip_details.pdf');


    }


   
}
