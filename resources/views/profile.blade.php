
@extends('admin.master')
@section('main_content')
    

  <div class="page-content container container-plus">
    <div class="page-header pb-2">
      <h1 class="page-title text-primary-d2 text-150">
      Update profile info     
      </h1>
    </div>

    <div class="row mt-3">
      <div class="col-12">
        <div class="card dcard">
          <div class="card-body px-1 px-md-3">

          <div class="row">
      <div class="col-12 col-lg-10 offset-lg-1 mt-3">

       

        <form  action="update-user" method="post" enctype="multipart/form-data" class="text-grey-d1 text-95" autocomplete="off">
          @csrf

          <div class="form-group row mx-0">
            <label for="id-field1" class="col-sm-4 col-xl-3 col-form-label text-sm-right">Profile Picture</label>
            <div class="col-sm-8 col-lg-6">
              <?php
                if ($data['image']==null) {?>
                   <img src="{{asset('assets/assets/image/avatar/avatar2.png')}}" width="50px">
               <?php } else{?>             
              <img src="{{asset('storage/app/public')}}/{{$data['image']}}" width="250px">
              <?php }?>

              <br>
              {{-- <img src="storage/app/{{$data['image']}}" alt="Profile Picture"> --}}
              <input type="file" name="profile_image" class="form-control1">
            </div>
          </div> 

          <div class="form-group row mx-0">
            <label for="id-field1" class="col-sm-4 col-xl-3 col-form-label text-sm-right">Full Name</label>
            <div class="col-sm-8 col-lg-6">
              <input type="text" name="name" value="{{$data['name']}}" class="form-control brc-on-focus brc-success-m2" id="id-field1">
            </div>
          </div>          
          <div class="form-group row mx-0">
            <label for="id-field1" class="col-sm-4 col-xl-3 col-form-label text-sm-right">Current Password</label>
            <div class="col-sm-8 col-lg-6">
              <input type="password" name="current_password" placeholder="Current password (Don't fill to keep upchanged)" class="form-control brc-on-focus brc-success-m2" id="id-field1">
            </div>
          </div>  
          
          <div class="form-group row mx-0">
            <label for="id-field1" class="col-sm-4 col-xl-3 col-form-label text-sm-right">New Password</label>
            <div class="col-sm-8 col-lg-6">
              <input type="password" name="new_password" placeholder="New passoword (Don't fill to keep upchanged)" class="form-control brc-on-focus brc-success-m2" id="id-field1">
            </div>
          </div>  
          <div class="form-group row mx-0">
            <label for="id-field1"  class="col-sm-4 col-xl-3 col-form-label text-sm-right">Confirm Password</label>
            <div class="col-sm-8 col-lg-6">
              <input type="password" name="confirm_password" placeholder="Confirm password (Don't fill to keep upchanged)" class="form-control brc-on-focus brc-success-m2" id="id-field1">
            </div>
          </div>          
       

      </div>



      <div class="col-12">
        <hr class="border-double brc-dark-l3">

        <div class="form-group text-center mt-4 mb-3">
          {{-- <button type="button" class="btn btn-outline-secondary radius-1 px-3 mx-1">
            Cancel
          </button> --}}

          <button type="submit" class="btn btn-outline-green radius-1 px-4 mx-1">
            Save Changes
          </button>
        </div>
      </div>

    </form>

    </div>

          </div><!-- /.card-body -->
        </div><!-- /.card -->
      </div><!-- /.col -->
    </div>

  </div>
 
@endsection