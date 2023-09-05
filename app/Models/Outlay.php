<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Outlay extends Model
{
    use SoftDeletes;
    protected $table = 'outlays';
    protected $fillable = ['description', 'outlay_date', 'amount', 'user_id'];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
