<?php
namespace Services\SocialScheduler\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Services\SocialScheduler\Models\ScheduledPost;

class SocialSchedulerController extends Controller
{
    public function index()
    {
        $posts = ScheduledPost::all();
        return view('SocialScheduler::index', compact('posts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required',
            'scheduled_at' => 'required|date',
        ]);

        ScheduledPost::create($request->all());

        return redirect()->back()->with('success', 'Postagem agendada!');
    }
}
