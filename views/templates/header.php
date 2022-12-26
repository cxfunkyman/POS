<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--favicon-->
    <link rel="icon" href="<?php echo BASE_URL; ?>assets/images/favicon-32x32.png" type="image/png" />
    <link href="<?php echo BASE_URL; ?>assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
    <link href="<?php echo BASE_URL; ?>assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
    <link href="<?php echo BASE_URL; ?>assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
    <!-- loader-->
    <link href="<?php echo BASE_URL; ?>assets/css/pace.min.css" rel="stylesheet" />
    <script src="<?php echo BASE_URL; ?>assets/js/pace.min.js"></script>
    <!-- Bootstrap CSS -->
    <link href="<?php echo BASE_URL; ?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo BASE_URL; ?>assets/css/bootstrap-extended.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/jquery-ui.min.css">
    <link href="<?php echo BASE_URL; ?>assets/css/app.css" rel="stylesheet">
    <link href="<?php echo BASE_URL; ?>assets/css/icons.css" rel="stylesheet">
    <!-- Theme Style CSS -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/dark-theme.css" />
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/semi-dark.css" />
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/header-colors.css" />
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/DataTables/datatables.min.css" />
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/plugins/fullcalendar/css/main.min.css" />
    
    <title><?php echo TITLE . ' - ' . $data['title']; ?></title>
</head>

<body>
    <!--wrapper-->
    <div class="wrapper">
        <!--sidebar wrapper -->
        <div class="sidebar-wrapper" data-simplebar="true">
            <div class="sidebar-header">
                <div>
                    <img src="<?php echo BASE_URL; ?>assets/images/logo-icon.png" class="logo-icon" alt="logo icon">
                </div>
                <div>
                    <h4 class="logo-text">SALES</h4>
                </div>
                <div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
                </div>
            </div>
            <!--navigation-->
            <ul class="metismenu" id="menu">
                <li>
                    <a href="<?php echo BASE_URL . 'admin'; ?>">
                        <div class="parent-icon"><i class="fa-brands fa-phoenix-squadron"></i>
                            </i>
                        </div>
                        <div class="menu-title">Dashboard</div>
                    </a>
                </li>
                <li>
                    <a href="javascript:;" class="has-arrow">
                        <div class="parent-icon"><i class="fa-solid fa-screwdriver-wrench"></i>
                        </div>
                        <div class="menu-title">Administration</div>
                    </a>
                    <ul>
                        <li> <a href="<?php echo BASE_URL . 'users'; ?>"><i class="bx bx-right-arrow-alt"></i>Users</a>
                        </li>
                        <li> <a href="<?php echo BASE_URL . 'admin/configData'; ?>"><i class="bx bx-right-arrow-alt"></i>Configuration</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:;" class="has-arrow">
                        <div class="parent-icon"><i class="fa-solid fa-clipboard-list"></i>
                        </div>
                        <div class="menu-title">Maintenance</div>
                    </a>
                    <ul>
                        <li> <a href="<?php echo BASE_URL . 'measures'; ?>"><i class="bx bx-right-arrow-alt"></i>Measures</a>
                        </li>
                        <li> <a href="<?php echo BASE_URL . 'categories'; ?>"><i class="bx bx-right-arrow-alt"></i>Categories</a>
                        </li>
                        <li> <a href="<?php echo BASE_URL . 'products'; ?>"><i class="bx bx-right-arrow-alt"></i>Products</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="<?php echo BASE_URL . 'clients'; ?>">
                        <div class="parent-icon"><i class='fa-solid fa-users'></i>
                        </div>
                        <div class="menu-title">Clients</div>
                    </a>
                </li>
                <li>
                    <a href="<?php echo BASE_URL . 'suppliers'; ?>">
                        <div class="parent-icon"><i class='fa-solid fa-cart-flatbed-suitcase'></i>
                        </div>
                        <div class="menu-title">Suppliers</div>
                    </a>
                </li>
                <li>
                    <a href="<?php echo BASE_URL . 'cashRegister'; ?>">
                        <div class="parent-icon"><i class="fa-solid fa-cash-register"></i>
                        </div>
                        <div class="menu-title">Cash Registers</div>
                    </a>
                </li>
                <li>
                    <a href="<?php echo BASE_URL . 'purchases'; ?>">
                        <div class="parent-icon"><i class="fa-solid fa-truck-fast"></i>
                        </div>
                        <div class="menu-title">Purchases</div>
                    </a>
                </li>
                <li>
                    <a href="<?php echo BASE_URL . 'sales'; ?>">
                        <div class="parent-icon"><i class="fa-solid fa-coins"></i>
                        </div>
                        <div class="menu-title">Sales</div>
                    </a>
                </li>
                <li>
                    <a href="<?php echo BASE_URL . 'credits'; ?>">
                        <div class="parent-icon"><i class="fa-solid fa-credit-card"></i>
                        </div>
                        <div class="menu-title">Admin Credits</div>
                    </a>
                </li>
                <li>
                    <a href="<?php echo BASE_URL . 'quotes'; ?>">
                        <div class="parent-icon"><i class="fa-solid fa-rectangle-list"></i>
                        </div>
                        <div class="menu-title">Quotes</div>
                    </a>
                </li>
                <li>
                    <a href="<?php echo BASE_URL . 'reserves'; ?>">
                        <div class="parent-icon"><i class="fa-solid fa-people-arrows"></i>
                        </div>
                        <div class="menu-title">Reserves</div>
                    </a>
                </li>
                <li>
                    <a href="<?php echo BASE_URL . 'inventory'; ?>">
                        <div class="parent-icon"><i class="fa-solid fa-file-lines"></i>
                        </div>
                        <div class="menu-title">Inventory & Kardex</div>
                    </a>
                </li>
            </ul>
            <!--end navigation-->
        </div>
        <!--end sidebar wrapper -->
        <!--start header -->
        <header>
            <div class="topbar d-flex align-items-center">
                <nav class="navbar navbar-expand">
                    <div class="mobile-toggle-menu"><i class='bx bx-menu'></i>
                    </div>
                    <div class="search-bar flex-grow-1">
                        <div class="position-relative">
                            <h6><?php echo TITLE . ' - ' . $data['title']; ?></h6>
                        </div>
                    </div>
                    <div class="user-box dropdown">
                        <a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="<?php echo BASE_URL; ?>assets/images/avatars/cx.jpg" class="user-img" alt="user avatar">
                            <div class="user-info ps-3">
                                <p class="user-name mb-0"><?php echo $_SESSION['user_name'] . ' ' . $_SESSION['user_lname']; ?></p>
                                <p class="designattion mb-0"><?php echo $_SESSION['user_email']; ?></p>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="javascript:;"><i class="bx bx-user"></i><span>Profile</span></a>
                            </li>
                            <li>
                                <div class="dropdown-divider mb-0"></div>
                            </li>
                            <li><a class="dropdown-item" href="javascript:;"><i class='bx bx-log-out-circle'></i><span>Logout</span></a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </header>
        <!--end header -->
        <!--start page wrapper -->
        <div class="page-wrapper">
            <div class="page-content">