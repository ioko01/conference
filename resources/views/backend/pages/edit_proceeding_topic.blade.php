@extends('backend.layouts.master_backend')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="bg-green p-3">
                <strong>PROCEEDINGS {{ $year }}</strong>
            </div>
            <div class="card rounded-0">
                <div class="card-content rounded-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="list-group rounded-0">
                                    <ul class="nav nav-tabs">
                                        <li class="nav-item">
                                            <a class="nav-link active" aria-current="page"
                                                href="{{ route('backend.proceeding.topic.index', $year) }}">
                                                <span><i class="fas fa-plus"></i></span> เพิ่มหัวข้อ Proceedings</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-dark"
                                                href="{{ route('backend.proceeding.file.index', $year) }}">
                                                <span><i class="fas fa-file-upload"></i></span> อัพโหลดไฟล์ Proceedings
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-dark"
                                                href="{{ route('backend.proceeding.research.index', $year) }}">
                                                <span><i class="fas fa-book"></i></span> อัพโหลดบทความ Proceedings</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-primary"
                                                href="{{ route('backend.proceeding.preview.index', $year) }}">
                                                <span><i class="fas fa-eye"></i></span> แสดงตัวอย่าง</a>
                                        </li>
                                        <li class="ml-auto align-self-center">
                                            <form method="POST"
                                                action="{{ route('backend.conference.update_status', $conference->id) }}"
                                                class="d-flex">
                                                @csrf
                                                @method('PUT')
                                                <div class="custom-control custom-switch">
                                                    <input
                                                        onchange="javascript:document.getElementById('change_proceeding1').click()"
                                                        type="checkbox" class="custom-control-input" id="switch_proceeding1"
                                                        @if ($conference->status_proceeding == 1) checked @endif>

                                                    @if ($conference->status_proceeding == 1)
                                                        <label style="font-size: 10px;"
                                                            class="custom-control-label text-success"
                                                            for="switch_proceeding1">เผยแพร่ Proceedings แล้ว</label>
                                                    @else
                                                        <label style="font-size: 10px;"
                                                            class="custom-control-label text-danger"
                                                            for="switch_proceeding1">ยังไม่ได้เผยแพร่ Proceedings</label>
                                                    @endif
                                                </div>
                                                <input type="submit" class="d-none" id="change_proceeding1"
                                                    name="change_status_proceeding"
                                                    @if ($conference->status_proceeding == 1) value=0
                                    @else
                                    value=1 @endif>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <form
                                action="{{ route('backend.proceeding.topic.update', ['year' => $year, 'id' => $topic->id]) }}"
                                method="POST" class="col-md-12">
                                @csrf
                                @method('PUT')
                                <div class="border border-top-0 p-3">
                                    <div class="row mb-3">
                                        <div class="col-lg-4 col-md-6">
                                            <label for="topic">หัวข้อ <span class="text-red text-sm">(เช่น : หน้าปก,
                                                    ส่วนหน้า,
                                                    สารบัญ)</span></label>
                                            <input value="{{ $topic->topic }}" type="text" name="topic" id="topic"
                                                class="form-control @error('topic') is-invalid @enderror"
                                                placeholder="หัวข้อ">

                                            @error('topic')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-lg-2 col-md-3">
                                            <label for="position">ลำดับ <span class="text-red text-sm">(1 -
                                                    10) * หน้า Proceedings
                                                    จะแสดงหัวข้อตามลำดับน้อยสุดไปมากสุด</span></label>
                                            <input value="{{ $topic->position }}" min="1" max="10"
                                                type="number" name="position" id="position"
                                                class="form-control @error('position') is-invalid @enderror"
                                                placeholder="ตำแหน่ง">

                                            @error('position')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button onclick="thisDisabled(this)"
                                                class="btn btn-warning text-white rounded-0"><i class="fas fa-edit"></i>
                                                แก้ไข</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="card">
        <div class="card-content">
            <div class="card-header">
                <h1>หัวข้อ Proceedings {{ $year }}</h1>
            </div>
            <div class="card-body text-xs">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>หัวข้อ</th>
                                <th style="width: 10%;">ตำแหน่ง</th>
                                <th style="width: 10%;" class="text-right">แก้ไข</th>
                                <th style="width: 10%;">ลบ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($topics as $topic)
                                <tr>
                                    <td>{{ $topic->topic }}</td>
                                    <td>{{ $topic->position }}</td>
                                    <td class="text-right"><a
                                            href="{{ route('backend.proceeding.topic.edit', ['year' => $year, 'id' => $topic->id]) }}"
                                            class="btn btn-sm text-white btn-warning rounded-0"><i class="fa fa-edit"></i>
                                            แก้ไข</a>
                                    </td>
                                    <td><button
                                            onclick="open_modal('{{ $topic->topic }}', '{{ route('backend.proceeding.topic.delete', ['year' => $year, 'id' => $topic->id]) }}')"
                                            class="btn btn-sm btn-danger rounded-0"><i class="fas fa-trash-alt"></i>
                                            ลบ</button></td>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">ไม่มีหัวข้อ</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div id="modal"></div>
@endsection
