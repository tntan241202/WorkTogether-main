<!DOCTYPE html>
<html>
<head>
	<title>Đăng Nhập</title>
	<link rel="stylesheet" type="text/css" href="{{url('access/css/style.css')}}">
	<link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
	<script src="https://kit.fontawesome.com/a81368914c.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
	<img class="wave" src="{{url('access/img/wave.png')}}">
	<div class="container">
		<div class="img">
			<img src="{{url('access/img/bg.svg')}}">
		</div>
		<div class="login-content">
			<form action="{{ route('checklogin') }}" method="post" enctype="multipart/form-data">
				@csrf
				<img src="{{url('access/img/avatar.svg')}}">
				<h2 class="title">Xin Chào</h2>
           		<div class="input-div one">
           		   <div class="i">
           		   		<i class="fas fa-user"></i>
           		   </div>
           		   <div class="div">
           		   		<h5>Tên Đăng Nhập</h5>
           		   		<input type="text" class="input" name="user_id" required >
           		   </div>
           		</div>
           		<div class="input-div pass">
           		   <div class="i"> 
           		    	<i class="fas fa-lock"></i>
           		   </div>
           		   <div class="div">
           		    	<h5>Mật Khẩu</h5>
           		    	<input type="password" class="input" name="passwd" required>
            	   </div>
            	</div>
				<a href="{{ route('quenmatkhau') }}">Quên Mật Khẩu?</a>
				@if(session()->has('mess'))
				<div style="color:red;" >
					{{ session('mess') }}
				</div>
				@endif
            	<input type="submit" class="btn" value="Đăng Nhập">
            </form>
        </div>
    </div>
    <script type="text/javascript" src="{{url('access/js/main.js')}}"></script>
</body>
</html>