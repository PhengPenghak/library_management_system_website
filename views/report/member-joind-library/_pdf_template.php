<?php
$month_and_year = Yii::$app->request->get('month_and_year');
$from_date = Yii::$app->request->get('from_date');
$to_date = Yii::$app->request->get('to_date');
$status = Yii::$app->request->get('status');


if ($month_and_year  == 0) { ?>
    <?php
    $gradeNames = ["មត្តេយ្យ", "ថ្នាក់ទី 1", "ថ្នាក់ទី 2", "ថ្នាក់ទី 3", "ថ្នាក់ទី 4", "ថ្នាក់ទី 5", "ថ្នាក់ទី 6", "គ្រូ", "សហគមន៏"];
    $totalMembersAllYears = 0;
    $totalMembersFemaleAllYears = 0;
    $gradeTotals = array_fill_keys($gradeNames, ['total_member' => 0, 'total_member_female' => 0]);
    $query = "SELECT 
         member_joined_library.type_joined AS typeJoined,
         CASE 
             WHEN grade.title LIKE 'ថ្នាក់ទី 1%' THEN 'ថ្នាក់ទី 1'
             WHEN grade.title LIKE 'ថ្នាក់ទី 2%' THEN 'ថ្នាក់ទី 2'
             WHEN grade.title LIKE 'ថ្នាក់ទី 3%' THEN 'ថ្នាក់ទី 3'
             WHEN grade.title LIKE 'ថ្នាក់ទី 4%' THEN 'ថ្នាក់ទី 4'
             WHEN grade.title LIKE 'ថ្នាក់ទី 5%' THEN 'ថ្នាក់ទី 5'
             WHEN grade.title LIKE 'ថ្នាក់ទី 6%' THEN 'ថ្នាក់ទី 6'
             ELSE grade.title 
         END AS gradeName,
         DAY(member_joined_library.dateTime) AS day,
         SUM(member_joined_library.total_member) AS total_member,
         SUM(member_joined_library.total_member_female) AS total_member_female
     FROM member_joined_library
     LEFT JOIN grade ON grade.id = member_joined_library.grade_id
     WHERE member_joined_library.dateTime BETWEEN :from_date AND :to_date
     ";
    if ($status !== null) {
        $query .= " AND member_joined_library.status = :status";
    }

    $query .= "
     GROUP BY day, member_joined_library.type_joined, gradeName
     ORDER BY day, member_joined_library.type_joined
     ";
    $params = [
        ':from_date' => $from_date,
        ':to_date' => $to_date,
    ];

    if ($status !== null) {
        $params[':status'] = $status;
    }
    $reportBorrowerBook = Yii::$app->db->createCommand($query, $params)->queryAll();

    $formattedData = [];
    foreach ($reportBorrowerBook as $entry) {
        $day = intval($entry['day']);
        $gradeName = $entry['gradeName'] ?: ($entry['typeJoined'] == 2 ? 'គ្រូ' : 'សហគមន៏');

        if (!isset($formattedData[$day])) {
            $formattedData[$day] = array_fill_keys($gradeNames, ['total_member' => 0, 'total_member_female' => 0]);
        }

        $formattedData[$day][$gradeName]['total_member'] += $entry['total_member'];
        $formattedData[$day][$gradeName]['total_member_female'] += $entry['total_member_female'];

        $totalMembersAllYears += $entry['total_member'];
        $totalMembersFemaleAllYears += $entry['total_member_female'];

        if (isset($gradeTotals[$gradeName])) {
            $gradeTotals[$gradeName]['total_member'] += $entry['total_member'];
            $gradeTotals[$gradeName]['total_member_female'] += $entry['total_member_female'];
        }
    }
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Daily Report</title>
        <style>
            table {
                width: 100%;
                margin-bottom: 1rem;
                border-collapse: collapse;
                border: 1px solid black;
            }

            th,
            td {
                padding: 5px;
                border: 1px solid black;
                text-align: center;
            }

            th {
                background-color: #f8f9fa;
            }

            thead th {
                background-color: #e9ecef;
                border-bottom: 2px solid black;
            }

            tfoot td {
                font-weight: bold;
                background-color: #f1f1f1;
            }

            .day-header {
                text-align: center;
                background-color: #e9ecef;
                border-bottom: 2px solid black;
            }
        </style>
    </head>

    <body style="font-family: 'khmerOS', sans-serif; font-size: 10px;">

        <table>
            <thead>
                <tr>
                    <th colspan="<?= count($gradeNames) * 2 + 3 ?>">
                        របាយការណ៏អ្នកចូលបណ្ណាល័យប្រចាំខែ <?= date('m') ?>
                    </th>
                </tr>
                <tr class="day-header">
                    <th rowspan="2" style="vertical-align: middle; width: 40px; border-bottom: none; border-right: none;">
                        ថ្ងៃ
                    </th>
                    <?php foreach ($gradeNames as $gradeName) : ?>
                        <th colspan="2"><?= htmlspecialchars($gradeName) ?></th>
                    <?php endforeach; ?>
                    <th colspan="2">សរុប</th>
                </tr>
                <tr>
                    <?php foreach ($gradeNames as $gradeName) : ?>
                        <th>ស.រ</th>
                        <th>ស</th>
                    <?php endforeach; ?>
                    <th>ស.រ</th>
                    <th>ស</th>
                </tr>
            </thead>
            <tbody>
                <?php for ($day = 1; $day <= 31; $day++) : ?>
                    <tr>
                        <td><?= $day ?></td>
                        <?php
                        $totalMembersDay = 0;
                        $totalMembersFemaleDay = 0;

                        foreach ($gradeNames as $gradeName) :
                            $totalMembers = $formattedData[$day][$gradeName]['total_member'] ?? 0;
                            $totalMembersFemale = $formattedData[$day][$gradeName]['total_member_female'] ?? 0;

                            echo "<td>" . htmlspecialchars($totalMembers) . "</td>";
                            echo "<td>" . htmlspecialchars($totalMembersFemale) . "</td>";

                            $totalMembersDay += $totalMembers;
                            $totalMembersFemaleDay += $totalMembersFemale;
                        endforeach;
                        ?>
                        <td><?= htmlspecialchars($totalMembersDay) ?></td>
                        <td><?= htmlspecialchars($totalMembersFemaleDay) ?></td>
                    </tr>
                <?php endfor; ?>

                <tr>
                    <td style="text-align: center;">សរុប</td>
                    <?php
                    foreach ($gradeNames as $gradeName) :
                        echo "<td>" . htmlspecialchars($gradeTotals[$gradeName]['total_member']) . "</td>";
                        echo "<td>" . htmlspecialchars($gradeTotals[$gradeName]['total_member_female']) . "</td>";
                    endforeach;
                    ?>
                    <td><?= htmlspecialchars($totalMembersAllYears) ?></td>
                    <td><?= htmlspecialchars($totalMembersFemaleAllYears) ?></td>
                </tr>
            </tbody>
        </table>

    </body>

    </html>

<?php } else { ?>

    <?php
    // Define grade names before using them
    $gradeNames = ["មត្តេយ្យ", "ថ្នាក់ទី 1", "ថ្នាក់ទី 2", "ថ្នាក់ទី 3", "ថ្នាក់ទី 4", "ថ្នាក់ទី 5", "ថ្នាក់ទី 6", "គ្រូ", "សហគមន៏"];

    $totalMembersAllYears = 0;
    $totalMembersFemaleAllYears = 0;

    $gradeTotals = array_fill_keys($gradeNames, ['total_member' => 0, 'total_member_female' => 0]);
    $query = "SELECT 
            member_joined_library.type_joined AS typeJoined,
            CASE 
                WHEN grade.title LIKE 'ថ្នាក់ទី 1%' THEN 'ថ្នាក់ទី 1'
                WHEN grade.title LIKE 'ថ្នាក់ទី 2%' THEN 'ថ្នាក់ទី 2'
                WHEN grade.title LIKE 'ថ្នាក់ទី 3%' THEN 'ថ្នាក់ទី 3'
                WHEN grade.title LIKE 'ថ្នាក់ទី 4%' THEN 'ថ្នាក់ទី 4'
                WHEN grade.title LIKE 'ថ្នាក់ទី 5%' THEN 'ថ្នាក់ទី 5'
                WHEN grade.title LIKE 'ថ្នាក់ទី 6%' THEN 'ថ្នាក់ទី 6'
                ELSE grade.title 
            END AS gradeName,
            YEAR(member_joined_library.dateTime) AS year,
            MONTH(member_joined_library.dateTime) AS month,
            DAY(member_joined_library.dateTime) AS day,
            SUM(member_joined_library.total_member) AS total_member,
            SUM(member_joined_library.total_member_female) AS total_member_female
        FROM member_joined_library
        LEFT JOIN grade ON grade.id = member_joined_library.grade_id
        WHERE 1=1
    ";

    $queryParams = [];

    if ($from_date && $to_date) {
        $query .= " AND member_joined_library.dateTime BETWEEN :from_date AND :to_date";
        $queryParams[':from_date'] = $from_date;
        $queryParams[':to_date'] = $to_date;
    }

    if ($status !== null) {
        $query .= " AND member_joined_library.status = :status";
        $queryParams[':status'] = $status;
    }

    if ($month_and_year === '1') {
        $query .= " AND (MONTH(member_joined_library.dateTime) = MONTH(CURDATE()) AND YEAR(member_joined_library.dateTime) = YEAR(CURDATE()))";
    }

    $query .= "
        GROUP BY year, month, day, member_joined_library.type_joined, gradeName
        ORDER BY year, month, day, member_joined_library.type_joined
    ";

    $reportBorrowerBook = Yii::$app->db->createCommand($query, $queryParams)->queryAll();


    $formattedData = [];
    foreach ($reportBorrowerBook as $entry) {
        $year = intval($entry['year']);
        $month = intval($entry['month']);
        $gradeName = $entry['gradeName'] ?: ($entry['typeJoined'] == 2 ? 'គ្រូ' : 'សហគមន៏');

        if (!isset($formattedData[$year])) {
            $formattedData[$year] = [];
        }
        if (!isset($formattedData[$year][$month])) {
            $formattedData[$year][$month] = [];
        }
        if (!isset($formattedData[$year][$month][$gradeName])) {
            $formattedData[$year][$month][$gradeName] = [
                'total_member' => 0,
                'total_member_female' => 0
            ];
        }

        $formattedData[$year][$month][$gradeName]['total_member'] += $entry['total_member'];
        $formattedData[$year][$month][$gradeName]['total_member_female'] += $entry['total_member_female'];

        // Update total counts for all grade names
        $totalMembersAllYears += $entry['total_member'];
        $totalMembersFemaleAllYears += $entry['total_member_female'];

        if (isset($gradeTotals[$gradeName])) {
            $gradeTotals[$gradeName]['total_member'] += $entry['total_member'];
            $gradeTotals[$gradeName]['total_member_female'] += $entry['total_member_female'];
        }
    }

    // Determine the year from the data
    $years = array_unique(array_column($reportBorrowerBook, 'year'));
    $year = !empty($years) ? reset($years) : date('Y'); // Use the first year found or the current year
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Report</title>
        <style>
            table {
                width: 100%;
                margin-bottom: 1rem;
                border-collapse: collapse;
                border: 1px solid black;
            }

            th,
            td {
                padding: 5px;
                border: 1px solid black;
                text-align: center;
            }

            th {
                background-color: #f8f9fa;
            }

            thead th {
                background-color: #e9ecef;
                border-bottom: 2px solid black;
            }

            tfoot td {
                font-weight: bold;
                background-color: #f1f1f1;
            }

            .month-header {
                text-align: center;
                background-color: #e9ecef;
                border-bottom: 2px solid black;
            }
        </style>
    </head>

    <body style="font-family: 'khmerOS', sans-serif; font-size: 10px;">

        <table>
            <thead>
                <tr>
                    <th colspan="<?= count($gradeNames) * 2 + 4 ?>">
                        របាយការណ៏អ្នកចូលបណ្ណាល័យប្រចាំឆ្នាំ <?= date('Y') ?>
                    </th>
                </tr>
                <tr class="month-header">
                    <th rowspan="2" style="vertical-align: middle; width: 40px; border-bottom: none; border-right: none;">
                        ខែ
                    </th>
                    <?php foreach ($gradeNames as $gradeName) : ?>
                        <th colspan="2"><?= htmlspecialchars($gradeName) ?></th>
                    <?php endforeach; ?>
                    <th colspan="2">សរុប</th>
                </tr>
                <tr>
                    <?php foreach ($gradeNames as $gradeName) : ?>
                        <th>ស.រ</th>
                        <th>ស</th>
                    <?php endforeach; ?>
                    <th>ស.រ</th>
                    <th>ស</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $months = [
                    1 => 'មករា',
                    2 => 'កុម្ភៈ',
                    3 => 'មីនា',
                    4 => 'មេសា',
                    5 => 'ឧសភា',
                    6 => 'មិថុនា',
                    7 => 'កក្តដា',
                    8 => 'សីហា',
                    9 => 'កញ្ញា',
                    10 => 'តុលា',
                    11 => 'វិច្ឆិកា',
                    12 => 'ធ្នូ'
                ];

                foreach ($months as $monthIndex => $monthName) : ?>
                    <tr>
                        <td><?= htmlspecialchars($monthName) ?></td>
                        <?php
                        $totalMembersMonth = 0;
                        $totalMembersFemaleMonth = 0;
                        foreach ($gradeNames as $gradeName) :
                            $totalMembers = 0;
                            $totalMembersFemale = 0;
                            if (isset($formattedData[$year][$monthIndex][$gradeName])) {
                                $totalMembers = $formattedData[$year][$monthIndex][$gradeName]['total_member'];
                                $totalMembersFemale = $formattedData[$year][$monthIndex][$gradeName]['total_member_female'];
                            }
                            echo "<td>" . htmlspecialchars($totalMembers) . "</td>";
                            echo "<td>" . htmlspecialchars($totalMembersFemale) . "</td>";
                            $totalMembersMonth += $totalMembers;
                            $totalMembersFemaleMonth += $totalMembersFemale;
                        endforeach; ?>
                        <td><?= htmlspecialchars($totalMembersMonth) ?></td>
                        <td><?= htmlspecialchars($totalMembersFemaleMonth) ?></td>
                    </tr>
                <?php endforeach; ?>

                <tr>
                    <td style="text-align: center;">សរុប</td>
                    <?php foreach ($gradeNames as $gradeName) : ?>
                        <td><?= htmlspecialchars($gradeTotals[$gradeName]['total_member']) ?></td>
                        <td><?= htmlspecialchars($gradeTotals[$gradeName]['total_member_female']) ?></td>
                    <?php endforeach; ?>
                    <td><?= array_sum(array_column($gradeTotals, 'total_member')) ?></td>
                    <td><?= array_sum(array_column($gradeTotals, 'total_member_female')) ?></td>
                </tr>
            </tbody>
        </table>
    </body>

    </html>

<?php }

?>