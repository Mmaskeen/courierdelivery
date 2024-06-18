<div class="horizontal-main clearfix">
    <div class="horizontal-mainwrapper container clearfix">
        <nav class="horizontalMenu clearfix">
            <ul class="horizontalMenu-list">
                <li aria-haspopup="true"><a href="{{route('employee_dashboard')}}" class="sub-icon"><i class="fa fa-desktop"></i> Home </a>

                </li>
                <li aria-haspopup="true"><a href="javascript:void(0);" class="sub-icon"><i class="fa fa-truck"></i> Orders<i class="fa fa-angle-down ml-2 mr-0"></i></a>
                    <ul class="sub-menu">
                        <li aria-haspopup="true"><a href="{{route('employee_all_order')}}">All Orders</a></li>
                        <li aria-haspopup="true"><a href="{{route('employee_trashed_order')}}">Trashed Orders</a></li>
                    </ul>
                </li>
                <li aria-haspopup="true"><a href="{{route('employee_add_order')}}" class="sub-icon"><i class="fa fa-shopping-cart"></i> Add New Order </a></li>
                <li aria-haspopup="true"><a href="javascript:void(0);" class="sub-icon"><i class="mdi mdi-city"></i> Cities </a>
                    <ul class="sub-menu">
                        <li aria-haspopup="true"><a href="{{route('employee_add_city')}}">Add City</a></li>
                        <li aria-haspopup="true"><a href="{{route('employee_all_city')}}">All City</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!--Menu HTML Code-->
    </div>
</div>
