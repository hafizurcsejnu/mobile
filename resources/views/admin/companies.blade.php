
@extends('admin.master')
@section('main_content')    
@php
  use App\Models\Setting;
  $settings = Setting::where('client_id', session('user.client_id'))->first();
@endphp
  <div class="page-content container container-plus">
  


    <div class="row mt-3">
      <div class="col-12">
        <div class="card dcard">
          <div class="card-body px-1 px-md-3">                                   
            <div role="main" class="main-content">         
              <div class="page-content container container-plus">
                <div class="page-header mb-2 pb-2 flex-column flex-sm-row align-items-start align-items-sm-center py-25 px-1">              

                <h1 class="page-title text-primary-d2 text-140">
                  Companies/Brands/Supplier
                    
                </h1>     
				<a href="add-company" class="btn btn-white px-3 text-95 radius-round border-2 brc-black-tp10 float-right">
					<i class="fa fa-plus mr-1"></i>
					Add <span class="d-sm-none d-md-inline">New</span> Entry
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
                          <th  class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm"> Title </th>	
                          <th  class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm"> Company Type </th>	
                          <th  class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm"> Current Balance</th>								
                          <th  class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm"> OB</th>								
                          <th  class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm"> Status </th>
                          <th  class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm"> Action </th>  
                      </tr>
                    </thead>

                    <tbody class="pos-rel">
                    @foreach($data as $item)                                   
                      <tr class="d-style bgc-h-default-l4">                      
                        <td class="pl-3 pl-md-4 align-middle pos-rel"></td>
                        <td class="pl-3 pl-md-4 align-middle pos-rel"> {{$loop->iteration}} </td>                       
                        <td>{{$item->title}}</td>
                        <td>{{$item->company_type}}</td>
                        
                      @php
                        $ob = DB::table('company_accounts')
                          ->where('company_id', $item->id)
                          ->where('type', 'OB')
                          ->orderBy('id', 'desc') 
                          ->first();
                        if($ob != null){
                          $ob = $ob->current_balance;
                        }else{
                          $ob =0;
                        }
                        
                        $ca = DB::table('company_accounts')
                          ->where('company_id', $item->id)
                          ->orderBy('id', 'desc') 
                          ->first();
                        if($ca != null){
                          $cb = $ca->current_balance;
                        }else{
                          $cb =0;
                        }
                    @endphp   
                    
                        <td class="@if ($cb<0) text-danger @endif">{{$cb}}</td>

                        @if ($settings->company_ob == 'on')
                        <td class="center">                         
                          <form action="update_company_ob" method="post" enctype="multipart/form-data">
                            @csrf  
                            <input type="text" class="form-control" id="amount_{{$item->id}}" style="width: 50%;display: inline;" name="amount" value="{{$ob}}">  
                            <input type="hidden" name="company_id" id="company_id_{{$item->id}}" value="{{$item->id}}">                            
                            <button class="btn  btn-default btn_ob" type="button" id="ob_{{$item->id}}" style="margin-top: -5px">Save</button>  
                            <span id="success_msg_{{$item->id}}" style="display: none; font-size: 12px; color: green; width: 100px; ">Done</span>
                            <span id="error_msg_{{$item->id}}" style="display: none; font-size: 12px; color: red; width: 100px; ">Something is wrong</span>
                          </form>                                
                        </td>                         
                      @else
                        <td>{{$ob}}</td>
                      @endif    
                        <td class="center">
                          @if($item->active == 'on') 
                          <span class="label label-success">Active</span>
                          @elseif ($item->active != 'on') 
                          <span class="label label-warning">Inactive</span>
                          @endif
                        </td>

                        <td class="align-middle">
                          <span class="d-none d-lg-inline">
                              <a  title="Edit" href="edit-company/{{$item->id}}" class="v-hover">
                                  <i class="fa fa-edit text-blue-m1 text-120"></i>
                              </a>
                          </span>

                          <span class="d-lg-none text-nowrap">
                              <a title="Edit" href="edit-company/{{$item->id}}" class="btn btn-outline-info shadow-sm px-4 btn-bgc-white">
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
                                    <a href="" class="btn btn-danger delete-company">Delete</a>
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
  <script>
    $(document).ready(function (event) {   
        //coupon code
        $(document).on('click', '.btn_ob', function (event) {
          event.preventDefault();       
          var row_id = $(this).attr('id').split('_').pop();  
          var amount = $('#amount_' + row_id + '').val();
          var company_id = $('#company_id_' + row_id + '').val();
  
          $.ajax({
            url: "update_company_ob",
            data: {
              _token: '{{csrf_token()}}',
              amount: amount,
              company_id: company_id
            },
            type: 'POST',
            success: function (response) {
              console.log(response.data);       
              if(response.success != true){
                $('#error_msg_'+ row_id + '').show();
                $('#success_msg_'+ row_id + '').hide();
                console.log('failed');  
              }else{
                //alert('Stock updated successfully!');
                $('#success_msg_'+ row_id + '').show();
                $('#error_msg_'+ row_id + '').hide();
                var amount = response.data;
                $('#amount_' + row_id + '').innerHTML = amount;
                $('#amount_' + row_id + '').val(amount)
              }  
            }
          });
        });
      });
  </script>
@endsection