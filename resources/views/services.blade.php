<?php $menu ='services';?>
@extends('layouts.master')
@section('main_content')

<style>
    div#carousel-example-1z, div#carousel-example-2z, div#carousel-example-3z, div#carousel-example-4z {
    width: 80%;
    margin: 0 auto;
}

</style>
<main class="main">
  
    <div class="page-header text-center" style="background-image: url('{{asset('frontend/images/page-header-bg.jpg')}}')">
        <div class="container">
            <h1 class="page-title">Custom 3D Modeling Services<span></span></h1> 
        </div><!-- End .container -->
    </div><!-- End .page-header -->
      

    <div class="page-content pb-3">

        <div class="container flash-message mt-2">
            @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                @if(Session::has('alert-' . $msg))
                    <p class="alert alert-{{ $msg }} text-center">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                @endif
            @endforeach
          </div>

          
        <div class="container">
            <div class="row">
                {{-- <div class="col-lg-10 offset-lg-1"> --}}
                <div class="col-lg-12">
                    <div class="about-text text-left mt-3">
                        <h2 class="title text-left mb-2"></h2><!-- End .title text-center mb-2 -->
                        <p>Ready 3d models provides all in one virtual photo shooting solution. With the help of our large team you can avoid tough logistics and complex organizational effort including photo shoot planning, location renting, produce all products for shooting and images post production etc with a much reduced cost and faster delivery time. Welcome to ready3dmodels custom 3D modeling service. Let us Transform your photography process towards CGI (Computer generated images). </p>    

                        <h2 class="title text-left mt-2">Photorealistic 3D modeling :</h2><!-- End .title text-center mb-2 -->
                        <p>Whether you are after a life like interior visualization or creating content for a catalog to replace the traditional photography you need extremely detailed and accurately created 3D models. Ready3Dmodels team has all the necessary skills and experience to produce 3D models that looks more appealing than the real life products. </p>                          
                   
                        <br>
                        <!--Carousel 1-->
                        <div id="carousel-example-1z" class="carousel slide carousel-fade z-depth-1-half" data-ride="carousel">
                            <!--Indicators-->
                            <ol class="carousel-indicators">
                            <li data-target="#carousel-example-1z" data-slide-to="0" class="active"></li>
                            <li data-target="#carousel-example-1z" data-slide-to="1"></li>
                            <li data-target="#carousel-example-1z" data-slide-to="2"></li>
                            </ol>
                            <!--/.Indicators-->
                            <!--Slides-->
                            <div class="carousel-inner" role="listbox">
                            <!--First slide-->
                            <div class="carousel-item active">
                                <img class="d-block w-100" src="https://mdbootstrap.com/img/Photos/Slides/img%20(130).jpg" alt="First slide">
                            </div>
                            <!--/First slide-->
                            <!--Second slide-->
                            <div class="carousel-item">
                                <img class="d-block w-100" src="https://mdbootstrap.com/img/Photos/Slides/img%20(129).jpg" alt="Second slide">
                            </div>
                            <!--/Second slide-->
                            <!--Third slide-->
                            <div class="carousel-item">
                                <img class="d-block w-100" src="https://mdbootstrap.com/img/Photos/Slides/img%20(70).jpg" alt="Third slide">
                            </div>
                            <!--/Third slide-->
                            </div>
                            <!--/.Slides-->
                            <!--Controls-->
                            <a class="carousel-control-prev" href="#carousel-example-1z" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carousel-example-1z" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                            </a>
                            <!--/.Controls-->
                        </div>
                        <!--/.Carousel 1-->
                    </div><!-- End .about-text -->

                    <div class="about-text text-left mt-3">
                        <h2 class="title text-left mt-2">Product images:</h2><!-- End .title text-center mb-2 -->
                        <p>When you have the properly made 3D models. You can create as many product images as you want from different viewing angles and with different materials/colors. In Ready3dmodels, through out the last decade we developed practices that are based on automation and optimized to create thousands of product images in a much shorter period of time.</p>                                                    
                   
                        <br>
                        <!--Carousel 2-->
                        <div id="carousel-example-2z" class="carousel slide carousel-fade z-depth-1-half" data-ride="carousel">
                            <!--Indicators-->
                            <ol class="carousel-indicators">
                            <li data-target="#carousel-example-2z" data-slide-to="0" class="active"></li>
                            <li data-target="#carousel-example-2z" data-slide-to="1"></li>
                            <li data-target="#carousel-example-2z" data-slide-to="2"></li>
                            </ol>
                            <!--/.Indicators-->
                            <!--Slides-->
                            <div class="carousel-inner" role="listbox">
                            <!--First slide-->
                            <div class="carousel-item active">
                                <img class="d-block w-100" src="https://mdbootstrap.com/img/Photos/Slides/img%20(130).jpg" alt="First slide">
                            </div>
                            <!--/First slide-->
                            <!--Second slide-->
                            <div class="carousel-item">
                                <img class="d-block w-100" src="https://mdbootstrap.com/img/Photos/Slides/img%20(129).jpg" alt="Second slide">
                            </div>
                            <!--/Second slide-->
                            <!--Third slide-->
                            <div class="carousel-item">
                                <img class="d-block w-100" src="https://mdbootstrap.com/img/Photos/Slides/img%20(70).jpg" alt="Third slide">
                            </div>
                            <!--/Third slide-->
                            </div>
                            <!--/.Slides-->
                            <!--Controls-->
                            <a class="carousel-control-prev" href="#carousel-example-2z" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carousel-example-2z" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                            </a>
                            <!--/.Controls-->
                        </div>
                        <!--/.Carousel 1-->
                    </div><!-- End .about-text -->

                    <div class="about-text text-left mt-3">
                        <h2 class="title text-left mt-2">Lifestyle images:</h2><!-- End .title text-center mb-2 -->
                        <p>Lifestyle images are also called mood images or in situ images. These images are intended to create desire and attract positive attention by putting the products in right context and in original situation. Our creative team has been creating images that are indistinguishable from great quality photographs. </p>                                                    
                   
                        <br>
                        <!--Carousel 2-->
                        <div id="carousel-example-3z" class="carousel slide carousel-fade z-depth-1-half" data-ride="carousel">
                            <!--Indicators-->
                            <ol class="carousel-indicators">
                            <li data-target="#carousel-example-3z" data-slide-to="0" class="active"></li>
                            <li data-target="#carousel-example-3z" data-slide-to="1"></li>
                            <li data-target="#carousel-example-3z" data-slide-to="2"></li>
                            </ol>
                            <!--/.Indicators-->
                            <!--Slides-->
                            <div class="carousel-inner" role="listbox">
                            <!--First slide-->
                            <div class="carousel-item active">
                                <img class="d-block w-100" src="https://mdbootstrap.com/img/Photos/Slides/img%20(130).jpg" alt="First slide">
                            </div>
                            <!--/First slide-->
                            <!--Second slide-->
                            <div class="carousel-item">
                                <img class="d-block w-100" src="https://mdbootstrap.com/img/Photos/Slides/img%20(129).jpg" alt="Second slide">
                            </div>
                            <!--/Second slide-->
                            <!--Third slide-->
                            <div class="carousel-item">
                                <img class="d-block w-100" src="https://mdbootstrap.com/img/Photos/Slides/img%20(70).jpg" alt="Third slide">
                            </div>
                            <!--/Third slide-->
                            </div>
                            <!--/.Slides-->
                            <!--Controls-->
                            <a class="carousel-control-prev" href="#carousel-example-3z" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carousel-example-3z" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                            </a>
                            <!--/.Controls-->
                        </div>
                        <!--/.Carousel 1-->
                    </div><!-- End .about-text -->

                    <div class="about-text text-left mt-3">
                        <h2 class="title text-left mt-2">Interactive visuals: </h2><!-- End .title text-center mb-2 -->
                        <p>This includes from pre-rendered 360° rotation to Realtime WebGL based configuration. You can integrate the technology that will allow you to play with your product by changing colors and rotating around in real-time. It feels closer to touching the product. These technologies can uplift your marketing face. </p>                                                    
                   
                        <br>    
                        
                       <a href="https://webapp.7cgi.com/avaReclinerChair/" target="_blank"> <img src="{{asset('frontend/images/AvaReclinerChair.gif')}}" style="margin: 0 auto" alt=""></a>

                        <!--Carousel 2-->
                        <div id="carousel-example-4z" class="d-none carousel slide carousel-fade z-depth-1-half" data-ride="carousel">
                            <!--Indicators-->
                            <ol class="carousel-indicators">
                            <li data-target="#carousel-example-4z" data-slide-to="0" class="active"></li>
                            <li data-target="#carousel-example-4z" data-slide-to="1"></li>
                            <li data-target="#carousel-example-4z" data-slide-to="2"></li>
                            </ol>
                            <!--/.Indicators-->
                            <!--Slides-->
                            <div class="carousel-inner" role="listbox">
                            <!--First slide-->
                            <div class="carousel-item active">
                                <img class="d-block w-100" src="https://mdbootstrap.com/img/Photos/Slides/img%20(130).jpg" alt="First slide">
                            </div>
                            <!--/First slide-->
                            <!--Second slide-->
                            <div class="carousel-item">
                                <img class="d-block w-100" src="https://mdbootstrap.com/img/Photos/Slides/img%20(129).jpg" alt="Second slide">
                            </div>
                            <!--/Second slide-->
                            <!--Third slide-->
                            <div class="carousel-item">
                                <img class="d-block w-100" src="https://mdbootstrap.com/img/Photos/Slides/img%20(70).jpg" alt="Third slide">
                            </div>
                            <!--/Third slide-->
                            </div>
                            <!--/.Slides-->
                            <!--Controls-->
                            <a class="carousel-control-prev" href="#carousel-example-4z" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carousel-example-4z" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                            </a>
                            <!--/.Controls-->
                        </div>
                        <!--/.Carousel 1-->
                    </div><!-- End .about-text -->


                </div>




            </div><!-- End .row -->
        
        </div><!-- End .container -->

        <div class="mb-2"></div><!-- End .mb-2 -->

        <div class="d-none bg-image pt-7 pb-5 pt-md-12 pb-md-9" style="background-image: url(https://portotheme.com/html/molla/assets/images/backgrounds/bg-4.jpg)">
            <div class="container">
                <div class="row">
                    <div class="col-6 col-md-3">
                        <div class="count-container text-center">
                            <div class="count-wrapper text-white">
                                <span class="count" data-from="0" data-to="40" data-speed="3000" data-refresh-interval="50">41</span>k+
                            </div><!-- End .count-wrapper -->
                            <h3 class="count-title text-white">Happy Customer</h3><!-- End .count-title -->
                        </div><!-- End .count-container -->
                    </div><!-- End .col-6 col-md-3 -->

                    <div class="col-6 col-md-3">
                        <div class="count-container text-center">
                            <div class="count-wrapper text-white">
                                <span class="count" data-from="0" data-to="20" data-speed="3000" data-refresh-interval="50">20</span>+
                            </div><!-- End .count-wrapper -->
                            <h3 class="count-title text-white">Years in Business</h3><!-- End .count-title -->
                        </div><!-- End .count-container -->
                    </div><!-- End .col-6 col-md-3 -->

                    <div class="col-6 col-md-3">
                        <div class="count-container text-center">
                            <div class="count-wrapper text-white">
                                <span class="count" data-from="0" data-to="95" data-speed="3000" data-refresh-interval="50">97</span>%
                            </div><!-- End .count-wrapper -->
                            <h3 class="count-title text-white">Return Clients</h3><!-- End .count-title -->
                        </div><!-- End .count-container -->
                    </div><!-- End .col-6 col-md-3 -->

                    <div class="col-6 col-md-3">
                        <div class="count-container text-center">
                            <div class="count-wrapper text-white">
                                <span class="count" data-from="0" data-to="15" data-speed="3000" data-refresh-interval="50">15</span>
                            </div><!-- End .count-wrapper -->
                            <h3 class="count-title text-white">Awards Won</h3><!-- End .count-title -->
                        </div><!-- End .count-container -->
                    </div><!-- End .col-6 col-md-3 -->
                </div><!-- End .row -->
            </div><!-- End .container -->
        </div><!-- End .bg-image pt-8 pb-8 -->

        <br>
        <hr>
        <br>

        <div class="page-content pb-0">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 mb-2 mb-lg-0">
                        <h2 class="title mb-1">Contact Information</h2><!-- End .title mb-2 -->
                        <p class="d-none mb-3">Vestibulum volutpat, lacus a ultrices sagittis, mi neque euismod dui, eu pulvinar nunc sapien ornare nisl. Phasellus pede arcu, dapibus eu, fermentum et, dapibus sed, urna.</p>
                        <div class="row">
                            <div class="col-sm-7">
                                <div class="contact-info">
                                    <h3>The Office</h3>

                                    <ul class="contact-list">
                                        <li>
                                            <i class="icon-map-marker"></i>
                                            70 Washington Square South New York, NY 10012, United States
                                        </li>
                                        <li>
                                            <i class="icon-phone"></i>
                                            <a href="tel:#">+92 423 567</a>
                                        </li>
                                        <li>
                                            <i class="icon-envelope"></i>
                                            <a href="mailto:#">info@ready3dmodels.com</a>
                                        </li>
                                    </ul><!-- End .contact-list -->
                                </div><!-- End .contact-info -->
                            </div><!-- End .col-sm-7 -->

                            <div class="col-sm-5">
                                <div class="contact-info">
                                    <h3>The Office</h3>

                                    <ul class="contact-list">
                                        <li>
                                            <i class="icon-clock-o"></i>
                                            <span class="text-dark">Monday-Saturday</span> <br>11am-7pm ET
                                        </li>
                                        <li>
                                            <i class="icon-calendar"></i>
                                            <span class="text-dark">Sunday</span> <br>11am-6pm ET
                                        </li>
                                    </ul><!-- End .contact-list -->
                                </div><!-- End .contact-info -->
                            </div><!-- End .col-sm-5 -->
                        </div><!-- End .row -->
                    </div><!-- End .col-lg-6 -->
                    <div class="col-lg-6">
                        <div id="message"></div>
                        <h2 class="title mb-1">Got Any Questions?</h2><!-- End .title mb-2 -->
                        <p class="mb-2">Use the form below to get in touch with the sales team</p>

                        <form action="" method="post" class="contact-form mb-3">
                          @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="cname" class="sr-only">Name</label>
                                    <input type="text" name="name" class="form-control" id="name" placeholder="Name *" required="">
                                </div><!-- End .col-sm-6 -->

                                <div class="col-sm-6">
                                    <label for="cemail" class="sr-only">Email</label>
                                    <input type="email" name="email" class="form-control" id="email" placeholder="Email *" required="">
                                </div><!-- End .col-sm-6 -->
                            </div><!-- End .row -->

                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="cphone" class="sr-only">Phone</label>
                                    <input type="tel" name="phone" class="form-control" id="phone" placeholder="Phone">
                                </div><!-- End .col-sm-6 -->

                                <div class="col-sm-6">
                                    <label for="csubject" class="sr-only">Subject</label>
                                    <input type="text" name="subject" class="form-control" id="subject" placeholder="Subject">
                                </div><!-- End .col-sm-6 -->
                            </div><!-- End .row -->

                            <label for="cmessage" class="sr-only">Message</label>
                            <textarea class="form-control" name="messages" cols="30" rows="4" id="messages" required="" placeholder="Message *"></textarea>

                            <input type="hidden" name="source" value="service_page"> 
                            <button type="submit" id="contactFormBtn" class="btn btn-outline-primary-2 btn-minwidth-sm">
                                <span>SUBMIT</span>
                                <i class="icon-long-arrow-right"></i>
                            </button> 
                        </form><!-- End .contact-form -->
                    </div><!-- End .col-lg-6 -->
                </div><!-- End .row -->
            </div><!-- End .container -->
           
        </div> 

    </div>

<style>
    .icon-boxes-container {
        display: none;
    }
</style>

</main>
@endsection