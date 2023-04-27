
@extends('admin.master')
@section('main_content')    

  <div class="page-content container container-plus">
    <div class="page-header pb-2">
      <h1 class="page-title text-primary-d2 text-150">
      Store Name:  <span style="color: #000; font-weight:600"> {{$data->title}}</span> @if ($data->address != null)
       <span style="font-size: 16px; color: #000">Address: {{$data->address}}</span>@endif
      </h1>
      
      <a href="stores"class="btn btn-default px-3 text-95 radius-round border-2 brc-black-tp10 float-left">
        <i class="fa fa-plus mr-1"></i>
        <span class="d-sm-none d-md-inline">All</span> Stores
      </a>
    </div>   


    <div class="row mt-3">
      <div class="col-12">
        

        <div class="card dcard">
          <div class="card-body px-1 px-md-3">                                   
            <div role="main" class="main-content">         
              <div class="page-content container container-plus">      
             
                <h4 style="float: left">Product Details:</h4>  
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
                <h4 class="float-right">Total Quantity: <span class="@if ($total_stock>0)text-success @else text-danger @endif"> {{$total_stock}}</span></h4>
                <table class="table table-striped">
                  <thead>
                    <tr>
                        <th scope="col">SN</th>   
                        <th  scope="col"> Product Title</th>	
                        <th  scope="col"> Quantity</th>
                    </tr>
                  </thead>
                  <tbody>
                  
                    @foreach($stocks as $stock)  
                    <tr>
                        <td scope="row">{{$loop->iteration}}</td>
                        @php
                          $product = DB::table('products')  
                                ->where('id', $stock->product_id)
                                ->first();
                        @endphp
                        <td><a href="product-stock/{{$product->id}}" target="_blank">{{$product->name}}</a></td>
                        <td>{{$stock->store_qty}}</td>
                    </tr>
                    @endforeach
                    <tr style="font-weight: 600">
                      <td></td>
                      <td style="float: right">Total:</td>
                      <td>{{$total_stock}}</td>
                      <td></td>
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