<option value="">Select type</option>  
@if (session('bt') == 'e')
  <option value="Ex Expense">Ex Expense</option> 
@endif

{{-- custom data lookup --}}
@php
    $data_lookups = DB::table('data_lookups')
      ->where('client_id', session('client_id'))
      ->where('data_type', 'Expense Type')
      ->get();
@endphp
@foreach($data_lookups as $item) 
  <option value="{{$item->title}}">{{$item->title}}</option>
@endforeach 
{{-- end custom data lookup --}}

<option value="Boss Personal">Boss Personal</option> 
<option value="Boucher Bill">Boucher Bill</option> 
<option value="Office Expense">Office Expense</option> 
<option value="Stationery">Stationery</option> 
<option value="Entertainement">Entertainement</option> 
<option value="Transport">Transport</option> 
<option value="Product Purchase">Product Purchase</option>  
<option value="Advance Payment">Advance Payment</option>  
<option value="General Purchase">General Purchase</option>  
<option value="Office Rent">Office Rent</option>  
<option value="Electricity Bill">Electricity Bill</option>  
<option value="Internet Bill">Internet Bill</option>  
<option value="Salary Pay">Salary Pay</option>  
<option value="Bonous Pay">Bonous Pay</option>
<option value="Overtime Bill">Overtime Bill</option>   
<option value="Honorarium Pay">Honorarium Pay</option>  
<option value="Loan Pay">Loan Pay</option> 
<option value="Software Bill">Software Bill</option> 
@if (session('bt') == 'p')
  <option value="Labour Bill">Labour Bill</option> 
  <option value="Machinaries Purchase">Machinaries Purchase</option> 
@endif
<option value="Others">Others</option> 
