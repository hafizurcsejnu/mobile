
@extends('admin.master')
@section('main_content')    

  <div class="page-content container container-plus">
    <div class="page-header pb-2">
      <h1 class="page-title text-primary-d2 text-150">
        Application Settings     
      </h1>      
    </div>   


    <div class="row mt-3">
      <div class="col-12">
        <div class="card dcard">
          <div class="card-body px-1 px-md-3">                                   
            <div role="main" class="main-content">         
              <div class="page-content container container-plus">               

                <form action="update_settings" method="post" enctype="multipart/form-data">
                  @csrf
                  <div class="form-group">
                    <label for="">Site Title</label>
                    <input type="text" name="title" class="form-control" id=""  value="{{$data->title}}">
                  </div> 
                  <div class="row">
                    <div class="col-md-6">                
                      <div class="form-group">
                        <label for="">Sub Title or Slogan</label>
                        <input type="text" name="sub_title" class="form-control" id=""  value="{{$data->sub_title}}">
                      </div> 
                    </div>
                    <div class="col-md-6">                
                      <div class="form-group">
                        <label for="">Business Type</label>
                        <select name="product_type" class="custom-select">
                          <option value="{{$data->product_type}}">{{$data->product_type}}</option>
                          <option value="Product">Product</option>
                          <option value="Service">Service</option> 
                          <option value="Product/Service">Product and Service</option> 
                        </select>
                      </div> 
                    </div>
                  </div>
                                 

                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="">Short Description</label>
                        <textarea name="short_description"  class="form-control" placeholder="Short description of your business"  rows="1">{{$data->short_description}}</textarea> 
                      </div> 
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="">Address</label>
                        <textarea name="address"  class="form-control"  rows="1">{{$data->address}}</textarea> 
                      </div> 
                    </div>
                  </div>


                  <div class="d-none form-group">
                    <label for="">Meta Description</label>                    
                    <textarea name="meta_description"  class="form-control"  rows="2">{{$data->meta_description}}</textarea> 
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="">Email Address</label>
                        <input type="email" name="email" class="form-control" id=""  value="{{$data->email}}">
                      </div> 
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="">Website</label>
                        <input type="text" name="website" class="form-control" id=""  value="{{$data->website}}">
                      </div> 
                    </div>                    
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
                        <label for="">Phone Number</label>
                        <input type="text" name="phone" class="form-control" id=""  value="{{$data->phone}}">
                      </div> 
                    </div>                   
                  </div>
                

                 
                <div class="row mt-3 d-none">
                    <div class="form-group col-6 float-left">
                        <label for="">Facebook link</label>
                        <input type="text" name="fb_link" class="form-control" id=""  value="{{$data->fb_link}}">
                    </div>
                    <div class="form-group col-6 float-left">
                        <label for="">Twitter link</label>
                        <input type="text" name="twitter_link" class="form-control" id=""   value="{{$data->twitter_link}}">
                    </div>
                    <div class="form-group col-6 float-left">
                        <label for="">Linkedin link</label>
                        <input type="text" name="linkedin_link" class="form-control" id=""   value="{{$data->linkedin_link}}">
                    </div>
                    <div class="form-group col-6 float-left">
                        <label for="">Instagram link</label>
                        <input type="text" name="instagram_link" class="form-control" id=""   value="{{$data->instagram_link}}">
                    </div>
                    <div class="form-group col-6 float-left">
                        <label for="">Pinterest link</label>
                        <input type="text" name="pinterest_link" class="form-control" id=""   value="{{$data->pinterest_link}}">
                    </div>
                    <div class="form-group col-6 float-left">
                        <label for="">Youtube link</label>
                        <input type="text" name="youtube_link" class="form-control" id=""   value="{{$data->youtube_link}}">
                    </div>
                </div>   
                  
                <div class="form-group mt-3">
                  <label for="">Logo header: </label>
                  <input type="hidden" name="hidden_logo_header" value="{{$data->logo_header}}">
                  <input type="hidden" name="id" value="{{$data->id}}">
                  <img src="{{ URL::asset('storage/app/public/'.$data->logo_header.'') }}" id="previousImage" height="70px" alt="">
                  <br>
                  <img id="uploadPreview" style="width: 100px; height: 70px; display:none" />
                  
                  <input id="uploadImage"  type="file" name="logo_header" onchange="PreviewImage();" />
                </div>
                <div class="form-group">
                  <label for="">Logo footer: </label>
                  <input type="hidden" name="hidden_logo_footer" value="{{$data->logo_footer}}">
                  <img src="{{ URL::asset('storage/app/public/'.$data->logo_footer.'') }}" id="previousImage2" height="70px" alt="">
                  <br>
                  <img id="uploadPreview2" style="width: 100px; height: 70px; display:none" />
                  <input id="uploadImage2"  type="file" name="logo_footer" onchange="PreviewImage();" />
                </div> 

                <div class="form-group">
                  <label for="">Favicon: </label> 
                  <input type="hidden" name="hidden_favicon" value="{{$data->favicon}}">
                  <img src="{{ URL::asset('storage/app/public/'.$data->favicon.'') }}" id="previousImage3" height="50px" alt="">
                  <br>
                  <img id="uploadPreview3" style="width: 50px; height: 50px; display:none" />
                  <input id="uploadImage3"  type="file" name="favicon" onchange="PreviewImage3();" />
                </div>

                <div class="form-group">                    
                  <label class="form-check-label" for="exampleCheck1">
                    Active
                  </label>
                  <input type="checkbox" name="active" @if($data->active == 'on') checked
                  @endif class="form-check-input" id="exampleCheck1">
                </div>
                <br>
                <button type="submit" class="btn btn-primary">Save Changes</button>
              </form>
                
             </div>
            </div>
          </div>
        </div>           
      </div>
    </div>

  </div>
 
@endsection