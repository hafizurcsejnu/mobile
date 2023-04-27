<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport;



class EquipementReportingController extends Controller
{
   
    public function generateReport(Request $request)
    {
        if($request->start_date != null){
            $start_date = $request->start_date;
        }else{
            $start_date = date("Y-m-d");
        }
        $end_date = $request->end_date;
        $report_title = $request->report_title; 
        $product_id = $request->product_id; 
        $expense_type = $request->expense_type; 
        $cashflow_type = $request->cashflow_type; 
        $store_id = $request->store_id; 
        //dd($start_date);
        //dd($end_date);
        
        // get table name
        if($report_title == 'Sales'){
            $table_name = 'payments';
            $total = 'amount'; 
        } 
        else if($report_title == 'Expense'){
            if($expense_type != null){
            }
            $table_name = 'expenses';
            $total = 'amount';
        } 
        else if($report_title == 'Cash Receive'){
            $table_name = 'cash_flows';
            $total = 'amount_in';
        }
        else if($report_title == 'Purchase'){
            $table_name = 'purchases';
            $total = 'total_price';
        }
        else if($report_title == 'DO Summary'){
            $table_name = 'order_details';
            $total = 'qty';
        }
        else if($report_title == 'Sales Profit'){           
            $table_name = 'order_details';
            $total = 'profit';  
        }
        else if($report_title == 'Stock Delivery'){
            $table_name = 'product_stocks';
            $total = 'qty';
            if($store_id != null){
                $store = DB::table('stores')
                ->where('id', $store_id)
                ->first();
                $store_title = $store->title;
            }else{
                $store_title = 'All Stock';
            }           
        }

        else if($report_title == 'Cash Sheet'){
            return $this->cashSheet($request);
        }
       
      

        // daily or On Date
        if($end_date == null){
            $report_type = 'On Date';
            $date_range = bd($start_date);

            if($report_title == 'Sales'){
                // Product based Daily sales
                if($product_id != null){                
                    $product = DB::table('products') 
                        ->where('id', $product_id)
                        ->first(); 
                    $product_name = $product->name;
                    //$report_title = $report_title."(".$product->name.")"; 
                    $data = DB::table($table_name)
                    ->where('product_id', $product_id)
                    ->where('created_at', 'like', '%' .$start_date. '%')
                    ->where('client_id', session('client_id'))->where('active', 'on')
                    ->orderBy('id', 'desc')
                    ->get();
                    $total_amount = DB::table($table_name)->where('created_at', 'like', '%' .$start_date. '%')->where('client_id', session('client_id'))->where('active', 'on')->sum($total);
                    return view('reports.sales_item', ['data' => $data, 'total_amount' => $total_amount, 'report_title' => $report_title." -".$product_id."-", 'report_type' => $report_type, 'date_range' => $date_range ]);   
                }
                else{
                    // all products daily sales
                    $data = DB::table('orders')
                    ->where('created_at', 'like', '%' .$start_date. '%')
                    ->where('client_id', session('client_id'))
                    ->where('active', 'on')
                    ->orderBy('id', 'asc')
                    ->get();
                    //dd($data);

                    $total_amount = DB::table($table_name)->where('client_id', session('client_id'))->where('active', 'on')->where('created_at', 'like', '%' .$start_date. '%')->sum($total);
                    return view('reports.sales', ['data' => $data, 'total_amount' => $total_amount, 'report_title' => $report_title." -".$product_id."-", 'report_type' => $report_type, 'date_range' => $date_range ]); 
                }               
            }
            else if($report_title == 'DO Summary'){
                $data = DB::table($table_name)
                ->selectRaw('product_id, sum(qty) as qty')
                ->where('created_at', 'like', '%' .$start_date. '%')
                ->where('client_id', session('client_id'))
                ->where('active', 'on')
                ->groupBy('product_id')
                ->orderBy('id', 'asc')
                ->get();                               
            }   
            else if($report_title == 'Sales Profit'){
                $data = DB::table($table_name)
                ->selectRaw('product_id, sum(qty) as qty, sum(profit) as profit, sum(profit_unit) as profit_unit, sum(total_price) as total_price')
                ->where('created_at', 'like', '%' .$start_date. '%')
                ->where('client_id', session('client_id'))
                ->where('active', 'on')
                ->groupBy('product_id')
                ->orderBy('id', 'asc')
                ->get();
                $total_amount = DB::table($table_name)->where('created_at', 'like', '%' .$start_date. '%')->where('active', 'on')->sum($total);
            }  
       
           
            else if($expense_type != null){
                $data = DB::table($table_name)
                ->where('created_at', 'like', '%' .$start_date. '%')
                ->where('expense_type', $expense_type)
                ->where('client_id', session('client_id'))->where('active', 'on')
                ->orderBy('id', 'desc')
                ->get();
                $total_amount = DB::table($table_name)->where('expense_type', $expense_type)->where('created_at', 'like', '%' .$start_date. '%')->where('client_id', session('client_id'))->where('active', 'on')->sum($total);
            }
            else if($cashflow_type != null){
                $data = DB::table($table_name)
                ->where('created_at', 'like', '%' .$start_date. '%')
                ->where('cashflow_type', $cashflow_type)
                ->where('client_id', session('client_id'))
                ->where('active', 'on')
                ->orderBy('id', 'desc')
                ->get();
                $total_amount = DB::table($table_name)->where('cashflow_type', $cashflow_type)->where('created_at', 'like', '%' .$start_date. '%')->where('client_id', session('client_id'))->where('active', 'on')->sum($total);
            }
            else if($report_title == 'Stock Delivery' && $store_id != null){
                $data = DB::table($table_name)
                ->where('created_at', 'like', '%' .$start_date. '%')
                ->where('store_id', $store_id)
                ->where('type', 'Credit')
                ->get();                
             
                $total_qty = DB::table($table_name)->where('store_id', $store_id)->where('created_at', 'like', '%' .$start_date. '%')->where('type', 'Credit')->sum($total);
            }
            else if($report_title == 'Stock Delivery' && $store_id == null){
                $data = DB::table($table_name)
                ->where('created_at', 'like', '%' .$start_date. '%')
                ->where('type', 'Credit')
                ->get();
             
                $total_qty = DB::table($table_name)->where('created_at', 'like', '%' .$start_date. '%')->where('type', 'Credit')->sum($total);
            }
            else{
                $data = DB::table($table_name)
                ->where('created_at', 'like', '%' .$start_date. '%')
                ->where('client_id', session('client_id'))
                ->orderBy('id', 'desc')
                ->get();
                $total_amount = DB::table($table_name)->where('created_at', 'like', '%' .$start_date. '%')->where('client_id', session('client_id'))->sum($total);
            }

             
        }
        // date range start
        else{
            $report_type = 'Date Range';
            $bd_start_date = bd($start_date);
            $bd_end_date = bd($end_date);
            $date_range = "From {$bd_start_date} To {$bd_end_date}";
            $start_date_time = "{$start_date} 00:00:01";
            $end_date_time = "{$end_date} 23:59:59";

            if($report_title == 'Sales'){
                $table_name = 'payments';
                $total = 'amount';
                
                // product based date reange sales
                if($product_id != null){
                    //$report_title = $report_title."(".$product_id.")"; 
                    $data = DB::table('order_details')
                    ->where('product_id', $product_id)
                    ->where('created_at', '>=', $start_date_time)
                    ->where('created_at', '<=', $end_date_time)
                    ->where('client_id', session('client_id'))->where('active', 'on')
                    ->orderBy('id', 'desc')
                    ->get();
                    //dd($data);
                    $total_amount = DB::table('order_details')->where('product_id', $product_id)->where('created_at', '>=', $start_date_time)->where('created_at', '<=', $end_date_time)->sum($total);

                    if(isset($product_name)){
                        $product_id = $product_name;
                    }        
                    return view('reports.sales_item', ['data' => $data, 'total_amount' => $total_amount, 'report_title' => $report_title." -".$product_id."-", 'report_type' => $report_type, 'date_range' => $date_range ]);    

                }else{
                    // all products sales without product based 
                    $data = DB::table('orders')
                    ->where('created_at', '>=', $start_date_time)
                    ->where('created_at', '<=', $end_date_time)
                    ->where('client_id', session('client_id'))->where('active', 'on')
                    ->orderBy('id', 'asc')
                    ->get();

                    $total_amount = DB::table($table_name)->where('client_id', session('client_id'))->where('active', 'on')->where('created_at', '>=', $start_date_time)->where('created_at', '<=', $end_date_time)->sum($total);
                    return view('reports.sales', ['data' => $data, 'total_amount' => $total_amount, 'report_title' => $report_title." -".$product_id."-", 'report_type' => $report_type, 'date_range' => $date_range ]); 
                }                
            } 

            else if($report_title == 'DO Summary'){               
                $data = DB::table($table_name)
                ->selectRaw('product_id, sum(qty) as qty')
                ->where('created_at', '>=', $start_date_time)
                ->where('created_at', '<=', $end_date_time)
                ->where('client_id', session('client_id'))
                ->where('active', 'on')
                ->groupBy('product_id')
                ->orderBy('qty', 'desc')
                ->get(); 
            }   
            else if($report_title == 'Sales Profit'){
                $data = DB::table($table_name)
                ->selectRaw('product_id, sum(profit_unit) as profit_unit, sum(qty) as qty_sum, sum(profit) as profit_sum')
                ->where('created_at', '>=', $start_date_time)
                ->where('created_at', '<=', $end_date_time)
                ->where('client_id', session('client_id'))
                ->where('active', 'on')
                ->groupBy('product_id')
                ->orderBy('id', 'desc')
                ->get();
                $total_amount = DB::table($table_name)->where('created_at', '>=', $start_date_time)->where('created_at', '<=', $end_date_time)->where('client_id', session('client_id'))->where('active', 'on')->sum($total);
            }  

           
            else if($expense_type != null){
                $data = DB::table($table_name)
                ->where('expense_type', $expense_type)
                ->where('created_at', '>=', $start_date_time)
                ->where('created_at', '<=', $end_date_time)
                ->where('client_id', session('client_id'))->where('active', 'on')
                ->orderBy('id', 'desc')
                ->get();
                //dd($data);
                $total_amount = DB::table($table_name)->where('expense_type', $expense_type)->where('created_at', '>=', $start_date_time)->where('created_at', '<=', $end_date_time)->where('client_id', session('client_id'))->where('active', 'on')->sum($total);
            } 
            else if($cashflow_type != null){
                $data = DB::table($table_name)
                ->where('cashflow_type', $cashflow_type)
                ->where('created_at', '>=', $start_date_time)
                ->where('created_at', '<=', $end_date_time)
                ->where('client_id', session('client_id'))->where('active', 'on')
                ->orderBy('id', 'desc')
                ->get();
                //dd($data);
                $total_amount = DB::table($table_name)->where('cashflow_type', $cashflow_type)->where('created_at', '>=', $start_date_time)->where('created_at', '<=', $end_date_time)->where('client_id', session('client_id'))->where('active', 'on')->sum($total);
            }
            else if($report_title == 'Stock Delivery' && $store_id != null){
                $data = DB::table($table_name)
                ->where('created_at', '>=', $start_date_time)
                ->where('created_at', '<=', $end_date_time)
                ->where('store_id', $store_id)
                ->where('type', 'Credit')
                ->get();
             
                $total_qty = DB::table($table_name)->where('store_id', $store_id)->where('created_at', '>=', $start_date_time)->where('created_at', '<=', $end_date_time)->where('type', 'Credit')->sum($total);
            }
            else if($report_title == 'Stock Delivery' && $store_id == null){
                $data = DB::table($table_name)
                ->where('created_at', '>=', $start_date_time)
                ->where('created_at', '<=', $end_date_time)
                ->where('type', 'Credit')
                ->get();
             
                $total_qty = DB::table($table_name)->where('created_at', '>=', $start_date_time)->where('created_at', '<=', $end_date_time)->where('type', 'Credit')->sum($total);
            }
            else{
                $data = DB::table($table_name)
                ->where('created_at', '>=', $start_date_time)
                ->where('created_at', '<=', $end_date_time)
                ->where('client_id', session('client_id'))
                ->orderBy('id', 'desc')  
                ->get();
            //dd('13'); 

                //dd($data);
                $total_amount = DB::table($table_name)->where('created_at', '>=', $start_date_time)->where('created_at', '<=', $end_date_time)->where('client_id', session('client_id'))->sum($total);
            } 

            
            //dd($total_amount);            
        }


        //dd($table_name); 
        if($report_title == 'Sales'){   
            if(isset($product_name)){
                $product_id = $product_name;
            }        
            return view('reports.sales', ['data' => $data, 'total_amount' => $total_amount, 'report_title' => $report_title." -".$product_id."-", 'report_type' => $report_type, 'date_range' => $date_range ]);          
        }        
        elseif($report_title == 'DO Summary'){ 
            return view('reports.do_summary', ['data' => $data, 'report_title' => $report_title."-", 'report_type' => $report_type, 'date_range' => $date_range ]);          
        }
        elseif($report_title == 'Sales Profit'){
            return view('reports.sales_profit', ['data' => $data, 'total_amount' => $total_amount, 'report_title' => $report_title, 'report_type' => $report_type, 'date_range' => $date_range ]);          
        }    
        elseif($report_title == 'Expense'){
            return view('reports.expenses', ['data' => $data, 'total_amount' => $total_amount, 'report_title' => $report_title."-".$expense_type."-", 'report_type' => $report_type, 'date_range' => $date_range ]);          
        } 
        elseif($report_title == 'Cash Receive'){
            return view('reports.cashflows', ['data' => $data, 'total_amount' => $total_amount, 'report_title' => $report_title."-".$cashflow_type."-", 'report_type' => $report_type, 'date_range' => $date_range ]);          
        } 
        elseif($report_title == 'Stock Delivery'){
            return view('reports.stock_delivery', ['data' => $data, 'total_qty' => $total_qty, 'report_title' => $report_title."-".$store_title."-", 'report_type' => $report_type, 'date_range' => $date_range ]);          
        }
        elseif($report_title == 'Purchase'){
            return view('reports.purchases', ['data' => $data, 'total_amount' => $total_amount, 'report_title' => $report_title, 'report_type' => $report_type, 'date_range' => $date_range ]);          
        }
      
        //return view('admin.report_center');        
    }
    public function cashSheet($request)
    {
        $day = $request->start_date;
        if($day == null){
            $date = date("Y-m-d");
        }else{
            $date= $request->start_date;
        }
        $end_date = $request->end_date;
        $report_title = $request->report_title; 
        $report_type = "Daily";
        //dd($date);

         
        $opening_cash = DB::table('daily_cash')
        ->where('date', $date)
        ->orderBy('id', 'DESC')
        ->first();
        //dd($last_cash);
        if($opening_cash){
            $opening_cash = $opening_cash->amount;
        }else{
            $opening_cash = 0;
        }
               
        // daily sales
        $payments = DB::table('payments')
        ->where('created_at', 'like', '%' .$date. '%')
        ->where('client_id', session('client_id'))
        ->where('amount', '!=', 0)
        ->where('active', 'on')
        ->orderBy('id', 'asc')
        ->get(); 

        //dd($payments);
        
        $bank_payments = DB::table('payments')
        ->where('payment_method', 'Bank')
        ->where('created_at', 'like', '%' .$date. '%')
        ->where('client_id', session('client_id'))->where('active', 'on')
        ->orderBy('id', 'asc')
        ->get(); 
        
        $cashflow_in = DB::table('cash_flows')
        ->where('payment_method', 'Cash')
        ->where('created_at', 'like', '%' .$date. '%')
        ->where('client_id', session('client_id'))->where('active', 'on')
        ->orderBy('id', 'asc')
        ->get();
        $total_cashflow_in = DB::table('cash_flows')->where('payment_method', 'Cash')->where('type', 'Debit')->where('created_at', 'like', '%' .$date. '%')->where('client_id', session('client_id'))->where('active', 'on')->sum('amount_in');
        
        $cashflow_in_bank = DB::table('cash_flows')
        ->where('payment_method', 'Bank')
        ->where('created_at', 'like', '%' .$date. '%')
        ->where('client_id', session('client_id'))->where('active', 'on')
        ->orderBy('id', 'asc')
        ->get();
        $total_cashflow_in_bank = DB::table('cash_flows')->where('payment_method', 'Bank')->where('type', 'Debit')->where('created_at', 'like', '%' .$date. '%')->where('client_id', session('client_id'))->where('active', 'on')->sum('amount_in');


        
        $checks = DB::table('bank_checks')
        ->where('created_at', 'like', '%' .$date. '%')
        ->where('status','!=', 'Withdraw Completed')
        ->where('status','!=', 'Cancelled')
        ->orderBy('id', 'asc')
        ->get(); 
        $total_payment = DB::table('payments')->where('created_at', 'like', '%' .$date. '%')->where('client_id', session('client_id'))->where('active', 'on')->sum('amount');

        $total_payment = $total_payment + $total_cashflow_in;

        $total_bank_payments = DB::table('payments')->where('payment_method', 'Bank')->where('created_at', 'like', '%' .$date. '%')->where('client_id', session('client_id'))->where('active', 'on')->sum('amount');

        // daily expenses
        $expenses = DB::table('expenses')
        ->where('created_at', 'like', '%' .$date. '%')
        ->where('client_id', session('client_id'))
        ->where('active', 'on')
        ->orderBy('id', 'asc')
        ->get(); 
        $total_expense = DB::table('expenses')->where('created_at', 'like', '%' .$date. '%')->where('client_id', session('client_id'))->where('active', 'on')->sum('amount');
        $total_expense = $total_expense + $total_bank_payments;

        return view('reports.cash_sheet', ['payments' => $payments, 'cashflow_in' => $cashflow_in, 'cashflow_in_bank' => $cashflow_in_bank, 'total_cashflow_in_bank' => $total_cashflow_in_bank, 'checks' => $checks, 'total_payment' => $total_payment, 'bank_payments' => $bank_payments, 'expenses' => $expenses, 'total_expense' => $total_expense, 'report_title' => $report_title, 'report_type' => $report_type, 'date_range' => $date, 'opening_cash' => $opening_cash ]);        
    }
    public function logBook($equipement_id)
    {
        $equipement = DB::table('products')
        ->where('id', $equipement_id)
        ->first();
        $equipement_name = $equipement->name;
        
        // $start_date= $request->start_date;
        // $end_date = $request->end_date;
        $report_title = "Log Book #".$equipement_name; 
        $report_type = "Not Defined";
        $date_range = date("Y-m-d");
               
        // dutiy
        $duties = DB::table('duties')
        ->where('equipement_id', $equipement_id)
        ->orderBy('id', 'desc')
        ->get();
        $total_duty = DB::table('duties')->where('equipement_id', $equipement_id)->sum('total_payment');
        
        // expenses 
        $expenses = DB::table('expenses')
        ->where('equipement_id', $equipement_id)
        ->orderBy('id', 'desc')
        ->get();
        $total_expense = DB::table('expenses')->where('equipement_id', $equipement_id)->sum('amount');
        //dd($duties);

        return view('reports.log_book', ['equipement_name' => $equipement_name, 'equipement_id' => $equipement_id, 'duties' => $duties, 'total_duty' => $total_duty , 'expenses' => $expenses, 'total_expense' => $total_expense, 'report_title' => $report_title, 'report_type' => $report_type, 'date_range' => $date_range ]);        
    } 
    public function companyExpenseLedger($company_id)
    {
        $company = DB::table('companies')
        ->where('id', $company_id)
        ->first();
        $company_name = $company->title;
        
        // $start_date= $request->start_date;
        // $end_date = $request->end_date;
        $report_title = "Company Expense Ledger #".$company_name; 
        $report_type = "Not Defined";
        $date_range = date("Y-m-d");
               
        // purchase or bill paid for company expense
        $purchases = DB::table('cash_flows')
        ->where('company_id', $company_id)
        ->orderBy('id', 'desc')
        ->get();
        $total_purchase = DB::table('cash_flows')->where('company_id', $company_id)->sum('amount_in');
        //dd($company_id);


        // bill pay
        $expenses = DB::table('expenses')
        ->where('company_id', $company_id)
        ->where('expense_type', 'Company')
        ->where('company_id', $company_id)
        ->where('client_id', session('client_id'))
        ->where('active', 'on')
        ->orderBy('id', 'desc') 
        ->get();
        $total_expenses = DB::table('expenses')->where('company_id', $company_id)->where('client_id', session('client_id'))->where('active', 'on')->where('client_id', session('client_id'))->where('active', 'on')->where('expense_type', 'Company')
        ->sum('amount');

        return view('reports.company_expense_ledger', ['company_name' => $company_name,'company_id' => $company_id, 'purchases' => $purchases, 'total_purchase' => $total_purchase, 'expenses' => $expenses, 'total_expenses' => $total_expenses, 'report_title' => $report_title, 'report_type' => $report_type, 'date_range' => $date_range ]);        
    }   
    public function bankStatement($bank_id)
    {
        $company = DB::table('banks')
        ->where('id', $bank_id)
        ->first();
        $company_name = $company->title;
        
        // $start_date= $request->start_date;
        // $end_date = $request->end_date;
        $report_title = "Bank Statement #".$company_name; 
        $report_type = "Not Defined";
        $date_range = date("Y-m-d"); 
               
        // amount in
        $cash_in = DB::table('bank_accounts')
        ->where('bank_id', $bank_id)
        ->where('type', 'Debit')
        ->orderBy('id', 'desc')
        ->get();
        $total_cash_in = DB::table('bank_accounts')->where('bank_id', $bank_id)->sum('amount_in');
         
 
        // amount out
        $cash_out = DB::table('bank_accounts')
        ->where('bank_id', $bank_id)
        ->where('type', 'Credit')
        ->orderBy('id', 'desc')
        ->get();
        $total_cash_out = DB::table('bank_accounts')->where('bank_id', $bank_id)->sum('amount_out');

        return view('reports.bank_statement', ['company_name' => $company_name,'bank_id' => $bank_id, 'cash_in' => $cash_in, 'total_cash_in' => $total_cash_in, 'cash_out' => $cash_out, 'total_cash_out' => $total_cash_out, 'report_title' => $report_title, 'report_type' => $report_type, 'date_range' => $date_range ]);        
    }    
    
