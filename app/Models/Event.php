<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable; //I'm not sure if I'll use this, make we dey see


class Event extends Authenticatable
{
    use HasFactory, Notifiable;
    //
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'parish_id',
        'title',
        'description',
        'event_date',
        'location'.
        'banner'
    ];

    public function parish(){
        return $this->belongsTo(Parish::class);
    }
}
