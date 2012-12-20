<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>

<?php foreach ($readings as $dow => $verses): ?>
    <div style="font-size: 125%; width: 100%; display: block;"><?php echo $daysofweek[$dow]; ?></div>
    <?php foreach ($verses as $verse): ?>
    <div style="width: 100%; display: block; text-indent: 25px;"><?php echo $verse; ?></div>
    <?php endforeach; ?>
<?php endforeach; ?>
<div style="font-size: 9px; text-align: center; margin-top: 5px;"><?php echo $plan_information; ?></div>