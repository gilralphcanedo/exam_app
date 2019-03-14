<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exam;
use App\Question;
use App\Choice;

class ChoiceController extends Controller
{
  public function index($examID,$questionID)
  {
  	$max_num_choices = 4;
  	$exam = Exam::where('exam_id',$examID)->first();
  	$question = Question::where('question_id',$questionID)->first();
  	$choices = Choice::with('questions')->where('question_id',$questionID)->get();
  	return view('question-details', compact('choices','question','exam','max_num_choices'));
  }

  public function addChoice(Request $request, $examID, $questionID)
  {
  	$choiceText = $request->input('choice-text');
  	$correct = $request->input('choice-answer');
  	if ($correct == null) {
  		$correct = "false";
  	}
  	else{
  		$correct = $correct[0];
  	}

    $this->validate($request,['choice-text' => 'required']);

  	$create = Choice::create([
  			'question_id' => $questionID,
  	    'choice_text' => $choiceText,
  	    'correct' => $correct,
  	]);
  	session()->flash('message','Choice added successfully!');
  	return redirect('exams/'.$examID.'/questions/'.$questionID.'/manage');
  }

  public function updateChoice(Request $request, $examID, $questionID, $choiceID)
  {
		$choiceText = $request->input('choice-text');
		$correct = $request->input('choice-answer');
		if ($correct == null) {
			$correct = "false";
		}
		else{
			$correct = $correct[0];
		}

    $this->validate($request,['choice-text' => 'required']);
    
		$update = Choice::where('choice_id' , $choiceID)->update([
		    'choice_text' => $choiceText,
  	    'correct' => $correct,
		]);
		session()->flash('message','Choice updated successfully!');
    return redirect('exams/'.$examID.'/questions/'.$questionID.'/manage');
  }

  public function deleteChoice($examID, $questionID, $choiceID)
  {
    $delete = Choice::where('choice_id', $choiceID)->delete();
    session()->flash('message','Choice deleted successfully!');
    return redirect('exams/'.$examID.'/questions/'.$questionID.'/manage');
  }
}
