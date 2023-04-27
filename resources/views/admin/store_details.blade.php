
@extends('admin.master')
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
                          ->where('product_id', '!=', 2)
                          ->where('product_id', '!=', 1)
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
                   <span style="color: #000; font-weight:600"> {{$data->title}} (<span class="@if ($total_stock>0)text-success @else text-danger @endif">{{$total_stock}}</span>)</span> 
                    @if ($data->address != null)
                     <span style="font-size: 16px; color: #000">Address: {{$data->address}}</span>
                     @endif
                    </h1>
      
                    
              
            <a href="" data-toggle="modal" data-target="#addNewEntry" class="btn btn-default px-3 text-95 radius-round border-2 brc-black-tp10 float-left">
              <i class="fa fa-plus mr-1"></i>
              Stock <span class="d-sm-none d-md-inline">Adjustment</span>
            </a>
                
            <!-- Modal -->
            <div class="modal fade" id="addNewEntry" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Stock Adjustment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form method="post" action="store_stock_adjustment"  enctype="multipart/form-data">
                    @csrf
                  <div class="modal-body">
            
                      <div class="row d-none"> 
                          <div class="col-md-12">
                            <div class="form-group">
                              <span>Adjustment Note</span>
                              <input type="text" name="note"  placeholder="" class="form-control">     
                            </div>           
                          </div> 
                      </div>
                      <div class="row"> 
                          <div class="col-md-12">
                            <div class="form-group">
                              <span>Product </span>
                              <select class="form-control select2-single" name="product_id" style="width: 100%">
                                
                                <option value="">Select product</option>
                                @php                   
                                $products=DB::table('products')
                                 ->where('client_id', session('client_id')) 
                                 ->where('active','on')
                                 ->orderBy('name','asc')
                                 ->get();      
                                @endphp
                                @foreach($products as $product) 
                                  <option value="{{$product->id}}">{{$product->name}}</option>
                                @endforeach  
                            </select>   
                            </div>
                          </div>
                      </div>    
                      
                      <div class="row"> 
                          <div class="col-md-12">
                            <div class="form-group">
                              <span>Adjusment Type </span>
                              <select class="form-control select2-single" name="type" style="width: 100%">
                                <option value="">Select type</option>                 
                                <option value="Debit">Plus</option>                 
                                <option value="Credit">Minus</option>                 
                            </select>   
                            </div>
                          </div>
                      </div>  
                      
                      <div class="row"> 
                        <div class="col-md-12">
                          <div class="form-group">
                            <span>Adjustment Quantity</span>
                            <input type="text" name="qty" required="" class="form-control">     
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
                          <th  class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm tr">Stock Qty</th>		
                          <th class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm tc">TP</th>					
                          <th class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm tc">Price</th>				
                          <th class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm tc">Stock Value</th>

                          <th  class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm"></th>						
                          <th  class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm d-none"> Action </th>  
                      </tr>
                    </thead>

                    <tbody class="pos-rel">
                    @foreach($stocks as $item)        
                    @php
                      $product = DB::table('products')  
                            ->where('id', $item->product_id)
                            ->first();
                    @endphp  
                    @if ($product)                         
                      <tr class="d-style bgc-h-default-l4">
                      
                        <td class="pl-3 pl-md-4 align-middle pos-rel"></td>
                        <td class="pl-3 pl-md-4 align-middle pos-rel"> {{$loop->iteration}} </td>                       
                        <td>
                          <a href="edit-product/{{$product->id}}" target="_blank">{{$product->name}}</a>
                        </td>
                        <td class="tr">
                          <a href="product-stock-details/{{$product->id}}">{{$item->store_qty}} </a> {{$product->measurement_unit}}
                        </td>
                        <td class="tr">{{$product->tp}}</td>
                        <td class="tr">{{$product->price}}</td>
                        <td class="tr">{{number_format($item->store_qty * $product->price, 2)}}</td>

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