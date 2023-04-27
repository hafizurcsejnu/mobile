@extends('admin.master_invoice')
@section('main_content')


<div class="page-content container container-plus">
  <div class="page-header pb-2">
    <h1 class="page-title text-primary-d2 text-150">
      Invoice Details (ID#{{$order->id}})
    </h1>
    <a href="orders" class="btn btn-default px-3 text-95 radius-round border-2 brc-black-tp10 float-left">
      <i class="fa fa-plus mr-1"></i>
      <span class="d-sm-none d-md-inline">All</span> Invoices
    </a>
  </div>
  <title>Invoice_{{$order->id}}</title>
  <style>
    .shipping {
      margin-left: 50px;
      background: #f3f3f3;
      padding: 25px
    }

    .c_details {
      background: #f3f3f3;
      padding: 25px;
    }

    table th, tr{
    height: 40px;
    }
    td.box{
      border: 1px dotted grey;
    }
    tr.product_row{
        border-bottom: 1px dotted grey;
    }
    .c_details {
        background: #f3f3f3;      
    }

    @media screen {
      div#printableArea img {
        display: none;
      }
    
    }

    @media print {
      body *{
        visibility: hidden;
      }
      div#printableArea img {
        display: block;
        margin-top: 100px;
      }
      table th, tr{
        height: 40px;
      }
      td.box{
        border: 1px dotted grey;
      }
      tr.product_row{
          border-bottom: 1px dotted grey;
      }
      .c_details {
          background: #f3f3f3;      
      }
   
      div#printableArea {
        margin-left: 25px !important;
        margin: 0 !important; 
        padding: 0 !important;
        overflow: hidden!important;
        visibility: visible;
      }
    }
  </style>

  <div class="row mt-3">
    <div class="col-12">
      <div class="card dcard">
        <div class="card-body px-1 px-md-3">
          <div role="main" class="main-content">
          
            <div class="page-content container container-plus" style="padding: 50px; overflow: hidden!important;">
              <div id="printableArea">
                <div class="print_area" style="margin-left:75px; margin-right: 50px; margin-top: 50px; height:100%;overflow: hidden!important;">
                  <div class="row text-center">
                    <h2 class="title" style="width: 100%; display:block;font-weight: 600; font-family: emoji;
                    font-size: 46px;">M/S Sohel Traders</h2> <br>
                    <p style="text-align: center; width:100%; border-bottom: 1px solid grey;"><span style="font-weight: 600">Address:</span> Nagarbari Ghat, Aminpur, Pabna. <span style="font-weight: 600">Mobile:</span> 01711-025685, <span style="font-weight: 600">Website:</span> mssoheltraders.com</p>
                    <hr style="border-bottom: 1px solid grey;">
                    <img src="https://www.planters.com.bd/assets/assets/image/logo.png"
                      style="width:350px; float:right;" alt="">
                  </div>

                  <div class="row">
                    <div class="col-md-12 c_details" style="margin-top: 10px;">
                      {{-- <h5>Customer Details:</h5> --}}
                      @php
                      $customer = DB::table('customers')
                      ->where('id',$order->customer_id)
                      ->first();
                      @endphp
                      <p style="float:left;" >
                        <span style="font-weight: 600">Order By:</span> {{$customer->title}} | <span style="font-weight: 600">Mobile:</span> {{$customer->mobile}}| <span style="font-weight: 600">Status:</span> {{$order->status}} |
                      <span style="font-weight: 600">Order Id:</span> {{$order->id}}<br>
                      </p>

                      <p style="text-align: right"><span style="font-weight: 600">Invoice Date:</span> {{$order->created_at}}</p>
                    </div>
                  </div>


                  <br>
                  <table class="table">
                    <thead>
                      <tr style="background: #ddd">
                        <th scope="col">#</th>
                        <th scope="col">Product Name</th>
                        <th scope="col">Unit Price</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Total Amount</th>
                      </tr>
                    </thead>
                    <tbody>

                      @php
                      $orderDetails = DB::table('order_details')
                      ->join('products', 'order_details.product_id', '=', 'products.id')
                      ->select('order_details.*', 'products.name as productName' ,'products.slug as productId' ,
                      'products.price')
                      ->where('order_id',$order->id)
                      ->get();
                      @endphp

                      @foreach ($orderDetails as $data)
                      <tr>
                        <td scope="row">{{$loop->iteration}}</td>
                        <td><a href="{{URL::to('product')}}/{{$data->productId}}">{{$data->productName}}</a> </td>
                        <td>{{$data->price}} Tk</td>
                        <td>{{$data->quantity}}</td>
                        {{-- <td>${{$data->price * $data->quantity}}</td> --}}
                        <td>{{$data->price * $data->quantity}} Tk</td>
                      </tr>
                      @endforeach

                      @if ($order->discount_amount != null)
                      <tr class="">
                        <td colspan="3">&nbsp;</td>
                        <td><b>Discount Amount</b> </td>
                        <td>-{{$order->discount_amount}} Tk</td>
                      </tr>
                      @endif
                      <tr> 
                        <td colspan="3">&nbsp;</td>
                        <td style=""><b>Total Amount</b> </td>
                        <td><b>{{$order->total_price}} Tk</b></td>
                      </tr>
                      <tr class="text-success">
                        <td colspan="3">&nbsp;</td>
                        <td style=""><b>Paid Amount</b> </td>
                        <td><b>{{$order->paid_amount}} Tk</b></td>
                      </tr>
                      <tr class="text-danger">
                        <td colspan="3">&nbsp;</td>
                        <td style=""><b>Total Due</b> </td>
                        <td><b>{{$order->due_amount}} Tk</b></td>
                      </tr>

                    </tbody>
                  </table>

                  <p style="text-align: center; border: 1px dotted grey;">Generated from Accounting Software. No signature is needed. </p>

                </div>
                {{-- print area--}}
              </div>

              <input type="button" onclick="printDiv('printableArea')" value="Print Invoice"
                style="width: 200px; float:right;" />
              <a href="{{URL::to('orders')}}" class="btn btn-default">Cancel</a>


            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
<script>
  function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;

    window.print();    
    //$("#printarea").print();

    document.body.innerHTML = originalContents;
  }
</script>
@endsection