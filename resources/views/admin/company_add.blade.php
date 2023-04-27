
@extends('admin.master')
@section('main_content')    

  <div class="page-content container container-plus">
    <div class="page-header pb-2">
      <h1 class="page-title text-primary-d2 text-150">
        Add New Company/Brand/Supplier    
      </h1> 
      <a href="companies"class="btn btn-default px-3 text-95 radius-round border-2 brc-black-tp10 float-left">
        <i class="fa fa-plus mr-1"></i>
        <span class="d-sm-none d-md-inline">All</span> Companies
      </a>
    </div>   


    <div class="row mt-3">
      <div class="col-12">
        <div class="card dcard">
          <div class="card-body px-1 px-md-3">                                   
            <div role="main" class="main-content">         
              <div class="page-content container container-plus">               

                <form action="save_company" method="post" enctype="multipart/form-data">
                  @csrf
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="">Company Name</label>
                        <input type="text" name="title" class="form-control" id=""  placeholder="Enter name here">
                      </div>  
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="">Type</label>
                        <select class="form-control ss" name="company_type" id="">                        
                          <option value="">Select Type</option>                     
                          <option value="Company">Company/Brand</option>
                          <option value="Vendor">Vendor</option>                     
                          <option value="Supplier">Supplier</option>                      
                          <option value="Client">Client</option>                     
                      </select>
                      </div>  
                    </div>
                  </div>

                  <div class="d-none form-group">
                    <label for="">Sub Title</label>
                    <input type="text" name="sub_title" class="form-control" id=""  placeholder="Enter sub title here">
                  </div>     
                  
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="">Mobile Number</label>
                        <input type="text" name="mobile" class="form-control" id="">
                      </div> 
                    </div>        
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="">Email Address</label>
                        <input type="email" name="email" class="form-control" id="" >
                      </div> 
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="">Website</label>
                        <input type="text" name="website" class="form-control" id="">
                      </div> 
                    </div>        
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="">Address</label>
                    <textarea name="address" class="form-control" rows="1"></textarea>
                      </div> 
                    </div>
                  </div>
                 

                  <div class="form-group">
                    <label for="">Description</label>
                    <textarea id="summernote1" name="description" class="form-control" rows="3"></textarea>  
                  </div>

                  <div class="d-none form-group">
                    <label for="">Short Description</label>
                    <textarea name="short_description" class="form-control" rows="3"></textarea>  
                  </div>
                 

                  <div class="d-none row">
                    <div class="form-group col-6 float-left">
                        <label for="">Link Title</label>
                        <input type="text" name="link_title" class="form-control" id=""  placeholder="Enter link title">
                    </div>

                    <div class="form-group col-6 float-left">
                        <label for="">Link Action</label>
                        <input type="text" name="link_action" class="form-control" id=""  placeholder="Enter link action url here">
                    </div>
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