    public function customerLedger($customer_id)
    {
       $customer = DB::table('customers')
        ->where('id', $customer_id)
        ->where('client_id', session('client_id'))
        ->first();
        if($customer == null){
            return redirect('404')->with(session()->flash('alert-warning', 'Nothing Found!'));
        }
        $customer_name = $customer->title;
        $customer_address = $customer->address;
        
        // $start_date= $request->start_date;
        // $end_date = $request->end_date;
        $report_title = "Customer Ledger: ".$customer_name. ", ". $customer_address; 
        $report_type = "Not Defined";
        $date_range = date("Y-m-d");
       
                   
        // bill pay
        $total_bill_paid = 0;
        $bill_paid = DB::table('payments')
        ->where('customer_id', $customer_id)
        ->where('client_id', session('client_id'))
        ->where('active', 'on')
        ->where('amount', '!=', 0)
        ->orderBy('id', 'desc') 
        ->get();
        
        $total_bill_paid = DB::table('payments')->where('customer_id', $customer_id)->where('client_id', session('client_id'))->where('active', 'on')->sum('amount');
  
         // purchase
        //  $purchases = DB::table('order_details')
        //  ->where('customer_id', $customer_id)
        //  ->where('product_type','!=', 'Advance')
        //  ->where('product_type','!=', 'Due')
        //  ->where('active', 'on')
        //  ->orderBy('id', 'desc')
        //  ->get();

         $purchases = DB::table('order_details')
         ->join('orders', 'order_details.order_id', '=', 'orders.id')
         ->select('order_details.*', 'orders.inv_id as inv_id')
         ->where('order_details.customer_id', $customer_id)
         ->where('order_details.product_type','!=', 'Advance')
         ->where('order_details.product_type','!=', 'Due')
         ->where('order_details.active', 'on')
         ->orderBy('order_details.id', 'desc')
         ->get();     

         
         $total_purchase = DB::table('order_details')->where('customer_id', $customer_id)->where('product_type', '!=' , 'Advance')->where('product_type', '!=' , 'Due')->where('active', 'on')->sum('total_price');
                  
         // customer refund
         $refund = DB::table('expenses')
         ->where('expense_type', 'Customer Refund')
         ->where('customer_id', $customer_id)
         ->where('client_id', session('client_id'))->where('active', 'on')
         ->orderBy('id', 'desc')
         ->get();
         $total_refund = DB::table('expenses')->where('expense_type', 'Customer Refund')->where('customer_id', $customer_id)->where('client_id', session('client_id'))->where('active', 'on')->sum('amount');

         //dd($total_bill_paid);
         //dd($total_purchase);
         //dd($total_refund);
    
         
    
        return view('reports.customer_ledger', ['customer_name' => $customer_name,'customer_id' => $customer_id,'purchases' => $purchases, 'refund' => $refund, 'total_refund' => $total_refund, 'total_purchase' => $total_purchase, 'bill_paid' => $bill_paid, 'total_bill_paid' => $total_bill_paid, 'report_title' => $report_title, 'report_type' => $report_type, 'date_range' => $date_range ]);        
    }

