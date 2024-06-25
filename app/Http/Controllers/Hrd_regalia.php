<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hrd_regalia extends Model
{
    use HasFactory;
        /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'HRD_REGALIA_ID',
        'YEAR_OF_RECEIPT',
        'DAY_OF_RECEIPT',
        'POSITION',
        'BADGE',
        'BADGE_R_G_L',
        'BADGE_R_G_D',
        'ANNOUNCEMENT_DATE',
        'VOLUME',
        'DUTY',
        'NO',
        'AGENCY',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
}
