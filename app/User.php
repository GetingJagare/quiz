<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $email_verified_at
 * @property string $password
 * @property int $is_admin
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereIsAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $filial
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereFilial($value)
 * @property int $is_expert
 * @property string|null $token
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereIsExpert($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereToken($value)
 * @property int $expert_type
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereExpertType($value)
 */
class User extends Authenticatable
{
    use Notifiable;

    const TYPES = [
        'Конкурсная комиссия',
        'Эксперты',
        'Зрители',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'is_admin' => 'boolean',
        'is_expert' => 'boolean'
    ];

    /**
     * @param integer $reportId
     *
     * @return integer
     */
    public function getReportAverageCount($reportId) {
        /** @var MarkExpert $markExpert */
        $markExpert = MarkExpert::where(['report_id' => $reportId, 'user_id' => $this->id])->first();

        if (!$markExpert) {
            return 0;
        }

        $avgCount = ($markExpert->novelty + $markExpert->study + $markExpert->worth + $markExpert->representation + $markExpert->efficiency) / 5;

        return round($avgCount, 2);
    }
}
