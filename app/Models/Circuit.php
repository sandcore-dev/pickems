<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Circuit
 *
 * @property int $id
 * @property string $name
 * @property int|null $length
 * @property string|null $city
 * @property string|null $area
 * @property int $country_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Country $country
 * @property-read string $local_location
 * @property-read string $local_location_short
 * @property-read string $location
 * @property-read string $location_short
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Race[] $races
 * @property-read int|null $races_count
 * @method static Builder|Circuit newModelQuery()
 * @method static Builder|Circuit newQuery()
 * @method static Builder|Circuit query()
 * @method static Builder|Circuit whereArea($value)
 * @method static Builder|Circuit whereCity($value)
 * @method static Builder|Circuit whereCountryId($value)
 * @method static Builder|Circuit whereCreatedAt($value)
 * @method static Builder|Circuit whereId($value)
 * @method static Builder|Circuit whereLength($value)
 * @method static Builder|Circuit whereName($value)
 * @method static Builder|Circuit whereUpdatedAt($value)
 * @mixin \Eloquent
 * @noinspection PhpFullyQualifiedNameUsageInspection
 * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
 */
class Circuit extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'length', 'city', 'area', 'country_id'];

    /**
     * Get country of this circuit.
     *
     * @return BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Get races of this circuit.
     *
     * @return HasMany
     */
    public function races()
    {
        return $this->hasMany(Race::class);
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(
            'orderByName',
            function (Builder $builder) {
                $builder->orderBy('name', 'asc');
            }
        );
    }

    /**
     * Get the place of this circuit.
     *
     * @return string
     */
    public function getLocationAttribute()
    {
        return $this->city . ', ' . ($this->area ? $this->area . ', ' : '') . $this->country->name;
    }

    /**
     * Get the short notation of the place of this circuit.
     *
     * @return string
     */
    public function getLocationShortAttribute()
    {
        return $this->city . ', ' . $this->country->name;
    }

    /**
     * Get the localized place of this circuit.
     *
     * @return string
     */
    public function getLocalLocationAttribute()
    {
        return $this->city . ', ' . ($this->area ? $this->area . ', ' : '') . $this->country->localName;
    }

    /**
     * Get the short localized notation of the place of this circuit.
     *
     * @return string
     */
    public function getLocalLocationShortAttribute()
    {
        return $this->city . ', ' . $this->country->localName;
    }
}
