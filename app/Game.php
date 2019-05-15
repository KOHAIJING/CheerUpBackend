<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
  protected $fillable = ['user_id', 'responsetime','accuracy', 'bef_feel', 'aft_feel', 'positive_bias','negative_bias'];

  public function user()
  {
     return $this->belongTo(User::class);
  }
}
