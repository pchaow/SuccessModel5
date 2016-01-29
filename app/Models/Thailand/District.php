<?php
namespace App\Models\Thailand;

/**
 * Created by PhpStorm.
 * UserRequest: chaow
 * Date: 4/6/2015
 * Time: 12:59 PM
 */

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class District extends Model
{
    protected $primaryKey = 'DISTRICT_ID';


    protected $table = "district";

}