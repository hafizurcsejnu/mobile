
@extends('layouts.master')
@section('main_content')
<main class="main">
    <div class="page-header text-center" style="background-image: url('{{asset('frontend/images/page-header-bg.jpg')}}')">
        <div class="container">
            <h1 class="page-title">{{$data->title}}<span></span></h1>
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
<style> 
/* img {
    max-width: 100%!important; 
} 
.icon-boxes-container {
    display: none;
} */
</style> 
<br>
<div class="page-content">
	<div class="container">

		<div class="popular-courses-contnet">
			<p>{!! $data->description !!}</p>
		</div>
	</div>

	</div>
</div>


 @endsection
