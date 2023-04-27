<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;

class DocumentController extends Controller
{
    public function index()
    {
        $a = File::first();
        echo count($a);
        die;
        return view('my_documents');
    }
}
