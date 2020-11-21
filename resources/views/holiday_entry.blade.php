<?php $title = 'Holidays Entry' ?>
@extends('layouts.master')
@section('content')
<div class="top-bar">
        <div class="-intro-x breadcrumb mr-auto hidden sm:flex">
                <a href="">Application</a>
                <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="breadcrumb__icon feather feather-chevron-right">
                <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
                <a href="" class="breadcrumb--active">Holidays Details</a>
            </div>
            <div class="intro-x relative mr-3 sm:mr-6">
            <a href="holiday_details"><button type="button" class="btn btn-info">
            <span class="glyphicon glyphicon-search"></span>List Of Holidays
            </button></a>
        </div>
            
    </div>

    <div class=" mt-8 card shadow-lg p-3  bg-white rounded h-75">
            <div class=" items-center h-20">
                    <h1 class="text-lg font-medium truncate mr-5"><span id="add_update"> Add </span> Holidays</h1>
            </div>
            <div class="card-body" style="background-color: white ;" >
            {!! Form::open(['url' => '', 'name' => 'holiday_form', 'id' => 'holiday_form', 'method' => 'post' ,'class'=>'animate-form form-horizontal','role'=>'form']) !!}
            {!! Form::hidden('code','',['id'=>'edit_code']) !!}
            <div class="row form-group">
                    <div class="col-sm-4 text-right font-weight-bold" style="font-size: 20Px;">
                        {!! Form::label('year', ' Year:', ['class' =>'required']) !!}
                        
                    </div>
                    <div class="col-sm-6">
                    {!! Form::select('year', [],null,['class'=>'form-control', 'id'=>'year']) !!}

                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-sm-4 text-right font-weight-bold" style="font-size: 20Px;">
                        {!! Form::label('holiday_date', ' Date:', ['class' =>'required']) !!}
                        
                    </div>
                    <div class="col-sm-6">
                    {!! Form::text('holiday_date',null,['class' => 'form-control','id'=>'holiday_date','placeholder'=>'Enter Date','autocomplete'=>'off','maxLength'=>'50']) !!}

                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-sm-4 text-right font-weight-bold" style="font-size: 20Px;">
                        {!! Form::label('description', ' Description:', ['class' =>'required']) !!}
                        
                    </div>
                    <div class="col-sm-6">
                    {!! Form::text('description', null, ['id'=>'description','class'=>'form-control','placeholder'=>'Enter Description','autocomplete'=>'off','maxLength'=>'40']) !!}

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
        <?php if(isset($holiday_data)) {?>
            var holiday = JSON.parse('<?php echo $holiday_data ?>');
            get_all_year(holiday.year);
            $('#edit_code').val(holiday.code);
            $('#holiday_date').val(holiday.holiday_date);
            $('#description').val(holiday.description);
            $("#save_update").html('Update');
            $("#add_update").html('Update');
        <?php } else {?>
            get_all_year('');
        <?php } ?>

       
        $('#holiday_date').datepicker({
                autoclose: true,
                format: "dd/mm/yyyy",
                todayHighlight: true,
                // placeholder: "Enter Date"   
              }).on('change', function(e) {
            // Revalidate the date field
            $('#holiday_form').bootstrapValidator('revalidateField', 'holiday_date');
        });

              $('#holiday_form').bootstrapValidator({
                message: 'This value is not valid',
                feedbackIcons: {
                            
                    },
                    fields: {
                        year: {
                            validators: {
                                notEmpty: {
                                    message: 'Year is Required'
                                },
                            }
                        },
                        holiday_date: {
                            validators: {
                                notEmpty: {
                                    message: 'Date is Required'
                                },
                                // date: {
                                //     format: 'dd/mm/yyyy',
                                //     message: 'The value is not a valid date'
                                // }
                            }
                        },
                        description: {
                            validators: {
                              
                                    notEmpty: {
                                        message: 'Description is Required'
                                    },
                                    regexp: {
                                        regexp: /^[1-9a-z\s]+$/i,
                                        message: 'Description can consist of alphabetical characters and spaces only'
                                    },
                                    stringLength: {
                                    message: 'Description  must be less than 40 characters',
                                    max: function (value, validator, $field) {
                                        return 40 - (value.match(/\r/g) || []).length;
                                    }
                                }
                                
                            }
                        }

                    }
              }).on('success.form.bv', function (e) {
                e.preventDefault();
                save_holidays(); 
            });
    });

    function get_all_year(holidayYear){

            var token = $("input[name='_token']").val();
                $.ajax({
                type: "post",
                url: "get_all_year",
                async:false,
                data:{_token:token},
                dataType: 'json',
                success: function (data) {
                
                    $('#year').html('<option value=""> Select Year </option>');
                    $.each(data.options, function (key, value) {
                    
                        $("#year").append('<option value=' + value + '>' + value + '</option>');
                    
                    });
                    if(holidayYear !=''){
                        $("#year").val(holidayYear);
                    }

                }
                });
            }


            function save_holidays() {
                // alert("hi");
                var token = $("input[name='_token']").val();
                var year = $("#year").val();
                // alert(year);
                var holiday_date = $("#holiday_date").val();
                // alert(holiday_date);
                var description = $("#description").val();
                // alert(description);
                var editcd = $("#edit_code").val();
                // alert(editcd);
                var formData_save = new FormData();
                formData_save.append('_token', token);
                formData_save.append('year', year);
                formData_save.append('holiday_date', holiday_date);
                formData_save.append('description', description);
                formData_save.append('editcd', editcd);

                $(".se-pre-con").fadeIn("slow");
                $.ajax({
                    type: "POST",
                    url: "holiday_save_update",
                    data: formData_save,
                    processData: false,
                    contentType: false,
                    dataType: "json",
                    success: function (data) {
                        if (data.status == 1) {
                    
                    var msg = "<strong>SUCCESS: </strong>Holidays Saved Successfully";

                    $.confirm({
                    title: 'Success!',
                    type: 'green',
                    icon: 'fa fa-check',
                    content: msg,
                    buttons: {
                        ok: function () {
                            
                            $('#holiday_form').get(0).reset();
                             location.reload();
                            
                        }

                    }
                });
                    
                }      else if(data.status == 2)
                    {
                         var msg = "<strong>SUCCESS: </strong>Holidays Updated Successfully";

                        $.confirm({
                        title: 'Success!',
                        type: 'green',
                        icon: 'fa fa-check',
                        content: msg,
                        buttons: {
                            ok: function () {
                              
                                 window.location.href = "holiday_details";
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
                        // var myJSON = JSON.stringify(jqXHR);
                        // alert(myJSON);
                        $(".se-pre-con").fadeOut("slow");
                        var msg = "";
                        if (jqXHR.status !== 422 && jqXHR.status !== 400) {
                            msg += "<strong>" + jqXHR.status + ": " + errorThrown + "</strong>";
                        } else {
                            if (jqXHR.responseJSON.hasOwnProperty('exception')) {
                                msg += "Exception: <strong>" + jqXHR.responseJSON.exception_message + "</strong>";
                            } else {
                                msg += "Error(s):<strong><ul>";
                            //    alert(jqXHR.responseJSON['error']) ;
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