<?php

namespace App\Http\Controllers;
/**
     * @OA\Info(
     *      version="1.0.0",
     *      title="ECEUNN DB API Documentation",
     *      description="API for ECEUNN DB, More info: https://docs.google.com/document/d/1t8LbBuWEJthV2E2WOad97VttjPGHiVC02lWdrYv0wf0/edit",
     *      @OA\Contact(
     *          email="ofuasiasoluchukwu@gmail.com"
     *      ),
     *      @OA\License(
     *          name="Apache 2.0",
     *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
     *      )
     * )
     * 
     *@OA\SecurityScheme(
    *         securityScheme="sanctum",
    *         type="http",
    *         scheme="bearer",
    *         bearerFormat="JWT",
    *         description="Enter your bearer token"
    *     )
 * 
     * @OA\Server(
     *      url="http://127.0.0.1:8000",
     *      description="ECEUNN DB API Server"
     * )

     *
     *
     */

abstract class Controller
{
    //
}
