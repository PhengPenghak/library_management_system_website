<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
</head>

<body style="font-family: 'khmeros', sans-serif;">
    <div class="header" style="text-align: center; margin-bottom: 20px;">
        <?php if (!empty($reportBorrowerBook)) { ?>
            <div class="header" style="text-align: center; margin-bottom: 20px;">
                <h1 style="margin: 0; font-size: 24px; color: #333;">
                    បញ្ញីខ្ចីសងថ្នាក់ទី <?= $reportBorrowerBook[0]['grade_title'] ?>
                </h1>
            </div>
        <?php } ?>
    </div>
    <div class="table-responsive" style="width: 100%; margin-bottom: 1rem; overflow-x: auto; -webkit-overflow-scrolling: touch; -ms-overflow-style: -ms-autohiding-scrollbar;">
        <table class="table table-sm mb-0" style="width: 100%; margin-bottom: 1rem; color: #212529; border-collapse: collapse;">
            <thead class="thead-" style="background-color: #f8f9fa; color: #333; font-weight: bold;">
                <tr>
                    <th style="width:60px; font-size:.9rem; padding: 0.75rem; vertical-align: top; border: 1px solid #dee2e6; text-align: center; border-bottom: 2px solid #dee2e6; color: black;">ល​ /​ រ</th>
                    <th style="width:250px; font-size:.9rem; padding: 0.75rem; vertical-align: top; border: 1px solid #dee2e6; text-align: center; border-bottom: 2px solid #dee2e6; color: black;">ឈ្មោះសិស្ស</th>
                    <th style="width:70px; font-size:.9rem; padding: 0.75rem; vertical-align: top; border: 1px solid #dee2e6; text-align: center; border-bottom: 2px solid #dee2e6; color: black;">ភេទ</th>
                    <th style="width:100px; font-size:.9rem; padding: 0.75rem; vertical-align: top; border: 1px solid #dee2e6; text-align: center; border-bottom: 2px solid #dee2e6; color: black;">ថ្នាក់</th>
                    <th style="width:200px; font-size:.9rem; padding: 0.75rem; vertical-align: top; border: 1px solid #dee2e6; text-align: center; border-bottom: 2px solid #dee2e6; color: black;">ចំណងជើងរឿង</th>
                    <th style="width:130px; font-size:.9rem; padding: 0.75rem; vertical-align: top; border: 1px solid #dee2e6; text-align: center; border-bottom: 2px solid #dee2e6; color: black;">លេខសារពើភ័ណ្ខ</th>
                    <th style="width:70px; font-size:.9rem; padding: 0.75rem; vertical-align: top; border: 1px solid #dee2e6; text-align: center; border-bottom: 2px solid #dee2e6; color: black;">ចំនួន</th>
                    <th style="font-size:.9rem; padding: 0.75rem; vertical-align: top; border: 1px solid #dee2e6; text-align: center; border-bottom: 2px solid #dee2e6; color: black;">កាលបរិច្ឆេទខ្ខី</th>

                </tr>
            </thead>
            <tbody>
                <?php foreach ($reportBorrowerBook as $key => $borrowerBook) { ?>
                    <tr style="background-color: <?= $key % 2 == 0 ? '#f2f2f2' : 'transparent'; ?>">
                        <td style="padding: 0.75rem; vertical-align: top; border: 1px solid #dee2e6; text-align: center;"><?= $borrowerBook['ID'] ?></td>
                        <td style="padding: 0.75rem; vertical-align: top; border: 1px solid #dee2e6; text-align: center;"><?= $borrowerBook['username'] ?></td>
                        <td style="padding: 0.75rem; vertical-align: top; border: 1px solid #dee2e6; text-align: center;"><?= $borrowerBook['gender'] ?></td>
                        <td style="padding: 0.75rem; vertical-align: top; border: 1px solid #dee2e6; text-align: center;"><?= $borrowerBook['grade_title'] ?></td>
                        <td style="padding: 0.75rem; vertical-align: top; border: 1px solid #dee2e6; text-align: center;"><?= $borrowerBook['bookTitle'] ?></td>
                        <td style="padding: 0.75rem; vertical-align: top; border: 1px solid #dee2e6; text-align: center;"><?= $borrowerBook['code'] ?></td>
                        <td style="padding: 0.75rem; vertical-align: top; border: 1px solid #dee2e6; text-align: center;"><?= $borrowerBook['quantity'] ?></td>
                        <td style="padding: 0.75rem; vertical-align: top; border: 1px solid #dee2e6; text-align: center;"> <?= Yii::$app->formatter->asDate($borrowerBook['start'], 'php:d/m/Y') ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <div class="footer" style="text-align: center; position: fixed; bottom: 0; width: 100%; background-color: #f8f9fa; padding: 10px 0;">
        <p style="margin: 0; font-size: 12px; color: #777;">&copy; <?= date('d/m/Y') ?>​ សាលាបឋមសិក្សា វេស្សវ័ណ</p>
    </div>
</body>

</html>