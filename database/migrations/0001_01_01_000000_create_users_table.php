<?php

use App\Enums\AspirantOffice;
use App\Enums\CoordinatorType;
use App\Enums\EducationStatus;
use App\Enums\Gender;
use App\Enums\PartyAgentType;
use App\Enums\StakeholderType;
use App\Enums\SupervisoryAgentType;
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
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');

            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();

            $table->string('password');

            $table->boolean('is_active')->default(true);

            $table->rememberToken();

            $table->timestamps();
        });

        Schema::create('user_profiles', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('user_id')
                ->unique()
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->string('phone')->nullable();

            $table->enum('gender', array_column(Gender::cases(), 'value'))->nullable();

            $table->string('occupation')->nullable();

            $table->enum('education_status', array_column(EducationStatus::cases(), 'value'))->nullable();

            $table->boolean('training_status')->default(false);

            $table->string('mentor_name')->nullable();

            $table->boolean('mentor_status')->default(false);

            $table->string('application_id')->nullable();

            $table->foreignUuid('state_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete()
                ->cascadeOnUpdate();

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

            $table->foreignUuid('pu_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->timestamps();
        });

        Schema::create('aspirants', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('user_id')
                ->unique()
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignUuid('constituency_id')
                ->constrained()
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->enum('office', array_column(AspirantOffice::cases(), 'value'))
                ->default(AspirantOffice::OTHER->value);

            $table->string('title')->nullable();
            $table->text('vision')->nullable();
            $table->text('mission')->nullable();

            $table->unsignedTinyInteger('overall_progress')->default(0);
            $table->unsignedInteger('total_supporters')->default(0);
            $table->integer('supporters_growth_this_week')->default(0);
            $table->unsignedInteger('campaign_team_members')->default(0);

            $table->string('avatar')->nullable();
            $table->string('picture')->nullable();

            $table->timestamps();
        });

        Schema::create('returning_officers', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('user_id')
                ->unique()
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->string('institution');

            $table->string('posting_location');

            $table->timestamps();
        });

        Schema::create('coordinators', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('user_id')
                ->unique()
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->enum('type', array_column(CoordinatorType::cases(), 'value'));

            $table->timestamps();
        });

        Schema::create('party_agents', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('user_id')
                ->unique()
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->enum('type', array_column(PartyAgentType::cases(), 'value'));

            $table->timestamps();
        });

         Schema::create('stakeholders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')
                ->unique()
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->enum('type', array_column(StakeholderType::cases(), 'value'));
            $table->string('organization')->nullable();
            $table->string('designation')->nullable();
            $table->timestamps();
        });

        Schema::create('supervisory_agents', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')
                ->unique()
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->enum('type', array_column(SupervisoryAgentType::cases(), 'value'));
            $table->unsignedInteger('agents_supervised')->default(0);
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();

            $table->foreignUuid('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supervisory_agents');
        Schema::dropIfExists('stakeholders');
        Schema::dropIfExists('coordinators');
        Schema::dropIfExists('returning_officers');
        Schema::dropIfExists('aspirants');
        Schema::dropIfExists('user_profiles');

        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('users');
    }
};
