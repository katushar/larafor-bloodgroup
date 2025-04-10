<?php

namespace Larafor\Bloodgroup\Traits;

use Larafor\Bloodgroup\App\Helpers\BloodGroupHelper;
use Larafor\Bloodgroup\Models\BloodGroup;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

trait HasBloodGroup
{
    public function bloodGroup(): BelongsTo
    {
        return $this->belongsTo(BloodGroup::class, 'blood_group_id');
    }

    protected function getBloodGroup(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->bloodgroup?->name,
        );
    }
    
    public function setBloodGroup($value): void
    {
        if ($value instanceof BloodGroup) {
            $this->bloodGroup()->associate($value);
        } elseif (is_numeric($value)) {
            $this->blood_group_id = (int) $value;
        } elseif (is_string($value)) {
            $this->assignBloodGroupByName($value);
        } elseif (is_null($value)) {
            $this->blood_group_id = null;
        } else {
            throw new \InvalidArgumentException('Unsupported blood group value.');
        }
    }

    public function getBloodGroupNameAttribute(): ?string
    {
        return $this->bloodGroup;
    }

    public function getBloodGroupIdAttribute(): ?int
    {
        return $this->attributes['blood_group_id'] ?? null;
    }

    public function hasBloodGroup(): bool
    {
        return !is_null($this->blood_group_id);
    }

    public function removeBloodGroup(): void
    {
        $this->bloodGroup()->dissociate();
        $this->save();
    }

    public function assignBloodGroupByName(string $name): void
    {
        $name = BloodGroupHelper::normalize($name);

        if (!$name) {
            throw new \InvalidArgumentException("Invalid blood group format.");
        }

        $validator = Validator::make(['name' => $name], [
            'name' => ['required', 'string', 'max:3', 'regex:/^(A|B|AB|O)[+-]$/'],
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        try {
            $bloodGroup = BloodGroup::firstOrCreate(['name' => $name]);
            $this->bloodGroup()->associate($bloodGroup);
            $this->save();
        } catch (\Exception $e) {
            throw new \RuntimeException('Error assigning blood group: ' . $e->getMessage());
        }
    }

    public function scopeWhereBloodGroup(Builder $query, string|int|BloodGroup|null $bloodGroup): Builder
    {
        return match (true) {
            $bloodGroup instanceof BloodGroup => $query->where('blood_group_id', $bloodGroup->id),
            is_numeric($bloodGroup)          => $query->where('blood_group_id', (int) $bloodGroup),
            is_string($bloodGroup)           => $query->whereHas('bloodGroup', fn($q) => $q->where('name', strtoupper($bloodGroup))),
            default                          => $query,
        };
    }
    public function scopeWhereBloodGroupName(Builder $query, string $name): Builder
    {
        return $query->whereHas('bloodGroup', function ($q) use ($name) {
            $q->where('name', strtoupper($name));
        });
    }

    public function scopeWhereBloodGroupId(Builder $query, int $bloodGroupId): Builder
    {
        return $query->where('blood_group_id', $bloodGroupId);
    }

    public function scopeWhereBloodGroupNotNull(Builder $query): Builder
    {
        return $query->whereNotNull('blood_group_id');
    }

    public function scopeWhereBloodGroupIsNull(Builder $query): Builder
    {
        return $query->whereNull('blood_group_id');
    }

    public function scopeWhereBloodGroupIn(Builder $query, array $bloodGroups): Builder
    {
        return $query->whereIn('blood_group_id', $bloodGroups);
    }
    public function scopeWhereBloodGroupNotIn(Builder $query, array $bloodGroups): Builder
    {
        return $query->whereNotIn('blood_group_id', $bloodGroups);
    }

    public function scopeWhereBloodGroupBetween(Builder $query, int $min, int $max): Builder
    {
        return $query->whereBetween('blood_group_id', [$min, $max]);
    }
}
