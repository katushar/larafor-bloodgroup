<?php

namespace Larafor\Bloodgroup\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BloodGroup extends Model
{
    protected $fillable = ['name', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];
    protected $hidden = ['created_at', 'updated_at'];

    public function __call($method, $parameters)
    {
        $models = config('bloodgroup.models', []);

        if (array_key_exists($singular = rtrim($method, 's'), $models)) {
            return $this->hasMany($models[$singular], 'blood_group_id');
        }

        return parent::__call($method, $parameters);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function scopeInactive($query)
    {
        return $query->where('is_active', 0);
    }
}
