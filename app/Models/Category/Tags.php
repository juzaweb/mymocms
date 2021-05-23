<?php

namespace App\Models\Category;

use App\Traits\UseSlug;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Category\Tags
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category\Tags newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category\Tags newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category\Tags query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category\Tags whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category\Tags whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category\Tags whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category\Tags whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category\Tags whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Tags extends Model
{
    use UseSlug;
    
    protected $table = 'tags';
    protected $primaryKey = 'id';
    protected $fillable = ['name'];
}
