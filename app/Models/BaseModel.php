<?php
/**
 * Created by PhpStorm.
 * User: akinyele.olubodun
 * Date: 23/04/2016
 * Time: 5:17 AM
 */

namespace Livestock247\Models;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    public $timestamps = false;

    protected $dateFormat = 'U';

    public function __construct()
    {
        parent::__construct();
    }
}