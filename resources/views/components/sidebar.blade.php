 <aside class="left-sidebar">
     <!-- Sidebar scroll-->
     <div>
         <div class="brand-logo d-flex align-items-center justify-content-between">
             <a href="./index.html" class="text-nowrap logo-img">
                 <img src="{{ asset('assets/images/logos/logo.jpg') }}" alt="" style="height: 100px;"/>
             </a>
             <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                 <i class="ti ti-x fs-6"></i>
             </div>
         </div>
         <!-- Sidebar navigation-->
         <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
             <ul id="sidebarnav">
                 <li class="nav-small-cap">
                     <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                     <span class="hide-menu">Home</span>
                 </li>
                 <li class="sidebar-item">
                     <a class="sidebar-link" href="{{ route('index')}}" aria-expanded="false">
                         <i class="ti ti-atom"></i>
                         <span class="hide-menu">Dashboard</span>
                     </a>
                 </li>
                 <li class="sidebar-item">
                     <a class="sidebar-link" href="{{ route('vehicles.vehicles') }}" aria-expanded="false">
                         <i class="ti ti-car"></i>
                         <span class="hide-menu">Vehicles</span>
                     </a>
                 <li class="sidebar-item">
                     <a class="sidebar-link" href="{{ route('officers.index') }}" aria-expanded="false">
                         <i class="ti ti-badge"></i>
                         <span class="hide-menu">Officer</span>
                     </a>
                 </li>
             </ul>
         </nav>
         <!-- End Sidebar navigation -->
     </div>
     <!-- End Sidebar scroll-->
 </aside>
