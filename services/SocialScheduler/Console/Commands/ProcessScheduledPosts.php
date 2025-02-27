<?php
namespace Services\SocialScheduler\Console\Commands;

use Illuminate\Console\Command;
use Services\SocialScheduler\Models\ScheduledPost;
use Services\SocialScheduler\Jobs\PublishScheduledPost;
use Carbon\Carbon;

class ProcessScheduledPosts extends Command
{
    protected $signature = 'posts:publish';
    protected $description = 'Verifica e publica postagens agendadas no horário correto.';

    public function handle()
    {
        $now = Carbon::now();

        $posts = ScheduledPost::where('scheduled_at', '<=', $now)
            ->whereNull('posted_at')
            ->get();

        foreach ($posts as $post) {
            PublishScheduledPost::dispatch($post);
            $post->update(['posted_at' => $now]); // Evita reprocessamento
        }

        $this->info('Postagens processadas.');
    }
}
