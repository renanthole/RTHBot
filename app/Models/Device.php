<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Device extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'phone',
        'img_url',
        'instancia',
        'token',
        'session_id',
        'business',
        'connected',
        'connected_at',
        'smartphone_connected',
        'smartphone_connected_at'
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = trim(mb_strtoupper($value));
    }

    public function setPhoneAttribute($value)
    {
        $this->attributes['phone'] = is_null($value) ? null : preg_replace('/[^0-9]/', '', $value);
    }

    public function setInstanciaAttribute($value)
    {
        $this->attributes['instancia'] = trim(mb_strtoupper($value));
    }

    public function setTokenAttribute($value)
    {
        $this->attributes['token'] = trim(mb_strtoupper($value));
    }
}
