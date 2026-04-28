<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Mydnic\Volet\Models\FeedbackMessage;
use Mydnic\Volet\Features\FeatureManager;
use App\Mail\FeedbackReceived;
use App\Models\User;

class FeedbackController extends Controller
{
    protected FeatureManager $features;

    public function __construct(FeatureManager $features)
    {
        $this->features = $features;
    }

    public function store(Request $request)
    {
        // Ambil kategori yang valid dari Volet
        $categories = collect(
            $this->features
                ->getFeature('feedback-messages')
                ->getCategories()
        )->pluck('slug')->toArray();

        // Validasi input
        $validated = $request->validate([
            'message' => 'required|string|max:255',
            'category' => 'required|string|in:'.implode(',', $categories),
            'user_info' => 'nullable|array',
        ]);

        // Simpan feedback
        $feedback = FeedbackMessage::create([
            'message' => $validated['message'],
            'category' => $validated['category'],
            'user_info' => $this->getUserInfo($request),
        ]);

        $userInfo = $feedback->user_info ?? [];

        // Ambil nama user dari user_id
        if (!empty($userInfo['user_id'])) {
            $user = User::find($userInfo['user_id']);
            $userInfo['user_name'] = $user ? $user->name : 'Anonymous';
        } else {
            $userInfo['user_name'] = 'Anonymous';
        }

        // Ambil email dan name
        $name = $userInfo['user_name'];
        $email = $userInfo['email'] ?? 'N/A';

        // Kirim email lengkap dengan semua info
        Mail::to('sek.esd@siix-global.com')->send(new FeedbackReceived([
            'name' => $name,
            'email' => $email,
            'category' => $feedback->category,
            'message' => $feedback->message,
            'user_info' => $userInfo,
        ]));

        return response()->json($feedback, 201);
    }

    protected function getUserInfo(Request $request): array
    {
        return array_merge([
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'url' => $request->header('referer'),
            'language' => $request->getPreferredLanguage(),
            'user_id' => auth()->check() ? auth()->id() : null,
            'viewportWidth' => $request->input('viewportWidth'),
            'viewportHeight' => $request->input('viewportHeight'),
        ], $request->user_info ?? []);
    }
}
