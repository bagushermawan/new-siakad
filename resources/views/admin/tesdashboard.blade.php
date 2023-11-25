@extends('admin.layouts.master')
@section('title', 'Dashboard')
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Vertical Layout witawfh Navbar</h3>
                    <p class="text-subtitle text-muted">Navbar will appear on the top of the page.</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item" aria-current="page">Layout Vertical Navbar
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Welcome <b><i>{{ auth()->user()->name }}</i></b></h4>
                </div>
                <div class="card-body">
                    <p style="color:green;">You're logged in as <b>{{ implode(', ', $roles->all()) }}</b>
                    </p>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">About Vertical Navbar</h4>
                </div>
                <div class="card-body">
                    <p>Vertical Navbar is a layout option that you can use with Mazer. </p>

                    <p>In case you want the navbar to be sticky on top while scrolling, add
                        <code>.navbar-fixed</code> class alongside with <code>.layout-navbar</code> class.
                    </p>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Dummy Text</h4>
                </div>
                <div class="card-body">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. In mollis tincidunt tempus.
                        Duis vitae facilisis enim, at rutrum lacus. Nam at nisl ut ex egestas placerat
                        sodales id quam. Aenean sit amet nibh quis lacus pellentesque venenatis vitae at
                    </p>
                </div>
            </div>
        </section>
    </div>
@endsection
