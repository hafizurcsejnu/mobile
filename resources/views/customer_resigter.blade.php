@extends('pages.master')
@section('main_content')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<style>
    label.control-label.col-md-3 {
    text-align: right;
}
</style>

<div class="tm-top-a-box tm-full-width tm-box-bg-1 ">
    <div class="uk-container uk-container-center">
        <section id="tm-top-a" class="tm-top-a uk-grid uk-grid-collapse" data-uk-grid-match="{target:'> div > .uk-panel'}" data-uk-grid-margin="">

            <div class="uk-width-1-1 uk-row-first">
                <div class="uk-panel">
                    <div class="uk-cover-background uk-position-relative head-wrap" style="height: 290px; background-image: url('images/head-bg.jpg');">
                        <img class="uk-invisible" src="{{asset('frontend/images/head-bg.jpg')}}" alt="" height="290" width="1920">
                        <div class="uk-position-cover uk-flex uk-flex-center head-title">
                            <h1>নিবন্ধকরণ</h1>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

    <br>
    <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <?php 
            $exception= Session::get('exception');
            if (isset($exception)) {
              echo "<div class=\"alert alert-danger\" role=\"alert\">";
              echo $exception;
              echo "</div>";
              Session::put('exception');
            }

            $message= Session::get('message');
            if (isset($message)) {
              echo "<div class=\"alert alert-success\" role=\"alert\">";
              echo $message;
              echo "</div>";
              Session::put('message');
            }      
        ?>


            <br>
            <div class="card">
                <div class="card-header" style="background:#ddd;padding:15px; margin-bottom:15px; font-weight:600;color:#000">User Register</div>

                <div class="card-body">
                   
                   {{-- {!! Form::open(['url'=>'save-customer','class'=>'form', 'method'=>'post']) !!}
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">Full Name</label>

                            <div class="col-md-6">
                                <input id="email" type="text" class="form-control" name="name" placeholder="Enter full name" value="" required="" autofocus="">
							</div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email"  placeholder="Enter your email"  type="email" class="form-control" name="email" value="" required="" autofocus="">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                            <div class="col-md-6">
                                <input id="password" placeholder="Enter password"  type="password" class="form-control" name="password" required="">
                             </div>
                        </div>
                     

                         <div class="form-group row mb-0">
                            <div class="col-md-4"></div>
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>

                                <p>Already registerd? <a href="{{URL::to('/login')}}">Login here.</a></p>
                            
                            </div>
                        </div>                       
                   {!! Form::close()!!} --}}


                   {!! Form::open(['url'=>'save-customer-admin','class'=>'form-horizontal', 'id'=>'form_sample_1', 'method'=>'post' , 'enctype'=>'multipart/form-data'])!!}

<div class="form-body">
<div class="form-group row">
    <label class="control-label col-md-3">Name
        <span class="required"> * </span>
    </label>
    <div class="col-md-7">
        <input type="text" name="name" data-required="1" placeholder="Enter name" class="form-control input-height" /> </div>
</div>

<div class="form-group row">
    <label class="control-label col-md-3">Father's Name
        <span class="required"> * </span>
    </label>
    <div class="col-md-7">
        <input type="text" name="father" data-required="1" placeholder="Enter father's name" class="form-control input-height" /> </div>
</div>

<div class="form-group row">
    <label class="control-label col-md-3">Mother's Name
        <span class="required"> * </span>
    </label>
    <div class="col-md-7">
        <input type="text" name="mother" data-required="1" placeholder="Enter mother's name" class="form-control input-height" /> </div>
