

<?php
use App\Models\Setting;
$settings = Setting::where('client_id', session('user.client_id'))->first();
function justdate($date_time){
	$date_time = explode(' ', $date_time);
	return $date_time[0];
}
function numToWord($num = false)
{
	$num = str_replace(array(',', ''), '' , trim($num));
	if(! $num) {
		return false;
	}
	$num = (int) $num;
	$words = array();
	$list1 = array('', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven',
		'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'
	);
	$list2 = array('', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety', 'hundred');
	$list3 = array('', 'thousand', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion', 'sextillion', 'septillion',
		'octillion', 'nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quattuordecillion',
		'quindecillion', 'sexdecillion', 'septendecillion', 'octodecillion', 'novemdecillion', 'vigintillion'
	);
	$num_length = strlen($num);
	$levels = (int) (($num_length + 2) / 3);
	$max_length = $levels * 3;
	$num = substr('00' . $num, -$max_length);
	$num_levels = str_split($num, 3);
	for ($i = 0; $i < count($num_levels); $i++) {
		$levels--;
		$hundreds = (int) ($num_levels[$i] / 100);
		$hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' hundred' . ( $hundreds == 1 ? '' : '' ) . ' ' : '');
		$tens = (int) ($num_levels[$i] % 100);
		$singles = '';
		if ( $tens < 20 ) {
			$tens = ($tens ? ' and ' . $list1[$tens] . ' ' : '' );
		} elseif ($tens >= 20) {
			$tens = (int)($tens / 10);
			$tens = ' and ' . $list2[$tens] . ' ';
			$singles = (int) ($num_levels[$i] % 10);
			$singles = ' ' . $list1[$singles] . ' ';
		}
		$words[] = $hundreds . $tens . $singles . ( ( $levels && ( int ) ( $num_levels[$i] ) ) ? ' ' . $list3[$levels] . ' ' : '' );
	} //end for loop
	$commas = count($words);
	if ($commas > 1) {
		$commas = $commas - 1;
	}
	$words = implode(' ',  $words);
	$words = preg_replace('/^\s\b(and)/', '', $words );
	$words = trim($words);
	$words = ucfirst($words);
	$words = $words . "";
	return $words;
}
?>

@php
$customer = DB::table('customers')
->where('id',$order->customer_id)
->first();

$user = DB::table('users')
->where('id',$order->created_by)
->first();
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>eDarc</title>
</head>
<body>

  <style>
	  table.table.tbl_product th, td {
			font-size: 12px;
		}
    .invoice_wrapper_pos{
      margin: 0 auto;
      width: 300px;
      padding-right: 3px;
    }
    .top1_left, .top1_right, .tbl_product, {
      font-size: 12px;
    }
    .f14{
      font-size: 12px;
    }
	.f12{
      font-size: 10px;
    }
	.text-center{
		text-align: center;
	}
    .tr{
      text-align: right;
	  padding-right: 3px!important;
    }
    hr {
      border:none;
      border-top:1px dashed #ddd;
      color:#fff;
      background-color:#fff;
      height:1px;
      width:80%;
      }
      .bt{
        border-top:1px dashed #ddd;
        height:1px;
        width:80%;
      }

      .d-none{
        display: none;
      }

@media print {
	table.table.tbl_product th, td {
			font-size: 12px!important;
		}
	.tr{
		text-align: right;
	}
    p.footer_msg{display: block;}
    a{
        text-decoration: none!important;
        color: #000!important;
    }
    /* table th, tr {
        height: 18px!important; 
    } */
    table.table.tbl_border td {
        /* font-size: 14px!important; */
    }
    span.acc{
        color: #fff!important;
    } 
    .footer {
        position: fixed;
        bottom: 0;
        width: 100%;
    }
    .invoice_wrapper {
        width: 100% !important;
        margin: 5px auto;
    }

    div#printableArea img {
        display: block;
        margin-top: 0px;
    }

    div#printableArea {
       
        margin: 0 !important;
        padding: 0 !important;
        overflow: hidden !important;
        visibility: visible;
		padding-bottom: 100px!important;
    }
}


  
  </style>

