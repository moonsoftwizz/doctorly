/*
 Template Name: Doctorly - Patient Management System
 Author: Lndinghub(Themesbrand)
 File: Calendar Init
 */


$(document).ready(function() {
    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();

    /*  className colors

     className: default(transparent), important(red), chill(pink), success(green), info(blue)

     */


    /* initialize the external events
     -----------------------------------------------------------------*/

    $('#external-events div.external-event').each(function() {

        // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
        // it doesn't need to have a start or end
        var eventObject = {
            title: $.trim($(this).text()) // use the element's text as the event title
        };

        // store the Event Object in the DOM element so we can get to it later
        $(this).data('eventObject', eventObject);

        // make the event draggable using jQuery UI
        $(this).draggable({
            zIndex: 999,
            revert: true, // will cause the event to go back to its
            revertDuration: 0 //  original position after the drag
        });

    });


    /* initialize the calendar
     -----------------------------------------------------------------*/

    var SITEURL = "{{url('/')}}"
    var calendar = $('#calendar').fullCalendar({

        header: {
            left: 'title',
            //center: 'agendaDay,agendaWeek,month',
            right: 'prev,next'
        },

        editable: true,
        firstDay: 1, //  1(Monday) this can be changed to 0(Sunday) for the USA system
        selectable: true,
        longPressDelay: 1,
        defaultView: 'month',
        axisFormat: 'h:mm',
        columnFormat: {
            month: 'ddd', // Mon
            week: 'ddd d', // Mon 7
            day: 'dddd M/d', // Monday 9/7
            agendaDay: 'dddd d'
        },
        titleFormat: {
            month: 'MMMM YYYY', // September 2009
            week: "MMMM YYYY", // September 2009
            day: 'MMMM YYYY' // Tuesday, Sep 8, 2009
        },
        events: SITEURL + "/cal-appointment-show",
        displayEventTime: true,
        eventRender: function(event, element, view) {
            if (event.allDay === 'true') {
                event.allDay = true;
            } else {
                event.allDay = false;
            }
        },

        allDaySlot: false,
        selectHelper: true,
        select: function(start, end, allDay) {
            var dt = start.format('YYYY/MM/DD');
            $('#selected_date').html(start.format('DD MMM, YYYY'));
            $('#appointment_list').hide();
            $('#new_list').show();
            $.ajax({
                method: 'get',
                url: aplist_url,
                data: { date: dt },
                dataType: 'json',
                success: function(response) {
                    if (response.status == 'error') {
                        $('#new_list').html('<h6>' + response.message + start.format('DD MMM, YYYY') + '</h6>');
                    } else {
                        var t = 1;
                        var data = response.appointments;
                        var list = '<table class="table table-bordered dt-responsive nowrap datatable" style="border-collapse: collapse; border-spacing: 0; width: 100%;"><thead class="thead-light"><tr><th>Sr.No</th>';
                        if (response.role == 'doctor') {
                            list += '<th>Patient Name</th>';
                            list += '<th>Patient Number</th>';
                        } else if (response.role == 'patient') {
                            list += '<th>Doctor Name</th>';
                            list += '<th>Doctor Number</th>';
                        } else {
                            list += '<th>Patient Name</th><th>Doctor Name</th>';
                            list += '<th>Patient Number</th>';
                        }

                        list += '<th>Time</th></tr></thead><tbody>';
                        if (response.role == 'receptionist') {

                            $.each(data, function(i, appointments) {
                                let DFirst_name = appointments.doctor.first_name;
                                let DLast_name = appointments.doctor.last_name;
                                let PFirst_name = appointments.patient.first_name;
                                let PLast_name = appointments.patient.last_name;
                                let from = appointments.time_slot.from;
                                let to = appointments.time_slot.to;
                                let mobile = appointments.patient.mobile
                                list += "<tr><td>" + t + "</td><td>" + DFirst_name + "&nbsp;" + DLast_name + "</td><td>" + PFirst_name + "&nbsp;" + PLast_name + "</td><td>" + mobile + "</td><td>" + from + " to " + to +
                                    "</td></td>";
                                t++;
                            });

                        } else if (response.role == 'patient') {
                            $.each(data, function(i, appointments) {
                                let first_name = appointments.doctor.first_name;
                                let last_name = appointments.doctor.last_name;
                                let from = appointments.time_slot.from;
                                let to = appointments.time_slot.to;
                                let mobile = appointments.doctor.mobile
                                list += "<tr><td>" + t + "</td><td>" + first_name + "&nbsp;" + last_name + "</td><td>" + mobile + "</td><td>" + from + " to " + to +
                                    "</td></td>";
                                t++;
                            });

                        } else if (response.role == 'doctor') {
                            $.each(data, function(i, appointments) {
                                let first_name = appointments.patient.first_name;
                                let last_name = appointments.patient.last_name;
                                let from = appointments.time_slot.from;
                                let to = appointments.time_slot.to;
                                let mobile = appointments.patient.mobile
                                list += "<tr><td>" + t + "</td><td>" + first_name + "&nbsp;" + last_name + "</td><td>" + mobile + "</td><td>" + from + " to " + to +
                                    "</td></td>";
                                t++;
                            });

                        }
                        list += "</tbody></table>";

                        $('#new_list').html(list);
                    }
                },
                error: function() {
                    console.log('Errors...Something went wrong!!!!');
                }
            });
            calendar.fullCalendar('unselect');
        },
        events: function(start, end, timezone, callback) {
            var start = moment(start, 'DD.MM.YYYY').format('YYYY-MM-DD')
            var end = moment(end, 'DD.MM.YYYY').format('YYYY-MM-DD')
                // console.log(start);
            $.ajax({
                type: "get",
                url: "/cal-appointment-show",
                data: {
                    start: start,
                    end: end,
                    title: 'appointment',
                },
                success: function(response) {
                    var events = [];
                    $(response.appointments).each(function(key, value) {
                        events.push({
                            title: value.total_appointment + ' Appointment',
                            start: value.appointment_date,
                            end: value.appointment_date,
                            className: 'bg-success text-white',
                        });
                    });
                    callback(events);
                },
                error: function(response) {
                    console.log(response);
                }
            });
        },
    });

});