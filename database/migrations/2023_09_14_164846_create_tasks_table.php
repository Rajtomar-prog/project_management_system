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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('priority')->default('1')->comment('1:Highest, 2:High, 3:Low, 4:Lowest');
            $table->dateTime('due_date', $precision = 0);
            $table->longText('description')->nullable();
            $table->bigInteger('created_by');
            $table->boolean('is_active')->comment('1-active,0-inactive')->default(1);
            $table->softDeletes($column = 'deleted_at', $precision = 0);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
