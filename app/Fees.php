<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Fees extends Model
{
    //
    protected $fillable = [
        'user_id', 'fee', 'amount', 'status', 'session',
    ];
}
