@extends('frontend.layouts.master_frontend')

@section('content')
<!-- Content -->
<div class="bg-white text-blue p-5 my-5">

    <div class="inner-content-header">
        <h2 class="text-center">รายชื่อบทความ ในงานการประชุมวิชาการ ราชภัฏเลยวิชาการ ครั้งที่ 8</h2>
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
                    placeholder="ค้นหาผ่านลำดับ, รหัสบทความ, บทความ/ผู้วิจัย, สังกัด/กลุ่มคณะ, สถานะ, รูปแบบ">
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="list table responsive hover">
            <thead>
                <tr class="text-center pagination-header">
                    <th style="width: 5%;">#</th>
                    <th style="width: 20%;">ชื่อบทความ/ผู้วิจัย</th>
                    <th style="width: 15%;">ลิงค์วิดีโอ</th>
                    <th style="width: 10%;">ไฟล์ Poster</th>
                    <th style="width: 5%;">รายละเอียด</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $key => $value)
                <tr class="text-center">
                    <td>{{ $value->id }}</td>
                    <td>{{ $value->topic_th }}
                        <br /><span class="name-research text-small text-green">{{ $value->presenter }}</span>
                    </td>

                    <td>
                        <a href="https://www.youtube.com">https://www.youtube.com</a>
                    </td>
                    <td>
                        
                    </td>
                    <td>
                        <button type="button" class="btn btn-green rounded-0 text-white" data-bs-toggle="modal"
                            data-bs-target="#detail">
                            รายละเอียด
                        </button>
                    </td>
                </tr>
                @empty
                <tr class="text-center">
                    <td colspan="8">ไม่มีบทความของท่าน</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<!-- End Content -->

@endsection