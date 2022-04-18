@extends('backend.layouts.master_backend')

@section('content')
    <div class="card">
        <div class="card-content">
            <div class="card-header">
                <h1>ผู้ใช้งาน</h1>
            </div>
            <div class="panel">
                <div class="body">
                    <div class="input-group">
                        <label for="search">ค้นหาผู้ใช้งาน</label>
                        <input type="text" class="form-control" name="search" id="search"
                            placeholder="ค้นหาผ่านลำดับ, ชื่อ - สกุล, อีเมลล์, สร้างเมื่อ">
                    </div>
                </div>
            </div>
            <div class="card-body text-xs">
                <div class="table-responsive">
                    <table class="list table responsive hover">
                        <th>#</th>
                        <th>ชื่อ - สกุล</th>
                        <th>อีเมล</th>
                        <th>สร้างเมื่อ</th>
                        <th>แก้ไข</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $key => $user)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $user->fullname }}@if ($user->id == auth()->user()->id)
                                            <i class="text-bluesky"> (ฉัน)</i>
                                        @endif
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td><i style="font-size: 12px;"
                                            class="text-bluesky">{{ thaiDateFormat($user->created_at, true) }}</i></td>
                                    <td>
                                        <a href="{{ route('backend.user.edit', $user->id) }}" class=" text-warning"><i
                                                class="nav-icon fas fa-pen"></i>
                                            แก้ไข</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
