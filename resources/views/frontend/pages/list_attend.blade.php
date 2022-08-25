@extends('frontend.layouts.master_frontend')

@section('content')
    <!-- Content -->
    <div class="bg-white text-blue p-5 my-5">

        <div class="inner-content-header">
            <h2 class="text-center">รายชื่อผู้ลงทะเบียน <br />
                @if ($conference)
                    {{ $conference->name }}
                @endif
            </h2>
            <h4 class="text-green py-3">
                {{ config('app.name') }}
            </h4>
        </div>

        <div>
            <h1>รายชื่อผู้ลงทะเบียน</h1>
        </div>
        <table class="dataTable table w-100">
            <thead>
                <tr class="text-center">
                    <th style="width: 5%;">#</th>
                    <th class="text-start" style="width: 25%;">ชื่อ - สกุล</th>
                    <th style="width: 15%;">สังกัด/หน่วยงาน</th>
                    <th style="width: 15%;">ชนิดการเข้าร่วม</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $key => $user)
                    <tr class="text-center">
                        <td>{{ $key + 1 }}</td>
                        <td class="text-start">{{ $user->prefix }}{{ $user->fullname }}</td>
                        <td>{{ $user->institution }}</td>
                        <td>
                            @if ($user->person_attend == 'send')
                                ส่งผลงาน
                            @elseif($user->person_attend == 'attend')
                                เข้าร่วมงาน
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr class="text-center">
                        <td colspan="4">ไม่มีรายชื่อผู้ลงทะเบียน</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <!-- End Content -->
@endsection
