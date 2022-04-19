<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">{{ __('Dashboard') }}</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item active">Welcome to {{ config('app.name') }} Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- end page title -->
<div class="row">
    <div class="col-xl-4">
        <div class="card overflow-hidden">
            <div class="bg-soft-primary">
                <div class="row">
                    <div class="col-7">
                        <div class="text-primary p-3">
                            <h5 class="text-primary">{{ __('Welcome Back !') }}</h5>
                            <p>{{ config('app.name') }} Dashboard</p>
                        </div>
                    </div>
                    <div class="col-5 align-self-end">
                        <img src="{{ URL::asset('assets/images/profile-img.png') }}" alt="" class="img-fluid">
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="avatar-md profile-user-wid mb-4">
                            <img src="@if ($user->profile_photo != ''){{ URL::asset('storage/images/users/' . $user->profile_photo) }}@else{{ URL::asset('assets/images/users/noImage.png') }}@endif" alt="" class="img-thumbnail rounded-circle">
                        </div>
                        <h5 class="font-size-15 text-truncate"> {{ $user->first_name }} {{ $user->last_name }} </h5>
                        <p class="text-muted mb-0 text-truncate">{{ __('Super Admin') }}</p>
                    </div>
                    <div class="col-sm-8">
                        <div class="pt-4">
                            <div class="row">
                                <div class="col-6">
                                    <a href="{{ url('/doctor') }}" class="mb-0 font-weight-medium font-size-15">
                                        <h5 class="mb-0">{{ number_format($data['total_doctors']) }}</h5>
                                    </a>
                                    <p class="text-muted mb-0">{{ __('Doctors') }}</p>
                                </div>
                                <div class="col-6">
                                    <a href="{{ url('/patient') }}" class="mb-0 font-weight-medium font-size-15">
                                        <h5 class="mb-0">{{ number_format($data['total_patients']) }}</h5>
                                    </a>
                                    <p class="text-muted mb-0">{{ __('Patients') }}</p>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-6">
                                    <a href="{{ url('/receptionist') }}"
                                        class="mb-0 font-weight-medium font-size-15">
                                        <h5 class="mb-0">{{ number_format($data['total_receptionists']) }}
                                        </h5>
                                    </a>
                                    <p class="text-muted mb-0">{{ __('Receptionist') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">{{ __('Monthly Earning') }}</h4>
                <div class="row">
                    <div class="col-sm-6">
                        <p class="text-muted">{{ __('This month') }}</p>
                        <h3>${{ number_format($data['monthly_earning']) }}</h3>
                        <p class="text-muted">
                            <span class="@if ($data['monthly_diff'] > 0) text-success @else text-danger @endif mr-2">
                                {{ $data['monthly_diff'] }}% <i class="mdi @if ($data['monthly_diff'] > 0) mdi-arrow-up @else mdi-arrow-down @endif"></i>
                            </span>{{ __('From previous month') }}
                        </p>
                    </div>
                    <div class="col-sm-6">
                        <div id="radialBar-chart" class="apex-charts"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <div class="card mini-stats-wid">
                <div class="card-body">
                    <div class="media">
                        @if (session()->has('page_limit'))
                            @php
                                $per_page = session()->get('page_limit');
                            @endphp
                        @else
                            @php
                                $per_page = Config::get('app.page_limit');
                            @endphp
                        @endif
                        <div class="media-body">
                            <p class="text-muted font-weight-medium">Display items per page</p>
                            <button
                                class="btn  {{ $per_page == 10 ? 'btn-primary' : 'btn-info' }}  btn-sm mr-2 per-page-items  mb-md-1"
                                data-page="10">10</button>
                            <button
                                class="btn  {{ $per_page == 25 ? 'btn-primary' : 'btn-info' }}  btn-sm mr-2 per-page-items  mb-md-1"
                                data-page="25">25</button>
                            <button
                                class="btn  {{ $per_page == 50 ? 'btn-primary' : 'btn-info' }}  btn-sm mr-2 per-page-items  mb-md-1"
                                data-page="50">50</button>
                            <button
                                class="btn  {{ $per_page == 100 ? 'btn-primary' : 'btn-info' }}  btn-sm mr-2 per-page-items  mb-md-1"
                                data-page="100">100</button>
                        </div>
                        <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                            <span class="avatar-title rounded-circle bg-primary">
                                <i class="bx bx-book-open font-size-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-8">
        <div class="row">
            <div class="col-md-4">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="media">
                            <div class="media-body">
                                <p class="text-muted font-weight-medium">{{ __('Appointments') }}</p>
                                <h4 class="mb-0">{{ number_format($data['total_appointment']) }}</h4>
                            </div>
                            <div class="mini-stat-icon avatar-sm rounded-circle bg-primary align-self-center">
                                <span class="avatar-title">
                                    <i class="bx bxs-calendar-check font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="media">
                            <div class="media-body">
                                <p class="text-muted font-weight-medium">{{ __('Revenue') }}</p>
                                <h4 class="mb-0">${{ number_format($data['revenue'], 2) }}</h4>
                            </div>
                            <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                <span class="avatar-title rounded-circle bg-primary">
                                    <i class="bx bx-dollar font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="media">
                            <div class="media-body">
                                <p class="text-muted font-weight-medium">{{ __("Today's Earning") }}</p>
                                <h4 class="mb-0">${{ number_format($data['daily_earning'], 2) }}</h4>
                            </div>
                            <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                <span class="avatar-title rounded-circle bg-primary">
                                    <i class="bx bxs-dollar-circle  font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="media">
                            <div class="media-body">
                                <p class="text-muted font-weight-medium">{{ __("Today's Appointments") }}</p>
                                <a href="{{ url('/today-appointment') }}"
                                    class="mb-0 font-weight-medium font-size-24">
                                    <h4 class="mb-0">{{ number_format($data['today_appointment']) }}</h4>
                                </a>
                            </div>
                            <div class="mini-stat-icon avatar-sm rounded-circle bg-primary align-self-center">
                                <span class="avatar-title">
                                    <i class="bx bx-calendar font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="media">
                            <div class="media-body">
                                <p class="text-muted font-weight-medium">{{ __('Tomorrow Appointments') }}</p>
                                <h4 class="mb-0">{{ number_format($data['tomorrow_appointment']) }}</h4>
                            </div>
                            <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                <span class="avatar-title rounded-circle bg-primary">
                                    <i class="bx bx-calendar-event font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="media">
                            <div class="media-body">
                                <p class="text-muted font-weight-medium">{{ __('Upcoming Appointments') }}</p>
                                <a href="{{ url('/upcoming-appointment') }}"
                                    class="mb-0 font-weight-medium font-size-24">
                                    <h4 class="mb-0">{{ number_format($data['Upcoming_appointment']) }}
                                    </h4>
                                </a>
                            </div>
                            <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                <span class="avatar-title rounded-circle bg-primary">
                                    <i class='bx bxs-calendar-minus font-size-24'></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- end row -->
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">{{ __('Monthly Registered Users') }}</h4>
                <div id="monthly_users" class="apex-charts" dir="ltr"></div>
            </div>
        </div>
    </div>
</div>
<!-- end row -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">{{ __('Latest Users') }}</h4>
                <!-- Nav tabs -->
                <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#Doctors" role="tab">
                            <span class="d-block d-sm-none"><i class="fas fa-user-md"></i></span>
                            <span class="d-none d-sm-block">{{ __('Doctors') }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#Receptionist" role="tab">
                            <span class="d-block d-sm-none"><i class="fas fa-user-tie"></i></span>
                            <span class="d-none d-sm-block">{{ __('Receptionist') }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#Patients" role="tab">
                            <span class="d-block d-sm-none"><i class="fas fa-user-injured"></i></span>
                            <span class="d-none d-sm-block">{{ __('Patients') }}</span>
                        </a>
                    </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content p-3 text-muted">
                    <div class="tab-pane active" id="Doctors" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-centered table-nowrap mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>{{ __('Sr.No.') }}</th>
                                        <th>{{ __('Name') }}</th>
                                        <th>{{ __('Degree') }}</th>
                                        <th>{{ __('Contact No') }}</th>
                                        <th>{{ __('Email') }}</th>
                                        <th>{{ __('View Details') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($doctors as $item)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $item->first_name }} {{ $item->last_name }}</td>
                                            {{--<td>{{ $item->doctor->degree }}</td>--}}
                                            <td>{{ $item->mobile }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>
                                                <!-- Button trigger modal -->
                                                <a href="{{ url('doctor/' . $item->id) }}">
                                                    <button type="button"
                                                        class="btn btn-primary btn-sm btn-rounded waves-effect waves-light">
                                                        {{ __('View Details') }}
                                                    </button>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- end table-responsive -->
                    </div>
                    <div class="tab-pane" id="Receptionist" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-centered table-nowrap mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>{{ __('Sr.No.') }}</th>
                                        <th>{{ __('Name') }}</th>
                                        <th>{{ __('Contact No') }}</th>
                                        <th>{{ __('Email') }}</th>
                                        <th>{{ __('View Details') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($receptionists as $receptionist)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $receptionist->first_name }} {{ $receptionist->last_name }}
                                            </td>
                                            <td>{{ $receptionist->mobile }}</td>
                                            <td>{{ $receptionist->email }}</td>
                                            <td>
                                                <!-- Button trigger modal -->
                                                <a href="{{ url('receptionist/' . $receptionist->id) }}">
                                                    <button type="button"
                                                        class="btn btn-primary btn-sm btn-rounded waves-effect waves-light"
                                                        data-toggle="modal" data-target=".exampleModal">
                                                        {{ __('View Details') }}
                                                    </button>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- end table-responsive -->
                    </div>
                    <div class="tab-pane" id="Patients" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-centered table-nowrap mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>{{ __('Sr.No.') }}</th>
                                        <th>{{ __('Name') }}</th>
                                        <th>{{ __('Contact No') }}</th>
                                        <th>{{ __('Email') }}</th>
                                        <th>{{ __('View Details') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($patients as $patient)
                                        <tr>
                                            <td> {{ $loop->index + 1 }} </td>
                                            <td> {{ $patient->first_name }} {{ $patient->last_name }} </td>
                                            <td> {{ $patient->mobile }} </td>
                                            <td> {{ $patient->email }} </td>
                                            <td>
                                                <!-- Button trigger modal -->
                                                <a href="{{ url('patient/' . $patient->id) }}">
                                                    <button type="button"
                                                        class="btn btn-primary btn-sm btn-rounded waves-effect waves-light"
                                                        data-toggle="modal" data-target=".exampleModal">
                                                        {{ __('View Details') }}
                                                    </button>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- end table-responsive -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end row -->