    public function exportUser()  {
        return Excel::download(new UsersExport, 'sales_report.xlsx');
    }
    
    public function exportPDF(Request $request){
        //dd($request);
        $starting_month = $request->starting_month;
        $ending_month = $request->ending_month;        
        if($ending_month == null){
            $starting_month = substr($starting_month,0,7);
            //dd($starting_month);
            $data = DB::table('order_details')
            ->join('products', 'order_details.product_id', '=', 'products.id')       
            ->select('products.*', 'order_details.created_at as order_date')
            ->where('order_details.created_at', 'like', '%' . $request->starting_month . '%')
            ->get();
        } 
        else{           
            $data = DB::table('order_details')
            ->join('products', 'order_details.product_id', '=', 'products.id')       
            ->select('products.*', 'order_details.created_at as order_date')
            ->whereBetween('order_details.created_at', [$starting_month, $ending_month])
            ->get();
        }
        $total = $data->count();   
        //dd($data);
        $pdf = PDF::loadView('pdf/sales_report', ['data' => $data, 'total' => $total, 'starting_month' => $starting_month, 'ending_month' => $ending_month,]);
        $name = 'sales';
        return $pdf->download($name.'_report.pdf');


    }


    public function sales(Request $request){
        dd($request);
        $starting_month = $request->starting_month;
        $starting_month = $starting_month.'-01';
        $ending_month = $request->ending_month;        
        if($ending_month == null){
            $data = DB::table('order_details')
            ->join('products', 'order_details.product_id', '=', 'products.id')       
            ->select('products.*', 'order_details.created_at as order_date')
            ->where('order_details.created_at', 'like', '%' . $request->starting_month . '%')
            ->get();
        } 
        else{ 

            $ending_month = $ending_month.'-31';
            $from = date($starting_month);
            $to = date($ending_month);
            $data = DB::table('order_details')
            ->join('products', 'order_details.product_id', '=', 'products.id')       
            ->select('products.*', 'order_details.created_at as order_date')
            ->whereBetween('order_details.created_at', [$from, $to])
            ->get();
        }
        $total = $data->count();
       
        //dd($data);
        return view('admin.report_sales', ['data' => $data, 'total' => $total, 'starting_month' => $starting_month, 'ending_month' => $ending_month,]);

    }



