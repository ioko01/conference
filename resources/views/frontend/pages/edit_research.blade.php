@extends('frontend.layouts.master_frontend')

@section('content')
    <!-- Content -->
    <div id="register-content" class="bg-white text-blue p-5 my-5">
        <div class="inner-content-header">
            <h2 class="text-center">ส่งบทความ</h2>
            <h4 class="text-green py-3">
                {{ config('app.name') }}
            </h4>
        </div>
        <div class="row w-100">
            <div class="col-md-7">
                @foreach ($researchs as $research)
                    <form action="{{ route('employee.research.update', ['topic_id' => $research->topic_id]) }}"
                        method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="topic_th">ชื่อบทความ (ภาษาไทย)</label>
                            <input type="text" id="topic_th" name="topic_th" value="{{ $research->topic_th }}"
                                class="form-control @error('topic_th') is-invalid @enderror" autocomplete="topic_th"
                                autofocus>

                            @error('topic_th')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="topic_en">ชื่อบทความ (ภาษาอังกฤษ)</label>
                            <input type="text" id="topic_en" name="topic_en" value="{{ $research->topic_en }}"
                                class="form-control @error('topic_en') is-invalid @enderror" autocomplete="topic_en">

                            @error('topic_en')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label>ชื่อนักวิจัย (รวมถึงชื่อผู้ร่วมวิจัย)</label>
                            <div class="mb-4">
                                <span>1.&nbsp;</span>
                                <input type="text" id="presenters[]" name="presenters[]"
                                    class="form-control w-100 @error('presenters.0') is-invalid @enderror"
                                    @if (isset(explode('|', $research->presenter)[0])) value="{{ explode('|', $research->presenter)[0] }}" @endif
                                    autocomplete="presenters[0]">

                                @error('presenters.0')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <span>2.&nbsp;</span>
                                <input type="text" id="presenters[]" name="presenters[]" class="form-control w-100"
                                    @if (isset(explode('|', $research->presenter)[1])) value="{{ explode('|', $research->presenter)[1] }}" @endif
                                    autocomplete="presenters[1]">
                            </div>
                            <div class="mb-4">
                                <span>3.&nbsp;</span>
                                <input type="text" id="presenters[]" name="presenters[]" class="form-control w-100"
                                    @if (isset(explode('|', $research->presenter)[2])) value="{{ explode('|', $research->presenter)[2] }}" @endif
                                    autocomplete="presenters[2]">
                            </div>
                            <div class="mb-4">
                                <span>4.&nbsp;</span>
                                <input type="text" id="presenters[]" name="presenters[]" class="form-control w-100"
                                    @if (isset(explode('|', $research->presenter)[3])) value="{{ explode('|', $research->presenter)[3] }}" @endif
                                    autocomplete="presenters[3]">
                            </div>
                            <div class="mb-4">
                                <span>5.&nbsp;</span>
                                <input type="text" id="presenters[]" name="presenters[]" class="form-control w-100"
                                    @if (isset(explode('|', $research->presenter)[4])) value="{{ explode('|', $research->presenter)[4] }}" @endif
                                    autocomplete="presenters[4]">
                            </div>

                        </div>
                        <div class="mb-4">
                            <label for="faculty_id">บทความของท่านอยู่ในกลุ่ม</label>
                            <select name="faculty_id" id="faculty_id"
                                class="form-select @error('faculty_id') is-invalid @enderror"
                                onchange="select_faculty(this)">
                                <option value="" @if (!$research->faculty_id) selected @endif>---กรุณาเลือก---
                                </option>
                                @foreach ($faculties as $faculty)
                                    <option value="{{ $faculty->id }}" @if ($faculty->id == $research->faculty_id) selected @endif>
                                        {{ $faculty->name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('faculty_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="branch_id">สาขาย่อย</label>
                            <select name="branch_id" id="branch_id"
                                class="form-select @error('branch_id') is-invalid @enderror"
                                @if (!$research->faculty_id) disabled @endif>
                                <option value="" @if (!$research->branch_id) selected @endif>---กรุณาเลือก---
                                </option>
                                @foreach ($branches as $branch)
                                    @if ($branch->faculty_id == $research->faculty_id)
                                        <option value="{{ $branch->id }}"
                                            @if ($branch->id == $research->branch_id) selected @endif>
                                            {{ $branch->name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>

                            @error('branch_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>


                        <div class="mb-4" id="select-research-branch"></div>
                        <div class="mb-4">
                            <label for="degree_id">ระดับบทความ</label>
                            <select class="form-select @error('degree_id') is-invalid @enderror" name="degree_id"
                                id="degree_id">
                                <option value="" @if (!$research->degree_id) selected @endif>---กรุณาเลือก---
                                </option>
                                @foreach ($degrees as $degree)
                                    <option value="{{ $degree->id }}"
                                        @if ($degree->id == $research->degree_id) selected @endif>
                                        {{ $degree->name }}</option>
                                @endforeach
                            </select>

                            @error('degree_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label>รูปแบบการนำเสนอ</label>
                            @foreach ($presents as $present)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="present_id"
                                        id="present_{{ $present->id }}" value="{{ $present->id }}"
                                        @if (!$research->present_id) @if ($present->id == $presents->first()->id)
                            checked @endif
                                    @elseif ($present->id == $research->present_id) checked @endif>
                                    <label class="form-check-label" for="present_{{ $present->id }}">
                                        {{ $present->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        <p class="text-red text-center">
                            * กรุณาตรวจสอบความถูกต้องก่อนกดส่งบทความของท่าน
                        </p>
                        <button class="btn btn-warning text-white w-100 rounded-0" name="send_research"
                            type="submit">แก้ไขบทความ</button>
                    </form>
                @endforeach
            </div>
            <div class="col-md-5 tips">
                <div class="tips-content">
                    @foreach ($tips as $tip)
                        <div class="tips-box py-5">
                            <div class="icon"><img src="{{ asset($tip->image, env('REDIRECT_HTTPS')) }}"
                                    alt="{{ $tip->head }}"></div>
                            <div class="content"><strong>{{ $tip->head }}</strong><br /><span>
                                    <textarea readonly style="width: 100%;" class="txt-tips autosize">{{ $tip->detail }}</textarea>
                                </span></div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- End Content -->
@endsection
