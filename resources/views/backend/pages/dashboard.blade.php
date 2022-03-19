@extends('backend.layouts.master_backend')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-content">
                <div class="card-body d-flex justify-content-between">
                    <div class="topic w-auto">
                        Storage Link <i style="font-size: 12px" class="text-danger">(เปิดแล้วไม่สามารถปิดได้)</i><br/>
                        <i style="font-size: 12px" class="text-bluesky">*เปิดใช้งานการเข้าถึงไฟล์ต่างๆ (จำเป็นต้องเปิด)</i>
                    </div>
                    <!-- Default checked -->
                    <form action="{{ route('backend.storage.open') }}" method="GET">
                        <div class="custom-control custom-switch">
                            <input onchange="javascript:document.getElementById('change_storage').click()"
                                type="checkbox" class="custom-control-input" id="switch_storage" @if ($storage) checked
                                @endif>
                                
                                @if ($storage) 
                                <label style="font-size: 10px;" class="custom-control-label text-success" for="switch_storage">เปิดใช้งานอยู่</label>
                                @else
                                <label style="font-size: 10px;" class="custom-control-label text-danger" for="switch_storage">ปิดใช้งาน</label>
                                @endif
                            
                        </div>
                        <input type="submit" class="d-none" id="change_storage">
                    </form>

                </div>
            </div>
        </div>
    </div>

    
</div>
@endsection