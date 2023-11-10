<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    //

    public function getCourses(){
        $courses = Course::all();
        return response()->json($courses,200);
    }

    public function storeQuiz(Request $request){
      
       
       try{
        DB::beginTransaction();
        $questions = $request->questions;
        foreach($questions as $question){
            
            $course = Course::findOrFail($question['course_id']);
            
            foreach($question['questions'] as $q){
                $quiz = $course->quizzes()->create([
                    'title' => $q['question'],
                    'comment' => $q['has_comment'],
                    'graded' => $q['graded']
                ]);
                foreach($q['answers'] as $qq){
                    $q = $quiz->answers()->create([
                        'question' => $qq['answer'],
                        'is_correct' => $qq['is_correct']
                    ]);
                }
            }
 
        }
        DB::commit();
        return response()->json('Quiz created successfully',200);
       }
         catch(\Exception $e){
              DB::rollBack();
              return response()->json($e->getMessage(),500);
         }
    }


    public function getQuiz($course_id){
        $course = Course::findOrFail($course_id);
        $quizzes = $course->quizzes()->with('answers')->get();
        return response()->json($quizzes,200);
    }

    public function deleteQuestion(Request $request){
        $quiz = Quiz::findOrFail($request->id);
        $quiz->delete();
        return response()->json('Question deleted successfully',200);
    }

    public function updateQuiz(Request $request){
        
       try{
        DB::beginTransaction();
       foreach($request->questions as $question){
      
           $quiz = Quiz::findOrFail($question['id']);
           $quiz->update([
               'title' => $question['title'],
               'comment' => $question['comment'],
               'graded' => $question['graded']
           ]);
           $quiz->answers()->delete();
           foreach($question['answers'] as $answer){
               $quiz->answers()->create([
                   'question' => $answer['question'],
                   'is_correct' => $answer['is_correct']
               ]);
           }
         }
        DB::commit();
        return response()->json('Quiz updated successfully',200);
       }
         catch(\Exception $e){
              DB::rollBack();
              return response()->json($e->getMessage(),500);
         }
    }
}
