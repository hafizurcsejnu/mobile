<?php
    use App\Models\Setting;
    $settings = Setting::where('client_id', session('user.client_id'))->first();
    function numToWordBn($num = false)
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

@include('reports._report_header')
<title>INV-{{date("Y")}}-{{$order->inv_id}}</title>

<div style="text-align: center; width: 100%; display: block; margin-top:10px;">
    <span style="font-weight: 600; border: 1px solid #6f6f6f; padding: 5px 30px;">ক্যাশ মেমো</span> 
</div>

@php
$customer = DB::table('customers')
->where('id',$order->customer_id)
->first();

$user = DB::table('users')
->where('id',$order->created_by)
->first(); 
@endphp

<table class="table" style="width: 100%; margin-bottom: 20px;">
    <tbody>
        <tr>
            <td>
                <table class="table top1_left" style="margin: 0;">
                    <tbody>
                        <tr><td>চালান নং</td><td>: <span style="font-weight: 600">INV-{{date("Y")}}-{{$order->inv_id}}</span>                        
                        </td></tr>
                        <tr><td>ক্রেতার নাম </td><td>: <span style="font-weight: 600"><a href="../customer-ledger/{{$customer->id}}" target="_blank">{{ucwords($customer->title)}}</a> </span></td></tr>
                        <tr><td>ঠিকানা</td><td>: {{ucwords($customer->address)}}</td></tr>
                        <tr><td>
                            @if ($customer->email != null)
                            মোবাইল নাম্বার </td><td>: {{$customer->mobile}}
                            @endif 
                        </td></tr>    
                        <tr><td>
                            @if ($customer->email != null)
                            ইমেইল</td><td>: {{$customer->email}}
                            @endif 
                        </td></tr>   
                        
                        
                    </tbody>
                </table>          
            </td>
            <td>
                <table class="table top1_right" style="margin: 0;">
                    <tbody>
                        <tr><td>চালান তারিখ</td><td>: <span style="font-weight: 600">{{bdtime($order->created_at)}}</span></td></tr>
                        <tr><td>চালান প্রিন্ট</td><td>: {{date("d-m-Y")}} {{date("h:i:sa")}}</td></tr>
                        @php
                        $billed_by = DB::table('users')
                        ->where('id',$order->created_by)
                        ->first();
                        $billed_by = $billed_by->name;
                        @endphp
                        <tr><td>বিল তৈরি করেছে</td><td>: {{$billed_by}}</td></tr>
                        <tr><td>পেমেন্ট</td><td>: {{$order->status}}</td></tr>    
                    </tbody>
                </table>          
            </td>
        </tr>
    </tbody>
</table>
       

<style>
    table.tbl_border, table.tbl_border th, table.tbl_border td {
        border: 1px solid #e5e5e5;
        border-collapse: collapse;
    }                
