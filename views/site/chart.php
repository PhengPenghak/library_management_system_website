<?php
/* @var $this yii\web\View */

$this->title = 'Books Borrowed per Month';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="borrow-book-index">

    <h1><?= \yii\helpers\Html::encode($this->title) ?></h1>

    <canvas id="borrowBookChart" width="400" height="200"></canvas>

    <?php
    $this->registerJs(
        <<<JS
    $(document).ready(function() {
        $.ajax({
            url: '/borrow-book/chart-data', // URL to the action that provides chart data
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var ctx = document.getElementById('borrowBookChart').getContext('2d');
                var borrowBookChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: data.months,
                        datasets: [{
                            label: 'Books Borrowed',
                            data: data.counts,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            },
            error: function(xhr, status, error) {
                console.error('Failed to fetch chart data:', error);
            }
        });
    });
    JS
    );
    ?>

</div>