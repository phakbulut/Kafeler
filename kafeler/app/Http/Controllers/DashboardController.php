<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\CafeBanner;
use Illuminate\Support\Str;



class DashboardController extends Controller
{

    /*kullanıcı ayar sayfası */
    public function settings()
    {
        $user = Auth::user();
        return view('userdashboard.settings', compact('user'));
    }

    public function updateSettings(Request $request)
    {

        try {
            DB::beginTransaction();

            $user = Auth::user();
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'surname' => 'required|string|max:255',
                'cafe_name' => 'required|string|max:255',
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'password' => 'nullable|string|min:8|confirmed',
            ]);

            $user->update([
                'name' => $validated['name'],
                'surname' => $validated['surname'],
                'slug' => Str::slug($validated['cafe_name']), 
                'cafe_name' => $validated['cafe_name'],
                'status' => $request->has('status') ? 1 : 0,
            ]);

            if ($request->hasFile('avatar')) {
                if ($user->avatar) {
                    Storage::delete('public/avatars/' . $user->avatar);
                }
                $avatarPath = $request->file('avatar')->store('avatars', 'public');
                $user->update(['avatar' => basename($avatarPath)]);
            }

            if ($request->filled('password')) {
                $user->update(['password' => Hash::make($validated['password'])]);
            }

