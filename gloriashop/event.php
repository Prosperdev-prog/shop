<?php
	include('./sdpanel/db.php');
	session_start(); // Assurez-vous que la session est démarrée
	if(isset($_POST['bt1']) && $_POST['bt1']=='connexion')
	{
		if((isset($_POST['tn1']) && !empty($_POST['tn1'])) && (isset($_POST['tn2']) && !empty($_POST['tn2'])) && (isset($_POST['tn3']) && !empty($_POST['tn3'])))
		{
			if($_SESSION['sdcapt']==$_POST['tn3'])
			{
				$sql1='SELECT * FROM utilisateur WHERE teluser="'.$_POST['tn1'].'" AND motpass="'.md5($_POST['tn2']).'"';
				$req1=mysql_query($sql1) or die(mysql_error());
				$nb1=mysql_num_rows($req1);
				if($nb1!=0)
				{
					$dt1=mysql_fetch_array($req1);
					$_SESSION['nom']=$dt1['nomuser'];
					$_SESSION['tel']=$dt1['teluser'];
					$_SESSION['pass']=$dt1['motpass'];
					$_SESSION['profil']=$dt1['profil'];
					header('location: index.php');
				}else{
					header('location: index.php?etat=Veuillez renseigner un profil disponible');
				}
			}else{
				header('location: index.php?etat=Code de securite non conforme');
			}
		}else{
			header('location: index.php?etat=Veuillez remplir les champs vides');
		}
	}elseif(isset($_POST['bt1']) && $_POST['bt1']=='modif_passe')
	{
		if((isset($_POST['tn3']) && !empty($_POST['tn3'])) && (isset($_POST['tn2']) && !empty($_POST['tn2'])) && (isset($_POST['tn1']) && !empty($_POST['tn1'])))
		{
			if(md5($_POST['tn1'])==$_SESSION['pass'])
			{
				if($_POST['tn2']==$_POST['tn3'])
				{
					$sql0='UPDATE agent SET motpass="'.htmlentities(strtolower(md5($_POST['tn2']))).'" WHERE telagent="'.$_SESSION['tel'].'"';
					$req0=mysql_query($sql0) or die(mysql_error());
					$_SESSION['etat']='<font color="#FF0000">Modifications du mot de passe effectue</font>';
					header('location: index.php?fct=trafic&ope=form');
				}else{
					$_SESSION['etat']='<font color="#FF0000">Nouveau mot de passe non conforme</font>';
					header('location: index.php?fct=trafic&ope=form');
				}
			}else{
				$_SESSION['etat']='<font color="#FF0000">Ancien mot de passe non conforme</font>';
				header('location: index.php?fct=trafic&ope=form');
			}
		}else{
			$_SESSION['etat']='<font color="#FF0000">Veuillez renseigner les champs vides</font>';
			header('location: index.php?fct=trafic&ope=form');
		}
	}elseif(isset($_POST['bt1']) && $_POST['bt1']=='add_client')
	{
		if((isset($_POST['tn2']) && !empty($_POST['tn2'])) && (isset($_POST['tn1']) && !empty($_POST['tn1'])))
		{
			$sql='SELECT * FROM client WHERE telclt="'.$_POST['tn2'].'"';
			$req=mysql_query($sql) or die (mysql_error());
			$nb=mysql_num_rows($req);
			if($nb==0)
			{
				$sql1='INSERT INTO client(telclt,nomclt) VALUES("'.$_POST['tn2'].'","'.strtolower($_POST['tn1']).'")';
				$req1=mysql_query($sql1) or die (mysql_error());
				header('location: index.php?fct=clientele&rub=null&etat=Enregistrement du client effectue');
			}else{
				header('location: index.php?fct=clientele&rub=null&ope=form&nomclt='.$_POST['tn1'].'&telclt='.$_POST['tn2'].'&etat=Ce client est deja enregistre');
			}
		}else{
			header('location: index.php?fct=clientele&rub=null&ope=form&nomclt='.$_POST['tn1'].'&telclt='.$_POST['tn2'].'&etat=Veuillez renseigner le champs telephone');
		}
	}elseif(isset($_POST['bt1']) && $_POST['bt1']=='modif_client')
	{
		if((isset($_POST['tn2']) && !empty($_POST['tn2'])) && (isset($_POST['tn1']) && !empty($_POST['tn1'])))
		{
			$sql1='UPDATE client SET nomclt="'.strtolower($_POST['tn1']).'" WHERE telclt="'.$_POST['tn0'].'"';
			$req1=mysql_query($sql1) or die (mysql_error());
			header('location: index.php?fct=clientele&rub=null&etat=Modifications effectu�es');
		}else{
			header('location: index.php?fct=clientele&rub=null&ope=form&task=modif&nomclt='.$_POST['tn2'].'&telclt='.$_POST['tn3'].'etat=Veuillez renseigner le champs societe ou nom et prenom');
		}
	}elseif(isset($_POST['bt1']) && $_POST['bt1']=='calculer' || $_POST['bt1']=='enregistrer')
	{
		$etat='';
		if($_POST['bt1']=='enregistrer')
		{
			$ope='save';
		}
		for($i=1; $i<=sizeof($_SESSION['idprod']); $i++)
		{
			$p='p'.$i; $t='t'.$i; $r='r'.$i; $qt='q'.$i; $l='l'.$i;
			if(($_POST[$t]=='') || ($_POST[$p]=='') || ($_POST[$qt]==0))
			{
				unset($_SESSION['mtht']);
				$etat='erreur';
			}else{
				$_SESSION['qt'][$i]=abs($_POST[$qt]);
				$_SESSION['taxe'][$i]=$_POST[$t];
				$_SESSION['mtprod'][$i]=abs($_POST[$p]);
				if($_SESSION['qt'][$i]>$_SESSION['qtstk'][$i] || $_SESSION['qt'][$i]==0)
				{
					$_SESSION['erreur'][$i]=$_SESSION['qtstk'][$i];
					$_SESSION['mt'][$i]=$_SESSION['qtstk'][$i]*$_SESSION['mtprod'][$i];
					$etat='erreur';
				}else{
					$_SESSION['erreur'][$i]=0;
					$_SESSION['mt'][$i]=$_SESSION['qt'][$i]*$_SESSION['mtprod'][$i];
				}
			}
		}
		if($etat=='erreur')
		{
			unset($_SESSION['mtht']);
			header('location: index.php?fct=facturation&rub=edition&ope=form');
		}else{
			if($ope=='save')
			{
				$sql2='SELECT * FROM facture WHERE idfac="'.$_SESSION['numfac'].'"';
				$req2=mysql_query($sql2);
				$nb2=mysql_num_rows($req2);
				if($nb2==0)
				{
					for($i=1; $i<=sizeof($_SESSION['idprod']); $i++)
					{
						$sql0='INSERT INTO faclist(idfaclist,facture,prodfac,qtfac,mtfac) VALUES("", "'.$_SESSION['numfac'].'", "'.$_SESSION['idprod'][$i].'", "'.$_SESSION['qt'][$i].'", "'.$_SESSION['mtprod'][$i].'")';
						$req0=mysql_query($sql0) or die(mysql_error);
						$s=$_SESSION['qtstk'][$i]-$_SESSION['qt'][$i];
						$sql2='UPDATE produit SET qtprod="'.$s.'" WHERE idprod="'.$_SESSION['idprod'][$i].'"';
						$req2=mysql_query($sql2) or die(mysql_error);
					}
					$sql1='INSERT INTO facture(idfac,cltfac,dtfac) VALUES("'.$_SESSION['numfac'].'", "'.$_SESSION['telclt'].'", "'.date('Y-m-d').'")';
					$req1=mysql_query($sql1) or die(mysql_error());
					header('location: index.php?fct=facturation&rub=null&ope=situation&idfac='.$_SESSION['numfac'].'&dtfac='.date('Y-m-d').'&nomclt='.$_SESSION['nomclt'].'&telclt='.$_SESSION['telclt'].'');
				}else{
					header('location: index.php?fct=facturation');
				}
			}else{
				header('location: index.php?fct=facturation&rub=edition&ope=form');
			}
		}
	}
?>