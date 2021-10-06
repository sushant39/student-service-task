<?php

namespace App\Repositories;

use App\Models\Student;

class StudentRepository
{
    /**
     * @var Student
     */
    private $student;

    /**
     * @param Student $student
     */
    public function __construct(Student $student)
    {
        $this->student = $student;
    }

    /**
     * @param $data
     * @return mixed
     */
    public function create($data)
    {
        return $this->student->create($data);
    }

    /**
     * @param $search_string
     * @return mixed
     */
    public function getStudentsBySearchString($search_string)
    {
        return $this->student->select('*')->WhereRaw("MATCH(`name`,`phone_number`,`email`,`country`) AGAINST(?)", [$search_string])->simplePaginate(10);
    }

}
