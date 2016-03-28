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
$this->registerJsFile('/js/order.js');

?>

<div class="project_donnate">
  <h1><?php echo yii::t('app/project','Donnate for').' «'.$project->name.'»' ?></h1>
  <!-- <div>
    <iframe frameborder="0" allowtransparency="true" scrolling="no" src="https://money.yandex.ru/embed/donate.xml?account=410011424722348&quickpay=donate&payment-type-choice=on&mobile-payment-type-choice=on&default-sum=350&targets=%D0%9F%D0%BE%D0%B4%D0%B4%D0%B5%D1%80%D0%B6%D0%BA%D0%B0&target-visibility=on&project-name=pon4ik&project-site=pon4ik.pj&button-text=05&fio=on&mail=on&successURL=http%3A%2F%2Fpon4ik.pj%2Findex.php%3Fr%3Dorder%252Fsuccesspay%26project%3D1" width="509" height="117"></iframe>
  </div>
  -->
  <div>
    <?php
      //vd($order);
      $form = ActiveForm::begin([
          'id' => 'order-form',
          'action' => Url::toRoute(['order/create'])
      ]);
      echo $form->field($order, 'project_id')->hiddenInput()->label(false);
      echo $form->field($order, 'price')->textInput(['value' => 250]);
      if ($signup){
        echo $form->field($signup, 'email');
      }
      echo Html::submitButton('Поддержать');
      ActiveForm::end();
       //*/
      ?>
      <hr/><hr/>

  </div>

  <div>
<!--    <form id="yd-form" action="https://money.yandex.ru/eshop.xml" method="post"> -->
    <form id="yd-form" action="/?r=order%2Fyadopay" method="post">
      <input name="shopId" value="1234" type="hidden"/>
      <input name="scid" value="4321" type="hidden"/>
      <input name="sum" value="100.50" type="text">
      <input name="orderSumAmount" value="300" type="text">
      <input name="orderSumCurrencyPaycash" value="RUB" type="text">
      <input name="orderSumBankPaycash" value="123" type="text">
      <input name="invoiceId" value="123" type="text">
      <input name="customerNumber" value="abc000" type="hidden"/>
      <input name="shopArticleId" value="567890" type="hidden"/>
      <input name="paymentType" value="AC" type="hidden"/>
      <input name="orderNumber" value="abc1111111" type="hidden"/>
<!--      <input name="cps_phone" value="79110000000" type="hidden"/> -->
      <input name="cps_email" value="user@domain.com" type="hidden"/>
      <input name="md5" value="9C36FE3816896EA943079A0822398001" type="hidden"/>
      <input name="action" value="paymentAviso" type="hidden"/>
      <input type="submit" value="Заплатить"/>
    </form>
  </div>
</div>