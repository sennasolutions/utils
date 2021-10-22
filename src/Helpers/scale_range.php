<?php

namespace Senna\Utils\Helpers;

function scale_range( $value, $min, $max, $new_min, $new_max, array $bezier_curve = null ) {
    $value = ( $value - $min ) / ( $max - $min );
    $value = $bezier_curve ? bezier_curve( $value, $bezier_curve ) : $value;
    return $new_min + ( $new_max - $new_min ) * $value;
}

function bezier_curve( $value, array $bezier_curve ) {
    $p0 = $bezier_curve[0];
    $p1 = $bezier_curve[1];
    $p2 = $bezier_curve[2];
    $p3 = $bezier_curve[3];
    $t  = $value;
    return ( $p0 * pow( 1 - $t, 3 ) ) + ( 3 * $p1 * $t * pow( 1 - $t, 2 ) ) + ( 3 * $p2 * pow( $t, 2 ) * ( 1 - $t ) ) + ( $p3 * pow( $t, 3 ) );
}
