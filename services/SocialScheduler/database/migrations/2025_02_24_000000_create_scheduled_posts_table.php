<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('scheduled_posts', function (Blueprint $table) {
            $table->id();
            $table->text('content');
            $table->timestamp('scheduled_at');
            $table->json('platforms')->nullable();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('scheduled_posts');
    }
};
