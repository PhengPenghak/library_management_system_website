<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\helpers\Console;

class BackupController extends Controller
{
    // Database configuration
    private $dbHost = 'localhost';
    private $dbName = 'library_management_system';
    private $dbUser = 'root';
    private $dbPass = '';
    private $backupDir = '@app/backups';

    /**
     * This command backs up the database.
     */
    public function actionBackup()
    {
        $backupFile = Yii::getAlias($this->backupDir) . '/backup_' . date('Y-m-d_H-i-s') . '.sql';

        // Command to dump the database
        $command = "mysqldump --user={$this->dbUser} --password={$this->dbPass} --host={$this->dbHost} {$this->dbName} > {$backupFile}";

        // Execute the command
        system($command, $output);

        // Check if the backup was successful
        if ($output === 0) {
            $this->stdout("Backup successful!\n", Console::FG_GREEN);
        } else {
            $this->stderr("Backup failed!\n", Console::FG_RED);
        }
    }
}
