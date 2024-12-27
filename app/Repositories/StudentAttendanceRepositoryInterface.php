<?php

namespace App\Repositories;

interface StudentAttendanceRepositoryInterface
{
    public function index();

    public function show($id);

    public function store($request);

    public function update($request);

    public function destroy($request);
}
