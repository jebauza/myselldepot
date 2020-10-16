<?php

namespace App\Http\Controllers\CMS\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryStoreUpdateRequest;

class CategoryCmsApiController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::name($request->name)->description($request->description)
                        ->orderBy('name')->paginate();

        return $categories;
    }

    public function store(CategoryStoreUpdateRequest $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        $new_category = new Category($request->all());
        $new_category->created_by = $request->user()->id;
        $new_category->updated_by = $request->user()->id;
        if($new_category->save()) {
            return response()->json(['msg'=>__('Save successfully'), 'category'=>$new_category], 201);
        }

        return response()->json(['msg_error' => __('Internal Server Error')], 500);
    }

    public function show($id)
    {
        //
    }

    public function update(CategoryStoreUpdateRequest $request, $id)
    {
        if(!$category = Category::find($id)){
            return response()->json(['msg_error' => __('Not found')], 404);
        }

        $category->fill($request->all());
        $category->updated_by = $request->user()->id;
        if($category->save()) {
            return response()->json(['msg'=>__('Save successfully'), 'category'=>$category], 200);
        }

        return response()->json(['msg_error' => __('Internal Server Error')], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