</style>

        
        <table class="table tbl_border" style="width: 100%; margin: 0 auto; text-align: center;">
            <thead>
                <tr style="background: #ddd">
                    <th>#</th>
                    <th style="background-color: #ddd!important; padding-left: 10px" class="tl">পণ্যের নাম </th> 
                    <th style="background-color: #ddd!important">পরিমাণ</th>
                    <th style="background-color: #ddd!important; width: 15%">দর</th>                    
                    <th style="background-color: #ddd!important; width: 15%" class="tr">টাকার পরিমাণ
                    </th>
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
                <tr class="product_row">
                    <td scope="row" class="product_title">{{$loop->iteration}}.</td>
                    <td style="text-align:left!important; padding-left: 10px" class="product_title">
                       <a href="../edit-product/{{$data->product_id}}" target="_blank" style="color: #000; text-decoration: none">{{$data->productName}}  </a>  <br>
                        @if ($data->product_sn != null)                         
                        <span style="font-weight: normal" class="">-- SL: {{$data->product_sn}}</span> @endif 
                        @if ($data->warranty != null) <span style="font-weight: normal"  class="">-- Warranty: {{$data->warranty}} months</span> @endif 
                    </td>                    
                    <td>{{$data->qty}}@if ($data->mUnit!=null) {{$data->mUnit}} @endif</td>
                    <td>{{$data->od_price}}</td>
                    <td class="tr">{{number_format($data->od_price * $data->qty, 2)}}</td>
                </tr>
                @endforeach
                <tr style="margin-top:1px solid #000; ">
                    <td colspan="3" style="max-width: 10%!important" class="b-none"></td>
                    <td class="box tr"><b>মোট টাকা </b> </td>
                    <td class="box tr"><b>{{number_format($order->total_price + $order->discount_amount, 2)}}</b></td> 
                </tr>

                @if ($order->discount_amount != null)
                <tr class="">
                    <td colspan="3" class="b-none">&nbsp;</td>
                    <td class="box tr"><b>ছাড়</b> </td>
                    <td class="box tr"><b>-{{number_format($order->discount_amount, 2)}}</b></td>
                </tr>                 
                <tr style="margin-top:1px solid #000; ">
                    <td colspan="3" style="max-width: 10%!important" class="b-none"></td>
                    <td class="box tr"><b>মোট মূল্য</b> </td>
                    <td class="box tr"><b>{{number_format($order->total_price, 2)}}</b></td> 
                </tr>
                @endif
                <tr class="text-success1">         
                    <td colspan="3" style="text-align: left" class="b-none"><br>  
                        {{-- Cash in word --}}
                    <td class="box tr"><b>পেইড</b> </td>
                    <td class="box tr"><b>{{number_format($order->paid_amount, 2)}}</b></td>
                </tr> 
                <tr class="text-danger1">  
                    <td colspan="3" style="text-align:left; color: #000;font-size: 16px;" class="b-none">
                        <span style="font-weight:600; font-style: italic; display: none">{{ ucwords(numToWord($order->total_price))}} Taka Only.</span></td>   
                    </td>                 
                    <td class="box tr"><b>বাকি</b> </td>  
                    <td class="box tr"><b>{{number_format($order->due_amount, 2)}}</b></td>
                </tr>  
                <tr class="d-none">
                    <td colspan="3" style="text-align: left">
                        {{-- Cash in word:  <br>    
                    <span style="font-weight:600;">{{ ucwords(numToWordBn($order->total_price))}} Taka Only.</span> --}}
                </td> 
                </tr>
 
            </tbody>
        </table>

        @php
        $payments = DB::table('payments')
        ->where('order_id',$order->id)
        ->get();
        $total_payments = $payments->count();
        @endphp

        @if($total_payments > 1)
        <h3 style="font-size: 17px;">অর্থ প্রদান রেকর্ড:</h3>
        <table class="table tbl_border" style="width: 60%;text-align: center; margin-top: -15px;"> 
                <thead>
                    <tr style="background: #dddddd;">
                        <th>#</th>
                        <th>তারিখ</th>
                        <th>পদ্ধতি</th>
                        <th>পরিমাণ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payments as $payment)
                        <tr>
                            <td>{{$loop->iteration}}</td>   
                            <td>{{bdtime($payment->created_at)}}</td>   
                            <td>{{$payment->payment_method}}</td>           
                            <td class="tr">{{number_format($payment->amount, 2)}}</td>     
                        </tr>
                    @endforeach   
                    <tr class="text-bold" style="font-weight: 600; background:#f1f1f1; border: 1px dotted #ddd;">
                        <td></td> 
                        <td></td>
                        <td>মোট</td>
                        <td class="tr">{{number_format($order->paid_amount, 2)}}</td>
                    </tr>               
                </tbody>
            </table>
        @endif
       

        <div class="footer">
            <table class="table" style="width: 100%;text-align: center; margin-top: -15px;"> 
                <tbody>
                    <tr>
                        <td style="width: 70%; padding-right: 100px; margin-top:-50px; text-align: left; font-size: 14px; font-style:italic; color: #000">
                            <p>আমাদের সেরা পণ্য দিয়ে আপনাকে পরিবেশন করা আমাদের প্রধান লক্ষ্য। আমাদের সম্মানিত ক্রেতা হওয়ার জন্য ধন্যবাদ এবং আমরা আমাদের কাছ থেকে ক্রয় চালিয়ে যাওয়ার আশা করি।</p>
                        </td>
                        <td style="width: 30%;">
                            <h3 style="border-top: 2px solid #000; margin-top: 25px;">অনুমোদিত স্বাক্ষর
                            </h3>
                        </td>
                    </tr>
                </tbody>
            </table>
            <p style="text-align: center; border: 1px dotted grey; width: 80%; margin: 50px auto; padding:5px">বিজনেস অটোমেশন সফটওয়্যার দ্বারা তৈরি। <br> সফ্টওয়্যার প্রদানকারী প্রতিষ্ঠান: orDevs (01794-694159)</p>
            <p style="text-align: center; color:rgb(52, 50, 50); font-size: 12px; margin-top:-40px!important; display: none;"></p>           
        </div>
       

    </div>
</div>

<div class="invoice_wrapper" style="text-align: center;">
    <button type="button" onclick="printDiv('printableArea')" style="width: 200px;cursor: pointer; ">Print </button>

    @if ($settings->business_description == 'Titles')
    <button> <a href="{{URL::to('delivery-order')}}/{{$order->id}}" >Delivery Order</a></button>
    @endif
    {{-- <button> <a href="{{URL::to('invoice')}}/{{$order->id}}" title="PDF Download">Download Invoice</a></button> --}}
    <button> <a href="{{URL::to('edit-invoice')}}/{{$order->id}}" title="Update">Update</a></button>
    <button> <a href="{{URL::to('invoices')}}" >All Invoices</a></button>
    <button> <a href="{{URL::to('add-invoice')}}" >New Invoice</a></button>
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