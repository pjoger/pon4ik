<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
//vd($projects);
?>
<h1>My Projects</h1>
<ul>
<?php foreach ($projects as $project): ?>
  <li>
    <?= Html::encode("{$project->name} ({$project->created_at})") ?>:
    <?php /* $project->load */ ?>
  </li>
<?php endforeach; ?>
</ul>

<?= LinkPager::widget(['pagination' => $pagination]) ?>
