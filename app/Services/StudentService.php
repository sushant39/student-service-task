<?php

namespace App\Services;


use App\Repositories\StudentRepository;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class StudentService
{
    /**
     * @var StudentRepository
     */
    private $studentRepository;

    /**
     * @param StudentRepository $studentRepository
     */
    public function __construct(StudentRepository $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }

    /**
     * @param array $required_fields
     * @return string[]
     */
    public function getRules($required_fields = [])
    {
        $rules = [
            'email' => 'email',
        ];

        foreach ($required_fields as $field) {
            if (isset($rules[$field])) {
                $rules[$field] = 'required|' . $rules[$field];
            } else {
                $rules[$field] = 'required';
            }
        }

        return $rules;
    }

    /**
     * @param $data
     * @return mixed
     */
    public function create($data)
    {
        Log::info('StudentService|Create|Request_data', $data);
        $response_data = $this->studentRepository->create($data);
        Log::info('StudentService|Create|Response_data', $response_data->toArray());
        return $response_data;

    }

    /**
     * @param $country_name
     * @return array|bool[]|mixed
     */
    public function getCountryCode($country_name)
    {
        try {
            $url = "https://countriesnow.space/api/v0.1/countries/codes";
            $data = ['country' => $country_name];
            Log::info('StudentService|getCountryCode|Request_data', $data);
            $response = Http::post($url, $data);
            Log::info('StudentService|getCountryCode|Response_data', $data);
            return $response->json();
        } catch (\Exception $e) {
            return ['error' => true];
        }
    }

    /**
     * @param $search_string
     * @return mixed
     */
    public function getStudentsBySearchString($search_string)
    {

        Log::info('StudentService|getStudentsBySearchString|Request_data', [$search_string]);
        $response_data = $this->studentRepository->getStudentsBySearchString($search_string);
        Log::info('StudentService|getStudentsBySearchString|Response_data', $response_data->toArray());
        return $response_data;
    }

}
