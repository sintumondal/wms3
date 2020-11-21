<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\tbl_designation;

class DesignationController extends Controller
{
    public function designation(){

        return view('designation_details');
    }
    public function add_designation(){

        return view('designation');
    }

    public function designation_save_update(Request $request){
                 $statusCode = 200;
                if (!$request->ajax()) {
                    $statusCode = 400;
                    $response = array('error' => 'Error occured in form submit.');
                    return response()->json($response, $statusCode);
                }
                    $this->validate($request,[
                        'designation_name'=>"required",
                           ],[
                        'designation_name.required' => 'Designation is Required',
                       ]);


                    try{
                           if(isset($request->editcd)){
                            $designation=tbl_designation::find($request->editcd);
                           }else{
                            $designation=new tbl_designation();
                           }

                           $designation->designation=$request->designation_name;

                           if($designation->save()){
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

    public function list_designation(Request $request){
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

                    $alldesignation =  tbl_designation::select('code','designation')
                            ->where(function($q) use ($search) {
                        $q->orwhere('designation', 'like', '%' . $search . '%');
                        
                    });



                    $record = $alldesignation;

                    for ($i = 0; $i < count($order); $i ++) {
                    $record = $record->orderBy($request->columns [$order [$i] ['column']] ['data'], strtoupper($order [$i] ['dir']));
                      }

                    $filtered_count = $alldesignation->count();
                    $page_displayed = $record->offset($offset)->limit($length)->get();

                      


                    $count = $offset + 1;
                    foreach ($page_displayed as $singledata) {
                        $nestedData['id'] = $count;
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

    public function designation_edit(Request $request){

       $this->validate($request, [
            'designation_code' => 'required|integer',
                ], [        
            'designation_code.required' => 'Designation Code is required',
            'designation_code.integer' => 'Designation Code Accepted Only Integer',
        ]); 

        
        try{
        $designation_code = $request->designation_code;

        if($designation_code!=0){
          $edit_data=tbl_designation::where('code','=',$designation_code)->first();  
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
           return  view('designation')->with('designation_data',$edit_data);
        } 

    }

    public function designation_delete(Request $request){

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
            $dlt_data = tbl_designation::where('code', '=', $request->dlt_code); 
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
