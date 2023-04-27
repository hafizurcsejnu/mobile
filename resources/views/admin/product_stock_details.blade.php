
@extends('admin.master')
@section('main_content')    

  <div class="page-content container container-plus">
    <div class="page-header pb-2">
      <h1 class="page-title text-primary-d2 text-150">
      Product Name:  <span style="color: #000; font-weight:600"> {{$product_name}}</span>
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
      
      
      <a href="store-details/{{session('client_id')}}"class="btn btn-default px-3 text-95 radius-round border-2 brc-black-tp10 float-left">
        <i class="fa fa-plus mr-1"></i>
        <span class="d-sm-none d-md-inline">All</span> Product Stock
      </a>
    </div>   


    <div class="row mt-3">
      <div class="col-12">
        

        <div class="card dcard">
          <div class="card-body px-1 px-md-3">                                   
            <div role="main" class="main-content">         
              <div class="page-content container container-plus">      
             
                <h4 style="float: left">Stock Details:</h4>  
               
               
                <table class="table table-striped">
                  <thead>
                    <tr>
                        <th scope="col">SN</th>   
                        <th  scope="col"> Date</th>	
                        <th  scope="col"> Stock Type</th>	
                        <th  scope="col"> Reference</th>	
                        <th  scope="col"  class="tr"> Quantity</th>
                        <th  scope="col"  class="tr"> Available Qty </th>
                    </tr>
                  </thead>
                  <tbody>
               
                    @foreach($data as $stock)     
                    <tr>
                        <td scope="row">{{$loop->iteration}}</td>
                        <td scope="row">{{$stock->created_at}}</td>
                        <td class=""> 
                          @if ($stock->type == 'OB') {{'Opening Balance'}}
                          @elseif ($stock->type == 'Debit') {{'Return'}}
                          @elseif ($stock->type == 'Production') {{'Production'}}
                          @elseif ($stock->type == 'Credit') {{'Sell'}}
                          @elseif ($stock->type == 'Return') {{'Invoice Delete'}}
                          @elseif ($stock->type == 'Removed') {{'Purchase Deleted'}}
                          @elseif ($stock->type == 'Plus') {{'Adjustment(+)'}}
                          @elseif ($stock->type == 'Minus') {{'Adjustment(-)'}}
                          @else {{''}} 
                          @endif   
                        </td>
                        <td>
                          @if ($stock->type == 'Debit')
                          <a href="edit-purchase/{{$stock->purchase_id}}" target="_blank" class="d-none">PurchaseId#{{$stock->purchase_id}}</a>
                          
                          @elseif ($stock->type == 'Credit')
                            <a href="invoice-preview/{{$stock->invoice_id}}" target="_blank"> Inv#@php
                                if ($stock->invoice_id != null) {
                                  $order = DB::table('orders')  
                                      ->where('id', $stock->invoice_id)
                                      ->first();
                                  echo $order->inv_id;                                      
                                }
                            @endphp
                            </a>
                          @elseif ($stock->type == 'Return') {{'-'}}
                          @elseif ($stock->type == 'Removed') {{'-'}}                         
                          @else {{''}}
                          @endif   
                        </td>  
                        <td class="tr">
                          @if ($stock->type == 'OB') {{'+'}}
                          @elseif ($stock->type == 'Debit') {{'+'}}
                          @elseif ($stock->type == 'Credit') {{'-'}}
                          @elseif ($stock->type == 'Return') {{'+'}} 
                          @elseif ($stock->type == 'Production') {{'+'}} 
                          @elseif ($stock->type == 'Removed') {{'-'}} 
                          @elseif ($stock->type == 'Plus') {{'+'}}
                          @elseif ($stock->type == 'Minus') {{'-'}}
                          @else {{''}} 
                          @endif 
                          {{$stock->qty}}
                        </td>
                        <td class="tr">{{$stock->store_qty}}</td>
                    </tr>
                    @endforeach

                    <tr style="font-weight: 600" class="d-none">
                        <td colspan="4"></td>
                        <td class="tr"></td>
                        <td class="tr">Total:  </td>
                       
                      </tr>
                   
                  </tbody>
                </table>
                               
              </div>
            </div>
          </div>
        </div>           
      </div>
    </div>

  </div>
 
@endsection