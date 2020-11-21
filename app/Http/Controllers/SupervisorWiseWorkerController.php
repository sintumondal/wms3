<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\tbl_department;
use App\tbl_designation;
use App\tbl_employee_details;
use App\tbl_supervisor_wise_worker;
use DB;

class SupervisorWiseWorkerController extends Controller
{
    public function supervisor_wise_worker_details(){

        return view('supervisorwiseworker_details');
    }

    public function add_supervisor_wise_worker(){

        return view('supervisorwiseworker_entry');
    }

    public function get_all_supervisor(Request $request){

         $statusCode = 200;
          if (!$request->ajax()) {

            $statusCode = 400;
            $response = array('error' => 'Error occered in Json call.');
            return response()->json($response, $statusCode);
          }
          try {

            $tbl_employee_details = tbl_employee_details::where('emp_type',1)->pluck('emp_name', 'code');

            $response = array(
              'options' => $tbl_employee_details, 'status' => 1
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

    public function get_all_worker(Request $request){

         $statusCode = 200;
          if (!$request->ajax()) {

            $statusCode = 400;
            $response = array('error' => 'Error occered in Json call.');
            return response()->json($response, $statusCode);
          }
          try {

            $tbl_employee_details = tbl_employee_details::where('emp_type',2)->where('status',0)->pluck('emp_name', 'code');

            $response = array(
              'options' => $tbl_employee_details, 'status' => 1
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

    public function get_worker_name(Request $request){

         $statusCode = 200;
          if (!$request->ajax()) {

            $statusCode = 400;
            $response = array('error' => 'Error occered in Json call.');
            return response()->json($response, $statusCode);
          }
          try {

            $employee_name = tbl_employee_details::where('code',$request->worker)->select('emp_name')->first();

            $response = array(
              'options' => $employee_name, 'status' => 1
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

    public function save_supervisorwiseworker(Request $request){

         $statusCode = 200;
        if (!$request->ajax()) {
            $statusCode = 400;
            $response = array('errors' => 'Error occured in form submit.');
            return response()->json($response, $statusCode);
        }
        $response = [];
        $supervisor = $request->supervisor;
        $workerNameArrayJson = $request->workerNameArrayJson;
        
        $decodeWorkerName = json_decode($workerNameArrayJson);
      // print_r($decodeWorkerName) ;die;

        try{
            
            $countTotalArray = count($decodeWorkerName);

            $data = array();
            for ($i = 0; $i < $countTotalArray; $i++) {
            $myArraylength = array();

            $myArraylength['worker_code'] = $decodeWorkerName[$i];
            $myArraylength['supervisor_code'] = $supervisor;
           
            array_push($data, $myArraylength);
            }
            $insertData = tbl_supervisor_wise_worker::insert($data);

            $result=tbl_employee_details::wherein('code',$decodeWorkerName)->update(['status'=>1]);

            $response = array(
                'count'=>$countTotalArray,'msg'=>'Total '.$countTotalArray.' Record Saved Successfully', 'status' => 1 
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

       public function list_supervisorwiseworker(Request $request){


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

                    $allsupervisorwiseworker =  tbl_supervisor_wise_worker::join('tbl_employee_details','tbl_employee_details.code','tbl_supervisor_wise_worker.supervisor_code')->select('tbl_supervisor_wise_worker.supervisor_code','tbl_employee_details.emp_name',DB::raw("COUNT(tbl_supervisor_wise_worker.supervisor_code) as count_click"))
                    ->groupby('tbl_supervisor_wise_worker.supervisor_code')
                            ->where(function($q) use ($search) {
                        $q->orwhere('tbl_employee_details.emp_name', 'like', '%' . $search . '%');
                        
                    });



                    $record = $allsupervisorwiseworker;

                    for ($i = 0; $i < count($order); $i ++) {
                    $record = $record->orderBy($request->columns [$order [$i] ['column']] ['data'], strtoupper($order [$i] ['dir']));
                      }

                    $filtered_count = $allsupervisorwiseworker->count();
                    $page_displayed = $record->offset($offset)->limit($length)->get();

                      


                    $count = $offset + 1;
                    foreach ($page_displayed as $singledata) {
                        $nestedData['id'] = $count;
                        $nestedData['emp_name'] = $singledata->emp_name;
                         $nestedData['count_u'] = $singledata->count_click;

                        $edit_button = $delete_button =  $singledata->supervisor_code;
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

    public function get_supervisor_wise_worker(Request $request){

         $statusCode = 200;
          if (!$request->ajax()) {

            $statusCode = 400;
            $response = array('error' => 'Error occered in Json call.');
            return response()->json($response, $statusCode);
          }
          try {

            $supervisor_wise_worker = tbl_supervisor_wise_worker::join('tbl_employee_details','tbl_employee_details.code','tbl_supervisor_wise_worker.worker_code')->where('supervisor_code',$request->supervisor_code)->select('emp_name','phno')->get();

            $response = array(
              'options' => $supervisor_wise_worker, 'status' => 1
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

    public function supervisorwiseworker_delete(Request $request){

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
           
            $data = tbl_supervisor_wise_worker::where('supervisor_code', '=', $request->dlt_code)->select('worker_code')->get();
               
            $dlt_data = tbl_supervisor_wise_worker::where('supervisor_code', '=', $request->dlt_code); 
            if (!empty($dlt_data)) {//Should be changed #30
                 $result= tbl_employee_details::whereIn('code', $data)->update(['status'=>0]);
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

    public function supervisorwiseworker_edit(Request $request){

         $this->validate($request, [
            'supervisor_code' => 'required|integer',
                ], [        
            'supervisor_code.required' => 'Supervisor Code is required',
            'supervisor_code.integer' => 'Supervisor Code Accepted Only Integer',
        ]); 

        
        try{
        $supervisor_code = $request->supervisor_code;

        if($supervisor_code!=0){
          $edit_data=tbl_supervisor_wise_worker::join('tbl_employee_details','tbl_employee_details.code','tbl_supervisor_wise_worker.worker_code')->select('emp_name')->where('supervisor_code','=',$supervisor_code)->get();

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
           return  view('supervisorwiseworker_entry')->with('supervisorwiseworker_editdata',$edit_data);
        } 



    }


   
}
