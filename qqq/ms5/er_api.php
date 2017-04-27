<?
//error_reporting(0);

$state = 9989086;

function lcgg ($a, $c, $p)  {
		global $state;
        $result = ($state*$a) % $p;
		$state = $result;
		return $result;
}

		function draw($shape, $rate) {
			$alpha = $shape;
			$beta = $rate;
			if($alpha > 1) {
				$ainv = sqrt(2.0 * $alpha - 1.0);
				$bbb = $alpha - log(4.0);
				$ccc = $alpha + $ainv;
				while (true) {
					$u1 = abs(lcgg (16807, 0, 2147483647)) / 2147483647;
					if (!((1e-7 < $u1) && ($u1 < 0.9999999))) {
						continue;
					}
					$u2 = 1.0 - (abs(lcgg (16807, 0, 2147483647)) / 2147483647);
					$v = log($u1 / (1.0-$u1))/$ainv;
					$x = $alpha * exp($v);
					$z = $u1 * $u1 * $u2;
					$r = $bbb+$ccc*$v-$x;
					$SG_MAGICCONST = 1 + log(4.5);
					if ($r + $SG_MAGICCONST - 4.5*$z >= 0.0 || $r >= log($z)) {
						return $x * $beta;
					}
				}
			} else if ($alpha == 1.0) {
				$u = abs(lcgg (16807, 0, 2147483647)) / 2147483647;
				while ($u <= 1e-7) {
					$u = abs(lcgg (16807, 0, 2147483647)) / 2147483647;
				}
				return -log($u) * $beta;
			} else { // 0 < alpha < 1
				while (true) {
					$u3 = abs(lcgg (16807, 0, 2147483647)) / 2147483647;
					$b = (M_E + $alpha)/M_E;
					$p = $b*$u3;
					if ($p <= 1.0) {
						$x = pow($p, (1.0/$alpha));
					}
					else {
						$x = log(($b-$p)/$alpha);
					}
					$u4 = abs(lcgg (16807, 0, 2147483647)) / 2147483647;
					if ($p > 1.0) {
						if ($u4 <= pow($x, ($alpha - 1.0))) {
							break;
						}
					}
					else if ($u4 <= exp(-$x)) {
						break;
					}
				}
				return $x * $beta;
			}
		}


$countin = 14000;
$min = 1;
$max = 100;

$rarr = array();
$rrasp = array();
$rcount = array();

function gen($func) {

$countin = 1000;
$min = 1;
$max = 100;

$rarr = array();
$rrasp = array();
$rcount = array();
$rnum = array();

for ($i=1; $i<=100000; $i++) {
$rand = $func(1,4); // значения MINSTD
//echo $rand."\n";
@array_push($rarr, $rand);
}

$step = $max / $countin;

for ($i = 1; $i<=$countin; $i++) {
	$rrasp[$i] = array();
}

for ($i = 1; $i<=count($rarr); $i++) {
	$place = @$rarr[$i] / $step;
	$rplace = round($place, 0, PHP_ROUND_HALF_UP);
	@array_push($rrasp[$rplace], $rarr[$i]);
}

for ($i = 1; $i<=count($rrasp); $i++) {
	@array_push($rcount, count($rrasp[$i]));
}

return $rcount;

}
?>
<div id="container" style="min-width: 300px; height: 400px; margin: 0 auto"></div>
<div id="container2" style="min-width: 300px; height: 400px; margin: 0 auto"></div>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script>
Highcharts.chart('container2', {
    chart: {
        type: 'column'
    },
    title: {
        text: ''
    },
    subtitle: {
        text: ''
    },
    xAxis: [{
            //categories: categories,
            reversed: false,
            labels: {
                step: 1
            }
        }, { // mirror axis on right side
            opposite: true,
            reversed: false,
            //categories: categories,
            linkedTo: 0,
            labels: {
                step: 1
            }
        }],
    yAxis: {
            title: {
            text: 'Value'
        }
    },
    legend: {
        enabled: false
    },
    tooltip: {
        pointFormat: 'Population in 2008: <b>{point.y:.1f} millions</b>'
    },
    series: [{
        name: 'Populationp',
		id: 2,
        data: [
            <?
			$a = gen('draw');			
			foreach ($a as $k=>$v) {
				if ($v>0) {
				echo ("['$k', $v],");
				}
			}
			?>
        ],
        dataLabels: {
            enabled: false,
            rotation: -90,
            color: 'rgba(255, 0, 0, 0.50)',
            align: 'right',
            format: '{point.y:.1f}', // one decimal
            y: 10, // 10 pixels down from the top
            style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
            }
        }
    }]
});
</script>
