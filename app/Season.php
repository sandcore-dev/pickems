<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Season
 *
 * @property int $id
 * @property int $series_id
 * @property float $start_year
 * @property float $end_year
 * @property int $picks_max
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Collections\EntryCollection|\App\Entry[] $entries
 * @property-read int|null $entries_count
 * @property-read string $name
 * @property-read \App\Season $previous
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Race[] $races
 * @property-read int|null $races_count
 * @property-read \App\Series $series
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Season newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Season newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Season query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Season whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Season whereEndYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Season whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Season wherePicksMax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Season whereSeriesId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Season whereStartYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Season whereUpdatedAt($value)
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
