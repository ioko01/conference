@extends('frontend.layouts.master_frontend')

@section('content')
    <!-- Content -->
    <div id="proceeding" class="bg-white text-blue p-5 my-5">
        @if ($conference->status_proceeding == 1)
            <div class="inner-content-header">
                <h4 class="text-center fw-bold">PROCEEDING <br />
                    @if ($conference)
                        {{ $conference->name }}
                    @endif
                </h4>
                <h4 class="text-green py-3">
                    {{ config('app.name') }}
                </h4>
            </div>
            @forelse ($topics as $topic)
                @if ($topic)
                    <div class="animate fade-up row">
                        <div class="col-md-6 mb-3">
                            <div class="border">
                                <div class="bg-green text-white p-3">
                                    <strong>{{ $topic }}</strong>
                                </div>
                                <div class="p-3 row">
                                    @forelse ($proceedings as $proceeding)
                                        @if ($proceeding->topic == $topic)
                                            @if ($proceeding->path)
                                                @if (in_array($proceeding->extension, ['jpg', 'jpeg', 'png', 'giff', 'webp']))
                                                    <div class="col-lg-4 col-md-5 col-sm-6 col-12">
                                                        <div class="card">
                                                            <div class="card-content">
                                                                <div class="card-header">
                                                                    <strong>
                                                                        {{ $proceeding->name }}
                                                                    </strong>
                                                                </div>
                                                                <div class="card-body">
                                                                    <img class="img-fluid"
                                                                        src="{{ Storage::url($proceeding->path) }}"
                                                                        alt="{{ $proceeding->name }}">
                                                                    <a target="_blank"
                                                                        class="btn btn-green mt-3 text-white rounded-0"
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

            <div id="proceeding" class="row my-5">
                <div class="col-md-8">
                    @forelse ($faculties as $key => $faculty)
                        <div class="animate fade-up my-5 border">
                            <div class="px-4 py-2 bg-green">
                                <strong class="text-white">
                                    {{ $faculty->name }}
                                </strong>
                            </div>
                            <div class="p-4 text-dark table-responsive">
                                <table style="color: inherit;" class="dataTable table w-100">
                                    <thead>
                                        <tr class="text-center">
                                            <th style="width: 10%;">เลขหน้า</th>
                                            <th style="width: 70%;" class="text-start">รายละเอียดบทความ</th>
                                            <th style="width: auto%;"><i class="fas fa-download"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($proceeding_researchs as $proceeding_research)
                                            @if ($proceeding_research->faculty_id == $faculty->id)
                                                <tr>
                                                    <td class="text-center fw-bold">{{ $proceeding_research->number }}</td>
                                                    <td class="text-start">
                                                        <strong
                                                            class="text-info">{{ $proceeding_research->present_name }}</strong><br />
                                                        <strong>{{ $proceeding_research->topic }}</strong><br />
                                                        <strong
                                                            class="text-green">{{ $proceeding_research->faculty_name }}</strong>
                                                    </td>
                                                    <td class="text-center">
                                                        <a target="_blank" class="fw-bold"
                                                            href="{{ Storage::url($proceeding_research->path) }}"
                                                            download="{{ $proceeding_research->number }} LRU_CONFERENCE.{{ $proceeding_research->extension }}"><i
                                                                class="fas fa-download"></i><br /> ดาวน์โหลด</a>
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
                </div>
            </div>
        @else
            <h1 class="text-danger text-center">
                <i class="fas fa-2x fa-times"></i><br />
                <strong style="font-size: calc(.5vw + 10px);">
                    ยังไม่เปิดเผยแพร่ Proceedings
                </strong>
            </h1>
        @endif


    </div>
    <!-- End Content -->
@endsection
