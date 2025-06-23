<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Settings extends Model
{
    use BelongsToTenant;

    protected $table = 'settings';

    protected $fillable = [
        'key',
        'value',
    ];
    public $timestamps = true;
    protected $primaryKey = 'key';
    public $incrementing = false;
    protected $keyType = 'string';

}
