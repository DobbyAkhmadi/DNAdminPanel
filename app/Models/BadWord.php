<?php

namespace App\Models;

use App\Common\UuidForKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BadWord extends Model
{
    use HasFactory, UuidForKey;

    protected $primaryKey = 'id';

    protected $keyType = 'uuid';

    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type', // account / chat world / replacement
        'language', // en / id / kr / jp
        'word',
        'replacement',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
}
