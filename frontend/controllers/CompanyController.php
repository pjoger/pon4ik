<?php

namespace frontend\controllers;
//use Yii;
use yii\web\Controller;
use yii\web\Request;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;
use common\models\Company;
/**
 * Description of ProjectController
 *
 * @author pj
 */
class CompanyController extends Controller
{
    public function actionIndex()
    {
      if (\Yii::$app->user->isGuest){
        throw new NotFoundHttpException;
      } else {
        $query = Company::findByUser(\Yii::$app->user->getId());

        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $query->count(),
        ]);

        $companies = $query->orderBy('created_at DESC')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('index', [
            'companies' => $companies,
            'pagination' => $pagination,
        ]);
      }
    }

    public function actionView($id) {
      $company = Company::findOne($id);
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
      if ($company === null) {
        throw new NotFoundHttpException;
      }

      return $this->render('view', [
        'company' => $company,
        //'persons' => $project->getOrders()->select('user_id')->distinct()->count(),
      ]);
    }
    public function actionUpdate($id=0)
    {
//      $out = ['status' => 'err', 'error' => 'Unknown error'];
      if (\Yii::$app->user->isGuest) {
        throw new NotFoundHttpException;
      }

      $r = new Request;
      if ($r->post('Company')['id']){
        $id = $r->post('Company')['id'];
      }
//      vd($r->post('Company'));
      $userID = \Yii::$app->user->getId();
      if ($id){
        $company = Company::findOne(['id' => $id, 'user_id' => $userID]);
      } else {
        $company = new Company;
//        \Yii::$app->session->setFlash('error', 'Company ID is required.');
//        $this->redirect(array('view','id'=>$company));
//        $this->redirect(array('index'));
//        return;
      }
//        vd($company);
      if ($company){
        if ($company->load($r->post())){
          $company->user_id = $userID;

          if ($company->validate() && $company->save()) {
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
             \Yii::$app->session->setFlash('error', array_values($company->errors)[0][0]);
//          $out['error'] = array_values($order->errors)[0][0];
          //vd($order->errors);
         }
        }
      } else {
        \Yii::$app->session->setFlash('error', 'Такой компании не существует');
        $this->redirect(array('index'));
        return;
      }
      return $this->render('update', [
        'company' => $company,
        //'persons' => $project->getOrders()->select('user_id')->distinct()->count(),
      ]);
//      \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
//      return $out;
      /*vd(['get' => $r->getQueryParams() ,
          'post' => $r->post(),
          'order' => $order],1); //*/
    }
}
