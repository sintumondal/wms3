<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\tbl_ptax;

class PTaxController extends Controller
{
    public function p_tax_details()
    {
        return view('p_tax_details');
    }
    public function add_p_tax()
    {
       return view('p_tax_entry');
    }
    public function p_tax_save_update(Request $request)
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
            'salary_from_amount' => "required",
            'salary_to_amount' => "required",
            'deductable_amount' => "required"
   
        ],
        [
            'salary_from_amount.required' => 'Salary From Amount is Required',
            'salary_to_amount.required' => 'Salary To Amount is Required',
            'deductable_amount.required' => 'Deductable Amount is Required',
   
   
        ]);
        try{
            if(isset($request->editcd)){
                $p_tax_save_update=tbl_ptax::find($request->editcd); 
            } else{
                $p_tax_save_update = new tbl_ptax();
                
            }
            $p_tax_save_update->from_amt = $request->salary_from_amount;
            $p_tax_save_update->to_amt = $request->salary_to_amount;
            $p_tax_save_update->amt	 = $request->deductable_amount;
           
            if($p_tax_save_update->save()){
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
    public function list_of_p_tax(Request $request)
    {
        // echo "hi";
        $statusCode = 200;
        if (!$request->ajax()) {
            $statusCode = 400;
            $response = array('error' => 'Error occured in form submit.');
            return response()->json($response, $statusCode);
        }
        try{
            $draw = $request->draw;
          
            $offset = $request->start;
            // echo $offset; die;
            $length = $request->length;
            // echo $length; die;
            $search = $request->search['value'];
            // echo $search; die;
            $order = $request->order;
            // echo $order; die;
            $data = [];
            
            $allPTax = tbl_ptax::select('code', 'from_amt', 'to_amt', 'amt')
            ->where(function($q) use ($search) {
                $q->orwhere('from_amt', 'like', '%' . $search . '%');
                
            });

            $record = $allPTax;
            $filtered_count = $allPTax->count();
            // echo $filtered_count; die;
            $page_displayed = $record->offset($offset)->limit($length)->get();
            // dd($page_displayed);
            $count = $offset + 1;
            foreach ($page_displayed as $singledata) {
               $nestedData['id'] = $count;
               $nestedData['salary_from_amt'] = $singledata->from_amt;
               $nestedData['salary_to_amt'] = $singledata->from_amt;
               $nestedData['deductable_amt'] = $singledata->amt;
               $edit_button = $delete_button = $singledata->code;
               $nestedData['action'] = ['e' => $edit_button, 'd' => $delete_button];
               $count++;
               $data[] = $nestedData; 
            }
            $response = [
                'draw' => $draw,
                'recordsTotal' => $filtered_count,
                'recordsFiltered' => $filtered_count,
                'record_details' => $data
            ];

              
    

        } catch(\Exception $e){
            $response = array(
                'exception' => true,
                'exception_message' => $e->getMessage()
            );
            $statusCode = 400;
        } finally{
            return response()->json($response, $statusCode);
        }
   
    }
    public function p_tax_edit(Request $request)
    {
        $this->validate($request, [
            'p_tax_cd' => 'required|integer',
                ], [        
            'p_tax_cd.required' => 'P_TAX Code is required',
            'p_tax_cd.integer' => 'P_TAX Code Accepted Only Integer',
        ]); 
        try{
            $p_tax_code = $request->p_tax_cd;
    
            if($p_tax_code!=0){
              $edit_data=tbl_ptax::where('code','=',$p_tax_code)->first();

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
               return  view('p_tax_entry')->with('p_tax_data', $edit_data);
            } 
    }

    public function p_tax_delete(Request $request)
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
         $dlt_data = tbl_ptax::where('code', '=', $request->dlt_code); 
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
