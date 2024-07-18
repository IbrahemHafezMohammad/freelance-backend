<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PostJobRequest;
use App\Models\JobPost;

class JobPostController extends Controller
{
    public function post(PostJobRequest $request)
    {
        $validated = $request->validated();

        $post = JobPost::create($request->getPostData($validated));

        $post->skills()->sync($validated['skills']);

        return response()->json([
            'status' => true,
            'message' => 'POST_CREATED_SUCCESSFULLY'
        ], 200);
    }
}
