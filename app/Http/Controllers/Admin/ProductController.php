<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\Category;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Product::query();

            // 搜索条件
            if ($request->filled('keyword')) {
                $query->where(function($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->keyword . '%')
                      ->orWhere('description', 'like', '%' . $request->keyword . '%');
                });
            }

            if ($request->filled('category_id')) {
                $query->where('category_id', (int)$request->category_id);
            }

            // 修复状态搜索逻辑
            if ($request->filled('status')) {
                $status = $request->status === '1' || $request->status === true || $request->status === 1;
                $query->where('status', $status);
            }

            if ($request->filled('language')) {
                $query->where('language', $request->language);
            }

            // 排序
            $query->orderBy('id', 'desc');

            // 调试输出SQL
            \Log::info('Products Query:', [
                'sql' => $query->toSql(),
                'bindings' => $query->getBindings(),
                'request' => $request->all()
            ]);

            // 获取数据并分页
            $products = $query->paginate(10);
            
            // 保持查询参数
            if ($request->hasAny(['keyword', 'category_id', 'status', 'language'])) {
                $products->appends($request->only(['keyword', 'category_id', 'status', 'language']));
            }
            
            // 获取分类
            $categories = Category::orderBy('name')->get();

            return view('admin.products.index', [
                'products' => $products,
                'categories' => $categories,
                'request' => $request
            ]);
        } catch (\Exception $e) {
            \Log::error('Products Index Error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->with('error', '获取产品列表失败：' . $e->getMessage());
        }
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.form', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = [
            'name' => $request->name,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'content' => $request->content,
            'status' => $request->boolean('status'),
            'language' => $request->language,
        ];

        if ($request->hasFile('image')) {
            // 处理封面图片
            $image = $request->file('image');
            $img = Image::make($image);
            
            // 设置最大宽度为 800px
            if ($img->width() > 800) {
                $img->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            }
            
            // 生成文件名并保存
            $filename = uniqid('product_') . '.jpg';
            $path = 'products/' . $filename;
            $img->save(storage_path('app/public/' . $path), 80, 'jpg');
            
            $data['image_url'] = asset('storage/' . $path);
        }

        Product::create($data);

        return redirect()
            ->route('admin.products.index')
            ->with('success', '产品创建成功');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.form', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $data = [
            'name' => $request->name,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'content' => $request->content,
            'status' => $request->boolean('status'),
            'language' => $request->language,
        ];

        if ($request->hasFile('image')) {
            // 处理封面图片
            $image = $request->file('image');
            $img = Image::make($image);
            
            // 设置最大宽度为 800px
            if ($img->width() > 800) {
                $img->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            }
            
            // 生成文件名并保存
            $filename = uniqid('product_') . '.jpg';
            $path = 'products/' . $filename;
            $img->save(storage_path('app/public/' . $path), 80, 'jpg');
            
            $data['image_url'] = asset('storage/' . $path);
        }

        $product->update($data);

        return redirect()
            ->route('admin.products.index')
            ->with('success', '产品更新成功');
    }

    public function toggleStatus(Product $product)
    {
        try {
            $product->status = !$product->status;
            $product->save();

            return response()->json([
                'success' => true,
                'message' => $product->status ? '产品已上架' : '产品已下架'
            ]);
        } catch (\Exception $e) {
            \Log::error('Toggle Product Status Error:', [
                'product_id' => $product->id,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => '操作失败：' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();

            return response()->json([
                'success' => true,
                'message' => '产品删除成功'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '删除失败：' . $e->getMessage()
            ], 500);
        }
    }

    public function uploadImage(Request $request)
    {
        try {
            if ($request->hasFile('file')) {
                $image = $request->file('file');
                $img = Image::make($image);
                
                // 设置最大宽度为 800px
                if ($img->width() > 800) {
                    $img->resize(800, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                }
                
                // 生成文件名并保存
                $filename = uniqid('product_') . '.jpg';
                $path = 'products/' . $filename;
                $img->save(storage_path('app/public/' . $path), 80, 'jpg');
                
                return response()->json([
                    'location' => asset('storage/' . $path)
                ]);
            }
            
            return response()->json([
                'error' => '没有上传文件'
            ], 400);
        } catch (\Exception $e) {
            \Log::error('Image Upload Error:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'error' => '上传失败：' . $e->getMessage()
            ], 500);
        }
    }

    public function uploadEditorImage(Request $request)
    {
        try {
            if ($request->hasFile('upload')) {
                $image = $request->file('upload');
                
                // 创建图片实例
                $img = Image::make($image);
                
                // 获取原始尺寸
                $originalWidth = $img->width();
                $originalHeight = $img->height();
                
                // 设置最大宽度
                $maxWidth = 800;
                
                // 如果图片宽度大于最大宽度，进行等比缩放
                if ($originalWidth > $maxWidth) {
                    // 计算等比例的新高度
                    $newHeight = intval($maxWidth * $originalHeight / $originalWidth);
                    
                    // 调整图片大小
                    $img->resize($maxWidth, $newHeight, function ($constraint) {
                        $constraint->aspectRatio();  // 保持纵横比
                        $constraint->upsize();       // 防止小图被放大
                    });
                }
                
                // 生成文件名
                $filename = uniqid('product_') . '.jpg';
                $path = 'products/' . $filename;
                
                // 保存图片（使用 80% 质量的 JPG 格式）
                $img->save(storage_path('app/public/' . $path), 80, 'jpg');
                
                return response()->json([
                    'uploaded' => true,
                    'url' => asset('storage/' . $path)
                ]);
            }
            
            return response()->json([
                'uploaded' => false,
                'error' => ['message' => '没有上传文件']
            ], 400);
            
        } catch (\Exception $e) {
            \Log::error('Image Upload Error:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'uploaded' => false,
                'error' => ['message' => '上传失败：' . $e->getMessage()]
            ], 500);
        }
    }
}