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
 * Description of successpay
 *
 * @author pj
 */

/*
vd(['get' => Yii::$app->getRequest()->getQueryParams() ,
    'post' => Yii::$app->request->getBodyParams()],1);
 *
 */

?>

<h1>Завершение платежа</h1>
<div>Спасибо за поддержку!</div>
<?php
  vd(['success',$project]);
?>
    <form name="test" action="/index.php?r=order%2Fsuccesspay&project=1&t=xxx" method="POST">
      <input type="hidden" name="action" value="test"/>
      <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
      <input type="text" name="t" value="ger"/><br/>
      <input type="submit" name="OK" value="OK2"/>
    </form>

