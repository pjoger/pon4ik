<?php

namespace common\models;
use yii\db\ActiveRecord;

class Project extends ActiveRecord {
  //put your code here

/*  public function fields(){
    return ['id' => 'id'];
  }
 *
 */
  public function getDaysLeft(){
    $diff = strtotime($this->closed_at) - time();
    if ($diff < 0) {
      $diff = 0;
    } else {
      $diff = floor($diff / 60 / 60 / 24);
    }
    return $diff;
  }
  public function getOrders(){
    return $this->hasMany(Order::className(), ['project_id' => 'id']);
  }
}
