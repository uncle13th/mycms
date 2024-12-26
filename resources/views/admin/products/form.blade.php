@extends('admin.layouts.app')

@section('title', isset($product) ? '编辑产品' : '新增产品')

@section('breadcrumb')
<span>产品管理</span>
<i class="fas fa-chevron-right"></i>
<span>{{ isset($product) ? '编辑产品' : '新增产品' }}</span>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ isset($product) ? route('admin.products.update', $product->id) : route('admin.products.store') }}" 
              method="POST" 
              enctype="multipart/form-data">
            @csrf
            @if(isset($product))
                @method('PUT')
            @endif

            <!-- 基础信息区域 -->
            <div class="form-section">
                <h3 class="section-title">基础信息</h3>
                <div class="basic-info">
                    <!-- 左侧：产品名称和分类 -->
                    <div class="left-column">
                        <div class="form-group">
                            <label>产品名称</label>
                            <input type="text" 
                                   name="name" 
                                   class="form-control" 
                                   value="{{ old('name', $product->name ?? '') }}" 
                                   required>
                        </div>

                        <div class="form-group">
                            <label>产品描述</label>
                            <input type="text" 
                                   name="description" 
                                   class="form-control" 
                                   value="{{ old('description', $product->description ?? '') }}" 
                                   placeholder="请输入产品简短描述">
                        </div>

                        <div class="form-group">
                            <label>产品分类</label>
                            <select name="category_id" class="form-control" required>
                                <option value="">请选择分类</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                            {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-inline-group">
                            <div class="form-group-half">
                                <label>语言</label>
                                <select name="language" class="form-control" required>
                                    <option value="">请选择语言</option>
                                    <option value="zh_CN" {{ old('language', $product->language ?? '') == 'zh_CN' ? 'selected' : '' }}>简体中文</option>
                                    <option value="zh_TW" {{ old('language', $product->language ?? '') == 'zh_TW' ? 'selected' : '' }}>繁体中文</option>
                                    <option value="en" {{ old('language', $product->language ?? '') == 'en' ? 'selected' : '' }}>英语</option>
                                </select>
                            </div>

                            <div class="form-group-half">
                                <label>产品状态</label>
                                <select name="status" class="form-control" required>
                                    <option value="0" {{ old('status', $product->status ?? 0) == 0 ? 'selected' : '' }}>下架</option>
                                    <option value="1" {{ old('status', $product->status ?? 0) == 1 ? 'selected' : '' }}>上架</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- 右侧：产品图片 -->
                    <div class="right-column">
                        <div class="form-group">
                            <label>产品图片</label>
                            <div class="image-upload-area">
                                <div class="image-preview" id="imagePreview">
                                    @if(isset($product) && $product->image_url)
                                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                                    @else
                                        <div class="no-image">
                                            <i class="fas fa-image"></i>
                                            <p>暂无图片</p>
                                        </div>
                                    @endif
                                </div>
                                <div class="image-actions">
                                    <div class="btn-group">
                                        <button type="button" class="btn-default" onclick="document.getElementById('imageInput').click()">
                                            <i class="fas fa-upload"></i>
                                            选择本地图片
                                        </button>
                                        <button type="button" class="btn-default" onclick="openImageLibrary()">
                                            <i class="fas fa-photo-video"></i>
                                            选择图片库
                                        </button>
                                    </div>
                                </div>
                                <input type="file" 
                                       id="imageInput"
                                       name="image" 
                                       accept="image/*"
                                       style="display: none;"
                                       {{ isset($product) ? '' : 'required' }}
                                       onchange="previewImage(this)">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 产品描述区域 -->
            <div class="form-section">
                <h3 class="section-title">产品内容</h3>
                <div class="form-group">
                    <div id="editor">{!! old('content', $product->content ?? '') !!}</div>
                    <input type="hidden" name="content" id="content">
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit">
                    <i class="fas fa-check"></i>
                    {{ isset($product) ? '保存修改' : '确认添加' }}
                </button>
                <a href="{{ route('admin.products.index') }}" class="btn-default">
                    <i class="fas fa-times"></i>
                    取消
                </a>
            </div>
        </form>
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
}

.card-body {
    padding: 20px;
}

/* 表单样式 */
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

textarea.form-control {
    height: auto;
    padding: 10px 15px;
}

/* 带前缀的输入框 */
.input-with-prefix {
    display: flex;
    align-items: center;
}

.prefix {
    padding: 0 12px;
    background: #f5f7fa;
    color: #909399;
    border: 1px solid #dcdfe6;
    border-right: none;
    border-radius: 4px 0 0 4px;
    height: 36px;
    line-height: 34px;
}