            DB::commit();
            return redirect()->route('dashboard.settings')->with('success', 'Ayarlar başarıyla güncellendi.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return redirect()->route('dashboard.settings')->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Ayarlar güncelleme hatası: ' . $e->getMessage());
            return redirect()->route('dashboard.settings')->with('error', 'Bir hata oluştu. Lütfen tekrar deneyin.');
        }
    }



    /* kategori sayfası */
    public function categoriesIndex()
    {
        $categories = Auth::user()->categories()->latest()->get();
        return view('userdashboard.categories.index', compact('categories'));
    }

    public function categoriesCreate()
    {
        return view('userdashboard.categories.create');
    }

    public function categoriesStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = [
            'user_id' => Auth::id(),
            'name' => $validated['name'],
            'slug' => \Str::slug($validated['name']),
            'status' => $request->has('status') ? 1 : 0,
        ];

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('category_images', 'public');
            $data['image'] = basename($imagePath);
        }

        Category::create($data);

        return redirect()->route('dashboard.categories.index')->with('success', 'Kategori başarıyla eklendi.');
    }

    public function categoriesEdit(Category $category)
    {
        abort_if($category->user_id !== Auth::id(), 403);
        return view('userdashboard.categories.edit', compact('category'));
    }

    public function categoriesUpdate(Request $request, Category $category)
    {
        abort_if($category->user_id !== Auth::id(), 403);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = [
            'name' => $validated['name'],
            'slug' => \Str::slug($validated['name']),
            'status' => $request->has('status') ? 1 : 0,
        ];

        if ($request->hasFile('image')) {
            if ($category->image) {
                Storage::delete('public/category_images/' . $category->image);
            }
            $imagePath = $request->file('image')->store('category_images', 'public');
            $data['image'] = basename($imagePath);
        }

        $category->update($data);

        return redirect()->route('dashboard.categories.index')->with('success', 'Kategori başarıyla güncellendi.');
    }

    public function categoriesDestroy(Category $category)
    {
        abort_if($category->user_id !== Auth::id(), 403);

        if ($category->image) {
            Storage::delete('public/category_images/' . $category->image);
        }

        $category->delete();

        return response()->json(['message' => 'Kategori başarıyla silindi.']);
    }

    public function categoriesBulkDelete(Request $request)
    {
        $ids = $request->input('ids');
        $categories = Category::whereIn('id', $ids)->where('user_id', Auth::id())->get();

        foreach ($categories as $category) {
            if ($category->image) {
                Storage::delete('public/category_images/' . $category->image);
            }
            $category->delete();
        }

        return response()->json(['message' => 'Seçilen kategoriler başarıyla silindi.']);
    }

    public function categoriesToggleStatus(Category $category)
    {
        abort_if($category->user_id !== Auth::id(), 403);

        $category->update(['status' => !$category->status]);

        return response()->json(['message' => 'Status başarıyla değiştirildi.', 'status' => $category->status]);
    }


    /*ürünler sayfası*/
    public function productsIndex()
    {
        $products = Auth::user()->products()->latest()->get();
        return view('userdashboard.products.index', compact('products'));
    }

    public function productsCreate()
    {
        $categories = Auth::user()->categories()->pluck('name', 'id');
        return view('userdashboard.products.create', compact('categories'));
    }

    public function productsStore(Request $request)
    {
        DB::beginTransaction();
        try {
            $validated = $request->validate([
                'category_id' => 'required|exists:categories,id',
                'name' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'description' => 'nullable|string',
                'main_image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'slider_images' => 'nullable|array',
                'slider_images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            ]);

            $data = [
                'user_id' => Auth::id(),
                'category_id' => $validated['category_id'],
                'name' => $validated['name'],
                'slug' => \Str::slug($validated['name']),
                'price' => $validated['price'],
                'description' => $validated['description'] ?? null,
                'status' => $request->has('status') ? 1 : 0,
            ];

            if ($request->hasFile('main_image')) {
                $mainImagePath = $request->file('main_image')->store('product_main_images', 'public');
                $data['main_image'] = basename($mainImagePath);
            }

            $product = Product::create($data);

            if ($request->hasFile('slider_images')) {
                foreach ($request->file('slider_images') as $image) {
                    $sliderImagePath = $image->store('product_slider_images', 'public');
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image' => basename($sliderImagePath),
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('dashboard.products.index')->with('success', 'Ürün başarıyla eklendi.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Ürün ekleme hatası: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Bir hata oluştu. Lütfen tekrar deneyin.');
        }
    }

    public function productsEdit(Product $product)
    {
        abort_if($product->user_id !== Auth::id(), 403);
        $categories = Auth::user()->categories()->pluck('name', 'id');
        return view('userdashboard.products.edit', compact('product', 'categories'));
    }

    public function productsUpdate(Request $request, Product $product)
    {
        DB::beginTransaction();
        try {
            abort_if($product->user_id !== Auth::id(), 403);

            $validated = $request->validate([
                'category_id' => 'required|exists:categories,id',
                'name' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'description' => 'nullable|string',
                'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'slider_images' => 'nullable|array',
                'slider_images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            ]);

            $data = [
                'category_id' => $validated['category_id'],
                'name' => $validated['name'],
                'slug' => \Str::slug($validated['name']),
                'price' => $validated['price'],
                'description' => $validated['description'] ?? null,
                'status' => $request->has('status') ? 1 : 0,
            ];

            if ($request->hasFile('main_image')) {
                if ($product->main_image) {
                    Storage::delete('public/product_main_images/' . $product->main_image);
                }
                $mainImagePath = $request->file('main_image')->store('product_main_images', 'public');
                $data['main_image'] = basename($mainImagePath);
            }

            $product->update($data);

            if ($request->hasFile('slider_images')) {
                foreach ($request->file('slider_images') as $image) {
                    $sliderImagePath = $image->store('product_slider_images', 'public');
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image' => basename($sliderImagePath),
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('dashboard.products.index')->with('success', 'Ürün başarıyla güncellendi.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Ürün güncelleme hatası: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Bir hata oluştu. Lütfen tekrar deneyin.');
        }
    }

    public function productsDestroy(Product $product)
    {
        abort_if($product->user_id !== Auth::id(), 403);

        if ($product->main_image) {
            Storage::delete('public/product_main_images/' . $product->main_image);
        }

        foreach ($product->images as $image) {
            Storage::delete('public/product_slider_images/' . $image->image);
            $image->delete();
        }

        $product->delete();

        return response()->json(['message' => 'Ürün başarıyla silindi.']);
    }

    public function productsBulkDelete(Request $request)
    {
        $ids = $request->input('ids');
        $products = Product::whereIn('id', $ids)->where('user_id', Auth::id())->get();

        foreach ($products as $product) {
            if ($product->main_image) {
                Storage::delete('public/product_main_images/' . $product->main_image);
            }

            foreach ($product->images as $image) {
                Storage::delete('public/product_slider_images/' . $image->image);
                $image->delete();
            }

            $product->delete();
        }

        return response()->json(['message' => 'Seçilen ürünler başarıyla silindi.']);
    }

    public function toggleStatus(Product $product)
    {
        abort_if($product->user_id !== Auth::id(), 403);

        if (!$product->category_id || !$product->main_image) {
            return response()->json([
                'message' => 'Status değiştirilemez. Ürünün eksik bilgileri var.',
                'missing' => [
                    'category' => !$product->category_id ? 'Kategori seçilmemiş.' : null,
                    'main_image' => !$product->main_image ? 'Ana resim yüklenmemiş.' : null,
                ],
            ], 400);
        }

        $product->update(['status' => !$product->status]);

        return response()->json(['message' => 'Status başarıyla değiştirildi.', 'status' => $product->status]);
    }
    public function removeImage(ProductImage $image)
    {
        abort_if($image->product->user_id !== Auth::id(), 403);

        Storage::delete('public/product_slider_images/' . $image->image);
        $image->delete();

        return response()->json(['message' => 'Resim başarıyla silindi.']);
    }


    /* banners sayfası */
    public function bannersIndex()
    {
        $banners = auth()->user()->cafeBanners()->latest()->get();
        return view('userdashboard.banners.index', compact('banners'));
    }

    public function bannersCreate()
    {
        return view('userdashboard.banners.create');
    }

    public function bannersStore(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $imagePath = $request->file('image')->store('banner_images', 'public');

        auth()->user()->cafeBanners()->create([
            'image' => $imagePath,
            'status' => $request->has('status'),
        ]);

        return redirect()->route('dashboard.banners.index')->with('success', 'Banner başarıyla eklendi.');
    }

    public function bannersEdit(CafeBanner $banner)
    {
        return view('userdashboard.banners.edit', compact('banner'));
    }

    public function bannersUpdate(Request $request, CafeBanner $banner)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($banner->image);
            $imagePath = $request->file('image')->store('banner_images', 'public');
            $banner->image = $imagePath;
        }

        $banner->status = $request->has('status');
        $banner->save();

        return redirect()->route('dashboard.banners.index')->with('success', 'Banner başarıyla güncellendi.');
    }

    public function bannersDestroy(CafeBanner $banner)
    {
        Storage::disk('public')->delete($banner->image);
        $banner->delete();
        return response()->json(['success' => 'Banner silindi.']);
    }

    public function bannersBulkDelete(Request $request)
    {
        $ids = $request->ids;

        foreach ($ids as $id) {
            $banner = CafeBanner::findOrFail($id);
            Storage::disk('public')->delete($banner->image);
            $banner->delete();
        }

        return response()->json([
            'message' => 'Seçilen bannerlar başarıyla silindi!',
            'deleted_count' => count($ids)
        ]);
    }
    public function bannersToggleStatus(CafeBanner $banner)
    {
        $banner->update(['status' => !$banner->status]);
        return response()->json([
            'message' => 'Durum güncellendi.',
            'new_status' => $banner->status
        ]);
    }
}
