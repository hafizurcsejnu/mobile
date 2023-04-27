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
						
						<img src="{{ URL::asset('storage/app/public/'.$item->image.'') }}" style="height: 400px!important" alt="Banner img desc">
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

		

		<span class="slider-loader text-white"></span><!-- End .slider-loader -->
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

				{{-- carosal --}}
				<div class="bg-lighter trending-products">
					<div class="heading heading-flex1" style="padding-top: 10px;">
						{{-- <div class="heading-left">
							<h2 class="title">Trending Today</h2>
						</div> --}}

					  
					   <div class="heading-center">
							<ul class="nav nav-pills justify-content-center" role="tablist">
								<li class="nav-item">
									<a class="nav-link active" id="sets-link" data-toggle="tab" href="#sets-tab" role="tab" aria-controls="sets-tab" aria-selected="true">Sets</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="collections-link" data-toggle="tab" href="#collections-tab" role="tab" aria-controls="collections-tab" aria-selected="false">Collections</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="top-selling-link" data-toggle="tab" href="#top-selling-tab" role="tab" aria-controls="top-selling-tab" aria-selected="false">New Arrivals</a>
								</li>
								
							</ul>
					   </div><!-- End .heading-right -->
					</div><!-- End .heading -->

					<div class="tab-content tab-content-carousel">
						<div class="tab-pane p-0 fade show active" id="sets-tab" role="tabpanel" aria-labelledby="sets-link">
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


						<div class="tab-pane p-0 fade" id="top-selling-tab" role="tabpanel" aria-labelledby="top-selling-link">
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

				{{-- categories --}}
<?php $data = ProductCategory::orderBy('id', 'desc')->where('parent_id', null)->get(); ?>
@foreach($data as $item)  
<?php 
	// skip those categories who has no product.
	$product = Product::orderBy('id', 'desc')
	->where('category_id', $item->id)
	->where('is_set', null)
	->where('active', 'on')
	->get();	  
	$subcat = ProductCategory::orderBy('id', 'desc')
	->where('parent_id', $item->id)
	->get();	  
	$product_count_cat = $product->count();
	if ($product_count_cat==0) {
		continue;
	} 
