
@extends('admin.master2')
@section('main_content')    

  <div class="page-content container container-plus">
  
 

    <div class="row mt-3">
      <div class="col-12">
        <div class="card dcard">
          <div class="card-body px-1 px-md-3">                                   
            <div role="main" class="main-content">         
              <div class="page-content container container-plus">
                <div class="page-header mb-2 pb-2 flex-column flex-sm-row align-items-start align-items-sm-center py-25 px-1">             
                  
                  @php
                  $total_stock = 0;
                  $stocks = DB::table('product_stocks')      
                          ->where('store_id', $data->id)
                          ->where('client_id', session('user.client_id'))
                          ->orderby('id', 'desc') 
                          ->get()
                          ->unique('product_id'); 
                      // $total_stock = DB::table('product_stocks')
                      //               ->where('store_id', $data->id)
                      //               ->where('type', '!=', 'Credit')
                      //               ->sum('qty');
                  @endphp
                  @foreach($stocks as $stock)     
                    @php
                        $total_stock = $total_stock + $stock->store_qty;
                    @endphp
                  @endforeach                
                  <h1 class="page-title text-primary-d2 text-150">
                    Store Name:  <span style="color: #000; font-weight:600"> {{$data->title}} (<span class="@if ($total_stock>0)text-success @else text-danger @endif">{{$total_stock}}</span>)</span> 
                    @if ($data->address != null)
                     <span style="font-size: 16px; color: #000">Address: {{$data->address}}</span>
                     @endif
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
                          <th class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm"></th>
                          <th class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm">SN</th>
                          <th  class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm">Product Title</th>
                          <th  class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm">Qty</th>						
                          <th  class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm"></th>						
                          <th  class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm d-none"> Action </th>  
                      </tr>
                    </thead>

                    <tbody class="pos-rel">
                    @foreach($stocks as $item)                                   
                      <tr class="d-style bgc-h-default-l4">
                      
                        <td class="pl-3 pl-md-4 align-middle pos-rel"></td>
                        <td class="pl-3 pl-md-4 align-middle pos-rel"> {{$loop->iteration}} </td>                  
                       
                      @php
                        $product = DB::table('products')  
                              ->where('id', $item->product_id)
                              ->first();
                      @endphp
                      
                        <td> 
                          @if ($product)
                            <a href="product-stock/{{$product->id}}" target="_blank">{{$product->name}}</a> 
                          @endif 
                        </td>                          
                      
                      <td class="tl">{{$item->store_qty}}</td>
                      <td class="tr"></td>
					

                        <td class="align-middle  d-none">
                          <span class="d-none d-lg-inline">
                              <a  title="Edit" href="edit-purchase/{{$item->id}}" class="v-hover">
                                  <i class="fa fa-edit text-blue-m1 text-120"></i>
                              </a>
                          </span>

                          <span class="d-lg-none text-nowrap">
                              <a title="Edit" href="edit-purchase/{{$item->id}}" class="btn btn-outline-info shadow-sm px-4 btn-bgc-white">
                                  <i class="fa fa-pencil-alt mx-1"></i>
                                  <span class="ml-1 d-md-none">Edit</span>
                          </a>
                          </span>
                                                                                        

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
                                    <a href="" class="btn btn-danger delete-purchase">Delete</a>
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