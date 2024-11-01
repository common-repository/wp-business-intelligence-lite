<canvas id="js-cj-radar-container-<?=$chartId?>"></canvas>

<?php if (!empty($options['caption']) && $caption != 'off') : ?>
  <div class="js-cj-radar-chart-caption"><span><?=$options['caption']?></span></div>
<?php endif; ?>

<script type="text/javascript">
var ctx = document.getElementById('js-cj-radar-container-<?=$chartId?>');

var colors = britechartsColors().colorSchemas.<?php echo (isset($options['color_scheme']) ? $options['color_scheme'] : 'random'); ?>;
<?php if (!isset($options['color_scheme']) || $options['color_scheme'] == 'random') { ?>
  var rounding = Math.floor(Math.random() * colors.length);
<?php } else { ?>
  var rounding = Math.round(colors.length/2);
<?php } ?>

var myChart = new Chart(ctx, {
    type: 'radar',
    data: {
      labels: <?=$chartLabels?>,
      datasets: [{
        label: '<?=$options['cname']?>',
        data: <?=$chartData?>,
        fill: true,
        backgroundColor: colors[colors.length - rounding],
        borderColor: colors[colors.length - rounding]
      }]
    },
    options: {
      x: {
        stacked: true,
      }
    }
});
</script>
