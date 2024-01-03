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
            <h4 class="text-primary py-3">
                {{ config('app.name') }}
            </h4>
        </div>

        <div class="row">
            <div class="row col-md-6 mx-auto border pb-4">
                <div class="p-3 text-center">
                    <strong>อัพโหลดข้อเสนอแนะไปให้นักวิจัย</strong>
                </div>

                <strong>บทความจากนักวิจัยส่งมา</strong>

                @forelse ($suggestions as $key => $suggestion)
                    <div style="background: #DAF0F7; border: 1px solid #A8B5E0;" class="my-2 p-3 rounded">
                        <div class="w-100 d-flex justify-content-between align-items-center">
                            <a target="_blank" href="{{ Storage::url($suggestion->path_admin_send) }}">
                                <strong>{{ $key + 1 }}. {{ $suggestion->file_admin_send }}</strong>
                            </a>
                            <div class="d-flex gap-3">
                                <a target="_blank" href="{{ Storage::url($suggestion->path_admin_send) }}"
                                    class="btn btn-success rounded-0">ดาวน์โหลด</a>

                            </div>
                        </div>
                        <hr />
                        <div class="row">
                            <div class="col-md-6">
                                <div style="background-color: #fdfcea;" class="text-center w-100 rounded p-3">
                                    <strong>ส่งไฟล์กลับไปให้นักวิจัยแก้ไข</strong>
                                    <form enctype="multipart/form-data" action="{{ route('suggestion.store') }}"
                                        method="POST" class="d-flex flex-wrap gap-2 py-2">
                                        @csrf
                                        <input type="hidden" value="{{ $suggestion->topic_id }}" name="topic_id">
                                        <input type="hidden" value="{{ $suggestion->user_admin_id }}" name="user_admin_id">
                                        <input type="hidden" value="{{ $suggestion->conference_id }}" name="conference_id">
                                        <input type="file"
                                            class="form-control @error('suggestion_upload') is-invalid @enderror"
                                            name="suggestion_upload" accept=".pdf, .doc, .docx, .jpg, .jpeg, .png">

                                        @error('suggestion_upload')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <button type="submit"
                                            class="btn btn-success rounded-0 text-white">อัพโหลดไฟล์กลับไปให้นักวิจัยแก้ไข</button>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="text-center w-100 bg-white rounded p-3">
                                    <strong>รายการไฟล์ที่ส่งไปให้นักวิจัยแก้ไข</strong>
                                    <ol class="text-start">
                                        @forelse ($suggestions_expert as $suggestion_expert)
                                            @if ($suggestion->topic_id == $suggestion_expert->topic_id)
                                                @if (auth()->user()->id == $suggestion_expert->user_expert_id && $suggestion_expert->path_expert_receive)
                                                    <li class="d-flex justify-content-between">
                                                        <a
                                                            href="{{ Storage::url($suggestion_expert->path_expert_receive) }}">{{ $suggestion_expert->file_expert_receive }}</a>
                                                        <button class="btn btn-danger btn-sm rounded-0"
                                                            onclick="open_modal('{{ $suggestion_expert->file_expert_receive }}', '{{ route('suggestion.delete', $suggestion_expert->sug_id) }}')">ลบไฟล์</button>
                                                    </li>
                                                    <hr />
                                                @endif
                                            @endif
                                        @empty
                                        @endforelse
                                    </ol>
                                </div>
                            </div>
                        </div>

                    </div>

                @empty
                @endforelse
            </div>
        </div>

    </div>
    <!-- End Content -->

    <div id="modal"></div>
@endsection
