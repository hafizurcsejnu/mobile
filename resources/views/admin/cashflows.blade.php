
@extends('admin.master')
@section('main_content')    

  <div class="page-content container container-plus">
  
<style>
  i.fa.fa-trash {
      display: block;
  }
</style>

    <div class="row mt-3">
      <div class="col-12">
        <div class="card dcard">
          <div class="card-body px-1 px-md-3">                                   
            <div role="main" class="main-content">         
              <div class="page-content container container-plus">
                <div class="page-header mb-2 pb-2 flex-column flex-sm-row align-items-start align-items-sm-center py-25 px-1">              

                <h1 class="page-title text-primary-d2 text-140">Cash Receives </h1>     
                <a href="add-cashflow" class="btn btn-white px-3 text-95 radius-round border-2 brc-black-tp10 float-right">
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
                          <th class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm" >SN</th>
                          <th  class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm" style="width: 75px;"> Date </th>
                          <th  class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm">Particular</th>														
                          <th  class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm"> Type</th>	
                          
                          <th  class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm"> Amount</th>								
                          <th  class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm"> P. M.</th>					
                          <th  class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm"> Received By</th>					
                          <th  class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm"> Notes </th>  
                          <th  class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm"> Action </th>  
                      </tr>
                    </thead>

                    <tbody class="pos-rel">
                    @foreach($data as $item)                                   
                      <tr class="d-style bgc-h-default-l4">
                      
                        <td class="pl-3 pl-md-4 align-middle pos-rel"></td>
                        <td class="pl-3 pl-md-4 align-middle pos-rel"> {{$loop->iteration}} </td>
                        <td>{{bd($item->date)}}</td> 
                        @if ($item->cashflow_type == 'Investment')
                        <?php                            
                              $customer = DB::table('customers')->where('id', $item->investor_id)->first();?>
                          <td>Investment From @if ($customer) <a href="edit-customer/{{$item->investor_id}}">{{$customer->title}}</a> @endif </td>
                        @else 
                          <td> <a title="Edit" href="edit-cashflow/{{$item->id}}">{{$item->title}}
                        </a></td>
                        @endif


                        @if ($item->cashflow_type == 'Bank Withdraw')
                          <td><a href="bank-statement/{{$item->bank_id}}">{{$item->cashflow_type}}</a></td>
                        @elseif ($item->cashflow_type == 'Company Expense Bill')
                          <td><a href="company-expense-ledger/{{$item->company_id}}">{{$item->cashflow_type}}</a></td>
                        @else 
                          <td>{{$item->cashflow_type}}</td>
                        @endif

                        <td class="price">{{number_format($item->amount_in,2)}}</td>
                        <td>{{$item->payment_method}}</td>
                        <td>{{$item->received_by}}</td>
                        <td>
                          @if ($item->notes != '')
                            <a type="button" class="btn btn-secondary" data-toggle="tooltip" data-placement="top" title="{{$item->notes}}">
                              Notes
                            </a>
                          @endif
                          
                        </td>
					 

                        <td class="align-middle">
                                                                        
                          <span class="d-none d-lg-inline">
                              <a title="Edit" href="edit-cashflow/{{$item->id}}" class="v-hover">
                                  <i class="fa fa-edit text-blue-m1 text-120"></i>
                              </a>
                          </span>

                          <span class="d-lg-none text-nowrap">
                              <a title="Edit" href="edit-cashflow/{{$item->id}}" class="btn btn-outline-info shadow-sm px-4 btn-bgc-white">
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
                                    <a href="" class="btn btn-danger delete-cashflow">Delete</a>
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