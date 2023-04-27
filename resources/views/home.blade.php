@extends('layouts.master')
@section('main_content')
<?php
use App\Models\ProductCategory;
use App\Models\Product;
use App\Models\Page;
use App\Models\Collection;
?>

<main class="main">	
	
	<div class="ntro-slider-container text-center">
		<div class="row">
			<div class="col-md-10">
				<div class="owl-carousel owl-simple owl-light owl-nav-inside" data-toggle="owl" data-owl-options='{"nav": false}'>
					
					<?php 
						$data = Page::orderBy('id', 'desc')
						->where('parent', 'Slider')
						->where('active', 'on')
						->get(); 
					?>
					@foreach($data as $item)  
					<div class="intro-slide" style="background-image: url({{ URL::asset('storage/app/public/'.$item->image.'') }});">
						<div class="container intro-content">
							<h3 class="intro-subtitle">{{$item->sub_title}}</h3><!-- End .h3 intro-subtitle -->
							<h1 class="intro-title">{!! $item->title !!}</h1><!-- End .intro-title -->
		
							<a href="{{$item->link_action}}" target="_blank" class="btn btn-primary">
								<span>{{$item->link_title}}</span>
								<i class="icon-long-arrow-right"></i>
							</a>
						</div><!-- End .container intro-content -->
					</div><!-- End .intro-slide -->
					@endforeach


				</div><!-- End .owl-carousel owl-simple -->
			</div>
			<div class="col-md-2 hidden-sm">
				<?php 
					$featured = Page::orderBy('id', 'desc')
					->where('parent', 'Featured')
					->where('active', 'on')
					->limit(1)
					->get(); 
				?>
					
					@foreach($featured as $item)  
				<div class="banner banner-overlay  banner-content-stretch ">
					<a href="{{$item->link_action}}" target="_blank">
						
						<img src="{{ URL::asset('storage/app/public/'.$item->image.'') }}" style="height: 400px!important" alt="Banner image">
					</a>
					<div class="banner-content text-right">
						<div class="price text-center">
							<span class="text-white">
								<h3 class="text-white">{{$item->title}}</h3>
								{{$item->sub_title}}</strong>
							</span>
						</div>
						<a href="{{$item->link_action}}" target="_blank" class="btn btn-primary">
							<span>{{$item->link_title}}</span>
							<i class="icon-long-arrow-right"></i>
						</a>
					</div><!-- End .banner-content -->
				</div>
				@endforeach			

			</div>
		</div>

		

		{{-- <span class="slider-loader text-white"></span> --}}
		
		<!-- End .slider-loader -->
	</div><!-- End .intro-slider-container -->


	<div class="mb-1 mb-lg-1"></div><!-- End .mb-3 mb-lg-5 -->
	

	<div class="container-fluid">
		<div class="row">
			<div class="col-xl-12 col-xxl-12">
				{{-- col-xl-3 col-xxl-2 order-xl-first --}}

				{{-- banner --}}
				<div class="d-none row">
					<div class="col-lg-12 col-xxl-4-5col">
						<div class="row">
							<div class="col-md-6">
								<div class="banner banner-overlay">
									<a href="{{URL::to('sets')}}">
										<img src="{{asset('frontend/images/demos/demo-14/banners/banner-2.jpg')}}" alt="Banner img desc">
									</a>

									<div class="banner-content">
										<h4 class="banner-subtitle text-white d-none d-sm-block"><a href="#">Hottest Deals</a></h4><!-- End .banner-subtitle -->
										<h3 class="banner-title text-white"><a href="{{URL::to('sets')}}">Sets of 3D Models <br>For Spring <br><span>Up To  20% Off</span></a></h3><!-- End .banner-title -->
										<a href="{{URL::to('sets')}}" class="banner-link">Shop Now <i class="icon-long-arrow-right"></i></a>
									</div><!-- End .banner-content -->
								</div><!-- End .banner -->
							</div><!-- End .col-md-6 -->

							<div class="col-md-6">
								<div class="banner banner-overlay">
									<a href="{{URL::to('collections')}}">
										<img src="{{asset('frontend/images/demos/demo-14/banners/banner-3.png')}}" alt="Banner img desc">
									</a>

									<div class="banner-content">
										<h4 class="banner-subtitle text-white d-none d-sm-block"><a href="{{URL::to('collections')}}">Reduce your effors</a></h4><!-- End .banner-subtitle -->
										<h3 class="banner-title text-white"><a href="{{URL::to('collections')}}">Collection of 3D Models <br><span>Up To 30% Off</span></a></h3><!-- End .banner-title -->
										<a href="{{URL::to('collections')}}" class="banner-link">Shop Now <i class="icon-long-arrow-right"></i></a>
									</div><!-- End .banner-content -->
								</div><!-- End .banner banner-overlay -->
							</div><!-- End .col-md-6 -->
						</div><!-- End .row -->
					</div><!-- End .col-lg-3 col-xxl-4-5col -->

					<div class="col-12 col-xxl-5col d-none d-xxl-block">
						<div class="banner banner-overlay">
							<a href="{{URL::to('freebies')}}">
								<img src="{{asset('frontend/images/demos/demo-14/banners/banner-4.jpg')}}" alt="Banner img desc">
							</a>

							<div class="banner-content">
								<h4 class="banner-subtitle text-white"><a href="{{URL::to('freebies')}}">Just awesome</a></h4><!-- End .banner-subtitle -->
								<h3 class="banner-title text-white"><a href="{{URL::to('freebies')}}">Freebee Items</a></h3><!-- End .banner-title -->
								<a href="{{URL::to('freebies')}}" class="banner-link">Download Now <i class="icon-long-arrow-right"></i></a>
							</div><!-- End .banner-content -->
						</div><!-- End .banner banner-overlay -->
					</div><!-- End .col-lg-3 col-xxl-2 -->
				</div><!-- End .row -->
 
				{{-- carosal  set collection --}}
				<div class="bg-lighter trending-products">
					<div class="heading heading-flex1" style="padding-top: 10px;">
						{{-- <div class="heading-left">
							<h2 class="title">Trending Today</h2>
						</div> --}}

					  
					   <div class="heading-center">
							<ul class="nav nav-pills justify-content-center" role="tablist">
								<li class="nav-item">
									<a class="nav-link active1" id="sets-link" data-toggle="tab" href="#sets-tab" role="tab" aria-controls="sets-tab" aria-selected="true">Sets</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="collections-link" data-toggle="tab" href="#collections-tab" role="tab" aria-controls="collections-tab" aria-selected="false">Collections</a>
								</li>
								<li class="nav-item">
									<a class="nav-link active" id="top-selling-link" data-toggle="tab" href="#top-selling-tab" role="tab" aria-controls="top-selling-tab" aria-selected="false">New Arrivals</a>
								</li>
								
							</ul>
					   </div><!-- End .heading-right -->
					</div><!-- End .heading -->

					<div class="tab-content tab-content-carousel">
						<div class="tab-pane p-0 fade show active1" id="sets-tab" role="tabpanel" aria-labelledby="sets-link">
							<div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow owl-loaded owl-drag" data-toggle="owl" data-owl-options="{
									&quot;nav&quot;: false, 
									&quot;dots&quot;: true,
									&quot;margin&quot;: 20,
									&quot;loop&quot;: false,
									&quot;responsive&quot;: {
										&quot;0&quot;: {
											&quot;items&quot;:1
										},
										&quot;480&quot;: {
											&quot;items&quot;:2
										},
										&quot;768&quot;: {
											&quot;items&quot;:3
										},
										&quot;992&quot;: {
											&quot;items&quot;:4
										},
										&quot;1200&quot;: {
											&quot;items&quot;:5,
											&quot;nav&quot;: true
										},
										&quot;1600&quot;: {
											&quot;items&quot;:6,
											&quot;nav&quot;: true
										}
									}
								}">
							
								
							<div class="owl-stage-outer">
								<div class="owl-stage" style="transform: translate3d(0px, 0px, 0px); transition: all 0s ease 0s; width: 1681px;">
								
									@foreach($sets as $item)    
										@include('layouts.home_products')
									@endforeach
							
								</div>
							</div>


								<div class="owl-nav"><button type="button" role="presentation" class="owl-prev disabled"><i class="icon-angle-left"></i></button><button type="button" role="presentation" class="owl-next"><i class="icon-angle-right"></i></button></div>

								<div class="owl-dots d-none"><button role="button" class="owl-dot active"><span></span></button>
									<button role="button" class="owl-dot"><span></span></button>
								</div>
								
								</div><!-- End .owl-carousel -->
						</div><!-- .End .tab-pane -->
						
						<div class="tab-pane p-0 fade" id="collections-tab" role="tabpanel" aria-labelledby="collections-link">
							<div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow owl-loaded owl-drag" data-toggle="owl" data-owl-options="{
									&quot;nav&quot;: false, 
									&quot;dots&quot;: true,
									&quot;margin&quot;: 20,
									&quot;loop&quot;: false,
									&quot;responsive&quot;: {
										&quot;0&quot;: {
											&quot;items&quot;:1
										},
										&quot;480&quot;: {
											&quot;items&quot;:2
										},
										&quot;768&quot;: {
											&quot;items&quot;:3
										},
										&quot;992&quot;: {
											&quot;items&quot;:4
										},
										&quot;1200&quot;: {
											&quot;items&quot;:5,
											&quot;nav&quot;: true
										},
										&quot;1600&quot;: {
											&quot;items&quot;:6,
											&quot;nav&quot;: true
										}
									}
								}">
								 
								
							
								
								
								<div class="owl-stage-outer">
									<div class="owl-stage" style="transform: translate3d(0px, 0px, 0px); transition: all 0s ease 0s; width: 1681px;">
																		
										@foreach($collections as $item)    
											@include('layouts.home_collections')
										@endforeach
								
									</div>
								</div>
								
								<div class="owl-nav"><button type="button" role="presentation" class="owl-prev disabled"><i class="icon-angle-left"></i></button><button type="button" role="presentation" class="owl-next"><i class="icon-angle-right"></i></button></div>
								
								<div class="owl-dots d-none"><button role="button" class="owl-dot active"><span></span></button>
									<button role="button" class="owl-dot"><span></span></button>
								</div>
							
							</div><!-- End .owl-carousel -->
						</div><!-- .End .tab-pane -->


						<div class="tab-pane p-0 fade show active" id="top-selling-tab" role="tabpanel" aria-labelledby="top-selling-link">
							<div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow owl-loaded owl-drag" data-toggle="owl" data-owl-options="{
									&quot;nav&quot;: false, 
									&quot;dots&quot;: true,
									&quot;margin&quot;: 20,
									&quot;loop&quot;: false,
									&quot;responsive&quot;: {
										&quot;0&quot;: {
											&quot;items&quot;:1
										},
										&quot;480&quot;: {
											&quot;items&quot;:2
										},
										&quot;768&quot;: {
											&quot;items&quot;:3
										},
										&quot;992&quot;: {
											&quot;items&quot;:4
										},
										&quot;1200&quot;: {
											&quot;items&quot;:5,
											&quot;nav&quot;: true
										},
										&quot;1600&quot;: {
											&quot;items&quot;:6,
											&quot;nav&quot;: true
										}
									}
								}">
								
								
								<div class="owl-stage-outer">
									<div class="owl-stage" style="transform: translate3d(0px, 0px, 0px); transition: all 0s ease 0s; width: 1681px;">
									
									@foreach($top_selling as $item)    
										@include('layouts.home_products')
									@endforeach
																	
									</div>
								</div>
								 
								<div class="owl-nav"><button type="button" role="presentation" class="owl-prev disabled"><i class="icon-angle-left"></i></button><button type="button" role="presentation" class="owl-next"><i class="icon-angle-right"></i></button></div>
								
								<div class="owl-dots d-none"><button role="button" class="owl-dot active"><span></span></button>
									<button role="button" class="owl-dot"><span></span></button>
								</div>
							
							</div><!-- End .owl-carousel -->
						</div><!-- .End .tab-pane -->
					
						

					</div><!-- End .tab-content -->
				</div><!-- End .bg-lighter -->

				<div class="mb-5"></div><!-- End .mb-5 -->

				<!-- categories data -->
				<div class="home-category">

					@foreach($categories as $category)
					<div class="row cat-banner-row {{$category->name}}">
						<div class="col-xl-2 col-xxl-2">
							<div class="cat-banner row no-gutters">		 				

								<div class="col-sm-12 col-xl-12 col-xxl-12">
									<div class="banner banner-overlay">
										<a href="#">
											@if($category->image != null )
												<img src="{{ URL::asset('storage/app/public/'.$category->image.'') }}" alt="Category img">
											@else
												<img src="{{asset('frontend/images/no-cat-image.webp')}}" width="260px" style="height: 300px!important" alt="Product category">
											@endif   
										</a>

										<div class="banner-content">										
											<a href="{{route('category',$category->slug)}}"><h2 class="title text-center mb-4">{{$category->name}}</h2></a>

											<h3 class="banner-title text-white"><a href="{{route('category',$category->slug)}}">{{count($category->children)}} sub categories</a></h3><!-- End .banner-title -->
											<a href="{{route('category',$category->slug)}}" class="banner-link">Shop Now <i class="icon-long-arrow-right"></i></a>
										</div><!-- End .banner-content -->
									</div><!-- End .banner -->
								</div><!-- End .col-sm-6 -->

							</div><!-- End .cat-banner -->
						</div><!-- End .col-xl-3 -->

						<div class="col-xl-10 col-xxl-10">
							<div class="owl-carousel owl-full carousel-equal-height carousel-with-shadow owl-loaded owl-drag" data-toggle="owl" data-owl-options="{
									&quot;nav&quot;: true, 
									&quot;dots&quot;: false,
									&quot;margin&quot;: 20,
									&quot;loop&quot;: false,
									&quot;responsive&quot;: {
										&quot;0&quot;: {
											&quot;items&quot;:2
										},
										&quot;480&quot;: {
											&quot;items&quot;:3
										},
										&quot;768&quot;: {
											&quot;items&quot;:4
										},
										&quot;992&quot;: {
											&quot;items&quot;:4
										},
										&quot;1200&quot;: {
											&quot;items&quot;:5
										},
										&quot;1600&quot;: {
											&quot;items&quot;:6
										}
									}
								}">
								

							
							<div class="owl-stage-outer">
								<div class="owl-stage" style="transform: translate3d(-3250px, 0px, 0px); transition: all 0.4s ease 0s; width: 4750px;">
																
								@foreach($category->children as $subcat)
									<!-- sub category item-->
									<div class="owl-item" style="width: 230px; margin-right: 20px;"><div class="product text-center">
										<figure class="product-media">
											
											<a href="{{route('category',$subcat->slug)}}">
												@if($subcat->image != null )
													<img src="{{ URL::asset('storage/app/public/'.$subcat->image.'') }}" alt="" class="product-image sub_cat">
												@else
													<img src="{{asset('frontend/images/no-cat-image.webp')}}" class="product-image sub_cat">
												@endif   
											</a>
										</figure>

										<a href="{{route('category',$subcat->slug)}}">	
											<div class="product-body">									
												<h3 class="product-title">{{$subcat->name}}</h3>
												<div class="product-price">
													@php
														$models = \App\Models\Product::where('sub_category_id',$subcat->id)->count();	
													@endphp
													{{-- {{$models}} Models --}}
												</div>
											</div>
										</a>
										</div>
									</div>
									<!-- sub category item end -->		
								@endforeach				
					

														
								</div>
							</div>
							@if(count($category->children) >5 )
								<div class="owl-nav">
									<button type="button" role="presentation" class="owl-prev disabled"><i class="icon-angle-left"></i></button>
									<button type="button" role="presentation" class="owl-next"><i class="icon-angle-right"></i></button>
								</div>
								<div class="owl-dots disabled"></div>
								<div class="owl-nav">
									<button type="button" role="presentation" class="owl-prev">
										<i class="icon-angle-left"></i>
									</button>
									<button type="button" role="presentation" class="owl-next disabled">
										<i class="icon-angle-right"></i>
									</button>
								</div>
							@endif
								<div class="owl-dots disabled"></div></div>								
							
						</div><!-- End .col-xl-9 -->
					</div>

					@endforeach
				</div>
				<!-- end categories data -->
		
