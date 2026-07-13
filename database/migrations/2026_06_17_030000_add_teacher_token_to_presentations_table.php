<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('presentations', function (Blueprint $table) {
            $table->string('teacher_token')->nullable()->unique()->after('token');
        });

        DB::table('presentations')->orderBy('id')->get()->each(function ($presentation) {
            DB::table('presentations')
                ->where('id', $presentation->id)
                ->update(['teacher_token' => Str::random(32)]);
        });
    }

    public function down(): void
    {
        Schema::table('presentations', function (Blueprint $table) {
            $table->dropUnique(['teacher_token']);
            $table->dropColumn('teacher_token');
        });
    }
};
