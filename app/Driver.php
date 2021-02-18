<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Driver
 *
 * @property int $id
 * @property string $first_name
 * @property string|null $surname_prefix
 * @property string $last_name
 * @property int|null $country_id
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Country|null $country
 * @property-read \App\Collections\EntryCollection|\App\Entry[] $entries
 * @property-read int|null $entries_count
 * @property-read string $first_letter
 * @property-read string $full_last_name
 * @property-read string $full_name
 * @property-read string $last_first
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Driver newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Driver newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Driver query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Driver whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Driver whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Driver whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Driver whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Driver whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Driver whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Driver whereSurnamePrefix($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Driver whereUpdatedAt($value)
 * @mixin \Eloquent
 * @noinspection PhpFullyQualifiedNameUsageInspection
 * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
 */
class Driver extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass-assignable.
     *
     * @var array
     */
    protected $fillable = [ 'first_name', 'surname_prefix', 'last_name', 'country_id', 'active' ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(
            'sortByName',
            function (Builder $builder) {
                $builder->orderBy('last_name', 'asc')->orderBy('first_name', 'asc');
            }
        );
    }

    /**
     * Get country of this driver.
     *
     * @return BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class)->withDefault();
    }

    /**
     * Get entries of this driver.
     *
     * @return HasMany
     */
    public function entries()
    {
        return $this->hasMany(Entry::class);
    }

    /**
     * Get full name of this driver.
     *
     * @return string
     */
    public function getFirstLetterAttribute()
    {
        return substr($this->first_name, 0, 1) . '.';
    }

    /**
     * Get full last name of this driver.
     *
     * @return string
     */
    public function getFullLastNameAttribute()
    {
        return ($this->surname_prefix ? $this->surname_prefix . ' ' : '') . $this->last_name;
    }

    /**
     * Get full name of this driver.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->fullLastName;
    }

    /**
     * Get full name of this driver, with last name first and then a comma.
     *
     * @return string
     */
    public function getLastFirstAttribute()
    {
        return $this->last_name . ', ' . $this->first_name . ($this->surname_prefix ? ' ' . $this->surname_prefix : '');
    }
}
