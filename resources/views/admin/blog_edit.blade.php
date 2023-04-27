
@extends('admin.master')
@section('main_content')    

  <div class="page-content container container-plus">
    <div class="page-header pb-2">
      <h1 class="page-title text-primary-d2 text-150">
        Add New Blog Post     
      </h1> 
      <a href="blogs"class="btn btn-default px-3 text-95 radius-round border-2 brc-black-tp10 float-left">
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

                <form action="update_blog" method="post" enctype="multipart/form-data">
                  @csrf
                  <div class="form-group">
                    <label for="">Post Title</label>
                    <input type="text" name="title"  class="form-control" id="" aria-describedby="emailHelp" value="{{$data->title}}">
                  </div>                 

                  <div class="form-group">
                    <label for="exampleInputPassword1">Category</label>
                    <select class="form-control" name="category_id" required="">
                        <option value="{{$data->category_id}}">{{$data->catName}}</option>
                        <?php                         
                        $categories=DB::table('blog_categories')->get();
                        ?>
                        @foreach($categories as $category) 
                        <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach  
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="">Post Description</label>
                    <textarea id="summernote" name="description" rows="25">
                        {{$data->description}}
                    </textarea>  
                  </div>

                  <div class="form-group">
                    <label for="">Short Description</label>
                    <textarea name="short_description"  class="form-control"  rows="10">
                        {{$data->short_description}}
                    </textarea>  
                  </div>
                  <div class="form-group">
                    <label for="">Post Image: </label>
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