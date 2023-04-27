
@extends('layouts.master')
@section('main_content')
<main class="main">
    <div class="page-header text-center" style="background-image: url('{{asset('frontend/images/page-header-bg.jpg')}}')">
        <div class="container">
                <h1 class="page-title"><span>Shop</span> in 
                    {{$category}}
        </h1>
            
        </div><!-- End .container -->
    </div><!-- End .page-header -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav mb-2">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{URL::to('/')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Shop</a></li>
                <li class="breadcrumb-item"><a href="#">Category</a></li>
            </ol> 
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->

    <div class="page-content">
        <div class="container">
            @include('layouts.filter_link')
            <div class="products">
                <div class="row">
                    @foreach($data as $item)      
                    <div class="col-6 col-md-4 col-lg-4 col-xl-3">
                        <div class="product">
                            <figure class="product-media">
                                <span class="product-label label-new">New</span>

                                <?php if($item->images!=null) { $images = explode('|', $item->images);?>

                                <a href="{{URL::to('product')}}/{{$item->id}}">
                                    <img src="{{asset('images')}}/{{$images[0]}}" alt="{{$images[0]}}" class="product-image">
                                </a>
                                <?php } else{?>
                                    <a href="{{URL::to('product')}}/{{$item->id}}">
                                        <img style="width: 100%" src="{{asset('frontend/images/no-image.png')}}" alt="product image not found">
                                    </a>                                    
                                <?php }?>

                                {{-- <div class="product-action-vertical">
                                    <a href="#" class="btn-product-icon btn-wishlist btn-expandable"><span>add to wishlist</span></a>
                                </div> --}}
                                <!-- End .product-action -->

                                <div class="product-action action-icon-top"> 
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

                                    <a href="javascript:void(0)" class="btn-product btn-cart addToCart {{$class}}" data-id="{{$item->id}}"><span>Add to cart</span></a>
                                    
                                    <a href="{{URL::to('quick-view')}}/{{$item->id}}" class="btn-product btn-quickview" title="Quick view"><span>quick view</span></a>
                                  
                                </div><!-- End .product-action -->
                            </figure><!-- End .product-media -->

                            <div class="product-body">
                                <div class="product-cat">
                                    <a href="#">{{$category}}</a>
                                </div><!-- End .product-cat -->
                                <h3 class="product-title"><a href="{{URL::to('product')}}/{{$item->id}}">{{$item->name}}</a></h3><!-- End .product-title -->
                                <div class="product-price">
                                   Price: ${{$item->price}}
                                </div><!-- End .product-price -->
                                {{-- <div class="ratings-container">
                                    <div class="ratings">
                                        <div class="ratings-val" style="width: 0%;"></div><!-- End .ratings-val -->
                                    </div>
                                    <span class="ratings-text">( 0 Reviews )</span>
                                </div> --}}


                                {{-- <div class="product-nav product-nav-dots">
                                    <a href="#" style="background: #cc9966;"><span class="sr-only">Color name</span></a>
                                    <a href="#" class="active" style="background: #ebebeb;"><span class="sr-only">Color name</span></a>
                                </div> --}}
                                
                                <!-- End .product-nav -->
                            </div><!-- End .product-body -->
                        </div><!-- End .product -->
                    </div><!-- End .col-sm-6 col-lg-4 col-xl-3 -->
                     @endforeach

                </div><!-- End .row -->
                <div class="" id="status">
                
                </div>
                <div class="load-more-container text-center">
                    <a href="javascript:void(0)" class="btn btn-outline-darker btn-load-more" data-count="20">More Products <i class="icon-refresh"></i></a>
                </div><!-- End .load-more-container -->
            </div><!-- End .products -->

            @include('layouts.filter')
        </div><!-- End .container -->
    </div><!-- End .page-content -->
</main>

@endsection