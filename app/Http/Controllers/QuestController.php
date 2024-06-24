<?php

namespace App\Http\Controllers;
use App\Models\Quest;
use Illuminate\Http\Request;

class QuestController extends Controller
{
    function quest(){
        $quest = new Quest;
        $quest = $quest->orderBy('id','DESC')->take(10)->get();
        if(!empty($quest)){
            return response()->json($quest);
        }
    }
    function getQuestByContent(Request $request){
        try {
            $searchValue = $request->input('searchValue');
            // $searchValue = "mặt";
            $quest = new Quest;
            $quest = Quest::where('content', 'like', '%'.$searchValue.'%')->take(10)->get();
      
            return response()->json($quest);
       
        } catch (Exception $error) {
            return response()->json([
                'success' => false,
                'message' => $error->getMessage(),
            ]);
        }
    }
    function getQuestByUserId($id){
        $records = Quest::orderBy('id','DESC')->where('owner', '=', $id)->take(30)->get();
        return response()->json($records);
    }
    public function createQuest(Request $request){
        try {
                 
            $newQuest = new Quest;

            $answers = array(); // danh sách đáp án để chọn
            
            $newQuest->content = $request->input('content');
            $newQuest->answer = $request->input('answer');
            $answerA = $request->input('answerA');
            $answerB = $request->input('answerB');
            $answerC = $request->input('answerC');
            $answerD = $request->input('answerD');
            $answerE = $request->input('answerE');
            $answerF = $request->input('answerF');
                if ($answerA !== null) $answers[] = $answerA;
                if ($answerB !== null) $answers[] = $answerB;
                if ($answerC !== null) $answers[] = $answerC;
                if ($answerD !== null) $answers[] = $answerD;
                if ($answerE !== null) $answers[] = $answerE;
                if ($answerF !== null) $answers[] = $answerF;
            $newQuest->answer_list = implode(', ', $answers);    
            $newQuest->owner = $request->input('owner');
            $newQuest->difficult = "0";
            $newQuest->save();

            return response()->json([
                'success' => true,
                'message' => 'create quest successfull',
                'data' => $newQuest,
            ], 200);
            
        } catch (Exception $error) {
            return response()->json([
                'success' => false,
                'message' => $error->getMessage(),
        ]);
    }
    }
    public function getQuestById($id){
        $records = Quest::find($id);
        
        $answersString = $records->answer_list; // "4,2,3,1" answer_list
        $answersArray = explode(',', $answersString);
        $numq = count($answersArray);
  
        $answerA = $answersArray[0] ?? null;
        $answerB = $answersArray[1] ?? null;
        $answerC = $answersArray[2] ?? null;
        $answerD = $answersArray[3] ?? null;
        $answerE = $answersArray[4] ?? null;
        $answerF = $answersArray[5] ?? null;
        // return $records;
        $records->setAttribute('num_of_answer', $numq);
        $records->setAttribute('answerA', trim($answerA)); // trim: xoa khoang trang
        $records->setAttribute('answerB', trim($answerB));
        $records->setAttribute('answerC', trim($answerC));
        $records->setAttribute('answerD', trim($answerD));
        $records->setAttribute('answerE', trim($answerE));
        $records->setAttribute('answerF', trim($answerF));
        return $records;

    }
}
