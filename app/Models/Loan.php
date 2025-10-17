<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Gateway;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount_value',
        'amount_label',
        'duration_value',
        'duration_label',
        'reason_value',
        'reason_label',
        // computed and processing fields
        'principal',
        'duration_months',
        'interest_rate',
        'interest_amount',
        'total_payable',
        'monthly_installment',
        // KYC docs
        'doc_type',
        'doc_front_path',
        'doc_back_path',
        // Deposit
        'deposit_required_amount',
        'deposit_gateway_id',
        'deposit_account_number',
        'deposit_transaction_id',
        'deposit_screenshot_path',
        'deposit_submitted_at',
        'status',
        'admin_note',
        'processed_by',
        'processed_at',
    ];

    protected $casts = [
        'processed_at' => 'datetime',
        'principal' => 'decimal:2',
        'interest_rate' => 'decimal:2',
        'interest_amount' => 'decimal:2',
        'total_payable' => 'decimal:2',
        'monthly_installment' => 'decimal:2',
        'deposit_required_amount' => 'decimal:2',
        'deposit_submitted_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function processor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    public function depositGateway(): BelongsTo
    {
        return $this->belongsTo(Gateway::class, 'deposit_gateway_id');
    }
}
