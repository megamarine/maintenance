<!-- START navbar header -->

<!--/ END navbar header -->

<!-- START Toolbar -->
<div class="navbar-toolbar clearfix">
    <!-- START Left nav -->
    <ul class="nav navbar-nav navbar-left">
        <!-- Sidebar shrink -->
        <li class="hidden-xs hidden-sm">
            <a href="javascript:void(0);" class="sidebar-minimize" data-toggle="minimize" title="Minimize sidebar">
                <span class="meta">
                    <span class="icon"></span>
                </span>
            </a>
        </li>
        <!--/ Sidebar shrink -->

        <!-- Offcanvas left: This menu will take position at the top of template header (mobile only). Make sure that only #header have the `position: relative`, or it may cause unwanted behavior -->
        <li class="navbar-main hidden-lg hidden-md hidden-sm">
            <a href="javascript:void(0);" data-toggle="sidebar" data-direction="ltr" rel="tooltip" title="Menu sidebar">
                <span class="meta">
                    <span class="icon"><i class="ico-paragraph-justify3"></i></span>
                </span>
            </a>
        </li>
        <!--/ Offcanvas left -->
		
    </ul>
    <!--/ END Left nav -->

    <!-- START navbar form -->
    <div class="navbar-form navbar-left dropdown" id="dropdown-form">
        <form action="" role="search">
            <div class="has-icon">
                <input type="text" class="form-control" placeholder="Search application...">
                <i class="ico-search form-control-icon"></i>
            </div>
        </form>
    </div>
    <!-- START navbar form -->

    <!-- START Right nav -->
    <ul class="nav navbar-nav navbar-right">
		<!-- Notification dropdown -->
        <!--/ Notification dropdown -->
		
        <!-- Profile dropdown -->
        <li class="dropdown profile">
            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
                <span class="meta">
                    <span class="text hidden-xs hidden-sm pl5"><?php echo $_SESSION["LOGINNAMAUS_MT"]; ?></span>
                </span>
            </a>
            <ul class="dropdown-menu" role="menu">
                <!-- <li><a href="edit_profile"><span class="icon"><i class="ico-cog4"></i></span> Profile Setting</a></li> -->
                <?php
                if ($_SESSION["LOGINDEP_MT"] == "DEPT-0033" or $_SESSION["LOGINDEP_MT"] == "DEPT-0040" or $_SESSION["LOGINDEP_MT"] == "DEPT-0094") {
                    ?>
                    <li><a href="panduan/Panduan Aplikasi Maintenance 21r3as423r.pdf" target="_blank"><span class="icon"><i class="fa fa-book fa-lg"></i></span> Buku Panduan</a></li>
                    <?php
                }
                else{
                    ?>
                    <li><a href="panduan/Panduan Aplikasi Maintenance 4yv435624c.pdf" target="_blank"><span class="icon"><i class="fa fa-book fa-lg"></i></span> Buku Panduan</a></li>
                    <?php
                }
                if ($_SESSION["LOGINDEP_MT"] == "DEPT-0040") {
                    ?>
                    <li><a href="parameter"><span class="icon"><i class="fa fa-share-alt"></i></span> Parameter</a></li>
                    <?php
                }
                ?>
                <li class="divider"></li>
                <li><a href="logout"><span class="icon"><i class="ico-exit"></i></span> Sign Out</a></li>
            </ul>
        </li>
        <!-- Profile dropdown -->
      
    </ul>
    <!--/ END Right nav -->
</div>
<!--/ END Toolbar -->