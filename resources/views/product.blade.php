
@extends('layouts.master')
@section('main_content')
<main class="main">
    <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0 d-none">
        <div class="container d-flex align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{URL::to('/')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{URL::to('/3dmodels')}}">Products</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$item->name}}</li>
            </ol>             
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->
    <style>
        @keyframes tawkMaxOpen {
            0% { 
                opacity: 0;
                transform: translate(0, 30px);
                ;
            }

            to {
                opacity: 1;
                transform: translate(0, 0px);
            }
        }

        @-moz-keyframes tawkMaxOpen {
            0% {
                opacity: 0;
                transform: translate(0, 30px);
                ;
            }

            to {
                opacity: 1;
                transform: translate(0, 0px);
            }
        }

        @-webkit-keyframes tawkMaxOpen {
            0% {
                opacity: 0;
                transform: translate(0, 30px);
                ;
            }

            to {
                opacity: 1;
                transform: translate(0, 0px);
            }
        }

        #b5kqk2g63lcg1fhgl9275.open {
            animation: tawkMaxOpen .25s ease !important;
        }

        @keyframes tawkMaxClose {
            from {
                opacity: 1;
                transform: translate(0, 0px);
                ;
            }

            to {
                opacity: 0;
                transform: translate(0, 30px);
                ;
            }
        }

        @-moz-keyframes tawkMaxClose {
            from {
                opacity: 1;
                transform: translate(0, 0px);
                ;
            }

            to {
                opacity: 0;
                transform: translate(0, 30px);
                ;
            }
        }

        @-webkit-keyframes tawkMaxClose {
            from {
                opacity: 1;
                transform: translate(0, 0px);
                ;
            }

            to {
                opacity: 0;
                transform: translate(0, 30px);
                ;
            }
        }

        #b5kqk2g63lcg1fhgl9275.closed {
            animation: tawkMaxClose .25s ease !important
        }
    </style>
    
