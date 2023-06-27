<a href="index.html" class="navbar-brand d-flex d-lg-none me-4">
    <h2 class="text-primary mb-0"><i class="fa fa-hashtag"></i></h2>
</a>
<a href="#" class="sidebar-toggler flex-shrink-0">
    <i class="fa fa-bars"></i>
</a>
<div class="navbar-nav align-items-center ms-auto">
    <div class="nav-item dropdown">
        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
            @if ($user_info)
            <img class="rounded-circle me-lg-2" src="{{url('accessweb/img/'.$user_info ->Avt)}}" alt="" style="width: 40px; height: 40px;">
            <span class="d-none d-lg-inline-flex">{{ $user_info->TenNV }}</span>
            @endif
        </a>
        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
            <a href="{{route('thongtincanhan')}}" class="dropdown-item">Thông Tin Cá Nhân</a>
            <a href="{{route('doimatkhau')}}" class="dropdown-item">Đổi Mật Khẩu</a>
            <a href="{{route('logout')}}" class="dropdown-item">Đăng Xuất</a>
        </div>
    </div>
</div>