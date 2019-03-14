<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{

	protected $fillable = [
		'id' , 
		'exam_title' , 
		'exam_desc' ,
	];

	public function users()
	{
		return $this->belongsTo('App\User', 'id', 'id');
	}

	public function questions()
	{
		return $this->hasMany('App\Question', 'exam_id', 'exam_id');
	}

}
