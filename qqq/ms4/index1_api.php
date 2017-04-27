<?
if ($_GET["type"] != "erlang") {
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

function draw() {
			$alpha = array_key_exists('a',$_REQUEST) ? ($_REQUEST['a'] > 0) ? $_REQUEST['a'] : 3 : 3;
			$beta = array_key_exists('b',$_REQUEST) ? ($_REQUEST['b'] > 0) ? $_REQUEST['b'] : 1 : 1;
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


if ($_GET["type"] == "erlang") {
$countin = 14000;
$min = 1;
$max = 100;
} else {
$countin = 140;
$min = 10;
$max = 100;
}

$rarr = array();
$rrasp = array();
$rcount = array();

$hl = rand(1,1000);

function gen($func, $hl) {

if ($_GET["type"] == "erlang") {
$countin = 1000;
$min = 1;
$max = 100;
} else {
	$countin = 40;
$min = 10;
$max = 100;
}


$rarr = array();
$rrasp = array();
$rcount = array();

$ecount = array_key_exists('count',$_REQUEST) ? ($_REQUEST['count'] > 0) ? $_REQUEST['count'] : 100000 : 100000;

for ($i=1; $i<=$ecount; $i++) {
$rand = $func($hl); // значения MINSTD
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


return $rarr;

}

if ($_GET["type"]) {

switch ($_GET["type"]) {
			case "hyper":
			$a = gen('hyperexp', $hl);			
			foreach ($a as $v) {
				if ($v>0.0005) {
				echo (number_format($v,10).";");
				}
			}
			break;
			
			case "exp":
			$a = gen('expo', $hl);			
			foreach ($a as $v) {
				if ($v>0.0005) {
				echo (number_format($v,10).";");
				}
			}
			break;
			
			case "erlang":
			$a = gen('draw', $hl);			
			foreach ($a as $v) {
				if ($v>0) {
				echo ($v.";");
				}
			}
			break;
}
}
}
else {
//error_reporting(0);

$state = 9989086;

function lcgg ($a, $c, $p)  {
		global $state;
        $result = ($state*$a) % $p;
		$state = $result;
		return $result;
}

		function draw($shape, $rate) {
			$alpha = array_key_exists('a',$_REQUEST) ? ($_REQUEST['a'] > 0) ? $_REQUEST['a'] : 3 : 3;
			$beta = array_key_exists('b',$_REQUEST) ? ($_REQUEST['b'] > 0) ? $_REQUEST['b'] : 1 : 1;
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

return $rarr;

}


			$a = gen('draw');			
			foreach ($a as $k=>$v) {
				if ($v>0) {
				echo (($v/100).";");
				}
			}
}
?>			