<option selected value="">--- Select Appointment ---</option>
@if (!empty($appointment))
    @foreach ($appointment as $key => $value)
        <option value="{{ $key }}">{{ $value }}</option>
    @endforeach
@endif
