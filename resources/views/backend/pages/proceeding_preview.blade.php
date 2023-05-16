@extends('backend.layouts.master_backend')

@section('content')
    <!-- Content -->
    <div id="proceeding" class="bg-white text-blue p-5 my-5">
        <h2>
            <a href="javascript: window.location = document.referrer" class="text-primary">← ย้อนกลับ</a>
        </h2>
        <div class="inner-content-header">
            <h4 class="text-center"><i class="fas fa-eye"></i> แสดงตัวอย่าง
            </h4>
            <h4 class="text-green py-3">
                {{ config('app.name') }}
            </h4>
        </div>
        @forelse ($topics as $key => $topic)
            @if ($topic)
                <div class="animate fade-up row">
                    <div class="col-md-6 mb-3">
                        <div class="bg-green text-white position-relative">
                            <div style="border: 10px solid white;
                                    border-top:10px solid transparent;
                                    border-bottom:10px solid transparent;
                                    border-left:10px solid transparent;
                                    right:0;
                                    top:0;"
                                class="position-absolute">

                            </div>
                            <div style="border: 10px solid white;
                                    border-top:10px solid transparent;
                                    border-bottom:10px solid transparent;
                                    border-left:10px solid transparent;
                                    right:0;
                                    bottom:0;"
                                class="position-absolute">

                            </div>
                            <div style="height: 40px;" class="px-3">
                                <strong style="line-height: 40px;">{{ $topic }}</strong>
                            </div>
                        </div>

                        <div class="border border-green">
                            <div class="p-3 row">
                                @forelse ($proceedings as $proceeding)
                                    @if ($proceeding->topic == $topic)
                                        @if ($proceeding->path)
                                            @if (in_array($proceeding->extension, ['jpg', 'jpeg', 'png', 'giff', 'webp']))
                                                <div class="col-lg-4 col-md-5 col-sm-6 col-12">
                                                    <div style="box-shadow: 0 0 1px rgb(0 0 0 / 13%), 0 1px 3px rgb(0 0 0 / 20%) !important;"
                                                        class="card">
                                                        <div class="card-content">
                                                            <div style="background-color: rgba(0,0,0,.03) !important;"
                                                                class="card-header">
                                                                <strong>
                                                                    {{ $proceeding->name }}
                                                                </strong>
                                                            </div>
                                                            <div class="card-body">
                                                                <img class="img-fluid"
                                                                    src="{{ Storage::url($proceeding->path) }}"
                                                                    alt="{{ $proceeding->name }}">
                                                                <a target="_blank"
                                                                    class="btn btn-success mt-3 text-white rounded-0"
                                                                    href="{{ Storage::url($proceeding->path) }}"
                                                                    download="{{ $proceeding->name }}.{{ $proceeding->extension }}">ดาวน์โหลด</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <strong class="d-inline mb-3">
                                                    <a target="_blank" href="{{ Storage::url($proceeding->path) }}">-
                                                        {{ $proceeding->name }}</a>
                                                </strong>
                                            @endif
                                        @elseif($proceeding->link)
                                            <strong class="d-inline mb-3">
                                                <a target="_blank" href="{{ $proceeding->link }}">-
                                                    {{ $proceeding->name }}</a>
                                            </strong>
                                        @endif
                                    @endif
                                @empty
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @empty
        @endforelse

        <div id="search_box" class="row my-5">
            <div class="col-md-8">
                <div class="animate fade-up mt-5">
                    <form action="{{ route('backend.proceeding.preview.index', ['year' => $year]) }}" method="GET">
                        <div class="d-flex w-100 position-relative">
                            <input type="text" name="search_proceedings" id="search_proceedings"
                                @if (isset($_GET['search_proceedings'])) value="{{ $_GET['search_proceedings'] }}" @endif
                                class="form-control w-100 p-4" placeholder="ค้นหาบทความ">
                            <button style="min-width: 80px;border: none;background-color: var(--color-green);"
                                type="submit" class="w-25 rounded-0 text-nowrap position-relative">
                                <div style="border: 10px solid var(--color-green);
                                            border-top:10px solid transparent;
                                            border-left:10px solid transparent;
                                            border-bottom:10px solid transparent;
                                            top:50%;
                                            left:-20px;
                                            transform:translateY(-50%)"
                                    class="position-absolute"></div>
                                <strong class="text-white">
                                    <i class="fas fa-search"></i> ค้นหาบทความ {{ old('search_proceedings') }}
                                </strong>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div id="proceeding" class="row my-5">
            <div class="col-md-8">
                @if (isset($_GET['search_proceedings']) && $_GET['search_proceedings'] != '')
                    <div class="animate fade-up my-5 border">
                        <div class="d-flex position-relative">


                            <div style="transform:translateY(-50%);background-color: var(--color-green);height:40px;left:-1px;"
                                class="px-5 position-absolute">

                                <div style="border: 20px solid var(--color-green);
                                border-top:20px solid transparent;
                                border-right:20px solid transparent;
                                border-bottom:20px solid transparent;
                                top:0;
                                right:-40px;"
                                    class="position-absolute"></div>

                                <strong style="line-height: 40px;" class="text-white">
                                    รายการบทความ
                                </strong>
                            </div>

                        </div>
                        <div class="p-4 text-dark">
                            <table data-searching="false" style="color: inherit;" class="dataTable table w-100">
                                <thead>
                                    <tr class="text-center">
                                        <th style="width: 10%;" class="d-none">#</th>
                                        <th style="width: 10%;">เลขหน้า</th>
                                        <th style="width: 70%;" class="text-start">รายละเอียดบทความ</th>
                                        <th style="width: auto%;"><i class="fas fa-download"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($proceeding_researchs as $proceeding_research)
                                        <tr>
                                            <td class="text-center fw-bold d-none">
                                                {{ explode('-', $proceeding_research->number)[0] }}</td>
                                            <td class="text-center fw-bold">{{ $proceeding_research->number }}
                                            </td>
                                            <td class="text-start">
                                                <strong
                                                    class="text-bluesky">{{ $proceeding_research->present_name }}</strong><br />
                                                <strong>{{ $proceeding_research->topic }}</strong><br />
                                                <div style="background-color: {{ $colors[$proceeding_research->faculty_id] }} "
                                                    class="px-3">
                                                    <strong
                                                        class="text-{{ $textColors[$proceeding_research->faculty_id] }}">{{ $proceeding_research->faculty_name }}</strong>
                                                </div>

                                            </td>
                                            <td class="text-center">
                                                <a target="_blank" class="fw-bold"
                                                    href="{{ Storage::url($proceeding_research->path) }}"
                                                    download="{{ $proceeding_research->number }} LRU_CONFERENCE.{{ $proceeding_research->extension }}"><i
                                                        class="fas fa-download"></i><br />ดาวน์โหลด</a>
                                            </td>
                                        </tr>
                                    @empty
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>
                @else
                    @forelse ($faculties as $key => $faculty)
                        <div class="animate fade-up my-5 border">
                            <div class="d-flex position-relative">


                                <div style="transform:translateY(-50%);background-color: {{ $colors[$faculty->id] }};height:40px;
                        @if ($key % 2 == 0) left:-1px;
                        @else right:-1px; @endif"
                                    class="px-5 position-absolute">


                                    @if ($key % 2 == 0)
                                        <div style="border: 20px solid {{ $colors[$faculty->id] }};
                                        border-top:20px solid transparent;
                                        border-right:20px solid transparent;
                                        border-bottom:20px solid transparent;
                                        top:0;
                                        right:-40px;"
                                            class="position-absolute"></div>
                                    @else
                                        <div style="border: 20px solid {{ $colors[$faculty->id] }};
                                        border-top:20px solid transparent;
                                        border-left:20px solid transparent;
                                        border-bottom:20px solid transparent;
                                        top:0;
                                        left:-40px;"
                                            class="position-absolute"></div>
                                    @endif

                                    <strong style="line-height: 40px;" class="text-{{ $textColors[$faculty->id] }}">
                                        {{ $faculty->name }}
                                    </strong>
                                </div>

                            </div>
                            <div class="p-4 text-dark">
                                <table data-searching="false" style="color: inherit;" class="dataTable table w-100">
                                    <thead>
                                        <tr class="text-center">
                                            <th style="width: 10%;" class="d-none">#</th>
                                            <th style="width: 10%;">เลขหน้า</th>
                                            <th style="width: 70%;" class="text-start">รายละเอียดบทความ</th>
                                            <th style="width: auto%;"><i class="fas fa-download"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($proceeding_researchs as $proceeding_research)
                                            @if ($proceeding_research->faculty_id == $faculty->id)
                                                <tr>
                                                    <td class="text-center fw-bold d-none">
                                                        {{ explode('-', $proceeding_research->number)[0] }}</td>
                                                    <td class="text-center fw-bold">{{ $proceeding_research->number }}
                                                    </td>
                                                    <td class="text-start">
                                                        <strong
                                                            class="text-bluesky">{{ $proceeding_research->present_name }}</strong><br />
                                                        <strong>{{ $proceeding_research->topic }}</strong><br />
                                                        <div style="background-color: {{ $colors[$proceeding_research->faculty_id] }} "
                                                            class="px-3">
                                                            <strong
                                                                class="text-{{ $textColors[$proceeding_research->faculty_id] }}">{{ $proceeding_research->faculty_name }}</strong>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <a target="_blank" class="fw-bold"
                                                            href="{{ Storage::url($proceeding_research->path) }}"
                                                            download="{{ $proceeding_research->number }} LRU_CONFERENCE.{{ $proceeding_research->extension }}"><i
                                                                class="fas fa-download"></i><br />ดาวน์โหลด</a>
                                                    </td>
                                                </tr>
                                            @endif
                                        @empty
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    @empty
                    @endforelse
                @endif

            </div>
        </div>



    </div>
    <!-- End Content -->
@endsection
