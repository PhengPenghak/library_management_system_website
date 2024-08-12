<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;

class SeedController extends Controller
{
    public function actionUser()
    {
        Yii::$app->db->createCommand()->batchInsert(
            'user',
            [
                'id',
                'role_id',
                'username',
                'auth_key',
                'created_at',
                'updated_at',
                'password_hash',
                'password_reset_token',
                'email',
                'status',
                'user_type_id',
                'first_name',
                'last_name',
                'mobile',

            ],
            [
                [1, 1, 'admin', 'Fbn3llmODsFMNzMJRL-B6e3qbex92P56', '2024-07-24 10:46:09', '2024-07-24 11:25:34', '$2y$13$WBA1yQ/PzBxONB8sr3Q8CuYpIepkQM4cMqQVs3aN6gcoLj.1ybow6', '', 'example@gmail.com', 1, 1, 'Penghak', 'Pheng', '0712131789'],
            ]
        )->execute();
    }

    public function actionUserRoleGroup()
    {
        Yii::$app->db->createCommand()->batchInsert(
            'user_role_group',
            [
                'id',
                'name',
                'sort',
            ],
            [
                [1, 'user', 1],
                [2, 'Book', 2],
                [3, 'Borroer Book', 3],
                [4, 'Book Distribution', 4],
                [5, 'Category Book', 5],
                [6, 'Member Joined Library', 6],
                [7, 'Location Book', 7],
                [8, 'Event', 8],
                [9, 'Grade', 9],
                [10, 'Report', 10],


            ]
        )->execute();
    }

    public function actionUserRole()
    {
        Yii::$app->db->createCommand()->batchInsert(
            'user_role',
            [
                'id',
                'name',
                'is_master',
            ],
            [
                [1, 'admin', ''],

            ]
        )->execute();
    }

    public function actionUserRoleAction()
    {
        Yii::$app->db->createCommand()->batchInsert(
            'user_role_action',
            [
                'id',
                'group_id',
                'name',
                'controller',
                'action',
                'status',
            ],
            [
                [1, 1, 'View', 'user', 'view,index,role-update,role', 1],
                [2, 1, 'Create', 'user', 'role-create,create', 1],
                [3, 1, 'Update', 'user', 'update,role-update', 1],
                [4, 1, 'Delete', 'user', 'delete', 1],

                [5, 2, 'View', 'book', 'view,index', 1],
                [6, 2, 'Create', 'book', 'create', 1],
                [7, 2, 'Update', 'book', 'update', 1],
                [8, 2, 'Delete', 'book', 'delete', 1],

                [9, 3, 'View', 'borrower-book', 'index,detail', 1],
                [10, 3, 'Create', 'borrower-book', 'create-information-borrower-book,create-borrow-book', 1],
                [11, 3, 'Update', 'borrower-book', 'update-borrow-book', 1],

                [12, 4, 'Index', 'book-distribution', 'index,detail', 1],
                [13, 4, 'Create', 'book-distribution', 'create-information-book-distribution,detail', 1],
                [14, 4, 'Update', 'book-distribution', 'update-book-distribution,create-book-distribution', 1],

                [15, 5, 'View', 'category-book', 'view,index', 1],
                [16, 5, 'Create', 'category-book', 'create', 1],
                [17, 5, 'Update', 'category-book', 'update', 1],
                [18, 5, 'Delete', 'category-book', 'delete', 1],

                [19, 6, 'View', 'member-joined-library', 'index,form', 1],
                [20, 6, 'Create', 'member-joined-library', 'form', 1],
                [21, 6, 'Update', 'member-joined-library', 'form', 1],
                [22, 6, 'Delete', 'member-joined-library', 'delete', 1],

                [23, 7, 'View', 'location-book', 'index,form', 1],
                [24, 7, 'Create', 'location-book', 'create', 1],
                [25, 7, 'Update', 'location-book', 'update', 1],
                [26, 7, 'Delete', 'location-book', 'delete', 1],

                [27, 8, 'View', 'event', 'view,index,events', 1],


                [31, 9, 'View', 'grade', 'view,index', 1],
                [32, 9, 'Create', 'grade', 'create', 1],
                [33, 9, 'Update', 'grade', 'update', 1],
                [34, 9, 'Delete', 'grade', 'delete', 1],

                [35, 10, 'View', 'report', 'borrower-book,export-excel-member-joined-library,export-pdf-member-joined-library,export-excel-member-joined-librarys,test,export-pdf-borrow-book,export-excel-borrow-book', 1],
                [36, 10, 'Details', 'report', 'details', 1],
                [37, 10, 'Member Joined', 'report', 'library', 1],
            ]
        )->execute();
    }

    public function actionUserRolePermission()
    {
        Yii::$app->db->createCommand()->batchInsert(
            'user_role_permission',
            [
                'id',
                'user_role_id',
                'action_id',
            ],
            [
                [9, 1, 1],
                [6, 1, 2],
                [7, 1, 3],
                [8, 1, 4],
                [10, 1, 5],
                [11, 1, 6],
                [12, 1, 7],
                [13, 1, 8],
                [16, 1, 9],
                [15, 1, 10],
                [14, 1, 11],
                [17, 1, 12],
                [18, 1, 13],
                [19, 1, 14],
                [20, 1, 15],
                [21, 1, 16],
                [22, 1, 17],
                [23, 1, 18],
                [24, 1, 19],
                [26, 1, 20],
                [27, 1, 21],
                [25, 1, 22],
                [28, 1, 23],
                [29, 1, 24],
                [30, 1, 25],
                [31, 1, 26],
                [35, 1, 27],
                [34, 1, 28],
                [32, 1, 29],
                [33, 1, 30],
                [36, 1, 31],
                [37, 1, 32],
                [38, 1, 33],
                [39, 1, 34],
                [40, 1, 35],
                [41, 1, 36],
                [42, 1, 37],
            ]
        )->execute();
    }
}
