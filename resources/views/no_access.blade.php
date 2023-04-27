<?php $menu ='services';?>
@extends('layouts.master')
@section('main_content')
<main class="main">

    <div class="page-header text-center" style="background-image: url('{{asset('frontend/images/page-header-bg.jpg')}}')">
        <div class="container">
          <h1 class="page-title">You are not authorized in admin pages!<span></span></h1>     
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
   

    <div class="page-content pb-3">

        <div class="container mt-2 ">
            @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                @if(Session::has('alert-' . $msg))
                    <p class="alert alert-{{ $msg }} text-center">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                @endif
            @endforeach
        </div>

<style>
.not_found_area {
    padding: 80px; 
}
.not_found_area p {
    font-size: 38px;
    color: #e3b566; 
}
</style>  
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="not_found_area text-center">
                        {{-- <h1 class="">404</h1> --}}
                        <p class="">Oops! Something is wrong.</p>
                    </div>
                </div>
            </div><!-- End .row -->
           
        </div><!-- End .container -->

      
    </div>

<style>
    .icon-boxes-container {
    display: none;
}
</style>

</main>
@endsection