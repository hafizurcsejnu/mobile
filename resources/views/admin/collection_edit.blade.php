
@extends('admin.master')
@section('main_content')    

  <div class="page-content container container-plus">
    <div class="page-header pb-2">
      <h1 class="page-title text-primary-d2 text-150">
        Update collection     
      </h1> 
      <a href="all-collections"class="btn btn-default px-3 text-95 radius-round border-2 brc-black-tp10 float-left">
        <i class="fa fa-plus mr-1"></i>
        <span class="d-sm-none d-md-inline">All</span> collection
      </a>
    </div>    


    <div class="row mt-3">
      <div class="col-12">
        <div class="card dcard">
          <div class="card-body px-1 px-md-3">                                   
            <div role="main" class="main-content">         
              <div class="page-content container container-plus">               

                <form action="update_collection" method="post" enctype="multipart/form-data">
                  @csrf                
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="">Collection Title</label>
                        <input type="text" name="name"  class="form-control" id="" aria-describedby="emailHelp" value="{{$data->name}}">
                      </div>  
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="">Total Price</label>
                        <input type="text" name="price" class="form-control" id=""  value="{{$data->price}}">
                      </div>  
                    </div>
                  </div>
                     

                  <div class="form-group">
                    <label for="">Description</label>
                    <textarea id="summernote" name="description" rows="25">{{$data->description}}</textarea>  
                  </div>

                  <div class="form-group d-none">
                    <label for="">Short Description</label>
                    <textarea name="short_description"  class="form-control"  rows="10">{{$data->short_description}}</textarea>  
                  </div>
                  <div class="form-group">
                    <label for="">Meta Description</label>
                    <textarea name="meta_description"  class="form-control"  rows="3">{{$data->meta_description}}</textarea>  
                  </div>

                  <div class="form-group">  
                    <label for="">Collection images: </label>
                    <input type="hidden" name="hidden_image" value="{{$data->images}}">
                    <input type="hidden" name="id" value="{{$data->id}}">

                    <div class="uloaded_images" style="border: 1px solid #ddd;">
                    <?php                        
                      if($images = $data->images){
                        $images = explode('|', $images);
                      }
                        ?>                      
                    </div>

                      <div class="input-images-1" style="padding-top: .5rem;"></div>                     
                        <input type="hidden" id="images" name="excludeImages" value="" multiple/>
                      <div id="drag-drop-area"></div>
     
                  </div>

                  <div class="form-group">
                    <label for="">Thumbnail: </label> <br>
                    
                    @if ($data->thumbnail != null)
                      <img src="{{ URL::asset('storage/app/public/'.$data->thumbnail.'') }}" style="width: 100px; height: 100px;">
                    @else 
                      <img src="{{ URL::asset('storage/app/public/noimage.png') }}" id="noimage"style="width: 100px; height: 100px;">
                    @endif 

                    <img id="uploadPreview" style="width: 100px; height: 100px; display:none" />
                    <input id="uploadImage"  type="file" name="thumbnail" onchange="PreviewImage();" />
                    <input type="hidden" name="hidden_thumbnail" value="{{ $data->thumbnail }}">
                  </div>


                  <div class="form-group">
                    <label for="">Add Products: </label>                                         
                        <div class="form-group">

                          <?php                     
                            if($product_ids = $data->product_ids){
                                $product_ids = explode(',', $product_ids);
                                foreach($product_ids as $item){?> 
                                    <input type="checkbox" name="product_id[]" checked value="{{$item}}"> 
                                    <?php 
                                     $product = DB::table('products')
                                    ->where('id', $item)
                                    ->first();
                                    ?>                                    
                                    {{$product->name}} ({{$product->price}} TK)<br>

                            <?php } 
                            }?>

                           <div class="products">
                           </div>
                        <input type="text" list="products" name="product_name" placeholder="Select products" class="form-control mt-1" id="product_id">
                        <button type="button" class="btn btn-default mt-1" id="add_product">Add</button>
                        <datalist id="products">
                            <?php 
                                $collection = DB::table('products')->get();
                            ?> 
                           @foreach ($collection as $item)                  
                            <option value="{{$item->name}}"> Price: {{$item->price}}
                            @endforeach
                        </datalist>
                      </div>    
                  </div>
                  <hr>



              

                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-check">                    
                        <label class="form-check-label" for="exampleCheck1">
                         Active
                        </label>
                        <input type="checkbox" name="active" @if($data->active == 'on') checked
                        @endif class="form-check-input" id="exampleCheck1">
                      </div>
                    </div>
                    <div class="d-none col-md-6">
                      <div class="form-check">                    
                        <label class="form-check-label" for="exampleCheck1">
                         Featured
                        </label>
                        <input type="checkbox" name="active" @if($data->featured == 'on') checked
                        @endif class="form-check-input" id="exampleCheck1">
                      </div>
                    </div>
                  </div>                 
                 

                  <br>
                  <button type="submit" class="btn btn-primary">Update</button>
                  <a href="{{URL::to('all-collections')}}" class="btn btn-default">Cancel</a> 
                </form>
                
             </div>
            </div>
          </div>
        </div>           
      </div>
    </div>

  </div>
 

  <script>
    $(document).ready(function() {
      let preloaded = new Array();
        <?php foreach($images as $key => $val){ ?>
            preloaded.push({id:'<?php echo $key; ?>',src:'<?php echo asset('images')."/".$val; ?>'});
        <?php } ?>
          console.log(preloaded);
        $('.input-images-1').imageUploader({
            preloaded: preloaded,
            imagesInputName: 'photos',
            preloadedInputName: 'old'
        }); 
       
       
        $("#add_product").click(function(){
          var product_name = $("#product_id").val();
          $.ajax({
            url: "find_product_id",
            data: {
              _token: '{{csrf_token()}}',
              product_name: product_name
            },
            type: 'POST',
            success: function (response) {
                //console.log(response.data);
                if(response.total>0){
                    $('#product_id').empty();
                    $('#product_id').focus;                   
                    $.each(response.data, function(key, value){
                        $('.products').append('<input type="checkbox" name="product_id[]" checked value="'+ value.id +'">'+ value.name+'<br>');
                        $('#product_id').val('');
                    });
                  }else{
                    $('#sub_category_id').empty();
                  }
            }
          });
        });
    });
    </script>

@endsection