<?php $title = 'Leave Assign'; ?>
@extends('layouts.master')
@section('content')
   <div class="top-bar">
         <div class="-intro-x breadcrumb mr-auto hidden sm:flex">
            <a href="">Application</a>
            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="breadcrumb__icon feather feather-chevron-right">
               <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
            <a href="" class="breadcrumb--active">Leave Assign</a>
         </div>
         <div class="intro-x relative mr-3 sm:mr-6">
        <a href="leave_assign_details"><button type="button" class="btn btn-info">
         <span class="glyphicon glyphicon-search"></span> List of Leave Assign 
        </button></a>
     </div>
    </div>

        <div class=" mt-8 card shadow-lg p-3  bg-white rounded h-75">
           <div class=" items-center h-20">
              <h1 class="text-lg font-medium truncate mr-5"><span id="add_update"> Add </span> Leave </h1>
            </div>

            <div class="card-body" style="background-color: white ;" >
                 {!! Form::open(['url' => '', 'name' => 'leave_assign_form', 'id' => 'leave_assign_form', 'method' => 'post' ,'class'=>'animate-form form-horizontal','role'=>'form']) !!}
                 <!-- {!! Form::hidden('code', '',['id'=>'edit_code']) !!} -->
                                
                 <div class="row form-group">
                    <div class="col-sm-4 text-right font-weight-bold" style="font-size: 17Px;">
                      {!! Form::label('designation', 'Designation:',['class'=>'required']) !!}
                    </div>   
                    <div class="col-sm-6">
                        {!! Form::select('designation',[''=>'Select Designation'],null,['class' => 'form-control','id'=>'designation']); !!}
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-sm-4 text-right font-weight-bold" style="font-size: 17Px;">
                       {!! Form::label('year', ' Year:', ['class' =>'required']) !!}
                    </div>   
                    <div class="col-sm-6">
                        {!! Form::select('year',[''=>'Select Year'],null,['class' => 'form-control','id'=>'year']); !!}
                      
                    </div>
                </div>
                <?php  
                $cnt = 0;
                // dd($all_leave);
                foreach ($all_leave as $value) {   
                   
                 ?>
                 <?php $cnt = $cnt + 1; ?>
                  <div class="row form-group">
                    <div class="col-sm-4 text-right font-weight-bold" style="font-size: 17Px;">
                        {!! Form::label('leave_type', $value['type_of_leave'], ['class' =>'required']) !!}
                    <input class="form-control" type="hidden" id="leave_code<?php echo $cnt; ?>" value="{{ $value->code }}">
                    </div>   
                    <div class="col-sm-6">
                   
                    <input class="form-control" type="number" id="no_of_leave<?php echo $cnt; ?>" placeholder="Enter <?php echo $value['type_of_leave']; ?>" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==3) return false;"> 
                     
                    </div>
                    
                </div>

                <?php }  ?>
                <input type="hidden" value="<?php echo $cnt ?>" id="total_leave">

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
         
            get_all_designation();
            get_all_year();


                 $('#leave_assign_form').bootstrapValidator({
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
                        },
                        year: {
                            validators: {
                                notEmpty: {
                                    message: 'Year is Required' 
                                }
                            }
                        }  

                    }
                }).on('success.form.bv', function (e) {
                    e.preventDefault();
                    save_leave_assign();               
                });
                

        });

       function  save_leave_assign(){
            // alert("hi");

             var token = $("input[name='_token']").val();
            // //  alert(token);
            var designation_name = $("#designation").val();
            //  alert(designation_name);
            var year_cd = $("#year").val();
            //  alert(year_cd);
            var total_leave = $("#total_leave").val();
            // // alert(total_leave);
            var arr = [];
            for(var i = 1; i<=total_leave; i++){
               
                var leave_cd = $("#leave_code"+i).val();
                var no_of_leave = $("#no_of_leave"+i).val();
                
                var str = leave_cd + ":" + no_of_leave;
                arr.push(str);

            //     //   alert(type_of_leave);
            }
          

             var formData_save = new FormData();
                formData_save.append('_token', token);

                formData_save.append('designation_name', designation_name);
                formData_save.append('year_cd', year_cd);
               
                formData_save.append('no_of_leave', arr);
              
           
            $(".se-pre-con").fadeIn("slow");
                $.ajax({
                    type: "POST",
                    url: "leave_assign_save_update",
                    data: formData_save,
                    processData: false,
                    contentType: false,
                    dataType: "json",
                     success: function (data) {
                        if (data.status == 1) {
                                
                                var msg = "<strong>SUCCESS: </strong>Leave Assign Saved Successfully";

                                $.confirm({
                                title: 'Success!',
                                type: 'green',
                                icon: 'fa fa-check',
                                content: msg,
                                buttons: {
                                    ok: function () {
                                        
                                        $('#leave_assign_form').get(0).reset();
                                        location.reload();
                                        
                                    }

                                }
                            });
                                
                            }
                        }
                });
        }

        
         function get_all_year(){

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

                  }
                });




         }

         function get_all_designation()
         {
            var token = $("input[name='_token']").val();
            // alert(token);
            $.ajax({
                type: "post",
                url: "get_all_designation",
                async:false,
                data: {_token:token},
                dataType: 'json',
                success: function(data){
                    $("#designation").html('<option value="">Select Designation</option>');
                    $.each(data.options, function (key, value){
                        $("#designation").append('<option value=' + key +'>' + value +'</option>')
                       
                    })
                }

            });
         }
     </script>


                      
  
@stop