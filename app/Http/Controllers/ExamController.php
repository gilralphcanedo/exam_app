<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Choice;
use App\Question;
use App\Exam;
use App\User;
use Auth;

class ExamController extends Controller
{
  public function index(Request $request)
  {
  	// $exams = Exam::with('users')->paginate(5);
    $exams = Exam::with(['questions', 'questions.choices'])->paginate(5);
  	return view('exams', compact('exams'));
  }

  public function addExam(Request $request)
  {
  	$examTitle = $request->input('exam-title');
  	$examDesc = $request->input('exam-desc');
  	$userID = Auth::user()->id;

    $this->validate($request,['exam-title' => 'required', 'exam-desc' => 'required']);

  	$create = Exam::create([
  			'id' => $userID,
  	    'exam_title' => $examTitle,
  	    'exam_desc' => $examDesc,
  	]);
    session()->flash('message','Exam added successfully!');
  	return redirect('/home');
  }

  public function updateExam(Request $request,$examID)
  {
		$examTitle = $request->input('exam-title');
		$examDesc = $request->input('exam-desc');

    $this->validate($request,['exam-title' => 'required', 'exam-desc' => 'required']);

		$update = Exam::where('exam_id' , $examID)->update([
		    'exam_title' => $examTitle,
  	    'exam_desc' => $examDesc,
		]);
    session()->flash('message','Exam updated successfully!');
    return redirect('/home');
  }

  public function deleteExam($examID)
  {
    $delete = Exam::where('exam_id', $examID)->delete();
    session()->flash('message','Exam deleted successfully!');
    return redirect('/home');
  }

  public function startExam($examID){
    $all = Exam::with(['questions', 'questions.choices'])->where('exam_id', $examID)->get();
    return view('exam-page', compact('all'));
  }

  public function processExam(Request $request, $examID){
    $exams = Exam::with(['questions', 'questions.choices'])->where('exam_id', $examID)->get();

    $correctAnswers_array = [];
    $guestAnswers_array = [];

    foreach ($exams as $key1 => $exam) {
      foreach ($exam->questions as $key2 => $questions) {
        foreach ($questions->choices as $key3 => $choices) {
          if ($choices->correct == "true") {
            $correctAnswers_array[] = $choices->choice_text;
          }
        }
      }
    }
    
    $count_correct_ans = 0;

    foreach ($request->post() as $requestKey => $value) {
      if ($requestKey != "_token") {
        $guestAnswers_array[] = $value;
      }
    }

    for ($i=0; $i < count($correctAnswers_array); $i++) { 
      if ($correctAnswers_array[$i] == $guestAnswers_array[$i]) {
        $count_correct_ans++;
      }
    }

    $final_score = $count_correct_ans;
    $total_num_items = count($correctAnswers_array);
    $score_percentage = round((($final_score/$total_num_items)*100),2);

    return view('result', compact('final_score','total_num_items','score_percentage'));
  }

}
