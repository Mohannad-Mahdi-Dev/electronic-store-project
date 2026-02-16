<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Brand;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $query = Product::with(['category', 'brand']); // منع N+1

        // Search
        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%")
                ->orWhere('sku', 'like', "%{$request->search}%");
        }

        // Filter category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter brand
        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->brand_id);
        }

        // Filter status
        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        $products = $query->paginate(10);

        $categories = Categorie::all();
        $brands = Brand::where('is_visible', true)->get();

        return view('dsadmin.products.index', compact('products', 'categories', 'brands'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Categorie::orderBy('name')->get();
        $brands = Brand::orderBy('name')->get();
        return view('dsadmin.products.create', compact('categories', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'sku' => 'nullable|string|max:255|unique:products,sku',
            'price' => 'required|numeric|min:0',
            'qty' => 'required|integer|min:0',
            'is_active' => 'sometimes|boolean',

            // ✅ صور متعددة
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data['is_active'] = $request->boolean('is_active');

        if (empty($data['sku'])) {
            $data['sku'] = 'SKU-' . strtoupper(Str::random(8));
        }

        // ✅ إنشاء المنتج
        $product = Product::create($data);

        // ✅ حفظ الصور
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $file) {
                $path = $file->store('products', 'public');

                $product->images()->create([
                    'path' => $path,
                    'is_main' => $index === 0,  // أول صورة رئيسية
                    'sort_order' => $index,
                ]);
            }
        }

        return redirect()->route('products.index')->with('status', 'تم إضافة المنتج ✅');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $product->load('images'); // ✅ عشان تعرض الصور القديمة في صفحة التعديل
        $categories = Categorie::orderBy('name')->get();
        $brands = Brand::orderBy('name')->get();
        return view('dsadmin.products.edit', compact('product', 'categories', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {

        $data = $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'sku' => 'nullable|string|max:255|unique:products,sku,' . $product->id,
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'is_active' => 'sometimes|boolean',

            // ✅ إضافة صور جديدة
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data['is_active'] = $request->boolean('is_active');

        if (empty($data['sku'])) {
            $data['sku'] = $product->sku ?? ('SKU-' . strtoupper(Str::random(8)));
        }

        // ✅ تحديث بيانات المنتج
        $product->update($data);

        // ✅ إضافة صور جديدة فقط (بدون حذف القديمة)
        if ($request->hasFile('images')) {
            $startOrder = (int) $product->images()->max('sort_order');
            $startOrder = $startOrder ? $startOrder + 1 : 0;

            foreach ($request->file('images') as $i => $file) {
                $path = $file->store('products', 'public');

                $product->images()->create([
                    'path' => $path,
                    'is_main' => false,
                    'sort_order' => $startOrder + $i,
                ]);
            }
        }

        return redirect()->route('products.index')->with('status', 'تم تحديث المنتج ✅');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // ✅ حذف الصور من storage قبل حذف المنتج
        foreach ($product->images as $img) {
            Storage::disk('public')->delete($img->path);
        }

        $product->delete();

        return redirect()->route('products.index')->with('status', 'تم حذف المنتج 🗑️');
    }

    /**
     * (اختياري) حذف صورة واحدة من المنتج
     */
    public function deleteImage(ProductImage $image)
    {
        Storage::disk('public')->delete($image->path);
        $image->delete();

        return back()->with('status', 'تم حذف الصورة ✅');
    }
}
