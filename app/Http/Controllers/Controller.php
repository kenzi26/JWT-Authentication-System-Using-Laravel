<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Authentication System And CRUD Operation",
 *      description="JWT SYSTEM AND CRUD OPERATION APIs ",
 *      @OA\Contact(
 *          email="kmokwenye@zojatech.com"
 *      ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url=""
 *     )
 * )
 * 
 */

class Controller extends BaseController

{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
