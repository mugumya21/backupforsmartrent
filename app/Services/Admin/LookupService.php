<?php
/**
 * Created by PhpStorm.
 * User: eugene
 * Date: 7/2/18
 * Time: 5:06 AM
 */

namespace App\Services\Admin;


use App\Http\Requests\Admin\LookupPost;
use App\Models\System\Setting;
use Carbon\Carbon;
use Auth;
use DB;
use Exception;

class LookupService implements iLookupService
{

    public function create(LookupPost $request)
    {
        DB::beginTransaction();
        try {
            $setting = new Setting();
            $setting->key = $request->key;
            $setting->description = $request->description;
            $setting->value = $request->value;
            $setting->created_by = Auth::id();

            $setting->save();

            DB::commit();
            return $setting;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function update(LookupPost $request, int $id)
    {
        DB::beginTransaction();
        try {
            $setting = Setting::find($id);
            $setting->key = $request->key;
            $setting->description = $request->description;
            $setting->value = $request->value;
            $setting->updated_by = Auth::id();

            $setting->save();

            DB::commit();
            return $setting;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function get(int $id)
    {
        return Setting::find($id);
    }

    public function getByKey(string $key)
    {
        return Setting::where('key', $key)->first();
    }

    public function list()
    {
        return Setting::all();
    }
}