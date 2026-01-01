<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class ProductController extends Controller
{
    /**
     * Display a listing of products.
     */
    public function index(Request $request)
    {
        $query = Product::with(['category', 'supplier', 'productStocks.warehouse']);

        // Search
        if ($request->has('search')) {
            $query->search($request->search);
        }

        // Filter by category
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by supplier
        if ($request->has('supplier_id')) {
            $query->where('supplier_id', $request->supplier_id);
        }

        // Filter by status
        if ($request->has('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        $products = $query->paginate($request->get('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => $products,
        ]);
    }

    /**
     * Store a newly created product.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'sku' => 'required|string|unique:products,sku|max:100',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'unit' => 'required|string|max:50',
            'min_stock' => 'required|integer|min:0',
            'max_stock' => 'nullable|integer|min:0',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        $product = Product::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Product created successfully',
            'data' => $product->load(['category', 'supplier']),
        ], 201);
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        $product->load(['category', 'supplier', 'productStocks.warehouse']);

        return response()->json([
            'success' => true,
            'data' => [
                'product' => $product,
                'total_stock' => $product->getTotalStock(),
                'stock_by_warehouse' => $product->productStocks->map(function ($stock) {
                    return [
                        'warehouse_id' => $stock->warehouse_id,
                        'warehouse_name' => $stock->warehouse->name,
                        'quantity' => $stock->quantity,
                        'reserved_quantity' => $stock->reserved_quantity,
                        'available_quantity' => $stock->available_quantity,
                    ];
                }),
                'is_low_stock' => $product->isLowStock(),
                'is_out_of_stock' => $product->isOutOfStock(),
            ],
        ]);
    }

    /**
     * Update the specified product.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'category_id' => 'sometimes|required|exists:categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'sku' => 'sometimes|required|string|max:100|unique:products,sku,' . $product->id,
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'unit' => 'sometimes|required|string|max:50',
            'min_stock' => 'sometimes|required|integer|min:0',
            'max_stock' => 'nullable|integer|min:0',
            'purchase_price' => 'sometimes|required|numeric|min:0',
            'selling_price' => 'sometimes|required|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        $product->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully',
            'data' => $product->load(['category', 'supplier']),
        ]);
    }

    /**
     * Remove the specified product.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully',
        ]);
    }

    /**
     * Get low stock products.
     */
    public function lowStock()
    {
        $products = Product::with(['category', 'supplier', 'productStocks.warehouse'])
            ->whereRaw('(SELECT SUM(quantity) FROM product_stocks WHERE product_id = products.id) <= products.min_stock')
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'sku' => $product->sku,
                    'name' => $product->name,
                    'category' => $product->category->name,
                    'min_stock' => $product->min_stock,
                    'current_stock' => $product->getTotalStock(),
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $products,
        ]);
    }

    /**
     * Get stock history for a product.
     */
    public function stockHistory(Product $product)
    {
        $movements = $product->stockMovements()
            ->with(['warehouse', 'user'])
            ->latest()
            ->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $movements,
        ]);
    }

    /**
     * Upload product image.
     */
    public function uploadImage(Request $request, Product $product)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
        ]);

        try {
            // Delete old image if exists
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            // Store new image
            $imagePath = $request->file('image')->store('products', 'public');
            
            $product->update(['image' => $imagePath]);

            return response()->json([
                'success' => true,
                'message' => 'Product image uploaded successfully',
                'data' => [
                    'image_path' => $imagePath,
                    'image_url' => url('storage/' . $imagePath),
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload image: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Generate QR code for product.
     */
    public function generateQRCode(Product $product)
    {
        try {
            $renderer = new ImageRenderer(
                new RendererStyle(200),
                new SvgImageBackEnd()
            );
            
            $writer = new Writer($renderer);
            
            // QR code data - JSON with product info
            $qrData = json_encode([
                'type' => 'product',
                'id' => $product->id,
                'sku' => $product->sku,
                'name' => $product->name,
            ]);
            
            $qrCode = $writer->writeString($qrData);

            return response($qrCode)
                ->header('Content-Type', 'image/svg+xml')
                ->header('Content-Disposition', 'inline; filename="product-' . $product->sku . '.svg"');
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate QR code: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Scan/lookup product by QR code data.
     */
    public function scanQRCode(Request $request)
    {
        $request->validate([
            'qr_data' => 'required|string',
        ]);

        try {
            $data = json_decode($request->qr_data, true);

            if (!$data || !isset($data['type']) || $data['type'] !== 'product') {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid QR code format',
                ], 400);
            }

            $product = null;

            // Lookup by ID or SKU
            if (isset($data['id'])) {
                $product = Product::find($data['id']);
            } elseif (isset($data['sku'])) {
                $product = Product::where('sku', $data['sku'])->first();
            }

            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found',
                ], 404);
            }

            $product->load(['category', 'supplier', 'productStocks.warehouse']);

            return response()->json([
                'success' => true,
                'message' => 'Product found',
                'data' => [
                    'product' => $product,
                    'total_stock' => $product->getTotalStock(),
                    'stock_by_warehouse' => $product->productStocks->map(function ($stock) {
                        return [
                            'warehouse_id' => $stock->warehouse_id,
                            'warehouse_name' => $stock->warehouse->name,
                            'quantity' => $stock->quantity,
                            'available_quantity' => $stock->available_quantity,
                        ];
                    }),
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to scan QR code: ' . $e->getMessage(),
            ], 500);
        }
    }
}
