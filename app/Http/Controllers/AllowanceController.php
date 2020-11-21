<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\tbl_allowance;
use App\tbl_designation_wise_allowance;

class AllowanceController extends Controller  
{
    public function allowance_details(){

        return view('allowance_master_details');
    }

    public function add_allowance(){

        return view('allowance_master_entry');
    }

    public function allowance_save_update(Request $request){

         $statusCode = 200;
                if (!$request->ajax()) {
                    $statusCode = 400;
                    $response = array('error' => 'Error occured in form submit.');
                    return response()->json($response, $statusCode);
                }
                    $this->validate($request,[
                        'allowance_name'=>"required",
                         'allowance_type'=>"required",
                           ],[
                        'allowance_name.required' => 'Allowance is Required',
                         'allowance_type.required' => 'Allowance Type is Required',
                       ]);


                    try{
                           if(isset($request->editcd)){
                            $allowance=tbl_allowance::find($request->editcd);
                           }else{
                            $allowance=new tbl_allowance();
                           }

                           $allowance->name_of_allowance=$request->allowance_name;
                             $allowance->allowance_type=$request->allowance_type;

                           if($allowance->save()){
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

    public function list_allowance(Request $request){

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

                    $allallowance =  tbl_allowance::select('code','name_of_allowance','allowance_type')
                            ->orderby('allowance_type')
                            ->where(function($q) use ($search) {
                        $q->orwhere('name_of_allowance', 'like', '%' . $search . '%');
                        
                    });

                    $record = $allallowance;

                    for ($i = 0; $i < count($order); $i ++) {
                    $record = $record->orderBy($request->columns [$order [$i] ['column']] ['data'], strtoupper($order [$i] ['dir']));
                      }

                    $filtered_count = $allallowance->count();
                    $page_displayed = $record->offset($offset)->limit($length)->get();

                    $count = $offset + 1;
                    foreach ($page_displayed as $singledata) {
                        $nestedData['id'] = $count;
                        $nestedData['name_of_allowance'] = $singledata->name_of_allowance;

                        $type_all=$singledata->allowance_type;

                        if($type_all == 1){
                            $p='ADDITION';
                        }else{
                            $p='DEDUCTION';
                        }

                         $nestedData['allowance_type'] =  $p;

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

    public function allowance_edit(Request $request){

          $this->validate($request, [
            'allowance_code' => 'required|integer',
                ], [        
            'allowance_code.required' => 'Allowance Code is required',
            'allowance_code.integer' => 'Allowance Code Accepted Only Integer',
         ]); 

        
        try{
        $allowance_code = $request->allowance_code;

        if($allowance_code!=0){
          $edit_data=tbl_allowance::where('code','=',$allowance_code)->first();  

          // echo $edit_data->name_of_allowance;die;
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
           return  view('allowance_master_entry')->with('allowance_data',$edit_data);
        } 


    }

    public function allowance_delete(Request $request){
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
            $dlt_data = tbl_allowance::where('code', '=', $request->dlt_code); 
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

    public function dsignation_wise_allowance_details(){

         return view("designation_wise_allowance_details");

    }

     public function add_designation_wise_allowance(){

         return view("designation_wise_allowance_entry");

    }

    public function get_all_allowance(Request $request){

          $statusCode = 200;
          if (!$request->ajax()) {

            $statusCode = 400;
            $response = array('error' => 'Error occered in Json call.');
            return response()->json($response, $statusCode);
          }
          try {

            $allowances = tbl_allowance::pluck('name_of_allowance', 'code');

            $response = array(
              'options' => $allowances, 'status' => 1
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

    public function get_allowance_name(Request $request){

         $statusCode = 200;
          if (!$request->ajax()) {

            $statusCode = 400;
            $response = array('error' => 'Error occered in Json call.');
            return response()->json($response, $statusCode);
          }
          try {

            $allowance_name = tbl_allowance::where('code',$request->allowance)->select('name_of_allowance')->first();

            $response = array(
              'options' => $allowance_name, 'status' => 1
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

    public function save_designationwiseallowance(Request $request){

          $statusCode = 200;
        if (!$request->ajax()) {
            $statusCode = 400;
            $response = array('errors' => 'Error occured in form submit.');
            return response()->json($response, $statusCode);
        }
        $response = [];
        $designation = $request->designation;
        $allowanceNameArrayJson = $request->allowanceNameArrayJson;
        
        $decodeAllowanceName = json_decode($allowanceNameArrayJson);
      // print_r($decodeWorkerName) ;die;

        try{
            $result=tbl_designation_wise_allowance::where('designation_code',$designation)->count();

            if($result == 0){

            $countTotalArray = count($decodeAllowanceName);

            $data = array();
            for ($i = 0; $i < $countTotalArray; $i++) {
            $myArraylength = array();

            $myArraylength['allowance_code'] = $decodeAllowanceName[$i];
            $myArraylength['designation_code'] = $designation;
           
            array_push($data, $myArraylength);
            }
            $insertData = tbl_designation_wise_allowance::insert($data);

            $response = array(
                'count'=>$countTotalArray,'msg'=>'Total '.$countTotalArray.' Record Saved Successfully', 'status' => 1 
            );
        }else{

            $response = array(
                'status' => 0 
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


    public function list_designation_wise_allowance(Request $request){

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

                    $alldesignation_wise_allowance =  tbl_designation_wise_allowance::join('tbl_designation','tbl_designation.code','tbl_designation_wise_allowance.designation_code')->select('tbl_designation.designation','tbl_designation_wise_allowance.code','tbl_designation_wise_allowance.designation_code')
                    ->groupby('tbl_designation_wise_allowance.designation_code')
                            ->where(function($q) use ($search) {
                        $q->orwhere('tbl_designation.designation', 'like', '%' . $search . '%');
                        
                    });



                    $record = $alldesignation_wise_allowance;

                    for ($i = 0; $i < count($order); $i ++) {
                    $record = $record->orderBy($request->columns [$order [$i] ['column']] ['data'], strtoupper($order [$i] ['dir']));
                      }

                    $filtered_count = $alldesignation_wise_allowance->count();
                    $page_displayed = $record->offset($offset)->limit($length)->get();

                    
                    $count = $offset + 1;
                    foreach ($page_displayed as $singledata) {
                        $nestedData['id'] = $count;
                        $nestedData['designation'] = $singledata->designation;
                        $edit_button = $delete_button =  $singledata->designation_code;
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

    public function get_designation_wise_allowance(Request $request){



         $statusCode = 200;
          if (!$request->ajax()) {

            $statusCode = 400;
            $response = array('error' => 'Error occered in Json call.');
            return response()->json($response, $statusCode);
          }
          try {
          //  echo $request->designation_code;die;

            $deg_wise_allowance= tbl_designation_wise_allowance::join('tbl_allowance','tbl_allowance.code','tbl_designation_wise_allowance.allowance_code')->where('tbl_designation_wise_allowance.designation_code',$request->designation_code)->select('name_of_allowance')->get();

            $response = array(
              'options' => $deg_wise_allowance, 'status' => 1
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


    public function designation_wise_allowance_delete(Request $request){

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
         // echo  $request->dlt_code ;die;
               
            $dlt_data = tbl_designation_wise_allowance::where('designation_code', '=', $request->dlt_code); 
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
