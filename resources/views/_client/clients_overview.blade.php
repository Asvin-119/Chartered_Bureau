@extends('dashboard.layout')

@section('title', 'Customer Overview')

@section('content')

<div class="col-md-6">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title text-center"><strong>Client Details Overview</strong></h4>

            <hr>

            <div class="table-responsive">
                <table class="table" id="customers-table">
                    <tr>
                        <td style="width: 30%; font-weight: bold; font-size: 16px;">Client ID</td>
                        <td style="width: 70%; font-weight: bold; font-size: 16px;"><span class="pe-4">:</span> {{ $client->custom_id }}</td>
                    </tr>
                    <tr>
                        <td style="width: 30%; font-weight: bold; font-size: 16px;">Client Name</td>
                        <td style="width: 70%; font-weight: bold; font-size: 16px;"><span class="pe-4">:</span> {{ $client->display_name }}</td>
                    </tr>
                    <tr>
                        <td style="width: 30%; font-weight: bold; font-size: 16px;">Client Email</td>
                        <td style="width: 70%; font-weight: bold; font-size: 16px;"><span class="pe-4">:</span> {{ $client->email }}</td>
                    </tr>
                    <tr>
                        <td style="width: 30%; font-weight: bold; font-size: 16px;">Phone No</td>
                        <td style="width: 70%; font-weight: bold; font-size: 16px;"><span class="pe-4">:</span> {{ $client->mobile_phone }}</td>
                    </tr>
                    <tr>
                        <td style="width: 30%; font-weight: bold; font-size: 16px;">Tour Consultant</td>
                        <td style="width: 70%; font-weight: bold; font-size: 16px;"><span class="pe-4">:</span> {{ $client->tour_consultant }}</td>
                    </tr>
                    <tr>
                        <td style="width: 30%; font-weight: bold; font-size: 16px;">Source / Agent</td>
                        <td style="width: 70%; font-weight: bold; font-size: 16px;"><span class="pe-4">:</span> {{ $client->source }}</td>
                    </tr>
                </table>
            </div>

            <!-- Action Buttons -->
            <div class="col-12 pt-3">
                <div class="card">
                    <div class="card-body d-flex justify-content-center">
                        <a href="{{ route('clients.edit', $client->id) }}">
                            <button class="btn btn-success btn-icon-text mx-2">
                                <i class="mdi mdi-pencil btn-icon-prepend"></i> Edit
                            </button>
                        </a>
                        <form action="{{ route('clients.destroy', $client->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this customer?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-icon-text mx-2">
                                <i class="mdi mdi-delete btn-icon-prepend"></i> Delete
                            </button>
                        </form>
                        <a href="{{ route('clients.index') }}">
                            <button class="btn btn-icon-text" style="background: #eeeeee;">
                                <i class="mdi mdi-cancel btn-icon-prepend"></i> Cancel
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
