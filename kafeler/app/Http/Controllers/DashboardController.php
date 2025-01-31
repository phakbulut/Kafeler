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
        $categories = auth()->user()->categories()->latest()->get();
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'user_id' => auth()->id(),
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
        abort_if($category->user_id !== auth()->id(), 403);
        return view('userdashboard.categories.edit', compact('category'));
    }

    public function categoriesUpdate(Request $request, Category $category)
    {
        abort_if($category->user_id !== auth()->id(), 403);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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
        abort_if($category->user_id !== auth()->id(), 403);

        if ($category->image) {
            Storage::delete('public/category_images/' . $category->image);
        }

        $category->delete();

        return response()->json(['message' => 'Kategori başarıyla silindi.']);
    }

    public function categoriesBulkDelete(Request $request)
    {
        $ids = $request->input('ids');
        $categories = Category::whereIn('id', $ids)->where('user_id', auth()->id())->get();

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
        abort_if($category->user_id !== auth()->id(), 403);

        $category->update(['status' => !$category->status]);

        return response()->json(['message' => 'Status başarıyla değiştirildi.', 'status' => $category->status]);
    }
}