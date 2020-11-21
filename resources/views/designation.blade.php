<?php $title = 'Designation'; ?>
@extends('layouts.master')
@section('content')
   <div class="top-bar">
         <div class="-intro-x breadcrumb mr-auto hidden sm:flex">
            <a href="">Application</a>
            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="breadcrumb__icon feather feather-chevron-right">
               <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
            <a href="" class="breadcrumb--active">Designation</a>
         </div>
         <div class="intro-x relative mr-3 sm:mr-6">
        <a href="designation"><button type="button" class="btn btn-info">
         <span class="glyphicon glyphicon-search"></span> List of Designation 
        </button></a>
     </div>
    </div>

        <div class=" mt-8 card shadow-lg p-3  bg-white rounded h-75">
           <div class=" items-center h-20">
              <h1 class="text-lg font-medium truncate mr-5"><span id="add_update"> Add </span> Designation</h1>
            </div>

            <div class="card-body" style="background-color: white ;" >
                 {!! Form::open(['url' => '', 'name' => 'designation_form', 'id' => 'designation_form', 'method' => 'post' ,'class'=>'animate-form form-horizontal','role'=>'form']) !!}
                 {!! Form::hidden('code', '',['id'=>'edit_code']) !!}
                                
                <div class="row form-group">
                    <div class="col-sm-4 text-right font-weight-bold" style="font-size: 20Px;">
                        {!! Form::label('designation_name', ' Designation:', ['class' =>'required']) !!}
                    </div>   
                    <div class="col-sm-6" style="float:left">
                        {!! Form::text('designation_name', null, ['id'=>'designation_name','class'=>'form-control','placeholder'=>'Enter Designation','autocomplete'=>'off']) !!}
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

            <?php if (isset($designation_data)) { ?>

            $("#edit_code").val("<?php echo $designation_data->code ;?>");
            $("#designation_name").val('<?php echo $designation_data->designation; ?>');
            $("#save_update").html('Update');
            $("#add_update").html('Update');
            

          <?php } ?>

                 $('#designation_form').bootstrapValidator({
                    message: 'This value is not valid',
                    feedbackIcons: {
                        
                    },

                    fields: {
                        designation_name: {
                            validators: {
                                notEmpty: {
                                    message: 'Designation is Required'
                                }
                            }
                        }    

                    }
                }).on('success.form.bv', function (e) {
                    e.preventDefault();
                    save_designation();               
                });   

        });

       function  save_designation(){

             var token = $("input[name='_token']").val();
             var designation_name = $("#designation_name").val();
             var editcd = $("#edit_code").val();

             var formData_save = new FormData();
                formData_save.append('_token', token);
                formData_save.append('designation_name', designation_name);
                formData_save.append('editcd', editcd);
           
            $(".se-pre-con").fadeIn("slow");
                $.ajax({
                    type: "POST",
                    url: "designation_save_update",
                    data: formData_save,
                    processData: false,
                    contentType: false,
                    dataType: "json",
                     success: function (data) {

                         if (data.status == 1) {
                    
                        var msg = "<strong>SUCCESS: </strong>Designation Saved Successfully";

                        $.confirm({
                        title: 'Success!',
                        type: 'green',
                        icon: 'fa fa-check',
                        content: msg,
                        buttons: {
                            ok: function () {
                                
                                $('#designation_form').get(0).reset();
                                 location.reload();
                                
                            }

                        }
                    });
                        
                    }
                    else if(data.status == 2)
                    {
                         var msg = "<strong>SUCCESS: </strong>Designation Updated Successfully";

                        $.confirm({
                        title: 'Success!',
                        type: 'green',
                        icon: 'fa fa-check',
                        content: msg,
                        buttons: {
                            ok: function () {
                              
                                 window.location.href = "designation";
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