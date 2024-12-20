@extends('dashboard.layout')

@section('title', 'Edit Client')

@section('content')

<div class="row">
    <form action="{{ route('clients.update', $client->id) }}" method="POST" class="col-md-12">
        @csrf 
        @method('PUT') <!-- Use PUT for updating -->
        
        <div class="row">
            <!-- Client Information -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Edit Client Information</h4>

                        <!-- Primary Contact Fields -->
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Primary Contact</label>
                            <div class="col-sm-3 mb-2">
                                <select id="salutation" class="form-control" name="salutation">
                                    <option value="{{ $client->salutation }}">{{ $client->salutation }}</option>
                                    <option>Mr.</option>
                                    <option>Mrs.</option>
                                    <option>Ms.</option>
                                    <option>Miss.</option>
                                    <option>Dr.</option>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" id="firstName" name="first_name" value="{{ old('first_name', $client->first_name) }}" placeholder="First Name" required>
                            </div>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" id="lastName" name="last_name" value="{{ old('last_name', $client->last_name) }}" placeholder="Last Name" required>
                            </div>
                        </div>

                        <!-- Display Name -->
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Client Display Name</label>
                            <div class="col-sm-9">
                                <input type="text" id="displayName" name="display_name" class="form-control" value="{{ $client->display_name }}" placeholder="Client Display Name" readonly required>
                            </div>
                        </div>

                        <!-- Client Email -->
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Client Email</label>
                            <div class="col-sm-9">
                                <input type="email" id="client_email" name="email" class="form-control" value="{{ old('email', $client->email) }}" placeholder="Client Email" required>
                            </div>
                        </div>

                        <!-- Client Phone -->
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Client Phone No</label>
                            <div class="col-sm-9">
                                <input type="text" id="mobilePhone" name="mobile_phone" class="form-control" value="{{ old('mobile_phone', $client->mobile_phone) }}" placeholder="Mobile Number">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 pt-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Sender Information</h4>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Tour Consultant</label>
                        <div class="col-sm-9">
                            <input type="text" id="tour_consultant" name="tour_consultant" class="form-control" value="{{ old('tour_consultant', $client->tour_consultant) }}" placeholder="Tour Consultant">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Source / Agent</label>
                        <div class="col-sm-9">
                            <input type="text" id="source" name="source" class="form-control" value="{{ old('source', $client->source) }}" placeholder="Source / Agent">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit and Cancel Buttons -->
        <div class="col-12 pt-3">
            <div class="card">
                <div class="card-body d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary btn-icon-text mx-2">
                        <i class="mdi mdi-content-save btn-icon-prepend"></i> Update
                    </button>
                    <a href="{{ route('clients.index') }}" class="btn btn-icon-text" style="background: #eeeeee;">
                        <i class="mdi mdi-cancel btn-icon-prepend"></i> Cancel
                    </a>
                </div>
            </div>
        </div>

    </form>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const salutation = document.getElementById('salutation');
        const firstName = document.getElementById('firstName');
        const lastName = document.getElementById('lastName');
        const displayName = document.getElementById('displayName');

        function updateDisplayName() {
            const salutationValue = salutation.value;
            const firstNameValue = firstName.value;
            const lastNameValue = lastName.value;
            displayName.value = `${salutationValue} ${firstNameValue} ${lastNameValue}`.trim();
        }

        salutation.addEventListener('change', updateDisplayName);
        firstName.addEventListener('input', updateDisplayName);
        lastName.addEventListener('input', updateDisplayName);
    });
</script>
@endsection

@endsection
