<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="image float-right">
                <img src="{{  auth()->user()->image ?? url('assets/admin/images/user2-160x160.jpg') }}" class="rounded"
                    alt="User Image">
            </div>
            <div class="info float-right">
                <p>{{ auth()->user()->username ?? auth()->user()->name ?? 'Admin' }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
            <!-- search form -->
            <form action="#" method="get" class="sidebar-form">
                <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="Search...">
                    <span class="input-group-btn">
                        <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i
                                class="fa fa-search"></i>
                        </button>
                    </span>
                </div>
            </form>
            <!-- /.search form -->
        </div>

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="treeview">
                <a class="mlink" href="{{ url("admin") }}">
                    <i class="fa fa-home"></i>
                    <span>@lang('Home')</span>
                </a>
            </li>
       
            @foreach(sidebar() as $role => $group)
            @if(isset($group['link']))
            <li class="treeview">
                <a class="mlink" href="{{ route("admin.".$group['link']) }}">
                    <i class="fa fa-dashboard"></i>
                    <span>{{ $group['title'] }}</span>
                </a>
            </li>
            @else
            <label class='side-title'>{{ $group['title'] }}</label>
            @foreach($group['links'] as $row)
            <li class="treeview">
                @if(isset($row['query']))
                <a href="{{ route('admin.'.$row['link'] , $row['query']) }}" class="mlink">
                    @else
                    <a href="{{ $row['link'] != '#' ? route('admin.'.$row['link']) : '#' }}"
                        class="{{ $row['link'] != '#' ? 'mlink' : '' }}">
                        @endif
                        <i class="{{ $row['icon'] ?? '' }}"></i>
                        <span>{{ $row['title'] }}</span>
                        @if(isset($row['childs']))
                        <span class="pull-left-container">
                            <i class="fa fa-angle-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} pull-left"></i>
                        </span>
                        @endif
                        @if(isset($row['count']))
                        <span class="pull-left-container">
                        <small class="label pull-left  {{ $row['count']['count'] ? 'bg-red' : '' }} {{ $row['count']['class']}}">
                            {{ $row['count']['count'] == 0 ? '' : $row['count']['count'] }}
                        </small>
                        </span>
                        @endif

                    </a>
                    @if(isset($row['childs']))
                    <ul class="treeview-menu">
                        @foreach($row['childs'] as $child)
                        <li>
                            <a href="{{ isset($child['query']) ? route('admin.'.$child['link'] , $child['query']) : route('admin.'.$child['link']) }}"
                                class="mlink">
                                <i class="far fa-circle"></i>
                                {{ $child['title'] }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                    @endif
            </li>
            @endforeach
            @endif
            @endforeach
        </ul>
    </section>
    <!-- /.sidebar -->
    <div class="sidebar-footer">
        <!-- item-->
        <a href="{{ route('admin.settings.app') }}" class="mlink link" data-toggle="tooltip" title=""
            data-original-title="Settings"><i class="fa fa-cog fa-spin"></i></a>
        <!-- item-->
        <a href="{{ route('admin.contactus.index') }}" class="mlink link" data-toggle="tooltip" title=""
            data-original-title="Email"><i class="fa fa-envelope"></i></a>
        <!-- item-->
        <a href="{{ route('logout') }}" class="link" data-toggle="tooltip" title="" data-original-title="Logout"><i
                class="fa fa-power-off"></i></a>
    </div>
</aside>