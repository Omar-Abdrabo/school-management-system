@extends('layouts.master')
@section('css')
    @toastr_css
@section('title')
    سندات القبض
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
@section('PageTitle')
    سندات القبض
@stop
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="row">
    <div class="col-md-12 mb-30">
        <div class="card card-statistics h-100">
            <div class="card-body">
                <div class="col-xl-12 mb-30">
                    <div class="card card-statistics h-100">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="datatable" class="table  table-hover table-sm table-bordered p-0"
                                    data-page-length="50" style="text-align: center">
                                    <thead>
                                        <tr class="alert-success">
                                            <th>#</th>
                                            <th>الاسم</th>
                                            <th>المبلغ</th>
                                            <th>البيان</th>
                                            <th>العمليات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($student_receipts as $student_receipt)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $student_receipt->student->name }}</td>
                                                <td>{{ number_format($student_receipt->debit, 2) }}</td>
                                                <td>{{ $student_receipt->description }}</td>
                                                <td>
                                                    <a href="{{ route('student_receipts.edit', $student_receipt->id) }}"
                                                        class="btn btn-info btn-sm" role="button"
                                                        aria-pressed="true"><i class="fa fa-edit"></i></a>
                                                    <button type="button" class="btn btn-danger btn-sm"
                                                        data-toggle="modal"
                                                        data-target="#Delete_receipt{{ $student_receipt->id }}"><i
                                                            class="fa fa-trash"></i></button>
                                                </td>
                                            </tr>
                                            @include('pages.Receipt.Delete')
                                        @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- row closed -->
@endsection
@section('js')
@toastr_js
@toastr_render
@endsection
