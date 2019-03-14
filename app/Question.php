<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{

	protected $fillable = [
		'exam_id' , 
		'question_text' , 
	];

  public function exams()
  {
  	return $this->belongsTo('App\Exam', 'exam_id', 'exam_id');
  }

  public function choices()
  {
  	return $this->hasMany('App\Choice', 'question_id', 'question_id');
  }
}
