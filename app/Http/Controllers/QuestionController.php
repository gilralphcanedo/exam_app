<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;
use App\Exam;

class QuestionController extends Controller
{
  public function index($examID)
  {
    $questions = Question::with(['exams','choices'])->where('exam_id', $examID)->paginate(5);
    $exams = Exam::where('exam_id', $examID)->get();
  	return view('exam-details', compact('exams','questions'));
  }

  public function addQuestion(Request $request, $examID)
  {

  	$questionText = $request->input('question-text');

    $this->validate($request,['question-text' => 'required']);

  	$create = Question::create([
  			'exam_id' => $examID,
  	    'question_text' => $questionText,
  	]);
    session()->flash('message','Question added successfully!');
  	return redirect('exams/'.$examID.'/questions/'.$create->id.'/manage');
  }

  public function updateQuestion(Request $request,$examID,$questionID)
  {
    // $exam = Exam::where('exam_id',$examID)->first();
		$questionText = $request->input('question-text');

    $this->validate($request,['question-text' => 'required']);

		$update = Question::where('question_id' , $questionID)->update([
		    'question_text' => $questionText,
		]);
    session()->flash('message','Question updated successfully!');
    return redirect('/exams/'.$examID."/view");
  }

  public function deleteQuestion($examID,$questionID)
  {
    $delete = Question::where('question_id', $questionID)->delete();
    session()->flash('message','Question deleted successfully!');
    return redirect('/exams/'.$examID."/view");
  }
}
