
@extends('admin.master')
@section('main_content')    

  <div class="page-content container container-plus">
    <div class="page-header pb-2">
      <h1 class="page-title text-primary-d2 text-150">
        Add New Bank     
      </h1> 
      <a href="banks"class="btn btn-default px-3 text-95 radius-round border-2 brc-black-tp10 float-left">
        <i class="fa fa-plus mr-1"></i>
        <span class="d-sm-none d-md-inline">All</span> Banks
      </a>
    </div>   


    <div class="row mt-3">
      <div class="col-12">
        <div class="card dcard">
          <div class="card-body px-1 px-md-3">                                   
            <div role="main" class="main-content">         
              <div class="page-content container container-plus">               

                <form action="save_bank" method="post" enctype="multipart/form-data">
                  @csrf
                  <div class="row">
                    <div class="col-md-6">
                    <div class="form-group">
                      <label for="">Bank Name</label>
                      <input type="text" name="title" class="form-control" id=""  placeholder="Enter bank name here">
                    </div>   
                  </div>
                  <div class="col-md-6">              
                    <div class="form-group">
                      <label for="">Branch</label>
                      <input type="text" name="branch" class="form-control" id=""  placeholder="Enter branch">
                    </div>    
                  </div> 
                </div> 

                <div class="row">
                    <div class="form-group col-6">
                        <label for="">Account Name</label>
                        <input type="text" name="ac_name" class="form-control" id=""  placeholder="Enter account name">
                    </div>

                    <div class="form-group col-6">
                        <label for="">Account No</label>
                        <input type="text" name="ac_no" class="form-control" id=""  placeholder="Enter account no">
                    </div>
                </div> 
                  
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="">Banking Type</label> 
                        <select class="select2-single product" name="banking_type" class="form-control" style="width: 100%">
                          <option value="General Banking">General Banking</option>
                          <option value="Mobile Banking">Mobile Banking</option>
                        </select>
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
                        <label for="">Mobile Number</label>
                        <input type="text" name="mobile" class="form-control" id="">
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
                    <textarea class="form-control" name="description" rows="3"> </textarea>  
                  </div>

                  <div class="d-none form-group">
                    <label for="">Short Description</label>
                    <textarea name="short_description" class="form-control" rows="3"></textarea>  
                  </div>
                             

                  <div class="d-none form-group">
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