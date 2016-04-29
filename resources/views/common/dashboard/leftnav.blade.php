<a class="gn-icon gn-icon-menu"><i class="small material-icons">playlist_add</i></a>
<div class="gn-menu-wrapper">
    <div class="gn-scroller">
        <ul class="gn-menu">
            <li>
                <a id="menu-select" class="gn-icon gn-icon-none" href="{{ route('admin::dashboard') }}" title="Dashboard">
                    <i class="icon-monitor"></i>
                    <span>Dashboard</span>
                </a>

            </li>
            @if (Auth::user()->hasRole(['root', 'admin']))
                <li>
                    <a class="gn-icon gn-icon-none" href="#" title="Mail">
                        <i class="icon-user-group"></i>
                        <span>User Management</span>

                    </a>
                    <ul class="gn-submenu">
                        <li>
                            <a ng-href="/users" title="Inbox">
                                <div class="noft-blue bg-red" style="display: inline-block; float: none;">Users</div>
                            </a>
                        </li>
                        <li>
                            <a href="/menus" title="Menu Management">Menu</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a class="gn-icon gn-icon-none" href="#" title="Mail">
                        <i class="fontello-chat-alt"></i>
                        <span>Chat</span>

                    </a>
                    <ul class="gn-submenu">
                        <li>
                            <a href="#" title="Inbox">Inbox
                                <div class="noft-blue bg-red" style="display: inline-block; float: none;">Live Chat Monitoring</div>
                            </a>
                        </li>
                        <li>

                            <a href="#" title="Compose">Online Users</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a class="gn-icon gn-icon-none" href="#" title="Mail">
                        <i class="fontello-users-outline"></i>
                        <span>Partners</span>

                    </a>
                    <ul class="gn-submenu">
                        <li>
                            <a href="/vendors" title="Inbox">Vendors
                                <div class="noft-blue bg-red" style="display: inline-block; float: none;">Daftar Merchant</div>
                            </a>
                        </li>
                        <li>

                            <a href="#" title="Compose">Reports</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a class="gn-icon gn-icon-none" href="#" title="Mail">
                        <i class="fontello-vcard"></i>
                        <span>KPI Management</span>

                    </a>
                    <ul class="gn-submenu">
                        <li>
                            <a href="#" title="Inbox">Inbox
                                <div class="noft-blue bg-red" style="display: inline-block; float: none;">Operators</div>
                            </a>
                        </li>
                        <li>

                            <a href="#" title="Compose">Partners</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a class="gn-icon gn-icon-none" href="#" title="Mail">
                        <i class="fontello-tag"></i>
                        <span>Transactions</span>
                    </a>
                    <ul class="gn-submenu">
                        <li>
                            <a href="/transactions" title="Inbox">Transactions
                                <div class="noft-blue bg-red" style="display: inline-block; float: none;">Categories</div>
                            </a>
                        </li>
                        <li>
                            <a href="#" title="Compose">Reports</a>
                        </li>
                    </ul>
                </li>
            @elseif (Auth::user()->hasRole('operator'))
                <li>
                    <a class="gn-icon gn-icon-none" href="#" title="UI">
                        <i class="icon-align-justify"></i>
                            <span>Chat
                        <small class="side-menu-noft">Chating</small></span>
                    </a>
                </li>
                <li>
                    <a class="gn-icon gn-icon-none" href="#" title="Transaction">
                        <i class="fontello-tag"></i>
                        <span>Transactions</span>

                    </a>
                    <ul class="gn-submenu">
                        <li>
                            <a href="/transactions" title="Inbox">Transactions
                                <div class="noft-blue bg-red" style="display: inline-block; float: none;">Categories</div>
                            </a>
                        </li>
                        <li>
                            <a href="#" title="Compose">Reports</a>
                        </li>
                    </ul>
                </li>
            @endif
            
            <li>
                <a class="gn-icon gn-icon-download">Downloads</a>
                <ul class="gn-submenu">
                    <li><a>Vector Illustrations</a></li>
                    <li><a>Photoshop files</a></li>
                </ul>
            </li>
            {{-- 
            <li><a class="gn-icon gn-icon-cog">Settings</a></li>
            <li><a class="gn-icon gn-icon-help">Help</a></li>
            <li>
                <a class="gn-icon gn-icon-archive">Archives</a>
                <ul class="gn-submenu">
                    <li><a class="">Articles</a></li>
                    <li><a>Images</a></li>
                    <li><a>Images</a></li>
                    <li><a>Images</a></li>
                    <li><a>Images</a></li>
                    <li><a>Images</a></li>
                    <li><a>Images</a></li>
                    <li><a>Images</a></li>
                    <li><a>Images</a></li>
                    <li><a>Images</a></li>
                    <li><a>Images</a></li>
                    <li><a>Images</a></li>
                    <li><a>Images</a></li>
                    <li><a>Images</a></li>
                    <li><a>Images</a></li>
                    <li><a>Images</a></li>
                    <li><a>Images</a></li>
                    <li><a>Images</a></li>
                    <li><a>Images</a></li>
                    <li><a>Images</a></li>
                    <li><a>Images</a></li>
                    <li><a>Images</a></li>
                    <li><a>Images</a></li>
                    <li><a>Images</a></li>
                    <li><a>Images</a></li>
                    <li><a>Images</a></li>
                    <li><a>Images</a></li>
                    <li><a>Images</a></li>
                    <li><a>Images</a></li>
                    <li><a>Images</a></li>
                    <li><a>Images</a></li>
                    <li><a>Images</a></li>
                    <li><a>Images</a></li>
                    <li><a>Images</a></li>
                    <li><a>Images</a></li>
                    <li><a>Images</a></li>
                    <li><a>Images</a></li>
                    <li><a>Images</a></li>
                    <li><a>Images</a></li>
                    <li><a>Images</a></li>
                    <li><a>Images</a></li>
                    <li><a>Images</a></li>
                </ul>
            </li>
            --}}
        </ul>
    </div>
    <!-- /gn-scroller -->
</div>