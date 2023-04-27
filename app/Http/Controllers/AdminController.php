<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DB;
use Session;
session_start(); //this will control back btn click effect

use Illuminate\Support\Facades\Mail;
use \App\Mail\SendMail;
use Barryvdh\DomPDF\Facade as PDF;

class AdminController
{
    /**
     * Display a listing of the resource.

     * echo "<pre>"; print_r($result); exit();

     * @return \Illuminate\Http\Response
     */

    public function __construct(){
       //echo $user_id = Session::get('user_id');
    }
    public function authCheck()
    {
      $user_id = Session::get('user_id');
      $name = Session::get('name');

      if ($user_id) {
        return;
      }else{
        return Redirect::to('/xyz')->send();
      }
    }

    public function index()
    {
      return view('admin.login');
    }


    public function dashboard()
    {
      $this->authCheck();

      $dashboard=view('admin.dashboard');
      return view('admin.master')
      ->with('main_content',$dashboard);
    }


    // pdf
      public function invoicePdf($cat_id)
      {
        /*$orderData = DB::table('orders')
        ->where('id',$cat_id)
        ->first();

        $orderData =$request->id;*/
       $data=array();
       
       $data['order_id']=$cat_id;

       $name = 'INV-'.$cat_id.'.pdf';

        $pdf = PDF::loadView('pdf', ['order_id' => $cat_id]);
       /* return $pdf->download('invoice.pdf');*/
        return $pdf->download($name);

      }


    /*============================
       Login Logout
       ============================*/

       public function login()
       {
        return view('admin.login');
       }     

      public function adminLogin(Request $request)
      {
        $email= $request->email;
        $password= $request->password;        

        $result = DB::table('users')
        ->where('email', $email)
        ->where('password', md5($password))
        ->first();

        if ($result) {
          Session::put('name', $result->name);
          Session::put('user_id', $result->id);
          Session::put('user_type', $result->user_type);
          return Redirect::to('/dashboard');

        }else{
          Session::put('exception', 'Invalid user id or password!');
          return Redirect::to('/xyz');
        }

      }

      public function logout()
      {
       Session::put('name');
       Session::put('user_id');
       Session::put('customer_id');
       Session::put('message','You are successfully logout!');

       return Redirect::to('/xyz');
     }


     /*============================
       End Login
       ============================*/



       public function saveContact(Request $request)
      {
        
        $data=array();
        $data['name']=$request->name;
        $data['email']=$request->email;
        $data['phone']='';
        $data['subject']='';
        $data['message']=$request->message;

        DB::table('web_messages')->insert($data);

        Session::put('message', 'Your message sent successfully!');
        return Redirect::to('/contact');
      }




    /*============================
       Category
       ============================*/
       public function categories()
       {
        $this->authCheck();

        $categoryData = DB::table('categories')
        ->get();
        
        $categories=view('admin.category_list')
        ->with('categoryData',$categoryData);

        return view('admin.master')
        ->with('main_content',$categories);
      } 

      public function addCategory()
      {
        $this->authCheck();
        
        $addCategory=view('admin.category_add');

        return view('admin.master')
        ->with('main_content',$addCategory);
      }

      public function saveCategory(Request $request)
      {
        //$this->authCheck();
        $data=array();
        $data['name']=$request->name;
        $data['description']=$request->description;
        $data['active']=$request->active;
        $data['created_by']=Session::get('user_id');
        $data['updated_by']='';       

        DB::table('categories')->insert($data);

        Session::put('message', 'Category saved successfully!');
        return Redirect::to('/categories');
      }

      public function editCategory($cat_id)
      {
        $categoryData = DB::table('categories')
        ->where('id',$cat_id)
        ->first();

        $editCategory=view('admin.category_edit')
        ->with('categoryData',$categoryData);

        return view('admin.master')
        ->with('main_content',$editCategory);

        return Redirect::to('/categories');
      }

      public function updateCategory(Request $request)
      {
        //$this->authCheck();
        $data=array();

        $id=$request->id;
        $data['name']=$request->name;
        $data['description']=$request->description;
        $data['active']=$request->active;

        DB::table('categories')
        ->where('id',$id)
        ->update($data);

        Session::put('message', 'Category updated successfully!');
        return Redirect::to('/categories');
      }

      public function deleteCategory($cat_id)
      {
        DB::table('categories')
        ->where('id',$cat_id)
        ->delete();

        Session::put('message', 'Category deleted successfully!');
        return Redirect::to('/categories');
      }

    /*============================
       End Category
       ============================*/


      /*============================
       Diagnostic Test Start
       ============================*/
       public function tests()
       {
        $this->authCheck();

        /*$testData = DB::table('diagnostic_tests')
        ->get();*/

        $testData = DB::table('diagnostic_tests')
        ->join('categories', 'diagnostic_tests.category_id', '=', 'categories.id')
        ->select('diagnostic_tests.*', 'categories.name as catName')
        ->get();
        
        $tests=view('admin.test_list')
        ->with('testData',$testData);

        return view('admin.master')
        ->with('main_content',$tests);

      } 

      public function users()
       {
        $this->authCheck();

        $fetch = DB::table('customers')
        ->get();
        
        $data=view('admin.users')
        ->with('data',$fetch);

        return view('admin.master')
        ->with('main_content',$data);

      } 

