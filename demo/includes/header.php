<?php Include("connection.php");
?>
<div class="nav-header" style="background-color: #ffffff">
    <a href="<?php echo $website; ?>/dashboard/" class="brand-logo">
        <!-- <img class="logo-abbr" src="https://bhims.ca/piloting/img/favicon_New.png" alt="">-->
        <!--            <img class="logo-abbr" src="<?php echo $website; ?>/includes/AEC.png" style="width: 70px;height: 42px" alt="">-->
        <!--            <img class="logo-compact" src="<?php echo $website; ?>/includes/AEC.png" alt="">-->
        <img class="brand-title" src="<?php echo $website; ?>/includes/AEC.png" style="height: 100px;width: 222px" alt="">
    </a>
    <div class="nav-control">
        <div class="hamburger">
            <span class="line"></span><span class="line"></span><span class="line"></span>
        </div>
    </div>
</div>


<div class="header">
    <div class="header-content">
        <nav class="navbar navbar-expand">
            <div class="collapse navbar-collapse justify-content-between">
                <div class="header-left">
                    <div class="dashboard_bar">

                        <?php echo  $header_name; ?>
                    </div>
                </div>
                <ul class="navbar-nav header-right">
                    <li class="nav-item">

                    </li>
                    <li class="nav-item dropdown notification_dropdown">

                    </li>
                    <li class="nav-item dropdown notification_dropdown">

                    </li>
                    <li class="nav-item dropdown header-profile">
                        <a class="nav-link" href="javascript:void(0)" role="button" data-toggle="dropdown">
                            <img src="<?php echo $website; ?>/img/avatar.jpg" width="20" alt="">
                            <div class="header-info">
                                <?php
                                if($_COOKIE['role'] == 'Super Admin'){
                                    ?>
                                    <span class="text-black">Super Admin</span>
                                    <span class="text-black"><?php echo $_COOKIE['user_name']; ?></span>
                                    <?php
                                }
                                ?>
                                <?php
                                if($_COOKIE['role'] != 'Super Admin'){
                                    ?>
                                    <span class="text-black"><?php echo $_COOKIE['role']; ?></span>
                                    <span class="text-black"><?php echo $_COOKIE['user_name']; ?></span>
                                    <?php
                                }
                                ?>
                                <p class="fs-12 mb-0">
                                    <?php

                                    date_default_timezone_set("Asia/Calcutta");

                                    if (date("H") < 12) {

                                        echo "Good Morning !";

                                    } elseif (date("H") > 11 && date("H") < 17) {

                                        echo "Good Afternoon !";

                                    } elseif (date("H") > 16) {

                                        echo "Good Evening !";
                                    }

                                    ?>
                                </p>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">

                            <a class="dropdown-item ai-icon">
                                <svg id="icon-user1" xmlns="http://www.w3.org/2000/svg" class="text-primary"
                                     width="18" height="18" viewbox="0 0 24 24" fill="none" stroke="currentColor"
                                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                <span class="ml-2"><?php  echo $_COOKIE['role'];?></span>
                            </a>
                            <a href="<?php echo $website; ?>/login?logout=1" class="dropdown-item ai-icon">
                                <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger"
                                     width="18" height="18" viewbox="0 0 24 24" fill="none" stroke="currentColor"
                                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                    <polyline points="16 17 21 12 16 7"></polyline>
                                    <line x1="21" y1="12" x2="9" y2="12"></line>
                                </svg>
                                <span class="ml-2">Logout </span>
                            </a>
                        </div>

                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>

