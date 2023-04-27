@extends('layouts.master')
@section('main_content')
<?php
use App\Models\ProductCategory;
use App\Models\Product;
use App\Models\Collection;
?>
<main class="main">
	<div class="intro-slider-container text-center">
		<div class="owl-carousel owl-simple owl-light owl-nav-inside" data-toggle="owl" data-owl-options='{"nav": false}'>
			<div class="intro-slide" style="background-image: url({{asset('frontend/images/demos/demo-2/slider/slide-1.jpg')}});">
				<div class="container intro-content">
					<h3 class="intro-subtitle">Top quality</h3><!-- End .h3 intro-subtitle -->
					<h1 class="intro-title">3D Models for Professissionals <br> by Professionals </h1><!-- End .intro-title -->

					<a href="{{URL::to('/3dmodels')}}" class="btn btn-primary">
						<span>Shop Now</span>
						<i class="icon-long-arrow-right"></i>
					</a>
				</div><!-- End .container intro-content -->
			</div><!-- End .intro-slide -->

			<div class="intro-slide" style="background-image: url(assets/images/demos/demo-2/slider/slide-2.jpg')}});">
				<div class="container intro-content">
					<h3 class="intro-subtitle">Deals and Promotions</h3><!-- End .h3 intro-subtitle -->
					<h1 class="intro-title">Ypperlig <br>Coffee Table <br><span class="text-primary"><sup>$</sup>49,99</span></h1><!-- End .intro-title -->

					<a href="#" class="btn btn-primary">
						<span>Shop Now</span>
						<i class="icon-long-arrow-right"></i>
					</a>
				</div><!-- End .container intro-content -->
			</div><!-- End .intro-slide -->

			<div class="intro-slide" style="background-image: url(assets/images/demos/demo-2/slider/slide-3.jpg')}});">
				<div class="container intro-content">
					<h3 class="intro-subtitle">Living Room</h3><!-- End .h3 intro-subtitle -->
					<h1 class="intro-title">
						Make Your Living Room <br>Work For You.<br>
						<span class="text-primary">
							<sup class="text-white font-weight-light">from</sup><sup>$</sup>9,99
						</span>
					</h1><!-- End .intro-title -->

					<a href="#" class="btn btn-primary">
						<span>Shop Now</span>
						<i class="icon-long-arrow-right"></i>
					</a>
				</div><!-- End .container intro-content -->
			</div><!-- End .intro-slide -->
		</div><!-- End .owl-carousel owl-simple -->

		<span class="slider-loader text-white"></span><!-- End .slider-loader -->
	</div><!-- End .intro-slider-container -->


	<div class="mb-3 mb-lg-5"></div><!-- End .mb-3 mb-lg-5 -->

	<div class="mb-3"></div><!-- End .mb-6 -->            

	<div class="container">
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
	<div class="container">
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