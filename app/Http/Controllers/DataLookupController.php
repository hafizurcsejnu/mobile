<?php
namespace App\Http\Controllers;

use App\Models\DataLookup;
use Illuminate\Http\Request;
use DB;

class DataLookupController extends Controller
{
     
    public function index()
    {
        $data = DataLookup::orderBy('id', 'desc')
              ->where('client_id', session('client_id'))
              ->get();        
        //dd($data); 
        return view('admin.data_lookup', ['data'=>$data]);
    }     
    
    
    public function store(Request $request)
    {
        if(DataLookup::where('title', $request->title)->where('client_id', session('client_id'))->first())
        {
            return redirect()->back()->with(session()->flash('alert-warning', 'A term with the name provided already exists!'));       
        }
        $data = new DataLookup;
        $data->title = $request->title;
        $data->data_type = $request->data_type;
        $data->client_id = session('client_id');
        $data->created_by = session('user_id');
        
        $data->save();

        return redirect()->back()->with(session()->flash('alert-success', 'Data has been inserted successfully.'));        
    }

    public function update(Request $request)    {        
        
        $data = DataLookup::find($request->id);
        $data->title = $request->title;
        $data->data_type = $request->data_type;
        $data->updated_by = session('user_id');
        $data->save(); 

        return redirect()->back()->with(session()->flash('alert-success', 'Data has been updated successfully.'));
    }

    public function destroy($id)
    {   
        return redirect()->back()->with(session()->flash('alert-warning', 'Please contact with your developer to be sure on this action.'));

        $data = DataLookup::find($id);
        $data->delete();

        return redirect()->back()->with(session()->flash('alert-success', 'Data has been deleted successfully.'));
    }

    
    
}
