<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class register_user extends Model
{
   protected $table = 'tbl_user';

   protected $primaryKey = 'user_id';

   protected $guarded = [];
}
