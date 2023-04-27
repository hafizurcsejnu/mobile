
            <div class="sidebar-filter-overlay"></div><!-- End .sidebar-filter-overlay -->
            <aside class="sidebar-shop sidebar-filter">
                <div class="sidebar-filter-wrapper">
                    <form action="" method="post" id="filter_form">
                        <div class="widget widget-clean">
                            <label class="close-filter"><i class="icon-close"></i>Filters</label>
                            <a href="#" class="sidebar-filter-clear">Clean All</a>
                        </div><!-- End .widget -->
                        <div class="d-none widget widget-collapsible">
                            <h3 class="widget-title">
                                <a data-toggle="collapse" href="#widget-1" role="button" aria-expanded="true" aria-controls="widget-1">
                                    Category
                                </a>
                            </h3><!-- End .widget-title -->

                            <div class="collapse show" id="widget-1">
                                <div class="widget-body">
                                    <div class="filter-items filter-items-count">
                                        <div class="filter-item">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="cat" value="cat1" id="cat-1">
                                                <label class="custom-control-label" for="cat-1">Dresses</label>
                                            </div><!-- End .custom-checkbox -->
                                            <span class="item-count">3</span>
                                        </div><!-- End .filter-item -->

                                        <div class="filter-item">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="cat" value="cat1" id="cat-2">
                                                <label class="custom-control-label" for="cat-2">T-shirts</label>
                                            </div><!-- End .custom-checkbox -->
                                            <span class="item-count">0</span>
                                        </div><!-- End .filter-item -->

                                        <div class="filter-item">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="cat" value="cat1" id="cat-3">
                                                <label class="custom-control-label" for="cat-3">Bags</label>
                                            </div><!-- End .custom-checkbox -->
                                            <span class="item-count">4</span>
                                        </div><!-- End .filter-item -->

                                        <div class="filter-item">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="cat" value="cat1" id="cat-4">
                                                <label class="custom-control-label" for="cat-4">Jackets</label>
                                            </div><!-- End .custom-checkbox -->
                                            <span class="item-count">2</span>
                                        </div><!-- End .filter-item -->

                                        <div class="filter-item">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="cat" value="cat1" id="cat-5">
                                                <label class="custom-control-label" for="cat-5">Shoes</label>
                                            </div><!-- End .custom-checkbox -->
                                            <span class="item-count">2</span>
                                        </div><!-- End .filter-item -->

                                        <div class="filter-item">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="cat" value="cat1" id="cat-6">
                                                <label class="custom-control-label" for="cat-6">Jumpers</label>
                                            </div><!-- End .custom-checkbox -->
                                            <span class="item-count">1</span>
                                        </div><!-- End .filter-item -->

                                        <div class="filter-item">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="cat" value="cat1" id="cat-7">
                                                <label class="custom-control-label" for="cat-7">Jeans</label>
                                            </div><!-- End .custom-checkbox -->
                                            <span class="item-count">1</span>
                                        </div><!-- End .filter-item -->

                                        <div class="filter-item">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="cat" value="cat1" id="cat-8">
                                                <label class="custom-control-label" for="cat-8">Sportwear</label>
                                            </div><!-- End .custom-checkbox -->
                                            <span class="item-count">0</span>
                                        </div><!-- End .filter-item -->
                                    </div><!-- End .filter-items -->
                                </div><!-- End .widget-body -->
                            </div><!-- End .collapse -->
                        </div><!-- End .widget -->

                     
                        <div class="d-none widget widget-collapsible">
                            <h3 class="widget-title">
                                <a data-toggle="collapse" href="#widget-3" role="button" aria-expanded="true" aria-controls="widget-3">
                                    Colour
                                </a>
                            </h3><!-- End .widget-title -->

                            <div class="collapse show" id="widget-3">
                                <div class="widget-body">
                                    <div class="filter-colors">
                                        <a href="#" style="background: #b87145;"><span class="sr-only">Color Name</span></a>
                                        <a href="#" style="background: #f0c04a;"><span class="sr-only">Color Name</span></a>
                                        <a href="#" style="background: #333333;"><span class="sr-only">Color Name</span></a>
                                        <a href="#" class="selected" style="background: #cc3333;"><span class="sr-only">Color Name</span></a>
                                        <a href="#" style="background: #3399cc;"><span class="sr-only">Color Name</span></a>
                                        <a href="#" style="background: #669933;"><span class="sr-only">Color Name</span></a>
                                        <a href="#" style="background: #f2719c;"><span class="sr-only">Color Name</span></a>
                                        <a href="#" style="background: #ebebeb;"><span class="sr-only">Color Name</span></a>
                                    </div><!-- End .filter-colors -->
                                </div><!-- End .widget-body -->
                            </div><!-- End .collapse -->
                        </div><!-- End .widget -->                     


                        <div class="widget widget-collapsible">
                            <h3 class="widget-title">
                                <a data-toggle="collapse" href="#widget-5" role="button" aria-expanded="true" aria-controls="widget-5">
                                    @php $collection = \App\Models\DataLookup::where('data_type','Materials')->get();  @endphp
                                    Materials ({{count($collection)}})
                                    
                                </a>
                            </h3><!-- End .widget-title -->

                            <div class="collapse hide" id="widget-5">
                                <div class="widget-body">
                                    <div class="filter-items">

                                        @php $collection = \App\Models\DataLookup::where('data_type','Materials')->get();  @endphp
                                        @foreach($collection as $item)
                                        <div class="filter-item">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="materials[]" value="{{$item->title}}" id="materials-{{$item->id}}">
                                                <label class="custom-control-label" for="materials-{{$item->id}}">{{$item->title}}</label>
                                            </div>
                                        </div>
                                        @endforeach

                                    </div><!-- End .filter-items -->
                                </div><!-- End .widget-body -->
                            </div><!-- End .collapse -->
                        </div><!-- End .widget -->

                        <div class="widget widget-collapsible">
                            <h3 class="widget-title">
                                <a data-toggle="collapse" href="#widget-4" role="button" aria-expanded="true" aria-controls="widget-4">
                                    @php $collection = \App\Models\DataLookup::where('data_type','Brand')->get();  @endphp
                                    Brand ({{count($collection)}})
                                </a>
                            </h3><!-- End .widget-title -->

                            <div class="collapse hide" id="widget-4">
                                <div class="widget-body">
                                    <div class="filter-items">

                                        @php $collection = \App\Models\DataLookup::where('data_type','Brand')->get();  @endphp
                                        @foreach($collection as $item)
                                        <div class="filter-item">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="brand[]" value="{{$item->title}}" id="brand-{{$item->id}}">
                                                <label class="custom-control-label" for="brand-{{$item->id}}">{{$item->title}}</label>
                                            </div>
                                        </div>
                                        @endforeach

                                    </div><!-- End .filter-items -->
                                </div><!-- End .widget-body -->
                            </div><!-- End .collapse -->
                        </div><!-- End .widget -->

                      
                        <div class="widget widget-collapsible">
                            <h3 class="widget-title">
                                <a data-toggle="collapse" href="#widget-6" role="button" aria-expanded="true" aria-controls="widget-6">
                                    @php $collection = \App\Models\DataLookup::where('data_type','Style')->get();  @endphp
                                    Style ({{count($collection)}})
                                </a>
                            </h3>

                            <div class="collapse hide" id="widget-6">
                                <div class="widget-body">
                                    <div class="filter-items">

                                        @php $collection = \App\Models\DataLookup::where('data_type','Style')->get();  @endphp
                                        @foreach($collection as $item)
                                        <div class="filter-item">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="style[]" value="{{$item->title}}" id="style-{{$item->id}}">
                                                <label class="custom-control-label" for="style-{{$item->id}}">{{$item->title}}</label>
                                            </div>
                                        </div>
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                        </div><!-- End .widget -->

                        <div class="widget widget-collapsible" style="border-bottom: .1rem solid #fff;">
                            <h3 class="widget-title">
                                <a data-toggle="collapse" href="#widget-7" role="button" aria-expanded="true" aria-controls="widget-7">
                                    @php $collection = \App\Models\DataLookup::where('data_type','Usage')->get();  @endphp
                                    Usages ({{count($collection)}})
                                </a>
                            </h3>

                            <div class="collapse hide" id="widget-7">
                                <div class="widget-body">
                                    <div class="filter-items">

                                        @php $collection = \App\Models\DataLookup::where('data_type','Usage')->get();  @endphp
                                        @foreach($collection as $item)
                                        <div class="filter-item" style="width: 50%; float: left;">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="usages[]" value="{{$item->title}}" id="usages-{{$item->id}}">
                                                <label class="custom-control-label" for="usages-{{$item->id}}">{{$item->title}}</label>
                                            </div>
                                        </div>
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                        </div><!-- End .widget -->
                        

                        {{-- <div class="widget widget-collapsible">
                            <h3 class="widget-title">
                                <a data-toggle="collapse" href="#widget-5" role="button" aria-expanded="true" aria-controls="widget-5">
                                    Price
                                </a>
                            </h3><!-- End .widget-title -->

                            <div class="collapse show" id="widget-5">
                                <div class="widget-body">
                                    <div class="filter-price">
                                        <div class="filter-price-text">
                                            Price Range:
                                            <span id="filter-price-range">$0 - $750</span>
                                        </div><!-- End .filter-price-text -->

                                        <div id="price-slider" class="noUi-target noUi-ltr noUi-horizontal"><div class="noUi-base"><div class="noUi-connects"><div class="noUi-connect" style="transform: translate(0%, 0px) scale(0.75, 1);"></div></div><div class="noUi-origin" style="transform: translate(-100%, 0px); z-index: 5;"><div class="noUi-handle noUi-handle-lower" data-handle="0" tabindex="0" role="slider" aria-orientation="horizontal" aria-valuemin="0.0" aria-valuemax="550.0" aria-valuenow="0.0" aria-valuetext="$0"><div class="noUi-touch-area"></div><div class="noUi-tooltip">$0</div></div></div><div class="noUi-origin" style="transform: translate(-25%, 0px); z-index: 4;"><div class="noUi-handle noUi-handle-upper" data-handle="1" tabindex="0" role="slider" aria-orientation="horizontal" aria-valuemin="200.0" aria-valuemax="1000.0" aria-valuenow="750.0" aria-valuetext="$750"><div class="noUi-touch-area"></div><div class="noUi-tooltip">$750</div></div></div></div></div><!-- End #price-slider -->
                                    </div><!-- End .filter-price -->
                                </div><!-- End .widget-body -->
                            </div><!-- End .collapse -->
                        </div><!-- End .widget --> --}}

                        <div>
                            <button type="submit" class="btn btn-outline-primary-2 btn-minwidth-sm w-100">Filter Models</button>
                        </div>
                    </form>
                </div><!-- End .sidebar-filter-wrapper -->
            </aside><!-- End .sidebar-filter -->



