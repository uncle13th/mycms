<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', '后台管理系统')</title>
    <link rel="stylesheet" href="https://unpkg.com/element-ui/lib/theme-chalk/index.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        html, body {
            height: 100%;
            overflow: hidden;
        }
        #app {
            height: 100%;
            overflow: hidden;
        }
        .sidebar {
            width: 220px;
            height: 100vh;
            background-color: #304156;
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            overflow-y: auto;
            z-index: 1001;
        }
        .main-container {
            margin-left: 220px;
            min-height: 100vh;
            position: relative;
        }
        .el-menu {
            border-right: none;
        }
        .header {
            height: 60px;
            background-color: #fff;
            border-bottom: 1px solid #e6e6e6;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
            position: fixed;
            top: 0;
            right: 0;
            left: 220px;
            z-index: 1000;
        }
        .main-content {
            margin-top: 60px;
            padding: 20px;
            background-color: #f0f2f5;
            min-height: calc(100vh - 60px);
            overflow-y: auto;
        }
        .logo {
            height: 60px;
            line-height: 60px;
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            color: #fff;
            background-color: #2b2f3a;
        }
        .user-info {
            display: flex;
            align-items: center;
            cursor: pointer;
        }
        .el-dropdown-link {
            color: #606266;
        }
    </style>
    @stack('styles')
</head>
<body>
    <div id="app">
        <!-- 左侧菜单 -->
        <div class="sidebar">
            <div class="logo">后台管理系统</div>
            <el-menu
                :default-active="activeMenu"
                background-color="#304156"
                text-color="#bfcbd9"
                active-text-color="#409EFF"
                :unique-opened="true"
                :router="true">
                <el-menu-item index="/admin/dashboard">
                    <i class="el-icon-s-home"></i>
                    <span slot="title">仪表盘</span>
                </el-menu-item>
                <el-submenu index="1">
                    <template slot="title">
                        <i class="el-icon-s-management"></i>
                        <span>系统管理</span>
                    </template>
                    <el-menu-item index="/admin/users">用户管理</el-menu-item>
                    <el-menu-item index="/admin/roles">角色管理</el-menu-item>
                    <el-menu-item index="/admin/permissions">权限管理</el-menu-item>
                </el-submenu>
            </el-menu>
        </div>

        <!-- 右侧内容 -->
        <div class="main-container">
            <!-- 顶部导航 -->
            <div class="header">
                <el-breadcrumb separator="/">
                    <el-breadcrumb-item :to="{ path: '/admin/dashboard' }">首页</el-breadcrumb-item>
                    <el-breadcrumb-item>@yield('breadcrumb', '仪表盘')</el-breadcrumb-item>
                </el-breadcrumb>

                <div class="user-info">
                    <el-dropdown trigger="click" @command="handleCommand">
                        <span class="el-dropdown-link">
                            {{ Auth::guard('admin')->user()->name }}
                            <i class="el-icon-arrow-down el-icon--right"></i>
                        </span>
                        <el-dropdown-menu slot="dropdown">
                            <el-dropdown-item command="profile">个人信息</el-dropdown-item>
                            <el-dropdown-item command="logout">退出登录</el-dropdown-item>
                        </el-dropdown-menu>
                    </el-dropdown>
                </div>
            </div>

            <!-- 主要内容 -->
            <div class="main-content">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/vue@2/dist/vue.js"></script>
    <script src="https://unpkg.com/element-ui/lib/index.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        // 设置 axios 默认值
        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
        axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        new Vue({
            el: '#app',
            data() {
                return {
                    activeMenu: window.location.pathname
                }
            },
            methods: {
                handleCommand(command) {
                    if (command === 'logout') {
                        this.$confirm('确认退出登录吗？', '提示', {
                            confirmButtonText: '确定',
                            cancelButtonText: '取消',
                            type: 'warning'
                        }).then(() => {
                            axios.post('{{ route("admin.logout") }}')
                                .then(() => {
                                    window.location.href = '{{ route("admin.login") }}';
                                });
                        }).catch(() => {});
                    }
                }
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
