<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Collections\EntryCollection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Entry
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
 * @property-read \App\Models\Driver $driver
 * @property-read \App\Collections\PickCollection|\App\Models\Pick[] $picks
 * @property-read int|null $picks_count
 * @property-read \App\Collections\ResultCollection|\App\Models\Result[] $results
 * @property-read int|null $results_count
 * @property-read \App\Models\Season $season
 * @property-read \App\Models\Team $team
 * @method static Builder|Entry active()
 * @method static EntryCollection|static[] all($columns = ['*'])
 * @method static EntryCollection|static[] get($columns = ['*'])
 * @method static Builder|Entry newModelQuery()
 * @method static Builder|Entry newQuery()
 * @method static Builder|Entry query()
 * @method static Builder|Entry sortByTeamDriver()
 * @method static Builder|Entry whereAbbreviation($value)
 * @method static Builder|Entry whereActive($value)
 * @method static Builder|Entry whereCarNumber($value)
 * @method static Builder|Entry whereColor($value)
 * @method static Builder|Entry whereCreatedAt($value)
 * @method static Builder|Entry whereDriverId($value)
 * @method static Builder|Entry whereId($value)
 * @method static Builder|Entry whereSeasonId($value)
 * @method static Builder|Entry whereTeamId($value)
 * @method static Builder|Entry whereUpdatedAt($value)
 * @mixin \Eloquent
 * @noinspection PhpFullyQualifiedNameUsageInspection
 * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
 */
class Entry extends Model
{
    use HasFactory;

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
