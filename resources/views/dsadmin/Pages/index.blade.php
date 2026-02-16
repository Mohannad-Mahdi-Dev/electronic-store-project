@extends('dsadmin.layouts.app')
@section('title', 'Static Pages Management')
@section('content')
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Static Pages Management</h1>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>4</h3>
                        <p>Total Pages</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>Active</h3>
                        <p>Site Status</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3 class="text-white">Live</h3>
                        <p class="text-white">Frontend View</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-eye"></i>
                    </div>
                    <a href="{{ route('home') }}" target="_blank" class="small-box-footer">Visit Site <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">List of Content Pages</h3>
                <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 250px;">
                        <input type="text" name="table_search" class="form-control float-right" placeholder="Search Page...">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th width="60">ID</th>
                            <th>Page Name</th>
                            <th>Slug (URL)</th>
                            <th width="150">Status</th>
                            <th width="150">Quick Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $pages = [
                                ['id' => 1, 'name' => 'About Us', 'slug' => 'about-us'],
                                ['id' => 2, 'name' => 'Terms & Conditions', 'slug' => 'terms'],
                                ['id' => 3, 'name' => 'Privacy Policy', 'slug' => 'privacy'],
                                ['id' => 4, 'name' => 'Refund Policy', 'slug' => 'refund'],
                            ];

                        @endphp
                        @foreach($pages as $page)
                        <tr>
                            <td>{{ $page['id'] }}</td>
                            <td><strong>{{ $page['name'] }}</strong></td>
                            <td><span class="badge badge-light">/page/{{ $page['slug'] }}</span></td>
                            <td>
                                <span class="badge badge-success px-2 py-1"><i class="fas fa-check mr-1"></i> Visible</span>
                            </td>
                            <td>
                                <a href="#" target="_blank" class="btn btn-sm btn-outline-primary" title="View on Site">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                                <a href="#" class="btn btn-sm btn-outline-info" title="Edit Content">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection