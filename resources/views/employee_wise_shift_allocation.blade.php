<?php $title='Employee Wise Shift Allocation' ?>
@extends('layouts.master')
@section('content')
<div class="top-bar">
        <div class="-intro-x breadcrumb mr-auto hidden sm:flex">
                <a href="">Application</a>
                <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="breadcrumb__icon feather feather-chevron-right">
                <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
                <a href="" class="breadcrumb--active">Employee Wise Shift Allocation</a>
            </div>
</div>
<div class=" mt-8 card shadow-lg p-3  bg-white rounded h-75">
            <div class=" items-center h-20">
              <h1 class="text-lg font-medium truncate mr-5"> Add Employee Wise Shift Allocation</h1>
            </div>
        <div class="card-body" style="background-color: white ;" >
        {!! Form::open(['url' => '', 'name' => 'designation_wise_search_form', 'id' => 'designation_wise_search_form', 'method' => 'post' ,'class'=>'animate-form form-horizontal','role'=>'form']) !!}
            <div class="row form-group">
                <div class="col-sm-3 text-right font-weight-bold" style="font-size: 20Px;">
                    {!! Form::label('designation', 'Designation: ',['class'=>'required']) !!}
                </div>
                <div class="col-sm-3">
                    {!! Form::select('designation', [],null,['class'=>'form-control', 'id'=>'designation']) !!}
                </div>
                <div class="col-sm-3 text-right font-weight-bold" style="font-size: 20Px;">
                    {!! Form::label('department', 'Department: ', ['class'=>'required']) !!}
               </div>
               <div class="col-sm-3">
                    {!! Form::select('department', [],null,['class'=>'form-control', 'id'=>'department']) !!}
               </div>
            </div>
            <div class="row form-group">
                <div class="col-sm-12" style="text-align: center;">
                        <button id="save_update" type="button" class="btn btn-primary">Search</button>
                    </div>
            </div>
            {!! Form::close() !!}
            <div class="datatbl table-responsive">
                <table class="table table-striped table-bordered table-hover notice-types-table" id="tbl_of_employee_wise_shift">
                    <thead class="text-center">
                        <tr>
                        <!-- <th>id</th> -->
                            <th style="width: 3%;">SL#</th>
                            <th style="width: 10%;">Emplyee Id</th>
                            <th style="width: 12%;">Employee Name</th>
                            <th style="width: 10%;">Designation</th>
                            <th style="width: 10%;">Department</th>
                            <th style="width: 15%;">Shift</th>
                            <th style="width: 10%;">ACTIONS</th>
                        </tr>
                    </thead>
                
                    <tbody>
                  
                    </tbody>
              
              
                </table>
            </div>
        </div>
