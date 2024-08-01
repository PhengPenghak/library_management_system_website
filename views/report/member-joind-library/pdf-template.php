<?php

use app\components\Formater;
use app\models\MemberJoinedLibrary;

$khmer_months = array(
    "មករា", "កុម្ភៈ", "មីនា", "មេសា", "ឧសភា", "មិថុនា",
    "កក្កដា", "សីហា", "កះញ្ញា", "តុលា", "វិច្ឆិកា", "ធ្នូ"
);
$view = new Formater();

$selectDate = Yii::$app->request->get("selectedDate");
$scheduleType = Yii::$app->request->get("scheduleType");
if (empty($scheduleType)) {
    $scheduleType = 0;
}
if ($selectDate) {
    $currentMonth = date('m', strtotime($selectDate));
    $currentYear = date('Y', strtotime($selectDate));
} else {
    $currentMonth = date('m');
    $currentYear = date('Y');
}

$totalSet = MemberJoinedLibrary::find()
    ->with('grade')
    ->andWhere(['MONTH(dateTime)' => $currentMonth])
    ->andWhere(['YEAR(dateTime)' =>  $currentYear])
    ->andWhere(['member_joined_library.status' => $scheduleType])
    ->all();
// echo "<pre>";
// print_r($totalSet);
// exit;
$totalSetYearItem = MemberJoinedLibrary::find()
    ->with('grade')
    ->andWhere(['YEAR(dateTime)' => $currentYear])
    ->andWhere(['member_joined_library.status' => $scheduleType])
    ->all();

$yearMonth1 = 0;
$yearMonthFemale1 = 0;
$yearMonth2 = 0;
$yearMonthFemale2 = 0;
$yearMonth3 = 0;
$yearMonthFemale3 = 0;
$yearMonth4 = 0;
$yearMonthFemale4 = 0;
$yearMonth5 = 0;
$yearMonthFemale5 = 0;
$yearMonth6 = 0;
$yearMonthFemale6 = 0;
$yearMonth7 = 0;
$yearMonthFemale7 = 0;
$yearMonth8 = 0;
$yearMonthFemale8 = 0;
$yearMonth9 = 0;
$yearMonthFemale9 = 0;
$yearMonth10 = 0;
$yearMonthFemale10 = 0;
$yearMonth11 = 0;
$yearMonthFemale11 = 0;
$yearMonth12 = 0;
$yearMonthFemale12 = 0;
foreach ($totalSetYearItem as $key => $val) {
    $val = (object)$val;
    $valMonth = date('m', strtotime($val['dateTime']));
    if ($valMonth == '01') {
        $yearMonth1 += $val['total_member'];
        $yearMonthFemale1 += $val['total_member_female'];
    }
    if ($valMonth == '02') {
        $yearMonth2 += $val['total_member'];
        $yearMonthFemale2 += $val['total_member_female'];
    }
    if ($valMonth == '03') {
        $yearMonth3 += $val['total_member'];
        $yearMonthFemale3 += $val['total_member_female'];
    }
    if ($valMonth == '04') {
        $yearMonth4 += $val['total_member'];
        $yearMonthFemale4 += $val['total_member_female'];
    }
    if ($valMonth == '05') {
        $yearMonth5 += $val['total_member'];
        $yearMonthFemale5 += $val['total_member_female'];
    }
    if ($valMonth == '06') {
        $yearMonth6 += $val['total_member'];
        $yearMonthFemale6 += $val['total_member_female'];
    }
    if ($valMonth == '07') {
        $yearMonth7 += $val['total_member'];
        $yearMonthFemale7 += $val['total_member_female'];
    }
    if ($valMonth == '08') {
        $yearMonth8 += $val['total_member'];
        $yearMonthFemale8 += $val['total_member_female'];
    }
    if ($valMonth == '09') {
        $yearMonth9 += $val['total_member'];
        $yearMonthFemale9 += $val['total_member_female'];
    }
    if ($valMonth == '10') {
        $yearMonth10 += $val['total_member'];
        $yearMonthFemale10 += $val['total_member_female'];
    }
    if ($valMonth == '11') {
        $yearMonth11 += $val['total_member'];
        $yearMonthFemale11 += $val['total_member_female'];
    }
    if ($valMonth == '12') {
        $yearMonth12 += $val['total_member'];
        $yearMonthFemale12 += $val['total_member_female'];
    }
}