?>
				<div class="row cat-banner-row electronics">
					<div class="col-xl-2 col-xxl-2">
						<div class="cat-banner row no-gutters">						

							<div class="col-sm-12 col-xl-12 col-xxl-12">
								<div class="banner banner-overlay">
									<a href="#">
										<img src="{{ URL::asset('storage/app/public/'.$item->image.'') }}" style="height: 300px!important" alt="Banner img desc">
									</a>

									<div class="banner-content">										
										<a href="{{URL::to('3dmodels-category')}}/{{$item->id}}"><h2 class="title text-center mb-4">{{$item->name}}</h2></a>

										<h3 class="banner-title text-white"><a href="{{URL::to('3dmodels-category')}}/{{$item->id}}">{{$subcat->count()}} subcategory in this category</a></h3><!-- End .banner-title -->
										<a href="{{URL::to('3dmodels-category')}}/{{$item->id}}" class="banner-link">Shop Now <i class="icon-long-arrow-right"></i></a>
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
										&quot;items&quot;:2
									},
									&quot;768&quot;: {
										&quot;items&quot;:3
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
							<div class="owl-stage" style="transform: translate3d(0px, 0px, 0px); transition: all 0s ease 0s; width: 1245px;">
							<?php 
$data = ProductCategory::orderBy('name', 'asc')
	->where('parent_id', $item->id)
	->get();
$subCategory = $data->count();
?>
@foreach($data as $item)  
<?php 
	// skip those sub categories who has no product and is not a set.
	$product = Product::orderBy('id', 'desc') 
		->where('sub_category_id', $item->id)
		->where('is_set', null)
		->get();	  
	$row_count = $product->count();
	if ($row_count==0) {  
		continue;
	}
?>	
<!-- sub category item-->
							<div class="owl-item active"><div class="product text-center">
								<figure class="product-media">
									{{-- <span class="product-label label-top">Top</span> --}}
									<a href="{{URL::to('3dmodels-category')}}/{{$item->id}}">	
										<img src="{{ URL::asset('storage/app/public/'.$item->image.'') }}" alt="" class="product-image sub_cat">
									</a>
								</figure>

								<a href="{{URL::to('3dmodels-category')}}/{{$item->id}}">	
									<div class="product-body">									
										<h3 class="product-title">{{$item->name}}</h3>
										<div class="product-price">
											{{$row_count}} Models
										</div>
									</div>
								</a>
								</div>
							</div>
<!-- sub category item end -->						
@endforeach

													
							</div>
						</div>

						@if ($subCategory > 4)
							<div class="owl-nav">
								<button type="button" role="presentation" class="owl-prev disabled"><i class="icon-angle-left"></i></button>
								<button type="button" role="presentation" class="owl-next"><i class="icon-angle-right"></i></button>
							</div>
							@endif
						<div class="owl-dots disabled"></div></div>
						
							
							
							
							
						
					</div><!-- End .col-xl-9 -->
				</div>
				<div class="mb-3"></div>
				<!-- End category-->
@endforeach			

				
			</div><!-- End .col-lg-9 col-xxl-10 -->

			<aside class="d-none col-xl-3 col-xxl-2 order-xl-first">
				<div class="sidebar sidebar-home">
					<div class="row">
						<div class="col-sm-6 col-xl-12">
							<div class="widget widget-banner">
								<div class="banner banner-overlay">
									<a href="#">
										<img src="{{asset('frontend/images/demos/demo-14/banners/banner-11.jpg')}}" alt="Banner img desc">
									</a>

									<div class="banner-content banner-content-top banner-content-right text-right">
										<h3 class="banner-title text-white"><a href="#">Maximum Comfort <span>Sofas -20% Off</span></a></h3><!-- End .banner-title -->
										<a href="#" class="banner-link">Shop Now <i class="icon-long-arrow-right"></i></a>
									</div><!-- End .banner-content -->
								</div><!-- End .banner banner-overlay -->
							</div><!-- End .widget widget-banner -->
						</div><!-- End .col-sm-6 col-xl-12 -->

						<div class="col-sm-6 col-xl-12 mb-2">
							<div class="widget widget-products">
								<h4 class="widget-title"><span>Bestsellers</span></h4><!-- End .widget-title -->

								<div class="products">
									<div class="product product-sm">
										<figure class="product-media">
											<a href="product.html">
												<img src="{{asset('frontend/images/demos/demo-14/products/small/product-1.jpg')}}" alt="Product image" class="product-image">
											</a>
										</figure>

										<div class="product-body">
											<h5 class="product-title"><a href="product.html">Sceptre 50" Class FHD (1080P) LED TV</a></h5><!-- End .product-title -->
											<div class="product-price">
												$199.99
											</div><!-- End .product-price -->
										</div><!-- End .product-body -->
									</div><!-- End .product product-sm -->

									<div class="product product-sm">
										<figure class="product-media">
											<a href="product.html">
												<img src="{{asset('frontend/images/demos/demo-14/products/small/product-2.jpg')}}" alt="Product image" class="product-image">
											</a>
										</figure>

										<div class="product-body">
											<h5 class="product-title"><a href="product.html">Red Cookware Set, 9 Piece</a></h5><!-- End .product-title -->
											<div class="product-price">
												$24.95
											</div><!-- End .product-price -->
										</div><!-- End .product-body -->
									</div><!-- End .product product-sm -->

									<div class="product product-sm">
										<figure class="product-media">
											<a href="product.html">
												<img src="{{asset('frontend/images/demos/demo-14/products/small/product-3.jpg')}}" alt="Product image" class="product-image">
											</a>
										</figure>

										<div class="product-body">
											<h5 class="product-title"><a href="product.html">Epson WorkForce WF-2750 All-in-One Wireless</a></h5><!-- End .product-title -->
											<div class="product-price">
												$49.99
											</div><!-- End .product-price -->
										</div><!-- End .product-body -->
									</div><!-- End .product product-sm -->

									<div class="product product-sm">
										<figure class="product-media">
											<a href="product.html">
												<img src="{{asset('frontend/images/demos/demo-14/products/small/product-4.jpg')}}" alt="Product image" class="product-image">
											</a>
										</figure>

										<div class="product-body">
											<h5 class="product-title"><a href="product.html">Stainless Steel Microwave Oven</a></h5><!-- End .product-title -->
											<div class="product-price">
												$64.84
											</div><!-- End .product-price -->
										</div><!-- End .product-body -->
									</div><!-- End .product product-sm -->

									<div class="product product-sm">
										<figure class="product-media">
											<a href="product.html">
												<img src="{{asset('frontend/images/demos/demo-14/products/small/product-5.jpg')}}" alt="Product image" class="product-image">
											</a>
										</figure>

										<div class="product-body">
											<h5 class="product-title"><a href="product.html">Fatboy Original Beanbag</a></h5><!-- End .product-title -->
											<div class="product-price">
												$49.99
											</div><!-- End .product-price -->
										</div><!-- End .product-body -->
									</div><!-- End .product product-sm -->
								</div><!-- End .products -->
							</div><!-- End .widget widget-products -->
						</div><!-- End .col-sm-6 col-xl-12 -->
						
						<div class="col-12">
							<div class="widget widget-deals">
								<h4 class="widget-title"><span>Special Offer</span></h4><!-- End .widget-title -->

								<div class="row">
									<div class="col-sm-6 col-xl-12">
										<div class="product text-center">
											<figure class="product-media">
												<span class="product-label label-sale">Deal of the week</span>
												<a href="product.html">
													<img src="{{asset('frontend/images/demos/demo-14/products/deals/product-1.jpg')}}" alt="Product image" class="product-image">
												</a>

												<div class="product-action-vertical">
													<a href="#" class="btn-product-icon btn-wishlist" title="Add to wishlist"><span>add to wishlist</span></a>
													<a href="popup/quickView.html" class="btn-product-icon btn-quickview" title="Quick view"><span>Quick view</span></a>
													<a href="#" class="btn-product-icon btn-compare" title="Compare"><span>Compare</span></a>
												</div><!-- End .product-action-vertical -->

												<div class="product-action">
													<a href="#" class="btn-product btn-cart" title="Add to cart"><span>add to cart</span></a>
												</div><!-- End .product-action -->
											</figure><!-- End .product-media -->

											<div class="product-body">
												<div class="product-cat">
													<a href="#">Audio</a>
												</div><!-- End .product-cat -->
												<h3 class="product-title"><a href="product.html">Bose SoundLink Micro speaker</a></h3><!-- End .product-title -->
												<div class="product-price">
													<span class="new-price">$99.99</span>
													<span class="old-price">Was $110.99</span>
												</div><!-- End .product-price -->
												<div class="ratings-container">
													<div class="ratings">
														<div class="ratings-val" style="width: 100%;"></div><!-- End .ratings-val -->
													</div><!-- End .ratings -->
													<span class="ratings-text">( 4 Reviews )</span>
												</div><!-- End .rating-container -->

												<div class="product-nav product-nav-dots">
													<a href="#" class="active" style="background: #f3815f;"><span class="sr-only">Color name</span></a>
													<a href="#" style="background: #333333;"><span class="sr-only">Color name</span></a>
												</div><!-- End .product-nav -->
											</div><!-- End .product-body -->

											<div class="product-countdown is-countdown" data-until="+44h" data-relative="true" data-labels-short="true"><span class="countdown-row countdown-show4"><span class="countdown-section"><span class="countdown-amount">01</span><span class="countdown-period">Day</span></span><span class="countdown-section"><span class="countdown-amount">19</span><span class="countdown-period">Hours</span></span><span class="countdown-section"><span class="countdown-amount">58</span><span class="countdown-period">Mins</span></span><span class="countdown-section"><span class="countdown-amount">41</span><span class="countdown-period">Secs</span></span></span></div><!-- End .product-countdown -->
										</div><!-- End .product -->
									</div><!-- End .col-sm-6 col-xl-12 -->

									<div class="col-sm-6 col-xl-12">
										<div class="product text-center">
											<figure class="product-media">
												<span class="product-label label-sale">Deal of the week</span>
												<a href="product.html">
													<img src="{{asset('frontend/images/demos/demo-14/products/deals/product-2.jpg')}}" alt="Product image" class="product-image">
												</a>

												<div class="product-action-vertical">
													<a href="#" class="btn-product-icon btn-wishlist" title="Add to wishlist"><span>add to wishlist</span></a>
													<a href="popup/quickView.html" class="btn-product-icon btn-quickview" title="Quick view"><span>Quick view</span></a>
													<a href="#" class="btn-product-icon btn-compare" title="Compare"><span>Compare</span></a>
												</div><!-- End .product-action-vertical -->

												<div class="product-action">
													<a href="#" class="btn-product btn-cart" title="Add to cart"><span>add to cart</span></a>
												</div><!-- End .product-action -->
											</figure><!-- End .product-media -->

											<div class="product-body">
												<div class="product-cat">
													<a href="#">Cameras</a>
												</div><!-- End .product-cat -->
												<h3 class="product-title"><a href="product.html">GoPro HERO Session Waterproof HD Action Camera</a></h3><!-- End .product-title -->
												<div class="product-price">
													<span class="new-price">$196.99</span>
													<span class="old-price">Was $210.99</span>
												</div><!-- End .product-price -->
												<div class="ratings-container">
													<div class="ratings">
														<div class="ratings-val" style="width: 100%;"></div><!-- End .ratings-val -->
													</div><!-- End .ratings -->
													<span class="ratings-text">( 19 Reviews )</span>
												</div><!-- End .rating-container -->
											</div><!-- End .product-body -->

											<div class="product-countdown is-countdown" data-until="+52h" data-relative="true" data-labels-short="true"><span class="countdown-row countdown-show4"><span class="countdown-section"><span class="countdown-amount">02</span><span class="countdown-period">Days</span></span><span class="countdown-section"><span class="countdown-amount">03</span><span class="countdown-period">Hours</span></span><span class="countdown-section"><span class="countdown-amount">58</span><span class="countdown-period">Mins</span></span><span class="countdown-section"><span class="countdown-amount">41</span><span class="countdown-period">Secs</span></span></span></div><!-- End .product-countdown -->
										</div><!-- End .product -->
									</div><!-- End .col-sm-6 col-xl-12 -->
								</div><!-- End .row -->
							</div><!-- End .widget widget-deals -->
						</div><!-- End .col-sm-6 col-lg-xl -->
						
						<div class="col-sm-6 col-xl-12">
							<div class="widget widget-banner">
								<div class="banner banner-overlay">
									<a href="#">
										<img src="{{asset('frontend/images/demos/demo-14/banners/banner-12.jpg')}}" alt="Banner img desc">
									</a>

									<div class="banner-content banner-content-top">
										<h3 class="banner-title text-white"><a href="#">Take Better Photos <br><span>With</span> Canon EOS <br><span>Up To 20% Off</span></a></h3><!-- End .banner-title -->
										<a href="#" class="banner-link">Shop Now <i class="icon-long-arrow-right"></i></a>
									</div><!-- End .banner-content -->
								</div><!-- End .banner banner-overlay -->
							</div><!-- End .widget widget-banner -->
						</div><!-- End .col-sm-6 col-lg-12 -->
						
						<div class="col-sm-6 col-xl-12">
							<div class="widget widget-posts">
								<h4 class="widget-title"><span>Latest Blog Posts</span></h4><!-- End .widget-title -->

								<div class="owl-carousel owl-simple owl-loaded owl-drag" data-toggle="owl" data-owl-options="{
										&quot;nav&quot;:false, 
										&quot;dots&quot;: true, 
										&quot;loop&quot;: false,
										&quot;autoHeight&quot;: true
									}">
									<!-- End .entry -->

									<!-- End .entry -->

									<!-- End .entry -->
								<div class="owl-stage-outer owl-height" style="height: 330.961px;"><div class="owl-stage" style="transform: translate3d(0px, 0px, 0px); transition: all 0s ease 0s; width: 841px;"><div class="owl-item active" style="width: 280.031px;"><article class="entry">
										<figure class="entry-media">
											<a href="single.html">
												<img src="{{asset('frontend/images/demos/demo-14/blog/post-1.jpg')}}" alt="image desc">
											</a>
										</figure><!-- End .entry-media -->

										<div class="entry-body">
											<div class="entry-meta">
												<a href="#">Nov 22, 2018</a>, 0 Comments
											</div><!-- End .entry-meta -->

											<h5 class="entry-title">
												<a href="single.html">Sed adipiscing ornare.</a>
											</h5><!-- End .entry-title -->

											<div class="entry-content">
												<p>Lorem ipsum dolor consectetuer adipiscing elit. Phasellus hendrerit. Pelletesque aliquet nibh ...</p>
												<a href="single.html" class="read-more">Read More</a>
											</div><!-- End .entry-content -->
										</div><!-- End .entry-body -->
									</article></div><div class="owl-item" style="width: 280.031px;"><article class="entry">
										<figure class="entry-media">
											<a href="single.html">
												<img src="{{asset('frontend/images/demos/demo-14/blog/post-2.jpg')}}" alt="image desc">
											</a>
										</figure><!-- End .entry-media -->

										<div class="entry-body">
											<div class="entry-meta">
												<a href="#">Nov 22, 2018</a>, 0 Comments
											</div><!-- End .entry-meta -->

											<h5 class="entry-title">
												<a href="single.html">Vivamus vestibulum ntulla.</a>
											</h5><!-- End .entry-title -->

											<div class="entry-content">
												<p>Phasellus hendrerit. Pelletesque aliquet nibh necurna In nisi neque, aliquet vel, dapibus id ... </p>
												<a href="single.html" class="read-more">Read More</a>
											</div><!-- End .entry-content -->
										</div><!-- End .entry-body -->
									</article></div><div class="owl-item" style="width: 280.031px;"><article class="entry">
										<figure class="entry-media">
											<a href="single.html">
												<img src="{{asset('frontend/images/demos/demo-14/blog/post-3.jpg')}}" alt="image desc">
											</a>
										</figure><!-- End .entry-media -->

										<div class="entry-body">
											<div class="entry-meta">
												<a href="#">Nov 22, 2018</a>, 0 Comments
											</div><!-- End .entry-meta -->

											<h5 class="entry-title">
												<a href="single.html">Praesent placerat risus.</a>
											</h5><!-- End .entry-title -->

											<div class="entry-content">
												<p>Sed pretium, ligula sollicitudin laoreet viverra, tortor libero sodales leo, eget blandit nunc ...</p>
												<a href="single.html" class="read-more">Read More</a>
											</div><!-- End .entry-content -->
										</div><!-- End .entry-body -->
									</article></div></div></div>
									
									<div class="owl-nav disabled"><button type="button" role="presentation" class="owl-prev"><i class="icon-angle-left"></i></button><button type="button" role="presentation" class="owl-next"><i class="icon-angle-right"></i></button></div><div class="owl-dots"><button role="button" class="owl-dot active"><span></span></button><button role="button" class="owl-dot"><span></span></button><button role="button" class="owl-dot"><span></span></button></div></div><!-- End .owl-carousel -->
							</div><!-- End .widget widget-posts -->
						</div><!-- End .col-sm-6 col-xl-12 -->
					</div><!-- End .row -->
				</div><!-- End .sidebar sidebar-home -->
			</aside><!-- End .col-lg-3 col-xxl-2 -->
		</div><!-- End .row -->
	</div>

	<div class="mb-3"></div><!-- End .mb-6 -->            

	{{-- sets and collections --}}
	<div class="d-none container">
		<div class="row">
			<div class="col-2">
			<a href="{{URL::to('sets')}}"><h3 style="float: left!important;" class="set">Sets</h3></a>	
			</div>
			<div class="col-8"></div>
			<div class="col-2">
				<a href="{{URL::to('all-collections')}}"><h3 style="float: right!important;" class="collecton">Collections</h3></a>
			</div>
		   
		   
		</div>
		<div class="row">
			<div class="col-5">
				
				<div class="row">
					<?php $data = Product::orderBy('id', 'desc')->where('is_set', 'on')->limit(3)->get(); ?>
					@foreach($data as $item)  
					<div class="col-md-4">
						<a href="{{URL::to('product')}}/{{$item->id}}">
							<div class="set_div">	
								<?php if($images = $item->images) {
								$images = explode('|', $images);
								?>             
									<img src="{{asset('images')}}/{{$images[0]}}" alt="" height="100%" width="100%">
								<?php }?>
							</div>
						</a>
					</div>
					@endforeach				
				</div>
			</div>

			<div class="col-2">
				<img src="{{asset('frontend/images/scroll.jpg')}}" class="scroll" alt="">
			</div>
			<div class="col-5">
			   
				<div class="row">                           
					<?php $data = Collection::orderBy('id', 'desc')->where('active', 'on')->limit(3)->get(); ?>
					@foreach($data as $item)  
					<div class="col-md-4">
						<a href="{{URL::to('collection')}}/{{$item->id}}">
							<div class="set_div">
								<?php if($images = $item->images) {
									$images = explode('|', $images);
									?>             
										<img src="{{asset('images/collection')}}/{{$images[0]}}" alt="" height="100%" width="100%">
									<?php }?>
							</div>
						</a>
					</div>
					@endforeach
				</div>
			</div>
		</div>
	</div>
	
