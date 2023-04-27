
@extends('admin.master')
@section('main_content')    

  <div class="page-content container container-plus">
    <div class="page-header pb-2">
      <h1 class="page-title text-primary-d2 text-150">
        Add New Class    
      </h1> 
      <a href="class"class="btn btn-default px-3 text-95 radius-round border-2 brc-black-tp10 float-left">
        <i class="fa fa-plus mr-1"></i>
        <span class="d-sm-none d-md-inline">All</span> Post
      </a>
    </div>   


    <div class="row mt-3">
      <div class="col-12">
        <div class="card dcard">
          <div class="card-body px-1 px-md-3">                                   
            <div role="main" class="main-content">         
              <div class="page-content container container-plus">               

                <form action="update_class" method="post" enctype="multipart/form-data">
                  @csrf
                  <div class="form-group">
                    <label for="">Class Title</label>
                    <input type="text" name="title"  class="form-control" id="" aria-describedby="emailHelp" value="{{$data->title}}">
                  </div>                 
                  <div class="form-group">
                    <label for="">Class Time</label>
                    <input type="text" name="date_time"  class="form-control" id="" aria-describedby="emailHelp" value="{{$data->date_time}}">
                  </div>                 


                  <div class="form-group">
                    <label for="">Class Description</label>
                    <textarea id="summernote" name="description" rows="25">{{$data->description}}
                    </textarea>  
                  </div>

                  <div class="form-group">
                    <label for="">Link</label>
                    <input type="text" name="link"  class="form-control" id="" aria-describedby="emailHelp" value="{{$data->link}}">
                  </div>  

                  <div class="form-group">
                    <label for="">Class Image: </label>
                    <input type="hidden" name="hidden_image" value="{{$data->image}}">
                    <input type="hidden" name="id" value="{{$data->id}}">
                    <img src="{{ URL::asset('storage/app/public/'.$data->image.'') }}" id="previousImage" height="100px" alt="">

                    <img id="uploadPreview" style="width: 200px; height: 150px; display:none" />
                    <input id="uploadImage"  type="file" name="image" onchange="PreviewImage();" />
                  </div>

                  <div class="form-check">                    
                    <label class="form-check-label" for="exampleCheck1">
                     Active
                    </label>
                    <input type="checkbox" name="active" @if($data->active == 'on') checked
                    @endif class="form-check-input" id="exampleCheck1">
                  </div>
                  <br>
                  <button type="submit" class="btn btn-primary">Update</button>
                  <a href="{{URL::to('blogs')}}" class="btn btn-default">Cancel</a>
                  <a href="/delete_blog/{{$data->id}}" onclick="confirmDelete()" class="btn btn-danger">Delete</a>
                </form>
                
             </div>
            </div>
          </div>
        </div>           
      </div>
    </div>

  </div>
 
@endsection