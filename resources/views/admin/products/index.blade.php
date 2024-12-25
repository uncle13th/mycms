@extends('admin.layouts.app')

@section('title', '产品管理')

@section('breadcrumb')
<span>产品管理</span>
<i class="fas fa-chevron-right"></i>
<span>产品列表</span>
@endsection

@section('content')
<div class="page-header">
    <div class="search-wrapper">
        <form action="{{ route('admin.products.index') }}" method="GET" class="search-form">
            <div class="search-row">
                <div class="search-group">
                    <label>产品名称</label>
                    <div class="input-with-icon">
                        <i class="fas fa-search"></i>
                        <input type="text" 
                               name="keyword" 
                               class="form-control" 
                               placeholder="请输入产品名称"
                               value="{{ request('keyword') }}">
                    </div>
                </div>
                <div class="search-group">
                    <label>产品分类</label>
                    <select name="category_id" class="form-control">
                        <option value="">请选择分类</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" 
                                    {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="search-group">
                    <label>语言</label>
                    <select name="language" class="form-control">
                        <option value="">请选择语言</option>
                        <option value="zh_CN" {{ request('language') === 'zh_CN' ? 'selected' : '' }}>简体中文</option>
                        <option value="zh_TW" {{ request('language') === 'zh_TW' ? 'selected' : '' }}>繁体中文</option>
                        <option value="en" {{ request('language') === 'en' ? 'selected' : '' }}>英语</option>
                    </select>
                </div>
                <div class="search-group">
                    <label>产品状态</label>
                    <select name="status" class="form-control">
                        <option value="">请选择状态</option>
                        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>上架</option>
                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>下架</option>
                    </select>
                </div>
                <div class="search-buttons">
                    <button type="submit" class="btn-info">
                        <i class="fas fa-search"></i> 搜索
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="btn-default">
                        <i class="fas fa-redo"></i> 重置
                    </a>
                </div>
            </div>
        </form>
        <a href="{{ route('admin.products.create') }}" class="btn-primary">
            <i class="fas fa-plus"></i> 新增产品
        </a>
    </div>
</div>

<div class="table-container">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>产品图片</th>
                    <th>产品名称</th>
                    <th>分类</th>
                    <th>语言</th>
                    <th>状态</th>
                    <th>创建时间</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>
                        <img src="{{ $product->image_url }}" 
                             alt="{{ $product->name }}" 
                             class="product-thumb">
                    </td>
                    <td>
                        <div class="product-name">{{ $product->name }}</div>
                        @if($product->description)
                            <div class="product-desc">{{ Str::limit($product->description, 50) }}</div>
                        @endif
                    </td>
                    <td>{{ $product->category->name }}</td>
                    <td>
                        @switch($product->language)
                            @case('zh_CN')
                                <span class="badge badge-info">简体中文</span>
                                @break
                            @case('zh_TW')
                                <span class="badge badge-info">繁体中文</span>
                                @break
                            @case('en')
                                <span class="badge badge-info">英语</span>
                                @break
                            @default
                                <span class="badge badge-secondary">未知</span>
                        @endswitch
                    </td>
                    <td>
                        @if($product->status)
                            <span class="badge badge-success">上架</span>
                        @else
                            <span class="badge badge-secondary">下架</span>
                        @endif
                    </td>
                    <td>{{ $product->created_at }}</td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('admin.products.edit', $product->id) }}" 
                               class="btn-action btn-edit" 
                               title="编辑">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" 
                                    class="btn-action btn-delete" 
                                    onclick="deleteProduct({{ $product->id }})"
                                    title="删除">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="empty-data">
                        <i class="fas fa-inbox"></i>
                        <p>暂无产品数据</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($products->hasPages())
    <div class="pagination-wrapper">
        <div class="pagination-content">
            <div class="pagination-info">
                显示第 {{ $products->firstItem() }} 到 {{ $products->lastItem() }} 条，共 {{ $products->total() }} 条
            </div>
            {{ $products->appends(request()->except('page'))->links() }}
        </div>
    </div>
    @endif
</div>
@endsection

@section('styles')
<style>
/* 搜索区域样式 */
.search-wrapper {
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 12px 0 rgba(0, 0, 0, 0.05);
    padding: 20px;
    margin-bottom: 20px;
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    gap: 20px;
    position: sticky;
    top: 0;
    z-index: 10;
}

.search-form {
    flex: 1;
}

.search-row {
    display: flex;
    gap: 20px;
    align-items: flex-end;
}

.search-group {
    flex: 1;
    min-width: 200px;
}

