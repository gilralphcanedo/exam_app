<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Choice extends Model
{

	protected $fillable = [
		'question_id' ,
		'choice_text' , 
		'correct' , 
	];

  public function questions()
  {
  	return $this->belongsTo('App\Question', 'question_id', 'question_id');
  }
  
}
