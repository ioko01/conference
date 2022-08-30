@extends('backend.layouts.master_backend')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="bg-green p-3">
                <strong>PROCEEDING {{ $year }}</strong>
            </div>
            <div class="card rounded-0">
                <div class="card-content rounded-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="list-group rounded-0">
                                    <ul class="nav nav-tabs">
                                        <li class="nav-item">
                                            <a class="nav-link text-dark"
                                                href="{{ route('backend.proceeding.topic.index', $year) }}">
                                                <span><i class="fas fa-plus"></i></span> เพิ่มหัวข้อ Proceeding</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-dark"
                                                href="{{ route('backend.proceeding.file.index', $year) }}">
                                                <span><i class="fas fa-file-upload"></i></span> อัพโหลดไฟล์ Proceeding
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link active" aria-current="page"
                                                href="{{ route('backend.proceeding.research.index', $year) }}">
                                                <span><i class="fas fa-book"></i></span> อัพโหลดบทความ Proceeding</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-9">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="card">
        <div class="card-content">
            <div class="card-header">
                <h1>Proceeding {{ $year }}</h1>
            </div>
            <div class="card-body text-xs">
                <div class="table-responsive">
                    <a href="#" class="btn btn-outline-success rounded-0">อัพโหลดบทความ Proceeding</a>
                </div>
            </div>
        </div>
    </div>
    <div id="modal"></div>
@endsection
