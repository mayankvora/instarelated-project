<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class post_dislike extends Model
{
   protected $table = 'post_dislike';

   protected $primaryKey = 'dislike_id';

   protected $guarded = [];
}
