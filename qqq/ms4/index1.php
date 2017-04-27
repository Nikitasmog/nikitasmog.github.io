<?
error_reporting(0);

$state = 9989087;

function lcgg ($a, $c, $p)  {
		global $state;
        $result = ($state*$a) % $p;
		$state = $result;
		return $result;
}

function expo($hl) {
	$rand = abs(lcgg (16807, 0, 2147483647)) / 2147483647;
	return ($hl*exp(-$hl*$rand));
}

function hyperexp($hl) {
	$rand = abs(lcgg (16807, 0, 2147483647)) / 2147483647;
	$raterand = abs(lcgg (16807, 0, 2147483647)) / 2147483647;
	
	
	return (2*$hl*pow($raterand,2)*exp(-2*$hl*$raterand*$rand) - 2*$hl*(pow(1-$raterand, 2))*exp(-2*$hl*(1-$raterand)*$rand));
}

$countin = 140;
$min = 10;
$max = 100;

$rarr = array();
$rrasp = array();
$rcount = array();

$hl = rand(1,1000);

function gen($func, $hl) {

$countin = 40;
$min = 10;
$max = 100;

$rarr = array();
$rrasp = array();
$rcount = array();

for ($i=1; $i<=100000; $i++) {
$rand = $func($hl); // значения MINSTD
//echo $rand."\n";
@array_push($rarr, $rand);
}

$step = $max / $countin;

for ($i = 1; $i<=$countin; $i++) {
	$rrasp[$i] = array();
}

for ($i = 1; $i<=count($rarr); $i++) {
	$place = $rarr[$i] / $step;
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
        name: 'Population',
		id: 1,
        data: [
            <?
			$a = gen('hyperexp', $hl);			
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
    }, {
        name: 'Populationp',
		id: 2,
        data: [
            <?
			$a = gen('expo', $hl);			
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
