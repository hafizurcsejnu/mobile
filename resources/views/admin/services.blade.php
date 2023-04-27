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
                <div
                  class="page-header mb-2 pb-2 flex-column flex-sm-row align-items-start align-items-sm-center py-25 px-1">

                  <h1 class="page-title text-primary-d2 text-140">
                    @if (session('bt') == 'e')
                        Equipements
                    @else 
                        Services
                    @endif
                  </h1>
      

                  @if ($settings->product_type == 'Product')
                  <a href="add-product2"
                    class="btn btn-white px-3 text-95 radius-round border-2 brc-black-tp10 float-right">
                    <i class="fa fa-plus mr-1"></i>
                    Add <span class="d-sm-none d-md-inline">Product</span>
                  </a>
                  @elseif($settings->product_type == 'Service')
                  <a href="add-service"
                    class="btn btn-white px-3 text-95 radius-round border-2 brc-black-tp10 float-right">
                    <i class="fa fa-plus mr-1"></i>
                    Add <span class="d-sm-none d-md-inline">Service</span>
                  </a>
                  @else
                  <a href="add-product2"
                  class="btn btn-white px-3 text-95 radius-round border-2 brc-black-tp10 float-right">
                  <i class="fa fa-plus mr-1"></i>
                  Add <span class="d-sm-none d-md-inline">Product</span>
                  </a>
                  <a href="add-service"
                    class="btn btn-white px-3 text-95 radius-round border-2 brc-black-tp10 float-right">
                    <i class="fa fa-plus mr-1"></i>
                    Add <span class="d-sm-none d-md-inline">Service</span>
                  </a>

                  @endif

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
                        <th class="td-toggle-details border-0 bgc-white shadow-sm">
                          <i class="fa fa-angle-double-down ml-2"></i>
                        </th>
                        <th class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm">SN</th>
                        <th class="d-none border-0 bgc-white bgc-h-yellow-l3 shadow-sm">Image </th>
                        <th class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm"> 
                          {{$settings->product_type}} Name </th>
                        <th class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm"> Category</th>
                        <th class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm"> Stock</th>
                        <th class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm"> TP</th>
                        <th class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm"> Price</th>
                        <th class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm"> Pack Size</th>
                        @if ($settings->product_type == 'Product/Service')
                        <th class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm"> Type</th>
                        @endif
                        @if (session('client_id') != 11)
                          {{-- <th class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm">Sub Cat.</th>
                          <th class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm">Size</th>  --}}
                        @endif
                                               
                        <th class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm"> Opening Stock </th>
                        <th class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm"> Action </th>

                        <th class="border-0 bgc-white shadow-sm w-2">
                          <!-- the TD will have edit icon -->
                        </th>
                      </tr>
                    </thead>

                    <tbody class="pos-rel">
                      @foreach($data as $item)
                      <tr class="d-style bgc-h-default-l4">
                        <td class="td-toggle-details pos-rel">
                          <div class="position-lc h-95 ml-1px border-l-3 brc-purple-m1">
                          </div>
                        </td>
                      
                        <td>{{$loop->iteration}}</td>

                        {{-- <td class="pl-3 pl-md-4 align-middle pos-rel"> {{$loop->iteration}} </td> --}}
                        <td class="d-none"><a href="{{URL::to('edit-service')}}/{{$item->id}}" target="_blank">
                            <?php if($item->thumbnail!=null) {?>
                            <img src="{{ URL::asset('storage/app/public/'.$item->thumbnail.'') }}" alt="" height="50px"
                              width="50px;">
                            <?php }elseif($images = $item->images !=null) {
                              $images = explode('|', $images);
                            ?>
                            <img src="{{asset('images')}}/{{$images[0]}}" alt="" height="50px" width="50px;">
                            <?php }else{?>

                            <?php }?></a>
                        </td>

                        <td><a href="{{URL::to('log-book')}}/{{$item->id}}" target="_blank" title="">{{$item->name}}</a> </td>
                        <td>{{$item->catName}}</td>
                        @php
                            $product_stock = DB::table('product_stocks')
                            ->where('product_id', $item->id)
                            ->orderBy('id', 'DESC')
                            ->first();
                            if($product_stock){
                              $total_stock = $product_stock->total_qty;
                            }else{
                              $total_stock = 0;
                            }
                            //opening_stock
                            $opening_stock = DB::table('product_stocks')
                            ->where('product_id', $item->id)
                            ->where('type', 'OB')
                            ->orderBy('id', 'DESC')
                            ->first();
                            if($opening_stock){
                              $opening_stock = $opening_stock->total_qty;
                            }else{
                              $opening_stock = 0;
                            }                            
                        @endphp
                        
                        <td><a href="{{URL::to('product-stock-details')}}/{{$item->id}}" target="_blank" title="Stock Details" id="stockQty_{{$item->id}}">{{$total_stock}}</a> </td>
                        <td>{{$item->tp}}</td>
                        <td>{{$item->price}}</td>
                        <td>{{$item->model}}</td>
                        @if ($settings->product_type == 'Product/Service')
                        <td>{{$item->product_type}}</td>
                        @endif
                       
                       

                        @if (session('client_id') != 11)
                        {{-- <td>
                          <?php 
                         
                            if($item->sub_category_id != null){             
                              $sub_category = DB::table('product_categories')                 
                                ->where('id', $item->sub_category_id)
                                ->first(); 
                              if($sub_category) {
                                //echo $sub_category->name;
                              }
                            }
                            ?>
                        </td> --}}

                        {{-- <td>{{$item->model}}</td> --}}
                        @endif

                        @if ($settings->product_ob == 'on')
                          <td class="center">                         
                            <form action="update_stock" method="post" enctype="multipart/form-data">
                              @csrf
                              <input type="text" class="form-control" id="qty_{{$item->id}}" style="width: 100px;display: inline;" name="qty" value="{{$opening_stock}}">  
                              <input type="hidden" name="product_id" id="product_id_{{$item->id}}" value="{{$item->id}}">
                              <input type="hidden" name="store_id" id="store_id_{{$item->id}}" value="{{$settings->client_id}}">
                              <button class="btn  btn-default stock_btn" type="button" id="stockBtn_{{$item->id}}" style="margin-top: -5px">Save</button>  <span id="success_msg_{{$item->id}}" style="display: none; font-size: 12px; color: green; width: 100px; ">Done</span>
                            </form>                               
                          </td>                         
                        @else
                          <td>{{$opening_stock}}</td>
                        @endif                          

                        <td class="align-middle">
                          <span class="d-none d-lg-inline">
                            <a title="Edit" href="edit-@if ($item->product_type == 'Product'){{"product"}}@elseif($item->product_type == 'Service'){{"service"}}@else{{"product"}}@endif/{{$item->id}}" class="v-hover">
                            {{-- <a title="Edit" href="edit-@if ($item->product_type == 'Product'){{"product"}}@elseif($item->product_type == 'Service'){{"service"}}@endif/{{$item->id}}" class="v-hover"> --}}
                              <i class="fa fa-edit text-blue-m1 text-120"></i>
                            </a>
                          </span>
 -
                          <span class="d-lg-none text-nowrap">
                            <a title="Edit" href="edit-product/{{$item->id}}"
                              class="btn btn-outline-info shadow-sm px-4 btn-bgc-white">
                              <i class="fa fa-pencil-alt mx-1"></i>
                              <span class="ml-1 d-md-none">Edit</span>
                            </a>
                          </span>


                          <span class="d-lg-inline">
                            <a data-rel="tooltip" title="Delete" href="javascript:void(0)"
                              data-target="#confirm_delete_modal" data-toggle="modal" data-id="{{$item->id}}"
                              class="delete-btn v-hover">
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
                                    <a href="" class="btn btn-danger delete-product">Delete</a>
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
                        <td></td>
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
      $(document).on('click', '.stock_btn', function (event) {
        event.preventDefault();       
        var row_id = $(this).attr('id').split('_').pop();

        var qty = $('#qty_' + row_id + '').val();
        var store_id = $('#store_id_' + row_id + '').val();
        var product_id = $('#product_id_' + row_id + '').val();

        $.ajax({
          url: "update_stock",
          data: {
            _token: '{{csrf_token()}}',
            qty: qty,
            store_id: store_id,
            product_id: product_id
          },
          type: 'POST',
          success: function (response) {   
            if(response.success != true){
             console.log('failed');  
            }else{
              //alert('Stock updated successfully!');
              $('#success_msg_'+ row_id + '').show();
              var qty = response.data;
              console.log(row_id);
              $('#stockQty_' + row_id + '').text(qty);
              // $('#stockQty_' + row_id).innerHTML = qty;
              // $('#qty_' + row_id + '').val(qty)
            }  
          }
        });
      });
    });
</script>
@endsection