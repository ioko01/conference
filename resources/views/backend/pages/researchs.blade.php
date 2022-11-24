@extends('backend.layouts.master_backend')

@section('content')
    <div class="card">
        <div class="card-content">
            <div class="bg-green card-header rounded-0">
                <strong><i class="nav-icon fas fa-book"></i> รายการบทความ</strong>
            </div>

            <div class="card-body text-xs">
                <div class="text-end">
                    <a href="{{ route('researchs.export') }}" class="btn btn-info rounded-0 mb-3"><i
                            class="fas fa-file-export"></i>
                        Export to
                        Excel</a>
                </div>
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
                            @forelse ($researchs as $key => $research)
                                <tr>
                                    <td class="text-center">{{ ++$key }}</td>
                                    <td class="text-start">
                                        <strong style="font-size: 12px" class="text-warning">
                                            รหัสบทความ : {{ $research->topic_id }}
                                        </strong>
                                        <br />
                                        <strong style="font-size: 12px" class="text-bluesky">
                                            รูปแบบ : {{ $research->present }}
                                        </strong>
                                        <br />
                                        <strong style="font-size: 12px" class="text-primary">สังกัด /
                                            หน่วยงาน : {{ $research->institution }}</strong>
                                        <br />
                                        <strong>
                                            {{ $research->topic_th }}
                                        </strong>
                                        <br />
                                        <strong style="font-size: 12px" class="text-green">ผู้นำเสนอ :
                                            {{ str_replace('|', ', ', $research->presenter) }}</strong>
                                    </td>
                                    <td class="text-center">{{ $research->year }}</td>
                                    <td class="text-center">
                                        <span class="text-info">
                                            {{ $research->fullname }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('backend.research.edit', $research->topic_id) }}"
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
