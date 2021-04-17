<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class   post_content extends Model
{
   protected $table = 'post_content';

   protected $primaryKey = 'content_id';

   protected $guarded = [];
}
