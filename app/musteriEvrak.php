<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class musteriEvrak extends Model
{
    //
    protected $table = 'musteriEvrak';
    protected $primaryKey='id';
    public function newQuery($excludeDeleted = true) {
        return parent::newQuery($excludeDeleted)
            ->where("deleted", '=', "no");
    }
}