<?php $data = ProductCategory::orderBy('id', 'desc')->where('parent_id', null)->get(); ?>
@foreach($data as $item)  
<?php 
	// skip those categories who has no product.
	$product = Product::orderBy('id', 'desc')
	->where('category_id', $item->id)
	->where('is_set', null)
	->get();	  
	$row_count = $product->count();
	if ($row_count==0) {
		continue; 
	} 
?>
	<div class="d-none container">
	<a href="{{URL::to('3dmodels-category')}}/{{$item->id}}"><h2 class="title text-center mb-4">{{$item->name}}</h2></a>	
		
		<div class="cat-blocks-container">
			<div class="row">

<?php 
$data = ProductCategory::orderBy('name', 'asc')
	->where('parent_id', $item->id)
	->get();
?>
@foreach($data as $item)  
<?php 
	// skip those sub categories who has no product and is not a set.
	$product = Product::orderBy('id', 'desc') 
		->where('sub_category_id', $item->id)
		->where('is_set', null)
		->get();	  
	$row_count = $product->count();
	if ($row_count==0) {  
		continue;
	}
?>
<div class="col-md-6 col-sm-6 col-xs-6 col-lg-2">
	<a href="{{URL::to('3dmodels-category')}}/{{$item->id}}" class="cat-block">
		<figure>
			<span>				
				<img src="{{ URL::asset('storage/app/public/'.$item->image.'') }}" alt="" height="40px" width="60px;">
			</span>
		</figure>

		<h3 class="cat-block-title">{{$item->name}}</h3><!-- End .cat-block-title -->
	</a>
