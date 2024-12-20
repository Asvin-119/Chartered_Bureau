@extends('dashboard.layout')

@section('title', 'Client Management')

@section('content')

<div class="container-fluid">
    <div class="card bg-light-info shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">All Users</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a class="text-muted text-decoration-none" href="{{route('dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item" aria-current="page">All Users</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-3 text-center mb-n5">
                    <img src="{{asset('dist/images/breadcrumb/ChatBc.png')}}" alt="" class="img-fluid mb-n4">
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">

                    <div class="col-sm-6">
                        <div class="input-group">
                            <input type="text" id="clientSearch" class="form-control" placeholder="Search clients..." />
                            <div class="input-group-append">
                                <span class="input-group-text bg-info" style="height: 43px;">
                                    <i class="ti ti-search"></i>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <a href="{{ route('clients.create') }}" class="btn btn-info btn-icon-text">
                            <i class="mdi mdi-plus-circle"></i> Add
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive pt-2">
                        <table class="table table-striped  table-bordered" id="clients-table">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 5%;">#</th> <!-- 5% -->
                                    <th style="width: 25%;">Client ID</th> <!-- 20% -->
                                    <th style="width: 30%;">Client Name</th> <!-- 35% -->
                                    <th style="width: 20%;">Email</th> <!-- 10% -->
                                    <th style="width: 20%;">Phone</th> <!-- 10% -->
                                    <!-- <th style="width: 10%;">Tour Consultant</th>
                                    <th style="width: 10%;">Source/Agent</th> -->
                                </tr>
                            </thead>
                            <tbody id="clients-tbody">
                                @foreach($clients as $client)
                                    <tr onclick="location.href='{{ route('clients.overview.show', $client->id) }}'">
                                        <td class="text-center" style="width: 5%;">{{ $loop->iteration }}</td>
                                        <td style="width: 20%;">{{ $client->custom_id }}</td>
                                        <td style="width: 35%;">{{ $client->display_name }}</td>
                                        <td style="width: 10%;">{{ $client->email }}</td>
                                        <td style="width: 10%;">{{ $client->mobile_phone }}</td>
                                        <!-- <td style="width: 10%;">{{ $client->tour_consultant }}</td>
                                        <td style="width: 10%;">{{ $client->source }}</td> -->
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@section('scripts')
<script>
    document.getElementById('clientSearch').addEventListener('input', function() {
        const query = this.value;

        // AJAX request to search clients
        fetch(`{{ route('clients.clients.search') }}?query=${query}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            }
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                const tbody = document.getElementById('clients-tbody');
                tbody.innerHTML = ''; // Clear existing results

                if (data.length > 0) {
                    data.forEach((client, index) => {
                        tbody.innerHTML += `
                            <tr onclick="location.href='{{ url('clients') }}/${client.id}'">
                                <td class="text-center" style="width: 5%;">${index + 1}</td>
                                <td style="width: 10%;">${client.custom_id}</td>
                                <td style="width: 45%;">${client.display_name}</td>
                                <td style="width: 10%;">${client.email}</td>
                                <td style="width: 10%;">${client.mobile_phone}</td>
                                <td style="width: 10%;">${client.tour_consultant}</td>
                                <td style="width: 10%;">${client.source}</td>
                            </tr>
                        `;
                    });
                } else {
                    tbody.innerHTML = '<tr><td colspan="7" class="text-center">No results found</td></tr>';
                }
            })
            .catch(error => console.error('Error:', error));
    });
</script>
@endsection

@endsection
