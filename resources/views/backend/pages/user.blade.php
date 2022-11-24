@extends('backend.layouts.master_backend')

@section('content')
    <div class="card">
        <div class="card-content">
            <div class="bg-green card-header rounded-0">
                <strong><i class="nav-icon fas fa-user"></i> ผู้ใช้งาน</strong>
            </div>

            <div class="card-body text-xs">
                <div class="text-end">
                    <a href="{{ route('users.export') }}" class="btn btn-info rounded-0 mb-3"><i
                            class="fas fa-file-export"></i>
                        Export to
                        Excel</a>
                </div>
                <div class="table-responsive">
                    <table style="color: inherit;" class="dataTable table w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ชื่อ - สกุล</th>
                                <th>สถานะ</th>
                                <th>อีเมล</th>
                                <th>สร้างเมื่อ</th>
                                <th>แก้ไข</th>
                                <th class="text-center">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $key => $user)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $user->fullname }}@if ($user->id == auth()->user()->id)
                                            <i class="text-bluesky text-sm"> (ฉัน)</i>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($user->conference_id)
                                            @if ($user->conference_id == $user->conference && $user->conference_status == 1)
                                                <strong class="text-green">Used</strong>
                                            @else
                                                <strong class="text-red">Not Used</strong>
                                            @endif
                                        @else
                                            <strong class="text-red">Not Used</strong>
                                        @endif
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td><i style="font-size: 12px;"
                                            class="text-bluesky">{{ thaiDateFormat($user->created_at, true) }}</i></td>
                                    <td>
                                        <a href="{{ route('backend.user.edit', $user->id) }}" class=" text-warning"><i
                                                class="nav-icon fa fa-edit"></i>
                                            แก้ไข</a>
                                    </td>
                                    <td class="text-center">
                                        @if (auth()->user()->id == $user->id)
                                            <a href="{{ route('backend.user.change_password', $user->id) }}"><i
                                                    class="nav-icon fa fa-pen"></i>
                                                เปลี่ยนรหัสผ่าน</a>
                                        @else
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                    <tr class="text-center">
                                        <td colspan="6">ไม่มีผู้ใช้งาน</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endsection
