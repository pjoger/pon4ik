<?php

/*
 * Copyright (C) 2016 pj
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace frontend\controllers;

use DateTime;
use Yii;
use yii\web\Controller;
use yii\data\Pagination;
use yii\web\Response;
use yii\web\Request;
use common\models\User;
use common\models\Project;
use common\models\Order;
use frontend\models\SignupForm;
use yii\db\Expression;

/**
 * Description of OrderController
 *
 * @author pj
 */
class OrderController extends Controller
{
    private $shopId;
    private $shopPass;

    public function beforeAction($action)
    {
      if ($action->id == 'yadopay') {
        $this->enableCsrfValidation = false;
        $this->shopId = Yii::$app->params['YAD']['shop_id'];
        $this->shopPass = Yii::$app->params['YAD']['shop_pass'];
      }

      return parent::beforeAction($action);
    }

    public function actionIndex($project)
    {
      $project_data = Project::findOne($project);
      //vd($order);

      return $this->render('index',[
          'project' => $project_data,
          'order' => new Order(['project_id' => $project_data->id]),
          'signup' => \Yii::$app->user->isGuest ? new SignupForm : null,
      ]);
    }

    public function actionMy()
    {
      if (\Yii::$app->user->isGuest){
        throw new NotFoundHttpException;
      } else {
        $query = Order::find()->where(['and', ['user_id' => \Yii::$app->user->getId()],['not', ['closed_at' => null]]]);

        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $query->count(),
        ]);

        $orders = $query->with('project')->orderBy('closed_at DESC')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
//        vd($orders);

        return $this->render('my', [
            'orders' => $orders,
            'pagination' => $pagination,
        ]);
      }
    }

    public function actionSuccesspay()
    {
//      vd(['get' => Yii::$app->request->getQueryParams() ,
//          'post' => Yii::$app->request->getBodyParams()],1);
      $r = new Request;
      //Yii::info(\yii\helpers\Json::encode($requestData), 'apiRequest');
      \Yii::info('[DEBUG_ME]'.print_r(['get' => $r->getQueryParams() , 'post' => $r->getBodyParams()],true), 'appDebug');
      if ($r->post('action')) vd(['get' => $r->getQueryParams() , 'post' => $r->getBodyParams()],1);
      $order = Order::findOne($r->post('orderNumber'));
      if ($order){

      } else {
        vd($order);
      }
      $project = $order->project;
      return $this->render('successpay',[
        'project' => $project,
      ]);
    }

    public function actionCreate()
    {
      $out = ['status' => 'err', 'error' => 'Unknown error'];
      $order = new Order;
      $r = new Request;
      if ($order->load($r->post())){
        $order->price = $order->price * 100;
        // $user = \Yii::$app->user;
        if (\Yii::$app->user->isGuest){
          if ($user = User::findByEmail($r->post('SignupForm')['email']) ){
            $order->user_id = $user->getId();
          } else {
            $signup = new SignupForm();
            if ($signup->load($r->post())){
              $signup->username = $signup->email;
              $signup->password = User::MakePass(7);
              if ($user = $signup->signup()) {
                $order->user_id = $user->getId();
              } else {
                $out['error'] = array_values($signup->errors)[0][0];
              }
            } else {
              //vd($signup->errors,1);
            }
          }
        } else {
          $order->user_id = \Yii::$app->user->getId();
        }

        if ($order->validate() && $order->save()) {
          //vd([$r->post(),$order->attributes]);
          $out = [
            'status' => 'ok',
            'order' => $order->id,
            'user' => $order->user_id,
            'sum' => $order->price / 100,
          ];
        } else {
          $out['error'] = array_values($order->errors)[0][0];
          //vd($order->errors);
        }
      }
      //vd($out);
      \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
      return $out;
      //return BaseJson::encode($out,JSON_PRETTY_PRINT);
      /*vd(['get' => $r->getQueryParams() ,
          'post' => $r->post(),
          'order' => $order],1); //*/
    }

    public function actionYadopay() {
      \Yii::info('start', 'app/payments/yad');
      $r = new Request;
      $param = $r->post();
      $code = 0;
      $err_msg = null;
      $order = null;
      if (!$this->checkMD5($param)) {
        // кривой md5
        $code = 1;
        //$err_msg = '';
      } else {
        $order = Order::chkOrder($param['orderNumber'], $param['customerNumber']);
        if ($order){
          // ордер нашелся
          if ($order->price < $param['orderSumAmount']*100){
            // и даже сумма норм
            if ($param['action'] == 'paymentAviso' && !$order->closed_at){
              // это уже сам платеж и ордер не закрыт еще
              // значит надо закрыть
              $order->price = $param['orderSumAmount']*100;
              $order->closed_at = new Expression('NOW()');
              if ($order->validate() && $order->save()){
                // ok, все сохранилось
              } else {
                // что-то пошло не так
                $code = 200;
                $err_msg = array_values($order->errors)[0][0];
                //vd($order->errors);
              }
            }
          } else {
            // сумма неправильная
            $err_msg = 'Неверная сумма';
          }
        } else {
          // нет такого ордера
          $err_msg = 'Платеж не найден';
        }
      }

      if (!$code && $err_msg){
        $code = 100;
      }
//      \Yii::$app->response->format = \yii\web\Response::FORMAT_XML;
      $response = \Yii::$app->response;
      $response->format = Response::FORMAT_RAW;
      $response->getHeaders()->set('Content-Type', 'application/xml; charset=utf-8');
//      return $this->render('sitemap');
      return $this->buildResponse($param['action'], $param['invoiceId'], $code, $err_msg);
      return $this->render('yadopay',[
        'response' => [
            'action' => $param['action'],
            'invoiceId' => $param['invoiceId'],
            'code' => $code,
            'msg' => $err_msg,
            'shopId' => $this->shopId,
        ],
        'rrr' => [
            'param' => $param,
            'order' => $order,
        ]
      ]);
    }

    private function checkMD5($request) {
      $str = join(';',[
          $request['action'],
          $request['orderSumAmount'],
          $request['orderSumCurrencyPaycash'],
          $request['orderSumBankPaycash'],
          $request['shopId'],
          $request['invoiceId'],
          $request['customerNumber'],
          $this->shopPass
      ]);
      $md5 = strtoupper(md5($str));
      if ($md5 != strtoupper($request['md5'])) {
          \Yii::error('wrong md5: '.$md5.', recieved md5: '.$request['md5'], 'app/payments/yad');
          return false;
      }
      return true;
    }

/**
 * Building XML response.
 * @param  string $functionName  "checkOrder" or "paymentAviso" string
 * @param  string $invoiceId     transaction number
 * @param  string $result_code   result code
 * @param  string $message       error message. May be null.
 * @return string                prepared XML response
 */
  private function buildResponse($functionName, $invoiceId, $result_code, $message = null) {
    $date = new DateTime();
//    $response = [
//      'performedDatetime' => $date->format('Y-m-d H:i:s'),
//      'code' => $result_code,
//      'invoiceId' => $invoiceId,
//      'shopId' => $this->shopId,
//    ];
//    if ($message != null){
//      $response['message'] = $message;
//    }
    return '<?xml version="1.0" encoding="UTF-8"?><'
        .$functionName.'Response performedDatetime="'.$date->format('Y-m-d H:i:s')
        .'" code="'.$result_code
        .'" '.($message != null ? 'message="' . $message . '"' : "")
        .' invoiceId="'.$invoiceId
        .'" shopId="'.$this->shopId
      .'"/>';
  }

}
