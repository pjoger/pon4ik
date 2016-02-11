<?php

namespace frontend\controllers;
use yii\web\Controller;
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
        $query = Project::find();

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
}
