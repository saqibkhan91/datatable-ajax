<!doctype html>
<html>
    <head>
        <title>Datatable AJAX pagination with PHP and PDO</title>
        <link href='DataTables/datatables.min.css' rel='stylesheet' type='text/css'>

        <script src="jquery-3.3.1.min.js"></script>

        <script src="DataTables/datatables.min.js"></script>
        
    </head>
    <body >
        <div >
            <table id='empTable' class='display dataTable'>
                <thead>
                <tr>
                    <th>User ID</th>
                    <th>User Name</th>

                </tr>
                </thead>
                
            </table>
        </div>
        
        <!-- Script -->
        <script>
        $(document).ready(function(){
            $('#empTable').DataTable({
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'ajax': {
                    'url':'ajaxfile.php'
                },
                'columns': [
                    { data: 'user_id' },
                    { data: 'user_name' },

                ]
            });
        });
        </script>
    </body>

</html>
