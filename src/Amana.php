<?php
/**
 * Created by PhpStorm.
 * User: binhnx
 * Date: 27/03/2019
 * Time: 11:23
 */

namespace Herode\Amana;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Amana.
 *
 * @package namespace Herode\Amana;
 */
class Amana extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'env',
        'user_target',
        'app_file_name',
        'plist_file_name',
        'version',
        'build',
        'is_latest_version',
        'device_type',
    ];


    /**
     * Get the default JavaScript variables for Amana.
     *
     * @return array
     */
    public static function scriptVariables()
    {
        return [
            'path'     => config('amana.path'),
            'timezone' => config('app.timezone')
        ];
    }
}
