<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
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

    /**
     * The attributes that are mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['series_id', 'name', 'access_token'];

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
                $builder->orderBy('name', 'asc');
            }
        );
    }

    /**
     * Get users of this league.
     *
     * @return BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    /**
     * Get series of this league.
     *
     * @return BelongsTo
     */
    public function series()
    {
        return $this->belongsTo(Series::class);
    }

    /**
     * Get standings of this league.
     *
     * @return HasMany
     */
    public function standings()
    {
        return $this->hasMany(Standing::class);
    }

    /**
     * Scope query by token.
     *
     * @param string $token
     * @return Builder
     */
    public function scopeByToken($query, $token)
    {
        return $query->whereNotNull('access_token')->where('access_token', $token);
    }

    /**
     * Get next race according to weekend_start.
     *
     * @return Race|null
     */
    public function getNextDeadlineAttribute()
    {
        $nextDeadline = $this->series->first()->seasons->first()->races()->nextDeadline();

        return $nextDeadline->count() ? $nextDeadline->first() : null;
    }
}
