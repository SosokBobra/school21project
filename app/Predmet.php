<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Predmet extends Model
{
    protected $table = 'predmet';
    protected $fillable = ['name_id', 'teacher_id', 'score'];
    public function student()
    {
        return $this->hasOne('App\Students', 'id');
    }

    public function teacher()
    {
        return $this->hasOne('App\Teachers', 'id');
    }
}