<div class="dlabnav">
    <div class="dlabnav-scroll">
        <ul class="metismenu" id="menu">
            <?php
            if($_COOKIE['role'] == 'Super Admin'|| $_COOKIE['role'] == 'Admin'|| $_COOKIE['role'] == 'Accounts' || $_COOKIE['role'] == 'Sales'|| $_COOKIE['role'] == 'Stores'|| $_COOKIE['role'] == 'Market'|| $_COOKIE['role'] == 'Service') {
                ?>
                <li>
                    <a class="ai-icon" href="<?php echo $website; ?>/dashboard/" aria-expanded="false">
                        <i class="fa-solid fa-desktop"></i>
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li>
                <?php
            }
            ?>
            <?php
            if($_COOKIE['role'] == 'Super Admin'|| $_COOKIE['role'] == 'Admin'|| $_COOKIE['role'] == 'Accounts'|| $_COOKIE['role'] == 'Sales'|| $_COOKIE['role'] == 'Market'|| $_COOKIE['role'] == 'Service') {
                ?>
                <li>
                    <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                        <i class="fa-solid fa-user"></i>
                        <span class="nav-text">People</span>
                    </a>
                    <ul aria-expanded="false">
                        <?php
                        if($_COOKIE['role'] == 'Super Admin'|| $_COOKIE['role'] == 'Admin'|| $_COOKIE['role'] == 'Accounts') {
                            ?>
                            <li id="active1"><a href="<?php echo $website; ?>/People/Suppliers/" id="link1"><i class="fa-solid fa-truck"></i> Suppliers</a></li>
                            <?php
                        }
                        ?>
                        <?php
                        if($_COOKIE['role'] == 'Super Admin'|| $_COOKIE['role'] == 'Admin'|| $_COOKIE['role'] == 'Accounts'|| $_COOKIE['role'] == 'Sales'|| $_COOKIE['role'] == 'Market'|| $_COOKIE['role'] == 'Service') {
                            ?>
                            <li id="active2"><a href="<?php echo $website; ?>/People/Customers/" id="link2"><i class="fa-solid fa-users"></i> Customers</a></li>
                            <?php
                        }
                        ?>
                        <?php
                        if($_COOKIE['role'] == 'Super Admin'|| $_COOKIE['role'] == 'Admin') {
                            ?>
                            <li id="active3"><a href="<?php echo $website; ?>/People/Users/" id="link3"><i class="fa-solid fa-user-friends"></i> Users</a></li>
                            <?php
                        }
                        ?>
                        <?php
                        if($_COOKIE['role'] == 'Super Admin'|| $_COOKIE['role'] == 'Admin'|| $_COOKIE['role'] == 'Accounts') {
                            ?>
                            <li id="active4"><a href="<?php echo $website; ?>/company_profile/" id="link4"><i class="fa-solid fa-building"></i> Company</a></li>
                            <?php
                        }
                        ?>
                    </ul>
                </li>
                <?php
            }
            ?>

            <?php
            if($_COOKIE['role'] == 'Super Admin'|| $_COOKIE['role'] == 'Admin'|| $_COOKIE['role'] == 'Accounts'|| $_COOKIE['role'] == 'Sales'|| $_COOKIE['role'] == 'Stores'|| $_COOKIE['role'] == 'Market'|| $_COOKIE['role'] == 'Service') {
                ?>
                <li>
                    <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                        <i class="fa-solid fa-warehouse"></i>
                        <span class="nav-text">Inventory</span>
                    </a>
                    <ul aria-expanded="false">
                        <?php
                        if($_COOKIE['role'] == 'Super Admin'|| $_COOKIE['role'] == 'Admin'|| $_COOKIE['role'] == 'Accounts'|| $_COOKIE['role'] == 'Sales'|| $_COOKIE['role'] == 'Stores'|| $_COOKIE['role'] == 'Market'|| $_COOKIE['role'] == 'Service') {
                            ?>
                            <li id="active5"><a href="<?php echo $website; ?>/inventory/product/" id="link5"><i class="fa-solid fa-cube"></i> Products</a></li>
                            <?php
                        }
                        ?>
                        <?php
                        if($_COOKIE['role'] == 'Super Admin'|| $_COOKIE['role'] == 'Admin'|| $_COOKIE['role'] == 'Sales'|| $_COOKIE['role'] == 'Stores') {
                            ?>
                            <li id="active6"><a href="<?php echo $website; ?>/inventory/category/" id="link6"><i class="fa-solid fa-tags"></i> Category</a></li>
                            <li id="active7"><a href="<?php echo $website; ?>/inventory/brand/" id="link7"><i class="fa-solid fa-stamp"></i> Brand</a></li>
                            <li id="active8"><a href="<?php echo $website; ?>/inventory/unit/" id="link8"><i class="fa-solid fa-balance-scale"></i> Unit</a></li>
                            <?php
                        }
                        ?>
                        <?php
                        if($_COOKIE['role'] == 'Super Admin'|| $_COOKIE['role'] == 'Admin') {
                            ?>
                            <li id="active9"><a href="<?php echo $website; ?>/inventory/currency/" id="link9"><i class="fa-solid fa-money-bill-wave"></i> Currency</a></li>
                            <?php
                        }
                        ?>
                    </ul>
                </li>
                <?php
            }
            ?>

            <?php
            if($_COOKIE['role'] == 'Super Admin'|| $_COOKIE['role'] == 'Accounts'|| $_COOKIE['role'] == 'Admin') {
                ?>
                <li>
                    <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                        <i class="fa-solid fa-wallet"></i>
                        <span class="nav-text">Ledger</span>
                    </a>
                    <ul aria-expanded="false">
                        <?php
                        if($_COOKIE['role'] == 'Super Admin'|| $_COOKIE['role'] == 'Admin'|| $_COOKIE['role'] == 'Accounts') {
                            ?>
                            <li id="active10"><a href="<?php echo $website; ?>/Ledgers/expense_category/" id="link10"><i
                                            class="fa-solid fa-chart-pie"></i> Expense Category</a></li>
                            <?php
                        }
                        ?>
                        <?php
                        if($_COOKIE['role'] == 'Super Admin'|| $_COOKIE['role'] == 'Accounts'|| $_COOKIE['role'] == 'Admin') {
                            ?>
                            <li id="active11"><a href="<?php echo $website; ?>/Ledgers/expense/" id="link11"><i class="fa-solid fa-receipt"></i>
                                    Expense</a></li>
                            <li id="active12"><a href="<?php echo $website; ?>/Ledgers/loan/" id="link12"><i
                                            class="fa-solid fa-hand-holding-usd"></i> Loan</a></li>
                            <?php
                        }
                        ?>
                        <?php
                        if($_COOKIE['role'] == 'Super Admin'|| $_COOKIE['role'] == 'Admin'|| $_COOKIE['role'] == 'Accounts') {
                            ?>
                            <li id="active13"><a href="<?php echo $website; ?>/cheque/" id="link13"><i class="fa-solid fa-money-check"></i>
                                    Cheque</a></li>
                        <?php }
                        ?>
                    </ul>
                </li>
                <?php
            }
            ?>

            <?php
            if($_COOKIE['role'] == 'Super Admin'||  $_COOKIE['role'] == 'Admin'|| $_COOKIE['role'] == 'Accounts'|| $_COOKIE['role'] == 'Sales'|| $_COOKIE['role'] == 'Stores') {
                ?>
                <li>
                    <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                        <i class="fa-solid fa-code-compare"></i>
                        <span class="nav-text">Adjustment</span>
                    </a>
                    <ul aria-expanded="false">
                        <?php
                        if($_COOKIE['role'] == 'Super Admin'|| $_COOKIE['role'] == 'Admin'|| $_COOKIE['role'] == 'Sales'|| $_COOKIE['role'] == 'Stores') {
                            ?>
                            <li id="active14"><a href="<?php echo $website; ?>/adjustment/" id="link14"><i class="fa-solid fa-cogs"></i> Create </a></li>
                            <?php
                        }
                        ?>
                        <?php
                        if($_COOKIE['role'] == 'Super Admin'|| $_COOKIE['role'] == 'Admin'|| $_COOKIE['role'] == 'Accounts'|| $_COOKIE['role'] == 'Sales'|| $_COOKIE['role'] == 'Stores') {
                            ?>
                            <li id="active15"><a href="<?php echo $website; ?>/adjustment/all_adjustment.php" id="link15"><i class="fa-solid fa-list-alt"></i> All </a></li>
                            <?php
                        }
                        ?>
                    </ul>
                </li>
                <?php
            }
            ?>
            <?php
            if($_COOKIE['role'] == 'Super Admin' || $_COOKIE['role'] == 'Admin' || $_COOKIE['role'] == 'Accounts'|| $_COOKIE['role'] == 'Sales'|| $_COOKIE['role'] == 'Stores') {
                ?>
                <li>
                    <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                        <i class="fa-solid fa-pen-fancy"></i>
                        <span class="nav-text">Intend</span>
                    </a>
                    <ul aria-expanded="false">
                        <li id="active16"><a href="<?php echo $website; ?>/intend/" id="link16"><i class="fa-solid fa-pencil-alt"></i> Create </a></li>
                        <li id="active17"><a href="<?php echo $website; ?>/intend/all_intend.php" id="link17"><i class="fa-solid fa-list"></i> All </a></li>
                    </ul>
                </li>
                <?php
            }
            ?>
            <?php
            if($_COOKIE['role'] == 'Super Admin' || $_COOKIE['role'] == 'Accounts'|| $_COOKIE['role'] == 'Admin'|| $_COOKIE['role'] == 'Sales'|| $_COOKIE['role'] == 'Stores') {
                ?>
                <li>
                    <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <span class="nav-text">Purchase</span>
                    </a>
                    <ul aria-expanded="false">
                        <?php
                        if($_COOKIE['role'] == 'Super Admin' ||  $_COOKIE['role'] == 'Admin') {
                            ?>
                            <li id="active18"><a href="<?php echo $website; ?>/purchase/" id="link18"><i class="fa-solid fa-cart-plus"></i> Create </a></li>
                            <?php
                        }
                        ?>
                        <?php
                        if($_COOKIE['role'] == 'Super Admin' ||  $_COOKIE['role'] == 'Accounts'|| $_COOKIE['role'] == 'Admin'|| $_COOKIE['role'] == 'Sales'|| $_COOKIE['role'] == 'Stores') {
                            ?>
                            <li id="active19"><a href="<?php echo $website; ?>/purchase/all_purchase.php" id="link19"><i class="fa-solid fa-clipboard-list"></i> All </a></li>
                            <li id="active19"><a href="<?php echo $website; ?>/purchase_payment" id="link19"><i class="fa-solid fa-clipboard-list"></i> Purchase Payment</a></li>
                            <li id="active20"><a href="<?php echo $website; ?>/purchase_shipment" id="link20"><i class="fa-solid fa-truck-loading"></i> Delivery challan</a></li>
                            <li id="active20"><a href="<?php echo $website; ?>/purchase_dc_payment" id="link20"><i class="fa-solid fa-truck-loading"></i> DC Payment</a></li>
                            <?php
                        }
                        ?>
                    </ul>
                </li>
                <?php
            }
            ?>
            <?php
            if($_COOKIE['role'] == 'Super Admin' || $_COOKIE['role'] == 'Admin' || $_COOKIE['role'] == 'Accounts'|| $_COOKIE['role'] == 'Sales'|| $_COOKIE['role'] == 'Stores') {
                ?>
                <li>
                    <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                        <i class="fa-solid fa-pen-fancy"></i>
                        <span class="nav-text">Sale Order</span>
                    </a>
                    <ul aria-expanded="false">
                        <?php
                        if($_COOKIE['role'] == 'Super Admin' || $_COOKIE['role'] == 'Admin'|| $_COOKIE['role'] == 'Sales') {
                            ?>
                            <li id="active21"><a href="<?php echo $website; ?>/so/" id="link21"><i class="fa-solid fa-pencil-alt"></i> Create </a></li>
                            <?php
                        }
                        ?>
                        <?php
                        if($_COOKIE['role'] == 'Super Admin' || $_COOKIE['role'] == 'Admin' || $_COOKIE['role'] == 'Accounts'|| $_COOKIE['role'] == 'Sales'|| $_COOKIE['role'] == 'Stores') {
                            ?>
                            <li id="active22"><a href="<?php echo $website; ?>/so/all_so.php" id="link22"><i class="fa-solid fa-list"></i> All </a></li>
                            <?php
                        }
                        ?>
                    </ul>
                </li>
                <?php
            }
            ?>
            <?php
            if($_COOKIE['role'] == 'Super Admin' || $_COOKIE['role'] == 'Accounts' || $_COOKIE['role'] == 'Admin'|| $_COOKIE['role'] == 'Sales'|| $_COOKIE['role'] == 'Stores') {
                ?>
                <li>
                    <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                        <i class="fa-solid fa-bag-shopping"></i>
                        <span class="nav-text">Sales</span>
                    </a>
                    <ul aria-expanded="false">
                        <?php
                        if($_COOKIE['role'] == 'Super Admin' || $_COOKIE['role'] == 'Admin'|| $_COOKIE['role'] == 'Sales') {
                            ?>
                            <li id="active23"><a href="<?php echo $website; ?>/sale/" id="link23"><i class="fa-solid fa-cart-arrow-down"></i> Create </a></li>
                            <?php
                        }
                        ?>
                        <?php
                        if($_COOKIE['role'] == 'Super Admin' || $_COOKIE['role'] == 'Accounts' || $_COOKIE['role'] == 'Admin'|| $_COOKIE['role'] == 'Sales'|| $_COOKIE['role'] == 'Stores') {
                            ?>
                            <li id="active24"><a href="<?php echo $website; ?>/sale/all_sale.php" id="link24"><i class="fa-solid fa-list-ul"></i> All </a></li>
                            <li id="active24"><a href="<?php echo $website; ?>/sale_payment" id="link24"><i class="fa-solid fa-list-ul"></i> Sale Payment </a></li>
                            <li id="active25"><a href="<?php echo $website; ?>/sale_shipment/" id="link25"><i class="fa-solid fa-truck-moving"></i> Delivery challan</a></li>
                            <li id="active25"><a href="<?php echo $website; ?>/sale_dc_payment/" id="link25"><i class="fa-solid fa-truck-moving"></i> DC Payment</a></li>
                            <li id="active25"><a href="https://ewaybillgst.gov.in/login.aspx/" target="_blank" id="link25"><i class="fa-solid fa-truck-moving"></i>E-Way Bill</a></li>
                            <?php
                        }
                        ?>
                    </ul>
                </li>
                <?php
            }
            ?>

            <?php
            if($_COOKIE['role'] == 'Super Admin'|| $_COOKIE['role'] == 'Admin'|| $_COOKIE['role'] == 'Accounts'|| $_COOKIE['role'] == 'Sales'|| $_COOKIE['role'] == 'Stores') {
                ?>
                <li>
                    <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                        <i class="fa-solid fa-tent-arrow-turn-left"></i>
                        <span class="nav-text">Purchase Returns</span>
                    </a>
                    <ul aria-expanded="false">
                        <li id="active26"><a href="<?php echo $website; ?>/purchase_return" id="link26"><i class="fa-solid fa-reply-all"></i> All Returns</a></li>
                        <li id="active26"><a href="<?php echo $website; ?>/purchase_return_payment" id="link26"><i class="fa-solid fa-reply-all"></i> Purchase Return Payment</a></li>
                    </ul>
                </li>
                <?php
            }
            ?>

            <?php
            if($_COOKIE['role'] == 'Super Admin'|| $_COOKIE['role'] == 'Accounts' || $_COOKIE['role'] == 'Admin'|| $_COOKIE['role'] == 'Sales'|| $_COOKIE['role'] == 'Stores') {
                ?>
                <li>
                    <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                        <i class="fa-solid fa-person-chalkboard"></i>
                        <span class="nav-text">Sale Returns</span>
                    </a>
                    <ul aria-expanded="false">
                        <li id="active27"><a href="<?php echo $website; ?>/sale_return" id="link27"><i class="fa-solid fa-undo-alt"></i> All Returns</a></li>
                        <li id="active27"><a href="<?php echo $website; ?>/sale_return_payment" id="link27"><i class="fa-solid fa-undo-alt"></i> Sale Return Payment</a></li>
                    </ul>
                </li>
                <?php
            }
            ?>

            <?php
            if($_COOKIE['role'] == 'Super Admin' || $_COOKIE['role'] == 'Market'|| $_COOKIE['role'] == 'Admin') {
                ?>
                <li>
                    <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                        <i class="fa-solid fa-person-chalkboard"></i>
                        <span class="nav-text">Marketing</span>
                    </a>
                    <ul aria-expanded="false">
                        <li id="active28"><a href="<?php echo $website; ?>/marketing" id="link28"><i class="fa-solid fa-briefcase"></i> Visit Report</a></li>
                        <li id="active29"><a href="<?php echo $website; ?>/market_company" id="link29"><i class="fa-solid fa-briefcase"></i> Company profile</a></li>
                    </ul>
                </li>
            <?php }
            ?>
            <?php
            if($_COOKIE['role'] == 'Super Admin'|| $_COOKIE['role'] == 'Service'|| $_COOKIE['role'] == 'Admin') {
                ?>
                <li>
                    <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                        <i class="fa-solid fa-person-chalkboard"></i>
                        <span class="nav-text">Services</span>
                    </a>
                    <ul aria-expanded="false">
                        <li id="active30"><a href="<?php echo $website; ?>/service"id="link30"><i class="fa-solid fa-briefcase"></i> Service Report</a></li>
                        <li id="active31"><a href="<?php echo $website; ?>/service_company" id="link31"><i class="fa-solid fa-briefcase"></i>Company profile</a></li>
                    </ul>
                </li>

            <?php }
            ?>

            <?php
            if($_COOKIE['role'] == 'Super Admin'  || $_COOKIE['role'] == 'Market'|| $_COOKIE['role'] == 'Admin' || $_COOKIE['role'] == 'Service' ) {
                ?>
                <li>
                    <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                        <i class="fa-solid fa-code-compare"></i>
                        <span class="nav-text">Planner</span>
                    </a>
                    <ul aria-expanded="false">
                        <?php
                        if($_COOKIE['role'] == 'Super Admin' || $_COOKIE['role'] == 'Accounts'|| $_COOKIE['role'] == 'Admin') {
                        ?>
                        <li>
                            <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                                <i class="fa-solid fa-code-compare"></i>
                                <span class="nav-text">Accounts Planner</span>
                            </a>
                            <ul aria-expanded="false">
                        <li id="active32">
                            <a class="ai-icon" href="<?php echo $website; ?>/planner/accounts_planner/customer" id="link32" aria-expanded="false">
                                <i class="fa-solid fa-briefcase"></i>
                                <span class="nav-text">Customer</span>
                            </a>
                        </li>
                        <li id="active32">
                            <a class="ai-icon" href="<?php echo $website; ?>/planner/accounts_planner/supplier" id="link32" aria-expanded="false">
                                <i class="fa-solid fa-briefcase"></i>
                                <span class="nav-text">Supplier</span>
                            </a>
                        </li>
                        
                            </ul>
                        </li>
                        <?php }?>
          <?php
            if($_COOKIE['role'] == 'Super Admin' || $_COOKIE['role'] == 'Market'|| $_COOKIE['role'] == 'Admin') {
                ?>
                        <li id="active33">
                            <a class="ai-icon" href="<?php echo $website; ?>/planner/marketing_planner/" id="link33" aria-expanded="false">
                                <i class="fa-solid fa-briefcase"></i>
                                <span class="nav-text"> Marketing Planner</span>
                            </a>
                        </li>
                    <li id="active33">
                        <a class="ai-icon" href="<?php echo $website; ?>/planner/marketing_target/" id="link33" aria-expanded="false">
                            <i class="fa-solid fa-briefcase"></i>
                            <span class="nav-text"> Marketing Target</span>
                        </a>
                    </li>
                        <li id="active33">
                            <a class="ai-icon" href="<?php echo $website; ?>/planner/marketing_planner/call_track/" id="link33" aria-expanded="false">
                                <i class="fa-solid fa-briefcase"></i>
                                <span class="nav-text"> Marketing CallTrack</span>
                            </a>
                        </li>
                         <?php }
                         ?>
                         <?php
                         if($_COOKIE['role'] == 'Super Admin'|| $_COOKIE['role'] == 'Service'|| $_COOKIE['role'] == 'Admin') {
                         ?>
                        <li id="active34">
                            <a class="ai-icon" href="<?php echo $website; ?>/planner/service_planner/" id="link34"aria-expanded="false">
                                <i class="fa-solid fa-briefcase"></i>
                                <span class="nav-text">Service Planner</span>
                            </a>
                        </li>
                         <li id="active34">
                             <a class="ai-icon" href="<?php echo $website; ?>/planner/service_target/" id="link34"aria-expanded="false">
                                 <i class="fa-solid fa-briefcase"></i>
                                 <span class="nav-text">Service Target</span>
                             </a>
                         </li>
                        <li id="active34">
                            <a class="ai-icon" href="<?php echo $website; ?>/planner/service_planner/call_track/" id="link34"aria-expanded="false">
                                <i class="fa-solid fa-briefcase"></i>
                                <span class="nav-text">Service CallTrack</span>
                            </a>
                        </li>
                        <?php }
                         ?>
                    </ul>
                </li>
                <?php
            }
            ?>


            <?php
            if($_COOKIE['role'] == 'Super Admin') {
                ?>
                <li>
                    <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                        <i class="fa-solid fa-code-compare"></i>
                        <span class="nav-text">Request</span>
                    </a>
                    <ul aria-expanded="false">
                        <li id="active32">
                            <a class="ai-icon" href="<?php echo $website; ?>/intend_request/" id="link32" aria-expanded="false">
                                <i class="fa-solid fa-briefcase"></i>
                                <span class="nav-text">Intend Request</span>
                            </a>
                        </li>
                        <li id="active33">
                            <a class="ai-icon" href="<?php echo $website; ?>/po_request/" id="link33" aria-expanded="false">
                                <i class="fa-solid fa-briefcase"></i>
                                <span class="nav-text"> PO Request</span>
                            </a>
                        </li>
                        <li id="active34">
                            <a class="ai-icon" href="<?php echo $website; ?>/product_request/" id="link34"aria-expanded="false">
                                <i class="fa-solid fa-briefcase"></i>
                                <span class="nav-text"> Product Request</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <?php
            }
            ?>
            <?php
            if($_COOKIE['role'] == 'Super Admin' || $_COOKIE['role'] == 'Admin') {
                ?>
                <li>
                    <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                        <i class="fa-solid fa-file-arrow-down"></i>
                        <span class="nav-text">Reports</span>
                    </a>
                    <ul aria-expanded="false">
                        <?php
                        if($_COOKIE['role'] == 'Super Admin'|| $_COOKIE['role'] == 'Admin') {
                            ?>
                            <li><a href="<?php echo $website; ?>/report/intend_report"><i
                                            class="fa-solid fa-chart-bar"></i> Intend</a></li>
                            <li><a href="<?php echo $website; ?>/report/adjustment_report"><i
                                            class="fa-solid fa-chart-line"></i> Adjustment</a></li>
                            <li><a href="<?php echo $website; ?>/report/purchase_outstanding/"><i
                                            class="fa-solid fa-chart-area"></i> Purchase Outstanding</a></li>
                            <li><a href="<?php echo $website; ?>/report/customer_outstanding"><i
                                            class="fa-solid fa-chart-area"></i> Customer Outstanding</a></li>
                            <li><a href="<?php echo $website; ?>/report/non_moving_product"><i
                                            class="fa-solid fa-chart-bar"></i> Non Moving Product</a></li>
                            <?php
                        }
                        ?>
                        <?php
                        if($_COOKIE['role'] == 'Super Admin'|| $_COOKIE['role'] == 'Stores'|| $_COOKIE['role'] == 'Admin') {
                            ?>
                            <li><a href="<?php echo $website; ?>/report/stock_report"><i class="fa-solid fa-chart-pie"></i>
                                    Stock</a></li>
                            <?php
                        }
                        ?>

                        <?php
                        if($_COOKIE['role'] == 'Super Admin'|| $_COOKIE['role'] == 'Sales'|| $_COOKIE['role'] == 'Admin') {
                            ?>
                            <li><a href="<?php echo $website; ?>/report/customerwise_sale"><i
                                            class="fa-solid fa-chart-line"></i> Customer wise sale </a></li>
                            <li><a href="<?php echo $website; ?>/report/sale_outstanding/"><i
                                            class="fa-solid fa-chart-line"></i> Sale Outstanding</a></li>
                            <li><a href="<?php echo $website; ?>/report/productwise_sale"><i
                                            class="fa-solid fa-chart-line"></i> Product Wise Sale</a></li>
                            <?php
                        }
                        ?>

                    </ul>
                </li>
                <?php
            }
            ?>







