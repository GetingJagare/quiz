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
 * @property \Illuminate\Support\Carbon|null $vote_to
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
 * @property int $active
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Report whereActive($value)
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
        'updated_at',
        'from',
        'to'
    ];

    protected $casts = [
        'active' => 'boolean'
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
        /*if ($user->is_expert) {
            return false;
        }*/

        return (bool)$this->marks()->whereUserId($user->id)->count();
    }

    /**
     * @param User $user
     * @return bool
     */
    public function getMark(User $user)
    {
        if ($user->is_expert) {
            return null;
        }

        return $this->marks()->whereUserId($user->id)->first();
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
     * @param User $user
     * @return bool
     */
    public function getExpertMark(User $user)
    {
        if (!$user->is_expert) {
            return null;
        }

        return $this->expertMarks()->whereUserId($user->id)->first();
    }

    /**
     * @return mixed
     */
    public function getAverageMark()
    {
        return $this->hasMarks() ? number_format($this->marks()->average('mark'), 2) : "Нет проголосовавших";
    }

    /**
     * @return mixed
     */
    public function getAverageNovelty($type = 0)
    {
        return $this->hasExpertMarks($type) ? number_format($this->expertMarks()->whereExpertType($type)->average('novelty'), 2) : "Нет проголосовавших";
    }

    /**
     * @return mixed
     */
    public function getAverageStudy($type = 0)
    {
        return $this->hasExpertMarks($type) ? number_format($this->expertMarks()->whereExpertType($type)->average('study'), 2) : "Нет проголосовавших";
    }

    /**
     * @return mixed
     */
    public function getAverageWorth($type = 0)
    {
        return $this->hasExpertMarks($type) ? number_format($this->expertMarks()->whereExpertType($type)->average('worth'), 2) : "Нет проголосовавших";
    }

    /**
     * @return mixed
     */
    public function getAverageRepresentation($type = 0)
    {
        return $this->hasExpertMarks($type) ? number_format($this->expertMarks()->whereExpertType($type)->average('representation'), 2) : "Нет проголосовавших";
    }

    /**
     * @return mixed
     */
    public function getAverageEfficiency($type = 0)
    {
        return $this->hasExpertMarks($type) ? number_format($this->expertMarks()->whereExpertType($type)->average('efficiency'), 2) : "Нет проголосовавших";
    }

    /**
     * @param int $type
     * @return string
     */
    public function getTotalAverage($type = 0)
    {
        return $this->hasExpertMarks($type) ? number_format(($this->getAverageNovelty($type) + $this->getAverageStudy($type) + $this->getAverageWorth($type) +
                $this->getAverageRepresentation($type) + $this->getAverageEfficiency($type)) / 5, 2) : "Нет проголосовавших";
    }

    /**
     * @param int $type
     * @return bool
     */
    public function hasMarks()
    {
        return (bool)$this->marks()->count();
    }

    /**
     * @param int $type
     * @return bool
     */
    public function hasExpertMarks($type = 0)
    {
        return (bool)$this->expertMarks()->whereExpertType($type)->count();
    }

    /**
     * @return string
     */
    public function getAllTotalAverage()
    {
        if ($this->hasExpertMarks() && $this->hasExpertMarks(1)) {
            return (float)$this->getTotalAverage() + (float)$this->getTotalAverage(1);
        } elseif ($this->hasExpertMarks()) {
            return $this->getTotalAverage();
        } elseif ($this->hasExpertMarks(1)) {
            return $this->getTotalAverage(1);
        } else {
            return "Нет проголосовавших";
        }
    }

    /**
     * @return int
     */
    public function getAcceptedCount()
    {
        return $this->marks()->where('mark', '=', 1)->count();
    }

    /**
     * @return int
     */
    public function getParticallyAcceptedCount()
    {
        return $this->marks()->where('mark', '=', 0.5)->count();
    }

    /**
     * @return int
     */
    public function getDeclinedCount()
    {
        return $this->marks()->where('mark', '=', 0)->count();
    }
}
