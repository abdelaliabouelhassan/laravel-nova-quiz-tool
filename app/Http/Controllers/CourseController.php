<?php

namespace App\Http\Controllers;

use App\Models\Course;
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
                foreach($q['questions'] as $qq){
                    $q = $quiz->questions()->create([
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
}
