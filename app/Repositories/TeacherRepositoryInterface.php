<?php

namespace App\Repositories;


interface TeacherRepositoryInterface
{
    public function getAllTeachers();
    public function getTeacherById($id);
    public function storeTeacher($request);
    public function editTeacher($id);
    public function updateTeacher($request);
    public function deleteTeacher($request);
    public function getGender();
    public function getSpecialization();
    // public function get_teacher_students();
    // public function get_teacher_sections();
    // public function attendance($request);
    // public function attendance_edit($request);
    // public function attendance_report();
    // public function attendance_report_search($request);
}