@push('js')

    <script>
        $(document).ready(function(){

            // load more function
            $(document).on('click','.btn-load-more',function(){
                var count = $(this).data('count');
                var loaded_item = count;
                var form = $("#filter_form");
                count = count+30;
                var page = count/30;

                $.get('?page='+page,{
                    filter: form.serialize(),
                },function(data, status){
                    var items =  JSON.parse(data.items);
                    console.log(items);
                    if (!Array.isArray(items)) {
                        items = items.data;
                    } 
                    var data_status = jQuery.isEmptyObject(items);
                    
                    if(!data_status){
                        items.forEach(element => {
                            loaded_item = loaded_item+1;
                            var html = '<div class="col-6 col-md-4 col-lg-4 col-xl-3"> <div class="product"> <figure class="product-media"> <span class="product-label label-new">:product_status</span> <a href=":product_url"> <img src=":image_src" alt=":image_name" class="product-image"> </a> <div class="product-action action-icon-top"> <a href="javascript:void(0)" class="btn-product btn-cart add-to-cart " data-id=":id"><span class="add-to-cart-btn">Add to cart</span></a> <a href=":quick_view_url" class="btn-product btn-quickview" title="Quick view"><span>quick view</span></a> </div> </figure> <div class="product-body"> <div class="product-cat"> <a href="#">:cat_name</a> </div> <h3 class="product-title"><a href=":product_url">:name</a></h3> <div class="product-price"> $:price </div> <div class="ratings-container"> <div class="ratings"> <div class="ratings-val" style="width: 0%;"></div> </div> <span class="ratings-text">( 0 Reviews )</span> </div> </div></div></div>';
                            // time difference 
                            var start_date= new Date(element.created_at);
                            var end_date= new Date();
                            var diff = end_date-start_date;
                            var days = Math.round(diff/(1000 * 3600 * 24));
                            
                            // image
                            var images = element.images.split('|');
                            var image_src = "{{asset('images')}}/"+images[0];


                            // product url 
                            var quick_view_url = "{{URL::to('quick-view')}}/"+element.id;
                            var product_url = "product/"+element.id;

                            // append data to html template
                            html = html.replace(":id",element.id);
                            html = html.replace(":name",element.name);
                            html = html.replace(":image_src",image_src);
                            html = html.replace(":image_name",images[0]);
                            html = html.replace(":quick_view_url",quick_view_url);
                            html = html.replace(":product_url",product_url);
                            html = html.replace(":price",element.price);
                            if(element.sub_category!=null){
                                html = html.replace(":cat_name",element.sub_category.name);
                            }else if(element.category!=null){
                                html = html.replace(":cat_name",element.category.name);
                            }else{
                                html = html.replace(":cat_name","");
                            }
                            if(days<7){
                                html = html.replace(":product_status",element.id);
                            }
                            else{
                                html = html.replace(":product_status","");
                            }


                            $('.products .row').append(html);
                        });
                        $('.btn-load-more').data('count',count);
                        $('#show_count').html(loaded_item);
                    }else{

                        $('.btn-load-more').css('display',"none");

                        $('#status').html("No More Models Available");
                    }
                });

            });

            // submit filter_form
            $(document).on('submit','#filter_form',function(e){
                e.preventDefault(); 
                var form = $(this);
                var loaded_item = 0;
                url = "{{url()->current()}}";
                
                $.get(url,{
                    filter: form.serialize(),
                },function(response){
                    var items =  JSON.parse(response.items);
                    if (!Array.isArray(items)) {
                        items = items.data;
                    } 
                    var data_status = jQuery.isEmptyObject(items);
                    if(!data_status){
                        var all_html = "";
                        items.forEach(element => {
                            if(response.total<30){ 
                                loaded_item = response.total;
                            } 
                            else{
                                loaded_item = loaded_item+1;
                            }
                            var html = '<div class="col-6 col-md-4 col-lg-4 col-xl-3"> <div class="product"> <figure class="product-media"> <span class="product-label label-new">:product_status</span> <a href=":product_url"> <img src=":image_src" alt=":image_name" class="product-image"> </a> <div class="product-action action-icon-top"> <a href="javascript:void(0)" class="btn-product btn-cart add-to-cart " data-id=":id"><span class="add-to-cart-btn">Add to cart</span></a> <a href=":quick_view_url" class="btn-product btn-quickview" title="Quick view"><span>quick view</span></a> </div> </figure> <div class="product-body"> <div class="product-cat"> <a href="#">:cat_name</a> </div> <h3 class="product-title"><a href=":product_url">:name</a></h3> <div class="product-price"> $:price </div> <div class="ratings-container"> <div class="ratings"> <div class="ratings-val" style="width: 0%;"></div> </div> <span class="ratings-text">( 0 Reviews )</span> </div> </div></div></div>';
                            // time difference 
                            var start_date= new Date(element.created_at);
                            var end_date= new Date();
                            var diff = end_date-start_date;
                            var days = Math.round(diff/(1000 * 3600 * 24));
                            
                            // image
                            var images = element.images.split('|');
                            var image_src = "{{asset('images')}}/"+images[0];


                            // product url 
                            var quick_view_url = "{{URL::to('quick-view')}}/"+element.id;
                            var product_url = "product/"+element.id;

                            // append data to html template
                            html = html.replace(":id",element.id);
                            html = html.replace(":name",element.name);
                            html = html.replace(":image_src",image_src);
                            html = html.replace(":image_name",images[0]);
                            html = html.replace(":quick_view_url",quick_view_url);
                            html = html.replace(":product_url",product_url);
                            html = html.replace(":price",element.price);
                            if(element.sub_category!=null){
                                html = html.replace(":cat_name",element.sub_category.name);
                            }else if(element.category!=null){
                                html = html.replace(":cat_name",element.category.name);
                            }else{
                                html = html.replace(":cat_name","");
                            }
                            if(days<7){
                                html = html.replace(":product_status",element.id);
                            }
                            else{
                                html = html.replace(":product_status","");
                            }


                            $('.close-filter').click();
                            all_html = all_html+html;
                        });
                        // $('.btn-load-more').data('count',count);
                        $('.products .row').html(all_html);
                        $("#show_count").html(loaded_item);
                        $("#total").html(response.total);
                        
                    }else{
                        $("#show_count").html("0");
                        $("#total").html("0");
                        $('.products .row').html("");
                        $('.btn-load-more').css('display',"none");
                        $('#status').html("No More Products Available");
                    }
                    var response_form_data = response.form_data;
                    if(response_form_data.hasOwnProperty('materials')){
                        $("#materials").html("Materials");
                        var list = "";
                        response.form_data.materials.forEach(element=>{
                            list = list+"<span>"+element+"</span>";
                        })
                        $("#materials-list").html(list);
                    }
                    if(response_form_data.hasOwnProperty('brand')){
                        $("#brand").html("Brand");
                        var list = "";
                        response.form_data.brand.forEach(element=>{
                            list = list+"<span>"+element+"</span>";
                        })
                        $("#brand-list").html(list);
                    }
                    if(response_form_data.hasOwnProperty('style')){
                        $("#style").html("Style");
                        var list = "";
                        response.form_data.style.forEach(element=>{
                            list = list+"<span>"+element+"</span>";
                        })
                        $("#style-list").html(list);
                    }
                    if(response_form_data.hasOwnProperty('usages')){
                        $("#usages").html("Usages");
                        var list = "";
                        response.form_data.usages.forEach(element=>{
                            list = list+"<span>"+element+"</span>";
                        })
                        $("#usages-list").html(list);
                    }
                    $('.filter-data-list').slideDown(1000);

                });
            });
            $(document).on('click','.close-filter',function(){
                $('.sidebar-toggler').click();
            });
        });
    </script>

@endpush