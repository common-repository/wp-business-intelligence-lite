<canvas id="js-cj-doughnut-container-<?=$chartId?>"></canvas>

<?php if (!empty($options['caption']) && $caption != 'off') : ?>
  <div class="js-cj-doughnut-chart-caption"><span><?=$options['caption']?></span></div>
<?php endif; ?>

<script type="text/javascript">
var ctx = document.getElementById('js-cj-doughnut-container-<?=$chartId?>');
var myChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels: <?=$chartLabels?>,
      datasets: [{
        label: '<?=$options['cname']?>',
        data: <?=$chartData?>,
        fill: false,
        backgroundColor: britechartsColors().colorSchemas.<?php echo (isset($options['color_scheme']) ? $options['color_scheme'] : 'random'); ?>,
        borderColor: britechartsColors().colorSchemas.<?php echo (isset($options['color_scheme']) ? $options['color_scheme'] : 'random'); ?>
      }]
    },
    options: {
      responsive: true
    }
});
</script>
