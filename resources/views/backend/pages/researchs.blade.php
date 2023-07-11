@extends('backend.layouts.master_backend')

@section('content')
    <div class="card">
        <div class="card-content">
            <div class="bg-green card-header rounded-0">
                <strong><i class="nav-icon fas fa-book"></i> รายการบทความ</strong>
            </div>

            <div class="card-body text-xs">
                <div class="table-responsive">
                    <table style="color: inherit;" class="dataTable table w-100">
                        <thead>
                            <tr class="text-center pagination-header">
                                <th style="width: 5%;">#</th>
                                <th style="width: 45%;" class="text-start">รายละเอียดบทความ</th>
                                <th style="width: 10%;">ปีที่ส่งผลงาน</th>
                                <th style="width: 10%;">ชื่อผู้ส่งผลงาน</th>
                                <th style="width: 10%;">แก้ไข</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($researchs as $key => $value)
                                <tr>
                                    <td class="text-center">{{ ++$key }}</td>
                                    <td class="text-start">
                                        <strong style="font-size: 12px" class="text-warning">
                                            รหัสบทความ : {{ $value->topic_id }}
                                        </strong>
                                        <br />
                                        <strong>
                                            {!! $value->topic_th !!}
                                        </strong>
                                        <br />
                                        <strong style="font-size: 12px" class="text-primary">สังกัด /
                                            หน่วยงาน : {{ $value->institution }}</strong>
                                        <br />
                                        <strong style="font-size: 12px" class="text-green">ผู้นำเสนอ :
                                            {{ str_replace('!!', ' ', str_replace('|', ', ', $value->presenter)) }}</strong>
                                        <br />
                                        <strong style="font-size: 12px" class="text-bluesky">
                                            รูปแบบบทความ : {{ $value->present }}
                                        </strong>
                                    </td>
                                    <td class="text-center">{{ $value->year }}</td>
                                    <td class="text-center">
                                        <span class="text-info">
                                            {{ $value->fullname }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('backend.research.edit', $value->topic_id) }}"
                                            class=" text-warning"><i class="nav-icon fa fa-edit"></i>
                                            แก้ไข</a>
                                    </td>
                                </tr>
                            @empty
                                <tr class="text-center">
                                    <td colspan="6">ไม่มีบทความ</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
