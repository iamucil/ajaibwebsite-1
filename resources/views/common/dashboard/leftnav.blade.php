<!-- Right sidemenu -->

<div id="skin-select" class="fixed-nest ">
    <!--      Toggle sidemenu icon button -->
    <a id="toggle">
        <span class="fa icon-menu"></span>
    </a>
    <!--      End of Toggle sidemenu icon button -->

    <div class="skin-part fixed-ajaib-sidemenu">
        <div id="tree-wrap">
            <!-- Profile -->
            <div class="profile">
                <img alt="logo" class="" src="{{ asset('/img/logo.png') }}">
                <h3>AJAIB <small>Beta</small></h3>
            </div>
            <!-- End of Profile -->

            <!-- Menu sidebar begin-->
            <div class="side-bar">
                <ul id="menu-showhide" class="topnav slicknav">
                    <li>
                        <a id="menu-select" class="tooltip-tip" href="{{ route('admin::dashboard') }}" title="Dashboard">
                            <i class="icon-monitor"></i>
                            <span>Dashboard</span>

                        </a>

                    </li>
                    @if (Auth::user()->hasRole(['root', 'admin']))
                        <li>
                            <a class="tooltip-tip" href="#" title="Mail">
                                <i class="icon-user-group"></i>
                                <span>User Management</span>

                            </a>
                            <ul>
                                <li>
                                    <a href="{{ route('user.list') }}" title="Inbox">Users
                                        <div class="noft-blue bg-red" style="display: inline-block; float: none;">Users</div>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a class="tooltip-tip" href="#" title="Mail">
                                <i class="fontello-chat-alt"></i>
                                <span>Chat</span>

                            </a>
                            <ul>
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
                            <a class="tooltip-tip" href="#" title="Mail">
                                <i class="fontello-users-outline"></i>
                                <span>Partners</span>

                            </a>
                            <ul>
                                <li>
                                    <a href="{{ route('vendor.index') }}" title="Inbox">Vendors
                                        <div class="noft-blue bg-red" style="display: inline-block; float: none;">Daftar Merchant</div>
                                    </a>
                                </li>
                                <li>

                                    <a href="#" title="Compose">Reports</a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a class="tooltip-tip" href="#" title="Mail">
                                <i class="fontello-vcard"></i>
                                <span>KPI Management</span>

                            </a>
                            <ul>
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
                            <a class="tooltip-tip" href="#" title="Mail">
                                <i class="fontello-tag"></i>
                                <span>Transactions</span>

                            </a>
                            <ul>
                                <li>
                                    <a href="{{ route('transaction.category.index') }}" title="Inbox">Transactions
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
                            <a class="tooltip-tip" href="#" title="UI">
                                <i class="icon-align-justify"></i>
                                    <span>Chat&nbsp;
                                <small class="side-menu-noft">Chating</small></span>
                            </a>
                        </li>
                        <li>
                            <a class="tooltip-tip" href="#" title="Transaction">
                                <i class="fontello-tag"></i>
                                <span>Transactions</span>

                            </a>
                            <ul>
                                <li>
                                    <a href="#" title="Inbox">Categories
                                        <div class="noft-blue bg-red" style="display: inline-block; float: none;">Transaction</div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" title="Compose">Reports</a>
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
            <!-- end of Menu sidebar  -->
            {{-- <ul class="bottom-list-menu">
                <li>Help <span class="icon-phone"></span>
                </li>
                <li>About Edumix <span class="icon-music"></span>
                </li>
            </ul> --}}
        </div>
    </div>
</div>
<!-- end of Rightsidemenu -->

