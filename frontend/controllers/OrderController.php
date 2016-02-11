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
use yii\web\Controller;
use common\models\Project;

/**
 * Description of OrderController
 *
 * @author pj
 */
class OrderController extends Controller
{
    public function actionIndex($project)
    {
      $project_data = Project::findOne($project);

      return $this->render('index',[
        'project' => $project_data,
      ]);
    }
}