      public function customerRegistrationAdmin(Request $request)
      {
          //$this->authCheck();
          $data=array();
         // dd($request);
          $source=$request->source;
          $data['name']=$request->name;
          $data['father']=$request->father;
          $data['mother']=$request->mother;
          $data['customer_type']=$request->customer_type;
          if($request->email==''){
            $data['email']=$request->mobile;
          }else{
            $data['email']=$request->email;
          }             
          
          $data['mobile']=$request->mobile;
          $data['date_of_birth']=$request->date_of_birth;
          $data['address']=$request->address;
          $data['maritual_status']=$request->maritual_status;
          $data['religion']=$request->religion;
          $data['nationality']=$request->nationality;
          $data['active']='on';
          $data['password']=md5($request->mobile);

          $data['s_year']=$request->s_year;
          $data['s_board']=$request->s_board;
          $data['s_roll']=$request->s_roll;
          $data['s_gpa']=$request->s_gpa;
          $data['h_year']=$request->h_year;
          $data['h_board']=$request->h_board;
          $data['h_roll']=$request->h_roll;
          $data['h_gpa']=$request->h_gpa;

          $data['ho_year']=$request->ho_year;
          $data['ho_university']=$request->ho_university;
          $data['ho_subject']=$request->ho_subject;
          $data['ho_cgpa']=$request->ho_cgpa;

          $data['m_year']=$request->m_year;
          $data['m_university']=$request->m_university;
          $data['m_subject']=$request->m_subject;
          $data['m_cgpa']=$request->m_cgpa;


          if (!empty($request->file('image'))) {
            $file = $request->file('image');
            $filename = $file->getClientOriginalName();
            $picture = date('His').$filename;      
            $path = 'images/member/';
            $destination_path = base_path(). '/images/member';
            $success = $file->move($destination_path, $picture);
          }

          $data['image']=$path."".$picture;


          $customer_id = DB::table('customers')->insertGetId($data);

          if ($customer_id) {
              // Session::put('customer_id',$customer_id);
              // Session::put('customer_name',$request->name);

              if($source=='frontend'){
                Session::put('message','Your registration form has been submitted successfully.');
                return Redirect::to('/registration');
              }else{
                return Redirect::to('/users');
              }

              
          }
      }

      public function editUser($id)
      {
        $fetch = DB::table('customers')
        ->where('id',$id)
        ->first();

        $data=view('admin.user-edit')
        ->with('data',$fetch);

        return view('admin.master')
        ->with('main_content',$data);

        return Redirect::to('/users');
      }

      public function updateUser(Request $request)
      {
        //$this->authCheck();
        $data=array();

        $file = $request->file('image');
        if($file == null){  
         $image =  $request->hidden_image;        
       }
       else{
        $file = $request->file('image');
        $filename = $file->getClientOriginalName();
        $picture = date('His').$filename;      
        $path = 'images/member/';
        $destination_path = base_path(). '/images/member';
        $success = $file->move($destination_path, $picture); 
        $image = $path."".$picture;
      } 
      $data['image']=$image;


        $id=$request->id;
        $data['name']=$request->name;
        $data['father']=$request->father;
        $data['mother']=$request->mother;
        $data['nid']=$request->nid;
        $data['email']=$request->email;
        $data['active']=$request->active;
        $data['mobile']=$request->mobile;
        $data['date_of_birth']=$request->date_of_birth;
        $data['address']=$request->address;
        $data['maritual_status']=$request->maritual_status;
        $data['religion']=$request->religion;
        $data['nationality']=$request->nationality;
        $data['customer_type']=$request->customer_type;        

        $data['s_year']=$request->s_year;
        $data['s_board']=$request->s_board;
        $data['s_roll']=$request->s_roll;
        $data['s_gpa']=$request->s_gpa;
        $data['h_year']=$request->h_year;
        $data['h_board']=$request->h_board;
        $data['h_roll']=$request->h_roll;
        $data['h_gpa']=$request->h_gpa;

        $data['ho_year']=$request->ho_year;
        $data['ho_university']=$request->ho_university;
        $data['ho_subject']=$request->ho_subject;
        $data['ho_cgpa']=$request->ho_cgpa;

        $data['m_year']=$request->m_year;
        $data['m_university']=$request->m_university;
        $data['m_subject']=$request->m_subject;
        $data['m_cgpa']=$request->m_cgpa;


        DB::table('customers')
        ->where('id',$id)
        ->update($data);

        Session::put('message', 'Users updated successfully!');
        return Redirect::to('/users');
      }

      public function deleteUser($id)
      {
        DB::table('customers')
        ->where('id',$id)
        ->delete();

        Session::put('message', 'User deleted successfully!');
        return Redirect::to('/users');
      }

      public function addTest()
      {
        $this->authCheck();
        
        $addTest=view('admin.test_add');

        return view('admin.master')
        ->with('main_content',$addTest);
      }

      public function saveTest(Request $request)
      {
        //$this->authCheck();
        $data=array();

         /*$request->validate([
            'name'              =>  'required',
            'image'     =>  'required|image|mimes:jpeg,PNG,png,jpg,gif|max:102048'
          ]);*/

          $file = $request->file('image');
          $filename = $file->getClientOriginalName();
          $picture = date('His').$filename;      
          $path = 'images/test/';
          $destination_path = base_path(). '/images/test';
          $success = $file->move($destination_path, $picture);


          $data['name']=$request->name;
          $data['image']=$path."".$picture;
          $data['detail']=$request->detail;
          $data['active']=$request->active;
          $data['symptom']=$request->symptom;
          $data['price']=$request->price;
          $data['pre_test_info']=$request->pre_test_info;
          $data['report_delivery']=$request->report_delivery;
          $data['category_id']=$request->category_id;
          $data['created_by']=Session::get('user_id');
          $data['updated_by']='';

       // print_r($data);


          DB::table('diagnostic_tests')->insert($data);

          Session::put('message', 'Diagnostic Test saved successfully!');
          return Redirect::to('/test-list');

        }

        public function editTest($cat_id)
        {

          $testData = DB::table('diagnostic_tests')
          ->join('categories', 'diagnostic_tests.category_id', '=', 'categories.id')
          ->select('diagnostic_tests.*', 'categories.name as catName', 'categories.id as catID')
          /*->get();*/
          ->where('diagnostic_tests.id',$cat_id)
          ->first();



        /*$testData = DB::table('diagnostic_tests')
        ->where('id',$cat_id)
        ->first();*/

        $editTest=view('admin.test_edit')
        ->with('testData',$testData);

        return view('admin.master')
        ->with('main_content',$editTest);

        return Redirect::to('/test-list');
      }

