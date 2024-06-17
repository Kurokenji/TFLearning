<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Test;
use App\Models\Quest;
use App\Models\History;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ExamController extends Controller
{
    function doExam($id){
        $test = new Test;
        $test = $test->find($id);
        return response()->json($test);
    }
    function testDetail(){
        $test = new Test;
        $test = $test->orderBy('id','DESC')->take(3)->get();
        if(!empty($test)){
            return response()->json($test);
        }
    }
    public function submitExam(Request $request){
        try {
          $newHistory = new History;
          $split = ",";
          $total = 0;
          $newHistory->user_id = $request->input('doingUser');
          $newHistory->test_id = $request->input('doingTest');
          $newHistory->quest_submit =  $request->input('arrayData');
          // xử lí time
        //   $timeSt = Carbon::parse($request->input('timeStart'))->format('H:i:s');
        //   $timeFn = Carbon::parse($request->input('timeFinish'))->format('H:i:s');
        //   $difference = $endTime->diff($startTime);
        //   $hours = $difference->h;
        //   $minutes = $difference->i;
        //   $seconds = $difference->s;
        //   $timeTotal = $hours . ":" . $minutes . ":" . $seconds;
          $newHistory->time = "60";
          // xử lí điểm
          $test = Test::where('id', '=', $newHistory->test_id)->first();
        //   $answer = new t;
          $arrayA = explode($split, $newHistory->quest_submit); // đáp án gửi đi
          $arrayB = explode($split , $test->quest); // mảng câu hỏi tương ứng
          $num_quest = count($arrayB); // đếm số câu hỏi trong bộ đ thi
          for ($i = 0; $i < $num_quest; $i++) {
            $elementA = $arrayA[$i];
            $elementB = $arrayB[$i];         
            $answer = Quest::where('id', '=', intval($elementB))->first();
            if($elementA == $answer->answer) $total++;
            // so khớp
            }
            $diem = strval($total) ;
          $newHistory->scores =  $diem . "/" . $num_quest;
          $newHistory->save();
          return response()->json([
            'success' => true,
            'message' => 'do exam successfull',
            'data' => $newHistory,
        ], 200);
        } catch (Exception $error) {
            return response()->json([
                'success' => false,
                'message' => $error->getMessage(),
            ]);
        }
    }

    function getQuestInTest($id){
        // return "hllo";
        $test = new Test;   
        $test = $test->find($id);
        return response()->json($test);
    }
    
}