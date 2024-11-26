<div class="page-section">
  <div class="container">
      <h1 class="text-center bold">Make an Appointment</h1>

      <!-- Display Success Message -->
      @if (session('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ session('success') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
      @endif

      <!-- Display Error Message -->
      @if (session('error'))
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
              {{ session('error') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
      @endif

      <form class="main-form" action="{{ url('appointment') }}" method="POST">
          @csrf

          <div class="row mt-5">
              <div class="col-12 col-sm-6 py-2">
                  <input type="text" name="name" class="form-control" placeholder="Full name" required>
              </div>
              <div class="col-12 col-sm-6 py-2">
                  <input type="text" name="email" class="form-control" placeholder="Email address" required>
              </div>
              <div class="col-12 col-sm-6 py-2">
                  <input type="date" name="date" id="appointment-date" class="form-control" required>
              </div>
              <div class="col-12 col-sm-6 py-2">
                  <select name="doctor" id="doctor-select" class="custom-select">
                      <option value="">---Select Doctor---</option>
                      @foreach($doctor as $doctors)
                          <option value="{{ $doctors->id }}">{{ $doctors->name }} - {{ $doctors->speciality }}</option>
                      @endforeach
                  </select>
              </div>
              <div class="col-12 py-2">
                  <select name="time_slot" id="time-slot-select" class="custom-select">
                      <option value="">---Select Time Slot---</option>
                  </select>
              </div>
              <div class="col-12 py-2">
                  <input type="text" name="number" class="form-control" placeholder="Phone number" required>
              </div>
              <div class="col-12 py-2">
                  <textarea name="message" class="form-control" rows="6" placeholder="Enter message"></textarea>
              </div>
          </div>

          <button type="submit" class="btn" style="background-color: #FFD580; color: #000;">Submit Request</button>
      </form>
  </div>
</div>

<script>
 document.getElementById('doctor-select').addEventListener('change', fetchTimeSlots);
 document.getElementById('appointment-date').addEventListener('change', fetchTimeSlots);

function fetchTimeSlots() {
    const doctorId = document.getElementById('doctor-select').value;
    const date = document.getElementById('appointment-date').value;

    if (doctorId && date) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch('/get-available-time-slots', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ doctor_id: doctorId, date: date })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            const timeSlotSelect = document.getElementById('time-slot-select');
            timeSlotSelect.innerHTML = '<option value="">---Select Time Slot---</option>';

            data.forEach(slot => {
                const option = document.createElement('option');
                option.value = slot.time_slot;
                option.textContent = `${slot.time_slot} (${slot.available} remaining)`;
                timeSlotSelect.appendChild(option);
            });
        })
        .catch(error => {
            console.error('Error fetching time slots:', error);
            alert('Failed to load time slots. Please try again later.');
        });
    }
 }


    @if(Session::has('success'))
    toastr.success("{{session('success')}}")
    @endif
</script>
