<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Collections\StandingCollection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Standing
 *
 * @property int $id
 * @property int $user_id
 * @property int $league_id
 * @property int $race_id
 * @property int $carry_over
 * @property int $rank
 * @property int|null $previous_rank
 * @property int|null $previous_id
 * @property int $total_overall
 * @property int $total_picked
 * @property int $total_positions_correct
 * @property int $total
 * @property int $picked
 * @property int $positions_correct
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read integer|null $rank_moved
 * @property-read string $rank_moved_glyphicon
 * @property-read League $league
 * @property-read \App\Standing|null $previous
 * @property-read Race $race
 * @property-read User $user
 * @method static \App\Collections\StandingCollection|static[] all($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Standing byLeague(League $league)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Standing byRace(Race $race)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Standing bySeason(Season $season)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Standing byUser(User $user)
 * @method static \App\Collections\StandingCollection|static[] get($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Standing newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Standing newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Standing query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Standing whereCarryOver($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Standing whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Standing whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Standing whereLeagueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Standing wherePicked($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Standing wherePositionsCorrect($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Standing wherePreviousId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Standing wherePreviousRank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Standing whereRaceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Standing whereRank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Standing whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Standing whereTotalOverall($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Standing whereTotalPicked($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Standing whereTotalPositionsCorrect($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Standing whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Standing whereUserId($value)
 * @mixin \Eloquent
 * @noinspection PhpFullyQualifiedNameUsageInspection
 * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
 */
class Standing extends Model
{
    /**
     * The attributes that are mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['race_id', 'user_id'];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(
            'sortByRaceRank',
            function (Builder $builder) {
                $builder->orderBy('race_id', 'asc')->orderBy('rank', 'asc');
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
        return new StandingCollection($models);
    }

    /**
     * Get the race of this standings entry.
     *
     * @return BelongsTo
     */
    public function race()
    {
        return $this->belongsTo(Race::class);
    }

    /**
     * Get the league of this standings entry.
     *
     * @return BelongsTo
     */
    public function league()
    {
        return $this->belongsTo(League::class);
    }

    /**
     * Get the user of this standings entry.
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the previous race entry of this standings entry.
     *
     * @return BelongsTo
     */
    public function previous()
    {
        return $this->belongsTo(Standing::class, 'previous_id');
    }

    /**
     * Scope to race.
     *
     * @param Builder $query
     * @param Race $race
     *
     * @return Builder
     */
    public function scopeByRace(Builder $query, Race $race)
    {
        return $query->where('race_id', $race->id);
    }

    /**
     * Scope to season.
     *
     * @param Builder $query
     * @param Season $season
     *
     * @return Builder
     */
    public function scopeBySeason(Builder $query, Season $season)
    {
        return $query->whereIn('race_id', $season->races->pluck('id'));
    }

    /**
     * Scope to user.
     *
     * @param Builder $query
     * @param User $user
     *
     * @return Builder
     */
    public function scopeByUser(Builder $query, User $user)
    {
        return $query->where('user_id', $user->id);
    }

    /**
     * Scope to league.
     *
     * @param Builder $query
     * @param League $league
     *
     * @return Builder
     */
    public function scopeByLeague(Builder $query, League $league)
    {
        return $query->where('league_id', $league->id);
    }

    /**
     * Get the difference between current rank and previous rank
     *
     * @return integer|null
     */
    public function getRankMovedAttribute()
    {
        if (is_null($this->previous_rank)) {
            return null;
        }

        return $this->previous_rank - $this->rank;
    }

    /**
     * Get the correct glyphicon class according to rankMoved.
     *
     * @return string
     */
    public function getRankMovedGlyphiconAttribute()
    {
        if (is_null($this->rankMoved)) {
            return 'glyphicon-star';
        }

        if ($this->rankMoved < 0) {
            return 'glyphicon-arrow-down text-danger';
        }

        if ($this->rankMoved > 0) {
            return 'glyphicon-arrow-up text-success';
        }

        return 'glyphicon-pause text-info';
    }
}
