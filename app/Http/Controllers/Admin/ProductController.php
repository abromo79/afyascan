<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesUploads;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductController extends Controller
{
    use HandlesUploads;

    public function index(): View
    {
        return view('admin.products.index', [
            'products' => Product::ordered()->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.products.form', [
            'product' => new Product,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->productData($request);

        $data['slug'] = Str::slug($data['name']);
        $data['is_published'] = $request->boolean('is_published');
        $data['image'] = $this->storeImage($request->file('image'), 'products');

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Product created.');
    }

    public function edit(Product $product): View
    {
        return view('admin.products.form', [
            'product' => $product,
        ]);
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $data = $this->productData($request);

        $data['is_published'] = $request->boolean('is_published');
        $data['image'] = $this->storeImage($request->file('image'), 'products', $product->image);

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Product updated.');
    }

    public function publish(Product $product): RedirectResponse
    {
        $product->update(['is_published' => ! $product->is_published]);

        return back()->with('success', $product->is_published ? 'Product published.' : 'Product unpublished.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $this->deleteImage($product->image);
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted.');
    }

    /**
     * @return array<string, mixed>
     */
    private function productData(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'label' => ['nullable', 'string', 'max:255'],
            'short_description' => ['nullable', 'string', 'max:1000'],
            'description' => ['nullable', 'string'],
            'features' => ['nullable', 'string'],
            'icon' => ['nullable', 'string', 'max:255'],
            'display_order' => ['nullable', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:4096'],
        ]);
    }
}
