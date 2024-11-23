<?php

namespace App\Http\Controllers\Dashboard\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:categories');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $order_by = $request->order_by ?? 'desc';
        $sort_by = $request->sort_by ?? 'id';
        $limit_by = $request->limit_by ?? 5;

        $categories = Category::withCount('posts')
            ->when($request->keyword, function ($query) use ($request) {
                $query->where('name', 'LIKE', '%' . $request->keyword . '%');
            })
            ->when(!is_null($request->status), function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->orderBy($sort_by, $order_by)
            ->paginate($limit_by);

        return view('dashboard.categories.index', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $category = Category::create($request->except('_token'));
        if (!$category) {
            setFlashMessage('error',  ' Try again latter!');
            return redirect()->route('dashboard.categories.index');
        }
        setFlashMessage('success', 'Category Created Suuccessfully!');
        return redirect()->route('dashboard.categories.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function update(CategoryRequest $request, string $id)
    {
        $category = Category::findOrFail($id);
        $category = $category->update($request->except(['_token', '_method']));
        if (!$category) {
            setFlashMessage('error', ' Try Again Latter!');
            return redirect()->route('dashboard.categories.index');
        }

        setFlashMessage('success', 'Category Deleted Suuccessfully!');
        return redirect()->route('dashboard.categories.index');
    }

    public function changeStatus($id)
    {
        $category = Category::findOrFail($id);

        if ($category->status == 1) {
            $category->update([
                'status' => 0
            ]);
            setFlashMessage('success', 'Category Blocked Successfully');
        } elseif ($category->status == 0) {
            $category->update([
                'status' => 1
            ]);
            setFlashMessage('success', 'Category Active Successfully');
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);

        $category->delete();

        setFlashMessage('success', 'Category Deleted Successfully');

        return to_route('dashboard.categories.index');
    }
}
