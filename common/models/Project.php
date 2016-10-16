<?php

namespace common\models;
use yii\db\ActiveRecord;
use yii\db\Expression;

class Project extends ActiveRecord {

  public function rules()
  {
      return [
          //
          [['user_id', 'name', 'price'], 'required'],
          //
          [[ 'user_id' ], 'integer', 'min' => 1 ],
          //
          ['name', 'string', 'max' => 255],
          //
          ['price', 'integer', 'min' => 1],
          //
          ['description', 'string'],
      ];
  }

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
  public static function findInProgress()
  {
    return static::find()
      ->where([ 'and', ['status' => 'collect'], ['>','closed_at', new Expression('NOW()')] ]);
  }
}
