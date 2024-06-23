<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function registeredEvents()
    {
        return $this->belongsToMany(Event::class, 'registers', 'user_id', 'event_id');
    }

    public function registeredForEvent(Event $event)
    {
        return $this->registeredEvents()->where('event_id', $event->id)->exists();
    }

    public function events()
    {
        return $this->belongsToMany(Event::class, 'registers', 'user_id', 'event_id')->withTimestamps();
    }
    public function isAdmin()
    {
        // Check if the user has admin role or any other condition that indicates admin status
        return $this->role === 'admin'; // Adjust this condition according to your application's logic
    }
  
    public function hasRole($role)
    {
        return $this->role === $role;
    }
}