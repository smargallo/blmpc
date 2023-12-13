<?php session_start(); ?>
<ul class="navbar-nav topbar topbar-dark mb-3" id="accordionTopBar">
    <li class="nav-item d-flex ml-auto mt-3 mr-2 p-2 align-items-center" tooltipl>
        <span class="mr-3 text-white text-center text-uppercase">Currently logged in as <span class="bold" style="font-weight: bold; font-style: italic;"><?php echo $_SESSION['username'] ?></span></span>
        <a style="border-radius: 100%; color: white; height: 30px; width: 30px;" class="d-flex align-items-center justify-content-between btn btn-sm btn-danger" href="#" data-toggle="modal" title="Logout button" data-target="#logoutModal">
            <i class="fas fa-fw fa-sign-out-alt"></i>
        </a>
    </li>
</ul>