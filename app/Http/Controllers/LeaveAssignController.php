<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\tbl_years;
use App\tbl_type_of_leave;
use App\tbl_designation;
use App\tbl_designation_wise_leave_assign;

class LeaveAssignController extends Controller
{
    public function leave_assign(){

        $all_leave_type=tbl_type_of_leave::select('code','type_of_leave')->get();

      return view('leave_assign')->with('all_leave',$all_leave_type);
    }

    public function leave_assign_details(){

      return view('leave_assign_details');
    }

    public function get_all_year(Request $request){

          $statusCode = 200;
          if (!$request->ajax()) {

            $statusCode = 400;
            $response = array('error' => 'Error occered in Json call.');
            return response()->json($response, $statusCode);
          }
          try {

            $employees = tbl_years::pluck('year', 'code');

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

    public function get_all_designation(Request $request)
    {
      // echo "hi";
      $statusCode = 200;
      if (!$request->ajax()) {

        $statusCode = 400;
        $response = array('error' => 'Error occered in Json call.');
        return response()->json($response, $statusCode);
      }
      try{
        $designation = tbl_designation::pluck('designation', 'code');
          // dd($designation);
      // print_r($designation);
      // die;
        $response = array(
          'options' => $designation,
          'status' => 1
        );
      } catch(\Exception $e) {
        $response = array(
          'exception' => true,
          'exception_message' => $e->getMessage(),
        );
        $statusCode = 400;
      } finally {
        return response()->json($response, $statusCode);
      }
    
    }
    public function leave_assign_save_update(Request $request)
    {
  
      // dd($request->all());
      $statusCode = 200;
      if (!$request->ajax()) {

        $statusCode = 400;
        $response = array('error' => 'Error occered in Json call.');
        return response()->json($response, $statusCode);
      }
      try {
        $leave_assign = explode(",", $request->no_of_leave);
  //       //  dd($leave_assign);
        $total_leave = count($leave_assign);
  //       // dd($total_leave);
  //       // echo $total_leave;die;
        for($i = 0; $i<$total_leave; $i++){
          $leave = new tbl_designation_wise_leave_assign();
          $explode_leave = explode(":", $leave_assign[$i]);
  //       //   // dd($explode_leave);
          if($explode_leave[1] != "" && $explode_leave[1] != 0){
            $leave->designation_code = $request->designation_name;
            $leave->year = $request->year_cd;
            $leave->type_of_leave_code=$explode_leave[0]; 
            
            $leave->no_of_leave=$explode_leave[1]; 
         
            if($leave->save()){
              $response = array(
                'status' => 1
              );
            }
          }
        }
      } catch (\Exception $e) {
        $response = array(
          'exception' => true,
          'exception' => $e->getMessage(),
        );
        $statusCode = 400;
      } finally {
        return response()->json($response, $statusCode);
      }
  }

  public function list_of_leave_assign(Request $request)
  {
  //   // echo "hi";
    $statusCode = 200;
    if (!$request->ajax()) {

      $statusCode = 400;
      $response = array('error' => 'Error occered in Json call.');
      return response()->json($response, $statusCode);
    }
    try {
  //     // $response = "hi";
      $draw = $request->draw;
  //     // echo $draw;die;
      $length = $request->length;
  //     // echo $length;die;
      $offset = $request->start;
  //     // echo $offset;die;
      $search = $request->search ["value"];
      $order = $request->order;
      $data = array();

     $allleaveassign = tbl_designation_wise_leave_assign::join('tbl_designation', 'tbl_designation.code', '=', 'tbl_designation_wise_leave_assign.designation_code')
    ->select('tbl_designation.designation', 'tbl_designation_wise_leave_assign.code', 'tbl_designation_wise_leave_assign.year', 'tbl_designation_wise_leave_assign.designation_code')
     ->groupby('tbl_designation_wise_leave_assign.designation_code')
     ->where(function($q) use ($search) {
      $q->orwhere('tbl_designation.designation', 'like', '%', $search, '%');
     });
    // dd($allleaveassign);
  //     // dd($allleaveassign);
      $record =  $allleaveassign;
     $filtered_count = $allleaveassign->count();
  //   //  echo $filtered_count;die;
    $page_displayed = $record->offset($offset)->limit($length)->get();
  //   // dd($page_displayed);
    $count = $offset + 1;
    foreach ($page_displayed as $singledata) {
     $nestedData['id'] = $count;
     $nestedData['designation'] = $singledata->designation;
     $nestedData['year'] = $singledata->year;
     $view_button = $singledata->designation_code;
    $nestedData['action'] = array('v' => $view_button);
  
     $count++;
     $data[] = $nestedData;


    } 
  //   // print_r($arrStr);die;
    $response = array(
      "draw" => $draw,
      "recordsTotal" => $filtered_count,
      "recordsFiltered" => $filtered_count,
      'record_details' => $data
  );
    } catch (\Exception $e) {
      $response = array(
        'exception' => true,
        'exception_message' => $e->getMessage()
      );
      $statusCode = 400;
    } finally {
      return response()->json($response, $statusCode);
    }
  }

  public function get_designation_wise_leave(Request $request)
  {
    // echo "hi";
    $statusCode = 200;
    if (!$request->ajax()) {

      $statusCode = 400;
      $response = array('error' => 'Error occered in Json call.');
      return response()->json($response, $statusCode);
    }
    try {
      $all_designation_wise_leave = tbl_designation_wise_leave_assign::join('tbl_type_of_leave', 'tbl_type_of_leave.code', '=', 'tbl_designation_wise_leave_assign.type_of_leave_code')->where('tbl_designation_wise_leave_assign.designation_code', '=', $request->leave_assign_cd)->select('type_of_leave', 'no_of_leave')->get();
      // dd($all_designation_wise_leave);
      $response = array(
        'options' => $all_designation_wise_leave,
        'status' => 1
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
 
}
