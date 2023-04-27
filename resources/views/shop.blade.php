<?php 
    use App\Models\DataLookup; 
?>
@extends('layouts.master')
@section('main_content')
<main class="main">

   
    <div class="page-header text-center" style="background-image: url('{{asset('frontend/images/page-header-bg.jpg')}}')">
        <div class="container">
            <h1 class="page-title">Top 3D Models<span></span></h1>
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
            @include('layouts.filter_link')  
                        
            @include('_message')

            @include('layouts.products')
            @include('layouts.filter')   
        </div> 
    </div>
   
 
</main>
@endsection 

