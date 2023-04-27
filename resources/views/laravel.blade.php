<?
session()->put('job_title', $request->job_title);

?>
{{-- errors showup --}}
@if($errors->any())
    @foreach ($errors->all() as $err)
        <li>{{$err}}</li>
    @endforeach
@endif 


<span style="color:red">@error('name'){{$message}}@enderror</span>


<div class="flash-message">
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
        @if(Session::has('alert-' . $msg))
            <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
        @endif
    @endforeach
  </div>
  