<?php $title = 'Monthly Attendance Report'; ?>
@extends('layouts.master')
@section('content')
   <div class="top-bar">
         <div class="-intro-x breadcrumb mr-auto hidden sm:flex">
            <a href="">Application</a>
            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="breadcrumb__icon feather feather-chevron-right">
               <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
            <a href="" class="breadcrumb--active">Monthly Employee Attendance</a>
         </div>
         {{--  <div class="intro-x relative mr-3 sm:mr-6">
        <a href="add_department"><button type="button" class="btn btn-info">
         <span class="glyphicon glyphicon-search"></span>Add Department
        </button></a>
      
        
     </div> --}}
        
    </div>

        <div class=" mt-8 card shadow-lg p-3  bg-white rounded h-75">
           <div class=" items-center h-10">
              <h1 class="text-lg font-medium truncate mr-5">Monthly Employee Attendance</h1>
            </div>

            <div class="card-body" style="background-color: white ;" >

                  {!! Form::open(['url' => '', 'name' => 'salary_generation', 'id' => 'salary_generation', 'method' => 'post' ,'class'=>'animate-form form-horizontal','role'=>'form']) !!}
                 {!! Form::hidden('code', '',['id'=>'edit_code']) !!}
                                
                <div class="row form-group">

                     <div class="col-sm-3  font-weight-bold" style="font-size: 16Px;">
                        {!! Form::label('designation', ' Designation:', ['class' =>'']) !!}
                    
                         {!! Form::select('designation',[''=>'Select Designation'],null,['class' => 'form-control','id'=>'designation']); !!}
                    </div>


                    <div class="col-sm-5 font-weight-bold" style="font-size: 16Px;">
                     {!! Form::label('employee', 'Employee:', ['class'=>'highlight']) !!}
                     
                        <select class="employee form-control"  name="employee" id='employee' autocomplete="off"></select>
                    
                        <div style="display: none;">
                            {!! Form::text('employee',null,['id'=>'employee','class'=>'form-control','autocomplete'=>'off','readonly'=>'false']) !!}
                        </div>
                  
                     </div>  
               

                   {{--  <div class="col-sm-3  font-weight-bold" style="font-size: 16Px;">
                        {!! Form::label('employee', ' Employee:', ['class' =>'']) !!}
                    
                         {!! Form::select('employee',[''=>'Select Employee'],null,['class' => 'form-control','id'=>'employee']); !!}
                    </div> --}}

                    <div class="col-sm-2  font-weight-bold" style="font-size: 16Px;">
                        {!! Form::label('year', ' Year:', ['class' =>'']) !!}
                    {!! Form::select('year',[''=>'Select Year' ,'2020'=>'2020' ,'2021'=>'2021','2022'=>'2022','2023'=>'2023'],null,['class' => 'form-control','id'=>'year']); !!}
                    </div>
                    <div class="col-sm-2 font-weight-bold" style="font-size: 16Px;">
                        {!! Form::label('month', ' Month:', ['class' =>'']) !!}
                    
                       {!! Form::select('month',[''=>'Select Month','01'=>'January','02'=>'February','03'=>'March','04'=>'April','05'=>'May','06'=>'June','07'=>'July','08'=>'August','09'=>'September','10'=>'October','11'=>'November','12'=>'December'],null,['class' => 'form-control','id'=>'month']); !!}
                    </div>
                    
                    
                </div>             
                <div class="row form-group">
                    <div class="col-sm-12" style="text-align: center;">
                        <button id="save_update" type="button" class="btn btn-primary">Search</button>
                    </div>
                </div>
                <div class="row form-group search_result">
                    
                </div>
               
                   {!! Form::close() !!}
                   <div id="total_all" style="display:none">

                   <div style="width: 18%;height: 10%; background-color: #eee; float:left; font-size: 17px;font-weight: bold;">Working Days :   <span id="working_day"> </span></div>
                   <div style="width: 18%;height: 10%; background-color:#eee; float:left; margin-left: 2%;font-size: 17px;font-weight: bold;">Present Days :   <span id="present_day"> </span></div>
                   <div style="width: 18%;height: 10%; background-color: #eee; float:left; margin-left: 2%;font-size: 17px;font-weight: bold;">Absent Days :   <span id="absent_day"> </span></div>
                   <div style="width: 18%;height: 10%; background-color: #eee; float:left; margin-left: 2%;font-size: 17px;font-weight: bold;">Holidays :   <span id="holi_day"> </span></div>
                   <div style="width: 18%;height: 10%; background-color: #eee; float:left; margin-left: 2%;font-size: 17px;font-weight: bold;">Leave :   <span id="leave_day"> </span></div>
                   </div>




            <div class="datatbl table-responsive" style="display:none;">
                <table class="table table-striped table-bordered table-hover notice-types-table" id="tbl_monthly_attendance_entry">
                    <thead class="text-center">
                        <tr>
                           {{-- // <th style="width: 10%;">SL#</th> --}}
                            <th style="width: 10%;">Date</th>
                            <th style="width: 10%;">Day</th>
                            <th style="width: 10%;">Shift In Time</th>
                            <th style="width: 10%;">Shift Out Time</th>
                            <th style="width: 10%;">In Time</th>
                            <th style="width: 10%;">Out Time</th>
                            <th style="width: 10%;">Late Arrival</th>
                            <th style="width: 10%;">Early Departure</th>
                            <th style="width: 10%;">Worked Time</th>
                            <th style="width: 10%;">Status</th>
                            <th style="width: 10%;">Action</th>
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
            get_all_designation();
            get_designation_wise_employee('');
            //department_details();
        });

         $("#designation").change(function(){

           //  tbll.fnClearTable();

          var deg=  $("#designation").val();
            get_designation_wise_employee(deg);

         });

         $("#save_update").click(function(){

            monthly_attendance_details();

            count_Absent_Present_Holiday_Leave();

         });
         function count_Absent_Present_Holiday_Leave(){

             var token = $('input[name="_token"]').val();
              var designation_code = $("#designation").val();
               var employee_code = $("#employee").val();
               var year = $("#year").val();
               var month = $("#month").val();
             $.ajax({
                  type: "post",
                  url: "countAbsentPresentHolidayLeave",
                  async:false,
                  data:{_token:token,designation_code:designation_code,employee_code:employee_code,year:year,month:month},
                  dataType: 'json',
                  success: function (data) {

                    $("#working_day").html(data.totworking_day);
                    $("#present_day").html(data.totpresent);
                    $("#absent_day").html(data.totabsent);
                    $("#holi_day").html(data.totholiday);
                    $("#leave_day").html(data.totleave);
                    $("#total_all").show();



                  }
              });


         }

         function monthly_attendance_details(){

           var designation_code = $("#designation").val();
           var employee_code = $("#employee").val();
           var year = $("#year").val();
           var month = $("#month").val();
           $(".datatbl").show();
             
            $("#tbl_monthly_attendance_entry").dataTable().fnDestroy();
             var tbll =   $('#tbl_monthly_attendance_entry').dataTable({

                  "processing": true,
                  "serverSide": true,
                   "scrollY":   "300px",
                    "scrollCollapse": true,
                  "dom": "t",
                  "ajax": {
                url: "list_tbl_monthly_attendance_entry",
                type: "post",
                data: {'_token': $('input[name="_token"]').val(),designation_code:designation_code,employee_code:employee_code,year:year,month:month},
                dataSrc: "record_details",

            },
            "dataType": 'json',
            "columnDefs":
                    [
                        {className: "table-text", "targets": "_all"},
                        // {
                        //     "targets": 0,
                        //     "data": "id",
                        //     "defaultContent": "",
                        //     "searchable": false,
                        //     "sortable": false,
                        // },
                        {
                            "targets": 0,
                            "data": "date",
                             "searchable": false,
                             "sortable": false,
                            
                        },
                         {
                            "targets": 1,
                            "data": "day",
                            "searchable": false,
                             "sortable": false,
                            
                        },
                        {
                            "targets": 2,
                            "data": "standerd_in_time",
                            "searchable": false,
                             "sortable": false,
                            
                        },
                        {
                            "targets": 3,
                            "data": "standerd_out_time",
                            "searchable": false,
                             "sortable": false,
                            
                        },
                         {
                            "targets": 4,
                            "data": "in_time",
                            "searchable": false,
                             "sortable": false,
                            
                        },
                         {
                            "targets": 5,
                            "data": "out_time",
                            "searchable": false,
                             "sortable": false,
                            
                        },
                        {
                            "targets": 6,
                            "data": "late_arrival",
                            "searchable": false,
                             "sortable": false,
                            
                        },
                        {
                            "targets": 7,
                            "data": "early_departure",
                            "searchable": false,
                             "sortable": false,
                            
                        },
                        {
                            "targets": 8,
                            "data": "worked_time",
                            "searchable": false,
                             "sortable": false,
                            
                        },
                         {
                            "targets": 9,
                            "data": "att_status",
                            "searchable": false,
                             "sortable": false,
                            
                        },
                       
                       
                        {
                            "targets": -1,
                            "data": 'action',
                            "searchable": false,
                            "sortable": false,
                            "render": function (data, type, full, meta) {
                                var str_btns = "";

                                if(data.presentAbsent == 0){

                                    str_btns+='<button type="submit" data-toggle="tooltip"  style="margin-left: 1px" class="btn btn-warning btn-sm Small leave_taken" leave_date="'+ data.leave_date +'" deg="'+data.d+'" id="' +data.e+ '" title="Leave Taken"><i class="fa fa-edit"></i> </button> &nbsp;';

                                }else{
                                     str_btns+= '';

                                }
                                
                                
                        
                                return str_btns;
                            }
                        }
                      

                        ],
                        "order": [[1, 'asc']]


         });



}

    var table = $('#tbl_monthly_attendance_entry').dataTable();
        table.on('draw.dt', function () {

             $('.leave_taken').click(function () {
                  var emp_code = this.id;
                  //alert(emp_code);
                  var des_code = $(this).attr('deg');
                  var leave_date = $(this).attr('leave_date');
                  var token = $('input[name="_token"]').val();

                $.ajax({
                  type: "post",
                  url: "get_all_leave_details",
                  async:false,
                  data:{_token:token,emp_code:emp_code,des_code:des_code,leave_date:leave_date},
                  dataType: 'json',
                  success: function (data) {
                    var tbl ='';

                    tbl+='<div class="row" style="width:100%; height:100%">';
                    tbl+='<div class="col-sm-6">';
                    tbl+= '<table id="user_details" class="table table-bordered"  >';

                       tbl+='<tr>';
                       tbl+='<td style="width: 50%;">Employee ID :</td>';
                       tbl+='<td>'+data.employee_details.emp_id+'</td>';
                       tbl+='</tr>';
                           
                       tbl+='<tr>';
                       tbl+='<td style="width: 50%;">Employee Name :</td>';
                       tbl+='<td>'+data.employee_details.emp_name+'</td>';
                       tbl+='</tr>';

                       tbl+='<tr>';
                       tbl+='<td style="width: 50%;">Date :</td>';
                       tbl+='<td>'+data.converted_leave_date+'</td>';
                       tbl+='</tr>';

                       tbl+='<tr>';
                       tbl+='<td style="width: 50%;">Designation :</td>';
                       tbl+='<td>'+data.employee_details.designation+'</td>';
                       tbl+='</tr>';

                       tbl+='<tr>';
                       tbl+='<td style="width: 50%;">Department :</td>';
                       tbl+='<td>'+data.employee_details.department+'</td>';
                       tbl+='</tr>';
                       tbl+='</table>';
                           
                    tbl+='</div>';
                    tbl+='<div class="col-sm-6">';
                   

                         tbl+= '<table id="user_details" class="table table-bordered"  >';
                           tbl+='<thead >';
                           tbl+='<tr>';
                           tbl+='<th style="width: 33%;">Type of Leave</th>';
                           tbl+='<th style="width: 33%;">Total Leave</th>';
                           tbl+='<th style="width: 33%;">Available Leave</th>';
                           tbl+='</tr>';
                           tbl+='</thead>';

                     $.each(data.total_leave, function (key, value) {

                                tbl+='<tbody>';
                                tbl+='<tr>';
                                tbl+='<td>' + value.type_of_leave + '</td>';
                                tbl+='<td>' + value.no_of_leave +' </td>';
                                tbl+='<td>' + value.leave_available + '</td>';
                                tbl+='</tr>';
                                tbl+='</tbody>';
                        
                        // tbl+='<div class="row">';

                        //  tbl+='<div  style="width:30%;"><h5 class=" p-3">'+value.type_of_leave+'</h5></div>';
                
                        // tbl +='<div class=" p-3 m-1" style="background-color: #eee; float:left ; width:30%;">Total '+value.no_of_leave+'</div>';

                        //  tbl +='<div class=" p-3 m-1" style="background-color: #eee; float:left ; width:30%;">Available '+value.leave_available+'</div>';
                        //   tbl+='</div>';
                         
                  
                     });
                      tbl+='</table>';
                       tbl+='</div>';
                       tbl+='</div>';
                  
                     tbl+='  <div class="col-sm-9  font-weight-bold" style="font-size: 16Px; text-align:center ; padding-left:100px">';
                     tbl+='<h5></h5>'
                         
                     tbl +='<select placeholder="Select Leave" class="form-control" name="leave" id="leave">';
                      tbl +='<option value=""> Select Leave</option>';

                      $.each(data.all_leave, function (key, value) {
                
                       tbl +='<option value='+ key +'>'+ value +'</option>';
                  
                     });
    
                     tbl +='</select>';
                     tbl+='</div>';

                     
  
                         $.confirm({
                            type: 'green',
                           // icon: 'fa fa-eye',
                            title: 'Leave Taken',
                           boxWidth: '70%',
                           useBootstrap: false,
                            content: tbl,
                            buttons: {
                              Save: {
                                btnClass: 'btn-orange',
                                action: function () {

                                    var leave_code =$("#leave").val();
                                   if(leave_code != ''){

                                    $.ajax({
                                          type: "post",
                                          url: "save_leave_employee",
                                          async:false,
                                          data:{_token:token,emp_code:emp_code,des_code:des_code,leave_date:leave_date,leave_code:leave_code},
                                          dataType: 'json',
                                          success: function (data) {

                                            if(data.status ==  1){

                                                 $.confirm({
                                                    title: 'Success!',
                                                    type: 'green',
                                                    icon: 'fa fa-success',
                                                    content: "Leave Taken Successfully",
                                                      buttons:{
                                                          ok:function () {

                                                            monthly_attendance_details();
                                                           
                                                        }
                                                        }
                                                   
                                                });
                                            }
                                          }
                                      });

                                   }else{

                                    alert("Please Select Leave");
                                   }     
                                 
                                }
                              },
                              
                              cancel: {

                                action: function () {

                                }
                              },

                            }
                          });

                  }
                });


                   
            });  

     });

        function  get_all_designation(){
            var token = $("input[name='_token']").val();
            $.ajax({
              type: "post",
              url: "get_all_designation",
              async:false,
              data:{_token:token},
              dataType: 'json',
              success: function (data) {
              
                $('#designation').html('<option value=""> Select Designation </option>');
                $.each(data.options, function (key, value) {
                
                    $("#designation").append('<option value=' + key + '>' + value + '</option>');
                  
                });

              }
            });
         }

         function get_designation_wise_employee(deg){
           // alert();

        $('.employee').select2({
            placeholder: "Select Employee Name",
            minimumInputLength: 1,
            maximumInputLength: 10,
            allowClear:true,
            //var token = $("input[name='_token']").val();
            ajax: {
                url: 'get_designation_wise_employee',
                dataType: 'json',
                method: 'POST',
                success:function(data){                    
                    
                },
                data: function (params) {
                    return {
                        q: $.trim(params.term),
                        _token: $("input[name='_token']").val(),
                         deg:deg
                    };
                },
                processResults: function (data) {

                    return {
                        results: $.map(data.options, function (item) {
                            return {
                                text: item.emp_name,
                                id: item.code
                            }
                        })
                    };
                },
                cache: true
            }
        }).on("select2:select", function (event) {
            var value = $(event.currentTarget).find("option:selected").val();
            //select_ltml(value);
        });

            //  var token = $("input[name='_token']").val();
            // $.ajax({
            //   type: "post",
            //   url: "get_designation_wise_employee",
            //   async:false,
            //   data:{_token:token,deg:deg},
            //   dataType: 'json',
            //   success: function (data) {
              
            //     $('#employee').html('<option value=""> Select Employee </option>');
            //     $.each(data.options, function (key, value) {
                
            //         $("#employee").append('<option value=' + key + '>' + value + '</option>');
                  
            //     });

            //   }
            // });

         }

     </script>


                      
  
@stop