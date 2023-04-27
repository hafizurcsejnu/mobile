
@extends('admin.master')
@section('main_content')
    
@php
  $sells = DB::table('orders')
  ->where('created_at', 'like', '%' .date("Y-m-d"). '%')
  ->where('active', 'on')
  ->sum('total_price');
  $expenses = DB::table('expenses')->where('created_at', 'like', '%' .date("Y-m-d"). '%')->sum('amount');
@endphp

<style>
.text-nowrap.text-100.text-dark-l2 {
  font-weight: 600;
  border-bottom: 1px solid #e9e9e9;
}
</style>
  <div class="page-content container container-plus">
    <div class="page-header pb-2">
      <h1 class="page-title text-primary-d2 text-150">
        Admin Panel
        <small class="page-info text-secondary-d2 text-nowrap">
          <i class="fa fa-angle-double-right text-80"></i>
          {{-- overview &amp; stats --}}
          Hi {{session('user.name')}},  welcome to your Admin Dashboard!
        </small>
      </h1>
    </div>

    <div class="row mt-3">
      <div class="col-xl-8">
        <div class="row px-3 px-lg-4">
          <div class="col-12">
            <div class="row h-100 mx-n425">

              <div class="col-12 col-sm-4 p-0 pos-rel mt-3 mt-sm-0 pt-0 pt-sm-0 text-center">
                <div class="ccard h-100 d-flex flex-column mx-2 px-2 py-3">
                  <div class="d-flex text-center">
                    <div class="flex-grow-1 mb-3">
                      <div class="text-nowrap text-100 text-dark-l2">
                        Invoices
                      </div>

                      <br>
                      <div>                      
                        <a href="{{URL::TO('add-invoice')}}" type="button" class="btn px-4 btn-outline-primary mb-1">New Invoice</a>
                        <a href="{{URL::TO('invoices')}}" type="button" class="btn px-4 btn-outline-primary mb-1">All Invoices</a>
                      </div>
                    </div>
                  </div>
                
                </div><!-- /.ccard -->
              </div><!-- /.col -->
              <div class="col-12 col-sm-4 p-0 pos-rel mt-3 mt-sm-0 pt-0 pt-sm-0 text-center">
                <div class="ccard h-100 d-flex flex-column mx-2 px-2 py-3">
                  <div class="d-flex text-center">
                    <div class="flex-grow-1 mb-3">
                      <div class="text-nowrap text-100 text-dark-l2">
                        Expenses
                      </div>

                      <br>
                      <div>                      
                        <a href="{{URL::TO('add-expense')}}" type="button" class="btn px-4 btn-outline-primary mb-1">New Expense</a>
                        <a href="{{URL::TO('expenses')}}" type="button" class="btn px-4 btn-outline-primary mb-1">All Expenses</a>
                      </div>
                    </div>
                  </div>
                 
                </div><!-- /.ccard -->
              </div><!-- /.col -->
              <div class="col-12 col-sm-4 p-0 pos-rel mt-3 mt-sm-0 pt-0 pt-sm-0 text-center">
                <div class="ccard h-100 d-flex flex-column mx-2 px-2 py-3">
                  <div class="d-flex text-center">
                    <div class="flex-grow-1 mb-3">
                      <div class="text-nowrap text-100 text-dark-l2">
                        Customers
                      </div>

                      <br>
                      <div>                      
                        <a href="{{URL::TO('add-customer')}}" type="button" class="btn px-4 btn-outline-primary mb-1">Add New</a>
                        <a href="{{URL::TO('customers')}}" type="button" class="btn px-4 btn-outline-primary mb-1">All Customers</a>
                      </div>
                    </div>
                  </div>
                 
                </div><!-- /.ccard -->
              </div><!-- /.col -->



            </div><!-- /.row -->
          </div>

          <div class="col-12 mt-35">
            <div class="row h-100 mx-n425">

              <div class="col-12 col-md-4 px-0 mb-2 mb-md-0">
                <div class="ccard h-100 pt-2 pb-25 px-25 d-flex mx-2 overflow-hidden">
                  <!-- the colored circles on bottom right -->
                  <div class="position-br	mb-n5 mr-n5 radius-round bgc-purple-l3 opacity-3" style="width: 5.25rem; height: 5.25rem;"></div>
                  <div class="position-br	mb-n5 mr-n5 radius-round bgc-purple-l2 opacity-5" style="width: 4.75rem; height: 4.75rem;"></div>
                  <div class="position-br	mb-n5 mr-n5 radius-round bgc-purple-l1 opacity-5" style="width: 4.25rem; height: 4.25rem;"></div>


                  <a href="/invoices" style="text-decoration: none;">
                    <div class="flex-grow-1 pl-25 pos-rel d-flex flex-column">
                    <div class="text-secondary-d4">
                      <span class="text-200">
                        {{$sells}}
                      </span>

                        {{-- <span class="text-md text-danger-m1 align-text-bottom text-nowrap">
                          (20% <i class="ml-2px fa fa-caret-down"></i>)
                        </span> --}}
                    </div>

                    <div class="mt-auto text-nowrap text-secondary-d2 text-105 letter-spacing mt-n1">
                      Sells
                    </div>
                    </div>
                  </a>


                  <div class="ml-auto pr-1 align-self-center pos-rel text-125">
                    <i class="fa fa-shopping-cart text-purple opacity-1 fa-2x mr-25"></i>
                  </div>
                </div><!-- /.ccard -->
              </div><!-- /.col -->



              <div class="col-12 col-md-4 px-0 mb-2 mb-md-0">
                <div class="ccard h-100 pt-2 pb-25 px-25 d-flex mx-2 overflow-hidden">
                  <!-- the colored circles on bottom right -->
                  <div class="position-br	mb-n5 mr-n5 radius-round bgc-blue-l3 opacity-3" style="width: 5.25rem; height: 5.25rem;"></div>
                  <div class="position-br	mb-n5 mr-n5 radius-round bgc-blue-l2 opacity-5" style="width: 4.75rem; height: 4.75rem;"></div>
                  <div class="position-br	mb-n5 mr-n5 radius-round bgc-blue-l1 opacity-5" style="width: 4.25rem; height: 4.25rem;"></div>


                 <a href="/expenses" style="text-decoration: none;">
                    <div class="flex-grow-1 pl-25 pos-rel d-flex flex-column">
                      <div class="text-secondary-d4">
                          <span class="text-200">
                            {{$expenses}}
                          </span>
                        {{-- <span class="text-md text-success-m1 align-text-bottom text-nowrap">
                      (+8% <i class="ml-2px fa fa-caret-up"></i>) --}}
                    </span>
                      </div>
                      <div class="mt-auto text-nowrap text-secondary-d2 text-105 letter-spacing mt-n1">
                      Expences
                      </div>
                    </div>
                  </a> 


                  <div class="ml-auto pr-1 align-self-center pos-rel text-125">
                    <i class="fa fa-bolt text-blue opacity-1 fa-2x mr-25"></i>
                  </div>
                </div><!-- /.ccard -->
              </div><!-- /.col -->



              <div class="col-12 col-md-4 px-0 mb-2 mb-md-0">
                <div class="ccard h-100 pt-2 pb-25 px-25 d-flex mx-2 overflow-hidden">
                  <!-- the colored circles on bottom right -->
                  <div class="position-br	mb-n5 mr-n5 radius-round bgc-orange-l3 opacity-3" style="width: 5.25rem; height: 5.25rem;"></div>
                  <div class="position-br	mb-n5 mr-n5 radius-round bgc-orange-l2 opacity-5" style="width: 4.75rem; height: 4.75rem;"></div>
                  <div class="position-br	mb-n5 mr-n5 radius-round bgc-orange-l1 opacity-5" style="width: 4.25rem; height: 4.25rem;"></div>

