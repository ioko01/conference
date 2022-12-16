@extends('backend.layouts.master_backend')

@section('content')
    {{-- <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-content">
                    <div class="card-body d-flex justify-content-between">
                        <div class="topic w-auto">
                            Storage Link <i style="font-size: 12px" class="text-danger">(เปิดแล้วไม่สามารถปิดได้)</i><br />
                            <i style="font-size: 12px" class="text-bluesky">*เปิดใช้งานการเข้าถึงไฟล์ต่างๆ
                                (จำเป็นต้องเปิด)</i>
                        </div>
                        <!-- Default checked -->
                        <form action="{{ route('backend.storage.open') }}" method="GET">
                            <div class="custom-control custom-switch">
                                <input onchange="javascript:document.getElementById('change_storage').click()"
                                    type="checkbox" class="custom-control-input" id="switch_storage"
                                    @if ($storage) checked @endif>

                                @if ($storage)
                                    <label style="font-size: 10px;" class="custom-control-label text-success"
                                        for="switch_storage">เปิดใช้งานอยู่</label>
                                @else
                                    <label style="font-size: 10px;" class="custom-control-label text-danger"
                                        for="switch_storage">ปิดใช้งาน</label>
                                @endif

                            </div>
                            <input type="submit" class="d-none" id="change_storage">
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header rounded-0 border border-primary">
                    <h3 class="card-title">งานประชุมวิชาการที่เปิดใช้งาน : @if (isset($conference->name))
                            <span class="text-green">{{ $conference->name }}</span>
                        @else
                            <span class="text-red">ไม่มีงานประชุมวิชาการที่เปิดใช้งาน</span>
                        @endif
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">

        <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="card card-success">
                <div class="card-header rounded-0">
                    <h3 class="card-title"><i class="fas fa-user-check"></i> ผู้ใช้งาน (ยืนยันอีเมลแล้ว)</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-around">
                        <strong class="text-success mr-auto">
                            <span class="d-none d-md-block">
                                ทั้งหมด
                            </span>
                        </strong>
                        <strong style="font-size: calc(5vw + 30px);"
                            class="text-success h1 mx-auto">{{ count($users) }}</strong>
                        <strong class="text-success ms-auto mt-auto">ไอดี</strong>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="card card-danger">
                <div class="card-header rounded-0">
                    <h3 class="card-title text-white"><i class="fas fa-user-times"></i> ผู้ใช้งาน (ไม่ยืนยันอีเมล)</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool text-white" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool text-white" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-around">
                        <strong class="text-danger mr-auto">
                            <span class="d-none d-md-block">
                                ทั้งหมด
                            </span>
                        </strong>
                        <strong style="font-size: calc(5vw + 30px);"
                            class="text-danger h1 mx-auto">{{ count($users_not_verify_email) }}</strong>
                        <strong class="text-danger ms-auto mt-auto">ไอดี</strong>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="card card-primary">
                <div class="card-header rounded-0">
                    <h3 class="card-title"><i class="fas fa-user-cog"></i> ผู้ใช้งาน (แอดมิน)</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-around">
                        <strong class="text-primary mr-auto">
                            <span class="d-none d-md-block">
                                ทั้งหมด
                            </span>
                        </strong>
                        <strong style="font-size: calc(5vw + 30px);"
                            class="text-primary h1 mx-auto">{{ count($admin) }}</strong>
                        <strong class="text-primary ms-auto mt-auto">ไอดี</strong>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="card card-dark">
                <div class="card-header rounded-0">
                    <h3 class="card-title"><i class="fas fa-book"></i> บทความ</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-around">
                        <strong class="text-dark mr-auto">
                            <span class="d-none d-md-block">
                                ทั้งหมด
                            </span>
                        </strong>
                        <strong style="font-size: calc(5vw + 30px);"
                            class="text-dark h1 mx-auto">{{ count($researchs) }}</strong>
                        <strong class="text-dark ms-auto mt-auto">บทความ</strong>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="card card-dark">
                <div class="card-header rounded-0">
                    <h3 class="card-title text-white"><i class="fas fa-chart-area"></i> กราฟบทความ</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool text-white" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool text-white" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    {!! $chart->container() !!}
                    <div>
                        <span class="text-small">บุคลากรภายใน <span class="text-small">จำนวน
                                {{ count($researchs_in) }} บทความ
                                <span
                                    class="text-small text-success">({{ number_format((count($researchs_in) / (count($researchs_in) + count($researchs_out) + count($researchs_kota))) * 100, 2, '.', '') }}%)</span></span></span><br>
                        <span class="text-small">บุคลากรภายนอก <span class="text-small">จำนวน
                                {{ count($researchs_out) }} บทความ
                                <span
                                    class="text-small text-success">({{ number_format((count($researchs_out) / (count($researchs_in) + count($researchs_out) + count($researchs_kota))) * 100, 2, '.', '') }}%)</span></span></span><br>
                        <span class="text-small">เจ้าภาพร่วม <span class="text-small">จำนวน
                                {{ count($researchs_kota) }} บทความ
                                <span
                                    class="text-small text-success">({{ number_format((count($researchs_kota) / (count($researchs_in) + count($researchs_out) + count($researchs_kota))) * 100, 2, '.', '') }}%)</span></span></span>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header rounded-0">
                    <h3 class="card-title"><i class="fas fa-calendar-alt"></i> ปฏิทิน</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <!-- THE CALENDAR -->
                    <div id="calendar" class="fc fc-media-screen fc-direction-ltr fc-theme-bootstrap"></div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>

        <div class="col-md-6">
            <div class="card card-warning">
                <div class="card-header rounded-0">
                    <h3 class="card-title text-white"><i class="fas fa-book"></i> บทความล่าสุด</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool text-white" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool text-white" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table style="table-layout:fixed;" class="table m-0">
                            <thead>
                                <tr>
                                    <th style="width: 15%;">รหัสบทความ</th>
                                    <th style="width: 70%;" class="text-center">ชื่อบทความ</th>
                                    <th style="width: 15%;" class="text-center">สร้างเมื่อ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($researchs as $key => $research)
                                    @if ($key < 10)
                                        <tr>
                                            <td>
                                                <p onclick="open_modal(this, 'detail')" style="cursor: pointer;"
                                                    class="text-primary">{{ $research->topic_id }}</p>
                                                <input type="hidden" value="{{ $research->topic_id }}">
                                            </td>
                                            <td><strong title="{{ $research->topic_th }}" class="d-flex">
                                                    <span class="single-text-ellipsis">{{ $research->topic_th }}</span>
                                                </strong></td>
                                            <td>
                                                <span class="badge badge-warning text-white">
                                                    {{ thaiDateFormat($research->research_created, false) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endif
                                    @if ($loop->last)
                                        <tr>
                                            <td colspan="3" class="text-end">
                                                <a href="{{ route('backend.research.index') }}">ดูทั้งหมด →</a>
                                            </td>
                                        </tr>
                                    @endif
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">ไม่มีบทความ</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
    <div id="modal"></div>
@endsection
