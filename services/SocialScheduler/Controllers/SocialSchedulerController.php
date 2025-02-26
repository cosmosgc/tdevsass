<?php
namespace Services\SocialScheduler\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Services\SocialScheduler\Models\ScheduledPost;
use Services\SocialScheduler\Models\SchedulerSetting;
use Illuminate\Support\Facades\Http;

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
        // Validate faz a pagina voltar, não consigo nem ver o erro dela assim, vou averiguar depois
        // $request->validate([
        //     'content' => 'required',
        //     'scheduled_at' => 'required|date',
        //     'networks' => 'required|array',
        // ]);
        ScheduledPost::create([
            'user_id' => Auth::id(),
            'content' => $request->content,
            'scheduled_at' => $request->scheduled_at,
            'platforms' => json_encode($request->platforms),
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
    public function postToWordPress(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'featured_media' => 'nullable|integer',
            'categories' => 'nullable|array',
            'post_date' => 'nullable|date',
        ]);

        $user = Auth::user();
        $settings = SchedulerSetting::where('user_id', $user->id)->first();
        if (!$settings) {
            return redirect()->back()->with('error', 'Configurações não encontradas.');
        }

        $apiKeys = json_decode($settings->api_keys, true);
        $wordpressApiUrl = 'https://seuwordpress.com/wp-json/wp_manage/v1/post_create/';

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . ($apiKeys['wordpress'] ?? ''),
            'Accept' => 'application/json',
        ])->post($wordpressApiUrl, [
            'title' => $request->title,
            'content' => $request->content,
            'featured_media' => $request->featured_media ?? null,
            'categories' => $request->categories ?? [],
            'post_date' => $request->post_date ?? now()->format('Y-m-d H:i:s'),
        ]);

        if ($response->successful()) {
            return redirect()->back()->with('success', 'Postagem enviada para o WordPress!');
        }

        return redirect()->back()->with('error', 'Erro ao enviar a postagem: ' . $response->body());
    }

    public function postNow(ScheduledPost $post)
    {
        $platforms = json_decode($post->platforms, true);

        if (in_array('wordpress', $platforms)) {
            $settings = SchedulerSetting::where('user_id', $post->user_id)->first();
            if (!$settings) {
                return redirect()->back()->with('error', 'Configurações do usuário não encontradas.');
            }

            $apiKeys = json_decode($settings->api_keys, true);

            // Pegando os dados de autenticação do usuário
            $domain = $apiKeys['wordpress_domain'] ?? 'http://177.190.68.79:3000/tdev/';
            $login = $apiKeys['wordpress_login'] ?? "cosmosgc";
            $password = $apiKeys['wordpress_password'] ?? "34421282";

            if (!$login || !$password) {
                return redirect()->back()->with('error', 'Credenciais do WordPress não encontradas.');
            }

            // Endpoint oficial do WordPress para criar posts
            $wordpressApiUrl = $domain . '/wp-json/wp/v2/posts';

            $response = Http::withBasicAuth($login, $password)->post($wordpressApiUrl, [
                'title' => 'Postagem Instantânea',
                'content' => $post->content,
                'status' => 'publish',
            ]);

            if ($response->successful()) {
                $post->update(['posted_at' => now()]);

                return redirect()->back()->with('success', 'Postagem enviada com sucesso!');
            } else {
                return redirect()->back()->with('error', 'Erro ao postar: ' . $response->body());
            }
        }

        return redirect()->back()->with('error', 'Nenhuma plataforma configurada.');
    }
}
