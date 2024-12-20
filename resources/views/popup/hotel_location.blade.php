<!-- Include SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Add Hotel Location Modal -->
<div class="modal fade" id="addHotelLocationModal" tabindex="-1" aria-labelledby="addHotelLocationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addHotelLocationModalLabel">Add Hotel Location</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addHotelLocationForm">
                    @csrf
                    <div class="mb-3">
                        <label for="hotelLocation" class="form-label">Hotel Location</label>
                        <input type="text" class="form-control" id="hotelLocation" name="hotel_location" required>
                    </div>
                    <div class="mb-3">
                        <label for="hotelName" class="form-label">Hotel Name</label>
                        <input type="text" class="form-control" id="hotelName" name="hotel_name" required>
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
document.querySelector('#addHotelLocationForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent default form submission

    let formData = new FormData(this);

    // Send form data via fetch with CSRF token
    fetch("{{ route('hotel.hotel_locations.store') }}", {
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
            $('#addHotelLocationModal').modal('hide');
            document.querySelector('#addHotelLocationForm').reset();
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Failed to add hotel location',
                text: data.message || 'An error occurred. Please try again.',
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'An error occurred while adding the hotel location.',
        });
    });
});
</script>
