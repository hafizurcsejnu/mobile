<?php $menu ='cart';?>
@extends('layouts.master')
@section('main_content')
<style>
  .cart-bottom {
    display: block;
}
</style>

@php 
  $total = 0
@endphp
@if(session('cart'))
  @foreach(session('cart') as $id => $details)  
    @php
      $product = DB::table('products')->where('id', $details['id'])->first();
      $product_price = $product->price;
      $total += $product_price * 1 ;
    @endphp
  @endforeach
@endif

<main class="main">
  <div class="page-header text-center" style="background-image: url('{{asset('frontend/images/page-header-bg.jpg')}}')">
    <div class="container">
      <h1 class="page-title">Shopping Cart<span></span></h1>     
    </div><!-- End .container -->
  </div><!-- End .page-header -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav d-none">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Shop</a></li>
                <li class="breadcrumb-item active" aria-current="page">Shopping Cart</li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->
    <br>

    <div class="page-content">
      <div class="cart">
          <div class="container">
            <div class="row">
              <div class="col-lg-9">
        
        <table class="table table-cart table-mobile">
          <thead>
            <tr>             
              <th>Product Image</th>
              <th>Product Name</th>
              <th>Price</th>
              <th>Total</th>
              <th></th>
            </tr>
          </thead>

          <tbody>
            @if(session('cart'))
                  @foreach(session('cart') as $id => $details)
                    <?php 
                        $product = \App\Models\Product::where('id',$id)->first();  
                        $src = asset($details['image']);    
                        //dd($product->images);
                    ?>
            <tr id="{{$product->id}}">
                  <td class="product-col">
                    <div class="product_image">  
                      @if ($product->product_type == 'collection')
                        <a href="{{URL::to('collection')}}/{{$product->slug}}" target="_blank">
                      @else
                        <a href="{{URL::to('product')}}/{{$product->slug}}" target="_blank">
                      @endif   
                                    
                      <?php if($product->thumbnail != null ){?>                         
                              <img src="{{ URL::asset('storage/app/public/'.$product->thumbnail.'') }}"class="cart_product" width="60px; height:60px">
                      <?php }elseif($product->images!=null) { $images = explode('|', $product->images);?>
                              <img src="{{asset('images')}}/{{$images[0]}}" class="cart_product" width="60px; height:60px">
                      <?php } else{?>
                              <img style="width: 100%" src="{{asset('frontend/images/no-image.png')}}" class="cart_product" width="60px; height:60px">
                      <?php }?>
                      </a>  
                    </div>                 

                </td>
              <td>
                  <h3 class="product-title">
                      @if ($product->product_type == 'collection')
                        <a href="{{URL::to('collection')}}/{{$product->slug}}" target="_blank">
                      @else
                        <a href="{{URL::to('product')}}/{{$product->slug}}" target="_blank">
                      @endif 
                        {{$product->name}}
                      </a>
                  </h3><!-- End .product-title -->
              </td>
              
              <td class="price-col">
                <p class="js--prc text-text" data-baseprice="{{$product->price}}">
                  $<span class="unit_price_{{$product->id}}">{{$product->price}} x 1</span>
              </p>

              </td>
              <td class="total-col">${{$product->price*1}}</td>
              <td class="remove-col">               
                <a href="javascript:void(0)" class="remove text-sm btn-remove" data-id="{{$product->id}}"><i class="icon-close"></i></a>
              </td>
            </tr>
            @endforeach
            @endif
          </tbody>
        </table>
        
       

                <div class="cart-bottom">
                  <div id="success_message" style="color: green; font-size:25px"></div>
                  <div id="error_message" style="color: red; font-size:25px"></div> <br>

                {{-- @if(session('coupon_discount')==null) --}}
                <div class="cart-discount">                  
                  <div class="input-group">
                    <input type="text" class="form-control" required="" name="coupon_code" id="coupon_code" placeholder="coupon code">
                    <div class="input-group-append">
                      <button class="btn btn-outline-primary-2" id="couponBtn" type="submit"><i class="icon-long-arrow-right"></i></button>
                    </div><!-- .End .input-group-append -->
                  </div><!-- End .input-group -->                  
                </div>
                {{-- @endif --}}

                <a href="#" class="d-none btn btn-outline-dark-2"><span>UPDATE CART</span><i class="icon-refresh"></i></a>
              </div><!-- End .cart-bottom -->
              </div><!-- End .col-lg-9 -->
              <aside class="col-lg-3">
                <div class="summary summary-cart">
                  <h3 class="summary-title">Cart Total</h3><!-- End .summary-title -->

                  <table class="table table-summary">
                    <tbody> 
                      <tr class="summary-subtotal">
                        <td>Subtotal:</td>
                        <td>$<span class="sub-total">{{$total}}</span></td>
                      </tr>
                      <!-- End .summary-subtotal -->
                      {{-- <tr class="summary-shipping">
                        <td>Shipping:</td>
                        <td>&nbsp;</td>
                      </tr> --}}


                      <tr class="coupon"></tr>

                      @if(session('coupon_discount')>0)
                      <tr class="summary-subtotal coupon_discount">
                        <td>Coupon discount:</td>
                        <td>-${{session('coupon_discount')}}</td>
                      </tr>
                      @endif 
                    

                      <tr class="summary-total">
                        <td>Total:</td>
                        <td>$<span class="total">@if(session('coupon_discount')>0){{$total-session('coupon_discount')}}@else{{$total}}@endif</span></td>
                      </tr>
                      
                      <!-- End .summary-total -->
                    </tbody>
                  </table><!-- End .table table-summary -->

                  @if($total!=0)
                    <a href="{{URL::to('checkout')}}" class="btn btn-outline-primary-2 btn-order btn-block">PROCEED TO CHECKOUT</a>                 
                  @endif

                </div><!-- End .summary -->

              <a href="{{URL::to('/')}}" class="btn btn-outline-dark-2 btn-block mb-3"><span>CONTINUE SHOPPING</span><i class="icon-refresh"></i></a>
              </aside><!-- End .col-lg-3 -->
            </div><!-- End .row -->
          </div><!-- End .container -->
        </div><!-- End .cart -->
    </div><!-- End .page-content -->
</main>


@endsection