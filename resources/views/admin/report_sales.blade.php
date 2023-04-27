
@extends('admin.master')
@section('main_content')
    

  <div class="page-content container container-plus">
    <div class="page-header pb-2">
      <h1 class="page-title text-primary-d2 text-150">
      Sales Report   
      </h1>

      <form class="form-inline" method="post" action="sales_report">
          @csrf
        <div class="form-group">
          <label for="email">Starting Month:</label>
          <input type="month" class="form-control" id="start" name="starting_month" min="2018-06" value="" required>
        </div>
        &nbsp;
        <div class="form-group">
          <label for="pwd">Ending Month:</label>
          <input type="month" class="form-control" id="start" name="ending_month" min="2018-06" value="">
        </div>

        &nbsp;  
        <button type="submit" class="btn btn-default">Submit</button>
      </form>

    </div>

            <div class="row">
               
                @if(isset($total) && $total>0)
               
                <h4 class="text-success">Total Records: {{$total}}</h4>               
                
                <div class="export_form float-right">
                    <form action="export-pdf" method="post">
                     @csrf  
                        <input type="hidden" class="form-control" name="starting_month" value="{{$starting_month}}">
                        <input type="hidden" class="form-control" name="ending_month" value="{{$ending_month}}">
                        <button type="submit" name="submit" class="btn btn-success">Export to PDF</button>
                    </form>
                </div>

                <div class="export_form float-right">
                    <form action="export-excel" method="post">
                     @csrf  
                        <input type="hidden" class="form-control" name="starting_month" value="{{$starting_month}}">
                        <input type="hidden" class="form-control" name="ending_month" value="{{$ending_month}}">
                        <button type="submit" name="submit" class="btn btn-default">Export to Excel</button>
                    </form>
                </div>
                <br>
                <br>

                <table class="table table-striped">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Product Id</th>
                        <th scope="col">Price</th>
                        <th scope="col">Order Date</th>
                      </tr>
                    </thead>
                    <tbody>
                   
                        @foreach($data as $item) 
                        <tr>
                            <th scope="row">{{$loop->iteration}}</th>
                            <td>{{$item->name}}</td>
                            <td>{{$item->id}}</td>
                            <td>${{$item->price}}</td>
                            <td>{{$item->created_at}}</td>
                        </tr>
                        @endforeach                       
                    </tbody>
                  </table>

                  @else                              
                    <div class="container flash-message mt-2">
                        <p class="alert alert-warning text-center">
                            No record found.
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                    </div> 
                  @endif

            </div>

     

  </div>
 
@endsection