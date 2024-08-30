<?php
	include('db.php');
	function deconnexion()
	{
		$_SESSION['teluser']="";
		$_SESSION['sdaff']="";
		$_SESSION['sdetat']="";
		$_SESSION['sdmenu']="";
		session_unset();
		session_destroy();
		header('Location: index.php');
	}
	function navig()
	{
		/*
			Auteur : OLORY Suzon
			Agence des Technologies Nouvelles
		*/
		$sql0='SELECT * FROM soft';
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
		/*
			Auteur : OLORY Suzon
			Agence des Technologies Nouvelles
		*/
		$_SESSION['ctmenu']='<center><img src="./picture/logo.png"></center>';
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
			$_SESSION['sdaff'].='<tr><td align="right" bgcolor="#FFFFFF">Societe : </td><td bgcolor="#FFFFFF"><input type="text" name="tn1" value="'.$_GET['steclt'].'"> *</td></tr>';
			$_SESSION['sdaff'].='<tr><td align="right" bgcolor="#FFFFFF">Nom / prenom : </td><td bgcolor="#FFFFFF"><input type="text" name="tn2" value="'.$_GET['nomclt'].'"></td></tr>';
			$_SESSION['sdaff'].='<tr><td align="right" bgcolor="#FFFFFF">Tel : </td><td bgcolor="#FFFFFF"><input type="text" name="tn3" value="'.$_GET['telclt'].'"> *</td></tr>';
			$_SESSION['sdaff'].='<tr><td align="right" bgcolor="#FFFFFF">Fax : </td><td bgcolor="#FFFFFF"><input type="text" name="tn4" value="'.$_GET['faxclt'].'"></td></tr>';
			$_SESSION['sdaff'].='<tr><td align="right" bgcolor="#FFFFFF">E-mail : </td><td bgcolor="#FFFFFF"><input type="text" name="tn5" value="'.$_GET['mailclt'].'"></td></tr>';
			if($_GET['task']=='modif')
			{
				$_SESSION['sdaff'].='<tr><td width="100" bgcolor="#FFFFFF">&nbsp;</td><td bgcolor="#FFFFFF"><input type="hidden" name="tn0" value="'.$_GET['idclt'].'"><input type="submit" name="bt1" value="modif_client"></td></tr>';
			}else
			{
				$_SESSION['sdaff'].='<tr><td width="100" bgcolor="#FFFFFF">&nbsp;</td><td bgcolor="#FFFFFF"><input type="submit" name="bt1" value="add_client"></td></tr>';
			}
			$_SESSION['sdaff'].='<tr><td colspan="2" bgcolor="#FAFAFE" align="center" style="color:#FF0000">&nbsp;'.$_SESSION['etat'].'&nbsp;</td></tr>';
			$_SESSION['sdaff'].='</table>';
			$_SESSION['sdaff'].='</div>';
		}elseif($_GET['ope']=='supp')
		{
			$sql2='SELECT * FROM facture WHERE client="'.$_GET['idclt'].'"';
			$req2=mysql_query($sql2) or die (mysql_error());
			$nb2=mysql_num_rows($req2);
			if($nb2==0)
			{
				$sql1='DELETE FROM client WHERE idclt="'.$_GET['idclt'].'"';
				$req1=mysql_query($sql1) or die (mysql_error());
			}else{
				$_SESSION['sdaff'].='<div class="inter0">';
				$_SESSION['sdaff'].='<table border="0" width="100%" bgcolor="#CCCCCC" cellspacing="1" cellpadding="4">';
				$_SESSION['sdaff'].='<tr><td colspan="3" bgcolor="#FFFFFF" height="50" align="center"><h1>Attention !</h1>Il est impossible d\'&eacute;ffectuer cette op&eacute;ration car des factures sont enregistr&eacute;es au nom de ce client<br><br></td></tr>';
				$_SESSION['sdaff'].='</table>';
				$_SESSION['sdaff'].='</div>';
			}
		}
		$sql0='SELECT * FROM client ORDER BY nomclt ASC';
		$req0=mysql_query($sql0);
		$nb0=mysql_num_rows($req0);
		$_SESSION['sdaff'].='<div class="inter3">';
		$_SESSION['sdaff'].='<div class="toobar">CLIENTELE : : CLIENT</div>';
		$_SESSION['sdaff'].='<table border="0" width="100%" bgcolor="#FFFFFF" cellspacing="1" cellpadding="4">';
		if($nb0==0)
		{
			$_SESSION['sdaff'].='<tr><td align="center" height="100">Pas de client enregistr&eacute;s</td></tr>';
		}else
		{
			$_SESSION['sdaff'].='<tr><td width="25" bgcolor="#B2B9C3">&nbsp;</td><td bgcolor="#B2B9C3"><b>Designation</b></td><td bgcolor="#B2B9C3"><b>T&eacute;l&eacute;phone</b></td><td bgcolor="#B2B9C3" colspan="2" align="center"><img src="./picture/1.png"></td></tr>';
			$bg="#DDDDDD";
			while($dt0=mysql_fetch_array($req0))
			{
				$_SESSION['sdaff'].='<tr><td bgcolor="'.$bg.'" width="25" align="center"><input type="checkbox"></td><td bgcolor="'.$bg.'">'.$dt0['nomclt'].'</td><td bgcolor="'.$bg.'">'.$dt0['telclt'].'</td><td bgcolor="'.$bg.'" align="center" width="25"><a href="index.php?fct=clientele&rub=null&ope=form&task=modif&idclt='.$dt0['idclt'].'&steclt='.$dt0['steclt'].'&nomclt='.$dt0['nomclt'].'&telclt='.$dt0['telclt'].'&faxclt='.$dt0['faxclt'].'&mailclt='.$dt0['mailclt'].'" title="modifier"><img src="./picture/2.png" border="0"></a></td><td bgcolor="'.$bg.'" align="center" width="25"><a href="index.php?fct=clientele&rub=null&ope=supp&idclt='.$dt0['idclt'].'" onclick="if(! confirm(\'Supprimer ce client ?\')) return false;" title="Supprimer"><img src="./picture/3.png"></a></td></tr>';
				if($bg=="#DDDDDD") $bg="#EEEEEE"; else $bg="#DDDDDD";
			}
		}
		$_SESSION['sdaff'].='</table>';
		$_SESSION['sdaff'].='<div class="refbar"><b>Total enregistrements : </b>'.$nb0.'</div>';
		$_SESSION['sdaff'].='</div>';
		$_SESSION['etat']='';
		$_SESSION['sdtitre']='SUDPANEL! CLIENTELE';
	}
	function utilisateur()
	{
		/*
			Auteur : OLORY Suzon
			Agence des Technologies Nouvelles
		*/
		$_SESSION['ctmenu']='<center><img src="./picture/logo.png"></center>';
		navig();
		$_SESSION['sdaff']='';
		$_SESSION['sdaff'].='<div class="inter1">';
		$_SESSION['sdaff'].='<ul>';
		$_SESSION['sdaff'].='<li><a href="index.php?fct=utilisateur&rub=null&ope=form">Ajouter un utilisateur</a></li>';
		$_SESSION['sdaff'].='</ul>';
		$_SESSION['sdaff'].='</div>';
		if($_GET['ope']=='form')
		{
			$_SESSION['sdaff'].='<div class="inter0">';
			$_SESSION['sdaff'].='<table border="0" width="100%" bgcolor="#CCCCCC" cellspacing="1" cellpadding="4">';
			$_SESSION['sdaff'].='<tr><td colspan="3" bgcolor="#FAFAFE">&nbsp;&nbsp;<font size="4"><b>Formulaire des utilisateurs</b></font></td></tr>';
			$_SESSION['sdaff'].='<tr><td align="right" bgcolor="#FFFFFF">Nom et prenom : </td><td bgcolor="#FFFFFF"><input type="text" name="tn1" value="'.$_GET['nomuser'].'"> *</td></tr>';
			$_SESSION['sdaff'].='<tr><td align="right" bgcolor="#FFFFFF">tel : </td><td bgcolor="#FFFFFF"><input type="text" name="tn2" value="'.$_GET['teluser'].'"> *</td></tr>';
			if($_GET['task']=='modif')
			{
				$_SESSION['sdaff'].='<tr><td align="right" bgcolor="#FFFFFF">Profil : </td><td bgcolor="#FFFFFF"><input type="text" name="tn3" value="agent" readonly></td></tr>';
				$_SESSION['sdaff'].='<tr><td width="100" bgcolor="#FFFFFF">&nbsp;</td><td bgcolor="#FFFFFF"><input type="submit" name="bt1" value="modif_agent"></td></tr>';
			}else{
				$_SESSION['sdaff'].='<tr><td width="100" bgcolor="#FFFFFF">&nbsp;</td><td bgcolor="#FFFFFF"><input type="submit" name="bt1" value="add_agent"></td></tr>';
			}
			$_SESSION['sdaff'].='<tr><td colspan="2" bgcolor="#FAFAFE" align="center" style="color:#FF0000">&nbsp;'.$_GET['etat'].'&nbsp;</td></tr>';
			$_SESSION['sdaff'].='</table>';
			$_SESSION['sdaff'].='</div>';
		}elseif($_GET['ope']=='supp')
		{
			$sql1='DELETE FROM agent WHERE teluser="'.$_GET['teluser'].'"';
			$req1=mysql_query($sql1) or die (mysql_error());
		}
		$sql0='SELECT * FROM utilisateur ORDER BY nomuser ASC';
		$req0=mysql_query($sql0);
		$nb0=mysql_num_rows($req0);
		$_SESSION['sdaff'].='<div class="inter3">';
		$_SESSION['sdaff'].='<div class="toobar">AGENT : : LISTE DES UTILISATEURS</div>';
		$_SESSION['sdaff'].='<table border="0" width="100%" bgcolor="#FFFFFF" cellspacing="1" cellpadding="4">';
		if($nb0==0)
		{
			$_SESSION['sdaff'].='<tr><td align="center" height="100"><b>Veuillez ajouter un agent</b></td></tr>';
		}else
		{
			$_SESSION['sdaff'].='<tr><td width="25" bgcolor="#B2B9C3">&nbsp;</td><td bgcolor="#B2B9C3"><b>Nom et prenom</b></td><td bgcolor="#B2B9C3" width="100"><b>Tel</b></td><td bgcolor="#B2B9C3" width="100"><b>Profil</b></td><td bgcolor="#B2B9C3" colspan="2" align="center"><img src="./picture/1.png"></td></tr>';
			$bg="#DDDDDD";
			while($dt0=mysql_fetch_array($req0))
			{
				$_SESSION['sdaff'].='<tr><td bgcolor="'.$bg.'" width="25" align="center"><input type="checkbox"></td><td bgcolor="'.$bg.'">'.$dt0['nomuser'].'</td><td bgcolor="'.$bg.'">'.$dt0['teluser'].'</td><td bgcolor="'.$bg.'">'.$dt0['profil'].'</td><td bgcolor="'.$bg.'" align="center" width="25"><a href="index.php?fct=utilisateur&rub=null&ope=form&task=modif&teluser='.$dt0['teluser'].'&nomuser='.$dt0['nomuser'].'&profil='.$dt0['profil'].'" title="modifier"><img src="./picture/2.png" border="0"></a></td><td bgcolor="'.$bg.'" align="center" width="25"><a href="index.php?fct=utilisateur&rub=null&ope=supp&teluser='.$dt0['teluser'].'" onclick="if(! confirm(\'Supprimer cet utilisateur ?\')) return false;" title="Supprimer"><img src="./picture/3.png"></a></td></tr>';
				if($bg=="#DDDDDD") $bg="#EEEEEE"; else $bg="#DDDDDD";
			}
		}
		$_SESSION['sdaff'].='</table>';
		$_SESSION['sdaff'].='<div class="refbar"><b>Total enregistrements : </b>'.$nb0.'</div>';
		$_SESSION['sdaff'].='</div>';
		$_SESSION['etat']='';
		$_SESSION['sdtitre']='SUDPANEL! UTILISATEUR';
	}
	function gestock()
	{
		/*
			Auteur : OLORY Suzon
			Agence des Technologies Nouvelles
		*/
		$_SESSION['ctmenu']='<ul>';
		$_SESSION['ctmenu'].='<li><a href="index.php?fct=gestock&rub=null">Liste des produits</a></li>';
		$_SESSION['ctmenu'].='<li><a href="index.php?fct=gestock&rub=null">Ravitaillement</a></li>';
		$_SESSION['ctmenu'].='</ul>';
		navig();
		$_SESSION['sdaff']='';
		if($_GET['rub']=='bordero')
		{
			$_SESSION['sdaff'].='<div class="inter1">';
			$_SESSION['sdaff'].='<ul>';
			$_SESSION['sdaff'].='<li><a href="index.php?fct=stock&rub=bordero&ope=form">Editer un bordero</a></li>';
			$_SESSION['sdaff'].='<li><a href="index.php?fct=stock&rub=bordero">Liste des borderos</a></li>';
			$_SESSION['sdaff'].='</ul>';
			$_SESSION['sdaff'].='</div>';
			if($_GET['ope']=='form')
			{
				$_SESSION['sdaff'].='<div class="inter0">';
				$_SESSION['sdaff'].='<table border="0" width="100%" bgcolor="#CCCCCC" cellspacing="1" cellpadding="4">';
				if($_GET['mag']=='ok')
				{
					if($_GET['addm']=='ok' || $_GET['task']=='modif')
					{
						$_SESSION['idmag']=$_GET['idmag'];
						$_SESSION['libmag']=$_GET['libmag'];
						$_SESSION['idbd']=($_GET['task']=='modif')?$_GET['idbd']:date('YmdHis');
						$_SESSION['dtbd']=($_GET['task']=='modif')?$_GET['dtbd']:date('Y-m-d');
						unset($_SESSION['idpdlist']);
						unset($_SESSION['desiprod']);
						unset($_SESSION['idbdlist']);
						unset($_SESSION['qtliv']);
					}
					$_SESSION['sdaff'].='<tr><td colspan="3" bgcolor="#FAFAFE"><b>&nbsp;&nbsp;&nbsp;&nbsp;: : &nbsp; &nbsp; BORDERO DE LIVRAISON</b></td></tr>';
					$_SESSION['sdaff'].='<tr><td align="right" bgcolor="#FFFFFF" width="100"><b>Ref : </b></td><td bgcolor="#FFFFFF">'.$_SESSION['idbd'].'</td></tr>';
					$_SESSION['sdaff'].='<tr><td align="right" bgcolor="#FFFFFF" width="100"><b>Magazin : </b></td><td bgcolor="#FFFFFF">'.$_SESSION['libmag'].'</td></tr>';
					$_SESSION['sdaff'].='<tr><td align="right" bgcolor="#FFFFFF" width="100"><b>Date : </b></td><td bgcolor="#FFFFFF">'.$_SESSION['dtbd'].'</td></tr>';
					$_SESSION['sdaff'].='</table>';
					$_SESSION['sdaff'].='</div>';
					$_SESSION['sdaff'].='<div class="inter0">';
					$_SESSION['sdaff'].='<table border="0" width="100%" bgcolor="#CCCCCC" cellspacing="1" cellpadding="4">';
					$_SESSION['sdaff'].=($_GET['task']=='modif')?'<tr><td colspan="6" bgcolor="#FAFAFE"><b>&nbsp;&nbsp;&nbsp;&nbsp;: : &nbsp; &nbsp; LISTE DES PRODUITS LIVRES</b></td></tr>':'<tr><td colspan="4" bgcolor="#FAFAFE"><b>&nbsp;&nbsp;&nbsp;&nbsp;: : &nbsp; &nbsp; </b><a href="index.php?fct=stock&rub=bordero&ope=form&mag=ok&list=prod">Selection des produits</a></td></tr>';
					if($_GET['prod']=='ok')
					{
						if($_GET['task']=='modif')
						{
							if($_GET['tab']=='supp')
							{
								$sql9='SELECT * FROM bdlist WHERE bd="'.$_SESSION['idbd'].'"';
								$req9=mysql_query($sql9);
								$nb9=mysql_num_rows($req9);
								if($nb9==1)
								{
									$sql5='DELETE FROM bdlist WHERE idbdlist="'.$_GET['idbdlist'].'"';
									$req5=mysql_query($sql5);
									$sql10='DELETE FROM bordero WHERE idbd="'.$_SESSION['idbd'].'"';
									$req10=mysql_query($sql10);
									header('location: index.php?fct=stock&rub=3&type=archive');
								}else{
									$sql5='DELETE FROM bdlist WHERE idbdlist="'.$_GET['idbdlist'].'"';
									$req5=mysql_query($sql5);
								}
							}
							$sql4='SELECT * FROM bdlist,prodlist,produit WHERE bdlist.prodbd=prodlist.idpdlist AND prodlist.prod=produit.idprod AND bd="'.$_SESSION['idbd'].'"';
							$req4=mysql_query($sql4);
							$nb4=mysql_num_rows($req4);
							$pp=0;
							while($dt4=mysql_fetch_array($req4))
							{
								$ind=sizeof($_SESSION['idpdlist'])+1;
								$_SESSION['idpdlist'][$ind]=$dt4['idpdlist'];
								$_SESSION['idbdlist'][$ind]=$dt4['idbdlist'];
								$_SESSION['desiprod'][$ind]=$dt4['desiprod'];
								$_SESSION['qtliv'][$ind]=$dt4['qtliv'];
								$_SESSION['qtrec'][$ind]=$dt4['qtrec'];
								$_SESSION['qtava'][$ind]=$dt4['qtava'];
								if(($dt4['qtliv']==$dt4['qtrec']) || ($dt4['qtliv']==$dt4['qtrec']+$dt4['qtava']))
								{
									$pp++;
								}
							}
							if($_GET['etatbd']=='valide')
							{
								$_SESSION['sdaff'].='<tr><td bgcolor="#FAFAFE" width="100"><b>Ref</b></td><td bgcolor="#FAFAFE"><b>Designation</b></td><td bgcolor="#FAFAFE" width="80"><b>Qtite livre</b></td><td bgcolor="#FAFAFE" width="80"><b>Qtite recu</b></td><td bgcolor="#FAFAFE" width="80"><b>Avarie</b></td></tr>';
								for($i=1; $i<=sizeof($_SESSION['idpdlist']); $i++)
								{
									$_SESSION['sdaff'].='<tr><td bgcolor="#FFFFFF">'.$_SESSION['idpdlist'][$i].'</td><td bgcolor="#FFFFFF">'.$_SESSION['desiprod'][$i].'</td><td bgcolor="#FFFFFF" width="50"><input type="text" value="'.$_SESSION['qtliv'][$i].'" name="tnc'.$i.'" style="width:80px" readonly></td><td bgcolor="#FFFFFF" width="80"><input type="text" value="'.$_SESSION['qtrec'][$i].'" name="tnl'.$i.'" style="width:80px" readonly></td><td bgcolor="#FFFFFF" width="80"><input type="text" value="'.$_SESSION['qtava'][$i].'" name="tna'.$i.'" style="width:80px" readonly></td></tr>';
								}
							}else{
								$_SESSION['sdaff'].='<tr><td bgcolor="#FAFAFE" width="25">&nbsp;</td><td bgcolor="#FAFAFE" width="65"><b>Ref</b></td><td bgcolor="#FAFAFE"><b>Designation</b></td><td bgcolor="#FAFAFE" width="80"><b>Qtite livre</b></td><td bgcolor="#FAFAFE" width="80"><b>Qtite recu</b></td><td bgcolor="#FAFAFE" width="80"><b>Avarie</b></td></tr>';
								for($i=1; $i<=sizeof($_SESSION['idpdlist']); $i++)
								{
									$_SESSION['sdaff'].='<tr><td align="center" bgcolor="#FFFFFF" width="25"><a href="index.php?fct=stock&rub=bordero&ope=form&task=modif&mag=ok&prod=ok&tab=supp&chp='.$i.'&idbdlist='.$_SESSION['idbdlist'][$i].'&idmag='.$_SESSION['idmag'].'&libmag='.$_SESSION['libmag'].'&idbd='.$_SESSION['idbd'].'&dtbd='.$_SESSION['dtbd'].'" onclick="if(! confirm(\'Supprimer ce produit de la liste ?\')) return false;" title="Supprimer"><img src="./picture/3.png" border="0"></a></td><td bgcolor="#FFFFFF">'.$_SESSION['idpdlist'][$i].'</td><td bgcolor="#FFFFFF">'.$_SESSION['desiprod'][$i].'</td><td bgcolor="#FFFFFF" width="50"><input type="text" value="'.$_SESSION['qtliv'][$i].'" name="tnc'.$i.'" style="width:80px"></td><td bgcolor="#FFFFFF" width="80"><input type="text" value="'.$_SESSION['qtrec'][$i].'" name="tnl'.$i.'" style="width:80px" readonly></td><td bgcolor="#FFFFFF" width="80"><input type="text" value="'.$_SESSION['qtava'][$i].'" name="tna'.$i.'" style="width:80px" readonly></td></tr>';
								}
								if($nb4!=$pp)
								{
									$_SESSION['sdaff'].='<tr><td bgcolor="#FFFFFF">&nbsp;</td><td bgcolor="#FFFFFF" colspan="5"><input type="submit" name="bt1" value="modif_bordero"></td></tr>';
								}
							}
							$_SESSION['sdaff'].='<tr><td colspan="6" bgcolor="#FAFAFE" align="center" style="color:#FF0000">&nbsp;'.$_SESSION['etat'].'&nbsp;</td></tr>';
						}else
						{
							if($_GET['addp']=='ok')
							{
								$etat=0;
								for($j=1; $j<=sizeof($_SESSION['idpdlist']); $j++)
								{
									if($_SESSION['idpdlist'][$j]==$_GET['idpdlist'])
									{
										$etat=1;
									}
								}
								if($etat==0)
								{
									$ind=sizeof($_SESSION['idpdlist'])+1;
									$_SESSION['idpdlist'][$ind]=$_GET['idpdlist'];
									$_SESSION['desiprod'][$ind]=$_GET['desiprod'];
									$_SESSION['qtliv'][$ind]=1;
								}
							}
							if($_GET['tab']=='supp')
							{
								$p=$_SESSION['idpdlist'][$_GET['chp']];
								$_SESSION['idpdlist'][$_GET['chp']]=$_SESSION['idpdlist'][sizeof($_SESSION['idpdlist'])];
								$_SESSION['idpdlist'][sizeof($_SESSION['idpdlist'])]=$p;
								
								$r=$_SESSION['desiprod'][$_GET['chp']];
								$_SESSION['desiprod'][$_GET['chp']]=$_SESSION['desiprod'][sizeof($_SESSION['desiprod'])];
								$_SESSION['desiprod'][sizeof($_SESSION['desiprod'])]=$r;
								
								$t=$_SESSION['qtliv'][$_GET['chp']];
								$_SESSION['qtliv'][$_GET['chp']]=$_SESSION['qtliv'][sizeof($_SESSION['qtliv'])];
								$_SESSION['qtliv'][sizeof($_SESSION['qtliv'])]=$t;
								
								unset($_SESSION['idpdlist'][sizeof($_SESSION['idpdlist'])]);
								unset($_SESSION['desiprod'][sizeof($_SESSION['desiprod'])]);
								unset($_SESSION['qtliv'][sizeof($_SESSION['qtliv'])]);
							}
							$_SESSION['sdaff'].='<tr><td bgcolor="#FAFAFE" width="25">&nbsp;</td><td bgcolor="#FAFAFE" width="65"><b>Ref</b></td><td bgcolor="#FAFAFE"><b>Designation</b></td><td bgcolor="#FAFAFE"><b>Quantite</b></td></tr>';
							for($i=1; $i<=sizeof($_SESSION['idpdlist']); $i++)
							{
								$_SESSION['sdaff'].='<tr><td align="center" bgcolor="#FFFFFF"><a href="index.php?fct=stock&rub=bordero&ope=form&mag=ok&prod=ok&tab=supp&chp='.$i.'" onclick="if(! confirm(\'Supprimer ce produit de la liste ?\')) return false;" title="Supprimer"><img src="./picture/3.png" border="0"></a></td><td bgcolor="#FFFFFF">'.$_SESSION['idpdlist'][$i].'</td><td bgcolor="#FFFFFF">'.$_SESSION['desiprod'][$i].'</td><td bgcolor="#FFFFFF" width="50"><input type="text" value="'.$_SESSION['qtliv'][$i].'" name="tn'.$i.'"></td></tr>';
							}
							$_SESSION['sdaff'].='<tr><td bgcolor="#FFFFFF">&nbsp;</td><td bgcolor="#FFFFFF" colspan="3"><input type="submit" name="bt1" value="add_bordero"></td></tr>';
							$_SESSION['sdaff'].='<tr><td colspan="4" bgcolor="#FAFAFE" align="center" style="color:#FF0000">&nbsp;'.$_SESSION['etat'].'&nbsp;</td></tr>';
						}
					}
				}else{
					$_SESSION['sdaff'].='<tr><td colspan="3" bgcolor="#FAFAFE">&nbsp;&nbsp;<b>&nbsp;&nbsp;: : &nbsp; &nbsp; </b><a href="index.php?fct=stock&rub=bordero&ope=form&list=mag">Choisir un magazin</a></td></tr>';
				}
				$_SESSION['sdaff'].='</table>';
				$_SESSION['sdaff'].='</div>';
			}elseif($_GET['ope']=='supp')
			{
				if($_GET['etatbd']=='valide')
				{
					$sql1='UPDATE bordero SET etatbd="non valide" WHERE idbd="'.$_GET['idbd'].'"';
					$req1=mysql_query($sql1) or die(mysql_error());
					$sql2='SELECT * FROM bdlist WHERE bd="'.$_GET['idbd'].'"';
					$req2=mysql_query($sql2) or die(mysql_error());
					while($dt2=mysql_fetch_array($req2))
					{
						$qt=0;
						$sql11='SELECT * FROM prodstock WHERE prodlist="'.$dt2['prodcmd'].'" AND mag="'.$_GET['idmag'].'"';
						$req11=mysql_query($sql11);
						$dt11=mysql_fetch_array($req11);
						$qt=$dt11['qtite']-$dt2['qtrec'];
						$sql7='UPDATE prodstock SET qtite="'.$qt.'" WHERE prodlist="'.$dt2['prodbd'].'" AND mag="'.$_GET['idmag'].'"';
						$req7=mysql_query($sql7) or die(mysql_error());
					}
				}else{
					$sql1='DELETE FROM bordero WHERE idbd="'.$_GET['idbd'].'"';
					$req1=mysql_query($sql1) or die(mysql_error());
					$sql2='DELETE FROM bdlist WHERE bd="'.$_GET['idbd'].'"';
					$req2=mysql_query($sql2) or die(mysql_error());
				}
			}elseif($_GET['ope']=='valider')
			{
				$sql1='UPDATE bordero SET etatbd="valide" WHERE idbd="'.$_GET['idbd'].'"';
				$req1=mysql_query($sql1) or die(mysql_error());
				$sql2='SELECT * FROM bdlist WHERE bd="'.$_GET['idbd'].'"';
				$req2=mysql_query($sql2);
				while($dt2=mysql_fetch_array($req2))
				{
					$qt=0;$qt2=0;
					$sql11='SELECT * FROM prodstock WHERE prodlist="'.$dt2['prodbd'].'" AND mag="'.$_GET['idmag'].'"';
					$req11=mysql_query($sql11);
					$dt11=mysql_fetch_array($req11);
					$qt=$dt11['qtite']+$dt2['qtrec'];
					$sql7='UPDATE prodstock SET qtite="'.$qt.'" WHERE prodlist="'.$dt2['prodbd'].'" AND mag="'.$_GET['idmag'].'"';
					$req7=mysql_query($sql7) or die(mysql_error());
					
					$sql111='SELECT * FROM prodstock WHERE prodlist="'.$dt2['prodbd'].'" AND mag="3"';
					$req111=mysql_query($sql111);
					$dt111=mysql_fetch_array($req111);
					$qt2=$dt111['qtite']-$dt2['qtrec'];
					$sql77='UPDATE prodstock SET qtite="'.$qt2.'" WHERE prodlist="'.$dt2['prodbd'].'" AND mag="3"';
					$req77=mysql_query($sql77) or die(mysql_error());
				}
			}                                                                                   
			if($_GET['list']=='mag')
			{
				$sqlf='SELECT * FROM magazin WHERE idmag!=3 ORDER BY libmag ASC';
				$reqf=mysql_query($sqlf) or die(mysql_error());
				$nbf=mysql_num_rows($reqf);
				$_SESSION['sdaff'].='<div class="inter0">';
				$_SESSION['sdaff'].='<table border="0" width="100%" bgcolor="#CCCCCC" cellspacing="1" cellpadding="4">';
				if($nbf==0)
				{
					$_SESSION['sdaff'].='<tr><td align="center" height="50" bgcolor="#FAFAFE"><b>IMPOSSIBLE ! Magazin non disponible</b></td></tr>';
				}else{
					$_SESSION['sdaff'].='<tr><td width="25" align="center" bgcolor="#FAFAFE"><img src="./picture/3.png" title="Fermer le tableau" border="0"></td><td bgcolor="#FAFAFE"><b>LISTE DES MAGAZINS</b></td></tr>';
					while($dtf=mysql_fetch_array($reqf))
					{
						$_SESSION['sdaff'].='<tr><td width="25" align="center" bgcolor="#FAFAFE"><a href="index.php?fct=stock&rub=bordero&ope=form&mag=ok&addm=ok&idmag='.$dtf['idmag'].'&libmag='.$dtf['libmag'].'"><img src="./picture/4.png" title="Ajouter au bordero" border="0"></a></td><td bgcolor="#FAFAFE">'.$dtf['libmag'].'</td></tr>';
					}
				}
				$_SESSION['sdaff'].='</table>';
				$_SESSION['sdaff'].='</div>';
			}elseif($_GET['list']=='prod')
			{
				$sqlf='SELECT * FROM prodstock,prodlist,produit WHERE prodstock.prodlist=prodlist.idpdlist AND produit.idprod=prodlist.prod AND mag=3 AND qtite>0 ORDER BY desiprod ASC';
				$reqf=mysql_query($sqlf) or die(mysql_error());
				$nbf=mysql_num_rows($reqf);
				$_SESSION['sdaff'].='<div class="inter0">';
				$_SESSION['sdaff'].='<table border="0" width="100%" bgcolor="#CCCCCC" cellspacing="1" cellpadding="4">';
				if($nbf==0)
				{
					$_SESSION['sdaff'].='<tr><td align="center" height="50" bgcolor="#FAFAFE"><b>IMPOSSIBLE ! Produit du fournisseur non disponible</b></td></tr>';
				}else{
					$_SESSION['sdaff'].='<tr><td width="25" align="center" bgcolor="#FAFAFE"><img src="./picture/3.png" title="Fermer le tableau" border="0"></td><td colspan="2" bgcolor="#FAFAFE"><b>LISTE DES PRODUITS</b></td></tr>';
					while($dtf=mysql_fetch_array($reqf))
					{
						$_SESSION['sdaff'].='<tr><td align="center" bgcolor="#FAFAFE"><a href="index.php?fct=stock&rub=bordero&ope=form&mag=ok&prod=ok&addp=ok&list=prod&idpdlist='.$dtf['idpdlist'].'&desiprod='.$dtf['desiprod'].'"><img src="./picture/4.png" title="Ajouter au bordero" border="0"></a></td><td bgcolor="#FAFAFE">'.$dtf['idpdlist'].'</td><td bgcolor="#FAFAFE">'.$dtf['desiprod'].'</td></tr>';
					}
				}
				$_SESSION['sdaff'].='</table>';
				$_SESSION['sdaff'].='</div>';
			}
			$sql0='SELECT * FROM bordero,magazin WHERE bordero.magbd=magazin.idmag ORDER BY dtbd DESC';
			$req0=mysql_query($sql0) or die(mysql_error());
			$nb0=mysql_num_rows($req0);
			$_SESSION['sdaff'].='<div class="inter3">';
			$_SESSION['sdaff'].='<div class="toobar">STOCK : : BORDEROS EDITES</div>';
			$_SESSION['sdaff'].='<table border="0" width="100%" bgcolor="#FFFFFF" cellspacing="1" cellpadding="4">';
			if($nb0==0)
			{
				$_SESSION['sdaff'].='<tr><td align="center" height="100"><b>Pas de borderos enregistr&eacute;s</b></td></tr>';
			}else
			{
				$_SESSION['sdaff'].='<tr><td width="25" bgcolor="#B2B9C3">&nbsp;</td><td width="" bgcolor="#B2B9C3"><b>Ref</b></td><td bgcolor="#B2B9C3"><b>Date</b></td><td bgcolor="#B2B9C3"><b>Magazin</b></td><td bgcolor="#B2B9C3" colspan="2" align="center"><img src="./picture/1.png"></td></tr>';
				$bg="#DDDDDD";
				while($dt0=mysql_fetch_array($req0))
				{
					$sql5='SELECT * FROM bdlist WHERE bd="'.$dt0['idbd'].'"';
					$req5=mysql_query($sql5);
					$nb5=mysql_num_rows($req5);
					$rep=0;
					while($dt5=mysql_fetch_array($req5))
					{
						if(($dt5['qtliv'] == $dt5['qtrec']) || ($dt5['qtliv'] == $dt5['qtrec']+$dt5['qtava']))
						{
							$rep++;
						}
					}
					if($rep==$nb5 && $dt0['etatbd']=='non valide')
					{
						$_SESSION['sdaff'].='<tr><td bgcolor="#FCB0A3" width="25" align="center"><input type="checkbox"></td><td width="" bgcolor="#FCB0A3">'.$dt0['idbd'].' - <a href="index.php?fct=stock&rub=bordero&ope=valider&idbd='.$dt0['idbd'].'&idmag='.$dt0['idmag'].'">[ Non valider ]</a></td><td bgcolor="#FCB0A3">'.$dt0['dtbd'].'</td><td bgcolor="#FCB0A3">'.$dt0['libmag'].'</td><td bgcolor="#FCB0A3" align="center" width="25"><a href="index.php?fct=stock&rub=bordero&ope=form&task=modif&mag=ok&prod=ok&idmag='.$dt0['idmag'].'&libmag='.$dt0['libmag'].'&idbd='.$dt0['idbd'].'&dtbd='.$dt0['dtbd'].'&etatbd='.$dt0['etatbd'].'" title="modifier"><img src="./picture/2.png" border="0"></a></td><td bgcolor="#FCB0A3" align="center" width="25"><a href="index.php?fct=stock&rub=bordero&ope=supp&idbd='.$dt0['idbd'].'&etatbd='.$dt0['etatbd'].'" onclick="if(! confirm(\'Supprimer ce bordero ?\')) return false;" title="Supprimer"><img src="./picture/3.png"></a></td></tr>';
					}elseif($rep==$nb5 && $dt0['etatbd']=='valide')
					{
						$_SESSION['sdaff'].='<tr><td bgcolor="#C9F2B9" width="25" align="center"><input type="checkbox"></td><td width="" bgcolor="#C9F2B9">'.$dt0['idbd'].' - <a href="#">[ Valider ]</a></td><td bgcolor="#C9F2B9">'.$dt0['dtbd'].'</td><td bgcolor="#C9F2B9">'.$dt0['libmag'].'</td><td bgcolor="#C9F2B9" align="center" width="25"><a href="index.php?fct=stock&rub=bordero&ope=form&task=modif&mag=ok&prod=ok&idmag='.$dt0['idmag'].'&libmag='.$dt0['libmag'].'&idbd='.$dt0['idbd'].'&dtbd='.$dt0['dtbd'].'&etatbd='.$dt0['etatbd'].'" title="modifier"><img src="./picture/2.png" border="0"></a></td><td bgcolor="#C9F2B9" align="center" width="25"><a href="index.php?fct=stock&rub=bordero&ope=supp&idbd='.$dt0['idbd'].'&etatbd='.$dt0['etatbd'].'" onclick="if(! confirm(\'Supprimer ce bordero ?\')) return false;" title="Supprimer"><img src="./picture/3.png"></a></td></tr>';
					}else{
						$_SESSION['sdaff'].='<tr><td bgcolor="'.$bg.'" width="25" align="center"><input type="checkbox"></td><td width="" bgcolor="'.$bg.'">'.$dt0['idbd'].'</td><td bgcolor="'.$bg.'">'.$dt0['dtbd'].'</td><td bgcolor="'.$bg.'">'.$dt0['libmag'].'</td><td bgcolor="'.$bg.'" align="center" width="25"><a href="index.php?fct=stock&rub=bordero&ope=form&task=modif&mag=ok&prod=ok&idmag='.$dt0['idmag'].'&libmag='.$dt0['libmag'].'&idbd='.$dt0['idbd'].'&dtbd='.$dt0['dtbd'].'&etatbd='.$dt0['etatbd'].'" title="modifier"><img src="./picture/2.png" border="0"></a></td><td bgcolor="'.$bg.'" align="center" width="25"><a href="index.php?fct=stock&rub=bordero&ope=supp&idbd='.$dt0['idbd'].'&etatbd='.$dt0['etatbd'].'" onclick="if(! confirm(\'Supprimer ce bordero ?\')) return false;" title="Supprimer"><img src="./picture/3.png"></a></td></tr>';
					}
					if($bg=="#DDDDDD") $bg="#EEEEEE"; else $bg="#DDDDDD";
				}
			}
			$_SESSION['sdaff'].='</table>';
			$_SESSION['sdaff'].='<div class="refbar"><b>Total enregistrements : </b>'.$nb0.'</div>';
			$_SESSION['sdaff'].='</div>';
		}else{
			$sql0='SELECT * FROM produit ORDER BY libprod ASC';
			$req0=mysql_query($sql0) or die(mysql_error());
			$nb0=mysql_num_rows($req0);
			$_SESSION['sdaff'].='<div class="inter3">';
			$_SESSION['sdaff'].='<div class="toobar">GESTOCK : : LISTE DES PRODUITS</div>';
			$_SESSION['sdaff'].='<table border="0" width="100%" bgcolor="#FFFFFF" cellspacing="1" cellpadding="4">';
			if($nb0==0)
			{
				$_SESSION['sdaff'].='<tr><td align="center" height="100"><b>Pas de produit disponible</b></td></tr>';
			}else
			{
				$_SESSION['sdaff'].='<tr><td width="25" bgcolor="#B2B9C3">&nbsp;</td><td bgcolor="#B2B9C3"><b>Designation</b></td><td bgcolor="#B2B9C3"><b>Qtite</b></td><td bgcolor="#B2B9C3"><b>Prix U</b></td><td bgcolor="#B2B9C3"><b>Taxe</b></td><td bgcolor="#B2B9C3">&nbsp;</td></tr>';
				$bg="#DDDDDD";
				while($dt0=mysql_fetch_array($req0))
				{
					$_SESSION['sdaff'].='<tr><td width="" bgcolor="'.$bg.'">&nbsp;</td><td bgcolor="'.$bg.'">'.$dt0['libprod'].'</td><td bgcolor="'.$bg.'">'.$dt0['qtprod'].'</td><td bgcolor="'.$bg.'">'.$dt0['mtprod'].'</td><td bgcolor="'.$bg.'">'.$dt0['valtaxe'].'</td><td bgcolor="'.$bg.'" align="center" width="25"><a href="#" title="plus de detail"><img src="./picture/2.png" border="0"></a></td></tr>';
					if($bg=="#DDDDDD") $bg="#EEEEEE"; else $bg="#DDDDDD";
				}
			}
			$_SESSION['sdaff'].='</table>';
			$_SESSION['sdaff'].='<div class="refbar"><b>Total enregistrements : </b>'.$nb0.'</div>';
			$_SESSION['sdaff'].='</div>';
		}
		$_SESSION['etat']='';
		$_SESSION['sdtitre']='SUDPANEL! STOCK';
	}
	function facturation()
	{
		/*
			Auteur : OLORY Suzon
			Agence des Technologies Nouvelles
		*/
		$sql2='SELECT * FROM operation ORDER BY libope';
		$req2=mysql_query($sql2);
		$_SESSION['ctmenu']='<ul>';
		while($dt2=mysql_fetch_array($req2))
		{
			$_SESSION['ctmenu'].='<li><a href="index.php?fct=facturation&rub=edition&libope='.$dt2['libope'].'">Liste '.$dt2['libope'].'</a></li>';
		}
		$_SESSION['ctmenu'].='</ul>';
		navig();
		$_SESSION['sdaff']='';
		$_SESSION['sdaff'].='<div class="inter1">';
		$_SESSION['sdaff'].='<ul>';
		$_SESSION['sdaff'].='<li><a href="index.php?fct=facturation&rub=null&ope=form&init=ok">Editer</a></li>';
		$_SESSION['sdaff'].='</ul>';
		$_SESSION['sdaff'].='</div>';
		if($_GET['ope']=='form')
		{
			if($_GET['init']=='ok')
			{
				unset($_SESSION['idpdlist']);
				unset($_SESSION['desiprod']);
				unset($_SESSION['taxe']);
				unset($_SESSION['prixht']);
				unset($_SESSION['qtfac']);
				unset($_SESSION['qtstk']);
				unset($_SESSION['qtliv']);
				unset($_SESSION['remise']);
				unset($_SESSION['idclt']);
				unset($_SESSION['steclt']);
				unset($_SESSION['telclt']);
				unset($_SESSION['nomclt']);
				unset($_SESSION['idreg']);
				unset($_SESSION['libreg']);
				unset($_SESSION['numfact']);
				unset($_SESSION['idope']);
				unset($_SESSION['libope']);
				unset($_SESSION['mtht']);
				unset($_SESSION['rmht']);
				unset($_SESSION['rmfac']);
				unset($_SESSION['erreur']);
			}
			$_SESSION['sdaff'].='<div class="inter0">';
			$_SESSION['sdaff'].='<table border="0" width="100%" bgcolor="#CCCCCC" cellspacing="1" cellpadding="4">';
			if($_GET['add']=='ope')
			{
				$_SESSION['idope']=$_GET['idope'];
				$_SESSION['libope']=$_GET['libope'];
			}elseif($_GET['add']=='client')
			{
				$_SESSION['numfac']=date('YmdHis');
				$_SESSION['idclt']=$_GET['idclt'];
				$_SESSION['steclt']=$_GET['steclt'];
				$_SESSION['nomclt']=$_GET['nomclt'];
				$_SESSION['telclt']=$_GET['telclt'];
				$_SESSION['rmfac']=0;
			}elseif($_GET['add']=='regle')
			{
				$_SESSION['idreg']=$_GET['idreg'];
				$_SESSION['libreg']=$_GET['libreg'];
				$_SESSION['netpaye']=0;
			}elseif($_GET['add']=='prod')
			{
				$etat=0;
				for($j=1; $j<=sizeof($_SESSION['idpdlist']); $j++)
				{
					if($_SESSION['idpdlist'][$j]==$_GET['idpdlist'])
					{
						$etat=1;
					}
				}
				if($etat==0)
				{
					$ind=sizeof($_SESSION['idpdlist'])+1;
					$_SESSION['idpdlist'][$ind]=$_GET['idpdlist'];
					$_SESSION['desiprod'][$ind]=$_GET['desiprod'];
					$_SESSION['taxe'][$ind]=$_GET['taxe'];
					$_SESSION['prixht'][$ind]=$_GET['prixht'];
					$_SESSION['qtstk'][$ind]=$_GET['qtstk'];
					$_SESSION['qtfac'][$ind]=1;
					$_SESSION['qtliv'][$ind]=1;
					$_SESSION['remise'][$ind]=0;
				}
			}elseif($_GET['add']=='supp')
			{
				$p=$_SESSION['idpdlist'][$_GET['chp']];
				$_SESSION['idpdlist'][$_GET['chp']]=$_SESSION['idpdlist'][sizeof($_SESSION['idpdlist'])];
				$_SESSION['idpdlist'][sizeof($_SESSION['idpdlist'])]=$p;
				
				$u=$_SESSION['desiprod'][$_GET['chp']];
				$_SESSION['desiprod'][$_GET['chp']]=$_SESSION['desiprod'][sizeof($_SESSION['desiprod'])];
				$_SESSION['desiprod'][sizeof($_SESSION['desiprod'])]=$u;
				
				$q=$_SESSION['taxe'][$_GET['chp']];
				$_SESSION['taxe'][$_GET['chp']]=$_SESSION['taxe'][sizeof($_SESSION['taxe'])];
				$_SESSION['taxe'][sizeof($_SESSION['taxe'])]=$q;
				
				$r=$_SESSION['prixht'][$_GET['chp']];
				$_SESSION['prixht'][$_GET['chp']]=$_SESSION['prixht'][sizeof($_SESSION['prixht'])];
				$_SESSION['prixht'][sizeof($_SESSION['prixht'])]=$r;
				
				$t=$_SESSION['qtfac'][$_GET['chp']];
				$_SESSION['qtfac'][$_GET['chp']]=$_SESSION['qtfac'][sizeof($_SESSION['qtfac'])];
				$_SESSION['qtfac'][sizeof($_SESSION['qtfac'])]=$t;
				
				$v=$_SESSION['qtstk'][$_GET['chp']];
				$_SESSION['qtstk'][$_GET['chp']]=$_SESSION['qtstk'][sizeof($_SESSION['qtstk'])];
				$_SESSION['qtstk'][sizeof($_SESSION['qtstk'])]=$v;
				
				$w=$_SESSION['qtliv'][$_GET['chp']];
				$_SESSION['qtliv'][$_GET['chp']]=$_SESSION['qtliv'][sizeof($_SESSION['qtliv'])];
				$_SESSION['qtliv'][sizeof($_SESSION['qtliv'])]=$w;
				
				$s=$_SESSION['remise'][$_GET['chp']];
				$_SESSION['remise'][$_GET['chp']]=$_SESSION['remise'][sizeof($_SESSION['remise'])];
				$_SESSION['remise'][sizeof($_SESSION['remise'])]=$s;
				
				unset($_SESSION['idpdlist'][sizeof($_SESSION['idpdlist'])]);
				unset($_SESSION['taxe'][sizeof($_SESSION['taxe'])]);
				unset($_SESSION['desiprod'][sizeof($_SESSION['desiprod'])]);
				unset($_SESSION['prixht'][sizeof($_SESSION['prixht'])]);
				unset($_SESSION['qtfac'][sizeof($_SESSION['qtfac'])]);
				unset($_SESSION['qtstk'][sizeof($_SESSION['qtstk'])]);
				unset($_SESSION['qtliv'][sizeof($_SESSION['qtliv'])]);
				unset($_SESSION['remise'][sizeof($_SESSION['remise'])]);
			}
			
			if(isset($_SESSION['idope']))
			{
				$_SESSION['sdaff'].='<tr><td colspan="3" bgcolor="#FAFAFE"><b>&nbsp;&nbsp;&nbsp;&nbsp;: : &nbsp; &nbsp; '.strtoupper($_SESSION['libope']).' &nbsp; &nbsp; : : &nbsp; &nbsp; '.$_SESSION['numfac'].'</b></td></tr>';
				if($_SESSION['idclt'])
				{
					$_SESSION['sdaff'].='<tr><td align="right" bgcolor="#FFFFFF" width="100"><b>Societe : </b></td><td bgcolor="#FFFFFF">'.$_SESSION['steclt'].'</td></tr>';
					$_SESSION['sdaff'].='<tr><td align="right" bgcolor="#FFFFFF" width="100"><b>Telephone : </b></td><td bgcolor="#FFFFFF">'.$_SESSION['telclt'].'</td></tr>';
					$_SESSION['sdaff'].='<tr><td align="right" bgcolor="#FFFFFF" width="100"><b>Date : </b></td><td bgcolor="#FFFFFF">'.date('Y-m-d').'</td></tr>';
					$_SESSION['sdaff'].='</table>';
					$_SESSION['sdaff'].='</div>';
					$_SESSION['sdaff'].='<div class="inter0">';
					$_SESSION['sdaff'].='<table border="0" width="100%" bgcolor="#CCCCCC" cellspacing="1" cellpadding="4">';
					if($_SESSION['idpdlist'])
					{
						if($_SESSION['libope']=='facture' || $_SESSION['libope']=='proforma')
						{
							$_SESSION['sdaff'].='<tr><td colspan="10" bgcolor="#FAFAFE"><b>&nbsp;&nbsp;&nbsp;&nbsp;: : &nbsp; &nbsp; </b><a href="index.php?fct=facturation&rub=null&ope=form&list=produit">Veuillez choisir les produits</a></td></tr>';
							$_SESSION['sdaff'].='<tr><td bgcolor="#FAFAFE" width="25">&nbsp;</td><td bgcolor="#FAFAFE" width="65"><b>Ref</b></td><td bgcolor="#FAFAFE"><b>Designation</b></td><td bgcolor="#FAFAFE"><b>PrixHT</b></td><td bgcolor="#FAFAFE"><b>TVA</b></td><td bgcolor="#FAFAFE"><b>Remise</b></td><td bgcolor="#FAFAFE"><b>Quantite</b></td><td bgcolor="#FAFAFE"><b>En stock</b></td><td bgcolor="#FAFAFE"><b>Remise ht</b></td><td bgcolor="#FAFAFE"><b>Montant ht</b></td></tr>';
							for($i=1; $i<=sizeof($_SESSION['idpdlist']); $i++)
							{
								if($_SESSION['erreur'][$i]!=0)
								{
									$_SESSION['qtfac'][$i]=$_SESSION['erreur'][$i];
									unset($_SESSION['mtht']);
									$_SESSION['sdaff'].='<tr><td align="center" bgcolor="#FFBBBB"><a href="index.php?fct=facturation&rub=null&ope=form&add=supp&chp='.$i.'" onclick="if(! confirm(\'Supprimer ce produit de la liste ?\')) return false;" title="Supprimer"><img src="./picture/3.png" border="0"></a></td><td bgcolor="#FFBBBB">'.$_SESSION['idpdlist'][$i].'</td><td bgcolor="#FFBBBB">'.$_SESSION['desiprod'][$i].'</td><td bgcolor="#FFBBBB" width="50"><input type="text" value="'.$_SESSION['prixht'][$i].'" name="p'.$i.'" readonly style="width:50px;"></td><td bgcolor="#FFBBBB" width="50"><input type="text" value="'.$_SESSION['taxe'][$i].'" name="t'.$i.'" style="width:50px;"></td><td bgcolor="#FFBBBB" width="50"><input type="text" value="'.$_SESSION['remise'][$i].'" name="r'.$i.'" style="width:50px;"></td><td bgcolor="#FFBBBB"><input type="text" value="'.$_SESSION['qtfac'][$i].'" name="q'.$i.'" style="width:50px;"></td><td bgcolor="#FFBBBB"><input type="text" value="'.$_SESSION['qtstk'][$i].'" readonly style="width:50px; border:1px solid; text-align:right; background:#C9F2B9;"></td><td bgcolor="#FFBBBB"><input type="text" value="'.$_SESSION['rmht'][$i].'" readonly style="width:100px;"></td><td bgcolor="#FFBBBB"><input type="text" value="'.$_SESSION['mtht'][$i].'" readonly style="width:100px;"></td></tr>';
								}else{
									$_SESSION['sdaff'].='<tr><td align="center" bgcolor="#FFFFFF"><a href="index.php?fct=facturation&rub=null&ope=form&add=supp&chp='.$i.'" onclick="if(! confirm(\'Supprimer ce produit de la liste ?\')) return false;" title="Supprimer"><img src="./picture/3.png" border="0"></a></td><td bgcolor="#FFFFFF">'.$_SESSION['idpdlist'][$i].'</td><td bgcolor="#FFFFFF">'.$_SESSION['desiprod'][$i].'</td><td bgcolor="#FFFFFF" width="50"><input type="text" value="'.$_SESSION['prixht'][$i].'" name="p'.$i.'" readonly style="width:50px;"></td><td bgcolor="#FFFFFF" width="50"><input type="text" value="'.$_SESSION['taxe'][$i].'" name="t'.$i.'" style="width:50px;"></td><td bgcolor="#FFFFFF" width="50"><input type="text" value="'.$_SESSION['remise'][$i].'" name="r'.$i.'" style="width:50px;"></td><td bgcolor="#FFFFFF"><input type="text" value="'.$_SESSION['qtfac'][$i].'" name="q'.$i.'" style="width:50px;"></td><td bgcolor="#FFFFFF"><input type="text" value="'.$_SESSION['qtstk'][$i].'" readonly style="width:50px; border:1px solid; text-align:right; background:#C9F2B9;"></td><td bgcolor="#FFFFFF"><input type="text" value="'.$_SESSION['rmht'][$i].'" readonly style="width:100px;"></td><td bgcolor="#FFFFFF"><input type="text" value="'.$_SESSION['mtht'][$i].'" readonly style="width:100px;"></td></tr>';
								}
							}
							$_SESSION['sdaff'].='<tr><td align="right" bgcolor="#FFFFFF" colspan="3"><b>Remise sur facture : </b></td><td bgcolor="#FFFFFF" colspan="7"><input type="text" value="'.$_SESSION['rmfac'].'" name="rf"><input type="submit" name="bt1" value="calculer"></td></tr>';
						}else{
							$_SESSION['sdaff'].='<tr><td colspan="11" bgcolor="#FAFAFE"><b>&nbsp;&nbsp;&nbsp;&nbsp;: : &nbsp; &nbsp; </b><a href="index.php?fct=facturation&rub=null&ope=form&list=produit">Veuillez choisir les produits</a></td></tr>';
							$_SESSION['sdaff'].='<tr><td bgcolor="#FAFAFE" width="25">&nbsp;</td><td bgcolor="#FAFAFE" width="65"><b>Ref</b></td><td bgcolor="#FAFAFE"><b>Designation</b></td><td bgcolor="#FAFAFE"><b>PrixHT</b></td><td bgcolor="#FAFAFE"><b>TVA</b></td><td bgcolor="#FAFAFE"><b>Remise</b></td><td bgcolor="#FAFAFE"><b>Quantite</b></td><td bgcolor="#FAFAFE"><b>Qtite liv</b></td><td bgcolor="#FAFAFE"><b>En stock</b></td><td bgcolor="#FAFAFE"><b>Remise ht</b></td><td bgcolor="#FAFAFE"><b>Mnt ht</b></td></tr>';
							for($i=1; $i<=sizeof($_SESSION['idpdlist']); $i++)
							{
								if($_SESSION['erreur'][$i]!=0)
								{
									$_SESSION['qtfac'][$i]=$_SESSION['erreur'][$i];
									unset($_SESSION['mtht']);
									$_SESSION['sdaff'].='<tr><td align="center" bgcolor="#FFBBBB"><a href="index.php?fct=facturation&rub=null&ope=form&add=supp&chp='.$i.'" onclick="if(! confirm(\'Supprimer ce produit de la liste ?\')) return false;" title="Supprimer"><img src="./picture/3.png" border="0"></a></td><td bgcolor="#FFBBBB">'.$_SESSION['idpdlist'][$i].'</td><td bgcolor="#FFBBBB">'.$_SESSION['desiprod'][$i].'</td><td bgcolor="#FFBBBB" width="50"><input type="text" value="'.$_SESSION['prixht'][$i].'" name="p'.$i.'" readonly style="width:50px;"></td><td bgcolor="#FFBBBB" width="50"><input type="text" value="'.$_SESSION['taxe'][$i].'" name="t'.$i.'" style="width:50px;"></td><td bgcolor="#FFBBBB" width="50"><input type="text" value="'.$_SESSION['remise'][$i].'" name="r'.$i.'" style="width:50px;"></td><td bgcolor="#FFBBBB" width="50"><input type="text" value="'.$_SESSION['qtfac'][$i].'" name="q'.$i.'" style="width:50px;"></td><td bgcolor="#FFBBBB" width="50"><input type="text" value="'.$_SESSION['qtliv'][$i].'" name="l'.$i.'" style="width:50px;"></td><td bgcolor="#FFBBBB" width="50"><input type="text" value="'.$_SESSION['qtstk'][$i].'" readonly style="width:50px; border:1px solid; text-align:right; background:#C9F2B9;"></td><td bgcolor="#FFBBBB"><input type="text" value="'.$_SESSION['rmht'][$i].'" readonly style="width:100px;"></td><td bgcolor="#FFBBBB"><input type="text" value="'.$_SESSION['mtht'][$i].'" readonly style="width:100px;"></td></tr>';
								}else{
									$_SESSION['sdaff'].='<tr><td align="center" bgcolor="#FFFFFF"><a href="index.php?fct=facturation&rub=null&ope=form&add=supp&chp='.$i.'" onclick="if(! confirm(\'Supprimer ce produit de la liste ?\')) return false;" title="Supprimer"><img src="./picture/3.png" border="0"></a></td><td bgcolor="#FFFFFF">'.$_SESSION['idpdlist'][$i].'</td><td bgcolor="#FFFFFF">'.$_SESSION['desiprod'][$i].'</td><td bgcolor="#FFFFFF" width="50"><input type="text" value="'.$_SESSION['prixht'][$i].'" name="p'.$i.'" readonly style="width:50px;"></td><td bgcolor="#FFFFFF" width="50"><input type="text" value="'.$_SESSION['taxe'][$i].'" name="t'.$i.'" style="width:50px;"></td><td bgcolor="#FFFFFF" width="50"><input type="text" value="'.$_SESSION['remise'][$i].'" name="r'.$i.'" style="width:50px;"></td><td bgcolor="#FFFFFF" width="50"><input type="text" value="'.$_SESSION['qtfac'][$i].'" name="q'.$i.'" style="width:50px;"></td><td bgcolor="#FFFFFF" width="50"><input type="text" value="'.$_SESSION['qtliv'][$i].'" name="l'.$i.'" style="width:50px;"></td><td bgcolor="#FFFFFF" width="50"><input type="text" value="'.$_SESSION['qtstk'][$i].'" readonly style="width:50px; border:1px solid; text-align:right; background:#C9F2B9;"></td><td bgcolor="#FFFFFF"><input type="text" value="'.$_SESSION['rmht'][$i].'" readonly style="width:100px;"></td><td bgcolor="#FFFFFF"><input type="text" value="'.$_SESSION['mtht'][$i].'" readonly style="width:100px;"></td></tr>';
								}
							}
							$_SESSION['sdaff'].='<tr><td align="right" bgcolor="#FFFFFF" colspan="3"><b>Remise sur facture : </b></td><td bgcolor="#FFFFFF" colspan="8"><input type="text" value="'.$_SESSION['rmfac'].'" name="rf"><input type="submit" name="bt1" value="calculer"></td></tr>';
						}
					}else{
						$_SESSION['sdaff'].='<tr><td colspan="4" bgcolor="#FAFAFE"><b>&nbsp;&nbsp;&nbsp;&nbsp;: : &nbsp; &nbsp; </b><a href="index.php?fct=facturation&rub=null&ope=form&list=produit">Veuillez choisir les produits</a></td></tr>';
					}
				}else{
					$_SESSION['sdaff'].='<tr><td colspan="4" bgcolor="#FAFAFE"><b>&nbsp;&nbsp;&nbsp;&nbsp;: : &nbsp; &nbsp; </b><a href="index.php?fct=facturation&rub=null&ope=form&list=client">Veuillez choisir un client</a></td></tr>';
				}
			}else{
				$_SESSION['sdaff'].='<tr><td colspan="3" bgcolor="#FAFAFE">&nbsp;&nbsp;<b>&nbsp;&nbsp;: : &nbsp; &nbsp; </b><a href="index.php?fct=facturation&rub=null&ope=form&list=operation">Veuillez choisir le type d\'operation</a></td></tr>';
			}
			$_SESSION['sdaff'].='</table>';
			$_SESSION['sdaff'].='</div>';
			
			// ================================================================Calcul facture=================
			if(isset($_SESSION['mtht']))
			{
				$acompte=0;
				$tvaht=$_SESSION['bht']*$_SESSION['tvaht'];
				$tvatc=$_SESSION['btc']*$_SESSION['tvatc'];
				$totalht=$_SESSION['bht']+$_SESSION['btc'];
				$totaltc=$totalht+$tvatc;
				$_SESSION['netpaye']=$totaltc-$acompte;
				$_SESSION['sdaff'].='<div class="inter0">';
				$_SESSION['sdaff'].='<table border="0" width="100%" bgcolor="#CCCCCC" cellspacing="1" cellpadding="4">';
				$_SESSION['sdaff'].='<tr><td bgcolor="#FAFAFE" colspan="2"><b>Base HT</b></td><td bgcolor="#FAFAFE"><b>Remise SF</b></td><td bgcolor="#FAFAFE"><b>MT TVA</b></td><td bgcolor="#FAFAFE"><b>Total HT</b></td><td bgcolor="#FAFAFE"><b>Total TC</b></td><td bgcolor="#FAFAFE"><b>Acompte</b></td><td bgcolor="#FAFAFE"><b>Net a payer</b></td></tr>';
				$_SESSION['sdaff'].='<tr><td bgcolor="#FFFFFF">0</td><td bgcolor="#FFFFFF">'.$_SESSION['bht'].'</td><td bgcolor="#FFFFFF" rowspan="2">Tx : '.$_SESSION['rmfac'].' %<br>'.$_GET['rf'].'</td><td bgcolor="#FFFFFF">'.$tvaht.'</td><td bgcolor="#FFFFFF" rowspan="2">'.$totalht.'</td><td bgcolor="#FFFFFF" rowspan="2">'.$totaltc.'</td><td bgcolor="#FFFFFF" rowspan="2">'.$acompte.'</td><td bgcolor="#FFFFFF" rowspan="2">'.$_SESSION['netpaye'].'</td></tr>';
				$_SESSION['sdaff'].='<tr><td bgcolor="#FFFFFF">0,18</td><td bgcolor="#FFFFFF">'.$_SESSION['btc'].'</td><td bgcolor="#FFFFFF">'.$tvatc.'</td></tr>';
				$_SESSION['sdaff'].='</table>';
				$_SESSION['sdaff'].='</div>';
				$_SESSION['sdaff'].='<div class="inter0">';
				$_SESSION['sdaff'].='<table border="0" width="100%" bgcolor="#CCCCCC" cellspacing="1" cellpadding="4">';
				if($_SESSION['idreg'])
				{
					$_SESSION['sdaff'].='<tr><td colspan="2" bgcolor="#FAFAFE"><b>&nbsp;&nbsp;&nbsp;&nbsp;: : &nbsp; &nbsp; </b><a href="index.php?fct=facturation&rub=null&ope=form&list=reglement">Veuillez choisir le mode de reglement</a></td></tr>';
					$_SESSION['sdaff'].='<tr><td colspan="2" bgcolor="#FAFAFE"><b>&nbsp;&nbsp;&nbsp;&nbsp;: : &nbsp; &nbsp; REGLEMENT &nbsp; &nbsp; : : &nbsp; &nbsp; '.strtoupper($_SESSION['libreg']).'</b></td></tr>';
					if($_GET['champ']=='vide') $_SESSION['sdaff'].='<tr><td colspan="2" bgcolor="#FFFFFF" style="text-align:center; color:#FF0000"><b>Veuillez renseigner les champs vides</b></td></tr>';
					$sql17='SELECT * FROM bank ORDER BY libbank ASC';
					$req17=mysql_query($sql17);
					if($_SESSION['libreg']=='cheque')
					{
						$_SESSION['sdaff'].='<tr><td align="right" bgcolor="#FFFFFF" width="100"><b>Banque : </b></td><td bgcolor="#FFFFFF"><select name="bank">';
						while($dt17=mysql_fetch_array($req17))
						{
							$_SESSION['sdaff'].='<option value="'.$dt17['idbank'].'">'.$dt17['libbank'].'</option>';
						}
						$_SESSION['sdaff'].='</select></td></tr>';
						$_SESSION['sdaff'].='<tr><td align="right" bgcolor="#FFFFFF" width="100"><b>Num cheque : </b></td><td bgcolor="#FFFFFF"><input type="text" name="numchek"></td></tr>';
						$_SESSION['sdaff'].='<tr><td align="right" bgcolor="#FFFFFF" width="100"><b>Montant : </b></td><td bgcolor="#FFFFFF"><input type="text" name="mtchek" value="'.$_SESSION['netpaye'].'" readonly></td></tr>';
					}elseif($_SESSION['libreg']=='comptant'){
						$_SESSION['sdaff'].='<tr><td align="right" bgcolor="#FFFFFF" width="100"><b>Montant : </b></td><td bgcolor="#FFFFFF"><input type="text" name="mtpaye" value="'.$_SESSION['netpaye'].'" readonly></td></tr>';
					}else{
						$_SESSION['sdaff'].='<tr><td align="right" bgcolor="#FFFFFF" width="100"><b>Montant : </b></td><td bgcolor="#FFFFFF"><input type="text" name="mtpaye" value="'.$_SESSION['netpaye'].'" readonly></td></tr>';
						$_SESSION['sdaff'].='<tr><td align="right" bgcolor="#FFFFFF" width="100"><b>Banque : </b></td><td bgcolor="#FFFFFF"><select name="bank">';
						while($dt17=mysql_fetch_array($req17))
						{
							$_SESSION['sdaff'].='<option value="'.$dt17['idbank'].'">'.$dt17['libbank'].'</option>';
						}
						$_SESSION['sdaff'].='</select></td></tr>';
						$_SESSION['sdaff'].='<tr><td align="right" bgcolor="#FFFFFF" width="100"><b>Num cheque : </b></td><td bgcolor="#FFFFFF"><input type="text" name="numchek"></td></tr>';
					}
					$_SESSION['sdaff'].='<tr><td bgcolor="#FFFFFF">&nbsp;</td><td bgcolor="#FFFFFF" colspan="3"><input type="submit" name="bt1" value="enregistrer"></td></tr>';
				}else{
					if($_SESSION['libope']=='proforma')
					{
						$_SESSION['sdaff'].='<tr><td colspan="4" bgcolor="#FAFAFE"><b>&nbsp;&nbsp;&nbsp;&nbsp;: : &nbsp; &nbsp; </b><input type="submit" name="bt1" value="enregistrer"></td></tr>';
					}else{
						$_SESSION['sdaff'].='<tr><td colspan="4" bgcolor="#FAFAFE"><b>&nbsp;&nbsp;&nbsp;&nbsp;: : &nbsp; &nbsp; </b><a href="index.php?fct=facturation&rub=null&ope=form&list=reglement">Veuillez choisir le mode de reglement</a></td></tr>';
					}
				}
				$_SESSION['sdaff'].='</table>';
				$_SESSION['sdaff'].='</div>';
			}
		}elseif($_GET['ope']=='situation')
		{
			$_SESSION['sdaff'].='<div class="inter0">';
			$_SESSION['sdaff'].='<table border="0" width="100%" bgcolor="#CCCCCC" cellspacing="1" cellpadding="4">';
			$_SESSION['sdaff'].='<tr><td colspan="2" bgcolor="#FFFFFF" style="font-size:25"><b>&nbsp;&nbsp;'.strtoupper($_GET['libope']).'</b></td><td bgcolor="#FFFFFF" align="right"> <a href="./imprimer/facture.php?&idope='.$_GET['idope'].'&libope='.$_GET['libope'].'&idfac='.$_GET['idfac'].'&dtfac='.$_GET['dtfac'].'&steclt='.$_GET['steclt'].'&telclt='.$_GET['telclt'].'&idreg='.$_GET['idreg'].'&libreg='.$_GET['libreg'].'" title="Imprimer"><img src="./picture/print.gif" border="0"></a> &nbsp; &nbsp; <a href="index.php?fct=facturation&rub=null&ope=supp&idfac='.$_GET['idfac'].'" onclick="if(! confirm(\'Supprimer ce support ?\')) return false;" title="Supprimer"><img src="./picture/3.png" border="0"></a> &nbsp; &nbsp; </td></tr>';
			$_SESSION['sdaff'].='<tr><td bgcolor="#FAFAFE" width="100">&nbsp;&nbsp;&nbsp;&nbsp; <b>Date :</b> </td><td bgcolor="#FFFFFF">'.$_GET['dtfac'].'</td><td bgcolor="#FAFAFE" align="center" rowspan="4" style="font-family:barcode font; font-size:65">'.$_GET['idfac'].'</td></tr>';
			$_SESSION['sdaff'].='<tr><td bgcolor="#FAFAFE">&nbsp;&nbsp;&nbsp;&nbsp; <b>Reglement :</b> </td><td bgcolor="#FFFFFF">'.$_GET['libreg'].'&nbsp;</td></tr>';
			$_SESSION['sdaff'].='<tr><td bgcolor="#FAFAFE">&nbsp;&nbsp;&nbsp;&nbsp; <b>Client :</b> </td><td bgcolor="#FFFFFF">'.$_GET['steclt'].'</td></tr>';
			$_SESSION['sdaff'].='<tr><td bgcolor="#FAFAFE">&nbsp;&nbsp;&nbsp;&nbsp; <b>Telephone :</b> </td><td bgcolor="#FFFFFF">'.$_GET['telclt'].'</td></tr>';
			$_SESSION['sdaff'].='</table>';
			$_SESSION['sdaff'].='</div>';
			$sql1='SELECT * FROM faclist,produit,prodlist WHERE produit.idprod=prodlist.prod AND prodlist.idpdlist=faclist.prodfac AND facture="'.$_GET['idfac'].'"';
			$req1=mysql_query($sql1);
			$_SESSION['sdaff'].='<div class="inter0">';
			$_SESSION['sdaff'].='<table border="0" width="100%" bgcolor="#CCCCCC" cellspacing="1" cellpadding="4">';
			$_SESSION['sdaff'].='<tr><td bgcolor="#FAFAFE" width="65"><b>Ref</b></td><td bgcolor="#FAFAFE"><b>Designation</b></td><td bgcolor="#FAFAFE"><b>PrixHT</b></td><td bgcolor="#FAFAFE"><b>TVA</b></td><td bgcolor="#FAFAFE"><b>Remise</b></td><td bgcolor="#FAFAFE"><b>Quantite</b></td><td bgcolor="#FAFAFE"><b>Remise ht</b></td><td bgcolor="#FAFAFE"><b>Montant ht</b></td></tr>';
			$bht=0;$btc=0;
			while($dt1=mysql_fetch_array($req1))
			{
				$mt=$dt1['qtfac']*$dt1['prixuht'];
				$rmht=($mt*$dt1['rmfac']/100);
				$mtht=$mt-$rmht;
				$_SESSION['sdaff'].='<tr><td bgcolor="#FFFFFF" width="65">'.$dt1['prodfac'].'</td><td bgcolor="#FFFFFF">'.$dt1['desiprod'].'</td><td bgcolor="#FFFFFF">'.$dt1['prixuht'].'</td><td bgcolor="#FFFFFF">'.$dt1['tva'].'</td><td bgcolor="#FFFFFF">'.$dt1['rmfac'].'</td><td bgcolor="#FFFFFF">'.$dt1['qtfac'].'</td><td bgcolor="#FFFFFF">'.$rmht.'</td><td bgcolor="#FFFFFF">'.$mtht.'</td></tr>';
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
			$_SESSION['sdaff'].='</div>';
			$acompte=0;
			$tvaht=$bht*$taxht;
			$tvatc=$btc*$taxtc;
			$totalht=$bht+$btc;
			$totaltc=$totalht+$tvatc;
			$netpaye=$totaltc-$acompte;
			$_SESSION['sdaff'].='<div class="inter0">';
			$_SESSION['sdaff'].='<table border="0" width="100%" bgcolor="#CCCCCC" cellspacing="1" cellpadding="4">';
			$_SESSION['sdaff'].='<tr><td bgcolor="#FAFAFE" colspan="2"><b>Base HT</b></td><td bgcolor="#FAFAFE"><b>Remise SF</b></td><td bgcolor="#FAFAFE"><b>MT TVA</b></td><td bgcolor="#FAFAFE"><b>Total HT</b></td><td bgcolor="#FAFAFE"><b>Total TC</b></td><td bgcolor="#FAFAFE"><b>Acompte</b></td><td bgcolor="#FAFAFE"><b>Net a payer</b></td></tr>';
			$_SESSION['sdaff'].='<tr><td bgcolor="#FFFFFF">0</td><td bgcolor="#FFFFFF">'.$bht.'</td><td bgcolor="#FFFFFF" rowspan="2">Tx : '.$_SESSION['rmfac'].' %<br>'.$_GET['rf'].'</td><td bgcolor="#FFFFFF">'.$tvaht.'</td><td bgcolor="#FFFFFF" rowspan="2">'.$totalht.'</td><td bgcolor="#FFFFFF" rowspan="2">'.$totaltc.'</td><td bgcolor="#FFFFFF" rowspan="2">'.$acompte.'</td><td bgcolor="#FFFFFF" rowspan="2">'.$netpaye.'</td></tr>';
			$_SESSION['sdaff'].='<tr><td bgcolor="#FFFFFF">0,18</td><td bgcolor="#FFFFFF">'.$btc.'</td><td bgcolor="#FFFFFF">'.$tvatc.'</td></tr>';
			$_SESSION['sdaff'].='</table>';
			$_SESSION['sdaff'].='</div>';
		}elseif($_GET['ope']=='supp')
		{
			//precision sur la suppression
		}else
		{
			unset($_SESSION['idpdlist']);
			unset($_SESSION['desiprod']);
			unset($_SESSION['taxe']);
			unset($_SESSION['prixht']);
			unset($_SESSION['qtfac']);
			unset($_SESSION['qtstk']);
			unset($_SESSION['qtliv']);
			unset($_SESSION['remise']);
			unset($_SESSION['idclt']);
			unset($_SESSION['steclt']);
			unset($_SESSION['telclt']);
			unset($_SESSION['nomclt']);
			unset($_SESSION['idreg']);
			unset($_SESSION['libreg']);
			unset($_SESSION['numfact']);
			unset($_SESSION['idope']);
			unset($_SESSION['libope']);
		}
		if($_GET['list']=='operation')
		{
			$sqlf='SELECT * FROM operation ORDER BY libope ASC';
			$reqf=mysql_query($sqlf) or die(mysql_error());
			$nbf=mysql_num_rows($reqf);
			$_SESSION['sdaff'].='<div class="inter0">';
			$_SESSION['sdaff'].='<table border="0" width="100%" bgcolor="#CCCCCC" cellspacing="1" cellpadding="4">';
			if($nbf==0)
			{
				$_SESSION['sdaff'].='<tr><td align="center" height="50" bgcolor="#FAFAFE"><b>IMPOSSIBLE ! Operation non disponible</b></td></tr>';
			}else{
				$_SESSION['sdaff'].='<tr><td width="25" align="center" bgcolor="#FAFAFE"><img src="./picture/3.png" title="Fermer le tableau" border="0"></td><td bgcolor="#FAFAFE"><b>LISTE DES TYPES D\'OPERATION</b></td></tr>';
				while($dtf=mysql_fetch_array($reqf))
				{
					$_SESSION['sdaff'].='<tr><td width="25" align="center" bgcolor="#FAFAFE"><a href="index.php?fct=facturation&rub=null&ope=form&add=ope&idope='.$dtf['idope'].'&libope='.$dtf['libope'].'"><img src="./picture/4.png" title="Ajouter a la '.$dtf['libope'].'" border="0"></a></td><td bgcolor="#FAFAFE">'.$dtf['libope'].'</td></tr>';
				}
			}
			$_SESSION['sdaff'].='</table>';
			$_SESSION['sdaff'].='</div>';
		}elseif($_GET['list']=='client')
		{
			$sqlf='SELECT * FROM client ORDER BY steclt ASC';
			$reqf=mysql_query($sqlf) or die(mysql_error());
			$nbf=mysql_num_rows($reqf);
			$_SESSION['sdaff'].='<div class="inter0">';
			$_SESSION['sdaff'].='<table border="0" width="100%" bgcolor="#CCCCCC" cellspacing="1" cellpadding="4">';
			if($nbf==0)
			{
				$_SESSION['sdaff'].='<tr><td align="center" height="50" bgcolor="#FAFAFE"><b>IMPOSSIBLE ! Clients non disponibles</b></td></tr>';
			}else{
				$_SESSION['sdaff'].='<tr><td width="25" align="center" bgcolor="#FAFAFE"><img src="./picture/3.png" title="Fermer le tableau" border="0"></td><td colspan="2" bgcolor="#FAFAFE"><b>LISTE DES CLIENTS</b></td></tr>';
				while($dtf=mysql_fetch_array($reqf))
				{
					$_SESSION['sdaff'].='<tr><td align="center" bgcolor="#FAFAFE"><a href="index.php?fct=facturation&rub=null&ope=form&add=client&idclt='.$dtf['idclt'].'&steclt='.$dtf['steclt'].'&telclt='.$dtf['telclt'].'&faxclt='.$dtf['faxclt'].'&mailclt='.$dtf['mailclt'].'"><img src="./picture/4.png" title="Ajouter a la '.$_SESSION['libope'].'" border="0"></a></td><td bgcolor="#FAFAFE">'.$dtf['steclt'].'</td></tr>';
				}
			}
			$_SESSION['sdaff'].='</table>';
			$_SESSION['sdaff'].='</div>';
		}elseif($_GET['list']=='reglement')
		{
			$sqlf='SELECT * FROM reglement ORDER BY libreg ASC';
			$reqf=mysql_query($sqlf) or die(mysql_error());
			$nbf=mysql_num_rows($reqf);
			$_SESSION['sdaff'].='<div class="inter0">';
			$_SESSION['sdaff'].='<table border="0" width="100%" bgcolor="#CCCCCC" cellspacing="1" cellpadding="4">';
			if($nbf==0)
			{
				$_SESSION['sdaff'].='<tr><td align="center" height="50" bgcolor="#FAFAFE"><b>IMPOSSIBLE ! Modes de reglements non disponibles</b></td></tr>';
			}else{
				$_SESSION['sdaff'].='<tr><td width="25" align="center" bgcolor="#FAFAFE"><img src="./picture/3.png" title="Fermer le tableau" border="0"></td><td colspan="2" bgcolor="#FAFAFE"><b>LISTE DES MODES DE REGLEMENTS</b></td></tr>';
				while($dtf=mysql_fetch_array($reqf))
				{
					$_SESSION['sdaff'].='<tr><td align="center" bgcolor="#FAFAFE"><a href="index.php?fct=facturation&rub=null&ope=form&add=regle&idreg='.$dtf['idreg'].'&libreg='.$dtf['libreg'].'"><img src="./picture/4.png" title="Ajouter a la '.$_SESSION['libope'].'" border="0"></a></td><td bgcolor="#FAFAFE">'.$dtf['libreg'].'</td></tr>';
				}
			}
			$_SESSION['sdaff'].='</table>';
			$_SESSION['sdaff'].='</div>';
		}elseif($_GET['list']=='produit')
		{
			$sqlf='SELECT * FROM produit,prodlist,prodstock,tva WHERE prodlist.taxe=tva.idtva AND produit.idprod=prodlist.prod AND prodlist.idpdlist=prodstock.prodlist AND mag="'.$_SESSION['mag'].'" AND qtite>0 AND prixht>0 ORDER BY desiprod ASC';
			$reqf=mysql_query($sqlf) or die(mysql_error());
			$nbf=mysql_num_rows($reqf);
			$_SESSION['sdaff'].='<div class="inter0">';
			$_SESSION['sdaff'].='<table border="0" width="100%" bgcolor="#CCCCCC" cellspacing="1" cellpadding="4">';
			if($nbf==0)
			{
				$_SESSION['sdaff'].='<tr><td align="center" height="50" bgcolor="#FAFAFE"><b>IMPOSSIBLE ! Produits non disponibles</b></td></tr>';
			}else{
				$_SESSION['sdaff'].='<tr><td width="25" align="center" bgcolor="#FAFAFE"><img src="./picture/3.png" title="Fermer le tableau" border="0"></td><td colspan="2" bgcolor="#FAFAFE"><b>LISTES DES PRODUITS</b></td><td bgcolor="#FAFAFE"><b>PRIX</b></td><td bgcolor="#FAFAFE"><b>QTITE</b></td></tr>';
				while($dtf=mysql_fetch_array($reqf))
				{
					$_SESSION['sdaff'].='<tr><td align="center" bgcolor="#FAFAFE"><a href="index.php?fct=facturation&rub=null&ope=form&add=prod&list=produit&idpdlist='.$dtf['idpdlist'].'&desiprod='.$dtf['desiprod'].'&prixht='.$dtf['prixht'].'&taxe='.$dtf['valtva'].'&qtstk='.$dtf['qtite'].'"><img src="./picture/4.png" title="Ajouter a la '.$_SESSION['libope'].'" border="0"></a></td><td bgcolor="#FAFAFE">'.$dtf['idpdlist'].'</td><td bgcolor="#FAFAFE">'.$dtf['desiprod'].'</td><td bgcolor="#FAFAFE">'.$dtf['prixht'].'</td><td bgcolor="#FAFAFE">'.$dtf['qtite'].'</td></tr>';
				}
			}
			$_SESSION['sdaff'].='</table>';
			$_SESSION['sdaff'].='</div>';
		}
		$sql0=(!$_GET['libope'])?'SELECT * FROM facture,operation,client,reglement WHERE facture.reglement=reglement.idreg AND facture.client=client.idclt AND facture.typope=operation.idope AND libope="facture" ORDER BY idfac DESC' : 'SELECT * FROM facture,operation,client,reglement WHERE facture.reglement=reglement.idreg AND facture.client=client.idclt AND facture.typope=operation.idope AND libope="'.$_GET['libope'].'" ORDER BY idfac DESC';
		$req0=mysql_query($sql0);
		$nb0=mysql_num_rows($req0);
		$_SESSION['sdaff'].='<div class="inter3">';
		$_SESSION['sdaff'].=(!$_GET['libope'])?'<div class="toobar">LISTE DES FACTURE</div>':'<div class="toobar">LISTE DES '.strtoupper($_GET['libope']).'</div>';
		$_SESSION['sdaff'].='<table border="0" width="100%" bgcolor="#FFFFFF" cellspacing="1" cellpadding="4">';
		if($nb0==0)
		{
			$_SESSION['sdaff'].='<tr><td align="center" height="100"><b>Pas de '.$_GET['libope'].' editer</b></td></tr>';
		}else
		{
			$_SESSION['sdaff'].='<tr><td width="25" bgcolor="#B2B9C3">&nbsp;</td><td bgcolor="#B2B9C3"><b>Date</b></td><td bgcolor="#B2B9C3"><b>Reference</b></td><td bgcolor="#B2B9C3"><b>Client</b></td></tr>';
			$bg="#DDDDDD";
			while($dt0=mysql_fetch_array($req0))
			{
				$_SESSION['sdaff'].='<tr><td bgcolor="'.$bg.'" width="25" align="center"><a href="index.php?fct=facturation&rub=null&ope=situation&idope='.$dt0['idope'].'&libope='.$dt0['libope'].'&idfac='.$dt0['idfac'].'&dtfac='.$dt0['dtfac'].'&steclt='.$dt0['steclt'].'&telclt='.$dt0['telclt'].'&idreg='.$dt0['idreg'].'&libreg='.$dt0['libreg'].'" title="apercu"><img src="./picture/2.png" border="0"></a></td><td bgcolor="'.$bg.'">'.$dt0['dtfac'].'</td><td bgcolor="'.$bg.'">'.$dt0['idfac'].'</td><td bgcolor="'.$bg.'">'.$dt0['steclt'].'</td></tr>';
				if($bg=="#DDDDDD") $bg="#EEEEEE"; else $bg="#DDDDDD";
			}
		}
		$_SESSION['sdaff'].='</table>';
		$_SESSION['sdaff'].='<div class="refbar"><b>Total enregistrements : </b>'.$nb0.'</div>';
		$_SESSION['sdaff'].='</div>';
		$_SESSION['etat']='';
		$_SESSION['sdtitre']='SUDPANEL! FACTURATION';
	}
	function commande()
	{
		/*
			Auteur : OLORY Suzon
			Agence des Technologies Nouvelles
		*/
		$_SESSION['ctmenu']='<ul>';
		$_SESSION['ctmenu'].='<li><a href="index.php?fct=commande&rub=null">Commandes</a></li>';
		$_SESSION['ctmenu'].='<li><a href="index.php?fct=commande&rub=produit">produits</a></li>';
		$_SESSION['ctmenu'].='<li><a href="index.php?fct=commande&rub=fournisseur">fournisseurs</a></li>';
		$_SESSION['ctmenu'].='</ul>';
		navig();
		$_SESSION['sdaff']='';
		if($_GET['rub']=='produit')
		{
			$_SESSION['sdaff'].='<div class="inter1">';
			$_SESSION['sdaff'].='<ul>';
			$_SESSION['sdaff'].='<li><a href="index.php?fct=commande&rub=produit&ope=form">Nouveau</a></li>';
			$_SESSION['sdaff'].='</ul>';
			$_SESSION['sdaff'].='</div>';
			if($_GET['ope']=='form')
			{
				$sql1='SELECT * FROM magazin';
				$req1=mysql_query($sql1);
				$nb1=mysql_num_rows($req1);
				$sql2='SELECT * FROM tva';
				$req2=mysql_query($sql2);
				$sql4='SELECT * FROM fournisseur ORDER BY desifour ASC';
				$req4=mysql_query($sql4);
				$sql5='SELECT * FROM categorie ORDER BY libcat ASC';
				$req5=mysql_query($sql5);
				$_SESSION['sdaff'].='<div class="inter0">';
				$_SESSION['sdaff'].='<table border="0" width="100%" bgcolor="#CCCCCC" cellspacing="1" cellpadding="4">';
				$_SESSION['sdaff'].='<tr><td colspan="3" bgcolor="#FAFAFE">&nbsp;&nbsp;<font size="4"><b>Formulaire des produits</b></font></td></tr>';
				$_SESSION['sdaff'].='<tr><td align="right" bgcolor="#FFFFFF">Libelle Fr : </td><td bgcolor="#FFFFFF"><input type="text" name="tn1" value="'.$_GET['desiprod'].'" style="width:500px"> *</td></tr>';
				$_SESSION['sdaff'].='<tr><td align="right" bgcolor="#FFFFFF">Libelle En : </td><td bgcolor="#FFFFFF"><input type="text" name="tn2" value="'.$_GET['desi_en'].'" style="width:500px"></td></tr>';
				if($_GET['dtexp'])
				{
					$_SESSION['sdaff'].='<tr><td align="right" bgcolor="#FFFFFF">Expiration : </td><td bgcolor="#FFFFFF"><input type="text" name="tn3" value="'.$_GET['dtexp'].'"></td></tr>';
				}else{
					$_SESSION['sdaff'].='<tr><td align="right" bgcolor="#FFFFFF">Expiration : </td><td bgcolor="#FFFFFF"><input type="text" name="tn3" value="'.date('Y-m-d').'"></td></tr>';
				}
				$_SESSION['sdaff'].='<tr><td align="right" bgcolor="#FFFFFF">PrixUHT : </td><td bgcolor="#FFFFFF"><input type="text" name="tn4" value="'.$_GET['prixht'].'"></td></tr>';
				$_SESSION['sdaff'].='<tr><td align="right" bgcolor="#FFFFFF">Seuil : </td><td bgcolor="#FFFFFF"><input type="text" name="tn6" value="'.$_GET['seuil'].'"></td></tr>';
				$_SESSION['sdaff'].='<tr><td align="right" bgcolor="#FFFFFF">Code fournisseur : </td><td bgcolor="#FFFFFF"><input type="text" name="tn7" value="'.$_GET['cdfour'].'"> *</td></tr>';
				$_SESSION['sdaff'].='<tr><td align="right" bgcolor="#FFFFFF">fournisseur : </td><td bgcolor="#FFFFFF"><select name="tn8">';
				if($_GET['task']=='modif')
				{
					$sql7='SELECT * FROM fournisseur WHERE idfour="'.$_GET['idfour'].'"';
					$req7=mysql_query($sql7);
					$dt7=mysql_fetch_array($req7);
					$_SESSION['sdaff'].='<option value="'.$dt7['idfour'].'">'.$dt7['desifour'].'</option>';
					while($dt4=mysql_fetch_array($req4))
					{
						if($_GET['idfour']!=$dt4['idfour'])
						{
							$_SESSION['sdaff'].='<option value="'.$dt4['idfour'].'">'.$dt4['desifour'].'</option>';
						}
					}
					$_SESSION['sdaff'].='</select></td></tr>';
					$sql6='SELECT * FROM categorie WHERE idcat="'.$_GET['idcat'].'"';
					$req6=mysql_query($sql6);
					$dt6=mysql_fetch_array($req6);
					$_SESSION['sdaff'].='<tr><td align="right" bgcolor="#FFFFFF">Categorie : </td><td bgcolor="#FFFFFF"><select name="tn9">';
					$_SESSION['sdaff'].='<option value="'.$dt6['idcat'].'">'.$dt6['libcat'].'</option>';
					$_SESSION['sdaff'].='</select></td></tr>';
					$sql3='SELECT * FROM tva WHERE idtva="'.$_GET['idtva'].'"';
					$req3=mysql_query($sql3);
					$dt3=mysql_fetch_array($req3);
					$_SESSION['sdaff'].='<tr><td align="right" bgcolor="#FFFFFF">taxe : </td><td bgcolor="#FFFFFF"><select name="tn5">';
					$_SESSION['sdaff'].='<option value="'.$dt3['idtva'].'">'.$dt3['valtva'].'</option>';
					while($dt2=mysql_fetch_array($req2))
					{
						if($_GET['idtva']!=$dt2['idtva'])
						{
							$_SESSION['sdaff'].='<option value="'.$dt2['idtva'].'">'.$dt2['valtva'].'</option>';
						}
					}
					$_SESSION['sdaff'].='</select></td></tr>';
					$cp=9;$ng=1;
					while($dt1=mysql_fetch_array($req1))
					{
						$sql8='SELECT * FROM prodstock WHERE mag="'.$dt1['idmag'].'" AND prodlist="'.$_GET['idpdlist'].'"';
						$req8=mysql_query($sql8);
						$dt8=mysql_fetch_array($req8);
						$n=$cp+$ng;
						$_SESSION['sdaff'].='<tr><td align="right" bgcolor="#FFFFFF">Stock de '.$dt1['libmag'].' : </td><td bgcolor="#FFFFFF"><input type="text" name="tn'.$n.'" value="'.$dt8['qtite'].'"></td></tr>';
						$ng++;
					}
					$_SESSION['sdaff'].='<tr><td width="120" bgcolor="#FFFFFF">&nbsp;</td><td bgcolor="#FFFFFF"><input type="hidden" name="tn0" value="'.$_GET['idpdlist'].'"><input type="hidden" name="tn00" value="'.$_GET['idprod'].'"><input type="submit" name="bt1" value="modif_prod"></td></tr>';
				}else
				{
					while($dt4=mysql_fetch_array($req4))
					{
						$_SESSION['sdaff'].='<option value="'.$dt4['idfour'].'">'.$dt4['desifour'].'</option>';
					}
					$_SESSION['sdaff'].='</select></td></tr>';
					$_SESSION['sdaff'].='<tr><td align="right" bgcolor="#FFFFFF">Categorie : </td><td bgcolor="#FFFFFF"><select name="tn9">';
					while($dt5=mysql_fetch_array($req5))
					{
						$_SESSION['sdaff'].='<option value="'.$dt5['idcat'].'">'.$dt5['libcat'].'</option>';
					}
					$_SESSION['sdaff'].='</select></td></tr>';
					$_SESSION['sdaff'].='<tr><td align="right" bgcolor="#FFFFFF">taxe : </td><td bgcolor="#FFFFFF"><select name="tn5">';
					while($dt2=mysql_fetch_array($req2))
					{
						$_SESSION['sdaff'].='<option value="'.$dt2['idtva'].'">'.$dt2['valtva'].'</option>';
					}
					$_SESSION['sdaff'].='</select></td></tr>';
					$_SESSION['sdaff'].='<tr><td width="120" bgcolor="#FFFFFF">&nbsp;</td><td bgcolor="#FFFFFF"><input type="submit" name="bt1" value="add_prod"></td></tr>';
				}
				$_SESSION['sdaff'].='<tr><td colspan="2" bgcolor="#FAFAFE" align="center" style="color:#FF0000">&nbsp;'.$_SESSION['etat'].'&nbsp;</td></tr>';
				$_SESSION['sdaff'].='</table>';
				$_SESSION['sdaff'].='</div>';
			}elseif($_GET['ope']=='supp')
			{
				/*$sql1='DELETE FROM produit WHERE idfour="'.$_GET['idprod'].'"';
				$req1=mysql_query($sql1) or die (mysql_error());
				*/
			}
			$sql0='SELECT * FROM produit,prodlist,tva,fournisseur,categorie WHERE produit.catprod=categorie.idcat AND prodlist.four=fournisseur.idfour AND prodlist.taxe=tva.idtva AND produit.idprod=prodlist.prod ORDER BY desiprod ASC';
			$req0=mysql_query($sql0);
			$nb0=mysql_num_rows($req0);
			$_SESSION['sdaff'].='<div class="inter3">';
			$_SESSION['sdaff'].='<div class="toobar">COMMANDE : : PRODUITS</div>';
			$_SESSION['sdaff'].='<table border="0" width="100%" bgcolor="#FFFFFF" cellspacing="1" cellpadding="4">';
			if($nb0==0)
			{
				$_SESSION['sdaff'].='<tr><td align="center" height="100"><b>Pas de produits enregistr&eacute;s</b></td></tr>';
			}else
			{
				$_SESSION['sdaff'].='<tr><td width="25" bgcolor="#B2B9C3">&nbsp;</td><td bgcolor="#B2B9C3"><b>Ref</b></td><td bgcolor="#B2B9C3"><b>Designation</b></td><td bgcolor="#B2B9C3"><b>Expiration</b></td><td bgcolor="#B2B9C3"><b>PrixUHT</b></td><td bgcolor="#B2B9C3"><b>Taxe</b></td><td bgcolor="#B2B9C3"><b>Cdfour</b></td><td bgcolor="#B2B9C3"><b>Fournisseur</b></td><td bgcolor="#B2B9C3" colspan="2" align="center"><img src="./picture/1.png"></td></tr>';
				$bg="#DDDDDD";
				while($dt0=mysql_fetch_array($req0))
				{
					$_SESSION['sdaff'].='<tr><td bgcolor="'.$bg.'" width="25" align="center"><input type="checkbox"></td><td bgcolor="'.$bg.'">'.$dt0['idpdlist'].'</td><td bgcolor="'.$bg.'">'.$dt0['desiprod'].'</td><td bgcolor="'.$bg.'">'.$dt0['dtexp'].'</td><td bgcolor="'.$bg.'">'.$dt0['prixht'].'</td><td bgcolor="'.$bg.'">'.$dt0['valtva'].'</td><td bgcolor="'.$bg.'">'.$dt0['cdfour'].'</td><td bgcolor="'.$bg.'">'.$dt0['desifour'].'</td><td bgcolor="'.$bg.'" align="center" width="25"><a href="index.php?fct=commande&rub=produit&ope=form&task=modif&idfour='.$dt0['idfour'].'&idtva='.$dt0['idtva'].'&idcat='.$dt0['idcat'].'&idpdlist='.$dt0['idpdlist'].'&idprod='.$dt0['idprod'].'&dtexp='.$dt0['dtexp'].'&prixht='.$dt0['prixht'].'&seuil='.$dt0['seuil'].'&cdfour='.$dt0['cdfour'].'&desiprod='.$dt0['desiprod'].'&desi_en='.$dt0['desi_en'].'" title="modifier"><img src="./picture/2.png" border="0"></a></td><td bgcolor="'.$bg.'" align="center" width="25"><a href="index.php?fct=commande&rub=fournisseur&ope=supp&idfour='.$dt0['idfour'].'" onclick="if(! confirm(\'Supprimer ce fournisseur ?\')) return false;" title="Supprimer"><img src="./picture/3.png"></a></td></tr>';
					if($bg=="#DDDDDD") $bg="#EEEEEE"; else $bg="#DDDDDD";
				}
			}
			$_SESSION['sdaff'].='</table>';
			$_SESSION['sdaff'].='<div class="refbar"><b>Total enregistrements : </b>'.$nb0.'</div>';
			$_SESSION['sdaff'].='</div>';
		}else
		{
			$_SESSION['sdaff'].='<div class="inter1">';
			$_SESSION['sdaff'].='<ul>';
			$_SESSION['sdaff'].='<li><a href="index.php?fct=commande&rub=null&ope=form">Nouvelle</a></li>';
			$_SESSION['sdaff'].='<li><a href="index.php?fct=commande&rub=null">En attentes</a></li>';
			$_SESSION['sdaff'].='<li><a href="index.php?fct=commande&rub=null&type=archive">Archives</a></li>';
			$_SESSION['sdaff'].='</ul>';
			$_SESSION['sdaff'].='</div>';
			if($_GET['ope']=='form')
			{
				$_SESSION['sdaff'].='<div class="inter0">';
				$_SESSION['sdaff'].='<table border="0" width="100%" bgcolor="#CCCCCC" cellspacing="1" cellpadding="4">';
				if($_GET['four']=='ok')
				{
					if($_GET['addf']=='ok' || $_GET['task']=='modif')
					{
						$_SESSION['idfour']=$_GET['idfour'];
						$_SESSION['desifour']=$_GET['desifour'];
						$_SESSION['cmd']=($_GET['task']=='modif')?$_GET['idcmd']:date('YmdHis');
						$_SESSION['dtcmd']=($_GET['task']=='modif')?$_GET['dtcmd']:date('Y-m-d');
						unset($_SESSION['idpdlist']);
						unset($_SESSION['idcmdlist']);
						unset($_SESSION['cdfour']);
						unset($_SESSION['desiprod']);
						unset($_SESSION['qtcmd']);
					}
					$_SESSION['sdaff'].='<tr><td colspan="3" bgcolor="#FAFAFE"><b>&nbsp;&nbsp;&nbsp;&nbsp;: : &nbsp; &nbsp; BON DE COMMANDE</b></td></tr>';
					$_SESSION['sdaff'].='<tr><td align="right" bgcolor="#FFFFFF" width="100"><b>Reference : </b></td><td bgcolor="#FFFFFF">'.$_SESSION['cmd'].'</td></tr>';
					$_SESSION['sdaff'].='<tr><td align="right" bgcolor="#FFFFFF" width="100"><b>Fournisseur : </b></td><td bgcolor="#FFFFFF">'.$_SESSION['desifour'].'</td></tr>';
					$_SESSION['sdaff'].='<tr><td align="right" bgcolor="#FFFFFF" width="100"><b>Date : </b></td><td bgcolor="#FFFFFF">'.$_SESSION['dtcmd'].'</td></tr>';
					$_SESSION['sdaff'].='</table>';
					$_SESSION['sdaff'].='</div>';
					$_SESSION['sdaff'].='<div class="inter0">';
					$_SESSION['sdaff'].='<table border="0" width="100%" bgcolor="#CCCCCC" cellspacing="1" cellpadding="4">';
					$_SESSION['sdaff'].=($_GET['task']=='modif')?'<tr><td colspan="6" bgcolor="#FAFAFE"><b>&nbsp;&nbsp;&nbsp;&nbsp;: : &nbsp; &nbsp; PRODUITS COMMANDES</b></td></tr>':'<tr><td colspan="4" bgcolor="#FAFAFE"><b>&nbsp;&nbsp;&nbsp;&nbsp;: : &nbsp; &nbsp; </b><a href="index.php?fct=commande&rub=null&ope=form&four=ok&list=prod">Selection des produits</a></td></tr>';
					if($_GET['prod']=='ok')
					{
						if($_GET['task']=='modif')
						{
							if($_GET['tab']=='supp')
							{
								$sql9='SELECT * FROM cmdlist WHERE cmd="'.$_SESSION['cmd'].'"';
								$req9=mysql_query($sql9);
								$nb9=mysql_num_rows($req9);
								if($nb9==1)
								{
									$sql5='DELETE FROM cmdlist WHERE idcmdlist="'.$_GET['idcmdlist'].'"';
									$req5=mysql_query($sql5);
									$sql10='DELETE FROM commande WHERE idcmd="'.$_SESSION['cmd'].'"';
									$req10=mysql_query($sql10);
									header('location: index.php?fct=commande&rub=null');
								}else{
									$sql5='DELETE FROM cmdlist WHERE idcmdlist="'.$_GET['idcmdlist'].'"';
									$req5=mysql_query($sql5);
								}
							}
							$sql4='SELECT * FROM cmdlist,prodlist,produit WHERE cmdlist.prodcmd=prodlist.idpdlist AND prodlist.prod=produit.idprod AND cmd="'.$_SESSION['cmd'].'"';
							$req4=mysql_query($sql4);
							while($dt4=mysql_fetch_array($req4))
							{
								$ind=sizeof($_SESSION['idpdlist'])+1;
								$_SESSION['idpdlist'][$ind]=$dt4['idpdlist'];
								$_SESSION['idcmdlist'][$ind]=$dt4['idcmdlist'];
								$_SESSION['cdfour'][$ind]=$dt4['cdfour'];
								$_SESSION['desiprod'][$ind]=$dt4['desiprod'];
								$_SESSION['qtcmd'][$ind]=$dt4['qtitecmd'];
								$_SESSION['qtliv'][$ind]=$dt4['qtiteliv'];
								$_SESSION['qtava'][$ind]=$dt4['avaricmd'];
							}
							if($_GET['type']=='archive')
							{
								$_SESSION['sdaff'].='<tr><td bgcolor="#FAFAFE" width="100"><b>Ref</b></td><td bgcolor="#FAFAFE"><b>Designation</b></td><td bgcolor="#FAFAFE" width="80"><b>Qtite cmd</b></td><td bgcolor="#FAFAFE" width="80"><b>Qtite livre</b></td><td bgcolor="#FAFAFE" width="80"><b>Avarie</b></td></tr>';
								for($i=1; $i<=sizeof($_SESSION['idpdlist']); $i++)
								{
									$_SESSION['sdaff'].='<tr><td bgcolor="#FFFFFF">'.$_SESSION['cdfour'][$i].'</td><td bgcolor="#FFFFFF">'.$_SESSION['desiprod'][$i].'</td><td bgcolor="#FFFFFF" width="50"><input type="text" value="'.$_SESSION['qtcmd'][$i].'" name="tnc'.$i.'" style="width:80px" readonly></td><td bgcolor="#FFFFFF" width="80"><input type="text" value="'.$_SESSION['qtliv'][$i].'" name="tnl'.$i.'" style="width:80px" readonly></td><td bgcolor="#FFFFFF" width="80"><input type="text" value="'.$_SESSION['qtava'][$i].'" name="tna'.$i.'" style="width:80px" readonly></td></tr>';
								}
								$_SESSION['sdaff'].='<tr><td align="right" bgcolor="#FFFFFF" colspan="2"><b>Fret : </b></td><td bgcolor="#FFFFFF" colspan="4"><input type="text" name="tn1" value="'.$_GET['fret'].'" readonly></td></tr>';
							}else{
								$_SESSION['sdaff'].='<tr><td bgcolor="#FAFAFE" width="25">&nbsp;</td><td bgcolor="#FAFAFE" width="65"><b>Ref</b></td><td bgcolor="#FAFAFE"><b>Designation</b></td><td bgcolor="#FAFAFE" width="80"><b>Qtite cmd</b></td><td bgcolor="#FAFAFE" width="80"><b>Qtite livre</b></td><td bgcolor="#FAFAFE" width="80"><b>Avarie</b></td></tr>';
								for($i=1; $i<=sizeof($_SESSION['idpdlist']); $i++)
								{
									$_SESSION['sdaff'].='<tr><td align="center" bgcolor="#FFFFFF" width="25"><a href="index.php?fct=commande&rub=null&ope=form&task=modif&four=ok&prod=ok&tab=supp&chp='.$i.'&idcmdlist='.$_SESSION['idcmdlist'][$i].'&idfour='.$_SESSION['idfour'].'&desifour='.$_SESSION['desifour'].'&idcmd='.$_SESSION['cmd'].'&dtcmd='.$_SESSION['dtcmd'].'" onclick="if(! confirm(\'Supprimer ce produit de la liste ?\')) return false;" title="Supprimer"><img src="./picture/3.png" border="0"></a></td><td bgcolor="#FFFFFF">'.$_SESSION['cdfour'][$i].'</td><td bgcolor="#FFFFFF">'.$_SESSION['desiprod'][$i].'</td><td bgcolor="#FFFFFF" width="50"><input type="text" value="'.$_SESSION['qtcmd'][$i].'" name="tnc'.$i.'" style="width:80px"></td><td bgcolor="#FFFFFF" width="80"><input type="text" value="'.$_SESSION['qtliv'][$i].'" name="tnl'.$i.'" style="width:80px"></td><td bgcolor="#FFFFFF" width="80"><input type="text" value="'.$_SESSION['qtava'][$i].'" name="tna'.$i.'" style="width:80px"></td></tr>';
								}
								$_SESSION['sdaff'].='<tr><td align="right" bgcolor="#FFFFFF" colspan="2"><b>Fret : </b></td><td bgcolor="#FFFFFF" colspan="4"><input type="text" name="tn1" value="'.$_GET['fret'].'"></td></tr>';
								$_SESSION['sdaff'].='<tr><td bgcolor="#FFFFFF">&nbsp;</td><td bgcolor="#FFFFFF" colspan="5"><input type="submit" name="bt1" value="modif_cmd"></td></tr>';
							}
							$_SESSION['sdaff'].='<tr><td colspan="6" bgcolor="#FAFAFE" align="center" style="color:#FF0000">&nbsp;'.$_SESSION['etat'].'&nbsp;</td></tr>';
						}else
						{
							if($_GET['addp']=='ok')
							{
								$etat=0;
								for($j=1; $j<=sizeof($_SESSION['idpdlist']); $j++)
								{
									if($_SESSION['idpdlist'][$j]==$_GET['idpdlist'])
									{
										$etat=1;
									}
								}
								if($etat==0)
								{
									$ind=sizeof($_SESSION['idpdlist'])+1;
									$_SESSION['idpdlist'][$ind]=$_GET['idpdlist'];
									$_SESSION['cdfour'][$ind]=$_GET['cdfour'];
									$_SESSION['desiprod'][$ind]=$_GET['desiprod'];
									$_SESSION['qtcmd'][$ind]=1;
								}
							}
							if($_GET['tab']=='supp')
							{
								$p=$_SESSION['idpdlist'][$_GET['chp']];
								$_SESSION['idpdlist'][$_GET['chp']]=$_SESSION['idpdlist'][sizeof($_SESSION['idpdlist'])];
								$_SESSION['idpdlist'][sizeof($_SESSION['idpdlist'])]=$p;
								
								$q=$_SESSION['cdfour'][$_GET['chp']];
								$_SESSION['cdfour'][$_GET['chp']]=$_SESSION['cdfour'][sizeof($_SESSION['cdfour'])];
								$_SESSION['cdfour'][sizeof($_SESSION['cdfour'])]=$q;
								
								$r=$_SESSION['desiprod'][$_GET['chp']];
								$_SESSION['desiprod'][$_GET['chp']]=$_SESSION['desiprod'][sizeof($_SESSION['desiprod'])];
								$_SESSION['desiprod'][sizeof($_SESSION['desiprod'])]=$r;
								
								$t=$_SESSION['qtcmd'][$_GET['chp']];
								$_SESSION['qtcmd'][$_GET['chp']]=$_SESSION['qtcmd'][sizeof($_SESSION['qtcmd'])];
								$_SESSION['qtcmd'][sizeof($_SESSION['qtcmd'])]=$t;
								
								unset($_SESSION['idpdlist'][sizeof($_SESSION['idpdlist'])]);
								unset($_SESSION['cdfour'][sizeof($_SESSION['cdfour'])]);
								unset($_SESSION['desiprod'][sizeof($_SESSION['desiprod'])]);
								unset($_SESSION['qtcmd'][sizeof($_SESSION['qtcmd'])]);
							}
							
							$_SESSION['sdaff'].='<tr><td bgcolor="#FAFAFE" width="25">&nbsp;</td><td bgcolor="#FAFAFE" width="65"><b>Ref</b></td><td bgcolor="#FAFAFE"><b>Designation</b></td><td bgcolor="#FAFAFE"><b>Quantite</b></td></tr>';
							for($i=1; $i<=sizeof($_SESSION['idpdlist']); $i++)
							{
								$_SESSION['sdaff'].='<tr><td align="center" bgcolor="#FFFFFF"><a href="index.php?fct=commande&rub=null&ope=form&four=ok&prod=ok&tab=supp&chp='.$i.'" onclick="if(! confirm(\'Supprimer ce produit de la liste ?\')) return false;" title="Supprimer"><img src="./picture/3.png" border="0"></a></td><td bgcolor="#FFFFFF">'.$_SESSION['cdfour'][$i].'</td><td bgcolor="#FFFFFF">'.$_SESSION['desiprod'][$i].'</td><td bgcolor="#FFFFFF" width="50"><input type="text" value="'.$_SESSION['qtcmd'][$i].'" name="tn'.$i.'"></td></tr>';
							}
							$_SESSION['sdaff'].='<tr><td bgcolor="#FFFFFF">&nbsp;</td><td bgcolor="#FFFFFF" colspan="3"><input type="submit" name="bt1" value="add_cmd"></td></tr>';
							$_SESSION['sdaff'].='<tr><td colspan="4" bgcolor="#FAFAFE" align="center" style="color:#FF0000">&nbsp;'.$_SESSION['etat'].'&nbsp;</td></tr>';
						}
					}
				}else{
					$_SESSION['sdaff'].='<tr><td colspan="3" bgcolor="#FAFAFE">&nbsp;&nbsp;<b>&nbsp;&nbsp;: : &nbsp; &nbsp; </b><a href="index.php?fct=commande&rub=null&ope=form&list=four">Choisir un fournisseur</a></td></tr>';
				}
				$_SESSION['sdaff'].='</table>';
				$_SESSION['sdaff'].='</div>';
			}elseif($_GET['ope']=='archive')
			{
				$sql1='UPDATE commande SET etat="valide" WHERE idcmd="'.$_GET['idcmd'].'"';
				$req1=mysql_query($sql1) or die(mysql_error());
				$sql2='SELECT * FROM cmdlist WHERE cmd="'.$_GET['idcmd'].'"';
				$req2=mysql_query($sql2) or die(mysql_error());
				while($dt2=mysql_fetch_array($req2))
				{
					$qt=0;
					$sql11='SELECT * FROM prodstock WHERE prodlist="'.$dt2['prodcmd'].'" AND mag="3"';
					$req11=mysql_query($sql11);
					$dt11=mysql_fetch_array($req11);
					$qt=$dt11['qtite']+$dt2['qtiteliv'];
					$sql7='UPDATE prodstock SET qtite="'.$qt.'" WHERE prodlist="'.$dt2['prodcmd'].'" AND mag="3"';
					$req7=mysql_query($sql7) or die(mysql_error());
				}
			}elseif($_GET['ope']=='supp')
			{
				if($_GET['type']=='archive')
				{
					$sql1='UPDATE commande SET etat="non valide" WHERE idcmd="'.$_GET['idcmd'].'"';
					$req1=mysql_query($sql1) or die(mysql_error());
					$sql2='SELECT * FROM cmdlist WHERE cmd="'.$_GET['idcmd'].'"';
					$req2=mysql_query($sql2) or die(mysql_error());
					while($dt2=mysql_fetch_array($req2))
					{
						$qt=0;
						$sql11='SELECT * FROM prodstock WHERE prodlist="'.$dt2['prodcmd'].'" AND mag="3"';
						$req11=mysql_query($sql11);
						$dt11=mysql_fetch_array($req11);
						$qt=$dt11['qtite']-$dt2['qtiteliv'];
						$sql7='UPDATE prodstock SET qtite="'.$qt.'" WHERE prodlist="'.$dt2['prodcmd'].'" AND mag="3"';
						$req7=mysql_query($sql7) or die(mysql_error());
					}
				}else{
					$sql1='DELETE FROM commande WHERE idcmd="'.$_GET['idcmd'].'"';
					$req1=mysql_query($sql1) or die(mysql_error());
					$sql2='DELETE FROM cmdlist WHERE cmd="'.$_GET['idcmd'].'"';
					$req2=mysql_query($sql2) or die(mysql_error());
				}
			}
			if($_GET['list']=='four')
			{
				$sqlf='SELECT * FROM fournisseur ORDER BY desifour ASC';
				$reqf=mysql_query($sqlf) or die(mysql_error());
				$nbf=mysql_num_rows($reqf);
				$_SESSION['sdaff'].='<div class="inter0">';
				$_SESSION['sdaff'].='<table border="0" width="100%" bgcolor="#CCCCCC" cellspacing="1" cellpadding="4">';
				if($nbf==0)
				{
					$_SESSION['sdaff'].='<tr><td align="center" height="50" bgcolor="#FAFAFE"><b>IMPOSSIBLE ! Fournisseur non disponible</b></td></tr>';
				}else{
					$_SESSION['sdaff'].='<tr><td width="25" align="center" bgcolor="#FAFAFE"><img src="./picture/3.png" title="Fermer le tableau" border="0"></td><td bgcolor="#FAFAFE"><b>LISTE DES FOURNISSEURS</b></td></tr>';
					while($dtf=mysql_fetch_array($reqf))
					{
						$_SESSION['sdaff'].='<tr><td width="25" align="center" bgcolor="#FAFAFE"><a href="index.php?fct=commande&rub=null&ope=form&four=ok&addf=ok&idfour='.$dtf['idfour'].'&desifour='.$dtf['desifour'].'"><img src="./picture/4.png" title="Ajouter au bon de commande" border="0"></a></td><td bgcolor="#FAFAFE">'.$dtf['desifour'].'</td></tr>';
					}
				}
				$_SESSION['sdaff'].='</table>';
				$_SESSION['sdaff'].='</div>';
			}elseif($_GET['list']=='prod')
			{
				$sqlf='SELECT * FROM prodlist,produit WHERE produit.idprod=prodlist.prod AND four="'.$_SESSION['idfour'].'" ORDER BY idpdlist ASC';
				$reqf=mysql_query($sqlf) or die(mysql_error());
				$nbf=mysql_num_rows($reqf);
				$_SESSION['sdaff'].='<div class="inter0">';
				$_SESSION['sdaff'].='<table border="0" width="100%" bgcolor="#CCCCCC" cellspacing="1" cellpadding="4">';
				if($nbf==0)
				{
					$_SESSION['sdaff'].='<tr><td align="center" height="50" bgcolor="#FAFAFE"><b>IMPOSSIBLE ! Produit du fournisseur non disponible</b></td></tr>';
				}else{
					$_SESSION['sdaff'].='<tr><td width="25" align="center" bgcolor="#FAFAFE"><img src="./picture/3.png" title="Fermer le tableau" border="0"></td><td colspan="2" bgcolor="#FAFAFE"><b>LISTE DES PRODUITS</b></td></tr>';
					while($dtf=mysql_fetch_array($reqf))
					{
						$_SESSION['sdaff'].='<tr><td align="center" bgcolor="#FAFAFE"><a href="index.php?fct=commande&rub=null&ope=form&four=ok&prod=ok&addp=ok&list=prod&idpdlist='.$dtf['idpdlist'].'&cdfour='.$dtf['cdfour'].'&desiprod='.$dtf['desiprod'].'"><img src="./picture/4.png" title="Ajouter au bon de commande" border="0"></a></td><td bgcolor="#FAFAFE">'.$dtf['cdfour'].'</td><td bgcolor="#FAFAFE">'.$dtf['desiprod'].'</td></tr>';
					}
				}
				$_SESSION['sdaff'].='</table>';
				$_SESSION['sdaff'].='</div>';
			}
			if($_GET['type']=='archive')
			{
				$sql0='SELECT * FROM commande,fournisseur WHERE commande.fourcmd=fournisseur.idfour AND commande.etat="valide" ORDER BY idcmd DESC';
				$req0=mysql_query($sql0);
				$nb0=mysql_num_rows($req0);
				$_SESSION['sdaff'].='<div class="inter3">';
				$_SESSION['sdaff'].='<div class="toobar">COMMANDE : : ARCHIVES</div>';
				$_SESSION['sdaff'].='<table border="0" width="100%" bgcolor="#FFFFFF" cellspacing="1" cellpadding="4">';
				if($nb0==0)
				{
					$_SESSION['sdaff'].='<tr><td align="center" height="100"><b>Pas de commande archive</b></td></tr>';
				}else
				{
					$_SESSION['sdaff'].='<tr><td width="25" bgcolor="#B2B9C3">&nbsp;</td><td bgcolor="#B2B9C3"><b>Date</b></td><td bgcolor="#B2B9C3"><b>Reference</b></td><td bgcolor="#B2B9C3"><b>Fournisseur</b></td><td bgcolor="#B2B9C3" colspan="2" align="center"><img src="./picture/1.png"></td></tr>';
					$bg="#DDDDDD";
					while($dt0=mysql_fetch_array($req0))
					{
						$sql5='SELECT * FROM cmdlist WHERE cmd="'.$dt0['idcmd'].'"';
						$req5=mysql_query($sql5);
						$nb5=mysql_num_rows($req5);
						while($dt5=mysql_fetch_array($req5))
						{
							if(($dt5['qtitecmd'] == $dt5['qtiteliv']) || ($dt5['qtitecmd'] == $dt5['qtiteliv']+$dt5['avaricmd']))
							{
								$rep++;
							}
						}
						$_SESSION['sdaff'].='<tr><td bgcolor="'.$bg.'" width="25" align="center"><input type="checkbox"></td><td bgcolor="'.$bg.'">'.$dt0['dtcmd'].'</td><td bgcolor="'.$bg.'">'.$dt0['idcmd'].'</td><td bgcolor="'.$bg.'">'.$dt0['desifour'].'</td><td bgcolor="'.$bg.'" align="center" width="25"><a href="index.php?fct=commande&rub=null&ope=form&task=modif&four=ok&prod=ok&type=archive&idfour='.$dt0['idfour'].'&desifour='.$dt0['desifour'].'&idcmd='.$dt0['idcmd'].'&dtcmd='.$dt0['dtcmd'].'&fret='.$dt0['fret'].'" title="modifier"><img src="./picture/2.png" border="0"></a></td><td bgcolor="'.$bg.'" align="center" width="25"><a href="index.php?fct=commande&rub=null&ope=supp&type=archive&idcmd='.$dt0['idcmd'].'" onclick="if(! confirm(\'Annuler cette commande ?\')) return false;" title="Annuler"><img src="./picture/3.png"></a></td></tr>';
						if($bg=="#DDDDDD") $bg="#EEEEEE"; else $bg="#DDDDDD";
					}
				}
				$_SESSION['sdaff'].='</table>';
				$_SESSION['sdaff'].='<div class="refbar"><b>Total enregistrements : </b>'.$nb0.'</div>';
				$_SESSION['sdaff'].='</div>';
			}else
			{
				$sql0='SELECT * FROM commande,fournisseur WHERE commande.fourcmd=fournisseur.idfour AND commande.etat="non valide" ORDER BY idcmd DESC';
				$req0=mysql_query($sql0);
				$nb0=mysql_num_rows($req0);
				$_SESSION['sdaff'].='<div class="inter3">';
				$_SESSION['sdaff'].='<div class="toobar">COMMANDE : : EN ATTENTES</div>';
				$_SESSION['sdaff'].='<table border="0" width="100%" bgcolor="#FFFFFF" cellspacing="1" cellpadding="4">';
				if($nb0==0)
				{
					$_SESSION['sdaff'].='<tr><td align="center" height="100"><b>Pas de commande en attente</b></td></tr>';
				}else
				{
					$_SESSION['sdaff'].='<tr><td width="25" bgcolor="#B2B9C3">&nbsp;</td><td bgcolor="#B2B9C3"><b>Date</b></td><td bgcolor="#B2B9C3"><b>Reference</b></td><td bgcolor="#B2B9C3"><b>Fournisseur</b></td><td bgcolor="#B2B9C3" colspan="2" align="center"><img src="./picture/1.png"></td></tr>';
					$bg="#DDDDDD";
					while($dt0=mysql_fetch_array($req0))
					{
						$sql5='SELECT * FROM cmdlist WHERE cmd="'.$dt0['idcmd'].'"';
						$req5=mysql_query($sql5);
						$nb5=mysql_num_rows($req5);
						$rep=0;
						while($dt5=mysql_fetch_array($req5))
						{
							if(($dt5['qtitecmd'] == $dt5['qtiteliv']) || ($dt5['qtitecmd'] == $dt5['qtiteliv']+$dt5['avaricmd']))
							{
								$rep++;
							}
						}
						if($rep==$nb5)
						{
							$_SESSION['sdaff'].='<tr><td bgcolor="'.$bg.'" width="25" align="center"><input type="checkbox"></td><td bgcolor="'.$bg.'">'.$dt0['dtcmd'].'</td><td bgcolor="'.$bg.'">'.$dt0['idcmd'].' - <a href="index.php?fct=commande&rub=null&ope=archive&idcmd='.$dt0['idcmd'].'">[ Veuillez valider cette commande ]</a></td><td bgcolor="'.$bg.'">'.$dt0['desifour'].'</td><td bgcolor="'.$bg.'" align="center" width="25"><a href="index.php?fct=commande&rub=null&ope=form&task=modif&four=ok&prod=ok&idfour='.$dt0['idfour'].'&desifour='.$dt0['desifour'].'&idcmd='.$dt0['idcmd'].'&dtcmd='.$dt0['dtcmd'].'&fret='.$dt0['fret'].'" title="modifier"><img src="./picture/2.png" border="0"></a></td><td bgcolor="'.$bg.'" align="center" width="25"><a href="index.php?fct=commande&rub=null&ope=supp&idcmd='.$dt0['idcmd'].'" onclick="if(! confirm(\'Supprimer cette commande ?\')) return false;" title="Supprimer"><img src="./picture/3.png"></a></td></tr>';
						}else{
							$_SESSION['sdaff'].='<tr><td bgcolor="'.$bg.'" width="25" align="center"><input type="checkbox"></td><td bgcolor="'.$bg.'">'.$dt0['dtcmd'].'</td><td bgcolor="'.$bg.'">'.$dt0['idcmd'].'</td><td bgcolor="'.$bg.'">'.$dt0['desifour'].'</td><td bgcolor="'.$bg.'" align="center" width="25"><a href="index.php?fct=commande&rub=null&ope=form&task=modif&four=ok&prod=ok&idfour='.$dt0['idfour'].'&desifour='.$dt0['desifour'].'&idcmd='.$dt0['idcmd'].'&dtcmd='.$dt0['dtcmd'].'&fret='.$dt0['fret'].'" title="modifier"><img src="./picture/2.png" border="0"></a></td><td bgcolor="'.$bg.'" align="center" width="25"><a href="index.php?fct=commande&rub=null&ope=supp&idcmd='.$dt0['idcmd'].'" onclick="if(! confirm(\'Supprimer cette commande ?\')) return false;" title="Supprimer"><img src="./picture/3.png"></a></td></tr>';
						}
						if($bg=="#DDDDDD") $bg="#EEEEEE"; else $bg="#DDDDDD";
					}
				}
				$_SESSION['sdaff'].='</table>';
				$_SESSION['sdaff'].='<div class="refbar"><b>Total enregistrements : </b>'.$nb0.'</div>';
				$_SESSION['sdaff'].='</div>';
			}
		}
		$_SESSION['etat']='';
		$_SESSION['sdtitre']='SUDPANEL! COMMANDES';
	}
	function parametres()
	{
		/*
			Auteur : OLORY Suzon
			Agence des Technologies Nouvelles
		*/
		$_SESSION['ctmenu']='<center><img src="./picture/logo.png"></center>';
		$_SESSION['sdaff']='';
		navig();
		$_SESSION['sdaff']='';
		$_SESSION['sdaff'].='<table border="0" width="100%" bgcolor="#CCCCCC" cellspacing="1" cellpadding="4">';
		$_SESSION['sdaff'].='<tr><td colspan="3" bgcolor="#FAFAFE">&nbsp;&nbsp;<font size="4"><b>Mot de passe</b></font></td></tr>';
		$_SESSION['sdaff'].='<tr><td align="right" bgcolor="#FFFFFF">Ancien : </td><td bgcolor="#FFFFFF"><input type="password" name="tn1"></td></tr>';
		$_SESSION['sdaff'].='<tr><td align="right" bgcolor="#FFFFFF">Nouveau : </td><td bgcolor="#FFFFFF"><input type="password" name="tn2"></td></tr>';
		$_SESSION['sdaff'].='<tr><td align="right" bgcolor="#FFFFFF">Confirmation : </td><td bgcolor="#FFFFFF"><input type="password" name="tn3"></td></tr>';
		$_SESSION['sdaff'].='<tr><td width="100" bgcolor="#FFFFFF">&nbsp;</td><td bgcolor="#FFFFFF"><input type="submit" name="bt1" value="modif_passe"></td></tr>';
		$_SESSION['sdaff'].='<tr><td colspan="2" bgcolor="#FAFAFE" align="center" style="color:#FF0000">&nbsp;'.$_SESSION['etat'].'&nbsp;</td></tr>';
		$_SESSION['sdaff'].='</table>';
		$_SESSION['etat']='';
		$_SESSION['sdtitre']='SUDPANEL! PARAMETRE';
	}
	function trafic()
	{
		/*
			Auteur : OLORY Suzon
			Agence des Technologies Nouvelles
		*/
		$oct=disk_free_space($_SERVER['DOCUMENT_ROOT'])/8;
		$_SESSION['ctmenu']='<center><img src="./picture/logo.png"></center>';
		//exec('ls -l /var/www/',$tab);
		//chmod('/var/www/aaaaa', 0777);
		//mkdir('/var/www/aaaaa', 0777);
		//exec('rm -r /var/www/aaaaa');
		//exec('sudo useradd -m -s /bin/bash -d /var/www/lola');
		navig();
		ob_start();
		system('ipconfig /all');
		$mycom=ob_get_contents();
		ob_clean();
		$findme = 'physique';
		$pmac = strpos($mycom, $findme);
		$mac=substr($mycom,($pmac+28),17);
		//=================nom du micro==============================
		//$host = gethostbyaddr("$REMOTE_ADDR");
		//===========================================================
		$taille=disk_total_space($_SERVER['DOCUMENT_ROOT'])/8/1024;
		navig();
		$_SESSION['sdaff']='';
		$_SESSION['sdaff'].='<div class="inter3">';
		$_SESSION['sdaff'].='<div class="toobar">TRAFIC : : SDPANEL</div>';
		$_SESSION['sdaff'].='<table border="0" width="100%" bgcolor="#FFFFFF" cellspacing="1" cellpadding="4">';
		$_SESSION['sdaff'].='<tr><td width="150" bgcolor="#E3E3E3"><b>Ordinateur client : </b></td><td bgcolor="#E3E3E3">'.$host.'</td></tr>';
		$_SESSION['sdaff'].='<tr><td bgcolor="#EFEFEF"><b>Adresse MAC : </b></td><td bgcolor="#EFEFEF">'.$mac.'</td></tr>';
		$_SESSION['sdaff'].='<tr><td bgcolor="#E3E3E3"><b>chemin hebergement : </b></td><td bgcolor="#E3E3E3">'.$_SERVER['DOCUMENT_ROOT'].'</td></tr>';
		$_SESSION['sdaff'].='<tr><td bgcolor="#EFEFEF"><b>capacite total disk : </b></td><td bgcolor="#EFEFEF">'.$taille.' ko</td></tr>';
		$_SESSION['sdaff'].='<tr><td bgcolor="#E3E3E3"><b>espace libre disk : </b></td><td bgcolor="#E3E3E3">'.disk_free_space($_SERVER['DOCUMENT_ROOT']).'</td></tr>';
		$_SESSION['sdaff'].='</table>';
		$_SESSION['sdaff'].='<div class="refbar"><b>Total enregistrements : </b>'.$nb0.'</div>';
		$_SESSION['sdaff'].='</div>';
		$_SESSION['etat']='';
		$_SESSION['sdtitre']='SUDPANEL! TRAFIC';
	}
?>