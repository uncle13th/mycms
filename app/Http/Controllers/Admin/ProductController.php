<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\Category;

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
            $path = $request->file('image')->store('products', 'public');
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
            $path = $request->file('image')->store('products', 'public');
            $data['image_url'] = asset('storage/' . $path);
        }

        $product->update($data);

        return redirect()
            ->route('admin.products.index')
            ->with('success', '产品更新成功');
    }

    public function toggleStatus($id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->status = !$product->status;
            $product->save();

            return response()->json([
                'success' => true,
                'message' => $product->status ? '产品已上架' : '产品已下架'
            ]);
        } catch (\Exception $e) {
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
}