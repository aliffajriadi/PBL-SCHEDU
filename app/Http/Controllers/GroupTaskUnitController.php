<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GroupTaskUnit;
use App\Models\Group;
use App\Models\GroupTask;
use Illuminate\Support\Facades\DB;

class GroupTaskUnitController extends Controller
{


    public function store(Request $request, Group $group)
    {
        DB::beginTransaction();
        try{
            $field = $request->validate([
                'name' => 'required|max:255',
            ]);

            $field['group_id'] = $group->id;

            GroupTaskUnit::create($field);

            DB::commit();

            return redirect()->back()->with('success', 'Succes Add New Unit For ' . $field['name']);

            // return response()->json([
            //     'status' => true, 
            //     'message' => 'Berhasil menambah unit'
            // ]);
        }catch(\Exception $e){
            DB::rollBack();

            return response()->json([
                'status' => false, 
                'message' => $e->getMessage()
            ]);
        }
    }

    public function update(Request $request, String $group, GroupTaskUnit $unit)
    {
        DB::beginTransaction();

        try{
            $field = $request->validate([
                'name' => 'required|max:255',
            ]);

            $unit->update($field);

            DB::commit();
            return redirect()->back()->with('success', 'Success Update unit.');
            
        }catch(\Exception $e) {
            
            DB::rollBack();
            return response()->json([
                'status' => false, 
                'message' => $e->getMessage()
            ]);
        }
    }

    public function destroy(String $group, GroupTaskUnit $unit)
    {
        DB::beginTransaction();

        try {
            $unit->delete();
        
            DB::commit();
            return redirect()->back()->with('success', 'Successfully deleted the unit');
        } catch (\Exception $e) {

            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to delete the unit: ' . $e->getMessage());
        }
        
    }
}
