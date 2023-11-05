<h1>Thư từ sinh viên</h1>
<p> Họ và tên: {{ $data["name"] }}</p>
<p> Mã sinh viên: {{ $data["student_code"] }}</p>
<p> Khóa: {{ $data["school_year"] }}</p>
<p> Email: {{ $data["email"] }}</p>
<hr>
{!! $data["detail"] !!}