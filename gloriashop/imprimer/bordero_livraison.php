<?php
	include('db.php');

	$sql0='SELECT * FROM transaction,transdetail,operation,acteur WHERE transaction.acteur=acteur.tel AND transaction.idtrans=transdetail.trans AND transaction.operation=operation.idope AND dttrans="'.$_GET['date'].'" AND libope="retrait"';
	$req0=mysql_query($sql0) or die (mysql_error());
	echo '<h1>Point du '.$_GET['date'].'</h1>';
	$total=0;
	echo '<table border="0" width="800" bgcolor="#DDDDDD" cellspacing="1" cellpadding="4">';
	echo '<tr><td colspan="3" bgcolor="#FFFFFF"><b>RETRAIT</b></td></tr>';
	echo '<tr><td width="250"><b>Designation</b></td><td><b>Motif</b></td><td width="120"><b>Montant</b></td></tr>';
	while($dt0=mysql_fetch_array($req0))
	{
		echo '<tr><td bgcolor="#FFFFFF">'.$dt0['nom'].'</td><td bgcolor="#FFFFFF">'.$dt0['motif'].'</td><td bgcolor="#FFFFFF">'.number_format($dt0['mtant'], 0, ' ', ' ').'</td></tr>';
		$total=$total+$dt0['mtant'];
	}
	echo '<tr><td colspan="2" align="right"><b>Total = </b></td><td>'.$total.'</td></tr>';
	echo '</table><br>';
	
	
	$sql1='SELECT * FROM transaction,transdetail,operation,acteur WHERE transaction.acteur=acteur.tel AND transaction.idtrans=transdetail.trans AND transaction.operation=operation.idope AND dttrans="'.$_GET['date'].'" AND libope="decaissement"';
	$req1=mysql_query($sql1) or die (mysql_error());
	$nb1=mysql_num_rows($req1);
	$total1=0;
	echo '<table border="0" width="800" bgcolor="#DDDDDD" cellspacing="1" cellpadding="4">';
	echo '<tr><td colspan="3" bgcolor="#FFFFFF"><b>DECAISSEMENT</b></td></tr>';
	if($nb1==0)
	{
		echo '<tr><td colspan="3" bgcolor="#FFFFFF" align="center" height="50">Pas de decaissements enregistres</td></tr>';
	}else{
		echo '<tr><td width="250"><b>Designation</b></td><td><b>Motif</b></td><td width="120"><b>Montant</b></td></tr>';
		while($dt1=mysql_fetch_array($req1))
		{
			echo '<tr><td bgcolor="#FFFFFF">'.$dt1['nom'].'</td><td bgcolor="#FFFFFF">'.$dt1['motif'].'</td><td bgcolor="#FFFFFF">'.$dt1['mtant'].'</td></tr>';
			$total1=$total1+$dt1['mtant'];
		}
		echo '<tr><td colspan="2" align="right"><b>Total = </b></td><td>'.$total1.'</td></tr>';
	}
	echo '</table>';
?>