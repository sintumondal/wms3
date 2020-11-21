<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\tbl_shift;
use App\tbl_employee_details;
use App\tbl_employee_wise_shift_allocation;

class EmployeeWiseShiftController extends Controller
{
   public function employee_wise_shift_allocation(Request $request)
   {
     $allEmployee = tbl_employee_details::get();
    //  dd($allEmployee);
    // $employee_wise_shift = tbl_employee_wise_shift_allocation::where('code', '=', $request->employee_cd)->first();
    // dd($employee_wise_shift);
  
      return view('employee_wise_shift_allocation')->with(
        'all_employee' , $allEmployee
        // 'all_employee_wise_shift' => $employee_wise_shift,
      );
   }

   public function get_employee_wise_shift(Request $request){

      $statusCode = 200;
      if (!$request->ajax()) {

        $statusCode = 400;
        $response = array('error' => 'Error occered in Json call.');
        return response()->json($response, $statusCode);
      }
      try {
        $employee = tbl_employee_details::where('code', '=', $request->employee_cd)->select('code', 'emp_id')->first();
        $shift = tbl_shift::pluck('shift', 'code');
        // dd($shift);
        $employee_wise_shift = tbl_employee_wise_shift_allocation::where('code', '=', $request->employee_cd)->select('shift_code')->first();
      //  dd($employee_wise_shift);
      $employee_shift_cnt = tbl_employee_wise_shift_allocation::where('code', '=', $request->employee_cd)->select('shift_code')->count();
      // dd($employee_wise_shift);
      // $shift = tbl_shift::join('tbl_employee_wise_shift_allocation', 'tbl_shift.code', '=', 'tbl_employee_wise_shift_allocation.shift_code')->where('shift_code', '=', $request->employee_cd)->select('tbl_employee_wise_shift_allocation.shift_code')->first();
      if($employee_shift_cnt > 0) {
        // echo "hi";
        $sh = $employee_wise_shift;
        // dd($sh);
        } else {
        $sh = "";
        }
        $response = array(
          'emp' => $employee,
          'employee_shift' => $sh,
          'options' => $shift, 
          'status' => 1
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
  public function list_of_employee_wise_shift(Request $request)
  {
    // echo "hi";
    $statusCode = 200;
    if (!$request->ajax()) {
        $statusCode = 400;
        $response = array('error' => 'Error occured in form submit.');
        return response()->json($response, $statusCode);
    }
    try {
      $draw = $request->draw;
      $offset = $request->start;
      $length = $request->length;
      $search = $request->search['value'];
      $order = $request->order;
      $data = [];
        $allemployee = tbl_employee_details::leftjoin('tbl_designation', 'tbl_designation.code', '=', 'tbl_employee_details.emp_designation')
      ->leftjoin('tbl_department', 'tbl_department.code', '=', 'tbl_employee_details.emp_deparment')
      ->select('tbl_employee_details.code', 'tbl_employee_details.emp_id', 'tbl_employee_details.emp_name', 'tbl_designation.designation', 'tbl_department.department')
      ->where(function($q) use ($search) {
        $q->orwhere('tbl_designation.designation', 'like', '%' . $search . '%');

      });
     if($request->designation_cd !=''){
        $allemployee = $allemployee->where('tbl_employee_details.emp_designation', '=', $request->designation_cd);
      }
      if($request->department_cd !=''){
        $allemployee = $allemployee->where('tbl_employee_details.emp_deparment', '=', $request->department_cd);
      } 
     $record =  $allemployee;
     $filtered_count = $allemployee->count();
     $page_displayed = $record->offset($offset)->limit($length)->get();
    $count = $offset + 1;
      foreach ($page_displayed as $singledata) {
        $nestedData['id'] = $count;
        $nestedData['emp_id'] = $singledata->emp_id;
        $nestedData['emp_name'] = $singledata->emp_name;
        $nestedData['designation'] = $singledata->designation;
        $nestedData['department'] = $singledata->department;
        $add_button = $singledata->code;
        $shif_details = tbl_employee_wise_shift_allocation::where('emp_code', '=', $singledata->code)->select('emp_code', 'shift_code')->count();
       
        $shift = tbl_shift::join('tbl_employee_wise_shift_allocation', 'tbl_shift.code', '=', 'tbl_employee_wise_shift_allocation.shift_code')->where('emp_code', '=', $singledata->code)->select('tbl_shift.shift')->first();
        if($shif_details > 0) {
          $nestedData['shift'] = $shift->shift;
        }
        else {
          $nestedData['shift'] = "";
        }
        $nestedData['action'] = array('a'=> $add_button);
        $count++;
        $data[] = $nestedData;
      }
      $response = array(
        "draw" => $draw,
        "recordsTotal" => $filtered_count,
        "recordsFiltered" => $filtered_count,
        'record_details' => $data
    );
    } catch (\Exception $e) {
      $response = [
        'exception' => true,
        'exception_message' => $e->getMessage()
      ];
      $statusCode = 400;
    } finally {
      return response()->json($response, $statusCode);
    }
  }

  public function employee_wise_shift_save_update(Request $request)
  {
  //  echo "hi";
  // dd($request->all());
  $statusCode = 200;
  if (!$request->ajax()) {
      $statusCode = 400;
      $response = array('error' => 'Error occured in form submit.');
      return response()->json($response, $statusCode);
  }
  try {
    $employee_wise_shift = new tbl_employee_wise_shift_allocation();
    $employee_wise_shift->emp_code = $request->emp_code;
    $employee_wise_shift->shift_code = $request->shift_cd;
    if($employee_wise_shift->save()){
      $response = array(
        'status' => 1
      );
    }
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


}
