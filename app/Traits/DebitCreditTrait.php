<?php
namespace App\Traits;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DB;

use App\Models\Customer;
use App\Models\CustomerAccount;
use App\Models\ProductStock;
use App\Models\ProductStockDetail;
use App\Models\Company;
use App\Models\CompanyAccount;
use App\Models\BankAccount;

trait DebitCreditTrait
{

/*
Debits
A debit is an accounting entry that either increases an asset or expense account, or decreases a liability or equity account. It is positioned to the left in an accounting entry.

Credits
A credit is an accounting entry that either increases a liability or equity account, or decreases an asset or expense account. It is positioned to the right in an accounting entry.
*/

   
    // if cash incresed
    public static function debitCustomerAc($customerId, $amount, $paymentId){
        $ca = DB::table('customer_accounts')
          ->where('customer_id', $customerId)
          ->orderBy('id', 'DESC')
          ->first();
        if($ca){
            $current_balance = $ca->current_balance + $amount;  
        }else{
            $current_balance = $amount;
        } 
        
        $data = new CustomerAccount;
        $data->customer_id = $customerId;       
        $data->payment_id = $paymentId;       
        $data->type = 'Debit';  
        $data->amount_in = $amount;
        $data->current_balance = $current_balance;
        $data->client_id = session('client_id');
        $data->created_by = session('user_id');
        $data->save();
    }

    // if cash reduced for product purchase
    public static function creditCustomerAc($customerId, $amount, $invoiceId){
        $ca = DB::table('customer_accounts')
          ->where('customer_id', $customerId)
          ->orderBy('id', 'DESC')
          ->first();
        if($ca){
          $current_balance = $ca->current_balance - $amount;  
        }else{
          $current_balance = 0 - $amount; 
        }
        
        $data = new CustomerAccount;
        $data->customer_id = $customerId;       
        $data->invoice_id = $invoiceId;       
        $data->type = 'Credit';  
        $data->amount_out = $amount;
        $data->current_balance = $current_balance;
        $data->client_id = session('client_id');
        $data->created_by = session('user_id');
        $data->save();
    }
    // if cash return, need to work if needed
    public static function returnCustomerAc($customerId, $amount, $expenseId){
        $ca = DB::table('customer_accounts')
          ->where('customer_id', $customerId)
          ->orderBy('id', 'DESC')
          ->first();
        $current_balance = $ca->current_balance - $amount;  
        
        $data = new CustomerAccount;
        $data->customer_id = $customerId;       
        $data->expense_id = $expenseId;       
        $data->type = 'Credit';  
        $data->amount_in = $amount;
        $data->current_balance = $current_balance;
        $data->client_id = session('client_id');
        $data->created_by = session('user_id');
        $data->save();
    }

    // company debitCredit
    // if cash incresed
    public static function debitCompanyAc($company_id, $amount, $purchase_id){
        $ca = DB::table('company_accounts')
          ->where('company_id', $company_id)
          ->orderBy('id', 'DESC')
          ->first();
        if($ca){
            $current_balance = $ca->current_balance + $amount;  
        }else{
            $current_balance = $amount;
        } 
        
        $data = new CompanyAccount;
        $data->company_id = $company_id;       
        $data->purchase_id = $purchase_id;       
        $data->type = 'Debit';  
        $data->amount_in = $amount;
        $data->current_balance = $current_balance;
        $data->client_id = session('client_id');
        $data->created_by = session('user_id');
        $data->save();
    }

    // if cash reduced for product purchase
    public static function creditCompanyAc($company_id, $amount, $expense_id){
        $ca = DB::table('company_accounts')
          ->where('company_id', $company_id)
          ->orderBy('id', 'DESC')
          ->first();
        if($ca){
          $current_balance = $ca->current_balance - $amount;  
        }else{
          $current_balance = 0 - $amount; 
        }
        
        $data = new CompanyAccount;
        $data->company_id = $company_id;       
        $data->expense_id = $expense_id;       
        $data->type = 'Credit';  
        $data->amount_out = $amount;
        $data->current_balance = $current_balance;
        $data->client_id = session('client_id');
        $data->created_by = session('user_id');
        $data->save();
    }

        // if cash in to bank
        public static function debitBankAc($bank_id, $amount, $expense_id=null, $invoice_id=null, $cashflow_id=null, $date = null){
          //dd($bank_id);
            $ca = DB::table('bank_accounts')
              ->where('bank_id', $bank_id) 
              ->orderBy('id', 'DESC')
              ->first();
            if($ca){
                $current_balance = $ca->current_balance + $amount;  
            }else{
                $current_balance = $amount;
            } 
            
            $data = new BankAccount;
            $data->bank_id = $bank_id;       
            $data->expense_id = $expense_id;       
            $data->invoice_id = $invoice_id;       
            $data->cashflow_id = $cashflow_id;       
            $data->type = 'Debit';  
            $data->amount_in = $amount;
            $data->current_balance = $current_balance;
            $data->created_by = session('user.id');
            $data->client_id = session('client_id');
            $data->created_at = $date;
            $data->save();
        }
    
