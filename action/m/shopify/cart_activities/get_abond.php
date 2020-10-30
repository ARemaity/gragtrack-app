<?php


require_once (dirname(__FILE__,5)).'/base.php';
require_once  (dirname(__FILE__,5)).'/'.DIR_INC.'List_Util.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(isset($_SESSION['AID'])):
    $path_to_json=(dirname(__FILE__,5)).'/webhook/user/'.$_SESSION['AID'].'/json/abond_cart.json';
function filterArray( $array, $allowed = [] ) {
	return array_filter(
		$array,
		function ( $val, $key ) use ( $allowed ) { // N.b. $val, $key not $key, $val
			return isset( $allowed[ $key ] ) && ( $allowed[ $key ] === true || $allowed[ $key ] === $val );
		},
		ARRAY_FILTER_USE_BOTH
	);
}

function filterKeyword( $data, $search, $field = '' ) {
	$filter = '';
	if ( isset( $search['value'] ) ) {
		$filter = $search['value'];
	}
	if ( ! empty( $filter ) ) {
		if ( ! empty( $field ) ) {
			if ( strpos( strtolower( $field ), 'date' ) !== false ) {
				// filter by date range
				$data = filterByDateRange( $data, $filter, $field );
			} else {
				// filter by column
				$data = array_filter( $data, function ( $a ) use ( $field, $filter ) {
					return (boolean) preg_match( "/$filter/i", $a[ $field ] );
				} );
			}

		} else {
			// general filter
			$data = array_filter( $data, function ( $a ) use ( $filter ) {
				return (boolean) preg_grep( "/$filter/i", (array) $a );
			} );
		}
	}

	return $data;
}

function filterByDateRange( $data, $filter, $field ) {
	// filter by range
	if ( ! empty( $range = array_filter( explode( '|', $filter ) ) ) ) {
		$filter = $range;
	}

	if ( is_array( $filter ) ) {
		foreach ( $filter as &$date ) {
			// hardcoded date format
			$date = date_create_from_format( 'm/d/Y', stripcslashes( $date ) );
		}
		// filter by date range
		$data = array_filter( $data, function ( $a ) use ( $field, $filter ) {
			// hardcoded date format
			$current = date_create_from_format( 'm/d/Y', $a[ $field ] );
			$from    = $filter[0];
			$to      = $filter[1];
			if ( $from <= $current && $to >= $current ) {
				return true;
			}

			return false;
		} );
	}

	return $data;
}

$columnsDefault = [
    'id'=>true,
    'cart_name'=>true,
    'link'=>true,
    'email'=>true,
    'total_price'=>true,
    'created_at'=>true,
    'name'=>true,
    'customer_id'=>true



];

if ( isset( $_REQUEST['columnsDef'] ) && is_array( $_REQUEST['columnsDef'] ) ) {
	$columnsDefault = [];
	foreach ( $_REQUEST['columnsDef'] as $field ) {
		$columnsDefault[ $field ] = true;
	}
}

// get all raw data
$alldata = json_decode( file_get_contents( $path_to_json ), true );
$data = [];
/*
/
/if isdata==1 work else echo empty
/
*/
if($alldata['isdata']=='1'){
	foreach ( $alldata['data'] as $d ) {
		$data[] = filterArray( $d, $columnsDefault );
	}
	// internal use; filter selected columns only from raw data

// count data
$totalRecords = $totalDisplay = count( $data );

// filter by general search keyword
if ( isset( $_REQUEST['search'] ) ) {
	$data         = filterKeyword( $data, $_REQUEST['search'] );
	$totalDisplay = count( $data );
}

if ( isset( $_REQUEST['columns'] ) && is_array( $_REQUEST['columns'] ) ) {
	foreach ( $_REQUEST['columns'] as $column ) {
		if ( isset( $column['search'] ) ) {
			$data         = filterKeyword( $data, $column['search'], $column['data'] );
			$totalDisplay = count( $data );
		}
	}
}

// sort
if ( isset( $_REQUEST['order'][0]['column'] ) && $_REQUEST['order'][0]['dir'] ) {
	$column = $_REQUEST['order'][0]['column'];
	$dir    = $_REQUEST['order'][0]['dir'];
	usort( $data, function ( $a, $b ) use ( $column, $dir ) {
		$a = array_slice( $a, $column, 1 );
		$b = array_slice( $b, $column, 1 );
		$a = array_pop( $a );
		$b = array_pop( $b );

		if ( $dir === 'asc' ) {
			return $a > $b ? true : false;
		}

		return $a < $b ? true : false;
	} );
}

// pagination length
if ( isset( $_REQUEST['length'] ) ) {
	$data = array_splice( $data, $_REQUEST['start'], $_REQUEST['length'] );
}

// return array values only without the keys
if ( isset( $_REQUEST['array_values'] ) && $_REQUEST['array_values'] ) {
	$tmp  = $data;
	$data = [];
	foreach ( $tmp as $d ) {
		$data[] = array_values( $d );
	}
}

$secho = 0;
if ( isset( $_REQUEST['sEcho'] ) ) {
	$secho = intval( $_REQUEST['sEcho'] );
}

$result = [
	'iTotalRecords'        => $totalRecords,
	'iTotalDisplayRecords' => $totalDisplay,
	'sEcho'                => $secho,
	'aaData'               => $data,
];

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');

echo json_encode( $result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);


	/*
/
/if isdata==0 echo empty array 
/
*/
}else{
	$result = [
		'iTotalRecords'        => 0,
		'iTotalDisplayRecords' => 0,
		'sEcho'                => 0,
		'aaData'               => $data,
	];
	
	header('Content-Type: application/json');
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
	header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');
	

	echo json_encode( $result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
	
	


}


endif;