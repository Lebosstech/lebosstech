<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Slider;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $activeProducts = Product::active()->count();
        $totalCategories = Category::count();
        $totalContacts = Contact::count();
        $unreadContacts = Contact::unread()->count();
        $totalSliders = Slider::count();
        $totalWhatsappClicks = Product::sum('whatsapp_clicks');
        
        $recentProducts = Product::with('category')->latest()->limit(5)->get();
        $recentContacts = Contact::latest()->limit(5)->get();
        
        return view('admin.dashboard', compact(
            'totalProducts',
            'activeProducts',
            'totalCategories',
            'totalContacts',
            'unreadContacts', 
            'totalSliders',
            'totalWhatsappClicks',
            'recentProducts',
            'recentContacts'
        ));
    }
}
