<?php
include('appli.php');

if(!isset($_SESSION['teluser']) || !$_SESSION['teluser']) {
    $_SESSION['teluser'] = ''; // Valeur par défaut

    ?>
    <html>
        <head>
            <link rel="SHORTCUT ICON" href="./picture/icone.ico">
            <title><?php echo isset($_SESSION['sdtitre']) ? $_SESSION['sdtitre'] : 'Titre par défaut'; ?></title>
            <link rel="stylesheet" type="text/css" href="panel.css">
        </head>
        <body id="panel">
            <form method="POST" action="event.php" enctype="multipart/form-data">
                <div class="rac">
                    <div class="top"><h1>AGENCE DES TECHNOLOGIES NOUVELLES</h1></div>
                    <div class="midle">
                        <h1>Gestion commerciale</h1>
                        <ul>
                            A notre actif &nbsp; : : 
                            <li>Gestion commerciale</li>
                            <li>Gestion comptable</li>
                            <li class="last">Organiseur</li>
                        </ul>
                        <div class="access">
                            <table border="0" align="center">
                                <tr><td colspan="2"><h3><br>Ouvrir session</h3><hr size="1"></td></tr>
                                <tr><td colspan="2">&nbsp;<?php echo isset($_SESSION['sdetat']) ? $_SESSION['sdetat'] : ''; ?>&nbsp;</td></tr>
                                <tr><td align="right"><label>T&eacute;l&eacute;phone : </label></td><td><input type="text" name="sdchp1"></td></tr>
                                <tr><td align="right"><label>Mot de passe : </label></td><td><input type="password" name="sdchp2"></td></tr>
                                <tr><td>&nbsp;</td><td>Recopier le code<?php echo isset($sdcapt) ? $sdcapt : ''; ?></td></tr>
                                <tr><td align="right"><img src="fs.php"> </td><td width="280"><input type="text" name="sdchp3"></td></tr>
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
    $_SESSION['sdetat'] = '';
} else {
    if(isset($_GET['fct'])) {
        switch($_GET['fct']) {
            case 'deconnexion':
                deconnexion();
                break;
            case 'facturation':
                facturation();
                break;
            case 'commande':
                commande();
                break;
            case 'gestock':
                gestock();
                break;
            case 'clientele':
                clientele();
                break;
            case 'utilisateur':
                utilisateur();
                break;
            case 'parametres':
                parametres();
                break;
            default:
                trafic();
                break;
        }
    }

    ?>
    <html>
        <head>
            <meta http-equiv="content-type" content="text/html" charset="utf-8" />
            <title><?php echo isset($_SESSION['sdtitre']) ? $_SESSION['sdtitre'] : 'Titre par défaut'; ?></title>
            <link rel="SHORTCUT ICON" href="./picture/icone.ico">
            <link href="panel.css" rel="stylesheet" type="text/css" />
        </head>
        <body>
            <form method="post" action="event.php" enctype="multipart/form-data">
                <div class="racine">
                    <div class="haut"><h1>AGENCE DES TECHNOLOGIES NOUVELLES</h1></div>
                    <div class="infosys">
                        <div class="lecompte"><a href="index.php?fct=parametres">parametres</a> | <a href="index.php?fct=deconnexion">deconnexion</a></div>
                        <div class="ladate"><?php echo date('d-m-Y'); ?> &nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp; Panneau d'assistance en ligne</div>
                    </div>
                    <div class="centre">
                        <div class="public"><?php echo isset($_SESSION['menu']) ? $_SESSION['menu'] : ''; ?></div>
                        <div class="princip">
                            <?php echo isset($_SESSION['sdaff']) ? $_SESSION['sdaff'] : ''; ?>
                            <div class="bas">Copyright &copy; D&eacute;cembre 2014 - Agennce des Technologies Nouvelles</div>
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
