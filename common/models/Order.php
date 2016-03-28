<?php

namespace common\models;
use yii\db\ActiveRecord;

class Order extends ActiveRecord {

  //public $price;

  public function rules()
  {
      return [
          //
          [['project_id', 'price', 'user_id'], 'required'],
          //
          [[ 'project_id', 'user_id' ], 'integer', 'min' => 1 ],
          ['project_id', 'validateProject'],
          //
          ['price', 'integer', 'min' => 1 ],
      ];
  }

  public function getProject(){
    return $this->hasOne(Project::className(), ['id' => 'project_id']);
  }

  public function validateProject($attribute)
  {
    if (!$this->project) {
      $this->addError($attribute,\yii::t('app/order','Unknown project'));
    }
  }

  public static function chkOrder($id, $user)
  {
    return static::findOne(['id' => $id, 'user_id' => $user]);
  }

}