</div><!-- End .col-sm-6 col-lg-2 -->
@endforeach

			</div><!-- End .row -->
		</div><!-- End .cat-blocks-container -->
	</div>
@endforeach

		
<div class="d-none text-center">
	<a href="#" class="btn btn-primary">
		<span>Load More</span><i class="icon-long-arrow-right"></i>
	</a>
</div>

	<div class="mb-5"></div><!-- End .mb-5 -->

	<div class="container d-none">
		<div class="heading heading-center mb-3">
			<h2 class="title">Top Selling Products</h2><!-- End .title -->

			<ul class="nav nav-pills nav-border-anim justify-content-center" role="tablist">
				<li class="nav-item">
					<a class="nav-link active" id="top-all-link" data-toggle="tab" href="#top-all-tab" role="tab" aria-controls="top-all-tab" aria-selected="true">All</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="top-fur-link" data-toggle="tab" href="#top-fur-tab" role="tab" aria-controls="top-fur-tab" aria-selected="false">Furniture</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="top-decor-link" data-toggle="tab" href="#top-decor-tab" role="tab" aria-controls="top-decor-tab" aria-selected="false">Decoration</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="top-light-link" data-toggle="tab" href="#top-light-tab" role="tab" aria-controls="top-light-tab" aria-selected="false">Lighting</a>
				</li>
			</ul>
		</div><!-- End .heading -->

		<div class="tab-content">
			<div class="tab-pane p-0 fade show active" id="top-all-tab" role="tabpanel" aria-labelledby="top-all-link">
				<div class="products">
					<div class="row justify-content-center">
						<div class="col-6 col-md-4 col-lg-3 col-xl-5col">
							<div class="product product-11 text-center">
								<figure class="product-media">
									<a href="#">
										<img src="{{asset('frontend/images/demos/demo-2/products/product-7-1.jpg')}}" alt="Product image" class="product-image">
										<img src="{{asset('frontend/images/demos/demo-2/products/product-7-2.jpg')}}" alt="Product image" class="product-image-hover">
									</a>

									<div class="product-action-vertical">
										<a href="#" class="btn-product-icon btn-wishlist "><span>add to wishlist</span></a>
									</div><!-- End .product-action-vertical -->
								</figure><!-- End .product-media -->

								<div class="product-body">
									<div class="product-cat">
										<a href="#">Lighting</a>
									</div><!-- End .product-cat -->
									<h3 class="product-title"><a href="#">Petite Table Lamp</a></h3><!-- End .product-title -->
									<div class="product-price">
										$401,00
									</div><!-- End .product-price -->
								</div><!-- End .product-body -->
								<div class="product-action">
									<a href="#" class="btn-product btn-cart"><span>add to cart</span></a>
								</div><!-- End .product-action -->
							</div><!-- End .product -->
						</div><!-- End .col-sm-6 col-md-4 col-lg-3 -->

						<div class="col-6 col-md-4 col-lg-3 col-xl-5col">
							<div class="product product-11 text-center">
								<figure class="product-media">
									<a href="#">
										<img src="{{asset('frontend/images/demos/demo-2/products/product-8-1.jpg')}}" alt="Product image" class="product-image">
										<img src="{{asset('frontend/images/demos/demo-2/products/product-8-2.jpg')}}" alt="Product image" class="product-image-hover">
									</a>

									<div class="product-action-vertical">
										<a href="#" class="btn-product-icon btn-wishlist "><span>add to wishlist</span></a>
									</div><!-- End .product-action-vertical -->
								</figure><!-- End .product-media -->

								<div class="product-body">
									<div class="product-cat">
										<a href="#">Decor</a>
									</div><!-- End .product-cat -->
									<h3 class="product-title"><a href="#">Madra Log Holder</a></h3><!-- End .product-title -->
									<div class="product-price">
										$401,00
									</div><!-- End .product-price -->

									<div class="product-nav product-nav-dots">
										<a href="#" class="active" style="background: #333333;"><span class="sr-only">Color name</span></a>
										<a href="#" style="background: #927764;"><span class="sr-only">Color name</span></a>
									</div><!-- End .product-nav -->

								</div><!-- End .product-body -->
								<div class="product-action">
									<a href="#" class="btn-product btn-cart"><span>add to cart</span></a>
								</div><!-- End .product-action -->
							</div><!-- End .product -->
						</div><!-- End .col-sm-6 col-md-4 col-lg-3 -->

						<div class="col-6 col-md-4 col-lg-3 col-xl-5col">
							<div class="product product-11 text-center">
								<figure class="product-media">
									<span class="product-label label-circle label-sale">Sale</span>
									<a href="#">
										<img src="{{asset('frontend/images/demos/demo-2/products/product-9-1.jpg')}}" alt="Product image" class="product-image">
										<img src="{{asset('frontend/images/demos/demo-2/products/product-9-2.jpg')}}" alt="Product image" class="product-image-hover">
									</a>

									<div class="product-action-vertical">
										<a href="#" class="btn-product-icon btn-wishlist "><span>add to wishlist</span></a>
									</div><!-- End .product-action-vertical -->
								</figure><!-- End .product-media -->

								<div class="product-body">
									<div class="product-cat">
										<a href="#">Furniture</a>
									</div><!-- End .product-cat -->
									<h3 class="product-title"><a href="#">Garden Armchair</a></h3><!-- End .product-title -->
									<div class="product-price">
										<span class="new-price">$94,00</span>
										<span class="old-price">Was $94,00</span>
									</div><!-- End .product-price -->
								</div><!-- End .product-body -->
								<div class="product-action">
									<a href="#" class="btn-product btn-cart"><span>add to cart</span></a>
								</div><!-- End .product-action -->
							</div><!-- End .product -->
						</div><!-- End .col-sm-6 col-md-4 col-lg-3 -->

						<div class="col-6 col-md-4 col-lg-3 col-xl-5col">
							<div class="product product-11 text-center">
								<figure class="product-media">
									<a href="#">
										<img src="{{asset('frontend/images/demos/demo-2/products/product-10-1.jpg')}}" alt="Product image" class="product-image">
										<img src="{{asset('frontend/images/demos/demo-2/products/product-10-2.jpg')}}" alt="Product image" class="product-image-hover">
									</a>

									<div class="product-action-vertical">
										<a href="#" class="btn-product-icon btn-wishlist "><span>add to wishlist</span></a>
									</div><!-- End .product-action-vertical -->
								</figure><!-- End .product-media -->

								<div class="product-body">
									<div class="product-cat">
										<a href="#">Lighting</a>
									</div><!-- End .product-cat -->
									<h3 class="product-title"><a href="#">Carronade Large Suspension Lamp</a></h3><!-- End .product-title -->
									<div class="product-price">
										$401,00
									</div><!-- End .product-price -->

									<div class="product-nav product-nav-dots">
										<a href="#" class="active" style="background: #e8e8e8;"><span class="sr-only">Color name</span></a>
										<a href="#" style="background: #333333;"><span class="sr-only">Color name</span></a>
									</div><!-- End .product-nav -->

								</div><!-- End .product-body -->
								<div class="product-action">
									<a href="#" class="btn-product btn-cart"><span>add to cart</span></a>
								</div><!-- End .product-action -->
							</div><!-- End .product -->
						</div><!-- End .col-sm-6 col-md-4 col-lg-3 -->

						<div class="col-6 col-md-4 col-lg-3 col-xl-5col">
							<div class="product product-11 text-center">
								<figure class="product-media">
									<a href="#">
										<img src="{{asset('frontend/images/demos/demo-2/products/product-11-1.jpg')}}" alt="Product image" class="product-image">
										<img src="{{asset('frontend/images/demos/demo-2/products/product-11-2.jpg')}}" alt="Product image" class="product-image-hover">
									</a>

									<div class="product-action-vertical">
										<a href="#" class="btn-product-icon btn-wishlist "><span>add to wishlist</span></a>
									</div><!-- End .product-action-vertical -->
								</figure><!-- End .product-media -->

								<div class="product-body">
									<div class="product-cat">
										<a href="#">Decor</a>
									</div><!-- End .product-cat -->
									<h3 class="product-title"><a href="#">Original Outdoor Beanbag</a></h3><!-- End .product-title -->
									<div class="product-price">
										$259,00
									</div><!-- End .product-price -->
								</div><!-- End .product-body -->
								<div class="product-action">
									<a href="#" class="btn-product btn-cart"><span>add to cart</span></a>
								</div><!-- End .product-action -->
							</div><!-- End .product -->
						</div><!-- End .col-sm-6 col-md-4 col-lg-3 -->

						<div class="col-6 col-md-4 col-lg-3 col-xl-5col">
							<div class="product product-11 text-center">
								<figure class="product-media">
									<span class="product-label label-circle label-new">New</span>
									<a href="#">
										<img src="{{asset('frontend/images/demos/demo-2/products/product-12-1.jpg')}}" alt="Product image" class="product-image">
										<img src="{{asset('frontend/images/demos/demo-2/products/product-12-2.jpg')}}" alt="Product image" class="product-image-hover">
									</a>

									<div class="product-action-vertical">
										<a href="#" class="btn-product-icon btn-wishlist "><span>add to wishlist</span></a>
									</div><!-- End .product-action-vertical -->
								</figure><!-- End .product-media -->

								<div class="product-body">
									<div class="product-cat">
										<a href="#">Furniture</a>
									</div><!-- End .product-cat -->
									<h3 class="product-title"><a href="#">2-Seater</a></h3><!-- End .product-title -->
									<div class="product-price">
										$3.107,00
									</div><!-- End .product-price -->
								</div><!-- End .product-body -->
								<div class="product-action">
									<a href="#" class="btn-product btn-cart"><span>add to cart</span></a>
								</div><!-- End .product-action -->
							</div><!-- End .product -->
						</div><!-- End .col-sm-6 col-md-4 col-lg-3 -->

						<div class="col-6 col-md-4 col-lg-3 col-xl-5col">
							<div class="product product-11 text-center">
								<figure class="product-media">
									<a href="#">
										<img src="{{asset('frontend/images/demos/demo-2/products/product-13-1.jpg')}}" alt="Product image" class="product-image">
										<img src="{{asset('frontend/images/demos/demo-2/products/product-13-2.jpg')}}" alt="Product image" class="product-image-hover">
									</a>

									<div class="product-action-vertical">
										<a href="#" class="btn-product-icon btn-wishlist "><span>add to wishlist</span></a>
									</div><!-- End .product-action-vertical -->
								</figure><!-- End .product-media -->

								<div class="product-body">
									<div class="product-cat">
										<a href="#">Furniture</a>
									</div><!-- End .product-cat -->
									<h3 class="product-title"><a href="#">Wingback Chair</a></h3><!-- End .product-title -->
									<div class="product-price">
										$2.486,00
									</div><!-- End .product-price -->
								</div><!-- End .product-body -->
								<div class="product-action">
									<a href="#" class="btn-product btn-cart"><span>add to cart</span></a>
								</div><!-- End .product-action -->
							</div><!-- End .product -->
						</div><!-- End .col-sm-6 col-md-4 col-lg-3 -->

						<div class="col-6 col-md-4 col-lg-3 col-xl-5col">
							<div class="product product-11 text-center">
								<figure class="product-media">
									<a href="#">
										<img src="{{asset('frontend/images/demos/demo-2/products/product-14-1.jpg')}}" alt="Product image" class="product-image">
										<img src="{{asset('frontend/images/demos/demo-2/products/product-14-2.jpg')}}" alt="Product image" class="product-image-hover">
									</a>

									<div class="product-action-vertical">
										<a href="#" class="btn-product-icon btn-wishlist "><span>add to wishlist</span></a>
									</div><!-- End .product-action-vertical -->
								</figure><!-- End .product-media -->

								<div class="product-body">
									<div class="product-cat">
										<a href="#">Decor</a>
									</div><!-- End .product-cat -->
									<h3 class="product-title"><a href="#">Cushion Set 3 Pieces</a></h3><!-- End .product-title -->
									<div class="product-price">
										$199,00
									</div><!-- End .product-price -->
								</div><!-- End .product-body -->
								<div class="product-action">
									<a href="#" class="btn-product btn-cart"><span>add to cart</span></a>
								</div><!-- End .product-action -->
							</div><!-- End .product -->
						</div><!-- End .col-sm-6 col-md-4 col-lg-3 -->

						<div class="col-6 col-md-4 col-lg-3 col-xl-5col">
							<div class="product product-11 text-center">
								<figure class="product-media">
									<a href="#">
										<img src="{{asset('frontend/images/demos/demo-2/products/product-15-1.jpg')}}" alt="Product image" class="product-image">
										<img src="{{asset('frontend/images/demos/demo-2/products/product-15-2.jpg')}}" alt="Product image" class="product-image-hover">
									</a>

									<div class="product-action-vertical">
										<a href="#" class="btn-product-icon btn-wishlist "><span>add to wishlist</span></a>
									</div><!-- End .product-action-vertical -->
								</figure><!-- End .product-media -->

								<div class="product-body">
									<div class="product-cat">
										<a href="#">Decor</a>
									</div><!-- End .product-cat -->
									<h3 class="product-title"><a href="#">Cushion Set 3 Pieces</a></h3><!-- End .product-title -->
									<div class="product-price">
										$199,00
									</div><!-- End .product-price -->
								</div><!-- End .product-body -->
								<div class="product-action">
									<a href="#" class="btn-product btn-cart"><span>add to cart</span></a>
								</div><!-- End .product-action -->
							</div><!-- End .product -->
						</div><!-- End .col-sm-6 col-md-4 col-lg-3 -->

						<div class="col-6 col-md-4 col-lg-3 col-xl-5col">
							<div class="product product-11 text-center">
								<figure class="product-media">
									<a href="#">
										<img src="{{asset('frontend/images/demos/demo-2/products/product-16-1.jpg')}}" alt="Product image" class="product-image">
										<img src="{{asset('frontend/images/demos/demo-2/products/product-16-2.jpg')}}" alt="Product image" class="product-image-hover">
									</a>

									<div class="product-action-vertical">
										<a href="#" class="btn-product-icon btn-wishlist "><span>add to wishlist</span></a>
									</div><!-- End .product-action-vertical -->
								</figure><!-- End .product-media -->

								<div class="product-body">
									<div class="product-cat">
										<a href="#">Lighting</a>
									</div><!-- End .product-cat -->
									<h3 class="product-title"><a href="#">Carronade Table Lamp</a></h3><!-- End .product-title -->
									<div class="product-price">
										$499,00
									</div><!-- End .product-price -->
								</div><!-- End .product-body -->
								<div class="product-action">
									<a href="#" class="btn-product btn-cart"><span>add to cart</span></a>
								</div><!-- End .product-action -->
							</div><!-- End .product -->
						</div><!-- End .col-sm-6 col-md-4 col-lg-3 -->
					</div><!-- End .row -->
				</div><!-- End .products -->
			</div><!-- .End .tab-pane -->
			<div class="tab-pane p-0 fade" id="top-fur-tab" role="tabpanel" aria-labelledby="top-fur-link">
				<div class="products">
					<div class="row justify-content-center">
						<div class="col-6 col-md-4 col-lg-3 col-xl-5col">
							<div class="product product-11 text-center">
								<figure class="product-media">
									<span class="product-label label-circle label-sale">Sale</span>
									<a href="#">
										<img src="{{asset('frontend/images/demos/demo-2/products/product-9-1.jpg')}}" alt="Product image" class="product-image">
										<img src="{{asset('frontend/images/demos/demo-2/products/product-9-2.jpg')}}" alt="Product image" class="product-image-hover">
									</a>

									<div class="product-action-vertical">
										<a href="#" class="btn-product-icon btn-wishlist "><span>add to wishlist</span></a>
									</div><!-- End .product-action-vertical -->
								</figure><!-- End .product-media -->

								<div class="product-body">
									<div class="product-cat">
										<a href="#">Furniture</a>
									</div><!-- End .product-cat -->
									<h3 class="product-title"><a href="#">Garden Armchair</a></h3><!-- End .product-title -->
									<div class="product-price">
										<span class="new-price">$94,00</span>
										<span class="old-price">Was $94,00</span>
									</div><!-- End .product-price -->
								</div><!-- End .product-body -->
								<div class="product-action">
									<a href="#" class="btn-product btn-cart"><span>add to cart</span></a>
								</div><!-- End .product-action -->
							</div><!-- End .product -->
						</div><!-- End .col-sm-6 col-md-4 col-lg-3 -->

						<div class="col-6 col-md-4 col-lg-3 col-xl-5col">
							<div class="product product-11 text-center">
								<figure class="product-media">
									<span class="product-label label-circle label-new">New</span>
									<a href="#">
										<img src="{{asset('frontend/images/demos/demo-2/products/product-12-1.jpg')}}" alt="Product image" class="product-image">
										<img src="{{asset('frontend/images/demos/demo-2/products/product-12-2.jpg')}}" alt="Product image" class="product-image-hover">
									</a>

									<div class="product-action-vertical">
										<a href="#" class="btn-product-icon btn-wishlist "><span>add to wishlist</span></a>
									</div><!-- End .product-action-vertical -->
								</figure><!-- End .product-media -->

								<div class="product-body">
									<div class="product-cat">
										<a href="#">Furniture</a>
									</div><!-- End .product-cat -->
									<h3 class="product-title"><a href="#">2-Seater</a></h3><!-- End .product-title -->
									<div class="product-price">
										$3.107,00
									</div><!-- End .product-price -->
								</div><!-- End .product-body -->
								<div class="product-action">
									<a href="#" class="btn-product btn-cart"><span>add to cart</span></a>
								</div><!-- End .product-action -->
							</div><!-- End .product -->
						</div><!-- End .col-sm-6 col-md-4 col-lg-3 -->
						
						<div class="col-6 col-md-4 col-lg-3 col-xl-5col">
							<div class="product product-11 text-center">
								<figure class="product-media">
									<a href="#">
										<img src="{{asset('frontend/images/demos/demo-2/products/product-13-1.jpg')}}" alt="Product image" class="product-image">
										<img src="{{asset('frontend/images/demos/demo-2/products/product-13-2.jpg')}}" alt="Product image" class="product-image-hover">
									</a>

									<div class="product-action-vertical">
										<a href="#" class="btn-product-icon btn-wishlist "><span>add to wishlist</span></a>
									</div><!-- End .product-action-vertical -->
								</figure><!-- End .product-media -->

								<div class="product-body">
									<div class="product-cat">
										<a href="#">Furniture</a>
									</div><!-- End .product-cat -->
									<h3 class="product-title"><a href="#">Wingback Chair</a></h3><!-- End .product-title -->
									<div class="product-price">
										$2.486,00
									</div><!-- End .product-price -->
								</div><!-- End .product-body -->
								<div class="product-action">
									<a href="#" class="btn-product btn-cart"><span>add to cart</span></a>
								</div><!-- End .product-action -->
							</div><!-- End .product -->
						</div><!-- End .col-sm-6 col-md-4 col-lg-3 -->
					</div><!-- End .row -->
				</div><!-- End .products -->
			</div><!-- .End .tab-pane -->
			<div class="tab-pane p-0 fade" id="top-decor-tab" role="tabpanel" aria-labelledby="top-decor-link">
				<div class="products">
					<div class="row justify-content-center">
						<div class="col-6 col-md-4 col-lg-3 col-xl-5col">
							<div class="product product-11 text-center">
								<figure class="product-media">
									<a href="#">
										<img src="{{asset('frontend/images/demos/demo-2/products/product-8-1.jpg')}}" alt="Product image" class="product-image">
										<img src="{{asset('frontend/images/demos/demo-2/products/product-8-2.jpg')}}" alt="Product image" class="product-image-hover">
									</a>

									<div class="product-action-vertical">
										<a href="#" class="btn-product-icon btn-wishlist "><span>add to wishlist</span></a>
									</div><!-- End .product-action-vertical -->
								</figure><!-- End .product-media -->

								<div class="product-body">
									<div class="product-cat">
										<a href="#">Decor</a>
									</div><!-- End .product-cat -->
									<h3 class="product-title"><a href="#">Madra Log Holder</a></h3><!-- End .product-title -->
									<div class="product-price">
										$401,00
									</div><!-- End .product-price -->

									<div class="product-nav product-nav-dots">
										<a href="#" class="active" style="background: #333333;"><span class="sr-only">Color name</span></a>
										<a href="#" style="background: #927764;"><span class="sr-only">Color name</span></a>
									</div><!-- End .product-nav -->

								</div><!-- End .product-body -->
								<div class="product-action">
									<a href="#" class="btn-product btn-cart"><span>add to cart</span></a>
								</div><!-- End .product-action -->
							</div><!-- End .product -->
						</div><!-- End .col-sm-6 col-md-4 col-lg-3 -->

						<div class="col-6 col-md-4 col-lg-3 col-xl-5col">
							<div class="product product-11 text-center">
								<figure class="product-media">
									<a href="#">
										<img src="{{asset('frontend/images/demos/demo-2/products/product-11-1.jpg')}}" alt="Product image" class="product-image">
										<img src="{{asset('frontend/images/demos/demo-2/products/product-11-2.jpg')}}" alt="Product image" class="product-image-hover">
									</a>

									<div class="product-action-vertical">
										<a href="#" class="btn-product-icon btn-wishlist "><span>add to wishlist</span></a>
									</div><!-- End .product-action-vertical -->
								</figure><!-- End .product-media -->

								<div class="product-body">
									<div class="product-cat">
										<a href="#">Decor</a>
									</div><!-- End .product-cat -->
									<h3 class="product-title"><a href="#">Original Outdoor Beanbag</a></h3><!-- End .product-title -->
									<div class="product-price">
										$259,00
									</div><!-- End .product-price -->
								</div><!-- End .product-body -->
								<div class="product-action">
									<a href="#" class="btn-product btn-cart"><span>add to cart</span></a>
								</div><!-- End .product-action -->
							</div><!-- End .product -->
						</div><!-- End .col-sm-6 col-md-4 col-lg-3 -->

						<div class="col-6 col-md-4 col-lg-3 col-xl-5col">
							<div class="product product-11 text-center">
								<figure class="product-media">
									<a href="#">
										<img src="{{asset('frontend/images/demos/demo-2/products/product-14-1.jpg')}}" alt="Product image" class="product-image">
										<img src="{{asset('frontend/images/demos/demo-2/products/product-14-2.jpg')}}" alt="Product image" class="product-image-hover">
									</a>

									<div class="product-action-vertical">
										<a href="#" class="btn-product-icon btn-wishlist "><span>add to wishlist</span></a>
									</div><!-- End .product-action-vertical -->
								</figure><!-- End .product-media -->

								<div class="product-body">
									<div class="product-cat">
										<a href="#">Decor</a>
									</div><!-- End .product-cat -->
									<h3 class="product-title"><a href="#">Cushion Set 3 Pieces</a></h3><!-- End .product-title -->
									<div class="product-price">
										$199,00
									</div><!-- End .product-price -->
								</div><!-- End .product-body -->
								<div class="product-action">
									<a href="#" class="btn-product btn-cart"><span>add to cart</span></a>
								</div><!-- End .product-action -->
							</div><!-- End .product -->
						</div><!-- End .col-sm-6 col-md-4 col-lg-3 -->

						<div class="col-6 col-md-4 col-lg-3 col-xl-5col">
							<div class="product product-11 text-center">
								<figure class="product-media">
									<a href="#">
										<img src="{{asset('frontend/images/demos/demo-2/products/product-15-1.jpg')}}" alt="Product image" class="product-image">
										<img src="{{asset('frontend/images/demos/demo-2/products/product-15-2.jpg')}}" alt="Product image" class="product-image-hover">
									</a>

									<div class="product-action-vertical">
										<a href="#" class="btn-product-icon btn-wishlist "><span>add to wishlist</span></a>
									</div><!-- End .product-action-vertical -->
								</figure><!-- End .product-media -->

								<div class="product-body">
									<div class="product-cat">
										<a href="#">Decor</a>
									</div><!-- End .product-cat -->
									<h3 class="product-title"><a href="#">Cushion Set 3 Pieces</a></h3><!-- End .product-title -->
									<div class="product-price">
										$199,00
									</div><!-- End .product-price -->
								</div><!-- End .product-body -->
								<div class="product-action">
									<a href="#" class="btn-product btn-cart"><span>add to cart</span></a>
								</div><!-- End .product-action -->
							</div><!-- End .product -->
						</div><!-- End .col-sm-6 col-md-4 col-lg-3 -->
					</div><!-- End .row -->
				</div><!-- End .products -->
			</div><!-- .End .tab-pane -->
			<div class="tab-pane p-0 fade" id="top-light-tab" role="tabpanel" aria-labelledby="top-light-link">
				<div class="products">
					<div class="row justify-content-center">
						<div class="col-6 col-md-4 col-lg-3 col-xl-5col">
							<div class="product product-11 text-center">
								<figure class="product-media">
									<a href="#">
										<img src="{{asset('frontend/images/demos/demo-2/products/product-7-1.jpg')}}" alt="Product image" class="product-image">
										<img src="{{asset('frontend/images/demos/demo-2/products/product-7-2.jpg')}}" alt="Product image" class="product-image-hover">
									</a>

									<div class="product-action-vertical">
										<a href="#" class="btn-product-icon btn-wishlist "><span>add to wishlist</span></a>
									</div><!-- End .product-action-vertical -->
								</figure><!-- End .product-media -->

								<div class="product-body">
									<div class="product-cat">
										<a href="#">Lighting</a>
									</div><!-- End .product-cat -->
									<h3 class="product-title"><a href="#">Petite Table Lamp</a></h3><!-- End .product-title -->
									<div class="product-price">
										$401,00
									</div><!-- End .product-price -->
								</div><!-- End .product-body -->
								<div class="product-action">
									<a href="#" class="btn-product btn-cart"><span>add to cart</span></a>
								</div><!-- End .product-action -->
							</div><!-- End .product -->
						</div><!-- End .col-sm-6 col-md-4 col-lg-3 -->

						<div class="col-6 col-md-4 col-lg-3 col-xl-5col">
							<div class="product product-11 text-center">
								<figure class="product-media">
									<a href="#">
										<img src="{{asset('frontend/images/demos/demo-2/products/product-10-1.jpg')}}" alt="Product image" class="product-image">
										<img src="{{asset('frontend/images/demos/demo-2/products/product-10-2.jpg')}}" alt="Product image" class="product-image-hover">
									</a>

									<div class="product-action-vertical">
										<a href="#" class="btn-product-icon btn-wishlist "><span>add to wishlist</span></a>
									</div><!-- End .product-action-vertical -->
								</figure><!-- End .product-media -->

								<div class="product-body">
									<div class="product-cat">
										<a href="#">Lighting</a>
									</div><!-- End .product-cat -->
									<h3 class="product-title"><a href="#">Carronade Large Suspension Lamp</a></h3><!-- End .product-title -->
									<div class="product-price">
										$401,00
									</div><!-- End .product-price -->

									<div class="product-nav product-nav-dots">
										<a href="#" class="active" style="background: #e8e8e8;"><span class="sr-only">Color name</span></a>
										<a href="#" style="background: #333333;"><span class="sr-only">Color name</span></a>
									</div><!-- End .product-nav -->

								</div><!-- End .product-body -->
								<div class="product-action">
									<a href="#" class="btn-product btn-cart"><span>add to cart</span></a>
								</div><!-- End .product-action -->
							</div><!-- End .product -->
						</div><!-- End .col-sm-6 col-md-4 col-lg-3 -->

						<div class="col-6 col-md-4 col-lg-3 col-xl-5col">
							<div class="product product-11 text-center">
								<figure class="product-media">
									<a href="#">
										<img src="{{asset('frontend/images/demos/demo-2/products/product-16-1.jpg')}}" alt="Product image" class="product-image">
										<img src="{{asset('frontend/images/demos/demo-2/products/product-16-2.jpg')}}" alt="Product image" class="product-image-hover">
									</a>

									<div class="product-action-vertical">
										<a href="#" class="btn-product-icon btn-wishlist "><span>add to wishlist</span></a>
									</div><!-- End .product-action-vertical -->
								</figure><!-- End .product-media -->

								<div class="product-body">
									<div class="product-cat">
										<a href="#">Lighting</a>
									</div><!-- End .product-cat -->
									<h3 class="product-title"><a href="#">Carronade Table Lamp</a></h3><!-- End .product-title -->
									<div class="product-price">
										$499,00
									</div><!-- End .product-price -->
								</div><!-- End .product-body -->
								<div class="product-action">
									<a href="#" class="btn-product btn-cart"><span>add to cart</span></a>
								</div><!-- End .product-action -->
							</div><!-- End .product -->
						</div><!-- End .col-sm-6 col-md-4 col-lg-3 -->
					</div><!-- End .row -->
				</div><!-- End .products -->
			</div><!-- .End .tab-pane -->
		</div><!-- End .tab-content -->
	</div><!-- End .container -->
  
</main><!-- End .main -->


 
@endsection