<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class post_comment extends Model
{
    protected $table = 'post_comment';

   protected $primaryKey = 'comment_id';

   protected $guarded = [];
}
