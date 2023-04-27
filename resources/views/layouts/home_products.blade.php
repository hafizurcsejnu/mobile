<div class="owl-item active" style="width: 260.01px; margin-right: 20px;">

    <div class="product product-2">
        <figure class="product-media">  

            <?php if($item->thumbnail != null ){?>
                <a href="{{URL::to('product')}}/{{$item->slug}}">
                    <img src="{{ URL::asset('storage/app/public/'.$item->thumbnail.'') }}" alt="" class="product-image">
                </a>
            <?php }elseif($item->images!=null) { $images = explode('|', $item->images);?>
            <a href="{{URL::to('product')}}/{{$item->slug}}">
                <img src="{{asset('images')}}/{{$images[0]}}" alt="{{$images[0]}}" class="product-image">
            </a>
            <?php } else{?>
                <a href="{{URL::to('product')}}/{{$item->slug}}">
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
            
                <a href="{{URL::to('quick-view')}}/{{$item->id}}" class="btn-product btn-quickview" title="Quick view"><span>quick view</span></a>
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