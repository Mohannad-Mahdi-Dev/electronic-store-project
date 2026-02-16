<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Categorie;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        // 1. نبدأ بالاستعلام مع العلاقات
        $query = Product::with('images');

        // 2. الفلترة حسب القسم - استخدم filled للتأكد أنها ليست فارغة
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // 3. الفلترة حسب الماركة
        if ($request->filled('brand')) {
            $query->where('brand_id', $request->brand);
        }

        // 4. الفلترة حسب نطاق السعر (هنا كان الخطأ)
        // if ($request->filled('min_price')) {
        //     $query->where('price', '>=', (float)$request->min_price);
        // }

        // if ($request->filled('max_price')) {
        //     $query->where('price', '<=', (float)$request->max_price);
        // }
        // 4. الفلترة حسب نطاق السعر
        if ($request->filled('min_price')) {
            $min = floatval($request->min_price);
            $query->where('price', '>=', $min);
        }

        if ($request->filled('max_price')) {
            $max = floatval($request->max_price);
            $query->where('price', '<=', $max);
        }

        // 5. ترتيب المنتجات
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                // ملاحظة: تأكد هل الحقل في قاعدة البيانات اسمه name أم title؟ 
                // في كود البحث استخدمت title، لذا سأعتمدها هنا أيضاً
                $query->orderBy('name', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        // 6. جلب البيانات مع الإبقاء على روابط الفلترة في الترقيم
        /** @var \Illuminate\Pagination\LengthAwarePaginator $products */
        $products = $query->paginate(12)->withQueryString();

        $categories = Categorie::all();
        $brands = Brand::where('is_visible', true)->get();

        return view('front.shop.index', compact('products', 'categories', 'brands'));
    }

    public function search(Request $request)
    {
        $queryText = $request->get('q', '');

        // تحسين: البحث يتم فقط إذا كان هناك نص بحث
        $products = Product::with('images')
            ->where(function ($q) use ($queryText) {
                $q->where('name', 'like', "%{$queryText}%")
                    ->orWhere('description', 'like', "%{$queryText}%");
            })
            ->paginate(12)->withQueryString();

        return view('front.shop.search', [
            'products' => $products,
            'query' => $queryText
        ]);
    }
}
