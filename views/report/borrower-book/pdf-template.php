<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
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

        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
        }

        .table th,
        .table td {
            padding: 0.75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
        }

        .table tbody+tbody {
            border-top: 2px solid #dee2e6;
        }

        .table-sm th,
        .table-sm td {
            padding: 0.3rem;
        }

        .thead- th {
            background-color: #f8f9fa;
        }
    </style>
</head>

<body>
    <div class="table-responsive">
        <table class="table table-sm mb-0">
            <thead class="thead-">
                <tr>
                    <th style="background-color:aqua;">លេខរៀង</th>
                    <th>ឈ្មោះសិស្ស</th>
                    <th>ភេទ</th>
                    <th>ថ្នាក់</th>
                    <th>ចំណងជើងរឿង</th>
                    <th>លេខសារពើភ័ណ្ខ</th>
                    <th>ចំនួនសៀវភៅ</th>
                    <th>ថ្ងៃ​ចាប់ផ្តើមកាលបរិច្ឆេទ</th>
                    <th>កាលបរិច្ឆេទបញ្ចប់</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reportBorrowerBook as $key => $borrowerBook) { ?>
                    <tr>
                        <td><?= $borrowerBook['ID'] ?></td>
                        <td><?= $borrowerBook['username'] ?></td>
                        <td><?= $borrowerBook['gender'] ?></td>
                        <td><?= $borrowerBook['title'] ?></td>
                        <td><?= $borrowerBook['bookTitle'] ?></td>
                        <td><?= $borrowerBook['code'] ?></td>
                        <td><?= $borrowerBook['quantity'] ?></td>
                        <td><?= $borrowerBook['start'] ?></td>
                        <td><?= $borrowerBook['end'] ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>

</html>