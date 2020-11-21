<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\tbl_type_of_leave;

class LeaveMasterController extends Controller
{
   
    public function leave_head()
    {
       return view('leave_master');
    }
    public function add_leave_head()
    {
        return view('leave_head_entry');
    }

    public function leave_save_update(Request $request)
    {
    //    echo "hi";
        // dd($request->all());
        $statusCode = 200;
        if (!$request->ajax()) {
            $statusCode = 400;
            $response = array('error' => 'Error occured in form submit.');
            return response()->json($response, $statusCode);
        }
        $this->validate($request,[
            'leave_head_name' => "required|max:40|unique:tbl_type_of_leave,type_of_leave|regex: /^[A-Za-z\s]+$/i",
        ],
        [
            'leave_head_name.required' => 'Leave is Required',
            'leave_head_name.regex' => 'Leave can consist of alphabetical characters and spaces only',
            // 'leave_head_name.alpha' => 'Leave allow only alphabitcal',
            // 'size.unique' => 'Leave is not Unique',

        ]);

        try{

            if(isset($request->editcd)){
                $leave=tbl_type_of_leave::find($request->editcd);
               }else{
                $leave=new tbl_type_of_leave();
               }

        // $leave = new tbl_type_of_leave();
        $leave->type_of_leave = $request->leave_head_name;
       
        if($leave->save()){
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
        }   catch(\Exception $e){
            $response = array(
                'exception' => true,
                'exception_message' => $e->getMessage(),
            );
            $statuscode=400;
         } finally{
           return response()->json($response, $statusCode);
        }
    }

    public function list_of_leave(Request $request)
    {
    //    echo "hi";
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
            // echo $length;
            // die;
            $search = $request->search ["value"];
            $order = $request->order;
            $data = array();

            $allleave = tbl_type_of_leave::select('code', 'type_of_leave')
            ->where(function($q) use ($search) {
                $q->orwhere('type_of_leave', 'like', '%' . $search . '%');
                
            });
            // dd($allleave);
         

            $record = $allleave;
            // for ($i = 0; $i < count($order); $i ++) {
            //     $record = $record->orderBy($request->columns [$order [$i] ['column']] ['data'], strtoupper($order [$i] ['dir']));
            //       }
            $filtered_count = $allleave->count();
            $page_displayed = $record->offset($offset)->limit($length)->get();
            $count = $offset + 1;
            foreach ($page_displayed as $singledata) {
                $nestedData['id'] = $count;
                $nestedData['leave_name'] = $singledata->type_of_leave;

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
            
        }  catch (\Exception $e) {
            $response = array(
                'exception' => true,
                'exception_message' => $e->getMessage(),
            );
            $statusCode = 400;
        } finally {
            return response()->json($response, $statusCode);
        }
    }

    public function leave_edit(Request $request)
    {
        
       $this->validate($request, [
        'leave_code' => 'required|integer',
            ], [        
        'leave_code.required' => 'Leave Code is required',
        'leave_code.integer' => 'Leave Code Accepted Only Integer',
    ]); 
    try{
        $leave_code = $request->leave_code;

        if($leave_code!=0){
          $edit_data=tbl_type_of_leave::where('code','=',$leave_code)->first();
        //   dd($edit_data);
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
           return  view('leave_head_entry')->with('leave_data',$edit_data);
        } 
    }

    public function leave_delete(Request $request)
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
            $dlt_data = tbl_type_of_leave::where('code', '=', $request->dlt_code); 
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
