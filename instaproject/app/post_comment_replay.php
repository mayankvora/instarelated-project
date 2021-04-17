<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class post_comment_replay extends Model
{
   protected $table = 'post_comment_replay';

   protected $primaryKey = 'replay_id';

   protected $guarded = [];
}
