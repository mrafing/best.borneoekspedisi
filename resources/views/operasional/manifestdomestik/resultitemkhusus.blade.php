@if ($id_layanan == 'LY5')
    @foreach ($listitemkhusus as $data )
        <label class="col-3 btn btn-outline-primary btn-sm mb-2 mr-2 rounded">
            <input type="radio" name="item_khusus" value="{{ $data->id }}"> <small>{{ $data->nama_item }}</small>
        </label>
    @endforeach
@endif

<script>
    // GET TABEL KOLI
    $(document).ready(function() {
        $('#koli, input[name="layanan"], input[name="item_khusus"]').on('change', function(){
            var koli = $('#koli').val();
            var id_layanan = $('input[name="layanan"]:checked').val();
            var id_item_khusus = $('input[name="item_khusus"]:checked').val();
            $.ajax({
                type: 'GET',
                url: '{{ route("resulttabelkoli") }}',
                data: {
                    koli: koli,
                    id_layanan: id_layanan,
                    id_item_khusus: id_item_khusus
                },
                success: function (response) {
                    $('#resultTabelKoli').html(response);
                },
                error: function (error) {
                    console.log(error);
                }
            });
        })
    })
</script>