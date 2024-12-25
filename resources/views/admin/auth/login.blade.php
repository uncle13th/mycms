<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <!-- 引入样式 -->
    <link rel="stylesheet" href="https://unpkg.com/element-ui/lib/theme-chalk/index.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .login-container {
            width: 400px;
            padding: 30px;
            background: white;
            border-radius: 4px;
            box-shadow: 0 2px 12px 0 rgba(0,0,0,.1);
        }
        .login-title {
            text-align: center;
            margin-bottom: 30px;
            font-size: 24px;
            color: #303133;
        }
    </style>
</head>
<body>
    <div id="app">
        <div class="login-container">
            <h2 class="login-title">后台管理系统</h2>
            <el-form :model="loginForm" :rules="rules" ref="loginForm" class="login-form" @submit.native.prevent>
                <el-form-item prop="username">
                    <el-input v-model="loginForm.username" placeholder="用户名">
                        <template slot="prepend">
                            <i class="el-icon-user"></i>
                        </template>
                    </el-input>
                </el-form-item>
                <el-form-item prop="password">
                    <el-input v-model="loginForm.password" type="password" placeholder="密码" @keyup.enter.native="submitForm('loginForm')">
                        <template slot="prepend">
                            <i class="el-icon-lock"></i>
                        </template>
                    </el-input>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" @click="submitForm('loginForm')" style="width: 100%">登录</el-button>
                </el-form-item>
            </el-form>
        </div>
    </div>

    <!-- 引入 Vue -->
    <script src="https://unpkg.com/vue@2/dist/vue.js"></script>
    <!-- 引入 Element UI -->
    <script src="https://unpkg.com/element-ui/lib/index.js"></script>
    <!-- 引入 axios -->
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        new Vue({
            el: '#app',
            data() {
                return {
                    loginForm: {
                        username: '',
                        password: '',
                        _token: '{{ csrf_token() }}'
                    },
                    rules: {
                        username: [
                            { required: true, message: '请输入用户名', trigger: 'blur' }
                        ],
                        password: [
                            { required: true, message: '请输入密码', trigger: 'blur' }
                        ]
                    }
                }
            },
            methods: {
                submitForm(formName) {
                    this.$refs[formName].validate((valid) => {
                        if (valid) {
                            axios.post('{{ route("admin.login.submit") }}', this.loginForm)
                                .then(response => {
                                    if (response.data.success) {
                                        window.location.href = response.data.redirect;
                                    }
                                })
                                .catch(error => {
                                    this.$message.error(error.response.data.message || '登录失败');
                                });
                        }
                    });
                }
            }
        })
    </script>
</body>
</html>
