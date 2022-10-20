 <!-- Sidebar -->
 <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

     <!-- Sidebar - Brand -->
     <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url(); ?>">
         <div class="sidebar-brand-icon">
             <i class="fas fa-print"></i>
         </div>
         <div class="sidebar-brand-text mx-3">TRANS APP</div>
     </a>

     <!-- Divider -->
     <hr class="sidebar-divider my-0">

     <!-- Nav Item - Dashboard -->
     <li class="nav-item">
         <a class="nav-link" href="<?= base_url(); ?>">
             <i class="fas fa-fw fa-list-alt"></i>
             <span>Daftar Transaksi</span></a>
     </li>

     <!-- Divider -->
     <hr class="sidebar-divider my-0">

     <!-- Divider -->
     <hr class="sidebar-divider my-0">

     <!-- Nav Item - Dashboard -->
     <li class="nav-item">
         <a class="nav-link" href="<?= base_url('sale'); ?>">
             <i class="fas fa-fw fa-list-alt"></i>
             <span>Sale</span></a>
     </li>



     <!-- Divider -->
     <hr class="sidebar-divider d-none d-md-block">

     <!-- Sidebar Toggler (Sidebar) -->
     <div class="text-center d-none d-md-inline">
         <button class="rounded-circle border-0" id="sidebarToggle"></button>
     </div>
 </ul>
 <!-- End of Sidebar -->