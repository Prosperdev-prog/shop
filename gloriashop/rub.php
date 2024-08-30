<?php
	include('./sdpanel/db.php');
	function deconnexion()
	{
		$_SESSION['tel']="";
		$_SESSION['pass']="";
		$_SESSION['nom']="";
		$_SESSION['profil']="";
		session_unset();
		session_destroy();
		header('Location: index.php');
	}
	function navig()
	{
		$sql0='SELECT * FROM soft WHERE libsoft="gestock" || libsoft="facturation" || libsoft="clientele"';
		$req0=mysql_query($sql0);
		$nb0=mysql_num_rows($req0);
		$_SESSION['menu']='';
		$l=1;$k=0;
		while($dt0=mysql_fetch_array($req0))
		{
			if($l==1)
			{
				$_SESSION['menu'].='<div class="pub2">';
				$_SESSION['menu'].='<div class="l'.$l.'"><br><a href="index.php?fct='.$dt0['libsoft'].'">'.strtoupper($dt0['libsoft']).'</a></div>';
				$l=2;
			}else
			{
				$_SESSION['menu'].='<div class="l'.$l.'"><br><a href="index.php?fct='.$dt0['libsoft'].'">'.strtoupper($dt0['libsoft']).'</a></div>';
				$_SESSION['menu'].='<div class="sepa"></div>';
				$_SESSION['menu'].='</div>';
				if($k==0)
				{
					$_SESSION['menu'].='<div class="pub1">'.$_SESSION['ctmenu'].'</div>';
					$k=1;
				}
				$l=1;
			}
		}
		if(ceil($nb0/2)!=($nb0/2)) $_SESSION['menu'].='</div>';
	}
	function clientele()
	{
		$_SESSION['ctmenu']='<center><img src="./sdpanel/picture/logo.png"></center>';
		$_SESSION['sdaff']='';
		navig();
		$_SESSION['sdaff']='';
		$_SESSION['sdaff'].='<div class="inter1">';
		$_SESSION['sdaff'].='<ul>';
		$_SESSION['sdaff'].='<li><a href="index.php?fct=clientele&rub=null&ope=form">Ajouter un client</a></li>';
		$_SESSION['sdaff'].='</ul>';
		$_SESSION['sdaff'].='</div>';
		if($_GET['ope']=='form')
		{
			$_SESSION['sdaff'].='<div class="inter0">';
			$_SESSION['sdaff'].='<table border="0" width="100%" bgcolor="#CCCCCC" cellspacing="1" cellpadding="4">';
			$_SESSION['sdaff'].='<tr><td colspan="3" bgcolor="#FAFAFE">&nbsp;&nbsp;<font size="4"><b>Formulaire des clients</b></font></td></tr>';
			$_SESSION['sdaff'].='<tr><td align="right" bgcolor="#FFFFFF">Nom / prenom : </td><td bgcolor="#FFFFFF"><input type="text" name="tn1" value="'.$_GET['nomclt'].'"></td></tr>';
			if($_GET['task']=='modif')
			{
				$_SESSION['sdaff'].='<tr><td align="right" bgcolor="#FFFFFF">Tel : </td><td bgcolor="#FFFFFF"><input type="text" name="tn2" value="'.$_GET['telclt'].'" readonly> *</td></tr>';
				$_SESSION['sdaff'].='<tr><td width="100" bgcolor="#FFFFFF">&nbsp;</td><td bgcolor="#FFFFFF"><input type="hidden" name="tn0" value="'.$_GET['telclt'].'"><input type="submit" name="bt1" value="modif_client"></td></tr>';
			}else{
				$_SESSION['sdaff'].='<tr><td align="right" bgcolor="#FFFFFF">Tel : </td><td bgcolor="#FFFFFF"><input type="text" name="tn2"> *</td></tr>';
				$_SESSION['sdaff'].='<tr><td width="100" bgcolor="#FFFFFF">&nbsp;</td><td bgcolor="#FFFFFF"><input type="submit" name="bt1" value="add_client"></td></tr>';
			}
			$_SESSION['sdaff'].='<tr><td colspan="2" bgcolor="#FAFAFE" align="center" style="color:#FF0000">&nbsp;'.$_GET['etat'].'&nbsp;</td></tr>';
			$_SESSION['sdaff'].='</table>';
			$_SESSION['sdaff'].='</div>';
		}else{
			if($_GET['task']=='supp')
			{
				$sql2='SELECT * FROM facture WHERE cltfac="'.$_GET['telclt'].'"';
				$req2=mysql_query($sql2) or die (mysql_error());
				$nb2=mysql_num_rows($req2);
				if($nb2==0)
				{
					$sql1='DELETE FROM client WHERE telclt="'.$_GET['telclt'].'"';
					$req1=mysql_query($sql1) or die (mysql_error());
				}else{
					$_SESSION['sdaff'].='<div class="inter0">';
					$_SESSION['sdaff'].='<table border="0" width="100%" bgcolor="#CCCCCC" cellspacing="1" cellpadding="4">';
					$_SESSION['sdaff'].='<tr><td bgcolor="#FFFFFF" height="50" align="center"><h1>Attention !</h1>Il est impossible d\'&eacute;ffectuer cette op&eacute;ration car des factures sont enregistr&eacute;es au nom de ce client<br><br></td></tr>';
					$_SESSION['sdaff'].='</table>';
					$_SESSION['sdaff'].='</div>';
				}
			}
			$sql0='SELECT * FROM client ORDER BY nomclt ASC';
			$req0=mysql_query($sql0);
			$nb0=mysql_num_rows($req0);
			$_SESSION['sdaff'].='<div class="inter3">';
			$_SESSION['sdaff'].='<div class="toobar">CLIENTELE : : LISTE DES CLIENTS</div>';
			$_SESSION['sdaff'].='<table border="0" width="100%" bgcolor="#FFFFFF" cellspacing="1" cellpadding="4">';
			if($nb0==0)
			{
				$_SESSION['sdaff'].='<tr><td align="center" height="100">Pas de client enregistr&eacute;s</td></tr>';
			}else
			{
				$_SESSION['sdaff'].='<tr><td width="25" bgcolor="#B2B9C3">&nbsp;</td><td bgcolor="#B2B9C3"><b>Nom et prenom</b></td><td bgcolor="#B2B9C3"><b>T&eacute;l&eacute;phone</b></td><td bgcolor="#B2B9C3" colspan="2" align="center"><img src="./sdpanel/picture/1.png"></td></tr>';
				$bg="#DDDDDD";
				while($dt0=mysql_fetch_array($req0))
				{
					$_SESSION['sdaff'].='<tr><td bgcolor="'.$bg.'" width="25" align="center"><input type="checkbox"></td><td bgcolor="'.$bg.'">'.$dt0['nomclt'].'</td><td bgcolor="'.$bg.'">'.$dt0['telclt'].'</td><td bgcolor="'.$bg.'" align="center" width="25"><a href="index.php?fct=clientele&rub=null&ope=form&task=modif&nomclt='.$dt0['nomclt'].'&telclt='.$dt0['telclt'].'" title="modifier"><img src="./sdpanel/picture/2.png" border="0"></a></td><td bgcolor="'.$bg.'" align="center" width="25"><a href="index.php?fct=clientele&rub=null&task=supp&telclt='.$dt0['telclt'].'" onclick="if(! confirm(\'Supprimer ce client ?\')) return false;" title="Supprimer"><img src="./sdpanel/picture/3.png"></a></td></tr>';
					if($bg=="#DDDDDD") $bg="#EEEEEE"; else $bg="#DDDDDD";
				}
			}
			$_SESSION['sdaff'].='</table>';
			$_SESSION['sdaff'].='<div class="refbar"><b>Total enregistrements : </b>'.$nb0.'</div>';
			$_SESSION['sdaff'].='</div>';
		}
	}
	function gestock()
	{
		$_SESSION['ctmenu']='<center><img src="./sdpanel/picture/logo.png"></center>';
		navig();
		$_SESSION['sdaff']='';
		$sql0='SELECT * FROM produit ORDER BY libprod ASC';
		$req0=mysql_query($sql0) or die(mysql_error());
		$nb0=mysql_num_rows($req0);
		$_SESSION['sdaff'].='<div class="inter3">';
		$_SESSION['sdaff'].='<div class="toobar">GESTION DU STOCK : : LISTE DES PRODUITS</div>';
		$_SESSION['sdaff'].='<table border="0" width="100%" bgcolor="#FFFFFF" cellspacing="1" cellpadding="4">';
		if($nb0==0)
		{
			$_SESSION['sdaff'].='<tr><td align="center" height="100"><b>Pas de produits disponibles</b></td></tr>';
		}else
		{
			$_SESSION['sdaff'].='<tr><td bgcolor="#B2B9C3">&nbsp;</td><td bgcolor="#B2B9C3"><b>Designation</b></td><td bgcolor="#B2B9C3"><b>Quantite</b></td><td bgcolor="#B2B9C3"><b>Prix</b></td></tr>';
			$bg="#DDDDDD";
			while($dt0=mysql_fetch_array($req0))
			{
				$_SESSION['sdaff'].='<tr><td bgcolor="'.$bg.'" align="center" width="25"><a href="#" title="En savoir plus"><img src="./sdpanel/picture/2.png" border="0"></a></td><td bgcolor="'.$bg.'">'.$dt0['libprod'].'</td><td bgcolor="'.$bg.'">'.$dt0['qtprod'].'</td><td bgcolor="'.$bg.'">'.$dt0['mtprod'].'</td></tr>';
				if($bg=="#DDDDDD") $bg="#EEEEEE"; else $bg="#DDDDDD";
			}
		}
		$_SESSION['sdaff'].='</table>';
		$_SESSION['sdaff'].='<div class="refbar"><b>Total enregistrements : </b>'.$nb0.'</div>';
		$_SESSION['sdaff'].='</div>';
	}
	function facturation()
	{
		/*
			Auteur : OLORY Suzon
			Agence des Technologies Nouvelles
		*/
		$_SESSION['ctmenu']='<center><img src="./sdpanel/picture/logo.png"></center>';
		navig();
		$_SESSION['sdaff']='';
		$_SESSION['sdaff'].='<div class="inter1">';
		$_SESSION['sdaff'].='<ul>';
		$_SESSION['sdaff'].='<li><a href="index.php?fct=facturation&rub=edition&ope=form&init=ok">Editer</a></li>';
		$_SESSION['sdaff'].='</ul>';
		$_SESSION['sdaff'].='</div>';
		
		if($_GET['rub']=='edition')
		{
			if($_GET['ope']=='form')
			{
				if($_GET['init']=='ok')
				{
					unset($_SESSION['idprod']);
					unset($_SESSION['libprod']);
					unset($_SESSION['taxe']);
					unset($_SESSION['mtprod']);
					unset($_SESSION['qt']);
					unset($_SESSION['qtstk']);
					unset($_SESSION['telclt']);
					unset($_SESSION['nomclt']);
					unset($_SESSION['numfact']);
					unset($_SESSION['erreur']);
					unset($_SESSION['mt']);
				}
				$_SESSION['sdaff'].='<div class="inter0">';
				$_SESSION['sdaff'].='<table border="0" width="100%" bgcolor="#CCCCCC" cellspacing="1" cellpadding="4">';
				if($_GET['add']=='client')
				{
					$_SESSION['numfac']=date('YmdHis');
					$_SESSION['telclt']=$_GET['telclt'];
					$_SESSION['nomclt']=$_GET['nomclt'];
				}elseif($_GET['add']=='prod')
				{
					$etat=0;
					for($j=1; $j<=sizeof($_SESSION['idprod']); $j++)
					{
						if($_SESSION['idprod'][$j]==$_GET['idprod'])
						{
							$etat=1;
						}
					}
					if($etat==0)
					{
						$ind=sizeof($_SESSION['idprod'])+1;
						$_SESSION['idprod'][$ind]=$_GET['idprod'];
						$_SESSION['libprod'][$ind]=$_GET['libprod'];
						$_SESSION['taxe'][$ind]=$_GET['taxe'];
						$_SESSION['mtprod'][$ind]=$_GET['mtprod'];
						$_SESSION['qtstk'][$ind]=$_GET['qtprod'];
						$_SESSION['qt'][$ind]=1;
						$_SESSION['mt'][$ind]=$_SESSION['qt'][$ind]*$_SESSION['mtprod'][$ind];
					}
				}elseif($_GET['add']=='supp')
				{
					$p=$_SESSION['idprod'][$_GET['chp']];
					$_SESSION['idprod'][$_GET['chp']]=$_SESSION['idprod'][sizeof($_SESSION['idprod'])];
					$_SESSION['idprod'][sizeof($_SESSION['idprod'])]=$p;
					
					$u=$_SESSION['libprod'][$_GET['chp']];
					$_SESSION['libprod'][$_GET['chp']]=$_SESSION['libprod'][sizeof($_SESSION['libprod'])];
					$_SESSION['libprod'][sizeof($_SESSION['libprod'])]=$u;
					
					$q=$_SESSION['taxe'][$_GET['chp']];
					$_SESSION['taxe'][$_GET['chp']]=$_SESSION['taxe'][sizeof($_SESSION['taxe'])];
					$_SESSION['taxe'][sizeof($_SESSION['taxe'])]=$q;
					
					$r=$_SESSION['mtprod'][$_GET['chp']];
					$_SESSION['mtprod'][$_GET['chp']]=$_SESSION['mtprod'][sizeof($_SESSION['mtprod'])];
					$_SESSION['mtprod'][sizeof($_SESSION['mtprod'])]=$r;
					
					$t=$_SESSION['qt'][$_GET['chp']];
					$_SESSION['qt'][$_GET['chp']]=$_SESSION['qt'][sizeof($_SESSION['qt'])];
					$_SESSION['qt'][sizeof($_SESSION['qt'])]=$t;
					
					$v=$_SESSION['qtstk'][$_GET['chp']];
					$_SESSION['qtstk'][$_GET['chp']]=$_SESSION['qtstk'][sizeof($_SESSION['qtstk'])];
					$_SESSION['qtstk'][sizeof($_SESSION['qtstk'])]=$v;
					
					unset($_SESSION['idprod'][sizeof($_SESSION['idprod'])]);
					unset($_SESSION['libprod'][sizeof($_SESSION['libprod'])]);
					unset($_SESSION['taxe'][sizeof($_SESSION['taxe'])]);
					unset($_SESSION['mtprod'][sizeof($_SESSION['mtprod'])]);
					unset($_SESSION['mt'][sizeof($_SESSION['mt'])]);
					unset($_SESSION['qt'][sizeof($_SESSION['qt'])]);
					unset($_SESSION['qtstk'][sizeof($_SESSION['qtstk'])]);
				}
				if($_SESSION['telclt'])
				{
					$_SESSION['sdaff'].='<tr><td colspan="3" bgcolor="#FAFAFE"><b>&nbsp;&nbsp;&nbsp;&nbsp;: : &nbsp; &nbsp; FACTURE N° &nbsp; &nbsp; : : &nbsp; &nbsp; '.$_SESSION['numfac'].'</b></td></tr>';
					$_SESSION['sdaff'].='<tr><td align="right" bgcolor="#FFFFFF" width="100"><b>Societe : </b></td><td bgcolor="#FFFFFF">'.$_SESSION['nomclt'].'</td></tr>';
					$_SESSION['sdaff'].='<tr><td align="right" bgcolor="#FFFFFF" width="100"><b>Telephone : </b></td><td bgcolor="#FFFFFF">'.$_SESSION['telclt'].'</td></tr>';
					$_SESSION['sdaff'].='<tr><td align="right" bgcolor="#FFFFFF" width="100"><b>Date : </b></td><td bgcolor="#FFFFFF">'.date('Y-m-d').'</td></tr>';
					$_SESSION['sdaff'].='</table>';
					$_SESSION['sdaff'].='</div>';
					$_SESSION['sdaff'].='<div class="inter0">';
					$_SESSION['sdaff'].='<table border="0" width="100%" bgcolor="#CCCCCC" cellspacing="1" cellpadding="4">';
					if($_SESSION['idprod'])
					{
						$_SESSION['sdaff'].='<tr><td colspan="10" bgcolor="#FAFAFE"><b>&nbsp;&nbsp;&nbsp;&nbsp;: : &nbsp; &nbsp; </b><a href="index.php?fct=facturation&rub=edition&ope=form&list=produit">Veuillez choisir les produits</a></td></tr>';
						$_SESSION['sdaff'].='<tr><td bgcolor="#FAFAFE" width="25">&nbsp;</td><td bgcolor="#FAFAFE"><b>Designation</b></td><td bgcolor="#FAFAFE" width="120"><b>Prix de vente</b></td><td bgcolor="#FAFAFE" width="60"><b>TVA</b></td><td bgcolor="#FAFAFE" width="120"><b>Quantite</b></td><td bgcolor="#FAFAFE" width="120"><b>En stock</b></td><td bgcolor="#FAFAFE" width="170"><b>Montant HT</b></td></tr>';
						$total=0;
						for($i=1; $i<=sizeof($_SESSION['idprod']); $i++)
						{
							if($_SESSION['erreur'][$i]!=0)
							{
								$_SESSION['qt'][$i]=$_SESSION['erreur'][$i];
								unset($_SESSION['mt']);
								$_SESSION['sdaff'].='<tr><td align="center" bgcolor="#FFBBBB"><a href="index.php?fct=facturation&rub=edition&ope=form&add=supp&chp='.$i.'" onclick="if(! confirm(\'Supprimer ce produit de la liste ?\')) return false;" title="Supprimer"><img src="./sdpanel/picture/3.png" border="0"></a></td><td bgcolor="#FFBBBB">'.$_SESSION['libprod'][$i].'</td><td bgcolor="#FFBBBB"><input type="text" value="'.$_SESSION['mtprod'][$i].'" name="p'.$i.'" style="width:100px;"></td><td bgcolor="#FFBBBB"><input type="text" value="'.$_SESSION['taxe'][$i].'" name="t'.$i.'" style="width:50px;"></td><td bgcolor="#FFBBBB"><input type="text" value="'.$_SESSION['qt'][$i].'" name="q'.$i.'" style="width:100px;"></td><td bgcolor="#FFBBBB"><input type="text" value="'.$_SESSION['qtstk'][$i].'" readonly style="width:100px; border:1px solid; text-align:right; background:#C9F2B9;"></td><td bgcolor="#FFBBBB"><input type="text" value="'.$_SESSION['mt'][$i].'" readonly style="width:150px;"></td></tr>';
							}else{
								$_SESSION['sdaff'].='<tr><td align="center" bgcolor="#FFFFFF"><a href="index.php?fct=facturation&rub=edition&ope=form&add=supp&chp='.$i.'" onclick="if(! confirm(\'Supprimer ce produit de la liste ?\')) return false;" title="Supprimer"><img src="./sdpanel/picture/3.png" border="0"></a></td><td bgcolor="#FFFFFF">'.$_SESSION['libprod'][$i].'</td><td bgcolor="#FFFFFF"><input type="text" value="'.$_SESSION['mtprod'][$i].'" name="p'.$i.'" style="width:100px;"></td><td bgcolor="#FFFFFF"><input type="text" value="'.$_SESSION['taxe'][$i].'" name="t'.$i.'" style="width:50px;"></td><td bgcolor="#FFFFFF"><input type="text" value="'.$_SESSION['qt'][$i].'" name="q'.$i.'" style="width:100px;"></td><td bgcolor="#FFFFFF"><input type="text" value="'.$_SESSION['qtstk'][$i].'" readonly style="width:100px; border:1px solid; text-align:right; background:#C9F2B9;"></td><td bgcolor="#FFFFFF"><input type="text" value="'.$_SESSION['mt'][$i].'" readonly style="width:150px;"></td></tr>';
							}
							$total=$total+$_SESSION['mt'][$i];
						}
						$_SESSION['sdaff'].='<tr><td align="right" bgcolor="#FFFFFF" colspan="6" align="right" style="text-align:right; font-size:20px; font-weight:bold;">Total : </td><td bgcolor="#FFFFFF">'.$total.' FCFA</td></tr>';
						$_SESSION['sdaff'].='<tr><td bgcolor="#FFFFFF" colspan="2">&nbsp;</td><td bgcolor="#FFFFFF" colspan="6"><input type="submit" name="bt1" value="calculer"> <input type="submit" name="bt1" value="proforma"> <input type="submit" name="bt1" value="enregistrer"></td></tr>';
					}else{
						$_SESSION['sdaff'].='<tr><td colspan="4" bgcolor="#FAFAFE"><b>&nbsp;&nbsp;&nbsp;&nbsp;: : &nbsp; &nbsp; </b><a href="index.php?fct=facturation&rub=edition&ope=form&list=produit">Veuillez choisir les produits</a></td></tr>';
					}
				}else{
					$_SESSION['sdaff'].='<tr><td colspan="4" bgcolor="#FAFAFE"><b>&nbsp;&nbsp;&nbsp;&nbsp;: : &nbsp; &nbsp; </b><a href="index.php?fct=facturation&rub=edition&ope=form&list=client">Veuillez choisir un client</a></td></tr>';
				}
				$_SESSION['sdaff'].='</table>';
				$_SESSION['sdaff'].='</div>';
				
			}else{
				unset($_SESSION['idprod']);
				unset($_SESSION['libprod']);
				unset($_SESSION['taxe']);
				unset($_SESSION['mtprod']);
				unset($_SESSION['qt']);
				unset($_SESSION['qtstk']);
				unset($_SESSION['telclt']);
				unset($_SESSION['nomclt']);
				unset($_SESSION['numfact']);
			}
			if($_GET['list']=='client')
			{
				$sqlf='SELECT * FROM client ORDER BY nomclt ASC';
				$reqf=mysql_query($sqlf) or die(mysql_error());
				$nbf=mysql_num_rows($reqf);
				$_SESSION['sdaff'].='<div class="inter0">';
				$_SESSION['sdaff'].='<table border="0" width="100%" bgcolor="#CCCCCC" cellspacing="1" cellpadding="4">';
				if($nbf==0)
				{
					$_SESSION['sdaff'].='<tr><td align="center" height="50" bgcolor="#FAFAFE"><b>IMPOSSIBLE ! Clients non disponibles</b></td></tr>';
				}else{
					$_SESSION['sdaff'].='<tr><td width="25" align="center" bgcolor="#FAFAFE"><img src="./sdpanel/picture/3.png" title="Fermer le tableau" border="0"></td><td colspan="2" bgcolor="#FAFAFE"><b>LISTE DES CLIENTS</b></td></tr>';
					while($dtf=mysql_fetch_array($reqf))
					{
						$_SESSION['sdaff'].='<tr><td align="center" bgcolor="#FAFAFE"><a href="index.php?fct=facturation&rub=edition&ope=form&add=client&telclt='.$dtf['telclt'].'&nomclt='.$dtf['nomclt'].'"><img src="./sdpanel/picture/4.png" title="Ajouter" border="0"></a></td><td width="100" bgcolor="#FAFAFE">'.$dtf['telclt'].'</td><td bgcolor="#FAFAFE">'.$dtf['nomclt'].'</td></tr>';
					}
				}
				$_SESSION['sdaff'].='</table>';
				$_SESSION['sdaff'].='</div>';
			}elseif($_GET['list']=='produit')
			{
				$sqlf='SELECT * FROM produit,tva WHERE produit.taxe=tva.idtva AND qtprod>0 AND mtprod>0 ORDER BY libprod ASC';
				$reqf=mysql_query($sqlf) or die(mysql_error());
				$nbf=mysql_num_rows($reqf);
				$_SESSION['sdaff'].='<div class="inter0">';
				$_SESSION['sdaff'].='<table border="0" width="100%" bgcolor="#CCCCCC" cellspacing="1" cellpadding="4">';
				if($nbf==0)
				{
					$_SESSION['sdaff'].='<tr><td align="center" height="50" bgcolor="#FAFAFE"><b>IMPOSSIBLE ! Produits non disponibles</b></td></tr>';
				}else{
					$_SESSION['sdaff'].='<tr><td width="25" align="center" bgcolor="#FAFAFE"><img src="./sdpanel/picture/3.png" title="Fermer le tableau" border="0"></td><td bgcolor="#FAFAFE"><b>LISTES DES PRODUITS</b></td><td bgcolor="#FAFAFE"><b>PRIX</b></td><td bgcolor="#FAFAFE"><b>QTITE</b></td></tr>';
					while($dtf=mysql_fetch_array($reqf))
					{
						$_SESSION['sdaff'].='<tr><td align="center" bgcolor="#FAFAFE"><a href="index.php?fct=facturation&rub=edition&ope=form&add=prod&list=produit&idprod='.$dtf['idprod'].'&libprod='.$dtf['libprod'].'&mtprod='.$dtf['mtprod'].'&taxe='.$dtf['valtva'].'&qtprod='.$dtf['qtprod'].'"><img src="./sdpanel/picture/4.png" title="Ajouter" border="0"></a></td><td bgcolor="#FAFAFE">'.$dtf['libprod'].'</td><td bgcolor="#FAFAFE">'.$dtf['mtprod'].'</td><td bgcolor="#FAFAFE">'.$dtf['qtprod'].'</td></tr>';
					}
				}
				$_SESSION['sdaff'].='</table>';
				$_SESSION['sdaff'].='</div>';
			}
		}else{
			if($_GET['ope']=='situation')
			{
				$_SESSION['sdaff'].='<div class="inter0">';
				$_SESSION['sdaff'].='<table border="0" width="100%" bgcolor="#CCCCCC" cellspacing="1" cellpadding="4">';
				$_SESSION['sdaff'].='<tr><td colspan="2" bgcolor="#FFFFFF" style="font-size:25"><b>&nbsp;&nbsp;'.strtoupper($_GET['libope']).'</b></td><td bgcolor="#FFFFFF" align="right"> <a href="./imprimer/facture.php?&idope='.$_GET['idope'].'&libope='.$_GET['libope'].'&idfac='.$_GET['idfac'].'&dtfac='.$_GET['dtfac'].'&steclt='.$_GET['steclt'].'&telclt='.$_GET['telclt'].'&idreg='.$_GET['idreg'].'&libreg='.$_GET['libreg'].'" title="Imprimer"><img src="./sdpanel/picture/print.gif" border="0"></a> &nbsp; &nbsp; <a href="index.php?fct=facturation&rub=archive&ope=supp&idfac='.$_GET['idfac'].'" onclick="if(! confirm(\'Supprimer ce support ?\')) return false;" title="Supprimer"><img src="./sdpanel/picture/3.png" border="0"></a> &nbsp; &nbsp; </td></tr>';
				$_SESSION['sdaff'].='<tr><td bgcolor="#FAFAFE" width="100">&nbsp;&nbsp;&nbsp;&nbsp; <b>Date :</b> </td><td bgcolor="#FFFFFF">'.$_GET['dtfac'].'</td><td bgcolor="#FAFAFE" align="center" rowspan="3" style="font-family:barcode font; font-size:65">'.$_GET['idfac'].'</td></tr>';
				$_SESSION['sdaff'].='<tr><td bgcolor="#FAFAFE">&nbsp;&nbsp;&nbsp;&nbsp; <b>Client :</b> </td><td bgcolor="#FFFFFF">'.$_GET['nomclt'].'</td></tr>';
				$_SESSION['sdaff'].='<tr><td bgcolor="#FAFAFE">&nbsp;&nbsp;&nbsp;&nbsp; <b>Telephone :</b> </td><td bgcolor="#FFFFFF">'.$_GET['telclt'].'</td></tr>';
				$_SESSION['sdaff'].='</table>';
				$_SESSION['sdaff'].='</div>';
				$sql1='SELECT * FROM faclist,produit,tva WHERE produit.taxe=tva.idtva AND produit.idprod=faclist.prodfac AND facture="'.$_GET['idfac'].'"';
				$req1=mysql_query($sql1);
				$_SESSION['sdaff'].='<div class="inter0">';
				$_SESSION['sdaff'].='<table border="0" width="100%" bgcolor="#CCCCCC" cellspacing="1" cellpadding="4">';
				$_SESSION['sdaff'].='<tr><td bgcolor="#FAFAFE" width="25">&nbsp;</td><td bgcolor="#FAFAFE"><b>Designation</b></td><td bgcolor="#FAFAFE" width="100"><b>Prix U</b></td><td bgcolor="#FAFAFE" width="50"><b>TVA</b></td><td bgcolor="#FAFAFE" width="50"><b>Quantite</b></td><td bgcolor="#FAFAFE" width="150"><b>Montant</b></td></tr>';
				$cp=1;
				while($dt1=mysql_fetch_array($req1))
				{
					$mt=$dt1['qtfac']*$dt1['mtprod'];
					$_SESSION['sdaff'].='<tr><td bgcolor="#FFFFFF" align="center">'.$cp.'</td><td bgcolor="#FFFFFF">'.$dt1['libprod'].'</td><td bgcolor="#FFFFFF">'.$dt1['mtprod'].'</td><td bgcolor="#FFFFFF">'.$dt1['valtva'].'</td><td bgcolor="#FFFFFF">'.$dt1['qtfac'].'</td><td bgcolor="#FFFFFF">'.$mt.'</td></tr>';
					$cp++;
				}
				$_SESSION['sdaff'].='</table>';
				$_SESSION['sdaff'].='</div>';
			}elseif($_GET['ope']=='supp')
			{
				/*precision sur la suppression
				$sql1='DELETE FROM facture WHERE idfac="'.$_GET['idfac'].'"';
				$req1=mysql_query($sql1);
				$sql2='SELECT * FROM faclist WHERE facture="'.$_GET['idfac'].'"';
				$req2=mysql_query($sql2);
				//*/
			}
			$sql0='SELECT * FROM facture,client WHERE facture.cltfac=client.telclt ORDER BY dtfac DESC';
			$req0=mysql_query($sql0);
			$nb0=mysql_num_rows($req0);
			$_SESSION['sdaff'].='<div class="inter3">';
			$_SESSION['sdaff'].='<div class="toobar">FACTURATION : : LISTE DES FACTURES</div>';
			$_SESSION['sdaff'].='<table border="0" width="100%" bgcolor="#FFFFFF" cellspacing="1" cellpadding="4">';
			if($nb0==0)
			{
				$_SESSION['sdaff'].='<tr><td align="center" height="100"><b>Pas de facture en attente</b></td></tr>';
			}else
			{
				$_SESSION['sdaff'].='<tr><td width="25" bgcolor="#B2B9C3">&nbsp;</td><td bgcolor="#B2B9C3" width="100"><b>Date</b></td><td bgcolor="#B2B9C3"><b>Reference</b></td><td bgcolor="#B2B9C3"><b>Reglement</b></td></tr>';
				$bg="#DDDDDD";
				while($dt0=mysql_fetch_array($req0))
				{
					$_SESSION['sdaff'].='<tr><td bgcolor="'.$bg.'" width="25" align="center"><a href="index.php?fct=facturation&rub=null&ope=situation&idfac='.$dt0['idfac'].'&dtfac='.$dt0['dtfac'].'&telclt='.$dt0['telclt'].'&nomclt='.$dt0['nomclt'].'" title="apercu"><img src="./sdpanel/picture/2.png" border="0"></a></td><td bgcolor="'.$bg.'">'.$dt0['dtfac'].'</td><td bgcolor="'.$bg.'">'.$dt0['idfac'].'</td><td bgcolor="'.$bg.'">'.$dt0['steclt'].'</td></tr>';
					if($bg=="#DDDDDD") $bg="#EEEEEE"; else $bg="#DDDDDD";
				}
			}
			$_SESSION['sdaff'].='</table>';
			$_SESSION['sdaff'].='<div class="refbar"><b>Total enregistrements : </b>'.$nb0.'</div>';
			$_SESSION['sdaff'].='</div>';
		}
		$_SESSION['etat']='';
		$_SESSION['sdtitre']='SUDPANEL! FACTURATION';
	}
	function trafic()
	{
		/*
			Auteur : OLORY Suzon
			Agence des Technologies Nouvelles
		*/
		$oct=disk_free_space($_SERVER['DOCUMENT_ROOT'])/8;
		$_SESSION['ctmenu']='<center><img src="./sdpanel/picture/logo.png"></center>';
		//exec('ls -l /var/www/',$tab);
		//chmod('/var/www/aaaaa', 0777);
		//mkdir('/var/www/aaaaa', 0777);
		//exec('rm -r /var/www/aaaaa');
		//exec('sudo useradd -m -s /bin/bash -d /var/www/lola');
		navig();
		$_SESSION['sdaff']='';
		$_SESSION['sdaff'].='<div class="inter1">';
		$_SESSION['sdaff'].='<ul>';
		$_SESSION['sdaff'].='<li><a href="index.php?fct=trafic&rub=null&ope=form">Modifier votre mot de passe</a></li>';
		$_SESSION['sdaff'].='</ul>';
		$_SESSION['sdaff'].='</div>';
		if($_GET['ope']=='form')
		{
			$_SESSION['sdaff'].='<div class="inter0">';
			$_SESSION['sdaff'].='<table border="0" width="100%" bgcolor="#CCCCCC" cellspacing="1" cellpadding="4">';
			$_SESSION['sdaff'].='<tr><td colspan="3" bgcolor="#FAFAFE">&nbsp;&nbsp;<font size="4"><b>Mot de passe</b></font></td></tr>';
			$_SESSION['sdaff'].='<tr><td align="right" bgcolor="#FFFFFF">Ancien : </td><td bgcolor="#FFFFFF"><input type="password" name="tn1"></td></tr>';
			$_SESSION['sdaff'].='<tr><td align="right" bgcolor="#FFFFFF">Nouveau : </td><td bgcolor="#FFFFFF"><input type="password" name="tn2"></td></tr>';
			$_SESSION['sdaff'].='<tr><td align="right" bgcolor="#FFFFFF">Confirmation : </td><td bgcolor="#FFFFFF"><input type="password" name="tn3"></td></tr>';
			$_SESSION['sdaff'].='<tr><td width="100" bgcolor="#FFFFFF">&nbsp;</td><td bgcolor="#FFFFFF"><input type="submit" name="bt1" value="modif_passe"></td></tr>';
			$_SESSION['sdaff'].='<tr><td colspan="2" bgcolor="#FAFAFE" align="center" style="color:#FF0000">&nbsp;'.$_SESSION['etat'].'&nbsp;</td></tr>';
			$_SESSION['sdaff'].='</table>';
			$_SESSION['sdaff'].='</div>';
		}
		$_SESSION['sdaff'].='<div class="inter3">';
		$_SESSION['sdaff'].='<div class="toobar">TRAFIC : : SUD PANEL</div>';
		$_SESSION['sdaff'].='<table border="0" width="100%" bgcolor="#FFFFFF" cellspacing="1" cellpadding="4">';
		$_SESSION['sdaff'].='<tr><td width="150" bgcolor="#E3E3E3"><b>Utilisateur : </b></td><td bgcolor="#E3E3E3">'.$_SESSION['nom'].'</td></tr>';
		$_SESSION['sdaff'].='<tr><td bgcolor="#EFEFEF"><b>T&eacute;l&eacute;phone : </b></td><td bgcolor="#EFEFEF">'.$_SESSION['tel'].'</td></tr>';
		$_SESSION['sdaff'].='<tr><td bgcolor="#E3E3E3" colspan="2">&nbsp;</td></tr>';
		$_SESSION['sdaff'].='<tr><td width="150" bgcolor="#EFEFEF"><b>Nom serveur : </b></td><td bgcolor="#EFEFEF">'.$_SERVER['SERVER_NAME'].'</td></tr>';
		$_SESSION['sdaff'].='<tr><td bgcolor="#E3E3E3"><b>Type de serveur http : </b></td><td bgcolor="#E3E3E3">'.$_SERVER['SERVER_SOFTWARE'].'</td></tr>';
		$_SESSION['sdaff'].='<tr><td bgcolor="#EFEFEF"><b>Chemin hebergement : </b></td><td bgcolor="#EFEFEF">'.$_SERVER['DOCUMENT_ROOT'].'</td></tr>';
		$_SESSION['sdaff'].='<tr><td bgcolor="#E3E3E3"><b>Capacite total disk : </b></td><td bgcolor="#E3E3E3">'.disk_total_space($_SERVER['DOCUMENT_ROOT']).'</td></tr>';
		$_SESSION['sdaff'].='<tr><td bgcolor="#EFEFEF"><b>Espace libre disk : </b></td><td bgcolor="#EFEFEF">'.$oct.'</td></tr>';
		$_SESSION['sdaff'].='</table>';
		$_SESSION['sdaff'].='<div class="refbar"><b>Nombre de personne connect&eacute; : </b>'.$nb0.'1</div>';
		$_SESSION['sdaff'].='</div>';
		$_SESSION['etat']='';
		$_SESSION['sdtitre']='SUDPANEL! TRAFIC';
	}
?>