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
            * example={"student_property": "student_value"},
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

    /**
*@OA\Get(
    *     path="/api/student/{reg_number}",
    *     summary="Get a student",
    *     description="Get a student with their reg_number",
    *     operationId="getAStudent",
    *     tags={"Student Data"},
  *  @OA\Response(
 *     response=200,
 *     description="Successful response",
 * @OA\JsonContent(
 *             type="object",
    *     @OA\Property(
 *             property="data",
 *             type="object",
            * example={"student_property": "student_value"},
 *         ),
 * ),
 * ),
 * @OA\Response(
     *     response=404,
     *     description="Student not found",
     *     @OA\JsonContent()
     *   ),
    * )
    */
    public function getAStudent($reg_number)
    {
        $student = Student::find($reg_number);
        if (!$student) {
            return $this->error(null, 'Student not found', 404);
        }
        
        $studentDetails = new StudentResource($student);
        return $studentDetails;
    }

     /**
*@OA\Get(
    *     path="/api/students/search",
    *     summary="Search for students",
    *     description="Route for searching for students with matching first name, last name, middle name and reg number",
    *     operationId="studentSearch",
    *     tags={"Student Data"},
    * @OA\Parameter(
    *         name="query",
    *         in="query",
    *         description="Search query",
    *         required=true,
    *         @OA\Schema(type="text")
    *     ),
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
  * @OA\Response(
 *     response=200,
 *     description="Array of student properties",
 * @OA\JsonContent(
 *             type="object",
            * example={"student_property": "student_value"},
 *         ),
 * ),
 * *  @OA\Response(
     *     response=400,
     *     description="Search term is required",
     *     @OA\JsonContent()
     *   ),
 * ),
    */

    public function studentSearch(Request $request)
    {
        // Validate the search input
        if (!$request->filled('query')) {
            return $this->error(null, 'Search term is required', 400);
        }

        // Get the search query from the request
        $query = $request->input('query');

        // Search for the student in the database
        $students = Student::where('first_name', 'like', "%$query%")
            ->orWhere('middle_name', 'like', "%$query%")
            ->orWhere('last_name', 'like', "%$query%")
            ->orWhere('reg_number', 'like', "%$query%")
            ->paginate($request->query('per_page',200));

        $studentDetails = StudentResource::collection($students);
        return $studentDetails;
    }

}