<!--            --><?php
//            if($_COOKIE['role'] == 'Super Admin'|| $_COOKIE['role'] == 'Admin'|| $_COOKIE['role'] == 'Accounts') {
//                ?>
<!--                <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">-->
<!--                        <i class="fa-solid fa-person-chalkboard"></i>-->
<!--                        <span class="nav-text">Planner</span>-->
<!--                    </a>-->
<!--                    <ul aria-expanded="false">-->
<!---->
<!--                        <li><a href="--><?php //echo $website; ?><!--/planner/accounts_planner/"><i class="fa-solid fa-users"></i> Accounts Planner</a>-->
<!--                            <ul aria-expanded="false">-->
<!--                                <li><a href="--><?php //echo $website; ?><!--/planner/accounts_planner/supplier/"><i class="fa-solid fa-users"></i>Supplier</a></li>-->
<!--                                <li><a href="--><?php //echo $website; ?><!--/planner/accounts_planner/customer/"><i class="fa-solid fa-users"></i>Customer</a></li>-->
<!--                            </ul>-->
<!--                        </li>-->
<!--                        <li><a href="--><?php //echo $website; ?><!--/planner/marketing_planner/"><i class="fa-solid fa-user-clock"></i> Marketing Planner</a></li>-->
<!--                        <li><a href="--><?php //echo $website; ?><!--/planner/service_planner/"><i class="fa-solid fa-mug-saucer"></i></i> Service Planner</a></li>-->
<!---->
<!---->
<!--                    </ul>-->
<!--                </li>-->
<!--                --><?php
//            }
//            ?>








            <?php
            if($_COOKIE['role'] == 'Super Admin'|| $_COOKIE['role'] == 'Admin'|| $_COOKIE['role'] == 'Accounts') {
                ?>
                <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                        <i class="fa-solid fa-person-chalkboard"></i>
                        <span class="nav-text">HRMS</span>
                    </a>
                    <ul aria-expanded="false">
                        <?php
                        if($_COOKIE['role'] == 'Super Admin'|| $_COOKIE['role'] == 'Admin'|| $_COOKIE['role'] == 'Accounts') {
                            ?>
<!--                            <li><a href="--><?php //echo $website; ?><!--/hrms/staff/"><i class="fa-solid fa-users"></i> Staff</a></li>-->
                            <?php
                        }
                        ?>
                        <?php
                        if($_COOKIE['role'] == 'Super Admin'|| $_COOKIE['role'] == 'Admin') {
                            ?>
                            <li><a href="<?php echo $website; ?>/hrms/attendance/"><i class="fa-solid fa-user-clock"></i> Attendance</a></li>
                            <li><a href="<?php echo $website; ?>/hrms/break_attendance/"><i class="fa-solid fa-mug-saucer"></i></i> Break</a></li>
                            <li><a href="<?php echo $website; ?>/hrms/visitors/"><i class="fa-solid fa-eye"></i> Visitors</a></li>
                            <li><a href="<?php echo $website; ?>/hrms/device/"><i class="fa-solid fa-mobile-screen"></i> Device</a></li>
                            <li><a href="<?php echo $website; ?>/hrms/settings/"><i class="fa-solid fa-gear"></i> Settings</a></li>
                            <li><a href="<?php echo $website; ?>/hrms/payroll_month/"><i class="fa-solid fa-file-invoice-dollar"></i> Payroll Month</a></li>
                            <?php
                        }
                        ?>
                        <?php
                        if($_COOKIE['role'] == 'Super Admin'|| $_COOKIE['role'] == 'Admin'|| $_COOKIE['role'] =='Accounts') {
                            ?>
                            <li><a href="<?php echo $website; ?>/hrms/payroll/"><i class="fa-solid fa-file-invoice-dollar"></i> Payroll</a></li>
                            <?php
                        }
                        ?>
                        <?php
                        if($_COOKIE['role'] == 'Super Admin'|| $_COOKIE['role'] == 'Admin') {
                            ?>
                            <li><a href="<?php echo $website; ?>/hrms/holiday/"><i class="fa-solid fa-calendar-alt"></i> Holidays</a></li>
                            <?php
                        }
                        ?>
                    </ul>
                </li>
                <?php
            }
            ?>
        </ul>

        <div class="copyright">
            <p><strong>AEC Admin Panel</strong> © <?php echo date('Y')?> All Rights Reserved</p>
            <p>Made with <span class="heart"></span> by <a href="https://www.gbtechcorp.co.in/" target="_blank">GB TECH CORP</a></p>
        </div>
    </div>
</div>









