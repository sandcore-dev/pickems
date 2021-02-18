<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Monarobase\CountryList\CountryListFacade as Countries;
use Monarobase\CountryList\CountryNotFoundException;

/**
 * App\Models\Country
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Circuit[] $circuits
 * @property-read int|null $circuits_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Driver[] $drivers
 * @property-read int|null $drivers_count
 * @property-read string $flag_class
 * @property-read string $local_name
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Team[] $teams
 * @property-read int|null $teams_count
 * @method static Builder|Country newModelQuery()
 * @method static Builder|Country newQuery()
 * @method static Builder|Country query()
 * @method static Builder|Country whereCode($value)
 * @method static Builder|Country whereCreatedAt($value)
 * @method static Builder|Country whereId($value)
 * @method static Builder|Country whereName($value)
 * @method static Builder|Country whereUpdatedAt($value)
 * @mixin \Eloquent
 * @noinspection PhpFullyQualifiedNameUsageInspection
 * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
 */
class Country extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass-assignable.
     *
     * @var array
     */
    protected $fillable = [ 'code', 'name' ];

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
     * Get circuits in this country.
     *
     * @return HasMany
     */
    public function circuits()
    {
        return $this->hasMany(Circuit::class);
    }

    /**
     * Get drivers of this country.
     *
     * @return HasMany
     */
    public function drivers()
    {
        return $this->hasMany(Driver::class);
    }

    /**
     * Get teams of this country.
     *
     * @return HasMany
     */
    public function teams()
    {
        return $this->hasMany(Team::class);
    }

    /**
     * Get the flag class of this country.
     *
     * @return string
     */
    public function getFlagClassAttribute()
    {
        return 'flag-icon flag-icon-' . strtolower($this->code);
    }

    /**
     * Get the name of this country in the current locale.
     *
     * @return string
     */
    public function getLocalNameAttribute()
    {
        try {
            return Countries::getOne($this->code, app()->getLocale());
        } catch (CountryNotFoundException $e) {
            error_log('CountryNotFoundException: ' . $e->getMessage());
        }

        return $this->name;
    }
}
