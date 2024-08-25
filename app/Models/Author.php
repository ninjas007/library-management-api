<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Author extends BaseModelUuid
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'bio',
        'birth_date',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
