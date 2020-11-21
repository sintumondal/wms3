<?php $title = 'P-Tax' ?>
@extends('layouts.master')
@section('content')
<div class="top-bar">
        <div class="-intro-x breadcrumb mr-auto hidden sm:flex">
                <a href="">Application</a>
                <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="breadcrumb__icon feather feather-chevron-right">
                <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
                <a href="" class="breadcrumb--active">P-Tax</a>
            </div>
            <div class="intro-x relative mr-3 sm:mr-6">
            <a href="p_tax_details"><button type="button" class="btn btn-info">
            <span class="glyphicon glyphicon-search"></span>List Of P_TAX
            </button></a>
        </div>
            
    </div>

    <div class=" mt-8 card shadow-lg p-3  bg-white rounded h-75">
            <div class=" items-center h-20">
                <h1 class="text-lg font-medium truncate mr-5"> Add P_TAX</h1>
            </div>
            <div class="card-body" style="background-color: white ;" >
            {!! Form::open(['url' => '', 'name' => 'p_tax_form', 'id' => 'p_tax_form', 'method' => 'post' ,'class'=>'animate-form form-horizontal','role'=>'form']) !!}
            {!! Form::hidden('code', '',['id'=>'edit_code']) !!}
            
                <div class="row form-group">
                    <div class="col-sm-4 text-right font-weight-bold" style="font-size: 20Px;">
                        {!! Form::label('salary_from_amount', 'Salary From Amount:', ['class'=>'required']) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::text('salary_from_amount',null,['class'=>'form-control', 'id'=>'salary_from_amount','placeholder'=>'Enter From Amount','autocomplete'=>'off','maxlength'=>'11']) !!}
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-sm-4 text-right font-weight-bold" style="font-size: 20Px;">
                        {!! Form::label('salary_to_amount', 'Salary To Amount:', ['class'=>'required']) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::text('salary_to_amount',null,['class'=>'form-control','id'=>'salary_to_amount','placeholder'=>'Enter To Amount','autocomplete'=>'off','maxlength'=>'11']) !!}
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-sm-4 text-right font-weight-bold" style="font-size: 20Px;">
                        {!! Form::label('deductable_amount', 'Deductable Amount:', ['class'=>'required']) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::text('deductable_amount',null,['class'=>'form-control','id'=>'deductable_amount','placeholder'=>'Enter Amount','autocomplete'=>'off','maxlength'=>'11']) !!}
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
$(function() {
    <?php if(isset($p_tax_data)) {?>

        $("#edit_code").val("<?php echo $p_tax_data->code ;?>");
        $("#salary_from_amount").val('<?php echo $p_tax_data->from_amt ?>');
        $("#salary_to_amount").val('<?php echo $p_tax_data->to_amt ?>');
        $("#deductable_amount").val('<?php echo $p_tax_data->amt ?>');
        $("#save_update").html('Update');
        $("#add_update").html('Update');
        <?php } ?>

    $("#p_tax_form").bootstrapValidator({
                message: 'This value is not valid',
                feedbackIcons: {
                            
                    },
                    fields: {
                        salary_from_amount: {
                            validators: {
                                notEmpty: {
                                    message: "Salary From Amount is Required"
                                },

                            }
                        },
                        salary_to_amount: {
                            validators: {
                                notEmpty: {
                                    message: "Salary To Amount is Required"
                                }
                            }
                        },
                        deductable_amount: {
                            validators: {
                                notEmpty: {
                                    message: "Deductable Amount is Required"
                                }
                            }
                        },


                    }
            }).on('success.form.bv', function(e){
                e.preventDefault();
                save_salary_form();
            });
    });

    function save_salary_form() {
        // alert("hi");
        var token = $("input[name='_token']").val();
        // alert(token);
        var salary_from_amount = $('#salary_from_amount').val();
        // alert(salary_from_amount);
        var salary_to_amount = $('#salary_to_amount').val();
        // alert(salary_to_amount);
        var deductable_amount = $('#deductable_amount').val();
        // alert(deductable_amount);
        var editcd = $("#edit_code").val();

        var formData_save = new FormData();
        formData_save.append('_token', token);
        formData_save.append('salary_from_amount', salary_from_amount);
        formData_save.append('salary_to_amount', salary_to_amount);
        formData_save.append('deductable_amount', deductable_amount);
        // alert(formData_save);
        formData_save.append('editcd', editcd);

        $(".se-pre-con").fadeIn("slow");
        $.ajax({
            type: "POST",
            url: "p_tax_save_update",
            data: formData_save,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function(data) {
                if (data.status == 1) {
                    
                    var msg = "<strong>SUCCESS: </strong>P_TAX Saved Successfully";

                    $.confirm({
                    title: 'Success!',
                    type: 'green',
                    icon: 'fa fa-check',
                    content: msg,
                    buttons: {
                        ok: function () {
                            
                            $('#p_tax_form').get(0).reset();
                             location.reload();
                            
                        }

                    }
                });
                    
                }
                else if(data.status == 2)
                    {
                         var msg = "<strong>SUCCESS: </strong>P_TAX Updated Successfully";

                        $.confirm({
                        title: 'Success!',
                        type: 'green',
                        icon: 'fa fa-check',
                        content: msg,
                        buttons: {
                            ok: function () {
                              
                                 window.location.href = "p_tax_details";
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