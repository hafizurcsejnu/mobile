
@extends('admin.master')
@section('main_content')  
<style>
  .progress { position:relative; width:100%; border: 1px solid #7F98B2; padding: 1px; border-radius: 3px; }
  .bar { background-color: #B4F5B4; width:0%; height:25px; border-radius: 3px; }
  .percent { position:absolute; display:inline-block; top:3px; left:48%; color: #7F98B2;}
</style>



  <div class="page-content container container-plus">
    <div class="page-header pb-2">
      <h1 class="page-title text-primary-d2 text-150">
        Add New Collection     
      </h1> 
      <a href="all-collections"class="btn btn-default px-3 text-95 radius-round border-2 brc-black-tp10 float-left">
        <i class="fa fa-plus mr-1"></i>
        <span class="d-sm-none d-md-inline">All</span> Collections
      </a>
    </div>    


    <div class="row mt-3"> 
      <div class="col-12">
        <div class="card dcard">
          <div class="card-body px-1 px-md-3">                                   
            <div role="main" class="main-content">         
              <div class="page-content container container-plus">               

                <form method="POST"  action="{{route('save_collection')}}" enctype="multipart/form-data">
                  @csrf
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="">Collection Title</label>
                        <input type="text" name="name" class="form-control" id=""  placeholder="Enter name">
                      </div>  
                    </div>       

                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="">Total Price</label>
                        <input type="text" name="price" class="form-control" id=""  placeholder="Enter price">
                      </div>   
                    </div>                  
                  </div>

                  <div class="form-group">
                    <label for="">Description</label>
                    <textarea id="summernote" name="description" rows="25"> 
                    <ul>
                      <li>High quality properly scaled model.</li>
                      <li>All models are created with utmost care and attention to detail.</li>
                      <li>High quality easy to manage shaders used.</li>
                      <li>Clean UV Chunks. </li>
                      <li>Centimeter is used as System unit setup.</li>
                      <li>Models are properly named and grouped for easy selection.</li>
                      <li>No additional plugin is required to open the model.</li> 
                    </ul>
                    </textarea>   
                   
                  </div>                 


                  <div class="form-group d-none">
                    <label for="">Short Description</label>
                    <textarea name="short_description" class="form-control" rows="10"></textarea>  
                  </div>
                  <div class="form-group">
                    <label for="">Meta Description</label>
                    <textarea name="meta_description" class="form-control" rows="3">{{$last_item->meta_description}}</textarea>  
                  </div>                  

                  <div class="form-group">
                    <label for="">Product images: </label>
                      <div class="input-images-1" style="padding-top: .5rem;"></div>
                        <input type="hidden" id="images" name="excludeImages" value="" multiple/>
                      <div id="drag-drop-area"></div>    
                      <script>
                        $('.input-images-1').imageUploader();
                      </script>  
                  </div>    
                  
                  <div class="form-group">
                    <label for="">Thumbnail: </label> <br>
                    <img id="uploadPreview" style="width: 100px; height: 100px; display:none" />
                    <input id="uploadImage"  type="file" name="thumbnail" onchange="PreviewImage();" />
                  </div>

                  
                  <div class="form-group">
                    <label for="">Add Products: </label>                                         
                        <div class="form-group">
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
                    <div class="col-md-4">
                      <div class="form-check">                    
                        <label class="form-check-label" for="">
                         Active
                        </label>
                        <input type="checkbox" name="active" checked class="form-check-input" id="">
                      </div>  
                    </div>
                    <div class="d-none col-md-4">
                      <div class="form-check">                    
                        <label class="form-check-label" for="">
                         Featured
                        </label>
                        <input type="checkbox" name="featured" class="form-check-input" id="">
                      </div>
                    </div>
                   
                  </div>
                  
                  <br>
                  <button type="submit" class="btn btn-primary" id="submitBtn">Submit</button>
                  <button type="button" class="btn btn-default">Cancel</button>
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