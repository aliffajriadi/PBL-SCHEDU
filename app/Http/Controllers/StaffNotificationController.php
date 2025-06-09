<?php

namespace App\Http\Controllers;

use App\Models\StaffNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffNotificationController extends Controller
{
    public static function store(string $title, string $description, string $instance_uuid)
    {
        StaffNotification::create([
            'staff_uuid' => $instance_uuid,
            'title' => $title,
            'description' => $description
        ]);
    }

    public function home()
    {
        return view('notification', [
            'user' =>  Auth::guard('staff')->user(),
            'role' => session('role')
        ]);
    }

    public function index(Request $request)
    {
        try {
            $user = Auth::guard('staff')->user();

            $notifications = StaffNotification::where('staff_uuid', $user->uuid);

            $keyword = $request->query('keyword') ?? false;
            
            if($keyword) {
                $notifications->where('title', 'LIKE', "%$keyword%")->orderByRaw(
                "CASE
                        WHEN title LIKE ? THEN 1
                        WHEN title LIKE ? THEN 2
                        ELSE 3
                    END
                ", ["$keyword%", "%$keyword%"]);
            }else{
                $notifications->orderBy('created_at', 'DESC');
            }

            return response()->json([
                'status' => true,
                'datas' => $notifications->get(),
                'keyword' => $keyword,
                'carbon_now' => Carbon::now()->toDateTimeString()
            ]);
            
        }catch(\Exception $e) {
            return response()->json([
                'status' => false, 
                'message' => $e->getMessage()
            ]);
        }
    
    }

    public function destroy(StaffNotification $notification)
    {
        try{
            $notification->delete();
            
            return response()->json([
                'status' => false,
                'message' => "notifikasi berhasil dihapus"
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function show(StaffNotification $notification)
    {
        try{

            if(!$notification->is_readed){
                $notification->is_readed = true;
                $notification->save();
            }

            return response()->json([
                'status' => true,
                'data' => $notification 
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
