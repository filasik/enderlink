<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
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
