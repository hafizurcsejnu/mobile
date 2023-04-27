@php
    use App\Models\Setting;
    $settings = Setting::where('client_id', session('client_id'))->first();
@endphp

@if (session('user_id') != 1)
  <style>
      i.fa.fa-trash {
          /* display: none; */
      }
    </style>
@endif

<!doctype html>
<html lang="en">
 
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1">
    <base href="../" />

    <title>{{$settings->title}} | Business Solution</title> 

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

  <style> 

a.v-hover {
    visibility: visible!important;
    opacity: 1!important;
} 
.note-editable { 
    height: 100px!important;
    max-height: 400px;
    min-height: 100px!important;
}
.footer {        
    bottom: 0!important;
    width: 100%;
}
/* top bg color change */
.navbar-inner {
    background: #edf2f9;
}
.navbar-intro.justify-content-xl-between {
    background: #afc0d9;
}
/* leftbar bg color change */
.sidebar-inner {
    background-color: #edf2f9!important;
}
a.nav-link {
    color: #000!important;
}
li.nav-item:hover {
    background: #adbbd1!important;
}
li.nav-item.active {
    /* background: #adbbd1!important; */
    background: #edf2f9!important;
}
a.nav-link:hover {
    font-weight: 500!important;
}
/* leftbar bd color change */

.select2-container--default .select2-selection--single {
    background-color: #fff;
    border: 1px solid #d3d5d7;
    border-radius: 0px;
    height: 38px;
    padding: 3px;
}
.select2-container.select2-container--focus .select2-selection, .select2-container .select2-selection[aria-expanded="true"] {
    border-color: #d7d8da!important;
    height: 39px!important;
    width: 100%!important;
    font-size: 16px!important;
    padding-top: 5px!important;
}

    .ace-toaster-container.position-tc {
    display: none!important;
}

i.fa.fa-times.fa-4x {
    display: none!important;
}
h4.modal-title.w-100 {
    color: #FFC107!important;
    text-align: center;
}

