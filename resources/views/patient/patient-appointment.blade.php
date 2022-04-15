@extends('layouts.master-layouts')
@section('title') {{ __('Appointment list') }} @endsection
@section('body')

    <body data-topbar="dark" data-layout="horizontal">
    @endsection
    @section('content')
        @component('components.breadcrumb')
            @slot('title') Appointment List @endslot
            @slot('li_1') Dashboard @endslot
            @slot('li_2') Appointment @endslot
        @endcomponent
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">

                        <div class="tab-content p-3 text-muted">
                            <div class="tab-pane active" id="PendingAppointmentList" role="tabpanel">
                                <table class="table table-bordered dt-responsive nowrap "
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Sr. No') }}</th>
                                            <th>{{ __('Doctor Name') }}</th>
                                            <th>{{ __('Date') }}</th>
                                            <th>{{ __('Time') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (session()->has('page_limit'))
                                            @php
                                                $per_page = session()->get('page_limit');
                                            @endphp
                                        @else
                                            @php
                                                $per_page = Config::get('app.page_limit');
                                            @endphp
                                        @endif
                                        @php
                                            $currentpage = $appointment->currentPage();
                                        @endphp
                                        @forelse ($appointment as $item)
                                            <tr>
                                                <td>{{ $loop->index + 1 + $per_page * ($currentpage - 1) }}</td>
                                                <td> {{ $item->doctor->first_name . ' ' . $item->doctor->last_name }}
                                                </td>
                                                <td>{{ $item->appointment_date }}</td>
                                                <td>{{ $item->timeSlot->from . ' to ' . $item->timeSlot->to }}</td>
                                                <td>
                                                    @if ($item->status == 0)
                                                        <span class="badge badge-warning">Pending</span>
                                                    @elseif ($item->status == 1 )
                                                        <span class="badge badge-success">Success</span>
                                                    @elseif ($item->status == 2 )
                                                        <span class="badge badge-danger">Cancel</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($item->status == 0)
                                                        <button type="button" class="btn btn-danger cancel"
                                                            data-id="{{ $item->id }}">Cancel</button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <p>No matching records found</p>
                                        @endforelse
                                    </tbody>
                                </table>
                                <div class="col-md-12 text-center mt-3">
                                    <div class="d-flex justify-content-start">
                                        Showing {{ $appointment->firstItem() }} to {{ $appointment->lastItem() }} of
                                        {{ $appointment->total() }} entries
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        {{ $appointment->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    @section('script')
        <!-- Init js-->
        <script src="{{ URL::asset('assets/js/pages/notification.init.js') }}"></script>
        <script src="{{ URL::asset('assets/js/pages/appointment.js') }}"></script>
    @endsection
