<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - {{ config('app.name') }}</title>
    <link href="https://cdn.bootcdn.net/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Helvetica Neue", Helvetica, "PingFang SC", "Hiragino Sans GB", "Microsoft YaHei", "微软雅黑", Arial, sans-serif;
            background: #f0f2f5;
            color: #333;
            height: 100vh;
            overflow: hidden;
        }

        /* 整体布局 */
        .app-container {
            display: flex;
            height: 100vh;
        }

        /* 侧边栏样式 */
        .sidebar {
            width: 240px;
            background: #001529;
            color: #fff;
            height: 100vh;
            overflow-y: auto;
            flex-shrink: 0;
        }

        /* 主要内容区域 */
        .main-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        /* 顶部导航栏 */
        .header {
            height: 64px;
            background: #fff;
            box-shadow: 0 1px 4px rgba(0,21,41,.08);
            display: flex;
            align-items: center;
            justify-content: space-between; /* 两端对齐 */
            padding: 0 24px;
            flex-shrink: 0;
        }

        /* 内容区域容器 */
        .content-container {
            flex: 1;
            overflow: auto;
            padding: 24px;
        }

        .logo {
            height: 64px;
            padding: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .logo h1 {
            color: #fff;
            font-size: 20px;
            margin: 0;
        }

        .menu {
            padding: 16px 0;
        }

        .menu-item {
            padding: 12px 24px;
            display: flex;
            align-items: center;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            color: #fff;
        }

        .menu-item:hover {
            background: #1890ff;
        }

        .menu-item.active {
            background: #1890ff;
        }

        .menu-item i {
            margin-right: 10px;
            width: 16px;
            text-align: center;
        }

        .header-left {
            display: flex;
            align-items: center;
        }

        .trigger {
            font-size: 18px;
            cursor: pointer;
            transition: color 0.3s;
            padding: 0 24px;
        }

        .trigger:hover {
            color: #1890ff;
        }

        .header-right {
            display: flex;
            align-items: center;
        }

        /* 面包屑导航样式 */
        .breadcrumb {
            display: flex;
            align-items: center;
            font-size: 14px;
            color: #666;
        }
        
        .breadcrumb i {
            margin: 0 8px;
            font-size: 12px;
            color: #999;
        }

        /* 用户下拉菜单样式 */
        .user-dropdown {
            position: relative;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            padding: 0 12px;
            height: 64px;
            transition: background-color 0.3s;
        }

        .user-info:hover {
            background: rgba(0,0,0,.025);
        }

        .user-info span {
            font-size: 14px;
            color: #666;
        }

        .user-info i {
            font-size: 12px;
            color: #999;
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            background: #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
            border-radius: 4px;
            padding: 4px 0;
            min-width: 160px;
            display: none;
            z-index: 1000;
        }

        .user-dropdown:hover .dropdown-menu {
            display: block;
        }

        .dropdown-item {
            padding: 8px 16px;
            display: flex;
            align-items: center;
            gap: 8px;
            color: #666;
            text-decoration: none;
            transition: all 0.3s;
            font-size: 14px;
        }

        .dropdown-item:hover {
            background: #f5f5f5;
            color: #1890ff;
        }

        .dropdown-divider {
            height: 1px;
            background: #f0f0f0;
            margin: 4px 0;
        }

        /* 页面内容区域 */
        .page-content {
            margin-top: 88px;
            background: #fff;
            padding: 24px;
            border-radius: 4px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.06);
        }

        /* Alert 样式 */
        .alert {
            padding: 10px 15px;
            border-radius: 4px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-success {
            background-color: #f0f9eb;
            color: #67c23a;
            border: 1px solid #e1f3d8;
        }

        .alert-danger {
            background-color: #fef0f0;
            color: #f56c6c;
            border: 1px solid #fde2e2;
        }
    </style>
    @yield('styles')
</head>
<body>
    <div class="app-container">
        @include('admin.partials.sidebar')
        <div class="main-container">
            @include('admin.partials.header')
            <div class="content-container">
                @yield('content')
            </div>
        </div>
    </div>
    @yield('scripts')
</body>
</html>
