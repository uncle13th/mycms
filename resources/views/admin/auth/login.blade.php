<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} - 管理员登录</title>
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
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-container {
            background: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 2px 12px 0 rgba(0, 0, 0, 0.1);
            width: 400px;
        }
        .login-header {
            text-align: center;
            margin-bottom: 40px;
        }
        .login-header h1 {
            color: #333;
            font-size: 28px;
            margin-bottom: 10px;
        }
        .form-group {
            margin-bottom: 20px;
            position: relative;
        }
        .form-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #909399;
        }
        .form-control {
            width: 100%;
            height: 40px;
            line-height: 40px;
            padding: 0 15px 0 40px;
            border: 1px solid #dcdfe6;
            border-radius: 4px;
            color: #606266;
            transition: all 0.3s;
        }
        .form-control:focus {
            border-color: #409eff;
            outline: none;
            box-shadow: 0 0 0 2px rgba(64, 158, 255, 0.2);
        }
        .btn-submit {
            width: 100%;
            height: 40px;
            background: #409eff;
            border: none;
            border-radius: 4px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s;
        }
        .btn-submit:hover {
            background: #66b1ff;
        }
        .remember-me {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .remember-me input {
            margin-right: 5px;
        }
        .alert {
            padding: 10px 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .alert-danger {
            background-color: #fef0f0;
            color: #f56c6c;
            border: 1px solid #fde2e2;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1>{{ config('app.name') }}</h1>
        </div>
        
        @if($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login') }}">
            @csrf
            <div class="form-group">
                <i class="fas fa-user"></i>
                <input type="text" 
                       name="username" 
                       class="form-control" 
                       placeholder="用户名" 
                       value="{{ old('username') }}" 
                       required 
                       autofocus>
            </div>

            <div class="form-group">
                <i class="fas fa-lock"></i>
                <input type="password" 
                       name="password" 
                       class="form-control" 
                       placeholder="密码" 
                       required>
            </div>

            <div class="remember-me">
                <label>
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    记住我
                </label>
            </div>

            <button type="submit" class="btn-submit">
                登 录
            </button>
        </form>
    </div>
</body>
</html>