// echo "
// <pre>";
// print_r($totalSetYearItem);
// exit;
$totalMember = array_fill(1, date('t'), 0);
$totalMemberFemale = array_fill(1, date('t'), 0);
$totalMember0 = array_fill(1, date('t'), 0);
$totalMemberFemale0 = array_fill(1, date('t'), 0);
$totalMember1 = array_fill(1, date('t'), 0);
$totalMemberFemale1 = array_fill(1, date('t'), 0);
$totalMember2 = array_fill(1, date('t'), 0);
$totalMemberFemale2 = array_fill(1, date('t'), 0);
$totalMember3 = array_fill(1, date('t'), 0);
$totalMemberFemale3 = array_fill(1, date('t'), 0);
$totalMember4 = array_fill(1, date('t'), 0);
$totalMemberFemale4 = array_fill(1, date('t'), 0);
$totalMember5 = array_fill(1, date('t'), 0);
$totalMemberFemale5 = array_fill(1, date('t'), 0);
$totalMember6 = array_fill(1, date('t'), 0);
$totalMemberFemale6 = array_fill(1, date('t'), 0);
$teacher = array_fill(1, date('t'), 0);
$teacherFemale = array_fill(1, date('t'), 0);
$association = array_fill(1, date('t'), 0);
$associationFemale = array_fill(1, date('t'), 0);

$totalMemberCount = 0;
$totalMemberFemaleCount = 0;
$totalMemberCount0 = 0;
$totalMemberFemaleCount0 = 0;
$totalMemberCount1 = 0;
$totalMemberFemaleCount1 = 0;
$totalMemberCount2 = 0;
$totalMemberFemaleCount2 = 0;
$totalMemberCount3 = 0;
$totalMemberFemaleCount3 = 0;
$totalMemberCount4 = 0;
$totalMemberFemaleCount4 = 0;
$totalMemberCount5 = 0;
$totalMemberFemaleCount5 = 0;
$totalMemberCount6 = 0;
$totalMemberFemaleCount6 = 0;
$teacherCount = 0;
$teacherFemaleCount = 0;
$associationCount = 0;
$associationFemaleCount = 0;

foreach ($totalSet as $member) {
    if ($member->dateTime !== null) {

        $day = date('j', strtotime($member->dateTime));
        if ($member->grade !== null) {
            if (preg_match('/មត្តេយ្យ/', $member->grade->title)) {
                if (isset($totalMember0[$day])) {
                    $totalMember0[$day] += $member->total_member;
                    $totalMemberFemale0[$day] += $member->total_member_female;
                    $totalMemberCount0 += $member->total_member;
                    $totalMemberFemaleCount0 += $member->total_member_female;
                }
            }
            if (preg_match('/^ថ្នាក់ទី\s*១/', $member->grade->title) || preg_match('/^ថ្នាក់ទី\s*1/', $member->grade->title)) {
                if (isset($totalMember1[$day])) {
                    $totalMember1[$day] += $member->total_member;
                    $totalMemberFemale1[$day] += $member->total_member_female;
                    $totalMemberCount1 += $member->total_member;
                    $totalMemberFemaleCount1 += $member->total_member_female;
                }
            }
            if (preg_match('/^ថ្នាក់ទី២/', $member->grade->title) || preg_match('/^ថ្នាក់ទី\s*2/', $member->grade->title)) {
                if (isset($totalMember2[$day])) {
                    $totalMember2[$day] += $member->total_member;
                    $totalMemberFemale2[$day] += $member->total_member_female;
                    $totalMemberCount2 += $member->total_member;
                    $totalMemberFemaleCount2 += $member->total_member_female;
                }
            }
            if (preg_match('/^ថ្នាក់ទី៣/', $member->grade->title) || preg_match('/^ថ្នាក់ទី\s*3/', $member->grade->title)) {
                if (isset($totalMember3[$day])) {
                    $totalMember3[$day] += $member->total_member;
                    $totalMemberFemale3[$day] += $member->total_member_female;
                    $totalMemberCount3 += $member->total_member;
                    $totalMemberFemaleCount3 += $member->total_member_female;
                }
            }
            if (preg_match('/^ថ្នាក់ទី៤/', $member->grade->title) || preg_match('/^ថ្នាក់ទី\s*4/', $member->grade->title)) {
                if (isset($totalMember4[$day])) {
                    $totalMember4[$day] += $member->total_member;
                    $totalMemberFemale4[$day] += $member->total_member_female;
                    $totalMemberCount4 += $member->total_member;
                    $totalMemberFemaleCount4 += $member->total_member_female;
                }
            }
            if (preg_match('/^ថ្នាក់ទី៥/', $member->grade->title) || preg_match('/^ថ្នាក់ទី\s*5/', $member->grade->title)) {
                if (isset($totalMember5[$day])) {
                    $totalMember5[$day] += $member->total_member;
                    $totalMemberFemale5[$day] += $member->total_member_female;
                    $totalMemberCount5 += $member->total_member;
                    $totalMemberFemaleCount5 += $member->total_member_female;
                }
            }
            if (preg_match('/^ថ្នាក់ទី៦/', $member->grade->title) || preg_match('/^ថ្នាក់ទី\s*6/', $member->grade->title)) {
                if (isset($totalMember6[$day])) {
                    $totalMember6[$day] += $member->total_member;
                    $totalMemberFemale6[$day] += $member->total_member_female;
                    $totalMemberCount6 += $member->total_member;
                    $totalMemberFemaleCount6 += $member->total_member_female;
                }
            }
        }
        if ($member->type_joined !== null) {
            if ($member->type_joined == 2) {
                if (isset($teacher[$day])) {
                    $teacher[$day] += $member->total_member;
                    $teacherFemale[$day] += $member->total_member_female;
                    $teacherCount += $member->total_member;
                    $teacherFemaleCount += $member->total_member_female;
                }
            }
            if ($member->type_joined == 3) {
                if (isset($association[$day])) {
                    $association[$day] += $member->total_member;
                    $associationFemale[$day] += $member->total_member_female;
                    $associationCount += $member->total_member;
                    $associationFemaleCount += $member->total_member_female;
                }
            }
            if (isset($totalMember[$day])) {
                $totalMember[$day] += $member->total_member;
                $totalMemberFemale[$day] += $member->total_member_female;
                $totalMemberCount += $member->total_member;
                $totalMemberFemaleCount += $member->total_member_female;
            }
        } else {
        }
    }
}
$daysInMonth = date('t');
// print_r($totalMemberMonth0);
// exit;

