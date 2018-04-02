<?php

// Global variable for table object
$ap_roles_usuarios = NULL;

//
// Table class for ap_roles_usuarios
//
class cap_roles_usuarios extends cTable {
	var $Id_Rol;
	var $grupo_Rol;
	var $formulario_Rol;
	var $abrir_Rol;
	var $agregar_Rol;
	var $editar_Rol;
	var $eliminar_Rol;
	var $mostrar_Rol;
	var $alias_Rol;
	var $empresa_Rol;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'ap_roles_usuarios';
		$this->TableName = 'ap_roles_usuarios';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`ap_roles_usuarios`";
		$this->DBID = 'DB';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->ExportExcelPageOrientation = ""; // Page orientation (PHPExcel only)
		$this->ExportExcelPageSize = ""; // Page size (PHPExcel only)
		$this->DetailAdd = FALSE; // Allow detail add
		$this->DetailEdit = FALSE; // Allow detail edit
		$this->DetailView = FALSE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 5;
		$this->AllowAddDeleteRow = ew_AllowAddDeleteRow(); // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// Id_Rol
		$this->Id_Rol = new cField('ap_roles_usuarios', 'ap_roles_usuarios', 'x_Id_Rol', 'Id_Rol', '`Id_Rol`', '`Id_Rol`', 3, -1, FALSE, '`Id_Rol`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->Id_Rol->Sortable = TRUE; // Allow sort
		$this->Id_Rol->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Rol'] = &$this->Id_Rol;

		// grupo_Rol
		$this->grupo_Rol = new cField('ap_roles_usuarios', 'ap_roles_usuarios', 'x_grupo_Rol', 'grupo_Rol', '`grupo_Rol`', '`grupo_Rol`', 3, -1, FALSE, '`grupo_Rol`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->grupo_Rol->Sortable = TRUE; // Allow sort
		$this->grupo_Rol->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['grupo_Rol'] = &$this->grupo_Rol;

		// formulario_Rol
		$this->formulario_Rol = new cField('ap_roles_usuarios', 'ap_roles_usuarios', 'x_formulario_Rol', 'formulario_Rol', '`formulario_Rol`', '`formulario_Rol`', 201, -1, FALSE, '`formulario_Rol`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->formulario_Rol->Sortable = TRUE; // Allow sort
		$this->fields['formulario_Rol'] = &$this->formulario_Rol;

		// abrir_Rol
		$this->abrir_Rol = new cField('ap_roles_usuarios', 'ap_roles_usuarios', 'x_abrir_Rol', 'abrir_Rol', '`abrir_Rol`', '`abrir_Rol`', 16, -1, FALSE, '`abrir_Rol`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->abrir_Rol->Sortable = TRUE; // Allow sort
		$this->abrir_Rol->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['abrir_Rol'] = &$this->abrir_Rol;

		// agregar_Rol
		$this->agregar_Rol = new cField('ap_roles_usuarios', 'ap_roles_usuarios', 'x_agregar_Rol', 'agregar_Rol', '`agregar_Rol`', '`agregar_Rol`', 16, -1, FALSE, '`agregar_Rol`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->agregar_Rol->Sortable = TRUE; // Allow sort
		$this->agregar_Rol->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['agregar_Rol'] = &$this->agregar_Rol;

		// editar_Rol
		$this->editar_Rol = new cField('ap_roles_usuarios', 'ap_roles_usuarios', 'x_editar_Rol', 'editar_Rol', '`editar_Rol`', '`editar_Rol`', 16, -1, FALSE, '`editar_Rol`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->editar_Rol->Sortable = TRUE; // Allow sort
		$this->editar_Rol->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['editar_Rol'] = &$this->editar_Rol;

		// eliminar_Rol
		$this->eliminar_Rol = new cField('ap_roles_usuarios', 'ap_roles_usuarios', 'x_eliminar_Rol', 'eliminar_Rol', '`eliminar_Rol`', '`eliminar_Rol`', 16, -1, FALSE, '`eliminar_Rol`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->eliminar_Rol->Sortable = TRUE; // Allow sort
		$this->eliminar_Rol->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['eliminar_Rol'] = &$this->eliminar_Rol;

		// mostrar_Rol
		$this->mostrar_Rol = new cField('ap_roles_usuarios', 'ap_roles_usuarios', 'x_mostrar_Rol', 'mostrar_Rol', '`mostrar_Rol`', '`mostrar_Rol`', 16, -1, FALSE, '`mostrar_Rol`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->mostrar_Rol->Sortable = TRUE; // Allow sort
		$this->mostrar_Rol->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['mostrar_Rol'] = &$this->mostrar_Rol;

		// alias_Rol
		$this->alias_Rol = new cField('ap_roles_usuarios', 'ap_roles_usuarios', 'x_alias_Rol', 'alias_Rol', '`alias_Rol`', '`alias_Rol`', 200, -1, FALSE, '`alias_Rol`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->alias_Rol->Sortable = TRUE; // Allow sort
		$this->fields['alias_Rol'] = &$this->alias_Rol;

		// empresa_Rol
		$this->empresa_Rol = new cField('ap_roles_usuarios', 'ap_roles_usuarios', 'x_empresa_Rol', 'empresa_Rol', '`empresa_Rol`', '`empresa_Rol`', 3, -1, FALSE, '`empresa_Rol`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->empresa_Rol->Sortable = TRUE; // Allow sort
		$this->empresa_Rol->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['empresa_Rol'] = &$this->empresa_Rol;
	}

	// Set Field Visibility
	function SetFieldVisibility($fldparm) {
		global $Security;
		return $this->$fldparm->Visible; // Returns original value
	}

	// Single column sort
	function UpdateSort(&$ofld) {
		if ($this->CurrentOrder == $ofld->FldName) {
			$sSortField = $ofld->FldExpression;
			$sLastSort = $ofld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$sThisSort = $this->CurrentOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$ofld->setSort($sThisSort);
			$this->setSessionOrderBy($sSortField . " " . $sThisSort); // Save to Session
		} else {
			$ofld->setSort("");
		}
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`ap_roles_usuarios`";
	}

	function SqlFrom() { // For backward compatibility
		return $this->getSqlFrom();
	}

	function setSqlFrom($v) {
		$this->_SqlFrom = $v;
	}
	var $_SqlSelect = "";

	function getSqlSelect() { // Select
		return ($this->_SqlSelect <> "") ? $this->_SqlSelect : "SELECT * FROM " . $this->getSqlFrom();
	}

	function SqlSelect() { // For backward compatibility
		return $this->getSqlSelect();
	}

	function setSqlSelect($v) {
		$this->_SqlSelect = $v;
	}
	var $_SqlWhere = "";

	function getSqlWhere() { // Where
		$sWhere = ($this->_SqlWhere <> "") ? $this->_SqlWhere : "";
		$this->TableFilter = "";
		ew_AddFilter($sWhere, $this->TableFilter);
		return $sWhere;
	}

	function SqlWhere() { // For backward compatibility
		return $this->getSqlWhere();
	}

	function setSqlWhere($v) {
		$this->_SqlWhere = $v;
	}
	var $_SqlGroupBy = "";

	function getSqlGroupBy() { // Group By
		return ($this->_SqlGroupBy <> "") ? $this->_SqlGroupBy : "";
	}

	function SqlGroupBy() { // For backward compatibility
		return $this->getSqlGroupBy();
	}

	function setSqlGroupBy($v) {
		$this->_SqlGroupBy = $v;
	}
	var $_SqlHaving = "";

	function getSqlHaving() { // Having
		return ($this->_SqlHaving <> "") ? $this->_SqlHaving : "";
	}

	function SqlHaving() { // For backward compatibility
		return $this->getSqlHaving();
	}

	function setSqlHaving($v) {
		$this->_SqlHaving = $v;
	}
	var $_SqlOrderBy = "";

	function getSqlOrderBy() { // Order By
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "";
	}

	function SqlOrderBy() { // For backward compatibility
		return $this->getSqlOrderBy();
	}

	function setSqlOrderBy($v) {
		$this->_SqlOrderBy = $v;
	}

	// Apply User ID filters
	function ApplyUserIDFilters($sFilter) {
		return $sFilter;
	}

	// Check if User ID security allows view all
	function UserIDAllow($id = "") {
		$allow = EW_USER_ID_ALLOW;
		switch ($id) {
			case "add":
			case "copy":
			case "gridadd":
			case "register":
			case "addopt":
				return (($allow & 1) == 1);
			case "edit":
			case "gridedit":
			case "update":
			case "changepwd":
			case "forgotpwd":
				return (($allow & 4) == 4);
			case "delete":
				return (($allow & 2) == 2);
			case "view":
				return (($allow & 32) == 32);
			case "search":
				return (($allow & 64) == 64);
			default:
				return (($allow & 8) == 8);
		}
	}

	// Get SQL
	function GetSQL($where, $orderby) {
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$where, $orderby);
	}

	// Table SQL
	function SQL() {
		$sFilter = $this->CurrentFilter;
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$sFilter, $sSort);
	}

	// Table SQL with List page filter
	function SelectSQL() {
		$sFilter = $this->getSessionWhere();
		ew_AddFilter($sFilter, $this->CurrentFilter);
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$this->Recordset_Selecting($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(), $this->getSqlGroupBy(),
			$this->getSqlHaving(), $this->getSqlOrderBy(), $sFilter, $sSort);
	}

	// Get ORDER BY clause
	function GetOrderBy() {
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql("", "", "", "", $this->getSqlOrderBy(), "", $sSort);
	}

	// Try to get record count
	function TryGetRecordCount($sSql) {
		$cnt = -1;
		if (($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') && preg_match("/^SELECT \* FROM/i", $sSql)) {
			$sSql = "SELECT COUNT(*) FROM" . preg_replace('/^SELECT\s([\s\S]+)?\*\sFROM/i', "", $sSql);
			$sOrderBy = $this->GetOrderBy();
			if (substr($sSql, strlen($sOrderBy) * -1) == $sOrderBy)
				$sSql = substr($sSql, 0, strlen($sSql) - strlen($sOrderBy)); // Remove ORDER BY clause
		} else {
			$sSql = "SELECT COUNT(*) FROM (" . $sSql . ") EW_COUNT_TABLE";
		}
		$conn = &$this->Connection();
		if ($rs = $conn->Execute($sSql)) {
			if (!$rs->EOF && $rs->FieldCount() > 0) {
				$cnt = $rs->fields[0];
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// Get record count based on filter (for detail record count in master table pages)
	function LoadRecordCount($sFilter) {
		$origFilter = $this->CurrentFilter;
		$this->CurrentFilter = $sFilter;
		$this->Recordset_Selecting($this->CurrentFilter);

		//$sSql = $this->SQL();
		$sSql = $this->GetSQL($this->CurrentFilter, "");
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			if ($rs = $this->LoadRs($this->CurrentFilter)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		$this->CurrentFilter = $origFilter;
		return intval($cnt);
	}

	// Get record count (for current List page)
	function SelectRecordCount() {
		$sSql = $this->SelectSQL();
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			$conn = &$this->Connection();
			if ($rs = $conn->Execute($sSql)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// INSERT statement
	function InsertSQL(&$rs) {
		$names = "";
		$values = "";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$names .= $this->fields[$name]->FldExpression . ",";
			$values .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		while (substr($names, -1) == ",")
			$names = substr($names, 0, -1);
		while (substr($values, -1) == ",")
			$values = substr($values, 0, -1);
		return "INSERT INTO " . $this->UpdateTable . " ($names) VALUES ($values)";
	}

	// Insert
	function Insert(&$rs) {
		$conn = &$this->Connection();
		return $conn->Execute($this->InsertSQL($rs));
	}

	// UPDATE statement
	function UpdateSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "UPDATE " . $this->UpdateTable . " SET ";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$sql .= $this->fields[$name]->FldExpression . "=";
			$sql .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		while (substr($sql, -1) == ",")
			$sql = substr($sql, 0, -1);
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		ew_AddFilter($filter, $where);
		if ($filter <> "")	$sql .= " WHERE " . $filter;
		return $sql;
	}

	// Update
	function Update(&$rs, $where = "", $rsold = NULL, $curfilter = TRUE) {
		$conn = &$this->Connection();
		return $conn->Execute($this->UpdateSQL($rs, $where, $curfilter));
	}

	// DELETE statement
	function DeleteSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "DELETE FROM " . $this->UpdateTable . " WHERE ";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		if ($rs) {
			if (array_key_exists('Id_Rol', $rs))
				ew_AddFilter($where, ew_QuotedName('Id_Rol', $this->DBID) . '=' . ew_QuotedValue($rs['Id_Rol'], $this->Id_Rol->FldDataType, $this->DBID));
		}
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		ew_AddFilter($filter, $where);
		if ($filter <> "")
			$sql .= $filter;
		else
			$sql .= "0=1"; // Avoid delete
		return $sql;
	}

	// Delete
	function Delete(&$rs, $where = "", $curfilter = TRUE) {
		$conn = &$this->Connection();
		return $conn->Execute($this->DeleteSQL($rs, $where, $curfilter));
	}

	// Key filter WHERE clause
	function SqlKeyFilter() {
		return "`Id_Rol` = @Id_Rol@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->Id_Rol->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@Id_Rol@", ew_AdjustSql($this->Id_Rol->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
		return $sKeyFilter;
	}

	// Return page URL
	function getReturnUrl() {
		$name = EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL;

		// Get referer URL automatically
		if (ew_ServerVar("HTTP_REFERER") <> "" && ew_ReferPage() <> ew_CurrentPage() && ew_ReferPage() <> "login.php") // Referer not same page or login page
			$_SESSION[$name] = ew_ServerVar("HTTP_REFERER"); // Save to Session
		if (@$_SESSION[$name] <> "") {
			return $_SESSION[$name];
		} else {
			return "ap_roles_usuarioslist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "ap_roles_usuarioslist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("ap_roles_usuariosview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("ap_roles_usuariosview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "ap_roles_usuariosadd.php?" . $this->UrlParm($parm);
		else
			$url = "ap_roles_usuariosadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("ap_roles_usuariosedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("ap_roles_usuariosadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("ap_roles_usuariosdelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "Id_Rol:" . ew_VarToJson($this->Id_Rol->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->Id_Rol->CurrentValue)) {
			$sUrl .= "Id_Rol=" . urlencode($this->Id_Rol->CurrentValue);
		} else {
			return "javascript:ew_Alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		return $sUrl;
	}

	// Sort URL
	function SortUrl(&$fld) {
		if ($this->CurrentAction <> "" || $this->Export <> "" ||
			in_array($fld->FldType, array(128, 204, 205))) { // Unsortable data type
				return "";
		} elseif ($fld->Sortable) {
			$sUrlParm = $this->UrlParm("order=" . urlencode($fld->FldName) . "&amp;ordertype=" . $fld->ReverseSort());
			return $this->AddMasterUrl(ew_CurrentPage() . "?" . $sUrlParm);
		} else {
			return "";
		}
	}

	// Get record keys from $_POST/$_GET/$_SESSION
	function GetRecordKeys() {
		global $EW_COMPOSITE_KEY_SEPARATOR;
		$arKeys = array();
		$arKey = array();
		if (isset($_POST["key_m"])) {
			$arKeys = ew_StripSlashes($_POST["key_m"]);
			$cnt = count($arKeys);
		} elseif (isset($_GET["key_m"])) {
			$arKeys = ew_StripSlashes($_GET["key_m"]);
			$cnt = count($arKeys);
		} elseif (!empty($_GET) || !empty($_POST)) {
			$isPost = ew_IsHttpPost();
			if ($isPost && isset($_POST["Id_Rol"]))
				$arKeys[] = ew_StripSlashes($_POST["Id_Rol"]);
			elseif (isset($_GET["Id_Rol"]))
				$arKeys[] = ew_StripSlashes($_GET["Id_Rol"]);
			else
				$arKeys = NULL; // Do not setup

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		if (is_array($arKeys)) {
			foreach ($arKeys as $key) {
				if (!is_numeric($key))
					continue;
				$ar[] = $key;
			}
		}
		return $ar;
	}

	// Get key filter
	function GetKeyFilter() {
		$arKeys = $this->GetRecordKeys();
		$sKeyFilter = "";
		foreach ($arKeys as $key) {
			if ($sKeyFilter <> "") $sKeyFilter .= " OR ";
			$this->Id_Rol->CurrentValue = $key;
			$sKeyFilter .= "(" . $this->KeyFilter() . ")";
		}
		return $sKeyFilter;
	}

	// Load rows based on filter
	function &LoadRs($sFilter) {

		// Set up filter (SQL WHERE clause) and get return SQL
		//$this->CurrentFilter = $sFilter;
		//$sSql = $this->SQL();

		$sSql = $this->GetSQL($sFilter, "");
		$conn = &$this->Connection();
		$rs = $conn->Execute($sSql);
		return $rs;
	}

	// Load row values from recordset
	function LoadListRowValues(&$rs) {
		$this->Id_Rol->setDbValue($rs->fields('Id_Rol'));
		$this->grupo_Rol->setDbValue($rs->fields('grupo_Rol'));
		$this->formulario_Rol->setDbValue($rs->fields('formulario_Rol'));
		$this->abrir_Rol->setDbValue($rs->fields('abrir_Rol'));
		$this->agregar_Rol->setDbValue($rs->fields('agregar_Rol'));
		$this->editar_Rol->setDbValue($rs->fields('editar_Rol'));
		$this->eliminar_Rol->setDbValue($rs->fields('eliminar_Rol'));
		$this->mostrar_Rol->setDbValue($rs->fields('mostrar_Rol'));
		$this->alias_Rol->setDbValue($rs->fields('alias_Rol'));
		$this->empresa_Rol->setDbValue($rs->fields('empresa_Rol'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// Id_Rol
		// grupo_Rol
		// formulario_Rol
		// abrir_Rol
		// agregar_Rol
		// editar_Rol
		// eliminar_Rol
		// mostrar_Rol
		// alias_Rol
		// empresa_Rol
		// Id_Rol

		$this->Id_Rol->ViewValue = $this->Id_Rol->CurrentValue;
		$this->Id_Rol->ViewCustomAttributes = "";

		// grupo_Rol
		$this->grupo_Rol->ViewValue = $this->grupo_Rol->CurrentValue;
		$this->grupo_Rol->ViewCustomAttributes = "";

		// formulario_Rol
		$this->formulario_Rol->ViewValue = $this->formulario_Rol->CurrentValue;
		$this->formulario_Rol->ViewCustomAttributes = "";

		// abrir_Rol
		$this->abrir_Rol->ViewValue = $this->abrir_Rol->CurrentValue;
		$this->abrir_Rol->ViewCustomAttributes = "";

		// agregar_Rol
		$this->agregar_Rol->ViewValue = $this->agregar_Rol->CurrentValue;
		$this->agregar_Rol->ViewCustomAttributes = "";

		// editar_Rol
		$this->editar_Rol->ViewValue = $this->editar_Rol->CurrentValue;
		$this->editar_Rol->ViewCustomAttributes = "";

		// eliminar_Rol
		$this->eliminar_Rol->ViewValue = $this->eliminar_Rol->CurrentValue;
		$this->eliminar_Rol->ViewCustomAttributes = "";

		// mostrar_Rol
		$this->mostrar_Rol->ViewValue = $this->mostrar_Rol->CurrentValue;
		$this->mostrar_Rol->ViewCustomAttributes = "";

		// alias_Rol
		$this->alias_Rol->ViewValue = $this->alias_Rol->CurrentValue;
		$this->alias_Rol->ViewCustomAttributes = "";

		// empresa_Rol
		$this->empresa_Rol->ViewValue = $this->empresa_Rol->CurrentValue;
		$this->empresa_Rol->ViewCustomAttributes = "";

		// Id_Rol
		$this->Id_Rol->LinkCustomAttributes = "";
		$this->Id_Rol->HrefValue = "";
		$this->Id_Rol->TooltipValue = "";

		// grupo_Rol
		$this->grupo_Rol->LinkCustomAttributes = "";
		$this->grupo_Rol->HrefValue = "";
		$this->grupo_Rol->TooltipValue = "";

		// formulario_Rol
		$this->formulario_Rol->LinkCustomAttributes = "";
		$this->formulario_Rol->HrefValue = "";
		$this->formulario_Rol->TooltipValue = "";

		// abrir_Rol
		$this->abrir_Rol->LinkCustomAttributes = "";
		$this->abrir_Rol->HrefValue = "";
		$this->abrir_Rol->TooltipValue = "";

		// agregar_Rol
		$this->agregar_Rol->LinkCustomAttributes = "";
		$this->agregar_Rol->HrefValue = "";
		$this->agregar_Rol->TooltipValue = "";

		// editar_Rol
		$this->editar_Rol->LinkCustomAttributes = "";
		$this->editar_Rol->HrefValue = "";
		$this->editar_Rol->TooltipValue = "";

		// eliminar_Rol
		$this->eliminar_Rol->LinkCustomAttributes = "";
		$this->eliminar_Rol->HrefValue = "";
		$this->eliminar_Rol->TooltipValue = "";

		// mostrar_Rol
		$this->mostrar_Rol->LinkCustomAttributes = "";
		$this->mostrar_Rol->HrefValue = "";
		$this->mostrar_Rol->TooltipValue = "";

		// alias_Rol
		$this->alias_Rol->LinkCustomAttributes = "";
		$this->alias_Rol->HrefValue = "";
		$this->alias_Rol->TooltipValue = "";

		// empresa_Rol
		$this->empresa_Rol->LinkCustomAttributes = "";
		$this->empresa_Rol->HrefValue = "";
		$this->empresa_Rol->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// Id_Rol
		$this->Id_Rol->EditAttrs["class"] = "form-control";
		$this->Id_Rol->EditCustomAttributes = "";
		$this->Id_Rol->EditValue = $this->Id_Rol->CurrentValue;
		$this->Id_Rol->ViewCustomAttributes = "";

		// grupo_Rol
		$this->grupo_Rol->EditAttrs["class"] = "form-control";
		$this->grupo_Rol->EditCustomAttributes = "";
		$this->grupo_Rol->EditValue = $this->grupo_Rol->CurrentValue;
		$this->grupo_Rol->PlaceHolder = ew_RemoveHtml($this->grupo_Rol->FldCaption());

		// formulario_Rol
		$this->formulario_Rol->EditAttrs["class"] = "form-control";
		$this->formulario_Rol->EditCustomAttributes = "";
		$this->formulario_Rol->EditValue = $this->formulario_Rol->CurrentValue;
		$this->formulario_Rol->PlaceHolder = ew_RemoveHtml($this->formulario_Rol->FldCaption());

		// abrir_Rol
		$this->abrir_Rol->EditAttrs["class"] = "form-control";
		$this->abrir_Rol->EditCustomAttributes = "";
		$this->abrir_Rol->EditValue = $this->abrir_Rol->CurrentValue;
		$this->abrir_Rol->PlaceHolder = ew_RemoveHtml($this->abrir_Rol->FldCaption());

		// agregar_Rol
		$this->agregar_Rol->EditAttrs["class"] = "form-control";
		$this->agregar_Rol->EditCustomAttributes = "";
		$this->agregar_Rol->EditValue = $this->agregar_Rol->CurrentValue;
		$this->agregar_Rol->PlaceHolder = ew_RemoveHtml($this->agregar_Rol->FldCaption());

		// editar_Rol
		$this->editar_Rol->EditAttrs["class"] = "form-control";
		$this->editar_Rol->EditCustomAttributes = "";
		$this->editar_Rol->EditValue = $this->editar_Rol->CurrentValue;
		$this->editar_Rol->PlaceHolder = ew_RemoveHtml($this->editar_Rol->FldCaption());

		// eliminar_Rol
		$this->eliminar_Rol->EditAttrs["class"] = "form-control";
		$this->eliminar_Rol->EditCustomAttributes = "";
		$this->eliminar_Rol->EditValue = $this->eliminar_Rol->CurrentValue;
		$this->eliminar_Rol->PlaceHolder = ew_RemoveHtml($this->eliminar_Rol->FldCaption());

		// mostrar_Rol
		$this->mostrar_Rol->EditAttrs["class"] = "form-control";
		$this->mostrar_Rol->EditCustomAttributes = "";
		$this->mostrar_Rol->EditValue = $this->mostrar_Rol->CurrentValue;
		$this->mostrar_Rol->PlaceHolder = ew_RemoveHtml($this->mostrar_Rol->FldCaption());

		// alias_Rol
		$this->alias_Rol->EditAttrs["class"] = "form-control";
		$this->alias_Rol->EditCustomAttributes = "";
		$this->alias_Rol->EditValue = $this->alias_Rol->CurrentValue;
		$this->alias_Rol->PlaceHolder = ew_RemoveHtml($this->alias_Rol->FldCaption());

		// empresa_Rol
		$this->empresa_Rol->EditAttrs["class"] = "form-control";
		$this->empresa_Rol->EditCustomAttributes = "";
		$this->empresa_Rol->EditValue = $this->empresa_Rol->CurrentValue;
		$this->empresa_Rol->PlaceHolder = ew_RemoveHtml($this->empresa_Rol->FldCaption());

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Aggregate list row values
	function AggregateListRowValues() {
	}

	// Aggregate list row (for rendering)
	function AggregateListRow() {

		// Call Row Rendered event
		$this->Row_Rendered();
	}
	var $ExportDoc;

	// Export data in HTML/CSV/Word/Excel/Email/PDF format
	function ExportDocument(&$Doc, &$Recordset, $StartRec, $StopRec, $ExportPageType = "") {
		if (!$Recordset || !$Doc)
			return;
		if (!$Doc->ExportCustom) {

			// Write header
			$Doc->ExportTableHeader();
			if ($Doc->Horizontal) { // Horizontal format, write header
				$Doc->BeginExportRow();
				if ($ExportPageType == "view") {
					if ($this->Id_Rol->Exportable) $Doc->ExportCaption($this->Id_Rol);
					if ($this->grupo_Rol->Exportable) $Doc->ExportCaption($this->grupo_Rol);
					if ($this->formulario_Rol->Exportable) $Doc->ExportCaption($this->formulario_Rol);
					if ($this->abrir_Rol->Exportable) $Doc->ExportCaption($this->abrir_Rol);
					if ($this->agregar_Rol->Exportable) $Doc->ExportCaption($this->agregar_Rol);
					if ($this->editar_Rol->Exportable) $Doc->ExportCaption($this->editar_Rol);
					if ($this->eliminar_Rol->Exportable) $Doc->ExportCaption($this->eliminar_Rol);
					if ($this->mostrar_Rol->Exportable) $Doc->ExportCaption($this->mostrar_Rol);
					if ($this->alias_Rol->Exportable) $Doc->ExportCaption($this->alias_Rol);
					if ($this->empresa_Rol->Exportable) $Doc->ExportCaption($this->empresa_Rol);
				} else {
					if ($this->Id_Rol->Exportable) $Doc->ExportCaption($this->Id_Rol);
					if ($this->grupo_Rol->Exportable) $Doc->ExportCaption($this->grupo_Rol);
					if ($this->abrir_Rol->Exportable) $Doc->ExportCaption($this->abrir_Rol);
					if ($this->agregar_Rol->Exportable) $Doc->ExportCaption($this->agregar_Rol);
					if ($this->editar_Rol->Exportable) $Doc->ExportCaption($this->editar_Rol);
					if ($this->eliminar_Rol->Exportable) $Doc->ExportCaption($this->eliminar_Rol);
					if ($this->mostrar_Rol->Exportable) $Doc->ExportCaption($this->mostrar_Rol);
					if ($this->alias_Rol->Exportable) $Doc->ExportCaption($this->alias_Rol);
					if ($this->empresa_Rol->Exportable) $Doc->ExportCaption($this->empresa_Rol);
				}
				$Doc->EndExportRow();
			}
		}

		// Move to first record
		$RecCnt = $StartRec - 1;
		if (!$Recordset->EOF) {
			$Recordset->MoveFirst();
			if ($StartRec > 1)
				$Recordset->Move($StartRec - 1);
		}
		while (!$Recordset->EOF && $RecCnt < $StopRec) {
			$RecCnt++;
			if (intval($RecCnt) >= intval($StartRec)) {
				$RowCnt = intval($RecCnt) - intval($StartRec) + 1;

				// Page break
				if ($this->ExportPageBreakCount > 0) {
					if ($RowCnt > 1 && ($RowCnt - 1) % $this->ExportPageBreakCount == 0)
						$Doc->ExportPageBreak();
				}
				$this->LoadListRowValues($Recordset);

				// Render row
				$this->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->ResetAttrs();
				$this->RenderListRow();
				if (!$Doc->ExportCustom) {
					$Doc->BeginExportRow($RowCnt); // Allow CSS styles if enabled
					if ($ExportPageType == "view") {
						if ($this->Id_Rol->Exportable) $Doc->ExportField($this->Id_Rol);
						if ($this->grupo_Rol->Exportable) $Doc->ExportField($this->grupo_Rol);
						if ($this->formulario_Rol->Exportable) $Doc->ExportField($this->formulario_Rol);
						if ($this->abrir_Rol->Exportable) $Doc->ExportField($this->abrir_Rol);
						if ($this->agregar_Rol->Exportable) $Doc->ExportField($this->agregar_Rol);
						if ($this->editar_Rol->Exportable) $Doc->ExportField($this->editar_Rol);
						if ($this->eliminar_Rol->Exportable) $Doc->ExportField($this->eliminar_Rol);
						if ($this->mostrar_Rol->Exportable) $Doc->ExportField($this->mostrar_Rol);
						if ($this->alias_Rol->Exportable) $Doc->ExportField($this->alias_Rol);
						if ($this->empresa_Rol->Exportable) $Doc->ExportField($this->empresa_Rol);
					} else {
						if ($this->Id_Rol->Exportable) $Doc->ExportField($this->Id_Rol);
						if ($this->grupo_Rol->Exportable) $Doc->ExportField($this->grupo_Rol);
						if ($this->abrir_Rol->Exportable) $Doc->ExportField($this->abrir_Rol);
						if ($this->agregar_Rol->Exportable) $Doc->ExportField($this->agregar_Rol);
						if ($this->editar_Rol->Exportable) $Doc->ExportField($this->editar_Rol);
						if ($this->eliminar_Rol->Exportable) $Doc->ExportField($this->eliminar_Rol);
						if ($this->mostrar_Rol->Exportable) $Doc->ExportField($this->mostrar_Rol);
						if ($this->alias_Rol->Exportable) $Doc->ExportField($this->alias_Rol);
						if ($this->empresa_Rol->Exportable) $Doc->ExportField($this->empresa_Rol);
					}
					$Doc->EndExportRow();
				}
			}

			// Call Row Export server event
			if ($Doc->ExportCustom)
				$this->Row_Export($Recordset->fields);
			$Recordset->MoveNext();
		}
		if (!$Doc->ExportCustom) {
			$Doc->ExportTableFooter();
		}
	}

	// Get auto fill value
	function GetAutoFill($id, $val) {
		$rsarr = array();
		$rowcnt = 0;

		// Output
		if (is_array($rsarr) && $rowcnt > 0) {
			$fldcnt = count($rsarr[0]);
			for ($i = 0; $i < $rowcnt; $i++) {
				for ($j = 0; $j < $fldcnt; $j++) {
					$str = strval($rsarr[$i][$j]);
					$str = ew_ConvertToUtf8($str);
					if (isset($post["keepCRLF"])) {
						$str = str_replace(array("\r", "\n"), array("\\r", "\\n"), $str);
					} else {
						$str = str_replace(array("\r", "\n"), array(" ", " "), $str);
					}
					$rsarr[$i][$j] = $str;
				}
			}
			return ew_ArrayToJson($rsarr);
		} else {
			return FALSE;
		}
	}

	// Table level events
	// Recordset Selecting event
	function Recordset_Selecting(&$filter) {

		// Enter your code here	
	}

	// Recordset Selected event
	function Recordset_Selected(&$rs) {

		//echo "Recordset Selected";
	}

	// Recordset Search Validated event
	function Recordset_SearchValidated() {

		// Example:
		//$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value

	}

	// Recordset Searching event
	function Recordset_Searching(&$filter) {

		// Enter your code here	
	}

	// Row_Selecting event
	function Row_Selecting(&$filter) {

		// Enter your code here	
	}

	// Row Selected event
	function Row_Selected(&$rs) {

		//echo "Row Selected";
	}

	// Row Inserting event
	function Row_Inserting($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {

		//echo "Row Inserted"
	}

	// Row Updating event
	function Row_Updating($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Updated event
	function Row_Updated($rsold, &$rsnew) {

		//echo "Row Updated";
	}

	// Row Update Conflict event
	function Row_UpdateConflict($rsold, &$rsnew) {

		// Enter your code here
		// To ignore conflict, set return value to FALSE

		return TRUE;
	}

	// Grid Inserting event
	function Grid_Inserting() {

		// Enter your code here
		// To reject grid insert, set return value to FALSE

		return TRUE;
	}

	// Grid Inserted event
	function Grid_Inserted($rsnew) {

		//echo "Grid Inserted";
	}

	// Grid Updating event
	function Grid_Updating($rsold) {

		// Enter your code here
		// To reject grid update, set return value to FALSE

		return TRUE;
	}

	// Grid Updated event
	function Grid_Updated($rsold, $rsnew) {

		//echo "Grid Updated";
	}

	// Row Deleting event
	function Row_Deleting(&$rs) {

		// Enter your code here
		// To cancel, set return value to False

		return TRUE;
	}

	// Row Deleted event
	function Row_Deleted(&$rs) {

		//echo "Row Deleted";
	}

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}

	// Lookup Selecting event
	function Lookup_Selecting($fld, &$filter) {

		//var_dump($fld->FldName, $fld->LookupFilters, $filter); // Uncomment to view the filter
		// Enter your code here

	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here	
	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>); 

	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
