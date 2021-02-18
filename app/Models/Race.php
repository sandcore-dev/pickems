<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Race
 *
 * @property int $id
 * @property int $season_id
 * @property int $circuit_id
 * @property string $name
 * @property \Illuminate\Support\Carbon $weekend_start
 * @property \Illuminate\Support\Carbon $race_day
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Circuit $circuit
 * @property-read bool $pickable
 * @property-read \App\Collections\PickCollection|\App\Models\Pick[] $picks
 * @property-read int|null $picks_count
 * @property-read \App\Collections\ResultCollection|\App\Models\Result[] $results
 * @property-read int|null $results_count
 * @property-read \App\Models\Season $season
 * @property-read \App\Collections\StandingCollection|\App\Models\Standing[] $standings
 * @property-read int|null $standings_count
 * @method static Builder|Race newModelQuery()
 * @method static Builder|Race newQuery()
 * @method static Builder|Race nextDeadline()
 * @method static Builder|Race nextOrLast()
 * @method static Builder|Race previousOrFirst(int $index = 0)
 * @method static Builder|Race query()
 * @method static Builder|Race whereCircuitId($value)
 * @method static Builder|Race whereCreatedAt($value)
 * @method static Builder|Race whereId($value)
 * @method static Builder|Race whereName($value)
 * @method static Builder|Race whereRaceDay($value)
 * @method static Builder|Race whereSeasonId($value)
 * @method static Builder|Race whereUpdatedAt($value)
 * @method static Builder|Race whereWeekendStart($value)
 * @mixin \Eloquent
 * @noinspection PhpFullyQualifiedNameUsageInspection
 * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
 */
class Race extends Model
{
    use HasFactory;

    /**
     * Date fields.
     *
     * @var array
     */
    protected $dates = [
        'weekend_start',
        'race_day',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that are mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['season_id', 'circuit_id', 'name', 'weekend_start', 'race_day'];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(
            'sortByRaceDay',
            function (Builder $builder) {
                $builder->orderBy('race_day');
            }
        );
    }

    /**
     * Get the circuit of this race.
     *
     * @return BelongsTo
     */
    public function circuit()
    {
        return $this->belongsTo(Circuit::class);
    }

    /**
     * Get the season of this race.
     *
     * @return BelongsTo
     */
    public function season()
    {
        return $this->belongsTo(Season::class);
    }

    /**
     * Get the results of this race.
     *
     * @return HasMany
     */
    public function results()
    {
        return $this->hasMany(Result::class);
    }

    /**
     * Get the standings of this race.
     *
     * @return HasMany
     */
    public function standings()
    {
        return $this->hasMany(Standing::class);
    }

    /**
     * Get the picks of this race.
     *
     * @return HasMany
     */
    public function picks()
    {
        return $this->hasMany(Pick::class);
    }

    /**
     * Get next race according to current date.
     *
     * @param $query Builder
     *
     * @return Builder
     */
    public function scopeNextOrLast(Builder $query)
    {
        $newQuery = clone $query;

        $first = $query->where('race_day', '>=', date('Y-m-d'))->first();

        if ($first) {
            return $first;
        }

        return $newQuery->withoutGlobalScope('sortByRaceDay')->orderBy('race_day', 'desc')->first();
    }

    /**
     * Get previous race according to current date.
     *
     * @param $query Builder
     * @param $index integer
     *
     * @return Builder
     */
    public function scopePreviousOrFirst(Builder $query, int $index = 0)
    {
        $newQuery = clone $query;

        $last = $query->withoutGlobalScope('sortByRaceDay')
            ->where('race_day', '<=', date('Y-m-d'))
            ->orderBy('race_day', 'desc')
            ->get()
            ->slice($index, 1)
            ->first();

        if ($last) {
            return $last;
        }

        return $newQuery->first();
    }

    /**
     * Get next race deadline according to current date.
     *
     * @param $query Builder
     *
     * @return Builder
     */
    public function scopeNextDeadline(Builder $query)
    {
        return $query->where('weekend_start', '>', date('Y-m-d H:i:s'));
    }

    /**
     * Can we pick for this race?
     *
     * @return bool
     */
    public function getPickableAttribute()
    {
        return false;
    }
}
