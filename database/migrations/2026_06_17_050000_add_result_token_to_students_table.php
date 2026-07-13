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
        Schema::table('students', function (Blueprint $table) {
            $table->string('result_token')->nullable()->unique()->after('name');
        });

        DB::table('students')->orderBy('id')->get()->each(function ($student) {
            DB::table('students')
                ->where('id', $student->id)
                ->update(['result_token' => Str::random(32)]);
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropUnique(['result_token']);
            $table->dropColumn('result_token');
        });
    }
};
