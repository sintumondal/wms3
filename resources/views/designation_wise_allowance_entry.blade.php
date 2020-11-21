<?php $title = 'Designation Wise Allowance'; ?>
@extends('layouts.master')
@section('content')
   <div class="top-bar">
         <div class="-intro-x breadcrumb mr-auto hidden sm:flex">
            <a href="">Application</a>
            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="breadcrumb__icon feather feather-chevron-right">
               <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
            <a href="" class="breadcrumb--active">Designation Wise Allowance</a>
         </div>
         <div class="intro-x relative mr-3 sm:mr-6">
        <a href="dsignation_wise_allowance_details"><button type="button" class="btn btn-info">
         <span class="glyphicon glyphicon-search"></span> List of Designation Wise Allowance 
        </button></a>
     </div>
    </div>

        <div class=" mt-8 card shadow-lg p-3  bg-white rounded h-75">
           <div class=" items-center h-20">
              <h1 class="text-lg font-medium truncate mr-5"><span id="add_update"> Add </span> Designation Wise Allowance</h1>
            </div>

            <div class="card-body" style="background-color: white ;" >
                 {!! Form::open(['url' => '', 'name' => 'designationwiseallowance_form', 'id' => 'designationwiseallowance_form', 'method' => 'post' ,'class'=>'animate-form form-horizontal','role'=>'form']) !!}
                 {!! Form::hidden('code', '',['id'=>'edit_code']) !!}
                                
                <div class="row form-group">
                    <div class="col-sm-4 text-right font-weight-bold" style="font-size: 20Px;">
                        {!! Form::label('designation', ' Designation:', ['class' =>'required']) !!}
                    </div>   
                    <div class="col-sm-6">
                        {!! Form::select('designation',[''=>'Select Designation'],null,['class' => 'form-control','id'=>'designation']); !!}
                    </div>
                    
                </div>
                
              
                {!! Form::hidden('allowanceNameArr', '',['id'=>'allowanceNameArr']) !!}
               
                <div class="row">
                 <div class="col-sm-4 text-right font-weight-bold" style="font-size: 20Px;">
                        
                    </div>   
                    <div class="col-sm-6">
                      <div id="message_insert"></div>  
                <table class="table table-bordered table-striped table-responsive table-hover" id="allowance_add_tbl" style="border-top:#1adab5 solid ;">
                    <thead >
                        <tr>
                            <th style="width: 500px;">Allowance</th>
                            <th style="width: 100px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td> {!! Form::select('allowance',[''=>'Select Allowance'],null,['class' => 'form-control','id'=>'allowance']); !!}</td>
                            
                            <td><button type="button" class="btn btn-success add-row"><i class="fa fa-plus"></i></button></td>
                        </tr>
                    </tbody>
                </table>
                </div>
                </div>

                <div class="row form-group">
                    <div class="col-sm-12" style="text-align: center;">
                        <button id="save_update" type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
               
                   {!! Form::close() !!}             
             
            </div>
        
     </div>


     <script type="text/javascript">
          var ttt=[];

        


         $(function () { 

            get_all_designation();
            get_all_allowance();


                 $('#designationwiseallowance_form').bootstrapValidator({
                    message: 'This value is not valid',
                    feedbackIcons: {
                        
                    },

                    fields: {
                        designation: {
                            validators: {
                                notEmpty: {
                                    message: 'Designation is Required'
                                }
                            }
                        }    

                    }
                }).on('success.form.bv', function (e) {
                    e.preventDefault();
                    if (typeof ttt != 'undefined' && ttt.length > 0) {
                            save_designationwiseallowance();
                        
                    }
                    else{
                            $.confirm({
                                title: 'Unsuccess!',
                                type: 'red',
                                icon: 'fa fa-warning',
                                content: "Please Enter Atleast one Allowance",
                                buttons: {
                                    ok: function () {
                                        
                                                                                
                                    }

                                   }
                            });
                         }               
                });   

        });

         function save_designationwiseallowance(){
                var token = $("input[name='_token']").val();
                var designation = $("#designation").val();
                var allowanceNameArrayJson = JSON.stringify(ttt);
               // alert(workerNameArrayJson);
                var fd = new FormData();
                fd.append('allowanceNameArrayJson', allowanceNameArrayJson);
                fd.append('designation', designation);
                fd.append('_token', token);

                        $.ajax({
                        url: "save_designationwiseallowance",
                        type: "POST",
                        data: fd,
                        processData: false,
                        contentType: false,
                        dataType: 'json',

                        success: function(response) {
                          if (response.status == 1) {
                            $("#empNameArr").focus();
                            Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            html: response.msg,
                            footer: ''
                            })
                            .then((result) => {
                            if (result.value) {
                          location.reload();
                            }
                            });
                          }

                         else if(response.status == 0) {
                            Swal.fire({
                            icon: 'Warning',
                            title: 'Attention',
                            html: 'This Designation is Already Exist',
                            footer: ''
                            })
                            .then((result) => {
                            if (result.value) {
                          location.reload();
                            }
                            });
                          }
                         
                          else{
                            Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            html: response.msg,
                            footer: ''
                          });
                          }

                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            $('.buttonSave').removeAttr('disabled');
                          var msg = "";
                          if (jqXHR.status !== 422 && jqXHR.status !== 400) {
                          msg += "<strong>" + jqXHR.status + ": " + errorThrown + "</strong>";
                          } else {
                            if (jqXHR.responseJSON.hasOwnProperty('exception')) {
                              msg += "Exception: <strong>" + jqXHR.responseJSON.exception_message + "</strong>";
                            } else {
                              msg += "Error(s):<strong><ul>";
                              var count = 0;
                              $.each(jqXHR.responseJSON['errors'], function(key, value) {
                                count++;
                                msg += "<li>" + value + "</li>";
                              });
                              msg += "</ul></strong>";
                            }
                          }
                          Swal.fire({
                            icon: 'error',
                            title: '',
                            html: msg,
                            footer: ''
                          });
                        }
                      });
            }

             $(".add-row").click(function () {

                if ($('#allowance').val() == '')
                {
                    $('#message_insert').html('<span style="color:red;">&#10060 Select Allowance</span>');
                    return false;
                } else {
                   
                    var allowance = $("#allowance").val();
                    $('#message_insert').html('');
                }

                if (jQuery.inArray(allowance, ttt) !== -1) {
                    $("#sub_head").val('');
                    $('#message_insert').html('<span style="color:red;">&#10060 This Allowance is Already Selected</span>');
                    return false;
                } else {
                    $('#message_insert').html("");
                }

                 var token = $("input[name='_token']").val();
                    $.ajax({
                      type: "post",
                      url: "get_allowance_name",
                      data:{_token:token,allowance:allowance},
                      dataType: 'json',
                      success: function (data) {


                    var markup ="<tr><td><input type='text' class='form-control' name='allowance' value='" + data.options.name_of_allowance + "' readonly='readonly' style='background-color:white;'></td>";
                        
                        markup +="<td><a href='javascript:' onclick='deleteRow(this);' class='btn  btn-danger'><i class='fa fa-trash'><i></a></td></tr>";
                    $("#allowance_add_tbl").append(markup);
                    ttt.push(allowance);
                    $("#allowanceNameArr").val(ttt);
                    $("#allowance").val('');
                    $("#allowance").focus();
                          
                
                      }

                  });



                });


             

        function deleteRow(row){
            var i = row.parentNode.parentNode.rowIndex;
            document.getElementById('allowance_add_tbl').deleteRow(i);
            var index_arr = parseInt(i) - parseInt(2);
            ttt.splice(index_arr, 1);
            $("#allowanceNameArr").val(ttt);
           

           }

         function get_all_designation(){

             var token = $("input[name='_token']").val();
            $.ajax({
              type: "post",
              url: "get_all_designation",
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

          function get_all_allowance(){

             var token = $("input[name='_token']").val();
            $.ajax({
              type: "post",
              url: "get_all_allowance",
              data:{_token:token},
              dataType: 'json',
              success: function (data) {
              
                $('#allowance').html('<option value=""> Select Allowance </option>');
                $.each(data.options, function (key, value) {
                
                    $("#allowance").append('<option value=' + key + '>' + value + '</option>');
                  
                });

              }

            });

         }

       // function  save_department(){

       //       var token = $("input[name='_token']").val();
       //       var department_name = $("#department_name").val();
       //       var editcd = $("#edit_code").val();

       //       var formData_save = new FormData();
       //          formData_save.append('_token', token);
       //          formData_save.append('department_name', department_name);
       //          formData_save.append('editcd', editcd);
           
       //      $(".se-pre-con").fadeIn("slow");
       //          $.ajax({
       //              type: "POST",
       //              url: "department_save_update",
       //              data: formData_save,
       //              processData: false,
       //              contentType: false,
       //              dataType: "json",
       //               success: function (data) {

       //                   if (data.status == 1) {
                    
       //                  var msg = "<strong>SUCCESS: </strong>Department Saved Successfully";

       //                  $.confirm({
       //                  title: 'Success!',
       //                  type: 'green',
       //                  icon: 'fa fa-check',
       //                  content: msg,
       //                  buttons: {
       //                      ok: function () {
                                
       //                          $('#department_form').get(0).reset();
       //                           location.reload();
                                
       //                      }

       //                  }
       //              });
                        
       //              }
       //              else if(data.status == 2)
       //              {
       //                   var msg = "<strong>SUCCESS: </strong>Department Updated Successfully";

       //                  $.confirm({
       //                  title: 'Success!',
       //                  type: 'green',
       //                  icon: 'fa fa-check',
       //                  content: msg,
       //                  buttons: {
       //                      ok: function () {
                              
       //                           window.location.href = "department_details";
       //                      }

       //                  }
       //              });

       //              }else{

       //                  $.confirm({
       //                      title: 'Unsuccess!',
       //                      type: 'red',
       //                      icon: 'fa fa-warning',
       //                      content: "Something Went Wrong",
                           
       //                  });


       //              }
                     
                    


       //              },
       //              error: function (jqXHR, textStatus, errorThrown) {
       //                  $(".se-pre-con").fadeOut("slow");
       //                  var msg = "";
       //                  if (jqXHR.status !== 422 && jqXHR.status !== 400) {
       //                      msg += "<strong>" + jqXHR.status + ": " + errorThrown + "</strong>";
       //                  } else {
       //                      if (jqXHR.responseJSON.hasOwnProperty('exception')) {
       //                          msg += "Exception: <strong>" + jqXHR.responseJSON.exception_message + "</strong>";
       //                      } else {
       //                          msg += "Error(s):<strong><ul>";
       //                          $.each(jqXHR.responseJSON['errors'], function (key, value) {
       //                              msg += "<li>" + value + "</li>";
       //                          });
       //                          msg += "</ul></strong>";
       //                      }
       //                  }
       //                  $.alert({
       //                      title: 'Error!!',
       //                      type: 'red',
       //                      icon: 'fa fa-warning',
       //                      content: msg,
       //                  });
       //              }
       //          });

       //   }
     </script>


                      
  
@stop