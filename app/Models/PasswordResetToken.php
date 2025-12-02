<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordResetToken extends Model
{
    
    // Tell Laravel that 'email' is the primary key
    protected $primaryKey = 'email';
    
    // Tell Laravel the primary key is not an auto-incrementing integer
    public $incrementing = false;
    
    // Specify the primary key type as string
    protected $keyType = 'string';
    //
    protected $fillable = [
        'email',
        'token'
    ];
}
