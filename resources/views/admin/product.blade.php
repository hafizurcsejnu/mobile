
@extends('admin.master')
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
                    <div class="col-md-5">
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

                    <div class="col-md-7"> 
                        <div class="product-details product-details-centered1">
                            <h1 class="product-title" style="border-bottom: 1px solid #ece8e8;padding-bottom:5px">{{$item->name}}  
                            
                            <a title="Edit" href="edit-product/{{$item->id}}" class="v-hover" style="font-size: 15px">
                                <i class="fa fa-edit text-blue-m1 text-120"></i>
                            </a> 
                        </h1>

                            
                                                    

                            <div class="product-price">
                              Price:  {{$item->price}} Tk
                            </div><!-- End .product-price -->

                            <div class="product-content">
                                {!!$item->description!!}
                            </div><!-- End .product-content -->

                          

                            <div class="product-details-footer">
                                @if ($item->category_id)
                                    <div class="product-cat">
                                        <span>Category:</span>
                                        <?php 
                                            $category = DB::table('product_categories') 
                                                ->where('id', $item->category_id)
                                                ->first(); 
                                        ?>
                                       {{$category->name}}
                                    </div>
                                @endif
                              
                            </div><!-- End .product-details-footer -->

                        </div>
                        </div><!-- End .product-details -->
                    </div><!-- End .col-md-6 -->
                </div><!-- End .row -->
            </div><!-- End .product-details-top -->

              
                
            
                
            </div>
        </div>
              
        </div><!-- End .container -->
    </div><!-- End .page-content -->
</main>

@endsection