$totalSetYearItem = MemberJoinedLibrary::find()
    ->with('grade')
    ->andWhere(['YEAR(dateTime)' => $currentYear])
    ->andWhere(['member_joined_library.status' => $scheduleType])
    ->all();

$startMonth = 1;
$endMonth = 12;
$year =   date('Y', strtotime($selectDate));

$monthlyData = [];
for ($month = $startMonth; $month <= $endMonth; $month++) {
    $monthName = date('F', mktime(0, 0, 0, $month, 1, $year));
    $monthlyData[$monthName] = [
        'total_member' => 0,
        'total_member_female' => 0,
        'count' => 0,
        'total_member0' => 0,
        'total_member_female0' => 0,
        'count0' => 0,
        'total_member1' => 0,
        'total_member_female1' => 0,
        'count1' => 0,
        'total_member2' => 0,
        'total_member_female2' => 0,
        'count2' => 0,
        'total_member3' => 0,
        'total_member_female3' => 0,
        'count3' => 0,
        'total_member4' => 0,
        'total_member_female4' => 0,
        'count4' => 0,
        'total_member5' => 0,
        'total_member_female5' => 0,
        'count5' => 0,
        'total_member6' => 0,
        'total_member_female6' => 0,
        'count6' => 0,
        'total_member7' => 0,
        'total_member_female7' => 0,
        'count7' => 0,
        'total_member8' => 0,
        'total_member_female8' => 0,
        'count8' => 0,
        'total_member9' => 0,
        'total_member_female9' => 0,
        'count9' => 0,
    ];
}

$totalMembers = 0;
$totalCount = 0;

