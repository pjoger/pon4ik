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
//vd($project,1);
?>

<div class="project_donnate">
  <h1><?php echo yii::t('app/project','Donnate for').' «'.$project->name.'»' ?></h1>
  <div>
    <iframe frameborder="0" allowtransparency="true" scrolling="no" src="https://money.yandex.ru/embed/donate.xml?account=410011424722348&quickpay=donate&payment-type-choice=on&mobile-payment-type-choice=on&default-sum=350&targets=%D0%9F%D0%BE%D0%B4%D0%B4%D0%B5%D1%80%D0%B6%D0%BA%D0%B0&target-visibility=on&project-name=pon4ik&project-site=pon4ik.pj&button-text=05&fio=on&mail=on&successURL=http%3A%2F%2Fpon4ik.pj%2Findex.php%3Fr%3Dorder%252Fsuccesspay%26project%3D1" width="509" height="117"></iframe>
  </div>
</div>