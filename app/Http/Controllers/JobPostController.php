<?php

namespace App\Http\Controllers;

use App\Models\JobPost;
use Illuminate\Http\Request;
use App\Http\Requests\PostJobRequest;
use App\Http\Requests\ListJobsRequest;

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

    public function list(ListJobsRequest $request)
    {
        $validated = $request->validated();

        $user = $request->user();

        $posts = JobPost::listJobs($request->validated(), $user)->orderByDesc('id')->paginate(10);

        return response()->json([
            'status' => true,
            'posts' => $posts,
        ]);
    }
}
