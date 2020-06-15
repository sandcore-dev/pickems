<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Collections\ResultCollection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Result
 *
 * @property int $id
 * @property int $rank
 * @property int $race_id
 * @property int $entry_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Entry $entry
 * @property-read \App\Race $race
 * @method static \App\Collections\ResultCollection|static[] all($columns = ['*'])
 * @method static \App\Collections\ResultCollection|static[] get($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Result newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Result newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Result query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Result whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Result whereEntryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Result whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Result whereRaceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Result whereRank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Result whereUpdatedAt($value)
 * @mixin \Eloquent
 * @noinspection PhpFullyQualifiedNameUsageInspection
 * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
 */
class Result extends Model
{
    /**
     * The attributes that are mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['race_id', 'entry_id', 'rank'];

    /**
     * Creates a new Collection instance of this model.
     *
     * @param array $models
     *
     * @return Collection
     */
    public function newCollection(array $models = [])
    {
        return new ResultCollection($models);
    }

    /**
     * Get the race of this result.
     *
     * @return BelongsTo
     */
    public function race()
    {
        return $this->belongsTo(Race::class);
    }

    /**
     * Get the entry of this result.
     *
     * @return BelongsTo
     */
    public function entry()
    {
        return $this->belongsTo(Entry::class);
    }
}
