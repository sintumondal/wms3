<?php $title="Shift" ?>
@extends('layouts.master')
@section('content')
<div class="top-bar">
        <div class="-intro-x breadcrumb mr-auto hidden sm:flex">
                <a href="">Application</a>
                <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="breadcrumb__icon feather feather-chevron-right">
                <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
                <a href="" class="breadcrumb--active">Shift</a>
            </div>
            <div class="intro-x relative mr-3 sm:mr-6">
            <a href="shift_details"><button type="button" class="btn btn-info">
            <span class="glyphicon glyphicon-search"></span>List Of Shift
            </button></a>
        </div>
            
    </div>

    <div class=" mt-8 card shadow-lg p-3  bg-white rounded h-75">
            <div class=" items-center h-20">
                <h1 class="text-lg font-medium truncate mr-5"> Add Shift</h1>
            </div>
            <div class="card-body" style="background-color: white ;" >
            {!! Form::open(['url' => '', 'name' => 'shift_form', 'id' => 'shift_form', 'method' => 'post' ,'class'=>'animate-form form-horizontal','role'=>'form']) !!}
            {!! Form::hidden('code', '', ['id'=>'edit_code']) !!}  
                
                <div class="row form-group">
                    <div class="col-sm-4 text-right font-weight-bold" style="font-size: 20Px;">
                        {!! Form::label('shift_name', 'Shift:', ['class'=>'required']) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::text('shift_name',null, ['class'=>'form-control','id'=>'shift_name','placeholder'=>'Enter Shift Name','autocomplete'=>'off','maxlength'=>'40']) !!}
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-sm-4 text-right font-weight-bold" style="font-size: 20Px;">
                        {!! Form::label('shift_in_time', 'Shift In Time:', ['class'=>'required']) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::time('shift_in_time',null, ['class'=>'form-control','id'=>'shift_in_time','placeholder'=>'Enter Shift In Time','autocomplete'=>'off','maxLength'=>'50']) !!}
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-sm-4 text-right font-weight-bold" style="font-size: 20Px;">
                        {!! Form::label('shift_out_time', 'Shift Out Time:', ['class'=>'required']) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::time('shift_out_time',null, ['class'=>'form-control','id'=>'shift_out_time','placeholder'=>'Enter Shift In Time','autocomplete'=>'off','maxLength'=>'50']) !!}
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
    <script>
        $(function (){
            <?php if(isset($shift_data)){ ?>
                var shift_details = JSON.parse('<?php echo $shift_data; ?>');
                $("#edit_code").val(shift_details.code);
                $("#shift_name").val(shift_details.shift);
                $("#shift_in_time").val(shift_details.shift_in_time);
                $("#shift_out_time").val(shift_details.shift_out_time);
                
                $("#save_update").html('Update');
                $("#add_update").html('Update');

            <?php } ?>
         
            $("#shift_form").bootstrapValidator({
                message: 'This value is not valid',
                feedbackIcons: {
                            
                    },
                    fields: {
                        shift_name: {
                            validators: {
                                notEmpty: {
                                    message: "Shift Name is Required"
                                },
                                regexp: {
                                        regexp: /^[a-z\s]+$/i,
                                        message: 'Shift can consist of alphabetical characters and spaces only'
                                    }
                                //     stringLength: {
                                //     message: 'Shift Name must be less than 40 characters',
                                //     max: function (value, validator, $field) {
                                //         return 40 - (value.match(/\r/g) || []).length;
                                //     }
                                // }
                            }
                        },
                        shift_in_time: {
                            validators: {
                                notEmpty: {
                                    message: "Shift In Time is Required"
                                }
                            }
                        },
                        shift_out_time: {
                            validators: {
                                notEmpty: {
                                    message: "Shift Out Time is Required"
                                }
                            }
                        },
                    }
            }).on('success.form.bv', function(e) {
                e.preventDefault();
                shift_details_save_update();
            });
        });

        function shift_details_save_update() {
            // alert("hi");
            var token = $("input[name='_token']").val();
            // alert(token);
            var shift = $("#shift_name").val();
            var shift_in_time = $("#shift_in_time").val();
            var shift_out_time = $("#shift_out_time").val();
            var editcd = $("#edit_code").val();
            // alert(editcd);

            var formData_save = new FormData();
            formData_save.append('_token', token);
            formData_save.append('shift', shift);
            formData_save.append('shift_in_time', shift_in_time);
            formData_save.append('shift_out_time', shift_out_time);
            formData_save.append('editcd', editcd);

            $(".se-pre-con").fadeIn("slow");

            $.ajax({
                type: "POST",
                url: "shift_save_update",
                data: formData_save,
                processData: false,
                contentType: false,
                success: function(data) {
                    if(data.status == 1) {
                        var msg = "<strong>SUCCESS: </strong> Shift Saved Successfully";
                        $.confirm({
                            title: 'Success!',
                            type: 'green',
                            icon: 'fa fa-check',
                            content: msg,
                            buttons: {
                                ok: function () {
                            
                                    $('#shift_form').get(0).reset();
                                    location.reload();
                            
                                    }

                                }
                        });
                    }  else if(data.status == 2)
                    {
                         var msg = "<strong>SUCCESS: </strong>Shift Updated Successfully";

                        $.confirm({
                        title: 'Success!',
                        type: 'green',
                        icon: 'fa fa-check',
                        content: msg,
                        buttons: {
                            ok: function () {
                              
                                 window.location.href = "shift_details";
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