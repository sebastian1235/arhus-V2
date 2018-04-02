<?php

// Global variable for table object
$ap_estado_preventa = NULL;

//
// Table class for ap_estado_preventa
//
class cap_estado_preventa extends cTable {
	var $id_estado_preventa;
	var $nombre_estado_preventa;
	var $activo_estado_preventa;
	var $detalle_estado_preventa;
	var $empresa_estado_preventa;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'ap_estado_preventa';
		$this->TableName = 'ap_estado_preventa';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`ap_estado_preventa`";
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

		// id_estado_preventa
		$this->id_estado_preventa = new cField('ap_estado_preventa', 'ap_estado_preventa', 'x_id_estado_preventa', 'id_estado_preventa', '`id_estado_preventa`', '`id_estado_preventa`', 3, -1, FALSE, '`id_estado_preventa`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->id_estado_preventa->Sortable = TRUE; // Allow sort
		$this->id_estado_preventa->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id_estado_preventa'] = &$this->id_estado_preventa;

		// nombre_estado_preventa
		$this->nombre_estado_preventa = new cField('ap_estado_preventa', 'ap_estado_preventa', 'x_nombre_estado_preventa', 'nombre_estado_preventa', '`nombre_estado_preventa`', '`nombre_estado_preventa`', 200, -1, FALSE, '`nombre_estado_preventa`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nombre_estado_preventa->Sortable = TRUE; // Allow sort
		$this->fields['nombre_estado_preventa'] = &$this->nombre_estado_preventa;

		// activo_estado_preventa
		$this->activo_estado_preventa = new cField('ap_estado_preventa', 'ap_estado_preventa', 'x_activo_estado_preventa', 'activo_estado_preventa', '`activo_estado_preventa`', '`activo_estado_preventa`', 16, -1, FALSE, '`activo_estado_preventa`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->activo_estado_preventa->Sortable = TRUE; // Allow sort
		$this->activo_estado_preventa->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['activo_estado_preventa'] = &$this->activo_estado_preventa;

		// detalle_estado_preventa
		$this->detalle_estado_preventa = new cField('ap_estado_preventa', 'ap_estado_preventa', 'x_detalle_estado_preventa', 'detalle_estado_preventa', '`detalle_estado_preventa`', '`detalle_estado_preventa`', 200, -1, FALSE, '`detalle_estado_preventa`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->detalle_estado_preventa->Sortable = TRUE; // Allow sort
		$this->fields['detalle_estado_preventa'] = &$this->detalle_estado_preventa;

		// empresa_estado_preventa
		$this->empresa_estado_preventa = new cField('ap_estado_preventa', 'ap_estado_preventa', 'x_empresa_estado_preventa', 'empresa_estado_preventa', '`empresa_estado_preventa`', '`empresa_estado_preventa`', 3, -1, FALSE, '`empresa_estado_preventa`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->empresa_estado_preventa->Sortable = TRUE; // Allow sort
		$this->empresa_estado_preventa->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['empresa_estado_preventa'] = &$this->empresa_estado_preventa;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`ap_estado_preventa`";
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
			if (array_key_exists('id_estado_preventa', $rs))
				ew_AddFilter($where, ew_QuotedName('id_estado_preventa', $this->DBID) . '=' . ew_QuotedValue($rs['id_estado_preventa'], $this->id_estado_preventa->FldDataType, $this->DBID));
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
		return "`id_estado_preventa` = @id_estado_preventa@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->id_estado_preventa->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@id_estado_preventa@", ew_AdjustSql($this->id_estado_preventa->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "ap_estado_preventalist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "ap_estado_preventalist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("ap_estado_preventaview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("ap_estado_preventaview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "ap_estado_preventaadd.php?" . $this->UrlParm($parm);
		else
			$url = "ap_estado_preventaadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("ap_estado_preventaedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("ap_estado_preventaadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("ap_estado_preventadelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "id_estado_preventa:" . ew_VarToJson($this->id_estado_preventa->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->id_estado_preventa->CurrentValue)) {
			$sUrl .= "id_estado_preventa=" . urlencode($this->id_estado_preventa->CurrentValue);
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
			if ($isPost && isset($_POST["id_estado_preventa"]))
				$arKeys[] = ew_StripSlashes($_POST["id_estado_preventa"]);
			elseif (isset($_GET["id_estado_preventa"]))
				$arKeys[] = ew_StripSlashes($_GET["id_estado_preventa"]);
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
			$this->id_estado_preventa->CurrentValue = $key;
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
		$this->id_estado_preventa->setDbValue($rs->fields('id_estado_preventa'));
		$this->nombre_estado_preventa->setDbValue($rs->fields('nombre_estado_preventa'));
		$this->activo_estado_preventa->setDbValue($rs->fields('activo_estado_preventa'));
		$this->detalle_estado_preventa->setDbValue($rs->fields('detalle_estado_preventa'));
		$this->empresa_estado_preventa->setDbValue($rs->fields('empresa_estado_preventa'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// id_estado_preventa
		// nombre_estado_preventa
		// activo_estado_preventa
		// detalle_estado_preventa
		// empresa_estado_preventa
		// id_estado_preventa

		$this->id_estado_preventa->ViewValue = $this->id_estado_preventa->CurrentValue;
		$this->id_estado_preventa->ViewCustomAttributes = "";

		// nombre_estado_preventa
		$this->nombre_estado_preventa->ViewValue = $this->nombre_estado_preventa->CurrentValue;
		$this->nombre_estado_preventa->ViewCustomAttributes = "";

		// activo_estado_preventa
		$this->activo_estado_preventa->ViewValue = $this->activo_estado_preventa->CurrentValue;
		$this->activo_estado_preventa->ViewCustomAttributes = "";

		// detalle_estado_preventa
		$this->detalle_estado_preventa->ViewValue = $this->detalle_estado_preventa->CurrentValue;
		$this->detalle_estado_preventa->ViewCustomAttributes = "";

		// empresa_estado_preventa
		$this->empresa_estado_preventa->ViewValue = $this->empresa_estado_preventa->CurrentValue;
		$this->empresa_estado_preventa->ViewCustomAttributes = "";

		// id_estado_preventa
		$this->id_estado_preventa->LinkCustomAttributes = "";
		$this->id_estado_preventa->HrefValue = "";
		$this->id_estado_preventa->TooltipValue = "";

		// nombre_estado_preventa
		$this->nombre_estado_preventa->LinkCustomAttributes = "";
		$this->nombre_estado_preventa->HrefValue = "";
		$this->nombre_estado_preventa->TooltipValue = "";

		// activo_estado_preventa
		$this->activo_estado_preventa->LinkCustomAttributes = "";
		$this->activo_estado_preventa->HrefValue = "";
		$this->activo_estado_preventa->TooltipValue = "";

		// detalle_estado_preventa
		$this->detalle_estado_preventa->LinkCustomAttributes = "";
		$this->detalle_estado_preventa->HrefValue = "";
		$this->detalle_estado_preventa->TooltipValue = "";

		// empresa_estado_preventa
		$this->empresa_estado_preventa->LinkCustomAttributes = "";
		$this->empresa_estado_preventa->HrefValue = "";
		$this->empresa_estado_preventa->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// id_estado_preventa
		$this->id_estado_preventa->EditAttrs["class"] = "form-control";
		$this->id_estado_preventa->EditCustomAttributes = "";
		$this->id_estado_preventa->EditValue = $this->id_estado_preventa->CurrentValue;
		$this->id_estado_preventa->ViewCustomAttributes = "";

		// nombre_estado_preventa
		$this->nombre_estado_preventa->EditAttrs["class"] = "form-control";
		$this->nombre_estado_preventa->EditCustomAttributes = "";
		$this->nombre_estado_preventa->EditValue = $this->nombre_estado_preventa->CurrentValue;
		$this->nombre_estado_preventa->PlaceHolder = ew_RemoveHtml($this->nombre_estado_preventa->FldCaption());

		// activo_estado_preventa
		$this->activo_estado_preventa->EditAttrs["class"] = "form-control";
		$this->activo_estado_preventa->EditCustomAttributes = "";
		$this->activo_estado_preventa->EditValue = $this->activo_estado_preventa->CurrentValue;
		$this->activo_estado_preventa->PlaceHolder = ew_RemoveHtml($this->activo_estado_preventa->FldCaption());

		// detalle_estado_preventa
		$this->detalle_estado_preventa->EditAttrs["class"] = "form-control";
		$this->detalle_estado_preventa->EditCustomAttributes = "";
		$this->detalle_estado_preventa->EditValue = $this->detalle_estado_preventa->CurrentValue;
		$this->detalle_estado_preventa->PlaceHolder = ew_RemoveHtml($this->detalle_estado_preventa->FldCaption());

		// empresa_estado_preventa
		$this->empresa_estado_preventa->EditAttrs["class"] = "form-control";
		$this->empresa_estado_preventa->EditCustomAttributes = "";
		$this->empresa_estado_preventa->EditValue = $this->empresa_estado_preventa->CurrentValue;
		$this->empresa_estado_preventa->PlaceHolder = ew_RemoveHtml($this->empresa_estado_preventa->FldCaption());

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
					if ($this->id_estado_preventa->Exportable) $Doc->ExportCaption($this->id_estado_preventa);
					if ($this->nombre_estado_preventa->Exportable) $Doc->ExportCaption($this->nombre_estado_preventa);
					if ($this->activo_estado_preventa->Exportable) $Doc->ExportCaption($this->activo_estado_preventa);
					if ($this->detalle_estado_preventa->Exportable) $Doc->ExportCaption($this->detalle_estado_preventa);
					if ($this->empresa_estado_preventa->Exportable) $Doc->ExportCaption($this->empresa_estado_preventa);
				} else {
					if ($this->id_estado_preventa->Exportable) $Doc->ExportCaption($this->id_estado_preventa);
					if ($this->nombre_estado_preventa->Exportable) $Doc->ExportCaption($this->nombre_estado_preventa);
					if ($this->activo_estado_preventa->Exportable) $Doc->ExportCaption($this->activo_estado_preventa);
					if ($this->detalle_estado_preventa->Exportable) $Doc->ExportCaption($this->detalle_estado_preventa);
					if ($this->empresa_estado_preventa->Exportable) $Doc->ExportCaption($this->empresa_estado_preventa);
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
						if ($this->id_estado_preventa->Exportable) $Doc->ExportField($this->id_estado_preventa);
						if ($this->nombre_estado_preventa->Exportable) $Doc->ExportField($this->nombre_estado_preventa);
						if ($this->activo_estado_preventa->Exportable) $Doc->ExportField($this->activo_estado_preventa);
						if ($this->detalle_estado_preventa->Exportable) $Doc->ExportField($this->detalle_estado_preventa);
						if ($this->empresa_estado_preventa->Exportable) $Doc->ExportField($this->empresa_estado_preventa);
					} else {
						if ($this->id_estado_preventa->Exportable) $Doc->ExportField($this->id_estado_preventa);
						if ($this->nombre_estado_preventa->Exportable) $Doc->ExportField($this->nombre_estado_preventa);
						if ($this->activo_estado_preventa->Exportable) $Doc->ExportField($this->activo_estado_preventa);
						if ($this->detalle_estado_preventa->Exportable) $Doc->ExportField($this->detalle_estado_preventa);
						if ($this->empresa_estado_preventa->Exportable) $Doc->ExportField($this->empresa_estado_preventa);
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
