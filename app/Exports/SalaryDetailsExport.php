<?php

namespace App\Exports;

use App\tbl_employee_salary_generation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use DB;

class SalaryDetailsExport implements FromCollection,WithStrictNullComparison,WithHeadings,WithEvents,ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;

      protected $salary_generate_excel_code;

         function __construct($salary_generate_excel_code) {
                $this->salary_generate_excel_code = $salary_generate_excel_code;
                
         }

    public function collection()
    {

        $salary_data_array=array();
        $salary_data_array1=array();

        $salary_data = tbl_employee_salary_generation::where('year_month_designation_code',$this->salary_generate_excel_code)->select('table_data')->first();

        $first_export_data =explode("&", $salary_data->table_data);

        foreach ($first_export_data as $key => $value) {

            unset($salary_data_array);
            $salary_data_array = array();

             $second_export_data =explode("~", $value);

              foreach ($second_export_data as $key => $value1) {
                   array_push($salary_data_array, $value1);
              }

               array_push($salary_data_array1, $salary_data_array);  
        }

          $all_salary_data= collect($salary_data_array1);

       // print_r($first_export_data);die;

        return  $all_salary_data;
    }

     public function headings(): array
        {

            $table_head_array = array();
             $table_head_array1 = array();
              array_push($table_head_array1, ['','','','','','','','ADDITION','','','DEDUCTION','','','']);

            $salary_head = tbl_employee_salary_generation::where('year_month_designation_code',$this->salary_generate_excel_code)->select('table_head')->first();

             $export_head =explode(",", $salary_head->table_head);

            foreach ( $export_head as $key => $value) {

               array_push($table_head_array, $value);  
               
            }
             array_push($table_head_array1, $table_head_array);


            return $table_head_array1;
        }
    
        public function registerEvents(): array
        {
            return [
                AfterSheet::class    => function(AfterSheet $event) {
    
                    $cellRange = 'A1:AK1'; // All headers
                    $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);

                    $cellRange1 = 'A2:AK2'; // All headers
                    $event->sheet->getDelegate()->getStyle($cellRange1)->getFont()->setSize(18);
                    
                },
            ];
        }
}
