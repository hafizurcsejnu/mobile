<?php

namespace App\Http\Controllers;

use App\Models\UserSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        //$data=$request->all();        
        if(count($request->section_id) > 0)
        {
            $ative_sections = array();

            foreach($request->section_id as $item=>$section_id){

                if(isset($request->active[$item])){
                    $active = $request->active[$item];
                    $ative_sections[] = $request->active[$item];
                }else{
                    $active = "no";#default value
                }

                $data2=array(
                    'resume_id'=>session('resume_id'),
                    'user_id'=>session('user_id'),
                    'section_id'=>$request->section_id[$item],
                    'name'=>$request->name[$item],
                    'name_updated'=>$request->name_updated[$item],
                    'active'=>$active                    
                );  
                UserSection::insert($data2);               

            }     
            
            for ($i = 0; $i < count($ative_sections); $i++) {

                DB::table('user_sections')
                    ->where('resume_id', session('resume_id'))
                    ->where('user_id', session('user_id'))
                    ->where('section_id', $ative_sections[$i])
                    ->update(['active' => "on"]);
            }
            //dd($ative_sections);
            
        }
        return redirect()->back()->with('success','Sections update successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserSection  $userSection
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $sections = UserSection::where('user_id',$id)->get();
        return $sections;

    }

    public function update_section(Request $request,$id){
        $section_id = $request->section_id_array;
        // sort($section_id);
        for ($i=1; $i < sizeof($request->section_id_array); $i++) {            
            $section = UserSection::where('id',$request->section_id_array[$i])->first();
            $section->sort_order = $i+1;
            $section->save();
        }
        $section = UserSection::select('sort_order','id','name')->where('user_id',$id)->where('resume_id',$request->resume_id)->orderBy('sort_order', 'asc')->get();
        return $section;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserSection  $userSection
     * @return \Illuminate\Http\Response
     */
    public function edit(UserSection $userSection)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserSection  $userSection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if(count($request->section_id) > 0)
        {
            //dd($request->all());
            $ative_sections = array();    

            foreach($request->section_id as $item=>$section_id){

                if(isset($request->active[$item])){
                    $active = $request->active[$item];
                    $ative_sections[] = $request->active[$item];
                }else{
                    $active = "no";#default value
                }

                $user_section = UserSection::where(['resume_id' => session('resume_id'), 'user_id' => session('user_id'), 'section_id' => $request->section_id[$item] ])->first();     
                if($user_section != null){                    
                    $user_section->name_updated = $request->name_updated[$item];     
                    //$user_section->sort_order = $request->sort_order[$item];     
                    $user_section->active = $active;     
                    $user_section->save();
                }


                // $data2=array(
                //     'resume_id'=>session('resume_id'),
                //     'user_id'=>session('user_id'),
                //     'section_id'=>$request->section_id[$item],
                //     'name'=>$request->name[$item],
                //     'name_updated'=>$request->name_updated[$item],
                //     'sort_order'=>$request->sort_order[$item],
                //     'active'=>$active                    
                // );
                // UserSection::insert($data2);               

            }     
            //dd($ative_sections);
            for ($i = 0; $i < count($ative_sections); $i++) {

                DB::table('user_sections')
                    ->where('resume_id', session('resume_id'))
                    ->where('user_id', session('user_id'))
                    ->where('id', $ative_sections[$i])
                    ->update(['active' => "on"]);
            }
            //dd($ative_sections);
            
        }
        return redirect()->back()->with('success','Sections updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserSection  $userSection
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserSection $userSection)
    {
        //
    }
}
