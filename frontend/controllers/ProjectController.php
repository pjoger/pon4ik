<?php

namespace frontend\controllers;
use yii\web\Controller;
use yii\web\Request;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;
use common\models\Project;
/**
 * Description of ProjectController
 *
 * @author pj
 */
class ProjectController extends Controller
{
    public function actionIndex()
    {
        $query = Project::findInProgress();

        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $query->count(),
        ]);

        $projects = $query->orderBy('created_at DESC')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('index', [
            'projects' => $projects,
            'pagination' => $pagination,
        ]);
    }

    public function actionView($id) {
      $project = Project::findOne($id);
/*        ->select([
          'id','user_id', 'name', 'price', 'description', 'created_at',
          'DaysLeft'
        ])->one();
 *
 */
//      $project = Project::getProject($id);
//      $cmd = yii::$app->db->createCommand('SELECT 123');
/*      $project = Project::findBySql('
        SELECT p.id, p.user_id, p.name, p.price, p.description, p.created_at,
          timestampdiff(DAY, NOW(), p.closed_at) AS left_day,
          COUNT(o.project_id) AS supported_persons
        FROM project AS p
          LEFT JOIN `order` AS o ON o.project_id = p.id
        WHERE p.id=1
      ')->one();
 *
 */
      //$project->persons = $project->getOrders()->select('user_id')->distinct()->count();
//var_dump($orders,2); die;
//$orders = $project->daysLeft;
//vd($project->orders->select()->count(),1); die;
      if ($project === null) {
        throw new NotFoundHttpException;
      }

      return $this->render('view', [
        'project' => $project,
        'persons' => $project->getOrders()->select('user_id')->distinct()->count(),
      ]);
    }
    public function actionMy() {
      if (\Yii::$app->user->isGuest){
        throw new NotFoundHttpException;
      } else {
        $query = Project::find();

        $pagination = new Pagination([
            'defaultPageSize' => 25,
            'totalCount' => $query->count(),
        ]);

        $projects = $query->where(['user_id' => \Yii::$app->user->getId()])
            ->orderBy('created_at DESC')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('my', [
            'projects' => $projects,
            'pagination' => $pagination,
        ]);
      }
    }

    public function actionUpdate($id=0)
    {
//      $out = ['status' => 'err', 'error' => 'Unknown error'];
      if (\Yii::$app->user->isGuest) {
        throw new NotFoundHttpException;
      }

      $r = new Request;
      if (isSet($r->post('Project')['id']) && $r->post('Project')['id']){
        $id = $r->post('Project')['id'];
      }
//      vd($r->post('Company'));
      $userID = \Yii::$app->user->getId();
      if ($id){
        $project = Project::findOne(['id' => $id, 'user_id' => $userID]);
      } else {
        $project = new Project;
//        \Yii::$app->session->setFlash('error', 'Company ID is required.');
//        $this->redirect(array('view','id'=>$company));
//        $this->redirect(array('index'));
//        return;
      }
//        vd($company);
      if ($project){
        if ($project->load($r->post())){
          $project->user_id = $userID;

          if ($project->validate() && $project->save()) {
            //vd([$r->post(),$order->attributes]);
//          $out = [
//            'status' => 'ok',
//            'order' => $order->id,
//            'user' => $order->user_id,
//            'sum' => $order->price / 100,
//          ];
//          $this->redirect(array('view','id'=>$company));
          } else {
//          vd($company->errors);
             \Yii::$app->session->setFlash('error', array_values($project->errors)[0][0]);
//          $out['error'] = array_values($order->errors)[0][0];
          //vd($order->errors);
         }
        }
      } else {
        \Yii::$app->session->setFlash('error', 'Такой проект не существует');
        $this->redirect(array('my'));
        return;
      }
      return $this->render('update', [
        'project' => $project,
        //'persons' => $project->getOrders()->select('user_id')->distinct()->count(),
      ]);
//      \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
//      return $out;
      /*vd(['get' => $r->getQueryParams() ,
          'post' => $r->post(),
          'order' => $order],1); //*/
    }

}
