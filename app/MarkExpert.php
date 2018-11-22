<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\MarkExpert
 *
 * @property int $id
 * @property int $user_id
 * @property int $report_id
 * @property int $novelty
 * @property int $study
 * @property int $worth
 * @property int $representation
 * @property int $efficiency
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\User $report
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MarkExpert newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MarkExpert newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MarkExpert query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MarkExpert whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MarkExpert whereEfficiency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MarkExpert whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MarkExpert whereNovelty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MarkExpert whereReportId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MarkExpert whereRepresentation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MarkExpert whereStudy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MarkExpert whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MarkExpert whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MarkExpert whereWorth($value)
 * @mixin \Eloquent
 */
class MarkExpert extends Model
{
    protected $fillable = [
        'user_id',
        'report_id',
        'mark'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function report()
    {
        return $this->belongsTo('App\User');
    }
}
