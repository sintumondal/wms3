<?php $title = 'Attendance Report'; ?>
@extends('layouts.master')
@section('content')
   <div class="top-bar">
         <div class="-intro-x breadcrumb mr-auto hidden sm:flex">
            <a href="">Application</a>
            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="breadcrumb__icon feather feather-chevron-right">
               <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
            <a href="" class="breadcrumb--active">Attendance Report</a>
         </div>
          <div class="intro-x relative mr-3 sm:mr-6">
        {{-- <a href="add_department"><button type="button" class="btn btn-info">
         <span class="glyphicon glyphicon-search"></span>Add Department
        </button></a> --}}
      
        
     </div>
        
    </div>

        <div class=" mt-8 card shadow-lg p-3  bg-white rounded h-75">
           <div class=" items-center h-10">
              <h1 class="text-lg font-medium truncate mr-5"> Attendance Report</h1>
            </div>

            <div class="card-body" style="background-color: white ;" >

                 {!! Form::open(['url' => '', 'name' => 'attendance_report_form', 'id' => 'attendance_report_form', 'method' => 'post' ,'class'=>'animate-form form-horizontal','role'=>'form']) !!}
                 {!! Form::hidden('code', '',['id'=>'edit_code']) !!}
                                
                <div class="row form-group">
                    <div class="col-sm-4  font-weight-bold" style="font-size: 16Px;">
                        {!! Form::label('employee', ' Employee:', ['class' =>'']) !!}
                    {!! Form::select('employee',[''=>'Select Employee'],null,['class' => 'form-control','id'=>'employee']); !!}
                    </div>
                    <div class="col-sm-4 font-weight-bold" style="font-size: 16Px;">
                        {!! Form::label('department', ' Department:', ['class' =>'']) !!}
                    
                       {!! Form::select('department',[''=>'Select Department'],null,['class' => 'form-control','id'=>'department']); !!}
                    </div>
                    <div class="col-sm-4  font-weight-bold" style="font-size: 16Px;">
                        {!! Form::label('designation', ' Designation:', ['class' =>'']) !!}
                    
                         {!! Form::select('designation',[''=>'Select Designation'],null,['class' => 'form-control','id'=>'designation']); !!}
                    </div>
                    <div class="col-sm-4  font-weight-bold" style="font-size: 16Px;">
                       {!! Form::label('from_date', 'From Date:', ['class'=>'highlight']) !!} 
                    
                         {!! Form::text('from_date',null,['id'=>'from_date','class'=>'form-control','placeholder'=>'DD/MM/YYYY','autocomplete'=>'off']) !!}

                    </div>
                    <div class="col-sm-4  font-weight-bold" style="font-size: 16Px;">
                        {!! Form::label('to_date', 'To Date:', ['class'=>'highlight']) !!} 
                    
                         {!! Form::text('to_date',null,['id'=>'to_date','class'=>'form-control','placeholder'=>'DD/MM/YYYY','autocomplete'=>'off']) !!}
                    </div>
                    
                    
                </div>             
                <div class="row form-group">
                    <div class="col-sm-12" style="text-align: center;">
                        <button id="search" type="button" class="btn btn-primary">Search</button>
                    </div>
                </div>
                <div class="row form-group search_result">
                    
                </div>
               
                   {!! Form::close() !!}             
             


            <div class="datatbl table-responsive">
                <table class="table table-striped table-bordered table-hover notice-types-table" id="tbl_attendance_report">
                    <thead class="text-center">
                        <tr>
                            <th style="width: 5%;">SL#</th>
                            <th style="width: 10%;">Name</th>
                            <th style="width: 10%;">ID</th>
                            <th style="width: 10%;">Department</th>
                            <th style="width: 10%;">Designation</th>
                            <th style="width: 10%;">Date</th>
                            <th style="width: 10%;">In Time</th>
                            <th style="width: 10%;">Out Time</th>
                            <th style="width: 10%;">Status</th>
                            <th style="width: 10%;">Working Time</th>
                            <th style="width: 5%;">Action</th>
                        </tr>
                   </thead>
                    <tbody >
                    </tbody>
                </table> 
            </div>


       
                            
                         
             
            </div>
        
     </div>

      <div id="map_modal" class="modal" tabindex="-1" role="dialog">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Map</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div id="mappp">

                      
                    </div>
                  </div>
                  
                </div>
              </div>
            </div>
        {{csrf_field()}}
     <script type="text/javascript">

          $("#to_date").datepicker({
                autoclose: true,
                format: 'dd/mm/yyyy',
                todayHighlight: true
                }).on('change', function (e) {
                //$('#road_form').bootstrapValidator('revalidateField', 'to_date');
                var from_date = $('#from_date').val();
                var to_date = $('#to_date').val();
                if (from_date != '' && from_date > to_date) {
                  $.alert({
                    type: 'red',
                    icon: 'fa fa-warning',
                    title: 'Error!!',
                    content: '<strong>ERROR:</strong> To Date Should be Greater than From Date .'
                  });
                  $('#to_date').val('');
                }

                });
                $("#from_date").datepicker({

                autoclose: true,
                format: 'dd/mm/yyyy',
                todayHighlight: true
                }).on('change', function (e) {
                //$('#road_form').bootstrapValidator('revalidateField', 'from_date');
                var from_date = $('#from_date').val();
                var to_date = $('#to_date').val();
                if (to_date != '' && from_date > to_date) { //alert('by');
                  $.alert({
                    type: 'red',
                    icon: 'fa fa-warning',
                    title: 'Error!!',
                    content: '<strong>ERROR:</strong>From date Should be Less than To Date'
                  });
                  $('#from_date').val('');
                }
                });
         
         $(function () { 
             get_all_employee();
             get_all_designation();
             get_all_department();
             attendance_report_detaiis();

        });

         $("#search").click(function(){
            attendance_report_detaiis();
         });

         function get_all_employee(){

              var token = $("input[name='_token']").val();
                $.ajax({
                  type: "post",
                  url: "get_all_employee",
                  async:false,
                  data:{_token:token},
                  dataType: 'json',
                  success: function (data) {
                  
                    $('#employee').html('<option value=""> Select Employee </option>');
                    $.each(data.options, function (key, value) {
                    
                        $("#employee").append('<option value=' + key + '>' + value + '</option>');
                      
                    });

                  }
                });



         }

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

          function  get_all_department(){

            var token = $("input[name='_token']").val();
            $.ajax({
              type: "post",
              url: "get_all_department",
              async:false,
              data:{_token:token},
              dataType: 'json',
              success: function (data) {
              
                $('#department').html('<option value=""> Select Department </option>');
                $.each(data.options, function (key, value) {
                
                    $("#department").append('<option value=' + key + '>' + value + '</option>');
                  
                });
              }

            });
         }


         function attendance_report_detaiis(){

            var employee=$("#employee").val();
            var department=$("#department").val();
            var designation=$("#designation").val();
            var from_date=$("#from_date").val();
            var to_date=$("#to_date").val();
             
            $("#tbl_attendance_report").dataTable().fnDestroy();
                $('#tbl_attendance_report').dataTable({

                  "processing": true,
                  "serverSide": true,
                  "ajax": {
                url: "list_attendance_report",
                type: "post",
                data: {employee:employee,department:department,designation:designation,from_date:from_date,to_date:to_date,'_token': $('input[name="_token"]').val()},
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
                            "data": "emp_name",
                            
                        },
                         {
                            "targets": 2,
                            "data": "emp_id",
                            
                        },
                        {
                            "targets": 3,
                            "data": "department",
                            
                        },
                        {
                            "targets": 4,
                            "data": "designation",
                            
                        },
                         {
                            "targets": 5,
                            "data": "current_att_date",
                            
                        },
                         {
                            "targets": 6,
                            "data": "in_date_time",
                            
                        },
                        {
                            "targets": 7,
                            "data": "out_date_time",
                            
                        },
                        {
                            "targets": 8,
                            "data": "att_status",
                            
                        },
                        {
                            "targets": 9,
                            "data": "working_time",
                            
                        },
                       
                        {
                            "targets": -1,
                            "data": 'action',
                            "searchable": false,
                            "sortable": false,
                            "render": function (data, type, full, meta) {
                                var str_btns = "";

                                if(data.location_status == 1){
                                
                                str_btns+='<button type="submit" data-toggle="tooltip"  style="margin-left: 1px" class="btn btn-warning btn-sm Small map_button" id="' +data.e+ '" title="Location of IN OUT Time"><i class="fa fa-map-marker" aria-hidden="true"></i> </button> &nbsp;';
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

     



    var table = $('#tbl_attendance_report').DataTable();
        table.on('draw.dt', function () {

        $('.map_button').click(function () {
          var att_code = this.id;

          //alert(road_challan_code);  
              $.ajax({
                  type: 'post',
                          url: 'get_att_lat_lang',
                          data: {'att_code': att_code, '_token': $('input[name="_token"]').val()},
                          dataType: 'json',
                          success: function (data) {
                           // alert(data.result.att_lat);

                           //   function initMap() {
                    
                           //  var uluru = {lat: parseFloat(data.result.att_lat), lng: parseFloat(data.result.att_long)};
                           //  // The map, centered at Uluru
                           //  var map = new google.maps.Map(
                           //      document.getElementById('mappp'), {zoom: 9, center: uluru});
                           //  // The marker, positioned at Uluru
                           //  var marker = new google.maps.Marker({position: uluru, map: map});
                           //   }

                           // initMap();
                           $("#map_modal").modal('show');



                                           
                      }
                  });
          });

            
           
     });

     </script>
     <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBiSsU-Ku9aQ0iDESdtpV_isjMs8HHDcEI&callback=initMap">
    </script>


                      
  
@stop