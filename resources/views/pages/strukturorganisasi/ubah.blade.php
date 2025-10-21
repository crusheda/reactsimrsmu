@extends('layouts.default')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Struktur Organisasi - Ubah <kbd>ID : {{ $list['id'] }}</kbd></h4>
            </div>
        </div>
    </div>

    <div class="card">

        <div class="card-body">

        {{-- <select class="selectpicker form-control mt-4" data-live-search="true" data-actions-box="true" multiple title="Choose one of the following..." data-header="Select a condiment" data-style="btn-light">
            <optgroup label="Picnic">
              <option>Mustard</option>
              <option>Ketchup</option>
              <option>Relish</option>
            </optgroup>
            <optgroup label="Camping">
              <option>Tent</option>
              <option>Flashlight</option>
              <option>Toilet Paper</option>
            </optgroup>
          </select><br> --}}
            <h4 class="card-title">
                <button class="btn btn-outline-secondary"
                    onclick="window.location.href='{{ route('strukturorganisasi.index') }}'"><i
                        class="bx bx-chevron-left"></i>&nbsp;&nbsp;Kembali</button>
            </h4>
            <hr>

            {{ Form::model($list['id'], ['route' => ['strukturorganisasi.update', $list['id']], 'method' => 'PUT', 'id' => 'formUbah']) }}
            @csrf
            <div class="form-group mb-4">
                <label for="userx" class="form-label">Nama User</label>
                <select id="userx" name="user" class="form-control select2" style="width: 100%" required>
                    @if (count($list['user']) > 0)
                        @foreach ($list['user'] as $item)
                            {{-- <option>{{ $item->nama }}</option> --}}
                            <option value="{{ $item->id }}" @if ($item->id == $list['id_user']) selected @endif>{{ $item->nama }}</option>
                        @endforeach
                    @endif
                </select>
                <sub>Pilih user yang akan mendapatkan akses laporan bawahannya</sub>
            </div>
            <div class="form-group mb-4">
                <label for="bawahanx" class="form-label">Jabatan Struktural Bawahan</label>
                <select id="bawahanx" name="bawahan[]" class="select2 form-control select2-multiple"
                    data-bs-auto-close="outside" required multiple="multiple" style="width: 100%">
                    @if (count($list['role']) > 0)
                        @foreach ($list['bawahan'] as $item)
                            @foreach ($list['role'] as $val)
                                <option value="{{ $val->id }}" @if ($val->id == $item) selected @endif>{{ $val->name }}</option>
                            @endforeach
                        @endforeach
                    @endif
                </select>
                <sub>Pilih semua Role bawahan</sub>
            </div>
            <button class="btn btn-primary" id="btn-simpan" onclick="saveData()">
                <i class="fas fa-save fa-md"></i>&nbsp;&nbsp;
                <span class="align-middle d-sm-inline-block d-none me-sm-1">Simpan</span>
            </button>
            {!! Form::close() !!}
        </div>





    </div>
    <script>
        $(document).ready(function() {
            $("#userx").select2({
                placeholder: "",
            });
            $("#bawahanx").select2({
                placeholder: "",
            });
        })

        // FUNCTION
        function saveData() {
            $("#formUbah").one('submit', function() {
                $("#btn-simpan").attr('disabled', 'disabled');
                $("#btn-simpan").find("i").toggleClass("fa-save fa-sync fa-spin");
                return true;
            });
        }
    </script>
@endsection
