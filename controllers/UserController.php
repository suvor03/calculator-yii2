<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\User;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\web\Response;


class UserController extends Controller
{
	public function behaviors()
	{
		 return [
			  'access' => [
					'class' => AccessControl::className(),
					'rules' => [
						 [
							  'actions' => ['update-roles', 'list', 'delete', 'update', 'profile'],
							  'allow' => true,
							  'roles' => ['super_admin'],
						 ],
						 [
							'actions' => ['update', 'delete', 'list', 'profile'],
							'allow' => true,
							'roles' => ['administrator'],
						],
						[
							'actions' => ['profile'],
							'allow' => true,
							'roles' => ['user'],
						],
					],
			  ],
		 ];
	}
	
	public function actionList()
{
    $users = User::find()->all();

  
    return $this->render('list', ['users' => $users]);
}

public function actionProfile()
	 {
		return $this->render('profile');
	 }

public function actionUpdateRoles($id)
    {
        if (!Yii::$app->user->can('super_admin')) {
            throw new ForbiddenHttpException('Доступ запрещен');
        }

        $user = User::findOne($id);

        if (!$user) {
            throw new NotFoundHttpException('Пользователь не найден');
        }

        $auth = Yii::$app->authManager;
        $userRole = $auth->getRole('user');
        $adminRole = $auth->getRole('administrator');

        if ($auth->checkAccess($user->id, 'user')) {
            $auth->revoke($userRole, $user->id);
            $auth->assign($adminRole, $user->id);
            Yii::$app->session->setFlash('success', 'Роль пользователя успешно изменена на administrator.');
        } elseif ($auth->checkAccess($user->id, 'administrator')) {
			$auth->revoke($adminRole, $user->id);
			$auth->assign($userRole, $user->id);
			Yii::$app->session->setFlash('success', 'Роль пользователя успешно изменена на user.');
		  }
		  else {
            Yii::$app->session->setFlash('info', 'Пользователь уже имеет роль administrator.');
        }

        return $this->redirect(['list']);
    }
	 public function actionUpdate($id)
{
    $user = User::findOne($id);
    if (!$user) {
        throw new NotFoundHttpException('Пользователь не найден');
    }

    if ($user->load(Yii::$app->request->post()) && $user->save()) {
        Yii::$app->session->setFlash('success', 'Данные пользователя успешно обновлены');
        return $this->redirect(['list']); // Перенаправляем на список пользователей после успешного обновления
    } else {
        Yii::$app->session->setFlash('error', 'Не удалось обновить данные пользователя');
    }

    return $this->render('update', ['user' => $user]);
}

public function actionDelete($id)
    {
        $user = User::findOne($id);

        if (!$user) {
            throw new NotFoundHttpException('Пользователь не найден');
        }

        // Удаляем пользователя из таблицы user
        $user->delete();

        // Удаляем роль пользователя из таблицы auth_assignment
        Yii::$app->db->createCommand()->delete('auth_assignment', ['user_id' => $user->id])->execute();

        return $this->redirect(['list']);
    }
}