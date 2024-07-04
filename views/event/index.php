<?php

use edofre\fullcalendar\Fullcalendar;
use yii\helpers\Url;
use yii\web\View;

$this->registerJsFile('https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js', ['depends' => [\yii\web\JqueryAsset::class]]);
$this->registerCssFile('https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css');

echo Fullcalendar::widget([
    'clientOptions' => [
        'header' => [
            'left' => 'prev,next today',
            'center' => 'title',
            'right' => 'month,agendaWeek,agendaDay',
        ],
        'locale' => 'kh', // Set the locale to Khmer
        'events' => Url::to(['event/events']),
        'selectable' => true,
        'select' => new \yii\web\JsExpression("
            function(start, end) {
                var startDate = moment(start).format('YYYY-MM-DD');
                var endDate = moment(end).format('YYYY-MM-DD');
                
                Swal.fire({
                    title: 'Create Event',
                    html: '<input id=\"swal-input1\" class=\"swal2-input\" placeholder=\"Event Title\">' +
                          '<textarea id=\"swal-input2\" class=\"swal2-textarea\" placeholder=\"Event Description\"></textarea>',
                    focusConfirm: false,
                    preConfirm: () => {
                        return [
                            document.getElementById('swal-input1').value,
                            document.getElementById('swal-input2').value
                        ]
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        var title = result.value[0];
                        var description = result.value[1];
                        
                        if (title) {
                            $.ajax({
                                url: '" . Url::to(['event/create']) . "',
                                type: 'POST',
                                data: {
                                    title: title,
                                    description: description,
                                    start: startDate,
                                    end: endDate,
                                    _csrf: yii.getCsrfToken()
                                },
                                success: function(data) {
                                    $('#calendar').fullCalendar('refetchEvents');
                                    Swal.fire('Event Created!', '', 'success');
                                },
                                error: function() {
                                    Swal.fire('Error creating event!', '', 'error');
                                }
                            });
                        } else {
                            Swal.fire('Title is required!', '', 'warning');
                        }
                    }
                });
            }
        "),
        'eventClick' => new \yii\web\JsExpression("
            function(event) {
                Swal.fire({
                    title: 'Edit or Delete Event?',
                    text: 'Click Edit to update the event or Delete to remove it.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Edit',
                    cancelButtonText: 'Delete',
                    cancelButtonColor: '#d33'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '" . Url::to(['event/update']) . "?id=' + event.id;
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        Swal.fire({
                            title: 'Are you sure?',
                            text: 'This event will be permanently deleted!',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Yes, delete it!',
                            cancelButtonText: 'Cancel',
                            cancelButtonColor: '#d33'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url: '" . Url::to(['event/delete']) . "?id=' + event.id,
                                    type: 'POST',
                                    success: function(result) {
                                        $('#calendar').fullCalendar('removeEvents', event.id);
                                        Swal.fire('Deleted!', 'Your event has been deleted.', 'success');
                                    },
                                    error: function() {
                                        Swal.fire('Error!', 'There was an error deleting the event.', 'error');
                                    }
                                });
                            }
                        });
                    }
                });
            }
        "),
    ],
]);

$session = Yii::$app->session;
if ($session->hasFlash('eventCreated')) {
    $this->registerJs("
        Swal.fire({
            title: 'Event Created!',
            text: 'Event has been created successfully.',
            icon: 'success',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'I Got it.'
        });
    ", View::POS_END);
}
