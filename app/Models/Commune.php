<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Commune extends Model
{
    use SoftDeletes;

    protected $table = 'communes';
    protected $primaryKey = 'id_com';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id_reg', 'code', 'description', 'status',
    ];

    /**
     * Get the region that owns the Commune.
     */
    public function region(): ?BelongsTo
    {
        return $this->belongsTo(Region::class, 'id_reg', 'id_reg');
    }

    /**
     * Get all of the customers for the Commune.
     */
    public function customers(): ?HasMany
    {
        return $this->hasMany(Customer::class, 'id_com', 'id_com');
    }

    public function scopeActive($query)
    {
        $query->where('status', 'A');
    }
}
