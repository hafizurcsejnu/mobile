@extends('admin.master')
@section('main_content')    
@php
  use App\Models\Setting;
  $settings = Setting::where('client_id', session('user.client_id'))->first();
@endphp

  <div class="page-content container container-plus">
    <div class="page-header pb-2">
      <h1 class="page-title text-primary-d2 text-150">
        {{$settings->product_type}} Categories        
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
      <form method="post" action="store_product_category"  enctype="multipart/form-data">
        @csrf
      <div class="modal-body">

          <div class="row"> 
              <div class="col-md-12">
                <div class="form-group">
                  <span>Name</span>
                  <input type="text" name="name"  placeholder="Insert category or sub category" required="" class="form-control">     
                </div>           
              </div> 
          </div>
          <div class="row"> 
              <div class="col-md-12">
                <div class="form-group">
                  <span>Parent category</span>
                  <select class="form-control select2-single" name="parent_id" style="width: 100%">
                    {{-- @php                   
                    $last_parent_cat=DB::table('product_categories')
                    ->where('parent_id', '!=', null)
                    ->orderby('id', 'desc')
                    ->first();  
                    if($last_parent_cat){
                      $last_cat=DB::table('product_categories')
                      ->where('id', $last_parent_cat->parent_id)
                      ->first();     
                    }          
                    @endphp
                    @if ($last_parent_cat)
                      <option value="{{$last_cat->id}}">{{$last_cat->name}}</option>
                    @endif --}}

                    <option value="">Select parent category</option>
                    <option value="">No Parent</option>
                    @php                   
                    $categories=DB::table('product_categories')
                    ->where('parent_id', null)
                    ->where('client_id', session('client_id'))
                    ->get();
                    @endphp
                    @foreach($categories as $category) 
                      <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach  
                </select>   
                </div>
              </div>
          </div>          
         
          <div class="form-group">
            <label for="">Image: </label> <br>
            <img id="uploadPreview" style="width: 200px; height: 150px; display:none" />
            <input id="uploadImage"  type="file" name="image" onchange="PreviewImage();" />
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
                {{$settings->product_type}} Categories  
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
                        <th class="border-0 bgc-white pl-3 pl-md-4 shadow-sm"></th>
                        <th class="border-0 bgc-white pl-3 pl-md-4 shadow-sm"> SN </th>
                        <th class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm">Name </th>  
                                         
                        <th class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm">Category Type</th>                    
                        <th class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm">Parent Category </th>                     

                        <th class="border-0 bgc-white shadow-sm w-2">
                          Action
                        </th>
                      </tr>
                    </thead>   
                    

                    <tbody class="pos-rel">
                    @foreach($data as $item)                                   
                      <tr class="d-style bgc-h-default-l4">
                        <td class="pl-3 pl-md-4 align-middle pos-rel"></td>
                        <td class="pl-3 pl-md-4 align-middle pos-rel"> {{$loop->iteration}} </td>
                        <td>			
                          @if($item->image != null )
                            <img src="{{ URL::asset('storage/'.$item->image.'') }}" height="50px" width="50px;">
                          @else
                            <img src="{{asset('frontend/images/no-image.png')}}" height="50px" width="50px;" class="product-image">
                          @endif                         
                        </td>
                        
                        <td> <span class="text-105"> {{$item->name}} </span> </td>
                        
                        <td> 
                          <span class="text-105">
                          @if ($item->parent_id==null) Category
                          @else Sub Category
                          @endif</span> 
                        </td>                     
                        <td> 
                          <span class="text-105">
                          @if ($item->parent_id!=null) 
                          <?php                   
                            $category=DB::table('product_categories')
                            ->where('id', $item->parent_id)
                            ->where('client_id', session('client_id'))
                            ->first();
                            ?>
                            {{$category->name}}
                          @endif</span> 
                        </td>

                        <td class="align-middle">
                          <span class="d-none d-lg-inline">
                              <a data-rel="tooltip"  data-toggle="modal" data-target="#item{{$item->id}}"  title="Edit {{$item->id}}" href="#" class="v-hover">
                                  <i class="fa fa-edit text-blue-m1 text-120"></i>
                              </a>
                          </span>

                          <span class="d-lg-none text-nowrap">
                              <a title="Edit {{$item->id}}" href="#" class="btn btn-outline-info shadow-sm px-4 btn-bgc-white">
                                  <i class="fa fa-pencil-alt mx-1"></i>
                                  <span class="ml-1 d-md-none">Edit</span>
                          </a>
                          </span>

                          <!-- edit modal -->
                          <div class="modal fade" id="item{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      
                            <div class="modal-dialog" role="document"  style="width:800px!important">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">
                                    Update Category
                                  </h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  
                                  <form method="post" action="update_product_category"   class="mt-lg-3" autocomplete="off" enctype="multipart/form-data">
                                    @csrf                    

                                    <div class="row"> 
                                      <div class="col-md-12">
                                        <div class="form-group">
                                          <span>Name</span>
                                          <input type="text" name="name"  value="{{ $item->name }}" required="" class="form-control">     
                                        </div>           
                                      </div>
                                  </div>
                                  @if ($item->parent_id != null) 
                                  <div class="row"> 
                                      <div class="col-md-12">
                                        <div class="form-group">
                                          <span>Parent category</span>
                                          <select class="form-control" name="parent_id">
                                            @if ($item->parent_id!=null) 
                                            <?php                   
                                              $category=DB::table('product_categories')
                                              ->where('id', $item->parent_id)
                                              ->first();
                                              ?>
                                              <option value="{{$item->parent_id}}">
                                                {{$category->name}}</option>
                                            @endif 

                                            <option value="">Select parent category</option>
                                            <option value="">No Parent</option>
                                            
                                            <?php                    
                                            $categories=DB::table('product_categories')
                                              ->where('parent_id', null)
                                              ->where('client_id', session('client_id'))
                                              ->get();
                                            ?>
                                            @foreach($categories as $category) 
                                              <option value="{{$category->id}}">{{$category->name}}</option>
                                            @endforeach  
                                        </select>   
                                        </div>
                                      </div>
                                  </div>  
                                  @endif         
                                 
                                  <div class="form-group">
                                    <label for="">Image: </label> <br>

                                    @if ($item->image != null)
                                      <img src="{{ URL::asset('storage/'.$item->image.'') }}" height="150px" width="150px;">
                                      <br>
                                      <br>
                                    @endif
                                    
                                    <img id="uploadPreview" style="width: 150px; height: 150px; display:none" />
                                    <input id="uploadImage" type="file" name="image" onchange="PreviewImage();" />
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
                                    <a href="" class="btn btn-danger delete-category">Delete</a>
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


                      @if($item->parent_id==null)
                        <?php 
                            $subCategories=DB::table('product_categories')->where('parent_id', $item->id)->get();
                        ?>
                        @foreach($subCategories as $item)                                  
                        <tr class="d-style bgc-h-default-l4" id="@if($item->parent_id!=null){{'sub_category'}}@endif">

                         
                          <td class="pl-3 pl-md-4 align-middle pos-rel"> {{$loop->iteration}} </td>

                          <td class="td-toggle-details pos-rel">
                            <div class="position-lc h-95 ml-1px border-l-3 brc-purple-m1">
                            </div>
                          </td>

                          <td>	
                            @if($item->image != null )
                              <img src="{{ URL::asset('storage/app/public/'.$item->image.'') }}" height="50px" width="50px;">
                            @else
                              <img src="{{asset('frontend/images/no-image.png')}}" height="50px" width="50px;" class="product-image">
                            @endif           

                          </td>
                          <td> <span class="text-105 @if($item->parent_id!=null){{'ml-5'}}@endif"> {{$item->name}} </span> </td>
                          <td> 
                            <span class="text-105">
                            @if ($item->parent_id==null) Category
                            @else Sub Category
                            @endif</span> 
                          </td>

                          <td> 
                            <span class="text-105">
                            @if ($item->parent_id!=null) 
                            <?php                   
                              $category=DB::table('product_categories')
                              ->where('id', $item->parent_id)
                              ->first();
                              ?>
                              {{$category->name}}
                            @endif</span> 
                          </td>

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

                            <div class="modal fade" id="item{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        
                              <div class="modal-dialog" role="document"  style="width:800px!important">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">
                                      Update Sub Category
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                    
                                    <form method="post" action="update_product_category"   class="mt-lg-3" autocomplete="off"  enctype="multipart/form-data">
                                      @csrf                    

                                      <div class="row"> 
                                        <div class="col-md-12">
                                          <div class="form-group">
                                            <span>Name</span>
                                            <input type="text" name="name"  value="{{ $item->name }}" required="" class="form-control">     
                                          </div>           
                                        </div>
                                    </div>
                                    <div class="row"> 
                                        <div class="col-md-12">
                                          <div class="form-group">
                                            <span>Parent category</span>
                                            <select class="form-control ss" name="parent_id">
                                              @if ($item->parent_id!=null) 
                                              <?php                   
                                                $category=DB::table('product_categories')
                                                ->where('id', $item->parent_id)
                                                ->first();
                                                ?>
                                                <option value="{{$item->parent_id}}">
                                                  {{$category->name}}</option>
                                              @endif 
                                              
                                              <?php                   
                                              $categories=DB::table('product_categories')
                                              ->where('parent_id', null)
                                              ->where('client_id', session('client_id'))

                                              ->get();
                                              ?>
                                              @foreach($categories as $category) 
                                                <option value="{{$category->id}}">{{$category->name}}</option>
                                              @endforeach  
                                          </select>   
                                          </div>
                                        </div>
                                    </div>          
                                  
                                    <div class="form-group">
                                      <label for="">Image: </label> <br>
                                      <img id="uploadPreview" style="width: 200px; height: 150px; display:none" />
                                      <input id="uploadImage"  type="file" name="image" onchange="PreviewImage();" />
                                    </div>
                                      
                                      <input type="hidden" name="id" value="{{$item->id}}">
                                      <input type="hidden" name="old_parent_id" value="{{$item->parent_id}}">
        
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-info btn-bold px-4">Save changes</button>
                                  </div>
                                </div>
                              </div>
                              </form>
                            </div>                      

                            <!-- edit modal end -->                                                                      

                          <span class="d-lg-inline">
                              <a data-rel="tooltip" title="Delete" href="javascript:void(0)" data-target="#confirm_delete_modal_sub" data-toggle="modal" data-id="{{$item->id}}" class="delete-btn v-hover">
                                  <i class="fa fa-trash text-blue-m1 text-120"></i>
                              </a>
                              <div id="confirm_delete_modal_sub" class="modal fade" aria-modal="true">
                                <div class="modal-dialog modal-dialog-centered modal-confirm">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <div class="icon-box">
                                        <i class="fa fa-times fa-4x"></i>
                                      </div>				
                                      <h4 class="modal-title w-100">Warning! sub</h4>	
                                    </div> 
                                    <div class="modal-body">
                                      <p class="text-center">Are you sure? This action can't be undone.</p>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                      <a href="" class="btn btn-danger delete-sub-category">Delete</a>
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
                      @endif

                      @endforeach

                    
                    </tbody>
                  </table>

              </div>
            </div>


           
      </div>
    </div>

  </div>
 
@endsection