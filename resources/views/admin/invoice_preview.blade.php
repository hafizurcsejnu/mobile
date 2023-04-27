<?php
    use App\Models\Setting;
    $settings = Setting::where('client_id', session('user.client_id'))->first();
    function numToWord1($num = false)
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

@include('reports._report_top1')

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
                    <th style="background-color: #ddd!important; padding-left: 10px" class="tl">{{$settings->product_type}} Name</th> 
                    <th style="background-color: #ddd!important">Quantity</th>
                    <th style="background-color: #ddd!important; width: 15%">Rate</th>                    
                    <th style="background-color: #ddd!important; width: 15%" class="tr">Amount</th>
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
                <tr class="product_row" @if ($data->qty < 0) style="background-color: rgb(228, 222, 222)" @endif>
                    <td scope="row" class="product_title">{{$loop->iteration}}.</td>
                    <td style="text-align:left!important; padding-left: 10px" class="product_title">
                       <a href="../edit-product/{{$data->product_id}}" target="_blank" style="color: #000; text-decoration: none">{{$data->productName}}</a>  <br>
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
                    <td colspan="2" style="max-width: 10%!important" class="b-none"></td>
                
                    <td class="box" style="border: 1px dotted #ddd"><b>Item: {{$order->total_item}}</b></td>   

                    <td class="box tr"><b>Total</b> </td>
                    <td class="box tr"><b>{{number_format($order->total_price + $order->discount_amount, 2)}}</b></td> 
                </tr>

                @if ($order->discount_amount > 0)
                <tr class="">
                    <td colspan="3" class="b-none">&nbsp;</td>
                    <td class="box tr"><b>Discount @if ($order->discount_percentage > 0)
                        ({{$order->discount_percentage}})
                    @endif </b> </td>
                    <td class="box tr"><b>-{{number_format($order->discount_amount, 2)}}</b></td>
                </tr>  
               
                <tr style="margin-top:1px solid #000; ">
                    <td colspan="3" style="max-width: 10%!important" class="b-none"></td>
                    <td class="box tr"><b>Net Price</b> </td>
                    <td class="box tr"><b>{{number_format($order->total_price, 2)}}</b></td> 
                </tr>
                @endif

                @if ($order->previous_due > 0)
                    <tr class="text-success1">         
                        <td colspan="3" class="b-none"></td>
                        <td class="box tr"><b>Previous Due</b> </td>
                        <td class="box tr"><b>{{number_format($order->previous_due, 2)}}</b></td>
                    </tr>    
                    <tr class="text-success1">         
                        <td colspan="3" class="b-none"></td>
                        <td class="box tr"><b>Total Bill</b> </td>
                        <td class="box tr"><b>{{number_format($order->total_bill, 2)}}</b></td>
                    </tr>   
                @endif
               
                <tr class="text-success1">         
                    <td colspan="3" style="text-align: left" class="b-none">Cash in word:  <br> 
                    <td class="box tr"><b>Paid</b> </td>
                    <td class="box tr"><b>{{number_format($order->paid_amount, 2)}}</b></td>
                </tr> 
                <tr class="text-danger1">  
                    <td colspan="3" style="text-align:left; color: #000;font-size: 16px;" class="b-none">
                        <span style="font-weight:600; font-style: italic;">{{ ucwords(numToWord($order->total_bill))}} Taka Only.</span></td>   
                    </td>                 
                    <td class="box tr"><b>Due</b> </td>  
                    <td class="box tr"><b>{{number_format($order->due_amount, 2)}}</b></td>
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
        <h3 style="font-size: 17px;">Payment History:</h3>
        <table class="table tbl_border" style="width: 60%;text-align: center; margin-top: -15px;"> 
                <thead>
                    <tr style="background: #dddddd;">
                        <th>SN</th>
                        <th>Date</th>
                        <th>Method</th>
                        <th>Amount</th>
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
                        <td>Total</td>
                        <td class="tr">{{number_format($order->paid_amount, 2)}}</td>
                    </tr>               
                </tbody>
            </table>
        @endif
        
       
       
       
@include('reports._report_footer1') 