</div>

    <div class="form-group row">
        <label class="control-label col-md-3">Role
            <span class="required"> * </span>
        </label>
        <div class="col-md-7">
            <select class="form-control input-height" name="customer_type">
                <option value="">Select...</option>
                <option value="Junior Player">Junior Player</option>
                <option value="Senior Player">Senior Player</option>
                <option value="Clab Member">Clab Member</option>
            </select>
        </div>
    </div>

    
    <div class="form-group row">
        <label class="control-label col-md-3">Email
        </label>
        <div class="col-md-7">
            <div class="input-group">
                <span class="input-group-addon">
                        <i class="fa fa-envelope"></i>
                    </span>
                <input type="text" class="form-control input-height" name="email" placeholder="Email address"> </div>
        </div>
    </div>
    {{-- <div class="form-group row">
        <label class="control-label col-md-3">Password
            <span class="required"> * </span>
        </label>
        <div class="col-md-7">
            <input type="password" name="pswd" data-required="1" placeholder="enter Password" class="form-control input-height" /> </div>
    </div>
    <div class="form-group row">
        <label class="control-label col-md-3">Confirm Password
            <span class="required"> * </span>
        </label>
        <div class="col-md-7">
            <input type="text" name="cnfmPwd" data-required="1" placeholder="Reenter your password" class="form-control input-height" /> </div>
    </div> --}}
    
    
    
    <div class="form-group row">
        <label class="control-label col-md-3">Mobile No.
            <span class="required"> * </span>
        </label>
        <div class="col-md-7">
            <input name="mobile" type="text" placeholder="Mobile number" class="form-control input-height" /> </div>
    </div>
    <div class="form-group row">
        <label class="control-label col-md-3">Date Of Birth
            <span class="required"> * </span>
        </label>
        <div class="col-md-7">
            <input type="date" name="date_of_birth" class="form-control">
        </div>
    </div>

    <div class="form-group row">
        <label class="control-label col-md-3">NID or Birth Registration Num
            <span class="required"> * </span>
        </label>
        <div class="col-md-7">
            <input type="text" name="nid" placeholder="NID or birth registration num" class="form-control">
        </div>
    </div>

    <div class="form-group row">
        <label class="control-label col-md-3">Maritual status
        </label>
        <div class="col-md-7">
            <select class="form-control input-height" name="maritual_status">
                <option value="">Select...</option>
                <option value="Single">Single</option>
                <option value="Married">Married</option>
            </select>
        </div>
    </div>

    <div class="form-group row">
        <label class="control-label col-md-3">Religion
        </label>
        <div class="col-md-7">
            <select class="form-control input-height" name="religion">
                <option value="">Select...</option>
                <option value="Muslim">Muslim</option>
                <option value="Hindhu">Hindhu</option>
                <option value="Khistian">Khistian</option>
                <option value="Buddho">Buddho</option>
            </select>
        </div>
    </div>

    <div class="form-group row">
        <label class="control-label col-md-3">Nationality
        </label>
        <div class="col-md-7">
            <input type="text" name="nationality" placeholder="Nationality" class="form-control">
        </div>
    </div>

        <div class="form-group row">
        <label class="control-label col-md-3">Detail Address
            <span class="required"> * </span>
        </label>
        <div class="col-md-7">
            <textarea name="address" placeholder="Village, Thana, District etc" class="form-control" rows="5" ></textarea>
        </div>
    </div>
    
    
    

    <div class="form-group row">
        <label class="control-label col-md-3">Educational History
        </label>
        <div class="col-md-7">
            
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">Exam</th>
                    <th scope="col">Passing Year</th>
                    <th scope="col">Board/University</th>
                    <th scope="col">Roll</th>
                    <th scope="col">CGPA/GPA</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <th scope="row">SSC</th>
                    <td>
                        <input type="text" name="s_year" placeholder="SSC Year" class="form-control">
                    </td>
                    <td>
                        <select  name="s_board" class="form-control">
                            <option selected="selected" value="0">Board</option>
                            <option value="1">Dhaka</option><option value="2">Comilla</option><option value="3">Rajshahi</option><option value="4">Jessore</option><option value="5">Chittagong</option><option value="6">Barisal</option><option value="7">Sylhet</option><option value="8">Dinajpur</option><option value="9">Madrasah</option><option value="10">Technical</option><option value="11">Mymensingh</option><option value="17">Open University</option>
                            </select>
                    </td>
                    <td><input type="text" name="s_roll" placeholder="SSC Roll" class="form-control"></td>
                    <td><input type="text" name="s_gpa" placeholder="SSC GPA" class="form-control"></td>
                    </tr>
                    <tr>
                    <th scope="row">HSC</th>
                    <td>
                        <input type="text" name="h_year" placeholder="HSC Year" class="form-control">
                    </td>
                    <td>
                        <select name="h_board" class="form-control">
                            <option selected="selected" value="0">Board</option>
                            <option value="1">Dhaka</option><option value="2">Comilla</option><option value="3">Rajshahi</option><option value="4">Jessore</option><option value="5">Chittagong</option><option value="6">Barisal</option><option value="7">Sylhet</option><option value="8">Dinajpur</option><option value="9">Madrasah</option><option value="10">Technical</option><option value="11">Mymensingh</option><option value="17">Open University</option>
                            </select>
                    </td>
                    <td><input type="text" name="h_roll" placeholder="HSC Roll" class="form-control"></td>
                    <td><input type="text" name="h_gpa" placeholder="HSC GPA" class="form-control"></td>
                    </tr>

                    <tr>
                    <th scope="row">Honors</th>
                    <td><input type="text" name="ho_year"  placeholder="Year"  class="form-control"></td>
                    <td><input type="text" name="ho_university" placeholder="University" class="form-control"></td>
                    <td><input type="text" placeholder="Subject" name="ho_subject" class="form-control"></td>
                    <td><input type="text" name="ho_cgpa" placeholder="CGPA" class="form-control"></td>
                    </tr>

                    <tr>
                    <th scope="row">Masters</th>
                    <td><input type="text" name="m_year"  placeholder="Year"  class="form-control"></td>
                    <td><input type="text" name="m_university" placeholder="University" class="form-control"></td>
                    <td><input type="text" placeholder="Subject" name="m_subject" class="form-control"></td>
                    <td><input type="text" name="m_cgpa" placeholder="CGPA" class="form-control"></td>
                    </tr>


                </tbody>
                </table>
        </div> <hr>
        
    </div>
    

    <div class="form-group row  margin-top-20">
        <label class="control-label col-md-3">Profile Picture
            
        </label>
        <div class="col-md-8">
            <img id="uploadPreview" style="width: 100px; height: 100px;" />
            <input id="uploadImage"  type="file" name="image" onchange="PreviewImage();" />                                
        </div>
    </div>

    
    <div class="form-actions">
    <div class="row">
        <div class="offset-md-3 col-md-9">
            <input type="hidden" name="source" value="frontend">
            <button type="submit" class="btn btn-info">Submit</button>
            {{-- <p>Already registerd? <a href="{{URL::to('/login')}}">Login here.</a></p> --}}
        </div>
        </div>
        </div>
</div>
{!! Form::close()!!}



                </div>
            </div>
        </div>
    </div>
</div>
<br>
@endsection