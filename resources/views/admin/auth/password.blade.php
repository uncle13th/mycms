@extends('admin.layouts.app')

@section('title', '修改密码')

@section('breadcrumb')
<span>系统设置</span>
<i class="fas fa-chevron-right"></i>
<span>修改密码</span>
@endsection

@section('content')

<div class="card">
    <div class="card-body">
        <div class="password-form">
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.password.update') }}">
                @csrf
                <div class="form-group">
                    <label>当前密码</label>
                    <div class="input-with-icon">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="current_password" class="form-control" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>新密码</label>
                    <div class="input-with-icon">
                        <i class="fas fa-key"></i>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="form-help">密码长度至少为 6 位</div>
                </div>

                <div class="form-group">
                    <label>确认新密码</label>
                    <div class="input-with-icon">
                        <i class="fas fa-key"></i>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-check"></i>
                        确认修改
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
/* 页面标题 */
.page-header {
    margin-bottom: 20px;
}

.page-title {
    font-size: 16px;
    color: #1f2f3d;
    font-weight: 500;
}

/* 卡片样式 */
.card {
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 12px 0 rgba(0, 0, 0, 0.05);
    max-width: 480px;
    margin: 0 auto;
}

.card-body {
    padding: 20px;
}

/* 表单样式 */
.password-form {
    max-width: 400px;
    margin: 0 auto;
}

.form-group {
    margin-bottom: 24px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    color: #606266;
    font-size: 14px;
    font-weight: 500;
}

.input-with-icon {
    position: relative;
}

.input-with-icon i {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #909399;
}

.input-with-icon input {
    padding-left: 35px;
}

.form-help {
    margin-top: 8px;
    font-size: 12px;
    color: #909399;
}

.form-control {
    width: 100%;
    height: 36px;
    padding: 0 15px;
    border: 1px solid #dcdfe6;
    border-radius: 4px;
    color: #606266;
    transition: all 0.3s;
}

.form-control:hover {
    border-color: #c0c4cc;
}

.form-control:focus {
    border-color: #409eff;
    outline: none;
    box-shadow: 0 0 0 2px rgba(64,158,255,.2);
}

.form-actions {
    margin-top: 32px;
    text-align: center;
}

.btn-submit {
    min-width: 120px;
    height: 36px;
    padding: 0 24px;
    background: linear-gradient(135deg, #409eff, #3a8ee6);
    border: none;
    border-radius: 4px;
    color: #fff;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.3s;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.btn-submit:hover {
    background: linear-gradient(135deg, #66b1ff, #409eff);
    transform: translateY(-1px);
}

.alert {
    margin-bottom: 24px;
    padding: 12px 16px;
    border-radius: 4px;
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
}

.alert-success {
    background: #f0f9eb;
    color: #67c23a;
    border: 1px solid #e1f3d8;
}

.alert-danger {
    background: #fef0f0;
    color: #f56c6c;
    border: 1px solid #fde2e2;
}
</style>
@endsection 