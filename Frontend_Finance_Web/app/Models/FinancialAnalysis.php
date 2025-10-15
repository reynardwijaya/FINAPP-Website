<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FinancialAnalysis extends Model
{
    protected $fillable = [
        'user_id',
        'analysis_type',
        'analysis_date',
        'financial_metrics',
        'analysis_summary',
        'recommendations',
        'related_resources',
    ];

    protected $casts = [
        'analysis_date' => 'date',
        'financial_metrics' => 'array',
        'recommendations' => 'array',
        'related_resources' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
} 