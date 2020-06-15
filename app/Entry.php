<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Collections\EntryCollection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Entry
 *
 * @property int $id
 * @property int $season_id
 * @property int $team_id
 * @property int $driver_id
 * @property int $car_number
 * @property string|null $abbreviation
 * @property string|null $color
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Driver $driver
 * @property-read \App\Collections\PickCollection|\App\Pick[] $picks
 * @property-read int|null $picks_count
 * @property-read \App\Collections\ResultCollection|\App\Result[] $results
 * @property-read int|null $results_count
 * @property-read \App\Season $season
 * @property-read \App\Team $team
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entry active()
 * @method static \App\Collections\EntryCollection|static[] all($columns = ['*'])
 * @method static \App\Collections\EntryCollection|static[] get($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entry newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entry newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entry query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entry sortByTeamDriver()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entry whereAbbreviation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entry whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entry whereCarNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entry whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entry whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entry whereDriverId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entry whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entry whereSeasonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entry whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entry whereUpdatedAt($value)
 * @mixin \Eloquent
 * @noinspection PhpFullyQualifiedNameUsageInspection
 * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
 */
class Entry extends Model
{
    /**
     * The attributes that are mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['season_id', 'abbreviation', 'car_number', 'color', 'team_id', 'driver_id', 'active'];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(
            'sortByCarNumber',
            function (Builder $builder) {
                $builder->orderBy('car_number', 'asc');
            }
        );
    }

    /**
     * Creates a new Collection instance of this model.
     *
     * @param array $models
     *
     * @return Collection
     */
    public function newCollection(array $models = [])
    {
        return new EntryCollection($models);
    }

    /**
     * Get team of this entry.
     *
     * @return BelongsTo
     */
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Get driver of this entry.
     *
     * @return BelongsTo
     */
    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    /**
     * Get season of this entry.
     *
     * @return BelongsTo
     */
    public function season()
    {
        return $this->belongsTo(Season::class);
    }

    /**
     * Get results of this entry.
     *
     * @return HasMany
     */
    public function results()
    {
        return $this->hasMany(Result::class);
    }

    /**
     * Get picks of this entry.
     *
     * @return HasMany
     */
    public function picks()
    {
        return $this->hasMany(Pick::class);
    }

    /**
     * Get active entries.
     *
     * @param $query Builder
     * @return Builder
     */
    public function scopeActive(Builder $query)
    {
        return $query->where('active', 1);
    }

    /**
     * Order by teams and drivers.
     *
     * @param $query Builder
     * @return Builder
     */
    public function scopeSortByTeamDriver(Builder $query)
    {
        return $query->with(
            [
                'team' => function ($query) {
                    $query->orderBy('name', 'asc');
                },
                'driver' => function ($query) {
                    $query->orderBy('last_name', 'asc');
                    $query->orderBy('first_name', 'asc');
                },
            ]
        );
    }
}
