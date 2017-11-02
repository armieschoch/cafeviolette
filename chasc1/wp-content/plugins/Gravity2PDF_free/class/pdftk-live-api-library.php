<?php
define( "API_URL" , "https://www.gravity2pdf.com/gravity2pdfPDFTKSERVER/pdfprocessing.php" );
function curlOps( $action , $extraparameters , $file = "" , $filename = "" , $filetype = "" )
{
	// initialise the curl request
	$request = curl_init( API_URL );
	// send a file
	curl_setopt( $request , CURLOPT_POST , true );
	curl_setopt( $request , CURLOPT_POSTFIELDS , true );
	$post_array = array( 'action' => $action );

	foreach( $extraparameters as $key => $value )
	{
		$post_array[$key] = $value;
	}
	if( $file ) {
		//curl_setopt( $ch , CURLOPT_SAFE_UPLOAD , false );
		if ((version_compare(PHP_VERSION, '5.5') >= 0)) {
			$post_array['file_contents'] = new CURLFile( $file , $filetype , $filename );
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_SAFE_UPLOAD, true);
		} else {
			$post_array['file_contents'] = '@' . $file.";filename=".$filename.";type=".$filetype ;
		}
		//		curl_setopt( $request , CURLOPT_POSTFIELDS , array( 'file_contents' => '@'. $file . ';filename=' . $filename ) );
	}

	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($request , CURLOPT_POSTFIELDS , $post_array );
	// output the response
	curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($request);
	if( $result === false )
	{
		// echo "CURL _ERROR = ";
		// print_r ( curl_error( $request ) );
	}
	else
	{
		return $result;
	}
	// close the session
	curl_close($request);

}

function getPdfFields( $pdffile , $pdffilename , $pdffiletype )
{
	return curlOps( "getpdffields" , array() , $pdffile , $pdffilename , $pdffiletype);
}

function generateEndPdf( $pdffile , $pdffilename , $pdfformfields , $flattenpdf , $passwordthepdf , $pdfpassword = "" )
{
	$pdffiletype = "application/pdf";
	return curlOps( 'fillpdfform' , array( 'pdfformfields' => $pdfformfields , 'flattenpdf' => $flattenpdf , 'passwordthepdf' => $passwordthepdf , 'pdfpassword' => $pdfpassword ) , $pdffile , $pdffilename , $pdffiletype  );
}
?>
