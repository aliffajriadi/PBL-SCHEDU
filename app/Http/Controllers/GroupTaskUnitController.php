<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GroupTaskUnit;
use App\Models\Group;
use App\Models\GroupTask;

class GroupTaskUnitController extends Controller
{


    public function store(Request $request, Group $group)
    {
     
        try{
            $field = $request->validate([
                'name' => 'required|max:255',
            ]);

            $field['group_id'] = $group->id;

            GroupTaskUnit::create($field);

            return redirect()->back()->with('success', 'Berhasil menambahkan unit');

            // return response()->json([
            //     'status' => true, 
            //     'message' => 'Berhasil menambah unit'
            // ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => false, 
                'message' => $e->getMessage()
            ]);
        }
    }

    public function update(Request $request, String $group, GroupTaskUnit $unit)
    {
        try{
            $field = $request->validate([
                'name' => 'required|max:255',
            ]);

            $unit->update($field);
            return redirect()->back()->with('success', 'Berhasil mengedit unit');
            
        }catch(\Exception $e) {
            return response()->json([
                'status' => false, 
                'message' => $e->getMessage()
            ]);
        }
    }

    public function destroy(String $group, GroupTaskUnit $unit)
    {
        try{
            $unit->delete();
    
            return redirect()->back()->with('success', 'Berhasil menghapus unit');
        }catch(\Exception $e) {
            return redirect()->back()->with('error', 'gagal menghapus unit' . $e->getMessage());

            return response()->json([
                'status' => false, 
                'message' => $e->getMessage()
            ]);
        }
    }
}
