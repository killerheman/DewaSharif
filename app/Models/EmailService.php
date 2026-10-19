<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Plan;
use App\Models\Faq;

class EmailService extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function plans()
    {
        return $this->hasMany(Plan::class, 'common_id')
            ->where('common_type', self::class)
            ->where('is_active', true)
            ->orderBy('sort_order');
    }

    public function faqs()
    {
        return $this->hasMany(Faq::class, 'common_id')
            ->where('common_type', self::class)
            ->where('is_active', true)
            ->orderBy('sort_order');
    }
}