</div>
{{csrf_field()}}
<script>
    $(function (){
        get_all_designation();
        get_all_department();
        list_of_employee_wise_shift();

       $("#save_update").click(function(){
         list_of_employee_wise_shift();
       });
    
    });

    function get_all_designation(){
        var token = $("input[name='_token']").val();

        $.ajax({
            type: "post",
            url: "get_all_designation",
            data: {_token:token},
            dataType: "json",
            success: function(data) {
                $("#designation").append('<option value="">Select Designation</option>');
                $.each(data.options, function(key, value){
                    $("#designation").append('<option value=' + key + '>' + value + '</option>');
                });
            }
        });
    }

    function get_all_department(){
        var token = $("input[name='_token']").val();
        $.ajax({
            type: "post",
            url: "get_all_department",
            data:{_token:token},
            dataType: "json",
            success: function(data){
                $("#department").append('<option value="">Select Department</option>');
                $.each(data.options, function(key, value){
                    $("#department").append('<option value=' + key + '>' + value + '</option>');

                });
            }
        });
    }
    
    function list_of_employee_wise_shift() {
        var designation_cd = $("#designation").val();
        // alert(designation_cd);
        var department_cd = $("#department").val();
        // alert(department_cd);
        $("#tbl_of_employee_wise_shift").dataTable().fnDestroy();
        $("#tbl_of_employee_wise_shift").dataTable({
            "processing": true,
            "serverSide": true,
            // "dom": "t",
            "ajax": {
                type: "post",
                url: "list_of_employee_wise_shift",
                data: {'designation_cd': designation_cd, 'department_cd': department_cd, '_token': $('input[name="_token"]').val()},
                dataSrc: "record_details",
            },
            "dataType": "json",
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
                    "data": "emp_id",
                },
                {
                    "targets": 2,
                    "data": "emp_name",
                   
                },
                {
                    "targets": 3,
                    "data": "designation",
                   
                },
                {
                    "targets": 4,
                    "data": "department",
                   
                },
                {
                    "targets": 5,
                    "data": "shift",
                   
                },
                
              
                {
                    "targets": -1,
                    "data": "action",
                    "searchable": false,
                    "sortable": false,
                    "render": function (data, type, full, meta) {
                                var str_btns = "";
                                str_btns+='<button type="submit" data-toggle="tooltip"  style="margin-left: 1px;font-size: 15px;" class="btn btn-primary btn-sm Small add-data" id="' +data.a+ '" title="Add"><i class="fa fa-plus"></i></button>';
                                return str_btns;
                    }
                }

 
            ],
            "order": [[1, 'asc']]
        });
        
    }

    var table = $('#tbl_of_employee_wise_shift').DataTable();
    table.on('draw.dt', function(){
       
        $(".add-data").click(function (){
            // alert("hi");

            var employee_cd = this.id;
            // alert(employee_cd);
        
            var token = $("input[name='_token']").val();
        //     // alert(token);
            $.ajax({
                type: "post",
                url: "get_employee_wise_shift",
                data: {_token:token, employee_cd:employee_cd},
                dataType: "json",
                success: function(data){
                //    alert(data);
                    var tbl = '<table id="" class="table">';
                    tbl+='<thead >';
                    tbl+='</thead>';
                      
                        tbl+='<form name="employee_wise_shift" id="employee_wise_shift" method="post">'
                        tbl+='<tbody>';
                        tbl+='<tr>';

                        tbl+='<td><input type="hidden" id="emp_code" value=' + data.emp['code'] + '></td>';
                        tbl+='<td class="form-group font-weight-bold" style="font-size: 20Px;"><label for="shift">Shift</label></td>';
                        tbl+='<td class="col-sm-6">';
                        tbl+='<select class="form-control" id="select_shift">';
                        tbl+='<option value="">Select Shift</option>'
                        
                        $.each(data.options,function(key,value){
                            if(key==data.employee_shift['shift_code']){
                                tbl+='<option value=' + key + ' selected>' + value +'</option>';

                            } else{
                                tbl+='<option value=' + key + '>' + value +'</option>';
                            }

                        });
                       
                        tbl+='</select>';
                        tbl+='</td>';
                    
                        tbl+='</tr>';
                        tbl+='</tbody>';
                        tbl+='<form>'
                    tbl+='</table>';
                        $.confirm({
                            title: 'Add Employee Wise Shift',
                            type: 'blue',
                            content: tbl,
                            boxHeight: '100%',
                            boxWidth: '50%',
                            useBootstrap: false,
                            buttons:{
                               
                                    formSubmit: {
                                        text: 'Save',
                                        btnClass: 'btn-primary',
                                        action: function () {
                                        var token = $("input[name='_token']").val();
                                   
                                        var emp_code = $("#emp_code").val();
                                        var shift_cd = $("#select_shift").val();
                                        
                                        if(shift_cd ==""){
                                            alert("Please Enter Shift");
                                        }else{
                                            var formData_save = new FormData();
                                            formData_save.append('_token', token);
                                            formData_save.append('emp_code', emp_code);

                                            formData_save.append('shift_cd', shift_cd);
                                            $(".se-pre-con").fadeIn("slow");
                                        $.ajax({
                                            type: "POST",
                                            url: "employee_wise_shift_save_update",
                                            data: formData_save,
                                            processData: false,
                                            contentType: false,
                                            dataType: "json",
                                            success: function(data) {
                                                if(data.status == 1){
                                                    var msg = "<strong>SUCCESS: </strong>Employee Wise Shift Saved Successfully";
                                                    $.confirm({
                                                        title: 'Success!',
                                                        type: 'green',
                                                        icon: 'fa fa-check',
                                                        content: msg,
                                                        buttons: {
                                                            ok: function () {
                                                                list_of_employee_wise_shift();
                                                            }

                                                        }
                                                    });
                                                }
                                            }
                                        });
                                    }
                                }
                            },
                           Cancel: {
                                text: 'Remove',
                                btnClass: 'btn-danger',
                            }
                        }


                        });
                }
            });
        });
    });
  
</script>
@stop