<style>
.product-body {
    min-height: 120px;
}
</style>

    <div class="page-content mt-3 product-page">
        <div class="container">
            <div class="product-details-top mb-2">
                <div class="row">
                    <div class="col-md-7">
                        <div class="product-gallery product-gallery-vertical">
                            <div class="row">
                                <?php 
                                    if($item->images != null) {
                                    $images = explode('|', $item->images);
                                    //dd($item->images);
                                ?>   
                                <figure class="product-main-image">                                    
                                    <img id="product-zoom" src="{{asset('images')}}/{{$images[0]}}" data-zoom-image="{{asset('images')}}/{{$images[0]}}" alt="product image">

                                    <a href="#" id="btn-product-gallery" class="btn-product-gallery">
                                        <i class="icon-arrows"></i>
                                    </a>
                                </figure><!-- End .product-main-image -->

                                <div id="product-zoom-gallery" class="product-image-gallery">
                                    <style>
                                        a.product-gallery-item {
                                            width: 100px;
                                            float: left;
                                        }
                                    </style>
                                   
                                    <?php 
                                        for ($i=0; $i<count($images) && $i<15; $i++) 
                                        {  
                                        ?>
                                            <a class="product-gallery-item <?php if($i==0) echo "active";?>" href="#" data-image="{{asset('images')}}/{{$images[$i]}}" data-zoom-image="{{asset('images')}}/{{$images[$i]}}" style="direction:ltr;">
                                                <img src="{{asset('images')}}/{{$images[$i]}}" alt="product thumnail">
                                            </a>
                                    <?php } ?>

                                </div><!-- End .product-image-gallery -->

                                <?php } else{?>
                                    <style>
                                        .product-gallery.product-gallery-vertical {
                                            float: left;
                                        }
                                    </style>
                                    <img src="{{asset('frontend/images/no-image.png')}}" alt="product image not found">
                                    <?php }?>

                            </div><!-- End .row -->
                           

                        </div>

                        <div class="d-none product-gallery product-gallery-vertical">
                            <div class="row">

                                <?php 
                                    if($item->images != null) {
                                    $images = explode('|', $item->images);
                                    //dd($item->images);
                                ?>   
                                <figure class="product-main-image">                                                                 
                                   
                                    <img id="product-zoom" src="{{asset('images')}}/{{$images[0]}}" data-zoom-image="{{asset('images')}}/{{$images[0]}}" alt="product image" style="height: 600px!important">

                                    <a href="#" id="btn-product-gallery" class="btn-product-gallery">
                                        <i class="icon-arrows"></i>
                                    </a>
                                </figure><!-- End .product-main-image -->

                                <div id="product-zoom-gallery" class="product-image-gallery" style="overflow-y: scroll;overflow-x:hidden; direction: rtl; height:620px;">
                                    <div class="scroll_bar_inside" style="direction: ltr1;">                               
                                        <?php 
                                        for ($i=0; $i<count($images) && $i<15; $i++) 
                                        {  
                                        ?>
                                            <a class="product-gallery-item <?php if($i==0) echo "active";?>" href="#" data-image="{{asset('images')}}/{{$images[$i]}}" data-zoom-image="{{asset('images')}}/{{$images[$i]}}" style="direction:ltr;">
                                                <img src="{{asset('images')}}/{{$images[$i]}}" alt="product thumnail">
                                            </a>
                                            <?php } ?>
                                    </div>
                                </div>
                               <?php } else{?>
                                <style>
                                    .product-gallery.product-gallery-vertical {
                                        float: left;
                                    }
                                </style>
                                <img src="{{asset('frontend/images/no-image.png')}}" alt="product image not found">
                                <?php }?>
                                <!-- End .product-image-gallery -->
                            </div><!-- End .row -->
                        </div><!-- End .product-gallery -->
                    </div><!-- End .col-md-6 -->

                    <div class="col-md-5"> 
                        <div class="product-details product-details-centered1">
                            <h1 class="product-title" style="border-bottom: 1px solid #ece8e8;padding-bottom:5px">{{$item->name}}</h1>
                            <!-- End .product-title -->

                            {{-- <div class="ratings-container">
                                <div class="ratings">
                                    <div class="ratings-val" style="width: 80%;"></div>
                                </div>
                                <a class="ratings-text" href="#product-review-link" id="review-link">( 2 Reviews )</a>
                            </div> --}}
                            

                            <div class="product-price">
                              Price:  ${{$item->price}}
                            </div><!-- End .product-price -->

                            <div class="product-content">
                                {!!$item->description!!}
                            </div><!-- End .product-content -->

                            <div class="cart_container">
                            @if ($item->freebee != 'on')  
                            
                                <div class="product-details-action">
                                    <a href="javascript:void(0)" id="atc{{$item->id}}" class="btn-product btn-cart addToCart" data-id="{{$item->id}}"><span>Add to cart</span></a>
                                </div>

                                <div id="message"></div>
                                <div class="details-action-wrapper">                               
                                    @if (Session::get('user'))
                                        <a href="javascript:void(0)"  id="addToWishlist" class="btn-product btn-wishlist" title="Wishlist" data-id="{{$item->id}}"><span>Add to Wishlist</span></a>
                                    @else
                                        <a href="{{url('login')}}" class="btn-product btn-wishlist" title="Wishlist"><span>Add to Wishlist</span></a>
                                    @endif                                
                                </div>  
                            
                            @else
                                <style>
                                    .freebees_download a {
                                            padding: 8px;
                                            margin: 5px;
                                    }
                                </style>     
                                @if (Session::get('user'))
                                <div class="freebees_download">
                                    @if($item->source_max != null)
                                        <a href="{{URL::to('freebees-download')}}/{{$item->id}}/source_max" 
                                        class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect btn-circle btn-primary"> Max </a>
                                    @endif
                                    @if($item->source_fbx != null)
                                        <a href="{{URL::to('freebees-download')}}/{{$item->id}}/source_fbx" 
                                        class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect btn-circle btn-primary"> FBX </a>
                                    @endif
                                    @if($item->source_obj != null)
                                        <a href="{{URL::to('freebees-download')}}/{{$item->id}}/source_obj" 
                                        class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect btn-circle btn-primary"> OBJ </a>
                                    @endif
                                    @if($item->source_blend != null)
                                        <a href="{{URL::to('freebees-download')}}/{{$item->id}}/source_blend" 
                                        class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect btn-circle btn-primary"> Blend </a>
                                    @endif                                  
                                    @if($item->source_c4d != null)
                                        <a href="{{URL::to('freebees-download')}}/{{$item->id}}/source_c4d" 
                                        class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect btn-circle btn-primary"> C4D </a>
                                    @endif
                                    @if($item->source_texture != null)
                                        <a href="{{URL::to('freebees-download')}}/{{$item->id}}/source_texture" 
                                        class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect btn-circle btn-primary"> Texture </a>
                                    @endif 

                                </div> 
                                @else
                                    <a href="{{url('login')}}" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect btn-circle btn-primary" style="padding:15px"><span>Please Login to explore download links</span></a>
                                @endif    
                                                               
                            @endif

                                
                            </div><!-- End .product-details-action -->

                            <div class="product-details-footer">
                                @if ($item->category_id)
                                    <div class="product-cat">
                                        <span>Category:</span>
                                        <?php 
                                            $category = DB::table('product_categories') 
                                                ->where('id', $item->category_id)
                                                ->first(); 
                                        ?>
                                        <a href="{{URL::to('3dmodels-category')}}/{{$category->slug}}">{{$category->name}}</a>
                                    </div>
                                @endif
                              
                            </div><!-- End .product-details-footer -->

                        </div>
                        </div><!-- End .product-details -->
                    </div><!-- End .col-md-6 -->
                </div><!-- End .row -->
            </div><!-- End .product-details-top -->

            <div class="container product-details-tab">
                <ul class="nav nav-pills justify-content-center" role="tablist">
                    {{-- <li class="nav-item"> 
                        <a class="nav-link active" id="product-desc-link" data-toggle="tab" href="#product-desc-tab" role="tab" aria-controls="product-desc-tab" aria-selected="true">Detail Description</a>
                    </li> --}}
                    <li class="nav-item">
                        <a class="nav-link active" id="product-info-link" data-toggle="tab" href="#product-info-tab" role="tab" aria-controls="product-info-tab" aria-selected="false">Additional information</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="product-shipping-link" data-toggle="tab" href="#product-shipping-tab" role="tab" aria-controls="product-shipping-tab" aria-selected="false">Available File Formates</a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link" id="product-review-link" data-toggle="tab" href="#product-review-tab" role="tab" aria-controls="product-review-tab" aria-selected="false">Reviews (2)</a>
                    </li> --}}
                </ul>
                <div class="tab-content">
                    {{-- <div class="tab-pane fade show active" id="product-desc-tab" role="tabpanel" aria-labelledby="product-desc-link">
                        <div class="product-desc-content">
                            <h3>Product Information</h3>
                            <p>
                                {!!$item->description!!}
                            </p>
                            
                        </div>
                    </div> --}}

                    <div class="tab-pane fade show active" id="product-info-tab" role="tabpanel" aria-labelledby="product-info-link">
                        <div class="product-desc-content">
                            <div class="row">
                                <div class="col-md-3">
                                    <h3>Faces</h3>
                                    <ul>
                                        <li> {!!$item->faces!!}</li>
                                    </ul>
                                </div>
                                <div class="col-md-3">
                                    <h3>Uses</h3>
                                    <ul>
                                        <li> {!!$item->usages!!}</li>
                                    </ul>
                                </div>
                                <div class="col-md-3">
                                    <h3>Materials</h3>
                                    <ul>
                                        <li> {!!$item->materials!!}</li>
                                    </ul>
                                </div>
                                <div class="col-md-3">
                                    <h3>Style</h3>
                                    <ul>
                                        <li> {!!$item->style!!}</li>
                                    </ul>
                                </div>                                
                            </div>
                        </div><!-- End .product-desc-content -->
                    </div><!-- .End .tab-pane -->
                    <div class="tab-pane fade" id="product-shipping-tab" role="tabpanel" aria-labelledby="product-shipping-link">
                        <div class="product-desc-content">
                            <h3>File Formats</h3>
                            <ul>

                    <?php                     
                        if($file_formats = $item->file_formats){
                            $file_formats = explode(',', $file_formats);
                            foreach($file_formats as $file){?>                            
                                #{{$file}} &nbsp;
                    <?php } }?>

                            </ul>

                            <?php                     
                            if($source_files = $item->source_files){
                                $source_files = explode(',', $source_files);
                                foreach($source_files as $file){?>  
                                    <a href="{{URL::to('/download')}}/{{$item->id}}">File One</a>&nbsp;
                            <?php } 
                            }?>


                        </div><!-- End .product-desc-content -->
                    </div><!-- .End .tab-pane -->

                </div><!-- End .tab-content -->
            </div><!-- End .product-details-tab -->

            <h2 class="title1 text-center mb-4">You May Also Like</h2><!-- End .title text-center -->
            <div class="container-fluid owl-carousel owl-simple carousel-equal-height carousel-with-shadow owl-loaded owl-drag" data-toggle="owl" data-owl-options="{
                    &quot;nav&quot;: false, 
                    &quot;dots&quot;: true,
                    &quot;margin&quot;: 20,
                    &quot;loop&quot;: false,
                    &quot;responsive&quot;: {
                        &quot;0&quot;: {
                            &quot;items&quot;:1
                        },
                        &quot;480&quot;: {
                            &quot;items&quot;:2
                        },
                        &quot;768&quot;: {
                            &quot;items&quot;:3
                        },
                        &quot;992&quot;: {
                            &quot;items&quot;:4
                        },
                        &quot;1200&quot;: {
                            &quot;items&quot;:6,
                            &quot;nav&quot;: true,
                            &quot;dots&quot;: false
                        }
                    }
                }">
              
                <!-- End .product -->
            <div class="owl-stage-outer"><div class="owl-stage" style="transform: translate3d(0px, 0px, 0px); transition: all 0s ease 0s; width: 1485px;">
                

        <?php 
        $products = DB::table('products') 
            ->where('category_id', $item->category_id)
            ->where('freebee', null)
            ->limit(12) 
            ->get(); 
            
        ?>
        @foreach ($products as $item)

            <div class="owl-item ymal active" style="width: 300px!important; margin-right: 20px;">
                <div class="product product-2">
                    <figure class="product-media">                       
                       

                        <?php if($item->thumbnail != null ){?>
                            <a href="{{URL::to('product')}}/{{$item->slug}}" target="_blank">
                                <img src="{{ URL::asset('storage/app/public/'.$item->thumbnail.'') }}" alt="" class="product-image">
                            </a>
                        <?php }elseif($item->images!=null) { $images = explode('|', $item->images);?>
                        <a href="{{URL::to('product')}}/{{$item->slug}}" target="_blank">
                            <img src="{{asset('images')}}/{{$images[0]}}" alt="{{$images[0]}}" class="product-image">
                        </a>
                        <?php } else{?>
                            <a href="{{URL::to('product')}}/{{$item->slug}}" target="_blank">
                                <img style="width: 100%" src="{{asset('frontend/images/no-image.png')}}" alt="Product image not found">
                            </a>                                    
                        <?php }?>

        
                        <div class="product-action-vertical">
                            @if (Session::get('user'))
                                <a href="javascript:void(0)" class="btn-product-icon btn-wishlist btn-expandable addToWishlist" title="Wishlist" data-id="{{$item->id}}">
                                    <span id="atw{{$item->id}}">Add to Wishlist</span> 
                                </a>                                           
                            @else
                                <a href="{{url('login')}}" class="btn-product-icon btn-wishlist btn-expandable" title="Wishlist"><span>Add to Wishlist</span></a>
                            @endif    
                        </div>
                        <!-- End .product-action -->
                        
    
                        <div class="product-action product-action-dark">
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
    
                            <a href="javascript:void(0)" id="atc{{$item->id}}" class="btn-product btn-cart addToCart {{$class}}" data-id="{{$item->id}}"><span>Add to cart</span></a>
                        
                            <a href="{{URL::to('quick-view')}}/{{$item->id}}" class="btn-product btn-quickview" title="Quick view"><span>Quick view</span></a>
                        </div>
                        <!-- End .product-action -->
                    </figure>
                    <!-- End .product-media -->
    
                    <div class="product-body">
                        <div class="product-cat">
                            {{-- <a href="3dmodels-category/{{$item->catId}}" target="_blank">{{$category}}</a> --}}
                        </div>
                        <!-- End .product-cat -->
                        
                        <h3 class="product-title"><a href="{{URL::to('product')}}/{{$item->slug}}">{{$item->name}}</a></h3>
                        <!-- End .product-title -->
                        <div class="product-price">
                            ${{$item->price}}
                        </div>
                        <!-- End .product-price -->                   
                    </div>
                    <!-- End .product-body -->
                </div>
            </div>
     @endforeach
              
                
            
                
            </div>
        </div>
                
                <div class="owl-nav"><button type="button" role="presentation" class="owl-prev disabled"><i class="icon-angle-left"></i></button><button type="button" role="presentation" class="owl-next"><i class="icon-angle-right"></i></button></div>
                
                <div class="owl-dots disabled">
                    
                    <button role="button" class="owl-dot active"><span></span></button><button role="button" class="owl-dot"><span></span></button><button role="button" class="owl-dot"><span></span></button></div></div><!-- End .owl-carousel -->
        </div><!-- End .container -->
    </div><!-- End .page-content -->
</main>

<script>    
    $( document ).ready(function() {
        // wishlist start
        $('#addToWishlist').click(function (event){  
            event.preventDefault();            
            var id = $(this).data('id');

            $.ajax({
            url:"{{route('add-to-wishlist')}}",
            data: {
                _token: '{{csrf_token()}}',
                id: id
            },
            type: 'POST',
            success: function(response){           

                if(response.success==true){  
                   var string = '<p class="alert alert-success text-center">'+response.data+'</p>';
                   $('#message').html(string);
                   console.log('wishlist added.'); 
                }
                else{
                  var string = '<p class="alert alert-danger text-center">'+response.data+'</p>';
                   $('#message').html(string);  
                }                
            }
            });
        });
        // wishlist end
});
</script>
@endsection