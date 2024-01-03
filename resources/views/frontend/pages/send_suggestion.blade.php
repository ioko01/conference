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
                    <strong>อัพโหลดข้อเสนอแนะไปให้นักวิจัยแก้ไข</strong>
                </div>
                <strong>รหัสบทความ: {{ $topic_id }}</strong>
                <form action="{{ route('suggestion.update') }}" method="POST" class="d-flex">
                    @csrf
                    <input type="file" class="form-control" name="expert_send_file">
                    <button class="btn btn-success rounded-0 text-nowrap">อัพโหลดไฟล์</button>
                </form>
            </div>
        </div>

    </div>
    <!-- End Content -->

    <div id="modal"></div>
@endsection
