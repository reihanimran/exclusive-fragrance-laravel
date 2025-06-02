<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    /**
     * Display the home page with bestsellers and new arrivals
     */
    public function index()
    {
        // Get bestseller products
        $bestsellers = Product::with(['images', 'category'])
            ->where('Bestseller', true)
            ->where('stock_quantity', '>', 0)
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        // Get new arrivals
        $newArrivals = Product::with(['images', 'category'])
            ->where('stock_quantity', '>', 0)
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        // Get featured categories
        $featuredCategories = Category::with(['products' => function($query) {
            $query->where('stock_quantity', '>', 0)->take(4);
        }])->whereHas('products')->take(3)->get();

        return view('home', compact('bestsellers', 'newArrivals', 'featuredCategories'));
    }

    /**
     * Display the about us page
     */
    public function about()
    {
        return view('about');
    }

    /**
     * Display the contact page
     */
    public function contact()
    {
        return view('contact');
    }

    /**
     * Process the contact form submission
     */
    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
        ]);

        // Send email
        // Mail::to('contact@exclusivefragrance.com')->send(
        //     new \App\Mail\ContactFormSubmitted($validated)
        // );

        return back()->with('success', 'Thank you for your message! We will respond within 24 hours.');
    }

    /**
     * Display brand showcase page
     */
    public function brands()
    {
        $brands = Product::select('brand')
            ->distinct()
            ->orderBy('brand')
            ->get()
            ->pluck('brand');

        return view('brands', compact('brands'));
    }
}