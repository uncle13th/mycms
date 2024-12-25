<div class="header">
    <div class="header-left">
        <div class="breadcrumb">
            @yield('breadcrumb')
        </div>
    </div>
    <div class="header-right">
        <div class="user-dropdown">
            <div class="user-info">
                <span>{{ auth()->user()->username }}</span>
                <i class="fas fa-chevron-down"></i>
            </div>
            <div class="dropdown-menu">
                <a href="{{ route('admin.password.show') }}" class="dropdown-item">
                    <i class="fas fa-key"></i>
                    修改密码
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item" 
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    退出登录
                </a>
            </div>
        </div>
        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
</div> 