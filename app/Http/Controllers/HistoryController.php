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
        $processedRecords = $history->map(function ($record) {
            // Lấy giờ từ trường created_at của mỗi bản ghi
            $createdAt = $record->created_at;
            $floatValue = eval('return ' . $record->scores . ';');
            // Lấy 2 số sau dấu phẩy
            $twoDecimalPlaces = number_format($floatValue*10, 1, '.', '');
            $temp = Test::where('id', '=', $record->test_id)->first();
        
            // Chuyển đổi đối tượng Carbon thành chuỗi giờ với định dạng mong muốn
            $date = Carbon::parse($createdAt)->format('Y-m-d');
            $time = Carbon::parse($createdAt)->format('H:i:s');
        
            // Thêm giờ vào bản ghi
            $record['formatted_time'] = $time;
            $record['formatted_date'] = $date;
            $record['name'] = $temp->title;
            $record['diemso'] = $twoDecimalPlaces;
        
            return $record;
        });
        return response()->json($processedRecords);
    }
    public function findQuestById($id){
        // return "hllo";
        $test = new Test;
        $test = $test->find($id);
        $createdAt = $test->created_at;

// Chuyển đổi đối tượng Carbon thành chuỗi ngày với định dạng mong muốn

        return response()->json($test);
    }
}
