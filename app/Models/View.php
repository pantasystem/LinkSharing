<?php
namespace App\Models;

use Illuminate\Detabase\Eloquent\Model;
use RuntimeException;

abstract class View extends Model
{
    protected $fillable = [];

    final public function __set($key, $value)
    {
        throw new RuntimeException("このクラスはView専用です。");
    }
}