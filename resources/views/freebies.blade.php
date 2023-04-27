
@extends('layouts.master')
@section('main_content')
<main class="main">
    <div class="page-header text-center" style="background-image: url('{{asset('frontend/images/page-header-bg.jpg')}}')">
        <div class="container">
            <h1 class="page-title">All Freebie Items<span></span></h1> 
        </div><!-- End .container -->
    </div><!-- End .page-header -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav mb-2">
        <div class="d-none container-fluid">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{URL::to('/')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{URL::to('/3dmodels')}}">Shop</a></li>
                <li class="breadcrumb-item active" aria-current="page">Category</li>
            </ol> 
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav --> 
 
    <div class="page-content">
        <div class="container-fluid">
          <style>
            .products .product {
                width: 99.3%!important;
            }
          </style>

            <div class="products">
                <div class="row">
                    @foreach($data as $item)      
                    <div class="col-6 col-md-4 col-lg-4 col-xl-2 product-column">
                        <div class="product">
                            <figure class="product-media">
                                @php
                                if(intval((strtotime(date('Y-m-d H:i:s'))-strtotime($item->created_at))/(60 * 60 * 24))<8)
                                {
                                     echo '<span class="product-label label-new"> New </span>';
                                }
                                @endphp     

                                <a href="{{URL::to('product')}}/{{$item->slug}}">
                                <?php if($item->thumbnail != null ){?>
                                        <img src="{{ URL::asset('storage/app/public/'.$item->thumbnail.'') }}" alt="" class="product-image">
                                <?php }elseif($item->images!=null) { $images = explode('|', $item->images);?>
                                    <img src="{{asset('images')}}/{{$images[0]}}" alt="{{$images[0]}}" class="product-image">
                                <?php } else{?>
                                        <img style="width: 100%" src="{{asset('frontend/images/no-image.png')}}" alt="Product image not found">
                                <?php }?>
                                </a>      

                                {{-- <div class="product-action-vertical">
                                    <a href="#" class="btn-product-icon btn-wishlist btn-expandable"><span>add to wishlist</span></a>
                                </div> --}}
                                <!-- End .product-action -->

                                <div class="product-action product-action-dark">                                   

                                    <a href="{{URL::to('product')}}/{{$item->slug}}" class="btn-product btn-cart"><span>Download</span></a>
                                    
                                    <a href="{{URL::to('quick-view')}}/{{$item->id}}" class="btn-product btn-quickview" title="Quick view"><span>Quick view</span></a>
                                  
                                </div><!-- End .product-action -->
                            </figure><!-- End .product-media -->

                            <div class="product-body">
                                <div class="product-cat">
                                    <a href="#">{{$item->catName}}</a>
                                </div><!-- End .product-cat -->
                                <h3 class="product-title"><a href="{{URL::to('product')}}/{{$item->slug}}">{{$item->name}}</a></h3><!-- End .product-title -->
                                <div class="product-price">
                                    <strike>Price: ${{$item->price}}</strike> 
                                   
                                </div>
                                
                                <!-- End .product-nav -->
                            </div><!-- End .product-body -->
                        </div><!-- End .product -->
                    </div><!-- End .col-sm-6 col-lg-4 col-xl-3 -->
                     @endforeach

                </div><!-- End .row -->

            </div><!-- End .products -->
           
            
        </div><!-- End .container -->
    </div><!-- End .page-content -->
</main>
@endsection