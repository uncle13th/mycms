<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>仪表板 - {{ config('app.name') }}</title>
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
        }

        .layout {
            display: flex;
            min-height: 100vh;
        }

        /* 侧边栏样式 */
        .sidebar {
            width: 240px;
            background: #001529;
            color: #fff;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
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

        /* 主要内容区域样式 */
        .main-content {
            flex: 1;
            margin-left: 240px;
            padding: 24px;
        }

        /* 顶部导航栏样式 */
        .header {
            background: #fff;
            padding: 0 24px;
            height: 64px;
            position: fixed;
            top: 0;
            right: 0;
            left: 240px;
            z-index: 1000;
            box-shadow: 0 1px 4px rgba(0,21,41,.08);
            display: flex;
            align-items: center;
            justify-content: space-between;
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
            margin-left: auto;
        }

        .user-info {
            margin-right: 16px;
        }

        .logout-btn {
            color: #666;
            cursor: pointer;
            transition: color 0.3s;
        }

        .logout-btn:hover {
            color: #1890ff;
        }

        /* 统计卡片样式 */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 24px;
            margin-top: 88px;
        }

        .stat-card {
            background: #fff;
            padding: 24px;
            border-radius: 4px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.06);
        }

        .stat-card h3 {
            color: #666;
            font-size: 14px;
            margin-bottom: 16px;
        }

        .stat-value {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 8px;
        }

        .stat-trend {
            font-size: 14px;
            color: #52c41a;
        }

        .stat-trend.down {
            color: #ff4d4f;
        }

        /* 图表容器样式 */
        .charts-container {
            margin-top: 24px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(500px, 1fr));
            gap: 24px;
        }

        .chart-card {
            background: #fff;
            padding: 24px;
            border-radius: 4px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.06);
        }

        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .chart-title {
            font-size: 16px;
            color: #333;
        }

        .chart-actions {
            display: flex;
            gap: 8px;
        }

        .chart-action {
            padding: 4px 8px;
            border: 1px solid #d9d9d9;
            border-radius: 2px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .chart-action:hover {
            color: #1890ff;
            border-color: #1890ff;
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
            cursor: pointer;
            padding: 0 8px;
            height: 64px;
        }

        .user-info:hover {
            background: rgba(0,0,0,.025);
        }

        .user-info i.fa-chevron-down {
            margin-left: 8px;
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
        }

        .user-dropdown:hover .dropdown-menu {
            display: block;
        }

        .dropdown-item {
            padding: 8px 16px;
            display: flex;
            align-items: center;
            color: #666;
            text-decoration: none;
            transition: all 0.3s;
            font-family: "Helvetica Neue", Helvetica, "PingFang SC", "Hiragino Sans GB", "Microsoft YaHei", "微软雅黑", Arial, sans-serif;
            font-size: 14px;
            border: none;
            background: none;
            width: 100%;
            cursor: pointer;
            text-align: left;
        }

        .dropdown-item:hover {
            background: #f5f5f5;
            color: #1890ff;
        }

        .dropdown-item i {
            margin-right: 8px;
            width: 16px;
            text-align: center;
        }

        .dropdown-item span {
            flex: 1;
        }

        .dropdown-divider {
            height: 1px;
            background: #f0f0f0;
            margin: 4px 0;
        }
    </style>
</head>
<body>
    <div class="layout">
        <!-- 侧边栏 -->
        <div class="sidebar">
            <div class="logo">
                <h1>{{ config('app.name') }}</h1>
            </div>
            <div class="menu">
                <div class="menu-item active">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>仪表板</span>
                </div>
                <div class="menu-item">
                    <i class="fas fa-users"></i>
                    <span>用户管理</span>
                </div>
                <div class="menu-item">
                    <i class="fas fa-cog"></i>
                    <span>系统设置</span>
                </div>
                <div class="menu-item">
                    <i class="fas fa-file-alt"></i>
                    <span>内容管理</span>
                </div>
            </div>
        </div>

        <!-- 主要内容区域 -->
        <div class="main-content">
            <!-- 顶部导航栏 -->
            <div class="header">
                <div class="header-left">
                    <span class="trigger">
                        <i class="fas fa-bars"></i>
                    </span>
                    <div class="breadcrumb">
                        <span>仪表板</span>
                        <i class="fas fa-chevron-right"></i>
                        <span>概览</span>
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
                            <a href="#" class="dropdown-item">
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

            <!-- 统计卡片 -->
            <div class="stats-container">
                <div class="stat-card">
                    <h3>总用户数</h3>
                    <div class="stat-value">1,234</div>
                    <div class="stat-trend">
                        <i class="fas fa-arrow-up"></i> 12% 较上周
                    </div>
                </div>
                <div class="stat-card">
                    <h3>今日访问量</h3>
                    <div class="stat-value">423</div>
                    <div class="stat-trend">
                        <i class="fas fa-arrow-up"></i> 5% 较昨日
                    </div>
                </div>
                <div class="stat-card">
                    <h3>内容数量</h3>
                    <div class="stat-value">89</div>
                    <div class="stat-trend">
                        <i class="fas fa-arrow-up"></i> 8% 较上月
                    </div>
                </div>
                <div class="stat-card">
                    <h3>系统消息</h3>
                    <div class="stat-value">12</div>
                    <div class="stat-trend down">
                        <i class="fas fa-arrow-down"></i> 2% 较昨日
                    </div>
                </div>
            </div>

            <!-- 图表区域 -->
            <div class="charts-container">
                <div class="chart-card">
                    <div class="chart-header">
                        <h3 class="chart-title">访问趋势</h3>
                        <div class="chart-actions">
                            <span class="chart-action">今日</span>
                            <span class="chart-action">本周</span>
                            <span class="chart-action">本月</span>
                        </div>
                    </div>
                    <div id="visits-chart" style="height: 300px;">
                        <!-- 这里可以集成 ECharts 等图表库 -->
                    </div>
                </div>
                <div class="chart-card">
                    <div class="chart-header">
                        <h3 class="chart-title">用户分布</h3>
                        <div class="chart-actions">
                            <span class="chart-action">详情</span>
                        </div>
                    </div>
                    <div id="users-chart" style="height: 300px;">
                        <!-- 这里可以集成 ECharts 等图表库 -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
