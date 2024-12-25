@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">新增菜单</h3>
                </div>
                <form action="{{ route('menus.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="name">菜单名称</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="url">链接地址</label>
                            <input type="text" class="form-control @error('url') is-invalid @enderror" 
                                   id="url" name="url" value="{{ old('url') }}" required>
                            @error('url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="icon">图标类名</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-icons"></i></span>
                                <input type="text" class="form-control @error('icon') is-invalid @enderror" 
                                       id="icon" name="icon" value="{{ old('icon', 'fas fa-circle') }}">
                            </div>
                            @error('icon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                使用 Font Awesome 5 图标类名，例如：fas fa-home
                            </small>
                        </div>

                        <div class="form-group mb-3">
                            <label for="sort">排序</label>
                            <input type="number" class="form-control @error('sort') is-invalid @enderror" 
                                   id="sort" name="sort" value="{{ old('sort', 0) }}">
                            @error('sort')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="status">状态</label>
                            <select class="form-control @error('status') is-invalid @enderror" 
                                    id="status" name="status">
                                <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>启用</option>
                                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>禁用</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">保存</button>
                        <a href="{{ route('menus.index') }}" class="btn btn-default">返回</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
