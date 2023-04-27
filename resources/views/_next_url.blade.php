<?php

//if sections is not updated
  $i=1;        
  $collection = DB::table('user_sections')
  ->where('user_id', session('user_id'))
  ->where('resume_id', session('resume_id'))
  ->where('active', 'on')
  ->get();
  if($collection->isEmpty()) {
    $i=0;
    $collection = DB::table('sections')
    ->where('name', $section_name)
    ->orderby('id', 'asc')
    ->get();		

    foreach ($collection as $item){
      $sort_order= $item->sort_order;    
    }
    $prev_sort_order = $sort_order-1;
    $next_sort_order = $sort_order+1;
    //dd($next_sort_order);

    $collection = DB::table('sections')
    ->where('sort_order', $next_sort_order)
    ->get();
    foreach ($collection as $item){

    $next_section_name= $item->name;   
    $next_url = explode(" ", $next_section_name); 
    $next_url = strtolower($next_url[0]); 
    session()->put('next_url', $next_url);
    }  

//if sections is not updated end
  }else{       	


$section = DB::table('user_sections')
        ->where('user_id', session('user_id'))
        ->where('resume_id', session('resume_id'))
        ->where('name', $section_name)
        ->get();  
if(!$section->isEmpty()) {
    foreach ($section as $item){
      $sort_order= $item->sort_order;    
    }
    $prev_sort_order = $sort_order-1;
    $next_sort_order = $sort_order+1;   
}

function search_next_item($next_sort_order){
  //dd($next_sort_order);
  //dd('in');
  $section = DB::table('user_sections')
          ->where('user_id', session('user_id'))
          ->where('resume_id', session('resume_id'))
          ->where('sort_order', $next_sort_order)
          ->get();

    if (!$section->isEmpty()) {
          foreach ($section as $item){
            $active= $item->active;
            $sort_order= $item->sort_order; 
            $next_sort_order = $sort_order+1; 
            //dd($next_sort_order);
            if ($active=='on') {              
              $next_section_name= $item->name;   
              $next_url = explode(" ", $next_section_name); 
              $next_url = strtolower($next_url[0]); 
              session()->put('next_url', $next_url);   
              return false;         
            }
            else{
              search_next_item($next_sort_order);
              //dd('ami');
            }          
        }
    }
    else{
      //dd($next_sort_order);
      if($next_sort_order<9){
        $next_sort_order = $next_sort_order+1;
        //dd($next_sort_order);
        search_next_item($next_sort_order);
      }
      $next_url = "preview-resume";
      session()->put('next_url', $next_url);
      return false;
    }
    
    
  }
  search_next_item($next_sort_order);
}



