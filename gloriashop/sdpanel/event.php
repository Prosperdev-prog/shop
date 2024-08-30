<?php
	include('db.php');
	if(isset($_POST['bt1']) && $_POST['bt1']=='connexion')
	{
		if((isset($_POST['sdchp1']) && !empty($_POST['sdchp1'])) && (isset($_POST['sdchp2']) && !empty($_POST['sdchp2'])) && (isset($_POST['sdchp3']) && !empty($_POST['sdchp3'])))
		{
			if($_SESSION['sdcapt']==$_POST['sdchp3'])
			{
				$sdsql1='SELECT * FROM utilisateur WHERE teluser="'.$_POST['sdchp1'].'" AND motpass="'.md5($_POST['sdchp2']).'" AND profil="admin"';
				$sdreq1=mysql_query($sdsql1);
				$nb1=mysql_num_rows($sdreq1);
				if($nb1!=0)
				{
					$sd1=mysql_fetch_array($sdreq1);
					$_SESSION['nomuser']=$sd1['nomuser'];
					$_SESSION['teluser']=$sd1['teluser'];
					$_SESSION['passuser']=$sd1['passuser'];
					$_SESSION['profil']=$sd1['profil'];
					header('location: index.php');
				}else
				{
					$_SESSION['sdetat']='<font color="#FF0000">Veuillez renseigner un profil disponible</font>';
					header('location: index.php');
				}
			}else
			{
				$_SESSION['sdetat']='<font color="#FF0000">Code de securite non conforme</font>';
				header('location: index.php');
			}
		}else
		{
			$_SESSION['sdetat']='<font color="#FF0000">Veuillez remplir les champs vides</font>';
			header('location: index.php');
		}
	}elseif(isset($_POST['bt1']) && $_POST['bt1']=='calculer' || $_POST['bt1']=='enregistrer')
	{
		$etat='';
		$_SESSION['rmfac']=abs($_POST['rf']);
		$_SESSION['bht']=0;$_SESSION['btc']=0;$_SESSION['tvaht']=0;$_SESSION['tvatc']=0;
		if($_POST['bt1']=='enregistrer')
		{
			$ope='save';
		}
		for($i=1; $i<=sizeof($_SESSION['idpdlist']); $i++)
		{
			$p='p'.$i; $t='t'.$i; $r='r'.$i; $q='q'.$i; $l='l'.$i;
			if(($_POST[$t]=='') || ($_POST[$r]=='') || ($_POST[$q]==0) || ($_POST[$q]=='') || ($_POST['rf']==''))
			{
				unset($_SESSION['mtht']);
				$_SESSION['rmfac']=0;
				$etat='erreur';
			}else{
				$_SESSION['qtfac'][$i]=abs($_POST[$q]);
				$_SESSION['qtliv'][$i]=abs($_POST[$l]);
				$_SESSION['taxe'][$i]=$_POST[$t];
				$_SESSION['remise'][$i]=$_POST[$r];
				if($_SESSION['qtfac'][$i]>$_SESSION['qtstk'][$i] || $_SESSION['qtfac'][$i]<$_SESSION['qtliv'][$i] || $_SESSION['qtfac'][$i]==0)
				{
					if($_SESSION['libope']=='facture avoir')
					{
						if($_SESSION['qtliv'][$i]>$_SESSION['qtstk'][$i] || $_SESSION['qtfac'][$i]<$_SESSION['qtliv'][$i])
						{
							$_SESSION['qtliv'][$i]=$_SESSION['qtstk'][$i];
							$_SESSION['erreur'][$i]=$_SESSION['qtfac'][$i];
							$etat='erreur';
						}else
						{
							$_SESSION['erreur'][$i]=0;
							$mt=$_SESSION['qtfac'][$i]*$_SESSION['prixht'][$i];
							$_SESSION['rmht'][$i]=($mt*$_SESSION['remise'][$i]/100);
							$_SESSION['mtht'][$i]=$mt-$_SESSION['rmht'][$i];
							if($_SESSION['taxe'][$i]==0)
							{
								$_SESSION['bht']=$_SESSION['bht']+$_SESSION['mtht'][$i];
								$_SESSION['tvaht']=$_SESSION['taxe'][$i];
							}else{
								$_SESSION['btc']=$_SESSION['btc']+$_SESSION['mtht'][$i];
								$_SESSION['tvatc']=$_SESSION['taxe'][$i];
							}
						}
					}else
					{
						$_SESSION['erreur'][$i]=$_SESSION['qtstk'][$i];
						$etat='erreur';
					}
				}else{
					$_SESSION['erreur'][$i]=0;
					$mt=$_SESSION['qtfac'][$i]*$_SESSION['prixht'][$i];
					$_SESSION['rmht'][$i]=($mt*$_SESSION['remise'][$i]/100);
					$_SESSION['mtht'][$i]=$mt-$_SESSION['rmht'][$i];
					if($_SESSION['taxe'][$i]==0)
					{
						$_SESSION['bht']=$_SESSION['bht']+$_SESSION['mtht'][$i];
						$_SESSION['tvaht']=$_SESSION['taxe'][$i];
					}else{
						$_SESSION['btc']=$_SESSION['btc']+$_SESSION['mtht'][$i];
						$_SESSION['tvatc']=$_SESSION['taxe'][$i];
					}
				}
			}
		}
		if($etat=='erreur')
		{
			unset($_SESSION['mtht']);
			header('location: index.php?fct=facturation&rub=null&ope=form&rf='.$rf.'');
		}else{
			$rfht=$_SESSION['bht']*$_SESSION['rmfac']/100;
			$rftc=$_SESSION['btc']*$_SESSION['rmfac']/100;
			$rf=$rfht+$rftc;
			$_SESSION['bht']=$_SESSION['bht']-$rfht;
			$_SESSION['btc']=$_SESSION['btc']-$rftc;
			if($ope=='save')
			{
				$sql2='SELECT * FROM facture WHERE idfac="'.$_SESSION['numfac'].'"';
				$req2=mysql_query($sql2);
				$nb2=mysql_num_rows($req2);
				if($nb2==0)
				{
					if($_SESSION['libope']=='facture')
					{
						if((isset($_POST['mtpaye']) && $_POST['mtpaye']==$_SESSION['netpaye']) || (isset($_POST['mtchek']) && $_POST['mtchek']==$_SESSION['netpaye'] && isset($_POST['numchek']) && !empty($_POST['numchek'])))
						{
							for($i=1; $i<=sizeof($_SESSION['idpdlist']); $i++)
							{
								$sql0='INSERT INTO faclist(idfaclist,facture,prodfac,qtfac,qtfacliv,rmfac,tva,prixuht) VALUES("", "'.$_SESSION['numfac'].'", "'.$_SESSION['idpdlist'][$i].'", "'.$_SESSION['qtfac'][$i].'", "'.$_SESSION['qtfac'][$i].'", "'.$_SESSION['remise'][$i].'", "'.$_SESSION['taxe'][$i].'", "'.$_SESSION['prixht'][$i].'")';
								$req0=mysql_query($sql0) or die(mysql_error);
								$s=$_SESSION['qtstk'][$i]-$_SESSION['qtfac'][$i];
								$sql2='UPDATE prodstock SET qtite="'.$s.'" WHERE prodlist="'.$_SESSION['idpdlist'][$i].'" AND mag="'.$_SESSION['mag'].'"';
								$req2=mysql_query($sql2) or die(mysql_error);
							}
							$sql1='INSERT INTO facture(idfac,client,dtfac,reglement,remise,typope,netpaye,agent) VALUES("'.$_SESSION['numfac'].'", "'.$_SESSION['idclt'].'", "'.date('Y-m-d').'", "'.$_SESSION['idreg'].'", "'.$_SESSION['rmfac'].'", "'.$_SESSION['idope'].'", "'.$_SESSION['netpaye'].'", "'.$_SESSION['sdtel'].'")';
							$req1=mysql_query($sql1) or die(mysql_error());
							if($_SESSION['libreg']=='cheque')
							{
								$sql2='INSERT INTO cheque(idchek,numchek,bank,facture) VALUES("", "'.$_POST['numchek'].'", "'.$_POST['bank'].'", "'.$_SESSION['numfac'].'")';
								$req2=mysql_query($sql2) or die(mysql_error());
								header('location: index.php?fct=facturation&rub=null&ope=situation&idope='.$_SESSION['idope'].'&libope='.$_SESSION['libope'].'&idfac='.$_SESSION['numfac'].'&dtfac='.date('Y-m-d').'&steclt='.$_SESSION['steclt'].'&telclt='.$_SESSION['telclt'].'&idreg='.$_SESSION['idreg'].'&libreg='.$_SESSION['libreg'].'');
							}elseif($_SESSION['libreg']=='credit'){
								
							}else{
								header('location: index.php?fct=facturation&rub=null&ope=situation&idope='.$_SESSION['idope'].'&libope='.$_SESSION['libope'].'&idfac='.$_SESSION['numfac'].'&dtfac='.date('Y-m-d').'&steclt='.$_SESSION['steclt'].'&telclt='.$_SESSION['telclt'].'&idreg='.$_SESSION['idreg'].'&libreg='.$_SESSION['libreg'].'');
							}
						}else{
							header('location: index.php?fct=facturation&rub=null&ope=form&rf='.$rf.'&champ=vide');
						}
					}elseif($_SESSION['libope']=='proforma')
					{
						for($i=1; $i<=sizeof($_SESSION['idpdlist']); $i++)
						{
							$sql0='INSERT INTO faclist(idfaclist,facture,prodfac,qtfac,qtfacliv,rmfac,tva,prixuht) VALUES("", "'.$_SESSION['numfac'].'", "'.$_SESSION['idpdlist'][$i].'", "'.$_SESSION['qtfac'][$i].'", "0", "'.$_SESSION['remise'][$i].'", "'.$_SESSION['taxe'][$i].'", "'.$_SESSION['prixht'][$i].'")';
							$req0=mysql_query($sql0) or die(mysql_error);
						}
						$sql1='INSERT INTO facture(idfac,client,dtfac,reglement,remise,typope,netpaye,agent) VALUES("'.$_SESSION['numfac'].'", "'.$_SESSION['idclt'].'", "'.date('Y-m-d').'", "4", "'.$_SESSION['rmfac'].'", "'.$_SESSION['idope'].'", "'.$_SESSION['netpaye'].'", "'.$_SESSION['sdtel'].'")';
						$req1=mysql_query($sql1) or die(mysql_error());
						header('location: index.php?fct=facturation&rub=null&ope=situation&idope='.$_SESSION['idope'].'&libope='.$_SESSION['libope'].'&idfac='.$_SESSION['numfac'].'&dtfac='.date('Y-m-d').'&steclt='.$_SESSION['steclt'].'&telclt='.$_SESSION['telclt'].'');
					}else{
						if((isset($_POST['mtpaye']) && !empty($_POST['mtpaye'])) || (isset($_POST['mtchek']) && !empty($_POST['mtchek']) && isset($_POST['numchek']) && !empty($_POST['numchek'])))
						{
							for($i=1; $i<=sizeof($_SESSION['idpdlist']); $i++)
							{
								$sql0='INSERT INTO faclist(idfaclist,facture,prodfac,qtfac,qtfacliv,rmfac,tva,prixuht) VALUES("", "'.$_SESSION['numfac'].'", "'.$_SESSION['idpdlist'][$i].'", "'.$_SESSION['qtfac'][$i].'", "'.$_SESSION['qtliv'][$i].'", "'.$_SESSION['remise'][$i].'", "'.$_SESSION['taxe'][$i].'", "'.$_SESSION['prixht'][$i].'")';
								$req0=mysql_query($sql0) or die(mysql_error());
								$s=$_SESSION['qtstk'][$i]-$_SESSION['qtliv'][$i];
								$sql2='UPDATE prodstock SET qtite="'.$s.'" WHERE prodlist="'.$_SESSION['idpdlist'][$i].'" AND mag="'.$_SESSION['mag'].'"';
								$req2=mysql_query($sql2) or die(mysql_error);
							}
							$sql1='INSERT INTO facture(idfac,client,dtfac,reglement,remise,typope,netpaye,agent) VALUES("'.$_SESSION['numfac'].'", "'.$_SESSION['idclt'].'", "'.date('Y-m-d').'", "'.$_SESSION['idreg'].'", "'.$_SESSION['rmfac'].'", "'.$_SESSION['idope'].'", "'.$_SESSION['netpaye'].'", "'.$_SESSION['sdtel'].'")';
							$req1=mysql_query($sql1) or die(mysql_error());
						}else{
							header('location: index.php?fct=facturation&rub=null&ope=form&rf='.$rf.'&champ=vide');
						}
					}
				}else{
					header('location: index.php?fct=facturation');
				}
			}else{
				header('location: index.php?fct=facturation&rub=null&ope=form&rf='.$rf.'');
			}
		}
	}elseif(isset($_POST['bt1']) && $_POST['bt1']=='add_cat')
	{
		if(isset($_POST['tn1']) && !empty($_POST['tn1']) && isset($_POST['tn2']) && !empty($_POST['tn2']))
		{
			$sql='SELECT * FROM categorie WHERE idcat="'.strtolower($_POST['tn1']).'" OR libcat="'.strtolower($_POST['tn2']).'"';
			$req=mysql_query($sql) or die (mysql_error());
			$nb=mysql_num_rows($req);
			if($nb==0)
			{
				$sql1='INSERT INTO categorie(idcat,libcat) VALUES("'.strtolower($_POST['tn1']).'","'.strtolower($_POST['tn2']).'")';
				$req1=mysql_query($sql1) or die (mysql_error());
				$_SESSION['etat']='Enregistrement effectue';
				header('location: index.php?fct=parametres&rub=null&ope=form');
			}else
			{
				$_SESSION['etat']='Cette categorie existe deja';
				header('location: index.php?fct=parametres&rub=null&ope=form&idcat='.$_POST['tn1'].'&libcat='.$_POST['tn2'].'');
			}
		}else
		{
			$_SESSION['etat']='Veuillez remplir les champs vides';
			header('location: index.php?fct=parametres&rub=null&ope=form&idcat='.$_POST['tn1'].'&libcat='.$_POST['tn2'].'');
		}
	}elseif(isset($_POST['bt1']) && $_POST['bt1']=='modif_cat')
	{
		if(isset($_POST['tn1']) && !empty($_POST['tn1']) && isset($_POST['tn2']) && !empty($_POST['tn2']))
		{
			$sql='SELECT * FROM categorie WHERE idcat="'.strtolower($_POST['tn1']).'" AND libcat="'.strtolower($_POST['tn2']).'"';
			$req=mysql_query($sql) or die (mysql_error());
			$nb=mysql_num_rows($req);
			if($nb==0)
			{
				$sql1='UPDATE categorie SET idcat="'.strtolower($_POST['tn1']).'",libcat="'.strtolower($_POST['tn2']).'" WHERE idcat="'.strtolower($_POST['tn0']).'"';
				$req1=mysql_query($sql1) or die (mysql_error());
				$_SESSION['etat']='Modification effectue';
				header('location: index.php?fct=parametres');
			}else
			{
				$_SESSION['etat']='Cette categorie existe deja';
				header('location: index.php?fct=parametres&rub=null&ope=form&task=modif&idcat='.$_POST['tn1'].'&libcat='.$_POST['tn2'].'');
			}
		}else
		{
			$_SESSION['etat']='Veuillez remplir les champs vides';
			header('location: index.php?fct=parametres&rub=null&ope=form&task=modif&idcat='.$_POST['tn1'].'&libcat='.$_POST['tn2'].'');
		}
		
	}elseif(isset($_POST['bt1']) && $_POST['bt1']=='add_taxe')
	{
		if(isset($_POST['tn1']) && !empty($_POST['tn1']))
		{
			$sql='SELECT * FROM tva WHERE valtva="'.$_POST['tn1'].'"';
			$req=mysql_query($sql) or die (mysql_error());
			$nb=mysql_num_rows($req);
			if($nb==0)
			{
				$sql1='INSERT INTO tva(idtva,valtva) VALUES("","'.$_POST['tn1'].'")';
				$req1=mysql_query($sql1) or die (mysql_error());
				$_SESSION['etat']='Enregistrement effectue';
				header('location: index.php?fct=parametres&rub=taxe&ope=form');
			}else
			{
				$_SESSION['etat']='Cette taxe existe deja';
				header('location: index.php?fct=parametres&rub=taxe&ope=form&valtva='.$_POST['tn1'].'');
			}
		}else
		{
			$_SESSION['etat']='Veuillez remplir les champs vides';
			header('location: index.php?fct=parametres&rub=taxe&ope=form&cvaltva='.$_POST['tn1'].'');
		}
	}elseif(isset($_POST['bt1']) && $_POST['bt1']=='modif_taxe')
	{
		if(isset($_POST['tn1']) && !empty($_POST['tn1']))
		{
			$sql='SELECT * FROM tva WHERE valtva="'.$_POST['tn1'].'"';
			$req=mysql_query($sql) or die (mysql_error());
			$nb=mysql_num_rows($req);
			if($nb==0)
			{
				$sql1='UPDATE tva SET valtva="'.$_POST['tn1'].'" WHERE idtva="'.$_POST['tn0'].'"';
				$req1=mysql_query($sql1) or die (mysql_error());
				$_SESSION['etat']='Modification effectue';
				header('location: index.php?fct=parametres&rub=taxe');
			}else
			{
				$_SESSION['etat']='Cette taxe existe deja';
				header('location: index.php?fct=parametres&rub=taxe&ope=form&task=modif&idtva='.$_POST['tn0'].'&valtva='.$_POST['tn1'].'');
			}
		}else
		{
			$_SESSION['etat']='Veuillez remplir les champs vides';
			header('location: index.php?fct=parametres&rub=taxe&ope=form&task=modif&idtva='.$_POST['tn0'].'&valtva='.$_POST['tn1'].'');
		}
		
	}elseif(isset($_POST['bt1']) && $_POST['bt1']=='add_client')
	{
		if(isset($_POST['tn3']) && !empty($_POST['tn3']))
		{
			if((isset($_POST['tn2']) && !empty($_POST['tn2'])) || (isset($_POST['tn1']) && !empty($_POST['tn1'])))
			{
				$sql='SELECT * FROM client WHERE telclt="'.strtolower($_POST['tn3']).'"';
				$req=mysql_query($sql) or die (mysql_error());
				$nb=mysql_num_rows($req);
				if($nb==0)
				{
					$sql1='INSERT INTO client(idclt,steclt,nomclt,telclt,faxclt,mailclt) VALUES("","'.strtolower($_POST['tn1']).'","'.strtolower($_POST['tn2']).'","'.$_POST['tn3'].'","'.$_POST['tn4'].'","'.$_POST['tn5'].'")';
					$req1=mysql_query($sql1) or die (mysql_error());
					$_SESSION['etat']='Enregistrement du client effectue';
					header('location: index.php?fct=clientele&rub=null&ope=form');
				}else
				{
					$_SESSION['etat']='Ce client est deja enregistre';
					$dt=mysql_fetch_array($req);
					header('location: index.php?fct=clientele&rub=null&ope=form&steclt='.$dt['steclt'].'&nomclt='.$dt['nomclt'].'&telclt='.$dt['telclt'].'&faxclt='.$dt['faxclt'].'&mailclt='.$dt['mailclt'].'');
				}
			}else
			{
				$_SESSION['etat']='Veuillez renseigner le champs societe ou nom prenom';
				header('location: index.php?fct=clientele&rub=null&ope=form&steclt='.$dt['steclt'].'&nomclt='.$dt['nomclt'].'&telclt='.$dt['telclt'].'&faxclt='.$dt['faxclt'].'&mailclt='.$dt['mailclt'].'');
			}
		}else
		{
			$_SESSION['etat']='Veuillez renseigner le champs telephone';
			header('location: index.php?fct=clientele&rub=null&ope=form&steclt='.$_POST['tn1'].'&nomclt='.$_POST['tn2'].'&telclt='.$_POST['tn3'].'&faxclt='.$_POST['tn4'].'&mailclt='.$_POST['tn5'].'');
		}
	}elseif(isset($_POST['bt1']) && $_POST['bt1']=='modif_client')
	{
		if(isset($_POST['tn3']) && !empty($_POST['tn3']))
		{
			if((isset($_POST['tn2']) && !empty($_POST['tn2'])) || (isset($_POST['tn1']) && !empty($_POST['tn1'])))
			{
				$sql='SELECT * FROM client WHERE idclt!="'.$_POST['tn0'].'" AND telclt="'.strtolower($_POST['tn3']).'"';
				$req=mysql_query($sql) or die (mysql_error());
				$nb=mysql_num_rows($req);
				if($nb==0)
				{
					$sql1='UPDATE client SET steclt="'.strtolower($_POST['tn1']).'",nomclt="'.strtolower($_POST['tn2']).'",telclt="'.$_POST['tn3'].'",faxclt="'.$_POST['tn4'].'",mailclt="'.strtolower($_POST['tn5']).'" WHERE idclt="'.$_POST['tn0'].'"';
					$req1=mysql_query($sql1) or die (mysql_error());
					$_SESSION['sdetat']='Modifications effectuées';
					header('location: index.php?fct=clientele&rub=null');
				}else
				{
					$_SESSION['sdetat']='Ce client est deja enregistre';
					$dt=mysql_fetch_array($req);
					header('location: index.php?fct=clientele&rub=null&ope=form&task=modif&idclt='.$_POST['tn0'].'&steclt='.$_POST['tn1'].'&nomclt='.$_POST['tn2'].'&telclt='.$_POST['tn3'].'&faxclt='.$_POST['tn4'].'&mailclt='.$_POST['tn5'].'');
				}
			}else
			{
				$_SESSION['sdetat']='Veuillez renseigner le champs societe ou nom et prenom';
				header('location: index.php?fct=clientele&rub=null&ope=form&task=modif&idclt='.$_POST['tn0'].'&steclt='.$_POST['tn1'].'&nomclt='.$_POST['tn2'].'&telclt='.$_POST['tn3'].'&faxclt='.$_POST['tn4'].'&mailclt='.$_POST['tn5'].'');
			}
		}else
		{
			$_SESSION['etat']='Veuillez renseigner le champs telephone';
			header('location: index.php?fct=clientele&rub=null&ope=form&task=modif&idclt='.$_POST['tn0'].'&steclt='.$_POST['tn1'].'&nomclt='.$_POST['tn2'].'&telclt='.$_POST['tn3'].'&faxclt='.$_POST['tn4'].'&mailclt='.$_POST['tn5'].'');
		}
	}elseif(isset($_POST['bt1']) && $_POST['bt1']=='add_agent')
	{
		if((isset($_POST['tn2']) && !empty($_POST['tn2'])) && (isset($_POST['tn1']) && !empty($_POST['tn1'])))
		{
			$sql='SELECT * FROM utilisateur WHERE teluser="'.$_POST['tn2'].'"';
			$req=mysql_query($sql) or die (mysql_error());
			$nb=mysql_num_rows($req);
			if($nb==0)
			{
				$sql1='INSERT INTO utilisateur(teluser,nomuser,motpass,profil) VALUES("'.$_POST['tn2'].'","'.strtolower($_POST['tn1']).'","77bee1ce07ad8a5fa051af2fa883d566","agent")';
				$req1=mysql_query($sql1) or die ('ERREUR SQL1<br>'.$sql1.'<br>'.mysql_error());
				header('location: index.php?fct=utilisateur&rub=null&ope=form&etat=Enregistrement effectue');
			}else{
				header('location: index.php?fct=utilisateur&rub=null&ope=form&teluser='.$_POST['tn2'].'&nomuser='.$_POST['tn1'].'&profil=agent&etat=Cet agent est deja enregistre');
			}
		}else{
			header('location: index.php?fct=utilisateur&rub=null&ope=form&teluser='.$_POST['tn2'].'&nomuser='.$_POST['tn1'].'&profil=agent&etat=Veuillez renseigner les champs vides');
		}
	}elseif(isset($_POST['bt1']) && $_POST['bt1']=='modif_agent')
	{
		if((isset($_POST['tn2']) && !empty($_POST['tn2'])) && (isset($_POST['tn1']) && !empty($_POST['tn1'])))
		{
			$sql1='UPDATE utilisateur SET nomuser="'.strtolower($_POST['tn1']).'" WHERE teluser="'.$_POST['tn2'].'"';
			$req1=mysql_query($sql1) or die (mysql_error());
			header('location: index.php?fct=utilisateur&rub=null&ope=form&teluser='.$_POST['tn2'].'&nomuser='.$_POST['tn1'].'&profil=agent&etat=Modifications effectuées');
		}else{
			header('location: index.php?fct=utilisateur&rub=null&ope=form&teluser='.$_POST['tn2'].'&nomuser='.$_POST['tn1'].'&profil=agent&etat=Veuillez renseigner les champs vides');
		}
	}elseif(isset($_POST['bt1']) && $_POST['bt1']=='add_prod')
	{
		if((isset($_POST['tn1']) && !empty($_POST['tn1'])) && (isset($_POST['tn7']) && !empty($_POST['tn7'])))
		{
			$sql='SELECT * FROM produit WHERE libprod="'.strtolower($_POST['tn1']).'"';
			$req=mysql_query($sql) or die (mysql_error());
			$nb=mysql_num_rows($req);
			if($nb==0)
			{
				$sql1='INSERT INTO produit(idprod,desiprod,desi_en,catprod) VALUES("","'.strtolower($_POST['tn1']).'","'.strtolower($_POST['tn2']).'","'.strtolower($_POST['tn9']).'")';
				$req1=mysql_query($sql1) or die (mysql_error());
				$nk=$_POST['tn9'].''.mysql_insert_id();
				$sql2='INSERT INTO prodlist(idpdlist,prod,dtexp,prixht,taxe,seuil,cdfour,four) VALUES("'.strtolower($nk).'","'.mysql_insert_id().'","'.strtolower($_POST['tn3']).'","'.strtolower($_POST['tn4']).'","'.$_POST['tn5'].'","'.$_POST['tn6'].'","'.strtolower($_POST['tn7']).'","'.$_POST['tn8'].'")';
				$req2=mysql_query($sql2) or die (mysql_error());
				$sql3='SELECT * FROM magazin';
				$req3=mysql_query($sql3);
				while($dt3=mysql_fetch_array($req3))
				{
					$sql4='INSERT INTO prodstock(idpdstock,prodlist,mag) VALUES("","'.strtolower($nk).'","'.$dt3['idmag'] .'")';
					$req4=mysql_query($sql4);
				}
				$_SESSION['etat']='Enregistrement du produit effectue';
				header('location: index.php?fct=commande&rub=produit&ope=form');
			}else
			{
				$_SESSION['etat']='Ce produit est deja enregistre';
				header('location: index.php?fct=commande&rub=produit&ope=form&task=modif&idfour='.$_POST['tn8'].'&desiprod='.$_POST['tn1'].'&desi_en='.$_POST['tn2'].'&dtexp='.$_POST['tn3'].'&prixht='.$_POST['tn4'].'&idtva='.$_POST['tn5'].'&seuil='.$_POST['tn6'].'&cdfour='.$_POST['tn7'].'&idcat='.$_POST['tn9'].'');
			}
		}else
		{
			$_SESSION['etat']='Veuillez renseigner les champs vides';
			header('location: index.php?fct=commande&rub=produit&ope=form&task=modif&idfour='.$_POST['tn8'].'&desiprod='.$_POST['tn1'].'&desi_en='.$_POST['tn2'].'&dtexp='.$_POST['tn3'].'&prixht='.$_POST['tn4'].'&idtva='.$_POST['tn5'].'&seuil='.$_POST['tn6'].'&cdfour='.$_POST['tn7'].'&idcat='.$_POST['tn9'].'');
		}
	}elseif(isset($_POST['bt1']) && $_POST['bt1']=='modif_prod')
	{
		if((isset($_POST['tn1']) && !empty($_POST['tn1'])) && (isset($_POST['tn7']) && !empty($_POST['tn7'])))
		{
			$sql='SELECT * FROM produit WHERE desiprod="'.strtolower($_POST['tn1']).'" AND idprod!="'.$_POST['tn00'].'"';
			$req=mysql_query($sql) or die (mysql_error());
			$nb=mysql_num_rows($req);
			if($nb==0)
			{
				$sql1='UPDATE produit SET desiprod="'.strtolower($_POST['tn1']).'",desi_en="'.$_POST['tn2'].'" WHERE idprod="'.$_POST['tn00'].'"';
				$req1=mysql_query($sql1) or die (mysql_error());
				$sql2='UPDATE prodlist SET dtexp="'.strtolower($_POST['tn3']).'",prixht="'.$_POST['tn4'].'",taxe="'.$_POST['tn5'].'",seuil="'.$_POST['tn6'].'",cdfour="'.strtolower($_POST['tn7']).'",four="'.$_POST['tn8'].'" WHERE idpdlist="'.$_POST['tn0'].'"';
				$req2=mysql_query($sql2) or die (mysql_error());
				$sql3='SELECT * FROM magazin';
				$req3=mysql_query($sql3);
				$cp=9;$ng=1;
				while($dt3=mysql_fetch_array($req3))
				{
					$n=$cp+$ng;
					$ft='tn'.$n;
					$sql4='UPDATE prodstock SET qtite="'.abs($_POST[$ft]).'" WHERE mag="'.$dt3['idmag'].'" AND prodlist="'.$_POST['tn0'].'"';
					$req4=mysql_query($sql4);
					$ng++;
				}
				$_SESSION['etat']='Modification du produit effectuees';
				header('location: index.php?fct=commande&rub=produit');
			}else
			{
				$_SESSION['etat']='Ce produit est deja enregistre';
				header('location: index.php?fct=commande&rub=produit&ope=form&task=modif&idpdlist='.$_POST['tn0'].'&idprod='.$_POST['tn0'].'&idfour='.$_POST['tn8'].'&desiprod='.$_POST['tn1'].'&desi_en='.$_POST['tn2'].'&dtexp='.$_POST['tn3'].'&prixht='.$_POST['tn4'].'&idtva='.$_POST['tn5'].'&seuil='.$_POST['tn6'].'&cdfour='.$_POST['tn7'].'&idcat='.$_POST['tn9'].'');
			}
		}else
		{
			$_SESSION['etat']='Veuillez renseigner les champs vides';
			header('location: index.php?fct=commande&rub=produit&ope=form&task=modif&idpdlist='.$_POST['tn0'].'&idprod='.$_POST['tn0'].'&idfour='.$_POST['tn8'].'&desiprod='.$_POST['tn1'].'&desi_en='.$_POST['tn2'].'&dtexp='.$_POST['tn3'].'&prixht='.$_POST['tn4'].'&idtva='.$_POST['tn5'].'&seuil='.$_POST['tn6'].'&cdfour='.$_POST['tn7'].'&idcat='.$_POST['tn9'].'');
		}
	}elseif(isset($_POST['bt1']) && $_POST['bt1']=='add_cmd')
	{
		$sql='INSERT INTO commande(idcmd,fourcmd,dtcmd) VALUES("'.$_SESSION['cmd'].'","'.$_SESSION['idfour'].'","'.$_SESSION['dtcmd'].'")';
		$req=mysql_query($sql) or die (mysql_error());
		for($i=1; $i<=sizeof($_SESSION['idpdlist']); $i++)
		{
			if((isset($_POST['tn'.$i]) && !empty($_POST['tn'.$i])))
			{
				$sql1='INSERT INTO cmdlist(idcmdlist,cmd,prodcmd,qtitecmd) VALUES("","'.$_SESSION['cmd'].'","'.$_SESSION['idpdlist'][$i].'","'.$_POST['tn'.$i].'")';
				$req1=mysql_query($sql1) or die (mysql_error());
			}else
			{
				$sql1='INSERT INTO cmdlist(idcmdlist,cmd,prodcmd) VALUES("","'.$_SESSION['cmd'].'","'.$_SESSION['idpdlist'][$i].'")';
				$req1=mysql_query($sql1) or die (mysql_error());
			}
		}
		unset($_SESSION['idpdlist']);
		unset($_SESSION['idcmdlist']);
		unset($_SESSION['idfour']);
		unset($_SESSION['desifour']);
		unset($_SESSION['desiprod']);
		unset($_SESSION['cdfour']);
		unset($_SESSION['cmd']);
		unset($_SESSION['dtcmd']);
		header('location: index.php?fct=commande&rub=null');
	}elseif(isset($_POST['bt1']) && $_POST['bt1']=='modif_cmd')
	{
		$fret=$_POST['tn1'];
		$cp=0;
		for($i=1; $i<=sizeof($_SESSION['idcmdlist']); $i++)
		{
			if(($_POST['tnc'.$i] == $_POST['tnl'.$i]) || ($_POST['tnc'.$i] == $_POST['tnl'.$i]+$_POST['tna'.$i]) || (($_POST['tnc'.$i] > $_POST['tnl'.$i]) && ($_POST['tnc'.$i] > $_POST['tna'.$i])))
			{
				$cp++;
			}
		}
		for($j=1; $j<=sizeof($_SESSION['idcmdlist']); $j++)
		{
			if($cp==sizeof($_SESSION['idcmdlist']))
			{
				$sql1='UPDATE cmdlist SET qtitecmd="'.$_POST['tnc'.$j].'",qtiteliv="'.$_POST['tnl'.$j].'",avaricmd="'.$_POST['tna'.$j].'" WHERE idcmdlist="'.$_SESSION['idcmdlist'][$j].'"';
				$req1=mysql_query($sql1) or die (mysql_error());
				$sql2='UPDATE commande SET fret="'.$fret.'" WHERE idcmd="'.$_SESSION['cmd'].'"';
				$req2=mysql_query($sql2) or die (mysql_error());
			}
		}
		unset($_SESSION['idpdlist']);
		unset($_SESSION['idcmdlist']);
		unset($_SESSION['idfour']);
		unset($_SESSION['desifour']);
		unset($_SESSION['desiprod']);
		unset($_SESSION['cdfour']);
		unset($_SESSION['cmd']);
		unset($_SESSION['dtcmd']);
		header('location: index.php?fct=commande&rub=null');
	}elseif(isset($_POST['bt1']) && $_POST['bt1']=='securite_up')
	{
		if((isset($_POST['tn2']) && !empty($_POST['tn2'])) && (isset($_POST['tn1']) && !empty($_POST['tn1'])) && (isset($_POST['tn3']) && !empty($_POST['tn3'])))
		{
			if(md5($_POST['tn1'])==$_SESSION['sdpass'])
			{
				if($_POST['tn2']==$_POST['tn3'])
				{
					$sql0='UPDATE mbre SET sdpass="'.md5($_POST['tn2']).'" WHERE idmbre="'.$_SESSION['usip'].'"';
					$req0=mysql_query($sql0) or die(mysql_error());
					$_SESSION['sdetat']='Modification effectuee';
				}else
				{
					$_SESSION['sdetat']='Nouveau mot de passe non conforme';
				}
			}else
			{
				$_SESSION['sdetat']='Ancien mot de passe non conforme';
			}
		}else
		{
			$_SESSION['sdetat']='Veuillez renseigner les champs vides';
		}
		header('location: index.php?fct=parametre&ope=modif');
	}
?>