.note-dropzone {
    display: none!important;
}
input.qty, input.price{
    text-align: center!important;
}
  </style>

  <body>
    <div class="body-container">
      <nav class="navbar navbar-expand-lg navbar-fixed navbar-blue">
        <div class="navbar-inner">

          <div class="navbar-intro justify-content-xl-between">

            <button type="button" class="btn btn-burger burger-arrowed static collapsed ml-2 d-flex d-xl-none" data-toggle-mobile="sidebar" data-target="#sidebar" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle sidebar">
              <span class="bars"></span>
            </button><!-- mobile sidebar toggler button -->
 
            <a class="navbar-brand text-white" href="/">
              @if (ENV('APP_ENV') == 'local')
                <img src="{{asset('images/logo.png')}}" alt="logo" width="{{$settings->nav_logo_size}}px!important" >
              @else 
                <img src="{{ URL::asset('storage/app/public/'.$settings->logo_header.'') }}" width="{{$settings->nav_logo_size}}px!important" alt="Band Logo"> 
              @endif
            </a>         
  
            <button type="button" class="btn btn-burger mr-2 d-none1 d-xl-flex" data-toggle="sidebar" data-target="#sidebar" aria-controls="sidebar" aria-expanded="true" aria-label="Toggle sidebar">
              <span class="bars">
                 
              </span>
            </button><!-- sidebar toggler button -->

          </div><!-- /.navbar-intro -->


          <div class="navbar-content">
            <button class="navbar-toggler py-2" type="button" data-toggle="collapse" data-target="#navbarSearch" aria-controls="navbarSearch" aria-expanded="false" aria-label="Toggle navbar search">
              <i class="fa fa-search text-white text-90 py-1"></i>
            </button><!-- mobile #navbarSearch toggler -->

            <h3 class="text-center" style="width: 100%;color: #000;font-weight: 600;font-family: sans-serif; margin-top:20px">{{$settings->title}}
              <p style="font-size: 14px; color:#2d5a9d;font-family: monospace;">{{$settings->sub_title}}</p>
            </h3>
           
            {{-- <div class="collapse navbar-collapse navbar-backdrop" id="navbarSearch">
              <form class="d-flex align-items-center ml-lg-4 py-1" data-submit="dismiss">
                <i class="fa fa-search text-white d-none1 d-lg-block pos-rel"></i>
                <input type="text" class="navbar-input mx-3 flex-grow-1 mx-md-auto pr-1 pl-lg-4 ml-lg-n3 py-2 autofocus" placeholder="SEARCH ..." aria-label="Search" />
              </form>
            </div> --}}

          </div><!-- .navbar-content -->


          <!-- mobile #navbarMenu toggler button -->
          <button class="navbar-toggler ml-1 mr-2 px-1" type="button" data-toggle="collapse" data-target="#navbarMenu" aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle navbar menu">
            <span class="pos-rel">
                  <img class="border-2 brc-white-tp1 radius-round" width="36" src="{{asset('assets/assets/image/avatar/profile.png')}}" alt="Jason's Photo">
                  <span class="bgc-warning radius-round border-2 brc-white p-1 position-tr mr-n1px mt-n1px"></span>
            </span>
          </button>


          <div class="navbar-menu collapse navbar-collapse navbar-backdrop" id="navbarMenu">
        
            <div class="navbar-nav ">
              <ul class="nav">
                <li class="nav-item dropdown dropdown-mega d-none1">
                  <a class="nav-link dropdown-toggle d-none" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-list-alt mr-2 d-lg-none"></i>
                    Contact Us
                    <i class="caret fa fa-angle-down d-none1 d-lg-block"></i>
                    <i class="caret fa fa-angle-left d-block d-lg-none"></i>
                  </a>
                  <div class="dropdown-menu p-0 dropdown-animated bgc-secondary-l4 brc-primary-m3 border-t-0 border-b-2 ace-scrollbar">
                    <div class="d-flex flex-column">

                      <div class="row mx-0">

                        <div class="col-lg-8 col-12 p-2 p-lg-8 p-xl-4 d-flex flex-column align-items-center">
                          <div class="contact_message">
                            Report any Issues with the application or contact us directly at  <a href="mailto:hafizur.csejnu@gmail.com">hafizur.csejnu@gmail.com</a>
                           <address>Maniknagar, Dhaka.</address> 
                          </div>
                         

                          {{-- <div class="w-100 mb-3">
                            <h5 class="col-lg-9 mx-auto text-dark-m2 px-0">
                              <i class="fa fa-clipboard-check mr-1 text-purple-m1"></i>
                              Current Tasks
                            </h5>
                          </div>

                          <div class="col-lg-9 list-group px-0 border-1 brc-default-l2 radius-1 shadow-md">
                            <a href="#" class="border-0 bgc-h-primary-l4 list-group-item list-group-item-action">
                              <i class="fab fa-facebook text-blue-m1 text-110 mr-2"></i>
                              Cras justo odio
                            </a>
                            <a href="#" class="border-0 bgc-h-primary-l4 list-group-item list-group-item-action text-primary">
                              <i class="fa fa-user text-success-m1 text-110 mr-2"></i>
                              Dapibus ac facilisis in
                            </a>
                            <a href="#" class="border-0 bgc-h-primary-l4 list-group-item list-group-item-action">
                              <i class="fa fa-clock text-purple-m1 text-110 mr-2"></i>
                              Morbi leo risus
                            </a>
                            <a href="#" class="border-0 list-group-item list-group-item-action bgc-success-l2">
                              <i class="fa fa-check text-orange-d1 text-110 mr-2"></i>
                              Porta ac consectetur
                              <span class="ml-2 badge badge-primary badge-pill badge-lg">14</span>
                            </a>
                            <a href="#" class="border-0 list-group-item list-group-item-action disabled">Vestibulum at eros</a>
                          </div> --}}
                        </div>
                        <!-- .col:mega tasks -->



                        {{--<div class="bgc-white1 col-lg-4 col-12 p-4">
                           <h5 class="text-dark-m2">
                            <i class="fas fa-bullhorn mr-1 text-primary-m1"></i>
                            Notifications
                          </h5>

                          <div class="mt-3">
                            <div class="media mt-2 px-3 pt-1 border-l-2 brc-purple-m2">
                              <div class="bgc-purple radius-1 mr-3 p-3">
                                <i class="fa fa-user text-white text-150"></i>
                              </div>
                              <div class="media-body pb-0 mb-0 text-90 text-grey-m1">
                                <div class="text-grey-d2 font-bolder">@username1</div>
                                Donec id elit non mi porta gravida at eget metus. Fusce dapibus...
                              </div>
                            </div>

                            <hr />

                            <div class="media mt-2 px-3 pt-1 border-l-2 brc-warning-m2">
                              <div class="bgc-warning radius-1 mr-3 p-3">
                                <i class="fa fa-user text-white text-150"></i>
                              </div>
                              <div class="media-body pb-0 mb-0 text-90 text-grey-m1">
                                <div class="text-grey-d2 font-bolder">@username2</div>
                                Fusce dapibus, tellus ac cursus commodo, tortor mauris...
                              </div>
                            </div>

                            <hr />

                            <div class="media mt-2 px-3 pt-1 border-l-2 brc-success-m2">
                              <div class="bgc-success radius-1 mr-3 p-3">
                                <i class="fa fa-user text-white text-150"></i>
                              </div>
                              <div class="media-body pb-0 mb-0 text-90 text-grey-m1">
                                <div class="text-grey-d2 font-bolder">@username3</div>
                                Tortor mauris condimentum nibh, fusce dapibus...
                              </div>
                            </div>
                          </div> 

                        </div>--}}
                        
                        <!-- .col:mega notifications -->


                        <div class="col-lg-4 col-12 p-4 dropdown-clickable">
                          <h5 class="text-dark-m2">
                            <i class="fa fa-envelope mr-1 text-green-m1"></i>
                            Contact Us
                          </h5>

                          <form class="my-3">
                            <div class="form-group mb-2">
                              <input placeholder="Name" type="text" class="form-control border-l-2" />
                            </div>

                            <div class="form-group mb-2">
                              <input placeholder="Email" type="text" class="form-control border-l-2" />
                            </div>

                            <div class="form-group mb-4">
                              <textarea class="form-control brc-primary-m2 border-l-2 text-grey-d1" rows="3" placeholder="Your message..."></textarea>
                            </div>

                            <div class="text-center">
                              {{-- <button type="reset" class="btn px-3 btn-secondary btn-bold tex1t-110">
                                Reset
                              </button> --}}

                              <button data-dismiss="dropdown" type="button" class="btn btn-outline-primary btn-bgc-white px-3 btn-bold btn-text-slide-x" style="width: 8rem;">
                                Submit<i class="btn-text-2  move-right fa fa-arrow-right text-120 align-text-bottom ml-1"></i>
                              </button>
                            </div>
                          </form>
                        </div><!-- .col:mega contact -->

                      </div><!-- .row: mega -->


                    </div>
                  </div>
                </li>

                {{-- 

                <li class="nav-item dropdown dropdown-mega">
                  <a class="nav-link dropdown-toggle pl-lg-3 pr-lg-4" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-bell text-110 icon-animated-bell mr-lg-2"></i>

                    <span class="d-inline-block d-lg-none ml-2">Notifications</span><!-- show only on mobile -->
                    <span id="id-navbar-badge1" class="badge badge-sm bgc-warning-d2 text-white radius-round text-85 border-1 brc-white-tp5">3</span>

                    <i class="caret fa fa-angle-left d-block d-lg-none"></i>
                    <div class="dropdown-caret brc-white"></div>
                  </a>
                  <div class="dropdown-menu dropdown-sm dropdown-animated p-0 bgc-white brc-primary-m3 border-b-2 shadow">
                    <ul class="nav nav-tabs nav-tabs-simple w-100 nav-justified dropdown-clickable border-b-1 brc-secondary-l2" role="tablist">
                      <li class="nav-item">
                        <a class="d-style px-0 mx-0 py-3 nav-link active text-600 brc-blue-m1 text-dark-tp5 bgc-h-blue-l4" data-toggle="tab" href="#navbar-notif-tab-1" role="tab">
                          <span class="d-active text-blue-d1 text-105">Notifications</span>
                          <span class="d-n-active">Notifications</span>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a class="d-style px-0 mx-0 py-3 nav-link text-600 brc-purple-m1 text-dark-tp5 bgc-h-purple-l4" data-toggle="tab" href="#navbar-notif-tab-2" role="tab">
                          <span class="d-active text-purple-d1 text-105">Messages</span>
                          <span class="d-n-active">Messages</span>
                        </a>
                      </li>
                    </ul><!-- .nav-tabs -->


                    <div class="tab-content tab-sliding p-0">

                      <div class="tab-pane mh-none show active px-md-1 pt-1" id="navbar-notif-tab-1" role="tabpanel">

                        <a href="#" class="mb-0 border-0 list-group-item list-group-item-action btn-h-lighter-secondary">
                          <i class="fab fa-twitter bgc-blue-tp1 text-white text-110 mr-15 p-2 radius-1"></i>
                          <span class="text-muted">Followers</span>
                          <span class="float-right badge badge-danger radius-round text-80">- 4</span>
                        </a>
                        <a href="#" class="mb-0 border-0 list-group-item list-group-item-action btn-h-lighter-secondary">
                          <i class="fa fa-comment bgc-pink-tp1 text-white text-110 mr-15 p-2 radius-1"></i>
                          <span class="text-muted">New Comments</span>
                          <span class="float-right badge badge-info radius-round text-80">+12</span>
                        </a>
                        <a href="#" class="mb-0 border-0 list-group-item list-group-item-action btn-h-lighter-secondary">
                          <i class="fa fa-shopping-cart bgc-success-tp1 text-white text-110 mr-15 p-2 radius-1"></i>
                          <span class="text-muted">New Orders</span>
                          <span class="float-right badge badge-success radius-round text-80">+8</span>
                        </a>
                        <a href="#" class="mb-0 border-0 list-group-item list-group-item-action btn-h-lighter-secondary">
                          <i class="far fa-clock bgc-purple-tp1 text-white text-110 mr-15 p-2 radius-1"></i>
                          <span class="text-muted">Finished processing data!</span>
                        </a>

                        <hr class="mt-1 mb-1px brc-secondary-l2" />
                        <a href="#" class="mb-0 py-3 border-0 list-group-item text-blue text-uppercase text-center text-85 font-bolder">
                          See All Notifications
                          <i class="ml-2 fa fa-arrow-right text-muted"></i>
                        </a>

                      </div><!-- .tab-pane : notifications -->


                      <div class="tab-pane mh-none pl-md-2" id="navbar-notif-tab-2" role="tabpanel">
                        <div data-ace-scroll='{"ignore": "mobile", "height": 300, "smooth":true}'>
                          <a href="#" class="d-flex mb-0 border-0 list-group-item list-group-item-action btn-h-lighter-secondary">
                            <img alt="Alex's avatar" src="{{asset('assets/assets/image/avatar/avatar.png')}}" width="48" class="align-self-start border-2 brc-primary-m3 p-1px mr-2 radius-round" />
                            <div>
                              <span class="text-primary-m1 font-bolder">Alex:</span>
                              <span class="text-grey text-90">Ciao sociis natoque penatibus et auctor ...</span>
                              <br />
                              <span class="text-grey-m1 text-85">
                                                  <i class="far fa-clock"></i>
                                                  a moment ago
                                              </span> 
                            </div>
                          </a>
                          <hr class="my-1px brc-grey-l3" />
                          <a href="#" class="d-flex mb-0 border-0 list-group-item list-group-item-action btn-h-lighter-secondary">
                            <img alt="Susan's avatar" src="{{asset('assets/assets/image/avatar/profile.png')}}" width="48" class="align-self-start border-2 brc-primary-m3 p-1px mr-2 radius-round" />
                            <div>
                              <span class="text-primary-m1 font-bolder">Susan:</span>
                              <span class="text-grey text-90">Vestibulum id ligula porta felis euismod ...</span>
                              <br />
                              <span class="text-grey-m1 text-85">
                                                  <i class="far fa-clock"></i>
                                                  20 minutes ago
                                              </span>
                            </div>
                          </a>
                          <hr class="my-1px brc-grey-l3" />
                          <a href="#" class="d-flex mb-0 border-0 list-group-item list-group-item-action btn-h-lighter-secondary">
                            <img alt="Bob's avatar" src="{{asset('assets/assets/image/avatar/avatar4.png')}}" width="48" class="align-self-start border-2 brc-primary-m3 p-1px mr-2 radius-round" />
                            <div>
                              <span class="text-primary-m1 font-bolder">Bob:</span>
                              <span class="text-grey text-90">Nullam quis risus eget urna mollis ornare ...</span>
                              <br />
                              <span class="text-grey-m1 text-85">
                                                  <i class="far fa-clock"></i>
                                                  3:15 pm
                                              </span>
                            </div>
                          </a>
                          <hr class="my-1px brc-grey-l3" />
                          <a href="#" class="d-flex mb-0 border-0 list-group-item list-group-item-action btn-h-lighter-secondary">
                            <img alt="Kate's avatar" src="{{asset('assets/assets/image/avatar/avatar2.png')}}" width="48" class="align-self-start border-2 brc-primary-m3 p-1px mr-2 radius-round" />
                            <div>
                              <span class="text-primary-m1 font-bolder">Kate:</span>
                              <span class="text-grey text-90">Ciao sociis natoque eget urna mollis ornare ...</span>
                              <br />
                              <span class="text-grey-m1 text-85">
                                                  <i class="far fa-clock"></i>
                                                  1:33 pm
                                              </span>
                            </div>
                          </a>
                          <hr class="my-1px brc-grey-l3" />
                          <a href="#" class="d-flex mb-0 border-0 list-group-item list-group-item-action btn-h-lighter-secondary">
                            <img alt="Fred's avatar" src="{{asset('assets/assets/image/avatar/avatar5.png')}}" width="48" class="align-self-start border-2 brc-primary-m3 p-1px mr-2 radius-round" />
                            <div>
                              <span class="text-primary-m1 font-bolder">Fred:</span>
                              <span class="text-grey text-90">Vestibulum id penatibus et auctor  ...</span>
                              <br />
                              <span class="text-grey-m1 text-85">
                                                  <i class="far fa-clock"></i>
                                                  10:09 am
                                              </span>
                            </div>
                          </a>

                        </div><!-- ace-scroll -->

                        <hr class="my-1px brc-secondary-l2 border-double" />
                        <a href="html/page-inbox.html" class="mb-0 py-3 border-0 list-group-item text-purple text-uppercase text-center text-85 font-bolder">
                          See All Messages
                          <i class="ml-2 fa fa-arrow-right text-muted"></i>
                        </a>
                      </div><!-- .tab-pane : messages -->

                    </div>
                  </div>
                </li>


                <li class="nav-item dd-backdrop dropdown dropdown-mega">
                  <a class="nav-link dropdown-toggle pl-lg-3 pr-lg-4" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-flask text-110 icon-animated-vertical mr-lg-1"></i>

                    <span class="d-inline-block d-lg-none ml-2">Tasks</span><!-- show only on mobile -->
                    <span id="id-navbar-badge2" class="badge badge-sm text-95 text-yellow-l4">+2</span>

                    <i class="caret fa fa-angle-left d-block d-lg-none"></i>
                    <div class="dropdown-caret brc-warning-l2"></div>
                  </a>
                  <div class="dropdown-menu dropdown-xs dropdown-animated animated-1 p-0 bgc-white brc-warning-l1 shadow">
                    <div class="bgc-orange-l2 py-25 px-4 border-b-1 brc-orange-l2">
                      <span class="text-dark-tp4 text-600 text-90 text-uppercase">
                              <i class="fa fa-check mr-2px text-warning-d2 text-120"></i>
                              4 Tasks to complete
                            </span>
                    </div>


                    <div class="px-4 py-2">
                      <div class="text-95">
                        <span class="text-grey-d1">Software update</span>
                      </div>
                      <div class="progress mt-2">
                        <div class="progress-bar bgc-info" role="progressbar" style="width: 60%;" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">60%</div>
                      </div>
                    </div>

                    <hr class="my-1 mx-4" />
                    <div class="px-4 py-2">
                      <div class="text-95">
                        <span class="text-grey-d1">Hardware upgrade</span>
                      </div>
                      <div class="progress mt-2">
                        <div class="progress-bar bgc-warning" role="progressbar" style="width: 40%;" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">40%</div>
                      </div>
                    </div>

                    <hr class="my-1 mx-4" />
                    <div class="px-4 py-2">
                      <div class="text-95">
                        <span class="text-grey-d1">Customer support</span>
                      </div>
                      <div class="progress mt-2">
                        <div class="progress-bar bgc-danger" role="progressbar" style="width: 30%;" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">30%</div>
                      </div>
                    </div>

                    <hr class="my-1 mx-4" />
                    <div class="px-4 py-2">
                      <div class="text-95">
                        <span class="text-grey-d1">Fixing bugs</span>
                      </div>
                      <div class="progress mt-2">
                        <div class="progress-bar bgc-success progress-bar-striped progress-bar-animated" role="progressbar" style="width: 85%;" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">85%</div>
                      </div>
                    </div>




                    <hr class="my-1px mx-2 brc-info-l2 " />
                    <a href="#" class="d-block bgc-h-primary-l4 py-3 border-0 text-center text-blue-m2">
                      <span class="text-85 text-600 text-uppercase">See All Tasks</span>
                      <i class="ml-2 fa fa-arrow-right text-muted"></i>
                    </a>
                  </div>
                </li> --}}


                <li class="nav-item dropdown order-first order-lg-last">
                  <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <img id="id-navbar-user-image" class="d-none1 d-lg-inline-block radius-round border-2 brc-white-tp1 mr-2 w-6" src="{{asset('assets/assets/image/avatar/profile.png')}}" alt="Jason's Photo">
                    <span class="d-inline-block d-lg-none d-xl-inline-block">
                              <span class="text-90" id="id-user-welcome">Welcome,</span>
                    <span class="nav-user-name">{{session('user')->name}}</span>
                    </span>

                    <i class="caret fa fa-angle-down d-none1 d-xl-block"></i>
                    <i class="caret fa fa-angle-left d-block d-lg-none"></i>
                  </a>

                  <div class="dropdown-menu dropdown-caret dropdown-menu-right dropdown-animated brc-primary-m3 py-1">
                    <div class="d-none1 d-lg-block d-xl-none">
                      <div class="dropdown-header">
                        Welcome, Jason
                      </div>
                      <div class="dropdown-divider"></div>
                    </div>

                    <div class="dropdown-clickable px-3 py-25 bgc-h-secondary-l3 border-b-1 brc-secondary-l2 d-none">
                      <!-- online/offline toggle -->
                      <div class="d-flex justify-content-center align-items-center tex1t-600">
                        <label for="id-user-online" class="text-grey-d1 pt-2 px-2">offline</label>
                        <input type="checkbox" class="ace-switch ace-switch-sm text-grey-l1 brc-green-d1" id="id-user-online" />
                        <label for="id-user-online" class="text-green-d1 text-600 pt-2 px-2">online</label>
                      </div>
                    </div>

                    <a class="mt-1 dropdown-item btn btn-outline-grey bgc-h-primary-l3 btn-h-light-primary btn-a-light-primary" href="/profile">
                      <i class="fa fa-user text-primary-m1 text-105 mr-1"></i>
                      Profile
                    </a>

                    {{-- <a class="dropdown-item btn btn-outline-grey bgc-h-success-l3 btn-h-light-success btn-a-light-success" href="#" data-toggle="modal" data-target="#id-ace-settings-modal">
                      <i class="fa fa-cog text-success-m1 text-105 mr-1"></i>
                      Settings
                    </a> --}}

                    <div class="dropdown-divider brc-primary-l2"></div>

                    <a class="dropdown-item btn btn-outline-grey bgc-h-secondary-l3 btn-h-light-secondary btn-a-light-secondary" href="/logout">
                      <i class="fa fa-power-off text-warning-d1 text-105 mr-1"></i>
                      Logout
                    </a>
                  </div>
                </li><!-- /.nav-item:last -->

              </ul><!-- /.navbar-nav menu -->
            </div>
            <!-- /.navbar-nav -->

          </div><!-- /#navbarMenu -->


        </div><!-- /.navbar-inner -->
      </nav>
      <div class="main-container bgc-white">

        <div id="sidebar" class="sidebar sidebar-fixed expandable sidebar-white2">
          <div class="sidebar-inner">

            <div class="ace-scroll flex-grow-1" data-ace-scroll="{}">

              <div class="sidebar-section my-2">
                <!-- the shortcut buttons -->
                <div class="sidebar-section-item fadeable-left">
                  <div class="fadeinable sidebar-shortcuts-mini">
                    <!-- show this small buttons when collapsed -->
                    <span class="btn btn-success p-0 opacity-1"></span>
                    <span class="btn btn-info p-0 opacity-1"></span>
                    <span class="btn btn-orange p-0 opacity-1"></span>
                    <span class="btn btn-danger p-0 opacity-1"></span>
                  </div>

                  <div class="d-none1 fadeable">
                    <!-- show this small buttons when not collapsed -->
                    <div class="sub-arrow"></div>
                    <div>
                      <a href="{{URL::to('add-invoice')}}" title="Add Invoice" class="btn px-25 py-2 text-95 btn-success opacity-1">
                        <i class="fa fa-plus f-n-hover"></i>
                      </a>

                      <a href="{{URL::to('')}}" class="btn px-25 py-2 text-95 btn-info opacity-1">
                        <i class="fa fa-edit f-n-hover"></i>
                      </a>

                      <a href="{{URL::to('users')}}" class="btn px-25 py-2 text-95 btn-orange opacity-1">
                        <i class="fa fa-users f-n-hover"></i>
                      </a>

                      <a href="{{URL::to('settings')}}" class="btn px-25 py-2 text-95 btn-danger opacity-1">
                        <i class="fa fa-cogs f-n-hover"></i>
                      </a>
                    </div>
                  </div>
                </div>               
               
              </div>

             {{-- @include('admin/_left_menu') --}}

            </div><!-- /.sidebar scroll -->


            <div class="sidebar-section">
              <div class="sidebar-section-item fadeable-bottom">
                <div class="fadeinable">
                  <!-- shows this when collapsed -->
                  <div class="pos-rel">
                    <img alt="User" src="{{asset('assets/assets/image/avatar/profile.png')}}" width="42" class="px-1px radius-round mx-2 border-2 brc-default-m2" />
                    <span class="bgc-success radius-round border-2 brc-white p-1 position-tr mr-1 mt-2px"></span>
                  </div>
                </div>

                <div class="fadeable hideable w-100 bg-transparent shadow-none border-0">
                  <!-- shows this when full-width -->
                  {{-- <div id="sidebar-footer-bg" class="d-flex align-items-center bgc-white shadow-sm mx-2 mt-2px py-2 radius-t-1 border-x-1 border-t-2 brc-primary-m3">
                    <div class="d-flex mr-auto py-1">
                      <div class="pos-rel">
                        <img alt="User" src="{{asset('assets/assets/image/avatar/profile.png')}}" width="42" class="px-1px radius-round mx-2 border-2 brc-default-m2" />
                        <span class="bgc-success radius-round border-2 brc-white p-1 position-tr mr-1 mt-2px"></span>
                      </div>

                     <div>
                        <span class="text-blue-d1 font-bolder">
                          {{session('user')->name}}
                        </span>
                        <div class="text-80 text-grey">
                          User
                        </div>
                      </div> 
                    </div>

                    <a href="#" class="d-style btn btn-outline-primary btn-h-light-primary btn-a-light-primary border-0 p-2 mr-2px ml-4" title="Settings" data-toggle="modal" data-target="#id-ace-settings-modal">
                      <i class="fa fa-cog text-150 text-blue-d2 f-n-hover"></i>
                    </a>

                    <a href="/logout" class="d-style btn btn-outline-orange btn-h-light-orange btn-a-light-orange border-0 p-2 mr-1" title="Logout">
                      <i class="fa fa-sign-out-alt text-150 text-orange-d2 f-n-hover"></i>
                    </a>
                  </div> --}}
                </div>
              </div>
            </div>

          </div>
        </div>

        
  <div role="main" class="main-content">

    @include('_message')

		@yield('main_content')

        <footer class="footer d-none1 d-sm-block">
            <div class="footer-inner bgc-white-tp1">              

              <div class="pt-3 border-none border-t-3 brc-grey-l2 border-double">                    
                <span class="text-primary-m1 font-bolder text-120"><a href="https://ordevs.com/" target="_blank" style="font-size: 16px;">orDevs  &copy; {{date("Y")}}</span></a></div>

              
            </div><!-- .footer-inner -->

            <!-- `scroll to top` button inside footer (for example when in boxed layout) -->
            <div class="footer-tools">
              <a href="#" class="btn-scroll-up btn btn-dark mb-2 mr-2">
                <i class="fa fa-angle-double-up mx-2px text-95"></i>
              </a>
            </div>
          </footer>



          <!-- footer toolbox for mobile view -->
          <footer class="d-sm-none footer footer-sm footer-fixed">
            <div class="footer-inner">
              <div class="btn-group d-flex h-100 mx-2 border-x-1 border-t-2 brc-primary-m3 bgc-white-tp1 radius-t-1 shadow">
                <button class="btn btn-outline-primary btn-h-lighter-primary btn-a-lighter-primary border-0" data-toggle="modal" data-target="#id-ace-settings-modal">
                  <i class="fas fa-sliders-h text-blue-m1 text-120"></i>
                </button>

                <button class="btn btn-outline-primary btn-h-lighter-primary btn-a-lighter-primary border-0">
                  <i class="fa fa-plus-circle text-green-m1 text-120"></i>
                </button>

                <button class="btn btn-outline-primary btn-h-lighter-primary btn-a-lighter-primary border-0" data-toggle="collapse" data-target="#navbarSearch" aria-controls="navbarSearch" aria-expanded="false" aria-label="Toggle navbar search">
                  <i class="fa fa-search text-orange text-120"></i>
                </button>

                <button class="btn btn-outline-primary btn-h-lighter-primary btn-a-lighter-primary border-0 mr-0">
                  <span class="pos-rel">
                      <i class="fa fa-bell text-purple-m1 text-120"></i>
                      <span class="badge badge-dot bgc-red position-tr mt-n1 mr-n2px"></span>
                  </span>
                </button>
              </div>
            </div>
          </footer>
        </div>

        <div id="id-ace-settings-modal" class="my-1 my-lg-2 modal modal-nb ace-aside aside-right aside-offset aside-below-nav" data-backdrop="false" tabindex="-1" role="dialog" aria-hidden="true">

          <div class="modal-dialog" role="document">
            <div class="modal-content w-auto flex-grow-1 pb-1px radius-0 radius-l-2 border-y-2 border-l-1 brc-default-m3 bgc-white-tp1 shadow">

              <div class="modal-header p-0 radius-0 mx-3">
                <h4 class="modal-title text-primary-d1 text-140 pt-2 pl-1">Visual Settings</h4>

                <button type="button" class="close m-0 mr-n2" data-dismiss="modal" aria-label="Close">
                  <i class="fa fa-times text-70" aria-hidden="true"></i>
                </button>
              </div>

              <div class="modal-body mx-md-2" data-ace-scroll='{"smooth": true, "lock": true}'>
                <form autocomplete="off">
                  <div class="d-flex flex-column flex-md-row justify-content-md-between align-items-md-center">
                    <h5 class="text-default-d2">
                      Zoom
                    </h5>

                    <div class="btn-group btn-group-toggle align-self-end" data-toggle="buttons">
                      <label class="btn btn-sm btn-lighter-grey btn-h-light-primary btn-a-primary">
                        90%
                        <input type="radio" name="zoom-level" value="90" />
                      </label>

                      <label class="btn btn-sm btn-lighter-grey btn-h-light-primary btn-a-primary active">
                        100%
                        <input type="radio" name="zoom-level" value="none" checked />
                      </label>

                      <label class="btn btn-sm btn-lighter-grey btn-h-light-primary btn-a-primary">
                        110%
                        <input type="radio" name="zoom-level" value="110" />
                      </label>

                      <label class="btn btn-sm btn-lighter-grey btn-h-light-primary btn-a-primary">
                        120%
                        <input type="radio" name="zoom-level" value="120" />
                      </label>
                    </div>
                  </div>


                  <hr class="border-double my-md-3" />


                  <h5 class="text-purple-d1">
                    Themes
                  </h5>

                  <div id="auto-match-div" class="bgc-secondary-l4 py-1 radius-1 mb-3 border-1 radius-1 border-l-3 brc-secondary-m4">
                    <label class="mt-1 pr-2 d-flex align-items-center" for="id-auto-match">
                      <input type="checkbox" class="input-lg mx-15" id="id-auto-match" checked />

                      <span class="pl-0 text-secondary-d1 text-90 font-bolder">
                        Match sidebar & navbar themes
                      </span>
                    </label>
                  </div>


                  <div class="d-flex flex-column flex-md-row justify-content-md-between align-items-md-center mt-3">
                    <h6 class="text-95 pl-1 text-grey-d1">Sidebar</h6>

                    <div class="btn-group btn-group-toggle align-self-end flex-wrap px-0  col-10 col-sm-7" data-toggle="buttons">
                      <label class="btn btn-sm btn-light-default btn-text-default btn-bgc-white btn-a-default btn-h-default">
                        Dark
                        <input type="radio" name="sidebar-theme" value="dark" />
                      </label>

                      <label class="btn btn-sm btn-light-default btn-text-default btn-bgc-white btn-a-default btn-h-default">
                        Light
                        <input type="radio" name="sidebar-theme" value="light" />
                      </label>
                    </div>
                  </div>



                  <div>
                    <div class="d-none1 bgc-secondary-l1 radius-1 px-1 mb-3 mt-1 text-center" id="id-sidebar-themes-dark">
                      <div class="btn-group btn-group-toggle align-self-end flex-wrap justify-content-center w-75 mx-auto align-items-center my-2 flex-equal-sm" data-toggle="buttons">
                        <label class="btn btn-xs sidebar-color border-0 sidebar-dark d-style active m-1px">
                          <i class="fa fa-check text-white v-active"></i>
                          <input type="radio" name="sidebar-dark" value="dark" checked />
                        </label>

                        <label class="btn btn-xs sidebar-color border-0 sidebar-dark2 d-style m-1px">
                          <i class="fa fa-check text-white v-active"></i>
                          <input type="radio" name="sidebar-dark" value="dark2" />
                        </label>

                        <label class="btn btn-xs sidebar-color border-0 sidebar-darkblue d-style m-1px">
                          <i class="fa fa-check text-white v-active"></i>
                          <input type="radio" name="sidebar-dark" value="darkblue" />
                        </label>

                        <label class="btn btn-xs sidebar-color border-0 sidebar-darkslategrey d-style m-1px">
                          <i class="fa fa-check text-white v-active"></i>
                          <input type="radio" name="sidebar-dark" value="darkslategrey" />
                        </label>

                        <label class="btn btn-xs sidebar-color border-0 sidebar-cadetblue d-style m-1px">
                          <i class="fa fa-check text-white v-active"></i>
                          <input type="radio" name="sidebar-dark" value="cadetblue" />
                        </label>

                        <label class="btn btn-xs sidebar-color border-0 sidebar-plum d-style my-1px m-1px">
                          <i class="fa fa-check text-white v-active"></i>
                          <input type="radio" name="sidebar-dark" value="plum" />
                        </label>

                        <label class="btn btn-xs sidebar-color border-0 sidebar-darkslateblue d-style m-1px">
                          <i class="fa fa-check text-white v-active"></i>
                          <input type="radio" name="sidebar-dark" value="darkslateblue" />
                        </label>

                        <label class="btn btn-xs sidebar-color border-0 sidebar-purple d-style m-1px">
                          <i class="fa fa-check text-white v-active"></i>
                          <input type="radio" name="sidebar-dark" value="purple" />
                        </label>

                        <label class="btn btn-xs sidebar-color border-0 sidebar-steelblue d-style m-1px">
                          <i class="fa fa-check text-white v-active"></i>
                          <input type="radio" name="sidebar-dark" value="steelblue" />
                        </label>

                        <label class="btn btn-xs sidebar-color border-0 sidebar-blue d-style m-1px">
                          <i class="fa fa-check text-white v-active"></i>
                          <input type="radio" name="sidebar-dark" value="blue" />
                        </label>

                        <label class="btn btn-xs sidebar-color border-0 sidebar-teal d-style m-1px d-none1">
                          <i class="fa fa-check text-white v-active"></i>
                          <input type="radio" name="sidebar-dark" value="teal" />
                        </label>

                        <label class="btn btn-xs sidebar-color border-0 sidebar-green d-style m-1px">
                          <i class="fa fa-check text-white v-active"></i>
                          <input type="radio" name="sidebar-dark" value="green" />
                        </label>

                        <label class="btn btn-xs sidebar-color border-0 sidebar-darkcrimson d-style m-1px">
                          <i class="fa fa-check text-white v-active"></i>
                          <input type="radio" name="sidebar-dark" value="darkcrimson" />
                        </label>

                        <label class="btn btn-xs sidebar-color border-0 sidebar-gradient1 d-style m-1px">
                          <i class="fa fa-check text-white v-active"></i>
                          <input type="radio" name="sidebar-dark" value="gradient1" />
                        </label>

                        <label class="btn btn-xs sidebar-color border-0 sidebar-gradient2 d-style m-1px">
                          <i class="fa fa-check text-white v-active"></i>
                          <input type="radio" name="sidebar-dark" value="gradient2" />
                        </label>

                        <label class="btn btn-xs sidebar-color border-0 sidebar-gradient3 d-style m-1px">
                          <i class="fa fa-check text-white v-active"></i>
                          <input type="radio" name="sidebar-dark" value="gradient3" />
                        </label>

                        <label class="btn btn-xs sidebar-color border-0 sidebar-gradient4 d-style m-1px">
                          <i class="fa fa-check text-white v-active"></i>
                          <input type="radio" name="sidebar-dark" value="gradient4" />
                        </label>

                        <!--
                      <label class="btn btn-xs sidebar-color border-0 sidebar-gradient5 d-style m-1px d-none1">
                        <i class="fa fa-check text-white v-active"></i>
                        <input type="radio" name="sidebar-dark" value="gradient5"  />
                      </label>
                      -->

                      </div>
                    </div><!-- #id-sidebar-themes-dark -->


                    <div class="d-none1" id="id-sidebar-themes-light">
                      <div class="bgc-secondary-tp2 radius-1 py-1 px-1 mb-3 mt-1 text-center">
                        <div class="d-flex btn-group btn-group-toggle align-self-end flex-wrap justify-content-center mx-auto align-items-center my-2 flex-equal-sm" data-toggle="buttons">

                          <label class="active btn btn-xs border-0 sidebar-white2 d-style m-1px">
                            <i class="fa fa-check text-muted v-active"></i>
                            <input type="radio" name="sidebar-light" value="white" checked />
                          </label>

                          <label class="btn btn-xs border-0 sidebar-white2 d-style m-1px d-none1">
                            <i class="fa fa-check text-muted v-active"></i>
                            <input type="radio" name="sidebar-light" value="white2" />
                          </label>

                          <label class="btn btn-xs border-0 sidebar-white3 d-style m-1px">
                            <i class="fa fa-check text-muted v-active"></i>
                            <input type="radio" name="sidebar-light" value="white3" />
                          </label>

                          <label class="btn btn-xs border-0 sidebar-white4 d-style m-1px">
                            <i class="fa fa-check text-muted v-active"></i>
                            <input type="radio" name="sidebar-light" value="white4" />
                          </label>

                          <label class="btn btn-xs border-0 sidebar-light d-style m-1px">
                            <i class="fa fa-check text-muted v-active"></i>
                            <input type="radio" name="sidebar-light" value="light" />
                          </label>

                          <label class="btn btn-xs border-0 sidebar-lightblue d-style m-1px">
                            <i class="fa fa-check text-muted v-active"></i>
                            <input type="radio" name="sidebar-light" value="lightblue" />
                          </label>

                          <label class="btn btn-xs border-0 sidebar-lightblue2 d-style m-1px">
                            <i class="fa fa-check text-muted v-active"></i>
                            <input type="radio" name="sidebar-light" value="lightblue2" />
                          </label>

                          <label class="btn btn-xs border-0 sidebar-lightpurple d-style m-1px">
                            <i class="fa fa-check text-muted v-active"></i>
                            <input type="radio" name="sidebar-light" value="lightpurple" />
                          </label>


                        </div>
                      </div>
                    </div><!-- #id-sidebar-themes-light -->

                  </div>

                  <hr class="border-dotted" />

                  <div class="d-flex flex-column flex-md-row justify-content-md-between align-items-md-center">
                    <h6 class="text-95 pl-1 text-grey-d1">Navbar</h6>

                    <div id="navbar-themes-show" class="btn-group btn-group-toggle align-self-end flex-wrap px-0 col-10 col-sm-7" data-toggle="buttons">
                      <label class="btn btn-sm btn-light-green btn-text-green btn-bgc-white btn-a-green btn-h-green">
                        Light
                        <input type="radio" name="navbar-theme" value="light" />
                      </label>

                      <label class="btn btn-sm btn-light-green btn-text-green btn-bgc-white btn-a-green btn-h-green">
                        Dark
                        <input type="radio" name="navbar-theme" value="dark" />
                      </label>
                    </div>

                    <div id="navbar-themes-show-msg" class="d-none1 text-95 px-3 py-15 bgc-secondary-l3 border-1 brc-secondary-m4 border-dotted ml-3 radius-1">
                      Navbar themes can be viewed in<br /> <span>Dashboard <a class="btn-h-dark no-underline px-2px" href="html/dashboard.html">1</a> & <a class="btn-h-dark no-underline px-2px" href="html/dashboard-4.html">4</a></span>
                    </div>

                  </div>

                  <div>
                    <div class="d-none1 bgc-secondary-l1 radius-1 px-1 mb-3 mt-1 text-center" id="id-navbar-themes-dark">
                      <div class="btn-group btn-group-toggle align-self-end flex-wrap justify-content-center w-75 mx-auto align-items-center my-2 flex-equal-sm" data-toggle="buttons">

                        <label class="btn btn-xs border-0 navbar-blue d-style active m-1px">
                          <i class="fa fa-check text-white v-active"></i>
                          <input type="radio" name="navbar-dark" value="blue" checked />
                        </label>

                        <label class="btn btn-xs border-0 navbar-darkblue d-style m-1px">
                          <i class="fa fa-check text-white v-active"></i>
                          <input type="radio" name="navbar-dark" value="darkblue" />
                        </label>

                        <label class="btn btn-xs border-0 navbar-teal d-style m-1px">
                          <i class="fa fa-check text-white v-active"></i>
                          <input type="radio" name="navbar-dark" value="teal" />
                        </label>

                        <label class="btn btn-xs border-0 navbar-green d-style m-1px">
                          <i class="fa fa-check text-white v-active"></i>
                          <input type="radio" name="navbar-dark" value="green" />
                        </label>

                        <label class="btn btn-xs border-0 navbar-cadetblue d-style m-1px">
                          <i class="fa fa-check text-white v-active"></i>
                          <input type="radio" name="navbar-dark" value="cadetblue" />
                        </label>



                        <label class="btn btn-xs border-0 navbar-plum d-style m-1px">
                          <i class="fa fa-check text-white v-active"></i>
                          <input type="radio" name="navbar-dark" value="plum" />
                        </label>

                        <label class="btn btn-xs border-0 navbar-purple d-style m-1px">
                          <i class="fa fa-check text-white v-active"></i>
                          <input type="radio" name="navbar-dark" value="purple" />
                        </label>

                        <label class="btn btn-xs border-0 navbar-orange d-style m-1px">
                          <i class="fa fa-check text-white v-active"></i>
                          <input type="radio" name="navbar-dark" value="orange" />
                        </label>


                        <label class="btn btn-xs border-0 navbar-brown d-style m-1px">
                          <i class="fa fa-check text-white v-active"></i>
                          <input type="radio" name="navbar-dark" value="brown" />
                        </label>

                        <label class="btn btn-xs border-0 navbar-darkgreen d-style m-1px">
                          <i class="fa fa-check text-white v-active"></i>
                          <input type="radio" name="navbar-dark" value="darkgreen" />
                        </label>

                        <label class="btn btn-xs border-0 navbar-skyblue d-style m-1px">
                          <i class="fa fa-check text-white v-active"></i>
                          <input type="radio" name="navbar-dark" value="skyblue" />
                        </label>

                        <label class="btn btn-xs border-0 navbar-secondary d-style m-1px">
                          <i class="fa fa-check text-white v-active"></i>
                          <input type="radio" name="navbar-dark" value="secondary" />
                        </label>

                      </div>
                    </div><!-- #id-navbar-themes-dark -->

                    <div class="d-none1" id="id-navbar-themes-light">
                      <div class="bgc-secondary-tp2 radius-1 py-1 px-1 mb-3 mt-1 text-center">
                        <div class="btn-group btn-group-toggle align-self-end flex-wrap justify-content-center w-75 mx-auto align-items-center my-2 flex-equal-sm" data-toggle="buttons">

                          <label class="active btn btn-xs border-0 navbar-white d-style m-1px">
                            <i class="fa fa-check text-muted v-active"></i>
                            <input type="radio" name="navbar-light" value="white" checked />
                          </label>

                          <label class="btn btn-xs border-0 navbar-white2 d-style m-1px">
                            <i class="fa fa-check text-muted v-active"></i>
                            <input type="radio" name="navbar-light" value="white2" />
                          </label>

                          <label class="btn btn-xs border-0 navbar-lightblue d-style m-1px">
                            <i class="fa fa-check text-muted v-active"></i>
                            <input type="radio" name="navbar-light" value="lightblue" />
                          </label>

                          <label class="btn btn-xs border-0 navbar-lightpurple d-style m-1px">
                            <i class="fa fa-check text-muted v-active"></i>
                            <input type="radio" name="navbar-light" value="lightpurple" />
                          </label>

                          <label class="btn btn-xs border-0 navbar-lightgreen d-style m-1px">
                            <i class="fa fa-check text-muted v-active"></i>
                            <input type="radio" name="navbar-light" value="lightgreen" />
                          </label>

                          <label class="btn btn-xs border-0 navbar-lightgrey d-style m-1px">
                            <i class="fa fa-check text-muted v-active"></i>
                            <input type="radio" name="navbar-light" value="lightgrey" />
                          </label>

                          <!--
                        <label class="btn btn-xs border-0 navbar-lightyellow d-style m-1px">
                          <i class="fa fa-check text-muted v-active"></i>
                          <input type="radio" name="navbar-light" value="lightyellow"  />
                        </label>
        
                        <label class="btn btn-xs border-0 navbar-khaki d-style m-1px">
                          <i class="fa fa-check text-muted v-active"></i>
                          <input type="radio" name="navbar-light" value="khaki"  />
                        </label>
                        -->

                        </div>
                      </div>

                    </div><!-- #id-navbar-themes-light -->

                  </div>


                  <hr class="border-dotted" />


                  <div class="text-95">
                    <h5 class="text-success">Layout</h5>

                    <div class="mt-3 d-flex justify-content-between align-items-center">
                      <label for="id-navbar-fixed" class="pl-1 text-grey-d1">Fixed Navbar</label>
                      <input type="checkbox" class="ace-switch" id="id-navbar-fixed" checked />
                    </div>

                    <div class="mt-2 d-flex justify-content-between align-items-center">
                      <label for="id-sidebar-fixed" class="pl-1 text-grey-d1">Fixed Sidebar</label>
                      <input type="checkbox" class="ace-switch" id="id-sidebar-fixed" checked />
                    </div>

                    <div class="mt-2 d-flex justify-content-between align-items-center">
                      <label for="id-footer-fixed" class="pl-1 text-grey-d1">Fixed Footer</label>
                      <input type="checkbox" class="ace-switch" id="id-footer-fixed" />
                    </div>

                    <div class="mt-2 d-none1 d-xl-flex flex-column flex-md-row justify-content-md-between align-items-md-center">
                      <div class="pl-1 text-grey-d1">Boxed Layout</div>

                      <div class="w-50 btn-group btn-group-toggle flex-row flex-wrap fl1ex-md-nowrap" data-toggle="buttons">
                        <label class="btn btn-sm btn-light-primary btn-bgc-white btn-text-primary btn-h-primary btn-a-primary">
                          None
                          <input type="radio" name="boxed-layout" value="none" />
                        </label>

                        <label class="btn btn-sm btn-light-primary btn-bgc-white btn-text-primary btn-h-primary btn-a-primary">
                          All
                          <input type="radio" name="boxed-layout" value="all" />
                        </label>

                        <label class="btn btn-sm btn-light-primary btn-bgc-white btn-text-primary btn-h-primary btn-a-primary">
                          Not Navbar
                          <input type="radio" name="boxed-layout" value="not-navbar" />
                        </label>

                        <label class="btn btn-sm btn-light-primary btn-bgc-white btn-text-primary btn-h-primary btn-a-primary active">
                          Only Content
                          <input type="radio" name="boxed-layout" value="only-content" checked />
                        </label>
                      </div>
                    </div>

                    <div id="id-body-bg" class="collapse">
                      <div class="mt-3 d-none1 d-xl-flex flex-column flex-md-row justify-content-md-between align-items-md-center">
                        <h6 class="text-95 pl-1 text-grey-d1">Body Background:</h6>

                        <div class="btn-group btn-group-toggle align-self-end" data-toggle="buttons">
                          <label class="btn btn-sm btn-outline-purple active  mb-1">
                            None
                            <input type="radio" name="body-theme" value="auto" checked />
                          </label>

                          <label class="btn btn-sm btn-outline-purple mb-1">
                            Image 1
                            <input type="radio" name="body-theme" value="img1" />
                          </label>

                          <label class="btn btn-sm btn-outline-purple mb-1">
                            Image 2
                            <input type="radio" name="body-theme" value="img2" />
                          </label>
                        </div>
                      </div>
                    </div>



                    <hr class="border-dotted my-2" />

                    <div class="mt-1 d-flex justify-content-between align-items-center">
                      <label for="id-rtl" class="pl-1 text-grey-d1">RTL (right to left)</label>

                      <input type="checkbox" class="ace-switch" id="id-rtl" />
                    </div>


                  </div>

                  <hr class="border-double my-md-4" />

                  <div class="d-flex flex-column flex-md-row justify-content-md-between align-items-md-center">
                    <h5 class="text-info">Font</h5>

                    <div class="align-self-end w-75">
                      <select id="id-change-font" class="ace-select radius-round w-100 text-grey brc-h-info-m2">
                        <option value="lato">Lato</option>
                        <option value="manrope">Manrope</option>
                        <option value="montserrat">Montserrat</option>
                        <option value="noto-sans">Noto Sans</option>
                        <option value="open-sans" selected>Open Sans</option>
                        <option value="poppins">Poppins</option>
                        <option value="raleway">Raleway</option>
                        <option value="roboto" class="text-primary-d2 text-600">Roboto (popular)</option>
                        <option value="">----</option>
                        <option value="markazi">Markazi (for RTL languages)</option>
                      </select>
                    </div>
                  </div>


                  <hr class="border-double my-md-4" />

                  <div class="text-95">
                    <h5 class="text-orange-d2 ml-n2px">Sidebar</h5>
                    <!--
                  <div class="mt-3 d-none1 d-xl-flex justify-content-between align-items-center">
                      <label for="id-sidebar-compact" class="pl-1 text-grey-d2">Compact</label>
        
                      <div class="custom-control custom-switch d-inline-block">
                        <input type="checkbox" class="custom-control-input" id="id-sidebar-compact"  />
                        <label class="custom-control-label" for="id-sidebar-compact"></label>
                      </div>
                  </div>
                  -->

                    <div class="mt-2 d-none1 d-xl-flex justify-content-between align-items-center">
                      <div class="pl-1 text-grey-d1">Collapsed Mode</div>

                      <div class="btn-group btn-group-toggle flex-row" data-toggle="buttons">
                        <label class="btn btn-sm btn-outline-red active">
                          Expand
                          <input type="radio" name="sidebar-collapsed" value="expandable" checked />
                        </label>

                        <label class="btn btn-sm btn-outline-red">
                          Popup
                          <input type="radio" name="sidebar-collapsed" value="hoverable" />
                        </label>

                        <label class="btn btn-sm btn-outline-red">
                          Hide
                          <input type="radio" name="sidebar-collapsed" value="hideable" />
                        </label>
                      </div>
                    </div>

                    <div class="mt-3 d-none1 d-xl-flex justify-content-between align-items-center">
                      <label for="id-sidebar-hover" class="pl-1 text-grey-d1">Submenu on Hover</label>

                      <label>
                        <input type="checkbox" class="ace-switch" id="id-sidebar-hover" />
                      </label>
                    </div>

                    <div class="mt-2 d-flex d-xl-none justify-content-between align-items-center">
                      <label for="id-push-content" class="pl-1 text-grey-d1">Push Content</label>

                      <label>
                        <input type="checkbox" class="ace-switch" id="id-push-content" />
                      </label>
                    </div>

                  </div>

                  <div class="my-1"></div>
                </form>
              </div>

              <div class="modal-footer d-none1 justify-content-center">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                  <i class="fa fa-times mr-1"></i>
                  Close
                </button>
                <button type="button" class="btn btn-info">
                  <i class="fa fa-check mr-1"></i>
                  Keep changes
                </button>
              </div>

            </div><!-- .modal-content -->

            <div class="aside-header align-self-start mt-1 mt-lg-5 text-right d-style">
              <button type="button" class="btn btn-orange btn-lg shadow-sm pl-2 radius-l-2 f-n-hover py-1 py-md-2" data-toggle="modal" data-target="#id-ace-settings-modal">
                <i class="fa fa-cog text-110 ml-1"></i>
              </button>
            </div>
          </div><!-- .modal-dialog -->
        </div><!-- .modal-aside -->
      </div>
    </div>

    <script>

        $("#category_id").change(function(){
          var category_id = $(this).val();
          $.ajax({
            url: "find_subcategory",
            data: {
              _token: '{{csrf_token()}}',
              category_id: category_id
            },
            type: 'POST',
            success: function (response) {
                //console.log(response.data);
                  if(response.total>0){
                      $('#sub_category_id').empty();
                      $('#sub_category_id').focus;
                      $('#sub_category_id').append('<option value="">-- Select Sub Category --</option>'); 
                      $.each(response.data, function(key, value){
                          $('select[name="sub_category_id"]').append('<option value="'+ value.id +'">' + value.name+ '</option>');
                      });
                  }else{
                      $('#sub_category_id').empty();
                  }
            }
          });
        });


      
       $("#cityId").change(function(){
        var city = $(this).val();
        $.ajax({
          url: "find_state",
          data: {
            _token: '{{csrf_token()}}',
            name: city
          },
          type: 'POST',
          success: function (response) {
             console.log(response.data);
              $("#state").val(response.data.state_name)
          }
        });
      });
    </script>

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
    <script type="text/javascript"> 

   $(document).ready(function() {
        $('.select2-multiple').select2({
          tags: true
        })
    });

    $(document).ready(function() {
        $('.select2-single').select2();
    });
    $(document).ready(function() {
        $('.ss').select2();
    });


    // edit search placeholder
    $(document).ready(function(){ 
      $('.pl-45').attr('placeholder','Search here .. ');
    });


      function PreviewImage() {
          // previousImage.style.display = "none";
          var oFReader = new FileReader();
          oFReader.readAsDataURL(document.getElementById("uploadImage").files[0]);

          oFReader.onload = function (oFREvent) {
              document.getElementById("uploadPreview").src = oFREvent.target.result;
          };
          $("#uploadPreview").css("display", "block");
          $("#noimage").css("display", "none");
          
      };                        
      function PreviewImage2() {
          oFReader.readAsDataURL(document.getElementById("uploadImage2").files[0]);            
            oFReader.onload = function (oFREvent) {
                document.getElementById("uploadPreview2").src = oFREvent.target.result;
            };
            $("#uploadPreview2").css("display", "block");          
      };                        
      function PreviewImage3() { 
          oFReader.readAsDataURL(document.getElementById("uploadImage3").files[0]);            
            oFReader.onload = function (oFREvent) {
                document.getElementById("uploadPreview3").src = oFREvent.target.result;
            };
            $("#uploadPreview3").css("display", "block");          
      };                        
  </script>  
   
  </body>

</html>