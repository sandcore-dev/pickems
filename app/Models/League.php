<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\League
 *
 * @property int $id
 * @property int $series_id
 * @property string $name
 * @property string|null $access_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Race|null $next_deadline
 * @property-read \App\Models\Series $series
 * @property-read \App\Collections\StandingCollection|\App\Models\Standing[] $standings
 * @property-read int|null $standings_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @property-read int|null $users_count
 * @method static Builder|League byToken(string $token)
 * @method static Builder|League newModelQuery()
 * @method static Builder|League newQuery()
 * @method static Builder|League query()
 * @method static Builder|League whereAccessToken($value)
 * @method static Builder|League whereCreatedAt($value)
 * @method static Builder|League whereId($value)
 * @method static Builder|League whereName($value)
 * @method static Builder|League whereSeriesId($value)
 * @method static Builder|League whereUpdatedAt($value)
 * @mixin \Eloquent
 * @noinspection PhpFullyQualifiedNameUsageInspection
 * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
 */
class League extends Model
{
    use HasFactory;

    protected $fillable = [
        'series_id',
        'name',
        'access_token',
        'championship_picks_enabled',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::addGlobalScope(
            'sortByName',
            function (Builder $builder) {
                $builder->orderBy('name', 'asc');
            }
        );
    }

    /**
     * Get users of this league.
     *
     * @return BelongsToMany|User
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    /**
     * Get series of this league.
     *
     * @return BelongsTo|Series
     */
    public function series(): BelongsTo
    {
        return $this->belongsTo(Series::class);
    }

    /**
     * Get standings of this league.
     *
     * @return HasMany|Standing
     */
    public function standings(): HasMany
    {
        return $this->hasMany(Standing::class);
    }

    public function scopeByToken(Builder $query, string $token): Builder
    {
        return $query
            ->whereNotNull('access_token')
            ->where('access_token', $token);
    }

    /**
     * Get next race according to weekend_start.
     *
     * @return Race|null
     */
    public function getNextDeadlineAttribute(): ?Race
    {
        try {
            return $this->series()
                ->firstOrFail()
                ->seasons()
                ->firstOrFail()
                ->races()
                ->nextDeadline()
                ->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return null;
        }
    }
}
