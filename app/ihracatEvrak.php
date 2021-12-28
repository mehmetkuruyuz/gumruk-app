<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ihracatEvrak extends Model
{
    //
    protected $table = 'ihracatEvrak';
    protected $primaryKey='id';
    public function newQuery($excludeDeleted = true) {
        return parent::newQuery($excludeDeleted)
            ->where("deleted", '=', "no");
    }
}
