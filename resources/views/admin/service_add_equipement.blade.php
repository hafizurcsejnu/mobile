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

.note-editable{
  height: 200px!important;
}
</style>

  <div class="page-content container container-plus">
    <div class="page-header pb-2">
      <h1 class="page-title text-primary-d2 text-150">
        Add New Equipement   
      </h1> 
      <a href="services"class="btn btn-default px-3 text-95 radius-round border-2 brc-black-tp10 float-left">
        <i class="fa fa-plus mr-1"></i>
        <span class="d-sm-none d-md-inline">All</span> Equipements
      </a>
    </div>   


    <div class="row mt-3">
      <div class="col-12">
        <div class="card dcard">
          <div class="card-body px-1 px-md-3">                                   
            <div role="main" class="main-content">         
              <div class="page-content container container-plus">               

                <form method="POST"  action="{{route('save_product')}}" enctype="multipart/form-data">
                  @csrf              

                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="">Equipement Title<span>*</span></label>
                        <input type="text" name="name" class="form-control" id="" required  placeholder="Enter Equipement Title or Ex No">
                      </div>     
                    </div> 
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="">Point <span></span></label>
                        <input type="text" name="code" class="form-control" id=""  placeholder="Enter Point">
                      </div>     
                    </div> 
                  </div> 
                  
                  <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Duty Rate<span>*</span></label>
                          <input type="text" name="price" required class="form-control" required="true" > 
                        </div>    
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="">Measurement Unit</label>                       
                        <select class="form-control select2-single" name="measurement_unit" id="">
                            @if($last_item != null)
                            <option value="{{$last_item->measurement_unit}}">{{$last_item->measurement_unit}}</option> 
                            @endif                             
                            @php                  
                            $mu = DB::table('data_lookups')
                                ->where('data_type','Measurement Unit')
                                ->where('client_id', session('client_id'))
                                ->orderBy('title','asc')
                                ->get(); 
                            @endphp   
                            @foreach ($mu as $item)
                                <option value="{{$item->title}}">{{$item->title}}</option>
                            @endforeach
                                         
                        </select>     
                      </div>    
                    </div>    
                  </div>


                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="exampleInputPassword1">Category</label>
                        <select class="form-control select2-single" name="category_id" id="category_id">
                            @if($last_item != null)
                            <?php 
                             $category=DB::table('product_categories')
                                ->where('id', $last_item->category_id)
                                ->first();              
                            ?>
                            <option value="{{$category->id}}">{{$category->name}}</option>
                            @endif

                            <?php                            
                             $categories=DB::table('product_categories')->where('parent_id', null)
                             ->where('client_id', session('client_id'))->orderBy('name','asc')->get();?>
                            @foreach($categories as $category) 
                            <option value="">Select category</option>
                            <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach  
                        </select>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">     
                      <label for="exampleInputPassword1">Sub Category</label>                       
                        <select class="form-control ss" name="sub_category_id" id="sub_category_id" >
                        @if($last_item != null && $last_item->sub_category_id)
                          <?php                            
                             $category=DB::table('product_categories')->where('id', $last_item->sub_category_id)->first();
                             //dd($category); 
                            ?>
                            <option value="{{$category->id}}">{{$category->name}}</option>
                        @endif
                          
                        </select>
                      </div>
                    </div>
                  </div>                 

                  <div class="row">
                    <div class="d-none col-md-4">
                      <div class="form-group">
                        <label for="">Usage</label>    
                        <select class="select2-multiple" name="usages[]" multiple="multiple" style="width: 100%">
                          <?php                            
                            $collection=DB::table('data_lookups')
                               ->where('data_type','Usage')
                               ->orderBy('title','asc')
                               ->get();                                
                            ?>
                            @foreach ($collection as $item)
                              <option value="{{$item->title}}">{{$item->title}}</option>
                            @endforeach
                            <option value="N/A">N/A</option>
                        </select>
                      </div>
                    </div>
                 
                    <div class="d-none col-md-4">
                      <div class="form-group">
                        <label for="">Materials</label>    
                        <select class="select2-multiple" name="materials[]" multiple="multiple" style="width: 100%">
                          <?php                            
                            $collection=DB::table('data_lookups')
                               ->where('data_type','Materials')
                               ->orderBy('title','asc')
                               ->get();                                
                            ?>
                            @foreach ($collection as $item)
                              <option value="{{$item->title}}">{{$item->title}}</option>
                            @endforeach
                            <option value="N/A">N/A</option>
                        </select>
                      </div>
                    </div>

                    <div class="d-none col-md-4">
                      <div class="form-group">
                        <label for="">Hidden</label>    
                        <select class="select2-multiple" name="hidden_data[]" multiple="multiple" style="width: 100%">
                            @php
                              $collection=DB::table('data_lookups')
                                ->where('data_type','Hidden')
                                ->orderBy('title','asc')
                                ->get();  
                            @endphp                     
                           
                            @foreach ($collection as $item)
                              <option value="{{$item->title}}">{{$item->title}}</option>
                            @endforeach
                            <option value="N/A">N/A</option>
                        </select>
                      </div>
                    </div>

                  </div>           

               
                  <div class="form-group">
                    <label for="">Description</label>
                    <textarea id="summernote" name="description" rows="25">
                    Model: <br>
                    Serial No: <br>
                    Engine Model No: <br>
                    Air Filter No: <br>
                    Mobile Filter No: <br>
                    Diesel Filter No: <br>
                    Hydraulic Filter No: <br>
                    Chain Bush Filter No: <br>
                    </textarea>   
                   
                  </div>                 


                  <div class="form-group d-none">
                    <label for="">Short Description</label>
                    <textarea name="short_description" class="form-control" rows="10"></textarea>  
                  </div>
                  <div class="d-none form-group">
                    <label for="">Meta Description</label>
                    <textarea name="meta_description" class="form-control" rows="3">@if($last_item != null){{$last_item->meta_description}}@endif</textarea>  
                  </div>     
                
                  
                  <div class="form-group">
                    <label for="">Image: </label> <br>
                    <img id="uploadPreview" style="width: 100px; height: 100px; display:none" />
                    <input id="uploadImage"  type="file" name="thumbnail" onchange="PreviewImage();" />
                  </div>

               
                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">                    
                        <label class="form-check-label" for="">
                         Active
                        </label>
                        <input type="checkbox" name="active" checked class="form-check-input" id="">
                      </div>  
                    </div>                  
                 
                    <div class="d-none col-md-3">
                      <div class="form-group">                    
                        <label class="form-check-label" for="">
                         Featured
                        </label>
                        <input type="checkbox" name="featured" class="form-check-input" id="">
                      </div>
                    </div>
                  </div>
                  
                  <br>
                  <input type="hidden" name="product_type" value="Service">
                  <input type="hidden" name="service_type" value="Equipement">
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

      var input_file = $("#source");
      input_file.on("change", function () {
          var files = input_file.prop("files")
          var names = $.map(files, function (val) { return val.name; });
          //console.log(names);
          $.each(names, function (i, name) {
                //console.log(name);               
          });

          var separator = '|';
          implodedArray = names.join(separator);  
          //console.log(implodedArray);
          $("#source_files").val(implodedArray);

      });
     
     
      // var files = $('#source').prop("file");
      // var names = $.map(files, function(val) { return val.name; });
      console.log('names');

    });
    </script>

 
@endsection