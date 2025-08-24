<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class VotingSite extends Model
{
    use HasFactory, BelongsToTenant;

    protected $fillable = [
    'tenant_id',
        'name',
        'url_template',
        'pass_username',
        'enabled',
        'sort_order',
    ];

    protected $casts = [
        'pass_username' => 'boolean',
        'enabled' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Get the resolved URL for the given (optional) username.
     */
    public function resolvedUrl(?string $username = null): string
    {
        $url = $this->url_template;
        if ($this->pass_username) {
            $replacement = $username ?: 'PLAYER_NAME';
            $url = str_replace('{username}', $replacement, $url);
        }
        return $url;
    }

    protected static function booted(): void
    {
        static::creating(function (self $model) {
            if (! $model->tenant_id && function_exists('tenant') && tenant()) {
                $model->tenant_id = tenant('id');
            }
        });
    }
}
