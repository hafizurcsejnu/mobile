<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BlogCategoryController;
use App\Http\Controllers\DataLookupController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ReturnController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\BankCheckController;
use App\Http\Controllers\CargoInvoiceController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ProductionController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\CashFlowController; 
use App\Http\Controllers\DataMigrationController; 

use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\WishListController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DutyController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\UsersExportController;

use App\Http\Controllers\DropzoneController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\ResumeController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\FileController;
use App\Http\Middleware\admin;
use App\Http\Middleware\user;
use App\Models\Page;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    if(session('user.user_type') == 'Admin' || session('user.user_type') == 'Moderator'){
        return redirect('/admin');
    }else{
        return view('user_login');
    }
});

// Route::get('blog',[BlogController::Class,'index']);
// Route::get('blog/{id}',[BlogController::Class,'show']);
// Route::get('page/{id}',[PageController::Class,'show']);

Route::get('3dmodels',[ProductController::Class,'shop'])->name('3dmodels');
Route::get('3dmodels',[ProductController::Class,'shop'])->name('shop');

Route::get('sets',[ProductController::Class,'sets'])->name('sets');
Route::get('collections',[ProductController::Class,'collections'])->name('collections');

Route::get('freebies',[ProductController::Class,'freebies'])->name('freebies');
Route::get('custom-3d-service', function () {
    return view('services');  
});
// Route::get('contact', function () {
//     return view('contact');  
// });
Route::post('contact_form', [UserController::class, 'contactForm'])->name('contact_form');

Route::get('404', function () {
    return view('404');  
});
Route::get('maintenance', function () {
    return view('under_construction');  
});
 

Route::get('3dmodels-category/{id}',[ProductController::Class,'shopCategory'])->name('category');
Route::get('3dmodels-subcategory/{id}',[ProductController::Class,'shopSubCategory'])->name('sub-category');
Route::get('quick-view/{id}',[ProductController::Class,'quickView']); 
Route::get('more-categories',[HomeController::Class,'loadCategories'])->name('load-more-category');

Route::get('product/{id}',[ProductController::Class,'show']);
Route::get('3dmodels-category/product/{id}',[ProductController::Class,'show']);

//search url
Route::post('mobile-search',[ProductController::class,'mobileSearch'])->name('mobile-search');
Route::post('search_product',[ProductController::class,'search_product']);
Route::post('product/search_product',[ProductController::class,'search_product']);
Route::post('3dmodels-category/search_product',[ProductController::class,'search_product']);

Route::get('collection/{id}',[CollectionController::Class,'show']);

//wishlist
Route::post('add-to-wishlist',[WishListController::Class,'addToWishlist'])->name('add-to-wishlist');
// Route::post('3dmodels-category/add-to-wishlist',[WishListController::Class,'addToWishlist'])->name('add-to-wishlist');
 

//cart option
Route::post('add-to-cart',[CheckoutController::Class,'AddToCart'])->name('add-to-cart');
Route::post('mobile-search/add-to-cart',[CheckoutController::Class,'AddToCart'])->name('add-to-cart');
Route::post('shop-subcategory/add-to-cart',[CheckoutController::Class,'AddToCart'])->name('add-to-cart');
Route::post('product/add-to-cart',[CheckoutController::Class,'AddToCart'])->name('add-to-cart');
Route::post('3dmodels-category/add-to-cart',[CheckoutController::Class,'AddToCart'])->name('add-to-cart');
Route::post('3dmodels/add-to-cart',[CheckoutController::Class,'AddToCart'])->name('add-to-cart');


Route::post('shop-subcategory/update-cart',[CheckoutController::Class,'updateCartItem'])->name('update-cart');
Route::post('product/remove-cart-item',[CheckoutController::Class,'removeCartItem'])->name('remove-cart-item');


Route::post('shop-category/add-to-cart',[CheckoutController::Class,'AddToCart'])->name('add-to-cart');
Route::post('shop-category/update-cart',[CheckoutController::Class,'updateCartItem'])->name('update-cart');
Route::post('shop-category/remove-cart-item',[CheckoutController::Class,'removeCartItem'])->name('remove-cart-item');


