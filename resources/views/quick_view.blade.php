
<div class="container quickView-container">
	<div class="quickView-content">
		<div class="row">
			<div class="col-lg-8 col-md-8">
				<div class="row">
					<div class="product-left">					

						<?php 
						if($images = $item->images) $images = explode('|', $images);
						for ($i=0; $i<count($images) && $i<6; $i++) 
						{ 
						?>
						<a href="#<?php echo $i;?>" class="carousel-dot <?php if($i==0) echo "active";?>">
							<img src="{{asset('images')}}/{{$images[$i]}}">
						</a>
						 <?php } ?>


					</div>
					<div class="product-right">
						<div class="owl-carousel owl-theme owl-nav-inside owl-light mb-0" data-toggle="owl" data-owl-options='{
	                        "dots": false,
	                        "nav": false, 
	                        "URLhashListener": true,
	                        "responsive": {
	                            "900": {
	                                "nav": true,
	                                "dots": true
	                            }
	                        }
	                    }'>
							

							<?php 
						if($images = $item->images) $images = explode('|', $images);
						for ($i=0; $i<count($images) && $i<6; $i++) 
						{ 
						?>
						<div class="intro-slide" data-hash="<?php echo $i;?>">
							<img src="{{asset('images')}}/{{$images[$i]}}" class="product_image" alt="Product Image">
						</div>
						 <?php } ?>

		                </div>
					</div>
                </div>
			</div>
			<div class="col-lg-4 col-md-4">
				<h2 class="product-title"><a href="{{URL::to('product')}}/{{$item->id}}">{{$item->name}}</a></h2>
				<h3 class="product-price">${{$item->price}}</h3>

                <div class="d-none ratings-container">
                    <div class="ratings">
                        <div class="ratings-val" style="width: 80%;"></div>
                    </div>
                    <span class="ratings-text">( 2 Reviews )</span>
                </div>

                <p class="product-txt">{!!$item->description!!}</p>


                {{-- <div class="details-filter-row product-nav product-nav-thumbs">
	                <label for="size">color:</label>
                    <a href="#" class="active">
                        <img src="assets/images/demos/demo-6/products/product-1-thumb.jpg" alt="product desc">
                    </a>
                    <a href="#">
                        <img src="assets/images/demos/demo-6/products/product-1-2-thumb.jpg" alt="product desc">
                    </a>
                </div> 
				

                <div class="details-filter-row details-row-size">
	                <label for="size">Size:</label>
	                <div class="select-custom">
	                    <select name="size" id="size" class="form-control">
	                        <option value="#" selected="selected">Select a size</option>
	                        <option value="s">Small</option>
	                        <option value="m">Medium</option>
	                        <option value="l">Large</option>
	                        <option value="xl">Extra Large</option>
	                    </select>
	                </div>
	            </div>

	            
                <div class="details-filter-row details-row-size">
                    <label for="qty">Qty:</label>
                    <div class="product-details-quantity">
                        <input type="number" id="qty" class="form-control" value="1" min="1" max="10" step="1" data-decimals="0" required>
                    </div>
                </div>
				--}}

                <div class="product-details-action">                   
					<a href="javascript:void(0)" id="atc{{$item->id}}" class="btn-product btn-cart addToCart" data-id="{{$item->id}}"><span>Add to cart</span></a>
                </div>

				<div id="messageQuick"></div>
				<div class="details-action-wrapper">                               
					@if (Session::get('user'))
						<a href="javascript:void(0)"  id="addToWishlist" class="btn-product btn-wishlist addToWishlist" title="Wishlist" data-id="{{$item->id}}"><span>Add to Wishlist</span></a>
					@else
						<a href="{{url('login')}}" id="atw{{$item->id}}" class="btn-product btn-wishlist" title="Wishlist"><span>Add to Wishlist</span></a>
					@endif                                
				</div>


                <div class="product-details-footer">
                    <div class="product-cat">						
						
                       @if ($item->category_id != null)
					    <span>Category:</span>						
						<?php 
							$category = DB::table('product_categories') 
								->where('id', $item->category_id)
								->first(); 
						?>
							<a href="{{URL::to('3dmodels-category')}}/{{$category->slug}}">{{$category->name}}</a>
						@endif
						 
 

                    </div><!-- End .product-cat -->

                    {{-- <div class="social-icons social-icons-sm">
                        <span class="social-label">Share:</span>
                        <a href="#" class="social-icon" title="Facebook" target="_blank"><i class="icon-facebook-f"></i></a>
                        <a href="#" class="social-icon" title="Twitter" target="_blank"><i class="icon-twitter"></i></a>
                        <a href="#" class="social-icon" title="Instagram" target="_blank"><i class="icon-instagram"></i></a>
                        <a href="#" class="social-icon" title="Pinterest" target="_blank"><i class="icon-pinterest"></i></a>
                    </div> --}}
                </div>
			</div>
		</div>
	</div>
</div>
<script src="{{asset('frontend/js/cart.js')}}"></script>

