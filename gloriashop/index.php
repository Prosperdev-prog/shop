<?php
    session_start();
	include('rub.php');
	
if(!isset($_SESSION['teluser']) || !$_SESSION['teluser']) {
    $_SESSION['teluser'] = ''; // Valeur par défaut
	$sdcapt = ""; // Initialisation de la variable $sdcapt
		?>
			<html>
				<head>
					<link rel="SHORTCUT ICON" href="./sdpanel/picture/icone.ico">
					<title><?php echo $_SESSION['sdtitre']; ?></title>
					<link rel="stylesheet" type="text/css" href="style.css">
				</head>
				<body id="panel">
					<form method="POST" action="event.php" enctype="multipart/form-data">
						<div class="rac">
							<div class="top"><h1>AGENCE DES TECHNOLOGIES NOUVELLES</h1></div>
							<div class="midle">
									<h1>Gestion commerciale</h1>
									<ul>
										<li>Gestion du stock</li>
										<li>Gestion des commandes</li>
										<li>Facturation</li>
									</ul>
									<div class="access">
										<table border="0" align="center">
											<tr><td colspan="2"><h3><br>Ouvrir session</h3><hr size="1"></td></tr>
											<tr><td colspan="2">&nbsp;<?php echo isset($_GET['etat']) ? $_GET['etat'] : ''; ?>&nbsp;</td></tr>
											<tr><td align="right"><label>T&eacute;t&eacute;phone : </label></td><td><input type="text" name="tn1"></td></tr>
											<tr><td align="right"><label>Mot de passe : </label></td><td><input type="password" name="tn2"></td></tr>
											<tr><td>&nbsp;</td><td>Recopier le code<?php echo $sdcapt; ?></td></tr>
											<tr><td align="right"><img src="../sdpanel/fs.php"> </td><td width="280"><input type="text" name="tn3"></td></tr>
											<tr><td>&nbsp;</td><td><input type="submit" name="bt1" value="connexion"><br><br><br></td></tr>
										</table>
									</div>
							</div>
							<div class="bottom">Copyright &copy; D&eacute;cembre 2014 - Agennce des Technologies Nouvelles</div>
						</div>
					</form>
				</body>
			</html>
		<?php
		$_SESSION['sdetat']='';
	}else
	{
		if($_GET['fct']=='deconnexion')
		{
			deconnexion();
		}elseif($_GET['fct']=='clientele')
		{
			clientele();
		}elseif($_GET['fct']=='facturation')
		{
			facturation();
		}elseif($_GET['fct']=='gestock')
		{
			gestock();
		}else
		{
			trafic();
		}
		?>
			<html>
				<head>
					<meta http-equiv="content-type" content="text/html" charset="utf-8" />
					<title><?php echo $_SESSION['sdtitre']; ?></title>
					<link rel="SHORTCUT ICON" href="./sdpanel/picture/icone.ico">
					<link href="style.css" rel="stylesheet" type="text/css" />
				</head>
				<body>
					<form method="post" action="event.php" enctype="multipart/form-data">
						<div class="racine">
							<div class="haut"><h1>AGENCE DES TECHNOLOGIES NOUVELLES</h1></div>
							<div class="infosys"><div class="lecompte"><a href="index.php">Parametre</a> | <a href="index.php?fct=deconnexion">deconnexion</a></div><div class="ladate">Gestion commerciale</div></div>
							<div class="centre">
								<div class="public"><?php echo $_SESSION['menu']; ?></div>
								<div class="princip">
									<?php echo $_SESSION['sdaff']; ?>
									<div class="bas">Copyright &copy; D&eacute;cembre 2014 - Toujours choisir nos solutions informatiques</div>
								</div>
							</div>
							<div class="sepa"></div>
						</div>
						<div class="sepa"></div>
					</form>
				</body>
			</html>
		<?php
	}
?>