{{-- @dd($listmanifest) --}}
{{-- @dd($listlayanan) --}}
@extends('layouts.main')


@section('container')
{{-- Sidebar --}}
@include('operasional.partials.sidebar')

{{-- Content wrapper --}}
<div id="content-wrapper" class="d-flex flex-column bg-white">
    {{-- Main content --}}
    <div id="content">
        {{-- Top bar --}}
        @include('partials.topbar')

        {{-- Page content --}}
        <div class="container-fluid p-2 p-lg-4 bg-white">
            <div class="watermark row justify-content-around">
                @for ($i=0; $i<500; $i++)
                    <div>
                        <p style="margin-bottom: 100px;"><b>{{ strtoupper(Auth::user()->username) }} - {{ strtoupper(Auth::user()->outlet->kode_agen) }} - {{ strtoupper(Auth::user()->role) }}</b></p>
                        <p style="margin-left: 200px; margin-bottom: 100px;"><b>{{ strtoupper(Auth::user()->username) }} - {{ strtoupper(Auth::user()->outlet->kode_agen) }} - {{ strtoupper(Auth::user()->role) }}</b></p>
                    </div>
                @endfor
            </div>
            {{-- CONTENT --}}
            <div style="max-width: 1000px">
                <form action="{{ URL::to('operasional/manifestdomestik/savehapus') }}" method="post">
                    @csrf
                    @method('delete')
                    <input type="hidden" name="id" value="{{ $data->id }}">
                    <input type="hidden" name="id_outlet_terima" value="{{ $data->id_outlet_terima }}">
                    <input type="hidden" name="id_pengirim" value="{{ $data->id_pengirim }}">
                    <input type="hidden" name="id_penerima" value="{{ $data->id_penerima }}">
                    <input type="hidden" name="id_barang" value="{{ $data->id_barang }}">
                    <input type="hidden" name="id_ongkir" value="{{ $data->id_ongkir }}">
                    <input type="hidden" name="id_layanan" value="{{ $data->id_layanan }}">
                    <input type="hidden" name="admin" value="{{ $data->admin }}">
                    <input type="hidden" name="deleted_by" value="{{ Auth::user()->username }}">

                    <label class="form-label">Keterangan Hapus</label>
                    <textarea class="form-control mb-3" name="keterangan_hapus" cols="30" rows="5"></textarea>
                    <button class="btn btn-danger" type="submit">Void</button>
                </form>
            </div>
            {{-- END CONTENT --}}
        </div>
    </div>

    {{-- Footer --}}
    <footer class="sticky-footer bg-white border-top">
        <div class="container my-auto">
            <div class="copyright text-center my-auto">
                <span>Copyright &copy; PT. Borneo Citra Express 2020 - {{ date('Y') }}</span>
            </div>
        </div>
    </footer>
</div>
@endsection

@section('script')
@endsection