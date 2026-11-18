<?php

namespace Modules\Guide\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ketersediaan extends Model
{
    protected $table = 'ketersediaan_pemandu';

    protected $guarded = ['id'];

    public function pemandu(): BelongsTo
    {
        return $this->belongsTo(Pemandu::class, 'pemandu_id');
    }
}
