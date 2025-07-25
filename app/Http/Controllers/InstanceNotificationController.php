<?php

namespace App\Http\Controllers;

use App\Models\InstanceNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InstanceNotificationController extends Controller
{
    public static function store(string $title, string $description, string $instance_uuid)
    {        
        InstanceNotification::create([
            'instance_uuid' => $instance_uuid,
            'title' => $title,
            'description' => $description
        ]);
    }

    public function home()
    {
        $data = Auth::guard('staff')->user();
        return view('staff.notification', [
            'user' =>  $data,
            'role' => session('role')
        ]);
    }

    public function index(Request $request)
    {
        try {
            $user = Auth::guard('staff')->user();

            $notifications = InstanceNotification::where('instance_uuid', $user->uuid);

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
                'datas' => $notifications->paginate(5),
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

    public function destroy(InstanceNotification $notification)
    {
        DB::beginTransaction();

        try{
            $notification->delete();
            
            DB::commit();

            return response()->json([
                'status' => false,
                'message' => "notifikasi berhasil dihapus"
            ]);
        }catch(\Exception $e){
            DB::rollBack();
            
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function show(InstanceNotification $notification)
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
