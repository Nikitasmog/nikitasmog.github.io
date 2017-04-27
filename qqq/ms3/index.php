<?
//error_reporting(0);

$state = 9989087;

function lcgg ($a, $c, $p)  {
		global $state;
        $result = ($state*$a) % $p;
		$state = $result;
		return $result;
}

function normal_box() {
	$x = lcgg (16807, 0, 2147483647) / 2147483647;
	$y = lcgg (16807, 0, 2147483647) / 2147483647;
	$s = pow($x,2) + pow ($y,2);
	if ($s > 1 || $s == 0) {
		return;
	} else {
		return array($x * sqrt ((-2 * log($s)) / $s), $y * sqrt ((-2 * log($s)) / $s));
	}
}

function ratio_box() {
	$u = lcgg (16807, 0, 2147483647) / 2147483647;
	$v = lcgg (16807, 0, 2147483647) / 2147483647;
	
	$x = sqrt (8/exp(1)) * ($v - 0.5) / $u;
	if ((pow($x, 2) <= (-4*log($u))) /*&& (pow ($x,2) <= 5-4*exp(0.25)*$u)*/) 
	{
		return $x;
	}
}

function gen($func) {

$countin = 10000;
$min = 10;
$max = 100;

$rarr = array();
$rrasp = array();
$rcount = array();

for ($i=1; $i<=300000; $i++) {
$rand = $func(); // значения MINSTD
//echo $rand."\n";
if ($func == "normal_box") {
@array_push($rarr, $rand[0]);
@array_push($rarr, $rand[1]);
} else {
@array_push($rarr, $rand);
}
}

$step = $max / $countin;

for ($i = 1; $i<=$countin*2; $i++) {
	//$rrasp[$i] = array();
}

for ($i = 1; $i<=count($rarr); $i++) {
	$place = @$rarr[$i] / $step;
	//echo $rarr[$i];
	$rplace = round($place, 0, PHP_ROUND_HALF_UP);
	//echo $rplace."\n";
	if (is_null(@$rrasp[$rplace])) {
	$rrasp[$rplace] = array();
	}
	if (@$rarr[$i] != 0) {
	@array_push($rrasp[$rplace], $rarr[$i]);
	}
}

ksort($rrasp);

//print_r($rrasp);

foreach ($rrasp as $r) {
	@array_push($rcount, count($r));
}

return $rcount;

}
?>
<div id="container" style="min-width: 300px; height: 400px; margin: 0 auto"></div>
<div id="container2" style="min-width: 300px; height: 400px; margin: 0 auto"></div>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script>
Highcharts.chart('container', {
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
        name: 'Population',
		id: 1,
        data: [
            <?
			$a = gen('ratio_box');			
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
        name: 'Population',
		id: 1,
        data: [
            <?
			$a = gen('normal_box');			
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
