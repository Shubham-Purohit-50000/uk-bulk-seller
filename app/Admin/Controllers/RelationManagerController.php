<?php

namespace App\Admin\Controllers;

use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use \App\Models\User;
use Admin;

class RelationManagerController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'RelationManager';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User());

        $grid->model()->whereHas('roles', function ($query) {
            $query->where('name', 'relational-manager'); // Change role as per requirement
        });

        $grid->column('id', __('Id'));
        $grid->column('name', __('Name'));
        $grid->column('email', __('Email'));
        $grid->column('phone', __('Phone'));
        $grid->column('commission', __('Commission in %'));
        $grid->column('address', __('Address'));
        $grid->column('created_at', __('Created at'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(User::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('email', __('Email'));
        $show->field('phone', __('Phone'));
        $show->field('commission', __('Commision in %'));
        $show->field('address', __('Address'));
        $show->field('created_at', __('Created at'));

        $show->panel()
        ->tools(function ($tools) use ($show) {
            $user = $show->getModel(); // Get the model instance
            $userId = $user->id; // Extract the ID

            Admin::css('https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css');

            Admin::script("
                function loadScript(url, callback) {
                    var script = document.createElement('script');
                    script.src = url;
                    script.type = 'text/javascript';
                    script.onload = callback;
                    document.head.appendChild(script);
                }

                function initializeCalendarAndMap() {
                    if (typeof jQuery == 'undefined') {
                        loadScript('https://code.jquery.com/jquery-3.6.0.min.js', function () {
                            loadFullCalendar();
                        });
                    } else {
                        loadFullCalendar();
                    }
                }

                function loadFullCalendar() {
                    if (typeof FullCalendar == 'undefined') {
                        loadScript('https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js', function () {
                            initCalendar();
                        });
                    } else {
                        initCalendar();
                    }
                }

                function initCalendar() {
                    $(document).ready(function () {
                        var calendarEl = document.getElementById('attendance-calendar');
                        if (!calendarEl) return;

                        console.log('Calendar initialized');

                        var calendar = new FullCalendar.Calendar(calendarEl, {
                            initialView: 'dayGridMonth',
                            events: '/admin/get-attendance-events/' + $userId,  // Load attendance events
                            
                            // Allow clicking on all dates
                            dateClick: function(info) {
                                var date = info.dateStr; // Get the clicked date
                                console.log('Date clicked : ', date);
                                loadTrackingData($userId, date);
                            },

                            eventClick: function(info) { // When clicking on an event
                                var date = info.event.startStr;
                                console.log('Event clicked on : ', date);
                                loadTrackingData($userId, date);
                            }
                        });

                        calendar.render();
                    });
                }


                function loadTrackingData(userId, date) {
                    console.log('Fetching tracking data for:', userId, date);

                    $.get('/admin/get-tracking-data/' + userId + '/' + date, function (data) {
                        console.log('Tracking Data:', data);

                        if (!data.length) {
                            alert('No tracking data available.');
                            return;
                        }

                        setTimeout(function () {
                            var mapEl = document.getElementById('map');
                            if (!mapEl) return;

                            if (window.mapInstance) {
                                window.mapInstance.remove();
                            }

                            // Initialize map centered at the first data point
                            window.mapInstance = L.map('map').setView(
                                [parseFloat(data[0].latitude), parseFloat(data[0].longitude)], 12
                            );

                            // Add OpenStreetMap tile layer
                            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                attribution: '&copy; OpenStreetMap contributors'
                            }).addTo(window.mapInstance);

                            var latLngs = [];

                            data.forEach(function (point, index) {
                                let lat = parseFloat(point.latitude);
                                let lng = parseFloat(point.longitude);

                                if (!isNaN(lat) && !isNaN(lng)) {
                                    latLngs.push([lat, lng]); // Add to polyline path

                                    let popupContent = 
                                        '<b>Stopped Here</b><br>' +
                                        '<b>From:</b> ' + new Date(point.start_time).toLocaleTimeString() + '<br>' +
                                        '<b>To:</b> ' + new Date(point.end_time).toLocaleTimeString() + '<br>' +
                                        '<b>Duration:</b> ' + point.duration + ' minutes';


                                    if (point.duration === 0) {
                                        popupContent = `<b>Quick Stop</b>`;
                                    }

                                    let marker = L.marker([lat, lng])
                                        .addTo(window.mapInstance)
                                        .bindPopup(popupContent);

                                    // Open popup only for the first marker to show some info initially
                                    if (index === 0) {
                                        marker.openPopup();
                                    }
                                }
                            });

                            // Draw polyline to show travel path
                            if (latLngs.length > 1) {
                                L.polyline(latLngs, { color: 'blue', weight: 4, opacity: 0.7 }).addTo(window.mapInstance);
                            }
                        }, 500);
                    }).fail(function () {
                        console.error('Failed to fetch tracking data');
                    });
                }


                initializeCalendarAndMap();
            ");
        });

        $show->field('attendance_calendar')->as(function () {
            return '<div id="attendance-calendar" style="width: 100%; height: 400px;"></div>';
        })->unescape();
        
        $show->field('map')->as(function () {
            return '<div id="map" style="width: 100%; height: 400px;"></div>';
        })->unescape();

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new User());

        $form->text('name', __('Name'));
        $form->email('email', __('Email'));
        $form->password('password', __('Password'));
        $form->phonenumber('phone','Phone no.')->options(['mask' => '999 9999 9999', 'mask' => '+91 99 9999 9999']);
        $form->decimal('commission', __('Comission in %'));
        $form->textarea('address', __('Address'));

        $form->saving(function (Form $form) {
            $form->model()->assignRole('relational-manager');
        });

        return $form;
    }
}
