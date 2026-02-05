<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaseStudy extends Model
{
    protected $fillable = [
        'title',
        'client_industry',
        'cover_image_path',
        'challenge_summary',
        'solution_summary',
        'roi_stats',
        'tech_stack',
        'is_published',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'roi_stats' => 'array',
            'tech_stack' => 'array',
            'is_published' => 'boolean',
        ];
    }
}
