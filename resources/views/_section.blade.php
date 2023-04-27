<?php 
$section_array = array();



$header = DB::table('headers')                
        ->where('user_id', '=', session('user_id'))
        ->where('resume_id', '=', session('resume_id'))
        ->first();
        if($header!=null){
           array_push($section_array, "Header");
        }

        
$educations = DB::table('educations')  
        ->where('user_id', '=', session('user_id'))
        ->where('resume_id', '=', session('resume_id'))
        ->first();
        if($educations!=null){
           array_push($section_array, "Education");
        }
       

$experiences = DB::table('experiences')  
        ->where('user_id', '=', session('user_id'))
        ->where('resume_id', '=', session('resume_id'))
        ->first();
        if($experiences!=null){
           array_push($section_array, "Work Experience");
        }

$activities = DB::table('activities')  
        ->where('user_id', '=', session('user_id'))
        ->where('resume_id', '=', session('resume_id'))
        ->first();
        if($activities!=null){
           array_push($section_array, "Extra-Curricular");
        }

$certifications = DB::table('certifications')  
        ->where('user_id', '=', session('user_id'))
        ->where('resume_id', '=', session('resume_id'))
        ->first();
        if($certifications!=null){
           array_push($section_array, "Certifications");
        }

$skills = DB::table('skills')  
        ->where('user_id', '=', session('user_id'))
        ->where('resume_id', '=', session('resume_id'))
        ->first();
        if($skills!=null){
           array_push($section_array, "Skills");
        }

$professional_summaries = DB::table('professional_summaries')  
        ->where('user_id', '=', session('user_id'))
        ->where('resume_id', '=', session('resume_id'))
        ->first(); 
        if($professional_summaries!=null){
           array_push($section_array, "Professional Summary");
        }

$additionals = DB::table('additionals')  
        ->where('user_id', '=', session('user_id'))
        ->where('resume_id', '=', session('resume_id'))
        ->first();
        if($additionals!=null){
           array_push($section_array, "Additional Information");
        }

       
?>

<div class="col-12 col-lg-4 mt-3 mt-lg-0">
<p id="resume_name_message" style="color:green; display:none">Resume saved!</p>
<div class="row">

  <?php 
      $resume = DB::table('resumes')
      ->where('id', session('resume_id'))
      ->first();
      // dd($resume);
  ?>


@csrf
  <div class="col-md-6">
      <form>
        <input type="text" name="resume_name" id="resume_name" placeholder="Resume name" value="@if($resume->status=="updated"){{$resume->name}}@endif" class="form-control">
       
      </div>
      <div class="col-md-6"> 
        <button class="btn btn-default" id="resume_name_btn" type="button">Save</button>    

<style>
i.fa.fa-eye.mx-1 {
  font-size: 25px;
}
i.fa.fa-download.mx-1 {
  font-size: 25px;
}
</style>
          
          <a href="/preview/{{session('resume_id')}}" target="_blank" title="Preview Resume" class="mx-2px btn radius-1 border-2 btn-xs btn-brc-tp btn-light-secondary btn-h-lighter-warning btn-a-lighter-warning">
            <i class="fa fa-eye mx-1"></i>
          </a>
         

          <style>
            /* Style The Dropdown Button */
            .dropbtn {             
              border: none;
              cursor: pointer;
            }
            
            /* The container <div> - needed to position the dropdown content */
            .dropdown {
              position: relative;
              display: inline-block;
            }
            
            /* Dropdown Content (Hidden by Default) */
            .dropdown-content {
              display: none;
              position: absolute;
              background-color: #f9f9f9;
              min-width: 160px;
              box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
              z-index: 1;
            }
            
            /* Links inside the dropdown */
            .dropdown-content a {
              color: black;
              padding: 12px 16px;
              text-decoration: none;
              display: block;
            }
            
          
            
            /* Show the dropdown menu on hover */
            .dropdown:hover .dropdown-content {
              display: block;
            }
            
          
            </style>
            
            {{-- <div class="dropdown">             
              <a href="/resume/{{session('resume_id')}}" target="_blank" title="Download PDF" class="dropbtn mx-2px btn radius-1 border-2 btn-xs btn-brc-tp btn-light-secondary btn-h-lighter-warning btn-a-lighter-warning">
                <i class="fa fa-download mx-1"></i>
              </a>

              <div class="dropdown-content">
                <a href="/resume/{{session('resume_id')}}">Download PDF</a>
                <a href="javascript:void(0)" class="word-export">Download Word</a>
              </div>
            </div> --}}
       


      </div>
      </form>
