<?php $menu ='shop';?>
@extends('layouts.master')
@section('main_content')
<script src="https://polyfill.io/v3/polyfill.min.js?version=3.52.1&features=fetch"></script>
<script src="https://js.stripe.com/v3/"></script>
<!-- HERO-4
			============================================= -->

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

<style>
  input.form-control.card-cvc {
    padding-left: 15px;
}
.accordion-summary .card-body {
    padding: 0.4rem 0 .8rem 0rem;
}
button.btn.btn-outline-primary-2.btn-order.btn-block {
    margin-left: 6px;
    margin-right: 6px;
}
.alert-warning {
    color: #fff;
    background-color: #c96;
}
</style>
<main class="main">


  <div class="page-header text-center" style="background-image: url('{{asset('frontend/images/page-header-bg.jpg')}}')">
    <div class="container">
      <h1 class="page-title">Checkout<span></span></h1>
    </div><!-- End .container -->
  </div><!-- End .page-header -->
    <nav aria-label="breadcrumb" class="d-none breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Shop</a></li>
                <li class="breadcrumb-item active" aria-current="page">Checkout</li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->
    <br>
    <div class="page-content">
      <div class="checkout">
        @include('_message')
         
          <div class="container">
          {{-- <div class="checkout-discount">
            <form action="#">
            <input type="text" class="form-control" required="" id="checkout-discount-input">
              <label for="checkout-discount-input" class="text-truncate">Have a coupon? <span>Click here to enter your code</span></label>
            </form>
          </div> --}}
          
          <!-- End .checkout-discount -->

                   
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
                            
                                <?php if($images = $product->images) {
                                  $images = explode('|', $images);
                                  ?>             
                                  <img src="{{asset('images')}}/{{$images[0]}}" class="cart_product" alt="" width="60px;">
                                  <?php }?>                     
                              </a>
                            </div><!-- End .product -->
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
                       
                      </tr>
                      @endforeach
                      @endif
                    </tbody>
                  </table>


                  <form action="#" method="post" class="d-none"> 
                  <h2 class="checkout-title">Billing Details</h2><!-- End .checkout-title -->
                    <div class="row">
                      <div class="col-sm-6">
                        <label>First Name *</label>
                        <input type="text" class="form-control" required="">
                      </div><!-- End .col-sm-6 -->

                      <div class="col-sm-6">
                        <label>Last Name *</label>
                        <input type="text" class="form-control" required="">
                      </div><!-- End .col-sm-6 -->
                    </div><!-- End .row -->

                  <label>Company Name (Optional)</label>
                  <input type="text" class="form-control">

                  <label>Country *</label>
                  <input type="text" class="form-control" required="">

                  <label>Street address *</label>
                  <input type="text" class="form-control" placeholder="House number and Street name" required="">
                 
                  <div class="row">
                      <div class="col-sm-6">
                        <label>Town / City *</label>
                        <input type="text" class="form-control" required="">
                      </div><!-- End .col-sm-6 -->

                      <div class="col-sm-6">
                        <label>State / County *</label>
                        <input type="text" class="form-control" required="">
                      </div><!-- End .col-sm-6 -->
                    </div><!-- End .row -->

                    <div class="row">
                      <div class="col-sm-6">
                        <label>Postcode / ZIP *</label>
                        <input type="text" class="form-control" required="">
                      </div><!-- End .col-sm-6 -->

                      <div class="col-sm-6">
                        <label>Phone *</label>
                        <input type="tel" class="form-control" required="">
                      </div><!-- End .col-sm-6 -->
                    </div><!-- End .row -->

                    <label>Email address *</label>
                <input type="email" class="form-control" required="">

            <div class="d-none custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" id="checkout-create-acc">
              <label class="custom-control-label" for="checkout-create-acc">Create an account?</label>
            </div>
            
            <!-- End .custom-checkbox -->           

                    <label>Order notes (optional)</label>
                <textarea class="form-control" cols="30" rows="4" placeholder="Notes about your order, e.g. special notes for delivery"></textarea>
                </div><!-- End .col-lg-9 -->
              </form>






              
                <aside class="col-lg-3">
                  <div class="summary">
                    <h3 class="summary-title">Summary</h3><!-- End .summary-title -->

                    <table class="table table-summary">
                      <thead class="d-none">
                        <tr>
                          <th>Product</th>
                          <th>Total</th>
                        </tr>
                      </thead>

                      <tbody>

                      {{-- @if(session('cart'))
                        @foreach(session('cart') as $id => $details)
                          <?php 
                              // $product = \App\Models\Product::where('id',$id)->first();  
                              // $src = asset($details['image']); 
                          ?> 

                        <tr>
                          <td><a href="#">{{$product->name}}</a></td>
                          <td>${{$product->price}}</td>
                        </tr>
                      @endforeach
                      @endif --}}

                        <tr class="summary-subtotal">
                          <td>Subtotal:</td> 
                          <td>${{$total}}</td>
                        </tr><!-- End .summary-subtotal -->
                        {{-- <tr>
                          <td>Shipping:</td>
                          <td>Free shipping</td>
                        </tr> --}}
                        @if(session('coupon_discount')>0)
                        <tr class="summary-subtotal">
                          <td>Coupon discount:</td>
                          <td>${{session('coupon_discount')}}</td>
                        </tr>
                        @endif

                        <tr class="summary-total">
                          <td>Total:</td>
                          <td>$@if(session('coupon_discount')>0){{$total-session('coupon_discount')}}@else{{$total}}@endif
                          </td>
                        </tr>
                       
                      </tbody>
                    </table><!-- End .table table-summary -->

                    <div class="accordion-summary" id="accordion-payment">
               
                <div class="d-none card">
                    <div class="card-header" id="heading-4">
                        <h2 class="card-title">
                            <a class="collapsed" role="button" data-toggle="collapse" href="#collapse-4" aria-expanded="false" aria-controls="collapse-4">
                                PayPal 
                            </a>
                        </h2>
                    </div>
                    <div id="collapse-4" class="collapse" aria-labelledby="heading-4" data-parent="#accordion-payment">
                        <div class="card-body">
                          <form action="{{ route('create-payment') }}" method="post">
                            @csrf  
                            {{-- <h3>Pay with:</h3> --}}
                            <button type = "submit" class="btn blue-hover1 submit">
                                <img width="100%" title="Click to pay with paypal" src="{{asset('images')}}/paypal.jpg" />
                             </button>
                         </form>
                        </div>
                    </div>
                </div> 

                <form action="{{ route('stripe.checkout') }}" method="POST">
                  @csrf
                  <button class="btn btn-success" style="background: #c96; border: 1px solid #c96" type="submit" id="checkout-button">Checkout</button>
                </form>  
              

                <div class="d-none card"> 
                    <div class="card-header" id="heading-5">
                        <h2 class="card-title">
                            <a class="collapsed" role="button" data-toggle="collapse" href="#collapse-5" aria-expanded="false" aria-controls="collapse-5">
                                Pay with Card
                                {{-- <img src="assets/images/payments-summary.png" alt="payments cards"> --}}
                            </a>
                        </h2>
                    </div><!-- End .card-header -->
                    <div id="collapse-5" class="collapse" aria-labelledby="heading-5" data-parent="#accordion-payment">
                        <div class="card-body"> 
                          
                          <div class="panel panel-default credit-card-box" style="">
                            <div class="panel-heading display-table" >
                                <div class="row display-tr" >
                                  
                                    <div class="display-td" >                            
                                        <img class="img-responsive pull-right" src="{{asset('images')}}/stripe.png">
                                    </div>
                                </div>                    
                            </div>
                            <div class="panel-body">      
                                @if (Session::has('success'))
                                    <div class="alert alert-success text-center">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                                        <p>{{ Session::get('success') }}</p>
                                    </div>
                                @endif
              
                                <form role="form" id="stripe_form" action="{{ route('stripe.post') }}" method="post" class="require-validation" data-cc-on-file="false" data-stripe-publishable-key="{{ env('STRIPE_KEY') }}" id="payment-form">
                                    @csrf
                                  
                                    <p id="errorMsg" class="alert alert-warning text-center" style="display: none"></p>
                                    <div class='form-row row'>
                                        <div class='col-md-12 form-group required'>
                                            <label class='control-label'>Name on Card</label> 
                                            <input
                                                class='form-control' size='4' type='text'>
                                        </div> 
                                    </div>
              
                                    <div class='form-row row'>
                                        <div class='col-md-12 form-group card required'>
                                            <label class='control-label'>Card Number</label> <input
                                                autocomplete='off' class='form-control card-number' size='20'
                                                type='text'>
                                        </div>
                                    </div>
              
                                    <div class='form-row row'>
                                        <div class='col-xs-12 col-md-4 form-group cvc required'>
                                            <label class='control-label'>CVC</label> <input autocomplete='off'
                                                class='form-control card-cvc' placeholder='ex. 311' size='4'
                                                type='text'>
                                        </div>
                                        <div class='col-xs-12 col-md-4 form-group expiration required'>
                                            <label class='control-label'>Month</label> <input
                                                class='form-control card-expiry-month' placeholder='MM' size='2'
                                                type='text'>
                                        </div>
                                        <div class='col-xs-12 col-md-4 form-group expiration required'>
                                            <label class='control-label'>Year</label> <input
                                                class='form-control card-expiry-year' placeholder='YYYY' size='4'
                                                type='text'>
                                        </div>
                                    </div>
              
                                    <div class='form-row row'>
                                        <div class='col-md-12 error form-group d-none'>
                                            <div class='alert-danger alert'>Please correct the errors and try again.</div>
                                        </div>
                                    </div>
              
                                    <div class="row">
                                      <button type="submit" class="btn btn-outline-primary-2 btn-order btn-block">
                                        <span class="btn-text">Pay Now» ($@if(session('coupon_discount')>0){{$total-session('coupon_discount')}}@else{{$total}}@endif)</span>
                                        <span class="btn-hover-text">Pay Now» ($@if(session('coupon_discount')>0){{$total-session('coupon_discount')}}@else{{$total}}@endif)</span>
                                      </button>
                                    </div>
                                      
                                </form>
                            </div>
                        </div>  
        
        {{-- <script type="text/javascript" src="https://js.stripe.com/v2/"></script> --}}
        <script type="text/javascript">
        $(function() {
        var $form         = $(".require-validation");
        $('form.require-validation').bind('submit', function(e) {
        var $form         = $(".require-validation"),
        inputSelector = ['input[type=email]', 'input[type=password]',
                 'input[type=text]', 'input[type=file]',
                 'textarea'].join(', '),
        $inputs       = $form.find('.required').find(inputSelector),
        $errorMessage = $form.find('div.error'),
        valid         = true;
        $errorMessage.addClass('hide');
        
        $('.has-error').removeClass('has-error');
        $inputs.each(function(i, el) {
        var $input = $(el);
        if ($input.val() === '') {
        $input.parent().addClass('has-error');
        $errorMessage.removeClass('hide');
        e.preventDefault();
        }
        });
        
        if (!$form.data('cc-on-file')) {
        e.preventDefault();
        Stripe.setPublishableKey($form.data('stripe-publishable-key'));
        Stripe.createToken({
        number: $('.card-number').val(),
        cvc: $('.card-cvc').val(),
        exp_month: $('.card-expiry-month').val(),
        exp_year: $('.card-expiry-year').val()
        }, stripeResponseHandler);
        }
        
        });
        
        function stripeResponseHandler(status, response) {
        if (response.error) {
          $('#errorMsg').html(response.error.message);
          $('#errorMsg').show();
          //console.log(response.error.message);
        $('.error')
        .removeClass('hide')
        .find('.alert')
        .text(response.error.message);
        } else {
        // token contains id, last4, and card type
        var token = response['id'];
        // insert the token into the form so it gets submitted to the server
        $form.find('input[type=text]').empty();
        $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
        $form.get(0).submit();
        }
        }
        });
        </script>


        
                        </div><!-- End .card-body -->
                    </div><!-- End .collapse -->
                </div>
                

            </div><!-- End .accordion -->

                    {{-- <button type="submit" class="btn btn-outline-primary-2 btn-order btn-block">
                      <span class="btn-text">Place Order</span>
                      <span class="btn-hover-text">Proceed to Checkout</span>
                    </button> --}}

                  </div><!-- End .summary -->
                </aside><!-- End .col-lg-3 -->
              </div><!-- End .row -->
          
          </div><!-- End .container -->
        </div><!-- End .checkout -->
    </div><!-- End .page-content -->
</main>
@endsection