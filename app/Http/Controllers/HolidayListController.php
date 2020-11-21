<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\tbl_of_holiday;
use DB;

class HolidayListController extends Controller
{
    public function holiday_details()
    {
       return view('holiday_details');
    }
    public function add_holidays()
    {
        return view('holiday_entry');
    }
    public function holiday_save_update(Request $request)
    {
    //    dd($request->all());
        $statusCode = 200;
        if (!$request->ajax()) {
            $statusCode = 400;
            $response = array('error' => 'Error occured in form submit.');
            return response()->json($response, $statusCode);
        }

        $this->validate($request,[
            'year' => 'required',
            'holiday_date' => 'required|date_format:d/m/Y',
            'description' => 'required|max:40',
        ],[
            'year.required' => "Year is Required",
            'holiday_date.required' => "Date is Required",
            'description.required' => "Description is Required",
        ]);
        try{
            if(isset($request->editcd)){
                $holidays = tbl_of_holiday::find($request->editcd);
            }else{
                $holidays = new tbl_of_holiday();
            }
            // $holiday_dt = date("Y-m-d", strtotime($request->date));
            // echo $request->holiday_date;
            // die;
            $request_date = date('Y-m-d', strtotime(trim(str_replace('/', '-', $request->holiday_date))));
            $holidays->year = $request->year;
            
            // $data_holiday_dt = tbl_of_holiday::where(DB::raw("DATE(holiday_date)"), '=', $request_date)->select('holiday_date')->count();
            // // echo $data_holiday_dt;
            // // die;
            // if($data_holiday_dt > 0){
            //     $statusCode = 400;
            // $response = array('error' => 'Error occured in form submit.');
            // return response()->json($response, $statusCode);

            // }
            $holidays->holiday_date = $request_date;
            $holidays->description = $request->description;

            if($holidays->save()){
                if($request->editcd){
                    $response = array(
                        'status' => 2,
                    );
                } else{
                    $response = array(
                        'status' => 1,
                    );
                }
               
            }else{
                $response = array(
                    'status' => 3,
                );
            }
            
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

    public function list_of_holidays(Request $request)
    {
        $statusCode = 200;
        if (!$request->ajax()) {
            $statusCode = 400;
            $response = array('error' => 'Error occured in form submit.');
            return response()->json($response, $statusCode);
        }
        try{
            $draw = $request->draw;
            $offset = $request->start;
            // echo $offset;
            // die;
            $length = $request->length;
            // echo $length;
            // die;
            $search = $request->search ["value"];
            $order = $request->order;
            $data = array();

            $allholidays = tbl_of_holiday::select('tbl_of_holiday.code', 'tbl_of_holiday.holiday_date', 'tbl_of_holiday.description', 'tbl_of_holiday.year')
            ->where(function($q) use ($search) {
                $q->orwhere('description', 'like', '%' . $search . '%');
                
            });
    //    dd($allholidays);
        $record = $allholidays;
        // dd($record);
        $filtered_count = $allholidays->count();
        $page_displayed = $record->offset($offset)->limit($length)->get();
        // dd($page_displayed);
        $count = $offset + 1;
        foreach ($page_displayed as $singledata) {
            $nestedData['id'] = $count;
            $nestedData['holiday_year'] = $singledata->year;
            $date_format_holiday = date('d/m/Y', strtotime($singledata->holiday_date));
            $nestedData['holiday_date'] = $date_format_holiday;
            $nestedData['descirption'] = $singledata->description;

            $edit_button = $delete_button = $singledata->code;
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

    public function holidays_edit(Request $request)
    {
    //    echo "hi";
        $this->validate($request,[
            'holiday_code' => "required|integer"
        ],[
            'holiday_code.required' => "Holiday Code is Required",
            'holiday_code.integer' => "Leave Code Accepted Only Integer"
        ]);

        try{
            $holiday_cd = $request->holiday_code;
           
            if($holiday_cd!=0){
                $edit_data = tbl_of_holiday::where('code', '=', $holiday_cd)->select('code', 'year', 'holiday_date', 'description')->first();
                // dd($edit_data);
                $holiday_date_format = date('d/m/Y', strtotime($edit_data->holiday_date));
                // dd($holiday_date_format);
                $multidimentional = [
                    'code' => $edit_data->code,
                    'year' => $edit_data->year,
                    'holiday_date' => $holiday_date_format,
                    'description' => $edit_data->description
                ];
                $holidays_details = json_encode($multidimentional);
                // dd($holidays_details);
                
            }
            else{
                $edit_data = [];
            }
        } catch (\Exception $e) {
            $response = array(
                'exception' => true,
                'exception_message' => $e->getMessage(),
            );
            $statusCode = 400;
        } finally {
           return  view('holiday_entry')->with('holiday_data',$holidays_details);
        } 
          
    }

    public function holidays_delete(Request $request)
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
            $dlt_data = tbl_of_holiday::where('code', '=', $request->dlt_code); 
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
