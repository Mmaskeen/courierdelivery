<div class="horizontal-main clearfix">
    <div class="horizontal-mainwrapper container clearfix">
        <nav class="horizontalMenu clearfix">
            <ul class="horizontalMenu-list">
                <li aria-haspopup="true"><a href="{{route('admin_dashboard')}}" class="sub-icon"><i class="fa fa-desktop"></i> Home </a>

                </li>
                <li aria-haspopup="true"><a href="javascript:void(0);" class="sub-icon"><i class="fa fa-truck"></i> Orders<i class="fa fa-angle-down ml-2 mr-0"></i></a>
                    <ul class="sub-menu">
                        <li aria-haspopup="true"><a href="{{route('admin_all_order')}}">All Orders</a></li>
                        <li aria-haspopup="true"><a href="{{route('admin_trashed_order')}}">Trashed Orders</a></li>
                    </ul>
                </li>
                <li aria-haspopup="true"><a href="{{route('admin_add_order')}}" class="sub-icon"><i class="fa fa-shopping-cart"></i> Add New Order </a></li>

                    <li aria-haspopup="true"><a href="{{route('admin_all_user')}}" class="sub-icon"><i class="mdi mdi-account-multiple-outline"></i> All Users </a></li>
                    <li aria-haspopup="true"><a href="{{route('admin_add_user')}}" class="sub-icon"><i class="mdi mdi-account-plus"></i> Add New User </a></li>
                <li aria-haspopup="true"><a href="javascript:void(0);" class="sub-icon"><i class="mdi mdi-city"></i> Cities </a>
                    <ul class="sub-menu">
                        <li aria-haspopup="true"><a href="{{route('admin_add_city')}}">Add City</a></li>
                        <li aria-haspopup="true"><a href="{{route('admin_all_city')}}">All City</a></li>
                    </ul>
                </li>
                <li aria-haspopup="true"><a href="javascript:void(0);" class="sub-icon"><i class="mdi mdi-city"></i> Riders </a>
                    <ul class="sub-menu">
                        <li aria-haspopup="true"><a href="{{route('admin_add_rider')}}">Add Rider</a></li>
                        <li aria-haspopup="true"><a href="{{route('admin_all_rider')}}">All Rider</a></li>
                    </ul>
                </li>
                    <li aria-haspopup="true"><a href="{{route('admin_report')}}" class="sub-icon"><i class="mdi mdi-file-account"></i> Reports </a></li>
            </ul>
        </nav>
        <!--Menu HTML Code-->
    </div>
</div>
