<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Questionnaire extends Model
{
  protected $fillable = ['user_id', 'phqscore','level'];

  public function user()
  {
     return $this->belongTo(User::class);
  }
}
