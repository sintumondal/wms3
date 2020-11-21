<?php $title = 'User'; ?>
@extends('layouts.master')
@section('content')
   <div class="top-bar">
         <div class="-intro-x breadcrumb mr-auto hidden sm:flex">
            <a href="">Application</a>
            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="breadcrumb__icon feather feather-chevron-right">
               <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
            <a href="" class="breadcrumb--active">User</a>
         </div>
          <div class="intro-x relative mr-3 sm:mr-6">
        <a href="add_user"><button type="button" class="btn btn-info">
         <span class="glyphicon glyphicon-search"></span>Add User
        </button></a>
      
        
     </div>
        
    </div>

        <div class=" mt-8 card shadow-lg p-3  bg-white rounded h-75">
           <div class=" items-center h-20">
              <h1 class="text-lg font-medium truncate mr-5"> List of User</h1>
            </div>

            <div class="card-body" style="background-color: white ;" >


            <div class="datatbl table-responsive">
                <table class="table table-striped table-bordered table-hover notice-types-table" id="tbl_user">
                    <thead class="text-center">
                        <tr>
                            <th style="width: 5%;">SL#</th>
                            <th style="width: 17%;">Name</th>
                            <th style="width: 18%;">Employee Name</th>
                            <th style="width: 15%;">Type</th>
                            <th style="width: 15%;">Designation</th>
                            <th style="width: 15%;">Mobile Number</th>
                            <th style="width: 15%;">Action</th>
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
             user_details();
        });

         function user_details(){
             
            $("#tbl_user").dataTable().fnDestroy();
                $('#tbl_user').dataTable({

                  "processing": true,
                  "serverSide": true,
                  "ajax": {
                url: "list_user",
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
                            "data": "name",
                            
                        },
                        {
                            "targets": 2,
                            "data": "emp_name",
                            
                        },
                        {
                            "targets": 3,
                            "data": "emp_type",
                            
                        },
                        {
                            "targets": 4,
                            "data": "designation",
                            
                        },
                        {
                            "targets": 5,
                            "data": "mobile_no",
                            
                        },
                        
                       
                        {
                            "targets": -1,
                            "data": 'action',
                            "searchable": false,
                            "sortable": false,
                            "render": function (data, type, full, meta) {
                                var str_btns = "";
                                
                                str_btns+='<button type="submit" data-toggle="tooltip"  style="margin-left: 1px" class="btn btn-warning btn-sm Small edit_data" id="' +data.e+ '" title="Edit"><i class="fa fa-edit"></i> </button> &nbsp;';
                                   if(data.status == 1){
                                     str_btns += '<button type="button" class="btn_action btn btn-success active_deactive_user "id="' + data.d + '" title="Click To Deactivate User" status="1"><i class="fa fa-toggle-on"></i></button>';
   
                                   }else{
                                    str_btns += '<button type="button" class="btn_action btn btn-danger active_deactive_user "id="' + data.d + '" title="Click To Activate User" status="0"><i class="fa fa-toggle-off"></i></button>'; 


                                   }

                                return str_btns;
                            }
                        }
                      

                        ],
                        "order": [[1, 'asc']]


         });



}

    var table = $('#tbl_user').DataTable();
        table.on('draw.dt', function () {
            
            $('.edit_data').click(function () {
                var user_code = this.id;
                var datas = {'user_code': user_code, '_token': $('input[name="_token"]').val()};
                redirectPost('{{url("user_edit")}}', datas);
            });
             $('.active_deactive_user').click(function () {

                var reply = confirm('Are you sure to change the Status?');
                if (!reply) {
                    return false;
                }
                var user_code = this.id;
               var status= $(".active_deactive_user").attr("status");
                $.ajax({
                    type: 'post',
                    url: 'active_deactive_user',
                    data: {'user_code': user_code, 'status': status, '_token': $('input[name="_token"]').val()},
                    dataType: 'json',
                    success: function (datam) {
                           user_details();
                        if (datam.status == 1) {
                            
                            $.alert({
                                type: 'green',
                                icon: 'fa fa-check',
                                title: 'Success!!',
                                content: '<strong>SUCCESS:</strong> User Deactivate Successfully.'
                            });
                        } else {
                            $.alert({
                                type: 'green',
                                icon: 'fa fa-check',
                                title: 'Success!!',
                                content: '<strong>SUCCESS:</strong> User Activate Successfully.'
                            });
                        }
                    }
                });

            });

     });

     </script>


                      
  
@stop