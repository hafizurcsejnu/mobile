
@extends('admin.master')
@section('main_content')
    

  <div class="page-content container container-plus">
    <div class="page-header pb-2">
      <h1 class="page-title text-primary-d2 text-150">
        Users       
      </h1>
    </div>

    <div class="row mt-3">
      <div class="col-12">
        <div class="card dcard">
          <div class="card-body px-1 px-md-3">

         
              <div class="d-flex justify-content-between flex-column flex-sm-row mb-3 px-2 px-sm-0">
                <h3 class="text-125 pl-1 mb-3 mb-sm-0 text-secondary-d4">
                 All Users
                </h3>

              

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
                              User Name
                          </span>
                          <input type="text"  name="name" placeholder="Jonn" required class="form-control form-control-lg shadow-none" id="id-form-field-2">                            
                          </div>

                          <div class="col-md-6 input-floating-label1 text-blue-d2 brc-blue-m1">
                            <span class="floating-label text-grey-m3">
                              User Type
                          </span>
                          <select name="user_type" id="field_of_study" class="form-control select2_class" id="form-field-select-1" style="height: 46px;">
                            <option value="">Select role </option>                                                  
                            <option value="User">User</option>
                            <option value="Admin">Admin</option>
                          </select>

                          
                          </div>
                        </div>
                        
                        <div class="row"> 
                          <div class="col-md-6 input-floating-label1 text-blue-d2 brc-blue-m1">
                            <span class="floating-label text-grey-m3">
                              Email Address
                          </span>
                          <input type="email" name="email" placeholder="email@here.com" required class="form-control form-control-lg shadow-none" id="id-form-field-2">
                        </div>
                        
                          <div class="col-md-6 input-floating-label1 text-blue-d2 brc-blue-m1">
                            <span class="floating-label text-grey-m3">
                              Password
                          </span>
                          <input type="password" name="password" placeholder="Password here" required class="form-control form-control-lg shadow-none" id="id-form-field-2">
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

              <table id="simple-table" class="mb-0 table table-borderless table-bordered-x brc-secondary-l3 text-dark-m2 radius-1 overflow-hidden">
                <thead class="text-dark-tp3 bgc-grey-l4 text-90 border-b-1 brc-transparent">
                  <tr>
                  

                    <th>SN</th>
                    <th>Name</th>
                    <th>Email Address</th>
                    <th>User Type</th>
                    <th>Action</th>
                  </tr>
                </thead>

                <tbody class="mt-1">
                  @foreach($data as $item)
                  <tr class="bgc-h-yellow-l4 d-style">                

                    <td>
                      <a href="#" class="text-blue-d1 text-600 text-95">{{$loop->iteration}}</a>
                    </td>
                    <td>
                      <a href="#" class="text-blue-d1 text-600 text-95">{{$item->name}}</a>
                    </td>

                    <td class="text-600">
                      {{$item->email}}
                    </td>                 
                    <td class="text-600">
                      {{$item->user_type}}
                    </td>     
                  
                    <td>
                      <!-- action buttons -->
                      <div class="d-none d-lg-flex">
                        <a href="" data-toggle="modal" data-target="#item{{$item->id}}" class="mx-2px btn radius-1 border-2 btn-xs btn-brc-tp btn-light-secondary btn-h-lighter-success btn-a-lighter-success">
                          <i class="fa fa-pencil-alt"></i>
                        </a> 
                          <div class="modal fade" id="item{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">
                                    Update User
                                  </h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  
                                  <form action="updateUser" method="post"  class="mt-lg-3" autocomplete="off">
                                    @csrf
                      
                                    <div class="row"> 
                                      <div class="col-md-6 input-floating-label1 text-blue-d2 brc-blue-m1">
                                        <span class="floating-label text-grey-m3">
                                          Name
                                      </span>
                                      <input type="text" name="name"  value="{{ $item->name }}" required="" class="form-control form-control-lg shadow-none" id="id-form-field-2">
                                        
                                      </div>
                      
                                      <div class="col-md-6 input-floating-label1 text-blue-d2 brc-blue-m1">
                                        <span class="floating-label text-grey-m3">
                                          User type
                                      </span>
                                      <select name="user_type" id="field_of_study" class="form-control select2_class" id="form-field-select-1" style="height: 46px;">
                                        <option value="{{ $item->user_type }}">{{ $item->user_type }} </option>                                                  
                                        <option value="User">User</option>
                                        <option value="Admin">Admin</option>
                                      </select>
                                      
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

                        <a href="/deleteUser/{{$item->id}}" onclick="confirmDelete()" class="mx-2px btn radius-1 border-2 btn-xs btn-brc-tp btn-light-secondary btn-h-lighter-danger btn-a-lighter-danger">
                          <i class="fa fa-trash-alt"></i>
                        </a>
                       

                      </div>

                      <!-- show a dropdown in mobile -->
                      <div class="dropdown d-inline-block d-lg-none dd-backdrop dd-backdrop-none-lg">
                        <a href="#" class="btn btn-default btn-xs py-15 radius-round dropdown-toggle" data-toggle="dropdown">
                          <i class="fa fa-cog"></i>
                        </a>

                        <div class="dropdown-menu dd-slide-up dd-slide-none-lg">
                          <div class="dropdown-inner">
                            <div class="dropdown-header text-100 text-secondary-d1 border-b-1 brc-secondary-l2 text-600 mb-2">
                              {{$item->name}}
                            </div>
                            <a href="#" class="dropdown-item">
                              <i class="fa fa-pencil-alt text-blue mr-1 p-2 w-4"></i>
                              Edit
                            </a>
                            <a href="#" class="dropdown-item">
                              <i class="fa fa-trash-alt text-danger-m1 mr-1 p-2 w-4"></i>
                              Delete
                            </a>
                            <a href="#" class="dropdown-item">
                              <i class="far fa-flag text-orange-d1 mr-1 p-2 w-4"></i>
                              Flag
                            </a>
                          </div>
                        </div>
                      </div>

                    </td>
                  </tr>

                  @endforeach

                

                </tbody>
              </table>

              <!-- table footer -->
              <div class="d-flex pl-4 pr-3 pt-35 border-t-1 brc-secondary-l3 flex-column flex-sm-row mt-n1px">
               

                <div class="btn-group ml-sm-auto mt-3 mt-sm-0">
                  <a href="#" class="btn btn-lighter-default btn-bgc-white btn-a-secondary radius-l-1 px-3 border-2">
                    <i class="fa fa-caret-left mr-1"></i>
                    Prev
                  </a>
                  <a href="#" class="btn btn-lighter-default btn-bgc-white btn-a-secondary radius-r-1 px-3 border-2 ml-n2px">
                    Next
                    <i class="fa fa-caret-right ml-1"></i>
                  </a>
                </div>
              </div>
            </form>

          </div><!-- /.card-body -->
        </div><!-- /.card -->
      </div><!-- /.col -->
    </div>

  </div>
 
@endsection