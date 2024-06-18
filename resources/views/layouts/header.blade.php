@include('layouts.css')
@yield('style')
<body class="app sidebar-mini rtl">
<div id="global-loader" ></div>
<div class="page">
    <div class="page-main">
        <div class="app-header header py-1 d-flex">
            <div class="container">
                <div class="d-flex">
                    <!-- <a class="header-brand" href="index.html">
                        <img src="assets/images/brand/logo.png" class="header-brand-img d-none d-sm-block" alt="Spain logo">
                        <img src="assets/images/brand/logo.png" class="header-brand-img-2 d-sm-none" alt="Spain logo">
                    </a> -->
                    <a id="horizontal-navtoggle" class="animated-arrow"><span></span></a>


                    <div class="d-flex order-lg-2 ml-auto ">
                        {{--                                                <form class="form-inline mr-auto">--}}
                        {{--                                                    <div class="search-element">--}}
                        {{--                                                        <input class="form-control" type="search" placeholder="Search" aria-label="Search">--}}
                        {{--                                                        <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>--}}
                        {{--                                                    </div>--}}
                        {{--                                                </form>--}}
                        <div class="dropdown d-none d-md-flex " >
                            <a  class="nav-link icon full-screen-link">
                                <i class="mdi mdi-arrow-expand-all"  id="fullscreen-button"></i>
                            </a>
                        </div>
                        <div class="dropdown d-none d-md-flex" id="notification-dropdown">
                            <a class="nav-link icon" data-toggle="dropdown" >
                                <i class="mdi mdi-bell-outline "></i>
                                <span class="nav-unread bg-success {{auth()->user()->unreadNotifications->count() ? '' : 'hide'}}"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow notificationsList notification">
                                @foreach(auth()->user()->unreadNotifications as $key => $notification)
                                    <a href="{{auth()->user()->getNewOrderUrl().'/'.$notification->data['order_id']}}" class="dropdown-item d-flex pb-3 bg-lime-light">
                                        <div class="notifyimg">
                                            <i class="fa fa-thumbs-o-up"></i>
                                        </div>
                                        <div>
                                            <strong>You have a new order.</strong>
                                            <div class="small text-muted">{{$notification->created_at->diffForHumans()}}</div>
                                        </div>
                                    </a>
                                @endforeach
                                @foreach(auth()->user()->readNotifications as $key => $notification)
                                    <a href="{{auth()->user()->getNewOrderUrl().'/'.$notification->data['order_id']}}" class="dropdown-item d-flex pb-3 ">
                                        <div class="notifyimg">
                                            <i class="fa fa-thumbs-o-up"></i>
                                        </div>
                                        <div>
                                            <strong>You have a new order.</strong>
                                            <div class="small text-muted">{{$notification->created_at->diffForHumans()}}</div>
                                        </div>
                                    </a>
                                    @if($key == 8)
                                        @break
                                    @endif
                                @endforeach
                                <div class="dropdown-divider"></div>
                                <a href="index4.html#" class="dropdown-item text-center">View all Notification</a>
                            </div>
                        </div>

                        <div class="dropdown">
                            <a href="index4.html#" class="nav-link pr-0 leading-none" data-toggle="dropdown">
                                <span class="avatar avatar-md brround"><img src="{{asset('uploads/users-profile/'.\Illuminate\Support\Facades\Auth::user()->avatar)}}" alt="Profile-img" class="avatar avatar-md brround"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow ">
                                <div class="text-center">
                                    <a href="#" class="dropdown-item text-center font-weight-sembold user">{{\Illuminate\Support\Facades\Auth::user()->name}}</a>

                                    <div class="dropdown-divider"></div>
                                </div>
                                <a class="dropdown-item" href="{{route('edit-profile')}}">
                                    <i class="dropdown-icon mdi mdi-account-outline "></i> Profile
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{route('logout')}}">
                                    <i class="dropdown-icon mdi  mdi-logout-variant"></i> Sign out
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--Horizontal-menu-->
@if(auth()->user()->isAdmin())
    @include('layouts.header-bar')
@else
    @include('employee.header-bar')
@endif
