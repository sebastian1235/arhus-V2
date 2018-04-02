<!-- Begin Main Menu -->
<?php $RootMenu = new cMenu(EW_MENUBAR_ID) ?>
<?php

// Generate all menu items
$RootMenu->IsRoot = TRUE;
$RootMenu->AddMenuItem(1, "mi_ap_asignacion", $Language->MenuPhrase("1", "MenuText"), "ap_asignacionlist.php", -1, "", AllowListMenu('{6A9AC718-A824-45A3-BED3-A95E91E6986D}ap_asignacion'), FALSE, FALSE);
$RootMenu->AddMenuItem(2, "mi_ap_camp_cliente", $Language->MenuPhrase("2", "MenuText"), "ap_camp_clientelist.php", -1, "", AllowListMenu('{6A9AC718-A824-45A3-BED3-A95E91E6986D}ap_camp_cliente'), FALSE, FALSE);
$RootMenu->AddMenuItem(3, "mi_ap_detalle_venta", $Language->MenuPhrase("3", "MenuText"), "ap_detalle_ventalist.php", -1, "", AllowListMenu('{6A9AC718-A824-45A3-BED3-A95E91E6986D}ap_detalle_venta'), FALSE, FALSE);
$RootMenu->AddMenuItem(4, "mi_ap_estado_interno", $Language->MenuPhrase("4", "MenuText"), "ap_estado_internolist.php", -1, "", AllowListMenu('{6A9AC718-A824-45A3-BED3-A95E91E6986D}ap_estado_interno'), FALSE, FALSE);
$RootMenu->AddMenuItem(5, "mi_ap_estado_preventa", $Language->MenuPhrase("5", "MenuText"), "ap_estado_preventalist.php", -1, "", AllowListMenu('{6A9AC718-A824-45A3-BED3-A95E91E6986D}ap_estado_preventa'), FALSE, FALSE);
$RootMenu->AddMenuItem(6, "mi_ap_forma_pago", $Language->MenuPhrase("6", "MenuText"), "ap_forma_pagolist.php", -1, "", AllowListMenu('{6A9AC718-A824-45A3-BED3-A95E91E6986D}ap_forma_pago'), FALSE, FALSE);
$RootMenu->AddMenuItem(7, "mi_ap_grupo_nomina", $Language->MenuPhrase("7", "MenuText"), "ap_grupo_nominalist.php", -1, "", AllowListMenu('{6A9AC718-A824-45A3-BED3-A95E91E6986D}ap_grupo_nomina'), FALSE, FALSE);
$RootMenu->AddMenuItem(8, "mi_ap_grupo_usuarios", $Language->MenuPhrase("8", "MenuText"), "ap_grupo_usuarioslist.php", -1, "", AllowListMenu('{6A9AC718-A824-45A3-BED3-A95E91E6986D}ap_grupo_usuarios'), FALSE, FALSE);
$RootMenu->AddMenuItem(9, "mi_ap_items_inv", $Language->MenuPhrase("9", "MenuText"), "ap_items_invlist.php", -1, "", AllowListMenu('{6A9AC718-A824-45A3-BED3-A95E91E6986D}ap_items_inv'), FALSE, FALSE);
$RootMenu->AddMenuItem(11, "mi_ap_solicitud", $Language->MenuPhrase("11", "MenuText"), "ap_solicitudlist.php", -1, "", AllowListMenu('{6A9AC718-A824-45A3-BED3-A95E91E6986D}ap_solicitud'), FALSE, FALSE);
$RootMenu->AddMenuItem(16, "mi_demanda", $Language->MenuPhrase("16", "MenuText"), "demandalist.php", -1, "", AllowListMenu('{6A9AC718-A824-45A3-BED3-A95E91E6986D}demanda'), FALSE, FALSE);
$RootMenu->AddMenuItem(24, "mci_Parametros", $Language->MenuPhrase("24", "MenuText"), "", -1, "", IsLoggedIn(), TRUE, TRUE);
$RootMenu->AddMenuItem(10, "mi_ap_roles_usuarios", $Language->MenuPhrase("10", "MenuText"), "ap_roles_usuarioslist.php", 24, "", AllowListMenu('{6A9AC718-A824-45A3-BED3-A95E91E6986D}ap_roles_usuarios'), FALSE, FALSE);
$RootMenu->AddMenuItem(12, "mi_ap_terceros", $Language->MenuPhrase("12", "MenuText"), "ap_terceroslist.php", 24, "", AllowListMenu('{6A9AC718-A824-45A3-BED3-A95E91E6986D}ap_terceros'), FALSE, FALSE);
$RootMenu->AddMenuItem(13, "mi_ap_tipo_cliente", $Language->MenuPhrase("13", "MenuText"), "ap_tipo_clientelist.php", 24, "", AllowListMenu('{6A9AC718-A824-45A3-BED3-A95E91E6986D}ap_tipo_cliente'), FALSE, FALSE);
$RootMenu->AddMenuItem(14, "mi_ap_tipo_inv", $Language->MenuPhrase("14", "MenuText"), "ap_tipo_invlist.php", 24, "", AllowListMenu('{6A9AC718-A824-45A3-BED3-A95E91E6986D}ap_tipo_inv'), FALSE, FALSE);
$RootMenu->AddMenuItem(15, "mi_ap_tipo_tercero", $Language->MenuPhrase("15", "MenuText"), "ap_tipo_tercerolist.php", 24, "", AllowListMenu('{6A9AC718-A824-45A3-BED3-A95E91E6986D}ap_tipo_tercero'), FALSE, FALSE);
$RootMenu->AddMenuItem(17, "mi_siax_campana", $Language->MenuPhrase("17", "MenuText"), "siax_campanalist.php", 24, "", AllowListMenu('{6A9AC718-A824-45A3-BED3-A95E91E6986D}siax_campana'), FALSE, FALSE);
$RootMenu->AddMenuItem(18, "mi_siax_ciudad", $Language->MenuPhrase("18", "MenuText"), "siax_ciudadlist.php", 24, "", AllowListMenu('{6A9AC718-A824-45A3-BED3-A95E91E6986D}siax_ciudad'), FALSE, FALSE);
$RootMenu->AddMenuItem(19, "mi_siax_estado_giv", $Language->MenuPhrase("19", "MenuText"), "siax_estado_givlist.php", 24, "", AllowListMenu('{6A9AC718-A824-45A3-BED3-A95E91E6986D}siax_estado_giv'), FALSE, FALSE);
$RootMenu->AddMenuItem(20, "mi_siax_localidad", $Language->MenuPhrase("20", "MenuText"), "siax_localidadlist.php", 24, "", AllowListMenu('{6A9AC718-A824-45A3-BED3-A95E91E6986D}siax_localidad'), FALSE, FALSE);
$RootMenu->AddMenuItem(21, "mi_siax_medio_pago", $Language->MenuPhrase("21", "MenuText"), "siax_medio_pagolist.php", 24, "", AllowListMenu('{6A9AC718-A824-45A3-BED3-A95E91E6986D}siax_medio_pago'), FALSE, FALSE);
$RootMenu->AddMenuItem(22, "mi_siax_sectores", $Language->MenuPhrase("22", "MenuText"), "siax_sectoreslist.php", 24, "", AllowListMenu('{6A9AC718-A824-45A3-BED3-A95E91E6986D}siax_sectores'), FALSE, FALSE);
$RootMenu->AddMenuItem(23, "mi_usuarios", $Language->MenuPhrase("23", "MenuText"), "usuarioslist.php", 24, "", AllowListMenu('{6A9AC718-A824-45A3-BED3-A95E91E6986D}usuarios'), FALSE, FALSE);
$RootMenu->AddMenuItem(-2, "mi_changepwd", $Language->Phrase("ChangePwd"), "changepwd.php", -1, "", IsLoggedIn() && !IsSysAdmin());
$RootMenu->AddMenuItem(-1, "mi_logout", $Language->Phrase("Logout"), "logout.php", -1, "", IsLoggedIn());
$RootMenu->AddMenuItem(-1, "mi_login", $Language->Phrase("Login"), "login.php", -1, "", !IsLoggedIn() && substr(@$_SERVER["URL"], -1 * strlen("login.php")) <> "login.php");
$RootMenu->Render();
?>
<!-- End Main Menu -->
