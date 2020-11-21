<?php $title = 'Employee'; ?>
@extends('layouts.master')
@section('content')

<?php
use App\Http\Controllers\EmployeeController;

 $all_allowance = EmployeeController::get_all_allowance();

 ?>

<style type="text/css" media="screen">

/*.nav-tabs{
  display:inline-flex;
}
.nav-tabs li{
  margin-right: 10px;
  list-style-type:none;
}*/
    
</style>
   <div class="top-bar">
         <div class="-intro-x breadcrumb mr-auto hidden sm:flex">
            <a href="">Application</a>
            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="breadcrumb__icon feather feather-chevron-right">
               <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
            <a href="" class="breadcrumb--active">Employee</a>
         </div>
         <div class="intro-x relative mr-3 sm:mr-6">
        <a href="employee_details"><button type="button" class="btn btn-info">
         <span class="glyphicon glyphicon-search"></span> List of Employee 
        </button></a>
     </div>
    </div>

        <div class=" mt-8 card shadow-lg p-3  bg-white rounded">
           <div class=" items-center h-5">
              <h1 class="text-lg font-medium truncate mr-5"><span id="add_update"> Add </span> Employee</h1>
            </div>

            <div class="card-body" style="background-color: white ;" >
            <div class="row tab-block">
             <div class="col-md-12">
              <div class="tabl-prt">

                <ul class="nav nav-tabs">
                  <li id="personaldetailsTab" class="active"><a id="personalTabid" data-toggle="tab" href="#personaldetails" class="active show"><b>Personal Details</b></a></li>
                  <li id="contactdetailsTab"><a id="contactTabid" data-toggle="tab" href="#contactdetails"><b>Contact Details</b></a></li>
                  <li id="workingdetailsTab"><a id="workingTabid" data-toggle="tab" href="#workingdetails"><b>Working/Joining Details</b></a></li>
                  <li id="salarydetailsTab"><a id="salaryTabid" data-toggle="tab" href="#salarydetails"><b>Salary Details</b></a></li>
               </ul>
            </div>
            </div>
            </div>
            <div class="tab-content">

         <div id="personaldetails" class="tab-pane fade in active show">
            {!! Form::open(['url' => '', 'method' => 'post' ,'name' => 'personaldetails_form', 'id'=>'personaldetails_form']) !!}
            <div class="row">
              <div class="col-sm-12" style="text-align:right"><a class="btn btn-info btn-sm" id="edit_personal">Edit</a></div>
            </div>
            <div class='row'>
              <div class="col-sm-12">
                <h3 class="formheading">Personal Details</h3>
              </div>
          </div>
            <div class="row">
              {!! Form::hidden('personalcode',"",['id'=>'personalcode']) !!}
              <div class="col-sm-6 form-group">
                {!! Form::label('emp_name',"Employee Name",['class'=>'required font-weight-bold']) !!} {!! Form::text('emp_name',null,['class' => 'form-control','id'=>'emp_name', 'placeholder' => 'Employee Name','autocomplete'=>'off','maxLength'=>'50']) !!}
              </div>
              <div class="col-sm-6 form-group">
                {!! Form::label('f_name','Father Name',['class'=>'required font-weight-bold']) !!} {!! Form::text('f_name',null,['class' => 'form-control','id'=>'f_name', 'placeholder' => 'Father Name','autocomplete'=>'off','maxLength'=>'50']) !!}
              </div>
            </div>

            <div class="row">

                <div class="col-sm-6 form-group">
                {!! Form::label('m_name','Mother Name',['class'=>'required font-weight-bold']) !!} {!! Form::text('m_name',null,['class' => 'form-control','id'=>'m_name', 'placeholder' => 'Mother Name','autocomplete'=>'off','maxLength'=>'50']) !!}
              </div>
              <div class="col-sm-6 form-group">
                {!! Form::label('dob',"Date of Birth",['class'=>'required font-weight-bold']) !!} {!! Form::text('dob',null,['class' => 'form-control','id'=>'dob', 'placeholder' => 'Date of Birth','autocomplete'=>'off','maxLength'=>'50']) !!}
              </div>
             
            </div>
          
            <div class="row">
              <div class="col-sm-6 form-group">
                {!! Form::label('gender','Gender',['class'=>'required font-weight-bold']) !!}
                {!! Form::select('gender',['Male'=>'Male','Female'=>'Female','Others'=>'Others'],null,['class' => 'form-control','id'=>'gender','placeholder' => 'Select Gender','maxLength'=>'50']); !!}
              </div>
              <div class="col-sm-6 form-group">
                {!! Form::label('blood_group','Blood Group',['class'=>'font-weight-bold']) !!}
                {!! Form::select('blood_group',[''=>'Select Blood Group','A+'=>'A+','A-'=>'A-','B+'=>'B+','B-'=>'B-','AB+'=>'AB+','AB-'=>'AB-','O+'=>'O+','O-'=>'O-'],null,['class' => 'form-control','id'=>'blood_group','maxLength'=>'50']); !!}
              </div>
            </div>

            <div class="row">
              <div class="col-sm-6 form-group">
                {!! Form::label('marital_status','Merital Status',['class'=>'required font-weight-bold']) !!}
                {!! Form::select('marital_status',[''=>'Select Merital Status','Yes'=>'Yes','No'=>'No'],null,['class' => 'form-control','id'=>'marital_status','maxLength'=>'50']); !!}
              </div>
              <div class="col-sm-6 form-group merital_hideshow" style="display:none;">
                {!! Form::label('spouse_name','Spouse Name',['class'=>'required font-weight-bold']) !!}
                {!! Form::text('spouse_name',null,['class' => 'form-control','id'=>'spouse_name', 'placeholder' => 'Spouse Name','autocomplete'=>'off','maxLength'=>'50']) !!}
              </div>
            
              <div class="col-sm-6 form-group merital_hideshow" style="display:none;">
                {!! Form::label('noofchildren','No of Children',['class'=>'required font-weight-bold']) !!}
                {!! Form::text('noofchildren',null,['class' => 'form-control','id'=>'noofchildren', 'placeholder' => 'No of Children','autocomplete'=>'off','onkeypress'=>'return isNumberKey(event);','maxLength'=>'1']) !!}
              </div>
              <div class="col-sm-6 form-group">
                {!! Form::label('hqualification','Highest Qualification',['class'=>'font-weight-bold']) !!}
                {!! Form::text('hqualification',null,['class' => 'form-control','id'=>'hqualification', 'placeholder' => 'Highest Qualification','autocomplete'=>'off','maxLength'=>'50']) !!}
              </div>
            </div>
        

        
            <div class="row">
              <div class="col-sm-12 form-group text-center" style="padding-top: 5%">
                {!! Form::submit('Save Personal Details',['class' => 'btn btn-primary','type'=>'submit']) !!}
              </div>
            </div>
            {!! Form::close() !!}
          </div>


          <div id="contactdetails" class="tab-pane fade">
            {!! Form::open(['url' => '', 'method' => 'post' ,'name' => 'contactdetails_form', 'id'=>'contactdetails_form']) !!}
            <div class="row">
              <div class="col-sm-12" style="text-align:right"><a class="btn btn-info btn-sm" id="edit_contact">Edit</a></div>
            </div>
            <div class='row'>
                <div class="col-sm-12">
                  <h3 class="formheading">Contact Details</h3>
                </div>
            </div>
            <div class="row">
              {!! Form::hidden('contactcode',"",['id'=>'contactcode']) !!}
            
              <div class="col-sm-6 form-group">
                {!! Form::label('mob_no','Mobile Number',['class'=>'required font-weight-bold']) !!}
                {!! Form::text('mob_no',null,['class' => 'form-control','id'=>'mob_no', 'placeholder' => 'Mobile Number','autocomplete'=>'off','maxLength'=>'10','onkeypress'=>'return isNumberKey(event);']) !!}
              </div>
              <div class="col-sm-6 form-group">
                {!! Form::label('email','Email ID',['class'=>'required font-weight-bold']) !!}
                {!! Form::text('email',null,['class' => 'form-control','id'=>'email', 'placeholder' => ' Email ID','autocomplete'=>'off','maxLength'=>'50']) !!}
              </div>
          </div>
          <div class='row'>
                <div class="col-sm-12">
                    <hr>
                  <h5 class="formheading">Present Address</h5>
                </div>
          </div>
          <div class="row">
                <div class="col-sm-6 form-group">
                    {!! Form::label('c_state','State',['class'=>'required font-weight-bold']) !!} {!! Form::text('c_state',null,['class' => 'form-control','id'=>'c_state', 'placeholder' => 'State','autocomplete'=>'off','maxLength'=>'50']) !!}
                  </div>
                  <div class="col-sm-6 form-group">
                    {!! Form::label('c_dist','District',['class'=>'required font-weight-bold']) !!} {!! Form::text('c_dist',null,['class' => 'form-control','id'=>'c_dist', 'placeholder' => 'District','autocomplete'=>'off','maxLength'=>'50']) !!}
                  </div>
               </div>

            <div class="row">
                <div class="col-sm-6 form-group">
                    {!! Form::label('c_address','Address',['class'=>'required font-weight-bold']) !!} {!! Form::text('c_address',null,['class' => 'form-control','id'=>'c_address', 'placeholder' => 'Address','autocomplete'=>'off','maxLength'=>'100']) !!}
                  </div>
                  <div class="col-sm-6 form-group">
                    {!! Form::label('c_pin','Pin',['class'=>'required font-weight-bold']) !!} {!! Form::text('c_pin',null,['class' => 'form-control','id'=>'c_pin', 'placeholder' => 'Pin','autocomplete'=>'off','maxLength'=>'6','onkeypress'=>'return isNumberKey(event);']) !!}
                  </div>
               </div>
               <div class='row'>
                <div class="col-sm-12">
                     <hr>
                  <h5 class="formheading">Permanent Address</h5>
                  <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                      <label class="form-check-label" for="defaultCheck1">
                        Check if Permanent Address is Same as Present Address
                      </label>
                    </div>
                </div>
          </div>
          <div class="row">
                <div class="col-sm-6 form-group">
                    {!! Form::label('p_state','State',['class'=>'required font-weight-bold']) !!} {!! Form::text('p_state',null,['class' => 'form-control','id'=>'p_state', 'placeholder' => 'State','autocomplete'=>'off','maxLength'=>'50']) !!}
                  </div>
                  <div class="col-sm-6 form-group">
                    {!! Form::label('p_dist','District',['class'=>'required font-weight-bold']) !!} {!! Form::text('p_dist',null,['class' => 'form-control','id'=>'p_dist', 'placeholder' => 'District','autocomplete'=>'off','maxLength'=>'50']) !!}
                  </div>
               </div>

            <div class="row">
                <div class="col-sm-6 form-group">
                    {!! Form::label('p_address','Address',['class'=>'required font-weight-bold']) !!} {!! Form::text('p_address',null,['class' => 'form-control','id'=>'p_address', 'placeholder' => 'Address','autocomplete'=>'off','maxLength'=>'100']) !!}
                  </div>
                  <div class="col-sm-6 form-group">
                    {!! Form::label('p_pin','Pin',['class'=>'required font-weight-bold']) !!} {!! Form::text('p_pin',null,['class' => 'form-control','id'=>'p_pin', 'placeholder' => 'Pin','autocomplete'=>'off','maxLength'=>'6','onkeypress'=>'return isNumberKey(event);']) !!}
                  </div>
               </div>
                <hr>
               <div class="row">
                <div class="col-sm-6 form-group">
                    {!! Form::label('contact_person','Contact Person',['class'=>'required font-weight-bold']) !!} {!! Form::text('contact_person',null,['class' => 'form-control','id'=>'contact_person', 'placeholder' => 'Contact Person','autocomplete'=>'off' ,'maxLength'=>'50']) !!}
                  </div>
                  <div class="col-sm-6 form-group">
                    {!! Form::label('relationship','Relationship With Contact Person',['class'=>'required font-weight-bold']) !!} {!! Form::text('relationship',null,['class' => 'form-control','id'=>'relationship', 'placeholder' => 'Relationship With Contact Person','autocomplete'=>'off','maxLength'=>'50']) !!}
                  </div>
               </div>

               <div class="row">
                <div class="col-sm-6 form-group">
                    {!! Form::label('emg_address','Emergency Address',['class'=>'required font-weight-bold']) !!} {!! Form::text('emg_address',null,['class' => 'form-control','id'=>'emg_address', 'placeholder' => 'Emergency Address','autocomplete'=>'off','maxLength'=>'100']) !!}
                  </div>
                  <div class="col-sm-6 form-group">
                    {!! Form::label('emg_mob_no','Emergency Mobile No',['class'=>'required font-weight-bold']) !!} {!! Form::text('emg_mob_no',null,['class' => 'form-control','id'=>'emg_mob_no', 'placeholder' => 'Emergency Mobile No','autocomplete'=>'off','maxLength'=>'10','onkeypress'=>'return isNumberKey(event);']) !!}
                  </div>
               </div>
          <div class="row">
              <div class="col-sm-12 form-group text-center" style="padding-top: 5%">
                {!! Form::submit('Save Contact Details',['class' => 'btn btn-primary','type'=>'submit']) !!}
              </div>
            </div>
            {!! Form::close() !!}
          </div>


          <div id="workingdetails" class="tab-pane fade">
            {!! Form::open(['url' => '', 'method' => 'post' ,'name' => 'workingdetails_form', 'id'=>'workingdetails_form']) !!}
            <div class="row">
              <div class="col-sm-12" style="text-align:right"><a class="btn btn-info btn-sm" id="edit_working">Edit</a></div>
            </div>
            <div class='row'>
                <div class="col-sm-12">
                  <h3 class="formheading">Working Details</h3>
                </div>
            </div>
            <div class="row">
              {!! Form::hidden('workingcode',"",['id'=>'workingcode']) !!}
            
              <div class="col-sm-6 form-group">
                {!! Form::label('emp_type','Employee Type',['class'=>'required font-weight-bold']) !!}
                {!! Form::select('emp_type',[''=>'Select Employee Trpe','1'=>'Supervisor','2'=>'Worker'],null,['class' => 'form-control','id'=>'emp_type']); !!}
              </div>
              <div class="col-sm-6 form-group">
                {!! Form::label('emp_designation','Designation',['class'=>'required font-weight-bold']) !!}
                {!! Form::select('emp_designation',[''=>'Select Designation'],null,['class' => 'form-control','id'=>'emp_designation']); !!}
              </div>
              </div>
              <div class='row'>
                <div class="col-sm-6 form-group">
                {!! Form::label('emp_deparment','Department',['class'=>'required font-weight-bold']) !!}
                {!! Form::select('emp_deparment',[''=>'Select Department'],null,['class' => 'form-control','id'=>'emp_deparment']); !!}
              </div> 
               </div>
                <div class='row'>
                <div class="col-sm-12">
                    <hr>
                  <h3 class="formheading">Joining Details</h3>
                </div>
            </div>
            <div class='row'>
                <div class="col-sm-6 form-group">
                {!! Form::label('joining_date','Joining Date',['class'=>'required font-weight-bold']) !!}
                {!! Form::text('joining_date',null,['class' => 'form-control','id'=>'joining_date', 'placeholder' => 'Joining Date','autocomplete'=>'off','maxLength'=>'50']) !!}
              </div> 
              <div class="col-sm-6 form-group">
                {!! Form::label('per_day_salary','Per day salary',['class'=>'required font-weight-bold']) !!}
                {!! Form::text('per_day_salary',null,['class' => 'form-control','id'=>'per_day_salary', 'placeholder' => 'Per day salary','autocomplete'=>'off','maxLength'=>'5','onkeypress'=>'return isNumberKey(event);']) !!}
              </div>
               </div>

              <div class='row'>
              <div class="col-sm-12 form-group text-center" style="padding-top: 5%">
                {!! Form::submit('Save Working Details',['class' => 'btn btn-primary','type'=>'submit']) !!}
              </div>
            </div>
            {!! Form::close() !!}
          </div>

          <div id="salarydetails" class="tab-pane fade">
            {!! Form::open(['url' => '', 'method' => 'post' ,'name' => 'salarydetails_form', 'id'=>'salarydetails_form']) !!}
            <div class="row">
              <div class="col-sm-12" style="text-align:right"><a class="btn btn-info btn-sm" id="edit_salary">Edit</a></div>
            </div>
            <div class='row'>
                <div class="col-sm-12">
                  <h3 class="formheading">Salary Details</h3>
                </div>
            </div>
             {!! Form::hidden('salarycode',"",['id'=>'salarycode']) !!}
             <?php $i=0; $j=0; $addition=''; $deduction=''; ?>

              <?php  foreach ($all_allowance as $key => $singledata){  ?>



              <?php if ($singledata->allowance_type == 1 && $i == 0){
           
                $addition = 'ADDITION' ;
                 $i=$i+1; 
               }else{
                     $addition='';
                      $i=$i+1; 
                }

                if ($singledata->allowance_type == 2 && $j == 0){

                $deduction='DEDUCTION';
                
                  $j=$j+1;

               }else{
                     $deduction='';
                      $i=$i+1; 
                }

                ?>

                <?php

                if($addition != ''){ ?>

                 <div>
                    <h5><?php echo  $addition; ?> </h5>
                    
                </div>


              <?php  } ?>

               <?php

                if($deduction != ''){ ?>

                <div>
                    <h5><?php echo  $deduction; ?> </h5>
                    
                </div>


              <?php  } ?>



                 

               

                 


            <div class="{{$singledata['name_of_allowance']}} row" style="display:none;">
              <div class=" col-sm-2 form-group " style="">
                {!! Form::label($singledata['name_of_allowance'],$singledata['name_of_allowance'],['class'=>'required font-weight-bold']) !!}
            </div>
            <div class="col-sm-2 form-group">
               {{--  {!! Form::label('month_day_wise','',['class'=>'required font-weight-bold']) !!} --}}
                {!! Form::select('month_day_wise'.$key,[''=>'Select Salary Type','1'=>'Month Wise','2'=>'Day Wise'],null,['class' => 'form-control month_day_wise','id'=>'month_day_wise'.$key]); !!}
              </div>


             <?php if($singledata['name_of_allowance'] != 'BASIC') {?>

              <div class="col-sm-2 form-group fixed_persentage_div">
               {{--  {!! Form::label('month_day_wise','',['class'=>'required font-weight-bold']) !!} --}}
                {!! Form::select('fixed_persentage'.$key,[''=>'Select','1'=>'Fixed','2'=>'Persentage'],null,['class' => 'form-control fixed_persentage','id'=>'fixed_persentage'.$key]); !!}
              </div>

              <div class="col-sm-1 form-group on_div{{$key}}" style='display:none'>
                <h5>ON</h5>
              
              </div>

              <div class="col-sm-2 form-group all_allowance_div{{$key}}" style='display:none'>
               {{--  {!! Form::label('month_day_wise','',['class'=>'required font-weight-bold']) !!} --}}
                {!! Form::select('all_allowance'.$key,[''=>'Select','1'=>'BASIC'],null,['class' => 'form-control all_allowance','id'=>'all_allowance'.$key]); !!}
              </div>

              <?php } ?>





            <div class=" col-sm-2 form-group amount_div{{$key}}">
                {!! Form::text($singledata['name_of_allowance'],null,['class' => 'form-control','id'=>$singledata['name_of_allowance'], 'placeholder' => 'Amount/%','autocomplete'=>'off','maxLength'=>'50']) !!}
              </div> 
              
              </div>
              <?php  } ?>

            
             

              <div class='row'>
              <div class="col-sm-12 form-group text-center" style="padding-top: 5%">
                {!! Form::submit('Save Salary Details',['class' => 'btn btn-primary','type'=>'submit']) !!}
              </div>
            </div>
            {!! Form::close() !!}
          </div>

             
            </div>  
            </div>
        
        </div>



     <script type="text/javascript">
         
         $(function () { 

            get_all_designation('');
            get_all_department('');
            //get_all_allowance('','');

          <?php if (isset($emp_cdd)) { ?>

            $("#personalcode").val("<?php echo $emp_cdd ;?>");
            $("#contactcode").val("<?php echo $emp_cdd ;?>");
            $("#workingcode").val("<?php echo $emp_cdd ;?>");
            $("#salarycode").val("<?php echo $emp_cdd ;?>");
            $("#save_update").html('Update');
            $("#add_update").html('Update');
            personal_details_show("<?php echo $emp_cdd ;?>");
            contact_details_show("<?php echo $emp_cdd ;?>");
            working_details_show("<?php echo $emp_cdd ;?>");
            salary_details_show("<?php echo $emp_cdd ;?>");

            $("#edit_personal").show();
            $("#edit_contact").show();
            $("#edit_working").show();
            $("#edit_salary").show();
            
            
           
            

          <?php }else{ ?>
            $("#edit_personal").hide();
            $("#edit_contact").hide();
            $("#edit_working").hide();
            $("#edit_salary").hide();

         <?php } ?>

         $(".fixed_persentage").change(function(){

           var id=this.id;
           var value=$("#"+id).val();
           myArray = id.split(/([0-9]+)/);
           if(value == 2){

            $(".on_div"+myArray[1]).show();
            $(".all_allowance_div"+myArray[1]).show();

           }else{

            $(".on_div"+myArray[1]).hide();
            $(".all_allowance_div"+myArray[1]).hide();
           }


         });


            $('#dob').datepicker({
                autoclose: true,
                format: "dd/mm/yyyy",
                todayHighlight: true,   
              }).on('change', function (e) {
                $('#personaldetails_form').bootstrapValidator('revalidateField', 'dob');
              });

              $('#joining_date').datepicker({
                autoclose: true,
                format: "dd/mm/yyyy",
                todayHighlight: true,   
              }).on('change', function (e) {
                $('#workingdetails_form').bootstrapValidator('revalidateField', 'joining_date');
              });

              $("#marital_status").change(function(){
                var marital_status=$("#marital_status").val();
                if(marital_status == "Yes"){
                    $(".merital_hideshow").show(); 
                }else{
                    $(".merital_hideshow").hide();
                }
              });

              $('#defaultCheck1').change(function(){
                var c = this.checked ;
                if(c == true){
                  
                   var c_state =$("#c_state").val();
                   var c_dist =$("#c_dist").val();
                   var c_address =$("#c_address").val();
                   var c_pin =$("#c_pin").val();
                  
                   $("#p_state").val(c_state);
                   $("#p_dist").val(c_dist);
                   $("#p_address").val(c_address);
                   $("#p_pin").val(c_pin);


                }else{

                   $("#p_state").val('');
                   $("#p_dist").val('');
                   $("#p_address").val('');
                   $("#p_pin").val('');

                }
               
              });

              $('#edit_personal').click(function () {
                $('#personaldetails_form')
                        .find("input[type=text],input[type=hidden],input[type=email],textarea,select,input[type=file]")
                        .removeAttr('readonly').removeAttr('disabled')
                        .find("input[type=checkbox], input[type=radio]").removeProp("disabled", "true")
                        .find('select').removeAttr('disabled').end();
                $('#edit_personal').hide();
                $('#personaldetails_form').find('input[type=submit]').show();
             

              });
              $('#edit_contact').click(function () {
                $('#contactdetails_form')
                        .find("input[type=text],input[type=hidden],input[type=email],textarea,select,input[type=file]")
                        .removeAttr('readonly').removeAttr('disabled')
                        .find("input[type=checkbox], input[type=radio]").removeProp("disabled", "true")
                        .find('select').removeAttr('disabled').end();
                $('#edit_contact').hide();
                $('#contactdetails_form').find('input[type=submit]').show();
             

              });
              $('#edit_working').click(function () {
                $('#workingdetails_form')
                        .find("input[type=text],input[type=hidden],input[type=email],textarea,select,input[type=file]")
                        .removeAttr('readonly').removeAttr('disabled')
                        .find("input[type=checkbox], input[type=radio]").removeProp("disabled", "true")
                        .find('select').removeAttr('disabled').end();
                $('#edit_working').hide();
                $('#workingdetails_form').find('input[type=submit]').show();
             

              });

              $('#edit_salary').click(function () {
                $('#salarydetails_form')
                        .find("input[type=text],input[type=hidden],input[type=email],textarea,select,input[type=file]")
                        .removeAttr('readonly').removeAttr('disabled')
                        .find("input[type=checkbox], input[type=radio]").removeProp("disabled", "true")
                        .find('select').removeAttr('disabled').end();
                $('#edit_salary').hide();
                $('#salarydetails_form').find('input[type=submit]').show();
             

              });


             $('#personaldetails_form').bootstrapValidator({
                message: 'This value is not valid',
                feedbackIcons: {
                    
                },

                fields: {
                    emp_name: {
                        validators: {
                            notEmpty: {
                                message: 'Employee Name is Required'
                            },
                            regexp: {
                                regexp: /^([a-zA-Z]+\s?)*$/,
                                message: 'Only Alphabate and Space Allowed Here',
                            },
                        }
                    },
                    f_name: {
                        validators: {
                            notEmpty: {
                                message: "Father's Name is Required"
                            },
                            regexp: {
                                regexp: /^([a-zA-Z]+\s?)*$/,
                                message: 'Only Alphabate and Space Allowed Here',
                            },
                        }
                    },
                    m_name: {
                        validators: {
                            notEmpty: {
                                message: "Mother's Name is Required"
                            },
                            regexp: {
                                regexp: /^([a-zA-Z]+\s?)*$/,
                                message: 'Only Alphabate and Space Allowed Here',
                            },
                        }
                    },
                    dob: {
                        validators: {
                            notEmpty: {
                                message: 'Date of Birth is Required'
                            },
                            date: {
                                format: 'DD/MM/YYYY',
                                message: 'Date Format is not Valid'
                            }
                        }
                    },
                    gender: {
                        validators: {
                            notEmpty: {
                                message: 'Gender is Required'
                            }
                        }
                    },
                    blood_group: {
                        validators: {
                            
                        }
                    },
                    marital_status: {
                        validators: {
                            notEmpty: {
                                message: 'Marital Status is Required'
                            }
                        }
                    },
                    spouse_name: {
                        validators: {
                             notEmpty: {
                                message: 'Spouse Name is Required'
                            },
                            regexp: {
                                regexp: /^([a-zA-Z]+\s?)*$/,
                                message: 'Only Alphabate and Space Allowed Here',
                            },
                            
                        }
                    },
                    noofchildren: {
                        validators: {
                             notEmpty: {
                                message: 'No of Children is Required'
                            },
                            integer: {
                              message: 'No of Children Should be in Digits'
                          }
                            
                        }
                    },
                    hqualification: {
                        validators: {

                            regexp: {
                                regexp: /^([a-zA-Z0-9]+\s?)*$/,
                                message: 'Only Alphanumeric and Space Allowed Here',
                            },
                           
                        }
                    },    

                }
            }).on('success.form.bv', function (e) {
                e.preventDefault();
                save_personal_details();               
            });


             $('#contactdetails_form').bootstrapValidator({
                message: 'This value is not valid',
                feedbackIcons: {
                    
                },

                fields: {
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
                    email: {
                        validators: {
                            notEmpty: {
                                message: "Email ID is Required"
                            },
                            emailAddress: {
                            message: 'Email Address is not Valid'
                           }
                        }
                    },
                    c_state: {
                        validators: {
                            notEmpty: {
                                message: "State is Required"
                            },
                            regexp: {
                                regexp: /^([a-zA-Z0-9]+\s?)*$/,
                                message: 'Only Alphanumeric and Space Allowed Here',
                            },
                        }
                    },
                    c_dist: {
                        validators: {
                            notEmpty: {
                                message: 'District is Required'
                            },
                            regexp: {
                                regexp: /^([a-zA-Z0-9]+\s?)*$/,
                                message: 'Only Alphanumeric and Space Allowed Here',
                            },
                        }
                    },
                    c_address: {
                        validators: {
                            notEmpty: {
                                message: 'Address is Required'
                            },
                            regexp: {
                                regexp: /^([a-zA-Z0-9/-]+\s?)*$/,
                                message: 'Only Alphanumeric Space and /- Allowed Here',
                            },
                        }
                    },
                    c_pin: {
                        validators: {
                            notEmpty: {
                                message: 'Pin is Required'
                            },
                          stringLength: {
                                min: 6,
                                max: 6,
                                message: 'Pin Number must be 6 Digits',
                              }
                            
                        }
                    },
                    p_state: {
                        validators: {
                            notEmpty: {
                                message: 'State is Required'
                            },
                            regexp: {
                                regexp: /^([a-zA-Z0-9]+\s?)*$/,
                                message: 'Only Alphanumeric and Space Allowed Here',
                            },
                        }
                    },
                    p_dist: {
                        validators: {
                            notEmpty: {
                                message: 'District is Required'
                            },
                            regexp: {
                                regexp: /^([a-zA-Z0-9]+\s?)*$/,
                                message: 'Only Alphanumeric and Space Allowed Here',
                            },
                            
                        }
                    },
                    p_address: {
                        validators: {
                            notEmpty: {
                              message: 'Address is Required'
                          },
                            regexp: {
                                regexp: /^([a-zA-Z0-9/-]+\s?)*$/,
                                message: 'Only Alphanumeric Space and /- Allowed Here',
                            },
                            
                        }
                    },
                    p_pin: {
                        validators: {
                             notEmpty: {
                              message: 'Pin is Required'
                          },
                          stringLength: {
                                min: 6,
                                max: 6,
                                message: 'Pin Number must be 6 Digits',
                              }
                           
                        }
                    },
                    contact_person: {
                        validators: {
                            notEmpty: {
                              message: 'Contact Person is Required'
                          },
                            regexp: {
                                regexp: /^([a-zA-Z]+\s?)*$/,
                                message: 'Only Alphabate and Space Allowed Here',
                            },
                            
                        }
                    },
                    relationship: {
                        validators: {
                            notEmpty: {
                              message: 'Relationship with Contact Person is Required'
                            },
                            regexp: {
                                regexp: /^([a-zA-Z]+\s?)*$/,
                                message: 'Only Alphabate and Space Allowed Here',
                            },
                            
                        }
                    },
                    emg_address: {
                        validators: {
                            notEmpty: {
                              message: 'Emergency Address is Required'
                          },
                            regexp: {
                                regexp: /^([a-zA-Z0-9/-]+\s?)*$/,
                                message: 'Only Alphanumeric Space and /- Allowed Here',
                            },
                            
                        }
                    },
                    emg_mob_no: {
                        validators: {
                            notEmpty: {
                              message: 'Emergency Mobile Number is Required'
                          },
                            stringLength: {
                                min: 10,
                                max: 10,
                                message: 'Emergency Mobile Number must be 10 Digits',
                              }
                            
                        }
                    },    

                }
            }).on('success.form.bv', function (e) {
                e.preventDefault();
                save_contact_details();               
            }); 

            $('#workingdetails_form').bootstrapValidator({
                message: 'This value is not valid',
                feedbackIcons: {
                    
                },

                fields: {
                    emp_type: {
                        validators: {
                            notEmpty: {
                                message: 'Employee Type is Required'
                            }
                        }
                    },
                    emp_designation: {
                        validators: {
                            notEmpty: {
                                message: "Designation is Required"
                            }
                        }
                    },
                    emp_deparment: {
                        validators: {
                            notEmpty: {
                                message: "Department is Required"
                            }
                        }
                    },
                    joining_date: {
                        validators: {
                            notEmpty: {
                                message: 'Joining Date is Required'
                            },
                            date: {
                                format: 'DD/MM/YYYY',
                                message: 'Date Format is not Valid'
                            }
                        }
                    },
                    per_day_salary: {
                        validators: {
                            notEmpty: {
                                message: 'Per Day Salary is Required'
                            }
                        }
                    }
                }
            }).on('success.form.bv', function (e) {
                e.preventDefault();
                save_working_details();               
            });

              $('#salarydetails_form').bootstrapValidator({
                message: 'This value is not valid',
                feedbackIcons: {
                    
                },

                fields: {
                    month_day_wise: {
                        validators: {
                            notEmpty: {
                                message: 'Employee Type is Required'
                            }
                        }
                    },

              <?php  foreach ($all_allowance as $key => $singledata){  ?>

               {{$singledata['name_of_allowance']}}: {
                        validators: {
                            notEmpty: {
                                message: '{{$singledata['name_of_allowance']}} is Required'
                            }
                        }
                    },
               month_day_wise{{$key}}: {
                        validators: {
                            notEmpty: {
                                message: 'Salary Type is Required'
                            }
                        }
                    },
                fixed_persentage{{$key}}: {
                    validators: {
                        notEmpty: {
                            message: 'Fixed/Persentage is Required'
                        }
                    }
                },
                all_allowance{{$key}}: {
                    validators: {
                        notEmpty: {
                            message: 'Select Persentahe On Allowance'
                        }
                    }
                },
                
              <?php  } ?>

                   
                }
            }).on('success.form.bv', function (e) {
                e.preventDefault();
                save_salary_details();               
            });  

         });

        function save_salary_details(){

              var token = $("input[name='_token']").val();
             
             // var month_day_wise = $("#month_day_wise").val();
              var formData_save = new FormData();

              var arr1 = [];
              var arr2 = [];
              var arr_month_day = [];
              var fixed_persentage = [];
              var all_allowance = [];

              <?php  foreach ($all_allowance as $key => $singledata){  ?> 

                var qq = $("#<?php echo $singledata['name_of_allowance']  ?>").val();
                 var month_yearr = $("#month_day_wise<?php echo $key  ?>").val();
                var fixed_per = $("#fixed_persentage<?php echo $key  ?>").val();
                var all_allow = $("#all_allowance<?php echo $key  ?>").val();

               // alert(all_allow);

                if(qq != '' && qq != null){

                     arr1.push('<?php echo $singledata['code'] ?>');
                     arr2.push(qq);
                     arr_month_day.push(month_yearr);
                     fixed_persentage.push(fixed_per);
                     all_allowance.push(all_allow);


                }
               
              
              

              <?php  } ?>

            //  exit();

                var salarycode = $("#salarycode").val();
            
                formData_save.append('_token', '{{csrf_token()}}');
               // formData_save.append('month_day_wise', month_day_wise);
                formData_save.append('arr1', arr1);
                formData_save.append('arr2', arr2);
                 formData_save.append('arr_month_day', arr_month_day);
                  formData_save.append('fixed_persentage', fixed_persentage);
                   formData_save.append('all_allowance', all_allowance);
                formData_save.append('salarycode', salarycode);
                
           
            $(".se-pre-con").fadeIn("slow");
                $.ajax({
                    type: "POST",
                    url: "salarydetails_save_update",
                    data: formData_save,
                    processData: false,
                    contentType: false,
                    dataType: "json",
                     success: function (data) {

                        if (data.status == 1) {

                             $.confirm({
                        title: 'Success!',
                        type: 'green',
                        icon: 'fa fa-check',
                        content: "Salary Details Saved Successfully",
                        buttons: {
                            ok: function () {

                                  location.reload();
                            }
                         }
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

           function  save_working_details(){
           
             var token = $("input[name='_token']").val();
             
             var emp_type = $("#emp_type").val();
             var emp_designation = $("#emp_designation").val();
             var emp_deparment = $("#emp_deparment").val();
             var joining_date = $("#joining_date").val();
             var per_day_salary = $("#per_day_salary").val();
             var workingcode = $("#workingcode").val();

             var formData_save = new FormData();
                formData_save.append('_token', '{{csrf_token()}}');
                formData_save.append('emp_type', emp_type);
                formData_save.append('emp_designation', emp_designation);
                formData_save.append('emp_deparment', emp_deparment);
                formData_save.append('joining_date', joining_date);
                formData_save.append('per_day_salary', per_day_salary); 
                formData_save.append('workingcode', workingcode);
           
            $(".se-pre-con").fadeIn("slow");
                $.ajax({
                    type: "POST",
                    url: "workingdetails_save_update",
                    data: formData_save,
                    processData: false,
                    contentType: false,
                    dataType: "json",
                     success: function (data) {

                         if (data.status == 1) {
                              var workingcode = data.code;
                             // alert(workingcode);
                              $('#salarycode').val(workingcode);

                         $.each(data.allowance_all, function (key, value) {

                         //   alert(value.name_of_allowance);
                
                           $("."+value.name_of_allowance).show();
                          
                        });

                  
                        var msg = "<strong>SUCCESS: </strong>Working Details Saved Successfully";

                         $.confirm({
                        title: 'Success!',
                        type: 'green',
                        icon: 'fa fa-check',
                        content: msg,
                        buttons: {
                            ok: function () {

                                $('#workingdetails_form').find("input[type=text],input[type=file],input[type=hidden],input[type=email],textarea,select").val('');
                                $('#workingdetails_form').bootstrapValidator('resetForm', true);
                                $('#workingdetails_form').find("input[type=text],input[type=file],input[type=hidden],input[type=email],textarea,select").attr('disabled', '');
                                 working_details_show(workingcode);
                                
                                $('#workingTabid').removeClass('active').removeClass('show');
                                $('#workingdetailsTab').removeClass('active');
                                $('#workingdetails').removeClass('active').removeClass('in').removeClass('show');
                                $('#salaryTabid').addClass('active').addClass('show');
                                $('#salarydetailsTab').addClass('active');
                                $('#salarydetails').addClass('active').addClass('in').addClass('show');
                                
                              
                              // location.reload();

                                
                            }

                        }
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

             function  save_contact_details(){
             
             var token = $("input[name='_token']").val();
             
             var mob_no = $("#mob_no").val();
             var email = $("#email").val();
             var c_state = $("#c_state").val();
             var c_dist = $("#c_dist").val();
             var c_address = $("#c_address").val();
             var c_pin = $("#c_pin").val();
             var p_state = $("#p_state").val();
             var p_dist = $("#p_dist").val();
             var p_address = $("#p_address").val();
             var p_pin = $("#p_pin").val();
             var contact_person = $("#contact_person").val();
             var relationship = $("#relationship").val();
             var emg_address = $("#emg_address").val();
             var emg_mob_no = $("#emg_mob_no").val();
             var contactcode = $("#contactcode").val();

             var formData_save = new FormData();
                formData_save.append('_token', '{{csrf_token()}}');
                formData_save.append('email', email);
                formData_save.append('c_state', c_state);
                formData_save.append('c_dist', c_dist);
                formData_save.append('c_address', c_address);
                formData_save.append('c_pin', c_pin);
                formData_save.append('p_state', p_state);
                formData_save.append('p_dist', p_dist);
                formData_save.append('p_address', p_address);
                formData_save.append('p_pin', p_pin);
                formData_save.append('mob_no', mob_no);
                formData_save.append('contact_person', contact_person);
                formData_save.append('relationship', relationship);
                formData_save.append('emg_address', emg_address);
                formData_save.append('emg_mob_no', emg_mob_no);
                formData_save.append('contactcode', contactcode);
           
            $(".se-pre-con").fadeIn("slow");
                $.ajax({
                    type: "POST",
                    url: "contactdetails_save_update",
                    data: formData_save,
                    processData: false,
                    contentType: false,
                    dataType: "json",
                     success: function (data) {

                     var contactcode = data.code;
                     $('#workingcode').val(contactcode);

                         if (data.status == 1) {
                  
                        var msg = "<strong>SUCCESS: </strong>Contact Details Saved Successfully";

                         $.confirm({
                        title: 'Success!',
                        type: 'green',
                        icon: 'fa fa-check',
                        content: msg,
                        buttons: {
                            ok: function () {
                                
                                $('#contactdetails_form').find("input[type=text],input[type=file],input[type=hidden],input[type=email],textarea,select").val('');
                                 $('#contactdetails_form').bootstrapValidator('resetForm', true);
                                $('#contactdetails_form').find("input[type=text],input[type=file],input[type=hidden],input[type=email],textarea,select").attr('disabled', '');
                                 contact_details_show(contactcode);
                                
                                $('#contactTabid').removeClass('active').removeClass('show');
                                $('#contactdetailsTab').removeClass('active');
                                $('#contactdetails').removeClass('active').removeClass('in').removeClass('show');
                                $('#workingTabid').addClass('active').addClass('show');
                                $('#workingdetailsTab').addClass('active');
                                $('#workingdetails').addClass('active').addClass('in').addClass('show');
                               // $(".se-pre-con").fadeOut("slow");

                                
                            }

                        }
                    });
                       
                    }
                    // else if(data.status == 2)
                    // {
                       
                    //      var msg = "<strong>SUCCESS: </strong>Contact Details Updated Successfully";

                    //       $.confirm({
                    //     title: 'Success!',
                    //     type: 'green',
                    //     icon: 'fa fa-check',
                    //     content: msg,
                    //     buttons: {
                    //         ok: function () {
                                
                               
                    //             $('#contactdetails_form').find("input[type=text],input[type=file],input[type=hidden],input[type=email],textarea,select").val('');
                    //              $('#contactdetails_form').bootstrapValidator('resetForm', true);
                    //             $('#contactdetails_form').find("input[type=text],input[type=file],input[type=hidden],input[type=email],textarea,select").attr('disabled', '');
                    //              contact_details_show(contactcode);
                                
                    //             $('#contactTabid').removeClass('active').removeClass('show');
                    //             $('#contactdetailsTab').removeClass('active');
                    //             $('#contactdetails').removeClass('active').removeClass('in').removeClass('show');
                    //             $('#workingTabid').addClass('active').addClass('show');
                    //             $('#workingdetailsTab').addClass('active');
                    //             $('#workingdetails').addClass('active').addClass('in').addClass('show');
                    //             $('#edit_contact').show();
                    //             //$(".se-pre-con").fadeOut("slow");
                    //             // location.reload();
                    //         }

                    //     }
                    // });

                    // }
                     
                    


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

       function  save_personal_details(){

             var token = $("input[name='_token']").val();

             var emp_name = $("#emp_name").val();
             var f_name = $("#f_name").val();
             var m_name = $("#m_name").val();
             var dob = $("#dob").val();
             var gender = $("#gender").val();
             var blood_group = $("#blood_group").val();
             var marital_status = $("#marital_status").val();
             var spouse_name = $("#spouse_name").val();
             var noofchildren = $("#noofchildren").val();
             var hqualification = $("#hqualification").val();
             var personalcode = $("#personalcode").val();

             var formData_save = new FormData();
                formData_save.append('_token', token);
                formData_save.append('emp_name', emp_name);
                formData_save.append('f_name', f_name);
                formData_save.append('m_name', m_name);
                formData_save.append('dob', dob);
                formData_save.append('gender', gender);
                formData_save.append('blood_group', blood_group);
                formData_save.append('marital_status', marital_status);
                formData_save.append('spouse_name', spouse_name);
                formData_save.append('noofchildren', noofchildren);
                formData_save.append('hqualification', hqualification);
                formData_save.append('personalcode', personalcode);
           
            $(".se-pre-con").fadeIn("slow");
                $.ajax({
                    type: "POST",
                    url: "personaldetails_save_update",
                    data: formData_save,
                    processData: false,
                    contentType: false,
                    dataType: "json",
                     success: function (data) {

                     var personalcode = data.code;
                     $('#contactcode').val(personalcode);

                         if (data.status == 1) {
                  
                        var msg = "<strong>SUCCESS: </strong>Personal Details saved Successfully";

                         $.confirm({
                        title: 'Success!',
                        type: 'green',
                        icon: 'fa fa-check',
                        content: msg,
                        buttons: {
                            ok: function () {
                                
                                $('#personaldetails_form').find("input[type=text],input[type=file],input[type=hidden],input[type=email],textarea,select").val('');
                                 $('#personaldetails_form').bootstrapValidator('resetForm', true);
                                $('#personaldetails_form').find("input[type=text],input[type=file],input[type=hidden],input[type=email],textarea,select").attr('disabled', '');
                                 personal_details_show(personalcode);
                                
                                $('#personalTabid').removeClass('active').removeClass('show');
                                $('#personaldetailsTab').removeClass('active');
                                $('#personaldetails').removeClass('active').removeClass('in').removeClass('show');
                                $('#contactTabid').addClass('active').addClass('show');
                                $('#contactdetailsTab').addClass('active');
                                $('#contactdetails').addClass('active').addClass('in').addClass('show');
                               // $(".se-pre-con").fadeOut("slow");

                                
                            }

                        }
                    });
                       
                    }
                    else if(data.status == 2)
                    {
                       
                         var msg = "<strong>SUCCESS: </strong>Personal Details Updated Successfully";

                          $.confirm({
                        title: 'Success!',
                        type: 'green',
                        icon: 'fa fa-check',
                        content: msg,
                        buttons: {
                            ok: function () {
                                
                               
                                 $('#personaldetails_form').bootstrapValidator('resetForm', true);
                                 $('#personaldetails_form').find("input[type=text],input[type=file],input[type=hidden],input[type=email],textarea,select").val('');
                                $('#personaldetails_form').find("input[type=text],input[type=file],input[type=hidden],input[type=email],textarea,select").attr('readonly', '');
                                 personal_details_show(personalcode);
                               
                                
                                $('#personalTabid').removeClass('active').removeClass('show');
                                $('#personaldetailsTab').removeClass('active');
                                $('#personaldetails').removeClass('active').removeClass('in').removeClass('show');
                                $('#contactTabid').addClass('active').addClass('show');
                                $('#contactdetailsTab').addClass('active');
                                $('#contactdetails').addClass('active').addClass('in').addClass('show');
                                $('#edit_personal').show();
                                //$(".se-pre-con").fadeOut("slow");
                                // location.reload();
                            }

                        }
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

            function  get_all_allowance(all_code,key){

            var token = $("input[name='_token']").val();
            $.ajax({
              type: "post",
              url: "get_all_allowance",
              data:{_token:'{{csrf_token()}}'},
              dataType: 'json',
              success: function (data) {
              
                $('.all_allowance').html('<option value="">Select</option>');
                $.each(data.options, function (key, value) {
                
                    $(".all_allowance").append('<option value=' + key + '>' + value + '</option>');
                  
                });

                // if(all_code != ''){
                //     $("#all_allowance"+key).val(all_code);
                // }

              }


            });


         }

         //  function  get_all_allowance_edit(all_code,key){


         //        if(all_code != ''){
         //            $("#all_allowance"+key).val(all_code);
         //        }



         // }

         function  get_all_designation(des){

            var token = $("input[name='_token']").val();
            $.ajax({
              type: "post",
              url: "get_all_designation",
              data:{_token:'{{csrf_token()}}'},
              dataType: 'json',
              success: function (data) {
              
                $('#emp_designation').html('<option value=""> Select Designation </option>');
                $.each(data.options, function (key, value) {
                
                    $("#emp_designation").append('<option value=' + key + '>' + value + '</option>');
                  
                });

                if(des != ''){
                    $("#emp_designation").val(des);
                }

              }


            });


         }

         function  get_all_department(dep){

            var token = $("input[name='_token']").val();
            $.ajax({
              type: "post",
              url: "get_all_department",
              data:{_token:'{{csrf_token()}}'},
              dataType: 'json',
              success: function (data) {
              
                $('#emp_deparment').html('<option value=""> Select Department </option>');
                $.each(data.options, function (key, value) {
                
                    $("#emp_deparment").append('<option value=' + key + '>' + value + '</option>');
                  
                });

                if(dep != ''){
                    $("#emp_deparment").val(dep);
                }

              }

            });


         }

         function personal_details_show(code){
            
             $.ajax({
                url: "get_personal_details",
                method: 'post',
                async: false,
                data: {
                  'code': code,
                  '_token': '{{csrf_token()}}',
                },
                success: function (data) {
                  $('#personalcode').val(data.personal_dtl.code);
                  $('#dob').val(data.personal_dtl.dob);
                  $('#emp_name').val(data.personal_dtl.emp_name);
                  $('#f_name').val(data.personal_dtl.father_name);
                  $('#gender').val(data.personal_dtl.gender);
                  $('#m_name').val(data.personal_dtl.mother_name);
                  $('#blood_group').val(data.personal_dtl.blood_group);
                  $('#hqualification').val(data.personal_dtl.hqualification);
                  $('#marital_status').val(data.personal_dtl.marital_status);
                  if(data.personal_dtl.marital_status == "Yes"){
                    $(".merital_hideshow").show();
                    $('#spouse_name').val(data.personal_dtl.spouse_name);
                    $('#noofchildren').val(data.personal_dtl.noofchildren);
                  }else{
                    $(".merital_hideshow").hide();
                  }
                  



                    $('#personaldetails_form')
                    .find("input[type=text],input[type=hidden],input[type=email],textarea,select,input[type=file]")
                    .attr('readonly', "").attr('disabled', 'true').css("background-color", "white")
                    .find("input[type=checkbox], input[type=radio]").prop("disabled", "true")
                    .find('select').attr('disabled', "true").end();
                     $('#personaldetails_form').find('input[type=submit]').hide();
                  
                },
               
                error: function (jqXHR, textStatus, errorThrown) {
                  var msg = "";
                  if (jqXHR.status !== 422 && jqXHR.status !== 400) {
                    msg += "<strong>" + jqXHR.status + ": " + errorThrown + "</strong>";
                  } else {
                    if (jqXHR.responseJSON.hasOwnProperty('exception')) {
                      if (jqXHR.responseJSON.exception_code == 23000) {
                        msg += "Some Sql Exception Occured";
                      } else {
                        msg += "Exception: <strong>" + jqXHR.responseJSON.exception_message + "</strong>";
                      }
                    } else {
                      msg += "Error(s):<strong><ul>";
                      $.each(jqXHR.responseJSON['errors'], function (key, value) {
                        msg += "<li>" + value + "</li>";
                      });
                      msg += "</ul></strong>";
                    }
                    $.alert({
                      title: 'Error!!',
                      type: 'red',
                      icon: 'fa fa-warning',
                      content: msg,
                    });
                  }

                },
              });
         }

         function contact_details_show(code){

             $.ajax({
                url: "get_contact_details",
                method: 'post',
                async: false,
                data: {
                  'code': code,
                  '_token': '{{csrf_token()}}',
                },
                success: function (data) {
                  $('#contactcode').val(data.contact_dtl.code);
                  $('#mob_no').val(data.contact_dtl.phno);
                  $('#email').val(data.contact_dtl.email);
                  $('#c_state').val(data.contact_dtl.c_state);
                  $('#c_dist').val(data.contact_dtl.c_dist);
                  $('#c_address').val(data.contact_dtl.c_address);
                  $('#c_pin').val(data.contact_dtl.c_pin);
                  $('#p_state').val(data.contact_dtl.p_state);
                  $('#p_dist').val(data.contact_dtl.p_dist);
                  $('#p_address').val(data.contact_dtl.p_address);
                  $('#p_pin').val(data.contact_dtl.p_pin);
                  $('#contact_person').val(data.contact_dtl.contact_person);
                  $('#relationship').val(data.contact_dtl.relationship);
                  $('#emg_address').val(data.contact_dtl.emg_address);
                  $('#emg_mob_no').val(data.contact_dtl.emg_phno);

                  if(data.contact_dtl.c_state == data.contact_dtl.p_state && data.contact_dtl.c_dist == data.contact_dtl.p_dist && data.contact_dtl.c_address==data.contact_dtl.p_address && data.contact_dtl.c_pin== data.contact_dtl.p_pin){
                    $("#defaultCheck1"). prop("checked", true);
                  }else{
                    $("#defaultCheck1"). prop("checked", false);
                  }

              

                 $('#contactdetails_form')
                .find("input[type=text],input[type=hidden],input[type=email],textarea,select,input[type=file]")
                .attr('readonly', "").attr('disabled', 'true').css("background-color", "white")
                .find("input[type=checkbox], input[type=radio]").prop("disabled", "true")
                .find('select').attr('disabled', "true").end();
                 $('#contactdetails_form').find('input[type=submit]').hide();
                  
                  
                },
               
                error: function (jqXHR, textStatus, errorThrown) {
                  var msg = "";
                  if (jqXHR.status !== 422 && jqXHR.status !== 400) {
                    msg += "<strong>" + jqXHR.status + ": " + errorThrown + "</strong>";
                  } else {
                    if (jqXHR.responseJSON.hasOwnProperty('exception')) {
                      if (jqXHR.responseJSON.exception_code == 23000) {
                        msg += "Some Sql Exception Occured";
                      } else {
                        msg += "Exception: <strong>" + jqXHR.responseJSON.exception_message + "</strong>";
                      }
                    } else {
                      msg += "Error(s):<strong><ul>";
                      $.each(jqXHR.responseJSON['errors'], function (key, value) {
                        msg += "<li>" + value + "</li>";
                      });
                      msg += "</ul></strong>";
                    }
                    $.alert({
                      title: 'Error!!',
                      type: 'red',
                      icon: 'fa fa-warning',
                      content: msg,
                    });
                  }

                },
              });
         }

          function working_details_show(code){

             $.ajax({
                url: "get_working_details",
                method: 'post',
                async: false,
                data: {
                  'code': code,
                  '_token': '{{csrf_token()}}',
                },
                success: function (data) {
                  $('#emp_type').val(data.working_dtl.emp_type);
                  $('#emp_designation').val(data.working_dtl.emp_designation);
                  $('#emp_deparment').val(data.working_dtl.emp_deparment);
                  $('#joining_date').val(data.working_dtl.joining_date);
                  $('#per_day_salary').val(data.working_dtl.salary_per_day);
                $('#workingdetails_form')
                .find("input[type=text],input[type=hidden],input[type=email],textarea,select,input[type=file]")
                .attr('readonly', "").attr('disabled', 'true').css("background-color", "white")
                .find("input[type=checkbox], input[type=radio]").prop("disabled", "true")
                .find('select').attr('disabled', "true").end();
                $('#workingdetails_form').find('input[type=submit]').hide();
                  get_all_designation(data.working_dtl.emp_designation);
                  get_all_department(data.working_dtl.emp_deparment);
                  
                  
                  
                },
               
                error: function (jqXHR, textStatus, errorThrown) {
                  var msg = "";
                  if (jqXHR.status !== 422 && jqXHR.status !== 400) {
                    msg += "<strong>" + jqXHR.status + ": " + errorThrown + "</strong>";
                  } else {
                    if (jqXHR.responseJSON.hasOwnProperty('exception')) {
                      if (jqXHR.responseJSON.exception_code == 23000) {
                        msg += "Some Sql Exception Occured";
                      } else {
                        msg += "Exception: <strong>" + jqXHR.responseJSON.exception_message + "</strong>";
                      }
                    } else {
                      msg += "Error(s):<strong><ul>";
                      $.each(jqXHR.responseJSON['errors'], function (key, value) {
                        msg += "<li>" + value + "</li>";
                      });
                      msg += "</ul></strong>";
                    }
                    $.alert({
                      title: 'Error!!',
                      type: 'red',
                      icon: 'fa fa-warning',
                      content: msg,
                    });
                  }

                },
              });
         }

         function salary_details_show(code){

           // alert(code);

             $.ajax({
                url: "get_salary_details",
                method: 'post',
                async: false,
                data: {
                  'code': code,
                  '_token': '{{csrf_token()}}',
                },
                success: function (data) {

                  //  alert(data.salary_dtl[0].salary_type);

                 //  alert();


                    

                       $.each(data.salary_dtl, function (key, value) {
                         $("#"+value.name_of_allowance).val(value.amount);
                         $("#month_day_wise"+key).val(value.salary_type);
                         $("#fixed_persentage"+key).val(value.fixed_persentage);

                         if(value.fixed_persentage == 2){

                             $(".on_div"+key).show();
                             $(".all_allowance_div"+key).show();

                          
                            $("#all_allowance"+key).val(value.on_allowance_code);
                          

                             // get_all_allowance_edit(value.on_allowance_code,key);

                            // $("#all_allowance"+key).val(value.on_allowance_code);

                         }

                         //alert(value.name_of_allowance);

                          $("."+value.name_of_allowance).show();
                          

                        
                        });
                        



                 // $('#month_day_wise').val(data.salary_dtl[0].salary_type);
                  

                $('#salarydetails_form')
                .find("input[type=text],input[type=hidden],input[type=email],textarea,select,input[type=file]")
                .attr('readonly', "").attr('disabled', 'true').css("background-color", "white")
                .find("input[type=checkbox], input[type=radio]").prop("disabled", "true")
                .find('select').attr('disabled', "true").end();
                $('#salarydetails_form').find('input[type=submit]').hide();
                 
                  
                },
               
                error: function (jqXHR, textStatus, errorThrown) {
                  var msg = "";
                  if (jqXHR.status !== 422 && jqXHR.status !== 400) {
                    msg += "<strong>" + jqXHR.status + ": " + errorThrown + "</strong>";
                  } else {
                    if (jqXHR.responseJSON.hasOwnProperty('exception')) {
                      if (jqXHR.responseJSON.exception_code == 23000) {
                        msg += "Some Sql Exception Occured";
                      } else {
                        msg += "Exception: <strong>" + jqXHR.responseJSON.exception_message + "</strong>";
                      }
                    } else {
                      msg += "Error(s):<strong><ul>";
                      $.each(jqXHR.responseJSON['errors'], function (key, value) {
                        msg += "<li>" + value + "</li>";
                      });
                      msg += "</ul></strong>";
                    }
                    $.alert({
                      title: 'Error!!',
                      type: 'red',
                      icon: 'fa fa-warning',
                      content: msg,
                    });
                  }

                },
              });


         }
     </script>


                      
  
@stop