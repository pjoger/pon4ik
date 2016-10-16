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

/**
 * Description of index
 *
 * @author pj
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
//$this->registerJsFile('/js/order.js');

?>

<div class="company_update">
  <h1><?php echo yii::t('app/company','Company manager').($company->id ? ' «'.$company->name.'»' : '') ?></h1>
  <div>
    <?php
//      vd($company);
      $form = ActiveForm::begin([
          'id' => 'company-form',
          'action' => Url::toRoute(['company/update'])
      ]);
      echo $form->field($company, 'id')->hiddenInput()->label(false);
      echo $form->field($company, 'name')->textInput();
      echo $form->field($company, 'inn')->textInput();
      echo $form->field($company, 'kpp')->textInput();
      echo $form->field($company, 'ogrn')->textInput();
      echo $form->field($company, 'phone')->textInput();
//      echo $form->field($order, 'price')->textInput(['value' => 250]);
      echo Html::submitButton('Сохранить');
      ActiveForm::end();
       //*/
      ?>
      <hr/><hr/>

  </div>

</div>