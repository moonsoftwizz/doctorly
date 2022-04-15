<!doctype html>
<html>
​
<head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Payment complete successfully  | {{ config('app.name'); }}</title>
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
                                        Hello, <b>{{ $invoice->patient->first_name .' '.$invoice->patient->last_name }}</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>Doctor Details: </b></td>
                                    <td><b>Invoice Date&Time: </b></td>
                                </tr>
                                <tr>
                                    <td><b>Name: </b>{{ $invoice->doctor->first_name .' '. $invoice->doctor->last_name}}</td>
                                    <td>{{ $invoice->created_at }}</td>
                                </tr>
                                <tr>
                                    <td><b>Contact: </b>{{ $invoice->doctor->mobile }}</td>
                                    <td><b>Appointment Date&Time: </b></td>
                                </tr>
                                <tr>
                                    <td><b>Email: </b>{{ $invoice->doctor->email }}</td>
                                    <td>{{ $invoice->appointment->appointment_date}}</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>{{ $invoice->appointment->timeSlot->from .' to '.$invoice->appointment->timeSlot->to }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 30px 24px 10px; color: #161c2d; font-size: 18px; font-weight: 600;">
                        Payment complete successfully
                    </td>
                </tr>
                <tr>
                    <td style="padding: 20px 24px 24px 24px;">
                        <div style="display: block; overflow-x: auto; -webkit-overflow-scrolling: touch;">
                            <table cellpadding="0" cellspacing="0" style="width: 100%;">
                                <tbody>
                                    <tr style="background-color: rgba(47,117,208, 0.1); color: #2f75d0; overflow-x: hidden;">
                                        <td style="text-align: left; padding: 12px; border-top: 1px solid #dee2e6; ">
                                            <b>Title</b>
                                        </td>
                                        <td style="text-align: end; padding: 12px; border-top: 1px solid #dee2e6;">
                                            <b>Amount</b>
                                        </td>
                                    </tr>
                                    @php
                                        $discount_amount = 0;
                                    @endphp
                                    @if($invoice->invoice_detail)
                                        @php
                                            $sub_total = 0;
                                        @endphp
                                        @foreach ($invoice->invoice_detail as $key=> $item)
                                            <tr>
                                                <td style="text-align: left; padding: 12px; border-top: 1px solid #dee2e6;">
                                                        <br/>
                                                        {{$key+1 }}.
                                                    <b>{{ $item->title }}</b>
                                                </td>
                                                <td style="text-align: end; padding: 12px; border-top: 1px solid #dee2e6;">
                                                    ${{ $item->amount }}
                                                </td>
                                            </tr>
                                        @endforeach
                                        @php
                                            $sub_total += $item->amount;
                                        @endphp
                                    @endif
                                    <tr>
                                        <td style="text-align: center; padding: 12px; border-top: 1px solid #dee2e6;">
                                            <strong>{{ __("Sub Total") }}</strong>
                                        </td>
                                        <td style="text-align: end; padding: 12px; border-top: 1px solid #dee2e6;">
                                            ${{ $item->amount }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: center; padding: 12px; ">
                                            <strong>{{ __("Tax (5%)") }}</strong>
                                        </td>
                                        <td style="text-align: end; padding: 12px;;">
                                            ${{ ($sub_total * 5) / 100 }}
                                        </td>
                                    </tr>
                                    <tr style="background-color: rgba(47,117,208, 0.1); color: #2f75d0; overflow-x: hidden;">
                                        <th scope="row" style="text-align: center; padding: 12px; border-top: 1px solid rgba(47,117,208, 0.1);">
                                            Total
                                        </th>
                                        <td style="text-align: end; font-weight: 700; font-size: 18px; padding: 12px; border-top: 1px solid rgba(47,117,208, 0.1);">
                                            ${{ $sub_total + ($sub_total * 5) / 100 }}
                                        </td>
                                    </tr>

                                </tbody>
                            </table>

                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 15px 24px 15px;  font-size: 16px;">
                        <b>Payment Method: </b>{{ $invoice->payment_mode }}
                    </td>
                </tr>

                <tr>
                    <td style="padding: 15px 24px 15px;  font-size: 16px;">
                        <b>Payment Status: </b>{{ $invoice->payment_status }}
                    </td>
                </tr>
                @if ($invoice->transaction != Null)
                    <td style="padding: 15px 24px 15px;  font-size: 16px;">
                        <b>Order Id: </b>{{ $invoice->transaction->order_id }}<br>
                        <b>Transaction No: </b>{{ $invoice->transaction->transaction_no }}<br>
                        <b>Payment Method: </b>{{ $invoice->transaction->payment_method }}<br>
                    </td>
                @endif
                <tr>
                    <td style="padding: 15px 24px 15px; color: #8492a6; font-size: 16px; font-weight: 600;">
                        Thank you for your payment!!
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
