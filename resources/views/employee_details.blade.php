<?php $title = 'Employee'; ?>
@extends('layouts.master')
@section('content')
   <div class="top-bar">
         <div class="-intro-x breadcrumb mr-auto hidden sm:flex">
            <a href="">Application</a>
            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="breadcrumb__icon feather feather-chevron-right">
               <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
            <a href="" class="breadcrumb--active">Employee</a>
         </div>
          <div class="intro-x relative mr-3 sm:mr-6">
        <a href="add_employee"><button type="button" class="btn btn-info">
         <span class="glyphicon glyphicon-search"></span>Add Employee
        </button></a>
      
        
     </div>
        
    </div>

        <div class=" mt-8 card shadow-lg p-3  bg-white rounded h-75">
           <div class=" items-center h-20">
              <h1 class="text-lg font-medium truncate mr-5"> List of Employee</h1>
            </div>

            <div class="card-body" style="background-color: white ;" >


            <div class="datatbl table-responsive">
                <table class="table table-striped table-bordered table-hover notice-types-table" id="tbl_employee">
                    <thead class="text-center">
                        <tr>
                            <th style="width: 3%;">SL#</th>
                            <th style="width: 12%;">Name</th>
                            <th style="width: 10%;">Mobile No</th>
                            <th style="width: 10%;">Type</th>
                            <th style="width: 10%;">Designation</th>
                            <th style="width: 10%;">Department</th>
                            <th style="width: 25%;">Address</th>
                            <th style="width: 20%;">ACTIONS</th>
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
             employee_details();
        });

         function employee_details(){
             
            $("#tbl_employee").dataTable().fnDestroy();
                $('#tbl_employee').dataTable({

                  "processing": true,
                  "serverSide": true,
                  "ajax": {
                url: "list_employee",
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
                            "data": "phno",
                            
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
                            "data": "department",
                            
                        },
                        {
                            "targets": 6,
                            "data": "c_address",
                            
                        },
                       
                        {
                            "targets": -1,
                            "data": 'action',
                            "searchable": false,
                            "sortable": false,
                            "render": function (data, type, full, meta) {
                                var str_btns = "";
                                str_btns+= '<button type="submit" data-toggle="tooltip" style="margin-left: 1px" class="btn btn-primary btn-sm Small view_button" id="' + data.d + '" title="View"><i class="fa fa-eye"></i> </button> &nbsp;';
                                str_btns+='<button type="submit" data-toggle="tooltip"  style="margin-left: 1px" class="btn btn-warning btn-sm Small edit_data" id="' +data.e+ '" title="Edit"><i class="fa fa-edit"></i> </button> &nbsp;';
                                 str_btns+= '<button type="submit" data-toggle="tooltip" style="margin-left: 1px" class="btn btn-danger btn-sm Small delete-button" id="' + data.d + '" title="Delete"><i class="fa fa-trash"></i> </button>';

                                return str_btns;
                            }
                        }
                      

                        ],
                        "order": [[1, 'asc']]


         });



}

    var table = $('#tbl_employee').DataTable();
        table.on('draw.dt', function () {
            
            $('.edit_data').click(function () {
                var employee_code = this.id;
                var datas = {'employee_code': employee_code, '_token': $('input[name="_token"]').val()};
                redirectPost('{{url("employee_edit")}}', datas);
            });
             $('.delete-button').click(function () {

                var reply = confirm('Are you sure to delete the record?');
                if (!reply) {
                    return false;
                }
                var dlt_code = this.id;
                $.ajax({
                    type: 'post',
                    url: 'employee_delete',
                    data: {'dlt_code': dlt_code, '_token': $('input[name="_token"]').val()},
                    dataType: 'json',
                    success: function (datam) {
 
                        if (datam.status == 1) {
                             employee_details();
                            $.alert({
                                type: 'green',
                                icon: 'fa fa-check',
                                title: 'Success!!',
                                content: '<strong>SUCCESS:</strong> Employee Deleted Successfully.'
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
                   
                });

            });

        $(".view_button").click(function() {
            var code = this.id;
            $.ajax({
                url: "view_employee_details",
                method: 'post',
                data: {
                    'code': code,
                    '_token': '{{csrf_token()}}',
                },
                success: function(data) {
                  // alert(data.p_date);
                    var str = "";
                     str += "<h5> Personal Details </h5>";
                    str += "<table class='table table-border'>";
                    str += "<tr class='covid_view'><td class='covid_view'>Employee Name</td><td>" + data.emp_name + "</td></tr>"
                    str += "<tr class='covid_view'><td class='covid_view'>Father's Name</td><td>" + data.father_name + "</td></tr>"
                    str += "<tr class='covid_view'><td class='covid_view'>Mother's Name</td><td>" + data.mother_name + "</td></tr>"
                    str += "<tr class='covid_view'><td class='covid_view'>Gender</td><td>" + data.gender + "</td></tr>"
                    str += "<tr class='covid_view'><td class='covid_view'>Date of Birth</td><td>" + data.dob + "</td></tr>"

                    str += "<tr class='covid_view'><td class='covid_view'>Blood Group</td><td>" + data.blood_group + "</td></tr>"

                    str += "<tr class='covid_view'><td class='covid_view'>Merital Status</td><td>" + data.marital_status + "</td></tr>"
                    if(data.spouse_name != null){

                        str += "<tr class='covid_view'><td class='covid_view'>Spouse Name</td><td>" + data.spouse_name + "</td></tr>"
                    }
                    if(data.noofchildren != null){

                      str += "<tr class='covid_view'><td class='covid_view'>No of Children</td><td>" + data.noofchildren + "</td></tr>"
                    }
                    str += "</table>";

                    str += "<h5> Contact Details </h5>";
                    str += "<table class='table table-border'>";
                     var t1= data.phno != null ? data.phno :' ';
                     str += "<tr class='covid_view'><td class='covid_view'>Mobile Number</td><td>" + t1 + "</td></tr>"
                     var t2= data.email != null ? data.email :' ';
                     str += "<tr class='covid_view'><td class='covid_view'>Email ID</td><td>" + t2 + "</td></tr>"
                     var t3= data.p_state != null ? data.p_state :' ';
                     str += "<tr class='covid_view'><td class='covid_view'>Permanent State</td><td>" + t3 + "</td></tr>"
                     var t4= data.p_dist != null ? data.p_dist :' ';
                     str += "<tr class='covid_view'><td class='covid_view'>Permanent District</td><td>" + t4 + "</td></tr>"
                     var t5= data.p_address != null ? data.p_address :' ';
                     str += "<tr class='covid_view'><td class='covid_view'>Permanent Addtrss</td><td>" + t5 + "</td></tr>"
                     var t6= data.p_pin != null ? data.p_pin :' ';
                     str += "<tr class='covid_view'><td class='covid_view'>Permanent Pin</td><td>" + t6 + "</td></tr>"
                      var t7= data.contact_person != null ? data.contact_person :' ';
                     str += "<tr class='covid_view'><td class='covid_view'>Contact Person</td><td>" + t7 + "</td></tr>"
                      var t8= data.relationship != null ? data.relationship :' ';
                     str += "<tr class='covid_view'><td class='covid_view'>Relationship with Contact Person</td><td>" + t8 + "</td></tr>"
                      var t9= data.emg_address != null ? data.emg_address :' ';
                     str += "<tr class='covid_view'><td class='covid_view'>Emergency Address</td><td>" + t9 + "</td></tr>"
                      var t10= data.emg_phno != null ? data.emg_phno :' ';
                     str += "<tr class='covid_view'><td class='covid_view'>Emergency Mobile Number</td><td>" + t10 + "</td></tr>"



                    str += "</table>";

                    str += "<h5> Working/Joining Details </h5>";
                    str += "<table class='table table-border'>";
                     var t11= data.emp_type != null ? data.emp_type :' ';
                     if(t11 == 1){
                         t11="Supervisor";
                     }else if(t11 == 2){
                        t11="Worker";
                     }
                     str += "<tr class='covid_view'><td class='covid_view'>Type</td><td>" + t11 + "</td></tr>"
                     var t12= data.designation != null ? data.designation :' ';
                     str += "<tr class='covid_view'><td class='covid_view'>Designation</td><td>" + t12 + "</td></tr>"
                     var t13= data.department != null ? data.department :' ';
                     str += "<tr class='covid_view'><td class='covid_view'>Department</td><td>" + t13 + "</td></tr>"
                     var t14= data.joining_date != null ? data.joining_date :' ';
                     str += "<tr class='covid_view'><td class='covid_view'>Joining Date</td><td>" + t14 + "</td></tr>"
                     var t15= data.salary_per_day != null ? data.salary_per_day :' ';
                     str += "<tr class='covid_view'><td class='covid_view'>Salary Per Day</td><td>" + t15 + "</td></tr>"

                    str += "</table>";
                    //var t1= data.case_state != null ? data.case_state :' ';
                  //  str += "<tr class='covid_view'><td class='covid_view'>Email</td><td>" + t1 + "</td></tr>"

                   // var t2= data.case_district != null ? data.case_district :' ';
                  //  str +="<tr class='covid_view'><td class='covid_view'>Case District</td><td>"+ t2 +"</td></tr>"

                    // if(data.case_district != null){
                    //     str += "<tr class='covid_view'><td class='covid_view'>Case District</td><td>" + data.case_district+ "</td></tr>"
                    // }else{
                    //     str += "<tr class='covid_view'><td class='covid_view'>Case District</td><td> </td></tr>"
                    // }
 
                    
                   
                    $.confirm({
                                    title: 'Employee Details',
                                    type: 'blue',
                                    content: str,
                                    boxHeight: '100%',
                                    boxWidth: '50%',
                                    useBootstrap: false,
                                    buttons:{
                                        OK:function(){

                                             }
                                    }


                                });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    var msg = "";
                    if (jqXHR.status !== 422 && jqXHR.status !== 400) {
                        msg += "<strong>" + jqXHR.status + ": " + errorThrown + "</strong>";
                    } else {
                        if (jqXHR.responseJSON.hasOwnProperty('exception')) {
                            if (jqXHR.responseJSON.exception_code == 23000) {
                                msg += "Some Sql Exception Occured";
                            } else {
                                msg += "Exception: <strong>" + jqXHR.responseJSON.exception_message + "</strong>";
                            }
                        } else {
                            msg += "Error(s):<strong><ul>";
                            $.each(jqXHR.responseJSON['errors'], function(key, value) {
                                msg += "<li>" + value + "</li>";
                            });
                            msg += "</ul></strong>";
                        }
                        $.alert({
                            title: 'Error!!',
                            type: 'red',
                            icon: 'fa fa-warning',
                            content: msg,
                        });
                    }

                },
            });
        });

     });

     </script>


                      
  
@stop