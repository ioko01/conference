@extends('backend.layouts.master_backend')

@section('content')
    <!-- Content -->

    <div class="card">
        <div class="card-content">
            <div class="bg-green card-header rounded-0">
                <strong><i class="nav-icon fas fa-cogs"></i> จัดการบทความ</strong>
            </div>

            <div class="card-body text-xs">
                <div class="table-responsive">
                    <table style="color: inherit;" class="dataTable table w-100">
                        <thead>
                            <tr class="text-center pagination-header">
                                <th style="width: 5%;">#</th>
                                <th style="width: 75%;" class="text-start">รายละเอียดบทความ</th>
                                <th style="width: 10%;">พิจารณาบทความ</th>
                                <th style="width: 10%;">รายละเอียด</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $key => $value)
                                <tr class="text-center">
                                    <td>{{ $key + 1 }}</td>
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
                                        <br />
                                        <p class="text-secondary">
                                            <i style="font-size: 10px" class="d-block">อัพโหลด
                                                {{ thaiDateFormat($value->created_at, true, true) }}</i>
                                        </p>
                                    </td>
                                    <td>
                                        <select name="research_passed" class="form-select"
                                            onchange="open_modal(this, 'change_research_passed')">

                                            @for ($i = 0; $i < 4; $i++)
                                                <option value="{{ $i }}"
                                                    @if ($value->research_passed == $i) selected="selected" @endif>
                                                    @if ($i == 0)
                                                        รอการตรวจสอบ
                                                    @elseif ($i == 1)
                                                        ผ่านรอบที่ 1
                                                    @elseif ($i == 2)
                                                        ผ่านรอบที่ 2
                                                    @elseif ($i == 3)
                                                        ไม่ผ่าน
                                                    @endif
                                                </option>
                                            @endfor

                                        </select>
                                        <input type="hidden" value="{{ $value->topic_id }}">
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-success rounded-0 text-white"
                                            onclick="open_modal(this, 'detail')">รายละเอียด</button>
                                        <input type="hidden" value="{{ $value->topic_id }}">
                                    </td>
                                </tr>
                            @empty
                                <tr class="text-center">
                                    <td colspan="9">ไม่มีบทความ</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>

            </div>

        </div>

    </div>

    <!-- End Content -->
    <div id="modal"></div>

@endsection
