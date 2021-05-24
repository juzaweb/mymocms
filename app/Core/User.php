<?php
/**
 * MYMO CMS - TV Series & Movie Portal CMS Unlimited
 *
 * @package mymocms/mymocms
 * @author The Anh Dang
 *
 * Developed based on Laravel Framework
 * Github: https://github.com/mymocms/mymocms
 */

namespace App\Core;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\Core\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\User whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $is_admin
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\User whereIsAdmin($value)
 * @property string|null $avatar
 * @property int $status
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\User whereStatus($value)
 * @property string $language
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\User whereLanguage($value)
 * @property string|null $verification_token
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\User whereVerificationToken($value)
 * @property int|null $package_id
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePackageId($value)
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function getAvatar() {
        if ($this->avatar) {
            return image_url($this->avatar);
        }
        
        return asset('images/thumb-default.png');
    }
    
    public static function masterAdminId() {
        return 1;
    }
}
