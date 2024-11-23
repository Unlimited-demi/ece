<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator as Validate;
use App\Models\User;
use App\Models\Student;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use App\Http\Resources\StudentResource;

class UserController extends Controller
{ // This class will contain the actions that the user (staff or admin) can do
    
    use HttpResponses;

     /**
*@OA\Get(
    *     path="/api/students",
    *     summary="Get students",
    *     description="Get all students data(paginated)",
    *     operationId="getAllStudents",
    *     tags={"Student Data"},
    *     security={
    *         {"sanctum": {}}
    *     },
     * @OA\Parameter(
    *         name="per_page",
    *         in="query",
    *         description="Items per page",
    *         required=false,
    *         @OA\Schema(type="integer", default=200)
    *     ),
     *@OA\Parameter(
 *         name="page",
 *         in="query",
 *         description="Page number",
 *         required=false,
 *         @OA\Schema(type="integer", default=1)
 *     ),
  *  @OA\Response(
 *     response=200,
 *     description="Successful response",
 * @OA\JsonContent(
 *             type="object",
    *     @OA\Property(
 *             property="data",
 *             type="object",
            * example={"listing_property": "listing_value"},
 *         ),
 * ),
 * ),
    * )
    */
    public function getAllStudents(Request $request)
    {
        $students = Student::orderBy('created_at', 'desc')
        ->paginate($request->query('per_page',200));
        $studentDetails = StudentResource::collection($students);
        return $studentDetails;
    }
}
