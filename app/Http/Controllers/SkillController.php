<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use App\Models\AdminLog;
use Illuminate\Http\Request;
use App\Http\Requests\CreateSkillRequest;
use App\Http\Requests\UpdateSkillRequest;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class SkillController extends Controller
{
    public function create(CreateSkillRequest $request)
    {
        Skill::create($validated = $request->validated());

        AdminLog::createLog('Created New Skill ' . $validated['name']);

        return response()->json([
            'status' => true,
            'message' => 'SKILL_CREATED_SUCCESSFULLY'
        ], 200);
    }

    public function update(UpdateSkillRequest $request, Skill $skill)
    {
        if ($skill->update($request->validated())) {

            AdminLog::createLog('Updated Game SKILL. ID:' . $skill->name);
            return response()->json([
                'status' => true,
                'message' => 'SKILL_UPDATED_SUCCESSFULLY'
            ], 200);
        }

        return response()->json([
            'status' => false,
            'message' => 'SKILL_UPDATE_FAILED'
        ], 400);
    }

    public function fetch()
    {
        // if (!auth()->user()->can('view-skills')) {
        //     throw new AccessDeniedHttpException();
        // }
        return Skill::orderBy('active_projects_count')->get();
    }
}
