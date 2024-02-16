@extends('backend.layouts.master_backend')

@section('content')
    <div class="card">
        <div class="card-content">
            <div class="bg-green card-header rounded-0">
                <strong><i class="nav-icon fas fa-user"></i> ผู้ใช้งาน</strong>
            </div>

            <div class="card-body text-xs">
                <div class="text-end">
                    <button id="export" onclick="loading_export('users')" class="btn btn-info rounded-0 mb-3"><i
                            class="fas fa-file-export"></i> Export to Excel</button>
                    <strong class="text-red d-block mb-2">อาจใช้เวลาในการเขียนไฟล์หลายนาที</strong>
                </div>
                <div class="table-responsive">
                    <table style="color: inherit;" class="dataTable table w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th class="text-start">ชื่อ - สกุล</th>
                                <th>สถานะ</th>
                                <th class="text-start">อีเมล</th>
                                <th class="text-start">สร้างเมื่อ</th>
                                @if (auth()->user()->is_admin === 2 || auth()->user()->is_admin === 3)
                                    <th>แก้ไข</th>
                                    <th class="text-center">#</th>
                                    <th class="text-center">รีเซ็ตรหัสผ่าน</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $key => $user)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td class="text-start">{{ $user->fullname }}@if ($user->id == auth()->user()->id)
                                            <strong class="text-blue text-sm"> (ฉัน)</strong>
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
                                    <td class="text-start">
                                        {{ $user->email }}
                                        @if ($user->email_verified)
                                            <strong class='text-green text-sm'>(ยันยืนอีเมลแล้ว)</strong>
                                        @else
                                            <strong class='text-danger text-sm'>(ยังไม่ยืนยันอีเมล)</strong>
                                        @endif
                                    </td>
                                    <td class="text-start"><i style="font-size: 12px;"
                                            class="text-bluesky">{{ thaiDateFormat($user->created_at, true) }}</i></td>
                                    @if (auth()->user()->is_admin === 2 || auth()->user()->is_admin === 3)
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

                                        <td class="text-center">
                                            <button class="btn btn-warning rounded-0"
                                                onclick="open_modal('{{ $user->email }}', '{{ route('backend.user.reset_password', $user->id) }}')"><i
                                                    class="nav-icon fa fa-key"></i>
                                                รีเซ็ตรหัสผ่าน</button>
                                        </td>
                                        {{-- href="{{ route('backend.user.reset_password', $user->id) }}" --}}
                                    @endif
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
        <div id="modal"></div>
    @endsection
