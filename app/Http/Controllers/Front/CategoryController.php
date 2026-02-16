<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display all categories.
     */
    public function index()
    {
        $categories = Categorie::withCount('products')->get();

        return view('front.categories.index', compact('categories'));
    }

    /**
     * Display products in a specific category.
     */
    public function show(Categorie $category)
    {
        $products = Product::where('category_id', $category->id)->paginate(12);

        return view('front.categories.show', compact('category', 'products'));
    }
}
