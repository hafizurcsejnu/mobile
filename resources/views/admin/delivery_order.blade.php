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
<title>DO-{{date("Y")}}-00{{$order->id}}</title>

@include('reports._report_top_do')
        
        <table class="table" style="width: 100%; margin: 0 auto; text-align: center;">
            <thead>
                <tr style="background: #ddd">
                    <th>#</th>
                    <th style="background-color: #ddd!important" class="tl">{{$settings->product_type}} Name</th> 
                    <th style="background-color: #ddd!important">Box</th>
                    <th style="background-color: #ddd!important">Piece</th>
                    <th style="background-color: #ddd!important; width: 20%">Qty(sft)</th>    
                </tr>
            </thead>   
            <tbody>
 
                @php
                $orderDetails = DB::table('order_details')
                ->join('products', 'order_details.product_id', '=', 'products.id')
                ->select('order_details.*', 'products.name as productName', 'products.warranty as warranty', 'order_details.price as od_price' ,'products.id as productId' ,
                'products.price', 'products.measurement_unit as mUnit')
                ->where('order_id',$order->id)
                ->get();
                @endphp

                @php
                    $total_box = 0;
                    $total_pcs = 0;
                    $total_sft = 0;
                @endphp

                @foreach ($orderDetails as $data)
                @php
                    if($data->productId =='1' or $data->productId =='2'){
                        continue;
                    }
                    if ($data->qty_box_pcs == null) {
                        $data->qty_box_pcs = '--_--';
                        $box_pcs = explode("_", $data->qty_box_pcs);
                    }
                    elseif($data->qty_box_pcs == '-_-'){
                        $box_pcs = explode("_", $data->qty_box_pcs);
                        $total_box = $box_pcs[0];
                        $total_pcs = $box_pcs[1];
                        $total_sft = $total_sft + $data->qty;
                    }else{
                        $box_pcs = explode("_", $data->qty_box_pcs);
                        $total_box = $total_box + $box_pcs[0];
                        $total_pcs = $total_pcs + $box_pcs[1];
                        $total_sft = $total_sft + $data->qty;
                    }
                    

                @endphp
                <tr class="product_row">
                    <td scope="row" class="product_title">{{$loop->iteration}}.</td>
                    <td style="text-align:left!important;" class="product_title">
                        {{ucwords($data->productName)}}  
                        @if ($data->product_sn != null) <span style="font-weight: normal" class="">-- SL: {{$data->product_sn}}</span> @endif 
                        @if ($data->warranty != null) <span style="font-weight: normal"  class="">-- Warranty: {{$data->warranty}} months</span> @endif 
                    </td>
                    
                    <td>{{$box_pcs[0]}}</td>
                    <td>{{$box_pcs[1]}}</td>
                    
                    <td class="tr">{{number_format($data->qty, 2)}}</td>
                </tr>
                @endforeach
                <tr style="margin-top:1px solid #000; ">
                    <td colspan="2" style="max-width: 10%!important"></td>
                
                    <td class="box" style="border: 1px dotted #ddd"><b>Total: {{$total_box}} Box</b></td> 
                    <td class="box" style="border: 1px dotted #ddd"><b>Total: {{$total_pcs}} Piece</b></td> 
                    <td class="box tr" style="border: 1px dotted #ddd"><b>Total: {{$total_sft}} Sft</b> </td>
                    
                </tr>

             
                
            </tbody>
        </table>

      
      
       
@include('reports._report_footer1') 