<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\tbl_shift;

class ShiftController extends Controller
{
    public function shift_details()
    {
       return view('shift_details');
    }
    public function add_shift()
    {
       return view('shift_entry');
    }

    public function shift_save_update(Request $request)
    {
      //  echo "hi";
      // dd($request->all());
      $statusCode = 200;
      if (!$request->ajax()) {
          $statusCode = 400;
          $response = array('error' => 'Error occured in form submit.');
          return response()->json($response, $statusCode);
      }
      $this->validate($request,[
         'shift' => "required|unique:tbl_shift,shift|regex: /^[A-Za-z\s]+$/i",
         'shift_in_time' => "required",
         'shift_out_time' => "required"

     ],
     [
         'shift.required' => 'Shift is Required',
         'shift.regex' => 'Shift can consist of alphabetical characters and spaces only',
         'shift_in_time.required' => 'Shift In Time is Required',
         'shift_out_time.required' => 'Shift Out Time is Required',


     ]);
      try {
         //code...

         if(isset($request->editcd)){
            $shift_details = tbl_shift::find($request->editcd);
         } else {
            $shift_details = new tbl_shift();

         }
         $shift_details->shift = $request->shift;
         $shift_details->shift_in_time = $request->shift_in_time;
         $shift_details->shift_out_time = $request->shift_out_time;

         if($shift_details->save()){
           if(isset($request->editcd)){
              $response = array(
               'status' => 2

              );
            
           } else {
               $response = array(
                  'status' => 1
               );
           } 
           
   
         }
         else{
            $response = array(
               'status' => 3
            );
           }
      } catch (\Exception $e) {
         $response = [
            'exception' => true,
            'exception_message' => $e->getMessage(),
         ];
         $statusCode = 400;
      } finally {
         return response()->json($response , $statusCode);
      }
   }

   public function list_of_shift(Request $request)
   {
      $statusCode = 200;
      if (!$request->ajax()) {
          $statusCode = 400;
          $response = array('error' => 'Error occured in form submit.');
          return response()->json($response, $statusCode);
      }
      try {
         $draw = $request->draw;
      //   echo $draw; die;
         $offset = $request->start;
      //   echo $offset; die;
         $length = $request->length;
         // echo $length; die;
         $search = $request->search ["value"];
         $order = $request->order;
         $data = [];
      $allshift = tbl_shift::select('code', 'shift', 'shift_in_time', 'shift_out_time')
      ->where(function($q) use ($search){
         $q->orwhere('shift', 'like', '%', $search, '%');

      });
      $record = $allshift;
      $filtered_count = $allshift->count();
      // echo $filtered_count; die;
      //   dd($allshift);
      $page_displayed = $record->offset($offset)->limit($length)->get();
      // dd($page_displayed);
      $count = $offset + 1;
      foreach ($page_displayed as $singledata) {
         $nestedData['id'] = $count;
         $nestedData['shift'] = $singledata->shift;
         $nestedData['shift_in_time'] = $singledata->shift_in_time;
         $nestedData['shift_out_time'] = $singledata->shift_out_time;
         $edit_code = $delete_code = $singledata->code;
         // echo  $singledata->code; die;
         $nestedData['action'] = ['e' => $edit_code, 'd'=> $delete_code ];
         $count++;
         $data[] = $nestedData;

      }
      $response = [
         "draw" => $draw,
         "recordsTotal" => $filtered_count,
         "recordsFiltered" => $filtered_count,
         'record_details' => $data
      ];
      } catch (\Exception $e) {
         $response = [
            'exception' => true,
            'exception_message' => $e->getMessage(),
         ];
         $statusCode = 400;
      } finally {
         return response()->json($response, $statusCode);
      }
  
   }

   public function shift_edit(Request $request)
   {
      $this->validate($request, [
         'shift_cd' => 'required|integer',
             ], [        
         'shift_cd.required' => 'Shift Code is required',
         'shift_cd.integer' => 'Shift Code Accepted Only Integer',
     ]); 
    
      try {
         $shift = $request->shift_cd;
         if($shift!=0){
         $edit_data = tbl_shift::where('code', '=', $shift)->first();
         //  dd($edit_data);
         $edit_data_json = json_encode($edit_data);
         // dd($edit_data_json);
         } else{
            $edit_data = [];
         }

        
      } catch (\Exception $e) {
        $response = [
           'exception' => true,
           'exception_message' => $e->getMessage(),
        ];
        $statusCode = 400;
      } finally {
         return view('shift_entry')->with('shift_data', $edit_data_json);
      }
   }

   public function shift_delete(Request $request)
   {
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
         $dlt_data = tbl_shift::where('code', '=', $request->dlt_code); 
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
}