      public function updateTest(Request $request)
      {
        //$this->authCheck();
        $data=array();

        $file = $request->file('image');
        if($file == null){  
         $old_image =  $request->hidden_image;  
       }
       else{
        $file = $request->file('image');
        $filename = $file->getClientOriginalName();
        $picture = date('His').$filename;      
        $path = 'images/test/';
        $destination_path = base_path(). '/images/test';
        $success = $file->move($destination_path, $picture); 
        $old_image = $path."".$picture;           
      }
      $id=$request->id;
      $data['category_id']=$request->category_id;
      $data['image'] = $old_image;
      $data['name']=$request->name;
      $data['detail']=$request->detail;
      $data['active']=$request->active;
      $data['symptom']=$request->symptom;
      $data['price']=$request->price;
      $data['pre_test_info']=$request->pre_test_info;
      $data['report_delivery']=$request->report_delivery;
      $data['updated_by']=Session::get('user_id');

        //print_r($data);

      DB::table('diagnostic_tests')
      ->where('id',$id)
      ->update($data);

      Session::put('message', 'Diagnostic Test updated successfully!');
      return Redirect::to('/test-list');
    }

    public function deleteTest($test_id)
    {
      DB::table('diagnostic_tests')
      ->where('id',$test_id)
      ->delete();

      Session::put('message', 'Diagnostic Test deleted successfully!');
      return Redirect::to('/test-list');
    }

    /*============================
       End  Diagnostic Test
       ============================*/


            /*============================
       Menus Section
       ============================*/
       public function sections()
       {
        $this->authCheck();

        $sections = DB::table('sections')
        ->get();
        
        $sections=view('admin.sections')
        ->with('sections',$sections);

        return view('admin.master')
        ->with('main_content',$sections);
      } 


      public function updateSection(Request $request)
      {
        //$this->authCheck();
        $data=array();

         $file = $request->file('image');
        if($file == null){  
         $old_image =  $request->hidden_image;        
       }
       else{
        $file = $request->file('image');
        $filename = $file->getClientOriginalName();
        $picture = date('His').$filename;      
        $path = 'images/post/';
        $destination_path = base_path(). '/images/post';
        $success = $file->move($destination_path, $picture); 
        $old_image = $path."".$picture;

      } 

        $id=$request->id;
        $data['sub_title']=$request->sub_title; 
        $data['title']=$request->title;        
        $data['image_path']=$old_image;
        $data['description']=$request->description;
        $data['position']=$request->position;
        $data['active']=$request->active;
        
        $data['updated_by']=Session::get('user_id');

        

        DB::table('sections')
        ->where('id',$id)
        ->update($data);

        Session::put('message', 'Section updated successfully!');
        return Redirect::to('/sections');
      }
      

             /*============================
       Settings Start
       ============================*/
       public function settings()
       {
        $this->authCheck();

        $settings = DB::table('site_settings')
        ->get();
        
        $settings=view('admin.settings')
        ->with('settings',$settings);

        return view('admin.master')
        ->with('main_content',$settings);
      } 

      /*public function addSetting()
      {
        $this->authCheck();
        
        $addTest=view('admin.test_add');

        return view('admin.master')
        ->with('main_content',$addTest);
      }*/

      /*public function saveSetting(Request $request)
      {
        //$this->authCheck();
        $data=array();

        $data['name']=$request->name;
        $data['detail']=$request->detail;
        $data['active']=$request->active;
        $data['symptom']=$request->symptom;
        $data['price']=$request->price;
        $data['category_id']=$request->category_id;
        $data['created_by']=Session::get('user_id');
        $data['updated_by']='';

        //print_r($data);
        

        DB::table('diagnostic_tests')->insert($data);

        Session::put('message', 'Diagnostic Test saved successfully!');
        return Redirect::to('/tests');

      }*/

      /*public function editSetting($cat_id)
      {

        $testData = DB::table('diagnostic_tests')
        ->join('categories', 'diagnostic_tests.category_id', '=', 'categories.id')
        ->select('diagnostic_tests.*', 'categories.name as catName', 'categories.id as catID')
        ->get();
        ->where('diagnostic_tests.id',$cat_id)
        ->first();




        $editTest=view('admin.test_edit')
        ->with('testData',$testData);

        return view('admin.master')
        ->with('main_content',$editTest);

        return Redirect::to('/tests');
      }*/

      public function updateSetting(Request $request)
      {
        //$this->authCheck();
        $data=array();

        $id=$request->id;
        $data['setting_value']=$request->setting_value;
        /*$data['name']=$request->name;
        $data['detail']=$request->detail;
        $data['active']=$request->active;
        $data['symptom']=$request->symptom;
        $data['price']=$request->price;*/
        $data['updated_by']=Session::get('user_id');

        

        DB::table('site_settings')
        ->where('id',$id)
        ->update($data);

        Session::put('message', 'Site Settings updated successfully!');
        return Redirect::to('/settings');
      }

      /*public function deleteSetting($test_id)
      {
        DB::table('diagnostic_tests')
        ->where('id',$test_id)
        ->delete();

        Session::put('message', 'Diagnostic Test deleted successfully!');
        return Redirect::to('/tests');
      }
*/
    /*============================
       End  Settings
       ============================*/

    /*============================
       Menus Start
       ============================*/
       public function menus()
       {
        $this->authCheck();

        $menus = DB::table('menus')
        ->get();
        
        $menus=view('admin.menus')
        ->with('menus',$menus);

        return view('admin.master')
        ->with('main_content',$menus);
      } 


      public function updateMenu(Request $request)
      {
        //$this->authCheck();
        $data=array();

        $id=$request->id;
        $data['menu_value']=$request->menu_value; 
        $data['position']=$request->position; 
        $data['sort_order']=$request->sort_order;
        $data['active']=$request->active;
        
        $data['updated_by']=Session::get('user_id');

        

        DB::table('menus')
        ->where('id',$id)
        ->update($data);

        Session::put('message', 'Menu updated successfully!');
        return Redirect::to('/menus');
      }

       /*============================
       News Category
       ============================*/
       public function newsCategories()
       {
        $this->authCheck();

        $categoryData = DB::table('news_categories')
        ->get();
        
        $newsCategories=view('admin.news_blog_category_list')
        ->with('categoryData',$categoryData);

        return view('admin.master')
        ->with('main_content',$newsCategories);
      } 

