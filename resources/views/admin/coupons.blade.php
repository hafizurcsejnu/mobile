@extends('admin.master')
@section('main_content')    

  <div class="page-content container container-plus">
    <div class="page-header pb-2">
      <h1 class="page-title text-primary-d2 text-150">
        Discount coupons        
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
      <form method="post" action="store_coupon"  enctype="multipart/form-data">
        @csrf
      <div class="modal-body">

          <div class="row"> 
              <div class="col-md-12">
                <div class="form-group">
                  <span>Title</span>
                  <input type="text" name="title"  placeholder="Insert title of the coupon" required="" class="form-control">     
                </div>           
              </div>
          </div>
          <div class="row"> 
              <div class="col-md-12">
                <div class="form-group">
                  <span>Coupon code</span>
                  <input type="text" name="code"  placeholder="Coupon code" required="" class="form-control">     
                </div>           
              </div>
          </div>
        
          <div class="row"> 
            <div class="col-md-6">
              <div class="form-group">
                <span>Discount type</span>
                <select class="form-control select2-single" name="discount_type" style="width: 100%">
                  <option value="">Select Discount Type</option>
                    <option value="Flat Rate">Flat Rate</option>
                    <option value="Percentage">Percentage</option>
                    @if ((session('bt') == 'f'))
                      <option value="Feed Qty">Feed Qty</option>
                      <option value="MF">MF</option>
                    @endif
                    
                </select> 
              </div>           
            </div>
            
            <div class="col-md-6">
              <div class="form-group">
                <span>Discount amount</span>
                <input type="text" name="discount_amount"  placeholder="Enter amount" required="" class="form-control">        
              </div>           
            </div>
        </div>


          <div class="row d-none"> 
              <div class="col-md-12">
                <div class="form-group">
                  <span>Product category</span>
                  <select class="form-control" name="category_id">
                    <option value="">Select category</option>
                    <?php                   
                    $categories=DB::table('product_categories')
                    ->where('parent_id', null)
                    ->get();
                    ?>
                    @foreach($categories as $category) 
                      <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach  
                </select>   
                </div>
              </div>
          </div>         
          
          <div class="row  d-none">
            <div class="form-check">                    
                <label class="form-check-label" for="">
                 Active
                </label>
                <input type="checkbox" name="active" checked class="form-check-input" id="">
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
                    Discount coupons  
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
                        <th class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm">Coupon Code</th>                     
                        <th class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm">Discount Amount</th>                     
                        <th class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm">Category </th>                     
                        <th class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm">Active </th>                     

                        <th class="border-0 bgc-white shadow-sm w-2">
                          Action
                        </th>
                      </tr>
                    </thead>  

                    <tbody class="pos-rel">
                    @foreach($data as $item)                                   
                    <tr class="d-style bgc-h-default-l4">
                      <td class="pl-3 pl-md-4 align-middle pos-rel"> {{$loop->iteration}} </td>
                     
                        <td class="pl-3 pl-md-4 align-middle pos-rel"> {{$loop->iteration}} </td>
                        <td> <span class="text-105"> {{$item->title}} </span> </td>
                        <td> <span class="text-105"> {{$item->code}} </span> </td>
                        <td> <span class="text-105"> {{$item->discount_amount}} </span> </td>
                        
                        <td> 
                          <span class="text-105">
                          @if ($item->applied_for==null) For all
                          @else 
                          
                          <?php                   
                            $category=DB::table('product_categories')
                            ->where('id', $item->applied_for)
                            ->first();
                            ?>
                            {{$category->name}}

                          @endif</span> 
                        </td>
                        <td> <span class="text-105">
                            @if($item->active == 'on') 
							<span class="label label-success">Active</span>
							@else
							<span class="label label-warning">Inactive</span>
							@endif
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
                                    Update
                                  </h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  
                                  <form method="post" action="update_coupon" autocomplete="off" enctype="multipart/form-data">
                                    @csrf                    

                                    <div class="row"> 
                                      <div class="col-md-12">
                                        <div class="form-group">
                                          <span>Title</span>
                                          <input type="text" name="title"  value="{{ $item->title }}" required="" class="form-control">     
                                        </div>           
                                      </div>
                                  </div>
                                      
                                 
                                  <div class="row"> 
                                    <div class="col-md-12">
                                      <div class="form-group">
                                        <span>Coupon code</span>
                                        <input type="text" name="code"  value="{{ $item->code }}" required="" class="form-control">     
                                      </div>           
                                    </div>
                                </div>
                                <div class="row"> 
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <span>Discount type</span>
                                        <select class="form-control" name="discount_type">
                                          <option value="{{$item->discount_type}}">
                                            {{$item->discount_type}}</option>
                                            <option value="Flat Rate">Flat Rate</option>
                                            <option value="Percentage">Percentage</option>
                                        </select> 
                                      </div>           
                                    </div>
                                    
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <span>Discount amount</span>
                                        <input type="text" name="discount_amount" value="{{ $item->discount_amount }}" required="" class="form-control">     
                                      </div>           
                                    </div>
                                </div>
                                

                                <div class="row d-none"> 
                                    <div class="col-md-12">
                                      <div class="form-group">
                                        <span>Product category</span>
                                        <select class="form-control" name="category_id">                                          
                                          <?php                   
                                            $category=DB::table('product_categories')
                                            ->where('id', $item->applied_for)
                                            ->first();
                                            if ($category!= null) {   
                                            ?>
                                            <option value="{{$item->applied_for}}">
                                              {{$category->name}}</option>
                                              <?php }?>
                                          

                                          <option value="">Select category</option>                                            
                                          <?php                   
                                          $categories=DB::table('product_categories')
                                          ->where('parent_id', null)
                                          ->get();
                                          ?>
                                          @foreach($categories as $category) 
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                          @endforeach  
                                      </select>   
                                      </div>
                                    </div>
                                </div> 

                                <div class="row d-none"> 
                                  <div class="col-md-12">
                                    {{-- <div class="form-group">                    
                                      <label class="form-check-label" for="exampleCheck2">
                                       Active
                                      </label>
                                      <input type="checkbox" name="active" @if($item->active == 'on') checked
                                      @endif class="form-check-input" id="exampleCheck2">
                                    </div> --}}

                                    <div class="form-group">
                                      <span>Active</span>
                                      <select class="form-control" name="active">  
                                        <option value="on">On</option>    
                                        <option value="">Off</option>    
                                    </select>   
                                    </div>

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
                                    <a href="" class="btn btn-danger delete-coupon">Delete</a>
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