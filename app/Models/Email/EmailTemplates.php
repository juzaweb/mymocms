<?php

namespace App\Models\Email;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Email\EmailTemplates
 *
 * @property int $id
 * @property string $code
 * @property string $subject
 * @property string|null $content
 * @property string|null $params
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Email\EmailTemplates newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Email\EmailTemplates newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Email\EmailTemplates query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Email\EmailTemplates whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Email\EmailTemplates whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Email\EmailTemplates whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Email\EmailTemplates whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Email\EmailTemplates whereParams($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Email\EmailTemplates whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Email\EmailTemplates whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EmailTemplates extends Model
{
    protected $table = 'email_templates';
    protected $primaryKey = 'id';
    protected $fillable = [
        'subject',
        'content',
    ];
    
    public static function findCode(string $code) {
        return self::where('code', '=', $code)
            ->first();
    }
}
