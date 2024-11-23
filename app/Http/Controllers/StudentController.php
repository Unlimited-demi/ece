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

class StudentController extends Controller
{// This class will contain the actions that the student can do
    use HttpResponses;

}
