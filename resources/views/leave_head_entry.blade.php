<?php $title = "Leave Head"; ?>
@extends('layouts.master')
@section('content')
<div class="top-bar">
         <div class="-intro-x breadcrumb mr-auto hidden sm:flex">
            <a href="">Application</a>
            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="breadcrumb__icon feather feather-chevron-right">
               <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
            <a href="" class="breadcrumb--active">Leave Head</a>
         </div>
         <div class="intro-x relative mr-3 sm:mr-6">
        <a href="leave_head"><button type="button" class="btn btn-info">
         <span class="glyphicon glyphicon-search"></span> List of Leave Head 
        </button></a>
     </div>
</div>

<div class=" mt-8 card shadow-lg p-3  bg-white rounded h-75">
           <div class=" items-center h-20">
              <h1 class="text-lg font-medium truncate mr-5"><span id="add_update"> Add </span> Leave</h1>
            </div>

            <div class="card-body" style="background-color: white ;" >
                 {!! Form::open(['url' => '', 'name' => 'leave_head_form', 'id' => 'leave_head_form', 'method' => 'post' ,'class'=>'animate-form form-horizontal','role'=>'form']) !!}
                 {!! Form::hidden('code', '',['id'=>'edit_code']) !!}

                                
                <div class="row form-group">
                    <div class="col-sm-4 text-right font-weight-bold" style="font-size: 20Px;">
                        {!! Form::label('leave_head_name', ' Leave:', ['class' =>'required']) !!}
                    </div>   
                    <div class="col-sm-6">
                        {!! Form::text('leave_head_name', null, ['id'=>'leave_head_name','class'=>'form-control','placeholder'=>'Enter Leave','autocomplete'=>'off']) !!}
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
    $(function (){
        <?php if(isset($leave_data)) {?>
        $("#edit_code").val("<?php echo $leave_data->code ;?>");
        $("#leave_head_name").val('<?php echo $leave_data->type_of_leave ?>')
        $("#save_update").html('Update');
        $("#add_update").html('Update');
        <?php } ?>

        $('#leave_head_form').bootstrapValidator({
            message: 'This value is not valid',
            feedbackIcons: {
                        
                },
                fields: {
                    leave_head_name: {
                        validators: {
                                notEmpty: {
                                    message: 'Leave Name is Required'
                                },
                                    regexp: {
                                        regexp: /^[a-z\s]+$/i,
                                        message: 'Leave can consist of alphabetical characters and spaces only'
                                    },
                                    stringLength: {
                                    message: 'Leave Name must be less than 40 characters',
                                    max: function (value, validator, $field) {
                                        return 40 - (value.match(/\r/g) || []).length;
                                    }
                                }
                                // callback: {
                                //      message: 'please enter only letters',
                      
                                //   }
                     }
                }
                }

        }).on('success.form.bv', function (e) {
            e.preventDefault();
            save_leave_head(); 
        });
    });

function save_leave_head() {
    // alert("hi");
    var token = $("input[name='_token']").val();
    var leave_name = $("#leave_head_name").val();
    // alert(leave_name);
    var editcd = $("#edit_code").val();
    // alert(editcd);
    var formData_save = new FormData();
    formData_save.append('_token', token);
    formData_save.append('leave_head_name', leave_name);
    formData_save.append('editcd', editcd);

    $(".se-pre-con").fadeIn("slow");
        $.ajax({
            type: "POST",
            url: "leave_save_update",
            data: formData_save,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function (data) {
                
                if (data.status == 1) {
                    
                    var msg = "<strong>SUCCESS: </strong>Leave Saved Successfully";

                    $.confirm({
                    title: 'Success!',
                    type: 'green',
                    icon: 'fa fa-check',
                    content: msg,
                    buttons: {
                        ok: function () {
                            
                            $('#leave_head_form').get(0).reset();
                             location.reload();
                            
                        }

                    }
                });
                    
                }
                else if(data.status == 2)
                    {
                         var msg = "<strong>SUCCESS: </strong>Leave Updated Successfully";

                        $.confirm({
                        title: 'Success!',
                        type: 'green',
                        icon: 'fa fa-check',
                        content: msg,
                        buttons: {
                            ok: function () {
                              
                                 window.location.href = "leave_head";
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