<?php $title = 'Department'; ?>
@extends('layouts.master')
@section('content')
   <div class="top-bar">
         <div class="-intro-x breadcrumb mr-auto hidden sm:flex">
            <a href="">Application</a>
            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="breadcrumb__icon feather feather-chevron-right">
               <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
            <a href="" class="breadcrumb--active">Leave Assign</a>
         </div>
          <div class="intro-x relative mr-3 sm:mr-6">
        <a href="leave_assign"><button type="button" class="btn btn-info">
         <span class="glyphicon glyphicon-search"></span>Leave Assign
        </button></a>
      
        
     </div>
        
    </div>

        <div class=" mt-8 card shadow-lg p-3  bg-white rounded h-75">
           <div class=" items-center h-20">
              <h1 class="text-lg font-medium truncate mr-5"> List of Leave Assign</h1>
            </div>

            <div class="card-body" style="background-color: white ;" >


            <div class="datatbl table-responsive">
                <table class="table table-striped table-bordered table-hover notice-types-table" id="tbl_leave_assign">
                    <thead class="text-center">
                        <tr>
                            <th style="width: 10%;">SL#</th>
                            <th style="width: 50;">Designation</th>
                            <th style="width: 30%;">Year</th>
                            <th style="width: 10%;">Actions</th>
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
         $(function (){
            leave_assign_details();
         });
         function leave_assign_details(){
            $("#tbl_leave_assign").dataTable().fnDestroy();
            $("#tbl_leave_assign").dataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    type: "post",
                    url: "list_of_leave_assign",
                    data: {'_token': $('input[name="_token"]').val()},
                    dataSrc: "record_details",
                },
                "dataType": 'json',
                "columnDefs": [
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
                        "data": "designation",

                    },
                    {
                        "targets": 2,
                        "data": "year",

                    },
                    {
                        "targets": 3,
                        "data": "action",
                        "searchable": false,
                        "sortable": false,
                        "render": function (data, type, full, meta) {
                                var str_btns = "";
                                
                                str_btns+='<button type="submit" data-toggle="tooltip"  style="margin-left: 1px;" class="btn btn-primary btn-sm Small view_data" id="' +data.v+ '" title="View"><i class="fa fa-users"></i> </button> &nbsp;';

                                return str_btns;
                            }
                    }
                ],
                "order": [[1, 'asc']]
            });
         }

         var table = $("#tbl_leave_assign").DataTable();
         table.on('draw.dt', function() {
            $(".view_data").click(function() {
                // alert("hi");
                var leave_assign_cd = this.id;
                // alert(leave_assign_cd);
                var token = $("input[name='_token']").val();
                // alert(token);
                $.ajax({
                    type: "post",
                    url: "get_designation_wise_leave",
                    data: {_token: token, leave_assign_cd: leave_assign_cd},
                    dataType: 'json',
                    success: function(data) {
                        var i=0;
                        var tbl = '<table id="designation_wise_leave" class="table table-striped table-bordered table-hover notice-types-table">';
                        tbl+= '<thead>';
                        tbl+= '<tr>';
                        tbl+= '<th> SL# </th>';
                        tbl+= '<th> Type Of Leave </th>';
                        tbl+= '<th> No. Of Leave </th>';

                        tbl+= '</tr>';
                        tbl+= '</thead>';
                      
                        $.each(data.options, function(key, value) {
                            i = i + 1;
                            tbl+= '<tbody>';
                            tbl+= '<tr>';
                            tbl+= '<td> ' + i + ' </td>';

                            tbl+= '<td> ' + value.type_of_leave + ' </td>';
                            tbl+= '<td> ' + value.no_of_leave + ' </td>';
                            tbl+= '</tr>';

                            tbl+= '</tbody>';
                        });
                        tbl+= '</table>';
                        $.confirm({
                            title: 'Designation Wise Leave',
                            type: 'blue',
                            content: tbl,
                            boxHeight: '100%',
                            boxWidth: '50%',
                            useBootstrap: false,
                            buttons:{
                                Ok: function(){

                                }
                            }
                        });
                    }
                });
            });
         });

     </script>


                      
  
@stop