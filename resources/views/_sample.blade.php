
@extends('layouts.master')
@section('main_content')

@endsection




<?php 

return redirect()->route('education')->with(session()->flash('alert-success', 'Header data is saved successfully!'));

return redirect()->back()->with(session()->flash('alert-danger', 'This email is already registered.'));



// image 
<?php if($images = $item->images) $images = explode('|', $images);?>

<a href="product/{{$item->id}}">
    <img src="{{asset('images')}}/{{$images[0]}}" alt="{{$images[0]}}" class="product-image">
</a>



@foreach ($images as $image)
    <a class="product-gallery-item active" href="#" data-image="" data-zoom-image="assets/images/products/single/centered/1-big.jpg">
    <img src="{{asset('images')}}/{{$image}}" alt="product side">
</a>
@endforeach



{{-- image  --}}