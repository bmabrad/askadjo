<?php

namespace App\Models;

use App\Enums\InputType;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'contact_id',
    'input_type',
    'raw_text',
    'screenshot_path',
    'situation_read',
    'applicable_principles',
    'reply_options',
    'ai_raw_response',
    'prompt_tokens',
    'completion_tokens',
])]
class CoachingSession extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'input_type' => InputType::class,
            'screenshot_path' => 'array',
            'applicable_principles' => 'array',
            'reply_options' => 'array',
        ];
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }
}
