<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Selected options from plans (store both value and label as submitted)
            $table->string('amount_value', 100);
            $table->string('amount_label', 255)->nullable();
            $table->string('duration_value', 100);
            $table->string('duration_label', 255)->nullable();
            $table->string('reason_value', 100);
            $table->string('reason_label', 255)->nullable();

            // Interest calculation fields
            $table->decimal('principal', 14, 2)->nullable();
            $table->unsignedInteger('duration_months')->nullable();
            $table->decimal('interest_rate', 5, 2)->nullable();
            $table->decimal('interest_amount', 14, 2)->nullable();
            $table->decimal('total_payable', 14, 2)->nullable();
            $table->decimal('monthly_installment', 14, 2)->nullable();

            // Document fields
            $table->string('doc_type', 50)->nullable(); // nid, passport, driving_licence
            $table->string('doc_front_path')->nullable();
            $table->string('doc_back_path')->nullable();

            // Deposit fields
            $table->decimal('deposit_required_amount', 14, 2)->nullable();
            $table->foreignId('deposit_gateway_id')->nullable()->constrained('gateways')->nullOnDelete();
            $table->string('deposit_account_number')->nullable();
            $table->string('deposit_transaction_id')->nullable();
            $table->string('deposit_screenshot_path')->nullable();
            $table->timestamp('deposit_submitted_at')->nullable();

            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->index();
            $table->text('admin_note')->nullable();

            $table->foreignId('processed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('processed_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
