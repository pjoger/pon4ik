<?php

namespace common\models;
use yii\db\ActiveRecord;

class Company extends ActiveRecord {
  //put your code here
  public function rules()
  {
      return [
          //
          [['user_id', 'name', 'inn','phone'], 'required'],
          //
          [[ 'user_id' ], 'integer', 'min' => 1 ],
          //
          [['ogrn','inn','kpp','ogrn','rs','ks','bik'], 'number'],
          //
          ['inn', 'string', 'length' => [10,12]],
          //
          ['inn','unique','targetAttribute' => ['user_id','inn'], 'message' => 'Вы уже использовали такой ИНН'],
          //
          ['kpp', 'string', 'length' => 9],
          //
          ['ogrn', 'string', 'length' => 13],
          //
          [['rs','ks'], 'string', 'length' => 20],
          //
          ['bik', 'string', 'length' => 9],
          //
          [[ 'fio_director' ], 'string', 'max' => 255 ],
          //
          [[ 'phone' ], 'string', 'max' => 20 ],
          //
//          ['price', 'integer', 'min' => 1 ],
      ];
  }

  public static function findByUser($user)
  {
    return static::find()
      ->where([ 'user_id' => $user]);
  }

  
}