      public function addNewsCategory()
      {
        $this->authCheck();
        
        $addCategory=view('admin.news_blog_category_add');

        return view('admin.master')
        ->with('main_content',$addCategory);
      }

      public function saveNewsCategory(Request $request)
      {
        //$this->authCheck();
        $data=array();

        $data['name']=$request->name;
        $data['description']=$request->description;
        $data['active']=$request->active;
        $data['created_by']=Session::get('user_id');
        $data['updated_by']='';
        $data['active']=$request->active;

        DB::table('news_categories')->insert($data);

        Session::put('message', 'Category saved successfully!');
        return Redirect::to('/news-categories');
      }

      public function editNewsCategory($cat_id)
      {
        $categoryData = DB::table('news_categories')
        ->where('id',$cat_id)
        ->first();

        $editCategory=view('admin.news_blog_category_edit')
        ->with('categoryData',$categoryData);

        return view('admin.master')
        ->with('main_content',$editCategory);

        return Redirect::to('/news-categories');
      }

      public function updateNewsCategory(Request $request)
      {
        //$this->authCheck();
        $data=array();

        $id=$request->id;
        $data['name']=$request->name;
        $data['description']=$request->description;
        $data['active']=$request->active;

        DB::table('news_categories')
        ->where('id',$id)
        ->update($data);

        Session::put('message', 'Category updated successfully!');
        return Redirect::to('/news-categories');
      }

      public function deleteNewsCategory($cat_id)
      {
        DB::table('news_categories')
        ->where('id',$cat_id)
        ->delete();

        Session::put('message', 'Category deleted successfully!');
        return Redirect::to('/news-categories');
      }

    /*============================
       Coupon
       ============================*/

       /*============================
       News Category
       ============================*/
       public function coupons()
       {
        $this->authCheck();


        $fetchData = DB::table('coupon')
        ->where('active', 'on')
        ->get();

        /*$postData = DB::table('news_posts')
        ->get();*/
        
        $data=view('admin.coupon_list')
        ->with('data',$fetchData);

        return view('admin.master')
        ->with('main_content',$data);
      } 

      public function addCoupon()
      {
        $this->authCheck();
        
        $page=view('admin.coupon_add');

        return view('admin.master')
        ->with('main_content',$page);
      }

      public function saveCoupon(Request $request)
      {
        //$this->authCheck();
        $data=array();     


        $data['title']=$request->title;
        $data['code']=$request->code;
        $data['discount_amount']=$request->discount_amount;            
        $data['start_from']=$request->start_from;            
        $data['end_to']=$request->end_to;            
        $data['active']=$request->active;


        DB::table('coupon')->insert($data);

        Session::put('message', 'Coupon added successfully!');
        return Redirect::to('/coupons');
      }

      public function editCoupon($id)
      {
        /*$postData = DB::table('news_posts')
        ->where('id',$cat_id)
        ->first();*/

        $fetchData = DB::table('coupon')
        ->where('coupon.id',$id)
        ->first();   

        $data=view('admin.coupon_edit')
        ->with('data',$fetchData);

        return view('admin.master')
        ->with('main_content',$data);

        return Redirect::to('/coupons');
      }

      public function updateCoupon(Request $request)
      {
        //$this->authCheck();
        $data=array();
       
        $id=$request->id;
        $data['title']=$request->title;
        $data['code']=$request->code;
        $data['discount_amount']=$request->discount_amount;            
        $data['start_from']=$request->start_from;            
        $data['end_to']=$request->end_to;            
        $data['active']=$request->active;

      DB::table('coupon')
      ->where('id',$id)
      ->update($data);

      Session::put('message', 'Coupon updated successfully!');
      return Redirect::to('/coupons');
    }

    public function deleteCoupon($id)
    {
      DB::table('coupon')
      ->where('id',$id)
      ->delete();

      Session::put('message', 'coupon deleted successfully!');
      return Redirect::to('/coupons');
    }


       /*============================
       News Category
       ============================*/
       public function newsPosts()
       {
        $this->authCheck();


        $postData = DB::table('news_posts')
        ->join('news_categories', 'news_posts.news_category_id', '=', 'news_categories.id')
        ->select('news_posts.*', 'news_categories.name as catName')
        ->get();

        /*$postData = DB::table('news_posts')
        ->get();*/
        
        $newsPosts=view('admin.news_post_list')
        ->with('postData',$postData);

        return view('admin.master')
        ->with('main_content',$newsPosts);
      } 

      public function addNewsPost()
      {
        $this->authCheck();
        
        $addCategory=view('admin.news_post_add');

        return view('admin.master')
        ->with('main_content',$addCategory);
      }

      public function saveNewsPost(Request $request)
      {
        //$this->authCheck();
        $data=array();

        $file = $request->file('image');
        $filename = $file->getClientOriginalName();
        $picture = date('His').$filename;      
        $path = 'images/post/';
        $destination_path = base_path(). '/images/post';
        $success = $file->move($destination_path, $picture);


        $data['title']=$request->name;
        $data['news_category_id']=$request->category_id;
        $data['image_path']=$path."".$picture;
        $data['description']=$request->editor1;            
        $data['active']=$request->active;
        $data['created_by']=Session::get('user_id');
        $data['updated_by']='';


        DB::table('news_posts')->insert($data);

        Session::put('message', 'Post saved successfully!');
        return Redirect::to('/news');
      }

      public function editNewsPost($cat_id)
      {
        /*$postData = DB::table('news_posts')
        ->where('id',$cat_id)
        ->first();*/

        $postData = DB::table('news_posts')
        ->join('news_categories', 'news_posts.news_category_id', '=', 'news_categories.id')
        ->select('news_posts.*', 'news_categories.name as catName', 'news_categories.id as catID')
        /*->get();*/
        ->where('news_posts.id',$cat_id)
        ->first();




        $editPost=view('admin.news_post_edit')
        ->with('postData',$postData);

        return view('admin.master')
        ->with('main_content',$editPost);

        return Redirect::to('/news');
      }

