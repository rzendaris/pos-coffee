<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Mit Coffee</div>
      </a>
      <hr class="sidebar-divider my-0">
      @if (env('DEPLOYMENT_ENV') == 'POS'){
        @if(Auth::user()->role == 3)
        <li class="nav-item active">
          <a class="nav-link" href="{{url('/')}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>POS</span></a>
        </li>
        
        <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-table"></i>
              <span>Order</span>
          </a>
          <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar" style="">
            <div class="bg-white py-2 collapse-inner rounded">
              <h6 class="collapse-header">Order:</h6>
              <a href="{{ url('order-undelivered') }}" class="collapse-item">Order Undelivered</a>
              <a href="{{ url('order-delivered') }}" class="collapse-item">Order Delivered</a>
            </div>
          </div>
        </li>
        <div style="display:none">
        @else
        <div>
        @endif
          <hr class="sidebar-divider">
          <div class="sidebar-heading">
            POS Management
          </div>
          <li class="nav-item">
            <a class="nav-link" href="{{url('user-management')}}">
              <i class="fas fa-fw fa-table"></i>
              <span>User Management</span></a>
          </li>
          <!-- <li class="nav-item">
            <a class="nav-link" href="{{url('branch-management')}}">
              <i class="fas fa-fw fa-table"></i>
              <span>Branch Management</span></a>
          </li> -->
          <li class="nav-item">
            <a class="nav-link" href="{{url('category-management')}}">
              <i class="fas fa-fw fa-table"></i>
              <span>Category Management</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{url('/item-management')}}">
              <i class="fas fa-fw fa-table"></i>
              <span>Items Management</span></a>
          </li>
          <!-- <li class="nav-item">
            <a class="nav-link" href="{{url('/customer-management')}}">
              <i class="fas fa-fw fa-table"></i>
              <span>Customer Management</span></a>
          </li> -->
          <!-- <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
              <i class="fas fa-fw fa-table"></i>
                <span>Transaction</span>
            </a>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar" style="">
              <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Transaction:</h6>
                <a href="{{ url('order-list') }}" class="collapse-item">Transaction List</a>
                <a href="{{ url('order-retur') }}" class="collapse-item">Transaction Retur</a>
              </div>
            </div>
          </li> -->
          <li class="nav-item">
            <a class="nav-link" href="{{url('order-list')}}">
              <i class="fas fa-fw fa-chart-area"></i>
              <span>Transaction</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{url('report-management')}}">
              <i class="fas fa-fw fa-chart-area"></i>
              <span>Report Management</span></a>
          </li>
        @endif
        <!-- <div class="sidebar-heading">
          Cash
        </div>
        <li class="nav-item">
          <a class="nav-link" href="{{url('payment')}}">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Penerimaan Cash</span></a>
        </li> -->
      </div>
      <hr class="sidebar-divider d-none d-md-block">
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>
      <hr class="sidebar-divider">
    </ul>