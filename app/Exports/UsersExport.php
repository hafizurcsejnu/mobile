<?php

namespace App\Exports;
use DB;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SalesExport implements FromCollection, WithHeadings
{
    public function headings():array{
        return[
            'Product Id',
            'Product Title',
            'Price',
            'Order Date'
        ];
    }
    public function collection()
    {
        // return User::where('user_type', 'Admin')
        //     ->get();

        $data = DB::table('order_details')
            ->join('products', 'order_details.product_id', '=', 'products.id')       
            ->select('products.id', 'products.name', 'order_details.price', 'order_details.created_at as order_date')
            ->get();
            return $data;
    }
}