      public function updateNewsPost(Request $request)
      {
        //$this->authCheck();
        $data=array();

        $file = $request->file('image');
        if($file == null){  
         $old_image =  $request->hidden_image;        
       }
       else{
        $file = $request->file('image');
        $filename = $file->getClientOriginalName();
        $picture = date('His').$filename;      
        $path = 'images/post/';
        $destination_path = base_path(). '/images/post';
        $success = $file->move($destination_path, $picture); 
        $old_image = $path."".$picture;

      } 

      $id=$request->id;
      $data['title']=$request->name;
      $data['news_category_id']=$request->category_id;
      $data['image_path']=$old_image;
      $data['description']=$request->editor1;            
      $data['active']=$request->active;        
      $data['updated_by']=Session::get('user_id');



      DB::table('news_posts')
      ->where('id',$id)
      ->update($data);

      Session::put('message', 'Post updated successfully!');
      return Redirect::to('/news');
    }

    public function deleteNewsPost($cat_id)
    {
      DB::table('news_posts')
      ->where('id',$cat_id)
      ->delete();

      Session::put('message', 'Post deleted successfully!');
      return Redirect::to('/news');
    }

    /*============================
       End News Post
       ============================*/




           /*============================
       Start Image Slider
       ============================*/
       public function sliders()
       {
        $this->authCheck();

        $sliderData = DB::table('image_sliders')
        ->get();
        
        $sliders=view('admin.slider_list')
        ->with('sliderData',$sliderData);

        return view('admin.master')
        ->with('main_content',$sliders);
      } 

      public function addSlider()
      {
        $this->authCheck();
        
        $addSlider=view('admin.slider_add');

        return view('admin.master')
        ->with('main_content',$addSlider);
      }

      public function saveSlider(Request $request)
      {
        //$this->authCheck();
        $data=array();

        if (!empty($request->image_type)) {

          if($request->image_type =='logo'){  
            $image_type = 'logo';          
            $data['image_type'] = $image_type;

            if (!empty($request->file('imageLogo'))) {
             $file = $request->file('imageLogo');
             $filename = $file->getClientOriginalName();
             $picture = date('His').$filename;      
             $path = 'images/slider/';
             $destination_path = base_path(). '/images/slider';
             $success = $file->move($destination_path, $picture);
           }

         } 
         else if($request->image_type =='slider') {
           $image_type = 'slider'; 
           $data['image_type'] = $image_type;

           if (!empty($request->file('imageSlider'))) {

             $file = $request->file('imageSlider');
             $filename = $file->getClientOriginalName();
             $picture = date('His').$filename;      
             $path = 'images/slider/';
             $destination_path = base_path(). '/images/slider';
             $success = $file->move($destination_path, $picture);
           }

         } 
         else if($request->image_type =='gallery') {
           $image_type = 'gallery'; 
           $data['image_type'] = $image_type;

           if (!empty($request->file('imageGallery'))) {

             $file = $request->file('imageGallery');
             $filename = $file->getClientOriginalName();
             $picture = date('His').$filename;      
             $path = 'images/slider/';
             $destination_path = base_path(). '/images/slider';
             $success = $file->move($destination_path, $picture);
           }

           //$data['image_type'] = 'gallery';
         }            
       } 

       $data['image_type'] = $image_type;
       $data['title']=$request->title;
       $data['sub_title']=$request->sub_title;
       $data['image_path']=$path."".$picture;
       $data['description']=$request->description;
       $data['link_text_1']=$request->link_text_1;
       $data['link_1']=$request->link_1;
       $data['link_text_2']=$request->link_text_2;
       $data['link_2']=$request->link_2;     
       $data['active']=$request->active;
       $data['created_by']=Session::get('user_id');
       $data['updated_by']='';


       //print_r($data);

       DB::table('image_sliders')->insert($data);

       Session::put('message', 'Image Slider saved successfully!');
       return Redirect::to('/sliders');
     }

     public function editSlider($cat_id)
     {
      $sliderData = DB::table('image_sliders')
      ->where('id',$cat_id)
      ->first();

      $editSlider=view('admin.slider_edit')
      ->with('sliderData',$sliderData);

      return view('admin.master')
      ->with('main_content',$editSlider);

      return Redirect::to('/sliders');
    }

    public function updateSlider(Request $request)
    {
        //$this->authCheck();
      $data=array();

      $file = $request->file('image');
      if($file == null){  
       $image =  $request->hidden_image;        
     }
     else{
      $file = $request->file('image');
      $filename = $file->getClientOriginalName();
      $picture = date('His').$filename;      
      $path = 'images/slider/';
      $destination_path = base_path(). '/images/slider';
      $success = $file->move($destination_path, $picture); 
      $image = $path."".$picture;
    } 
    $data['image_path']=$image;

    $id=$request->id;

    $data['title']=$request->title;
    $data['sub_title']=$request->sub_title;
    $data['description']=$request->description;
    $data['link_text_1']=$request->link_text_1;
    $data['link_1']=$request->link_1;
    $data['link_text_2']=$request->link_text_2;
    $data['link_2']=$request->link_2;     
    $data['active']=$request->active;
    $data['updated_by']=Session::get('user_id');

    /*print_r($data);*/

    DB::table('image_sliders')
    ->where('id',$id)
    ->update($data);

    Session::put('message', 'Image Slider updated successfully!');
    return Redirect::to('/sliders');
  }

  public function deleteSlider($cat_id)
  {
    DB::table('image_sliders')
    ->where('id',$cat_id)
    ->delete();

    Session::put('message', 'Image Slider deleted successfully!');
    return Redirect::to('/sliders');
  }

    /*============================
       End Image Slider
       ============================*/

       /*============================
       Department
       ============================*/
       public function departments()
       {
        $this->authCheck();

        $departmentData = DB::table('departments')
        ->get();
        
        $departments=view('admin.department_list')
        ->with('departmentData',$departmentData);

        return view('admin.master')
        ->with('main_content',$departments);
      } 

      public function addDepartment()
      {
        $this->authCheck();
        
        $addDepartment=view('admin.department_add');

        return view('admin.master')
        ->with('main_content',$addDepartment);
      }

