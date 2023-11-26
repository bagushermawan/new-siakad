<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DataTables with Ajax</title>

    <!-- Sertakan library DataTables dan jQuery -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
</head>
<body>

    <table id="myDataTable" class="display">
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>username</th>
                <th>Email</th>
                <th>created at</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

    <script>
$(document).ready(function () {
    $.ajax({
        url: "{{ route('admin.user.ajax') }}",
        method: "GET",
        success: function (data) {
            const isAdmin = data.isAdmin;

            $('#myDataTable').DataTable({
                data: data.data,
                columns: [
                    { data: 'no', name: 'no' },
                    { data: 'name', name: 'name' },
                    { data: 'username', name: 'username' },
                    { data: 'email', name: 'email' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'roles', name: 'roles' }, // Tambah kolom roles
                    {
                        data: null,
                        render: function (data, type, row) {
                            if (isAdmin) {
                                return `
                                    <center>
                                        <a href="${data.edit_url}" class="badge bg-primary">Edit</a> |
                                        <a href="${data.delete_url}" class="badge bg-danger">Delete</a>
                                    </center>
                                `;
                            } else {
                                return '';
                            }
                        }
                    }
                ],
                columnDefs: [
                    { targets: -1, visible: isAdmin },
                    { targets: -2, visible: isAdmin } // Menyembunyikan/menampilkan kolom 'Roles' berdasarkan isAdmin
                ],
            });
        },
        error: function (error) {
            console.error('Ajax request failed:', error);
        }
    });
});
    </script>

</body>
</html>
