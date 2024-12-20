<!-- Include SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Add Airline Details Modal -->
<div class="modal fade" id="addAirlineDetailsModal" tabindex="-1" aria-labelledby="addAirlineDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addAirlineDetailsModalLabel">Add Airline Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addAirlineDetailsForm">
                    @csrf
                    <input type="hidden" name="quote_id" id="quote_id" value="{{ $lastQuote->id }}">

                    <div class="mb-3">
                        <label for="airlineDetails" class="form-label">Airline Details</label>
                        <textarea class="form-control" id="airlineDetails" name="airline_details" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="bookingSummary" class="form-label">Booking Summary</label>
                        <textarea class="form-control" id="bookingSummary" name="booking_summary" rows="3" required></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.querySelector('#addAirlineDetailsForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent default form submission

    let formData = new FormData(this);

    // Send form data via fetch with CSRF token
    fetch("{{ route('airline_details.store') }}", {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: data.message,
                toast: true,
                position: "top-start",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                }
            });

            // Close modal and reset form on success
            $('#addAirlineDetailsForm').modal('hide');
            document.querySelector('#addAirlineDetailsForm').reset();
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Failed to add Airline Details',
                text: data.message || 'An error occurred. Please try again.',
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'An error occurred while adding the Airline Details.',
        });
    });
});
</script>
