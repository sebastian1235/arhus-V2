<?php

// Global variable for table object
$siax_campana = NULL;

//
// Table class for siax_campana
//
class csiax_campana extends cTable {
	var $id_campana;
	var $nombre_campana;
	var $descuente_campana;
	var $desc_financ_campana;
	var $plazo_max_campana;
	var $detalle_campana;
	var $aplicacion_campana;
	var $desde_campana;
	var $hasta_campana;
	var $vigente_campana;
	var $tasa_campana;
	var $descuento_fijo_campana;
	var $manto_max_campana;
	var $condiciones_campana;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'siax_campana';
		$this->TableName = 'siax_campana';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`siax_campana`";
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

		// id_campana
		$this->id_campana = new cField('siax_campana', 'siax_campana', 'x_id_campana', 'id_campana', '`id_campana`', '`id_campana`', 3, -1, FALSE, '`id_campana`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->id_campana->Sortable = TRUE; // Allow sort
		$this->id_campana->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id_campana'] = &$this->id_campana;

		// nombre_campana
		$this->nombre_campana = new cField('siax_campana', 'siax_campana', 'x_nombre_campana', 'nombre_campana', '`nombre_campana`', '`nombre_campana`', 200, -1, FALSE, '`nombre_campana`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nombre_campana->Sortable = TRUE; // Allow sort
		$this->fields['nombre_campana'] = &$this->nombre_campana;

		// descuente_campana
		$this->descuente_campana = new cField('siax_campana', 'siax_campana', 'x_descuente_campana', 'descuente_campana', '`descuente_campana`', '`descuente_campana`', 131, -1, FALSE, '`descuente_campana`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->descuente_campana->Sortable = TRUE; // Allow sort
		$this->descuente_campana->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['descuente_campana'] = &$this->descuente_campana;

		// desc_financ_campana
		$this->desc_financ_campana = new cField('siax_campana', 'siax_campana', 'x_desc_financ_campana', 'desc_financ_campana', '`desc_financ_campana`', '`desc_financ_campana`', 131, -1, FALSE, '`desc_financ_campana`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->desc_financ_campana->Sortable = TRUE; // Allow sort
		$this->desc_financ_campana->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['desc_financ_campana'] = &$this->desc_financ_campana;

		// plazo_max_campana
		$this->plazo_max_campana = new cField('siax_campana', 'siax_campana', 'x_plazo_max_campana', 'plazo_max_campana', '`plazo_max_campana`', '`plazo_max_campana`', 3, -1, FALSE, '`plazo_max_campana`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->plazo_max_campana->Sortable = TRUE; // Allow sort
		$this->plazo_max_campana->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['plazo_max_campana'] = &$this->plazo_max_campana;

		// detalle_campana
		$this->detalle_campana = new cField('siax_campana', 'siax_campana', 'x_detalle_campana', 'detalle_campana', '`detalle_campana`', '`detalle_campana`', 201, -1, FALSE, '`detalle_campana`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->detalle_campana->Sortable = TRUE; // Allow sort
		$this->fields['detalle_campana'] = &$this->detalle_campana;

		// aplicacion_campana
		$this->aplicacion_campana = new cField('siax_campana', 'siax_campana', 'x_aplicacion_campana', 'aplicacion_campana', '`aplicacion_campana`', '`aplicacion_campana`', 201, -1, FALSE, '`aplicacion_campana`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->aplicacion_campana->Sortable = TRUE; // Allow sort
		$this->fields['aplicacion_campana'] = &$this->aplicacion_campana;

		// desde_campana
		$this->desde_campana = new cField('siax_campana', 'siax_campana', 'x_desde_campana', 'desde_campana', '`desde_campana`', 'DATE_FORMAT(`desde_campana`, \'%Y/%m/%d\')', 135, 0, FALSE, '`desde_campana`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->desde_campana->Sortable = TRUE; // Allow sort
		$this->desde_campana->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['desde_campana'] = &$this->desde_campana;

		// hasta_campana
		$this->hasta_campana = new cField('siax_campana', 'siax_campana', 'x_hasta_campana', 'hasta_campana', '`hasta_campana`', 'DATE_FORMAT(`hasta_campana`, \'%Y/%m/%d\')', 135, 0, FALSE, '`hasta_campana`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->hasta_campana->Sortable = TRUE; // Allow sort
		$this->hasta_campana->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['hasta_campana'] = &$this->hasta_campana;

		// vigente_campana
		$this->vigente_campana = new cField('siax_campana', 'siax_campana', 'x_vigente_campana', 'vigente_campana', '`vigente_campana`', '`vigente_campana`', 16, -1, FALSE, '`vigente_campana`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->vigente_campana->Sortable = TRUE; // Allow sort
		$this->vigente_campana->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['vigente_campana'] = &$this->vigente_campana;

		// tasa_campana
		$this->tasa_campana = new cField('siax_campana', 'siax_campana', 'x_tasa_campana', 'tasa_campana', '`tasa_campana`', '`tasa_campana`', 131, -1, FALSE, '`tasa_campana`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tasa_campana->Sortable = TRUE; // Allow sort
		$this->tasa_campana->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['tasa_campana'] = &$this->tasa_campana;

		// descuento_fijo_campana
		$this->descuento_fijo_campana = new cField('siax_campana', 'siax_campana', 'x_descuento_fijo_campana', 'descuento_fijo_campana', '`descuento_fijo_campana`', '`descuento_fijo_campana`', 131, -1, FALSE, '`descuento_fijo_campana`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->descuento_fijo_campana->Sortable = TRUE; // Allow sort
		$this->descuento_fijo_campana->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['descuento_fijo_campana'] = &$this->descuento_fijo_campana;

		// manto_max_campana
		$this->manto_max_campana = new cField('siax_campana', 'siax_campana', 'x_manto_max_campana', 'manto_max_campana', '`manto_max_campana`', '`manto_max_campana`', 131, -1, FALSE, '`manto_max_campana`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->manto_max_campana->Sortable = TRUE; // Allow sort
		$this->manto_max_campana->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['manto_max_campana'] = &$this->manto_max_campana;

		// condiciones_campana
		$this->condiciones_campana = new cField('siax_campana', 'siax_campana', 'x_condiciones_campana', 'condiciones_campana', '`condiciones_campana`', '`condiciones_campana`', 201, -1, FALSE, '`condiciones_campana`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->condiciones_campana->Sortable = TRUE; // Allow sort
		$this->fields['condiciones_campana'] = &$this->condiciones_campana;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`siax_campana`";
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
			if (array_key_exists('id_campana', $rs))
				ew_AddFilter($where, ew_QuotedName('id_campana', $this->DBID) . '=' . ew_QuotedValue($rs['id_campana'], $this->id_campana->FldDataType, $this->DBID));
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
		return "`id_campana` = @id_campana@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->id_campana->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@id_campana@", ew_AdjustSql($this->id_campana->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "siax_campanalist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "siax_campanalist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("siax_campanaview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("siax_campanaview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "siax_campanaadd.php?" . $this->UrlParm($parm);
		else
			$url = "siax_campanaadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("siax_campanaedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("siax_campanaadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("siax_campanadelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "id_campana:" . ew_VarToJson($this->id_campana->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->id_campana->CurrentValue)) {
			$sUrl .= "id_campana=" . urlencode($this->id_campana->CurrentValue);
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
			if ($isPost && isset($_POST["id_campana"]))
				$arKeys[] = ew_StripSlashes($_POST["id_campana"]);
			elseif (isset($_GET["id_campana"]))
				$arKeys[] = ew_StripSlashes($_GET["id_campana"]);
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
			$this->id_campana->CurrentValue = $key;
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
		$this->id_campana->setDbValue($rs->fields('id_campana'));
		$this->nombre_campana->setDbValue($rs->fields('nombre_campana'));
		$this->descuente_campana->setDbValue($rs->fields('descuente_campana'));
		$this->desc_financ_campana->setDbValue($rs->fields('desc_financ_campana'));
		$this->plazo_max_campana->setDbValue($rs->fields('plazo_max_campana'));
		$this->detalle_campana->setDbValue($rs->fields('detalle_campana'));
		$this->aplicacion_campana->setDbValue($rs->fields('aplicacion_campana'));
		$this->desde_campana->setDbValue($rs->fields('desde_campana'));
		$this->hasta_campana->setDbValue($rs->fields('hasta_campana'));
		$this->vigente_campana->setDbValue($rs->fields('vigente_campana'));
		$this->tasa_campana->setDbValue($rs->fields('tasa_campana'));
		$this->descuento_fijo_campana->setDbValue($rs->fields('descuento_fijo_campana'));
		$this->manto_max_campana->setDbValue($rs->fields('manto_max_campana'));
		$this->condiciones_campana->setDbValue($rs->fields('condiciones_campana'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// id_campana
		// nombre_campana
		// descuente_campana
		// desc_financ_campana
		// plazo_max_campana
		// detalle_campana
		// aplicacion_campana
		// desde_campana
		// hasta_campana
		// vigente_campana
		// tasa_campana
		// descuento_fijo_campana
		// manto_max_campana
		// condiciones_campana
		// id_campana

		$this->id_campana->ViewValue = $this->id_campana->CurrentValue;
		$this->id_campana->ViewCustomAttributes = "";

		// nombre_campana
		$this->nombre_campana->ViewValue = $this->nombre_campana->CurrentValue;
		$this->nombre_campana->ViewCustomAttributes = "";

		// descuente_campana
		$this->descuente_campana->ViewValue = $this->descuente_campana->CurrentValue;
		$this->descuente_campana->ViewCustomAttributes = "";

		// desc_financ_campana
		$this->desc_financ_campana->ViewValue = $this->desc_financ_campana->CurrentValue;
		$this->desc_financ_campana->ViewCustomAttributes = "";

		// plazo_max_campana
		$this->plazo_max_campana->ViewValue = $this->plazo_max_campana->CurrentValue;
		$this->plazo_max_campana->ViewCustomAttributes = "";

		// detalle_campana
		$this->detalle_campana->ViewValue = $this->detalle_campana->CurrentValue;
		$this->detalle_campana->ViewCustomAttributes = "";

		// aplicacion_campana
		$this->aplicacion_campana->ViewValue = $this->aplicacion_campana->CurrentValue;
		$this->aplicacion_campana->ViewCustomAttributes = "";

		// desde_campana
		$this->desde_campana->ViewValue = $this->desde_campana->CurrentValue;
		$this->desde_campana->ViewValue = ew_FormatDateTime($this->desde_campana->ViewValue, 0);
		$this->desde_campana->ViewCustomAttributes = "";

		// hasta_campana
		$this->hasta_campana->ViewValue = $this->hasta_campana->CurrentValue;
		$this->hasta_campana->ViewValue = ew_FormatDateTime($this->hasta_campana->ViewValue, 0);
		$this->hasta_campana->ViewCustomAttributes = "";

		// vigente_campana
		$this->vigente_campana->ViewValue = $this->vigente_campana->CurrentValue;
		$this->vigente_campana->ViewCustomAttributes = "";

		// tasa_campana
		$this->tasa_campana->ViewValue = $this->tasa_campana->CurrentValue;
		$this->tasa_campana->ViewCustomAttributes = "";

		// descuento_fijo_campana
		$this->descuento_fijo_campana->ViewValue = $this->descuento_fijo_campana->CurrentValue;
		$this->descuento_fijo_campana->ViewCustomAttributes = "";

		// manto_max_campana
		$this->manto_max_campana->ViewValue = $this->manto_max_campana->CurrentValue;
		$this->manto_max_campana->ViewCustomAttributes = "";

		// condiciones_campana
		$this->condiciones_campana->ViewValue = $this->condiciones_campana->CurrentValue;
		$this->condiciones_campana->ViewCustomAttributes = "";

		// id_campana
		$this->id_campana->LinkCustomAttributes = "";
		$this->id_campana->HrefValue = "";
		$this->id_campana->TooltipValue = "";

		// nombre_campana
		$this->nombre_campana->LinkCustomAttributes = "";
		$this->nombre_campana->HrefValue = "";
		$this->nombre_campana->TooltipValue = "";

		// descuente_campana
		$this->descuente_campana->LinkCustomAttributes = "";
		$this->descuente_campana->HrefValue = "";
		$this->descuente_campana->TooltipValue = "";

		// desc_financ_campana
		$this->desc_financ_campana->LinkCustomAttributes = "";
		$this->desc_financ_campana->HrefValue = "";
		$this->desc_financ_campana->TooltipValue = "";

		// plazo_max_campana
		$this->plazo_max_campana->LinkCustomAttributes = "";
		$this->plazo_max_campana->HrefValue = "";
		$this->plazo_max_campana->TooltipValue = "";

		// detalle_campana
		$this->detalle_campana->LinkCustomAttributes = "";
		$this->detalle_campana->HrefValue = "";
		$this->detalle_campana->TooltipValue = "";

		// aplicacion_campana
		$this->aplicacion_campana->LinkCustomAttributes = "";
		$this->aplicacion_campana->HrefValue = "";
		$this->aplicacion_campana->TooltipValue = "";

		// desde_campana
		$this->desde_campana->LinkCustomAttributes = "";
		$this->desde_campana->HrefValue = "";
		$this->desde_campana->TooltipValue = "";

		// hasta_campana
		$this->hasta_campana->LinkCustomAttributes = "";
		$this->hasta_campana->HrefValue = "";
		$this->hasta_campana->TooltipValue = "";

		// vigente_campana
		$this->vigente_campana->LinkCustomAttributes = "";
		$this->vigente_campana->HrefValue = "";
		$this->vigente_campana->TooltipValue = "";

		// tasa_campana
		$this->tasa_campana->LinkCustomAttributes = "";
		$this->tasa_campana->HrefValue = "";
		$this->tasa_campana->TooltipValue = "";

		// descuento_fijo_campana
		$this->descuento_fijo_campana->LinkCustomAttributes = "";
		$this->descuento_fijo_campana->HrefValue = "";
		$this->descuento_fijo_campana->TooltipValue = "";

		// manto_max_campana
		$this->manto_max_campana->LinkCustomAttributes = "";
		$this->manto_max_campana->HrefValue = "";
		$this->manto_max_campana->TooltipValue = "";

		// condiciones_campana
		$this->condiciones_campana->LinkCustomAttributes = "";
		$this->condiciones_campana->HrefValue = "";
		$this->condiciones_campana->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// id_campana
		$this->id_campana->EditAttrs["class"] = "form-control";
		$this->id_campana->EditCustomAttributes = "";
		$this->id_campana->EditValue = $this->id_campana->CurrentValue;
		$this->id_campana->ViewCustomAttributes = "";

		// nombre_campana
		$this->nombre_campana->EditAttrs["class"] = "form-control";
		$this->nombre_campana->EditCustomAttributes = "";
		$this->nombre_campana->EditValue = $this->nombre_campana->CurrentValue;
		$this->nombre_campana->PlaceHolder = ew_RemoveHtml($this->nombre_campana->FldCaption());

		// descuente_campana
		$this->descuente_campana->EditAttrs["class"] = "form-control";
		$this->descuente_campana->EditCustomAttributes = "";
		$this->descuente_campana->EditValue = $this->descuente_campana->CurrentValue;
		$this->descuente_campana->PlaceHolder = ew_RemoveHtml($this->descuente_campana->FldCaption());
		if (strval($this->descuente_campana->EditValue) <> "" && is_numeric($this->descuente_campana->EditValue)) $this->descuente_campana->EditValue = ew_FormatNumber($this->descuente_campana->EditValue, -2, -1, -2, 0);

		// desc_financ_campana
		$this->desc_financ_campana->EditAttrs["class"] = "form-control";
		$this->desc_financ_campana->EditCustomAttributes = "";
		$this->desc_financ_campana->EditValue = $this->desc_financ_campana->CurrentValue;
		$this->desc_financ_campana->PlaceHolder = ew_RemoveHtml($this->desc_financ_campana->FldCaption());
		if (strval($this->desc_financ_campana->EditValue) <> "" && is_numeric($this->desc_financ_campana->EditValue)) $this->desc_financ_campana->EditValue = ew_FormatNumber($this->desc_financ_campana->EditValue, -2, -1, -2, 0);

		// plazo_max_campana
		$this->plazo_max_campana->EditAttrs["class"] = "form-control";
		$this->plazo_max_campana->EditCustomAttributes = "";
		$this->plazo_max_campana->EditValue = $this->plazo_max_campana->CurrentValue;
		$this->plazo_max_campana->PlaceHolder = ew_RemoveHtml($this->plazo_max_campana->FldCaption());

		// detalle_campana
		$this->detalle_campana->EditAttrs["class"] = "form-control";
		$this->detalle_campana->EditCustomAttributes = "";
		$this->detalle_campana->EditValue = $this->detalle_campana->CurrentValue;
		$this->detalle_campana->PlaceHolder = ew_RemoveHtml($this->detalle_campana->FldCaption());

		// aplicacion_campana
		$this->aplicacion_campana->EditAttrs["class"] = "form-control";
		$this->aplicacion_campana->EditCustomAttributes = "";
		$this->aplicacion_campana->EditValue = $this->aplicacion_campana->CurrentValue;
		$this->aplicacion_campana->PlaceHolder = ew_RemoveHtml($this->aplicacion_campana->FldCaption());

		// desde_campana
		$this->desde_campana->EditAttrs["class"] = "form-control";
		$this->desde_campana->EditCustomAttributes = "";
		$this->desde_campana->EditValue = ew_FormatDateTime($this->desde_campana->CurrentValue, 8);
		$this->desde_campana->PlaceHolder = ew_RemoveHtml($this->desde_campana->FldCaption());

		// hasta_campana
		$this->hasta_campana->EditAttrs["class"] = "form-control";
		$this->hasta_campana->EditCustomAttributes = "";
		$this->hasta_campana->EditValue = ew_FormatDateTime($this->hasta_campana->CurrentValue, 8);
		$this->hasta_campana->PlaceHolder = ew_RemoveHtml($this->hasta_campana->FldCaption());

		// vigente_campana
		$this->vigente_campana->EditAttrs["class"] = "form-control";
		$this->vigente_campana->EditCustomAttributes = "";
		$this->vigente_campana->EditValue = $this->vigente_campana->CurrentValue;
		$this->vigente_campana->PlaceHolder = ew_RemoveHtml($this->vigente_campana->FldCaption());

		// tasa_campana
		$this->tasa_campana->EditAttrs["class"] = "form-control";
		$this->tasa_campana->EditCustomAttributes = "";
		$this->tasa_campana->EditValue = $this->tasa_campana->CurrentValue;
		$this->tasa_campana->PlaceHolder = ew_RemoveHtml($this->tasa_campana->FldCaption());
		if (strval($this->tasa_campana->EditValue) <> "" && is_numeric($this->tasa_campana->EditValue)) $this->tasa_campana->EditValue = ew_FormatNumber($this->tasa_campana->EditValue, -2, -1, -2, 0);

		// descuento_fijo_campana
		$this->descuento_fijo_campana->EditAttrs["class"] = "form-control";
		$this->descuento_fijo_campana->EditCustomAttributes = "";
		$this->descuento_fijo_campana->EditValue = $this->descuento_fijo_campana->CurrentValue;
		$this->descuento_fijo_campana->PlaceHolder = ew_RemoveHtml($this->descuento_fijo_campana->FldCaption());
		if (strval($this->descuento_fijo_campana->EditValue) <> "" && is_numeric($this->descuento_fijo_campana->EditValue)) $this->descuento_fijo_campana->EditValue = ew_FormatNumber($this->descuento_fijo_campana->EditValue, -2, -1, -2, 0);

		// manto_max_campana
		$this->manto_max_campana->EditAttrs["class"] = "form-control";
		$this->manto_max_campana->EditCustomAttributes = "";
		$this->manto_max_campana->EditValue = $this->manto_max_campana->CurrentValue;
		$this->manto_max_campana->PlaceHolder = ew_RemoveHtml($this->manto_max_campana->FldCaption());
		if (strval($this->manto_max_campana->EditValue) <> "" && is_numeric($this->manto_max_campana->EditValue)) $this->manto_max_campana->EditValue = ew_FormatNumber($this->manto_max_campana->EditValue, -2, -1, -2, 0);

		// condiciones_campana
		$this->condiciones_campana->EditAttrs["class"] = "form-control";
		$this->condiciones_campana->EditCustomAttributes = "";
		$this->condiciones_campana->EditValue = $this->condiciones_campana->CurrentValue;
		$this->condiciones_campana->PlaceHolder = ew_RemoveHtml($this->condiciones_campana->FldCaption());

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
					if ($this->id_campana->Exportable) $Doc->ExportCaption($this->id_campana);
					if ($this->nombre_campana->Exportable) $Doc->ExportCaption($this->nombre_campana);
					if ($this->descuente_campana->Exportable) $Doc->ExportCaption($this->descuente_campana);
					if ($this->desc_financ_campana->Exportable) $Doc->ExportCaption($this->desc_financ_campana);
					if ($this->plazo_max_campana->Exportable) $Doc->ExportCaption($this->plazo_max_campana);
					if ($this->detalle_campana->Exportable) $Doc->ExportCaption($this->detalle_campana);
					if ($this->aplicacion_campana->Exportable) $Doc->ExportCaption($this->aplicacion_campana);
					if ($this->desde_campana->Exportable) $Doc->ExportCaption($this->desde_campana);
					if ($this->hasta_campana->Exportable) $Doc->ExportCaption($this->hasta_campana);
					if ($this->vigente_campana->Exportable) $Doc->ExportCaption($this->vigente_campana);
					if ($this->tasa_campana->Exportable) $Doc->ExportCaption($this->tasa_campana);
					if ($this->descuento_fijo_campana->Exportable) $Doc->ExportCaption($this->descuento_fijo_campana);
					if ($this->manto_max_campana->Exportable) $Doc->ExportCaption($this->manto_max_campana);
					if ($this->condiciones_campana->Exportable) $Doc->ExportCaption($this->condiciones_campana);
				} else {
					if ($this->id_campana->Exportable) $Doc->ExportCaption($this->id_campana);
					if ($this->nombre_campana->Exportable) $Doc->ExportCaption($this->nombre_campana);
					if ($this->descuente_campana->Exportable) $Doc->ExportCaption($this->descuente_campana);
					if ($this->desc_financ_campana->Exportable) $Doc->ExportCaption($this->desc_financ_campana);
					if ($this->plazo_max_campana->Exportable) $Doc->ExportCaption($this->plazo_max_campana);
					if ($this->desde_campana->Exportable) $Doc->ExportCaption($this->desde_campana);
					if ($this->hasta_campana->Exportable) $Doc->ExportCaption($this->hasta_campana);
					if ($this->vigente_campana->Exportable) $Doc->ExportCaption($this->vigente_campana);
					if ($this->tasa_campana->Exportable) $Doc->ExportCaption($this->tasa_campana);
					if ($this->descuento_fijo_campana->Exportable) $Doc->ExportCaption($this->descuento_fijo_campana);
					if ($this->manto_max_campana->Exportable) $Doc->ExportCaption($this->manto_max_campana);
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
						if ($this->id_campana->Exportable) $Doc->ExportField($this->id_campana);
						if ($this->nombre_campana->Exportable) $Doc->ExportField($this->nombre_campana);
						if ($this->descuente_campana->Exportable) $Doc->ExportField($this->descuente_campana);
						if ($this->desc_financ_campana->Exportable) $Doc->ExportField($this->desc_financ_campana);
						if ($this->plazo_max_campana->Exportable) $Doc->ExportField($this->plazo_max_campana);
						if ($this->detalle_campana->Exportable) $Doc->ExportField($this->detalle_campana);
						if ($this->aplicacion_campana->Exportable) $Doc->ExportField($this->aplicacion_campana);
						if ($this->desde_campana->Exportable) $Doc->ExportField($this->desde_campana);
						if ($this->hasta_campana->Exportable) $Doc->ExportField($this->hasta_campana);
						if ($this->vigente_campana->Exportable) $Doc->ExportField($this->vigente_campana);
						if ($this->tasa_campana->Exportable) $Doc->ExportField($this->tasa_campana);
						if ($this->descuento_fijo_campana->Exportable) $Doc->ExportField($this->descuento_fijo_campana);
						if ($this->manto_max_campana->Exportable) $Doc->ExportField($this->manto_max_campana);
						if ($this->condiciones_campana->Exportable) $Doc->ExportField($this->condiciones_campana);
					} else {
						if ($this->id_campana->Exportable) $Doc->ExportField($this->id_campana);
						if ($this->nombre_campana->Exportable) $Doc->ExportField($this->nombre_campana);
						if ($this->descuente_campana->Exportable) $Doc->ExportField($this->descuente_campana);
						if ($this->desc_financ_campana->Exportable) $Doc->ExportField($this->desc_financ_campana);
						if ($this->plazo_max_campana->Exportable) $Doc->ExportField($this->plazo_max_campana);
						if ($this->desde_campana->Exportable) $Doc->ExportField($this->desde_campana);
						if ($this->hasta_campana->Exportable) $Doc->ExportField($this->hasta_campana);
						if ($this->vigente_campana->Exportable) $Doc->ExportField($this->vigente_campana);
						if ($this->tasa_campana->Exportable) $Doc->ExportField($this->tasa_campana);
						if ($this->descuento_fijo_campana->Exportable) $Doc->ExportField($this->descuento_fijo_campana);
						if ($this->manto_max_campana->Exportable) $Doc->ExportField($this->manto_max_campana);
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
