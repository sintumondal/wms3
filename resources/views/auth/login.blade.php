<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width,initial-scale=1">
      <title>WMS Login </title>
      <link href="{{ asset('frontend/css/style.css') }}" rel="stylesheet">
      <link href="{{ asset('frontend/css/bootstrap.min.css') }}" rel="stylesheet">
      <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/font-awesome.min.css') }}" />
      <link href="{{ asset('frontend/css/custom.css') }}" rel="stylesheet">

       <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('/favicon_package/apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('/favicon_package/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/favicon_package/favicon-16x16.png') }}">
        <link rel="manifest" href="{{ asset('/favicon_package/site.webmanifest') }}">
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="theme-color" content="#ffffff">

      <script src="{{ asset('frontend/js/jquery-3.4.1.min.js') }}"></script>
   </head>
   <body class="login">
     
      <div id="app">
         <div>
            
            <div class="container sm:px-10">
               <div class="block xl:grid grid-cols-2 gap-4">
                  <div class="hidden xl:flex flex-col min-h-screen">
                     <a href="" class="-intro-x flex items-center pt-5"><img alt="Deb" src="{{ asset('frontend/images/logo-top.svg') }}" class="w-6"><span class="text-white text-lg ml-3 font-medium"> Worker <span class="font-medium">Management System</span></span></a>
                     <div class="my-auto">
                        <img alt="Deb" src="{{ asset('frontend/images/login1.svg') }}" class="-intro-x w-1/2 -mt-16">
                        <div class="-intro-x text-white font-medium text-4xl leading-tight mt-10"> A few more clicks to <br> sign in to your account. </div>
                        <div class="-intro-x mt-5 text-lg text-white dark:text-gray-500"> Manage all your Employee Attendance & Salary in one Place </div>
                     </div>
                  </div>
                  <div class="h-screen xl:h-auto flex py-5 xl:py-0 my-10 xl:my-0">
                     <div class="my-auto mx-auto xl:ml-20 bg-white xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto border ">
                        <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left"> Sign In </h2>
                        
                        <div class="intro-x mt-8">
                             @isset ($error_msg)
                                            <div class="alert alert-danger" id="error">{{$error_msg}}</div>
                                        @endisset 
                            {!! Form::open(['url' => '/login', 'name' => 'login_form', 'id' => 'login_form', 'method' => 'post' ,'class'=>'login-form animate-form form-horizontal','role'=>'form']) !!}
                            <div class="form-group">

                                {!! Form::text('mobile_no', null, ['id'=>'mobile_no','class'=>'form-control intro-x login__input input input--lg border border-gray-300 block','placeholder'=>'Enter Mobile Number','autocomplete'=>'off','maxlength'=>'10']) !!}
                                
                            </div>
                            <div class="form-group">

                               {!! Form::password('password',['id'=>'password','class' => 'form-control intro-x login__input input input--lg border border-gray-300 block mt-4', 'placeholder' => 'Enter Password', 'type' => 'password','autocomplete'=>'off','maxlength'=>'15']) !!}
                                
                            </div>
                        </div>
                      
                        <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left p-2">
                            <button type="submit" class="button button--lg w-full xl:w-32 text-white bg-theme-1 xl:mr-3 align-top" id="btnSubmit"> Login </button>
                        </div>
                        {!! Form::close() !!}
                        
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
     
      
   </body>

   <script type="text/javascript">
       
    $( document ).ready(function() {

       $('#btnSubmit').attr("disabled", true);
        

    });

    $( "#mobile_no" ).keyup(function() {
       if($("#mobile_no").val() != '' && $("#password").val() != '') {
          $('#btnSubmit').attr("disabled", false);
       }

       });

    $( "#password" ).keyup(function() {
       if($("#mobile_no").val() != '' && $("#password").val() != '') {
          $('#btnSubmit').attr("disabled", false);
       }

       });



   </script>
</html>