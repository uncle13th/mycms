<div class="header">
    <div class="header-left">
        <span class="trigger">
            <i class="fas fa-bars"></i>
        </span>
        <div class="breadcrumb">
            @yield('breadcrumb')
        </div>
    </div>
    <div class="header-right">
        <div class="user-dropdown">
            <div class="user-info">
                <span>{{ auth()->user()->name }}</span>
                <i class="fas fa-chevron-down"></i>
            </div>
            <div class="dropdown-menu">
                <a href="#" class="dropdown-item">
                    <i class="fas fa-user"></i>
                    <span>个人信息</span>
                </a>
                <a href="{{ route('admin.password.show') }}" class="dropdown-item">
                    <i class="fas fa-key"></i>
                    <span>修改密码</span>
                </a>
                <div class="dropdown-divider"></div>
                <form method="POST" action="{{ route('admin.logout') }}" style="display: contents;">
                    @csrf
                    <button type="submit" class="dropdown-item" style="width: 100%; border: none; background: none; cursor: pointer;">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>退出登录</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div> 