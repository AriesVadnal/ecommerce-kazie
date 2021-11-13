<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\SubSubCategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function SubCategoryView()
    {
        $categories = Category::orderBy('category_name_en', 'ASC')->get();
        $subcategory = SubCategory::latest()->get();
        return view('backend.category.subcategory_view', compact('subcategory','categories'));
    }

    public function SubCategoryStore(Request $request)
    {

        $request->validate([
            'category_id' => 'required',
            'subcategory_name_en' => 'required',
            'subcategory_name_hin' => 'required'
        ], [
            'subcategory_id.required' => 'Please Select Any Option',
            'subcategory_name_en.required' => 'Input Category Name English'
        ]);

        SubCategory::insert([
            'category_id' => $request->category_id,
            'subcategory_name_en' => $request->subcategory_name_en,
            'subcategory_name_hin' => $request->subcategory_name_hin,
            'subcategory_slug_en' => Str::slug($request->subcategory_name_en),
            'subcategory_slug_hin' => Str::slug($request->subcategory_name_hin)
        ]);

        $notification = array(
            'message' => 'Sub Category Input Successfull',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function SubCategoryEdit($id)
    {
        $categories = Category::orderBy('category_name_en','ASC')->get();
        $subcategory = SubCategory::findOrFail($id);
        return view('backend.category.subcategory_edit', compact('categories','subcategory'));
    }

    public function SubCategoryUpdate(Request $request, $id)
    {
        SubCategory::findOrFail($id)->update([
            'category_id' => $request->category_id,
            'subcategory_name_en' => $request->subcategory_name_en,
            'subcategory_name_hin' => $request->subcategory_name_hin,
            'subcategory_slug_en' => Str::slug($request->subcategory_name_en),
            'subcategory_slug_hin' => Str::slug($request->subcategory_name_hin)
        ]);

        $notification = array(
            'message' => 'SubCategory Updated Successfull',
            'alert-type' => 'success'
        );

        return redirect()->route('all.subcategory')->with($notification);
    }

    public function SubCategoryDelete($id)
    {
        SubCategory::findOrFail($id)->delete();
        $notification = array(
            'message' => 'SubCategory Updated Successfull',
            'alert-type' => 'success'
        );

        return redirect()->route('all.subcategory')->with($notification);
    }

    public function SubSubCategoryView()
    {
        $subsubcategory = SubSubCategory::latest()->get();
        $categories = Category::orderBy('category_name_en','ASC')->get();
        return view('backend.category.sub_subcategory_view', compact('subsubcategory','categories'));
    }

    public function GetSubCategory($category_id)
    {
        $subcat = SubCategory::where('category_id', $category_id)->orderBy('subcategory_name_en','ASC')->get();
        return json_encode($subcat);


    }

    public function GetSubSubCategory($subcategory_id){

        $subsubcat = SubSubCategory::where('subcategory_id',$subcategory_id)->orderBy('subsubcategory_name_en','ASC')->get();
        return json_encode($subsubcat);
     }

    public function SubSubCategoryStore(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'subcategory_id' => 'required',
            'subsubcategory_name_en' => 'required',
            'subsubcategory_name_hin' => 'required'
        ],[
            'category_id.required' => 'Select Category Any Option',
            'subsubcategory_name_en' => 'Input SubSubCategory English Name'
        ]);

        SubSubCategory::insert([
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'subsubcategory_name_en' => $request->subsubcategory_name_en,
            'subsubcategory_name_hin' => $request->subsubcategory_name_hin,
            'subsubcategory_slug_en' => Str::slug($request->subsubcategory_name_en),
            'subsubcategory_slug_hin' => Str::slug($request->subsubcategory_name_hin)
        ]);

        $notification = array(
            'message' => 'Sub Subcategory Inserted Successfull',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function SubSubCategoryEdit($id)
    {
        $categories = Category::orderBy('category_name_en', 'ASC')->get();
        $subcategories = SubCategory::orderBy('subcategory_name_en', 'ASC')->get();
        $subsubcategories = SubSubCategory::findOrFail($id);
        return view('backend.category.sub_subcategory_edit', compact('categories','subcategories','subsubcategories'));
    }

    public function SubSubCategoryUpdate(Request $request, $id)
    {
        SubSubCategory::findOrFail($id)->update([
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'subsubcategory_name_en' => $request->subsubcategory_name_en,
            'subsubcategory_name_hin' => $request->subsubcategory_name_hin,
            'subsubcategory_slug_en' => Str::slug($request->subsubcategory_name_en),
            'subsubcategory_slug_hin' => Str::slug($request->subsubcategory_name_hin)
        ]);

        $notification = array(
            'message' => 'SubSubCategory Updated Successfull',
            'alert-type' => 'success'
        );

        return redirect()->route('all.subsubcategory')->with($notification);
    }

    public function SubSubCategoryDelete($id)
    {
        SubSubCategory::findOrFail($id)->delete();

        $notification = array(
            'message' => 'SubSubCategory Deleted Successfull',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
}
