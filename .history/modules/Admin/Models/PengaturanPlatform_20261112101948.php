<?php

namespace Modules\Admin\\Models;

use Illuminate\Database\Eloquent\Model;

class PengaturanPlatform extends Model
{
    protected $table = 'pengaturan_platform';

    protected $primaryKey = 'kunci';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $guarded = [];
}
