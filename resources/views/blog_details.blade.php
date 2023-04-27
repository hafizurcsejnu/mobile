
@extends('layouts.master2')
@section('main_content')
<style>
img {
    max-width: 100%!important;
} 
</style>
	<!-- SERVICES-2
	============================================= -->	

	<section id="services-2" class="wide-60 services-section division">
		<div class="container blog_details_page"> 
			<div class="row">	
							
				<div class="col-md-12">
					<?php 
							$category = DB::table('blog_categories')
							->where('id', $data->category_id)
							->first(); 
							?>
						<h4 class="text-center blog_details_category">{{$category->name}}</h4>
						<h3 style="white-space:pre-wrap;" class="text-center blog_details_title">{{$data->title}}</h3>
					<img src="{{ URL::asset('storage/app/public/'.$data->image.'') }}" class="blog_details" alt="" style="margin-left: auto;margin-right: auto;display: block;margin-bottom: 50px;">

					<div class="blog_details_inner">                                
						
						<p>{!! $data->description !!}</p>
											

					</div>
				</div>	
			
				
			</div>
		</div>
			
	</section>
			
			
 <br><br>
 <br><br>

 @endsection