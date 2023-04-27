
@extends('admin.master')
@section('main_content')    

  <div class="page-content container container-plus">
    <div class="page-header pb-2">
      <h1 class="page-title text-primary-d2 text-150">
        Data Lookup        
      </h1> 
      <a href="" data-toggle="modal" data-target="#addNewEntry" class="btn btn-default px-3 text-95 radius-round border-2 brc-black-tp10 float-left">
        <i class="fa fa-plus mr-1"></i>
        Add <span class="d-sm-none d-md-inline">New</span> Entry
      </a>
    </div>

<!-- Modal -->
<div class="modal fade" id="addNewEntry" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New Entry</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form method="post" action="store_data_lookup">
        @csrf
      <div class="modal-body">
          <div class="row"> 
              <div class="col-md-12">
                <span>Title</span>
                <input type="text" name="title"  placeholder="Enter data" required="" class="form-control form-control shadow-none">                
              </div>
          </div>
          <br>
          <div class="row"> 
              <div class="col-md-12">
                <span>Data Type</span>
                    <div class="form-group">                  
                    <select class="form-control ss" name="data_type" required="" style="width: 100%">
                      <?php 
                        $last_item = DB::table('data_lookups')->orderBy('id', 'DESC')->first();
                      ?> 
                      @if ($last_item)
                        <option value="{{$last_item->data_type}}">{{$last_item->data_type}}</option>
                      @else 
                      <option value="">Select type</option>
                      @endif    
                          {{-- <option value="Service For">Service For</option>  --}}
                          <option value="Expense Type">Expense Type</option>         
                          <option value="Measurement Unit">Measurement Unit</option>
                          <option value="Particular">Particular/Material</option>                         
                          <option value="Model">Model/Size/Pack Size</option>                           
                          <option value="Usage">Usage</option> 
                          <option value="Hidden">Hidden</option> 
                                          
                    </select>
                  </div>            
              </div>
          </div>

        
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- Modal End -->
    


    <div class="row mt-3">
      <div class="col-12">
        <div class="card dcard">
          <div class="card-body px-1 px-md-3">                                   
            <div role="main" class="main-content">         
              <div class="page-content container container-plus">
                <div class="page-header mb-2 pb-2 flex-column flex-sm-row align-items-start align-items-sm-center py-25 px-1">              

                <h1 class="page-title text-primary-d2 text-140">
                Data Lookup  
                  <small class="page-info text-dark-m3">
                    <i class="fa fa-angle-double-right text-80"></i>
                    you can add, edit and delete any of these data.
                  </small>
                </h1>                     


                <div class="page-tools mt-3 mt-sm-0 mb-sm-n1">
                  <!-- dataTables search box will be inserted here dynamically -->
                </div>
              </div>

              <div class="card bcard h-auto">               

                  <table id="datatable" class="d-style w-100 table text-dark-m1 text-95 border-y-1 brc-black-tp11 collapsed">
                    <!-- add `collapsed` by default ... it will be removed by default -->
                    <!-- thead with .sticky-nav -->
                    <thead class="sticky-nav text-secondary-m1 text-uppercase text-85">
                      <tr>
                        <th class="td-toggle-details border-0 bgc-white shadow-sm">
                          <i class="fa fa-angle-double-down ml-2"></i>
                        </th>

                        <th class="border-0 bgc-white pl-3 pl-md-4 shadow-sm"> SN </th>
                        <th class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm">Title </th>                     
                        <th class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm">Data Type </th>                     

                        <th class="border-0 bgc-white shadow-sm w-2" style="width:10%"></th>
                      </tr>
                    </thead>

                    <tbody class="pos-rel">
                    @foreach($data as $item)                                  
                      <tr class="d-style bgc-h-default-l4">
                        <td class="td-toggle-details pos-rel">
                          <div class="position-lc h-95 ml-1px border-l-3 brc-purple-m1">
                          </div>
                        </td>
                        <td class="pl-3 pl-md-4 align-middle pos-rel"> {{$loop->iteration}} </td>
                        <td> <span class="text-105"> {{$item->title}} </span> </td>
                        <td> <span class="text-105"> {{$item->data_type}} </span> </td>

                        <td class="align-middle">
                          <span class="d-none d-lg-inline">
                              <a data-rel="tooltip"  data-toggle="modal" data-target="#item{{$item->id}}"  title="Edit" href="#" class="v-hover">
                                  <i class="fa fa-edit text-blue-m1 text-120"></i>
                              </a>
                          </span>

                          <span class="d-lg-none text-nowrap">
                              <a title="Edit" href="#" class="btn btn-outline-info shadow-sm px-4 btn-bgc-white">
                                  <i class="fa fa-pencil-alt mx-1"></i>
                                  <span class="ml-1 d-md-none">Edit</span>
                          </a>
                          </span>

                          <!-- edit modal -->

                          <!-- Modal -->
