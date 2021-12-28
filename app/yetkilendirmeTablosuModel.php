<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class yetkilendirmeTablosuModel extends Model
{
    protected $table = 'yetkilendirmeTablosu';
    protected $primaryKey='id';
    protected $fillable=['pageurl','userId'];
    


}
