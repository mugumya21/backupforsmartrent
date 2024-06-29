<?php

namespace App\Services\Main;

use Illuminate\Http\Request;

interface iFileUploadService
{
    public function upload(Request $request);
}