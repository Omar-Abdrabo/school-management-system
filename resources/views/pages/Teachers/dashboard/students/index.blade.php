@extends('layouts.master')
@section('css')
    @toastr_css
@section('title')
    قائمة الحضور والغياب للطلاب
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
@section('PageTitle')
    قائمة الحضور والغياب للطلاب
@stop
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('status'))
    <div class="alert alert-danger">
        <ul>
            <li>{{ session('status') }}</li>
        </ul>
    </div>
@endif

<h5 style="font-family: 'Cairo', sans-serif;color: red"> تاريخ اليوم : {{ date('Y-m-d') }}</h5>
<form method="post" action="{{ route('teacher.attendance') }}" autocomplete="off">
    @csrf
    <table id="datatable" class="table  table-hover table-sm table-bordered p-0" data-page-length="50"
        style="text-align: center">
        <thead>
            <tr>
                <th class="alert-success">#</th>
                <th class="alert-success">{{ trans('Students_trans.name') }}</th>
                <th class="alert-success">{{ trans('Students_trans.email') }}</th>
                <th class="alert-success">{{ trans('Students_trans.gender') }}</th>
                <th class="alert-success">{{ trans('Students_trans.Grade') }}</th>
                <th class="alert-success">{{ trans('Students_trans.classrooms') }}</th>
                <th class="alert-success">{{ trans('Students_trans.section') }}</th>
                <th class="alert-success">الحضور والغياب</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $student)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->email }}</td>
                    <td>{{ $student->gender->name }}</td>
                    <td>{{ $student->grade->name }}</td>
                    <td>{{ $student->classroom->name_class }}</td>
                    <td>{{ $student->section->section_name }}</td>
                    <td>

                        @if (isset($student->studentAttendance()->where('attendance_date', date('Y-m-d'))->first()->student_id))
                            @php
                                $attendance_status = $student
                                    ->studentAttendance()
                                    ->where('attendance_date', date('Y-m-d'))
                                    ->where('student_id', $student->id)
                                    ->first()->attendance_status;
                            @endphp
                            {{-- <label class="block text-gray-500 font-semibold sm:border-r sm:pr-4">
                                <input name="attendances[{{ $student->id }}]" disabled
                                    {{ $attendance_status == 1 ? 'checked' : '' }} 
                                    class="leading-tight" type="radio"
                                    value="presence">
                                <span class="text-success">حضور</span>
                                <span>{{ $attendance_status}}</span>
                            </label>

                            <label class="ml-4 block text-gray-500 font-semibold">
                                <input name="attendances[{{ $student->id }}]" disabled
                                    {{ $attendance_status == 0 ? 'checked' : '' }} class="leading-tight" type="radio"
                                    value="absent">
                                <span class="text-danger">غياب</span>
                            </label> --}}

                            @if ($attendance_status == 0)
                                <span style="padding-inline: 8px; padding-bottom: 2px" class="btn-danger">غياب</span>
                            @else
                                <span style="padding-inline: 8px; padding-bottom: 2px" class="btn-success">حضور</span>
                            @endif

                            <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal"
                                data-target="#edit_attendance{{ $student->id }}" title="تعديل"><i
                                    class="fa fa-edit"></i></button>
                            @include('pages.Teachers.dashboard.students.edit_attendance')
                        @else
                            <label class="block text-gray-500 font-semibold sm:border-r sm:pr-4">
                                <input name="attendances[{{ $student->id }}]" class="leading-tight" type="radio"
                                    value="presence">
                                <span class="text-success">حضـور</span>
                            </label>

                            <label class="ml-4 block text-gray-500 font-semibold">
                                <input name="attendances[{{ $student->id }}]" class="leading-tight" type="radio"
                                    value="absent">
                                <span class="text-danger">غيـاب</span>
                            </label>
                        @endif

                        <input type="hidden" name="grade_id" value="{{ $student->grade_id }}">
                        <input type="hidden" name="classroom_id" value="{{ $student->classroom_id }}">
                        <input type="hidden" name="section_id" value="{{ $student->section_id }}">
                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>
    <P>
        <button class="btn btn-success" type="submit">{{ trans('Students_trans.submit') }}</button>
    </P>
</form><br>
<!-- row closed -->
@endsection
@section('js')
@toastr_js
@toastr_render
@endsection