      public function saveDepartment(Request $request)
      {
        //$this->authCheck();
        $data=array();

        $data['name']=$request->name;
        $data['description']=$request->description;
        $data['active']=$request->active;
        $data['created_by']=Session::get('user_id');
        $data['updated_by']='';
        

        DB::table('departments')->insert($data);

        Session::put('message', 'Department saved successfully!');
        return Redirect::to('/departments');
      }

      public function editDepartment($cat_id)
      {
        $departmentData = DB::table('departments')
        ->where('id',$cat_id)
        ->first();

        $editDepartment=view('admin.department_edit')
        ->with('departmentData',$departmentData);

        return view('admin.master')
        ->with('main_content',$editDepartment);

        return Redirect::to('/departments');
      }

      public function updateDepartment(Request $request)
      {
        //$this->authCheck();
        $data=array();

        $id=$request->id;
        $data['name']=$request->name;
        $data['description']=$request->description;
        $data['active']=$request->active;

        DB::table('departments')
        ->where('id',$id)
        ->update($data);

        Session::put('message', 'Department updated successfully!');
        return Redirect::to('/departments');
      }

      public function deleteDepartment($cat_id)
      {
        DB::table('departments')
        ->where('id',$cat_id)
        ->delete();

        Session::put('message', 'Department deleted successfully!');
        return Redirect::to('/departments');
      }

    /*============================
       End Department
       ============================*/

       /*============================
       specialist
       ============================*/
       public function specialists()
       {
        $this->authCheck();

        /*$specialistData = DB::table('specialists')
        ->get();*/

        $specialistData = DB::table('specialists')
        ->join('departments', 'specialists.department_id', '=', 'departments.id')
        ->select('specialists.*', 'departments.name as deptName')
        ->get();
        
        $specialists=view('admin.specialist_list')
        ->with('specialistData',$specialistData);

        return view('admin.master')
        ->with('main_content',$specialists);
      } 

      public function addSpecialist()
      {
        $this->authCheck();
        
        $addspecialist=view('admin.specialist_add');

        return view('admin.master')
        ->with('main_content',$addspecialist);
      }

      public function saveSpecialist(Request $request)
      {
        //$this->authCheck();
        $data=array();

        /*$file = $request->file('image');
        $filename = $file->getClientOriginalName();
        $picture = date('His').$filename;      
        $path = 'images/test/';
        $destination_path = base_path(). '/images/test';
        $success = $file->move($destination_path, $picture);*/

        if (!empty($request->file('image'))) {

         $file = $request->file('image');
         $filename = $file->getClientOriginalName();
         $picture = date('His').$filename;      
         $path = 'images/slider/';
         $destination_path = base_path(). '/images/slider';
         $success = $file->move($destination_path, $picture);
       }



       $data['firstname']=$request->firstname;
       $data['lastname']=$request->lastname;
       $data['email']=$request->email;
       $data['department_id']=$request->department_id;
       $data['designation']=$request->designation;
       $data['gender']=$request->gender;
       $data['phone_no']=$request->phone_no;
       $data['date_of_birth']=$request->date_of_birth;
       $data['address']=$request->address;
       $data['education']=$request->education;
       $data['experise_area']=$request->experise_area;
       $data['image']=$path."".$picture;
       $data['active']=$request->active;
       $data['created_by']=Session::get('user_id');
       $data['updated_by']='';

        /*print_r($data);
        exit();*/

        
        

        DB::table('specialists')->insert($data);

        Session::put('message', 'Specialist saved successfully!');
        return Redirect::to('/specialists');
      }

      public function editSpecialist($cat_id)
      {
        /*$specialistData = DB::table('specialists')
        ->where('id',$cat_id)
        ->first();*/

        $specialistData = DB::table('specialists')
        ->join('departments', 'specialists.department_id', '=', 'departments.id')
        ->select('specialists.*', 'departments.name as deptName', 'departments.id as catID')
        /*->get();*/
        ->where('specialists.id',$cat_id)
        ->first();

        $editSpecialist=view('admin.specialist_edit')
        ->with('specialistData',$specialistData);

        return view('admin.master')
        ->with('main_content',$editSpecialist);

        return Redirect::to('/specialists');
      }

      public function updateSpecialist(Request $request)
      {
        //$this->authCheck();
        $data=array();

        

        $file = $request->file('image');
        if($file == null){  
         $old_image =  $request->hidden_image;  
       }
       else{
        $file = $request->file('image');
        $filename = $file->getClientOriginalName();
        $picture = date('His').$filename;      
        $path = 'images/slider/';
        $destination_path = base_path(). '/images/slider';
        $success = $file->move($destination_path, $picture); 
        $old_image = $path."".$picture;           
      }


      $id=$request->id;
      $data['firstname']=$request->firstname;
      $data['lastname']=$request->lastname;
      $data['email']=$request->email;
      $data['department_id']=$request->department_id;
      $data['designation']=$request->designation;
      $data['gender']=$request->gender;
      $data['phone_no']=$request->phone_no;
      $data['date_of_birth']=$request->date_of_birth;
      $data['address']=$request->address;
      $data['education']=$request->education;
      $data['experise_area']=$request->experise_area;
      $data['image'] = $old_image;
      $data['active']=$request->active;
      $data['updated_by']=Session::get('user_id');

      /*print_r($data);
      exit();*/
      



      DB::table('specialists')
      ->where('id',$id)
      ->update($data);

      Session::put('message', 'Specialist updated successfully!');
      return Redirect::to('/specialists');
    }

    public function deleteSpecialist($cat_id)
    {
      DB::table('specialists')
      ->where('id',$cat_id)
      ->delete();

      Session::put('message', 'Specialist deleted successfully!');
      return Redirect::to('/specialists');
    }

    /*============================
       End specialist
       ============================*/



      /*============================
       Start Web Messages
       ============================*/
       public function webMessages()
       {
        $this->authCheck();

        /*$messagesData = DB::table('web_messages')
        ->get();*/

        $messagesData = DB::table('web_messages')
          ->whereNull('is_deleted')
          ->orderBy('id', 'desc')
          ->get();
        
        $messages=view('admin.web_messages')
        ->with('messagesData',$messagesData);

        return view('admin.master')
        ->with('main_content',$messages);
      } 

