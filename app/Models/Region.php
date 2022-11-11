<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Region extends Model
{
    use SoftDeletes;

    protected $table = 'regions';
    protected $primaryKey = 'id_reg';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'code', 'description', 'status',
    ];

    /**
     * Get all of the communes for the Region.
     */
    public function communes(): ?HasMany
    {
        return $this->hasMany(Commune::class, 'id_reg', 'id_reg');
    }

    // scope
    public function scopeActive($query)
    {
        $query->where('status', 'A');
    }
}
