@forelse ($listhargaongkir as $data)
    <div class="input-contain-layanan">
        <input type="radio" name="id_layanan" value="{{ $data->layanan->id }}">
        <div class="radio-layanan">
            <label><b>{{ $data->layanan->nama_layanan }}</b> <br> <small>{{ $data->layanan->nama_komoditi }}</small></label>
        </div>
    </div>
@empty
    <div class="input-contain-layanan">
        <input type="radio" name="layanan" value="" disabled>
        <div class="radio-layanan-disabled">
            <label><b class="text-danger">Maaf Layanan Belum Tersedia Ke tempat Tujuan</b> <br> <small></small></label>
        </div>
    </div>
@endforelse

<script>
    // GET TABEL KOLI
    $(document).ready(function() {
        $('#koli, input[name="id_layanan"]').on('change', function(){
            var koli = $('#koli').val();
            var id_layanan = $('input[name="id_layanan"]:checked').val();
            $.ajax({
                type: 'GET',
                url: '{{ route("resulttabelkoliln") }}',
                data: {
                    koli: koli,
                    id_layanan: id_layanan
                },
                success: function (response) {
                    $('#resulttabelkoliln').html(response);
                },
                error: function (error) {
                    console.log(error);
                }
            });
        })
    })
</script>