<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>管理员登录 - {{ config('app.name') }}</title>
    <link href="https://cdn.bootcdn.net/ajax/libs/twitter-bootstrap/5.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.bootcdn.net/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        body {
            height: 100vh;
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            padding-top: 40px;
            padding-bottom: 40px;
        }
        .login-container {
            width: 100%;
            max-width: 420px;
            margin: 0 auto;
            padding: 15px;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 35px rgba(0, 0, 0, 0.05);
            background: #fff;
        }
        .card-header {
            background: none;
            border-bottom: 1px solid #f1f1f1;
            padding: 25px;
            text-align: center;
        }
        .card-body {
            padding: 30px;
        }
        .logo {
            margin-bottom: 0.5rem;
        }
        .logo-text {
            font-size: 1.75rem;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 0.5rem;
        }
        .logo-description {
            color: #718096;
            font-size: 0.875rem;
        }
        .form-group {
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
        }
        .form-group label {
            color: #2d3748;
            font-weight: 500;
            margin-bottom: 0;
            width: 80px;
            flex-shrink: 0;
        }
        .form-control {
            border: 2px solid #e2e8f0;
            height: 42px;
            font-size: 0.95rem;
            border-radius: 6px;
            padding: 0.5rem 1rem;
            flex-grow: 1;
        }
        .form-control:focus {
            border-color: #4299e1;
            box-shadow: none;
        }
        .btn-primary {
            background-color: #4299e1;
            border: none;
            padding: 0.8rem;
            font-weight: 500;
            height: 42px;
            transition: all 0.2s;
        }
        .btn-primary:hover {
            background-color: #3182ce;
            transform: translateY(-1px);
        }
        .alert {
            border-radius: 8px;
            font-size: 0.875rem;
            border: none;
        }
        .alert-danger {
            background-color: #fff5f5;
            color: #e53e3e;
        }
        .form-check-label {
            color: #718096;
            font-size: 0.875rem;
        }
        .form-check-input:checked {
            background-color: #4299e1;
            border-color: #4299e1;
        }
        .copyright {
            text-align: center;
            color: #718096;
            margin-top: 2rem;
            font-size: 0.875rem;
        }
        .form-check {
            padding-left: 80px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <div class="card">
                <div class="card-header">
                    <div class="logo">
                        <div class="logo-text">{{ config('app.name') }}</div>
                        <div class="logo-description">欢迎回来! 请登录您的账号</div>
                    </div>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger mb-4">
                            <ul class="mb-0 list-unstyled">
                                @foreach ($errors->all() as $error)
                                    <li><i class="fas fa-exclamation-circle me-2"></i>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.login') }}">
                        @csrf
                        <div class="form-group">
                            <label for="username">用户名</label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror" 
                                   id="username" name="username" value="{{ old('username') }}" required autofocus>
                        </div>

                        <div class="form-group">
                            <label for="password">密码</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" required>
                        </div>

                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" name="remember" 
                                   id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                记住我的登录状态
                            </label>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-sign-in-alt me-2"></i>登录
                        </button>
                    </form>
                </div>
            </div>
            <div class="copyright">
                &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
            </div>
        </div>
    </div>
</body>
</html>
