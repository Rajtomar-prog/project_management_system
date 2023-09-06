<?php

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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('project_name');
            $table->bigInteger('client_id');
            $table->decimal('budget', $precision = 8, $scale = 2);
            $table->string('budget_type')->default('Fixed Cost');
            $table->integer('curency')->default('1')->comment('1:USD, 2:INR, 3:EUR, 4:AUD');
            $table->longText('description')->nullable();
            $table->bigInteger('created_by');
            $table->integer('status')->default('1')->comment('1:To Do, 2:On Hold, 3:In Process, 4:Done');
            $table->softDeletes($column = 'deleted_at', $precision = 0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