.input-with-prefix .form-control {
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
}

/* 图片预览 */
.current-image {
    margin-top: 8px;
}

.current-image img {
    max-width: 200px;
    max-height: 200px;
    border-radius: 4px;
}

/* 复选框样式 */
.checkbox-label {
    display: inline-flex;
    align-items: center;
    cursor: pointer;
}

.checkbox-label input[type="checkbox"] {
    margin-right: 8px;
}

/* 表单操作区 */
.form-actions {
    margin-top: 32px;
    display: flex;
    gap: 16px;
}

.btn-submit {
    height: 36px;
    padding: 0 20px;
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

.btn-default {
    height: 36px;
    padding: 0 20px;
    background: #fff;
    border: 1px solid #dcdfe6;
    border-radius: 4px;
    color: #606266;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.3s;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    text-decoration: none;
}

.btn-default:hover {
    color: #409eff;
    border-color: #c6e2ff;
    background: #ecf5ff;
}

/* 区域分隔 */
.form-section {
    margin-bottom: 32px;
}

.section-title {
    font-size: 16px;
    color: #1f2f3d;
    font-weight: 500;
    margin-bottom: 20px;
    padding-bottom: 12px;
    border-bottom: 1px solid #ebeef5;
}

/* 基础信息布局 */
.basic-info {
    display: flex;
    gap: 40px;
}

.left-column {
    flex: 1;
}

.right-column {
    flex: 1;
}

/* 图片上传区域 */
.image-upload-area {
    border: 2px dashed #dcdfe6;
    border-radius: 8px;
    padding: 20px;
    background: #fafafa;
    transition: all 0.3s;
}

.image-upload-area:hover {
    border-color: #409eff;
}

/* 图片预览区域 */
.image-preview {
    width: 200px;
    height: 200px;
    margin: 0 auto 20px;
    background: #fff;
    border-radius: 4px;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
}

.image-preview img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.no-image {
    color: #909399;
    text-align: center;
}

.no-image i {
    font-size: 48px;
    margin-bottom: 8px;
}

.no-image p {
    margin: 0;
    font-size: 14px;
}

/* 按钮组样式 */
.image-actions {
    text-align: center;
}

.btn-group {
    display: flex;
    gap: 12px;
    justify-content: center;
}

.btn-group .btn-default {
    flex: 1;
    max-width: 160px;
}

/* 调整文本框样式 */
textarea.form-control {
    min-height: 120px;
    resize: vertical;
}

/* 行内表单组样式 */
.form-inline-group {
    display: flex;
    gap: 20px;
    margin-bottom: 24px;
}

.form-group-half {
    flex: 1;
}

.form-group-half label {
    display: block;
    margin-bottom: 8px;
    color: #606266;
    font-size: 14px;
    font-weight: 500;
}

.form-group-half .form-control {
    width: 100%;
}

/* 编辑器样式调整 */
.ck-editor__editable {
    min-height: 400px;
    max-height: 600px;
}

.ck-content {
    font-size: 14px;
}
</style>
@endsection

@section('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
<script>
ClassicEditor
    .create(document.querySelector('#editor'), {
        toolbar: {
            items: [
                'heading',
                '|',
                'bold',
                'italic',
                'link',
                'bulletedList',
                'numberedList',
                '|',
                'outdent',
                'indent',
                '|',
                'imageUpload',
                'blockQuote',
                'insertTable',
                'undo',
                'redo'
            ]
        },
        language: 'zh-cn',
        image: {
            toolbar: [
                'imageTextAlternative',
                'imageStyle:inline',
                'imageStyle:block',
                'imageStyle:side'
            ]
        },
        table: {
            contentToolbar: [
                'tableColumn',
                'tableRow',
                'mergeTableCells'
            ]
        },
        simpleUpload: {
            uploadUrl: '{{ route("admin.products.upload-image") }}',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        }
    })
    .then(editor => {
        // 在表单提交前将编辑器内容同步到隐藏输入框
        const form = editor.sourceElement.closest('form');
        const contentInput = document.querySelector('#content');
        
        form.addEventListener('submit', function() {
            contentInput.value = editor.getData();
        });
    })
    .catch(error => {
        console.error(error);
    });

function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            const preview = document.getElementById('imagePreview');
            preview.innerHTML = `<img src="${e.target.result}" alt="预览图片">`;
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}

function openImageLibrary() {
    // 图片库功能实现
    alert('图片库功能开发中...');
}
</script>
@endsection 