foreach ($totalSetYearItem as $item) {
    $month = date('n', strtotime($item->dateTime));
    $monthKey = date('F', mktime(0, 0, 0, $month, 1, $year));
    if (isset($monthlyData[$monthKey])) {
        $monthlyData[$monthKey]['total_member9'] += $item->total_member;
        $monthlyData[$monthKey]['total_member_female9'] += $item->total_member_female;
        if ($item->grade !== null) {
            if (preg_match('/^មត្តេយ្យ/', $item->grade->title)) {
                $monthlyData[$monthKey]['total_member0'] += $item->total_member;
                $monthlyData[$monthKey]['total_member_female0'] += $item->total_member_female;
                $monthlyData[$monthKey]['count0']++;
            }
            if (preg_match('/^ថ្នាក់ទី\s*១/', $item->grade->title) || preg_match('/^ថ្នាក់ទី\s*1/', $item->grade->title)) {
                $monthlyData[$monthKey]['total_member1'] += $item->total_member;
                $monthlyData[$monthKey]['total_member_female1'] += $item->total_member_female;
                $monthlyData[$monthKey]['count1']++;
            }
            if (preg_match('/^ថ្នាក់ទី\s*២/', $item->grade->title) || preg_match('/^ថ្នាក់ទី\s*2/', $item->grade->title)) {
                $monthlyData[$monthKey]['total_member2'] += $item->total_member;
                $monthlyData[$monthKey]['total_member_female2'] += $item->total_member_female;
                $monthlyData[$monthKey]['count2']++;
            }
            if (preg_match('/^ថ្នាក់ទី\s*៣/', $item->grade->title) || preg_match('/^ថ្នាក់ទី\s*3/', $item->grade->title)) {
                $monthlyData[$monthKey]['total_member3'] += $item->total_member;
                $monthlyData[$monthKey]['total_member_female3'] += $item->total_member_female;
                $monthlyData[$monthKey]['count3']++;
            }
            if (preg_match('/^ថ្នាក់ទី\s*៤/', $item->grade->title) || preg_match('/^ថ្នាក់ទី\s*4/', $item->grade->title)) {
                $monthlyData[$monthKey]['total_member4'] += $item->total_member;
                $monthlyData[$monthKey]['total_member_female4'] += $item->total_member_female;
                $monthlyData[$monthKey]['count4']++;
            }
            if (preg_match('/^ថ្នាក់ទី\s*៥/', $item->grade->title) || preg_match('/^ថ្នាក់ទី\s*5/', $item->grade->title)) {
                $monthlyData[$monthKey]['total_member5'] += $item->total_member;
                $monthlyData[$monthKey]['total_member_female5'] += $item->total_member_female;
                $monthlyData[$monthKey]['count5']++;
            }
            if (preg_match('/^ថ្នាក់ទី\s*៦/', $item->grade->title) || preg_match('/^ថ្នាក់ទី\s*6/', $item->grade->title)) {
                $monthlyData[$monthKey]['total_member6'] += $item->total_member;
                $monthlyData[$monthKey]['total_member_female6'] += $item->total_member_female;
                $monthlyData[$monthKey]['count6']++;
            }
        }
        if ($item->type_joined !== null) {
            if ($item->type_joined == 2) {
                $monthlyData[$monthKey]['total_member7'] += $item->total_member;
                $monthlyData[$monthKey]['total_member_female7'] += $item->total_member_female;
                $monthlyData[$monthKey]['count7']++;
            }
            if ($item->type_joined == 3) {
                $monthlyData[$monthKey]['total_member8'] += $item->total_member;
                $monthlyData[$monthKey]['total_member_female8'] += $item->total_member_female;
                $monthlyData[$monthKey]['count8']++;
            }
        }
        $monthlyData[$monthKey]['total_member'] += $item->total_member;
        $monthlyData[$monthKey]['total_member_female'] += $item->total_member_female;
        $monthlyData[$monthKey]['count']++;
    }
}
?>

<style>
    body {
        font-family: 'khmeros', sans-serif;
    }

    .table-responsive {
        width: 100%;
        margin-bottom: 1rem;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        -ms-overflow-style: -ms-autohiding-scrollbar;
    }

    /* .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
        } */

    table.table th,
    tbale.table td {
        padding: 0.75rem;
        vertical-align: top;
        border: 1px solid black;
    }

    /* .table thead th {
            vertical-align: bottom;
            border: 2px solid #dee2e6;
        } */

    /* .table tbody+tbody {
            border: 2px solid #dee2e6;
        } */

    .table-sm th,
    .table-sm td {
        padding: 0.3rem;
    }

    .thead- th {
        background-color: #f8f9fa;
    }

    /* tfoot tr td,
        tfoot tr th {
            border: none !important;
        } */

    table,
    th,
    td {
        border: 1px solid black;
        border-collapse: collapse;
        font-family: 'khmerOS';
        text-align: center;
    }
