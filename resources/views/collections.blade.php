
@extends('layouts.master')
@section('main_content')
<main class="main">
    <div class="page-header text-center" style="background-image: url('{{asset('frontend/images/page-header-bg.jpg')}}')">
        <div class="container">
            <h1 class="page-title">Collections of 3D Model<span></span></h1> 
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
                .load-more-container{display: none;}
            </style>
            {{-- @include('layouts.filter_link') --}}
           
<style>               
    .btn-product-icon {
        color: #c96;
        border-color: #c96;
        background-color: transparent;
        border: 0.1rem solid #c96;
    }
    .product-body {
        min-height: 105px;
    }    
</style>

<div class="products">
    <div class="row">
        @foreach($data as $item)      
        @if(isset($page))
            <div class="col-6 col-md-4 col-lg-4 col-xl-2 product-column" data-count="0">   
        @else
            <div class="col-6 col-md-4 col-lg-4 col-xl-2 product-column"  data-count="{{$item->popularity_count}}">      
        @endif

                             

            <div class="product product-2">
                <figure class="product-media">
                    @php
                       if(intval((strtotime(date('Y-m-d H:i:s'))-strtotime($item->created_at))/(60 * 60 * 24))<8)
                       {
                            echo '<span class="product-label label-new"> New </span>';
                       }
                    @endphp  

                        <a href="{{URL::to('collection')}}/{{$item->slug}}" target="_blank">
                        <?php if($item->thumbnail != null ){?>
                            <img src="{{ URL::asset('storage/app/public/'.$item->thumbnail.'') }}" alt="" class="product-image">
                        <?php }elseif($item->images!=null) { $images = explode('|', $item->images);?>
                            <img src="{{asset('images')}}/{{$images[0]}}" alt="{{$images[0]}}" class="product-image">
                        <?php } else{?>
                                <img style="width: 100%" src="{{asset('frontend/images/no-image.png')}}" alt="Product image not found">
                        <?php }?>                                            
                        </a>
    
                    <div class="product-action-vertical">
                        @if (Session::get('user'))
                            <a href="javascript:void(0)" class="btn-product-icon btn-wishlist btn-expandable addToWishlist" title="Wishlist" data-id="{{$item->id}}">
                                <span id="atw{{$item->id}}">Add to Wishlist</span> 
                            </a>                                           
                        @else
                            <a href="{{url('login')}}" class="btn-product-icon btn-wishlist btn-expandable" title="Wishlist"><span>Add to Wishlist</span></a>
                        @endif    
                    </div>
                    <!-- End .product-action -->
                    

                    <div class="product-action product-action-dark">
                        @if(session('cart'))
                            @php
                                $cart = session()->get('cart');
                                if(isset($cart[$item->id])) {
                                $class= "cart";
                                }
                                else{
                                $class="";
                                } 
                            @endphp
                        @else
                            @php
                                $class = "";
                            @endphp
                        @endif

                        <a href="javascript:void(0)" id="atc{{$item->id}}" class="btn-product btn-cart addToCart {{$class}}" data-id="{{$item->id}}"><span>Add to cart</span></a>
                    
                        <a href="{{URL::to('quick-view')}}/{{$item->id}}" class="btn-product btn-quickview" title="Quick view"><span>Quick view</span></a>
                    </div>
                    <!-- End .product-action -->
                </figure>
                <!-- End .product-media --> 

                <div class="product-body">
                    <div class="product-cat">
                        {{-- <a href="3dmodels-category/{{$item->catId}}" target="_blank">{{$category}}</a> --}}
                    </div>
                    <!-- End .product-cat -->
                    
                    <h3 class="product-title"><a href="{{URL::to('collection')}}/{{$item->slug}}" target="_blank">{{$item->name}}</a></h3>
                    <!-- End .product-title -->
                    <div class="product-price">
                        ${{$item->price}}
                    </div>
                    <!-- End .product-price -->                   
                </div>
                <!-- End .product-body -->
            </div>

        </div>
         @endforeach
    </div><!-- End .row -->

    <div class="" id="status"></div>
    @if(count($data)>=30)
    <div class="load-more-container text-center">
        <a href="javascript:void(0)" class="btn btn-outline-darker btn-load-more" data-count="30">More Models <i class="icon-refresh"></i></a>
    </div><!-- End .load-more-container -->
    @endif
</div> 
            {{-- @include('layouts.filter') --}} 

        </div>
    </div>

</main>
@endsection