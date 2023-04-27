<?php $menu ='my-account';?>
@extends('layouts.master')
@section('main_content')

<main class="main">
    <div class="page-header text-center" style="background-image: url('{{asset('frontend/images/page-header-bg.jpg')}}')">
        <div class="container">
            <h1 class="page-title">My Account<span></span></h1>
        </div><!-- End .container -->
    </div><!-- End .page-header -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav mb-2">
        <div class="d-none container-fluid">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{URL::to('/')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{URL::to('/3dmodels')}}">Shop</a></li>
                <li class="breadcrumb-item active" aria-current="page">Category</li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->

    <style>
       
        .icon-boxes-container {
        display: none;
        } 
        a.mdl-button {
            margin-left: 5px;
            padding: 5px;
            float: left;
        }
        td.center a {
            margin-top: 2px!important;
            float: left!important;
        }
        .alert-success {
            color: #fff;
            background-color: #89a7c1;
        }
        </style>
    <div class="container flash-message">
        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
            @if(Session::has('alert-' . $msg))
                <p class="alert alert-{{ $msg }} text-center">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
            @endif
        @endforeach
      </div> 


    <div class="page-content mt-3">
        <div class="dashboard">
            <div class="container">
                <div class="row">
                    <aside class="col-md-4 col-lg-3">
                        <ul class="nav nav-dashboard flex-column mb-3 mb-md-0" role="tablist">
                            <li class="nav-item active">
                                <a class="nav-link" id="tab-dashboard-link" data-toggle="tab" href="#tab-dashboard" role="tab" aria-controls="tab-dashboard" aria-selected="true">Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-orders-link" data-toggle="tab" href="#tab-orders" role="tab" aria-controls="tab-orders" aria-selected="false">Orders</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-downloads-link" data-toggle="tab" href="#tab-downloads" role="tab" aria-controls="tab-downloads" aria-selected="false">Downloads</a>
                            </li>
                          
                            <li class="nav-item">
                                <a class="nav-link" id="tab-account-link" data-toggle="tab" href="#tab-account" role="tab" aria-controls="tab-account" aria-selected="false">Account Details</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" style="color:#bf8040" href="{{route('logout')}}">Sign Out</a>
                            </li>
                        </ul>
                    </aside><!-- End .col-lg-3 -->

                    <div class="col-md-8 col-lg-9">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="tab-dashboard" role="tabpanel" aria-labelledby="tab-dashboard-link">
                                <p>Hello, {{ session('user.name') }} <span class="font-weight-normal text-dark"></span> (<a href="{{route('logout')}}">Log out</a>) 
                                <br>
                                From your account dashboard you can view your <a href="#tab-orders" class="tab-trigger-link link-underline">recent orders</a>, download <a href="#tab-downloads" class="tab-trigger-link link-underline">source files</a>, and edit your <a href="#tab-account" class="tab-trigger-link link-underline">password and account details</a>.</p>
                            </div><!-- .End .tab-pane -->

                            <div class="tab-pane fade show" id="tab-orders" role="tabpanel" aria-labelledby="tab-orders-link">

{{-- <h5>Orders</h3> --}}                                

