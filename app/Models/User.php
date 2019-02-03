<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $email
 * @property string $password
 */
class User extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];
}
