
@extends('admin.master')
@section('main_content')
    

  <div class="page-content container container-plus">
    <div class="page-header pb-2">
      <h1 class="page-title text-primary-d2 text-150">
        Sections       
      </h1>
    </div>

    <div class="row mt-3">
      <div class="col-12">
        <div class="card dcard">
          <div class="card-body px-1 px-md-3">

            <form autocomplete="off">
              <div class="d-flex justify-content-between flex-column flex-sm-row mb-3 px-2 px-sm-0">
                <h3 class="text-125 pl-1 mb-3 mb-sm-0 text-secondary-d4">
                  Popular products
                </h3>

                <div class="pos-rel ml-sm-auto mr-sm-2 order-last order-sm-0">
                  <i class="fa fa-search position-lc ml-25 text-primary-m1"></i>
                  <input type="text" class="form-control w-100 pl-45 radius-1 brc-primary-m4" placeholder="Search ...">
                </div>

                <div class="mb-2 mb-sm-0">
                  <button type="button" class="btn btn-blue px-3 d-block w-100 text-95 radius-round border-2 brc-black-tp10">
                    <i class="fa fa-plus mr-1"></i>
                    Add <span class="d-sm-none d-md-inline">New</span> Entry
                  </button>
                </div>
              </div>

              <table id="simple-table" class="mb-0 table table-borderless table-bordered-x brc-secondary-l3 text-dark-m2 radius-1 overflow-hidden">
                <thead class="text-dark-tp3 bgc-grey-l4 text-90 border-b-1 brc-transparent">
                  <tr>
                    <th class="text-center pr-0">
                      <label class="py-0">
                        <input type="checkbox" class="align-bottom mb-n1 border-2 text-dark-m3">
                      </label>
                    </th>

                    <th>
                      Domain
                    </th>

                    <th>
                      Price
                    </th>

                    <th class="d-none d-sm-table-cell">
                      Clicks
                    </th>

                    <th class="d-none d-sm-table-cell">
                      Update
                    </th>

                    <th class="d-none d-sm-table-cell">
                      Status
                    </th>

                    <th></th>
                    <th></th>
                  </tr>
                </thead>

                <tbody class="mt-1">
                  <tr class="bgc-h-yellow-l4 d-style">
                    <td class="text-center pr-0 pos-rel">
                      <div class="position-tl h-100 ml-n1px border-l-4 brc-orange-m1 v-hover">
                        <!-- border shown on hover -->
                      </div>
                      <div class="position-tl h-100 ml-n1px border-l-4 brc-success-m1 v-active">
                        <!-- border shown when row is selected -->
                      </div>

                      <label>
                        <input type="checkbox" class="align-middle">
                      </label>
                    </td>

                    <td>
                      <a href="#" class="text-blue-d1 text-600 text-95">ace.com</a>
                    </td>

                    <td class="text-600 text-orange-d2">
                      $45
                    </td>

                    <td class="d-none d-sm-table-cell text-grey-d1">
                      3,330
                    </td>

                    <td class="d-none d-sm-table-cell text-grey text-95">
                      Feb 12
                    </td>

                    <td class="d-none d-sm-table-cell">
                      <span class="badge badge-sm bgc-warning-d1 text-white pb-1 px-25">Expiring</span>



                    </td>

                    <td class="text-center pr-0">
                      <div>
                        <a href="#" data-toggle="collapse" data-target="#table-detail-0" class="d-style btn btn-outline-info text-90 text-600 border-0 px-2 collapsed" title="Show Details">
                          <span class="d-none d-md-inline mr-1">
              Details
            </span>
                          <i class="fa fa-angle-down toggle-icon opacity-1 text-90"></i>
                        </a>
                      </div>
                    </td>

                    <td>
                      <!-- action buttons -->
                      <div class="d-none d-lg-flex">
                        <a href="#" class="mx-2px btn radius-1 border-2 btn-xs btn-brc-tp btn-light-secondary btn-h-lighter-success btn-a-lighter-success">
                          <i class="fa fa-pencil-alt"></i>
                        </a>

                        <a href="#" class="mx-2px btn radius-1 border-2 btn-xs btn-brc-tp btn-light-secondary btn-h-lighter-danger btn-a-lighter-danger">
                          <i class="fa fa-trash-alt"></i>
                        </a>
                        <a href="#" class="mx-2px btn radius-1 border-2 btn-xs btn-brc-tp btn-light-secondary btn-h-lighter-warning btn-a-lighter-warning">
                          <i class="fa fa-ellipsis-v mx-1"></i>
                        </a>
                      </div>

                      <!-- show a dropdown in mobile -->
                      <div class="dropdown d-inline-block d-lg-none dd-backdrop dd-backdrop-none-lg">
                        <a href="#" class="btn btn-default btn-xs py-15 radius-round dropdown-toggle" data-toggle="dropdown">
                          <i class="fa fa-cog"></i>
                        </a>

                        <div class="dropdown-menu dd-slide-up dd-slide-none-lg">
                          <div class="dropdown-inner">
                            <div class="dropdown-header text-100 text-secondary-d1 border-b-1 brc-secondary-l2 text-600 mb-2">
                              ace.com
                            </div>
                            <a href="#" class="dropdown-item">
                              <i class="fa fa-pencil-alt text-blue mr-1 p-2 w-4"></i>
                              Edit
                            </a>
                            <a href="#" class="dropdown-item">
                              <i class="fa fa-trash-alt text-danger-m1 mr-1 p-2 w-4"></i>
                              Delete
                            </a>
                            <a href="#" class="dropdown-item">
                              <i class="far fa-flag text-orange-d1 mr-1 p-2 w-4"></i>
                              Flag
                            </a>
                          </div>
                        </div>
                      </div>

                    </td>
                  </tr>

                

                </tbody>
              </table>

              <!-- table footer -->
              <div class="d-flex pl-4 pr-3 pt-35 border-t-1 brc-secondary-l3 flex-column flex-sm-row mt-n1px">
                <div class="text-nowrap align-self-center align-self-sm-start">
                  <span class="d-inline-block text-grey-d2">
      Showing 1 - 10 of 152
    </span>

                  <select class="ml-3 ace-select no-border angle-down brc-h-blue-m3 w-auto pr-45 text-secondary-d3">
                    <option value="10">Show 10</option>
                    <option value="20">Show 20</option>
                    <option value="50">Show 50</option>
                  </select>
                </div>

                <div class="btn-group ml-sm-auto mt-3 mt-sm-0">
                  <a href="#" class="btn btn-lighter-default btn-bgc-white btn-a-secondary radius-l-1 px-3 border-2">
                    <i class="fa fa-caret-left mr-1"></i>
                    Prev
                  </a>
                  <a href="#" class="btn btn-lighter-default btn-bgc-white btn-a-secondary radius-r-1 px-3 border-2 ml-n2px">
                    Next
                    <i class="fa fa-caret-right ml-1"></i>
                  </a>
                </div>
              </div>
            </form>

          </div><!-- /.card-body -->
        </div><!-- /.card -->
      </div><!-- /.col -->
    </div>

  </div>
 
@endsection