    public function exportExcel(Request $request)
    {
      $starting_month = $request->starting_month;
      $ending_month = $request->ending_month; 

      if($ending_month == null){
        $data = DB::table('order_details')
        ->join('products', 'order_details.product_id', '=', 'products.id')       
        ->select('products.*', 'order_details.created_at as order_date')
        ->where('order_details.created_at', 'like', '%' . $request->starting_month . '%')
        ->get()->toArray();
    } 
    else{
        $ending_month = $ending_month.'-31';
        $data = DB::table('order_details')
        ->join('products', 'order_details.product_id', '=', 'products.id')       
        ->select('products.*', 'order_details.created_at as order_date')
        ->whereBetween('order_details.created_at', [$starting_month, $ending_month])
        ->get()->toArray();
    }
   

     $file_name = 'sales_report_'.$starting_month.'_to_'.$ending_month;
   
     $product_array[] = array('name', 'id', 'price', 'created_at');

     foreach($data as $item)
     {
      $product_array[] = array(
       'product name'  => $item->name,
       'product id'   => $item->id,
       'price'   => $item->price,
       'order date'   => $item->created_at       
      );
     }
     
     //Excel::download/Excel::store($product_array);
    //  Excel::create('Customer Data', function($excel) use ($product_array){
    //     $excel->setTitle('Customer Data');
    //     $excel->sheet('Customer Data', function($sheet) use ($product_array){
    //      $sheet->fromArray($product_array, null, 'A1', false, false);
    //     });
    //    })->download('xlsx');

       //Excel::download/Excel::store($product_array);
       Excel::raw($product_array, Excel::XLSX);

    }


}

