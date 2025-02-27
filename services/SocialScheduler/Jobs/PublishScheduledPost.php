<?php
namespace Services\SocialScheduler\Jobs;

use Services\SocialScheduler\Models\ScheduledPost;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class PublishScheduledPost implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $post;

    public function __construct(ScheduledPost $post)
    {
        $this->post = $post;
    }

    public function handle()
    {
        $networks = json_decode($this->post->networks, true);

        if (in_array('wordpress', $networks)) {
            $settings = $this->post->user->schedulerSetting;
            if (!$settings) {
                // Log::error('Configurações do usuário não encontradas.');
                return;
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
            $wordpressApiUrl = rtrim($domain, '/') . '/wp-json/wp/v2/posts';

            $response = Http::withBasicAuth($login, $password)->post($wordpressApiUrl, [
                'title'   => 'Postagem Instantânea',
                'content' => $this->post->content, // Mudança para `$this->post`
                'status'  => 'publish',
            ]);

            if ($response->successful()) {
                $this->post->update(['posted_at' => now()]); // Garantindo que `$this->post` seja usado corretamente

                // return redirect()->back()->with('success', 'Postagem enviada com sucesso!');
            } else {
                // return redirect()->back()->with('error', 'Erro ao postar: ' . $response->body());
            }
        }
    }
}
