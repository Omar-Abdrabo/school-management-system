<?php

namespace App\Repositories;

interface GraduatedStudentRepositoryInterface
{
    public function index();
    public function create();
    public function softDelete($request);
    public function returnStudent($request);
    public function deleteForEver($request);
}
