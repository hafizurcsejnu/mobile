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
    //dd($prev_sort_order);

    $collection = DB::table('sections')
    ->where('sort_order', $prev_sort_order)
    ->get();
    foreach ($collection as $item){

    $prev_section_name= $item->name;   
    $prev_url = explode(" ", $prev_section_name); 
    $prev_url = strtolower($prev_url[0]); 
    session()->put('prev_url', $prev_url);
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
}

function search_prev_item($prev_sort_order){
  //dd($prev_sort_order);
  //dd('in');
  $section = DB::table('user_sections')
          ->where('user_id', session('user_id'))
          ->where('resume_id', session('resume_id'))
          ->where('sort_order', $prev_sort_order)
          ->get();

    if (!$section->isEmpty()) {
          foreach ($section as $item){
            $active= $item->active;
            $sort_order= $item->sort_order; 
            $prev_sort_order = $sort_order-1; 
            //dd($prev_sort_order);
            if ($active=='on') {              
              $prev_section_name= $item->name;   
              $prev_url = explode(" ", $prev_section_name); 
              $prev_url = strtolower($prev_url[0]); 
              session()->put('prev_url', $prev_url);   
              return false;         
            }
            else{
              search_prev_item($prev_sort_order);
              //dd('ami');
            }          
        }
    }
    else{
      //dd($prev_sort_order);
      if($prev_sort_order<9){
        $prev_sort_order = $prev_sort_order-1;
        //dd($prev_sort_order);
        search_prev_item($prev_sort_order);
      }
      $prev_url = "complete";
      session()->put('prev_url', $prev_url);
      return false;
    }    
  
    
  }
  search_prev_item($prev_sort_order);
}