Route::post('shop/update-cart',[CheckoutController::Class,'updateCartItem'])->name('update-cart');
Route::post('shop/remove-cart-item',[CheckoutController::Class,'removeCartItem'])->name('remove-cart-item');


Route::get('get-cart-total',[CheckoutController::class,'getCartTotal'])->name('get-cart-total');
Route::get('cart',function(){
    return view('cart');
});
Route::get('payment',[CheckoutController::class,'payment'])->name('payment');
  
 
/*checkout*/
Route::get('checkout',[CheckoutController::Class,'index']); 
Route::get('cancel',[CheckoutController::Class,'index']); 

Route::post('create-payment',[PaymentController::class,'createPayment'])->name('create-payment');
Route::get('execute-payment',[PaymentController::class,'execute']);
Route::post('stripe',[PaymentController::class,'stripePayment'])->name('stripe.post');

Route::post('stripe-checkout',[PaymentController::class,'stripeCheckout'])->name('stripe.checkout');
Route::get('payment-success',[PaymentController::class,'paymentSuccess']);

Route::get('send_email',[PaymentController::class,'testMail']);  


Route::get('/login', function () {
    if(session('user.user_type') == 'User'){       
        return redirect('/');
    }
    else if(session('user.user_type') == 'Admin' || session('user.user_type') == 'Moderator'){
        return redirect('/admin');
    }else{
        return view('user_login');
    }
})->name('login');


Route::get('logout', [UserController::class, 'logout'])->name('logout');
Route::get('/no-access', function(){  
    return view('errors/no-access');  
}); 



/*user section*/
Route::post('create_user', [UserController::class, 'store']);
//Route::view('login', 'user_login')->name('login');
Route::post('access-user', [UserController::class, 'login']);


Route::view('main', 'home_main');

Route::get('verify', [UserController::class, 'verifyUser'])->name('verify.user');

Route::post('reset-password', [UserController::class, 'resetPassword']);
Route::get('reset', [UserController::class, 'resetPass'])->name('reset');
Route::view('new-password', 'new_password')->name('newPassword');
Route::post('new-password-store', [UserController::class, 'newPasswordStore']);

Route::post('coupon_execution',[CouponController::class,'checkCoupon']);
Route::get('freebees-download/{id}/{source}',[ProductController::Class,'freebeesDownload']);

Route::get('/stock/{id}', [StoreController::class, 'stock']);


//user
Route::middleware([user::class])->group(function () {   

    // resume section
    Route::get('profile', [UserController::class, 'edit']);
    Route::post('update-user', [UserController::class, 'update']);

    Route::post('update_user', [UserController::class, 'update_user']);
    
    //customer
    Route::get('/my-account', [UserController::Class,'myAccount']); 
    
    Route::get('/my-wishlist', [WishListController::Class,'myWishlist']); 
    Route::post('/wishlist_remove', [WishListController::Class,'destroy']); 

    /**
     * Routes for Folder CRUD
     */
    Route::get('my-documents', [FolderController::class, 'index']);
    Route::get('get-folder-by-id/{folderId}', [FolderController::class, 'getFolderById']);
    Route::post('create-folder',[FolderController::class, 'create']);
    Route::post('sorting-folder',[FolderController::class, 'sorting']);
    Route::post('rename-folder',[FolderController::class, 'renameFolder']);
    Route::delete('delete-folder/{folderId}',[FolderController::class, 'deleteFolder']);
    Route::get('get-tree-data', [FolderController::class, 'getTreeData']);
    Route::post('upload', [FileController::class, 'create'])->name('createFile');
    Route::post('rename-file',[FileController::class, 'renameFile']);
    Route::delete('delete-file/{fileId}',[FileController::class, 'deleteFile']);
    Route::get('get-folder-files/{type}/{folderId}', [FileController::class, 'getFolderFiles']);
    Route::get('get-file-by-id/{fileId}', [FileController::class, 'getFileById']);
    Route::POST('copy-file', [FileController::class, 'copyFile']);
    Route::get('check-file-exist/{folderId}', [FolderController::class, 'checkFileExist']);
    Route::get('download/{fileId}', [FileController::class, 'download']);
});

Route::get('/documentation', function(){
    return view('admin.documentation');    
}); 





/************************************************************
 //admin section
 ************************************************************/

