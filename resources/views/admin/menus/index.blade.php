@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">菜单管理</h3>
                    <div class="card-tools">
                        <a href="{{ route('menus.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> 新增菜单
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width: 50px">ID</th>
                                <th>名称</th>
                                <th>链接</th>
                                <th>图标</th>
                                <th>排序</th>
                                <th>状态</th>
                                <th style="width: 150px">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($menus ?? [] as $menu)
                            <tr>
                                <td>{{ $menu->id }}</td>
                                <td>{{ $menu->name }}</td>
                                <td>{{ $menu->url }}</td>
                                <td><i class="{{ $menu->icon }}"></i> {{ $menu->icon }}</td>
                                <td>{{ $menu->sort }}</td>
                                <td>
                                    @if($menu->status)
                                        <span class="badge bg-success">启用</span>
                                    @else
                                        <span class="badge bg-danger">禁用</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('menus.edit', $menu->id) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-edit"></i> 编辑
                                    </a>
                                    <form action="{{ route('menus.destroy', $menu->id) }}" method="POST" 
                                          style="display: inline-block;" 
                                          onsubmit="return confirm('确定要删除这个菜单吗？');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i> 删除
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">暂无数据</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if(isset($menus) && method_exists($menus, 'links'))
                <div class="card-footer clearfix">
                    {{ $menus->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.card-tools {
    margin-left: auto;
}
.table th {
    background-color: #f8f9fa;
}
.pagination {
    margin-bottom: 0;
}
</style>
@endpush
