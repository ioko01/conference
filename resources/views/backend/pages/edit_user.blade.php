@extends('backend.layouts.master_backend')

@section('content')
    <div class="card">
        <div class="card-content">
            <div class="card-header">
                <h1>รายละเอียดผู้ใช้งาน</h1>
            </div>
            <div class="card-body">
                <form action="{{ route('backend.user.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    @if ($user->is_admin == 2)
                        <strong>สถานะ <span class="text-green">ซุปเปอร์แอดมิน</span></strong>
                    @else
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <label for="status">สถานะ</label>
                                <select name="is_admin" id="is_admin" class="form-control">
                                    <option value="0"
                                        @if (old('is_admin')) @if (old('is_admin') == 0)
                                        selected @endif
                                    @elseif($user->is_admin == 0) selected @endif
                                        >ผู้ใช้งานทั่วไป
                                    </option>
                                    <option value="1"
                                        @if (old('is_admin')) @if (old('is_admin') == 1)
                                selected @endif
                                    @elseif($user->is_admin == 1) selected @endif>แอดมิน
                                    </option>
                                </select>
                            </div>
                        </div>
                    @endif


                    <div class="row mb-4">
                        <div class="col-12">
                            <strong>อีเมล <span class="text-green">{{ $user->email }}</span></strong>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="prefix">คำนำหน้า <span style="font-size: 12px;"
                                    class="text-bluesky">(ใช้ลงในเกียรติบัตร)</span></label>
                            <input type="text" name="prefix" id="prefix"
                                class="form-control @error('prefix') is-invalid @enderror"
                                @if (old('prefix')) value="{{ old('prefix') }}" @else value="{{ $user->prefix }}" @endif
                                autocomplete="prefix">

                            @error('prefix')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="fullname">ชื่อ - สกุล</label>
                            <input type="text" name="fullname" id="fullname"
                                class="form-control @error('fullname') is-invalid @enderror"
                                @if (old('fullname')) value="{{ old('fullname') }}" @else value="{{ $user->fullname }}" @endif
                                autocomplete="fullname">

                            @error('fullname')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="d-block">เพศ</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="sex" id="male"
                                    @if (old('sex') === 'male') checked
                                   @elseif ($user->sex === 'male') checked 
                                    value="male" @endif>
                                <label class="form-check-label" for="male">
                                    ชาย
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="sex" id="female"
                                    @if (old('sex') === 'female') checked
                                  @elseif($user->sex === 'female') checked @endif
                                    value="female">
                                <label class="form-check-label" for="female">
                                    หญิง
                                </label>
                            </div>

                            @error('sex')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="phone">เบอร์โทร</label>
                            <input type="text" name="phone" id="phone"
                                class="form-control @error('phone') is-invalid @enderror"
                                @if (old('phone')) value="{{ old('phone') }}"
                                @else
                                value="{{ $user->phone }}" @endif
                                autocomplete="phone">

                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-12">
                            <label for="institution">สังกัด / หน่วยงาน</label>
                            <input type="text" name="institution" id="institution"
                                class="form-control @error('institution') is-invalid @enderror"
                                @if (old('institution')) value="{{ old('institution') }}"
                                @else 
                                value="{{ $user->institution }}" @endif
                                autocomplete="institution">

                            @error('institution')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-12">
                            <label for="address">ที่อยู่ <span style="font-size: 12px;"
                                    class="text-bluesky">(ใช้ในการส่งเอกสาร)</span></label>
                            <textarea class="form-control @error('address') is-invalid @enderror" name="address" id="address" cols="30" rows="5">
@if (old('address')){{ old('address') }}@else{{ $user->address }}@endif
</textarea>

                            @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-12">
                            <label>เลือกสถานะของท่าน
                                @error('position_id')
                                    <span class="text-danger"> *กรุณาเลือกสถานะของท่าน</span>
                                @enderror
                            </label>

                            @foreach ($positions as $position)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="position_id"
                                        id="position_{{ $position->id }}" value="{{ $position->id }}"
                                        onchange="toggle_kota(this)"
                                        @if (old('position_id')) @if (old('position_id') == $position->id)
                                        checked @endif
                                    @else
                                        @if (!$user->position_id) @if ($position->id == $positions->first()->id)
                                        checked @endif
                                    @elseif($user->position_id == $position->id) checked @endif
                            @endif>

                            <label class="form-check-label" for="position_{{ $position->id }}">
                                {{ $position->name }}
                            </label>
                        </div>
                        @endforeach

                        <p style="color:red">* โควต้าเจ้าภาพร่วมกรุณาติดต่อต้นสังกัด
                            หากท่านเป็นบุคลากรภายในมหาวิทยาลัยราชภัฏเลย และบทความของท่านเป็นของมหาวิทยาลัยอื่น
                            จะต้องลงทะเบียนเป็น "บุคคลภายนอก"
                        </p>
                    </div>
            </div>
            <div class="row mb-4">
                <div class="col-12" id="select-kota">
                    <label>โควต้าเจ้าภาพร่วม
                        @error('position_id')
                            <span class="text-danger"> *กรุณาเลือกสถานะของท่าน</span>
                        @enderror
                    </label>

                    @foreach ($kotas as $kota)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="kota_id" id="kota_{{ $kota->id }}"
                                value="{{ $kota->id }}"
                                @if (old('kota_id')) @if (old('kota_id') == $kota->id)
                                checked @endif
                            @if (old('position_id') != '3') disabled @endif @else
                                @if ($user->position_id != '3') disabled @endif
                                @if (!$user->kota_id) @if ($kota->id == $kotas->first()->id)
                                checked @endif
                            @elseif($user->kota_id == $kota->id) checked @endif
                    @endif>

                    <label class="form-check-label" for="kota_{{ $kota->id }}">
                        {{ $kota->name }}
                    </label>
                </div>
                @endforeach

            </div>
        </div>
        <div class="row mb-4">
            <div class="col-12">
                <label>ท่านลงทะเบียนส่งผลงาน หรือเข้าร่วมงานทั่วไป ? @error('person_attend')
                        <span class="text-danger"> * กรุณาเลือกวิธีลงทะเบียน</span>
                    @enderror
                </label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="person_attend" id="send"
                        @if (old('person_attend')) @if (old('person_attend') === 'send')
                             checked @endif
                    @elseif($user->person_attend === 'send') checked @endif
                    value="send">
                    <label class="form-check-label" for="send">
                        ลงทะเบียนส่งผลงาน
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="person_attend" id="attend"
                        @if (old('person_attend')) @if (old('person_attend') === 'attend')
                             checked @endif
                    @elseif($user->person_attend === 'attend') checked @endif
                    value="attend">
                    <label class="form-check-label" for="attend">
                        ลงทะเบียนเข้าร่วมงานทั่วไป
                    </label>
                </div>
                <p style="color: red;">* บุคคลภายนอกจะต้องชำระค่าลงทะเบียน 2,000 บาท ต่อ 1 ผลงาน /
                    ลงทะเบียนเข้าร่วมงานทั่วไป 1,000 ต่อ 1 ท่าน * กรณีที่ท่านเป็นผู้ร่วมวิจัยฯ
                    ให้หัวหน้าโครงการลงทะเบียนส่งผลงาน และท่านลงทะเบียนเข้าร่วมงานทั่วไป
                </p>
            </div>
        </div>

        <div class="d-block">
            <input class="btn btn-warning rounded-0 text-white text-white w-100" type="submit" value="แก้ไขผู้ใช้งาน">
        </div>
        </form>
    </div>
    </div>
    </div>
@endsection