Route::middleware([admin::class])->group(function () {
    
    Route::get('/admin', function(){
        return view('admin.index');    
    });
    Route::get('/dashboard', function(){ 
        return view('admin/index');
    });  

    Route::get('settings', [SettingController::class, 'index']);
    Route::get('resetall', [SettingController::class, 'reset']);
    Route::post('update_settings', [SettingController::class, 'update']);

    Route::get('profile', [UserController::class, 'edit']);
    Route::post('update-user', [UserController::class, 'update']);    
    Route::post('update_user_type', [UserController::class, 'update_user_type']);
    
    Route::view('resume-list', 'resume_list');
    Route::resource('sections', SectionController::class);

    Route::get('templates', [TemplateController::class, 'index']);
    Route::post('template_store', [TemplateController::class, 'store']);
    Route::post('template_update', [TemplateController::class, 'update']);
    Route::get('template_delete/{id}', [TemplateController::class, 'destroy']);

    Route::get('users', [UserController::class, 'index']);
    Route::get('/add-user', [UserController::class, 'create']);
    Route::post('/save_user', [UserController::class, 'storeUser'])->name('save_user');
    Route::post('/upload_user', [UserController::class, 'upload'])->name('upload_user');
    Route::get('/edit-user/{id}', [UserController::class, 'edit']);
    Route::post('/update_user', [UserController::class, 'update']);
    Route::get('/delete-user/{id}', [UserController::class, 'destroy']);


    Route::post('change_user_status', [UserController::class, 'change_user_status']);
    Route::post('storeUser', [UserController::class, 'storeUser']);
    Route::post('updateUser', [UserController::class, 'updateUser']);
    Route::get('delete-user/{id}', [UserController::class, 'destroy']); 

    /*blog_category*/
    Route::get('/blog-categories', [BlogCategoryController::class, 'index']);
    Route::post('/store_blog_category', [BlogCategoryController::class, 'store']);
    Route::post('/update_blog_category', [BlogCategoryController::class, 'update']);
    Route::get('/delete_blog_category/{id}', [BlogCategoryController::class, 'destroy']);

    /*data_lookup*/
    Route::get('/data-lookup', [DataLookupController::class, 'index']);
    Route::post('/store_data_lookup', [DataLookupController::class, 'store']);
    Route::post('/update_data_lookup', [DataLookupController::class, 'update']);
    Route::get('/delete_data_lookup/{id}', [DataLookupController::class, 'destroy']);

    /*blog*/
    Route::get('/blogs', [BlogController::class, 'blogs']);
    Route::get('/add-blog', [BlogController::class, 'create']);
    Route::post('/save_blog', [BlogController::class, 'store']);
    Route::get('/edit-blog/{id}', [BlogController::class, 'edit']);
    Route::post('/update_blog', [BlogController::class, 'update']);
    Route::get('/delete-blog/{id}', [BlogController::class, 'destroy']);

    /*product_category*/
    Route::get('/product-categories', [ProductCategoryController::class, 'index']);
    Route::post('/store_product_category', [ProductCategoryController::class, 'store']);
    Route::post('/update_product_category', [ProductCategoryController::class, 'update']);
    Route::get('/delete_product_category/{id}', [ProductCategoryController::class, 'destroy']);
    Route::get('/delete_product_sub_category/{id}', [ProductCategoryController::class, 'destroySubCat']); 

    /*coupon*/
    Route::get('/coupons', [CouponController::class, 'index']);
    Route::post('/store_coupon', [CouponController::class, 'store']);
    Route::post('/update_coupon', [CouponController::class, 'update']);
    Route::get('/delete_coupon/{id}', [CouponController::class, 'destroy']);
 
  
    /*product*/
    Route::get('/products', [ProductController::class, 'products']); 
    Route::get('/services', [ProductController::class, 'services']); 
    Route::get('/add-product', [ProductController::class, 'create']);
    Route::get('/add-product2', [ProductController::class, 'create2']);

    // data migration
    Route::get('/alibaba', [DataMigrationController::class, 'alibaba']);
    Route::get('/updateDate', [DataMigrationController::class, 'updateDate']);
    Route::get('/updateObDate', [DataMigrationController::class, 'updateObDate']);
    Route::get('/insertProduct', [DataMigrationController::class, 'insertProduct']);


    Route::get('/add-service', [ProductController::class, 'createService']);
    Route::post('/save_product', [ProductController::class, 'store'])->name('save_product');
    Route::post('/upload_product', [ProductController::class, 'upload'])->name('upload_product');
    Route::get('/edit-product/{id}', [ProductController::class, 'edit']);
    Route::get('/edit-service/{id}', [ProductController::class, 'editService']);
    Route::post('/update_product', [ProductController::class, 'update']);
    Route::get('/delete-product/{id}', [ProductController::class, 'destroy']);
    Route::post('/upload_price', [ProductController::class, 'updatePrice'])->name('update_price');
    Route::get('/add-stock/{id}', [ProductController::class, 'addStock']);
    Route::get('/product-stock/{id}', [ProductController::class, 'productStock']);
    Route::get('/product-stock-details/{id}', [ProductController::class, 'productStockDetails']);


    /*duty*/
    Route::get('/duties', [DutyController::class, 'index']);
    Route::get('/add-duty', [DutyController::class, 'create']);
    Route::post('/save_duty', [DutyController::class, 'store']);
    Route::get('/edit-duty/{id}', [DutyController::class, 'edit']);
    Route::post('/update_duty', [DutyController::class, 'update']);


 
    /*collection*/
    Route::get('/all-collections', [CollectionController::class, 'index']);
    Route::get('/add-collection', [CollectionController::class, 'create']);
    Route::post('/save_collection', [CollectionController::class, 'store'])->name('save_collection');
    Route::post('/upload_collection', [CollectionController::class, 'upload'])->name('upload_collection');
    Route::get('/edit-collection/{id}', [CollectionController::class, 'edit']);
    Route::post('/update_collection', [CollectionController::class, 'update']);
    Route::get('/delete-collection/{id}', [ProductController::class, 'destroy']);

    Route::post('find_subcategory',[ProductController::class,'find_subcategory']);
    Route::post('find_product_id',[ProductController::class,'find_product_id']);

    // data migration
    // Route::get('/g_product', [DataMigrationController::class, 'g_product']); 
    // Route::get('/g_cat', [DataMigrationController::class, 'g_cat']); 
    // Route::get('/g_data_lookup', [DataMigrationController::class, 'g_data_lookup']); 
    //Route::get('/g_company_acc', [DataMigrationController::class, 'g_company_acc']); 
    Route::get('/g_inv_id', [DataMigrationController::class, 'g_inv_id']); 



   
    /*page*/
    Route::get('/page', [PageController::class, 'index']);
    Route::get('/pages', [PageController::class, 'index']);
    Route::get('/add-page', [PageController::class, 'create']);
    Route::post('/save_page', [PageController::class, 'store']);
    Route::get('/edit-page/{id}', [PageController::class, 'edit']);
    Route::post('/update_page', [PageController::class, 'update']);
    Route::get('/delete-page/{id}', [PageController::class, 'destroy']);
    
    /*stores*/
    Route::get('/store', [StoreController::class, 'index']);
    Route::get('/stores', [StoreController::class, 'index']);
    Route::get('/add-store', [StoreController::class, 'create']);
    Route::post('/save_store', [StoreController::class, 'store']);
    Route::get('/edit-store/{id}', [StoreController::class, 'edit']);
    Route::post('/update_store', [StoreController::class, 'update']);
    Route::get('/delete-store/{id}', [StoreController::class, 'destroy']);
    Route::get('/store-details/{id}', [StoreController::class, 'show']);
 


     /*customer*/
     Route::get('/customers', [CustomerController::class, 'index']);
     Route::get('/add-customer', [CustomerController::class, 'create']);
     Route::post('/save_customer', [CustomerController::class, 'store']);
     Route::get('/edit-customer/{id}', [CustomerController::class, 'edit']);
     Route::get('/customer-details/{id}', [CustomerController::class, 'show']);
     Route::post('/update_customer', [CustomerController::class, 'update']);
     Route::get('/delete-customer/{id}', [CustomerController::class, 'destroy']);

     /*employee*/
     Route::get('/employees', [EmployeeController::class, 'index']);
     Route::get('/add-employee', [EmployeeController::class, 'create']);
     Route::post('/save_employee', [EmployeeController::class, 'store']);
     Route::get('/edit-employee/{id}', [EmployeeController::class, 'edit']);
     Route::get('/employee-details/{id}', [EmployeeController::class, 'show']);
     Route::post('/update_employee', [EmployeeController::class, 'update']);
     Route::get('/delete-employee/{id}', [EmployeeController::class, 'destroy']);

     /*salary*/
    Route::get('/salaries', [SalaryController::class, 'index']);
    Route::get('/add-salary', [SalaryController::class, 'create']);
    Route::post('/save_salary', [SalaryController::class, 'store']);
    Route::get('/add-salary2', [SalaryController::class, 'create2']);
    Route::post('/save_salary2', [SalaryController::class, 'store2']);   
    Route::get('/edit-salary/{id}', [SalaryController::class, 'edit']);
    Route::post('/update_salary', [SalaryController::class, 'update']);
    Route::get('/delete-salary/{id}', [SalaryController::class, 'destroy']);


     Route::post('/store_customer_ob', [CustomerController::class, 'storeOB']);
     Route::post('/store_customer_ac', [CustomerController::class, 'storeCustomerAc']);

    /*invoice*/
    Route::get('/akij', [InvoiceController::class, 'akij']);  
    Route::get('/due-invoices', [InvoiceController::class, 'dueInvoices']);  
    Route::get('/invoices', [InvoiceController::class, 'index']);  
    Route::get('/add-invoice', [InvoiceController::class, 'create']);
    Route::get('/add-invoice2', [InvoiceController::class, 'create2']);
    Route::get('/add-invoice3', [InvoiceController::class, 'create3']);
    Route::get('/create-invoice', [InvoiceController::class, 'createInvoice']);
    Route::get('/wholesale-invoice', [InvoiceController::class, 'createWholesale']);
    Route::post('/store_invoice', [InvoiceController::class, 'store']);
    Route::get('/edit-invoice/{id}', [InvoiceController::class, 'edit']);
    Route::post('/update_invoice', [InvoiceController::class, 'update']);
    Route::get('/delete-invoice/{id}', [InvoiceController::class, 'destroy']);
    Route::get('/invoice-details/{id}', [InvoiceController::class, 'show']);
    // Route::get('/invoice-preview/{id}', [InvoiceController::class, 'invoice']);
    Route::get('invoice/{id}', [InvoiceController::class, 'pdf']);


    /*return*/
    Route::get('/returns', [ReturnController::class, 'index']);  
    Route::get('/add-return', [ReturnController::class, 'create']);
    Route::get('/create-return', [ReturnController::class, 'createReturn']);
    Route::post('/store_return', [ReturnController::class, 'store']);
    Route::get('/edit-return/{id}', [ReturnController::class, 'edit']);
    Route::post('/update_return', [ReturnController::class, 'update']);
    Route::get('/delete-return/{id}', [ReturnController::class, 'destroy']);
    Route::get('/return-details/{id}', [ReturnController::class, 'show']);
    Route::get('/return-preview/{id}', [ReturnController::class, 'return']);
    Route::get('return/{id}', [ReturnController::class, 'pdf']);


    Route::post('/update_stock', [ProductController::class, 'update_opening_stock']);

    Route::post('find_product',[InvoiceController::class,'find_product']);
    Route::post('find_product_sn',[InvoiceController::class,'find_product_sn']);
    Route::post('find_imei',[InvoiceController::class,'find_imei']);
    Route::post('find_product_code',[InvoiceController::class,'find_product_code']);
    Route::post('find_customer',[InvoiceController::class,'find_customer']);
    Route::post('find_employee',[InvoiceController::class,'find_employee']);
    Route::post('find_discount',[InvoiceController::class,'find_discount']);
    Route::post('find_equipement_rate',[DutyController::class,'find_equipement_rate']);

    /*company*/
    Route::get('/companies', [CompanyController::class, 'index']);
    Route::get('/add-company', [CompanyController::class, 'create']);
    Route::post('/save_company', [CompanyController::class, 'store']);
    Route::get('/edit-company/{id}', [CompanyController::class, 'edit']);
    Route::post('/update_company', [CompanyController::class, 'update']);
    Route::get('/delete-company/{id}', [CompanyController::class, 'destroy']);
    Route::post('/update_company_ob', [CompanyController::class, 'update_company_ob']);

    /*bank*/
    Route::get('/banks', [BankController::class, 'index']);
    Route::get('/add-bank', [BankController::class, 'create']);
    Route::post('/save_bank', [BankController::class, 'store']);
    Route::get('/edit-bank/{id}', [BankController::class, 'edit']);
    Route::post('/update_bank', [BankController::class, 'update']);
    Route::get('/delete-bank/{id}', [BankController::class, 'destroy']);

    /*bank checks*/
    Route::get('/bank-checks', [BankCheckController::class, 'index']);
    Route::post('/store_bank_check', [BankCheckController::class, 'store']);
    Route::post('/update_bank_check', [BankCheckController::class, 'update']);
    Route::get('/delete-bank-check/{id}', [BankCheckController::class, 'destroy']);

    /*cargo-invoice*/
    Route::get('/cargo-invoices', [CargoInvoiceController::class, 'index']);
    Route::get('/add-cargo-invoice', [CargoInvoiceController::class, 'create']);
    Route::post('/save_cargo_invoice', [CargoInvoiceController::class, 'store']);
    Route::get('/edit-cargo-invoice/{id}', [CargoInvoiceController::class, 'edit']);
    Route::post('/update_cargo_invoice', [CargoInvoiceController::class, 'update']);
    Route::get('/delete-cargo-invoice/{id}', [CargoInvoiceController::class, 'destroy']);

    /*purchase*/
    Route::get('/purchases', [PurchaseController::class, 'index']);
    Route::get('/add-purchase', [PurchaseController::class, 'create']);
    Route::post('/save_purchase', [PurchaseController::class, 'store']);
    Route::get('/add-purchase2', [PurchaseController::class, 'create2']);
    Route::post('/save_purchase2', [PurchaseController::class, 'store2']);   
    Route::get('/edit-purchase/{id}', [PurchaseController::class, 'edit']);
    Route::post('/update_purchase', [PurchaseController::class, 'update']);
    Route::get('/delete-purchase/{id}', [PurchaseController::class, 'destroy']);

    Route::post('/store_stock_adjustment', [PurchaseController::class, 'stockAdmustment']);

    /*production*/
    Route::get('/productions', [ProductionController::class, 'index']);
    Route::get('/add-production', [ProductionController::class, 'create']);
    Route::post('/save_production', [ProductionController::class, 'store']);
    Route::get('/edit-production/{id}', [ProductionController::class, 'edit']);
    Route::post('/update_production', [ProductionController::class, 'update']);
    Route::get('/delete-production/{id}', [ProductionController::class, 'destroy']);
    
    /*expense*/
    Route::get('/expenses', [ExpenseController::class, 'index']);
    Route::get('/add-expense', [ExpenseController::class, 'create']);
    Route::post('/save_expense', [ExpenseController::class, 'store']);
    Route::get('/edit-expense/{id}', [ExpenseController::class, 'edit']);
    Route::post('/update_expense', [ExpenseController::class, 'update']);
    Route::get('/delete-expense/{id}', [ExpenseController::class, 'destroy']);

    /*cashflow*/
    Route::get('/cashflows', [CashFlowController::class, 'index']);
    Route::get('/add-cashflow', [CashFlowController::class, 'create']);
    Route::post('/save_cashflow', [CashFlowController::class, 'store']);
    Route::get('/edit-cashflow/{id}', [CashFlowController::class, 'edit']);
    Route::post('/update_cashflow', [CashFlowController::class, 'update']);
    Route::get('/delete-cashflow/{id}', [CashFlowController::class, 'destroy']);

    Route::post('find_store',[StoreController::class,'find_store']); 
    
    /*reports*/
    Route::get('/invoice-preview/{id}', [InvoiceController::class, 'invoice']);
    Route::get('/invoice-stock', [InvoiceController::class, 'invoiceStock']);
    Route::get('/invoice-pos/{id}', [InvoiceController::class, 'invoicePos']);
    Route::get('/delivery-order/{id}', [InvoiceController::class, 'deliveryOrder']);


});
 
  
 









