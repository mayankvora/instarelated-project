<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class post_like extends Model
{
    protected $table = 'post_like';

   protected $primaryKey = 'like_id';

   protected $guarded = [];
}