<div class="invoice_wrapper_pos" id="printableAreaPos" style=""> 
  <div class="pos_header" style="text-align: center">    
    
      <p style="margin:0px; margin-top: 20px;">Invoice</p>
	  <a href="{{URL::to('add-invoice')}}" style="color: #000; text-decoration: none;"><h3 style="border: 1px solid #000;padding: 5px;width: 150px;text-align: center;margin: 0 auto;">eDARC</h3></a> 
		<p class="address" style="margin: 0; margin-bottom: -5px; font-size: 10px!important;"> Address : Isamoti Cinema Hall Market, Bera, Pabna
		</br>Mobile: 01996-977087</br></p>  
      <hr> 
  </div>
  

  
  <table class="table" style="width: 100%; margin-bottom: 0px;margin-top: -10px;">
      <tbody>
          <tr> 
              <td>
                  <table class="table top1_left" style="margin: 0;">
                      <tbody>
						  <tr style="font-size: 12px;"><td>Inv-No</td><td>: <span style="">INV-{{date("Y")}}-{{$order->inv_id}}</span>
							<tr style="font-size: 12px;"><td>Inv Date</td><td>: <span>{{$order->created_at}}</span></td></tr>
                          </td></tr> 
                          <tr style="font-size: 12px;"><td>Customer</td><td>: <span style="font-weight: 500"><a href="../customer-ledger/{{$customer->id}}" style="color: #000!important; text-decoration: none;" target="_blank">{{ucwords($customer->title)}}</a> </span></td></tr>
                          <tr style="font-size: 12px;"><td>Mobile No</td><td>: {{$customer->mobile}}</td></tr>     
                    
						  @php
							$billed_by = DB::table('users')
							->where('id',$order->created_by)
							->first();
							$billed_by = $billed_by->name;
						  @endphp
                          <tr style="font-size: 12px;"><td>Billed By</td><td>: {{$billed_by}}</td></tr>
                          <tr style="font-size: 12px;"><td>P. Status</td><td>: {{$order->status}}</td></tr>    
                      </tbody>
                  </table>          
              </td>
          </tr>
      </tbody>
  </table>
	
	<table class="table tbl_product" style="width: 100%; margin: 0 auto; text-align: center;">
		<thead>
			<tr style="background: #ddd; font-size: 12px;">
				<th>#</th>
				<th style="background-color: #ddd!important; text-align:left;">{{$settings->product_type}} Title</th>
				<th style="background-color: #ddd!important">Qty</th>
				<th style="background-color: #ddd!important">Price</th>                    
				<th style="background-color: #ddd!important; width: 13%" class="tr">Total</th>
			</tr>
		</thead>
		<tbody>

			@php
			$orderDetails = DB::table('order_details')
			->join('products', 'order_details.product_id', '=', 'products.id')
			->select('order_details.*', 'products.name as productName', 'products.warranty as warranty', 'order_details.price as od_price' ,'products.slug as productId' ,
			'products.price', 'products.measurement_unit as mUnit')
			->where('order_id',$order->id)
			->get();
			@endphp

			@foreach ($orderDetails as $data)
			
			{{-- <tr class="product_row" style="font-size: 12px;">
				<td scope="row" class="product_title">{{$loop->iteration}}.</td>
				<td colspan="4" style="text-align:left!important;" class="product_title">
					{{$data->productName}} 				
					@if ($data->warranty != null) <span style="font-weight: normal">-- Warranty: {{$data->warranty}} months</span> @endif 
				</td>
			</tr>
			<tr class="product_row_details" style="font-size: 12px;">
				<td colspan="2">&nbsp;</td>
				<td>{{$data->qty}}</td>
				<td class="tr">{{$data->od_price}}/-</td>
				<td class="tr">{{$data->od_price * $data->qty}}/-</td>
			</tr> --}}
			<tr class="product_row" style="font-size: 12px;">
				<td scope="row" class="product_title">{{$loop->iteration}}.</td>
				<td style="text-align:left!important;" class="product_title">
					{{$data->productName}} 				
					@if ($data->warranty != null) <span style="font-weight: normal">-- Warranty: {{$data->warranty}} months</span> @endif 
				</td>			
				<td>{{$data->qty}}</td>
				<td class="tr">{{$data->od_price}}/-</td>
				<td class="tr">{{$data->od_price * $data->qty}}/-</td>
			</tr>

			@endforeach
			<tr> 
				<td colspan="5" style="border-top: 1px dotted #ddd; margin-bottom:0px; font-size:1px">&nbsp; </td></tr>
			<tr style="margin-top: -20px!important; font-size: 12px; text-align: center">
				<td colspan="2">&nbsp;</td>
				<td colspan="2" class="box tr" style="text-align: right"><b>Total Price:</b> </td>
				<td class="box tr" style="text-align: right"> <b>{{$order->total_price + $order->discount_amount}}</b></td> 
			</tr>

			@if ($order->discount_amount != null)
			<tr class="bt" style="font-size: 12px;">
				<td colspan="2">&nbsp;</td>
				<td colspan="2" class="tr" style="text-align: right"><b>Discount:</b> </td>
				<td class="tr" style="text-align: right">-{{$order->discount_amount}}</td>
			</tr>  
			@endif
			<tr style="border-top:1px solid #000;font-size: 12px; ">
				<td colspan="2">&nbsp;</td>
				<td colspan="2" class="box tr" style="text-align: right"><b>Net Price:</b> </td>
				<td class="box tr" style="text-align: right">{{$order->total_price}}</td> 
			</tr>
			<tr class="text-success" style="font-size: 12px;">         
				<td colspan="2">&nbsp;</td>
				<td colspan="2" class="box tr" style="text-align: right"><b>Paid:</b> </td>
				<td class="box tr" style="text-align: right"><b>{{$order->paid_amount}}</b></td>
			</tr>
			<tr class="text-danger" style="font-size: 12px;">   
				<td colspan="2" style="text-align:left; color: #000;font-size: 18px;">					
				</td>               
				<td colspan="2" class="box tr" style="text-align: right"><b>Due:</b> </td>
				<td class="box tr" style="text-align: right"><b>{{$order->due_amount}}</b></td>
			</tr>
		</tbody>
	</table>
	<p class="f14 text-center" style="font-size: 12px; text-align: center"> <b>Total amount in word:</b>  <br> <i style="font-weight:500;">{{ ucwords(numToWord($order->total_price))}} Taka Only.</i> </p>

	@php
	$payments = DB::table('payments')
	->where('order_id',$order->id)
	->get();
	$total_payments = $payments->count();
	@endphp
	@if($total_payments > 1)
	<h5>Payment History:</h5>
	<table class="table tbl_product" style="width: 100%; text-align: center; margin-top: -15px;"> 
			<thead>
				<tr style="background: #dddddd;font-size: 12px;">
					<th>SN</th>
					<th>Date</th>
					<th>Method</th>
					<th>Amount</th>
				</tr>
			</thead>
			<tbody>
				@foreach($payments as $payment)
					<tr style="font-size: 12px;">
						<td>{{$loop->iteration}}</td>   
						<td>{{justdate($payment->created_at)}}</td>   
						<td>{{$payment->payment_method}}</td>           
						<td class="tr">{{$payment->amount}}</td>     
					</tr>
				@endforeach  
				<tr class="text-bold" style="font-weight: 600; background:#f1f1f1; border: 1px dotted #ddd;font-size: 12px;">
					<td></td> 
					<td></td>
					<td>Total</td>
					<td class="tr">{{$order->paid_amount}}</td>
				</tr>               
			</tbody>
		</table>
	@endif


	
	
	<div class="footer">
		<table class="table" style="width: 100%;text-align: center; margin-top: -15px;"> 
			<tbody>
				<tr>
					<td style="width: 100%; font-size:11px; margin-top:-60px; text-align: center;font-style:italic; color: #000">
						<p>Thanks for shopping with us. Your dream fashion with best quality is our commitment. We look forward to serving you again in the future!</p>
					</td>				  
				</tr>
			</tbody>
		</table>
		<p class="f12" style="font-size: 10px; text-align: center; border: 1px dotted grey; width: 90%; margin: 0px auto 50px auto; padding:5px;">Generated by Business Automation Software. <br> Developed by orDevs. 01794-694159 </p>
		<p style="text-align: center; color:rgb(52, 50, 50); font-size: 9px; margin-top:-40px!important;padding-bottom: 30px;">  &nbsp;  </p>   
		
	</div>
 
	
</div>

<div class="invoice_wrapper" style="text-align: center; margin-top: 50px;">
<button type="button" onclick="printDiv('printableAreaPos')" style="width: 200px;cursor: pointer; ">Print Invoice</button> <br> <br>
{{-- <button> <a href="{{URL::to('invoice')}}/{{$order->id}}" title="PDF Download">Download Invoice</a></button> --}}
<button> <a href="{{URL::to('invoices')}}" >All Invoices</a></button> 
<button> <a href="{{URL::to('add-invoice')}}" >New Invoice</a></button>
</div>

</div>  {{-- wrapper --}}

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