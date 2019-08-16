<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Event extends Model
{
    protected $fillable = ['title', 'from', 'to', 'days'];

    public function setDaysAttribute($value)
    {
        $this->attributes['days'] = serialize($value);
    }

    public function setFromAttribute($value)
    {
        $this->attributes['from'] = Carbon::parse($value)->format('Y-m-d');
    }

    public function setToAttribute($value)
    {
        $this->attributes['to'] = Carbon::parse($value)->format('Y-m-d');
    }

    public function getDaysAttribute($value)
    {
        return $this->attributes['days'] = unserialize($value);
    }
}
