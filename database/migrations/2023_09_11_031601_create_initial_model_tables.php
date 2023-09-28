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
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('enabled')->default(true);
            $table->timestamps();
        });

        Schema::create('bank_statement_maps', function (Blueprint $table) {
            $table->foreignId('bank_account_id')->constrained()->cascadeOnDelete();
            $table->integer('header_lines');
            $table->integer('date_column');
            $table->integer('description_column');
            $table->boolean('amount_is_split')->default(false);
            $table->integer('amount_column');
            $table->integer('amount_2_column')->nullable();
            $table->timestamps();
        });

        Schema::create('transactions', function (Blueprint $table){
            $table->id();
            $table->string('description');
            $table->foreignId('bank_account_id')->constrained();
            $table->date('date');
            $table->decimal('amount', 9, 2);
            $table->timestamps();
        });

        Schema::create('categories', function (Blueprint $table){
            $table->id();
            $table->string('name')->unique();
            $table->boolean('enabled')->default(true);
            $table->timestamps();
        });

        Schema::create('sub_categories', function (Blueprint $table){
            $table->id();
            $table->string('name');
            $table->foreignId('category_id')->constrained(table: 'categories');
            $table->boolean('enabled')->default(true);
            $table->timestamps();

            $table->unique(['name', 'category_id']);
        });

        Schema::create('expenses', function (Blueprint $table){
            $table->id();
            $table->string('description');
            $table->date('month');
            $table->foreignId('sub_category_id')->constrained(table: 'sub_categories');
            $table->decimal('amount', 9, 2);
            $table->boolean('one_time')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bank_statement_maps', function (Blueprint $table) {
            $table->dropForeign(['bank_account_id']);
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['bank_account_id']);
        });

        Schema::table('sub_categories', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
        });

        Schema::table('expenses', function (Blueprint $table) {
            $table->dropForeign(['sub_category_id']);
        });

        Schema::dropIfExists('bank_accounts');
        Schema::dropIfExists('bank_statement_maps');
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('sub_categories');
        Schema::dropIfExists('expenses');
    }
};
