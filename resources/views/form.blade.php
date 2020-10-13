Đây là trang chứa form của api

<h2>Form tạo mới tài khoản</h2>
<form method="POST" action="http://localhost/bookapi/public/api/register">
    <p>Name<input type="text" name="name">
    <p>Email<input type="text" name="email">
    <p>Password<input type="text" name="password">
    <p>Nhap lai password<input type="text" name="c_password">
        {{-- Thay đổi value bằng tên..--}}
        <input type="hidden" name="created_by" value="user">
    @csrf;
<button type="submit">Register</button>
</form>
{{--  --}}

<h2>Form login</h2>
<form method="Post" action="http://localhost/bookapi/public/api/login">
    <p>email<input type="text" name="email">
    <p>password<input type="password" name="password"> 
        <button type="submit">Login</button>   
</form>


{{--  --}}
<h2>Form user details</h2>
<form method="Post" action="http://localhost/bookapi/public/api/details">
    @csrf
    <button type="submit">Xuat thong tin</button>
</form>

<form method="Post" action="http://localhost/bookapi/public/api/cover" enctype="multipart/form-data">
    Chọn file :<input type="file" name="cover">
    @csrf
    <button type="submit">Xuat thong tin</button>
</form>