@extends('frontend.layouts.master_frontend')

@section('content')
    <!-- Content -->
    <div class="bg-white text-blue p-5 my-5">
        <div class="inner-content-header">
            <h2 class="text-center">ผลงานนำเสนอ Oral Presentation <br />
                @if ($conference)
                    {{ $conference->name }}
                @endif
            </h2>
            <h4 class="text-green py-3">
                {{ config('app.name') }}
            </h4>
        </div>

        <div>
            <h1>การนำเสนอผลงาน Oral Presentation</h1>
        </div>
        <div id="oral" class="my-5">
            <div class="row">
                <div class="col-md-10 mx-auto">

                    <div class="animate fade-up">
                        <div class="card p-0 rounded-0 my-5">
                            <div class="card-content">
                                <div class="card-header">
                                    <h1>
                                    </h1>
                                </div>
                                <div class="card-body">
                                    <table class="dataTable table w-100">
                                        <thead>
                                            <tr class="text-center">
                                                <th class="d-none">ลำดับ</th>
                                                <th>รหัสการนำเสนอ</th>
                                                <th>เวลา</th>
                                                <th class="text-start">ชื่อบทความ</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
    <!-- End Content -->
    <div id="modal_oral"></div>
@endsection