        // if cash reduced for product purchase or cashflow debit 
        public static function creditBankAc($bank_id, $amount, $cashflow_id = null, $expense_id =null, $date = null){
            $ba = DB::table('bank_accounts')
              ->where('bank_id', $bank_id)
              ->orderBy('id', 'DESC')
              ->first();
            if($ba){
              $current_balance = $ba->current_balance - $amount;  
            }else{
              $current_balance = 0 - $amount; 
            }
            
            $data = new BankAccount;
            $data->bank_id = $bank_id;          
            $data->cashflow_id = $cashflow_id;          
            $data->expense_id = $expense_id;          
            $data->type = 'Credit';  
            $data->amount_out = $amount;
            $data->current_balance = $current_balance;
            $data->created_by = session('user.id');
            $data->client_id = session('client_id');
            $data->created_at = $date;
            $data->save(); 
        }


    // product unload/purchase
    public static function debitProductStock($product_id, $store_id, $productQty, $purchase_id, $debit_type = null){
      $ps = DB::table('product_stocks')
        ->where('product_id', $product_id)
        ->where('store_id', $store_id)
        ->orderBy('id', 'DESC')
        ->first();
      if($ps){
          $qty = $productQty;  
          $store_qty = $ps->store_qty + $productQty;  
          $total_qty = $ps->total_qty + $productQty;  
      }else{
        $qty = $productQty;  
        $store_qty = $productQty;  
        $just_product = DB::table('product_stocks')
        ->where('product_id', $product_id)
        ->orderBy('id', 'DESC')
        ->first();
        if($just_product){
          $total_qty = $just_product->total_qty + $productQty;  
        }else{
          $total_qty = $productQty;
        }         
      } 
      
      $data = new ProductStock;
      $data->product_id = $product_id;       
      $data->store_id = $store_id;  
      if($purchase_id == 'Plus'){
        $data->type = 'Plus';
        $purchase_id = null;
      } 
      if($debit_type == 'Production'){
        $data->type = 'Production';
        $purchase_id = null;
      }
      else{
        $data->type = 'Debit'; 
      }       

      $data->qty = $qty;
      $data->store_qty = $store_qty;
      $data->total_qty = $total_qty;
      $data->purchase_id = $purchase_id;
      $data->client_id = session('client_id');
      $data->created_by = session('user_id');
      $data->save();
    }
    
    // product return
    public static function returnProductStock($product_id, $store_id, $productQty, $order_id){
      $ps = DB::table('product_stocks')
        ->where('product_id', $product_id)
        ->where('store_id', $store_id)
        ->orderBy('id', 'DESC')
        ->first();
      if($ps){
          $qty = $productQty;  
          $store_qty = $ps->store_qty + $productQty;  
          $total_qty = $ps->total_qty + $productQty;  
      }else{
        $qty = $productQty;  
        $store_qty = $productQty;  
        $just_product = DB::table('product_stocks')
        ->where('product_id', $product_id)
        ->orderBy('id', 'DESC')
        ->first();
        if($just_product){
          $total_qty = $just_product->total_qty + $productQty;  
        }else{
          $total_qty = $productQty;
        }        
      } 
      
      $data = new ProductStock;
      $data->product_id = $product_id;       
      $data->store_id = $store_id;       
      $data->type = 'Return';  
      $data->qty = $qty;
      $data->store_qty = $store_qty;
      $data->total_qty = $total_qty;
      $data->purchase_id = $order_id;
      $data->client_id = session('client_id');
      $data->created_by = session('user_id');
      $data->save();
    }

    // product SOLD OR UNLOAD DELETED
    public static function creditProductStock($product_id, $store_id, $productQty, $invoice_id){
      $ps = DB::table('product_stocks')
        ->where('product_id', $product_id)
        ->where('store_id', $store_id)
        ->orderBy('id', 'DESC')
        ->first();
      if($ps){
          $qty = $productQty;  
          $store_qty = $ps->store_qty - $productQty;  
          $total_qty = $ps->total_qty - $productQty;  
      }else{
        $qty = 0 - $productQty;  
        $store_qty = 0 - $productQty;  

        $just_product = DB::table('product_stocks')
        ->where('product_id', $product_id)
        ->orderBy('id', 'DESC')
        ->first();
        if($just_product){
          $total_qty = $just_product->total_qty - $productQty;  
        }else{
          $total_qty = $productQty;
        }         
      } 
      
      $data = new ProductStock;
      $data->product_id = $product_id;       
      $data->store_id = $store_id; 
      if($invoice_id == ''){
        $data->type = 'Removed'; // purchase removed/deleted
      }
      elseif($invoice_id == 'Minus'){
        $data->type = 'Minus';
        $invoice_id = null;
      }
      else{
        $data->type = 'Credit'; 
      }      
      $data->qty = $qty;
      $data->store_qty = $store_qty;
      $data->total_qty = $total_qty;
      $data->invoice_id = $invoice_id;
      $data->client_id = session('client_id');
      $data->created_by = session('user_id');
      $data->save();
    }

    public static function updateProductStockStatus($product_id, $product_sn){
      $data = ProductStockDetail::where('product_sn', $product_sn)
            ->where('product_id', $product_id)
            ->first();
      $data->status= 'Sold';
      $data->save(); 
     
    }



}
