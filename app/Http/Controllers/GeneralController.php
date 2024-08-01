<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class GeneralController extends Controller
{
    public function uploadFile(Request $request)
    {
        if (!$request->hasFile('file')) {
            return response()->json([
                'message' => 'File not found'
            ], 404);
        }

        $folderName = $request->name ?? 'images';

        $path = Storage::putFile('public/' . $folderName, $request->file('file'));
        $relativePath = Storage::url($path);
        $fullUrl = URL::to($relativePath);

        return response()->json([
            'status' => 'success',
            'path' => $path,
            'link' => $fullUrl
        ]);
    }
}
