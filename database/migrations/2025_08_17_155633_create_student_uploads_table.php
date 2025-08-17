<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('student_uploads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('upload_point_id')->constrained()->cascadeOnDelete();
            $table->string('file_path', 2048);
            $table->text('note')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['upload_point_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_uploads');
    }
};
