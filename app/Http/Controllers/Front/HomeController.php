<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Categorie;
use App\Models\Brand;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the landing page with featured products and categories.
     */
    public function index()
    {
        $featuredProducts = Product::with('images')
            ->where('is_featured', true)
            ->where('is_active', true)
            ->take(8)
            ->get();

        $categories = Categorie::take(6)->get();

        $brands = Brand::where('is_visible', true)->take(6)->get();

        return view('front.home.index', compact('featuredProducts', 'categories', 'brands'));
    }
}
