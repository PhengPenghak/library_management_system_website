<?php

namespace app\controllers;

use app\models\User;
use app\models\UserRole;
use app\models\UserRolePermission;
use app\models\UserRoleSearch;
use app\models\UserSearch;
use Yii;
use Exception;
use Ramsey\Uuid\Uuid;
use yii\web\Controller;
use yii\filters\VerbFilter;

class UserController extends Controller
{
  /**
   * @inheritDoc
   */
  // public function behaviors()
  // {
  //   return array_merge(
  //     parent::behaviors(),
  //     [
  //       'access' => [
  //         'class' => \yii\filters\AccessControl::class,
  //         'rules' => [
  //           [
  //             'actions' => User::getUserPermission(Yii::$app->controller->id),
  //             'allow' => true,
  //           ]
  //         ],
  //       ],
  //       'verbs' => [
  //         'class' => VerbFilter::class,
  //         'actions' => [
  //           'delete' => ['POST'],
  //         ],
  //       ],
  //     ]
  //   );
  // }

  public function beforeAction($action)
  {
    Yii::$app->view->params['controller_group'] = 'setting';
    Yii::$app->view->params['controller_action_group'] = 'setting_user';
    if ($action->id == 'error') {
      $this->layout = 'error';
    }

    return parent::beforeAction($action);
  }

  public function actionRole()
  {
    Yii::$app->view->params['controller_action_group'] = 'setting_role';
    $searchModel = new UserRoleSearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    $total_items = $dataProvider->getTotalCount();



    return $this->render('role', [
      'page_size' => 15,
      'searchModel' => $searchModel,
      'dataProvider' => $dataProvider,
    ]);
  }

