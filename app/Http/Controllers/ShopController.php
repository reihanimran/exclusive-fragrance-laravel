<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ShopController extends Controller
{
    /**
     * Display the shop page with filters
     */
    public function index(Request $request)
    {
        $query = Product::with(['category', 'images'])
            ->when($request->filled('gender'), function ($q) use ($request) {
                $q->whereIn('gender', explode(',', $request->gender));
            })
            ->when($request->filled('categories'), function ($q) use ($request) {
                $q->whereIn('category_id', explode(',', $request->categories));
            })
            ->when($request->filled('fragrance_type'), function ($q) use ($request) {
                $q->whereIn('fragrance_type', explode(',', $request->fragrance_type));
            })
            ->when($request->filled('size'), function ($q) use ($request) {
                $q->whereIn('size', explode(',', $request->size));
            })
            ->when($request->filled('min_price') || $request->filled('max_price'), function ($q) use ($request) {
                $q->whereBetween('sale_price', [
                    $request->min_price ?? 0,
                    $request->max_price ?? Product::max('sale_price')
                ]);
            })
            ->when($request->filled('stock_status'), function ($q) use ($request) {
                $request->stock_status === 'in_stock' 
                    ? $q->where('stock_quantity', '>', 0)
                    : $q->where('stock_quantity', '<=', 0);
            })
            ->when($request->filled('bestseller'), function ($q) {
                $q->where('Bestseller', true);
            });

        // Sorting
        $sortOptions = [
            'latest' => ['created_at', 'desc'],
            'price_asc' => ['sale_price', 'asc'],
            'price_desc' => ['sale_price', 'desc'],
            'name_asc' => ['product_name', 'asc'],
            'name_desc' => ['product_name', 'desc']
        ];

        $sort = $sortOptions[$request->input('sort', 'latest')] ?? $sortOptions['latest'];
        $query->orderBy($sort[0], $sort[1]);

        // Pagination
        $products = $query->paginate($request->input('limit', 12))
            ->appends($request->query());

        // Filter data for sidebar
        $filterData = [
            'categories' => Category::withCount(['products' => function ($q) {
                $q->where('stock_quantity', '>', 0);
            }])->get(),
            
            'fragranceTypes' => Product::select('fragrance_type')
                ->distinct()
                ->orderBy('fragrance_type')
                ->pluck('fragrance_type'),
            
            'sizes' => Product::select('size')
                ->distinct()
                ->orderBy('size')
                ->pluck('size'),
            
            'genders' => Product::select('gender')
                ->distinct()
                ->orderBy('gender')
                ->pluck('gender'),
            
            'priceRange' => [
                'min' => Product::min('sale_price'),
                'max' => Product::max('sale_price')
            ]
        ];

        $selectedCategories = $request->filled('categories') ? 
        explode(',', $request->categories) : [];

        return view('shop.index', compact('products', 'filterData', 'selectedCategories'));
    }

    /**
     * Display single product page
     */
    public function show(Product $product)
    {
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->with('images')
            ->take(4)
            ->get();

        return view('shop.show', [
            'product' => $product->load('images', 'category'),
            'relatedProducts' => $relatedProducts
        ]);
    }

    /**
     * Get available filter options (for AJAX)
     */
    public function getFilterOptions(Request $request)
    {
        $options = Product::selectRaw('
                COUNT(*) as product_count,
                MIN(sale_price) as min_price,
                MAX(sale_price) as max_price
            ')
            ->when($request->filled('filters'), function ($q) use ($request) {
                $this->applyFilters($q, json_decode($request->filters, true));
            })
            ->first();

        return response()->json([
            'price_range' => [
                'min' => $options->min_price,
                'max' => $options->max_price
            ],
            'total_products' => $options->product_count
        ]);
    }

    /**
     * Apply filters to query
     */
    private function applyFilters($query, $filters)
    {
        foreach ($filters as $type => $values) {
            if (!empty($values)) {
                switch ($type) {
                    case 'category':
                        $query->whereIn('category_id', $values);
                        break;
                    case 'fragrance_type':
                        $query->whereIn('fragrance_type', $values);
                        break;
                    case 'size':
                        $query->whereIn('size', $values);
                        break;
                    case 'gender':
                        $query->whereIn('gender', $values);
                        break;
                    case 'price':
                        $query->whereBetween('sale_price', [$values['min'], $values['max']]);
                        break;
                    case 'stock_status':
                        $values === 'in_stock'
                            ? $query->where('stock_quantity', '>', 0)
                            : $query->where('stock_quantity', '<=', 0);
                        break;
                    case 'bestseller':
                        $query->where('Bestseller', true);
                        break;
                }
            }
        }
    }
}