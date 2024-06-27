<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'description', 'image', 'date', 'time', 'price', 'user_id', 'major', 'rating'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Many-to-many relationship with User through calendar_events pivot table
    public function users()
    {
        return $this->belongsToMany(User::class, 'calendar_user_event')->withTimestamps();
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function ranks()
    {
        return $this->hasMany(Rank::class, 'id_evenement');
    }
    public function registrations()
    {
        return $this->hasMany(Register::class);
    }
    public function calendarEvents()
    {
        return $this->hasMany(CalendarEvent::class);
    }
}