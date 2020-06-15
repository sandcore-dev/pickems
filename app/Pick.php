<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Collections\PickCollection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Pick
 *
 * @property int $id
 * @property int $race_id
 * @property int $entry_id
 * @property int $user_id
 * @property int $rank
 * @property int $carry_over
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Entry $entry
 * @property-read integer|null $points
 * @property-read Race $race
 * @property-read User $user
 * @method static \App\Collections\PickCollection|static[] all($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Pick byRace(Race $race)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Pick byRaceAndUser(Race $race, User $user)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Pick byUser(User $user)
 * @method static \App\Collections\PickCollection|static[] get($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Pick newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Pick newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Pick query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Pick whereCarryOver($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Pick whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Pick whereEntryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Pick whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Pick whereRaceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Pick whereRank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Pick whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Pick whereUserId($value)
 * @mixin \Eloquent
 * @noinspection PhpFullyQualifiedNameUsageInspection
 * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
 */
class Pick extends Model
{
    /**
     * The attributes that are mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['race_id', 'entry_id', 'user_id', 'rank', 'carry_over'];

    /**
     * Creates a new Collection instance of this model.
     *
     * @param array $models
     *
     * @return Collection
     */
    public function newCollection(array $models = [])
    {
        return new PickCollection($models);
    }

    /**
     * Get the race of this pick.
     *
     * @return BelongsTo
     */
    public function race()
    {
        return $this->belongsTo(Race::class);
    }

    /**
     * Get the entry of this pick.
     *
     * @return BelongsTo
     */
    public function entry()
    {
        return $this->belongsTo(Entry::class);
    }

    /**
     * Get the user of this pick.
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope to race and user.
     *
     * @param Builder $query
     * @param Race $race
     * @param User $user
     *
     * @return Builder
     */
    public function scopeByRaceAndUser(Builder $query, Race $race, User $user)
    {
        /** @noinspection PhpUndefinedMethodInspection */
        return $query->byRace($race)->byUser($user);
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
     * Scope to user.
     *
     * @param Builder $query
     * @param User $user
     * @return Builder
     */
    public function scopeByUser(Builder $query, User $user)
    {
        return $query->where('user_id', $user->id);
    }

    /**
     * Calculate the points of this pick.
     *
     * @return integer|null
     */
    public function getPointsAttribute()
    {
        if ($this->race->results->isEmpty()) {
            return null;
        }

        $result = $this->race->results
            ->where('rank', '<=', config('picks.max'))
            ->whereIn('entry_id', $this->entry_id);

        $points = $result->count();

        if ($points) {
            $points += $result->first()->rank == $this->rank ? 1 : 0;
        }

        return $points;
    }
}
