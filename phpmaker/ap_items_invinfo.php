<?php

// Global variable for table object
$ap_items_inv = NULL;

//
// Table class for ap_items_inv
//
class cap_items_inv extends cTable {
	var $Id_Item;
	var $codigo_item;
	var $nombre_item;
	var $und_item;
	var $precio_item;
	var $costo_item;
	var $tipo_item;
	var $marca_item;
	var $cod_marca_item;
	var $detalle_item;
	var $saldo_item;
	var $activo_item;
	var $maneja_serial_item;
	var $asignado_item;
	var $si_no_item;
	var $precio_old_item;
	var $costo_old_item;
	var $registra_item;
	var $fecha_registro_item;
	var $empresa_item;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'ap_items_inv';
		$this->TableName = 'ap_items_inv';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`ap_items_inv`";
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

		// Id_Item
		$this->Id_Item = new cField('ap_items_inv', 'ap_items_inv', 'x_Id_Item', 'Id_Item', '`Id_Item`', '`Id_Item`', 3, -1, FALSE, '`Id_Item`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->Id_Item->Sortable = TRUE; // Allow sort
		$this->Id_Item->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Item'] = &$this->Id_Item;

		// codigo_item
		$this->codigo_item = new cField('ap_items_inv', 'ap_items_inv', 'x_codigo_item', 'codigo_item', '`codigo_item`', '`codigo_item`', 200, -1, FALSE, '`codigo_item`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->codigo_item->Sortable = TRUE; // Allow sort
		$this->fields['codigo_item'] = &$this->codigo_item;

		// nombre_item
		$this->nombre_item = new cField('ap_items_inv', 'ap_items_inv', 'x_nombre_item', 'nombre_item', '`nombre_item`', '`nombre_item`', 200, -1, FALSE, '`nombre_item`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nombre_item->Sortable = TRUE; // Allow sort
		$this->fields['nombre_item'] = &$this->nombre_item;

		// und_item
		$this->und_item = new cField('ap_items_inv', 'ap_items_inv', 'x_und_item', 'und_item', '`und_item`', '`und_item`', 3, -1, FALSE, '`und_item`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->und_item->Sortable = TRUE; // Allow sort
		$this->und_item->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['und_item'] = &$this->und_item;

		// precio_item
		$this->precio_item = new cField('ap_items_inv', 'ap_items_inv', 'x_precio_item', 'precio_item', '`precio_item`', '`precio_item`', 131, -1, FALSE, '`precio_item`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->precio_item->Sortable = TRUE; // Allow sort
		$this->precio_item->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['precio_item'] = &$this->precio_item;

		// costo_item
		$this->costo_item = new cField('ap_items_inv', 'ap_items_inv', 'x_costo_item', 'costo_item', '`costo_item`', '`costo_item`', 131, -1, FALSE, '`costo_item`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->costo_item->Sortable = TRUE; // Allow sort
		$this->costo_item->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['costo_item'] = &$this->costo_item;

		// tipo_item
		$this->tipo_item = new cField('ap_items_inv', 'ap_items_inv', 'x_tipo_item', 'tipo_item', '`tipo_item`', '`tipo_item`', 3, -1, FALSE, '`tipo_item`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tipo_item->Sortable = TRUE; // Allow sort
		$this->tipo_item->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['tipo_item'] = &$this->tipo_item;

		// marca_item
		$this->marca_item = new cField('ap_items_inv', 'ap_items_inv', 'x_marca_item', 'marca_item', '`marca_item`', '`marca_item`', 200, -1, FALSE, '`marca_item`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->marca_item->Sortable = TRUE; // Allow sort
		$this->fields['marca_item'] = &$this->marca_item;

		// cod_marca_item
		$this->cod_marca_item = new cField('ap_items_inv', 'ap_items_inv', 'x_cod_marca_item', 'cod_marca_item', '`cod_marca_item`', '`cod_marca_item`', 200, -1, FALSE, '`cod_marca_item`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->cod_marca_item->Sortable = TRUE; // Allow sort
		$this->fields['cod_marca_item'] = &$this->cod_marca_item;

		// detalle_item
		$this->detalle_item = new cField('ap_items_inv', 'ap_items_inv', 'x_detalle_item', 'detalle_item', '`detalle_item`', '`detalle_item`', 200, -1, FALSE, '`detalle_item`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->detalle_item->Sortable = TRUE; // Allow sort
		$this->fields['detalle_item'] = &$this->detalle_item;

		// saldo_item
		$this->saldo_item = new cField('ap_items_inv', 'ap_items_inv', 'x_saldo_item', 'saldo_item', '`saldo_item`', '`saldo_item`', 5, -1, FALSE, '`saldo_item`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->saldo_item->Sortable = TRUE; // Allow sort
		$this->saldo_item->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['saldo_item'] = &$this->saldo_item;

		// activo_item
		$this->activo_item = new cField('ap_items_inv', 'ap_items_inv', 'x_activo_item', 'activo_item', '`activo_item`', '`activo_item`', 16, -1, FALSE, '`activo_item`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->activo_item->Sortable = TRUE; // Allow sort
		$this->activo_item->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['activo_item'] = &$this->activo_item;

		// maneja_serial_item
		$this->maneja_serial_item = new cField('ap_items_inv', 'ap_items_inv', 'x_maneja_serial_item', 'maneja_serial_item', '`maneja_serial_item`', '`maneja_serial_item`', 16, -1, FALSE, '`maneja_serial_item`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->maneja_serial_item->Sortable = TRUE; // Allow sort
		$this->maneja_serial_item->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['maneja_serial_item'] = &$this->maneja_serial_item;

		// asignado_item
		$this->asignado_item = new cField('ap_items_inv', 'ap_items_inv', 'x_asignado_item', 'asignado_item', '`asignado_item`', '`asignado_item`', 16, -1, FALSE, '`asignado_item`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->asignado_item->Sortable = TRUE; // Allow sort
		$this->asignado_item->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['asignado_item'] = &$this->asignado_item;

		// si_no_item
		$this->si_no_item = new cField('ap_items_inv', 'ap_items_inv', 'x_si_no_item', 'si_no_item', '`si_no_item`', '`si_no_item`', 16, -1, FALSE, '`si_no_item`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->si_no_item->Sortable = TRUE; // Allow sort
		$this->si_no_item->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['si_no_item'] = &$this->si_no_item;

		// precio_old_item
		$this->precio_old_item = new cField('ap_items_inv', 'ap_items_inv', 'x_precio_old_item', 'precio_old_item', '`precio_old_item`', '`precio_old_item`', 131, -1, FALSE, '`precio_old_item`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->precio_old_item->Sortable = TRUE; // Allow sort
		$this->precio_old_item->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['precio_old_item'] = &$this->precio_old_item;

		// costo_old_item
		$this->costo_old_item = new cField('ap_items_inv', 'ap_items_inv', 'x_costo_old_item', 'costo_old_item', '`costo_old_item`', '`costo_old_item`', 131, -1, FALSE, '`costo_old_item`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->costo_old_item->Sortable = TRUE; // Allow sort
		$this->costo_old_item->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['costo_old_item'] = &$this->costo_old_item;

		// registra_item
		$this->registra_item = new cField('ap_items_inv', 'ap_items_inv', 'x_registra_item', 'registra_item', '`registra_item`', '`registra_item`', 200, -1, FALSE, '`registra_item`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->registra_item->Sortable = TRUE; // Allow sort
		$this->fields['registra_item'] = &$this->registra_item;

		// fecha_registro_item
		$this->fecha_registro_item = new cField('ap_items_inv', 'ap_items_inv', 'x_fecha_registro_item', 'fecha_registro_item', '`fecha_registro_item`', 'DATE_FORMAT(`fecha_registro_item`, \'%Y/%m/%d\')', 135, 0, FALSE, '`fecha_registro_item`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fecha_registro_item->Sortable = TRUE; // Allow sort
		$this->fecha_registro_item->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['fecha_registro_item'] = &$this->fecha_registro_item;

		// empresa_item
		$this->empresa_item = new cField('ap_items_inv', 'ap_items_inv', 'x_empresa_item', 'empresa_item', '`empresa_item`', '`empresa_item`', 3, -1, FALSE, '`empresa_item`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->empresa_item->Sortable = TRUE; // Allow sort
		$this->empresa_item->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['empresa_item'] = &$this->empresa_item;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`ap_items_inv`";
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
			if (array_key_exists('Id_Item', $rs))
				ew_AddFilter($where, ew_QuotedName('Id_Item', $this->DBID) . '=' . ew_QuotedValue($rs['Id_Item'], $this->Id_Item->FldDataType, $this->DBID));
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
		return "`Id_Item` = @Id_Item@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->Id_Item->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@Id_Item@", ew_AdjustSql($this->Id_Item->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "ap_items_invlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "ap_items_invlist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("ap_items_invview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("ap_items_invview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "ap_items_invadd.php?" . $this->UrlParm($parm);
		else
			$url = "ap_items_invadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("ap_items_invedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("ap_items_invadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("ap_items_invdelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "Id_Item:" . ew_VarToJson($this->Id_Item->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->Id_Item->CurrentValue)) {
			$sUrl .= "Id_Item=" . urlencode($this->Id_Item->CurrentValue);
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
			if ($isPost && isset($_POST["Id_Item"]))
				$arKeys[] = ew_StripSlashes($_POST["Id_Item"]);
			elseif (isset($_GET["Id_Item"]))
				$arKeys[] = ew_StripSlashes($_GET["Id_Item"]);
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
			$this->Id_Item->CurrentValue = $key;
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
		$this->Id_Item->setDbValue($rs->fields('Id_Item'));
		$this->codigo_item->setDbValue($rs->fields('codigo_item'));
		$this->nombre_item->setDbValue($rs->fields('nombre_item'));
		$this->und_item->setDbValue($rs->fields('und_item'));
		$this->precio_item->setDbValue($rs->fields('precio_item'));
		$this->costo_item->setDbValue($rs->fields('costo_item'));
		$this->tipo_item->setDbValue($rs->fields('tipo_item'));
		$this->marca_item->setDbValue($rs->fields('marca_item'));
		$this->cod_marca_item->setDbValue($rs->fields('cod_marca_item'));
		$this->detalle_item->setDbValue($rs->fields('detalle_item'));
		$this->saldo_item->setDbValue($rs->fields('saldo_item'));
		$this->activo_item->setDbValue($rs->fields('activo_item'));
		$this->maneja_serial_item->setDbValue($rs->fields('maneja_serial_item'));
		$this->asignado_item->setDbValue($rs->fields('asignado_item'));
		$this->si_no_item->setDbValue($rs->fields('si_no_item'));
		$this->precio_old_item->setDbValue($rs->fields('precio_old_item'));
		$this->costo_old_item->setDbValue($rs->fields('costo_old_item'));
		$this->registra_item->setDbValue($rs->fields('registra_item'));
		$this->fecha_registro_item->setDbValue($rs->fields('fecha_registro_item'));
		$this->empresa_item->setDbValue($rs->fields('empresa_item'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// Id_Item
		// codigo_item
		// nombre_item
		// und_item
		// precio_item
		// costo_item
		// tipo_item
		// marca_item
		// cod_marca_item
		// detalle_item
		// saldo_item
		// activo_item
		// maneja_serial_item
		// asignado_item
		// si_no_item
		// precio_old_item
		// costo_old_item
		// registra_item
		// fecha_registro_item
		// empresa_item
		// Id_Item

		$this->Id_Item->ViewValue = $this->Id_Item->CurrentValue;
		$this->Id_Item->ViewCustomAttributes = "";

		// codigo_item
		$this->codigo_item->ViewValue = $this->codigo_item->CurrentValue;
		$this->codigo_item->ViewCustomAttributes = "";

		// nombre_item
		$this->nombre_item->ViewValue = $this->nombre_item->CurrentValue;
		$this->nombre_item->ViewCustomAttributes = "";

		// und_item
		$this->und_item->ViewValue = $this->und_item->CurrentValue;
		$this->und_item->ViewCustomAttributes = "";

		// precio_item
		$this->precio_item->ViewValue = $this->precio_item->CurrentValue;
		$this->precio_item->ViewCustomAttributes = "";

		// costo_item
		$this->costo_item->ViewValue = $this->costo_item->CurrentValue;
		$this->costo_item->ViewCustomAttributes = "";

		// tipo_item
		$this->tipo_item->ViewValue = $this->tipo_item->CurrentValue;
		$this->tipo_item->ViewCustomAttributes = "";

		// marca_item
		$this->marca_item->ViewValue = $this->marca_item->CurrentValue;
		$this->marca_item->ViewCustomAttributes = "";

		// cod_marca_item
		$this->cod_marca_item->ViewValue = $this->cod_marca_item->CurrentValue;
		$this->cod_marca_item->ViewCustomAttributes = "";

		// detalle_item
		$this->detalle_item->ViewValue = $this->detalle_item->CurrentValue;
		$this->detalle_item->ViewCustomAttributes = "";

		// saldo_item
		$this->saldo_item->ViewValue = $this->saldo_item->CurrentValue;
		$this->saldo_item->ViewCustomAttributes = "";

		// activo_item
		$this->activo_item->ViewValue = $this->activo_item->CurrentValue;
		$this->activo_item->ViewCustomAttributes = "";

		// maneja_serial_item
		$this->maneja_serial_item->ViewValue = $this->maneja_serial_item->CurrentValue;
		$this->maneja_serial_item->ViewCustomAttributes = "";

		// asignado_item
		$this->asignado_item->ViewValue = $this->asignado_item->CurrentValue;
		$this->asignado_item->ViewCustomAttributes = "";

		// si_no_item
		$this->si_no_item->ViewValue = $this->si_no_item->CurrentValue;
		$this->si_no_item->ViewCustomAttributes = "";

		// precio_old_item
		$this->precio_old_item->ViewValue = $this->precio_old_item->CurrentValue;
		$this->precio_old_item->ViewCustomAttributes = "";

		// costo_old_item
		$this->costo_old_item->ViewValue = $this->costo_old_item->CurrentValue;
		$this->costo_old_item->ViewCustomAttributes = "";

		// registra_item
		$this->registra_item->ViewValue = $this->registra_item->CurrentValue;
		$this->registra_item->ViewCustomAttributes = "";

		// fecha_registro_item
		$this->fecha_registro_item->ViewValue = $this->fecha_registro_item->CurrentValue;
		$this->fecha_registro_item->ViewValue = ew_FormatDateTime($this->fecha_registro_item->ViewValue, 0);
		$this->fecha_registro_item->ViewCustomAttributes = "";

		// empresa_item
		$this->empresa_item->ViewValue = $this->empresa_item->CurrentValue;
		$this->empresa_item->ViewCustomAttributes = "";

		// Id_Item
		$this->Id_Item->LinkCustomAttributes = "";
		$this->Id_Item->HrefValue = "";
		$this->Id_Item->TooltipValue = "";

		// codigo_item
		$this->codigo_item->LinkCustomAttributes = "";
		$this->codigo_item->HrefValue = "";
		$this->codigo_item->TooltipValue = "";

		// nombre_item
		$this->nombre_item->LinkCustomAttributes = "";
		$this->nombre_item->HrefValue = "";
		$this->nombre_item->TooltipValue = "";

		// und_item
		$this->und_item->LinkCustomAttributes = "";
		$this->und_item->HrefValue = "";
		$this->und_item->TooltipValue = "";

		// precio_item
		$this->precio_item->LinkCustomAttributes = "";
		$this->precio_item->HrefValue = "";
		$this->precio_item->TooltipValue = "";

		// costo_item
		$this->costo_item->LinkCustomAttributes = "";
		$this->costo_item->HrefValue = "";
		$this->costo_item->TooltipValue = "";

		// tipo_item
		$this->tipo_item->LinkCustomAttributes = "";
		$this->tipo_item->HrefValue = "";
		$this->tipo_item->TooltipValue = "";

		// marca_item
		$this->marca_item->LinkCustomAttributes = "";
		$this->marca_item->HrefValue = "";
		$this->marca_item->TooltipValue = "";

		// cod_marca_item
		$this->cod_marca_item->LinkCustomAttributes = "";
		$this->cod_marca_item->HrefValue = "";
		$this->cod_marca_item->TooltipValue = "";

		// detalle_item
		$this->detalle_item->LinkCustomAttributes = "";
		$this->detalle_item->HrefValue = "";
		$this->detalle_item->TooltipValue = "";

		// saldo_item
		$this->saldo_item->LinkCustomAttributes = "";
		$this->saldo_item->HrefValue = "";
		$this->saldo_item->TooltipValue = "";

		// activo_item
		$this->activo_item->LinkCustomAttributes = "";
		$this->activo_item->HrefValue = "";
		$this->activo_item->TooltipValue = "";

		// maneja_serial_item
		$this->maneja_serial_item->LinkCustomAttributes = "";
		$this->maneja_serial_item->HrefValue = "";
		$this->maneja_serial_item->TooltipValue = "";

		// asignado_item
		$this->asignado_item->LinkCustomAttributes = "";
		$this->asignado_item->HrefValue = "";
		$this->asignado_item->TooltipValue = "";

		// si_no_item
		$this->si_no_item->LinkCustomAttributes = "";
		$this->si_no_item->HrefValue = "";
		$this->si_no_item->TooltipValue = "";

		// precio_old_item
		$this->precio_old_item->LinkCustomAttributes = "";
		$this->precio_old_item->HrefValue = "";
		$this->precio_old_item->TooltipValue = "";

		// costo_old_item
		$this->costo_old_item->LinkCustomAttributes = "";
		$this->costo_old_item->HrefValue = "";
		$this->costo_old_item->TooltipValue = "";

		// registra_item
		$this->registra_item->LinkCustomAttributes = "";
		$this->registra_item->HrefValue = "";
		$this->registra_item->TooltipValue = "";

		// fecha_registro_item
		$this->fecha_registro_item->LinkCustomAttributes = "";
		$this->fecha_registro_item->HrefValue = "";
		$this->fecha_registro_item->TooltipValue = "";

		// empresa_item
		$this->empresa_item->LinkCustomAttributes = "";
		$this->empresa_item->HrefValue = "";
		$this->empresa_item->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// Id_Item
		$this->Id_Item->EditAttrs["class"] = "form-control";
		$this->Id_Item->EditCustomAttributes = "";
		$this->Id_Item->EditValue = $this->Id_Item->CurrentValue;
		$this->Id_Item->ViewCustomAttributes = "";

		// codigo_item
		$this->codigo_item->EditAttrs["class"] = "form-control";
		$this->codigo_item->EditCustomAttributes = "";
		$this->codigo_item->EditValue = $this->codigo_item->CurrentValue;
		$this->codigo_item->PlaceHolder = ew_RemoveHtml($this->codigo_item->FldCaption());

		// nombre_item
		$this->nombre_item->EditAttrs["class"] = "form-control";
		$this->nombre_item->EditCustomAttributes = "";
		$this->nombre_item->EditValue = $this->nombre_item->CurrentValue;
		$this->nombre_item->PlaceHolder = ew_RemoveHtml($this->nombre_item->FldCaption());

		// und_item
		$this->und_item->EditAttrs["class"] = "form-control";
		$this->und_item->EditCustomAttributes = "";
		$this->und_item->EditValue = $this->und_item->CurrentValue;
		$this->und_item->PlaceHolder = ew_RemoveHtml($this->und_item->FldCaption());

		// precio_item
		$this->precio_item->EditAttrs["class"] = "form-control";
		$this->precio_item->EditCustomAttributes = "";
		$this->precio_item->EditValue = $this->precio_item->CurrentValue;
		$this->precio_item->PlaceHolder = ew_RemoveHtml($this->precio_item->FldCaption());
		if (strval($this->precio_item->EditValue) <> "" && is_numeric($this->precio_item->EditValue)) $this->precio_item->EditValue = ew_FormatNumber($this->precio_item->EditValue, -2, -1, -2, 0);

		// costo_item
		$this->costo_item->EditAttrs["class"] = "form-control";
		$this->costo_item->EditCustomAttributes = "";
		$this->costo_item->EditValue = $this->costo_item->CurrentValue;
		$this->costo_item->PlaceHolder = ew_RemoveHtml($this->costo_item->FldCaption());
		if (strval($this->costo_item->EditValue) <> "" && is_numeric($this->costo_item->EditValue)) $this->costo_item->EditValue = ew_FormatNumber($this->costo_item->EditValue, -2, -1, -2, 0);

		// tipo_item
		$this->tipo_item->EditAttrs["class"] = "form-control";
		$this->tipo_item->EditCustomAttributes = "";
		$this->tipo_item->EditValue = $this->tipo_item->CurrentValue;
		$this->tipo_item->PlaceHolder = ew_RemoveHtml($this->tipo_item->FldCaption());

		// marca_item
		$this->marca_item->EditAttrs["class"] = "form-control";
		$this->marca_item->EditCustomAttributes = "";
		$this->marca_item->EditValue = $this->marca_item->CurrentValue;
		$this->marca_item->PlaceHolder = ew_RemoveHtml($this->marca_item->FldCaption());

		// cod_marca_item
		$this->cod_marca_item->EditAttrs["class"] = "form-control";
		$this->cod_marca_item->EditCustomAttributes = "";
		$this->cod_marca_item->EditValue = $this->cod_marca_item->CurrentValue;
		$this->cod_marca_item->PlaceHolder = ew_RemoveHtml($this->cod_marca_item->FldCaption());

		// detalle_item
		$this->detalle_item->EditAttrs["class"] = "form-control";
		$this->detalle_item->EditCustomAttributes = "";
		$this->detalle_item->EditValue = $this->detalle_item->CurrentValue;
		$this->detalle_item->PlaceHolder = ew_RemoveHtml($this->detalle_item->FldCaption());

		// saldo_item
		$this->saldo_item->EditAttrs["class"] = "form-control";
		$this->saldo_item->EditCustomAttributes = "";
		$this->saldo_item->EditValue = $this->saldo_item->CurrentValue;
		$this->saldo_item->PlaceHolder = ew_RemoveHtml($this->saldo_item->FldCaption());
		if (strval($this->saldo_item->EditValue) <> "" && is_numeric($this->saldo_item->EditValue)) $this->saldo_item->EditValue = ew_FormatNumber($this->saldo_item->EditValue, -2, -1, -2, 0);

		// activo_item
		$this->activo_item->EditAttrs["class"] = "form-control";
		$this->activo_item->EditCustomAttributes = "";
		$this->activo_item->EditValue = $this->activo_item->CurrentValue;
		$this->activo_item->PlaceHolder = ew_RemoveHtml($this->activo_item->FldCaption());

		// maneja_serial_item
		$this->maneja_serial_item->EditAttrs["class"] = "form-control";
		$this->maneja_serial_item->EditCustomAttributes = "";
		$this->maneja_serial_item->EditValue = $this->maneja_serial_item->CurrentValue;
		$this->maneja_serial_item->PlaceHolder = ew_RemoveHtml($this->maneja_serial_item->FldCaption());

		// asignado_item
		$this->asignado_item->EditAttrs["class"] = "form-control";
		$this->asignado_item->EditCustomAttributes = "";
		$this->asignado_item->EditValue = $this->asignado_item->CurrentValue;
		$this->asignado_item->PlaceHolder = ew_RemoveHtml($this->asignado_item->FldCaption());

		// si_no_item
		$this->si_no_item->EditAttrs["class"] = "form-control";
		$this->si_no_item->EditCustomAttributes = "";
		$this->si_no_item->EditValue = $this->si_no_item->CurrentValue;
		$this->si_no_item->PlaceHolder = ew_RemoveHtml($this->si_no_item->FldCaption());

		// precio_old_item
		$this->precio_old_item->EditAttrs["class"] = "form-control";
		$this->precio_old_item->EditCustomAttributes = "";
		$this->precio_old_item->EditValue = $this->precio_old_item->CurrentValue;
		$this->precio_old_item->PlaceHolder = ew_RemoveHtml($this->precio_old_item->FldCaption());
		if (strval($this->precio_old_item->EditValue) <> "" && is_numeric($this->precio_old_item->EditValue)) $this->precio_old_item->EditValue = ew_FormatNumber($this->precio_old_item->EditValue, -2, -1, -2, 0);

		// costo_old_item
		$this->costo_old_item->EditAttrs["class"] = "form-control";
		$this->costo_old_item->EditCustomAttributes = "";
		$this->costo_old_item->EditValue = $this->costo_old_item->CurrentValue;
		$this->costo_old_item->PlaceHolder = ew_RemoveHtml($this->costo_old_item->FldCaption());
		if (strval($this->costo_old_item->EditValue) <> "" && is_numeric($this->costo_old_item->EditValue)) $this->costo_old_item->EditValue = ew_FormatNumber($this->costo_old_item->EditValue, -2, -1, -2, 0);

		// registra_item
		$this->registra_item->EditAttrs["class"] = "form-control";
		$this->registra_item->EditCustomAttributes = "";
		$this->registra_item->EditValue = $this->registra_item->CurrentValue;
		$this->registra_item->PlaceHolder = ew_RemoveHtml($this->registra_item->FldCaption());

		// fecha_registro_item
		$this->fecha_registro_item->EditAttrs["class"] = "form-control";
		$this->fecha_registro_item->EditCustomAttributes = "";
		$this->fecha_registro_item->EditValue = ew_FormatDateTime($this->fecha_registro_item->CurrentValue, 8);
		$this->fecha_registro_item->PlaceHolder = ew_RemoveHtml($this->fecha_registro_item->FldCaption());

		// empresa_item
		$this->empresa_item->EditAttrs["class"] = "form-control";
		$this->empresa_item->EditCustomAttributes = "";
		$this->empresa_item->EditValue = $this->empresa_item->CurrentValue;
		$this->empresa_item->PlaceHolder = ew_RemoveHtml($this->empresa_item->FldCaption());

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
					if ($this->Id_Item->Exportable) $Doc->ExportCaption($this->Id_Item);
					if ($this->codigo_item->Exportable) $Doc->ExportCaption($this->codigo_item);
					if ($this->nombre_item->Exportable) $Doc->ExportCaption($this->nombre_item);
					if ($this->und_item->Exportable) $Doc->ExportCaption($this->und_item);
					if ($this->precio_item->Exportable) $Doc->ExportCaption($this->precio_item);
					if ($this->costo_item->Exportable) $Doc->ExportCaption($this->costo_item);
					if ($this->tipo_item->Exportable) $Doc->ExportCaption($this->tipo_item);
					if ($this->marca_item->Exportable) $Doc->ExportCaption($this->marca_item);
					if ($this->cod_marca_item->Exportable) $Doc->ExportCaption($this->cod_marca_item);
					if ($this->detalle_item->Exportable) $Doc->ExportCaption($this->detalle_item);
					if ($this->saldo_item->Exportable) $Doc->ExportCaption($this->saldo_item);
					if ($this->activo_item->Exportable) $Doc->ExportCaption($this->activo_item);
					if ($this->maneja_serial_item->Exportable) $Doc->ExportCaption($this->maneja_serial_item);
					if ($this->asignado_item->Exportable) $Doc->ExportCaption($this->asignado_item);
					if ($this->si_no_item->Exportable) $Doc->ExportCaption($this->si_no_item);
					if ($this->precio_old_item->Exportable) $Doc->ExportCaption($this->precio_old_item);
					if ($this->costo_old_item->Exportable) $Doc->ExportCaption($this->costo_old_item);
					if ($this->registra_item->Exportable) $Doc->ExportCaption($this->registra_item);
					if ($this->fecha_registro_item->Exportable) $Doc->ExportCaption($this->fecha_registro_item);
					if ($this->empresa_item->Exportable) $Doc->ExportCaption($this->empresa_item);
				} else {
					if ($this->Id_Item->Exportable) $Doc->ExportCaption($this->Id_Item);
					if ($this->codigo_item->Exportable) $Doc->ExportCaption($this->codigo_item);
					if ($this->nombre_item->Exportable) $Doc->ExportCaption($this->nombre_item);
					if ($this->und_item->Exportable) $Doc->ExportCaption($this->und_item);
					if ($this->precio_item->Exportable) $Doc->ExportCaption($this->precio_item);
					if ($this->costo_item->Exportable) $Doc->ExportCaption($this->costo_item);
					if ($this->tipo_item->Exportable) $Doc->ExportCaption($this->tipo_item);
					if ($this->marca_item->Exportable) $Doc->ExportCaption($this->marca_item);
					if ($this->cod_marca_item->Exportable) $Doc->ExportCaption($this->cod_marca_item);
					if ($this->detalle_item->Exportable) $Doc->ExportCaption($this->detalle_item);
					if ($this->saldo_item->Exportable) $Doc->ExportCaption($this->saldo_item);
					if ($this->activo_item->Exportable) $Doc->ExportCaption($this->activo_item);
					if ($this->maneja_serial_item->Exportable) $Doc->ExportCaption($this->maneja_serial_item);
					if ($this->asignado_item->Exportable) $Doc->ExportCaption($this->asignado_item);
					if ($this->si_no_item->Exportable) $Doc->ExportCaption($this->si_no_item);
					if ($this->precio_old_item->Exportable) $Doc->ExportCaption($this->precio_old_item);
					if ($this->costo_old_item->Exportable) $Doc->ExportCaption($this->costo_old_item);
					if ($this->registra_item->Exportable) $Doc->ExportCaption($this->registra_item);
					if ($this->fecha_registro_item->Exportable) $Doc->ExportCaption($this->fecha_registro_item);
					if ($this->empresa_item->Exportable) $Doc->ExportCaption($this->empresa_item);
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
						if ($this->Id_Item->Exportable) $Doc->ExportField($this->Id_Item);
						if ($this->codigo_item->Exportable) $Doc->ExportField($this->codigo_item);
						if ($this->nombre_item->Exportable) $Doc->ExportField($this->nombre_item);
						if ($this->und_item->Exportable) $Doc->ExportField($this->und_item);
						if ($this->precio_item->Exportable) $Doc->ExportField($this->precio_item);
						if ($this->costo_item->Exportable) $Doc->ExportField($this->costo_item);
						if ($this->tipo_item->Exportable) $Doc->ExportField($this->tipo_item);
						if ($this->marca_item->Exportable) $Doc->ExportField($this->marca_item);
						if ($this->cod_marca_item->Exportable) $Doc->ExportField($this->cod_marca_item);
						if ($this->detalle_item->Exportable) $Doc->ExportField($this->detalle_item);
						if ($this->saldo_item->Exportable) $Doc->ExportField($this->saldo_item);
						if ($this->activo_item->Exportable) $Doc->ExportField($this->activo_item);
						if ($this->maneja_serial_item->Exportable) $Doc->ExportField($this->maneja_serial_item);
						if ($this->asignado_item->Exportable) $Doc->ExportField($this->asignado_item);
						if ($this->si_no_item->Exportable) $Doc->ExportField($this->si_no_item);
						if ($this->precio_old_item->Exportable) $Doc->ExportField($this->precio_old_item);
						if ($this->costo_old_item->Exportable) $Doc->ExportField($this->costo_old_item);
						if ($this->registra_item->Exportable) $Doc->ExportField($this->registra_item);
						if ($this->fecha_registro_item->Exportable) $Doc->ExportField($this->fecha_registro_item);
						if ($this->empresa_item->Exportable) $Doc->ExportField($this->empresa_item);
					} else {
						if ($this->Id_Item->Exportable) $Doc->ExportField($this->Id_Item);
						if ($this->codigo_item->Exportable) $Doc->ExportField($this->codigo_item);
						if ($this->nombre_item->Exportable) $Doc->ExportField($this->nombre_item);
						if ($this->und_item->Exportable) $Doc->ExportField($this->und_item);
						if ($this->precio_item->Exportable) $Doc->ExportField($this->precio_item);
						if ($this->costo_item->Exportable) $Doc->ExportField($this->costo_item);
						if ($this->tipo_item->Exportable) $Doc->ExportField($this->tipo_item);
						if ($this->marca_item->Exportable) $Doc->ExportField($this->marca_item);
						if ($this->cod_marca_item->Exportable) $Doc->ExportField($this->cod_marca_item);
						if ($this->detalle_item->Exportable) $Doc->ExportField($this->detalle_item);
						if ($this->saldo_item->Exportable) $Doc->ExportField($this->saldo_item);
						if ($this->activo_item->Exportable) $Doc->ExportField($this->activo_item);
						if ($this->maneja_serial_item->Exportable) $Doc->ExportField($this->maneja_serial_item);
						if ($this->asignado_item->Exportable) $Doc->ExportField($this->asignado_item);
						if ($this->si_no_item->Exportable) $Doc->ExportField($this->si_no_item);
						if ($this->precio_old_item->Exportable) $Doc->ExportField($this->precio_old_item);
						if ($this->costo_old_item->Exportable) $Doc->ExportField($this->costo_old_item);
						if ($this->registra_item->Exportable) $Doc->ExportField($this->registra_item);
						if ($this->fecha_registro_item->Exportable) $Doc->ExportField($this->fecha_registro_item);
						if ($this->empresa_item->Exportable) $Doc->ExportField($this->empresa_item);
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
