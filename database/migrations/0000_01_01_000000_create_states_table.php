<?php

use App\Enums\ConstituencyType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('states', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::create('zones', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->foreignUuid('state_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->unique(['name', 'state_id']);
            $table->timestamps();
        });

        Schema::create('lgas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->foreignUuid('zone_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->unique(['name', 'zone_id']);
            $table->timestamps();
        });

        Schema::create('wards', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->foreignUuid('lga_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->unique(['name', 'lga_id']);
            $table->timestamps();
        });

        Schema::create('pus', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('code');
            $table->string('name');
            $table->foreignUuid('ward_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->unique(['code', 'ward_id']);
            $table->timestamps();
        });

        Schema::create('constituencies', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('name');

            $table->enum('type', array_column(ConstituencyType::cases(), 'value'));

            $table->foreignUuid('state_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignUuid('zone_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->foreignUuid('lga_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->foreignUuid('ward_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->text('description')->nullable();

            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->unique(['name', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pus');
        Schema::dropIfExists('wards');
        Schema::dropIfExists('lgas');
        Schema::dropIfExists('zones');
        Schema::dropIfExists('states');
        Schema::dropIfExists('constituencies');
    }
};
