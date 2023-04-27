<?php
use App\Models\Setting;
?>
<!doctype html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1">

    <title>Reset Password | orBiz Solution</title>

    <!-- include common vendor stylesheets & fontawesome -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/node_modules/bootstrap/dist/css/bootstrap.css')}}">


    <link rel="stylesheet" type="text/css" href="{{asset('assets/node_modules/@fortawesome/fontawesome-free/css/fontawesome.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/node_modules/@fortawesome/fontawesome-free/css/regular.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/node_modules/@fortawesome/fontawesome-free/css/brands.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/node_modules/@fortawesome/fontawesome-free/css/solid.css')}}">



    <!-- include vendor stylesheets used in "Login" page. see "/views//pages/partials/page-login/@vendor-stylesheets.hbs" -->


   <!-- include fonts -->
   <link rel="stylesheet" type="text/css" href="{{asset('assets/dist/css/ace-font.css')}}">
   <!-- ace.css -->
   <link rel="stylesheet" type="text/css" href="{{asset('assets/dist/css/ace.css')}}">
   <!-- favicon -->
   <link rel="icon" type="image/png" href="{{ URL::asset('storage/app/public/')}}" />

   <!-- "Dashboard" page styles, specific to this page for demo only -->
   <link rel="stylesheet" type="text/css" href="{{asset('assets/views/pages/dashboard/@page-style.css')}}">
  </head>

  <body>
    <div class="body-container" style="background: #f2efea;">

      <div class="main-container container bgc-transparent">

        <div class="main-content minh-100 justify-content-center">
          <div class="p-2 p-md-4">
            <div class="row" id="row-1">
              <div class="col-12 col-xl-10 offset-xl-1 bgc-white shadow radius-1 overflow-hidden">

                <div class="row" id="row-2">

                  <div id="id-col-intro" class="col-lg-5 d-none d-lg-flex border-r-1 brc-default-l3 px-0">
                    <!-- the left side section is carousel in this demo, to show some example variations -->

                    <div id="loginBgCarousel" class="carousel slide minw-100 h-100">
                      <ol class="d-none carousel-indicators">
                        <li data-target="#loginBgCarousel" data-slide-to="0" class="active"></li>
                        <li data-target="#loginBgCarousel" data-slide-to="1"></li>
                        <li data-target="#loginBgCarousel" data-slide-to="2"></li>
                        <li data-target="#loginBgCarousel" data-slide-to="3"></li>
                      </ol>

                      <div class="carousel-inner minw-100 h-100">
                        <div class="carousel-item active minw-100 h-100">
                          <!-- default carousel section that you see when you open login page -->
                          <div class="px-3 bgc-blue-l4 d-flex flex-column align-items-center justify-content-center">
                            <a class="mt-5 mb-2" href="{{URL::to('/')}}">
                              {{-- <img src="{{ URL::asset('storage/app/public/'.$settings->logo_header.'') }}" width="100%" height="80px" alt=""> --}}
                            </a>                            

                            <div class="mt-5 mx-4 text-dark-tp3">
                             
                              <hr class="mb-1 brc-black-tp10" />
                              <br>
                              <br>
                              <br>
                              <br>
                              <br>
                              <br>
                              <div style="text-align: center">
                              
                                {{-- <br />
                                <a id="id-remove-carousel" href="#" class="text-md text-dark-l2 d-inline-block mt-3">
                                  <i class="far fa-trash-alt text-110 text-orange-d1 mr-1 w-2"></i>
                                  Remove this section
                                </a>
                                <br /> --}}
                               
                              </div>
                            </div>

                            <div class="mt-auto mb-4 text-dark-tp2">
                              {{ENV('APP_NAME')}} &copy; <?php echo date("Y"); ?>
                            </div>
                          </div>
                        </div>



                        <div class="carousel-item minw-100 h-100">
                          <!-- the second carousel item with dark background -->
                          <div style="background-image: url({{asset('assets/assets/image/login-bg-2.svg')}});" class="d-flex flex-column align-items-center justify-content-start">
                            <a class="mt-5 mb-2" href="html/dashboard.html">
                              <i class="fa fa-leaf text-success-m2 fa-3x"></i>
                            </a>

                            <h2 class="text-blue-l1">
                               {{ENV('APP_NAME')}} <span class="text-80 text-white-tp3"> App</span>
                            </h2>
                          </div>
                        </div>



                        <div class="carousel-item minw-100 h-100">
                          <div style="background-image: url({{asset('assets/assets/image/login-bg-3.jpg')}});" class="d-flex flex-column align-items-center justify-content-start">
                            <div class="bgc-black-tp4 radius-1 p-3 w-90 text-center my-3 h-100">
                              <a class="mt-5 mb-2" href="html/dashboard.html">
                                <i class="fa fa-leaf text-success-m2 fa-3x"></i>
                              </a>

                              <h2 class="text-blue-l1">
                              {{ENV('APP_NAME')}} <span class="text-80 text-white-tp3">Application</span>
                              </h2>
                            </div>
                          </div>
                        </div>



                        <div class="carousel-item minw-100 h-100">
                          <div style="background-image: url({{asset('assets/assets/image/login-bg-4.jpg')}});" class="d-flex flex-column align-items-center justify-content-start">
                            <a class="mt-5 mb-2" href="html/dashboard.html">
                              <i class="fa fa-leaf text-success-m2 fa-3x"></i>
                            </a>

                            <h2 class="text-blue-d1">
                            {{ENV('APP_NAME')}} <span class="text-80 text-dark-tp3">Application</span>
                            </h2>
                          </div>
                        </div>

                      </div>
                    </div>
                  </div> 


                  <div id="id-col-main" class="col-12 col-lg-7 py-lg-5 bgc-white px-0">


                    <!-- you can also use these tab links -->
                    <ul class="d-none mt-n4 mb-4 nav nav-tabs nav-tabs-simple justify-content-end bgc-black-tp11" role="tablist">
                      <li class="nav-item mx-2">
                        <a class="nav-link active px-2" data-toggle="tab" href="#id-tab-login" role="tab" aria-controls="id-tab-login" aria-selected="true">
                          Login
                        </a>
                      </li>
                      <li class="nav-item mx-2">
                        <a class="nav-link px-2" data-toggle="tab" href="#id-tab-signup" role="tab" aria-controls="id-tab-signup" aria-selected="false">
                          Signup
                        </a>
                      </li>
                    </ul>


                    <div class="tab-content tab-sliding border-0 p-0" data-swipe="right">

                      <div class="tab-pane active show mh-100 px-3 px-lg-0 pb-3" id="id-tab-login">

                        


                        <!-- show this in desktop -->
                        <div class="d-none d-lg-block col-md-6 offset-md-3 mt-lg-4 px-0">

                          <div class="flash-message">
                            @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                                @if(Session::has('alert-' . $msg))
                                    <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                                @endif
                            @endforeach
                          </div>

                          <?php 
                        $exception= Session::get('exception');
                        if (isset($exception)) {
                          echo "<div class=\"alert alert-danger\" role=\"alert\">";
                          echo $exception;
                          echo "</div>";
                          Session::put('exception');
                        }
          
                        $message= Session::get('message');
                        if (isset($message)) {
                          echo "<div class=\"alert alert-success\" role=\"alert\">";
                          echo $message;
                          echo "</div>";
                          Session::put('message');
                        }      
                    ?>
                    
                          <h4 class="text-dark-tp4 border-b-1 brc-secondary-l2 pb-1 text-130">
                            <i class="fa fa-coffee text-orange-m1 mr-1"></i>
                            Enter new password ..
                          </h4>
                        </div>

                        <!-- show this in mobile device -->
                        <div class="d-lg-none text-secondary-m1 my-4 text-center">
                          <a href="html/dashboard.html">
                            <i class="fa fa-leaf text-success-m2 text-200 mb-4"></i>
                          </a>

                        


                          <h1 class="text-170">
                            <span class="text-blue-d1">
                               {{ENV('APP_NAME')}} <span class="text-80 text-dark-tp3"></span>
                            </span>
                          </h1>

                          Enter new password ..
                        </div>


                        <form action="new-password-store" method="post" autocomplete="off" class="form-row mt-4">
                          @csrf                        

                          <div class="form-group col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3 mt-2 mt-md-1">
                            <div class="d-flex align-items-center input-floating-label text-blue brc-blue-m2">
                              <input type="password" id="newPassword" name="new_password" class="form-control form-control-lg pr-4 shadow-none" id="id-login-password" />
                             <a href="" id="showPassword"><i class="fa fa-eye text-grey-m2 ml-n4"></i></a>
                              <label class="floating-label text-grey-l1 ml-n3" for="id-login-password">
                                New password
                              </label>
                            </div>
                          </div>




                          <div class="form-group col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3">

                            <?php 
                            $reset_pass_code = \Illuminate\Support\Facades\Request::get('code');    
                            ?>
                            <input type="hidden" name="reset_pass_code" value="<?php echo $reset_pass_code;?>">
                           
                            <button type="submit" class="btn btn-primary btn-block px-4 btn-bold mt-2 mb-4">
                              Submit
                            </button>
                          </div>
                        </form>


                       
                      </div>



                    </div><!-- .tab-content -->
                  </div>

                </div><!-- /.row -->

              </div><!-- /.col -->
            </div><!-- /.row -->

            <div class="d-lg-none my-3 text-white-tp1 text-center">
              <i class="fa fa-leaf text-success-l3 mr-1 text-110"></i>{{ENV('APP_NAME')}} &copy; 2020
            </div>
          </div>
        </div>

      </div>

    </div>

    <!-- include common vendor scripts used in demo pages -->
    <script src="{{asset('assets/node_modules/jquery/dist/jquery.js')}}"></script>
    <script src="{{asset('assets/node_modules/popper.js/dist/umd/popper.js')}}"></script>
    <script src="{{asset('assets/node_modules/bootstrap/dist/js/bootstrap.js')}}"></script>

    <!-- include ace.js -->
    <script src="{{asset('assets/dist/js/ace.js')}}"></script>

    <!-- demo.js is only for Ace's demo and you shouldn't use it -->
    <script src="{{asset('assets/app/browser/demo.js')}}"></script>

    <!-- "Dashboard" page script to enable its demo functionality -->
    <script src="{{asset('assets/views/pages/page-login/@page-script.js')}}"></script>
    
    <script>    
      $( document ).ready(function() {         
      // change input field pass to text
          $('#showPassword').click(function (event){  
              event.preventDefault();            
              if(document.getElementById('newPassword').type == 'password'){
                document.getElementById('newPassword').type = 'text';
                $(".text-grey-m2").css("color", "#2c86d1!important");
              }else{
                document.getElementById('newPassword').type = 'password';
                $(".text-grey-m2").css("color", "#77797e!important");
              }
          });
      // end
  });
  </script>
 
 
  </body>

</html>