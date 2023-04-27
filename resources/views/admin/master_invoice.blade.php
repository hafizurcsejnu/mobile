<?php
use App\Models\Setting;
$settings = Setting::where('client_id', session('user.client_id'))->first();
?>

<!doctype html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1">
    <base href="../" />

    <title>Invoice Details (ID#{{$order->id}})</title>

    <!-- include common vendor stylesheets & fontawesome -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/node_modules/bootstrap/dist/css/bootstrap.css')}}">

    <link rel="stylesheet" type="text/css" href="{{asset('assets/node_modules/@fortawesome/fontawesome-free/css/fontawesome.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/node_modules/@fortawesome/fontawesome-free/css/regular.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/node_modules/@fortawesome/fontawesome-free/css/brands.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/node_modules/@fortawesome/fontawesome-free/css/solid.css')}}">

    <link rel="stylesheet" type="text/css" href="{{asset('assets/node_modules/bootstrap-select/dist/css/bootstrap-select.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/node_modules/bootstrap-duallistbox/dist/bootstrap-duallistbox.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/node_modules/select2/dist/css/select2.css')}}">
    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" /> --}}
   

    <link rel="stylesheet" type="text/css" href="{{asset('assets/node_modules/chosen-js/chosen.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/node_modules/summernote/dist/summernote-lite.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/node_modules/datatables.net-buttons-bs4/css/buttons.bootstrap4.css')}}">
    <!-- <link rel="stylesheet" type="text/css" href="{{asset('assets/views/pages/table-datatables/@page-style.css')}}"> -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/dropzone.min.css" integrity="sha512-jU/7UFiaW5UBGODEopEqnbIAHOI8fO6T99m7Tsmqs2gkdujByJfkCbbfPSN4Wlqlb9TGnsuC0YgUgWkRBK7B9A==" crossorigin="anonymous" />


    <!-- include vendor stylesheets used in "Dashboard" page. see "/views//pages/partials/dashboard/@vendor-stylesheets.hbs" -->


    <!-- include fonts -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/dist/css/ace-font.css')}}">
    <!-- ace.css -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/dist/css/ace.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/dist/css/jquery-ui.css')}}">
    
    <!-- favicon -->
    <link rel="icon" type="image/png" href="{{ URL::asset('storage/app/public/'.$settings->favicon.'') }}" />

    <!-- "Dashboard" page styles, specific to this page for demo only -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/views/pages/dashboard/@page-style.css')}}">
    {{-- <link rel="stylesheet" type="text/css" href="{{asset('assets/views/pages/form-wysiwyg/@page-style.css')}}"> --}}
    

    <link rel="stylesheet" type="text/css" href="{{asset('assets/dist/css/custom.css')}}">

    <script src="{{asset('assets/node_modules/jquery/dist/jquery.js')}}"></script>
    <script src="{{asset('assets/node_modules/chosen-js/chosen.jquery.js')}}"></script>
    
    <script src="{{asset('assets/dist/js/jquery-ui.js')}}"></script>
    <script src="{{asset('assets/dist/js/jquery-ui.min.js')}}"></script>
    
    <script src="{{asset('assets/js/FileSaver.js')}}"></script>
    <script src="{{asset('assets/js/custom.js')}}"></script>
    <script src="{{asset('assets/js/jquery.wordexport.js')}}"></script> 

    {{-- <script src="{{asset('assets/js/dropzone.js')}}"></script> --}} 

    <script src="{{asset('assets/image-uploader.min.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{asset('assets/image-uploader.min.css')}}">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


  </head>

 
  <body>
       
            
		@yield('main_content')

              
 

    <!-- include common vendor scripts used in demo pages -->

    <script src="{{asset('assets/node_modules/popper.js/dist/umd/popper.js')}}"></script>
    <script src="{{asset('assets/node_modules/bootstrap/dist/js/bootstrap.js')}}"></script>
    <script src="{{asset('assets/node_modules/summernote/dist/summernote-lite.js')}}"></script>
    <!-- include vendor scripts used in "Dashboard" page. see "/views//pages/partials/dashboard/@vendor-scripts.hbs" -->
    <script src="{{asset('assets/node_modules/chart.js/dist/Chart.js')}}"></script>


    <script src="{{asset('assets/node_modules/bootstrap-select/dist/js/bootstrap-select.js')}}"></script>
    <script src="{{asset('assets/node_modules/bootstrap-duallistbox/dist/jquery.bootstrap-duallistbox.js')}}"></script>
    <script src="{{asset('assets/node_modules/select2/dist/js/select2.js')}}"></script>
  

    <!-- include ace.js -->
    <script src="{{asset('assets/dist/js/ace.js')}}"></script>

    <!-- demo.js is only for Ace's demo and you shouldn't use it -->
    <script src="{{asset('assets/app/browser/demo.js')}}"></script>

    <!-- "Dashboard" page script to enable its demo functionality -->
    <script src="{{asset('assets/views/pages/dashboard/@page-script.js')}}"></script>
    <script src="{{asset('assets/views/pages/form-basic/@page-script.js')}}"></script>
    <script src="{{asset('assets/views/pages/form-wysiwyg/@page-script.js')}}"></script>
    <script src="{{asset('assets/views/pages/form-more/@page-script.js')}}"></script>

      <!-- include vendor scripts used in "DataTables" page. see "/views//pages/partials/table-datatables/@vendor-scripts.hbs" -->
      <script src="{{asset('assets/node_modules/datatables/media/js/jquery.dataTables.js')}}"></script>
      <script src="{{asset('assets/node_modules/datatables.net-bs4/js/dataTables.bootstrap4.js')}}"></script>
      <script src="{{asset('assets/node_modules/datatables.net-colreorder/js/dataTables.colReorder.js')}}"></script>
      <script src="{{asset('assets/node_modules/datatables.net-select/js/dataTables.select.js')}}"></script>
  
  
      <script src="{{asset('assets/node_modules/datatables.net-buttons/js/dataTables.buttons.js')}}"></script>
      <script src="{{asset('assets/node_modules/datatables.net-buttons-bs4/js/buttons.bootstrap4.js')}}"></script>
      <script src="{{asset('assets/node_modules/datatables.net-buttons/js/buttons.html5.js')}}"></script>
      <script src="{{asset('assets/node_modules/datatables.net-buttons/js/buttons.print.js')}}"></script>
      <script src="{{asset('assets/node_modules/datatables.net-buttons/js/buttons.colVis.js')}}"></script>
      <script src="{{asset('assets/node_modules/datatables.net-responsive/js/dataTables.responsive.js')}}"></script>
     
      
      {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.js" integrity="sha512-VQQXLthlZQO00P+uEu4mJ4G4OAgqTtKG1hri56kQY1DtdLeIqhKUp9W/lllDDu3uN3SnUNawpW7lBda8+dSi7w==" crossorigin="anonymous"></script>  --}}
      
  
      <script src="{{asset('assets/views/pages/table-datatables/@page-script.js')}}"></script>


   
  </body>

</html>