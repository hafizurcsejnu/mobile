
@extends('layouts.master')
@section('main_content')
<main class="main">
   
    <div class="page-header text-center" style="background-image: url('{{asset('frontend/images/page-header-bg.jpg')}}')">
        <div class="container">
            <h1 class="page-title">3D Models [{{$category}}]</h1>
        </div><!-- End .container -->
    </div><!-- End .page-header -->

   

    <nav aria-label="breadcrumb" class="breadcrumb-nav mb-2">
        <div class="d-none container-fluid">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{URL::to('/')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{URL::to('/3dmodels')}}">Shop</a></li>
                <li class="breadcrumb-item"><a href="#">Category</a></li> 
            </ol> 
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->

    <div class="page-content">
        <div class="container-fluid">

            @include('layouts.filter_link')
            @include('layouts.products')            
            @include('layouts.filter')

        </div>
    </div>

</main>

@endsection