<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
//vd($projects);
?>
<h1>My Projects</h1>
<ul>
<?php foreach ($orders as $order): ?>
  <li>
    <?= Html::encode("{$order->id} {$order->project->name} ({$order->closed_at}) ".($order->price/100)) ?>
    <?php /* $project->load */ ?>
  </li>
<?php endforeach; ?>
</ul>

<?= LinkPager::widget(['pagination' => $pagination]) ?>