<table id="tableExport" class="display table table-hover table-checkable order-column m-t-20" style="width: 100%">
    <thead>
        <tr>
            <th> Sl No</th>
            <th> Invoice No</th>
            <th> Total Price </th>	
            <th> Order Date</th>
            <th> Action </th>
        </tr>
    </thead>
    <tbody>
    
    <?php 
        $orderData = DB::table('orders')
        ->join('users', 'orders.user_id', '=', 'users.id')       
        ->select('orders.*', 'users.name as userName' , 'users.email', 'users.address' , 'users.city' , 'users.mobile')
        ->where('orders.user_id', session('user_id'))
        ->orderby('orders.id', 'desc')
        ->get();

        $i=1;									
        foreach ($orderData as $order) {			
            ?> 

            <tr class="odd gradeX">
                <td><?php echo $i;?></td>
                <td>INV-{{$order->id}}</td>
                <td>${{$order->total_price}}</td>
                <td>{{$order->created_at}}</td>

                <td class="center">												

                    <button type="button"
                    class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect btn-circle btn-primary"
                    data-toggle="modal" data-target="#exampleModalCenter_{{$order->id}}">View Details</button>

                    <div class="modal fade" id="exampleModalCenter_{{$order->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 50%;">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="exampleModalLongTitle">Order Information</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="cardbox">																		
                                        <form action="update-order-status" method="post">
                                            @csrf
                                        <div class="form-body">
                                            <div class="card-body no-padding height-9">
        
        
        <div class="row list-separated profile-stat">        
            <div class="card-body ">
                <div class="table-scrollable">
                    <table class="table">        
                        <thead>        
                            <tr style="background-color: #ddd;">
                                <th>Product Name</th>
                                <th>Price</th>	
                                <th>Total Price</th> 
                            </tr>
                        </thead>
        
                            <tbody>

                            <?php         
                                $id=$order->id;
                                $orderDetails = DB::table('order_details')
                                ->join('products', 'order_details.product_id', '=', 'products.id')       
                                ->select('order_details.*', 'products.name as productName' , 'products.price')
                                ->where('order_id',$id)
                                ->get();
                            ?>
                                @foreach($orderDetails as $ordDtl) 
                                <tr>        
                                    <th>{{$ordDtl->productName}}</th>
                                    <th>${{$ordDtl->price}}</th>	
                                    <th>${{$ordDtl->price * $ordDtl->quantity}}</th>
                                </tr>
                                @endforeach  
        
                                <tr>
                                    <td>Tax</td>
                                    <td></td>
                                    <td>${{$order->tax}}</td>
                                </tr>	
                                @if ($order->discount_amount>0)   
                                <tr>
                                    <td>Discount</td>
                                    <td></td>
                                    <td>-${{$order->discount_amount}}</td>
                                </tr>	
                                @endif
                                <tr>
                                    <td></td>
                                    <td><span class="badge">Total Payable</span></td>
                                    <td><span class="badge">${{$order->total_price}} </span></td>
                                </tr>
        
                            </tbody>
                        </table>
                    </div>
                </div>
        
            </div>
        
        
        </div>
                                        <input type="hidden" name="id" value="{{$order->id}}">

                                


                                    <div class="modal-footer">
                                        <button type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect btn-circle btn-primary" data-dismiss="modal">Close</button>
                                       
                                        <!-- <button type="submit" class="btn btn-primary">Update changes</button> -->
                                    </div>
                                </form>


                                </div>



                            </div>
                        </div>

                    </div>
                </div>
            </div><br>

        </td>
    </tr>
    <?php $i++;?>
<?php }?>



