@php 
use App\Models\Setting;
$settings = Setting::where('client_id', session('user.client_id'))->first(); 
@endphp
@extends('admin.master')
@section('main_content')    
<style>
  span.select2-selection.select2-selection--multiple {
      height: 40px;
      border-color: #cccfd2!important;
  }
  .select2-container.select2-container--focus .select2-selection, .select2-container .select2-selection[aria-expanded="true"] {
      border-color: #cccfd2!important;
      height: 40px!important;
      width: 100%!important;
      font-size: 16px!important;
      padding-top: 0px!important;
  } 
  </style>

  <div class="page-content container container-plus">
    <div class="page-header pb-2">
      <h1 class="page-title text-primary-d2 text-150">
        Update Service     
      </h1> 
      <a href="products"class="btn btn-default px-3 text-95 radius-round border-2 brc-black-tp10 float-left">
        <i class="fa fa-plus mr-1"></i>
        <span class="d-sm-none d-md-inline">All</span> Services
      </a>
    </div>   


    <div class="row mt-3">
      <div class="col-12">
        <div class="card dcard">
          <div class="card-body px-1 px-md-3">                                   
            <div role="main" class="main-content">         
              <div class="page-content container container-plus">               

                <form action="update_product" method="post" enctype="multipart/form-data">
                  @csrf
                  <div class="form-group">
                    <label for="">Service Title<span>*</span></label>
                    <input type="text" name="name"  class="form-control" required aria-describedby="emailHelp" value="{{$data->name}}">
                  </div>          
                  <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Price<span>*</span></label>
                          <input type="text" name="price" required class="form-control" id="" aria-describedby="emailHelp" value="{{$data->price}}">
                        </div>    
                      </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="">Measurement Unit</label>                        
                        <select class="form-control" name="measurement_unit" id="">
                          <option value="{{$data->measurement_unit}}">{{$data->measurement_unit}}</option>  
                          @php                  
                          $mu = DB::table('data_lookups')
                              ->where('data_type','Measurement Unit')
                              ->orderBy('title','asc')
                              ->get(); 
                          @endphp   
                          @foreach ($mu as $item)
                              <option value="{{$item->title}}">{{$item->title}}</option>
                          @endforeach
                          <option value="No">No</option>
                          <option value="Each">Each</option>                         
                          <option value="Per">Per</option>                         
                          <option value="LS">LS</option>  
                          <option value="N/A">N/A</option>                             
                        </select>  
                          
                      </select>     
                      </div>    
                    </div>
                  
                  </div>


                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="">Category</label>
                        <select class="form-control" name="category_id" id="category_id">
                          <option value="{{$data->category_id}}">{{$data->catName}}</option>
                          <?php                         
                            $categories=DB::table('product_categories')->where('parent_id', null)->orderBy('name','asc')->get();
                          ?>
                          @foreach($categories as $category) 
                            <option value="{{$category->id}}">{{$category->name}}</option>
                          @endforeach  
                        </select>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">                                
                        <label for="">Sub Category</label>
                        <select class="form-control" name="sub_category_id" id="sub_category_id" >

                          @if ($data->sub_category_id != null)
                          <?php                         
                            $sub_category = DB::table('product_categories')->where('id', $data->sub_category_id)->first();
                          ?>
                            <option value="{{$sub_category->id}}">{{$sub_category->name}}</option>
                          @endif            
                          
                        </select>
                      </div>
                    </div>
                  
                  </div>
                

                                 <div class="form-group">
                    <label for="">Service Description</label>
                    <textarea id="summernote" name="description" rows="25">{{$data->description}}</textarea>  
                  </div>

                  <div class="form-group d-none">
                    <label for="">Short Description</label>
                    <textarea name="short_description"  class="form-control"  rows="10">{{$data->short_description}}</textarea>  
                  </div>
                  <div class="d-none form-group">
                    <label for="">Meta Description</label>
                    <textarea name="meta_description"  class="form-control"  rows="3">{{$data->meta_description}}</textarea>  
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

                  <hr>
                  

                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">                    
                        <label class="form-check-label" for="exampleCheck1">
                         Active
                        </label>
                        <input type="checkbox" name="active" @if($data->active == 'on') checked
                        @endif class="form-check-input" id="exampleCheck1">
                      </div>
                    </div>
                  

                    <div class="d-none col-md-3">
                      <div class="form-group">                    
                        <label class="form-check-label" for="">
                         Featured
                        </label> 
                        <input type="checkbox" name="featured" @if($data->featured == 'on') checked
                        @endif class="form-check-input" id="">
                      </div>
                    </div>

                  </div>                
                 

                  <br>
                  <input type="hidden" name="id" value="{{$data->id}}">
                  <button type="submit" class="btn btn-primary">Update</button>
                  <a href="{{URL::to('products')}}" class="btn btn-default">Cancel</a>
                </form>
                
             </div>
            </div>
          </div>
        </div>           
      </div>
    </div>

  </div>
 
@endsection