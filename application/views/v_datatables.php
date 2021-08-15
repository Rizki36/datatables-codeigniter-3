<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
    <title>Hello, world!</title>
</head>

<body>
    <table id="table-ticketing" class="table mt-3">
        <thead>
            <tr>
                <td colspan="6">
                    <div class="input-group m-0 p-0">
                        <input class="form-control m-0 mt-1" style="padding: 5px; box-sizing: border-box;" id="search" type="text">
                    </div>
                </td>
            </tr>
            <tr>
                <td>No</td>
                <td>awb</td>
                <td>nama pickup</td>
                <td>alamat pickup</td>
                <td>customer code</td>
                <td>tgl trx</td>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#table-ticketing').DataTable({
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'ajax': {
                    'url': '<?= base_url('datatables/get_data'); ?>'
                },
                "order": [
                    [5, 'desc']
                ],
                "columnDefs": [{
                    "orderable": false,
                    "searchable": false,
                    "targets": 0
                }]
                // 'columns': [
                //     {
                //         data: 'awb_no'
                //     },
                //     {
                //         data: 'pickup_name'
                //     },
                //     {
                //         data: 'pickup_address'
                //     },
                //     {
                //         data: 'customer_code'
                //     }
                // ]
            });
        });
    </script>
</body>

</html>