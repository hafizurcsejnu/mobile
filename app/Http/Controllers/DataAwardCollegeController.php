<?php

namespace App\Http\Controllers;

use App\Models\DataAwardCollege;
use Illuminate\Http\Request;

class DataAwardCollegeController extends Controller
{
   
    
    public function index()
    {
        $data = DataAwardCollege::orderBy('id', 'desc')->get();
        return view('admin.award_college', ['data'=>$data]);
    }     
    
    
    public function store(Request $request)
    {
        $data = new DataAwardCollege;
        $data->name = $request->name;
        $data->save();

        return redirect()->back()->with(session()->flash('alert-success', 'Data has been inserted successfully.'));        
    }

    public function update(Request $request)    {        
        
        $data = DataAwardCollege::find($request->id);
        $data->name = $request->name;
        $data->save(); 

        return redirect()->back()->with(session()->flash('alert-success', 'Data has been updated successfully.'));
    }

    public function destroy($id)
    {       
        $data = DataAwardCollege::find($id);
        $data->delete();

        return redirect()->back()->with(session()->flash('alert-success', 'Data has been deleted successfully.'));
    }

    
    
}
