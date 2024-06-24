<?php

namespace App\Http\Controllers;
use App\Models\History;
use App\Models\Test;
use Illuminate\Http\Request;
use Carbon\Carbon;


class HistoryController extends Controller
{
    function getHistory($id){
        $history = History::orderBy('id','DESC')->where('user_id', '=', $id)->take(10)->get();
        $editRecord = $history->map(function ($record) {
            
            $createdAt = $record->created_at;
            $floatValue = eval('return ' . $record->scores . ';');
            // Lay 2 so
            $diemhaiso = number_format($floatValue*10, 1, '.', '');
            $temp = Test::where('id', '=', $record->test_id)->first();
        
            // Format lai
            $date = Carbon::parse($createdAt)->format('Y-m-d');
            $time = Carbon::parse($createdAt)->format('H:i:s');
        
            // Them vao record
            $record['formatted_time'] = $time;
            $record['formatted_date'] = $date;
            $record['name'] = $temp->title;
            $record['diemso'] = $diemhaiso;
        
            return $record;
        });
        return response()->json($editRecord);
    }
    public function findQuestById($id){
        // return "hllo";
        $test = new Test;
        $test = $test->find($id);
        $createdAt = $test->created_at;
        return response()->json($test);
    }
}
