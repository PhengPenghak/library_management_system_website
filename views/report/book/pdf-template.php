<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
</head>

<body style="font-family: 'khmeros', sans-serif;">
    <div class="header" style="text-align: center; margin-bottom: 20px;">
        <h1 style="margin: 0; font-size: 24px; color: #333;">
            បញ្ញីខ្ចីសារពើភ័ណ្ឌសៀវភៅ
        </h1>
    </div>
    <div class="table-responsive"
        style="width: 100%; margin-bottom: 1rem; overflow-x: auto; -webkit-overflow-scrolling: touch; -ms-overflow-style: -ms-autohiding-scrollbar;">
        <table class="table table-sm mb-0"
            style="width: 100%; margin-bottom: 1rem; color: #212529; border-collapse: collapse;">
            <thead class="thead-" style="background-color: #f8f9fa; color: #333; font-weight: bold;">
                <tr>
                    <th
                        style="width:130px; font-size:.9rem; padding: 0.75rem; vertical-align: top; border: 1px solid #dee2e6; text-align: center; border-bottom: 2px solid #dee2e6; color: black;">
                        លេខសារពើភ័ណ្ឌ</th>
                    <th
                        style="width:110px; font-size:.9rem; padding: 0.75rem; vertical-align: top; border: 1px solid #dee2e6; text-align: center; border-bottom: 2px solid #dee2e6; color: black;">
                        ថ្ងៃខែឆ្នាំចូល</th>
                    <th
                        style="width:120px; font-size:.9rem; padding: 0.75rem; vertical-align: top; border: 1px solid #dee2e6; text-align: center; border-bottom: 2px solid #dee2e6; color: black;">
                        ឈ្មោះអ្នកនិពន្ធ</th>
                    <th
                        style="width:150px; font-size:.9rem; padding: 0.75rem; vertical-align: top; border: 1px solid #dee2e6; text-align: center; border-bottom: 2px solid #dee2e6; color: black;">
                        ចំណងជើងសៀវភៅ</th>
                    <th
                        style="width:150px; font-size:.9rem; padding: 0.75rem; vertical-align: top; border: 1px solid #dee2e6; text-align: center; border-bottom: 2px solid #dee2e6; color: black;">
                        គ្រឹះស្ថានបោះពុម្ភ</th>
                    <th
                        style="width:130px; font-size:.9rem; padding: 0.75rem; vertical-align: top; border: 1px solid #dee2e6; text-align: center; border-bottom: 2px solid #dee2e6; color: black;">
                        លេខកូដសៀវភៅ</th>
                    <th
                        style="width:100px; font-size:.9rem; padding: 0.75rem; vertical-align: top; border: 1px solid #dee2e6; text-align: center; border-bottom: 2px solid #dee2e6; color: black;">
                        ប្រភពផ្ដល់</th>
                    <th
                        style="font-size:.9rem; padding: 0.75rem; vertical-align: top; border: 1px solid #dee2e6; text-align: center; border-bottom: 2px solid #dee2e6; color: black;">
                        សរុប</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reportBook as $key => $book) { ?>
                    <tr style="background-color: <?= $key % 2 == 0 ? '#f2f2f2' : 'transparent'; ?>">
                        <td style="padding: 0.75rem; vertical-align: top; border: 1px solid #dee2e6; text-align: center;">
                            <?= $book->id ?>
                        </td>
                        <td style="padding: 0.75rem; vertical-align: top; border: 1px solid #dee2e6; text-align: center;">
                            <?= Yii::$app->formatter->asDate($book->publishing_date, 'php:d.m.y'); ?>
                        </td>
                        <td style="padding: 0.75rem; vertical-align: top; border: 1px solid #dee2e6; text-align: center;">
                            <?= $book->author ?>
                        </td>
                        <td style="padding: 0.75rem; vertical-align: top; border: 1px solid #dee2e6; text-align: center;">
                            <?= $book->title ?>
                        </td>
                        <td style="padding: 0.75rem; vertical-align: top; border: 1px solid #dee2e6; text-align: center;">
                            <?= $book->publishing ?>
                        </td>
                        <td style="padding: 0.75rem; vertical-align: top; border: 1px solid #dee2e6; text-align: center;">
                            <?= $book->code ?>
                        </td>
                        <td style="padding: 0.75rem; vertical-align: top; border: 1px solid #dee2e6; text-align: center;">
                            <?= $book->sponse ?>
                        </td>
                        <td style="padding: 0.75rem; vertical-align: top; border: 1px solid #dee2e6; text-align: center;">
                            <?= $book->quantity . " ក្បាល" ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <div class="footer"
        style="text-align: center; position: fixed; bottom: 0; width: 100%; background-color: #f8f9fa; padding: 10px 0;">
        <p style="margin: 0; font-size: 12px; color: #777;">&copy; <?= date('d/m/Y') ?>​ សាលាបឋមសិក្សា វេស្សវ័ណ</p>
    </div>
</body>

</html>