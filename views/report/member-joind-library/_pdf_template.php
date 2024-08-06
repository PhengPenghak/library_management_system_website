<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report</title>
</head>

<body>

    <table style="width: 100%; margin-bottom: 1rem; border-collapse: collapse; border: 1px solid black;">
        <thead>
            <tr style="border-bottom: none;">
                <th rowspan="3" style="vertical-align: middle; width: 40px; padding: 5px; border: 1px solid black; text-align: center; background-color: #f8f9fa; border-bottom: none; border-right: none;">ថ្ងៃ</th>
                <th colspan="<?= count($gradeNames) * 2 + 2; ?>" style="padding: 5px; border: 1px solid black; text-align: center; background-color: #f8f9fa; border-bottom: none;">ចំនួនសិស្សចូលអាន</th>
            </tr>
            <tr style="border-bottom: none;">
                <?php foreach ($gradeNames as $gradeName) { ?>
                    <th colspan="2" style="padding: 5px; border: 1px solid black; text-align: center; background-color: #f8f9fa;"><?= $gradeName ?></th>
                <?php } ?>
                <th colspan="2" style="padding: 5px; border: 1px solid black; text-align: center; background-color: #f8f9fa;">សរុប</th>
            </tr>
            <tr>
                <?php foreach ($gradeNames as $gradeName) { ?>
                    <th style="padding: 5px; border: 1px solid black; text-align: center;">ស.រ</th>
                    <th style="padding: 5px; border: 1px solid black; text-align: center;">ស</th>
                <?php } ?>
                <th style="padding: 5px; border: 1px solid black; text-align: center;">ស.រ</th>
                <th style="padding: 5px; border: 1px solid black; text-align: center;">ស</th>
            </tr>
        </thead>
        <tbody>
            <?php for ($day = 1; $day <= 31; $day++) {
                echo "<tr>";
                echo "<td style='padding: 5px; border: 1px solid black; text-align: center;'>{$day}</td>";
                $totalMembers = 0;
                $totalMembersFemale = 0;

                foreach ($gradeNames as $gradeName) {
                    $found = false;
                    if (isset($formattedData[$day])) {
                        foreach ($formattedData[$day] as $details) {
                            if ($details['gradeName'] == $gradeName) {
                                echo "<td style='padding: 5px; border: 1px solid black; text-align: center;'>{$details['total_member']}</td>";
                                echo "<td style='padding: 5px; border: 1px solid black; text-align: center;'>{$details['total_member_female']}</td>";
                                $totalMembers += $details['total_member'];
                                $totalMembersFemale += $details['total_member_female'];

                                // Update grade totals
                                $gradeTotals[$gradeName]['total_member'] += $details['total_member'];
                                $gradeTotals[$gradeName]['total_member_female'] += $details['total_member_female'];

                                $found = true;
                                break;
                            }
                        }
                    }
                    if (!$found) {
                        echo "<td style='padding: 5px; border: 1px solid black; text-align: center;'>0</td>";
                        echo "<td style='padding: 5px; border: 1px solid black; text-align: center;'>0</td>";
                    }
                }

                echo "<td style='padding: 5px; border: 1px solid black; text-align: center;'>{$totalMembers}</td>";
                echo "<td style='padding: 5px; border: 1px solid black; text-align: center;'>{$totalMembersFemale}</td>";
                echo "</tr>";
                $totalMembersAllDays += $totalMembers;
                $totalMembersFemaleAllDays += $totalMembersFemale;
            } ?>
        </tbody>
        <tbody>
            <tr>
                <td style='padding: 5px; border: 1px solid black; text-align: center;'>សរុប</td>
                <?php foreach ($gradeNames as $gradeName) { ?>
                    <td style='padding: 5px; border: 1px solid black; text-align: center;'><?= $gradeTotals[$gradeName]['total_member'] ?></td>
                    <td style='padding: 5px; border: 1px solid black; text-align: center;'><?= $gradeTotals[$gradeName]['total_member_female'] ?></td>
                <?php } ?>
                <td style='padding: 5px; border: 1px solid black; text-align: center;'><?= $totalMembersAllDays ?></td>
                <td style='padding: 5px; border: 1px solid black; text-align: center;'><?= $totalMembersFemaleAllDays ?></td>
            </tr>
        </tbody>
    </table>

</body>

</html>