</style>
<div class="table-responsive">
    <?php
    $reportType = Yii::$app->request->get('reportType');
    if ($reportType == 1) { ?>
        <table class="table table-sm mb-0" style="border: none;">
            <thead class="thead-table">
                <tr class="text-center">
                    <th rowspan="4" style="vertical-align: middle;font-family: 'khmerOS';width: 40px;">ខែ</th>
                <tr>
                    <th colspan="20" class="text-center">ចំនួនសិស្សចូលអាន<?= $scheduleType == 1 ? 'តាមកាលវិភាគ' : 'សេរី' ?> </th>
                </tr>
                <tr class="text-center">
                    <th colspan="2">មតេ្តយ្យ</th>
                    <th colspan="2">ថ្នាក់ទី​១</th>
                    <th colspan="2">ថ្នាក់ទី​២</th>
                    <th colspan="2">ថ្នាក់ទី​៣</th>
                    <th colspan="2">ថ្នាក់ទី​៤</th>
                    <th colspan="2">ថ្នាក់ទី​៥</th>
                    <th colspan="2">ថ្នាក់ទី​៦</th>
                    <th colspan="2">គ្រូ</th>
                    <th colspan="2">សមាគមន៍</th>
                    <th colspan="2">សរុប</th>
                </tr>
                <tr class="text-center">
                    <th>សរ</th>
                    <th>ស</th>
                    <th>សរ</th>
                    <th>ស</th>
                    <th>សរ</th>
                    <th>ស</th>
                    <th>សរ</th>
                    <th>ស</th>
                    <th>សរ</th>
                    <th>ស</th>
                    <th>សរ</th>
                    <th>ស</th>
                    <th>សរ</th>
                    <th>ស</th>
                    <th>សរ</th>
                    <th>ស</th>
                    <th>សរ</th>
                    <th>ស</th>
                    <th>សរ</th>
                    <th>ស</th>
                </tr>
                </th>
                </tr>
            <tbody class="text-center">
                <?php


                foreach ($monthlyData as $month => $data) { ?>
                    <tr>
                        <td style="text-align: start;"><?= $view->maskMonthKHmer($month) ?></td>
                        <td><?= $data['total_member0'] == 0 ? '' : $data['total_member0'] ?></td>
                        <td><?= $data['total_member_female0'] == 0 ? '' : $data['total_member_female0'] ?></td>
                        <td><?= $data['total_member1'] == 0 ? '' : $data['total_member1'] ?></td>
                        <td><?= $data['total_member_female1'] == 0 ? '' : $data['total_member_female1'] ?></td>
                        <td><?= $data['total_member2'] == 0 ? '' : $data['total_member2'] ?></td>
                        <td><?= $data['total_member_female2'] == 0 ? '' : $data['total_member_female2'] ?></td>
                        <td><?= $data['total_member3'] == 0 ? '' : $data['total_member3'] ?></td>
                        <td><?= $data['total_member_female3'] == 0 ? '' : $data['total_member_female3'] ?></td>
                        <td><?= $data['total_member4'] == 0 ? '' : $data['total_member4'] ?></td>
                        <td><?= $data['total_member_female4'] == 0 ? '' : $data['total_member_female4'] ?></td>
                        <td><?= $data['total_member5'] == 0 ? '' : $data['total_member5'] ?></td>
                        <td><?= $data['total_member_female5'] == 0 ? '' : $data['total_member_female5'] ?></td>
                        <td><?= $data['total_member6'] == 0 ? '' : $data['total_member6'] ?></td>
                        <td><?= $data['total_member_female6'] == 0 ? '' : $data['total_member_female6'] ?></td>
                        <td><?= $data['total_member7'] == 0 ? '' : $data['total_member7'] ?></td>
                        <td><?= $data['total_member_female7'] == 0 ? '' : $data['total_member_female7'] ?></td>
                        <td><?= $data['total_member8'] == 0 ? '' : $data['total_member8'] ?></td>
                        <td><?= $data['total_member_female8'] == 0 ? '' : $data['total_member_female8'] ?></td>
                        <td><?= $data['total_member9'] == 0 ? '' : $data['total_member9'] ?></td>
                        <td style="height: 40px;"><?= $data['total_member_female9'] == 0 ? '' : $data['total_member_female9'] ?></td>

                    </tr>

                <?php }
                ?>
            </tbody>

            </thead>
            <tbody>

            </tbody>
        </table>
        <table style="margin-left: auto;margin-top: 30px; font-family: 'khmerOS';">

            <tr style="font-size: 14px;">
                <th style="text-align: start !important;padding: 5px 15px;width: 130px;font-size: 12px;">ថ្នាក់</th>
                <th style="text-align: start !important;padding: 5px 15px;font-size: 12px;">សិស្សសរុប</th>
                <th style="text-align: start !important;padding: 5px 15px;font-size: 12px;">សិស្សស្រីសរុប</th>
            </tr>
            <tr>
                <td style="text-align: start !important;padding: 5px 15px;">មតេ្តយ្យ</td>
                <td style="text-align: start !important;padding: 5px 15px;"><?= array_sum(array_column($monthlyData, 'total_member0')) == 0 ? '' : array_sum(array_column($monthlyData, 'total_member0')); ?></td>
                <td style="text-align: start !important;padding: 5px 15px;"><?= array_sum(array_column($monthlyData, 'total_member_female0')) == 0 ? '' : array_sum(array_column($monthlyData, 'total_member_female0')); ?></td>
            </tr>
            <tr>
                <td style="text-align: start !important;padding: 5px 15px;">ថា្នក់ទី ១</td>
                <td style="text-align: start !important;padding: 5px 15px;"><?= array_sum(array_column($monthlyData, 'total_member1')) == 0 ? '' : array_sum(array_column($monthlyData, 'total_member1')); ?></td>
                <td style="text-align: start !important;padding: 5px 15px;"><?= array_sum(array_column($monthlyData, 'total_member_female1')) == 0 ? '' : array_sum(array_column($monthlyData, 'total_member_female1')); ?></td>
            </tr>
            <tr>
                <td style="text-align: start !important;padding: 5px 15px;">ថា្នក់ទី ២</td>
                <td style="text-align: start !important;padding: 5px 15px;"><?= array_sum(array_column($monthlyData, 'total_member2')) == 0 ? '' : array_sum(array_column($monthlyData, 'total_member2')); ?></td>
                <td style="text-align: start !important;padding: 5px 15px;"><?= array_sum(array_column($monthlyData, 'total_member_female2')) == 0 ? '' : array_sum(array_column($monthlyData, 'total_member_female2')); ?></td>
            </tr>
            <tr>
                <td style="text-align: start !important;padding: 5px 15px;">ថា្នក់ទី ៣</td>
                <td style="text-align: start !important;padding: 5px 15px;"><?= array_sum(array_column($monthlyData, 'total_member3')) == 0 ? '' : array_sum(array_column($monthlyData, 'total_member3')); ?></td>
                <td style="text-align: start !important;padding: 5px 15px;"><?= array_sum(array_column($monthlyData, 'total_member_female3')) == 0 ? '' : array_sum(array_column($monthlyData, 'total_member_female3')); ?></td>
            </tr>
            <tr>
                <td style="text-align: start !important;padding: 5px 15px;">ថ្នាក់ទី ៤</td>
                <td style="text-align: start !important;padding: 5px 15px;"><?= array_sum(array_column($monthlyData, 'total_member4')) == 0 ? '' : array_sum(array_column($monthlyData, 'total_member4')); ?></td>
                <td style="text-align: start !important;padding: 5px 15px;"><?= array_sum(array_column($monthlyData, 'total_member_female4')) == 0 ? '' : array_sum(array_column($monthlyData, 'total_member_female4')); ?></td>
            </tr>
            <tr>
                <td style="text-align: start !important;padding: 5px 15px;">ថ្នាក់ទី ៥</td>
                <td style="text-align: start !important;padding: 5px 15px;"><?= array_sum(array_column($monthlyData, 'total_member5')) == 0 ? '' : array_sum(array_column($monthlyData, 'total_member5')); ?></td>
                <td style="text-align: start !important;padding: 5px 15px;"><?= array_sum(array_column($monthlyData, 'total_member_female5')) == 0 ? '' : array_sum(array_column($monthlyData, 'total_member_female5')); ?></td>
            </tr>
            <tr>
                <td style="text-align: start !important;padding: 5px 15px;">ថ្នាក់ទី ៦</td>
                <td style="text-align: start !important;padding: 5px 15px;"><?= array_sum(array_column($monthlyData, 'total_member6')) == 0 ? '' : array_sum(array_column($monthlyData, 'total_member6')); ?></td>
                <td style="text-align: start !important;padding: 5px 15px;"><?= array_sum(array_column($monthlyData, 'total_member_female6')) == 0 ? '' : array_sum(array_column($monthlyData, 'total_member_female6')); ?></td>
            </tr>
            <tr>
                <td style="text-align: start !important;padding: 5px 15px;">គ្រូ</td>
                <td style="text-align: start !important;padding: 5px 15px;"><?= array_sum(array_column($monthlyData, 'total_member7')) == 0 ? '' : array_sum(array_column($monthlyData, 'total_member7')); ?></td>
                <td style="text-align: start !important;padding: 5px 15px;"><?= array_sum(array_column($monthlyData, 'total_member_female7')) == 0 ? '' : array_sum(array_column($monthlyData, 'total_member_female7')); ?></td>
            </tr>
            <tr>
                <td style="text-align: start !important;padding: 5px 15px;">សមាគមន៍</td>
                <td style="text-align: start !important;padding: 5px 15px;"><?= array_sum(array_column($monthlyData, 'total_member8')) == 0 ? '' : array_sum(array_column($monthlyData, 'total_member8')); ?></td>
                <td style="text-align: start !important;padding: 5px 15px;"><?= array_sum(array_column($monthlyData, 'total_member_female8')) == 0 ? '' : array_sum(array_column($monthlyData, 'total_member_female8')); ?></td>
            </tr>

            <tr>
                <td style="text-align: start !important;padding: 5px 15px;">សរុប​​​​​ទាំង​​​​អស់</td>
                <td style="text-align: start !important;padding: 5px 15px;"><?= array_sum(array_column($monthlyData, 'total_member9')) == 0 ? '' : array_sum(array_column($monthlyData, 'total_member9')); ?></td>
                <td style="text-align: start !important;padding: 5px 15px;"><?= array_sum(array_column($monthlyData, 'total_member_female9')) == 0 ? '' : array_sum(array_column($monthlyData, 'total_member_female9')); ?></td>
            </tr>

        </table>
    <?php } else { ?>

        <table class="table table-sm mb-0" style="border: none;">
            <thead class="thead-table">
                <tr class="text-center">
                    <th rowspan="4" style="vertical-align: middle;font-family: 'khmerOS';width: 10px;">ថ្ងៃ​</th>
                <tr>
                    <th colspan="20" class="text-center">ចំនួនសិស្សចូលអាន<?= $scheduleType == 1 ? 'តាមកាលវិភាគ' : 'សេរី' ?></th>
                </tr>
                <tr class="text-center">
                    <th colspan="2">មតេ្តយ្យ</th>
                    <th colspan="2">ថ្នាក់ទី​១</th>
                    <th colspan="2">ថ្នាក់ទី​២</th>
                    <th colspan="2">ថ្នាក់ទី​៣</th>
                    <th colspan="2">ថ្នាក់ទី​៤</th>
                    <th colspan="2">ថ្នាក់ទី​៥</th>
                    <th colspan="2">ថ្នាក់ទី​៦</th>
                    <th colspan="2">គ្រូ</th>
                    <th colspan="2">សមាគមន៍</th>
                    <th colspan="2">សរុប</th>
                </tr>
                <tr class="text-center">
                    <th>សរ</th>
                    <th>ស</th>
                    <th>សរ</th>
                    <th>ស</th>
                    <th>សរ</th>
                    <th>ស</th>
                    <th>សរ</th>
                    <th>ស</th>
                    <th>សរ</th>
                    <th>ស</th>
                    <th>សរ</th>
                    <th>ស</th>
                    <th>សរ</th>
                    <th>ស</th>
                    <th>សរ</th>
                    <th>ស</th>
                    <th>សរ</th>
                    <th>ស</th>
                    <th>សរ</th>
                    <th>ស</th>
                </tr>
                </th>
                </tr>
            <tbody class="text-center">
                <?php
                for ($day = 1; $day <= $daysInMonth; $day++) { ?>
                    <tr>
                        <td><?= $day ?></td>
                        <td>
                            <?= $totalMember0[$day] == 0 ? '' : $totalMember0[$day]  ?>
                        </td>
                        <td>
                            <?= $totalMemberFemale0[$day] == 0 ? '' : $totalMemberFemale0[$day]  ?>
                        </td>
                        <td>
                            <?= $totalMember1[$day] == 0 ? '' : $totalMember1[$day]  ?>
                        </td>
                        <td>
                            <?= $totalMemberFemale1[$day] == 0 ? '' : $totalMemberFemale1[$day]  ?>
                        </td>
                        <td>
                            <?= $totalMember2[$day] == 0 ? '' : $totalMember2[$day]  ?>
                        </td>
                        <td>
                            <?= $totalMemberFemale2[$day] == 0 ? '' : $totalMemberFemale2[$day]  ?>
                        </td>
                        <td>
                            <?= $totalMember3[$day] == 0 ? '' : $totalMember3[$day]  ?>
                        </td>
                        <td>
                            <?= $totalMemberFemale3[$day] == 0 ? '' : $totalMemberFemale3[$day]  ?>
                        </td>
                        <td>
                            <?= $totalMember4[$day] == 0 ? '' : $totalMember4[$day]  ?>
                        </td>
                        <td>
                            <?= $totalMemberFemale4[$day] == 0 ? '' : $totalMemberFemale4[$day]  ?>
                        </td>
                        <td>
                            <?= $totalMember5[$day] == 0 ? '' : $totalMember5[$day]  ?>
                        </td>
                        <td>
                            <?= $totalMemberFemale5[$day] == 0 ? '' : $totalMemberFemale5[$day]  ?>
                        </td>
                        <td>
                            <?= $totalMember6[$day] == 0 ? '' : $totalMember6[$day]  ?>
                        </td>
                        <td>
                            <?= $totalMemberFemale6[$day] == 0 ? '' : $totalMemberFemale6[$day]  ?>
                        </td>
                        <td>
                            <?= $teacher[$day] == 0 ? '' : $teacher[$day]  ?>
                        </td>
                        <td>
                            <?= $teacherFemale[$day] == 0 ? '' : $teacherFemale[$day]  ?>
                        </td>
                        <td>
                            <?= $association[$day] == 0 ? '' : $association[$day]  ?>
                        </td>
                        <td>
                            <?= $associationFemale[$day] == 0 ? '' : $associationFemale[$day]  ?>
                        </td>

                        <td>
                            <?= $totalMember[$day] == 0 ? '' : $totalMember[$day]  ?>
                        </td>
                        <td>
                            <?= $totalMemberFemale[$day] == 0 ? '' : $totalMemberFemale[$day]  ?>
                        </td>
                    </tr>
                <?php  } ?>
            </tbody>

            </thead>
            <tbody>

            </tbody>
        </table>

        <table style="margin-left: auto;margin-top: 30px; font-family: 'khmerOS';">

            <tr style="font-size: 14px;">
                <th style="text-align: start !important;padding: 5px 15px;width: 130px;font-size: 12px;">ថ្នាក់</th>
                <th style="text-align: start !important;padding: 5px 15px;font-size: 12px;">សិស្សសរុប</th>
                <th style="text-align: start !important;padding: 5px 15px;font-size: 12px;">សិស្សស្រីសរុប</th>
            </tr>
            <tr>
                <td style="text-align: start !important;padding: 5px 15px;">មតេ្តយ្យ</td>
                <td style="text-align: start !important;padding: 5px 15px;"><?= $totalMemberCount0 == 0 ? '' : $totalMemberCount0 ?></td>
                <td style="text-align: start !important;padding: 5px 15px;"><?= $totalMemberFemaleCount0 == 0 ? '' : $totalMemberFemaleCount0 ?></td>
            </tr>
            <tr>
                <td style="text-align: start !important;padding: 5px 15px;">ថា្នក់ទី ១</td>
                <td style="text-align: start !important;padding: 5px 15px;"><?= $totalMemberCount1 == 0 ? '' : $totalMemberCount1 ?></td>
                <td style="text-align: start !important;padding: 5px 15px;"><?= $totalMemberFemaleCount1 == 0 ? '' : $totalMemberFemaleCount1 ?></td>
            </tr>
            <tr>
                <td style="text-align: start !important;padding: 5px 15px;">ថា្នក់ទី ២</td>
                <td style="text-align: start !important;padding: 5px 15px;"><?= $totalMemberCount2 == 0 ? '' : $totalMemberCount2 ?></td>
                <td style="text-align: start !important;padding: 5px 15px;"><?= $totalMemberFemaleCount2 == 0 ? '' : $totalMemberFemaleCount2 ?></td>
            </tr>
            <tr>
                <td style="text-align: start !important;padding: 5px 15px;">ថា្នក់ទី ៣</td>
                <td style="text-align: start !important;padding: 5px 15px;"><?= $totalMemberCount3 == 0 ? '' : $totalMemberCount3 ?></td>
                <td style="text-align: start !important;padding: 5px 15px;"><?= $totalMemberFemaleCount3 == 0 ? '' : $totalMemberFemaleCount3 ?></td>
            </tr>
            <tr>
                <td style="text-align: start !important;padding: 5px 15px;">ថ្នាក់ទី ៤</td>
                <td style="text-align: start !important;padding: 5px 15px;"><?= $totalMemberCount4 == 0 ? '' : $totalMemberCount4 ?></td>
                <td style="text-align: start !important;padding: 5px 15px;"><?= $totalMemberFemaleCount4 == 0 ? '' : $totalMemberFemaleCount4 ?></td>
            </tr>
            <tr>
                <td style="text-align: start !important;padding: 5px 15px;">ថ្នាក់ទី ៥</td>
                <td style="text-align: start !important;padding: 5px 15px;"><?= $totalMemberCount5 == 0 ? '' : $totalMemberCount5 ?></td>
                <td style="text-align: start !important;padding: 5px 15px;"><?= $totalMemberFemaleCount5 == 0 ? '' : $totalMemberFemaleCount5 ?></td>
            </tr>
            <tr>
                <td style="text-align: start !important;padding: 5px 15px;">ថ្នាក់ទី ៦</td>
                <td style="text-align: start !important;padding: 5px 15px;"><?= $totalMemberCount6 == 0 ? '' : $totalMemberCount6 ?></td>
                <td style="text-align: start !important;padding: 5px 15px;"><?= $totalMemberFemaleCount6 == 0 ? '' : $totalMemberFemaleCount6 ?></td>
            </tr>
            <tr>
                <td style="text-align: start !important;padding: 5px 15px;">គ្រូ</td>
                <td style="text-align: start !important;padding: 5px 15px;"><?= $teacherCount == 0 ? '' : $teacherCount ?></td>
                <td style="text-align: start !important;padding: 5px 15px;"><?= $teacherFemaleCount == 0 ? '' : $teacherFemaleCount ?></td>
            </tr>
            <tr>
                <td style="text-align: start !important;padding: 5px 15px;">សមាគមន៍</td>
                <td style="text-align: start !important;padding: 5px 15px;"><?= $associationCount == 0 ? '' : $associationCount ?></td>
                <td style="text-align: start !important;padding: 5px 15px;"><?= $associationFemaleCount == 0 ? '' : $associationFemaleCount ?></td>
            </tr>

            <tr>
                <td style="text-align: start !important;padding: 5px 15px;">សរុប​​​​​ទាំង​​​​អស់</td>
                <td style="text-align: start !important;padding: 5px 15px;"><?= $totalMemberCount == 0 ? '' : $totalMemberCount ?></td>
                <td style="text-align: start !important;padding: 5px 15px;"><?= $totalMemberFemaleCount == 0 ? '' : $totalMemberFemaleCount ?></td>
            </tr>

        </table>

    <?php }
    ?>
</div>
<?php
$script = <<<JS
$(document).load();
JS;
$this->registerJs($script);
?>