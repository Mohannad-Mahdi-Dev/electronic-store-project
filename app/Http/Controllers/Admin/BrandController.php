<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;

class BrandController extends Controller
{
    /**
     * دالة index لعرض صفحة كل العلامات التجارية
     */
    public function index(Request $request)
    {
        $query = Brand::query();

        // 🔍 Search by name
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        //  Filter by visibility
        if ($request->filled('is_visible')) {
            $query->where('is_visible', $request->is_visible);
        }

        // Order & pagination
        $brands = $query->orderBy('name')->paginate(10)->withQueryString();

        return view('dsadmin.brands.index', compact('brands'));
    }


    /**
     * دالة لعرض صفحة علامة تجارية معينة ومنتجاتها
     *
     * @param Brand $brand // هنا نستخدم Route Model Binding
     */
    public function show(Brand $brand)
    {
        // التأكد من أن العلامة المطلوبة ظاهرة للعيان، وإلا عرض صفحة 404
        if (!$brand->is_visible) {
            abort(404);
        }

        // جلب منتجات هذه العلامة التجارية باستخدام العلاقة التي أنشأناها
        // paginate(12) أفضل من get() لعرض 12 منتجاً في كل صفحة
        $products = $brand->products()->paginate(12);

        // إرسال بيانات العلامة التجارية والمنتجات إلى الـ view
        return view('site.brands.show', compact('brand', 'products'));
    }

    public function create()
    {
        $brands = Brand::all();
        return view('dsadmin.brands.create', compact('brands'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'is_visible' => 'required|boolean',
        ]);

        $brand = Brand::create($request->only([
            'name',
            'description',
            'is_visible',
        ]));

        return redirect()->route('brands.index')->with('success', 'Brand created successfully');
    }

    public function edit(Brand $brand)
    {
        return view('dsadmin.brands.edit', compact('brand'));
    }

    public function update(Request $request, Brand $brand)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'is_visible' => 'required|boolean',
        ]);

        $brand->update($request->only([
            'name',
            'description',
            'is_visible',
        ]));

        return redirect()->route('brands.index')->with('success', 'Brand updated successfully');
    }


    public function destroy(Brand $brand)
    {
        $brand->delete();

        return redirect()->route('brands.index')->with('success', 'Brand deleted successfully');
    }

    public function toggleVisibility(Brand $brand)
    {
        $brand->is_visible = !$brand->is_visible;
        $brand->save();

        return redirect()->route('brands.index')->with('success', 'Brand visibility toggled successfully');
    }

    public function search(Request $request)
    {
        $search = $request->input('search');

        $brands = Brand::where('name', 'like', "%{$search}%")->get();

        return view('dsadmin.brands.index', compact('brands'));
    }

    public function sort(Request $request)
    {
        $sort = $request->input('sort');

        $brands = Brand::orderBy($sort)->get();

        return view('dsadmin.brands.index', compact('brands'));
    }

    public function filter(Request $request)
    {
        $filter = $request->input('filter');

        $brands = Brand::where('is_visible', $filter)->get();

        return view('dsadmin.brands.index', compact('brands'));
    }
}
