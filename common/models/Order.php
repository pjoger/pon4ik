<?php

namespace common\models;
use yii\db\ActiveRecord;

class Order extends ActiveRecord {
  //put your code here

/*  public function fields(){
    return ['id' => 'id'];
  }
 *
 */
  public function getProject(){
    return $this->hasOne(Order::className(), ['id' => 'project_id']);
  }
}
