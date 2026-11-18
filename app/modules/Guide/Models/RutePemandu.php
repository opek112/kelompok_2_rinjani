<?php

namespace Modules\Guide\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RutePemandu extends Model
{
    protected $table = 'rute_pemandu';

    public $incrementing = false;

    public $timestamps = false;

    protected $guarded = [];

    public function pemandu(): BelongsTo
    {
        return $this->belongsTo(Pemandu::class, 'pemandu_id');
    }
}
