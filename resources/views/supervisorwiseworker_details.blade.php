<?php $title = 'Supervisor Wise Worker'; ?>
@extends('layouts.master')
@section('content')
   <div class="top-bar">
         <div class="-intro-x breadcrumb mr-auto hidden sm:flex">
            <a href="">Application</a>
            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="breadcrumb__icon feather feather-chevron-right">
               <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
            <a href="" class="breadcrumb--active">Supervisor Wise Worker</a>
         </div>
          <div class="intro-x relative mr-3 sm:mr-6">
        <a href="add_supervisor_wise_worker"><button type="button" class="btn btn-info">
         <span class="glyphicon glyphicon-search"></span>Add Supervisor Wise Worker
        </button></a>
      
        
     </div>
        
    </div>

        <div class=" mt-8 card shadow-lg p-3  bg-white rounded h-75">
           <div class=" items-center h-20">
              <h1 class="text-lg font-medium truncate mr-5"> List of Supervisor Wise Worker</h1>
            </div>

            <div class="card-body" style="background-color: white ;" >


            <div class="datatbl table-responsive">
                <table class="table table-striped table-bordered table-hover notice-types-table" id="tbl_supervisor_wise_worker">
                    <thead class="text-center">
                        <tr>
                            <th style="width: 10%;">SL#</th>
                            <th style="width: 50%;">Supervisor</th>
                            <th style="width: 15%;">No of Worker</th>
                            <th style="width: 20%;">Action</th>
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
             supervisorwiseworker_details();
        });

         function supervisorwiseworker_details(){
             
            $("#tbl_supervisor_wise_worker").dataTable().fnDestroy();
                $('#tbl_supervisor_wise_worker').dataTable({

                  "processing": true,
                  "serverSide": true,
                  "ajax": {
                url: "list_supervisorwiseworker",
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
                            "data": "emp_name",
                            
                        },
                        {
                            "targets": 2,
                            "data": "count_u",
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
                                str_btns+='<button type="submit" data-toggle="tooltip"  style="margin-left: 1px" class="btn btn-primary btn-sm Small view_data" id="' +data.e+ '" title="View Worker"><i class="fa fa-users"></i> </button> &nbsp;';
                                 str_btns+= '<button type="submit" data-toggle="tooltip" style="margin-left: 1px" class="btn btn-danger btn-sm Small delete-button" id="' + data.d + '" title="Delete"><i class="fa fa-trash"></i> </button';

                                return str_btns;
                            }
                        }
                      

                        ],
                        "order": [[1, 'asc']]


         });



}

    var table = $('#tbl_supervisor_wise_worker').DataTable();
        table.on('draw.dt', function () {

             $('.delete-button').click(function () {

                var reply = confirm('Are you sure to delete the record?');
                if (!reply) {
                    return false;
                }
                var dlt_code = this.id;
                $.ajax({
                    type: 'post',
                    url: 'supervisorwiseworker_delete',
                    data: {'dlt_code': dlt_code, '_token': $('input[name="_token"]').val()},
                    dataType: 'json',
                    success: function (datam) {
 
                        if (datam.status == 1) {
                            supervisorwiseworker_details();
                            $.alert({
                                type: 'green',
                                icon: 'fa fa-check',
                                title: 'Success!!',
                                content: '<strong>SUCCESS:</strong> Supervisor Wise Worker Deleted Successfully.'
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

             $('.view_data').click(function () {
                 var supervisor_code = this.id;
                 var token = $("input[name='_token']").val();
                    $.ajax({
                      type: "post",
                      url: "get_supervisor_wise_worker",
                      data:{_token:token,supervisor_code:supervisor_code},
                      dataType: 'json',
                      success: function (data) {
                         var i=0;

                        var tbl= '<table id="worker_details" class="table table-striped table-bordered table-hover notice-types-table"  >';
                           tbl+='<thead >';
                           tbl+='<tr>';
                           tbl+='<th style="width: 10%;">SL#</th>';
                           tbl+='<th style="width: 45%;">Worker Name</th>';
                           tbl+='<th style="width: 45%;">Mobile Number</th>';
                           tbl+='</tr>';
                           tbl+='</thead>';

                            $.each(data.options,function(key,value){
                                 i=i+1;
                                tbl+='<tbody>';
                                tbl+='<tr>';
                                tbl+='<td>'+i+'</td>';
                                tbl+='<td>' + value.emp_name + '</td>';
                                tbl+='<td>' + value.phno + '</td>';
                                tbl+='</tr>';
                                tbl+='</tbody>';

                               
                                });
                            tbl+='</table>';
                   
                    
                   
                    $.confirm({
                            title: 'Worker List',
                            type: 'blue',
                            content: tbl,
                            boxHeight: '100%',
                            boxWidth: '50%',
                            useBootstrap: false,
                            buttons:{
                                OK:function(){

                                     }
                            }


                        });
              
                       
                      }

                    });
            });



     });

     </script>


                      
  
@stop