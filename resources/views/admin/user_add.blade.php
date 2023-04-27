
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
        Add New User 
      </h1> 
      <a href="users"class="btn btn-default px-3 text-95 radius-round border-2 brc-black-tp10 float-left">
        <i class="fa fa-plus mr-1"></i>
        <span class="d-sm-none d-md-inline">All</span> Users
      </a>
    </div>   


    <div class="row mt-3">
      <div class="col-12">
        <div class="card dcard">
          <div class="card-body px-1 px-md-3">                                   
            <div role="main" class="main-content">         
              <div class="page-content container container-plus">               

                <form method="POST"  action="{{route('save_user')}}" enctype="multipart/form-data">
                  @csrf              
                  <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                          <label for="">Full Name<span></span></label>
                          <input type="text" name="name" class="form-control"  placeholder="Enter client name">
                        </div>                 
                  </div>                   
                    <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Client<span></span></label>
                          <select name="client_id" id="" class="custom-select select2-single">
                          <option selected>Select client</option>
                          @php                   
                            $clients = DB::table('clients')
                            ->get();
                          @endphp   
                          @foreach($clients as $client) 
                            <option value="{{$client->id}}">{{$client->name}}</option>
                          @endforeach 
                          </select> 
                        </div>                 
                    </div>        
                    
                    <div class="col-md-6">
                        <div class="form-group">
                          <label for="">User Type<span></span></label>
                          <select name="user_type" id="" class="custom-select select2-single">
                          <option selected>Select user type</option>
                          <option value="User">User</option>
                          <option value="Moderator">Moderator</option>
                          <option value="Manager">Manager</option>
                          <option value="Admin">Admin</option>
                     
                          </select> 
                        </div>                 
                    </div>                 
                  </div>                 
                  <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Username<span>*</span></label>
                          <input type="text" name="email" class="form-control" required  placeholder="Mobile or email address">
                        </div>                 
                    </div>                 
                    <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Password<span>*</span></label>
                          <input type="text" name="password" class="form-control" required  placeholder="at least 8 digit. ">
                        </div>                 
                    </div>                 
                    <div class="col-md-6 d-none">
                        <div class="form-group">
                          <label for="">Email Address</label>
                          <input type="text" name="mobile" class="form-control"  placeholder="">
                        </div>                 
                    </div>        
                    <div class="col-md-6 d-none">
                      <div class="form-group">
                        <label for="">Address</label>
                        <input type="text" name="address" class="form-control"   placeholder="">
                      </div>                 
                    </div>               
                  </div>             


                  <div class="form-group d-none">
                    <label for="">Image: </label> <br>
                    <img id="uploadPreview" style="width: 200px; height: 150px; display:none" />
                    <input id="uploadImage"  type="file" name="image" onchange="PreviewImage();" />
                  </div>
              
                  
                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-check">                    
                        <label class="form-check-label" for="">
                         Active
                        </label>
                        <input type="checkbox" name="active" checked class="form-check-input">
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