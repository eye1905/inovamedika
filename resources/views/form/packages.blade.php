@extends("template.layout")

@section("content")
<div class="card">
  <div class="card-body">
    @include("template.page-name")
    @include("template.notif")

    <form method="POST" enctype="multipart/form-data" action="@if(Request::segment(2)=='create'){{ url(Request::segment(1)) }}@else{{ url(Request::segment(1), $data->package_id) }}@endif">

      @csrf
      @if(Request::segment(3)=="edit")
      {{ method_field("PUT") }}
      @endif

      <div class="row">
        <div class="col-md-3">
          <label class="col-form-label">
            Gambar Paket
          </label>
          <br>
          <img class="img-thumbnail" src="@if(isset($data->pictures) and $data->pictures != null){{ $data->pictures }}@else{{ asset("images/no-image.png") }}@endif" name="img1" id="img1" width="90%" onclick="$('#gambar').trigger('click'); return false;">
          <br>
          (Maksimal 2 Mb | Format: jpg, jpeg, png, svg)
          <input type="file" id="gambar" name="gambar"/>

          @if($errors->has('gambar'))
          <label class="text-danger">
            {{ $errors->first('gambar') }}
          </label>
          @endif
        </div>

        <div class="col-md-9 row">

          <div class="col-md-6">
            <label class="col-form-label">
              Nama {{ StringHelper::getNameMenu() }} <span class="text-danger"> *</span>
            </label>

            <input type="text" class="form-control" id="name" name="name" value="@if(isset($data->name)){{ $data->name }} @else{{ old("name") }}@endif" required minlength="4" maxlength="100" placeholder="Masukan Nama {{ StringHelper::getNameMenu() }} ..">

            @if($errors->has('name'))
            <label class="text-danger">
              {{ $errors->first('name') }}
            </label>
            @else
            <label class="text-notif">
              Nama Paket di isi huruf, titik, koma, angka dan spasi  (4 - 100 Karakter)
            </label>
            @endif
          </div>

          <div class="col-md-6">
            <label class="col-form-label">
              Jumlah Pertemuan <span class="text-danger"> *</span>
            </label>

            <input type="number" step="any" class="form-control" id="total_meet" name="total_meet" onKeyPress="if(this.value.length==3) return false;" required placeholder="Masukan jumlah pertemuan ..">

            @if($errors->has('total_meet'))
            <label class="text-danger">
              {{ $errors->first('total_meet') }}
            </label>
            @else
            <label class="text-notif">
              Jumlah Pertemuan angka (1-3 Karakter)
            </label>
            @endif
          </div>

          <div class="col-md-6">
            <label class="col-form-label">
              Harga {{ StringHelper::getNameMenu() }} <span class="text-danger"> *</span>
            </label>

            <input type="number" step="any" class="form-control" id="price" name="price" v onKeyPress="if(this.value.length==15) return false;" required placeholder="Masukan harga {{ StringHelper::getNameMenu() }} ..">

            @if($errors->has('price'))
            <label class="text-danger">
              {{ $errors->first('price') }}
            </label>
            @else
            <label class="text-notif">
              Harga {{ StringHelper::getNameMenu() }} angka (1-15 Karakter)
            </label>
            @endif
          </div>

          <div class="col-md-6">
            <label class="col-form-label">Diskon 
            </label>
            <br>
            <table>
              <tr>
                <td>
                  <input type="checkbox" name="using_discount" id="using_discount">
                </td>
                <td width="600" style="padding-left: 10px;">
                  <input type="number" step="any" class="form-control" id="discount_price" name="discount_price" onKeyPress="if(this.value.length==10) return false;" required placeholder="Masukan Diskon {{ StringHelper::getNameMenu() }} ..">
                </td>
              </tr>
            </table>
            <br>
            @if($errors->has('discount_price'))
            <label class="text-danger">
              {{ $errors->first('discount_price') }}
            </label>
            @endif
          </div>

          <div class="col-md-6">
            <label class="col-form-label">
              Deskripsi
            </label>

            <textarea name="description" id="description"pa placeholder="Masukan Deskripsi {{ StringHelper::getNameMenu() }}" class="form-control" minlength="5" maxlength="255">@if(isset($data->description)){{ $data->description }}@else{{ old('description') }}@endif</textarea>
            
            @if($errors->has('description'))
            <label class="text-danger">
              {{ $errors->first('description') }}
            </label>
            @else
            <label class="text-notif">
              Deskripsi berisi 5 - 255 karakter
            </label>
            @endif
          </div>

          <div class="col-md-6">
            <label class="col-form-label">Status</label>
            <br>
            <label style="margin-left: 10px"><input type="radio" id="is_active" name="is_active" value="1"> Active</label>
            <label style="margin-left: 10px"><input type="radio" id="is_active" name="is_active" value=""> Inactive</label>
            <br>
            @if($errors->has('is_active'))
            <label class="text-danger">
              {{ $errors->first('is_active') }}
            </label>
            @endif
          </div>
          <hr>
        </div>
        <div class="col-md-12 text-end">
          @include("template.action")
        </div>

      </div>
    </form>

  </div>
</div>
@endsection

@section("script")
<script type="text/javascript">
  $("#is_active[value=1]").prop('checked', true);

  $("#gambar").hide();
  $("#gambar").on("change",function(e){
    if (this.files && this.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $('#img1').attr('src', e.target.result);
      }
      reader.readAsDataURL(this.files[0]);
      $("#img1").css({ 'height': '180px', 'width': '180px' });
    }
  });
  
  $("#discount_price").attr("disabled",  true);
  $("#discount_price").attr("readonly",  true);

  $(function(){
    $('#using_discount').change(function()
    {
      if($(this).is(':checked')) {
        $("#using_discount").val("1");
        $("#discount_price").attr("disabled",  false);
        $("#discount_price").attr("readonly",  false);
      }else{   
        $("#using_discount").val("");
        $("#discount_price").attr("disabled",  true);
        $("#discount_price").attr("readonly",  true);
      }
    });
  });
  
  @if(isset($data->using_discount) and $data->using_discount == "1")
  $("#using_discount").val('{{ $data->using_discount }}');
  $("#using_discount").attr("checked",  true);
  $("#discount_price").attr("disabled",  false);
  $("#discount_price").attr("readonly",  false);
  $("#discount_price").val('{{ $data->discount_price }}');
  @endif

  @if(isset($data->price))
  $("#price").val('{{ $data->price }}');
  @else
  $("#price").val('{{ old("price") }}');
  @endif

  @if(isset($data->total_meet))
  $("#total_meet").val('{{ $data->total_meet }}');
  @else
  $("#total_meet").val('{{ old("total_meet") }}');
  @endif

  @if(old("using_discount") == "1")
  $("#using_discount").attr("checked",  true);
  $("#discount_price").attr("disabled",  false);
  $("#discount_price").attr("readonly",  false);
  $("#discount_price").val('{{ old("discount_price") }}');
  @endif

</script>
@endsection