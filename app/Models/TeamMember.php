<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeamMember extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'job_title', 'subtitle', 'bio', 'photo',
        'email', 'phone', 'facebook', 'instagram', 'twitter',
        'linkedin', 'github', 'website',
        'sort_order', 'is_featured', 'is_active',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_active'   => 'boolean',
    ];

    public function getInitialsAttribute(): string
    {
        $words = explode(' ', $this->name);
        return strtoupper(substr($words[0], 0, 1) . (substr(end($words), 0, 1)));
    }

    public function getPhotoUrlAttribute(): ?string
    {
        if (!$this->photo) return null;
        return str_starts_with($this->photo, 'http') ? $this->photo : asset('storage/' . $this->photo);
    }

    public function scopeActive($query)  { return $query->where('is_active', true); }
    public function scopeFeatured($query){ return $query->where('is_featured', true); }
}
