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
        <a href="user_details"><button type="button" class="btn btn-info">
         <span class="glyphicon glyphicon-search"></span> List of User 
        </button></a>
     </div>
    </div>

        <div class=" mt-8 card shadow-lg p-3  bg-white rounded h-75">
           <div class=" items-center h-20">
              <h1 class="text-lg font-medium truncate mr-5"><span id="add_update"> Add </span> User</h1>
            </div>

            <div class="card-body" style="background-color: white ;" >
                 {!! Form::open(['url' => '', 'name' => 'user_form', 'id' => 'user_form', 'method' => 'post' ,'class'=>'animate-form form-horizontal','role'=>'form']) !!}
                 {!! Form::hidden('code', '',['id'=>'edit_code']) !!}
                                
                <div class="row form-group">
                    <div class="col-sm-4 text-right font-weight-bold" style="font-size: 17Px;">
                        {!! Form::label('name', ' Name:', ['class' =>'required']) !!}
                    </div>   
                    <div class="col-sm-6">
                        {!! Form::text('name', null, ['id'=>'name','class'=>'form-control','placeholder'=>'Enter Name','autocomplete'=>'off']) !!}
                    </div>
                    
                </div> 
                <div class="row form-group">
                    <div class="col-sm-4 text-right font-weight-bold" style="font-size: 17Px;">
                        {!! Form::label('emp_type', ' Type:', ['class' =>'required']) !!}
                    </div>   
                    <div class="col-sm-6">
                        {!! Form::select('emp_type',[''=>'Select Employee Trpe','1'=>'Supervisor','2'=>'Worker'],null,['class' => 'form-control','id'=>'emp_type']); !!}
                    </div>
                    
                </div>  
                 <div class="row form-group">
                    <div class="col-sm-4 text-right font-weight-bold" style="font-size: 17Px;">
                        {!! Form::label('mob_no', ' Mobile Number:', ['class' =>'required']) !!}
                    </div>   
                    <div class="col-sm-6">
                        {!! Form::text('mob_no',null,['class' => 'form-control','id'=>'mob_no', 'placeholder' => 'Mobile Number','autocomplete'=>'off','maxLength'=>'10','onkeypress'=>'return isNumberKey(event);']) !!}
                    </div>
                    
                </div>
                 <div class="row form-group">
                    <div class="col-sm-4 text-right font-weight-bold" style="font-size: 17Px;">
                        {!! Form::label('designation', ' Designation:', ['class' =>'required']) !!}
                    </div>   
                    <div class="col-sm-6">
                        {!! Form::text('designation', null, ['id'=>'designation','class'=>'form-control','placeholder'=>'Designation','autocomplete'=>'off']) !!}
                    </div>
                    
                </div>
                <div class="row form-group">
                    <div class="col-sm-4 text-right font-weight-bold" style="font-size: 17Px;">
                     {!! Form::label('employee', 'Employee:', ['class'=>'highlight required']) !!}
                    
                    </div>  
                    <div class='col-sm-6'>
                        <div class="form-group">
                            <div class=''>
                                <select class="employee form-control"  name="employee" id='employee' autocomplete="off"></select>
                            </div>
                        </div>
                        <div style="display: none;">
                            {!! Form::text('employee',null,['id'=>'employee','class'=>'form-control','autocomplete'=>'off','readonly'=>'false']) !!}
                        </div>
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
         
         $(function () { 

            $('.employee').select2({
            placeholder: "Select Employee Name",
            minimumInputLength: 1,
            maximumInputLength: 10,
            allowClear:true,
            //var token = $("input[name='_token']").val();
            ajax: {
                url: 'get_all_employee_name',
                dataType: 'json',
                method: 'POST',
                success:function(data){                    
                    
                },
                data: function (params) {
                    return {
                        q: $.trim(params.term),
                        _token: $("input[name='_token']").val()
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

            <?php if (isset($user_data)) { ?>

            $("#edit_code").val("<?php echo $user_data->code ;?>");
            $("#name").val('<?php echo $user_data->name; ?>');
            $("#designation").val('<?php echo $user_data->designation; ?>');
            $("#mob_no").val('<?php echo $user_data->mobile_no; ?>');
            $("#emp_type").val('<?php echo $user_data->emp_type; ?>');

            var empCode = '<?php echo $user_data->emp_code; ?>';
            var emp_name = '<?php echo $user_data->emp_name; ?>';
            
            $("#employee").empty().append('<option value=' + empCode + '>' + emp_name + '</option>').val(empCode).trigger('change');


            $("#save_update").html('Update');
            $("#add_update").html('Update');
            

          <?php } ?>

                 $('#user_form').bootstrapValidator({
                    message: 'This value is not valid',
                    feedbackIcons: {
                        
                    },

                    fields: {
                        name: {
                            validators: {
                                notEmpty: {
                                    message: 'Name is Required'
                                },
                                regexp: {
                                regexp: /^([a-zA-Z]+\s?)*$/,
                                message: 'Only Alphabate and Space Allowed Here',
                               }
                            }
                        },
                        emp_type: {
                            validators: {
                                notEmpty: {
                                    message: 'User Type is Required'
                                }
                            }
                        },
                        designation: {
                            validators: {
                                notEmpty: {
                                    message: 'Designation is Required'
                                },
                                regexp: {
                                regexp: /^([a-zA-Z0-9/-]+\s?)*$/,
                                message: 'Only Alphanumeric Space and /- Allowed Here',
                              }
                            }
                        },
                        mob_no: {
                            validators: {
                                notEmpty: {
                                    message: 'Mobile Number is Required'
                                },
                                stringLength: {
                                min: 10,
                                max: 10,
                                message: 'Mobile Number must be 10 Digits',
                              }
                            }
                        },
                        employee: {
                            validators: {
                                notEmpty: {
                                    message: 'Employee is Required'
                                }
                            }
                        }    

                    }
                }).on('success.form.bv', function (e) {
                    e.preventDefault();
                    save_user();               
                });   

        });

       function  save_user(){

             var token = $("input[name='_token']").val();
             var name = $("#name").val();
             var mob_no = $("#mob_no").val();
             var designation = $("#designation").val();
             var emp_type = $("#emp_type").val();
             var employee = $("#employee").val();
             var editcd = $("#edit_code").val();

             var formData_save = new FormData();
                formData_save.append('_token', token);
                formData_save.append('name', name);
                formData_save.append('mob_no', mob_no);
                formData_save.append('designation', designation);
                formData_save.append('emp_type', emp_type);
                formData_save.append('employee', employee);
                formData_save.append('editcd', editcd);
           
            $(".se-pre-con").fadeIn("slow");
                $.ajax({
                    type: "POST",
                    url: "user_save_update",
                    data: formData_save,
                    processData: false,
                    contentType: false,
                    dataType: "json",
                     success: function (data) {

                         if (data.status == 1) {
                    
                        var msg = "<strong>SUCCESS: </strong>User Saved Successfully";

                        $.confirm({
                        title: 'Success!',
                        type: 'green',
                        icon: 'fa fa-check',
                        content: msg,
                        buttons: {
                            ok: function () {
                                
                                $('#user_form').get(0).reset();
                                 location.reload();
                                
                            }

                        }
                    });
                        
                    }
                    else if(data.status == 2)
                    {
                         var msg = "<strong>SUCCESS: </strong>User Updated Successfully";

                        $.confirm({
                        title: 'Success!',
                        type: 'green',
                        icon: 'fa fa-check',
                        content: msg,
                        buttons: {
                            ok: function () {
                              
                                 window.location.href = "user_details";
                            }

                        }
                    });

                    }else{

                        $.confirm({
                            title: 'Unsuccess!',
                            type: 'red',
                            icon: 'fa fa-warning',
                            content: "Something Went Wrong",
                           
                        });


                    }
                     
                    


                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        $(".se-pre-con").fadeOut("slow");
                        var msg = "";
                        if (jqXHR.status !== 422 && jqXHR.status !== 400) {
                            msg += "<strong>" + jqXHR.status + ": " + errorThrown + "</strong>";
                        } else {
                            if (jqXHR.responseJSON.hasOwnProperty('exception')) {
                                msg += "Exception: <strong>" + jqXHR.responseJSON.exception_message + "</strong>";
                            } else {
                                msg += "Error(s):<strong><ul>";
                                $.each(jqXHR.responseJSON['errors'], function (key, value) {
                                    msg += "<li>" + value + "</li>";
                                });
                                msg += "</ul></strong>";
                            }
                        }
                        $.alert({
                            title: 'Error!!',
                            type: 'red',
                            icon: 'fa fa-warning',
                            content: msg,
                        });
                    }
                });

         }
     </script>


                      
  
@stop