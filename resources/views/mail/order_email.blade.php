Hello {{$email_data['name']}},
<br>
Thanks for your order!
<br>
<h3>Here is your Order Details:</h3> 

<div style=" background-color:#f9f9f9; padding:5px;">
<table  style="width:80%; margin:0 auto;">
    <thead style="text-align:left">
        <tr style="background:#a3d0e2">
            <th>SN</th>
            <th>Product Name</th>
            <th>Price</th>
            <th>Download Link</th>
        </tr>
    </thead>
    <tbody>

    
    <?php 
         $data =  DB::table('order_details')
        ->join('products', 'order_details.product_id', '=', 'products.id')       
        ->select('products.*', 'order_details.price as price', )          
        ->where('order_id',  $email_data['order_id'])
        ->get(); 
        ?>
    @foreach ($data as $item)
    <tr>
        <td>{{$loop->iteration}}</td>
        <td>{{$item->name}}</td>
        <td>${{$item->price}}</td>
        <td class="center">	
            <?php 
         if($item->source_max != null){
            echo '<a href="https://ready3dmodels.com/download/'.$item->id.'/source_max" 
            class=""> Max </a> |';
          }
        
         if($item->source_fbx != null){
            echo '<a href="https://ready3dmodels.com/download/'.$item->id.'/source_fbx" 
            class=""> FBX </a> |';
          }
         if($item->source_obj != null){
            echo '<a href="https://ready3dmodels.com/download/'.$item->id.'/source_obj" 
            class=""> OBJ </a> |';
          }
         if($item->source_blend != null){
            echo '<a href="https://ready3dmodels.com/download/'.$item->id.'/source_blend" 
            class=""> Blend </a> |';
          }
          if($item->source_c4d != null){
            echo '<a href="https://ready3dmodels.com/download/'.$item->id.'/source_c4d" 
            class=""> C4D </a> |';
          }
       
          ?>
            
        </td>        
    </tr>
    @endforeach
    <?php 
         $order =  DB::table('orders')         
        ->where('id',  $email_data['order_id'])
        ->first(); 
        ?>
    @if ($order->discount_amount>0)   
    <tr style="background-color: #f9f9f9; font-weight:600;">
        <td></td>
        <td>Discount</td>
        <td>-${{$order->discount_amount}}</td>
        <td></td>
    </tr>	
    @endif
    <tr style="background-color: #f9f9f9; font-weight:600;">
        <td></td>
        <td><span class="badge">Total Price</span></td>
        <td><span class="badge">${{$order->total_price}} </span></td>
        <td></td>
    </tr>
  
</tbody>
</table>
</div>

<br> <br>
Thank you!
<br>
{{env('APP_NAME')}} Team.