.search-group label {
    display: block;
    margin-bottom: 8px;
    color: #606266;
    font-size: 14px;
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

/* 表格容器样式 */
.table-container {
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 12px 0 rgba(0, 0, 0, 0.05);
    display: flex;
    flex-direction: column;
}

.table-responsive {
    overflow: auto;
}

/* 表格样式 */
.table {
    width: 100%;
    border-collapse: collapse;
}

.table th {
    background: #f5f7fa;
    padding: 12px 16px;
    font-weight: 500;
    color: #606266;
    text-align: left;
    border-bottom: 2px solid #ebeef5;
}

.table td {
    padding: 16px;
    border-bottom: 1px solid #ebeef5;
}

.table tr:hover {
    background-color: #f5f7fa;
}

/* 产品图片样式 */
.product-thumb {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 4px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

/* 产品信息样式 */
.product-name {
    font-weight: 500;
    color: #303133;
    margin-bottom: 4px;
}

.product-desc {
    font-size: 13px;
    color: #909399;
}

.price {
    color: #f56c6c;
    font-weight: 500;
}

/* 状态标签样式 */
.status-tag {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 15px;
    font-size: 13px;
}

.status-active {
    background: #e1f3d8;
    color: #67c23a;
}

.status-inactive {
    background: #fde2e2;
    color: #f56c6c;
}

/* 按钮样式 */
.btn-primary, .btn-info, .btn-default {
    height: 36px;
    padding: 0 20px;
    border-radius: 4px;
    font-size: 14px;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    transition: all 0.3s;
    border: none;
    text-decoration: none;
}

.btn-primary {
    background: linear-gradient(135deg, #409eff, #3a8ee6);
    color: #fff;
}

.btn-info {
    background: #409eff;
    color: #fff;
}

.btn-default {
    background: #fff;
    color: #606266;
    border: 1px solid #dcdfe6;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #66b1ff, #409eff);
    transform: translateY(-1px);
}

.btn-info:hover {
    background: #66b1ff;
}

.btn-default:hover {
    color: #409eff;
    border-color: #c6e2ff;
    background: #ecf5ff;
}

/* 操作按钮样式 */
.action-buttons {
    display: flex;
    gap: 8px;
}

.btn-action {
    width: 32px;
    height: 32px;
    border-radius: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s;
    border: none;
    color: #fff;
}

.btn-edit {
    background: #409eff;
}

.btn-delete {
    background: #f56c6c;
}

.btn-edit:hover {
    background: #66b1ff;
    transform: translateY(-1px);
}

.btn-delete:hover {
    background: #f78989;
    transform: translateY(-1px);
}

/* 空数据样式 */
.empty-data {
    text-align: center;
    padding: 40px 0;
    color: #909399;
}

.empty-data i {
    font-size: 48px;
    margin-bottom: 16px;
    color: #dcdfe6;
}

.empty-data p {
    margin: 0;
    font-size: 14px;
}

/* 分页样式 */
.pagination-wrapper {
    margin-top: auto;
    padding: 20px;
    background: #fff;
    border-top: 1px solid #ebeef5;
}

.pagination-content {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 20px;
}

.pagination-info {
    color: #909399;
    font-size: 13px;
}

.pagination {
    display: flex;
    list-style: none;
    padding: 0;
    margin: 0;
}

.pagination li {
    margin: 0 4px;
}

.pagination li span,
.pagination li a {
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 32px;
    height: 32px;
    padding: 0 10px;
    border-radius: 4px;
    font-size: 13px;
    color: #606266;
    border: 1px solid #dcdfe6;
    background: #fff;
    text-decoration: none;
    transition: all 0.3s;
}

.pagination li.active span {
    background: #409eff;
    color: #fff;
    border-color: #409eff;
}

.pagination li a:hover {
    color: #409eff;
    border-color: #c6e2ff;
    background: #ecf5ff;
}

.pagination li.disabled span {
    color: #c0c4cc;
    cursor: not-allowed;
    background: #f5f7fa;
    border-color: #e4e7ed;
}

/* 表单控件样式 */
.form-control {
    width: 100%;
    height: 36px;
    padding: 0 12px;
    border: 1px solid #dcdfe6;
    border-radius: 4px;
    color: #606266;
    transition: all 0.3s;
    background: #fff;
}

.form-control:hover {
    border-color: #c0c4cc;
}

.form-control:focus {
    border-color: #409eff;
    outline: none;
    box-shadow: 0 0 0 2px rgba(64,158,255,.2);
}

select.form-control {
    appearance: none;
    padding-right: 30px;
    background: #fff url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e") no-repeat right 0.75rem center/16px 12px;
}

/* 美化滚动条 */
.content-container::-webkit-scrollbar,
.table-responsive::-webkit-scrollbar {
    width: 6px;
    height: 6px;
}

.content-container::-webkit-scrollbar-thumb,
.table-responsive::-webkit-scrollbar-thumb {
    background: #dcdfe6;
    border-radius: 3px;
}

.content-container::-webkit-scrollbar-track,
.table-responsive::-webkit-scrollbar-track {
    background: #f5f7fa;
}
</style>
@endsection

@section('scripts')
<script>
function deleteProduct(id) {
    if (confirm('确定要删除这个产品吗？此操作不可恢复！')) {
        fetch(`{{ url('admin/products') }}/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            } else {
                alert('删除失败：' + data.message);
            }
        })
        .catch(error => {
            alert('操作失败，请重试');
        });
    }
}
</script>
@endsection 