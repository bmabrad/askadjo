<?php

namespace App\Http\Controllers;

use App\Models\CoachingSession;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class ScreenshotController extends Controller
{
    public function show(string $filename): Response
    {
        $disk = Storage::disk('screenshots');

        if (! $disk->exists($filename)) {
            abort(404);
        }

        // Verify the authenticated user owns this screenshot
        $session = CoachingSession::whereJsonContains('screenshot_path', $filename)
            ->whereHas('contact', fn ($q) => $q->where('user_id', auth()->id()))
            ->first();

        if (! $session) {
            abort(403);
        }

        return response($disk->get($filename), 200, [
            'Content-Type' => $disk->mimeType($filename),
            'Cache-Control' => 'private, max-age=3600',
        ]);
    }
}
