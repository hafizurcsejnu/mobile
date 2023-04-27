<?php 
    use App\Models\DataLookup; 
?>
@extends('layouts.master')
@section('main_content')
<main class="main">
    <div class="page-header text-center" style="background-image: url('{{asset('frontend/images/page-header-bg.jpg')}}')">
        <div class="container">
            <h1 class="page-title">Top 3D Models<span>Shop</span></h1>
        </div><!-- End .container -->
    </div><!-- End .page-header -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav mb-2">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{URL::to('/')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{URL::to('/shop')}}">Shop</a></li>
                <li class="breadcrumb-item active" aria-current="page">Category</li>
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
                                
                                    <?php 
                                        $now = time();  
                                        $created_at = strtotime($item->created_at);
                                        $datediff = $now - $created_at;
                                        $difference = round($datediff / (60 * 60 * 24));
                                        if($difference < 7){
                                            echo '<span class="product-label label-new">New</span>';
                                        }
                                    ?>
                                

                                <?php if($images = $item->images) $images = explode('|', $images);?>

                                <a href="product/{{$item->id}}">
                                    <img src="{{asset('images')}}/{{$images[0]}}" alt="{{$images[0]}}" class="product-image">
                                </a>

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
                                    <a href="javascript:void(0)" class="btn-product btn-cart add-to-cart {{$class}}" data-id="{{$item->id}}"><span class="add-to-cart-btn">Add to cart</span></a>

                                    <a href="{{URL::to('quick-view')}}/{{$item->id}}" class="btn-product btn-quickview" title="Quick view"><span>quick view</span></a>
                                   


                                </div>
                            </figure>

                            <div class="product-body">
                                <div class="product-cat">
                                    <a href="#">{{$item->catName}}</a>
                                </div>
                                <h3 class="product-title"><a href="product/{{$item->id}}">{{$item->name}}</a></h3>
                                <div class="product-price">
                                    ${{$item->price}}
                                </div>
                                <div class="ratings-container">
                                    <div class="ratings">
                                        <div class="ratings-val" style="width: 0%;"></div>
                                    </div>
                                    <span class="ratings-text">( 0 Reviews )</span>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                     @endforeach

                </div><!-- End .row -->
                <div class="" id="status">
                        
                </div>
                <div class="load-more-container text-center">
                    <a href="javascript:void(0)" data-count="20" class="btn btn-outline-darker btn-load-more">More Models <i class="icon-refresh"></i></a>
                </div><!-- End .load-more-container -->
            </div><!-- End .products -->

            @include('layouts.filter')           

        </div><!-- End .container -->
    </div><!-- End .page-content -->
</main>
@endsection 

