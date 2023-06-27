<div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
    <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
        <span class="sr-only">Loading...</span>
    </div>
</div>
<div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-light navbar-light">
        <a href="{{route('IndexUser')}}" class="navbar-brand mx-4 mb-3">
            <h3 class="text-primary"><i class="fa fa-hashtag me-2"></i>Work Together</h3>
        </a>
        <div class="d-flex align-items-center ms-4 mb-4">
            @if ($user_info)
            <div class="position-relative">
                <img class="rounded-circle" src="{{url('accessweb/img/'.$user_info->Logo)}}" alt="" style="width: 40px; height: 40px;">
                <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
            </div>
            <div class="ms-3">
                <h6 class="mb-0">{{ $user_info->TenPhong }}</h6>
                <span>{{ $user_info->TenQuyen }}</span>
                @endif
            </div>
        </div>
        <div class="navbar-nav w-100">
            @switch($user_info->MaQuyen)
                @case(000)
                <a href="{{ route('list_nhanvien') }}" class="nav-item nav-link"><i class="fa fa-users me-2"></i>Quản lý nhân viên</a>
                <a href="{{ route('themnhanvien') }}" class="nav-item nav-link"><i class="fa fa-plus me-2"></i>Thêm Nhân Viên</a>
                <a href="{{route('listdonvi')}}" class="nav-item nav-link"><i class="fa fa-table me-2"></i>Quản Lý Đơn vị</a>
                <a href="{{ route('themdonvi') }}" class="nav-item nav-link"><i class="fa fa-plus me-2"></i>Thêm đơn vị</a>
                    @break
                @case(002)
                    <a href="{{ route('listcongviecpb') }}" class="nav-item nav-link"><i class="fa fa-table me-2"></i>Xem Công Việc</a>
                    <a href="{{ route('taocongviec') }}" class="nav-item nav-link"><i class="fa fa-plus me-2"></i>Tạo Công Việc</a>
                    <a href="{{ route('xemnhatkyphongban')}} " class="nav-item nav-link"><i class="fa fa-clock me-2"></i>Xem Nhật Ký</a>
                    <a href="{{ route('thongke')}} " class="nav-item nav-link"><i class="fa fa-chart-bar me-2"></i>Thống Kê</a>
                    <a href="{{ route('dscongviecnhanxet')}}" class="nav-item nav-link"><i class="fa fa-pen me-2"></i>Nhận xét</a>
                    @break
                @case(001)
                    <a href="{{ route('dscongviec') }}" class="nav-item nav-link"><i class="fa fa-list-ol me-2"></i>Xem Công Việc</a>
                    <a href="{{ route('xemnhatky')}} " class="nav-item nav-link"><i class="fa fa-clock me-2"></i>Xem Nhật Ký</a>
                    <a href="{{route('themnhatky')}}" class="nav-item nav-link"><i class="fa fa-bookmark me-2"></i>Ghi Nhật Ký</a>
                    <a href="{{route('xemketqua')}}" class="nav-item nav-link"><i class="fa fa-sticky-note me-2"></i>Xem Kết quả</a>
                    @break
            @endswitch
            <!-- <a href="#" class="nav-item nav-link"><i class="fa fa-comments me-2"></i>ChatBox</a> -->
        </div>
    </nav>
</div>
