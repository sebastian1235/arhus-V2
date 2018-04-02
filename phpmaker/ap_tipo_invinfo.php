<?php

// Global variable for table object
$ap_tipo_inv = NULL;

//
// Table class for ap_tipo_inv
//
class cap_tipo_inv extends cTable {
	var $id_tipo_inv;
	var $nombre_tipo_inv;
	var $venta_tipo_inv;
	var $activo_tipo_inv;
	var $global_tipo_inv;
	var $grupo_tipo_inv;
	var $empresa_tipo_inv;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'ap_tipo_inv';
		$this->TableName = 'ap_tipo_inv';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`ap_tipo_inv`";
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

		// id_tipo_inv
		$this->id_tipo_inv = new cField('ap_tipo_inv', 'ap_tipo_inv', 'x_id_tipo_inv', 'id_tipo_inv', '`id_tipo_inv`', '`id_tipo_inv`', 3, -1, FALSE, '`id_tipo_inv`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->id_tipo_inv->Sortable = TRUE; // Allow sort
		$this->id_tipo_inv->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id_tipo_inv'] = &$this->id_tipo_inv;

		// nombre_tipo_inv
		$this->nombre_tipo_inv = new cField('ap_tipo_inv', 'ap_tipo_inv', 'x_nombre_tipo_inv', 'nombre_tipo_inv', '`nombre_tipo_inv`', '`nombre_tipo_inv`', 200, -1, FALSE, '`nombre_tipo_inv`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nombre_tipo_inv->Sortable = TRUE; // Allow sort
		$this->fields['nombre_tipo_inv'] = &$this->nombre_tipo_inv;

		// venta_tipo_inv
		$this->venta_tipo_inv = new cField('ap_tipo_inv', 'ap_tipo_inv', 'x_venta_tipo_inv', 'venta_tipo_inv', '`venta_tipo_inv`', '`venta_tipo_inv`', 16, -1, FALSE, '`venta_tipo_inv`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->venta_tipo_inv->Sortable = TRUE; // Allow sort
		$this->venta_tipo_inv->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['venta_tipo_inv'] = &$this->venta_tipo_inv;

		// activo_tipo_inv
		$this->activo_tipo_inv = new cField('ap_tipo_inv', 'ap_tipo_inv', 'x_activo_tipo_inv', 'activo_tipo_inv', '`activo_tipo_inv`', '`activo_tipo_inv`', 16, -1, FALSE, '`activo_tipo_inv`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->activo_tipo_inv->Sortable = TRUE; // Allow sort
		$this->activo_tipo_inv->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['activo_tipo_inv'] = &$this->activo_tipo_inv;

		// global_tipo_inv
		$this->global_tipo_inv = new cField('ap_tipo_inv', 'ap_tipo_inv', 'x_global_tipo_inv', 'global_tipo_inv', '`global_tipo_inv`', '`global_tipo_inv`', 3, -1, FALSE, '`global_tipo_inv`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->global_tipo_inv->Sortable = TRUE; // Allow sort
		$this->global_tipo_inv->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['global_tipo_inv'] = &$this->global_tipo_inv;

		// grupo_tipo_inv
		$this->grupo_tipo_inv = new cField('ap_tipo_inv', 'ap_tipo_inv', 'x_grupo_tipo_inv', 'grupo_tipo_inv', '`grupo_tipo_inv`', '`grupo_tipo_inv`', 200, -1, FALSE, '`grupo_tipo_inv`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->grupo_tipo_inv->Sortable = TRUE; // Allow sort
		$this->fields['grupo_tipo_inv'] = &$this->grupo_tipo_inv;

		// empresa_tipo_inv
		$this->empresa_tipo_inv = new cField('ap_tipo_inv', 'ap_tipo_inv', 'x_empresa_tipo_inv', 'empresa_tipo_inv', '`empresa_tipo_inv`', '`empresa_tipo_inv`', 3, -1, FALSE, '`empresa_tipo_inv`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->empresa_tipo_inv->Sortable = TRUE; // Allow sort
		$this->empresa_tipo_inv->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['empresa_tipo_inv'] = &$this->empresa_tipo_inv;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`ap_tipo_inv`";
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
			if (array_key_exists('id_tipo_inv', $rs))
				ew_AddFilter($where, ew_QuotedName('id_tipo_inv', $this->DBID) . '=' . ew_QuotedValue($rs['id_tipo_inv'], $this->id_tipo_inv->FldDataType, $this->DBID));
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
		return "`id_tipo_inv` = @id_tipo_inv@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->id_tipo_inv->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@id_tipo_inv@", ew_AdjustSql($this->id_tipo_inv->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "ap_tipo_invlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "ap_tipo_invlist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("ap_tipo_invview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("ap_tipo_invview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "ap_tipo_invadd.php?" . $this->UrlParm($parm);
		else
			$url = "ap_tipo_invadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("ap_tipo_invedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("ap_tipo_invadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("ap_tipo_invdelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "id_tipo_inv:" . ew_VarToJson($this->id_tipo_inv->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->id_tipo_inv->CurrentValue)) {
			$sUrl .= "id_tipo_inv=" . urlencode($this->id_tipo_inv->CurrentValue);
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
			if ($isPost && isset($_POST["id_tipo_inv"]))
				$arKeys[] = ew_StripSlashes($_POST["id_tipo_inv"]);
			elseif (isset($_GET["id_tipo_inv"]))
				$arKeys[] = ew_StripSlashes($_GET["id_tipo_inv"]);
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
			$this->id_tipo_inv->CurrentValue = $key;
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
		$this->id_tipo_inv->setDbValue($rs->fields('id_tipo_inv'));
		$this->nombre_tipo_inv->setDbValue($rs->fields('nombre_tipo_inv'));
		$this->venta_tipo_inv->setDbValue($rs->fields('venta_tipo_inv'));
		$this->activo_tipo_inv->setDbValue($rs->fields('activo_tipo_inv'));
		$this->global_tipo_inv->setDbValue($rs->fields('global_tipo_inv'));
		$this->grupo_tipo_inv->setDbValue($rs->fields('grupo_tipo_inv'));
		$this->empresa_tipo_inv->setDbValue($rs->fields('empresa_tipo_inv'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// id_tipo_inv
		// nombre_tipo_inv
		// venta_tipo_inv
		// activo_tipo_inv
		// global_tipo_inv
		// grupo_tipo_inv
		// empresa_tipo_inv
		// id_tipo_inv

		$this->id_tipo_inv->ViewValue = $this->id_tipo_inv->CurrentValue;
		$this->id_tipo_inv->ViewCustomAttributes = "";

		// nombre_tipo_inv
		$this->nombre_tipo_inv->ViewValue = $this->nombre_tipo_inv->CurrentValue;
		$this->nombre_tipo_inv->ViewCustomAttributes = "";

		// venta_tipo_inv
		$this->venta_tipo_inv->ViewValue = $this->venta_tipo_inv->CurrentValue;
		$this->venta_tipo_inv->ViewCustomAttributes = "";

		// activo_tipo_inv
		$this->activo_tipo_inv->ViewValue = $this->activo_tipo_inv->CurrentValue;
		$this->activo_tipo_inv->ViewCustomAttributes = "";

		// global_tipo_inv
		$this->global_tipo_inv->ViewValue = $this->global_tipo_inv->CurrentValue;
		$this->global_tipo_inv->ViewCustomAttributes = "";

		// grupo_tipo_inv
		$this->grupo_tipo_inv->ViewValue = $this->grupo_tipo_inv->CurrentValue;
		$this->grupo_tipo_inv->ViewCustomAttributes = "";

		// empresa_tipo_inv
		$this->empresa_tipo_inv->ViewValue = $this->empresa_tipo_inv->CurrentValue;
		$this->empresa_tipo_inv->ViewCustomAttributes = "";

		// id_tipo_inv
		$this->id_tipo_inv->LinkCustomAttributes = "";
		$this->id_tipo_inv->HrefValue = "";
		$this->id_tipo_inv->TooltipValue = "";

		// nombre_tipo_inv
		$this->nombre_tipo_inv->LinkCustomAttributes = "";
		$this->nombre_tipo_inv->HrefValue = "";
		$this->nombre_tipo_inv->TooltipValue = "";

		// venta_tipo_inv
		$this->venta_tipo_inv->LinkCustomAttributes = "";
		$this->venta_tipo_inv->HrefValue = "";
		$this->venta_tipo_inv->TooltipValue = "";

		// activo_tipo_inv
		$this->activo_tipo_inv->LinkCustomAttributes = "";
		$this->activo_tipo_inv->HrefValue = "";
		$this->activo_tipo_inv->TooltipValue = "";

		// global_tipo_inv
		$this->global_tipo_inv->LinkCustomAttributes = "";
		$this->global_tipo_inv->HrefValue = "";
		$this->global_tipo_inv->TooltipValue = "";

		// grupo_tipo_inv
		$this->grupo_tipo_inv->LinkCustomAttributes = "";
		$this->grupo_tipo_inv->HrefValue = "";
		$this->grupo_tipo_inv->TooltipValue = "";

		// empresa_tipo_inv
		$this->empresa_tipo_inv->LinkCustomAttributes = "";
		$this->empresa_tipo_inv->HrefValue = "";
		$this->empresa_tipo_inv->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// id_tipo_inv
		$this->id_tipo_inv->EditAttrs["class"] = "form-control";
		$this->id_tipo_inv->EditCustomAttributes = "";
		$this->id_tipo_inv->EditValue = $this->id_tipo_inv->CurrentValue;
		$this->id_tipo_inv->ViewCustomAttributes = "";

		// nombre_tipo_inv
		$this->nombre_tipo_inv->EditAttrs["class"] = "form-control";
		$this->nombre_tipo_inv->EditCustomAttributes = "";
		$this->nombre_tipo_inv->EditValue = $this->nombre_tipo_inv->CurrentValue;
		$this->nombre_tipo_inv->PlaceHolder = ew_RemoveHtml($this->nombre_tipo_inv->FldCaption());

		// venta_tipo_inv
		$this->venta_tipo_inv->EditAttrs["class"] = "form-control";
		$this->venta_tipo_inv->EditCustomAttributes = "";
		$this->venta_tipo_inv->EditValue = $this->venta_tipo_inv->CurrentValue;
		$this->venta_tipo_inv->PlaceHolder = ew_RemoveHtml($this->venta_tipo_inv->FldCaption());

		// activo_tipo_inv
		$this->activo_tipo_inv->EditAttrs["class"] = "form-control";
		$this->activo_tipo_inv->EditCustomAttributes = "";
		$this->activo_tipo_inv->EditValue = $this->activo_tipo_inv->CurrentValue;
		$this->activo_tipo_inv->PlaceHolder = ew_RemoveHtml($this->activo_tipo_inv->FldCaption());

		// global_tipo_inv
		$this->global_tipo_inv->EditAttrs["class"] = "form-control";
		$this->global_tipo_inv->EditCustomAttributes = "";
		$this->global_tipo_inv->EditValue = $this->global_tipo_inv->CurrentValue;
		$this->global_tipo_inv->PlaceHolder = ew_RemoveHtml($this->global_tipo_inv->FldCaption());

		// grupo_tipo_inv
		$this->grupo_tipo_inv->EditAttrs["class"] = "form-control";
		$this->grupo_tipo_inv->EditCustomAttributes = "";
		$this->grupo_tipo_inv->EditValue = $this->grupo_tipo_inv->CurrentValue;
		$this->grupo_tipo_inv->PlaceHolder = ew_RemoveHtml($this->grupo_tipo_inv->FldCaption());

		// empresa_tipo_inv
		$this->empresa_tipo_inv->EditAttrs["class"] = "form-control";
		$this->empresa_tipo_inv->EditCustomAttributes = "";
		$this->empresa_tipo_inv->EditValue = $this->empresa_tipo_inv->CurrentValue;
		$this->empresa_tipo_inv->PlaceHolder = ew_RemoveHtml($this->empresa_tipo_inv->FldCaption());

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
					if ($this->id_tipo_inv->Exportable) $Doc->ExportCaption($this->id_tipo_inv);
					if ($this->nombre_tipo_inv->Exportable) $Doc->ExportCaption($this->nombre_tipo_inv);
					if ($this->venta_tipo_inv->Exportable) $Doc->ExportCaption($this->venta_tipo_inv);
					if ($this->activo_tipo_inv->Exportable) $Doc->ExportCaption($this->activo_tipo_inv);
					if ($this->global_tipo_inv->Exportable) $Doc->ExportCaption($this->global_tipo_inv);
					if ($this->grupo_tipo_inv->Exportable) $Doc->ExportCaption($this->grupo_tipo_inv);
					if ($this->empresa_tipo_inv->Exportable) $Doc->ExportCaption($this->empresa_tipo_inv);
				} else {
					if ($this->id_tipo_inv->Exportable) $Doc->ExportCaption($this->id_tipo_inv);
					if ($this->nombre_tipo_inv->Exportable) $Doc->ExportCaption($this->nombre_tipo_inv);
					if ($this->venta_tipo_inv->Exportable) $Doc->ExportCaption($this->venta_tipo_inv);
					if ($this->activo_tipo_inv->Exportable) $Doc->ExportCaption($this->activo_tipo_inv);
					if ($this->global_tipo_inv->Exportable) $Doc->ExportCaption($this->global_tipo_inv);
					if ($this->grupo_tipo_inv->Exportable) $Doc->ExportCaption($this->grupo_tipo_inv);
					if ($this->empresa_tipo_inv->Exportable) $Doc->ExportCaption($this->empresa_tipo_inv);
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
						if ($this->id_tipo_inv->Exportable) $Doc->ExportField($this->id_tipo_inv);
						if ($this->nombre_tipo_inv->Exportable) $Doc->ExportField($this->nombre_tipo_inv);
						if ($this->venta_tipo_inv->Exportable) $Doc->ExportField($this->venta_tipo_inv);
						if ($this->activo_tipo_inv->Exportable) $Doc->ExportField($this->activo_tipo_inv);
						if ($this->global_tipo_inv->Exportable) $Doc->ExportField($this->global_tipo_inv);
						if ($this->grupo_tipo_inv->Exportable) $Doc->ExportField($this->grupo_tipo_inv);
						if ($this->empresa_tipo_inv->Exportable) $Doc->ExportField($this->empresa_tipo_inv);
					} else {
						if ($this->id_tipo_inv->Exportable) $Doc->ExportField($this->id_tipo_inv);
						if ($this->nombre_tipo_inv->Exportable) $Doc->ExportField($this->nombre_tipo_inv);
						if ($this->venta_tipo_inv->Exportable) $Doc->ExportField($this->venta_tipo_inv);
						if ($this->activo_tipo_inv->Exportable) $Doc->ExportField($this->activo_tipo_inv);
						if ($this->global_tipo_inv->Exportable) $Doc->ExportField($this->global_tipo_inv);
						if ($this->grupo_tipo_inv->Exportable) $Doc->ExportField($this->grupo_tipo_inv);
						if ($this->empresa_tipo_inv->Exportable) $Doc->ExportField($this->empresa_tipo_inv);
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
