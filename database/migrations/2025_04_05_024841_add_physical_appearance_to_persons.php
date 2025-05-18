<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('persons', function (Blueprint $table): void {
            $table->text('height')->nullable()->after('languages');
            $table->text('weight')->nullable()->after('height');
            $table->text('build')->nullable()->after('weight');
            $table->text('skin_tone')->nullable()->after('build');
            $table->text('face_shape')->nullable()->after('skin_tone');
            $table->text('eye_color')->nullable()->after('face_shape');
            $table->text('eye_shape')->nullable()->after('eye_color');
            $table->text('hair_color')->nullable()->after('eye_shape');
            $table->text('hair_type')->nullable()->after('hair_color');
            $table->text('hair_length')->nullable()->after('hair_type');
            $table->text('facial_hair')->nullable()->after('hair_length');
            $table->text('scars')->nullable()->after('facial_hair');
            $table->text('tatoos')->nullable()->after('scars');
            $table->text('piercings')->nullable()->after('tatoos');
            $table->text('distinctive_marks')->nullable()->after('piercings');
            $table->text('glasses')->nullable()->after('distinctive_marks');
            $table->text('dress_style')->nullable()->after('glasses');
            $table->text('voice')->nullable()->after('dress_style');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('persons', function (Blueprint $table): void {
            $table->dropColumn([
                'height',
                'weight',
                'build',
                'skin_tone',
                'face_shape',
                'eye_color',
                'eye_shape',
                'hair_color',
                'hair_type',
                'hair_length',
                'facial_hair',
                'scars',
                'tatoos',
                'piercings',
                'distinctive_marks',
                'glasses',
                'dress_style',
                'voice',
            ]);
        });
    }
};