</div>
<br>

    <div class="card bcard h-100">
    
      <div class="border-t-3 w-100 brc-success-m1 radius-t-1"></div>

      

      <div class="card-header border-0">
        <h5 class="card-title text-grey-d1 pl-1 text-center">
          Resume Sections
          <!-- <span class="badge btn-light-success text-success float-right font-bolder">
            +6 -->
          </span> 
        </h5>
        
      </div>
      <p class="text-center text-green" style="font-weight: 600; margin:-12px auto">Drag and drop for reorder</p>
      <hr>

      <div class="card-body p-3 d-flex flex-column h-100 section_link">

    <?php 
        $i=1;        
        $resume_id = session('resume_id');
        $collection = DB::table('user_sections')
        ->where('user_id', session('user_id'))
        ->where('resume_id', $resume_id)
        // ->where('active', 'on')
        ->orderBy('sort_order', 'asc')
        ->get();

        //dd($resume_id);

        if($collection->isEmpty()) {
          $i=0;
          $collection = DB::table('sections')
          ->orderby('id', 'asc')
          ->get();		
        }        	
    ?> 
    <ul id="sort_me"  style="width:100%;list-style:none;padding-left: 0px;" data-temp-id = "{{$resume_id}}" data-user-id = "{{session('user_id')}}">

    @foreach ($collection as $item)
    <?php 
      $url = explode(" ", $item->name);
    ?>
      <li class="list_item @if($item->active=='on') d-block @else d-none @endif" data-id="{{$item->sort_order}}" data-section-id="{{$item->id}}">
        <a href="{{strtolower($url[0])}}" class="btn btn-primay text-center <?php if($item->name == $section_name){echo "active";} 
        if (in_array($item->name, $section_array)){echo " updated";}
        ?>" style="width:100%">
          @if($i==1 && $item->name_updated != null){{$item->name_updated}}
          @else {{$item->name}} 
          @endif
        </a>
      </li>
    @endforeach
    </ul>


        {{--<div class="flex-grow-1">         
            <div class="mb-2 text-grey-m1 text-95">
           
           <div class="d-flex align-items-start">
              <div class="mx-2 text-grey-d1">
                <div class="text-600 text-blue-d1 center-text">
                    
                    
                </div>
              </div>
            </div>
          </div>
          <hr class="brc-grey-l3">  
        </div>--}}

        <div class="mt-2 px-4 border-t-1 brc-default-l3 pt-3">
          <button type="button" class="btn btn-block btn-sm border-2 btn-lighter-default btn-h-light-primary btn-a-light-primary" data-toggle="modal" data-target="#sectionModal">
            Manage sections
          </button>
        </div>
      </div><!-- /.card-body -->
      
    </div><!-- /.card -->
  </div>

  <style>
      .modal-dialog {
    max-width: 1000px;
    margin: 1.75rem auto;
}
  </style>
   <!-- default example -->
   <div class="modal fade" id="sectionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog " role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-primary-d3" id="exampleModalLabel">
            Add, Remove, Rename Sections
          </h5>

          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
            <div class="row mt-3">
                <div class="col-12">
                  <div class="card dcard">
                    <div class="card-body px-1 px-md-3">

                    <?php                      
                      $collection = DB::table('user_sections')
                      ->where('user_id', session('user_id'))
                      ->where('resume_id', $resume_id)
                      ->orderBy('sort_order', 'asc')
                      ->get();
                      if ($collection->isEmpty()) {
                        $collection = DB::table('sections')
                        ->orderby('id', 'asc')
                        ->get();		
                      }        	
                    ?> 
          
                      <form method="post" action="<?php if($i==0){echo "store-section";}else{echo "update-section";}?>" autocomplete="off">
                        @csrf
                        <div class="d-flex justify-content-between flex-column flex-sm-row mb-3 px-2 px-sm-0">
                          <h3 class="text-125 pl-1 mb-3 mb-sm-0 text-secondary-d4">
                           All Sections
          
                          </h3>
          
                        
          
                          {{-- <div class="mb-2 mb-sm-0">
                            <button type="button" class="btn btn-blue px-3 d-block w-100 text-95 radius-round border-2 brc-black-tp10">
                              <i class="fa fa-plus mr-1"></i>
                              Add <span class="d-sm-none d-md-inline">New</span> Entry
                            </button>
                          </div> --}}
                        </div>
          
                        <table id="simple-table" class="mb-0 table table-borderless table-bordered-x brc-secondary-l3 text-dark-m2 radius-1 overflow-hidden">
                          <thead class="text-dark-tp3 bgc-grey-l4 text-90 border-b-1 brc-transparent" id="section_table">
                            <tr>
                              
                              <th>Section Title</th>
                              <th>Rename</th>
                              <th>Action</th>
                            </tr>
                          </thead>

                          <tbody class="mt-1 sort_me">
                           
                            @foreach ($collection as $item)
                        
                            <tr class="bgc-h-yellow-l4 d-style list_item">              
                        
                              
                              <td>
                                <a href="#" class="text-blue-d1 text-600 text-95">{{$item->name}}</a>
                                <input type="hidden" name="section_id[]" value="<?php if($i==1){echo $item->section_id;}else{ echo $item->id;}?>">
                                <input type="hidden" name="name[]" value="{{$item->name}}">
                              </td>
                        
                              <td class="text-600 text-orange-d2">
                                <input type="text" width="20%" name="name_updated[]" class="form-control"

                                @if($i==1 && $item->name_updated != null) value="{{$item->name_updated}}"
                                @else placeholder="Rename section"
                                @endif
                                
                                >                                
                            </td>    
                                        
                        
                            
                              <td>
                                <!-- action buttons -->
                                <div class="d-none d-lg-flex">
                                  <div class="mb-1">
                                    <label>                                      
                                      <input type="checkbox" name="active[]" class="input-lg bgc-blue" value="{{$item->id}}" <?php if($item->active=='on'){echo "checked";}else{ echo '';}?>>
                                      Active
                                    </label>
                                  </div>
                                 
                                </div>
                        
                                <!-- show a dropdown in mobile -->
                                <div class="dropdown d-inline-block d-lg-none dd-backdrop dd-backdrop-none-lg">
                                  <a href="#" class="btn btn-default btn-xs py-15 radius-round dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-cog"></i>
                                  </a>
                        
                                  <div class="dropdown-menu dd-slide-up dd-slide-none-lg">
                                    <div class="dropdown-inner">
                                      <div class="dropdown-header text-100 text-secondary-d1 border-b-1 brc-secondary-l2 text-600 mb-2">
                                        {{$item->name}}
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
                        
                     
          
                    </div><!-- /.card-body -->
                  </div><!-- /.card -->
                </div><!-- /.col -->
              </div>
          
          <br />
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary px-4" data-dismiss="modal">
            Close
          </button>

          <button type="submit" class="btn btn-primary">
            Save changes
          </button>
        </div>
      </form>
      </div>
    </div>
  </div>

  <script>
  $(document).ready(function() {

        // $("#sort_me").sortable({
        //   placeholder:"ui-state-highlight",
        //   update:function(event, ui){

        //   }
        // });

        

        $('#sort_me').sortable({
         disabled: false,
         axis: 'y',
         forceHelperSize: true,
         items: '> li:gt(0)',
         update: function (event, ui) {
             var Newpos = ui.item.index();
              var sort_id_array = new Array();
              var section_id_array = new Array();
              $('#sort_me li').each(function(){
                sort_id_array.push($(this).data('id'));
                section_id_array.push($(this).data('section-id'));
              });
              console.log(sort_id_array);
              console.log(section_id_array);
              var user_id = $("#sort_me").data('user-id');
              var resume_id = $("#sort_me").data('temp-id');
              if (resume_id==null) {
                resume_id = "";
              }
              $.ajax({
                url:"sections/update/"+user_id,
                method:"POST",
                data:{sort_id_array:sort_id_array,section_id_array:section_id_array,resume_id:resume_id,_token:"{{csrf_token()}}"},
                success:function(data)
                {
                  console.log(data);
                  //load_data();
                }
              })

         }
     }).disableSelection();
    });  
    function load_data()
    {
      var id = "";
      $.ajax({
        url:"section/"+id,
        method:"POST",
        data:{action:'fetch_data'},
        dataType:'json',
        success:function(data)
        {
          var html = '';
          for(var count = 0; count < data.length; count++)
          {
            html += '<li>'+data.name+'</li>';
          }
          $('#sort_me').html(html);
          console.log(html);
        }
      });
    }
  </script>

<script>
       $("#resume_name_btn").click(function(){
        var resume_name = $('#resume_name').val();
        $.ajax({
          url: "save_resume_name",
          data: {
            _token: '{{csrf_token()}}',
            resume_name: resume_name
          },
          type: 'POST',
          success: function (response) {
              $("#resume_name_message").show();
          }
        });
      });
</script>
<?php 
$template = DB::table('resumes')
->where('id', '=', session('resume_id'))
->first();
?>
<script>        
  $("a.word-export").click(function(event) {
      $(".resume_wrapper").wordExport('{{$template->name}}');
  });
</script>