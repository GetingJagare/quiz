<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Mark
 *
 * @property int $id
 * @property int $user_id
 * @property int $report_id
 * @property int $mark
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\User $report
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mark newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mark newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mark query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mark whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mark whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mark whereMark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mark whereReportId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mark whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mark whereUserId($value)
 * @mixin \Eloquent
 * @property int $expert_type
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mark whereExpertType($value)
 */
class Mark extends Model
{
    const EXPERT_TYPE_COM = 0;
    const EXPERT_TYPE_EXP = 1;
    
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
