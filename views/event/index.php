<?php

use edofre\fullcalendar\Fullcalendar;
use yii\helpers\Url;
use yii\web\View;

$this->registerJsFile('https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js', ['depends' => [\yii\web\JqueryAsset::class]]);
$this->registerCssFile('https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css');
$this->registerCss("
    .fc-agendaWeek-button, .fc-agendaDay-button {
        display: none;
    }
");
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
                    title: 'បង្កើតព្រឹត្តិការណ៍',
                    html: '<input id=\"swal-input1\" class=\"form-control\" placeholder=\"ឈ្មោះព្រឹត្តការណ៍\">' +
                          '<textarea id=\"swal-input2\" class=\"form-control mt-3\" placeholder=\"ពិពណ៌នា\" rows=\"5\"></textarea>',
                    focusConfirm: false,
                    confirmButtonText: 'យល់ព្រម',
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
                                    Swal.fire({
                                        title: 'ព្រឹត្តិការណ៍ត្រូវបានបង្កើត!',
                                        icon: 'success',
                                        confirmButtonText: 'យល់ព្រម' // Customize OK button text here
                                    });
                                },
                                error: function() {
                                    Swal.fire('មានកុំហុសក្នុងការបង្កើត!', '', 'error');
                                }
                            });
                        } else {
                            Swal.fire('ទាមទារឈ្មោះព្រឹត្តិការណ៍!', '', 'warning');
                        }
                    }
                });
            }
        "),
        'eventClick' => new \yii\web\JsExpression("
            function(event) {
                Swal.fire({
                    title: 'កែប្រែ ឬលុប​',
                    text: 'ចុចកែប្រែដើម្បីកែប្រែព្រឹត្តិការណ៍ ឬចុចលុបដើម្បីលុបព្រឹត្តិការណ៍',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'កែប្រែ',
                    cancelButtonText: 'លុប',
                    cancelButtonColor: '#d33'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'កែប្រែព្រឹត្តិការណ៍',
                            html: '<input id=\"swal-input1\" class=\"form-control\" value=\"' + event.title + '\" placeholder=\"ឈ្មោះព្រឹត្តការណ៍\">' +
                                  '<textarea id=\"swal-input2\" class=\"form-control mt-3\" placeholder=\"ពិពណ៌នា\" rows=\"5\">' + event.description + '</textarea>',
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
                                        url: '" . Url::to(['event/update']) . "?id=' + event.id,
                                        type: 'POST',
                                        data: {
                                            title: title,
                                            description: description,
                                            start: event.start.format('YYYY-MM-DD'),
                                            end: event.end ? event.end.format('YYYY-MM-DD') : event.start.format('YYYY-MM-DD'),
                                            _csrf: yii.getCsrfToken()
                                        },
                                        success: function(data) {
                                            $('#calendar').fullCalendar('refetchEvents');
                                            Swal.fire('ព្រឹត្តិការណ៌ត្រូវបានកែប្រែ!', '', 'success');
                                        },
                                        error: function() {
                                            Swal.fire('មានកុំហុសក្នុងការកែប្រែ!', '', 'error');
                                        }
                                    });
                                } else {
                                    Swal.fire('ទាមទារឈ្មោះព្រឹត្តិការណ៍!', '', 'warning');
                                }
                            }
                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        Swal.fire({
                            title: 'តើអ្នកប្រាកដឬទេ?',
                            text: 'ព្រឹត្តការណ៍នឹងត្រូវបានលុបមិនអាចបងក្រោយ!',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'ខ្ញុំយល់ព្រមលុប!',
                            cancelButtonText: 'បោះបង់',
                            cancelButtonColor: '#d33'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url: '" . Url::to(['event/delete']) . "?id=' + event.id,
                                    type: 'POST',
                                    success: function(result) {
                                        $('#calendar').fullCalendar('removeEvents', event.id);
                                        Swal.fire('លុប!', 'ព្រឹត្តិការណ៍របស់អ្នកត្រូវបានលុបដោយជោគជ័យ.', 'success');
                                    },
                                    error: function() {
                                        // Swal.fire('Error!', 'There was an error deleting the event.', 'error');
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
            title: 'ព្រឹត្តិការណ៍ត្រូវបានបង្កើត!',
            text: 'ព្រឹត្តិការណ៍ត្រូវបានបង្កើតដោយជោគជ័យ',
            icon: 'success',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'ខ្ញុំយល់ព្រម.'
        });
    ", View::POS_END);
}
