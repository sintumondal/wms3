<?php $title = 'Salary Generated Details'; ?>
@extends('layouts.master')
@section('content')
   <div class="top-bar">
         <div class="-intro-x breadcrumb mr-auto hidden sm:flex">
            <a href="">Salary Generated Details</a>
            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="breadcrumb__icon feather feather-chevron-right">
               <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
            <a href="" class="breadcrumb--active"></a>
         </div>
        {{--   <div class="intro-x relative mr-3 sm:mr-6">
        <a href="add_department"><button type="button" class="btn btn-info">
         <span class="glyphicon glyphicon-search"></span>Add Department
        </button></a>
      
        
     </div> --}}
        
    </div>

        <div class=" mt-8 card shadow-lg p-3  bg-white rounded h-75">
           <div class=" items-center h-20">
              <h1 class="text-lg font-medium truncate mr-5"> Salary Generated Details</h1>
            </div>

            <div class="card-body" style="background-color: white ;" >


            <div class="datatbl table-responsive">
                <table class="table table-striped table-bordered table-hover notice-types-table" id="tbl_salary_generated_details">
                    <thead class="text-center">
                        <tr>
                            <th style="width: 10%;">SL#</th>
                            <th style="width: 20%;">Year</th>
                            <th style="width: 20%;">Month</th>
                            <th style="width: 20%;">Designation</th>
                            <th style="width: 30%;">Action</th>
                        </tr>
                   </thead>
                    <tbody >
                    </tbody>
                </table> 
            </div>
       
                            
                         
             
            </div>
        
     </div>
        {{csrf_field()}}
     <script type="text/javascript">
         
         $(function () { 
             salary_generated_details();
        });

         function salary_generated_details(){
             
            $("#tbl_salary_generated_details").dataTable().fnDestroy();
                $('#tbl_salary_generated_details').dataTable({

                  "processing": true,
                  "serverSide": true,
                  "ajax": {
                url: "list_salary_generated_details",
                type: "post",
                data: {'_token': $('input[name="_token"]').val()},
                dataSrc: "record_details",

            },
            "dataType": 'json',
            "columnDefs":
                    [
                        {className: "table-text", "targets": "_all"},
                        {
                            "targets": 0,
                            "data": "id",
                            "defaultContent": "",
                            "searchable": false,
                            "sortable": false,
                        },
                        {
                            "targets": 1,
                            "data": "year",
                            
                        },
                         {
                            "targets": 2,
                            "data": "month",
                            
                        },
                         {
                            "targets": 3,
                            "data": "designation",
                            
                        },
                       
                        {
                            "targets": -1,
                            "data": 'action',
                            "searchable": false,
                            "sortable": false,
                            "render": function (data, type, full, meta) {
                                var str_btns = "";
                                
                                str_btns+='<button type="submit" data-toggle="tooltip"  style="margin-left: 1px" class="btn btn-primary btn-sm Small regenerate_salary" id="' +data.e+ '" title="Regenerate Salary"><i class="fa fa-retweet" aria-hidden="true"></i> </button> &nbsp;';

                                str_btns+='<button type="submit" data-toggle="tooltip"  style="margin-left: 1px" class="btn btn-success btn-sm Small salary_generate_excel" id="' +data.e+ '" title="Salary Report in Excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i> </button> &nbsp;';

                                 str_btns+='<button type="submit" data-toggle="tooltip"  style="margin-left: 1px" class="btn btn-warning btn-sm Small salary_generate_pdf" id="' +data.e+ '" title="Salary Report in PDF"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> </button> &nbsp;';

                                  str_btns+='<button type="submit" data-toggle="tooltip"  style="margin-left: 1px" class="btn btn-info btn-sm Small pay_slip_generate" id="' +data.e+ '" title="Pay Slip Generate"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> </button> &nbsp;';



                                 // str_btns+= '<button type="submit" data-toggle="tooltip" style="margin-left: 1px" class="btn btn-danger btn-sm Small delete-button" id="' + data.d + '" title="Delete"><i class="fa fa-trash"></i> </button';

                                return str_btns;
                            }
                        }
                      

                        ],
                        "order": [[1, 'asc']]


         });



}

    var table = $('#tbl_salary_generated_details').DataTable();
        table.on('draw.dt', function () {
            
            $('.regenerate_salary').click(function () {
                var regenerate_salary_code = this.id;
                var datas = {'regenerate_salary_code': regenerate_salary_code, '_token': $('input[name="_token"]').val()};
                redirectPost('{{url("regenerate_salary_details")}}', datas);
            });

             $('.salary_generate_excel').click(function () {
                var salary_generate_excel_code = this.id;
                var datas = {'salary_generate_excel_code': salary_generate_excel_code, '_token': $('input[name="_token"]').val()};
                redirectPost('{{url("salary_generate_excel_report")}}', datas);
            });

            $('.salary_generate_pdf').click(function () {
                var salary_generate_pdf_code = this.id;
                var datas = {'salary_generate_pdf_code': salary_generate_pdf_code, '_token': $('input[name="_token"]').val()};
                redirectPost('{{url("salary_generate_pdf_report")}}', datas);
            });

             $('.pay_slip_generate').click(function () {
                var pay_slip_generate_code = this.id;
                var datas = {'pay_slip_generate_code': pay_slip_generate_code, '_token': $('input[name="_token"]').val()};
                redirectPost('{{url("pay_slip_generate")}}', datas);
            });


             $('.delete-button').click(function () {

                var reply = confirm('Are you sure to delete the record?');
                if (!reply) {
                    return false;
                }
                var dlt_code = this.id;
                $.ajax({
                    type: 'post',
                    url: 'department_delete',
                    data: {'dlt_code': dlt_code, '_token': $('input[name="_token"]').val()},
                    dataType: 'json',
                    success: function (datam) {
 
                        if (datam.status == 1) {
                            department_details();
                            $.alert({
                                type: 'green',
                                icon: 'fa fa-check',
                                title: 'Success!!',
                                content: '<strong>SUCCESS:</strong> Deparment Deleted Successfully.'
                            });
                        } else {
                            $.alert({
                                type: 'red',
                                icon: 'fa fa-warning',
                                title: 'Error!!',
                                content: '<strong>UNSUCCESS:</strong> Failed to Delete Data.'
                            });
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                       
                        var msg = "<strong>Failed to Delete data.</strong><br/>";
                        if (jqXHR.status !== 422 && jqXHR.status !== 400) {
                            msg += "<strong>" + jqXHR.status + ": " + errorThrown + "</strong>";
                        } else {
                            if (jqXHR.responseJSON.hasOwnProperty('exception')) {
                                if (jqXHR.responseJSON.exception_code == 23000) {
                                    msg += "Data Already Used!! Cannot Be Deleted.";
                                }
                            } else {
                                msg += "Error(s):<strong><ul>";
                                $.each(jqXHR.responseJSON['errors'], function (key, value) {
                                    msg += "<li>" + value + "</li>";
                                });
                                msg += "</ul></strong>";
                            }
                        }
                        $.alert({
                            type: 'red',
                            icon: 'fa fa-warning',
                            title: 'Error!!',
                            content: msg
                        });

                    }
                    // alert('hi');
                });

            });

     });

     </script>


                      
  
@stop