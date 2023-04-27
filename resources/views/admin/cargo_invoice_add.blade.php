
@extends('admin.master')
@section('main_content')    

  <div class="page-content container container-plus">
    <div class="page-header pb-2">
      <h1 class="page-title text-primary-d2 text-150">
        Add New Chalan     
      </h1> 
      <a href="cargo-invoices"class="btn btn-default px-3 text-95 radius-round border-2 brc-black-tp10 float-left">
        <i class="fa fa-plus mr-1"></i>
        <span class="d-sm-none d-md-inline">All</span> Chalans
      </a>
    </div>   


    <div class="row mt-3">
      <div class="col-12">
        <div class="card dcard">
          <div class="card-body px-1 px-md-3">                                   
            <div role="main" class="main-content">         
              <div class="page-content container container-plus">               

                <form action="save_cargo_invoice" method="post" enctype="multipart/form-data">
                  @csrf
                  <div class="form-group">
                    <label for="">Chalan Name</label>
                    <input type="text" name="title" class="form-control" id=""  placeholder="Enter name here">
                  </div>                 
                  <div class="form-group">
                    <label for="">Product Name</label>                    
                        <select class="form-control" name="product_id" id="product_id">  
                          <option value="">-- Select Product --</option> 
                            <?php                            
                             $products=DB::table('products')->where('active', 'on')->orderBy('name','asc')->get();?>
                            @foreach($products as $item) 
                            <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach  
                        </select>
                  </div>     

                  <div class="d-none row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="">Category</label>
                        <select class="form-control" name="category_id" id="category_id">  
                            <?php                            
                             $categories=DB::table('product_categories')->where('parent_id', null)->orderBy('name','asc')->get();?>
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
                       
                          
                        </select>
                      </div>
                    </div>
                  
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="">Company Name</label>
                        <select class="form-control" name="company_id" id="">  
                          <option value="">-- Select Company --</option>                       

                            <?php                            
                             $companies=DB::table('companies')->where('active', 'on')->orderBy('title','asc')->get();
                             ?>
                            @foreach($companies as $item) 
                            <option value="{{$item->id}}">{{$item->title}}</option>
                            @endforeach  
                        </select>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">     
                      <label for="">Cargo Name</label>                       
                        <select class="form-control" name="ship_id" id="" >
                          <option value="">-- Select Cargo --</option>
                          <?php                            
                            $ship = DB::table('data_lookups')->where('data_type', 'ship')->orderBy('title','asc')->get();
                          ?>
                          @foreach($ship as $item) 
                          <option value="{{$item->id}}">{{$item->title}}</option>
                          @endforeach  
                          
                        </select>
                      </div>
                    </div>
                  
                  </div>

                  
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="">Arrival Date Time</label>
                        <input type="datetime-local" name="arrival_date_time" class="form-control" id="">
                      </div> 
                    </div>        
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="">Release Date Time</label>
                        <input type="datetime-local" name="release_date_time" class="form-control" id="">
                      </div> 
                    </div>                             
                  </div>

                  <div class="form-group">     
                    <label for="">Select Sordar</label>                       
                      <select class="form-control" name="sordar_id" id="" >
                        <option value="">-- Select Sordar --</option>
                        <?php                            
                          $sordar = DB::table('data_lookups')->where('data_type', 'sordar')->orderBy('title','asc')->get();
                        ?>
                        @foreach($sordar as $item) 
                        <option value="{{$item->id}}">{{$item->title}}</option>
                        @endforeach  
                        
                      </select>
                    </div>                 

                  <div class="form-group">
                    <label for="">Description</label>
                    <textarea id="summernote" name="description" rows="25">
                    </textarea>  
                  </div>
                  <div class="form-group">
                    <label for="">Notes</label>
                    <textarea name="notes" class="form-control" rows="3"></textarea>  
                  </div>                

                  <div class="form-group">
                    <label for="">Image: </label>
                    <img id="uploadPreview" style="width: 200px; height: 150px; display:none" />
                    <input id="uploadImage"  type="file" name="image" onchange="PreviewImage();" />

                    <p class="d-none">NB: Best image resolutions -> [slider: 1200px*500px] [featured: 260px*640px] </p>
                  </div>

                  <div class="form-group">                    
                    <label class="form-check-label" for="exampleCheck1">
                     Active
                    </label>
                    <input type="checkbox" name="active" checked class="form-check-input" id="exampleCheck1">
                  </div>
                  <br>
                  <button type="submit" class="btn btn-primary">Submit</button>
                  <button type="button" class="btn btn-default">Cancel</button>
                </form>
                
             </div>
            </div>
          </div>
        </div>           
      </div>
    </div>

  </div>
 
@endsection