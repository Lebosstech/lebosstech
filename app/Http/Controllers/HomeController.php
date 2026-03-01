<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Slider;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = Slider::active()->ordered()->get();
        $featuredProducts = Product::active()->featured()->with('category')->limit(8)->get();
        $categories = Category::active()->withCount('products')->limit(6)->get();
        
        return view('home', compact('sliders', 'featuredProducts', 'categories'));
    }
}
