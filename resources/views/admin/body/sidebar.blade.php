@php 
   $prefix = Request::route()->getPrefix();
   $route = Route::current()->getName();
@endphp

<aside class="main-sidebar">
    <!-- sidebar-->
    <section class="sidebar">	
		
        <div class="user-profile">
			<div class="ulogo">
				 <a href="index.html">
				  <!-- logo for regular state and mobile devices -->
					 <div class="d-flex align-items-center justify-content-center">					 	
						  <img src="{{ asset('backend/images/logo-dark.png')}}" alt="">
						  <h3><b>Dashboard</b> Admin</h3>
					 </div>
				</a>
			</div>
        </div>
      
      <!-- sidebar menu-->
      <ul class="sidebar-menu" data-widget="tree">  
		  
		<li>
          <a href="index.html">
            <i data-feather="pie-chart"></i>
			<span>Dashboard</span>
          </a>
        </li>  
		
        <li class="treeview {{ ($prefix == '/brand') ? 'active' : ''}}">
          <a href="#">
            <i data-feather="message-circle"></i>
            <span>Brands</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu {{ ($route == 'all.brand') ? 'active' : ''}}">
            <li><a href="{{ route('all.brand')}}"><i class="ti-more"></i>All Brand</a></li>
          </ul>
        </li> 
		  
        <li class="treeview {{ ($prefix == '/category') ? 'active' : ''}}">
          <a href="#">
            <i data-feather="mail"></i> <span>Category</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu {{ ($route == 'view.category') ? 'active' : ''}}">
            <li><a href="{{ route('view.category')}}"><i class="ti-more"></i>All Category</a></li>
            <li><a href="{{ route('all.subcategory')}}"><i class="ti-more"></i>All Sub Category</a></li>
            <li><a href="{{ route('all.subsubcategory')}}"><i class="ti-more"></i>All Sub SubCategory</a></li>
          </ul>
        </li>
		
        <li class="treeview {{ ($prefix == '/product')? 'active': ''}}">
          <a href="#">
            <i data-feather="file"></i>
            <span>Products</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu {{ ($route == 'add-product') ? 'active' : ''}}">
            <li><a href="{{ route('add-product')}}"><i class="ti-more"></i>Add Product</a></li>
            <li><a href="{{ route('manage-product')}}"><i class="ti-more"></i>Manage Product</a></li>
          </ul>
        </li> 	
        
        <li class="treeview {{ ($prefix == '/slider')? 'active': ''}}">
          <a href="#">
            <i data-feather="file"></i>
            <span>Slider</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu {{ ($route == 'manage-slider') ? 'active' : ''}}">
            <li><a href="{{ route('manage-slider')}}"><i class="ti-more"></i>Manage Slider</a></li>
          </ul>
        </li>

        <li class="treeview {{ ($prefix == '/coupons')? 'active': ''}}">
          <a href="#">
            <i data-feather="file"></i>
            <span>Coupons</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu {{ ($route == 'manage-coupon') ? 'active' : ''}}">
            <li><a href="{{ route('manage-coupon')}}"><i class="ti-more"></i>Manage Coupon</a></li>
          </ul>
        </li>


        <li class="treeview {{ ($prefix == '/shipping')? 'active': ''}}">
          <a href="#">
            <i data-feather="file"></i>
            <span>Shipping Area</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu {{ ($route == 'manage-coupon') ? 'active' : ''}}">
            <li><a href="{{ route('manage-division')}}"><i class="ti-more"></i>Ship Division</a></li>
            <li><a href="{{ route('manage-district')}}"><i class="ti-more"></i>Ship District</a></li>
            <li><a href="{{ route('manage-state')}}"><i class="ti-more"></i>Ship State</a></li>
          </ul>
        </li>
		 
        <li class="header nav-small-cap">User Interface</li>
		  
        <li class="treeview {{ ($prefix == '/orders')? 'active': ''}}">
          <a href="#">
            <i data-feather="file"></i>
            <span>Order Area</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{ ($route == 'pending-order')? 'active':'' }}"><a href="{{ route('pending-order') }}"><i class="ti-more"></i>Pending Orders</a></li>
            <li class="{{ ($route == 'confirmend-order')? 'active':'' }}"><a href="{{ route('confirmend-order')}}"><i class="ti-more"></i>Confirm Order</a></li>
            <li class="{{ ($route == 'processiong-orders')? 'active':'' }}"><a href="{{ route('processiong-orders')}}"><i class="ti-more"></i>Procession Orders</a></li>
            <li class="{{ ($route == 'picked-orders')? 'active':'' }}"><a href="{{ route('picked-orders')}}"><i class="ti-more"></i>Picked Orders</a></li>
            <li class="{{ ($route == 'shipped-orders')? 'active':'' }}"><a href="{{ route('shipped-orders')}}"><i class="ti-more"></i>Shipped Orders</a></li>
            <li class="{{ ($route == 'delivered-orders')? 'active':'' }}"><a href="{{ route('delivered-orders')}}"><i class="ti-more"></i>Delivered Orders</a></li>
            <li class="{{ ($route == 'cancel-orders')? 'active':'' }}"><a href="{{ route('cancel-orders')}}"><i class="ti-more"></i>Cancel Orders</a></li>
          </ul>
        </li>
		
        <li class="treeview {{ ($prefix == '/reports')? 'active': ''}}">
          <a href="#">
            <i data-feather="file"></i>
            <span>All Report</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{ ($route == 'all-reports')? 'active':'' }}"><a href="{{ route('all-reports') }}"><i class="ti-more"></i>All Report</a></li>
          </ul>
        </li> 

        <li class="treeview {{ ($prefix == '/allUser')? 'active': ''}}">
          <a href="#">
            <i data-feather="file"></i>
            <span>All Users</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{ ($route == 'all-users')? 'active':'' }}"><a href="{{ route('all-users') }}"><i class="ti-more"></i>All Users</a></li>
          </ul>
        </li> 
        
      </ul>
    </section>
	
	<div class="sidebar-footer">
		<!-- item-->
		<a href="javascript:void(0)" class="link" data-toggle="tooltip" title="" data-original-title="Settings" aria-describedby="tooltip92529"><i class="ti-settings"></i></a>
		<!-- item-->
		<a href="mailbox_inbox.html" class="link" data-toggle="tooltip" title="" data-original-title="Email"><i class="ti-email"></i></a>
		<!-- item-->
		<a href="javascript:void(0)" class="link" data-toggle="tooltip" title="" data-original-title="Logout"><i class="ti-lock"></i></a>
	</div>
  </aside>