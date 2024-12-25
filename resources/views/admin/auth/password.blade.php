@extends('admin.layouts.app')

@section('title', '修改密码')

@section('breadcrumb')
<span>系统设置</span>
<i class="fas fa-chevron-right"></i>
<span>修改密码</span>
@endsection

@section('styles')
<style>
    .password-form {
        max-width: 500px;
        margin: 0 auto;
    }

    .form-title {
        font-size: 18px;
        color: #333;
        margin-bottom: 24px;
        padding-bottom: 12px;
        border-bottom: 1px solid #f0f0f0;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        color: #666;
        font-size: 14px;
    }

    .form-control {
        width: 100%;
        height: 40px;
        line-height: 40px;
        padding: 0 15px;
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
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s;
    }

    .btn-submit:hover {
        background: #66b1ff;
    }
</style>
@endsection

@section('content')
<div class="password-form">
    <h2 class="form-title">修改密码</h2>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.password.update') }}">
        @csrf
        <div class="form-group">
            <label>当前密码</label>
            <input type="password" name="current_password" class="form-control" required>
        </div>

        <div class="form-group">
            <label>新密码</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="form-group">
            <label>确认新密码</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <button type="submit" class="btn-submit">确认修改</button>
    </form>
</div>
@endsection 