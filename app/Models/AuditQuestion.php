<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'sector_id',
        'question_text',
        'variable_name',
        'cost_per_unit',
        'suggestion_text',
    ];

    protected $casts = [
        'question_text' => 'array',
        'suggestion_text' => 'array',
        'cost_per_unit' => 'decimal:2',
    ];

    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }
}
