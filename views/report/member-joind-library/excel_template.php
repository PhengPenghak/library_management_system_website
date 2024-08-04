<?=
header("Content-type: application/vnd.ms-excel;charset:UTF-8");
header("Content-Disposition: attachment;filename=$file_name.xls");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>export to excel</title>

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

        table.table th,
        tbale.table td {
            padding: 0.75rem;
            vertical-align: top;
            border: 3px solid black;
        }



        .table-sm th,
        .table-sm td {
            padding: 0.3rem;
        }

        .thead- th {
            background-color: #f8f9fa;
        }



        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
            font-family: 'khmerOS';
            text-align: center;
            border: 3px solid black;
        }
    </style>
</head>

<body>


    <table class="table table-sm mb-0" style="border: 1px solid black;">
        <thead class="thead-table">
            <tr class="text-center">
                <th rowspan="4" style="vertical-align: middle;font-family: 'khmerOS';width: 40px;">ខែ</th>
            <tr>
                <th colspan="20" class="text-center">ចំនួនសិស្សចូលអាន</th>
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
            <tr>
                <td style="text-align: start;"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td style="height: 40px;"></td>
            </tr>
        </tbody>

        </thead>
        <tbody>

        </tbody>
    </table>
    <table style="margin-left: auto;margin-top: 30px; font-family: 'khmerOS'; border: 1px solid black;">

        <tr style="font-size: 14px;">
            <th style="text-align: start !important;padding: 5px 15px;width: 130px;font-size: 12px;">ថ្នាក់</th>
            <th style="text-align: start !important;padding: 5px 15px;font-size: 12px;">សិស្សសរុប</th>
            <th style="text-align: start !important;padding: 5px 15px;font-size: 12px;">សិស្សស្រីសរុប</th>
        </tr>
        <tr>
            <td style="text-align: start !important;padding: 5px 15px;">មតេ្តយ្យ</td>
            <td style="text-align: start !important;padding: 5px 15px;"></td>
            <td style="text-align: start !important;padding: 5px 15px;"></td>
        </tr>
        <tr>
            <td style="text-align: start !important;padding: 5px 15px;">ថា្នក់ទី ១</td>
            <td style="text-align: start !important;padding: 5px 15px;"></td>
            <td style="text-align: start !important;padding: 5px 15px;"></td>
        </tr>
        <tr>
            <td style="text-align: start !important;padding: 5px 15px;">ថា្នក់ទី ២</td>
            <td style="text-align: start !important;padding: 5px 15px;"></td>
            <td style="text-align: start !important;padding: 5px 15px;"></td>
        </tr>

        <tr>
            <td style="text-align: start !important;padding: 5px 15px;">ថា្នក់ទី ៣</td>
            <td style="text-align: start !important;padding: 5px 15px;"></td>
            <td style="text-align: start !important;padding: 5px 15px;"></td>
        </tr>
        <tr>
            <td style="text-align: start !important;padding: 5px 15px;">ថា្នក់ទី ៤</td>
            <td style="text-align: start !important;padding: 5px 15px;"></td>
            <td style="text-align: start !important;padding: 5px 15px;"></td>
        </tr>
        <tr>
            <td style="text-align: start !important;padding: 5px 15px;">ថា្នក់ទី ៥</td>
            <td style="text-align: start !important;padding: 5px 15px;"></td>
            <td style="text-align: start !important;padding: 5px 15px;"></td>
        </tr>
        <tr>
            <td style="text-align: start !important;padding: 5px 15px;">ថា្នក់ទី ៦</td>
            <td style="text-align: start !important;padding: 5px 15px;"></td>
            <td style="text-align: start !important;padding: 5px 15px;"></td>
        </tr>

        <tr>
            <td style="text-align: start !important;padding: 5px 15px;">គ្រូ</td>
            <td style="text-align: start !important;padding: 5px 15px;"></td>
            <td style="text-align: start !important;padding: 5px 15px;"></td>
        </tr>
        <tr>
            <td style="text-align: start !important;padding: 5px 15px;">សមាគមន៍</td>
            <td style="text-align: start !important;padding: 5px 15px;"></td>
            <td style="text-align: start !important;padding: 5px 15px;"></td>
        </tr>

        <tr>
            <td style="text-align: start !important;padding: 5px 15px;">សរុប​​​​​ទាំង​​​​អស់</td>
            <td style="text-align: start !important;padding: 5px 15px;"></td>
            <td style="text-align: start !important;padding: 5px 15px;"></td>
        </tr>

    </table>
</body>

</html>