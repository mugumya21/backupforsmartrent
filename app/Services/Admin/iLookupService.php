<?php
/**
 * Created by PhpStorm.
 * User: eugene
 * Date: 7/2/18
 * Time: 5:05 AM
 */

namespace App\Services\Admin;


use App\Http\Requests\Admin\LookupPost;

interface iLookupService
{
    public function create(LookupPost $request);
    public function update(LookupPost $request, int $id);
    public function get(int $id);
    public function getByKey(string $key);
    public function list();
}