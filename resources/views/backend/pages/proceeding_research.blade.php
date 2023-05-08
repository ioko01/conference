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
                                            <a class="nav-link text-dark"
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
                                            <a class="nav-link active" aria-current="page"
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
                            <form action="{{ route('backend.proceeding.research.store', $year) }}"
                                enctype="multipart/form-data" method="POST" class="col-md-12">
                                @csrf
                                <div class="border border-top-0 p-3">
                                    <div class="row mb-3">
                                        <div class="col-lg-4 col-md-6">
                                            <label for="faculty_id">กลุ่มบทความ</label>
                                            <select name="faculty_id" id="faculty_id"
                                                class="form-select @error('faculty_id') is-invalid @enderror">
                                                <option value="">-- เลือกกลุ่มบทความ --</option>
                                                @forelse ($faculties as $faculty)
                                                    <option value="{{ $faculty->id }}">{{ $faculty->name }}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                            @error('faculty_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-lg-4 col-md-6">
                                            <label for="present_id">รูปแบบบทความ</label>
                                            <select name="present_id" id="present_id"
                                                class="form-select @error('present_id') is-invalid @enderror">
                                                <option value="">-- เลือกรูปแบบบทความ --</option>
                                                @forelse ($presents as $present)
                                                    <option value="{{ $present->id }}">{{ $present->name }}</option>
                                                @empty
                                                @endforelse
                                            </select>

                                            @error('present_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-lg-3 col-md-6">
                                            <label for="name">เลขหน้า</span></label>
                                            <input type="text" name="number" id="number"
                                                class="form-control @error('number') is-invalid @enderror"
                                                placeholder="เลขหน้า" />

                                            @error('number')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-8">
                                            <label for="topic">ชื่อบทความ <span class="text-red text-sm">(เช่น :
                                                    การสร้างวัฒนธรรมการกินพาสาเกตแก่เด็กปฐมวัยในจังหวัดร้อยเอ็ดด้วยกระบวนการวิจัยเชิงปฏิบัติการแบบมีส่วนร่วม)</span></label>
                                            <input type="text" name="topic" id="topic"
                                                class="form-control @error('topic') is-invalid @enderror"
                                                placeholder="ชื่อบทความ" />

                                            @error('topic')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4 col-md-6">
                                            <div class="form-check form-check-inline">
                                                <label for="file">
                                                    อัพโหลดเป็นไฟล์ <span style="font-size: 12px;"
                                                        class="text-red">(แนะนำเฉพาะไฟล์ที่มีขนาดเล็ก
                                                        ขนาดไฟล์ใหญ่สุดคือ 25 MB)</span>
                                                </label>
                                            </div>
                                            <div class="mb-3">
                                                <input type="file" name="file" id="file"
                                                    class="form-control rounded-0 @error('file') is-invalid @enderror"
                                                    accept=".pdf, .doc, .docx">
                                                @error('file')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button onclick="thisDisabled(this)" class="btn btn-success rounded-0"><i
                                                    class="fas fa-save"></i>
                                                บันทึก</button>
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
                <h1>อัพโหลดไฟล์ Proceedings {{ $year }}</h1>
            </div>
            <div class="card-body text-xs">
                <div class="table-responsive">
                    <table class="dataTable table table-striped w-100">
                        <thead>
                            <tr>
                                <th class="text-center d-none">#</th>
                                <th class="text-center">เลขหน้า</th>
                                <th style="width: 85%;">รายละเอียดบทความ</th>
                                <th style="width: auto;" class="text-right">แก้ไข</th>
                                <th style="width: auto;">ลบ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($researchs as $research)
                                <tr>
                                    <td class="text-center d-none">{{ explode('-', $research->number)[0] }}</td>
                                    <td class="text-center">{{ $research->number }}</td>
                                    <td class="text-start">
                                        <strong style="font-size: 12px" class="text-bluesky">
                                            {{ $research->present_name }}
                                        </strong>
                                        <br />
                                        <strong>{{ $research->topic }}</strong>
                                        <br />
                                        <strong style="font-size: 12px"
                                            class="text-green">{{ str_replace('|', ', ', $research->faculty_name) }}</strong>
                                    </td>
                                    <td class="text-right"><a
                                            href="{{ route('backend.proceeding.research.edit', ['year' => $year, 'id' => $research->id]) }}"
                                            class="btn btn-sm text-white btn-warning rounded-0"><i class="fa fa-edit"></i>
                                            แก้ไข</a>
                                    </td>
                                    <td><button
                                            onclick="open_modal('{{ $research->topic }}', '{{ route('backend.proceeding.research.delete', ['year' => $year, 'id' => $research->id]) }}')"
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
