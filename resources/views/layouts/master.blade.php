<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
   <head> 
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width,initial-scale=1">
      <title>WMS-{{$title}}</title>

      <!--    CSS     -->
      <style>
        .has-error .help-block {
             color: red;
          }
          .has-error .form-control:focus {
              border-color: red !important;
              box-shadow: 0px 1px 1px rgba(0, 0, 0, 0.075) inset, 0px 0px 8px rgba(255, 100, 255, 0.5) !important;
          }
          .has-success .form-control:focus {
              border-color: green !important;
              box-shadow: 0px 1px 1px rgba(0,153,0,0.6) inset, 0px 0px 8px rgba(0,153,0,0.6) !important;
          }
        .form-control:focus {
        border-color: blue !important;
        box-shadow: 0px 1px 1px rgba(0,0,255,0.6) inset, 0px 0px 8px rgba(0,0,255,0.6) !important;
          }
        .required::after{
              content: '*';
              color: red;
              font-size: 20px;
          }
       /* .jconfirm-box{
        
        margin-left: -200px !important; 
    }*/
      </style>


	  <link href="{{ asset('frontend/css/style.css') }}" rel="stylesheet">
      <link href="{{ asset('frontend/css/bootstrap.min.css') }}" rel="stylesheet">
	  <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/font-awesome.min.css') }}" />
      <link href="{{ asset('frontend/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
      <link href="{{ asset('frontend/css/custom.css') }}" rel="stylesheet"> 
      <link href="{{ asset('frontend/css/bootstrapValidator.css') }}" rel="stylesheet" type="text/css" media="all" />
      <link href="{{ asset('frontend/css/jquery-confirm.min.css') }}" rel="stylesheet" type="text/css" media="all" /> 
      <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap-datepicker.min.css') }}" />
      <link rel="stylesheet" href="{{ asset('frontend/css/sweetalert2.css') }}" />
      <link rel="stylesheet" href="{{ asset('frontend/css/select2.min.css') }}" />
      <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap-toggle.min.css') }}" />

       

        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('/favicon_package/apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('/favicon_package/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/favicon_package/favicon-16x16.png') }}">
        <link rel="manifest" href="{{ asset('/favicon_package/site.webmanifest') }}">
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="theme-color" content="#ffffff">



       <!--    Java Script     -->

        <script src="{{ asset('frontend/js/jquery-3.4.1.min.js') }}"></script>
        <!--<script src="{{ asset('frontend/js/popper.min.js') }}"></script>-->
        <script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('frontend/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('frontend/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('frontend/js/bootstrapValidator.js') }}"></script>
        <script src="{{ asset('frontend/js/jquery-confirm.min.js') }}"></script>
        <script src="{{ asset('frontend/js/bootstrap-datepicker.min.js') }}"></script>
        <script src="{{ asset('frontend/js/sweetalert2.js') }}"></script> 
        <script src="{{ asset('frontend/js/select2.min.js') }}"></script>   
        <script src="{{ asset('frontend/js/bootstrap-toggle.min.js') }}"></script>    
   </head>
   <body class="app">
      <div id="app">
         <div>
            <div class="mobile-menu md:hidden">
               <div class="mobile-menu-bar">
                  <a href="" class="flex mr-auto"><img alt="Midone Tailwind HTML Admin Template" src="{{ asset('/frontend/img/logo.603c31f0.svg') }}" class="w-6"></a>
                  <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 text-white transform -rotate-90 feather feather-bar-chart-2">
                     <line x1="18" y1="20" x2="18" y2="10"></line>
                     <line x1="12" y1="20" x2="12" y2="4"></line>
                     <line x1="6" y1="20" x2="6" y2="14"></line>
                  </svg>
               </div>
              
            </div>
            
            <div class="flex">
              @include('layouts.sidebar')               
               <div class="content">
               
               @yield('content')  
                 
               </div>
            </div>
      
      


      
  <script type="text/javascript">
             jQuery(function($) {					   
						jQuery("ul.accordion li a").click(function(){															  
									  jQuery(this).next("ul").slideDown();
									  jQuery(this).addClass('side-menu--active');
									  jQuery(this).parents("li").siblings().find("a").next("ul").slideUp();
									  jQuery(this).parents("li").siblings().find("a").removeClass('side-menu--active');
									  })   
						   });

    function redirectPost(url, data1) {
          var $form = $("<form />");
          $form.attr("action", url);
          $form.attr("method", "post");
          //         $form.attr("target", "_blank");
          for (var data in data1)
                  $form.append('<input type="hidden" name="' + data + '" value="' + data1[data] + '" />');
          $("body").append($form);
          $form.submit();
      }

      function redirectPost_newTab(url, data1) {
          var $form = $("<form />");
          $form.attr("action", url);
          $form.attr("method", "post");
          $form.attr("target", "_blank");
          for (var data in data1)
                  $form.append('<input type="hidden" name="' + data + '" value="' + data1[data] + '" />');
          $("body").append($form);
          $form.submit();
      }
       function isNumberKey(evt) {
          var charCode = (evt.which) ? evt.which : evt.keyCode;
          if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
            return true;
      }
						   
		   

</script>    
      
      
   </body>
</html>