<style>
  button.flex-grow-1.pl-25.pos-rel.d-flex.flex-column {
    width: 100%;
    border: none;
    background: transparent;
}
</style>
                  <form action="generate_report" method="post">
                    @csrf
                    <button type="submit" class="flex-grow-1 pl-25 pos-rel d-flex flex-column">
                    <div class="text-secondary-d4">
                      <span class="text-200">
                        N/A
                      </span>
                    </div>

                    <input type="hidden" name="report_title" value="Cash Sheet">
                    <div class="mt-auto text-nowrap text-secondary-d2 text-105 letter-spacing mt-n1">
                      Cash
                    </div>
                  </button>
                  </form>


                  <div class="ml-auto pr-1 align-self-center pos-rel text-125">
                    <i class="fa fa-home text-orange opacity-1 fa-2x mr-25"></i>
                  </div>
                </div><!-- /.ccard -->
              </div><!-- /.col -->


            </div>
          </div>
        </div><!-- /.row -->
      </div>

      <div class="col-xl-4 mt-4 mt-xl-0">
        <div class="card ccard h-100 overflow-hidden">
          <div class="card-header border-0 bgc-white card-header-sm">
            <h6 class="card-title text-dark-l2 pl-25 pt-15 text-110 text-center" style="border-bottom: 1px solid #e9e9e9; font-weight: 600">
              Report Center              
            </h6>
          </div>

          <div class="card-body p-0 bgc-whit flex-grow-1">
            <div class="d-flex align-items-center justify-content-center flex-wrap h-100">
            
              <form action="generate_report" method="post">
                @csrf
                <div class="form-row">
                    <div class="col-md-6">
                        <div class="col">
                            <label>Start Date</label>
                            <input type="date" name="start_date" class="form-control">
                          </div>
                    </div>
                    <div class="col-md-6">
                        <div class="col">
                            <label>End Date</label>
                            <input type="date" name="end_date" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="col">
                            <label></label> 
                            <select  required="ture" name="report_title" class="custom-select">
                                <option value="">Report type</option>
                                <option value="Sales">Sales</option>
                                <option value="Expense">Expense</option>                             
                                <option value="Cash Sheet">Cash Sheet</option>                             
                                
                              </select>
                          </div>
                    </div>

                    <div class="col-md-6">
                        <div class="col">
                            <label></label>
                            <button type="submit" class="form-control">Submit</button>
                        </div>
                    </div>
                </div>
              </form>


            </div>
          </div>
        </div><!-- /.card -->
      </div>
    </div>

    <div class="d-none row pt-3 mt-1 mt-lg-3">
      <div class="col-lg-6 order-last order-lg-first mt-lg-3">
        <div class="card border-0">
          <div class="card-header bg-transparent border-0 pl-1">
            <h5 class="card-title mb-2 mb-md-0 text-120 text-grey-d3">
              <i class="fa fa-star mr-1 text-orange text-90"></i>
              Todays Sells
            </h5>

            <div class="card-toolbar align-self-center">
              <a href="#" data-action="toggle" class="card-toolbar-btn text-grey text-110">
                <i class="fa fa-chevron-up"></i>
              </a>
            </div>
          </div>

          <div class="card-body p-0 ccard overflow-hidden collapse show" style="">
            <table class="table brc-black-tp11">
              <thead class="border-0">
                <tr class="border-0 bgc-dark-l5 text-dark-tp5">
                  <th class="border-0 pl-4">
                    name
                  </th>
                  <th class="border-0">
                    price
                  </th>
                  <th class="border-0">
                    status
                  </th>
                </tr>
              </thead>

              <tbody>
                <tr class="bgc-h-secondary-l4">
                  <td class="text-dark-tp3 opacity-1 text-95 text-600 pl-4">
                    Hoverboard
                  </td>

                  <td>
                    <small><s class="text-danger-m1">$229.99</s></small>
                    <span class="text-success-m1 font-bolder text-95">
              $119.99
            </span>
                  </td>

                  <td>
                    <span class="badge text-75 border-l-3 brc-black-tp8 bgc-info-d2 text-white">on sale</span>
                  </td>
                </tr>
                <tr class="bgc-h-secondary-l4">
                  <td class="text-dark-tp3 opacity-1 text-95 text-600 pl-4">
                    Hiking Shoe
                  </td>

                  <td>
                    <span class="text-info-d2 text-95 font-bolder">
              $46.45
            </span>
                  </td>

                  <td>
                    <span class="badge text-75 border-l-3 brc-black-tp8 bgc-success text-white">approved</span>
                  </td>
                </tr>
                <tr class="bgc-h-secondary-l4">
                  <td class="text-dark-tp3 opacity-1 text-95 text-600 pl-4">
                    Gaming Console
                  </td>

                  <td>
                    <span class="text-info-d2 text-95 font-bolder">
              $355.00
            </span>
                  </td>

                  <td>
                    <span class="badge text-75 border-l-3 brc-black-tp8 bgc-danger text-white">pending</span>
                  </td>
                </tr>
                <tr class="bgc-h-secondary-l4">
                  <td class="text-dark-tp3 opacity-1 text-95 text-600 pl-4">
                    Digital Camera
                  </td>

                  <td>
                    <small><s class="text-danger-m1">$324.99</s></small>
                    <span class="text-success-m1 font-bolder text-95">
              $219.95
            </span>
                  </td>

                  <td>
                    <span class="badge bgc-secondary-l1 text-dark-tp4 border-1 brc-black-tp10"><s>out of stock</s></span>
                  </td>
                </tr>
                <tr class="bgc-h-secondary-l4">
                  <td class="text-dark-tp3 opacity-1 text-95 text-600 pl-4">
                    Laptop
                  </td>

                  <td>
                    <span class="text-info-d2 text-95 font-bolder">
              $899.00
            </span>
                  </td>

                  <td>
                    <span class="badge text-75 border-l-3 brc-black-tp8 bgc-orange text-white">SOLD</span>
                  </td>
                </tr>
                <tr class="bgc-h-secondary-l4">
                  <td class="text-dark-tp3 opacity-1 text-95 text-600 pl-4">
                    Digital Camera
                  </td>

                  <td>
                    <small><s class="text-danger-m1">$324.99</s></small>
                    <span class="text-success-m1 font-bolder text-95">
              $219.95
            </span>
                  </td>

                  <td>
                    <span class="badge bgc-secondary-l1 text-dark-tp4 border-1 brc-black-tp10"><s>out of stock</s></span>
                  </td>
                </tr>
                <tr class="bgc-h-secondary-l4">
                  <td class="text-dark-tp3 opacity-1 text-95 text-600 pl-4">
                    Digital Camera
                  </td>

                  <td>
                    <small><s class="text-danger-m1">$324.99</s></small>
                    <span class="text-success-m1 font-bolder text-95">
              $219.95
            </span>
                  </td>

                  <td>
                    <span class="badge bgc-secondary-l1 text-dark-tp4 border-1 brc-black-tp10"><s>out of stock</s></span>
                  </td>
                </tr>
                <tr class="bgc-h-secondary-l4">
                  <td class="text-dark-tp3 opacity-1 text-95 text-600 pl-4">
                    Digital Camera
                  </td>

                  <td>
                    <small><s class="text-danger-m1">$324.99</s></small>
                    <span class="text-success-m1 font-bolder text-95">
              $219.95
            </span>
                  </td>

                  <td>
                    <span class="badge bgc-secondary-l1 text-dark-tp4 border-1 brc-black-tp10"><s>out of stock</s></span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div class="col-lg-6 order-last order-lg-first mt-lg-3">
        <div class="card border-0">
          <div class="card-header bg-transparent border-0 pl-1">
            <h5 class="card-title mb-2 mb-md-0 text-120 text-grey-d3">
              <i class="fa fa-star mr-1 text-orange text-90"></i>
              Todo List
            </h5>

            <div class="card-toolbar align-self-center">
              <a href="#" data-action="toggle" class="card-toolbar-btn text-grey text-110">
                <i class="fa fa-chevron-up"></i>
              </a>
            </div>
          </div>

          <div class="card-body p-0 ccard overflow-hidden collapse show" style="">
            <div class="card ccard radius-t-0 h-100">
              <div class="position-tl w-102 border-t-3 brc-primary-tp3 ml-n1px mt-n1px"></div><!-- the blue line on top -->

              <div class="card-header brc-secondary-l3 pb-3">
                <h5 class="card-title mb-2 mb-md-0 text-dark-m3">
                  Todo List
                  <span class="text-sm">
                    (Sortable)
                </span>
                </h5>

                <div class="card-toolbar no-border pl-0 pl-md-2">
                  <a href="#" class="btn btn-sm btn-lighter-grey btn-bgc-white btn-h-light-orange btn-a-light-orange text-600 px-25 radius-round">
                    View all
                    <i class="fa fa-arrow-right ml-2 text-90"></i>
                  </a>
                </div>
              </div>

              <div class="card-body bgc-white p-0 pb-15">
                <form autocomplete="off" id="tasks">
                  <div class="task-item d-flex align-items-center bgc-h-green-l3 brc-secondary-l3 px-2 bgc-secondary-l4" draggable="false">
                    <label class="line-through text-grey-d2">
                      <input type="checkbox" class="align-middle input-sm ml-2 mr-25" id="task-item-0">
                    </label>

                    <label class="flex-grow-1 mr-3 py-3 line-through text-grey-d2" for="task-item-0">
                      <span class="align-middle">
                            Answering customer questions
                        </span>
                    </label>



                  </div>
                  <div class="task-item d-flex align-items-center border-t-1 bgc-h-green-l3 brc-secondary-l3 px-2" draggable="false">
                    <label class="">
                      <input type="checkbox" class="align-middle input-sm ml-2 mr-25" id="task-item-1">
                    </label>

                    <label class="flex-grow-1 mr-3 py-3" for="task-item-1">
                      <span class="align-middle">
                            Fixing bugs
                        </span>
                      <i class="fa fa-exclamation-circle text-danger-m2 text-110 align-middle ml-1"></i>
                    </label>

                    <span class="badge bgc-danger-l3 border-r-2 radius-r-0 brc-danger-m2 text-danger-d1 ml-1 mr-2">
                        urgent
                    </span>


                  </div>
                  <div class="task-item d-flex align-items-center border-t-1 bgc-h-green-l3 brc-secondary-l3 px-2">
                    <label>
                      <input type="checkbox" class="align-middle input-sm ml-2 mr-25" id="task-item-2">
                    </label>

                    <label class="flex-grow-1 mr-3 py-3" for="task-item-2">
                      <span class="align-middle">
                            Adding new features
                        </span>
                    </label>


                    <span class="badge bgc-success-l3 border-r-2 radius-r-0 brc-success-m2 text-dark-tp3 ml-1 mr-2">
                        normal
                    </span>

                  </div>
                  <div class="task-item d-flex align-items-center border-t-1 bgc-h-green-l3 brc-secondary-l3 px-2">
                    <label>
                      <input type="checkbox" class="align-middle input-sm ml-2 mr-25" id="task-item-3">
                    </label>

                    <label class="flex-grow-1 mr-3 py-3" for="task-item-3">
                      <span class="align-middle">
                            Upgrading server hardware
                        </span>
                    </label>



                  </div>
                  <div class="task-item d-flex align-items-center border-t-1 bgc-h-green-l3 brc-secondary-l3 px-2">
                    <label>
                      <input type="checkbox" class="align-middle input-sm ml-2 mr-25" id="task-item-4">
                    </label>

                    <label class="flex-grow-1 mr-3 py-3" for="task-item-4">
                      <span class="align-middle">
                            Adding new skins
                        </span>
                    </label>



                    <span class="badge bgc-blue-l3 border-r-2 radius-r-0 brc-blue-m2 text-dark-tp3 ml-1 mr-2">
                        low
                    </span>
                  </div>
                  <div class="task-item d-flex align-items-center border-t-1 bgc-h-green-l3 brc-secondary-l3 px-2">
                    <label>
                      <input type="checkbox" class="align-middle input-sm ml-2 mr-25" id="task-item-5">
                    </label>

                    <label class="flex-grow-1 mr-3 py-3" for="task-item-5">
                      <span class="align-middle">
                            Updating server software
                        </span>
                      <i class="fa fa-exclamation-circle text-danger-m2 text-110 align-middle ml-1"></i>
                    </label>

                    <span class="badge bgc-danger-l3 border-r-2 radius-r-0 brc-danger-m2 text-danger-d1 ml-1 mr-2">
                        urgent
                    </span>


                  </div>
                  <div class="task-item d-flex align-items-center border-t-1 bgc-h-green-l3 brc-secondary-l3 px-2">
                    <label>
                      <input type="checkbox" class="align-middle input-sm ml-2 mr-25" id="task-item-6">
                    </label>

                    <label class="flex-grow-1 mr-3 py-3" for="task-item-6">
                      <span class="align-middle">
                            Cleaning up
                        </span>
                    </label>


                    <span class="badge bgc-success-l3 border-r-2 radius-r-0 brc-success-m2 text-dark-tp3 ml-1 mr-2">
                        normal
                    </span>

                  </div>
                </form>
              </div><!-- /.card-body -->
            </div>
          </div>
        </div>
      </div>

     
    </div>


  </div>
 
@endsection