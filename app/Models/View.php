<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use RuntimeException;

abstract class View extends Model
{
    protected $fillable = [];

    final public function __set($key, $value)
    {
        throw new RuntimeException("このクラスはView専用です。");
    }

    final public function setAttribute($key, $value)
    {
        throw new RuntimeException("このクラスはView専用です。");
    }
}