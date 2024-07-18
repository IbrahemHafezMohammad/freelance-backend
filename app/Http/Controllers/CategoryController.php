<?php

namespace App\Http\Controllers;

use App\Models\AdminLog;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Services\WebService\WebRequestService;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class CategoryController extends Controller
{
    public function create(CreateCategoryRequest $request)
    {
        Category::create($request->getCategoryData());

        AdminLog::createLog('Created New Category ' . $request->en);

        return response()->json([
            'status' => true,
            'message' => 'CATEGORY_CREATED_SUCCESSFULLY'
        ], 200);
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        if ($category->update($request->getCategoryData())) {

            AdminLog::createLog('Updated Category :' . $category->name);
            return response()->json([
                'status' => true,
                'message' => 'CATEGORY_UPDATED_SUCCESSFULLY'
            ], 200);
        }

        return response()->json([
            'status' => false,
            'message' => 'CATEGORY_UPDATE_FAILED'
        ], 400);
    }

    public function fetch()
    {
        if (!auth()->user()->can('view-categories')) {
            throw new AccessDeniedHttpException();
        }
        return Category::all();
    }

    public function toggleStatus(Category $category)
    {
        if (!auth()->user()->can('toggle-category-status')) {
            throw new AccessDeniedHttpException();
        }
        
        if ($category->update(['status' => !$category->status])) {

            AdminLog::createLog('Changed Category (' . $category->name . ') status from ' . (!$category->status ? "on" : "off")  . ' to ' . ($category->status ? "on" : "off"));
            return response()->json([
                'status' => true,
                'message' => 'STATUS_UPDATED_SUCCESSFULLY'
            ], 200);
        }

        return response()->json([
            'status' => false,
            'message' => 'STATUS_UPDATE_FAILED'
        ], 400);
    }
}
