@extends('frontend.layouts.master_frontend')

@section('content')
    <!-- Content -->
    <div class="bg-white text-blue p-5 my-5">

        <div class="inner-content-header">
            <h4 class="text-center fw-bold"><i class="nav-icon fas fa-1x fa-upload"></i> อัพโหลดไฟล์ข้อเสนอแนะ<br />
                @if ($conference)
                    {{ $conference->name }}
                @endif
            </h4>
            <h4 class="text-green py-3">
                {{ config('app.name') }}
            </h4>
        </div>

        <div class="row">
            <div class="col-md-4 mx-auto border">
                <div class="p-3 text-center">
                    <strong>รายละเอียดบทความ</strong>
                </div>

                <div class="p-3">
                    <table>
                        <tr>
                            <td style="text-wrap:nowrap;">รหัสบทความ: </td>
                            <td class="ps-3">{{ $research->topic_id }}</td>
                        </tr>
                        <tr>
                            <td style="text-wrap:nowrap;">ชื่อบทความ (ภาษาไทย): </td>
                            <td class="ps-3">{{ $research->topic_th }}</td>
                        </tr>
                        <tr>
                            <td style="text-wrap:nowrap;">ชื่อบทความ (ภาษาอังกฤษ): </td>
                            <td class="ps-3">{{ $research->topic_en }}</td>
                        </tr>
                    </table>
                </div>
                <hr />

                <form enctype="multipart/form-data" method="POST"
                    action="{{ route('suggestion.store', ['link' => explode('/', Request::getRequestUri())[2]]) }}"
                    class="p-3 row">
                    @csrf
                    <div class="col-md-12">
                        <strong>อัพโหลดไฟล์ข้อเสนอแนะ <strong class="text-danger">(ขนาดไฟล์สูงสุดคือ 10 MB รองรับนามสกุลไฟล์ .pdf, .doc, .docx, .jpg, .jpeg, .png)</strong></strong>
                        <input class="form-control @error('suggestion_upload') is-invalid @enderror" type="file"
                            name="suggestion_upload" id="suggestion_upload" accept=".jpg, .jpeg, .png, .doc, .docx, .pdf">
                        @error('suggestion_upload')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <button class="btn btn-success rounded-0 my-4">อัพโหลดไฟล์</button>
                    </div>
                </form>
                <div class="border p-3 my-2">
                    <strong>รายการไฟล์ข้อเสนอแนะ</strong>

                    <ul>
                        @forelse ($suggestions as $suggestion)
                            <li>
                                {{-- <form method="POST"
                                    action="{{ route('suggestion.delete', ['link' => explode('/', Request::getRequestUri())[2], 'id' => $suggestion->id]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <div class="d-flex justify-content-between align-items-center">
                                        <a href="{{ Storage::url($suggestion->path) }}" download>{{ $suggestion->name }}</a>
                                        <button class="btn btn-sm btn-danger rounded-0 my-2">ลบไฟล์</button>
                                    </div>
                                </form> --}}

                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="{{ Storage::url($suggestion->path) }}" download>{{ $suggestion->name }}</a>
                                    <button
                                        onclick="open_modal('{{ $suggestion->name }}', '{{ route('suggestion.delete', ['link' => explode('/', Request::getRequestUri())[2], 'id' => $suggestion->id]) }}')"
                                        class="btn btn-sm btn-danger rounded-0 my-2">ลบไฟล์</button>
                                </div>
                            </li>
                        @empty
                            <p class="text-center">-- ไม่มีไฟล์ข้อเสนอแนะ --</p>
                        @endforelse
                    </ul>
                </div>


            </div>
        </div>

    </div>
    <!-- End Content -->

    <div id="modal"></div>
@endsection
