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
        Schema::table('time_records', function (Blueprint $table) {
            $table->decimal('revenue', 18, 2)->default(0);
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->dateTime('paid_at')->nullable()
                ->after('status');
            $table->boolean('create_bank_transaction')
                ->default(false)
                ->after('paid_at');
        });

        Schema::table('expenses', function (Blueprint $table) {
            $table->dateTime('paid_at')->nullable()
                ->after('status');
            $table->boolean('create_bank_transaction')
                ->default(false)
                ->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('time_records', function (Blueprint $table) {
            $table->dropColumn('revenue');
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn('paid_at');
            $table->dropColumn('create_bank_transaction');
        });

        Schema::table('expenses', function (Blueprint $table) {
            $table->dropColumn('create_bank_transaction');
        });
    }
};
