<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function CategoryView()
    {
        $category = Category::latest()->get();
        return view('backend.category.category_view', compact('category'));
    }

    public function CategoryStore(Request $request)
    {
        $request->validate([
            'category_name_en' => 'required',
            'category_name_hin' => 'required',
            'category_icon' => 'required',
        ], [
            'category_name_en.required' => 'Input Category Name English',
            'category_name_hin.required' => 'Input Category Name Hindi',
        ]);

        Category::insert([
            'category_name_en' => $request->category_name_en,
            'category_name_hin' => $request->category_name_hin,
            'category_slug_en' => Str::slug($request->category_name_en),
            'category_slug_hin' => Str::slug($request->category_name_hin),
            'category_icon' => $request->category_icon
        ]);

        $notification = array(
            'success' => 'Category Inserted Successfull',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function CategoryEdit($id)
    {
        $category = Category::findOrFail($id);
        return view('backend.category.category_edit', compact('category'));
    }

    public function CategoryUpdate(Request $request, $id)
    {
        Category::findOrFail($id)->update([
            'category_name_en' => $request->category_name_en,
            'category_name_hin' => $request->category_name_hin,
            'category_slug_en' => Str::slug($request->category_name_en),
            'category_slug_hin' => Str::slug($request->category_name_hin),
            'category_icon' => $request->category_icon
        ]);

        $notification = array(
            'message' => 'Category Updated Successfull',
            'alert-type' => 'success'
        );

        return redirect()->route('view.category')->with($notification);
    }

    public function CategoryDelete($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        $notification = array(
            'message' => 'Category Deleted Successfull',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
}
