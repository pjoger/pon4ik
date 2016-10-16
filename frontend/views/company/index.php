<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
vd($companies);
?>
<h1>Companies</h1>
<ul>
<?php foreach ($companies as $company): ?>
  <li>
    <?= Html::encode("{$company->name} ({$company->created_at})") ?>:
    <?php /* $project->load */ ?>
  </li>
<?php endforeach; ?>
</ul>

<?= LinkPager::widget(['pagination' => $pagination]) ?>
