<?php

// Global variable for table object
$ap_terceros = NULL;

//
// Table class for ap_terceros
//
class cap_terceros extends cTable {
	var $Id_tercero;
	var $nombre_tercero;
	var $direccion_tercero;
	var $telefono1_tercero;
	var $telefono2_tercero;
	var $fax_tercero;
	var $nit_tercero;
	var $tipo_tercero;
	var $e_mail_tercero;
	var $Contacto_tercero;
	var $gran_contrib_tercero;
	var $autoretenedor_tercero;
	var $activo_tercero;
	var $tercero__registrado_por;
	var $reg_comun_tercero;
	var $responsable_materiales_tercero;
	var $grupo_nomina_tercero;
	var $tercero__lider_Obra;
	var $tercero_nombre_lider;
	var $empresa_tercero;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'ap_terceros';
		$this->TableName = 'ap_terceros';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`ap_terceros`";
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

		// Id_tercero
		$this->Id_tercero = new cField('ap_terceros', 'ap_terceros', 'x_Id_tercero', 'Id_tercero', '`Id_tercero`', '`Id_tercero`', 3, -1, FALSE, '`Id_tercero`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->Id_tercero->Sortable = TRUE; // Allow sort
		$this->Id_tercero->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_tercero'] = &$this->Id_tercero;

		// nombre_tercero
		$this->nombre_tercero = new cField('ap_terceros', 'ap_terceros', 'x_nombre_tercero', 'nombre_tercero', '`nombre_tercero`', '`nombre_tercero`', 200, -1, FALSE, '`nombre_tercero`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nombre_tercero->Sortable = TRUE; // Allow sort
		$this->fields['nombre_tercero'] = &$this->nombre_tercero;

		// direccion_tercero
		$this->direccion_tercero = new cField('ap_terceros', 'ap_terceros', 'x_direccion_tercero', 'direccion_tercero', '`direccion_tercero`', '`direccion_tercero`', 200, -1, FALSE, '`direccion_tercero`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->direccion_tercero->Sortable = TRUE; // Allow sort
		$this->fields['direccion_tercero'] = &$this->direccion_tercero;

		// telefono1_tercero
		$this->telefono1_tercero = new cField('ap_terceros', 'ap_terceros', 'x_telefono1_tercero', 'telefono1_tercero', '`telefono1_tercero`', '`telefono1_tercero`', 200, -1, FALSE, '`telefono1_tercero`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->telefono1_tercero->Sortable = TRUE; // Allow sort
		$this->fields['telefono1_tercero'] = &$this->telefono1_tercero;

		// telefono2_tercero
		$this->telefono2_tercero = new cField('ap_terceros', 'ap_terceros', 'x_telefono2_tercero', 'telefono2_tercero', '`telefono2_tercero`', '`telefono2_tercero`', 200, -1, FALSE, '`telefono2_tercero`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->telefono2_tercero->Sortable = TRUE; // Allow sort
		$this->fields['telefono2_tercero'] = &$this->telefono2_tercero;

		// fax_tercero
		$this->fax_tercero = new cField('ap_terceros', 'ap_terceros', 'x_fax_tercero', 'fax_tercero', '`fax_tercero`', '`fax_tercero`', 200, -1, FALSE, '`fax_tercero`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fax_tercero->Sortable = TRUE; // Allow sort
		$this->fields['fax_tercero'] = &$this->fax_tercero;

		// nit_tercero
		$this->nit_tercero = new cField('ap_terceros', 'ap_terceros', 'x_nit_tercero', 'nit_tercero', '`nit_tercero`', '`nit_tercero`', 200, -1, FALSE, '`nit_tercero`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nit_tercero->Sortable = TRUE; // Allow sort
		$this->fields['nit_tercero'] = &$this->nit_tercero;

		// tipo_tercero
		$this->tipo_tercero = new cField('ap_terceros', 'ap_terceros', 'x_tipo_tercero', 'tipo_tercero', '`tipo_tercero`', '`tipo_tercero`', 3, -1, FALSE, '`tipo_tercero`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tipo_tercero->Sortable = TRUE; // Allow sort
		$this->tipo_tercero->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['tipo_tercero'] = &$this->tipo_tercero;

		// e_mail_tercero
		$this->e_mail_tercero = new cField('ap_terceros', 'ap_terceros', 'x_e_mail_tercero', 'e_mail_tercero', '`e_mail_tercero`', '`e_mail_tercero`', 200, -1, FALSE, '`e_mail_tercero`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->e_mail_tercero->Sortable = TRUE; // Allow sort
		$this->fields['e_mail_tercero'] = &$this->e_mail_tercero;

		// Contacto_tercero
		$this->Contacto_tercero = new cField('ap_terceros', 'ap_terceros', 'x_Contacto_tercero', 'Contacto_tercero', '`Contacto_tercero`', '`Contacto_tercero`', 200, -1, FALSE, '`Contacto_tercero`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Contacto_tercero->Sortable = TRUE; // Allow sort
		$this->fields['Contacto_tercero'] = &$this->Contacto_tercero;

		// gran_contrib_tercero
		$this->gran_contrib_tercero = new cField('ap_terceros', 'ap_terceros', 'x_gran_contrib_tercero', 'gran_contrib_tercero', '`gran_contrib_tercero`', '`gran_contrib_tercero`', 16, -1, FALSE, '`gran_contrib_tercero`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->gran_contrib_tercero->Sortable = TRUE; // Allow sort
		$this->gran_contrib_tercero->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['gran_contrib_tercero'] = &$this->gran_contrib_tercero;

		// autoretenedor_tercero
		$this->autoretenedor_tercero = new cField('ap_terceros', 'ap_terceros', 'x_autoretenedor_tercero', 'autoretenedor_tercero', '`autoretenedor_tercero`', '`autoretenedor_tercero`', 16, -1, FALSE, '`autoretenedor_tercero`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->autoretenedor_tercero->Sortable = TRUE; // Allow sort
		$this->autoretenedor_tercero->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['autoretenedor_tercero'] = &$this->autoretenedor_tercero;

		// activo_tercero
		$this->activo_tercero = new cField('ap_terceros', 'ap_terceros', 'x_activo_tercero', 'activo_tercero', '`activo_tercero`', '`activo_tercero`', 16, -1, FALSE, '`activo_tercero`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->activo_tercero->Sortable = TRUE; // Allow sort
		$this->activo_tercero->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['activo_tercero'] = &$this->activo_tercero;

		// tercero_ registrado_por
		$this->tercero__registrado_por = new cField('ap_terceros', 'ap_terceros', 'x_tercero__registrado_por', 'tercero_ registrado_por', '`tercero_ registrado_por`', '`tercero_ registrado_por`', 200, -1, FALSE, '`tercero_ registrado_por`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tercero__registrado_por->Sortable = TRUE; // Allow sort
		$this->fields['tercero_ registrado_por'] = &$this->tercero__registrado_por;

		// reg_comun_tercero
		$this->reg_comun_tercero = new cField('ap_terceros', 'ap_terceros', 'x_reg_comun_tercero', 'reg_comun_tercero', '`reg_comun_tercero`', '`reg_comun_tercero`', 16, -1, FALSE, '`reg_comun_tercero`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->reg_comun_tercero->Sortable = TRUE; // Allow sort
		$this->reg_comun_tercero->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['reg_comun_tercero'] = &$this->reg_comun_tercero;

		// responsable_materiales_tercero
		$this->responsable_materiales_tercero = new cField('ap_terceros', 'ap_terceros', 'x_responsable_materiales_tercero', 'responsable_materiales_tercero', '`responsable_materiales_tercero`', '`responsable_materiales_tercero`', 16, -1, FALSE, '`responsable_materiales_tercero`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->responsable_materiales_tercero->Sortable = TRUE; // Allow sort
		$this->responsable_materiales_tercero->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['responsable_materiales_tercero'] = &$this->responsable_materiales_tercero;

		// grupo_nomina_tercero
		$this->grupo_nomina_tercero = new cField('ap_terceros', 'ap_terceros', 'x_grupo_nomina_tercero', 'grupo_nomina_tercero', '`grupo_nomina_tercero`', '`grupo_nomina_tercero`', 3, -1, FALSE, '`grupo_nomina_tercero`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->grupo_nomina_tercero->Sortable = TRUE; // Allow sort
		$this->grupo_nomina_tercero->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['grupo_nomina_tercero'] = &$this->grupo_nomina_tercero;

		// tercero_ lider_Obra
		$this->tercero__lider_Obra = new cField('ap_terceros', 'ap_terceros', 'x_tercero__lider_Obra', 'tercero_ lider_Obra', '`tercero_ lider_Obra`', '`tercero_ lider_Obra`', 3, -1, FALSE, '`tercero_ lider_Obra`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tercero__lider_Obra->Sortable = TRUE; // Allow sort
		$this->tercero__lider_Obra->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['tercero_ lider_Obra'] = &$this->tercero__lider_Obra;

		// tercero_nombre_lider
		$this->tercero_nombre_lider = new cField('ap_terceros', 'ap_terceros', 'x_tercero_nombre_lider', 'tercero_nombre_lider', '`tercero_nombre_lider`', '`tercero_nombre_lider`', 200, -1, FALSE, '`tercero_nombre_lider`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tercero_nombre_lider->Sortable = TRUE; // Allow sort
		$this->fields['tercero_nombre_lider'] = &$this->tercero_nombre_lider;

		// empresa_tercero
		$this->empresa_tercero = new cField('ap_terceros', 'ap_terceros', 'x_empresa_tercero', 'empresa_tercero', '`empresa_tercero`', '`empresa_tercero`', 3, -1, FALSE, '`empresa_tercero`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->empresa_tercero->Sortable = TRUE; // Allow sort
		$this->empresa_tercero->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['empresa_tercero'] = &$this->empresa_tercero;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`ap_terceros`";
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
			if (array_key_exists('Id_tercero', $rs))
				ew_AddFilter($where, ew_QuotedName('Id_tercero', $this->DBID) . '=' . ew_QuotedValue($rs['Id_tercero'], $this->Id_tercero->FldDataType, $this->DBID));
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
		return "`Id_tercero` = @Id_tercero@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->Id_tercero->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@Id_tercero@", ew_AdjustSql($this->Id_tercero->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "ap_terceroslist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "ap_terceroslist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("ap_tercerosview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("ap_tercerosview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "ap_tercerosadd.php?" . $this->UrlParm($parm);
		else
			$url = "ap_tercerosadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("ap_tercerosedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("ap_tercerosadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("ap_tercerosdelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "Id_tercero:" . ew_VarToJson($this->Id_tercero->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->Id_tercero->CurrentValue)) {
			$sUrl .= "Id_tercero=" . urlencode($this->Id_tercero->CurrentValue);
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
			if ($isPost && isset($_POST["Id_tercero"]))
				$arKeys[] = ew_StripSlashes($_POST["Id_tercero"]);
			elseif (isset($_GET["Id_tercero"]))
				$arKeys[] = ew_StripSlashes($_GET["Id_tercero"]);
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
			$this->Id_tercero->CurrentValue = $key;
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
		$this->Id_tercero->setDbValue($rs->fields('Id_tercero'));
		$this->nombre_tercero->setDbValue($rs->fields('nombre_tercero'));
		$this->direccion_tercero->setDbValue($rs->fields('direccion_tercero'));
		$this->telefono1_tercero->setDbValue($rs->fields('telefono1_tercero'));
		$this->telefono2_tercero->setDbValue($rs->fields('telefono2_tercero'));
		$this->fax_tercero->setDbValue($rs->fields('fax_tercero'));
		$this->nit_tercero->setDbValue($rs->fields('nit_tercero'));
		$this->tipo_tercero->setDbValue($rs->fields('tipo_tercero'));
		$this->e_mail_tercero->setDbValue($rs->fields('e_mail_tercero'));
		$this->Contacto_tercero->setDbValue($rs->fields('Contacto_tercero'));
		$this->gran_contrib_tercero->setDbValue($rs->fields('gran_contrib_tercero'));
		$this->autoretenedor_tercero->setDbValue($rs->fields('autoretenedor_tercero'));
		$this->activo_tercero->setDbValue($rs->fields('activo_tercero'));
		$this->tercero__registrado_por->setDbValue($rs->fields('tercero_ registrado_por'));
		$this->reg_comun_tercero->setDbValue($rs->fields('reg_comun_tercero'));
		$this->responsable_materiales_tercero->setDbValue($rs->fields('responsable_materiales_tercero'));
		$this->grupo_nomina_tercero->setDbValue($rs->fields('grupo_nomina_tercero'));
		$this->tercero__lider_Obra->setDbValue($rs->fields('tercero_ lider_Obra'));
		$this->tercero_nombre_lider->setDbValue($rs->fields('tercero_nombre_lider'));
		$this->empresa_tercero->setDbValue($rs->fields('empresa_tercero'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// Id_tercero
		// nombre_tercero
		// direccion_tercero
		// telefono1_tercero
		// telefono2_tercero
		// fax_tercero
		// nit_tercero
		// tipo_tercero
		// e_mail_tercero
		// Contacto_tercero
		// gran_contrib_tercero
		// autoretenedor_tercero
		// activo_tercero
		// tercero_ registrado_por
		// reg_comun_tercero
		// responsable_materiales_tercero
		// grupo_nomina_tercero
		// tercero_ lider_Obra
		// tercero_nombre_lider
		// empresa_tercero
		// Id_tercero

		$this->Id_tercero->ViewValue = $this->Id_tercero->CurrentValue;
		$this->Id_tercero->ViewCustomAttributes = "";

		// nombre_tercero
		$this->nombre_tercero->ViewValue = $this->nombre_tercero->CurrentValue;
		$this->nombre_tercero->ViewCustomAttributes = "";

		// direccion_tercero
		$this->direccion_tercero->ViewValue = $this->direccion_tercero->CurrentValue;
		$this->direccion_tercero->ViewCustomAttributes = "";

		// telefono1_tercero
		$this->telefono1_tercero->ViewValue = $this->telefono1_tercero->CurrentValue;
		$this->telefono1_tercero->ViewCustomAttributes = "";

		// telefono2_tercero
		$this->telefono2_tercero->ViewValue = $this->telefono2_tercero->CurrentValue;
		$this->telefono2_tercero->ViewCustomAttributes = "";

		// fax_tercero
		$this->fax_tercero->ViewValue = $this->fax_tercero->CurrentValue;
		$this->fax_tercero->ViewCustomAttributes = "";

		// nit_tercero
		$this->nit_tercero->ViewValue = $this->nit_tercero->CurrentValue;
		$this->nit_tercero->ViewCustomAttributes = "";

		// tipo_tercero
		$this->tipo_tercero->ViewValue = $this->tipo_tercero->CurrentValue;
		$this->tipo_tercero->ViewCustomAttributes = "";

		// e_mail_tercero
		$this->e_mail_tercero->ViewValue = $this->e_mail_tercero->CurrentValue;
		$this->e_mail_tercero->ViewCustomAttributes = "";

		// Contacto_tercero
		$this->Contacto_tercero->ViewValue = $this->Contacto_tercero->CurrentValue;
		$this->Contacto_tercero->ViewCustomAttributes = "";

		// gran_contrib_tercero
		$this->gran_contrib_tercero->ViewValue = $this->gran_contrib_tercero->CurrentValue;
		$this->gran_contrib_tercero->ViewCustomAttributes = "";

		// autoretenedor_tercero
		$this->autoretenedor_tercero->ViewValue = $this->autoretenedor_tercero->CurrentValue;
		$this->autoretenedor_tercero->ViewCustomAttributes = "";

		// activo_tercero
		$this->activo_tercero->ViewValue = $this->activo_tercero->CurrentValue;
		$this->activo_tercero->ViewCustomAttributes = "";

		// tercero_ registrado_por
		$this->tercero__registrado_por->ViewValue = $this->tercero__registrado_por->CurrentValue;
		$this->tercero__registrado_por->ViewCustomAttributes = "";

		// reg_comun_tercero
		$this->reg_comun_tercero->ViewValue = $this->reg_comun_tercero->CurrentValue;
		$this->reg_comun_tercero->ViewCustomAttributes = "";

		// responsable_materiales_tercero
		$this->responsable_materiales_tercero->ViewValue = $this->responsable_materiales_tercero->CurrentValue;
		$this->responsable_materiales_tercero->ViewCustomAttributes = "";

		// grupo_nomina_tercero
		$this->grupo_nomina_tercero->ViewValue = $this->grupo_nomina_tercero->CurrentValue;
		$this->grupo_nomina_tercero->ViewCustomAttributes = "";

		// tercero_ lider_Obra
		$this->tercero__lider_Obra->ViewValue = $this->tercero__lider_Obra->CurrentValue;
		$this->tercero__lider_Obra->ViewCustomAttributes = "";

		// tercero_nombre_lider
		$this->tercero_nombre_lider->ViewValue = $this->tercero_nombre_lider->CurrentValue;
		$this->tercero_nombre_lider->ViewCustomAttributes = "";

		// empresa_tercero
		$this->empresa_tercero->ViewValue = $this->empresa_tercero->CurrentValue;
		$this->empresa_tercero->ViewCustomAttributes = "";

		// Id_tercero
		$this->Id_tercero->LinkCustomAttributes = "";
		$this->Id_tercero->HrefValue = "";
		$this->Id_tercero->TooltipValue = "";

		// nombre_tercero
		$this->nombre_tercero->LinkCustomAttributes = "";
		$this->nombre_tercero->HrefValue = "";
		$this->nombre_tercero->TooltipValue = "";

		// direccion_tercero
		$this->direccion_tercero->LinkCustomAttributes = "";
		$this->direccion_tercero->HrefValue = "";
		$this->direccion_tercero->TooltipValue = "";

		// telefono1_tercero
		$this->telefono1_tercero->LinkCustomAttributes = "";
		$this->telefono1_tercero->HrefValue = "";
		$this->telefono1_tercero->TooltipValue = "";

		// telefono2_tercero
		$this->telefono2_tercero->LinkCustomAttributes = "";
		$this->telefono2_tercero->HrefValue = "";
		$this->telefono2_tercero->TooltipValue = "";

		// fax_tercero
		$this->fax_tercero->LinkCustomAttributes = "";
		$this->fax_tercero->HrefValue = "";
		$this->fax_tercero->TooltipValue = "";

		// nit_tercero
		$this->nit_tercero->LinkCustomAttributes = "";
		$this->nit_tercero->HrefValue = "";
		$this->nit_tercero->TooltipValue = "";

		// tipo_tercero
		$this->tipo_tercero->LinkCustomAttributes = "";
		$this->tipo_tercero->HrefValue = "";
		$this->tipo_tercero->TooltipValue = "";

		// e_mail_tercero
		$this->e_mail_tercero->LinkCustomAttributes = "";
		$this->e_mail_tercero->HrefValue = "";
		$this->e_mail_tercero->TooltipValue = "";

		// Contacto_tercero
		$this->Contacto_tercero->LinkCustomAttributes = "";
		$this->Contacto_tercero->HrefValue = "";
		$this->Contacto_tercero->TooltipValue = "";

		// gran_contrib_tercero
		$this->gran_contrib_tercero->LinkCustomAttributes = "";
		$this->gran_contrib_tercero->HrefValue = "";
		$this->gran_contrib_tercero->TooltipValue = "";

		// autoretenedor_tercero
		$this->autoretenedor_tercero->LinkCustomAttributes = "";
		$this->autoretenedor_tercero->HrefValue = "";
		$this->autoretenedor_tercero->TooltipValue = "";

		// activo_tercero
		$this->activo_tercero->LinkCustomAttributes = "";
		$this->activo_tercero->HrefValue = "";
		$this->activo_tercero->TooltipValue = "";

		// tercero_ registrado_por
		$this->tercero__registrado_por->LinkCustomAttributes = "";
		$this->tercero__registrado_por->HrefValue = "";
		$this->tercero__registrado_por->TooltipValue = "";

		// reg_comun_tercero
		$this->reg_comun_tercero->LinkCustomAttributes = "";
		$this->reg_comun_tercero->HrefValue = "";
		$this->reg_comun_tercero->TooltipValue = "";

		// responsable_materiales_tercero
		$this->responsable_materiales_tercero->LinkCustomAttributes = "";
		$this->responsable_materiales_tercero->HrefValue = "";
		$this->responsable_materiales_tercero->TooltipValue = "";

		// grupo_nomina_tercero
		$this->grupo_nomina_tercero->LinkCustomAttributes = "";
		$this->grupo_nomina_tercero->HrefValue = "";
		$this->grupo_nomina_tercero->TooltipValue = "";

		// tercero_ lider_Obra
		$this->tercero__lider_Obra->LinkCustomAttributes = "";
		$this->tercero__lider_Obra->HrefValue = "";
		$this->tercero__lider_Obra->TooltipValue = "";

		// tercero_nombre_lider
		$this->tercero_nombre_lider->LinkCustomAttributes = "";
		$this->tercero_nombre_lider->HrefValue = "";
		$this->tercero_nombre_lider->TooltipValue = "";

		// empresa_tercero
		$this->empresa_tercero->LinkCustomAttributes = "";
		$this->empresa_tercero->HrefValue = "";
		$this->empresa_tercero->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// Id_tercero
		$this->Id_tercero->EditAttrs["class"] = "form-control";
		$this->Id_tercero->EditCustomAttributes = "";
		$this->Id_tercero->EditValue = $this->Id_tercero->CurrentValue;
		$this->Id_tercero->ViewCustomAttributes = "";

		// nombre_tercero
		$this->nombre_tercero->EditAttrs["class"] = "form-control";
		$this->nombre_tercero->EditCustomAttributes = "";
		$this->nombre_tercero->EditValue = $this->nombre_tercero->CurrentValue;
		$this->nombre_tercero->PlaceHolder = ew_RemoveHtml($this->nombre_tercero->FldCaption());

		// direccion_tercero
		$this->direccion_tercero->EditAttrs["class"] = "form-control";
		$this->direccion_tercero->EditCustomAttributes = "";
		$this->direccion_tercero->EditValue = $this->direccion_tercero->CurrentValue;
		$this->direccion_tercero->PlaceHolder = ew_RemoveHtml($this->direccion_tercero->FldCaption());

		// telefono1_tercero
		$this->telefono1_tercero->EditAttrs["class"] = "form-control";
		$this->telefono1_tercero->EditCustomAttributes = "";
		$this->telefono1_tercero->EditValue = $this->telefono1_tercero->CurrentValue;
		$this->telefono1_tercero->PlaceHolder = ew_RemoveHtml($this->telefono1_tercero->FldCaption());

		// telefono2_tercero
		$this->telefono2_tercero->EditAttrs["class"] = "form-control";
		$this->telefono2_tercero->EditCustomAttributes = "";
		$this->telefono2_tercero->EditValue = $this->telefono2_tercero->CurrentValue;
		$this->telefono2_tercero->PlaceHolder = ew_RemoveHtml($this->telefono2_tercero->FldCaption());

		// fax_tercero
		$this->fax_tercero->EditAttrs["class"] = "form-control";
		$this->fax_tercero->EditCustomAttributes = "";
		$this->fax_tercero->EditValue = $this->fax_tercero->CurrentValue;
		$this->fax_tercero->PlaceHolder = ew_RemoveHtml($this->fax_tercero->FldCaption());

		// nit_tercero
		$this->nit_tercero->EditAttrs["class"] = "form-control";
		$this->nit_tercero->EditCustomAttributes = "";
		$this->nit_tercero->EditValue = $this->nit_tercero->CurrentValue;
		$this->nit_tercero->PlaceHolder = ew_RemoveHtml($this->nit_tercero->FldCaption());

		// tipo_tercero
		$this->tipo_tercero->EditAttrs["class"] = "form-control";
		$this->tipo_tercero->EditCustomAttributes = "";
		$this->tipo_tercero->EditValue = $this->tipo_tercero->CurrentValue;
		$this->tipo_tercero->PlaceHolder = ew_RemoveHtml($this->tipo_tercero->FldCaption());

		// e_mail_tercero
		$this->e_mail_tercero->EditAttrs["class"] = "form-control";
		$this->e_mail_tercero->EditCustomAttributes = "";
		$this->e_mail_tercero->EditValue = $this->e_mail_tercero->CurrentValue;
		$this->e_mail_tercero->PlaceHolder = ew_RemoveHtml($this->e_mail_tercero->FldCaption());

		// Contacto_tercero
		$this->Contacto_tercero->EditAttrs["class"] = "form-control";
		$this->Contacto_tercero->EditCustomAttributes = "";
		$this->Contacto_tercero->EditValue = $this->Contacto_tercero->CurrentValue;
		$this->Contacto_tercero->PlaceHolder = ew_RemoveHtml($this->Contacto_tercero->FldCaption());

		// gran_contrib_tercero
		$this->gran_contrib_tercero->EditAttrs["class"] = "form-control";
		$this->gran_contrib_tercero->EditCustomAttributes = "";
		$this->gran_contrib_tercero->EditValue = $this->gran_contrib_tercero->CurrentValue;
		$this->gran_contrib_tercero->PlaceHolder = ew_RemoveHtml($this->gran_contrib_tercero->FldCaption());

		// autoretenedor_tercero
		$this->autoretenedor_tercero->EditAttrs["class"] = "form-control";
		$this->autoretenedor_tercero->EditCustomAttributes = "";
		$this->autoretenedor_tercero->EditValue = $this->autoretenedor_tercero->CurrentValue;
		$this->autoretenedor_tercero->PlaceHolder = ew_RemoveHtml($this->autoretenedor_tercero->FldCaption());

		// activo_tercero
		$this->activo_tercero->EditAttrs["class"] = "form-control";
		$this->activo_tercero->EditCustomAttributes = "";
		$this->activo_tercero->EditValue = $this->activo_tercero->CurrentValue;
		$this->activo_tercero->PlaceHolder = ew_RemoveHtml($this->activo_tercero->FldCaption());

		// tercero_ registrado_por
		$this->tercero__registrado_por->EditAttrs["class"] = "form-control";
		$this->tercero__registrado_por->EditCustomAttributes = "";
		$this->tercero__registrado_por->EditValue = $this->tercero__registrado_por->CurrentValue;
		$this->tercero__registrado_por->PlaceHolder = ew_RemoveHtml($this->tercero__registrado_por->FldCaption());

		// reg_comun_tercero
		$this->reg_comun_tercero->EditAttrs["class"] = "form-control";
		$this->reg_comun_tercero->EditCustomAttributes = "";
		$this->reg_comun_tercero->EditValue = $this->reg_comun_tercero->CurrentValue;
		$this->reg_comun_tercero->PlaceHolder = ew_RemoveHtml($this->reg_comun_tercero->FldCaption());

		// responsable_materiales_tercero
		$this->responsable_materiales_tercero->EditAttrs["class"] = "form-control";
		$this->responsable_materiales_tercero->EditCustomAttributes = "";
		$this->responsable_materiales_tercero->EditValue = $this->responsable_materiales_tercero->CurrentValue;
		$this->responsable_materiales_tercero->PlaceHolder = ew_RemoveHtml($this->responsable_materiales_tercero->FldCaption());

		// grupo_nomina_tercero
		$this->grupo_nomina_tercero->EditAttrs["class"] = "form-control";
		$this->grupo_nomina_tercero->EditCustomAttributes = "";
		$this->grupo_nomina_tercero->EditValue = $this->grupo_nomina_tercero->CurrentValue;
		$this->grupo_nomina_tercero->PlaceHolder = ew_RemoveHtml($this->grupo_nomina_tercero->FldCaption());

		// tercero_ lider_Obra
		$this->tercero__lider_Obra->EditAttrs["class"] = "form-control";
		$this->tercero__lider_Obra->EditCustomAttributes = "";
		$this->tercero__lider_Obra->EditValue = $this->tercero__lider_Obra->CurrentValue;
		$this->tercero__lider_Obra->PlaceHolder = ew_RemoveHtml($this->tercero__lider_Obra->FldCaption());

		// tercero_nombre_lider
		$this->tercero_nombre_lider->EditAttrs["class"] = "form-control";
		$this->tercero_nombre_lider->EditCustomAttributes = "";
		$this->tercero_nombre_lider->EditValue = $this->tercero_nombre_lider->CurrentValue;
		$this->tercero_nombre_lider->PlaceHolder = ew_RemoveHtml($this->tercero_nombre_lider->FldCaption());

		// empresa_tercero
		$this->empresa_tercero->EditAttrs["class"] = "form-control";
		$this->empresa_tercero->EditCustomAttributes = "";
		$this->empresa_tercero->EditValue = $this->empresa_tercero->CurrentValue;
		$this->empresa_tercero->PlaceHolder = ew_RemoveHtml($this->empresa_tercero->FldCaption());

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
					if ($this->Id_tercero->Exportable) $Doc->ExportCaption($this->Id_tercero);
					if ($this->nombre_tercero->Exportable) $Doc->ExportCaption($this->nombre_tercero);
					if ($this->direccion_tercero->Exportable) $Doc->ExportCaption($this->direccion_tercero);
					if ($this->telefono1_tercero->Exportable) $Doc->ExportCaption($this->telefono1_tercero);
					if ($this->telefono2_tercero->Exportable) $Doc->ExportCaption($this->telefono2_tercero);
					if ($this->fax_tercero->Exportable) $Doc->ExportCaption($this->fax_tercero);
					if ($this->nit_tercero->Exportable) $Doc->ExportCaption($this->nit_tercero);
					if ($this->tipo_tercero->Exportable) $Doc->ExportCaption($this->tipo_tercero);
					if ($this->e_mail_tercero->Exportable) $Doc->ExportCaption($this->e_mail_tercero);
					if ($this->Contacto_tercero->Exportable) $Doc->ExportCaption($this->Contacto_tercero);
					if ($this->gran_contrib_tercero->Exportable) $Doc->ExportCaption($this->gran_contrib_tercero);
					if ($this->autoretenedor_tercero->Exportable) $Doc->ExportCaption($this->autoretenedor_tercero);
					if ($this->activo_tercero->Exportable) $Doc->ExportCaption($this->activo_tercero);
					if ($this->tercero__registrado_por->Exportable) $Doc->ExportCaption($this->tercero__registrado_por);
					if ($this->reg_comun_tercero->Exportable) $Doc->ExportCaption($this->reg_comun_tercero);
					if ($this->responsable_materiales_tercero->Exportable) $Doc->ExportCaption($this->responsable_materiales_tercero);
					if ($this->grupo_nomina_tercero->Exportable) $Doc->ExportCaption($this->grupo_nomina_tercero);
					if ($this->tercero__lider_Obra->Exportable) $Doc->ExportCaption($this->tercero__lider_Obra);
					if ($this->tercero_nombre_lider->Exportable) $Doc->ExportCaption($this->tercero_nombre_lider);
					if ($this->empresa_tercero->Exportable) $Doc->ExportCaption($this->empresa_tercero);
				} else {
					if ($this->Id_tercero->Exportable) $Doc->ExportCaption($this->Id_tercero);
					if ($this->nombre_tercero->Exportable) $Doc->ExportCaption($this->nombre_tercero);
					if ($this->direccion_tercero->Exportable) $Doc->ExportCaption($this->direccion_tercero);
					if ($this->telefono1_tercero->Exportable) $Doc->ExportCaption($this->telefono1_tercero);
					if ($this->telefono2_tercero->Exportable) $Doc->ExportCaption($this->telefono2_tercero);
					if ($this->fax_tercero->Exportable) $Doc->ExportCaption($this->fax_tercero);
					if ($this->nit_tercero->Exportable) $Doc->ExportCaption($this->nit_tercero);
					if ($this->tipo_tercero->Exportable) $Doc->ExportCaption($this->tipo_tercero);
					if ($this->e_mail_tercero->Exportable) $Doc->ExportCaption($this->e_mail_tercero);
					if ($this->Contacto_tercero->Exportable) $Doc->ExportCaption($this->Contacto_tercero);
					if ($this->gran_contrib_tercero->Exportable) $Doc->ExportCaption($this->gran_contrib_tercero);
					if ($this->autoretenedor_tercero->Exportable) $Doc->ExportCaption($this->autoretenedor_tercero);
					if ($this->activo_tercero->Exportable) $Doc->ExportCaption($this->activo_tercero);
					if ($this->tercero__registrado_por->Exportable) $Doc->ExportCaption($this->tercero__registrado_por);
					if ($this->reg_comun_tercero->Exportable) $Doc->ExportCaption($this->reg_comun_tercero);
					if ($this->responsable_materiales_tercero->Exportable) $Doc->ExportCaption($this->responsable_materiales_tercero);
					if ($this->grupo_nomina_tercero->Exportable) $Doc->ExportCaption($this->grupo_nomina_tercero);
					if ($this->tercero__lider_Obra->Exportable) $Doc->ExportCaption($this->tercero__lider_Obra);
					if ($this->tercero_nombre_lider->Exportable) $Doc->ExportCaption($this->tercero_nombre_lider);
					if ($this->empresa_tercero->Exportable) $Doc->ExportCaption($this->empresa_tercero);
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
						if ($this->Id_tercero->Exportable) $Doc->ExportField($this->Id_tercero);
						if ($this->nombre_tercero->Exportable) $Doc->ExportField($this->nombre_tercero);
						if ($this->direccion_tercero->Exportable) $Doc->ExportField($this->direccion_tercero);
						if ($this->telefono1_tercero->Exportable) $Doc->ExportField($this->telefono1_tercero);
						if ($this->telefono2_tercero->Exportable) $Doc->ExportField($this->telefono2_tercero);
						if ($this->fax_tercero->Exportable) $Doc->ExportField($this->fax_tercero);
						if ($this->nit_tercero->Exportable) $Doc->ExportField($this->nit_tercero);
						if ($this->tipo_tercero->Exportable) $Doc->ExportField($this->tipo_tercero);
						if ($this->e_mail_tercero->Exportable) $Doc->ExportField($this->e_mail_tercero);
						if ($this->Contacto_tercero->Exportable) $Doc->ExportField($this->Contacto_tercero);
						if ($this->gran_contrib_tercero->Exportable) $Doc->ExportField($this->gran_contrib_tercero);
						if ($this->autoretenedor_tercero->Exportable) $Doc->ExportField($this->autoretenedor_tercero);
						if ($this->activo_tercero->Exportable) $Doc->ExportField($this->activo_tercero);
						if ($this->tercero__registrado_por->Exportable) $Doc->ExportField($this->tercero__registrado_por);
						if ($this->reg_comun_tercero->Exportable) $Doc->ExportField($this->reg_comun_tercero);
						if ($this->responsable_materiales_tercero->Exportable) $Doc->ExportField($this->responsable_materiales_tercero);
						if ($this->grupo_nomina_tercero->Exportable) $Doc->ExportField($this->grupo_nomina_tercero);
						if ($this->tercero__lider_Obra->Exportable) $Doc->ExportField($this->tercero__lider_Obra);
						if ($this->tercero_nombre_lider->Exportable) $Doc->ExportField($this->tercero_nombre_lider);
						if ($this->empresa_tercero->Exportable) $Doc->ExportField($this->empresa_tercero);
					} else {
						if ($this->Id_tercero->Exportable) $Doc->ExportField($this->Id_tercero);
						if ($this->nombre_tercero->Exportable) $Doc->ExportField($this->nombre_tercero);
						if ($this->direccion_tercero->Exportable) $Doc->ExportField($this->direccion_tercero);
						if ($this->telefono1_tercero->Exportable) $Doc->ExportField($this->telefono1_tercero);
						if ($this->telefono2_tercero->Exportable) $Doc->ExportField($this->telefono2_tercero);
						if ($this->fax_tercero->Exportable) $Doc->ExportField($this->fax_tercero);
						if ($this->nit_tercero->Exportable) $Doc->ExportField($this->nit_tercero);
						if ($this->tipo_tercero->Exportable) $Doc->ExportField($this->tipo_tercero);
						if ($this->e_mail_tercero->Exportable) $Doc->ExportField($this->e_mail_tercero);
						if ($this->Contacto_tercero->Exportable) $Doc->ExportField($this->Contacto_tercero);
						if ($this->gran_contrib_tercero->Exportable) $Doc->ExportField($this->gran_contrib_tercero);
						if ($this->autoretenedor_tercero->Exportable) $Doc->ExportField($this->autoretenedor_tercero);
						if ($this->activo_tercero->Exportable) $Doc->ExportField($this->activo_tercero);
						if ($this->tercero__registrado_por->Exportable) $Doc->ExportField($this->tercero__registrado_por);
						if ($this->reg_comun_tercero->Exportable) $Doc->ExportField($this->reg_comun_tercero);
						if ($this->responsable_materiales_tercero->Exportable) $Doc->ExportField($this->responsable_materiales_tercero);
						if ($this->grupo_nomina_tercero->Exportable) $Doc->ExportField($this->grupo_nomina_tercero);
						if ($this->tercero__lider_Obra->Exportable) $Doc->ExportField($this->tercero__lider_Obra);
						if ($this->tercero_nombre_lider->Exportable) $Doc->ExportField($this->tercero_nombre_lider);
						if ($this->empresa_tercero->Exportable) $Doc->ExportField($this->empresa_tercero);
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
