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

        <form action="#" class="row">
            <div class="row col-md-12 mx-auto border pb-4">
                <div class="p-3 text-center">
                    <strong>รายการบทความ</strong>
                </div>

                <div class="col-md-6">
                    <strong>บทความจากนักวิจัย</strong>
                    @forelse ($suggestions as $suggestion)
                        <div style="border: 1px solid #A8B5E0;background-color: #DAF0F7;" class="w-100 p-2">
                            <a target="_blank" href="{{ Storage::url($suggestion->path_admin_send) }}">
                                {{ $suggestion->file_admin_send }}
                            </a>
                        </div>
                    @empty
                    @endforelse
                </div>
                <div class="col-md-6">
                    <input type="file" class="form-control">
                    <button class="btn btn-success rounded-0">อัพโหลด</button>
                </div>






            </div>
        </form>

    </div>
    <!-- End Content -->

    <div id="modal"></div>
@endsection
