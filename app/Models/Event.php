<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
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
