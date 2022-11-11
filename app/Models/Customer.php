<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;

    protected $table = 'customers';
    protected $primaryKey = 'dni';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'dni', 'id_com', 'email', 'name', 'last_name', 'address', 'status',
    ];

    /**
     * Get the commune that owns the Customer.
     */
    public function commune(): ?BelongsTo
    {
        return $this->belongsTo(Commune::class, 'id_com', 'id_com');
    }

    // Scopes
    public function scopeActive($query)
    {
        $query->where('status', 'A');
    }
}
