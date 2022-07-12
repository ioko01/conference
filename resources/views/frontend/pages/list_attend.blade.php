@extends('frontend.layouts.master_frontend')

@section('content')
    <!-- Content -->
    <div class="bg-white text-blue p-5 my-5">

        <div class="inner-content-header">
            <h2 class="text-center">รายชื่อรายชื่อบทความ ในงานการประชุมวิชาการ ราชภัฏเลยวิชาการ ครั้งที่ 8</h2>
            <h4 class="text-green py-3">
                LRU Conference 2022
            </h4>
        </div>

        <div>
            <h1>รายชื่อรายชื่อบทความ</h1>
        </div>
        <div class="panel">
            <div class="body">
                <div class="input-group">
                    <label for="search">ค้นหาบทความ</label>
                    <input type="text" class="form-control" name="search" id="search"
                        placeholder="ค้นหาผ่านลำดับ, ชื่อ, สังกัด/หน่วยงาน, ชนิดการเข้าร่วม">
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="list table responsive hover">
                <thead>
                    <tr class="text-center pagination-header">
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
                                    ลงทะเบียนส่งผลงาน
                                @elseif($user->person_attend == 'attend')
                                    ลงทะเบียนเข้าร่วมงาน
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
    </div>
    <!-- End Content -->
@endsection
