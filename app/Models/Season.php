<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Season
 *
 * @property int $id
 * @property int $series_id
 * @property string $start_year
 * @property string $end_year
 * @property int $picks_max
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Collections\EntryCollection|\App\Models\Entry[] $entries
 * @property-read int|null $entries_count
 * @property-read string $name
 * @property-read Season $previous
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Race[] $races
 * @property-read int|null $races_count
 * @property-read \App\Models\Series $series
 * @method static Builder|Season newModelQuery()
 * @method static Builder|Season newQuery()
 * @method static Builder|Season query()
 * @method static Builder|Season whereCreatedAt($value)
 * @method static Builder|Season whereEndYear($value)
 * @method static Builder|Season whereId($value)
 * @method static Builder|Season wherePicksMax($value)
 * @method static Builder|Season whereSeriesId($value)
 * @method static Builder|Season whereStartYear($value)
 * @method static Builder|Season whereUpdatedAt($value)
 * @mixin \Eloquent
 * @noinspection PhpFullyQualifiedNameUsageInspection
 * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
 */
class Season extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['series_id', 'start_year', 'end_year', 'picks_max'];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(
            'sortByStartAndEnd',
            function (Builder $builder) {
                $builder->orderBy('start_year', 'desc')->orderBy('end_year', 'desc');
            }
        );
    }

    /**
     * Get series of this season.
     *
     * @return BelongsTo
     */
    public function series()
    {
        return $this->belongsTo(Series::class);
    }

    /**
     * Get races of this season.
     *
     * @return HasMany
     */
    public function races()
    {
        return $this->hasMany(Race::class);
    }

    /**
     * Get entries of this season.
     *
     * @return HasMany
     */
    public function entries()
    {
        return $this->hasMany(Entry::class);
    }

    /**
     * Get the season's name.
     *
     * @return string
     */
    public function getNameAttribute()
    {
        $out = $this->start_year;

        if ($this->start_year != $this->end_year) {
            $out .= '-' . $this->end_year;
        }

        return $out;
    }

    /**
     * Get previous season.
     *
     * @return Season
     */
    public function getPreviousAttribute()
    {
        $previousSeasons = $this->series->seasons
            ->where('id', '!=', $this->id)
            ->where('start_year', '<', $this->start_year)
            ->where('end_year', '<', $this->end_year)
            ->sortByDesc('name');

        return $previousSeasons->isEmpty() ? new self() : $previousSeasons->first();
    }
}
