<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Reports
 *
 * @property int $id
 * @property string $name
 * @property string $reporter
 * @property string $position
 * @property string $filial
 * @property string $from
 * @property string $to
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Report newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Report newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Report query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Report whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Report whereFilial($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Report whereFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Report whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Report whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Report wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Report whereReporter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Report whereTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Report whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Mark[] $marks
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\MarkExpert[] $expertMarks
 */
class Report extends Model
{
    protected $fillable = [
        'name',
        'reporter',
        'position',
        'filial',
        'from',
        'to'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function marks()
    {
        return $this->hasMany('App\Mark');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function expertMarks()
    {
        return $this->hasMany('App\MarkExpert');
    }

    /**
     * @param User $user
     * @return bool
     */
    public function hasMark(User $user)
    {
        if ($user->is_expert) {
            return false;
        }

        return (bool)$this->marks()->whereUserId($user->id)->count();
    }

    /**
     * @param User $user
     * @return bool
     */
    public function hasExpertMark(User $user)
    {
        if (!$user->is_expert) {
            return false;
        }

        return (bool)$this->expertMarks()->whereUserId($user->id)->count();
    }

    /**
     * @return mixed
     */
    public function getAverageMark()
    {
        return $this->marks()->average('mark');
    }

    /**
     * @return mixed
     */
    public function getAverageNovelty()
    {
        return $this->expertMarks()->average('novelty');
    }

    /**
     * @return mixed
     */
    public function getAverageStudy()
    {
        return $this->expertMarks()->average('study');
    }

    /**
     * @return mixed
     */
    public function getAverageWorth()
    {
        return $this->expertMarks()->average('worth');
    }

    /**
     * @return mixed
     */
    public function getAverageRepresentation()
    {
        return $this->expertMarks()->average('representation');
    }

    /**
     * @return mixed
     */
    public function getAverageEfficiency()
    {
        return $this->expertMarks()->average('efficiency');
    }
}
