<?php
namespace Services\SocialScheduler\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Services\SocialScheduler\Models\ScheduledPost;
use Services\SocialScheduler\Models\SchedulerSetting;

class SocialSchedulerController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $posts = ScheduledPost::where('user_id', $user->id)->get();
        $settings = SchedulerSetting::where('user_id', $user->id)->first();
        $redes = ['facebook' => 'Facebook', 'twitter' => 'Twitter', 'wordpress' => 'WordPress'];

        return view('SocialScheduler::index', compact('posts', 'redes', 'settings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required',
            'scheduled_at' => 'required|date',
            'networks' => 'required|array',
        ]);

        ScheduledPost::create([
            'user_id' => Auth::id(),
            'content' => $request->content,
            'scheduled_at' => $request->scheduled_at,
            'networks' => json_encode($request->networks),
        ]);

        return redirect()->back()->with('success', 'Postagem agendada!');
    }

    public function settings()
    {
        $user = Auth::user();
        $settings = SchedulerSetting::where('user_id', $user->id)->first();

        $enabledNetworks = $settings ? json_decode($settings->enabled_networks, true) : [];
        $apiKeys = $settings ? json_decode($settings->api_keys, true) : [];
        $redes = [
            'facebook' => 'Facebook',
            'twitter' => 'Twitter',
            'wordpress' => 'WordPress'
        ];

        return view('SocialScheduler::settings', compact('enabledNetworks', 'apiKeys', 'redes'));
    }


    public function saveSettings(Request $request)
    {
        $user = Auth::user();

        // Collect API keys into an array
        $apiKeys = [
            'facebook' => $request->facebook_api ?? '',
            'twitter' => $request->twitter_api ?? '',
            'wordpress' => $request->wordpress_api ?? '',
        ];

        $settings = SchedulerSetting::updateOrCreate(
            ['user_id' => $user->id],
            [
                'user_id' => $user->id,
                'enabled_networks' => json_encode($request->enabled_networks ?? []),
                'api_keys' => json_encode($apiKeys) // Store the collected API keys
            ]
        );

        return redirect()->back()->with('success', 'Configurações salvas!');
    }

}
