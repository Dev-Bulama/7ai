<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    protected $fillable = ['name', 'key', 'subject', 'body', 'is_active'];
    protected $casts    = ['is_active' => 'boolean'];

    /** Replace {{variable}} placeholders with actual values. */
    public function render(array $vars): string
    {
        $body = $this->body;
        foreach ($vars as $k => $v) {
            $body = str_replace('{{' . $k . '}}', e($v), $body);
        }
        return $body;
    }

    public function renderSubject(array $vars): string
    {
        $subject = $this->subject;
        foreach ($vars as $k => $v) {
            $subject = str_replace('{{' . $k . '}}', $v, $subject);
        }
        return $subject;
    }

    public static function getByKey(string $key): ?self
    {
        return static::where('key', $key)->where('is_active', true)->first();
    }
}
