
@extends('admin.master')
@section('main_content')    

  <div class="page-content container container-plus">
  


    <div class="row mt-3">
      <div class="col-12">
        <div class="card dcard">
          <div class="card-body px-1 px-md-3">                                   
            <div role="main" class="main-content">         
              <div class="page-content container container-plus">
                <div class="page-header mb-2 pb-2 flex-column flex-sm-row align-items-start align-items-sm-center py-25 px-1">              

                <h1 class="page-title text-primary-d2 text-140">
                  Due Invoices                    
                </h1>     
                <a href="add-invoice"class="btn btn-default px-3 text-95 radius-round border-2 brc-black-tp10 float-left">
                  <i class="fa fa-plus mr-1"></i>
                  <span class="d-sm-none d-md-inline">New</span> Invoice
                </a>

                <div class="page-tools mt-3 mt-sm-0 mb-sm-n1">
                  <!-- dataTables search box will be inserted here dynamically -->
                </div>
              </div>

              <div class="card bcard h-auto">
               

                  <table id="datatable" class="d-style w-100 table text-dark-m1 text-95 border-y-1 brc-black-tp11 collapsed">
                    <!-- add `collapsed` by default ... it will be removed by default -->
                    <!-- thead with .sticky-nav -->
                    <thead class="sticky-nav text-secondary-m1 text-uppercase text-85">
                      <tr>
                        <th class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm"></th>
                        <th class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm">SN</th>
                        <th  class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm"> Date </th>
                        <th  class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm"> Inv ID </th>	
                        <th  class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm" style="width: 20%"> Customer </th>                        
                        <th  class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm" style="width: 15%"> Mobile </th>                        
                        <th  class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm" style="width: 10%"> Total</th>
                        <th  class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm"> Paid </th>                        
                        <th  class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm"> Due </th>                        
                        <th  class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm"> Status </th>                        
                        <th  class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm"> Action </th>                   

                      </tr>
                    </thead>

                    <tbody class="pos-rel">
                    @foreach($order as $order)                                   
                      <tr class="d-style bgc-h-default-l4">  
                      
                        <td class="pl-3 pl-md-4 align-middle pos-rel"></td>						
                        <td class="pl-3 pl-md-4 align-middle pos-rel"> {{$loop->iteration}} </td>						
                        <td>{{bd($order->invoice_date)}}</td>
                        
                        <td> <a  title="Details" href="invoice-<?php if($order->invoice_type == 'on') echo'preview'; else echo 'pos';?>/{{$order->id}}" target="_blank">INV-{{$order->inv_id}} </a></td>
                        
                        <td>
                            <a  title="Edit" href="customer-details/{{$order->customer_id}}">
                              {{ucwords($order->customer)}}
                            </a>
                        </td>   
                        <td>{{$order->mobile}}</td>
                        <td class="tr">{{number_format($order->total_price,2)}}</td>
                        <td class="tr">{{number_format($order->paid_amount,2)}}</td>
                        <td class="text-danger tr">
                          @if($order->due_amount > 0) 
                            {{number_format($order->due_amount, 2)}}
                          @endif                          
                        </td>
                        <td>{{$order->status}}</td>
					

                        <td class="align-middle">
                          <span class="d-none d-lg-inline">
                              <a href="invoice-<?php if($order->invoice_type == 'on') echo'preview'; else echo 'pos';?>/{{$order->id}}" title="Invoice" target="_blank" class="v-hover">
                                  <i class="fa fa-eye text-blue-m1 text-120"></i>
                              </a>
                          </span>
                          @if (session('td')=='Titles')
                            <span class="d-none d-lg-inline">
                                <a  href="delivery-order/{{$order->id}}" title="DO" target="_blank" class="v-hover">
                                    <i class="fa fa-eye text-green-m1 text-120" style="color: green"></i>
                                </a>
                            </span>
                          @endif
                         
                          {{-- <span class="d-none d-lg-inline">
                              <a  title="PDF Download" href="invoice/{{$order->id}}" target="_blank" class="v-hover">
                                  <i class="fa fa-download text-blue-m1 text-120"></i>
                              </a>
                          </span> --}}
                          <span class="d-lg-none text-nowrap">
                              <a title="Print" href="print/{{$order->id}}" class="btn btn-outline-info shadow-sm px-4 btn-bgc-white">
                                  <i class="fa fa-pencil-alt mx-1"></i>
                                  <span class="ml-1 d-md-none">View</span>
                              </a>
                          </span>
                          
                          {{-- <span class="d-none d-lg-inline">
                              <a  title="Edit" href="#" class="v-hover">
                                  <i class="fa fa-print text-blue-m1 text-120"></i>
                              </a>
                          </span>
                          <span class="d-lg-none text-nowrap">
                              <a title="Edit" href="#" class="btn btn-outline-info shadow-sm px-4 btn-bgc-white">
                                  <i class="fa fa-pencil-alt mx-1"></i>
                                  <span class="ml-1 d-md-none">Print</span>
                              </a> 
                          </span> --}}
                                                                                        
                          <span class="d-none d-lg-inline">
                              <a  title="Edit" href="edit-invoice/{{$order->id}}" class="v-hover">
                                  <i class="fa fa-edit text-blue-m1 text-120"></i>
                              </a>
                          </span>
                          <span class="d-lg-none text-nowrap">
                              <a title="Edit" href="edit-invoice/{{$order->id}}" class="btn btn-outline-info shadow-sm px-4 btn-bgc-white">
                                  <i class="fa fa-pencil-alt mx-1"></i>
                                  <span class="ml-1 d-md-none">Edit</span>
                              </a>
                          </span>
                          @if (session('user.user_type') == 'Admin')   

                          <span class="d-none d-lg-inline">
                              <a data-rel="tooltip" title="Delete" href="/delete-invoice/{{$order->id}}" onclick="confirmDelete()" class="v-hover">
                                  <i class="fa fa-trash text-blue-m1 text-120"></i>
                              </a>
                          </span>
                          <span class="d-lg-none text-nowrap">
                              <a title="Delete" href="/delete-invoice/{{$order->id}}" onclick="confirmDelete()"  class="btn btn-outline-info shadow-sm px-4 btn-bgc-white">
                                  <i class="fa fa-trash-alt mx-1"></i>
                                  <span class="ml-1 d-md-none">Delete</span>
                              </a>
                          </span>


                       

                          @endif     


                        </td>
                      </tr>
                      @endforeach

                    
                    </tbody>
                  </table>

              </div>
            </div>


           
      </div>
    </div>

  </div>
 
@endsection