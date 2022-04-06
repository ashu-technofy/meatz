@php
    $authed_user = auth()->user() ?? auth('stores')->user();
@endphp
<header class="main-header" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
    <!-- Logo -->
    <a href="{{ url('admin') }}" class="logo mlink">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>{{ app_setting('title') ?? 'لوحة التحكم' }}</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        @if($authed_user->role_id)
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        @endif
        <form id="search_form">
            <input type="text" class="form-control" name="keyword" placeholder="{{ __('Search word') }}">
            <i class="fa fa-search"></i>
        </form>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu lang-link">
                    <a href="{{ route("change_locale") }}">
                        <b>{{ app()->getLocale() == 'ar' ? 'EN' : 'عربي' }}</b>
                    </a>
                </li>
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="{{ $authed_user->image ??  url('assets/admin/images/user2-160x160.jpg') }}"
                            class="user-image rounded" alt="User Image">
                    </a>
                    <ul class="dropdown-menu scale-up">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="{{ $authed_user->image ??  url('assets/admin/images/user2-160x160.jpg') }}"
                                class="rounded float-right" alt="User Image">

                            <p>
                                <ul style="list-style-type: none">
                                    <li>
                                        <h3>{{  $authed_user->username ?? $authed_user->name->{app()->getLocale()} ?? '' }}</h3>
                                    </li>
                                    <li>
                                        <span style="color: #999">{{ $authed_user->role->name ?? 'Vendor' }}</span>
                                    </li>
                                </ul>
                            </p>
                        </li>
                        <!-- Menu Body -->

                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-right">
                                @if($authed_user->role_id)
                                <a href="{{ route('admin.users.edit' , $authed_user->id) }}"
                                    class="btn btn-block btn-primary mlink">@lang('My information')</a>
                                @else
                                <a href="{{ route('admin.stores.edit' , $authed_user->id) }}"
                                    class="btn btn-block btn-primary mlink">@lang('My information')</a>
                                @endif
                            </div>
                            <div class="pull-left">
                                <a href="{{ url('logout') }}" class="btn btn-block btn-danger">@lang('Logout')</a>
                            </div>
                        </li>
                    </ul>
                </li>
                @if($authed_user->role_id)
                <!-- Messages: style can be found in dropdown.less-->
                <li class="dropdown messages-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-envelope"></i>
                        @php $messages = \Modules\Contactus\Models\Contactus::where('seen' , null); @endphp
                        @if($messages->count())
                        <span class="label label-success messages_count">{{ $messages->count() }}</span>
                        @endif
                    </a>
                    <ul class="dropdown-menu scale-up">
                        <li class="header">{{ __("You have :num messages" , ['num' => $messages->count() ]) }}</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu inner-content-div">
                                @foreach($messages->latest()->take(5)->get() as $row)
                                <li>
                                    <!-- start message -->
                                    <a class="mlink" href="{{ route('admin.contactus.show' , $row->id) }}">
                                        <div class="pull-right">
                                            <img src="{{ url('assets/admin') }}/images/user2-160x160.jpg"
                                                class="rounded-circle" alt="User Image">
                                        </div>
                                        <div class="mail-contnet">
                                            <h4>
                                                {{ $row->name }}
                                                <small style="position: static;"><i class="fa fa-clock-o"></i> {{ $row->time_ago }}</small>
                                            </h4>
                                            <span>{{ $row->short_message }}</span>
                                        </div>
                                    </a>
                                </li>
                                <!-- end message -->
                                @endforeach

                            </ul>
                        </li>
                        <li class="footer"><a class="mlink" href="{{ route('admin.contactus.index') }}">@lang('View
                                all')</a></li>
                    </ul>
                </li>
                @endif
                <!-- Notifications: style can be found in dropdown.less -->
                <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-bell"></i>
                        @php 
                        $orders = \Modules\Orders\Models\Order::forStore()->notseen();
                        @endphp
                        @if($orders->count())
                        <span class="label label-warning orders_counter">{{ $orders->count() }}</span>
                        @endif
                    </a>
                    <ul class="dropdown-menu scale-up">
                        <li class="header">@lang("You have :num new orders" , ['num' => $orders->count()])</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu inner-content-div">
                                @foreach($orders->latest()->take(5)->get() as $row)
                                <li>
                                    <a class="mlink" href="{{ route('admin.orders.show' , $row->id) }}">
                                        <ul style="list-style-type: none">
                                            <li>
                                                <i class="fa fa-users text-aqua"></i> {{ $row->user->username ?? '#' }}
                                            </li>
                                            <li>
                                                <i class="fa fa-money"></i>
                                                {{ $row->total ?? '#' }} @lang('KD')
                                            </li>
                                            <li>
                                                <i class="fa fa-clock"></i> {{ $row->created_at }}
                                            </li>
                                        </ul>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </li>
                        <li class="footer"><a class="mlink"
                                href="{{ route('admin.orders.index') }}">@lang('View all')</a></li>
                    </ul>
                </li>


                <!-- Control Sidebar Toggle Button -->
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-cog fa-spin"></i></a>
                </li>
            </ul>
        </div>
    </nav>
</header>


<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
    </ul>
    <!-- Tab panes -->
    <div class="tab-content" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
        <!-- Home tab content -->
        <div class="tab-pane" id="control-sidebar-home-tab">

        </div>

    </div>
</aside>
<!-- /.control-sidebar -->

<!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
<div class="control-sidebar-bg"></div>