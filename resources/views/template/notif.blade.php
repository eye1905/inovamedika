@if(Session::has('success'))
<div class="alert alert-success">
	<h3><b>Berhasil</b></h3> 
	<b style="color:#ffff">{{ Session::get('success') }}</b>
</div>
@endif

@if(Session::has('error'))
<div class="alert alert-danger">
	<h3><b>Gagal</b></h3>
	<b style="color:#ffff">{{  Session::get('error') }}</b>
</div>
@endif

@if (count($errors) > 0)
<div class="alert alert-danger" style="margin-top: 10px">
	<ul>
		<h3><b>Kesalahan</b></h3> 
		@foreach ($errors->all() as $error)
		<li>{{ $error }}</li>
		@endforeach
	</ul>
</div>
@endif