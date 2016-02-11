<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
?>
<h1>Projects</h1>
<ul>
<?php foreach ($projects as $project): ?>
  <li>
    <?= Html::encode("{$project->name} ({$country->created_at})") ?>:
    <?= $project->population ?>
  </li>
<?php endforeach; ?>
</ul>

<?= LinkPager::widget(['pagination' => $pagination]) ?>
