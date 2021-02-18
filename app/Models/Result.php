<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Collections\ResultCollection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Result
 *
 * @property int $id
 * @property int $rank
 * @property int $race_id
 * @property int $entry_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Entry $entry
 * @property-read \App\Models\Race $race
 * @method static ResultCollection|static[] all($columns = ['*'])
 * @method static ResultCollection|static[] get($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|Result newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Result newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Result query()
 * @method static \Illuminate\Database\Eloquent\Builder|Result whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Result whereEntryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Result whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Result whereRaceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Result whereRank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Result whereUpdatedAt($value)
 * @mixin \Eloquent
 * @noinspection PhpFullyQualifiedNameUsageInspection
 * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
 */
class Result extends Model
{
    use HasFactory;

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
