<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class user_followers extends Model
{
   protected $table = 'user_followers';

   protected $primaryKey = 'follow_id';

   protected $guarded = [];
}
