<?php $title = 'Salary Sheet'; ?>
@extends('layouts.master')
@section('content')
<style>
table {
  border-collapse: collapse;
  border-spacing: 0;
  width: 100%;
  border: 1px solid #ddd;
}

th, td {
  text-align: left;
  padding: 8px;
}

tr:nth-child(even){background-color: #f2f2f2}
</style>
   <div class="top-bar">
         <div class="-intro-x breadcrumb mr-auto hidden sm:flex">
            <a href="">Application</a>
            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="breadcrumb__icon feather feather-chevron-right">
               <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
            <a href="" class="breadcrumb--active">Salary Report</a>
         </div>


          <div class="intro-x relative mr-3 sm:mr-6">
        <a href="salary_generated_list"><button type="button" class="btn btn-info">
         <span class="glyphicon glyphicon-search"></span>Salary Generated Details
        </button></a>
     </div>
        
    </div>

        <div class=" mt-8 card shadow-lg p-3  bg-white rounded h-75">
           <div class=" items-center h-10">
              <h1 class="text-lg font-medium truncate mr-5"> Salary Report</h1>
            </div>


            <div class="card-body" style="background-color: white ;" >
                 {!! Form::open(['url' => '', 'name' => 'salary_generation', 'id' => 'salary_generation', 'method' => 'post' ,'class'=>'animate-form form-horizontal','role'=>'form']) !!}
                 {!! Form::hidden('code', '',['id'=>'edit_code']) !!}
                                
                <div class="row form-group">
                    <div class="col-sm-4  font-weight-bold" style="font-size: 16Px;">
                        {!! Form::label('year', ' Year:', ['class' =>'']) !!}
                    {!! Form::select('year',[''=>'Select Year' ,'2020'=>'2020' ,'2021'=>'2021','2022'=>'2022','2023'=>'2023'],null,['class' => 'form-control','id'=>'year']); !!}
                    </div>
                    <div class="col-sm-4 font-weight-bold" style="font-size: 16Px;">
                        {!! Form::label('month', ' Month:', ['class' =>'']) !!}
                    
                       {!! Form::select('month',[''=>'Select Month','01'=>'January','02'=>'February','03'=>'March','04'=>'April','05'=>'May','06'=>'June','07'=>'July','08'=>'August','09'=>'September','10'=>'October','11'=>'November','12'=>'December'],null,['class' => 'form-control','id'=>'month']); !!}
                    </div>
                    <div class="col-sm-4  font-weight-bold" style="font-size: 16Px;">
                        {!! Form::label('designation', ' Designation:', ['class' =>'']) !!}
                    
                         {!! Form::select('designation',[''=>'Select Designation'],null,['class' => 'form-control','id'=>'designation']); !!}
                    </div>
                    
                </div>             
                <div class="row form-group">
                    <div class="col-sm-12" style="text-align: center;">
                        <button id="save_update" type="submit" class="btn btn-primary">Search</button>
                    </div>
                </div>
                <div class="row form-group search_result">
                    
                </div>

                <div class="row form-group div_saraly_generate" style="display: none">
                    <div class="col-sm-12" style="text-align: center;">
                        <button id="btn_saraly_generate" type="button" class="btn btn-primary">Salary Generate</button>
                    </div>
                </div>
               
                   {!! Form::close() !!}             
             
            </div>

         
        
     </div>
        {{csrf_field()}}
     <script type="text/javascript">
         
         $(function () { 

            

          <?php if (isset($regenerate_salary_data)) { ?>

             var decode_array =JSON.parse('<?php echo $regenerate_salary_data  ?> ');

            $("#edit_code").val(decode_array.code);
            $("#year").val(decode_array.year);
            $("#month").val(decode_array.month);
           // $("#designation").val(decode_array.designation_code);
             get_all_designation(decode_array.designation_code);
           
          <?php }else{ ?>

             get_all_designation('');

             <?php } ?>
           
            // department_details();

                 $('#salary_generation').bootstrapValidator({
                    message: 'This value is not valid',
                    feedbackIcons: {
                        
                    },

                    fields: {
                        year: {
                            validators: {
                                notEmpty: {
                                    message: 'Year is Required'
                                }
                            }
                        },
                        month: {
                            validators: {
                                notEmpty: {
                                    message: 'Month is Required'
                                }
                            }
                        } ,
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
                    
                    salary_generation_search();  
                    $(".div_saraly_generate").show();             
                });
        });

      function salary_generation_search(){

             var token = $("input[name='_token']").val();
             var year = $("#year").val();
             var month = $("#month").val();
             var designation = $("#designation").val();


             var formData_save = new FormData();
                 formData_save.append('_token', token);
                 formData_save.append('year', year);
                 formData_save.append('month', month);
                 formData_save.append('designation', designation);

                $.ajax({
                    type: "POST",
                    url: "designation_wise_salary",
                    data: formData_save,
                    processData: false,
                    contentType: false,
                    dataType: "json",
                    success: function (data) {
                        var i=0;  var j=0;

                    var str = "";
                   str += "<div id='tbl_salary_generate'  class='row table-responsive'>";
                    str += "<table class='table'>";
                    str += "<thead>";
                    str += "<tr><th> </th>";
                    str += "<th> </th>";str += "<th> </th>";str += "<th> </th>";str += "<th> </th>";str += "<th> </th>";str += "<th> </th>";
                   $.each(data.record[0].allowance_type, function (key, value) {
                    if(value == 1 && i==0){

                        var add="ADDITION";
                        i=i+1;

                    }else{
                        var add="";
                       // str += "<td> </td>";
                         i=i+1;
                    }
                     if(value == 2 && j==0){

                        var sub="DEDUCTION";
                         str += "<th> </th>";
                         str += "<th>"+sub+"</th>";
                        
                        j=j+1;
                      }
                      str += "<th>"+add+"</th>";
                     
                     });


                    str += "</tr>";

                   

                     str += "<tr id='table_field_name'><th>Employee ID</th>";
                     str += "<th >Employee Name</th>";
                     str += "<th>Working Days</th>";
                     str += "<th>Present Days</th>";
                     str += "<th>Absent Days</th>";
                     str += "<th>Holidays</th>";
                     str += "<th>Leave</th>";
                     $.each(data.record[0].allowance_addition, function (key, value) {

                        // if(value.type_allowance == 1){

                        // }
                     str += "<th >"+value.name_allowance+"</th>";


                     });

                     str += "<th >Gross </th>";

                     $.each(data.record[0].allowance_deduction, function (key, value) {

                        // if(value.type_allowance == 1){

                        // }
                     str += "<th >"+value.name_allowance+"</th>";


                     });

                      str += "<th width='auto'>Ded</th>";
                     str += "<th>Net</th></tr>";
                     

                     str += "</thead>";
                     str += "<tbody>";

                     $.each(data.record, function (key, value) {

                       str += "<tr><td>"+value.emp_id+"</td>";
                       str += "<td>"+value.emp_name+"</td>";


                        $.each(value.all_present_absent_holiday_leave_day, function (key2, value3) {

                            str += "<td>"+value3.working_day+"</td>";
                            str += "<td>"+value3.present_day+"</td>";
                            str += "<td>"+value3.absent_day+"</td>";
                            str += "<td>"+value3.holi_day+"</td>";
                            str += "<td>"+value3.leave_day+"</td>";

                        });

                        $.each(value.amount_addition, function (key1, value1) {

                            str += "<td>"+value1.amount+"</td>";

                        });

                        str += "<td>"+value.gross+"</td>";

                         $.each(value.amount_deduction, function (key2, value2) {

                            str += "<td>"+value2.amount+"</td>";

                        });

                         str += "<td>"+value.total_deduction+"</td>";

                        str += "<td>"+value.net+"</td></tr>";
  

                     });

                    // str +="<td> "+ emp_id+"</td>";

                     str += "</tbody>";
                     str += "</table>";
                     str += "</div>";

                    $(".search_result").append(str);

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


      $("#btn_saraly_generate").click(function(){
    
             var token = $("input[name='_token']").val();
             var year = $("#year").val();

            // alert(year);
             var month = $("#month").val();
             var designation = $("#designation").val();

              var header = Array();
               var data = Array();
                $("#tbl_salary_generate tr:eq(1) th").each(function(i, v){
                        header[i] = $(this).text();
                })

               
                $("#tbl_salary_generate tbody tr").each(function(i, v){
                    data[i] = Array();
                    $(this).children('td').each(function(ii, vv){
                        data[i][ii] = $(this).text();
                    }); 
                })
                     // alert(header);
                     //   alert(data);

                 $.ajax({
                  type: "post",
                  url: "save_salary_generate",
                  async:false,
                  data:{_token:token,designation:designation,header:header,year:year,month:month,data:data},
                  dataType: 'json',
                  success: function (data) {

                        if(data.status == 1) {
                            var msg = "<strong>SUCCESS:</strong>Salary Generated Successfully";
                            $.confirm({
                                title: 'Success!',
                                type: 'green',
                                icon: 'fa fa-check',
                                content: msg,
                                buttons: {
                                    Ok: function (){
                                        location.reload();
                                    }
                                }
                            });
                        }

                  }
              });

      });

          function  get_all_designation(deg){

            var token = $("input[name='_token']").val();
            $.ajax({
              type: "post",
              url: "get_all_designation",
              data:{_token:'{{csrf_token()}}'},
              dataType: 'json',
              success: function (data) {
              
                $('#designation').html('<option value=""> Select Designation </option>');
                $.each(data.options, function (key, value) {
                
                    $("#designation").append('<option value=' + key + '>' + value + '</option>');
                  
                });

                if(deg != ''){
                    $("#designation").val(deg);
                }

               

              }


            });


         }

     </script>


                      
  
@stop