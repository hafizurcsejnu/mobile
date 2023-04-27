
@extends('layouts.master')
@section('main_content')
    

  <div class="page-content container container-plus">
    <div class="page-header pb-2">
      <h1 class="page-title text-primary-d2 text-150">
        My Resumes       
      </h1>
    </div>

    <div class="row mt-3">
      <div class="col-12">
        <div class="card dcard">
          <div class="card-body px-1 px-md-3">

            <form autocomplete="off">
              <div class="d-flex justify-content-between flex-column flex-sm-row mb-3 px-2 px-sm-0">
                <h3 class="text-125 pl-1 mb-3 mb-sm-0 text-secondary-d4">
                 All Resumes
                </h3>               

                <div class="mb-2 mb-sm-0">
                  <a href="/select-template" class="btn btn-blue px-3 d-block w-100 text-95 radius-round border-2 brc-black-tp10">
                    <i class="fa fa-plus mr-1"></i>
                    Add <span class="d-sm-none d-md-inline">New</span> Entry
                  </a>
                </div>

              </div>

              <table id="simple-table" class="mb-0 table table-borderless table-bordered-x brc-secondary-l3 text-dark-m2 radius-1 overflow-hidden">
                <thead class="text-dark-tp3 bgc-grey-l4 text-90 border-b-1 brc-transparent">
                  <tr>                 

                    <th>SN</th>

                    <th>Title</th>

                    <th>Action</th>

                  </tr>
                </thead>

                <tbody class="mt-1">
                  
                  @foreach($data as $item)
                  <tr class="bgc-h-yellow-l4 d-style">
                    <td class="text-center pr-0 pos-rel">
                      {{$loop->iteration}}
                    </td>

                    <td>
                      <a href="/select-resume?id={{$item->id}}" class="text-blue-d1 text-600 text-95">                          
                            {{$item->name}}
                        </a>
                    </td>                 

                    <td>
                      <!-- action buttons -->
                      <div class="d-none d-lg-flex">
                        <a href="/select-resume?id={{$item->id}}" class="mx-2px btn radius-1 border-2 btn-xs btn-brc-tp btn-light-secondary btn-h-lighter-success btn-a-lighter-success">
                          <i class="fa fa-pencil-alt"></i>
                        </a>

                        <a href="/delete-my-resume/{{$item->id}}"  onclick="confirmDelete()" class="mx-2px btn radius-1 border-2 btn-xs btn-brc-tp btn-light-secondary btn-h-lighter-danger btn-a-lighter-danger">
                          <i class="fa fa-trash-alt"></i>
                        </a>
                        <a href="/preview/{{$item->id}}" target="_blank" title="Preview Resume" class="mx-2px btn radius-1 border-2 btn-xs btn-brc-tp btn-light-secondary btn-h-lighter-warning btn-a-lighter-warning">
                          <i class="fa fa-eye mx-1"></i>
                        </a>
                        <a href="/resume/{{$item->id}}" target="_blank" title="Download PDF" class="mx-2px btn radius-1 border-2 btn-xs btn-brc-tp btn-light-secondary btn-h-lighter-warning btn-a-lighter-warning">
                          <i class="fa fa-download mx-1"></i>
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
                              {{$item->id}}
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

                  @endforeach    
               

                  
                

                

                </tbody>
              </table>

              <!-- table footer -->
              <div class="d-flex pl-4 pr-3 pt-35 border-t-1 brc-secondary-l3 flex-column flex-sm-row mt-n1px">
               
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