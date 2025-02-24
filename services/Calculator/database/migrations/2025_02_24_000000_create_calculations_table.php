<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('calculations', function (Blueprint $table) {
            $table->id();
            $table->decimal('num1', 10, 2);
            $table->decimal('num2', 10, 2);
            $table->string('operation');
            $table->decimal('result', 10, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('calculations');
    }
};