<div class="text-center">
	<a href="javascript:void(0)" class="btn btn-primary category-load-more" data-count="5">
		<span>Load More</span><i class="icon-long-arrow-right"></i>
	</a>
</div>

	<div class="mb-5"></div><!-- End .mb-5 -->
 
</main><!-- End .main -->
 
@endsection 

@push('js')
	<script>
		$(document).ready(function(){
			$(document).on('click','.category-load-more',function(){
				var count = $(this).data('count');
				var url = '{{route("load-more-category")}}';
				$.get(url,{
                    count: count,
                },function(response){
					var sub_url = "{{route('category',':cat_id')}}";
					var category_html = '<div class="row cat-banner-row :cat_name"> <div class="col-xl-2 col-xxl-2"> <div class="cat-banner row no-gutters"> <div class="col-sm-12 col-xl-12 col-xxl-12"> <div class="banner banner-overlay"> <a href="#"> <img src=":cat_img" style="height: 300px!important" alt="Category img"> </a> <div class="banner-content"> <a href=":url"><h2 class="title text-center mb-4">:name</h2></a> <h3 class="banner-title text-white"><a href=":url">:children_count sub categories</a></h3><a href=":url" class="banner-link">Shop Now <i class="icon-long-arrow-right"></i></a> </div></div></div></div></div><div class="col-xl-10 col-xxl-10"> <div class="owl-carousel owl-full carousel-equal-height carousel-with-shadow owl-loaded owl-drag" data-toggle="owl" data-owl-options="{\'nav\': true,\'dots\': false,\'margin\': 20,\'loop\': false,\'responsive\':{\'0\':{\'items\':2},\'480\':{\'items\':2},\'768\': {\'items\':3},\'992\':{\'items\':4}}}">:sub_category_card</div> </div></div>';
					var sub_category_card = '<div class="product product-2"><figure class="product-media"> <a href=":sub_cat_url"> <img src=":sub_cat_img" alt="" class="product-image sub_cat"> </a> </figure> <a href=":sub_cat_url"> <div class="product-body"> <h3 class="product-title">:sub_cat_name</h3> <div class="d-none product-price"> :models_count Models </div> </div> </a> </div>';
					var corusel_arrow = '<div class="owl-nav"><button type="button" role="presentation" class="owl-prev disabled"><i class="icon-angle-left"></i></button> <button type="button" role="presentation" class="owl-next"><i class="icon-angle-right"></i></button> </div> <div class="owl-dots disabled"></div> <div class="owl-nav"> <button type="button" role="presentation" class="owl-prev"> <i class="icon-angle-left"></i> </button> <button type="button" role="presentation" class="owl-next disabled"> <i class="icon-angle-right"></i> </button> </div>';
					count = count+5;
					var items =  JSON.parse(response.items);
					var data_status = jQuery.isEmptyObject(items);
                    if(!data_status){
						var all_html = "";
                        var all_cat_html = "";	 					

                        items.forEach(element => {
                        	var all_subcat_html = ""; 
							sub_url = sub_url.replaceAll(':cat_id',element.slug);
							url = url.replaceAll(':cat_id',element.slug);
							if(!jQuery.isEmptyObject(element.children)){
								element.children.forEach(subcat=>{  
 
									var subcat_image = subcat.image;  
									if(subcat.image == null){
										subcat_image = 'images/no-cat-image.webp';
									}
									var sub_cat_url = "{{route('category',':cat_id')}}";
									sub_cat_url = sub_cat_url.replaceAll(':cat_id',subcat.slug);
									all_subcat_html = all_subcat_html + sub_category_card;
									all_subcat_html = all_subcat_html.replaceAll(':sub_cat_url',sub_cat_url);
									all_subcat_html = all_subcat_html.replaceAll(':sub_cat_name',subcat.name);
									all_subcat_html = all_subcat_html.replaceAll(':models_count',count);
									all_subcat_html = all_subcat_html.replaceAll(':sub_cat_img','storage/app/public/'+subcat_image);									
								});
							}
							var element_image = element.image;
							if(element.image == null){ 
								element_image = 'images/no-cat-image.webp';
							}
							all_html = all_html + category_html;
							all_html = all_html.replaceAll(":sub_category_card",all_subcat_html);
							all_html = all_html.replaceAll(":url",sub_url);
							all_html = all_html.replaceAll(":name",element.name);
							all_html = all_html.replaceAll(":cat_img",'storage/app/public/'+element_image);
							all_html = all_html.replaceAll(":children_count",Object.keys(element.children).length);
							if(Object.keys(element.children).length>5){
								all_html = all_html.replaceAll(":corusel_arrow",corusel_arrow);
							}
							else{
								all_html = all_html.replaceAll(":corusel_arrow","");
							}
						});
						$('.home-category').append(all_html);
						$( ".owl-carousel" ).each(function() {
							$(this).owlCarousel({
								"nav": true, 
								"dots": false,
								"margin": 20,
								"loop": false,
								"responsive": {
									"0": {
										"items":2
									},
									"480": {
										"items":3
									},
									"768": {
										"items":4
									},
									"992": {
										"items":6
									}
								}
                                    
							});
						});
						
						if(response.remaining<0){
							$('.category-load-more').css('display','none');
						}else{
							$('.category-load-more').data('count',count);
						}
					}
					else{
						$('.category-load-more').css('display','none');
					}


				});
			});
			
		});
	</script>	
@endpush