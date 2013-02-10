<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>

<?php foreach ($readings as $dow => $verses): ?>
    <h4 class='bible_dow'><?php echo $daysofweek[$dow]; ?></h4>
    <?php foreach ($verses as $verse): ?>
    <h5 class='bible_verse'><?php echo $verse; ?></h5>
    <?php endforeach; ?>
<?php endforeach; ?>
<div class='bible_planinfo'><?php echo $plan_information; ?></div>