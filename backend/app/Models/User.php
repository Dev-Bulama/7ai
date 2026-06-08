<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name', 'email', 'password', 'phone', 'country', 'company',
        'avatar', 'is_active', 'two_factor_enabled', 'two_factor_secret', 'last_login_at',
    ];

    protected $hidden = ['password', 'remember_token', 'two_factor_secret'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'is_active' => 'boolean',
        'two_factor_enabled' => 'boolean',
    ];

    public function projects() { return $this->hasMany(Project::class, 'client_id'); }
    public function tickets() { return $this->hasMany(Ticket::class); }
    public function invoices() { return $this->hasMany(Invoice::class); }
    public function subscriptions() { return $this->hasMany(Subscription::class); }
    public function activityLogs() { return $this->hasMany(ActivityLog::class); }
    public function posts() { return $this->hasMany(Post::class, 'author_id'); }
}
