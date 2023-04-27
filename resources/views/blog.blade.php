
@extends('layouts.master')
@section('main_content')

			<!-- HERO-4
			============================================= -->	
			<section id="hero-4" class="hero-section">


				<!-- HERO-4 TEXT -->
				<div id="hero-5-txt" class="bg-scroll division">
					<div class="container white-color">						
						<div class="row">
							<img src="{{asset('frontend/images/hero-m-class.jpg')}}" class="class_slider" alt="">
							<div class="col-md-10 col-lg-12">
								<div class="hero-txt-class text-center">

									<!-- Title -->
									<h1 class="h3-lg wow fadeInUp" data-wow-delay="0.5s" style="color:#3d3d3d; font-family: Cormorant;
									font-weight: normal;
									font-style: normal;
									font-size: 57px;
									letter-spacing: 0em;
									line-height: 1.25em;
									text-transform: none;">

<!-- Articles and tools for support and self-healing.  -->
<form class="form-inline1" style="display: none">

	<div class="form-group1 mx-sm-3 mb-2">
	  <label for="staticEmail2" class="sr-only">Email</label>
	  <select class="form-control blog_search" aria-label="Default select example">
		<option selected>By Category</option>
		<option value="1">Meditation & Mindfulness</option>
		<option value="2">Recipes</option>
	  </select>
	</div>
	<div class="form-group1 mx-sm-3 mb-2">
	  <label for="staticEmail2" class="sr-only">Email</label>
	  <select class="form-control blog_search" aria-label="Default select example">
		<option selected>By Date</option>
		<option value="1">January 2021</option>
		<option value="2">February 2021</option>
	  </select>
	</div>

	
	<div class="form-group mx-sm-3 mb-2">
	  <label for="keyword" class="sr-only">Password</label>
	  <input type="text" class="form-control blog_search" id="keyword" placeholder="Keyword">
	</div>
	
  </form>

									
									</h1>
									
									

									

									

								</div>
							</div>	
						</div>	 <!-- End row -->
					</div>	 <!-- End container --> 
				</div>	 <!-- END HERO-4 TEXT -->



			</section>	<!-- END HERO-4 -->

			<div class="title text-center">				
				<img src="{{asset('frontend/images/resources.png')}}" class="services" alt="" style="width: 40%; margin-bottom: -75px; margin-top: 50px;">
			</div>


			<!-- SERVICES-2
			============================================= -->	

			<section id="services-2" class="wide-60 services-section division">
				<div class="container blog_page">
					<div class="row">	
						@foreach ($data as $item)				
						<div class="col-md-4">
							<a href="blog/{{$item->id}}"><img src="{{ URL::asset('storage/app/public/'.$item->image.'') }}" class="blog_item" alt="" style="width: 100%;"></a>

							<div class="blog_inner">
								<h4>{{$item->catName}}</h4> 
								<a href="blog/{{$item->id}}"><h3 style="white-space:pre-wrap;"><em>{{$item->title}}</em></h3></a>
								<p>{!! substr($item->short_description, 0, 1000) !!}</p>
								<div class="cta-btn text-center">
									<a href="blog/{{$item->id}}" class="btn btn-md btn-theme black-hover">Read More</a>
								</div>
							</div>
						</div>	
						@endforeach	
						
					</div>
				</div>
					
			</section>
			
			
 <br><br>
 <br><br>

 @endsection