  public function actionRoleCreate()
  {
    Yii::$app->view->params['controller_action_group'] = 'setting_role';
    $model = new UserRole();

    if ($this->request->isPost && $model->load($this->request->post())) {

      $transaction_exception = Yii::$app->db->beginTransaction();

      try {

        $chkboxAction = $this->request->post('chkboxAction');
        if (!empty($chkboxAction)) {
          $bulkData = [];
          foreach ($chkboxAction as $key => $value) {
            if (!empty($value)) {
              $bulkData[] = [$model->id, $value];
            }
          }
          $batchInsert = Yii::$app->db->createCommand()->batchInsert(
            'user_role_permission',
            [
              'user_role_id',
              'action_id'
            ],
            $bulkData
          );
          if (!$batchInsert->execute()) throw new Exception("Failed to save booking item!");
        }

        if (!$model->save()) throw new Exception("Failed to Save! Code #001");

        $transaction_exception->commit();
        Yii::$app->session->setFlash('success', "User saved successfully");
        return $this->redirect(['role-update', 'id' => $model->id]);
      } catch (Exception $ex) {
        Yii::$app->session->setFlash('warning', $ex->getMessage());
        $transaction_exception->rollBack();
        return $this->redirect(Yii::$app->request->referrer);
      }
    }
    $user_role_id = NULL;
    $userRoleAction = Yii::$app->db->createCommand("SELECT 
        user_role_group.`name` group_name,
        user_role_action.*,
        IF(user_role_permission.id IS NULL OR user_role_permission.id = '', 0,1) checked
      FROM user_role_action
      INNER JOIN user_role_group ON user_role_group.id = user_role_action.group_id
      LEFT JOIN user_role_permission ON user_role_permission.action_id = user_role_action.id 
        AND user_role_permission.user_role_id = :user_role_id
        ORDER BY user_role_group.`sort`
    ")->bindParam(':user_role_id', $user_role_id)
      ->queryAll();
    $userRoleActionByGroup = [];
    if (!empty($userRoleAction)) {
      foreach ($userRoleAction as $key => $value) {
        $userRoleActionByGroup[$value['group_name']][] = $value;
      }
    }

    return $this->render('form_role', [
      'model' => $model,
      'userRoleAction' => $userRoleAction,
      'userRoleActionByGroup' => $userRoleActionByGroup
    ]);
  }

  public function actionRoleUpdate($id)
  {
    Yii::$app->view->params['controller_action_group'] = 'setting_role';
    $model = UserRole::findOne($id);

    if ($this->request->isPost && $model->load($this->request->post())) {

      $transaction_exception = Yii::$app->db->beginTransaction();

      try {

        $chkboxAction = $this->request->post('chkboxAction');
        UserRolePermission::deleteAll(['user_role_id' => $model->id]);
        if (!empty($chkboxAction)) {
          $bulkData = [];
          foreach ($chkboxAction as $key => $value) {
            if (!empty($value)) {
              $bulkData[] = [$model->id, $value];
            }
          }
          $batchInsert = Yii::$app->db->createCommand()->batchInsert(
            'user_role_permission',
            [
              'user_role_id',
              'action_id'
            ],
            $bulkData
          );
          if (!$batchInsert->execute()) throw new Exception("Failed to save booking item!");
        }

        if (!$model->save()) throw new Exception("Failed to Save! Code #001");

        $transaction_exception->commit();
        Yii::$app->session->setFlash('success', "User saved successfully");
        return $this->redirect(Yii::$app->request->referrer);
      } catch (Exception $ex) {
        Yii::$app->session->setFlash('warning', $ex->getMessage());
        $transaction_exception->rollBack();
        return $this->redirect(Yii::$app->request->referrer);
      }
    }
    $user_role_id = $model->id;
    $userRoleAction = Yii::$app->db->createCommand("SELECT 
        user_role_group.`name` group_name,
        user_role_action.*,
        IF(user_role_permission.id IS NULL OR user_role_permission.id = '', 0,1) checked
      FROM user_role_action
      INNER JOIN user_role_group ON user_role_group.id = user_role_action.group_id
      LEFT JOIN user_role_permission ON user_role_permission.action_id = user_role_action.id 
        AND user_role_permission.user_role_id = :user_role_id
        ORDER BY user_role_group.`sort`
    ")->bindParam(':user_role_id', $user_role_id)
      ->queryAll();
    $userRoleActionByGroup = [];
    if (!empty($userRoleAction)) {
      foreach ($userRoleAction as $key => $value) {
        $userRoleActionByGroup[$value['group_name']][] = $value;
      }
    }

    return $this->render('form_role', [
      'model' => $model,
      'userRoleAction' => $userRoleAction,
      'userRoleActionByGroup' => $userRoleActionByGroup
    ]);
  }

  public function actionIndex()
  {

    $searchModel = new UserSearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    $total_items = $dataProvider->getTotalCount();

    return $this->render('index', [
      'page_size' => 15,
      'searchModel' => $searchModel,
      'dataProvider' => $dataProvider,
    ]);
  }

  public function actionCreate()
  {
    $model = new User();
    $model->scenario = "profile";
    $model->user_type_id = 1;
    $master = Yii::$app->master;

    if ($this->request->isPost && $model->load($this->request->post())) {

      $transaction_exception = Yii::$app->db->beginTransaction();

      try {

        if ($model->password != "") {
          $model->setPassword($model->password);
          $model->generateAuthKey($model->auth_key);
        }

        if (!$model->save()) throw new Exception($master->errToString($model->getErrors()));

        $transaction_exception->commit();
        Yii::$app->session->setFlash('success', "User saved successfully");
        return $this->redirect(['update', ['id' => $model->id]]);
      } catch (Exception $ex) {
        Yii::$app->session->setFlash('warning', $ex->getMessage());
        $transaction_exception->rollBack();
        return $this->redirect(Yii::$app->request->referrer);
      }
    }

    return $this->render('form', [
      'model' => $model,
    ]);
  }

  public function actionUpdate($id)
  {
    $model = User::findOne($id);
    $model->scenario = "profile";

    if ($this->request->isPost && $model->load($this->request->post())) {

      $transaction_exception = Yii::$app->db->beginTransaction();

      try {
        if ($model->password != "") {
          $model->setPassword($model->password);
          $model->generateAuthKey($model->auth_key);
        }

        if (!$model->save()) throw new Exception(Yii::$app->master->errToString($model->getErrors()));

        $transaction_exception->commit();
        Yii::$app->session->setFlash('success', "User saved successfully");
        return $this->redirect(Yii::$app->request->referrer);
      } catch (Exception $ex) {
        Yii::$app->session->setFlash('warning', $ex->getMessage());
        $transaction_exception->rollBack();
        return $this->redirect(Yii::$app->request->referrer);
      }
    }

    return $this->render('form', [
      'model' => $model,
    ]);
  }

  public function actionValidation($id = null)
  {

    $model = $id === null ? new User() : User::findOne($id);
    if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
      Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
      return \yii\widgets\ActiveForm::validate($model);
    }
  }
}
