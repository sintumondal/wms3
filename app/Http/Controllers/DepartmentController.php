<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\tbl_department;

class DepartmentController extends Controller
{
    public function department_details(){

        return view('department_details');
    }
    public function add_department(){

        return view('department_entry');
    }

    public function department_save_update(Request $request){
                 $statusCode = 200;
                if (!$request->ajax()) {
                    $statusCode = 400;
                    $response = array('error' => 'Error occured in form submit.');
                    return response()->json($response, $statusCode);
                }
                    $this->validate($request,[
                        'department_name'=>"required",
                           ],[
                        'department_name.required' => 'Department is Required',
                       ]);


                    try{
                           if(isset($request->editcd)){
                            $department=tbl_department::find($request->editcd);
                           }else{
                            $department=new tbl_department();
                           }

                           $department->department=$request->department_name;

                           if($department->save()){
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

    public function list_department(Request $request){
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

                    $alldepartment =  tbl_department::select('code','department')
                            ->where(function($q) use ($search) {
                        $q->orwhere('department', 'like', '%' . $search . '%');
                        
                    });



                    $record = $alldepartment;

                    for ($i = 0; $i < count($order); $i ++) {
                    $record = $record->orderBy($request->columns [$order [$i] ['column']] ['data'], strtoupper($order [$i] ['dir']));
                      }

                    $filtered_count = $alldepartment->count();
                    $page_displayed = $record->offset($offset)->limit($length)->get();

                      


                    $count = $offset + 1;
                    foreach ($page_displayed as $singledata) {
                        $nestedData['id'] = $count;
                        $nestedData['department'] = $singledata->department;

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

    public function department_edit(Request $request){

       $this->validate($request, [
            'department_code' => 'required|integer',
                ], [        
            'department_code.required' => 'Department Code is required',
            'department_code.integer' => 'Department Code Accepted Only Integer',
        ]); 

        
        try{
        $department_code = $request->department_code;

        if($department_code!=0){
          $edit_data=tbl_department::where('code','=',$department_code)->first();  
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
           return  view('department_entry')->with('department_data',$edit_data);
        } 

    }

    public function department_delete(Request $request){

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
            $dlt_data = tbl_department::where('code', '=', $request->dlt_code); 
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
