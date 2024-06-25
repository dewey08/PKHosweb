<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Article extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'article_data';
    protected $primaryKey = 'article_id';
    protected $fillable = [
        'article_fsn',
        'article_num',
        'article_name',
        'article_attribute',
        'article_spypriceid',
        'article_typeid',
        'article_categoryid',
        'article_groupid',
        'article_unit_id',
        'article_img'
            
    ];


    // public function photo(){
    //     return $this->belongsTo(UserDetail::class);
    // }

  
}
