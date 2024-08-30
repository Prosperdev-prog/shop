<?php
	include('../sdpanel/db.php');	
	?>
		<html>
			<head>
				<meta http-equiv="content-type" content="text/html" charset="utf-8" />
				<link rel="SHORTCUT ICON" href="../picture/icone.ico">
			</head>
	<?php
	$_SESSION['sdaff']='<br><br><br><br><br><br><div class="inter0">';
	$_SESSION['sdaff'].='<table border="0" width="700" bgcolor="#CCCCCC" cellspacing="1" cellpadding="4">';
	$_SESSION['sdaff'].='<tr><td colspan="3" bgcolor="#FFFFFF" style="font-size:25"><b>'.strtoupper($_GET['libope']).'</b></td></tr>';
	$_SESSION['sdaff'].='<tr><td bgcolor="#FAFAFE" width="100">&nbsp;&nbsp;<b>Date :</b> </td><td bgcolor="#FFFFFF">'.$_GET['dtfac'].'</td><td bgcolor="#FAFAFE" align="center" rowspan="4" style="font-family:barcode font; font-size:65">'.$_GET['idfac'].'</td></tr>';
	$_SESSION['sdaff'].='<tr><td bgcolor="#FAFAFE">&nbsp;&nbsp;<b>Reglement :</b> </td><td bgcolor="#FFFFFF">'.$_GET['libreg'].'&nbsp;</td></tr>';
	$_SESSION['sdaff'].='<tr><td bgcolor="#FAFAFE">&nbsp;&nbsp;<b>Client :</b> </td><td bgcolor="#FFFFFF">'.$_GET['steclt'].'</td></tr>';
	$_SESSION['sdaff'].='<tr><td bgcolor="#FAFAFE">&nbsp;&nbsp;<b>Telephone :</b> </td><td bgcolor="#FFFFFF">'.$_GET['telclt'].'</td></tr>';
	$_SESSION['sdaff'].='</table>';
	$_SESSION['sdaff'].='</div><br>';
	$sql1='SELECT * FROM faclist,produit,prodlist WHERE produit.idprod=prodlist.prod AND prodlist.idpdlist=faclist.prodfac AND facture="'.$_GET['idfac'].'"';
	$req1=mysql_query($sql1);
	$_SESSION['sdaff'].='<div class="inter0">';
	$_SESSION['sdaff'].='<table border="0" width="700" bgcolor="#CCCCCC" cellspacing="1" cellpadding="4">';
	$_SESSION['sdaff'].='<tr><td bgcolor="#FAFAFE"><b>Designation</b></td><td bgcolor="#FAFAFE"><b>PrixHT</b></td><td bgcolor="#FAFAFE"><b>TVA</b></td><td bgcolor="#FAFAFE"><b>Rm</b></td><td bgcolor="#FAFAFE"><b>Qtite</b></td><td bgcolor="#FAFAFE"><b>RmHT</b></td><td bgcolor="#FAFAFE"><b>MtHT</b></td></tr>';
	$bht=0;$btc=0;
	while($dt1=mysql_fetch_array($req1))
	{
		$mt=$dt1['qtfac']*$dt1['prixuht'];
		$rmht=($mt*$dt1['rmfac']/100);
		$mtht=$mt-$rmht;
		$_SESSION['sdaff'].='<tr><td bgcolor="#FFFFFF">'.$dt1['desiprod'].'</td><td bgcolor="#FFFFFF">'.$dt1['prixuht'].'</td><td bgcolor="#FFFFFF">'.$dt1['tva'].'</td><td bgcolor="#FFFFFF">'.$dt1['rmfac'].'</td><td bgcolor="#FFFFFF">'.$dt1['qtfac'].'</td><td bgcolor="#FFFFFF">'.$rmht.'</td><td bgcolor="#FFFFFF">'.$mtht.'</td></tr>';
		if($dt1['tva']==0)
		{
			$bht=$bht+$mtht;
			$taxht=$dt1['tva'];
		}else{
			$btc=$btc+$mtht;
			$taxtc=$dt1['tva'];
		}
	}
	$_SESSION['sdaff'].='</table>';
	$_SESSION['sdaff'].='</div><br>';
	$acompte=0;
	$tvaht=$bht*$taxht;
	$tvatc=$btc*$taxtc;
	$totalht=$bht+$btc;
	$totaltc=$totalht+$tvatc;
	$netpaye=$totaltc-$acompte;
	$_SESSION['sdaff'].='<div class="inter0">';
	$_SESSION['sdaff'].='<table border="0" width="700" bgcolor="#CCCCCC" cellspacing="1" cellpadding="4">';
	$_SESSION['sdaff'].='<tr><td bgcolor="#FAFAFE" colspan="2"><b>Base HT</b></td><td bgcolor="#FAFAFE"><b>Remise SF</b></td><td bgcolor="#FAFAFE"><b>MT TVA</b></td><td bgcolor="#FAFAFE"><b>Total HT</b></td><td bgcolor="#FAFAFE"><b>Total TC</b></td><td bgcolor="#FAFAFE"><b>Acompte</b></td><td bgcolor="#FAFAFE"><b>Net a payer</b></td></tr>';
	$_SESSION['sdaff'].='<tr><td bgcolor="#FFFFFF">0</td><td bgcolor="#FFFFFF">'.$bht.'</td><td bgcolor="#FFFFFF" rowspan="2">Tx : '.$_SESSION['rmfac'].' %<br>'.$_GET['rf'].'</td><td bgcolor="#FFFFFF">'.$tvaht.'</td><td bgcolor="#FFFFFF" rowspan="2">'.$totalht.'</td><td bgcolor="#FFFFFF" rowspan="2">'.$totaltc.'</td><td bgcolor="#FFFFFF" rowspan="2">'.$acompte.'</td><td bgcolor="#FFFFFF" rowspan="2">'.$netpaye.'</td></tr>';
	$_SESSION['sdaff'].='<tr><td bgcolor="#FFFFFF">0,18</td><td bgcolor="#FFFFFF">'.$btc.'</td><td bgcolor="#FFFFFF">'.$tvatc.'</td></tr>';
	$_SESSION['sdaff'].='</table>';
	$_SESSION['sdaff'].='</div>';
	echo $_SESSION['sdaff'];
?>
</html>