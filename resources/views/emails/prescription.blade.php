
<!doctype html>
<html>
​
<head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Prescription  | {{ config('app.name'); }}</title>
</head>
​
<body style="background-color:#f0f3fc; padding: 20px 0px;">
    <div style="margin: 50px 0px;">
​
        <table cellpadding="0" cellspacing="0" style="font-size: 15px; font-weight: 400; max-width: 700px; border: none; margin: 0 auto; border-radius: 6px; overflow: hidden; background-color: #fff; box-shadow: 0 0 3px rgba(60, 72, 88, 0.15); width:50%; ">
            <thead>
                <tr style="background-color: #242e4d; border: none; height: 70px; font-size: 32px;">
                    <th scope="col">
                        <img src="{{ URL::asset('assets/images/logo-light1.png') }}" alt="{{ config('app.name'); }}"
                            title="{{ config('app.name'); }}" style="height: 24px;" />
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="padding: 30px 24px 0; color: #161c2d; font-size: 18px;">
                        <table style="width: 100%;">
                            <tbody>
                                <tr>
                                    <td style="padding-bottom: 10px; color: #161c2d; font-size: 18px; ">
                                        Hello, <b>{{ $prescription->patient->first_name .' '.$prescription->patient->last_name }}</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>Doctor Details: </b></td>
                                    <td><b>Prescription Date&Time: </b></td>
                                </tr>
                                <tr>
                                    <td><b>Name: </b>{{ $prescription->doctor->first_name .' '. $prescription->doctor->last_name}}</td>
                                    <td>{{ $prescription->created_at }}</td>
                                </tr>
                                <tr>
                                    <td><b>Contact: </b>{{ $prescription->doctor->mobile }}</td>
                                    <td><b>Appointment Date&Time: </b></td>
                                </tr>
                                <tr>
                                    <td><b>Email: </b>{{ $prescription->doctor->email }}</td>
                                    <td>{{ $prescription->appointment->appointment_date}}</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>{{ $prescription->appointment->timeSlot->from .' to '.$prescription->appointment->timeSlot->to }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 30px 24px 10px; color: #161c2d; font-size: 18px; font-weight: 600;">
                        Bellow you can find your prescription
                    </td>
                </tr>
                <tr>
                    <td style="padding: 20px 24px 24px 24px;">
                        <div style="display: block; overflow-x: auto; -webkit-overflow-scrolling: touch;">
                            <table cellpadding="0" cellspacing="0" style="width: 100%;">
                                <tbody >
                                    <tr style="background-color: rgba(47,117,208, 0.1); color: #2f75d0; overflow-x: hidden;">
                                        <td style="text-align: center; padding: 12px;margin-left:20px; border-top: 1px solid #dee2e6;font-size:20px; ">
                                            <b>Symptoms
                                            </b>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr style=" overflow-x: hidden;">
                                        <td style="text-align: center; padding: 12px; border-top: 1px solid #dee2e6; ">
                                            {{ $prescription->symptoms }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 20px 24px 24px 24px;">
                        <div style="display: block; overflow-x: auto; -webkit-overflow-scrolling: touch;">
                            <table cellpadding="0" cellspacing="0" style="width: 100%;">
                                <tbody >
                                    <tr style="background-color: rgba(47,117,208, 0.1); color: #2f75d0; overflow-x: hidden;">
                                        <td style="text-align: center; padding: 12px;margin-left:20px; border-top: 1px solid #dee2e6;font-size:20px; ">
                                            <b>Diagnosis
                                            </b>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr style=" overflow-x: hidden;">
                                        <td style="text-align: center; padding: 12px; border-top: 1px solid #dee2e6; ">
                                            {{ $prescription->diagnosis}}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 20px 24px 24px 24px;">
                        <div style="display: block; overflow-x: auto; -webkit-overflow-scrolling: touch;">
                            <table cellpadding="0" cellspacing="0" style="width: 100%;">
                                <tbody >
                                    <tr style="background-color: rgba(47,117,208, 0.1); color: #2f75d0; overflow-x: hidden;">
                                        <td style="text-align: center; padding: 12px;margin-left:20px; border-top: 1px solid #dee2e6;font-size:20px; ">
                                            <b>Medications
                                            </b>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr style=" overflow-x: hidden;">
                                        <td style="text-align: left; padding: 12px; border-top: 1px solid #dee2e6; ">
                                            <b>Name</b>
                                        </td>
                                        <td style="text-align: end; padding: 12px; border-top: 1px solid #dee2e6;">
                                            <b>Notes</b>
                                        </td>
                                    </tr>
                                    @foreach ($medicines as $key=> $item)
                                        <tr>
                                            <td style="text-align: left; padding: 12px; border-top: 1px solid #dee2e6;width:50%; text-align-last:left;">
                                                <br/>
                                                {{$key+1 }}. {{ $item->name }}
                                            </td>
                                            <td style="text-align: end; padding: 12px; border-top: 1px solid #dee2e6; width:50%; text-align-last:right;">
                                                {{ $item->notes }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </td>
                </tr>
                @if ($test_reports->count() !==0 )
                    <tr>
                        <td style="padding: 20px 24px 24px 24px;">
                            <div style="display: block; overflow-x: auto; -webkit-overflow-scrolling: touch;">
                                <table cellpadding="0" cellspacing="0" style="width: 100%;">
                                    <tbody >
                                        <tr style="background-color: rgba(47,117,208, 0.1); color: #2f75d0; overflow-x: hidden;">
                                            <td style="text-align: center; padding: 12px;margin-left:20px; border-top: 1px solid #dee2e6;font-size:20px; ">
                                                <b>Test Reports
                                                </b>
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr style=" overflow-x: hidden;">
                                            <td style="text-align: left; padding: 12px; border-top: 1px solid #dee2e6; ">
                                                <b>Name</b>
                                            </td>
                                            <td style="text-align: end; padding: 12px; border-top: 1px solid #dee2e6;">
                                                <b>Notes</b>
                                            </td>
                                        </tr>
                                        @foreach ($test_reports as $key=> $item)
                                            <tr>
                                                <td style="text-align: left; padding: 12px; border-top: 1px solid #dee2e6;width:50%; text-align-last:left;">
                                                    <br/>
                                                    {{$key+1 }}. {{ $item->name }}
                                                </td>
                                                <td style="text-align: end; padding: 12px; border-top: 1px solid #dee2e6; width:50%; text-align-last:right;">
                                                    {{ $item->notes }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                @endif
                <tr>
                    <td style="padding: 15px 24px 15px; color: #8492a6; font-size: 16px; font-weight: 600;">
                        We look forward to seeing you soon!
                    </td>
                </tr>
                <tr>
                    <td style="padding: 15px 24px 15px; color: #8492a6;">
                        {{ config('app.name'); }} <br> Support Team
                    </td>
                </tr>
                <tr>
                    <td style="padding: 16px 8px; color: #8492a6; background-color: #f8f9fc; text-align: center;">
                        @php echo Config::get('app.footer_copy_rights') @endphp
                    </td>
                </tr>
            </tbody>
        </table>
​
    </div>
</body>
​
</html>
