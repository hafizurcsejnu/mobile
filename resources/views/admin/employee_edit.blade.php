
@extends('admin.master')
@section('main_content')    

  <div class="page-content container container-plus">
    <div class="page-header pb-2">
      <h1 class="page-title text-primary-d2 text-150">
        Update Employee     
      </h1> 
      <a href="{{URL::to('add-employee')}}">Add new</a>
      <a href="employees"class="btn btn-default px-3 text-95 radius-round border-2 brc-black-tp10 float-left">
        <i class="fa fa-plus mr-1"></i>
        <span class="d-sm-none d-md-inline">All</span> Employees
      </a>
    </div>   


    <div class="row mt-3">
      <div class="col-12">
        <div class="card dcard">
          <div class="card-body px-1 px-md-3">                                   
            <div role="main" class="main-content">         
              <div class="page-content container container-plus">               

                <form action="update_employee" method="post" enctype="multipart/form-data">
                  @csrf

                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="">Employee</label>
                        <input type="text" name="title" class="form-control" id=""  value="{{$data->title}}">
                      </div>  
                    </div>

                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="exampleInputPassword1">Designation</label>
                        <select class="form-control ss" name="designation" required="">
                            <option value="">Select type</option>                        
                            <option value="Accountant">Accountant</option>
                            <option value="Managing Director">Managing Director</option>
                            <option value="Manager">Manager</option>
                            <option value="Technician">Technician</option>
                            <option value="Driver">Driver</option>
                            <option value="Office Assistant">Office Assistant</option>                        
                            <option value="Labour">Labour</option>      
                            <option value="Painter">Painter</option>      
                            <option value="Others">Others</option>                  
                        </select>
                      </div>
                    </div>
                   
                    
                  </div>

                                
                  <div class="d-none form-group">
                    <label for="">Sub Title</label>
                    <input type="text" name="sub_title" class="form-control" id=""  value="{{$data->sub_title}}">
                  </div> 
                  <div class="row">
                    
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="">Mobile Number</label>
                        <input type="text" name="mobile" class="form-control" id=""  value="{{$data->mobile}}">
                      </div> 
                    </div>

                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="">Email Address</label>
                        <input type="email" name="email" class="form-control" id=""  value="{{$data->email}}">
                      </div> 
                    </div>
                   
                    
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="">Address</label>                    
                      <textarea name="address"  class="form-control"  rows="1">{{$data->address}}</textarea> 
                    </div>    
                  </div>    
                </div>    

                  <div class="form-group">
                    <label for="">Description</label>
                    <textarea id="summernote1" name="description" class="form-control" rows="2">{{$data->description}}</textarea>  
                  </div>

                  <div class="d-none form-group">
                    <label for="">Short Description</label>
                    <textarea name="short_description"  class="form-control"  rows="1">{{$data->short_description}}</textarea>  
                  </div>
                  

                  <div class="d-none row">
                    <div class="form-group col-6 float-left">
                        <label for="">Link Title</label>
                        <input type="text" name="link_title" class="form-control" id=""  value="{{$data->link_title}}">
                    </div>

                    <div class="form-group col-6 float-left">
                        <label for="">Link Action</label>
                        <input type="text" name="link_action" class="form-control" id=""   value="{{$data->link_action}}">
                    </div>
                    </div>

                  
                      <div class="form-group">
                        <label for="">Image: </label>
                        <input type="hidden" name="hidden_image" value="{{$data->image}}">
                        <input type="hidden" name="id" value="{{$data->id}}">
                        @if ($data->image != null)
                           <img src="{{ URL::asset('storage/app/public/'.$data->image.'') }}" id="previousImage" height="100px" alt="">
                        @endif
    
                        <img id="uploadPreview" style="width: 200px; height: 150px; display:none" />
                        <input id="uploadImage"  type="file" name="image" onchange="PreviewImage();" />
                      </div>
    
                      <div class="form-group">                    
                        <label class="form-check-label" for="exampleCheck1">
                         Active
                        </label>
                        <input type="checkbox" name="active" @if($data->active == 'on') checked
                        @endif class="form-check-input" id="exampleCheck1">
                      </div>
                      <br>
                      <button type="submit" class="btn btn-primary">Update</button>
                      <a href="{{URL::to('pages')}}" class="btn btn-default">Cancel</a>
                      
                    </form>
                
             </div>
            </div>
          </div>
        </div>           
      </div>
    </div>

  </div>
 
@endsection