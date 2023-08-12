<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>
</head>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script>
    $(document).ready(function() {
        setInterval(() => {
            $.ajax({
                url: '/admin/permintaan/all',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.permintaan.length > 0) {
                        var permintaan = '<tr><th>id</th>' +
                            '<th>keperluan</th>' +
                            '<th>disetujui</th></tr>';
                        var p = response.permintaan;
                        for (var i = 0; i < p.length; i++) {
                            permintaan += '<tr>' +
                                '<td>' + p[i].id + '</td>' +
                                '<td>' + p[i].keperluan + '</td>' +
                                '<td>' + p[i].disetujui + '</td></tr>';
                        }
                        $('#tpermintaan').empty();
                        $('#tpermintaan').append(permintaan);
                    }
                },
                error: function(err) {}
            })
        }, 5000);
    });
</script>

<body>
    <h1>Data Permintaan</h1>
    <hr>
    <table border="1" id="tpermintaan" cellspacing="0" cellpadding="5">
        <tr>
            <th>id</th>
            <th>keperluan</th>
            <th>disetujui</th>
        </tr>
        @if(isset($permintaan))
        @foreach($permintaan as $p)
        <tr>
            <td>{{ $p->id_tamu }}</td>
            <td>{{ $p->keperluan }}</td>
            <td>{{ $p->disetujui }}</td>
        </tr>
        @endforeach
        @endif
    </table>
</body>

</html>