<?php $title = 'Allowance'; ?>
@extends('layouts.master')
@section('content')
   <div class="top-bar">
         <div class="-intro-x breadcrumb mr-auto hidden sm:flex">
            <a href="">Application</a>
            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="breadcrumb__icon feather feather-chevron-right">
               <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
            <a href="" class="breadcrumb--active">Allowance</a>
         </div>
         <div class="intro-x relative mr-3 sm:mr-6">
        <a href="allowance_details"><button type="button" class="btn btn-info">
         <span class="glyphicon glyphicon-search"></span> List of Allowance 
        </button></a>
     </div>
    </div>

        <div class=" mt-8 card shadow-lg p-3  bg-white rounded h-75">
           <div class=" items-center h-20">
              <h1 class="text-lg font-medium truncate mr-5"><span id="add_update"> Add </span> Allowance</h1>
            </div>

            <div class="card-body" style="background-color: white ;" >
                 {!! Form::open(['url' => '', 'name' => 'allowance_form', 'id' => 'allowance_form', 'method' => 'post' ,'class'=>'animate-form form-horizontal','role'=>'form']) !!}
                 {!! Form::hidden('code', '',['id'=>'edit_code']) !!}

                 <div class="row form-group">
                    <div class="col-sm-4 text-right font-weight-bold" style="font-size: 20Px;">
                        {!! Form::label('allowance_type', ' Allowance Type:', ['class' =>'required']) !!}
                    </div>   
                    <div class="col-sm-6">
                        {!! Form::select('allowance_type',[''=>'Select Allowance Type','1'=>'Addition','2'=>'Deduction'],null,['id'=>'allowance_type','class'=>'form-control','autocomplete'=>'off']) !!}
                    </div>
                    
                </div>
                                
                <div class="row form-group">
                    <div class="col-sm-4 text-right font-weight-bold" style="font-size: 20Px;">
                        {!! Form::label('allowance_name', ' Allowance:', ['class' =>'required']) !!}
                    </div>   
                    <div class="col-sm-6">
                        {!! Form::text('allowance_name', null, ['id'=>'allowance_name','class'=>'form-control','placeholder'=>'Enter Allowance','autocomplete'=>'off']) !!}
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

            <?php if (isset($allowance_data)) { ?>

            $("#edit_code").val("<?php echo $allowance_data->code ;?>");
            $("#allowance_name").val('<?php echo $allowance_data->name_of_allowance; ?>');
            $("#allowance_type").val('<?php echo $allowance_data->allowance_type; ?>');
            $("#save_update").html('Update');
            $("#add_update").html('Update');
            

          <?php } ?>

                 $('#allowance_form').bootstrapValidator({
                    message: 'This value is not valid',
                    feedbackIcons: {
                        
                    },

                    fields: {
                        allowance_name: {
                            validators: {
                                notEmpty: {
                                    message: 'Allowance is Required'
                                }
                            }
                        },
                        allowance_type: {
                            validators: {
                                notEmpty: {
                                    message: 'Allowance Type is Required'
                                }
                            }
                        }    

                    }
                }).on('success.form.bv', function (e) {
                    e.preventDefault();
                    save_allowance();               
                });   

        });

       function  save_allowance(){

             var token = $("input[name='_token']").val();
             var allowance_name = $("#allowance_name").val();
             var allowance_type = $("#allowance_type").val();
             var editcd = $("#edit_code").val();

             var formData_save = new FormData();
                formData_save.append('_token', token);
                formData_save.append('allowance_name', allowance_name);
                 formData_save.append('allowance_type', allowance_type);
                formData_save.append('editcd', editcd);
           
            $(".se-pre-con").fadeIn("slow");
                $.ajax({
                    type: "POST",
                    url: "allowance_save_update",
                    data: formData_save,
                    processData: false,
                    contentType: false,
                    dataType: "json",
                     success: function (data) {

                         if (data.status == 1) {
                    
                        var msg = "<strong>SUCCESS: </strong>Allowance Saved Successfully";

                        $.confirm({
                        title: 'Success!',
                        type: 'green',
                        icon: 'fa fa-check',
                        content: msg,
                        buttons: {
                            ok: function () {
                                
                                $('#allowance_form').get(0).reset();
                                 location.reload();
                                
                            }

                        }
                    });
                        
                    }
                    else if(data.status == 2)
                    {
                         var msg = "<strong>SUCCESS: </strong>Allowance Updated Successfully";

                        $.confirm({
                        title: 'Success!',
                        type: 'green',
                        icon: 'fa fa-check',
                        content: msg,
                        buttons: {
                            ok: function () {
                              
                                 window.location.href = "allowance_details";
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