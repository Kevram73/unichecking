<?php

define('IMG_PATH', 'img/');

define('DAYS_OF_WEEK', array(
	1 => "LUNDI",
	2 => "MARDI",
	3 => "MERCREDI",
	4 => "JEUDI",
	5 => "VENDREDI",
	6 => "SAMEDI",
	7 => "DIMANCHE"
	)
);

define('WEEKEND', array(
	6 => "SAMEDI",
	7 => "DIMANCHE"
	)
);
define('sep_an', ' - ');
define('user_role__admin', 1);
define('user_role__enseignant', 2);

define('status_prob_bd', -2);

$cst = 1;
define('status_tpi__libellevide', $cst++);
define('status_tpi__libelledbl', $cst++);
define('status_tpi__idnotfnd', $cst++);
define('status_tpi__idused', $cst++);

$cst = 1;
define('status_tdpl__dsgvide', $cst++);
define('status_tdpl__dsgdbl', $cst++);
define('status_tdpl__idnotfnd', $cst++);
define('status_tdpl__idused', $cst++);

$cst = 1;
define('status_ens__nomvide', $cst++);
define('status_ens__prenvide', $cst++);
define('status_ens__emailvide', $cst++);
define('status_ens__emaildbl', $cst++);
define('status_ens__tpiunkwn', $cst++);
define('status_ens__grdunkwn', $cst++);
define('status_ens__pstunkwn', $cst++);
define('status_ens__idnotfnd', $cst++);
define('status_ens__idused', $cst++);

$cst = 1;
define('status_fil__nomvide', $cst++);
define('status_fil__nomdbl', $cst++);
define('status_fil__facunkwn', $cst++);
define('status_fil__idnotfnd', $cst++);
define('status_fil__idused', $cst++);

$cst = 1;
define('status_fac__codevide', $cst++);
define('status_fac__codedbl', $cst++);
define('status_fac__libellevide', $cst++);
define('status_fac__libelledbl', $cst++);
define('status_fac__idnotfnd', $cst++);
define('status_fac__idused', $cst++);


$cst = 1;
define('status_sce__jourvide', $cst++);
define('status_sce__hrdebvide', $cst++);
define('status_sce__hrfinvide', $cst++);
define('status_sce__hrchrono', $cst++);
define('status_sce__dtdebvide', $cst++);
define('status_sce__dtfinvide', $cst++);
define('status_sce__dtchrono', $cst++);
define('status_sce__ensunkwn', $cst++);
define('status_sce__ueunkwn', $cst++);
define('status_sce__idnotfnd', $cst++);
define('status_sce__idused', $cst++);

$cst = 1;
define('status_dpl__tpdunkwn', $cst++);
define('status_dpl__dtdebvide', $cst++);
define('status_dpl__dtfinvide', $cst++);
define('status_dpl__dtchrono', $cst++);
define('status_dpl__ensunkwn', $cst++);
define('status_dpl__ueunkwn', $cst++);
define('status_dpl__idnotfnd', $cst++);
define('status_dpl__idused', $cst++);

$cst = 1;
define('status_ue__codevide', $cst++);
define('status_ue__codedbl', $cst++);
define('status_ue__intitulevide', $cst++);
define('status_ue__intituledbl', $cst++);
define('status_ue__idnotfnd', $cst++);
define('status_ue__idused', $cst++);

$cst = 1;
define('status_pst__libellevide', $cst++);
define('status_pst__libelledbl', $cst++);
define('status_pst__catunkwn', $cst++);
define('status_pst__idnotfnd', $cst++);
define('status_pst__idused', $cst++);
define('status_cat__libellevide', $cst++);
define('status_cat__libelledbl', $cst++);
define('status_cat__idnotfnd', $cst++);
define('status_cat__idused', $cst++);

$cst = 1;
define('status_grd__intitulevide', $cst++);
define('status_grd__intituledbl', $cst++);
define('status_grd__idnotfnd', $cst++);
define('status_grd__idused', $cst++);

$cst = 1;
define('status_unv__nomvide', $cst++);
define('status_unv__nomdbl', $cst++);
define('status_unv__idnotfnd', $cst++);
define('status_unv__idused', $cst++);

$cst = 1;
define('status_spe__codevide', $cst++);
define('status_spe__codedbl', $cst++);
define('status_spe__intitulevide', $cst++);
define('status_spe__intituledbl', $cst++);
define('status_spe__idnotfnd', $cst++);
define('status_spe__idused', $cst++);

$cst = 1;
define('status_usr__nomvide', $cst++);
define('status_usr__prenvide', $cst++);
define('status_usr__emailvide', $cst++);
define('status_usr__emaildbl', $cst++);
define('status_usr__idnotfnd', $cst++);
define('status_usr__idused', $cst++);
define('status_usr__badlogin', $cst++);
define('status_usr__oldpwdnotset', $cst++);
define('status_usr__nwpwdvide', $cst++);
define('status_usr__badpwd', $cst++);
define('status_usr__badconfpwd', $cst++);
		

$cst = 1;
define('status_an__libellevide', $cst++);
define('status_an__libelledbl', $cst++);
define('status_an__opennew', $cst++);
define('status_an__closupd', $cst++);
define('status_an__no_onoff', $cst++);
define('status_an__unvunkwn', $cst++);
define('status_an__idnotfnd', $cst++);
define('status_an__idused', $cst++);

$cst = 1;			
define('status_ens_ue__dtvide', $cst++);
define('status_ens_ue__dbl', $cst++);
define('status_ens_ue__ensunkwn', $cst++);
define('status_ens_ue__ueunkwn', $cst++);
define('status_ens_ue__idnotfnd', $cst++);
define('status_ens_ue__idused', $cst++);

?>