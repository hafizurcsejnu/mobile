
@extends('admin.master')
@section('main_content')    

  <div class="page-content container container-plus">
    <div class="page-header pb-2">
      <h1 class="page-title text-primary-d2 text-150">
      Product Name:  <span style="color: #000; font-weight:600"> {{$data->name}}</span>
      </h1>
      
      <a href="products"class="btn btn-default px-3 text-95 radius-round border-2 brc-black-tp10 float-left">
        <i class="fa fa-plus mr-1"></i>
        <span class="d-sm-none d-md-inline">All</span> Products
      </a>
    </div>   


    <div class="row mt-3">
      <div class="col-12">
        

        <div class="card dcard">
          <div class="card-body px-1 px-md-3">                                   
            <div role="main" class="main-content">         
              <div class="page-content container container-plus">      
             
                <h4 style="float: left">Stock Details:</h4>  
                @php
                    $stocks = DB::table('product_stocks')      
                    ->where('product_id', $data->id)
                    ->where('client_id', session('client_id'))
                    ->orderby('id', 'desc')
                    ->get()
                    ->unique('store_id'); 
                    $total_stock = 0;

                    $product_stock = DB::table('product_stocks')
                        ->where('product_id', $data->id)
                        ->where('client_id', session('client_id'))
                        ->orderby('id', 'desc')
                        ->first();
                @endphp
                
                <table class="table table-striped">
                  <thead>
                    <tr>
                        <th scope="col">SN</th>   
                        <th  scope="col"> Store Title</th>	
                        <th  scope="col"  class="tr"> Quantity</th>
                    </tr>
                  </thead>
                  <tbody>
               
                    @foreach($stocks as $stock)     
                    <tr>
                        <td scope="row">{{$loop->iteration}}</td>
                        @php
                          $store = DB::table('stores')  
                                ->where('id', $stock->store_id)
                                ->first();
                          $total_stock = $total_stock + $stock->store_qty;
                        @endphp  
                       
                        <td>                           
                            <a href="store-details/{{$store->id}}" target="_blank">{{$store->title}}</a>                         
                        </td>
                        <td class="tr">{{$stock->store_qty}}</td>
                    </tr>
                    @endforeach

                    <tr style="font-weight: 600">
                        <td></td>
                        <td class="tr"></td>
                        <td class="tr">Total: {{$total_stock}}</td>
                       
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