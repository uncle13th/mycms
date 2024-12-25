<div class="sidebar">
    <div class="logo">
        <h1>{{ config('app.name') }}</h1>
    </div>
    <div class="menu">
        <a href="{{ route('admin.dashboard') }}" class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt"></i>
            <span>仪表板</span>
        </a>
        <a href="{{ route('admin.products.index') }}" class="menu-item {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
            <i class="fas fa-box"></i>
            <span>产品管理</span>
        </a>
        <a href="{{ route('admin.categories.index') }}" class="menu-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
            <i class="fas fa-folder"></i>
            <span>分类管理</span>
        </a>
        <a href="{{ route('admin.images.index') }}" class="menu-item {{ request()->routeIs('admin.images.*') ? 'active' : '' }}">
            <i class="fas fa-images"></i>
            <span>图片管理</span>
        </a>
    </div>
</div> 