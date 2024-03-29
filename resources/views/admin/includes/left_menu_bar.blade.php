<section>
    <!-- Left Sidebar -->
    <aside id="leftsidebar" class="sidebar">
        <!-- User Info -->
        <div class="user-info">
            <div class="info-container">
                <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{!! Auth::user()->full_name !!}</div>
                <div class="email">
                    {!! Auth::user()->email !!}
                </div>
                <div class="btn-group user-helper-dropdown">
                    <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                    <ul class="dropdown-menu pull-right">
                        <li><a href="{!! URL::to('logout') !!}"><i class="material-icons">input</i>Sign Out</a></li>
                        <li role="seperator" class="divider"></li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- #User Info -->
        <!-- Menu -->
        <div class="menu">
            <ul class="list">
                <li class="header">MAIN NAVIGATION</li>
                <li class="active">
                    <a href="{!! url('/') !!}">
                        <i class="material-icons">home</i>
                        <span>Home</span>
                    </a>
                </li>
                @if(\App\Models\TeamLeader::where('user_id',auth()->user()->id)->first())
                    <li class="">
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">perm_identity</i>
                            <span>Team Leave</span>
                        </a>
                        <ul class="ml-menu">
                            <li class=""><a href="{!! url('module/mange_team_leave') !!}">Team Leave application</a></li>
                            <li class=""><a href="{!! url('module/team_leave_balance') !!}">Team Leave Balance</a></li>
                        </ul>
                    </li>
                @endif
                @if(auth()->user()->employee->designation == 'CEO')
                    <li class="">
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">perm_identity</i>
                            <span>TL Leave</span>
                        </a>
                        <ul class="ml-menu">
                            <li class=""><a href="{!! url('module/manage_tl_leave') !!}">TL Leave application</a></li>
                            <li class=""><a href="{!! url('module/tl_leave_balance') !!}">TL Leave Balance</a></li>
                        </ul>
                    </li>
                @endif
                @foreach(menu_array() as $i=>$item)

                    @if($item['role_id'] == Auth::user()->role_id)
                        @if(isset($item['sub']))
                            <li class="">
                                <a href="javascript:void(0);" class="menu-toggle">
                                    <i class="material-icons">{!! $item['icon'] !!}</i>
                                    <span>{!! $item['label'] !!}</span>
                                </a>
                                <ul class="ml-menu">
                                    @foreach($item['sub'] as $sub_item)
                                        <li class="">
                                            <a href="{!! $sub_item['link'] !!}">{!! $sub_item['label'] !!}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @else
                            <li class="">
                                <a href="{!! $item['link'] !!}">
                                    <i class="material-icons">{!! $item['icon'] !!}</i>
                                    <span>{!! $item['label'] !!}</span>
                                </a>
                            </li>
                        @endif
                    @endif
                @endforeach

            </ul>
        </div>
        <!-- #Menu -->
        <!-- Footer -->
        <div class="legal">
            <div class="copyright">
                &copy; 2018 <a href="https://bikroy.com/">Bikroy Digital</a>
            </div>
        </div>
        <!-- #Footer -->
    </aside>
    <!-- #END# Left Sidebar -->
</section>
