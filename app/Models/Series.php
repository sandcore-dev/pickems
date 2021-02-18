<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Series
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Season $latest_season
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\League[] $leagues
 * @property-read int|null $leagues_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Season[] $seasons
 * @property-read int|null $seasons_count
 * @method static Builder|Series newModelQuery()
 * @method static Builder|Series newQuery()
 * @method static Builder|Series query()
 * @method static Builder|Series whereCreatedAt($value)
 * @method static Builder|Series whereId($value)
 * @method static Builder|Series whereName($value)
 * @method static Builder|Series whereUpdatedAt($value)
 * @mixin \Eloquent
 * @noinspection PhpFullyQualifiedNameUsageInspection
 * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
 */
class Series extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

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
     * Get seasons of this series
     *
     * @return HasMany
     */
    public function seasons()
    {
        return $this->hasMany(Season::class);
    }

    /**
     * Get leagues of this series.
     *
     * @return HasMany
     */
    public function leagues()
    {
        return $this->hasMany(League::class);
    }

    /**
     * Get latest (most recent by year) season.
     *
     * @return Season
     */
    public function getLatestSeasonAttribute()
    {
        if ($this->seasons->isEmpty()) {
            return new Season();
        }

        return $this->seasons->sortByDesc('name')->first();
    }
}