<div class="modal fade" id="addNewEntry" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New Entry</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form method="post" action="store_data_lookup">
        @csrf
      <div class="modal-body">
          <div class="row"> 
              <div class="col-md-12">
                <span>Title</span>
                <input type="text" name="title"  placeholder="Enter data" required="" class="form-control form-control shadow-none">                
              </div>
          </div>
          <br>
          <div class="row"> 
              <div class="col-md-12">
                <span>Data Type</span>
                    <div class="form-group">                  
                    <select class="form-control" name="data_type" required="">
                       <?php 
                        //$last_item = DB::table('data_lookups')->orderBy('id', 'DESC')->first();
                      ?>
                        {{-- <option value="Service For">Service For</option>  --}}
                        <option value="Measurement Unit">Measurement Unit</option>
                        <option value="Particular">Particular/Material</option>                         
                        <option value="Model">Model/Size</option>                           
                        <option value="Usage">Usage</option>         
                        <option value="Expense Type">Expense Type</option>                           
                        <option value="Hidden">Hidden</option>                           
                    </select> 
                  </div>
            
              </div>
          </div> 

        
      </div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- Modal End -->


                          <div class="modal fade" id="item{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">
                                    Update
                                  </h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>

                                

                                  <form method="post" action="update_data_lookup"   class="" autocomplete="off">
                                    @csrf          
                                <div class="modal-body">            
                                    <div class="row"> 
                                      <div class="col-md-12">
                                        <span>Title</span>
                                        <input type="text" name="title"  value="{{ $item->title }}" required="" class="form-control">                                        
                                      </div>
                                    </div> 
                                    
                                    <div class="row"> 
                                      <div class="col-md-12">
                                        <span>Data Type</span>
                                        <select class="form-control" name="data_type" required="">
                                            <option value="{{$item->data_type}}">{{$item->data_type}}</option>                        
                                              {{-- <option value="Service For">Service For</option>  --}}
                                                <option value="Expense Type">Expense Type</option>
                                                <option value="Measurement Unit">Measurement Unit</option>                                                
                                                <option value="Particular">Particular/Material</option>                         
                                                <option value="Model">Model/Size</option>                           
                                                <option value="Usage">Usage</option>                           
                                                <option value="Hidden">Hidden</option>        
                                        </select>                                       
                                      </div>
                                    </div> 
                                    <input type="hidden" name="id" value="{{ $item->id }}">      
                                </div>

                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                  <button type="submit" class="btn btn-info btn-bold px-4">Save changes</button>
                                </div>
                              </form>
                              </div>
                            </div>
                            
                          </div>                      

                          <!-- edit modal end -->                                                                      




                          <span class="d-lg-inline">
                            <a data-rel="tooltip" title="Delete" href="javascript:void(0)" data-target="#confirm_delete_modal" data-toggle="modal" data-id="{{$item->id}}" class="delete-btn v-hover">
                                <i class="fa fa-trash text-blue-m1 text-120"></i>
                            </a>
                            <div id="confirm_delete_modal" class="modal fade" aria-modal="true">
                              <div class="modal-dialog modal-dialog-centered modal-confirm">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <div class="icon-box">
                                      <i class="fa fa-times fa-4x"></i>
                                    </div>				
                                    <h4 class="modal-title w-100">Warning!</h4>	
                                  </div>
                                  <div class="modal-body">
                                    <p class="text-center">Are you sure? This action can't be undone.</p>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <a href="" class="btn btn-danger delete-datalookup">Delete</a>
                                  </div>
                                </div>
                              </div>
                            </div>                              
                        </span>

                          <span class="d-lg-none text-nowrap">
                              <a title="Edit" href="#" class="btn btn-outline-info shadow-sm px-4 btn-bgc-white">
                                  <i class="fa fa-trash-alt mx-1"></i>
                                  <span class="ml-1 d-md-none">Delete</span>
                          </a>
                          </span>
                        </td>
                      </tr>
                      @endforeach

                    
                    </tbody>
                  </table>

              </div>
            </div>


           
      </div>
    </div>

  </div>
 
@endsection