</tbody>
</table>


                            <p class="d-none">No order has been made yet.</p>
                                <a href="{{route('shop')}}" class="btn btn-outline-primary-2"><span>GO SHOP</span><i class="icon-long-arrow-right"></i></a>
                            </div><!-- .End .tab-pane -->

                            <div class="tab-pane fade" id="tab-downloads" role="tabpanel" aria-labelledby="tab-downloads-link">


                                <table id="tableExport" class="display table table-hover table-checkable order-column m-t-20" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th style="margin-left: 25px;"> Product Name</th>
                                            <th> Price </th>
                                            <th> Download </th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody> 
                                <?php 
                                    $data = DB::table('order_details')
                                    ->join('products', 'order_details.product_id', '=', 'products.id')       
                                    ->select('products.*', 'order_details.price as price')
                                    ->where('user_id',session('user_id'))
                                    ->orderby('order_details.id', 'desc')
                                    ->get();                               
                                
                                        $i=1;									
                                        foreach ($data as $item) {			
                                            ?> 
                                
                                            <tr class="odd gradeX">
                                                <td><?php echo $i;?>.</td>
                                                <td>{{$item->name }}</td>
                                                <td>${{$item->price}}</td> 
                                                <td class="center">	
                                                    <?php 
                                                if ($item->product_type == 'product') {  
                                                    if($item->source_max != null){
                                                        echo '<a href="/download/'.$item->id.'/source_max" 
                                                        class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect btn-circle btn-primary"> Max </a>';
                                                    }
                                                     
                                                    if($item->source_fbx != null){
                                                        echo '<a href="/download/'.$item->id.'/source_fbx" 
                                                        class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect btn-circle btn-primary"> FBX </a>';
                                                    }
                                                    if($item->source_obj != null){
                                                        echo '<a href="/download/'.$item->id.'/source_obj" 
                                                        class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect btn-circle btn-primary"> OBJ </a>';
                                                    }
                                                    if($item->source_blend != null){
                                                        echo '<a href="/download/'.$item->id.'/source_blend" 
                                                        class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect btn-circle btn-primary"> Blend </a>';
                                                    }
                                                    if($item->source_c4d != null){
                                                        echo '<a href="/download/'.$item->id.'/source_c4d" 
                                                        class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect btn-circle btn-primary"> C4D </a>';
                                                    }
                                                    if($item->source_texture != null){
                                                        echo '<a href="/download/'.$item->id.'/source_texture" 
                                                        class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect btn-circle btn-primary"> Texture </a>';
                                                    }
                                                }
                                                if ($item->product_type == 'collection') { ?>

                                                   
                                                    <!-- Collection modal -->
                                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#collections">
                                                                Download Links
                                                            </button>
                                                            
                                                            <!-- Modal -->
                                                            <div class="modal fade" id="collections" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                <div class="modal-content" style="width: 700px;">
                                                                    <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">All products in this collection</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <table class="table">
                                                                            <thead class="collection">
                                                                              <tr>
                                                                                <th scope="col">#</th>
                                                                                <th scope="col">Product Title</th>
                                                                                <th scope="col">Download Links</th>
                                                                              </tr>
                                                                            </thead>
                                                                            <tbody>
                                                <?php 
                                                 $i=0;	
                                                $product_ids = explode(',', $item->product_ids);      
                                                foreach($product_ids as $id){
                                                    $i++;
                                                    $products = DB::table('products')
                                                        ->where('id', $id)
                                                        ->get();                               
                                                    
                                                   		
                                                    foreach ($products as $collection_item) {?>
                                                                              <tr>
                                                                                <td>{{$i}}</td>
                                                                                <td>{{$collection_item->name}}</td>
                                                                                <td>
                                                        <?php 
                                                            if($collection_item->source_max != null){
                                                                echo '<a href="/download-collection/'.$collection_item->id.'/source_max/'.$item->id.'" 
                                                                class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect btn-circle btn-primary"> Max </a>';
                                                            }                                                            
                                                            if($collection_item->source_fbx != null){
                                                                echo '<a href="/download-collection/'.$collection_item->id.'/source_fbx/'.$item->id.'" 
                                                                class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect btn-circle btn-primary"> FBX </a>';
                                                            }
                                                            if($collection_item->source_obj != null){
                                                                echo '<a href="/download-collection/'.$collection_item->id.'/source_obj/'.$item->id.'" 
                                                                class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect btn-circle btn-primary"> OBJ </a>';
                                                            }
                                                            if($collection_item->source_blend != null){
                                                                echo '<a href="/download-collection/'.$collection_item->id.'/source_blend/'.$item->id.'" 
                                                                class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect btn-circle btn-primary"> Blend </a>';
                                                            }
                                                            if($collection_item->source_c4d != null){
                                                                echo '<a href="/download-collection/'.$collection_item->id.'/source_c4d/'.$item->id.'" 
                                                                class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect btn-circle btn-primary"> C4D </a>';
                                                            }
                                                            if($collection_item->source_texture != null){
                                                                echo '<a href="/download-collection/'.$collection_item->id.'/source_texture/'.$item->id.'" 
                                                                class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect btn-circle btn-primary"> Texture </a>';
                                                            }
                                                            ?></td>
                                                                              </tr>
                                                                                     
                                                      <?php  }
                                                        }
                                                      ?>
                                                                             
                                                                            </tbody>
                                                                          </table>

                                                                   
                                                  
                                                                                                                    
                                                    
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>                                                                   
                                                                    </div>
                                                                </div>
                                                                </div>
                                                            </div>
                                                    <?php }?>
                                                    
                                                </td>
                                    </tr>
                                    <?php $i++;?>
                                <?php }?>
                                
                                
                                
                                </tbody>
                                </table>

                                <p class="d-none">No downloads available yet.</p>
                                <a href="{{URL::to('/3dmodels')}}" class="btn btn-outline-primary-2"><span>GO SHOP</span><i class="icon-long-arrow-right"></i></a>
                            </div><!-- .End .tab-pane -->

                          

       

                            <div class="tab-pane fade" id="tab-account" role="tabpanel" aria-labelledby="tab-account-link">

                                <div class="flash-message">
                                    <div id="message"></div>
                                </div>

                                <?php 
                                $data = DB::table('users')
                                ->where('id', session('user_id'))
                                ->first();		
                                ?> 
                                <form>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label>Full Name *</label>
                                            <input type="text" name="name" id="name" class="form-control" value="{{$data->name}}" required="">
                                        </div><!-- End .col-sm-6 -->
                                    </div><!-- End .row -->

                                    <label>Email address</label>
                                    <input type="email"  readonly="readonly"  name="email" id="email" class="form-control" value="{{$data->email}}"   required="">

                                    <label>Current password </label>
                                    <input type="password" required name="current_password" id="current_password" placeholder="leave blank to keep unchanged" class="form-control">

                                    <label>New password </label>
                                    <input type="password" name="new_password" id="new_password" placeholder="leave blank to keep unchanged" class="form-control">
                                    <label>Confirm password </label>
                                    <input type="password" name="confirm_password" id="confirm_password" placeholder="leave blank to keep unchanged" class="form-control">

                                    <span><i>The password must be at least 8 characters containing with a number and a sign letter.</i> </span>


                                    <br>
                                    <br>
                                    <button type="submit" id="accountUpdate" class="btn btn-outline-primary-2">
                                        <span>SAVE CHANGES</span>
                                        <i class="icon-long-arrow-right"></i>
                                    </button>

                                  </div>

                                    {{-- <label>Confirm new password</label>
                                    <input type="password" name="new_password" id="new_password" class="form-control mb-2"> --}}

                                  
                                </form>
                            </div><!-- .End .tab-pane -->
                        </div>
                    </div><!-- End .col-lg-9 -->
                </div><!-- End .row -->
            </div><!-- End .container -->
        </div><!-- End .dashboard -->
    </div>
   
</main>


<script>    
    $( document ).ready(function() {
        // signup start
        $('#accountUpdate').click(function (event){  
            event.preventDefault();            
            var name = $('#name').val();
            var email=$('#email').val();              
            var current_password=$('#current_password').val();   
            var new_password=$('#new_password').val();   
            var confirm_password=$('#confirm_password').val();   
                            
            $.ajax({
            url:"update_user",
            data: {
                _token: '{{csrf_token()}}',
                name: name, email: email, current_password:current_password, new_password:new_password, confirm_password:confirm_password
            },
            type: 'POST',
            success: function(response){                        
                console.log(response);  
                if(response.success==true){  
                   var string = '<p class="alert alert-success">'+response.data+'</p>';
                   $('#message').html(string);
                }
                else{
                  var string = '<p class="alert alert-danger">'+response.data+'</p>';
                   $('#message').html(string); 
                } 
              
            }
            });

          });
    // coupon end
});
</script>
@endsection