<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'prenom', 'nom', 'courriel', 'motDePasse', 'isAdmin',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'motDePasse', 'remember_token',
    ];

    public function evenement_inscriptions(){
        return $this->hasMany('App\EvenementInscription');
    }

    public function atelier_inscriptions(){
        return $this->hasMany('App\AtelierInscription');
    }

    public function professeur(){
        return $this->belongsTo('App\Professeur');
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->motDePasse;
    }

    public function getEmailAttribute()
    {
        return $this->attributes['courriel'];
    }

    public function setEmailAttribute($value)
    {
        $this->attributes['courriel'] = strtolower($value);
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new Notifications\MailResetPasswordNotification($token));
    }
}
