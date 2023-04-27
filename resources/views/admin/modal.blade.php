public function storeUser(Request $request){
  $data = new User;
  $data->name = $request->name;
  $data->email = $request->email; 
  $data->password = Hash::make($request->password);
  $data->user_type = $request->user_type;
  $data->is_verified = '1';
  $data->verification_code = sha1(time());
  $data->save();
  return redirect()->back()->with(session()->flash('alert-success', 'New user created.'));
}

public function updateUser(Request $request)
{
    //dd($request);
    $data = User::find($request->id); 
    $data->name = $request->name; 
    $data->user_type = $request->user_type;       
    $data->save();
    return redirect()->back()->with(session()->flash('alert-success', 'Data updated successfully.'));        
}

public function deleteUser($id){
    $data = User::find($id);
    $data->delete();

    return redirect()->back()->with(session()->flash('alert-success', 'Data  deleted successfully.'));
}


{{-- new entry --}}

<div class="mb-2 mb-sm-0">
  <a href="" data-toggle="modal" data-target="#newEntry" class="btn btn-blue px-3 d-block w-100 text-95 radius-round border-2 brc-black-tp10">
    <i class="fa fa-plus mr-1"></i>
    Add <span class="d-sm-none d-md-inline">New</span> Entry
  </a>
</div>
</div>

<div class="modal fade" id="newEntry" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    
<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">
        New User
      </h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
      
      <form action="storeUser" method="post"  class="mt-lg-3" autocomplete="off">
        @csrf

        <div class="row"> 
          <div class="col-md-6 input-floating-label1 text-blue-d2 brc-blue-m1">
            <span class="floating-label text-grey-m3">
              Certificate Name
          </span>
          <input type="text" name="certificate_name"  required="" class="form-control form-control-lg shadow-none" id="id-form-field-2">
            
          </div>

          <div class="col-md-6 input-floating-label1 text-blue-d2 brc-blue-m1">
            <span class="floating-label text-grey-m3">
              Institute
          </span>
          <input type="text"  name="institute"  required class="form-control form-control-lg shadow-none" id="id-form-field-2">
          
          </div>
        </div>
        
        <div class="row"> 
          <div class="col-md-6 input-floating-label1 text-blue-d2 brc-blue-m1">
            <span class="floating-label text-grey-m3">
              Start Date
          </span>
          <input type="date" name="start_date"  class="form-control form-control-lg shadow-none" id="id-form-field-2">
        </div>
        
          <div class="col-md-6 input-floating-label1 text-blue-d2 brc-blue-m1">
            <span class="floating-label text-grey-m3">
              Finish Date
          </span>
          <input type="date" name="end_date"   class="form-control form-control-lg shadow-none" id="id-form-field-2">
        </div> 
          
        </div>   

    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      <button type="submit" class="btn btn-info btn-bold px-4">Save</button>
    </div>
  </div>
</div>
</form>
</div>


{{-- new entry end--}}

<a href="" data-toggle="modal" data-target="#item{{$item->id}}" class="mx-2px btn radius-1 border-2 btn-xs btn-brc-tp btn-light-secondary btn-h-lighter-success btn-a-lighter-success">
  <i class="fa fa-pencil-alt"></i>
</a> 


<div class="modal fade" id="item{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">
            Update Certification
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          
          <form action="updateCertification" method="post"  class="mt-lg-3" autocomplete="off">
            @csrf

            <div class="row"> 
              <div class="col-md-6 input-floating-label1 text-blue-d2 brc-blue-m1">
                <span class="floating-label text-grey-m3">
                  Certificate Name
              </span>
              <input type="text" name="certificate_name"  value="{{ $item->certificate_name }}" required="" class="form-control form-control-lg shadow-none" id="id-form-field-2">
                
              </div>

              <div class="col-md-6 input-floating-label1 text-blue-d2 brc-blue-m1">
                <span class="floating-label text-grey-m3">
                  Institute
              </span>
              <input type="text"  name="institute" value="{{ $item->institute }}" required class="form-control form-control-lg shadow-none" id="id-form-field-2">
              
              </div>
            </div>
            
            <div class="row"> 
              <div class="col-md-6 input-floating-label1 text-blue-d2 brc-blue-m1">
                <span class="floating-label text-grey-m3">
                  Start Date
              </span>
              <input type="date" name="start_date" value="{{ $item->start_date }}" class="form-control form-control-lg shadow-none" id="id-form-field-2">
            </div>
            
              <div class="col-md-6 input-floating-label1 text-blue-d2 brc-blue-m1">
                <span class="floating-label text-grey-m3">
                  Finish Date
              </span>
              <input type="date" name="end_date" value="{{ $item->end_date }}" class="form-control form-control-lg shadow-none" id="id-form-field-2">
            </div> 
              
            </div>   
            
            <input type="hidden" name="id" value="{{ $item->id }}">

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-info btn-bold px-4">Save changes</button>
        </div>
      </div>
    </div>
    </form>
  </div>