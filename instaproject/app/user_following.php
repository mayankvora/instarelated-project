<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class user_following extends Model
{
   protected $table = 'user_following';

   protected $primaryKey = 'following_id';

   protected $guarded = [];
}
