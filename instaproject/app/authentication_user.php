<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class authentication_user extends Model
{
   protected $table = 'tbl_authentication';

   protected $primaryKey = 'auth_id';

   protected $guarded = [];
}
