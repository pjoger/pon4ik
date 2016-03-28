<?php
use yii\helpers\Html;
use yii\helpers\Url;
//use yii\widgets\LinkPager;
//use yii\i18n\Formatter;
$this->registerCssFile('/css/project_view.css');

Yii::$app->formatter->numberFormatterOptions = [
  NumberFormatter::MIN_FRACTION_DIGITS => 0,
  NumberFormatter::MAX_FRACTION_DIGITS => 0,
];

$this->title = 'Проект по сбору средств на проект по сбору средств';
?>
<div class="project">
  <h1><?php echo $project->name ?></h1>
  <div class="photo" style="background: url(/img/projects/<?php echo $project->id ?>.jpg) center center;">
    <!-- <img src="/img/projects/1.jpg" width="770" height="300"/> -->
  </div>
  <div class="info">
    <div class="odometer">
      <?php
        echo Yii::$app->formatter->asCurrency($project->collected,'RUB');
      ?>
    </div>
    <div class="progressbar">
      <div class="curr_progress" style="width: <?php echo round(328*$project->collected/$project->price) ?>px;"></div>
    </div>
    <ul class="infobox">
      <li>
        <div class="string">
          <?php echo yii::t('app/project','Required amount'); ?>
        </div>
        <div class="value"><?php
          echo Yii::$app->formatter->asCurrency($project->price,'RUB');
        ?></div>
      </li>
      <li>
        <div class="string">
          <?php echo yii::t('app/project','Left'); ?>
        </div>
        <div class="value"><?php
          $days = $project->daysLeft;
          echo $days.' '.yii::t('app/project','{0, plural, one{day} other{days}}',$days);
        ?></div>
      </li>
      <li>
      <?php
        echo '<div class="string">'
                .yii::t('app/project','Suported')
              .'</div>
              <div class="value">'
                .$persons.' '.yii::t('app/project','{0, plural, one{person} other{persons}}',$persons)
              .'</div>';
      ?>
      </li>
      <li>
        <div class="string">
          <?php echo yii::t('app/project','Started'); ?>
        </div>
        <div class="value"><?php
          echo date('Y-m-d', strtotime($project->created_at));
        ?></div>
      </li>
    </ul>
    <div class='clear'></div>
    <?=
      Html::a(yii::t('app/project','Donnate'),
              Url::toRoute(['order/index', 'project' => $project->id]),
              ['class' => 'donnate']);
    ?>
  </div>
  <div class="descr clear">
    <p><?php echo $project->description ?></p>
  </div>
</div>
