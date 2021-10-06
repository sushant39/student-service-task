<?php

namespace App\Http\Controllers;

use App\Services\StudentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    /**
     * @var StudentService
     */
    private $student;

    /**
     * @param StudentService $student
     */
    public function __construct(StudentService $student)
    {
        $this->student = $student;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $request_data = $request->all();

        $required_fields = ['name', 'phone_number', 'email', 'country'];
        $rules = $this->student->getRules($required_fields);
        $validator = Validator::make($request_data, $rules);

        if ($validator->fails()) {
            $response['message'] = 'validation failed';
            $response['errors'] = $validator->errors()->all();
            return response()->json($response);
        }

        $country_data = $this->student->getCountryCode($request_data['country']);
        if ($country_data['error'] == true) {
            $response['message'] = 'validation failed';
            $response['errors'] = "The country must be a valid country.";
            return response()->json($response);
        }

        $request_data['country_code'] = $country_data['data']['code'];
        $request_data['dial_code'] = $country_data['data']['dial_code'];
        $response_data = $this->student->create($request_data);

        $response['message'] = 'success';
        $response['data'] = $response_data;
        return response()->json($response);
    }

    /**
     * @param $search_string
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStudentsBySearchString($search_string)
    {

        $response_data = $this->student->getStudentsBySearchString($search_string);
        $response['message'] = 'success';
        $response['data'] = $response_data;
        return response()->json($response);
    }
}
