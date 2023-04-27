
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

                <h1 class="page-title text-primary-d2 text-140">Duties </h1>     
                <a href="add-duty" class="btn btn-white px-3 text-95 radius-round border-2 brc-black-tp10 float-right">
                  <i class="fa fa-plus mr-1"></i>Add <span class="d-sm-none d-md-inline">New</span> Entry
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
                          <th  class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm">Ex No</th>				
                          <th  class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm"> Company</th>								
                          <th  class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm"> Total Hours</th>								
                          <th  class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm"> Payment Receive</th>						
                          <th  class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm"> Fuel</th>						
                          <th  class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm"> Expense</th>						
                          <th  class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm"> Action </th>  
                      </tr>
                    </thead>

                    <tbody class="pos-rel">
                    @foreach($data as $item)                                   
                      <tr class="d-style bgc-h-default-l4">
                      
                        <td class="pl-3 pl-md-4 align-middle pos-rel"></td>
                        <td class="pl-3 pl-md-4 align-middle pos-rel"> {{$loop->iteration}} </td>
                        <td>{{bd($item->date)}}</td>
                        <td><a title="Edit" href="log-book/{{$item->equipement_id}}" target="_blank">
                          @php
                               $equipement = DB::table('products')->where('id', $item->equipement_id)->first();  
                                if($equipement){
                                  echo $equipement->name;
                                }
                          @endphp
                          </a>
                        </td>                       
                       

                        
                         <td> 
                          <a title="Customer Ledger" href="customer-ledger/{{$item->customer_id}}" target="_blank">
                          <?php 
                          if ($item->customer_id) {
                          $customer = DB::table('customers')->where('id', $item->customer_id)->first();
                          if($customer){
                            echo $customer->title; 
                          }
                            
                          }                            
                        ?>
                          </a>
                        
                        </td>

                        <td>{{$item->total_hours}}</td>
                        <td>{{$item->payment_receive}}</td>
                        <td>{{$item->fuel_qty.'x'.$item->fuel_rate}} = {{$item->fuel_qty * $item->fuel_rate}}</td>
                        @php
                          $total_expense = DB::table('expenses')->where('duty_id', $item->id)->sum('amount');
                         @endphp
                        <td class="tr">{{number_format($total_expense,2)}}</td>
					

                        <td class="align-middle">
                          <span class="d-none d-lg-inline">
                              <a  title="Edit" href="edit-duty/{{$item->id}}" class="v-hover">
                                  <i class="fa fa-edit text-blue-m1 text-120"></i>
                              </a>
                          </span>

                          <span class="d-lg-none text-nowrap">
                              <a title="Edit" href="edit-duty/{{$item->id}}" class="btn btn-outline-info shadow-sm px-4 btn-bgc-white">
                                  <i class="fa fa-pencil-alt mx-1"></i>
                                  <span class="ml-1 d-md-none">Edit</span>
                          </a>
                          </span>
                                                                                         

                          <span class="d-lg-inline">
                            <a data-rel="tooltip" title="Delete" href="javascript:void(0)" data-target="#confirm_delete_modal" data-toggle="modal" data-id="{{$item->id}}" class="delete-btn v-hover">
                                <i class="fa fa-trash text-blue-m1 text-120"></i>
                            </a>
                            <div id="confirm_delete_modal" class="modal fade" aria-modal="true">
                              <div class="modal-dialog modal-dialog-centered modal-confirm">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <div class="icon-box">
                                      <i class="fa fa-times fa-4x"></i>
                                    </div>				
                                    <h4 class="modal-title w-100">Warning!</h4>	
                                  </div>
                                  <div class="modal-body">
                                    <p class="text-center">Are you sure? This action can't be undone.</p>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <a href="" class="btn btn-danger delete-duty">Delete</a>
                                  </div>
                                </div>
                              </div>
                            </div>                              
                        </span>

                          <span class="d-lg-none text-nowrap">
                              <a title="Edit" href="#" class="btn btn-outline-info shadow-sm px-4 btn-bgc-white">
                                  <i class="fa fa-trash-alt mx-1"></i>
                                  <span class="ml-1 d-md-none">Delete</span>
                          </a>
                          </span>
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