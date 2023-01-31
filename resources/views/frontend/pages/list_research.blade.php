@extends('frontend.layouts.master_frontend')

@section('content')
    <!-- Content -->
    <div class="bg-white text-blue p-5 my-5 row">

        <div class="inner-content-header">
            <h4 class="text-center fw-bold"><i class="nav-icon fas fa-book"></i> รายชื่อบทความ <br />
                @if ($conference)
                    {{ $conference->name }}
                @endif
            </h4>
            <h4 class="text-green py-3">
                {{ config('app.name') }}
            </h4>
        </div>

        <div class="col-md-12 mx-auto table-responsive">
            <table class="dataTable table w-100">
                <thead>
                    <tr class="text-center">
                        <th style="width: 5%;">รหัสบทความ</th>
                        <th style="width: 40%;">รายละเอียดบทความ</th>
                        <th style="width: 15%;" class="text-start">กลุ่มคณะ</th>
                        <th style="width: 15%;">การชำระเงิน</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($researchs as $research)
                        <tr class="text-center">
                            <td><strong>{{ $research->topic_id }}</strong></td>
                            <td class="text-start"><strong>
                                    {{ $research->topic_th }}
                                    <br />
                                    <span class="name-research text-small text-primary">สังกัด / หน่วยงาน :
                                        {{ $research->institution }}</span>
                                    <br />
                                    <span class="name-research text-small text-bluesky">รูปแบบบทความ :
                                        {{ $research->present_name }}</span>
                                </strong>
                            </td>
                            <td class="text-green text-start">
                                <strong class="text-small">{{ $research->faculty_name }}</strong>
                            </td>
                            <td>
                                <strong>
                                    @if ($research->topic_status_id >= 4)
                                        @if ($research->position_id === 1)
                                            <span class="text-small text-green">บุคลากรภายในมหาวิทยาลัยราชภัฏเลย
                                                <br />ไม่ต้องชำระเงิน</span>
                                        @elseif($research->position_id === 3)
                                            <span class="text-small text-green">โควต้าเจ้าภาพร่วม
                                                <br />ไม่ต้องชำระเงิน</span>
                                        @else
                                            @if ($research->payment)
                                                <span class="text-small text-green">ชำระเงินแล้ว</span>
                                            @else
                                                <span class="text-small text-danger">ค้างชำระเงิน</span>
                                            @endif
                                        @endif
                                    @else
                                        @if (countDate($research->created_at, 1, 'days'))
                                            <span class="text-small text-warning">{{ $research->topic_status }}</span>
                                        @else
                                            @if ($research->position_id === 1)
                                                <span class="text-small text-green">บุคลากรภายในมหาวิทยาลัยราชภัฏเลย
                                                    <br />ไม่ต้องชำระเงิน</span>
                                            @elseif($research->position_id === 3)
                                                <span class="text-small text-green">โควต้าเจ้าภาพร่วม
                                                    <br />ไม่ต้องชำระเงิน</span>
                                            @else
                                                @if ($research->payment)
                                                    <span class="text-small text-green">ชำระเงินแล้ว</span>
                                                @else
                                                    <span class="text-small text-danger">ค้างชำระเงิน</span>
                                                @endif
                                            @endif
                                        @endif
                                    @endif
                                </strong>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
    <!-- End Content -->
@endsection