      public function deleteWebMessage($cat_id)
      {           
        $data['is_deleted']='Deleted';
        $data['updated_by']=Session::get('user_id');

        /*print_r($data);*/

        DB::table('web_messages')
        ->where('id',$cat_id)
        ->update($data);

        Session::put('message', 'Mesages deleted successfully!');
        return Redirect::to('/web-messages');
      }

    /*============================
       End Web Mesages
       ============================*/

             /*============================
       Start Web Messages
       ============================*/
       public function reviews()
       {
        $this->authCheck();

        /*$messagesData = DB::table('web_messages')
        ->get();*/

        $reviewsData = DB::table('reviews')->where('is_deleted', '=', 'No')->get();
        /*whereNull('is_deleted')->get();*/
        
        $reviews=view('admin.reviews')
        ->with('reviewsData',$reviewsData);

        return view('admin.master')
        ->with('main_content',$reviews);
      } 

      public function addReview()
      {
        $this->authCheck();
        
        $addReview=view('admin.review_add');

        return view('admin.master')
        ->with('main_content',$addReview);
      }

      public function saveReview(Request $request)
      {
        //$this->authCheck();
        $data=array();

        $file = $request->file('image');
        $filename = $file->getClientOriginalName();
        $picture = date('His').$filename;      
        $path = 'images/test/';
        $destination_path = base_path(). '/images/test';
        $success = $file->move($destination_path, $picture);

        $data['name']=$request->name;
        $data['image']=$path."".$picture;
        $data['rating']=$request->rating;
        $data['review']=$request->review;
        $data['is_web_show']=$request->active;
        $data['is_deleted']='No';
        $data['created_by']=Session::get('user_id');
        $data['updated_by']='';
        

        DB::table('reviews')->insert($data);

        Session::put('message', 'Review saved successfully!');
        return Redirect::to('/reviews');
      }

      public function editReview($cat_id)
      {
        $reviewData = DB::table('reviews')
        ->where('id',$cat_id)
        ->first();

        $editReview=view('admin.review_edit')
        ->with('reviewData',$reviewData);

        return view('admin.master')
        ->with('main_content',$editReview);

        return Redirect::to('/reviews');
      }

      public function updateReview(Request $request)
      {
        //$this->authCheck();
        $data=array();

        $file = $request->file('image');
        if($file == null){  
         $old_image =  $request->hidden_image;  
       }
       else{
        $file = $request->file('image');
        $filename = $file->getClientOriginalName();
        $picture = date('His').$filename;      
        $path = 'images/test/';
        $destination_path = base_path(). '/images/test';
        $success = $file->move($destination_path, $picture); 
        $old_image = $path."".$picture;           
      }
      $id=$request->id;
      

      $data['name']=$request->name;
      $data['image'] = $old_image;
      $data['rating']=$request->rating;
      $data['review']=$request->review;
      $data['is_web_show']=$request->active;
      $data['updated_by']=Session::get('user_id');

      DB::table('reviews')
      ->where('id',$id)
      ->update($data);

      Session::put('message', 'Review updated successfully!');
      return Redirect::to('/reviews');
    }

    

    public function webShowReview(Request $request)
    {
        //$this->authCheck();
      $data=array();

      $id=$request->id;
      
      $data['is_web_show']=$request->active;
      $data['updated_by']=Session::get('user_id');

      DB::table('reviews')
      ->where('id',$id)
      ->update($data);

      Session::put('message', 'Review updated successfully!');
      return Redirect::to('/reviews');
    }

    public function deleteReview($cat_id)
    {

      $data=array();

      /*$id=$request->id;*/
      
      $data['is_deleted']='Yes';
      $data['updated_by']=Session::get('user_id');

      DB::table('reviews')
      ->where('id',$cat_id)
      ->update($data);

      Session::put('message', 'Review Deleted successfully!');
      return Redirect::to('/reviews');


        /*DB::table('reviews')
        ->where('id',$cat_id)
        ->delete();

        Session::put('message', 'Review deleted successfully!');
        return Redirect::to('/reviews');*/
      }

      


    /*============================
       End Review
       ============================*/

       /*============================
       Faq
       ============================*/
       public function faqs()
       {
        $this->authCheck();

        $faqData = DB::table('master')
        ->get();
        
        $faqs=view('admin.faqs')
        ->with('faqData',$faqData);

        return view('admin.master')
        ->with('main_content',$faqs);
      } 


      public function addFaq()
      {
        $this->authCheck();
        
        $addFaq=view('admin.faq_add');

        return view('admin.master')
        ->with('main_content',$addFaq);
      }

      public function saveFaq(Request $request)
      {
        //$this->authCheck();
        $data=array();

        $data['type']=$request->type;
        $data['question']=$request->question;
        $data['answer'] = $request->editor1;
        $data['active']=$request->active;
        $data['created_by']=Session::get('user_id');
        $data['updated_by']='';        

        DB::table('faqs')->insert($data);

        Session::put('message', 'Faq saved successfully!');
        return Redirect::to('/post-code');
      }

      public function editFaq($cat_id)
      {
        $faqData = DB::table('master')
        ->where('id',$cat_id)
        ->first();

        $editFaq=view('admin.faq_edit')
        ->with('data',$faqData);

        // $post_code = $faqData->post_code;

        // $editFaq=view('admin.faq_edit')
        // ->with('data', ['post_code' => $post_code, 'product_type' => $faqData]); 

        return view('admin.master')
        ->with('main_content',$editFaq);

        return Redirect::to('/post-code');
      }

      public function updateFaq(Request $request)
      {
        //$this->authCheck();
       $data=array();
       $id=$request->id;

       $data['comission_fee']=$request->comission_fee;
       $data['q24']=$request->q24;
       $data['a24']=$request->a24;
       $data['b24']=$request->b24;
       $data['c24']=$request->c24;

       $data['q48']=$request->q48;
       $data['a48']=$request->a48;
       $data['b48']=$request->b48;
       $data['c48']=$request->c48;
       $data['c148']=$request->c148;
       $data['c248']=$request->c248;
       $data['c348']=$request->c348;


       $data['q72']=$request->q72;
       $data['a72']=$request->a72;
       $data['b72']=$request->b72;
       $data['c72']=$request->c72;
       $data['c172']=$request->c172;
       $data['c272']=$request->c272;
       $data['c372']=$request->c372;

       DB::table('master')
       ->where('id',$id)
       ->update($data);

       Session::put('message', 'Faq updated successfully!');
       return Redirect::to('/post-code');
     }

