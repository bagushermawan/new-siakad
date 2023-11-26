@extends('admin.layouts.master')
@section('title', 'Dashboard')
@push('page-css')
    <link rel="stylesheet" href="{{ asset('extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">


    <link rel="stylesheet" href="{{ asset('compiled/css/table-datatable-jquery.css') }}">
@endpush
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Data User</h3>
                    <p class="text-subtitle text-muted">A sortable, searchable, paginated table without dependencies thanks
                        to simple-datatables.</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item" aria-current="page">User
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        Simple Datatable
                    </h5>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>username</th>
                                <th>Email</th>
                                <th>created at</th>
                                <th><center>Status</center></th>
                                <th><center>Action</center></th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>

        </section>
    </div>
@endsection
@push('page-script')
    <script src="{{ asset('extensions/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('extensions/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    {{-- <script src="{{ asset('static/js/pages/datatables.js') }}"></script> --}}
    <script>
$(document).ready(function () {
    // Inisialisasi DataTable dengan Ajax
    $.ajax({
        url: "{{ route('admin.user.ajax') }}",
        method: "GET",
        success: function (data) {
             console.log('Ajax request successful:', data);
            const isAdmin = data.isAdmin;

            // DataTable untuk table1
            let table1 = $('#table1').DataTable({
                data: data.data,
                columns: [
                    { data: 'no', name: 'no' },
                    { data: 'name', name: 'name' },
                    { data: 'username', name: 'username' },
                    { data: 'email', name: 'email' },
                    { data: 'created_at', name: 'created_at' },
                    {
                        data: 'roles',
                        name: 'roles',
                        render: function (data, type, row) {
                            // Menampilkan roles ke dalam kolom dan meratakan ke tengah
                            return `<center>${data}</center>`;
                        }
                    },
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

            // DataTable untuk table2
            let table2 = $("#table2").DataTable({
                responsive: true,
                pagingType: 'simple',
                dom:
                    "<'row'<'col-3'l><'col-9'f>>" +
                    "<'row dt-row'<'col-sm-12'tr>>" +
                    "<'row'<'col-4'i><'col-8'p>>",
                "language": {
                    "info": "Page _PAGE_ of _PAGES_",
                    "lengthMenu": "_MENU_ ",
                    "search": "",
                    "searchPlaceholder": "Search.."
                }
            });

            // Fungsi untuk memberi warna pada pagination
            const setTableColor = () => {
                document.querySelectorAll('.dataTables_paginate .pagination').forEach(dt => {
                    dt.classList.add('pagination-primary')
                })
            }

            // Memanggil fungsi setTableColor pada awal dan setiap kali DataTable digambar ulang
            setTableColor();
            table1.on('draw', setTableColor);
            table2.on('draw', setTableColor);
        },
        error: function (error) {
            console.error('Ajax request failed:', error);
        }
    });
});

    </script>
@endpush
