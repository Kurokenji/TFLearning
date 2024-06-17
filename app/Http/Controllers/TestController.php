<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Test;
use Illuminate\Http\Request;

class TestController extends Controller
{
    function testDetail(){
        $test = new Test;
        $test = $test->orderBy('id','DESC')->take(6)->get();
        $processedRecords = $test->map(function ($record) {
            // Lấy giờ từ trường created_at của mỗi bản ghi
            $name = User::where('id', '=', $record->create_by)->first();
            // Thêm giờ vào bản ghi
            $record['own'] = $name->name;
            return $record;
        });
        if(!empty($test)){
            return response()->json($processedRecords);
        }
    }
    public function findQuestById($id){
        // return "hllo";
        $test = new Test;
        $test = $test->find($id);
        return response()->json($test);
    }
    function getTestByUserId($id){
        $records = Test::orderBy('id','DESC')->where('create_by', '=', $id)->take(10)->get();
        return response()->json($records);
    }
    public function createTest(Request $request){
        try {
            $newTest = new Test;

            $newTest->title = $request->input('title');
            $newTest->quest = $request->input('quest');
            $newTest->create_by = $request->input('create_by');
            $newTest->save();

            return response()->json([
                'success' => true,
                'message' => 'create quest successfull',
                'data' => $newTest,
            ], 200);
            
            Quest::create($newTest);

            return response()->json([
                'success' => true,
                'message' => 'create quest successfull',
            ], 200);
        } catch (Exception $error) {
            return response()->json([
                'success' => false,
                'message' => $error->getMessage(),
        ]);
    }
    }
    public function getUserName()
    {
        // Lấy thông tin người dùng có tên là "admin" từ cơ sở dữ liệu
        $userName = User::where('name', 'nguoidung99')->first();

        // Kiểm tra xem người dùng có tồn tại không
        if ($userName) {
            $userInfor = [
                'email' => $userName->email,
                'name' => $userName->name,
            ];

            return response()->json($userInfor);
        }

        // Trường hợp không tìm thấy người dùng
        return response()->json(['error' => 'user not found.'], 404);
    }
}