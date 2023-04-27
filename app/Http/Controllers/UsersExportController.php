<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Exports\UsersExport;

class UsersExportController extends Controller
{
    public function export()     {
        return Excel::download(new UsersExport, 'users.xlsx');
    }
}
