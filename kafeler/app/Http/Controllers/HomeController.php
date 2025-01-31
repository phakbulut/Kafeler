<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        $cafes = User::where('status', 1)
            ->with(['cafebanners' => function ($query) {
                $query->where('status', 1);
            }])
            ->get();
        return view('home.index', compact('cafes'));
    }

    public function showCafe($slug)
    {
        $cafe = User::where('status', 1)
            ->where('slug', $slug)
            ->with('categories')
            ->with(['cafebanners' => function ($query) {
                $query->where('status', 1);
            }])
            ->firstOrFail();


       
        return view('home.cafe', compact('cafe'));
    }
    public function searchCafes(Request $request)
    {
        $query = $request->input('query');
        $cafes = User::where('status', 1)
            ->where('cafe_name', 'LIKE', "%{$query}%")
            ->select('id', 'cafe_name', 'slug')
            ->limit(5)
            ->get();

        return response()->json($cafes);
    }

    public function showCategoryProducts($cafeSlug, $categorySlug)
{
    $cafe = User::where('slug', $cafeSlug)->firstOrFail();
    $category = $cafe->categories()->where('slug', $categorySlug)->firstOrFail();

    $products = $category->products()->with(['images', 'user'])->where('status', 1)->get();

    return view('home.category-products', compact('cafe', 'category', 'products'));
}
}
