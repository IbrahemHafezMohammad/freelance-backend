<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\CreateCategoryRequest;

class CategoryController extends Controller
{
    public function create(CreateCategoryRequest $request)
    {
        Category::create($request->getCategoryData());

        return response()->json([
            'status' => true,
            'message' => 'CATEGORY_CREATED_SUCCESSFULLY'
        ], 200);
    }
}
