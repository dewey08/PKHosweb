<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $table = 'hrd_person';
    protected $primaryKey = 'ID';

    // public function prefixs() {
    //     return $this->belongsTo(Prefix::class);
    // }
    
    // public function user() {
    //     return $this->hasOne(User::class, 'PERSON_ID', 'ID');
    // }
    public static function getPersonWork(){
        return Person::leftJoin('hrd_prefix','hrd_prefix.HR_PREFIX_ID','hrd_person.HR_PREFIX_ID')
        ->where(function ($q){
            $q->orWhere('HR_STATUS_ID',1)
            ->orWhere('HR_STATUS_ID',2)
            ->orWhere('HR_STATUS_ID',3)
            ->orWhere('HR_STATUS_ID',4);
        })->get();
    }
}
