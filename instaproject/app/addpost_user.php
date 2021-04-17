<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class addpost_user extends Model
{
   protected $table = 'add_post';

   protected $primaryKey = 'post_id';

   protected $guarded = [];
}