     public function deleteFaq($cat_id)
     {
      DB::table('faqs')
      ->where('id',$cat_id)
      ->delete();

      Session::put('message', 'Faq deleted successfully!');
      return Redirect::to('/post-code');
    }

    /*============================
       End Faq
       ============================*/

    /*============================
       International Post Codes
      ============================*/

      public function internationalPostCodes()
      {
       $this->authCheck();

       $fetchData = DB::table('international_data')
       ->get();
       
       $data=view('admin.international-post-code')
       ->with('data',$fetchData);

       return view('admin.master')
       ->with('main_content',$data);
     } 

     public function editInternationalPostCode($id)
     {
       $fetchData = DB::table('international_data')
       ->where('id',$id)
       ->first();

       $data=view('admin.edit-international-post-code')
       ->with('data',$fetchData);

       return view('admin.master')
       ->with('main_content',$data);

       return Redirect::to('/post-code');
     }

     public function updateInternationalPostCode(Request $request)
     {
       //$this->authCheck();
      $data=array();
      $id=$request->id;

      $data['q1']=$request->q1;
      $data['a1']=$request->a1;
      $data['b1']=$request->b1;

      $data['q2']=$request->q2;
      $data['a2']=$request->a2;
      $data['b2']=$request->b2;
      
      $data['qn']=$request->qn;
      $data['an']=$request->an;
      $data['bn']=$request->bn;

      DB::table('international_data')
      ->where('id',$id)
      ->update($data);

      Session::put('message', 'Data updated successfully!');
      return Redirect::to('/international-post-code');
     }

    public function deleteInternationalPostCode($id)
    {
     DB::table('international_data')
     ->where('id',$id)
     ->delete();

     Session::put('message', 'Data deleted successfully!');
     return Redirect::to('/international-post-code');
    }


      /*============================
       Orders
       ============================*/
       public function orders()
       {
        $this->authCheck();       

        $orderData = DB::table('orders')
        ->join('pick_drop', 'orders.id', '=', 'pick_drop.order_id')       
        ->select('orders.*', 'pick_drop.c_zip as c_zip' , 'pick_drop.c_address as c_address' ,'pick_drop.c_state as c_state' ,'pick_drop.c_city as c_city' ,'pick_drop.c_country as c_country', 'pick_drop.d_zip as d_zip' , 'pick_drop.d_address as d_address' ,'pick_drop.d_state as d_state' ,'pick_drop.d_city as d_city' ,'pick_drop.d_country as d_country','pick_drop.collection_date as collection_date','pick_drop.delivery_date as delivery_date')
        ->where('active', 'on')
        ->orderBy('id', 'desc')
        ->get();
        
        
        $orders=view('admin.orders')
        ->with('orderData',$orderData);

        return view('admin.master')
        ->with('main_content',$orders);
      } 

      
      public function editOrder($cat_id)
      {
        $orderData = DB::table('orders')
        ->where('id',$cat_id)
        ->first();

        $edit_order=view('admin.edit_order')
        ->with('orderData',$orderData);

        return view('admin.master')
        ->with('main_content',$edit_order);

        return Redirect::to('/orders');
      }

      public function updateOrderStatus(Request $request)
      {
        //$this->authCheck();
        $data=array();

        $id=$request->id;
        $data['status']=$request->status;        
        /*$data['updated_by']=Session::get('user_id');*/

        DB::table('orders')
        ->where('id',$id)
        ->update($data);

        $data = array(
          'name'      =>  $request->name

        );

        //$email= $request->email;
        //Mail::to($email)->send(new SendMail($data));

        Session::put('message', 'Order updated successfully!');
        return Redirect::to('/orders');
      }

          /*============================
       End Orders
       ============================*/



      /*============================
       Post
       ============================*/
       public function posts()
       {
        $this->authCheck();

        $postData = DB::table('posts')
        ->get();
        // $category_name = DB::table('categories')
        //         ->where('id',$postData['category']);
        
        $posts=view('admin.posts')
        ->with('postData',$postData);

        return view('admin.master')
        ->with('main_content',$posts);
      } 

      public function addPost()
      {
        $this->authCheck();
        
        $add_zip=view('admin.add_zip');

        return view('admin.master')
        ->with('main_content',$add_zip);
      }

      public function savePost(Request $request)
      {
        $this->authCheck();
        $data=array();

       // echo $user_id; exit()

        $data['title']=$request->title;
        $data['description']=$request->description;
        $data['category']=$request->category;
        $data['created_by']=Session::get('user_id');
        $data['active']=$request->active;

        DB::table('posts')->insert($data);

        Session::put('message', 'Post saved successfully!');
        return Redirect::to('/posts');
      }

      public function editPost($cat_id)
      {
        $postData = DB::table('posts')
        ->where('id',$cat_id)
        ->first();

        $edit_post=view('admin.edit_post')
        ->with('PostData',$postData);

        return view('admin.master')
        ->with('main_content',$edit_post);

        return Redirect::to('/posts');
      }

      public function updatePost(Request $request)
      {
        //$this->authCheck();
        $data=array();

        $id=$request->id;
        $data['name']=$request->name;
        $data['description']=$request->description;
        $data['active']=$request->active;

        DB::table('posts')
        ->where('id',$id)
        ->update($data);

        Session::put('message', 'Post updated successfully!');
        return Redirect::to('/posts');
      }

      public function deletePost($cat_id)
      {
        DB::table('posts')
        ->where('id',$cat_id)
        ->delete();

        Session::put('message', 'Post deleted successfully!');
        return Redirect::to('/posts');
      }

    /*============================
       End Post
       ============================*/









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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
  }
