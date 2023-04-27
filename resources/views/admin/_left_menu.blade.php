<ul class="nav has-active-border active-on-right">


    <li class="nav-item-caption">
      {{-- <span class="fadeable pl-3">MAIN</span> --}}
      <span class="fadeinable mt-n2 text-125">&hellip;</span>
      <!--
               OR something like the following (with `.hideable` text)
           -->
      <!--
               <div class="hideable">
                   <span class="pl-3">MAIN</span>
               </div>
               <span class="fadeinable mt-n2 text-125">&hellip;</span>
           -->
    </li>

 
    <li class="nav-item active">
      <a href="/admin" class="nav-link">
        <i class="nav-icon fa fa-home"></i>
        <span class="nav-text fadeable"> 
         <span style="color: #000; font-weight:600">Dashboard</span>
        </span>
      </a> 
      <b class="sub-arrow"></b>
    </li>    
    <li class="nav-item">
    <a class="nav-link dropdown-toggle collapsed">
      <i class="nav-icon fas fa-sort-amount-up-alt"></i>
      <span class="nav-text fadeable">
        <span>Sales</span>
      </span>
      <b class="caret fa fa-angle-left rt-n90"></b>
    </a>

    <div class="hideable submenu collapse">
      <ul class="submenu-inner">

        <li class="nav-item">
          <a href="add-invoice" class="nav-link">
              <span class="nav-text">
              <span style="color: #000">Create Invoice</span>
              </span>
          </a>
        </li>
        @if ($settings->wholesale == 'yes')
          <li class="nav-item">
            <a href="wholesale-invoice" class="nav-link">
                <span class="nav-text">
                <span style="color: #000">Wholesale Invoice</span>
                </span>
            </a>
          </li>
        @endif
        <li class="nav-item">
          <a href="due-invoices" class="nav-link">
              <span class="nav-text">
              <span style="color: #000">Due Invoices</span>
              </span>
          </a>
        </li>  

        <li class="nav-item">
          <a href="invoices" class="nav-link">
              <span class="nav-text">
              <span style="color: #000">All Invoices</span>
              </span>
          </a>
        </li>  
        @if (session('client_id') == '18')
          <li class="nav-item">
            <a href="returns" class="nav-link">
                <span class="nav-text">
                <span style="color: #000">Return Invoices</span>
                </span>
            </a>
          </li>  
        @endif
                           
      </ul>
    </div>
    <b class="sub-arrow"></b>
  </li>


  @if (session('bt') == 'e')
  <li class="nav-item">
    <a class="nav-link dropdown-toggle collapsed">
      <i class="nav-icon fa fa-user"></i>
      <span class="nav-text fadeable">
       <span>Duty</span>
      </span>
      <b class="caret fa fa-angle-left rt-n90"></b>
    </a>

    <div class="hideable submenu collapse">
      <ul class="submenu-inner">

        <li class="nav-item">
          <a href="add-duty" class="nav-link">
              <span class="nav-text">
              <span style="color: #000">Add Duty</span>
              </span>
          </a>
        </li> 
        <li class="nav-item">
          <a href="duties" class="nav-link">
              <span class="nav-text">
              <span style="color: #000">All Duties</span>
              </span>
          </a>
        </li>                     
      </ul>
    </div>
    <b class="sub-arrow"></b>
  </li>
  @endif


    <li class="nav-item">
      <a href="expenses" class="nav-link">
        <i class="nav-icon far fa-window-restore"></i>
        <span class="nav-text fadeable">
         <span>Expenses</span>
        </span>
      </a>
      <b class="sub-arrow"></b>
    </li>

   
    
    

    <li class="nav-item">
      <a class="nav-link dropdown-toggle collapsed">
        <i class="nav-icon fa fa-user"></i>
        <span class="nav-text fadeable">
         <span>Customers</span>
        </span>
        <b class="caret fa fa-angle-left rt-n90"></b>
      </a>

      <div class="hideable submenu collapse">
        <ul class="submenu-inner">

          <li class="nav-item">
            <a href="add-customer" class="nav-link">
                <span class="nav-text">
                <span style="color: #000">Add Customer</span>
                </span>
            </a>
          </li> 
          <li class="nav-item">
            <a href="customers" class="nav-link">
                <span class="nav-text">
                <span style="color: #000">All Customers</span>
                </span>
            </a>
          </li>                     
        </ul>
      </div>
      <b class="sub-arrow"></b>
    </li>
               
   



    @if (session('user.user_type') == 'Admin')   
      @if($settings->product_type != 'Service')                
      <li class="nav-item">
        <a href="purchases" class="nav-link">
          <i class="nav-icon fas fa-sort-amount-up-alt"></i>
          <span class="nav-text fadeable">
          <span>Purchases</span>
          </span>
        </a>
        <b class="sub-arrow"></b>
      </li>
      @endif

      @if (session('bt') =='p')                
      <li class="nav-item">
        <a href="productions" class="nav-link">
          <i class="nav-icon fas fa-sort-amount-up-alt"></i>
          <span class="nav-text fadeable">
          <span>Productions</span>
          </span>
        </a>
        <b class="sub-arrow"></b>
      </li>
      @endif


    
 
    
    <li class="d-none nav-item">
      <a class="nav-link" href="report-center">
        <i class="nav-icon far fa-calendar-alt"></i>
        <span class="nav-text fadeable">
         <span>Report Center</span>
        </span>                   
      </a>
    </li>

  

    <li class="nav-item">

      <a class="nav-link dropdown-toggle collapsed">
        <i class="nav-icon fa fa-list"></i>
        <span class="nav-text fadeable">
         <span>{{$settings->product_type}}s</span>
        </span>
        <b class="caret fa fa-angle-left rt-n90"></b>
      </a>

      <div class="hideable submenu collapse">
        <ul class="submenu-inner">

         
         @if ($settings->product_type == 'Product')
          <li class="nav-item">
            <a href="add-product" class="nav-link">
                <span class="nav-text">
                <span style="color: #000">Add Product</span>
                </span>
            </a>
          </li>
         @elseif($settings->product_type == 'Service')
         <li class="nav-item">
            <a href="add-service" class="nav-link">
                <span class="nav-text">
                <span style="color: #000">Add Service</span>
                </span>
            </a>
          </li>
        @else
        <li class="nav-item">
          <a href="add-product" class="nav-link">
              <span class="nav-text">
              <span style="color: #000">Add Product</span>
              </span>
          </a>
        </li>

         
        <li class="nav-item">
          <a href="products" class="nav-link">
              <span class="nav-text">
              <span style="color: #000">All Products</span>
              </span>
          </a>
        </li>

        

        <li class="nav-item">
          <a href="add-service" class="nav-link">
              <span class="nav-text">
              <span style="color: #000">
                  @if (session('bt') == 'e')
                    Add Equipement
                  @else 
                    Add Service 
                  @endif 
              </span>
              </span>
          </a>
        </li>

    

        @endif
       
        
          

        @if (session('bt') == 'e')
          <li class="nav-item">
            <a href="services" class="nav-link">
                <span class="nav-text">
                <span style="color: #000">All Equipements</span>
                </span>
            </a>
          </li>
        @else 
        <li class="nav-item">
          <a href="products" class="nav-link">
              <span class="nav-text">
              <span style="color: #000">All {{$settings->product_type}}s</span>
              </span>
          </a>
        </li>
        @endif 


          <li class="nav-item">
                <a href="product-categories" class="nav-link">
                  <span class="nav-text">
                <span style="color: #000">Categories</span>
                  </span>
                </a>
            </li>                     
        </ul>
      </div>
      <b class="sub-arrow"></b>
    </li>

      @if($settings->product_type != 'Service')   
        <li class="nav-item">
          <a href="store-details/{{session('client_id')}}" class="nav-link">
            <i class="nav-icon fas fa-sort-amount-up-alt"></i>
            <span class="nav-text fadeable">
            <span>Stock Management</span>
            </span>
          </a>
          <b class="sub-arrow"></b>
        </li>
        <li class="nav-item">
          <a href="companies" class="nav-link">
            <i class="nav-icon fas fa-sort-amount-up-alt"></i>
            <span class="nav-text fadeable">
            <span>Company/Brand</span>
            </span>
          </a>
          <b class="sub-arrow"></b>
        </li>
      @endif
  
 
     

    <li class="nav-item">
      <a href="/coupons" class="nav-link">
        <i class="nav-icon fa fa-file"></i>
        <span class="nav-text fadeable">
         <span>Discount coupons</span>
        </span>
      </a>
      <b class="sub-arrow"></b>
    </li>

    <li class="nav-item">
      <a href="/data-lookup" class="nav-link">
        <i class="nav-icon fa fa-folder"></i>
        <span class="nav-text fadeable">
         <span>Data Lookup</span>
        </span>
      </a>
      <b class="sub-arrow"></b>
    </li>

    <li class="d-none nav-item">
      <a href="/pages" class="nav-link">
        <i class="nav-icon fa fa-file"></i>
        <span class="nav-text fadeable">
         <span>Pages & Sliders</span>
        </span>
      </a>
      <b class="sub-arrow"></b>
    </li>

  
    
    <li class="nav-item">
      <a href="/users" class="nav-link">
        <i class="nav-icon fa fa-user"></i>
        <span class="nav-text fadeable">
         <span>Users</span>
        </span>
      </a>
      <b class="sub-arrow"></b>
    </li>

    <li class="nav-item">
      <a href="/settings" class="nav-link">
        <i class="nav-icon fa fa-cog"></i>
        <span class="nav-text fadeable">
         <span style="font-weight: 600">Settings</span>
        </span>
      </a>
      <b class="sub-arrow"></b>
    </li>

    @endif

  
   
   





    {{--
      <li class="nav-item-caption">
      <span class="fadeable pl-3">OTHER</span>
      <span class="fadeinable mt-n2 text-125">&hellip;</span>
     
    </li>


    <li class="nav-item">

      <a href="#" class="nav-link dropdown-toggle collapsed">
        <i class="nav-icon fa fa-tag"></i>
        <span class="nav-text fadeable">
         <span>More Pages</span>
        <span class="badge badge-primary py-1 radius-round text-90 mr-2px badge-sm ">5</span>
        </span>

        <b class="caret fa fa-angle-left rt-n90"></b>

        <!-- or you can use custom icons. first add `d-style` to 'A' -->
        <!--
            <b class="caret d-n-collapsed fa fa-minus text-80"></b>
            <b class="caret d-collapsed fa fa-plus text-80"></b>
        -->
      </a>

      <div class="hideable submenu collapse">
        <ul class="submenu-inner">

          <li class="nav-item">

            <a href="/profile" class="nav-link">

              <span class="nav-text">
                     <span>Profile</span>
              </span>


            </a>


          </li>


          <li class="nav-item">

            <a href="html/page-login.html" class="nav-link">

              <span class="nav-text">
                     <span>Login</span>
              </span>


            </a>


          </li>


          <li class="nav-item">

            <a href="html/page-pricing.html" class="nav-link">

              <span class="nav-text">
                     <span>Pricing</span>
              </span>


            </a>


          </li>


          <li class="nav-item">

            <a href="html/page-invoice.html" class="nav-link">

              <span class="nav-text">
                     <span>Invoice</span>
              </span>


            </a>


          </li>


          <li class="nav-item">

            <a href="html/page-inbox.html" class="nav-link">

              <span class="nav-text">
                     <span>Inbox</span>
              </span>


            </a>


          </li>


          <li class="nav-item">

            <a href="html/page-search.html" class="nav-link">

              <span class="nav-text">
                     <span>Search Results</span>
              </span>


            </a>


          </li>


          <li class="nav-item">

            <a href="html/page-error.html" class="nav-link">

              <span class="nav-text">
                     <span>Error</span>
              </span>


            </a>


          </li>


          <li class="nav-item">

            <a href="html/starter.html" class="nav-link">

              <span class="nav-text">
                     <span>Starter</span>
              </span>


            </a>


          </li>

        </ul>
      </div>

      <b class="sub-arrow"></b>

    </li> --}}

  </ul>