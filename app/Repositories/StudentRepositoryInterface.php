<?php

namespace App\Repositories;


interface StudentRepositoryInterface {
    public function getAllStudents();
    public function showStudent($id);
    public function createStudent();
    public function storeStudent($request);
    public function editStudent($student);
    public function updateStudent($request);
    public function deleteStudent($student);
    public function getClassrooms($id);
    public function getSections($id);
    public function upload_attachment($request);
    public function download_attachment($student_name, $file_name);
    public function delete_attachment($request);
}