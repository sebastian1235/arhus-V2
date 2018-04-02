<?php

// Global variable for table object
$demanda = NULL;

//
// Table class for demanda
//
class cdemanda extends cTable {
	var $origen_dem;
	var $tipo_cliente_dem;
	var $fecha_llamada;
	var $cod_dem;
	var $poliza_dem;
	var $usuario_captura;
	var $campana_demanda;
	var $chip_natural;
	var $estado_predio;
	var $tipo_predio;
	var $uso;
	var $mecado;
	var $nombre_cliente;
	var $num_doc;
	var $direccion;
	var $municipio;
	var $telefono;
	var $cod_trabajo_original;
	var $fecha_trab_dem;
	var $cod_ult_visit;
	var $res_ult_vis;
	var $fecha_ult_visita;
	var $usu_asig_primer_trab;
	var $fecha_prim_visit;
	var $respuesta_pv;
	var $fecha_cap_primera_visita;
	var $cod_contratista;
	var $nom_cont;
	var $distrito;
	var $malla;
	var $sector;
	var $descr_estado_dem;
	var $estrato;
	var $clase_dem;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'demanda';
		$this->TableName = 'demanda';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`demanda`";
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

		// origen_dem
		$this->origen_dem = new cField('demanda', 'demanda', 'x_origen_dem', 'origen_dem', '`origen_dem`', '`origen_dem`', 200, -1, FALSE, '`origen_dem`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->origen_dem->Sortable = TRUE; // Allow sort
		$this->fields['origen_dem'] = &$this->origen_dem;

		// tipo_cliente_dem
		$this->tipo_cliente_dem = new cField('demanda', 'demanda', 'x_tipo_cliente_dem', 'tipo_cliente_dem', '`tipo_cliente_dem`', '`tipo_cliente_dem`', 200, -1, FALSE, '`tipo_cliente_dem`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tipo_cliente_dem->Sortable = TRUE; // Allow sort
		$this->fields['tipo_cliente_dem'] = &$this->tipo_cliente_dem;

		// fecha_llamada
		$this->fecha_llamada = new cField('demanda', 'demanda', 'x_fecha_llamada', 'fecha_llamada', '`fecha_llamada`', 'DATE_FORMAT(`fecha_llamada`, \'%Y/%m/%d\')', 133, 0, FALSE, '`fecha_llamada`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fecha_llamada->Sortable = TRUE; // Allow sort
		$this->fecha_llamada->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['fecha_llamada'] = &$this->fecha_llamada;

		// cod_dem
		$this->cod_dem = new cField('demanda', 'demanda', 'x_cod_dem', 'cod_dem', '`cod_dem`', '`cod_dem`', 3, -1, FALSE, '`cod_dem`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->cod_dem->Sortable = TRUE; // Allow sort
		$this->cod_dem->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['cod_dem'] = &$this->cod_dem;

		// poliza_dem
		$this->poliza_dem = new cField('demanda', 'demanda', 'x_poliza_dem', 'poliza_dem', '`poliza_dem`', '`poliza_dem`', 3, -1, FALSE, '`poliza_dem`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->poliza_dem->Sortable = TRUE; // Allow sort
		$this->poliza_dem->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['poliza_dem'] = &$this->poliza_dem;

		// usuario_captura
		$this->usuario_captura = new cField('demanda', 'demanda', 'x_usuario_captura', 'usuario_captura', '`usuario_captura`', '`usuario_captura`', 200, -1, FALSE, '`usuario_captura`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->usuario_captura->Sortable = TRUE; // Allow sort
		$this->fields['usuario_captura'] = &$this->usuario_captura;

		// campana_demanda
		$this->campana_demanda = new cField('demanda', 'demanda', 'x_campana_demanda', 'campana_demanda', '`campana_demanda`', '`campana_demanda`', 200, -1, FALSE, '`campana_demanda`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->campana_demanda->Sortable = TRUE; // Allow sort
		$this->fields['campana_demanda'] = &$this->campana_demanda;

		// chip_natural
		$this->chip_natural = new cField('demanda', 'demanda', 'x_chip_natural', 'chip_natural', '`chip_natural`', '`chip_natural`', 200, -1, FALSE, '`chip_natural`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->chip_natural->Sortable = TRUE; // Allow sort
		$this->fields['chip_natural'] = &$this->chip_natural;

		// estado_predio
		$this->estado_predio = new cField('demanda', 'demanda', 'x_estado_predio', 'estado_predio', '`estado_predio`', '`estado_predio`', 200, -1, FALSE, '`estado_predio`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->estado_predio->Sortable = TRUE; // Allow sort
		$this->fields['estado_predio'] = &$this->estado_predio;

		// tipo_predio
		$this->tipo_predio = new cField('demanda', 'demanda', 'x_tipo_predio', 'tipo_predio', '`tipo_predio`', '`tipo_predio`', 200, -1, FALSE, '`tipo_predio`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tipo_predio->Sortable = TRUE; // Allow sort
		$this->fields['tipo_predio'] = &$this->tipo_predio;

		// uso
		$this->uso = new cField('demanda', 'demanda', 'x_uso', 'uso', '`uso`', '`uso`', 200, -1, FALSE, '`uso`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->uso->Sortable = TRUE; // Allow sort
		$this->fields['uso'] = &$this->uso;

		// mecado
		$this->mecado = new cField('demanda', 'demanda', 'x_mecado', 'mecado', '`mecado`', '`mecado`', 200, -1, FALSE, '`mecado`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->mecado->Sortable = TRUE; // Allow sort
		$this->fields['mecado'] = &$this->mecado;

		// nombre_cliente
		$this->nombre_cliente = new cField('demanda', 'demanda', 'x_nombre_cliente', 'nombre_cliente', '`nombre_cliente`', '`nombre_cliente`', 200, -1, FALSE, '`nombre_cliente`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nombre_cliente->Sortable = TRUE; // Allow sort
		$this->fields['nombre_cliente'] = &$this->nombre_cliente;

		// num_doc
		$this->num_doc = new cField('demanda', 'demanda', 'x_num_doc', 'num_doc', '`num_doc`', '`num_doc`', 200, -1, FALSE, '`num_doc`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->num_doc->Sortable = TRUE; // Allow sort
		$this->fields['num_doc'] = &$this->num_doc;

		// direccion
		$this->direccion = new cField('demanda', 'demanda', 'x_direccion', 'direccion', '`direccion`', '`direccion`', 200, -1, FALSE, '`direccion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->direccion->Sortable = TRUE; // Allow sort
		$this->fields['direccion'] = &$this->direccion;

		// municipio
		$this->municipio = new cField('demanda', 'demanda', 'x_municipio', 'municipio', '`municipio`', '`municipio`', 200, -1, FALSE, '`municipio`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->municipio->Sortable = TRUE; // Allow sort
		$this->fields['municipio'] = &$this->municipio;

		// telefono
		$this->telefono = new cField('demanda', 'demanda', 'x_telefono', 'telefono', '`telefono`', '`telefono`', 200, -1, FALSE, '`telefono`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->telefono->Sortable = TRUE; // Allow sort
		$this->fields['telefono'] = &$this->telefono;

		// cod_trabajo_original
		$this->cod_trabajo_original = new cField('demanda', 'demanda', 'x_cod_trabajo_original', 'cod_trabajo_original', '`cod_trabajo_original`', '`cod_trabajo_original`', 3, -1, FALSE, '`cod_trabajo_original`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->cod_trabajo_original->Sortable = TRUE; // Allow sort
		$this->cod_trabajo_original->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['cod_trabajo_original'] = &$this->cod_trabajo_original;

		// fecha_trab_dem
		$this->fecha_trab_dem = new cField('demanda', 'demanda', 'x_fecha_trab_dem', 'fecha_trab_dem', '`fecha_trab_dem`', 'DATE_FORMAT(`fecha_trab_dem`, \'%Y/%m/%d\')', 133, 0, FALSE, '`fecha_trab_dem`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fecha_trab_dem->Sortable = TRUE; // Allow sort
		$this->fecha_trab_dem->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['fecha_trab_dem'] = &$this->fecha_trab_dem;

		// cod_ult_visit
		$this->cod_ult_visit = new cField('demanda', 'demanda', 'x_cod_ult_visit', 'cod_ult_visit', '`cod_ult_visit`', '`cod_ult_visit`', 3, -1, FALSE, '`cod_ult_visit`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->cod_ult_visit->Sortable = TRUE; // Allow sort
		$this->cod_ult_visit->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['cod_ult_visit'] = &$this->cod_ult_visit;

		// res_ult_vis
		$this->res_ult_vis = new cField('demanda', 'demanda', 'x_res_ult_vis', 'res_ult_vis', '`res_ult_vis`', '`res_ult_vis`', 200, -1, FALSE, '`res_ult_vis`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->res_ult_vis->Sortable = TRUE; // Allow sort
		$this->fields['res_ult_vis'] = &$this->res_ult_vis;

		// fecha_ult_visita
		$this->fecha_ult_visita = new cField('demanda', 'demanda', 'x_fecha_ult_visita', 'fecha_ult_visita', '`fecha_ult_visita`', 'DATE_FORMAT(`fecha_ult_visita`, \'%Y/%m/%d\')', 133, 0, FALSE, '`fecha_ult_visita`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fecha_ult_visita->Sortable = TRUE; // Allow sort
		$this->fecha_ult_visita->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['fecha_ult_visita'] = &$this->fecha_ult_visita;

		// usu_asig_primer_trab
		$this->usu_asig_primer_trab = new cField('demanda', 'demanda', 'x_usu_asig_primer_trab', 'usu_asig_primer_trab', '`usu_asig_primer_trab`', '`usu_asig_primer_trab`', 200, -1, FALSE, '`usu_asig_primer_trab`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->usu_asig_primer_trab->Sortable = TRUE; // Allow sort
		$this->fields['usu_asig_primer_trab'] = &$this->usu_asig_primer_trab;

		// fecha_prim_visit
		$this->fecha_prim_visit = new cField('demanda', 'demanda', 'x_fecha_prim_visit', 'fecha_prim_visit', '`fecha_prim_visit`', 'DATE_FORMAT(`fecha_prim_visit`, \'%Y/%m/%d\')', 133, 0, FALSE, '`fecha_prim_visit`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fecha_prim_visit->Sortable = TRUE; // Allow sort
		$this->fecha_prim_visit->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['fecha_prim_visit'] = &$this->fecha_prim_visit;

		// respuesta_pv
		$this->respuesta_pv = new cField('demanda', 'demanda', 'x_respuesta_pv', 'respuesta_pv', '`respuesta_pv`', '`respuesta_pv`', 200, -1, FALSE, '`respuesta_pv`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->respuesta_pv->Sortable = TRUE; // Allow sort
		$this->fields['respuesta_pv'] = &$this->respuesta_pv;

		// fecha_cap_primera_visita
		$this->fecha_cap_primera_visita = new cField('demanda', 'demanda', 'x_fecha_cap_primera_visita', 'fecha_cap_primera_visita', '`fecha_cap_primera_visita`', 'DATE_FORMAT(`fecha_cap_primera_visita`, \'%Y/%m/%d\')', 133, 0, FALSE, '`fecha_cap_primera_visita`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fecha_cap_primera_visita->Sortable = TRUE; // Allow sort
		$this->fecha_cap_primera_visita->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['fecha_cap_primera_visita'] = &$this->fecha_cap_primera_visita;

		// cod_contratista
		$this->cod_contratista = new cField('demanda', 'demanda', 'x_cod_contratista', 'cod_contratista', '`cod_contratista`', '`cod_contratista`', 200, -1, FALSE, '`cod_contratista`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->cod_contratista->Sortable = TRUE; // Allow sort
		$this->fields['cod_contratista'] = &$this->cod_contratista;

		// nom_cont
		$this->nom_cont = new cField('demanda', 'demanda', 'x_nom_cont', 'nom_cont', '`nom_cont`', '`nom_cont`', 200, -1, FALSE, '`nom_cont`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nom_cont->Sortable = TRUE; // Allow sort
		$this->fields['nom_cont'] = &$this->nom_cont;

		// distrito
		$this->distrito = new cField('demanda', 'demanda', 'x_distrito', 'distrito', '`distrito`', '`distrito`', 3, -1, FALSE, '`distrito`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->distrito->Sortable = TRUE; // Allow sort
		$this->distrito->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['distrito'] = &$this->distrito;

		// malla
		$this->malla = new cField('demanda', 'demanda', 'x_malla', 'malla', '`malla`', '`malla`', 3, -1, FALSE, '`malla`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->malla->Sortable = TRUE; // Allow sort
		$this->malla->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['malla'] = &$this->malla;

		// sector
		$this->sector = new cField('demanda', 'demanda', 'x_sector', 'sector', '`sector`', '`sector`', 3, -1, FALSE, '`sector`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sector->Sortable = TRUE; // Allow sort
		$this->sector->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['sector'] = &$this->sector;

		// descr_estado_dem
		$this->descr_estado_dem = new cField('demanda', 'demanda', 'x_descr_estado_dem', 'descr_estado_dem', '`descr_estado_dem`', '`descr_estado_dem`', 200, -1, FALSE, '`descr_estado_dem`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->descr_estado_dem->Sortable = TRUE; // Allow sort
		$this->fields['descr_estado_dem'] = &$this->descr_estado_dem;

		// estrato
		$this->estrato = new cField('demanda', 'demanda', 'x_estrato', 'estrato', '`estrato`', '`estrato`', 3, -1, FALSE, '`estrato`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->estrato->Sortable = TRUE; // Allow sort
		$this->estrato->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['estrato'] = &$this->estrato;

		// clase_dem
		$this->clase_dem = new cField('demanda', 'demanda', 'x_clase_dem', 'clase_dem', '`clase_dem`', '`clase_dem`', 200, -1, FALSE, '`clase_dem`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->clase_dem->Sortable = TRUE; // Allow sort
		$this->fields['clase_dem'] = &$this->clase_dem;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`demanda`";
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
		return "";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
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
			return "demandalist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "demandalist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("demandaview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("demandaview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "demandaadd.php?" . $this->UrlParm($parm);
		else
			$url = "demandaadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("demandaedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("demandaadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("demandadelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
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

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		if (is_array($arKeys)) {
			foreach ($arKeys as $key) {
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
		$this->origen_dem->setDbValue($rs->fields('origen_dem'));
		$this->tipo_cliente_dem->setDbValue($rs->fields('tipo_cliente_dem'));
		$this->fecha_llamada->setDbValue($rs->fields('fecha_llamada'));
		$this->cod_dem->setDbValue($rs->fields('cod_dem'));
		$this->poliza_dem->setDbValue($rs->fields('poliza_dem'));
		$this->usuario_captura->setDbValue($rs->fields('usuario_captura'));
		$this->campana_demanda->setDbValue($rs->fields('campana_demanda'));
		$this->chip_natural->setDbValue($rs->fields('chip_natural'));
		$this->estado_predio->setDbValue($rs->fields('estado_predio'));
		$this->tipo_predio->setDbValue($rs->fields('tipo_predio'));
		$this->uso->setDbValue($rs->fields('uso'));
		$this->mecado->setDbValue($rs->fields('mecado'));
		$this->nombre_cliente->setDbValue($rs->fields('nombre_cliente'));
		$this->num_doc->setDbValue($rs->fields('num_doc'));
		$this->direccion->setDbValue($rs->fields('direccion'));
		$this->municipio->setDbValue($rs->fields('municipio'));
		$this->telefono->setDbValue($rs->fields('telefono'));
		$this->cod_trabajo_original->setDbValue($rs->fields('cod_trabajo_original'));
		$this->fecha_trab_dem->setDbValue($rs->fields('fecha_trab_dem'));
		$this->cod_ult_visit->setDbValue($rs->fields('cod_ult_visit'));
		$this->res_ult_vis->setDbValue($rs->fields('res_ult_vis'));
		$this->fecha_ult_visita->setDbValue($rs->fields('fecha_ult_visita'));
		$this->usu_asig_primer_trab->setDbValue($rs->fields('usu_asig_primer_trab'));
		$this->fecha_prim_visit->setDbValue($rs->fields('fecha_prim_visit'));
		$this->respuesta_pv->setDbValue($rs->fields('respuesta_pv'));
		$this->fecha_cap_primera_visita->setDbValue($rs->fields('fecha_cap_primera_visita'));
		$this->cod_contratista->setDbValue($rs->fields('cod_contratista'));
		$this->nom_cont->setDbValue($rs->fields('nom_cont'));
		$this->distrito->setDbValue($rs->fields('distrito'));
		$this->malla->setDbValue($rs->fields('malla'));
		$this->sector->setDbValue($rs->fields('sector'));
		$this->descr_estado_dem->setDbValue($rs->fields('descr_estado_dem'));
		$this->estrato->setDbValue($rs->fields('estrato'));
		$this->clase_dem->setDbValue($rs->fields('clase_dem'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// origen_dem
		// tipo_cliente_dem
		// fecha_llamada
		// cod_dem
		// poliza_dem
		// usuario_captura
		// campana_demanda
		// chip_natural
		// estado_predio
		// tipo_predio
		// uso
		// mecado
		// nombre_cliente
		// num_doc
		// direccion
		// municipio
		// telefono
		// cod_trabajo_original
		// fecha_trab_dem
		// cod_ult_visit
		// res_ult_vis
		// fecha_ult_visita
		// usu_asig_primer_trab
		// fecha_prim_visit
		// respuesta_pv
		// fecha_cap_primera_visita
		// cod_contratista
		// nom_cont
		// distrito
		// malla
		// sector
		// descr_estado_dem
		// estrato
		// clase_dem
		// origen_dem

		$this->origen_dem->ViewValue = $this->origen_dem->CurrentValue;
		$this->origen_dem->ViewCustomAttributes = "";

		// tipo_cliente_dem
		$this->tipo_cliente_dem->ViewValue = $this->tipo_cliente_dem->CurrentValue;
		$this->tipo_cliente_dem->ViewCustomAttributes = "";

		// fecha_llamada
		$this->fecha_llamada->ViewValue = $this->fecha_llamada->CurrentValue;
		$this->fecha_llamada->ViewValue = ew_FormatDateTime($this->fecha_llamada->ViewValue, 0);
		$this->fecha_llamada->ViewCustomAttributes = "";

		// cod_dem
		$this->cod_dem->ViewValue = $this->cod_dem->CurrentValue;
		$this->cod_dem->ViewCustomAttributes = "";

		// poliza_dem
		$this->poliza_dem->ViewValue = $this->poliza_dem->CurrentValue;
		$this->poliza_dem->ViewCustomAttributes = "";

		// usuario_captura
		$this->usuario_captura->ViewValue = $this->usuario_captura->CurrentValue;
		$this->usuario_captura->ViewCustomAttributes = "";

		// campana_demanda
		$this->campana_demanda->ViewValue = $this->campana_demanda->CurrentValue;
		$this->campana_demanda->ViewCustomAttributes = "";

		// chip_natural
		$this->chip_natural->ViewValue = $this->chip_natural->CurrentValue;
		$this->chip_natural->ViewCustomAttributes = "";

		// estado_predio
		$this->estado_predio->ViewValue = $this->estado_predio->CurrentValue;
		$this->estado_predio->ViewCustomAttributes = "";

		// tipo_predio
		$this->tipo_predio->ViewValue = $this->tipo_predio->CurrentValue;
		$this->tipo_predio->ViewCustomAttributes = "";

		// uso
		$this->uso->ViewValue = $this->uso->CurrentValue;
		$this->uso->ViewCustomAttributes = "";

		// mecado
		$this->mecado->ViewValue = $this->mecado->CurrentValue;
		$this->mecado->ViewCustomAttributes = "";

		// nombre_cliente
		$this->nombre_cliente->ViewValue = $this->nombre_cliente->CurrentValue;
		$this->nombre_cliente->ViewCustomAttributes = "";

		// num_doc
		$this->num_doc->ViewValue = $this->num_doc->CurrentValue;
		$this->num_doc->ViewCustomAttributes = "";

		// direccion
		$this->direccion->ViewValue = $this->direccion->CurrentValue;
		$this->direccion->ViewCustomAttributes = "";

		// municipio
		$this->municipio->ViewValue = $this->municipio->CurrentValue;
		$this->municipio->ViewCustomAttributes = "";

		// telefono
		$this->telefono->ViewValue = $this->telefono->CurrentValue;
		$this->telefono->ViewCustomAttributes = "";

		// cod_trabajo_original
		$this->cod_trabajo_original->ViewValue = $this->cod_trabajo_original->CurrentValue;
		$this->cod_trabajo_original->ViewCustomAttributes = "";

		// fecha_trab_dem
		$this->fecha_trab_dem->ViewValue = $this->fecha_trab_dem->CurrentValue;
		$this->fecha_trab_dem->ViewValue = ew_FormatDateTime($this->fecha_trab_dem->ViewValue, 0);
		$this->fecha_trab_dem->ViewCustomAttributes = "";

		// cod_ult_visit
		$this->cod_ult_visit->ViewValue = $this->cod_ult_visit->CurrentValue;
		$this->cod_ult_visit->ViewCustomAttributes = "";

		// res_ult_vis
		$this->res_ult_vis->ViewValue = $this->res_ult_vis->CurrentValue;
		$this->res_ult_vis->ViewCustomAttributes = "";

		// fecha_ult_visita
		$this->fecha_ult_visita->ViewValue = $this->fecha_ult_visita->CurrentValue;
		$this->fecha_ult_visita->ViewValue = ew_FormatDateTime($this->fecha_ult_visita->ViewValue, 0);
		$this->fecha_ult_visita->ViewCustomAttributes = "";

		// usu_asig_primer_trab
		$this->usu_asig_primer_trab->ViewValue = $this->usu_asig_primer_trab->CurrentValue;
		$this->usu_asig_primer_trab->ViewCustomAttributes = "";

		// fecha_prim_visit
		$this->fecha_prim_visit->ViewValue = $this->fecha_prim_visit->CurrentValue;
		$this->fecha_prim_visit->ViewValue = ew_FormatDateTime($this->fecha_prim_visit->ViewValue, 0);
		$this->fecha_prim_visit->ViewCustomAttributes = "";

		// respuesta_pv
		$this->respuesta_pv->ViewValue = $this->respuesta_pv->CurrentValue;
		$this->respuesta_pv->ViewCustomAttributes = "";

		// fecha_cap_primera_visita
		$this->fecha_cap_primera_visita->ViewValue = $this->fecha_cap_primera_visita->CurrentValue;
		$this->fecha_cap_primera_visita->ViewValue = ew_FormatDateTime($this->fecha_cap_primera_visita->ViewValue, 0);
		$this->fecha_cap_primera_visita->ViewCustomAttributes = "";

		// cod_contratista
		$this->cod_contratista->ViewValue = $this->cod_contratista->CurrentValue;
		$this->cod_contratista->ViewCustomAttributes = "";

		// nom_cont
		$this->nom_cont->ViewValue = $this->nom_cont->CurrentValue;
		$this->nom_cont->ViewCustomAttributes = "";

		// distrito
		$this->distrito->ViewValue = $this->distrito->CurrentValue;
		$this->distrito->ViewCustomAttributes = "";

		// malla
		$this->malla->ViewValue = $this->malla->CurrentValue;
		$this->malla->ViewCustomAttributes = "";

		// sector
		$this->sector->ViewValue = $this->sector->CurrentValue;
		$this->sector->ViewCustomAttributes = "";

		// descr_estado_dem
		$this->descr_estado_dem->ViewValue = $this->descr_estado_dem->CurrentValue;
		$this->descr_estado_dem->ViewCustomAttributes = "";

		// estrato
		$this->estrato->ViewValue = $this->estrato->CurrentValue;
		$this->estrato->ViewCustomAttributes = "";

		// clase_dem
		$this->clase_dem->ViewValue = $this->clase_dem->CurrentValue;
		$this->clase_dem->ViewCustomAttributes = "";

		// origen_dem
		$this->origen_dem->LinkCustomAttributes = "";
		$this->origen_dem->HrefValue = "";
		$this->origen_dem->TooltipValue = "";

		// tipo_cliente_dem
		$this->tipo_cliente_dem->LinkCustomAttributes = "";
		$this->tipo_cliente_dem->HrefValue = "";
		$this->tipo_cliente_dem->TooltipValue = "";

		// fecha_llamada
		$this->fecha_llamada->LinkCustomAttributes = "";
		$this->fecha_llamada->HrefValue = "";
		$this->fecha_llamada->TooltipValue = "";

		// cod_dem
		$this->cod_dem->LinkCustomAttributes = "";
		$this->cod_dem->HrefValue = "";
		$this->cod_dem->TooltipValue = "";

		// poliza_dem
		$this->poliza_dem->LinkCustomAttributes = "";
		$this->poliza_dem->HrefValue = "";
		$this->poliza_dem->TooltipValue = "";

		// usuario_captura
		$this->usuario_captura->LinkCustomAttributes = "";
		$this->usuario_captura->HrefValue = "";
		$this->usuario_captura->TooltipValue = "";

		// campana_demanda
		$this->campana_demanda->LinkCustomAttributes = "";
		$this->campana_demanda->HrefValue = "";
		$this->campana_demanda->TooltipValue = "";

		// chip_natural
		$this->chip_natural->LinkCustomAttributes = "";
		$this->chip_natural->HrefValue = "";
		$this->chip_natural->TooltipValue = "";

		// estado_predio
		$this->estado_predio->LinkCustomAttributes = "";
		$this->estado_predio->HrefValue = "";
		$this->estado_predio->TooltipValue = "";

		// tipo_predio
		$this->tipo_predio->LinkCustomAttributes = "";
		$this->tipo_predio->HrefValue = "";
		$this->tipo_predio->TooltipValue = "";

		// uso
		$this->uso->LinkCustomAttributes = "";
		$this->uso->HrefValue = "";
		$this->uso->TooltipValue = "";

		// mecado
		$this->mecado->LinkCustomAttributes = "";
		$this->mecado->HrefValue = "";
		$this->mecado->TooltipValue = "";

		// nombre_cliente
		$this->nombre_cliente->LinkCustomAttributes = "";
		$this->nombre_cliente->HrefValue = "";
		$this->nombre_cliente->TooltipValue = "";

		// num_doc
		$this->num_doc->LinkCustomAttributes = "";
		$this->num_doc->HrefValue = "";
		$this->num_doc->TooltipValue = "";

		// direccion
		$this->direccion->LinkCustomAttributes = "";
		$this->direccion->HrefValue = "";
		$this->direccion->TooltipValue = "";

		// municipio
		$this->municipio->LinkCustomAttributes = "";
		$this->municipio->HrefValue = "";
		$this->municipio->TooltipValue = "";

		// telefono
		$this->telefono->LinkCustomAttributes = "";
		$this->telefono->HrefValue = "";
		$this->telefono->TooltipValue = "";

		// cod_trabajo_original
		$this->cod_trabajo_original->LinkCustomAttributes = "";
		$this->cod_trabajo_original->HrefValue = "";
		$this->cod_trabajo_original->TooltipValue = "";

		// fecha_trab_dem
		$this->fecha_trab_dem->LinkCustomAttributes = "";
		$this->fecha_trab_dem->HrefValue = "";
		$this->fecha_trab_dem->TooltipValue = "";

		// cod_ult_visit
		$this->cod_ult_visit->LinkCustomAttributes = "";
		$this->cod_ult_visit->HrefValue = "";
		$this->cod_ult_visit->TooltipValue = "";

		// res_ult_vis
		$this->res_ult_vis->LinkCustomAttributes = "";
		$this->res_ult_vis->HrefValue = "";
		$this->res_ult_vis->TooltipValue = "";

		// fecha_ult_visita
		$this->fecha_ult_visita->LinkCustomAttributes = "";
		$this->fecha_ult_visita->HrefValue = "";
		$this->fecha_ult_visita->TooltipValue = "";

		// usu_asig_primer_trab
		$this->usu_asig_primer_trab->LinkCustomAttributes = "";
		$this->usu_asig_primer_trab->HrefValue = "";
		$this->usu_asig_primer_trab->TooltipValue = "";

		// fecha_prim_visit
		$this->fecha_prim_visit->LinkCustomAttributes = "";
		$this->fecha_prim_visit->HrefValue = "";
		$this->fecha_prim_visit->TooltipValue = "";

		// respuesta_pv
		$this->respuesta_pv->LinkCustomAttributes = "";
		$this->respuesta_pv->HrefValue = "";
		$this->respuesta_pv->TooltipValue = "";

		// fecha_cap_primera_visita
		$this->fecha_cap_primera_visita->LinkCustomAttributes = "";
		$this->fecha_cap_primera_visita->HrefValue = "";
		$this->fecha_cap_primera_visita->TooltipValue = "";

		// cod_contratista
		$this->cod_contratista->LinkCustomAttributes = "";
		$this->cod_contratista->HrefValue = "";
		$this->cod_contratista->TooltipValue = "";

		// nom_cont
		$this->nom_cont->LinkCustomAttributes = "";
		$this->nom_cont->HrefValue = "";
		$this->nom_cont->TooltipValue = "";

		// distrito
		$this->distrito->LinkCustomAttributes = "";
		$this->distrito->HrefValue = "";
		$this->distrito->TooltipValue = "";

		// malla
		$this->malla->LinkCustomAttributes = "";
		$this->malla->HrefValue = "";
		$this->malla->TooltipValue = "";

		// sector
		$this->sector->LinkCustomAttributes = "";
		$this->sector->HrefValue = "";
		$this->sector->TooltipValue = "";

		// descr_estado_dem
		$this->descr_estado_dem->LinkCustomAttributes = "";
		$this->descr_estado_dem->HrefValue = "";
		$this->descr_estado_dem->TooltipValue = "";

		// estrato
		$this->estrato->LinkCustomAttributes = "";
		$this->estrato->HrefValue = "";
		$this->estrato->TooltipValue = "";

		// clase_dem
		$this->clase_dem->LinkCustomAttributes = "";
		$this->clase_dem->HrefValue = "";
		$this->clase_dem->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// origen_dem
		$this->origen_dem->EditAttrs["class"] = "form-control";
		$this->origen_dem->EditCustomAttributes = "";
		$this->origen_dem->EditValue = $this->origen_dem->CurrentValue;
		$this->origen_dem->PlaceHolder = ew_RemoveHtml($this->origen_dem->FldCaption());

		// tipo_cliente_dem
		$this->tipo_cliente_dem->EditAttrs["class"] = "form-control";
		$this->tipo_cliente_dem->EditCustomAttributes = "";
		$this->tipo_cliente_dem->EditValue = $this->tipo_cliente_dem->CurrentValue;
		$this->tipo_cliente_dem->PlaceHolder = ew_RemoveHtml($this->tipo_cliente_dem->FldCaption());

		// fecha_llamada
		$this->fecha_llamada->EditAttrs["class"] = "form-control";
		$this->fecha_llamada->EditCustomAttributes = "";
		$this->fecha_llamada->EditValue = ew_FormatDateTime($this->fecha_llamada->CurrentValue, 8);
		$this->fecha_llamada->PlaceHolder = ew_RemoveHtml($this->fecha_llamada->FldCaption());

		// cod_dem
		$this->cod_dem->EditAttrs["class"] = "form-control";
		$this->cod_dem->EditCustomAttributes = "";
		$this->cod_dem->EditValue = $this->cod_dem->CurrentValue;
		$this->cod_dem->PlaceHolder = ew_RemoveHtml($this->cod_dem->FldCaption());

		// poliza_dem
		$this->poliza_dem->EditAttrs["class"] = "form-control";
		$this->poliza_dem->EditCustomAttributes = "";
		$this->poliza_dem->EditValue = $this->poliza_dem->CurrentValue;
		$this->poliza_dem->PlaceHolder = ew_RemoveHtml($this->poliza_dem->FldCaption());

		// usuario_captura
		$this->usuario_captura->EditAttrs["class"] = "form-control";
		$this->usuario_captura->EditCustomAttributes = "";
		$this->usuario_captura->EditValue = $this->usuario_captura->CurrentValue;
		$this->usuario_captura->PlaceHolder = ew_RemoveHtml($this->usuario_captura->FldCaption());

		// campana_demanda
		$this->campana_demanda->EditAttrs["class"] = "form-control";
		$this->campana_demanda->EditCustomAttributes = "";
		$this->campana_demanda->EditValue = $this->campana_demanda->CurrentValue;
		$this->campana_demanda->PlaceHolder = ew_RemoveHtml($this->campana_demanda->FldCaption());

		// chip_natural
		$this->chip_natural->EditAttrs["class"] = "form-control";
		$this->chip_natural->EditCustomAttributes = "";
		$this->chip_natural->EditValue = $this->chip_natural->CurrentValue;
		$this->chip_natural->PlaceHolder = ew_RemoveHtml($this->chip_natural->FldCaption());

		// estado_predio
		$this->estado_predio->EditAttrs["class"] = "form-control";
		$this->estado_predio->EditCustomAttributes = "";
		$this->estado_predio->EditValue = $this->estado_predio->CurrentValue;
		$this->estado_predio->PlaceHolder = ew_RemoveHtml($this->estado_predio->FldCaption());

		// tipo_predio
		$this->tipo_predio->EditAttrs["class"] = "form-control";
		$this->tipo_predio->EditCustomAttributes = "";
		$this->tipo_predio->EditValue = $this->tipo_predio->CurrentValue;
		$this->tipo_predio->PlaceHolder = ew_RemoveHtml($this->tipo_predio->FldCaption());

		// uso
		$this->uso->EditAttrs["class"] = "form-control";
		$this->uso->EditCustomAttributes = "";
		$this->uso->EditValue = $this->uso->CurrentValue;
		$this->uso->PlaceHolder = ew_RemoveHtml($this->uso->FldCaption());

		// mecado
		$this->mecado->EditAttrs["class"] = "form-control";
		$this->mecado->EditCustomAttributes = "";
		$this->mecado->EditValue = $this->mecado->CurrentValue;
		$this->mecado->PlaceHolder = ew_RemoveHtml($this->mecado->FldCaption());

		// nombre_cliente
		$this->nombre_cliente->EditAttrs["class"] = "form-control";
		$this->nombre_cliente->EditCustomAttributes = "";
		$this->nombre_cliente->EditValue = $this->nombre_cliente->CurrentValue;
		$this->nombre_cliente->PlaceHolder = ew_RemoveHtml($this->nombre_cliente->FldCaption());

		// num_doc
		$this->num_doc->EditAttrs["class"] = "form-control";
		$this->num_doc->EditCustomAttributes = "";
		$this->num_doc->EditValue = $this->num_doc->CurrentValue;
		$this->num_doc->PlaceHolder = ew_RemoveHtml($this->num_doc->FldCaption());

		// direccion
		$this->direccion->EditAttrs["class"] = "form-control";
		$this->direccion->EditCustomAttributes = "";
		$this->direccion->EditValue = $this->direccion->CurrentValue;
		$this->direccion->PlaceHolder = ew_RemoveHtml($this->direccion->FldCaption());

		// municipio
		$this->municipio->EditAttrs["class"] = "form-control";
		$this->municipio->EditCustomAttributes = "";
		$this->municipio->EditValue = $this->municipio->CurrentValue;
		$this->municipio->PlaceHolder = ew_RemoveHtml($this->municipio->FldCaption());

		// telefono
		$this->telefono->EditAttrs["class"] = "form-control";
		$this->telefono->EditCustomAttributes = "";
		$this->telefono->EditValue = $this->telefono->CurrentValue;
		$this->telefono->PlaceHolder = ew_RemoveHtml($this->telefono->FldCaption());

		// cod_trabajo_original
		$this->cod_trabajo_original->EditAttrs["class"] = "form-control";
		$this->cod_trabajo_original->EditCustomAttributes = "";
		$this->cod_trabajo_original->EditValue = $this->cod_trabajo_original->CurrentValue;
		$this->cod_trabajo_original->PlaceHolder = ew_RemoveHtml($this->cod_trabajo_original->FldCaption());

		// fecha_trab_dem
		$this->fecha_trab_dem->EditAttrs["class"] = "form-control";
		$this->fecha_trab_dem->EditCustomAttributes = "";
		$this->fecha_trab_dem->EditValue = ew_FormatDateTime($this->fecha_trab_dem->CurrentValue, 8);
		$this->fecha_trab_dem->PlaceHolder = ew_RemoveHtml($this->fecha_trab_dem->FldCaption());

		// cod_ult_visit
		$this->cod_ult_visit->EditAttrs["class"] = "form-control";
		$this->cod_ult_visit->EditCustomAttributes = "";
		$this->cod_ult_visit->EditValue = $this->cod_ult_visit->CurrentValue;
		$this->cod_ult_visit->PlaceHolder = ew_RemoveHtml($this->cod_ult_visit->FldCaption());

		// res_ult_vis
		$this->res_ult_vis->EditAttrs["class"] = "form-control";
		$this->res_ult_vis->EditCustomAttributes = "";
		$this->res_ult_vis->EditValue = $this->res_ult_vis->CurrentValue;
		$this->res_ult_vis->PlaceHolder = ew_RemoveHtml($this->res_ult_vis->FldCaption());

		// fecha_ult_visita
		$this->fecha_ult_visita->EditAttrs["class"] = "form-control";
		$this->fecha_ult_visita->EditCustomAttributes = "";
		$this->fecha_ult_visita->EditValue = ew_FormatDateTime($this->fecha_ult_visita->CurrentValue, 8);
		$this->fecha_ult_visita->PlaceHolder = ew_RemoveHtml($this->fecha_ult_visita->FldCaption());

		// usu_asig_primer_trab
		$this->usu_asig_primer_trab->EditAttrs["class"] = "form-control";
		$this->usu_asig_primer_trab->EditCustomAttributes = "";
		$this->usu_asig_primer_trab->EditValue = $this->usu_asig_primer_trab->CurrentValue;
		$this->usu_asig_primer_trab->PlaceHolder = ew_RemoveHtml($this->usu_asig_primer_trab->FldCaption());

		// fecha_prim_visit
		$this->fecha_prim_visit->EditAttrs["class"] = "form-control";
		$this->fecha_prim_visit->EditCustomAttributes = "";
		$this->fecha_prim_visit->EditValue = ew_FormatDateTime($this->fecha_prim_visit->CurrentValue, 8);
		$this->fecha_prim_visit->PlaceHolder = ew_RemoveHtml($this->fecha_prim_visit->FldCaption());

		// respuesta_pv
		$this->respuesta_pv->EditAttrs["class"] = "form-control";
		$this->respuesta_pv->EditCustomAttributes = "";
		$this->respuesta_pv->EditValue = $this->respuesta_pv->CurrentValue;
		$this->respuesta_pv->PlaceHolder = ew_RemoveHtml($this->respuesta_pv->FldCaption());

		// fecha_cap_primera_visita
		$this->fecha_cap_primera_visita->EditAttrs["class"] = "form-control";
		$this->fecha_cap_primera_visita->EditCustomAttributes = "";
		$this->fecha_cap_primera_visita->EditValue = ew_FormatDateTime($this->fecha_cap_primera_visita->CurrentValue, 8);
		$this->fecha_cap_primera_visita->PlaceHolder = ew_RemoveHtml($this->fecha_cap_primera_visita->FldCaption());

		// cod_contratista
		$this->cod_contratista->EditAttrs["class"] = "form-control";
		$this->cod_contratista->EditCustomAttributes = "";
		$this->cod_contratista->EditValue = $this->cod_contratista->CurrentValue;
		$this->cod_contratista->PlaceHolder = ew_RemoveHtml($this->cod_contratista->FldCaption());

		// nom_cont
		$this->nom_cont->EditAttrs["class"] = "form-control";
		$this->nom_cont->EditCustomAttributes = "";
		$this->nom_cont->EditValue = $this->nom_cont->CurrentValue;
		$this->nom_cont->PlaceHolder = ew_RemoveHtml($this->nom_cont->FldCaption());

		// distrito
		$this->distrito->EditAttrs["class"] = "form-control";
		$this->distrito->EditCustomAttributes = "";
		$this->distrito->EditValue = $this->distrito->CurrentValue;
		$this->distrito->PlaceHolder = ew_RemoveHtml($this->distrito->FldCaption());

		// malla
		$this->malla->EditAttrs["class"] = "form-control";
		$this->malla->EditCustomAttributes = "";
		$this->malla->EditValue = $this->malla->CurrentValue;
		$this->malla->PlaceHolder = ew_RemoveHtml($this->malla->FldCaption());

		// sector
		$this->sector->EditAttrs["class"] = "form-control";
		$this->sector->EditCustomAttributes = "";
		$this->sector->EditValue = $this->sector->CurrentValue;
		$this->sector->PlaceHolder = ew_RemoveHtml($this->sector->FldCaption());

		// descr_estado_dem
		$this->descr_estado_dem->EditAttrs["class"] = "form-control";
		$this->descr_estado_dem->EditCustomAttributes = "";
		$this->descr_estado_dem->EditValue = $this->descr_estado_dem->CurrentValue;
		$this->descr_estado_dem->PlaceHolder = ew_RemoveHtml($this->descr_estado_dem->FldCaption());

		// estrato
		$this->estrato->EditAttrs["class"] = "form-control";
		$this->estrato->EditCustomAttributes = "";
		$this->estrato->EditValue = $this->estrato->CurrentValue;
		$this->estrato->PlaceHolder = ew_RemoveHtml($this->estrato->FldCaption());

		// clase_dem
		$this->clase_dem->EditAttrs["class"] = "form-control";
		$this->clase_dem->EditCustomAttributes = "";
		$this->clase_dem->EditValue = $this->clase_dem->CurrentValue;
		$this->clase_dem->PlaceHolder = ew_RemoveHtml($this->clase_dem->FldCaption());

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
					if ($this->origen_dem->Exportable) $Doc->ExportCaption($this->origen_dem);
					if ($this->tipo_cliente_dem->Exportable) $Doc->ExportCaption($this->tipo_cliente_dem);
					if ($this->fecha_llamada->Exportable) $Doc->ExportCaption($this->fecha_llamada);
					if ($this->cod_dem->Exportable) $Doc->ExportCaption($this->cod_dem);
					if ($this->poliza_dem->Exportable) $Doc->ExportCaption($this->poliza_dem);
					if ($this->usuario_captura->Exportable) $Doc->ExportCaption($this->usuario_captura);
					if ($this->campana_demanda->Exportable) $Doc->ExportCaption($this->campana_demanda);
					if ($this->chip_natural->Exportable) $Doc->ExportCaption($this->chip_natural);
					if ($this->estado_predio->Exportable) $Doc->ExportCaption($this->estado_predio);
					if ($this->tipo_predio->Exportable) $Doc->ExportCaption($this->tipo_predio);
					if ($this->uso->Exportable) $Doc->ExportCaption($this->uso);
					if ($this->mecado->Exportable) $Doc->ExportCaption($this->mecado);
					if ($this->nombre_cliente->Exportable) $Doc->ExportCaption($this->nombre_cliente);
					if ($this->num_doc->Exportable) $Doc->ExportCaption($this->num_doc);
					if ($this->direccion->Exportable) $Doc->ExportCaption($this->direccion);
					if ($this->municipio->Exportable) $Doc->ExportCaption($this->municipio);
					if ($this->telefono->Exportable) $Doc->ExportCaption($this->telefono);
					if ($this->cod_trabajo_original->Exportable) $Doc->ExportCaption($this->cod_trabajo_original);
					if ($this->fecha_trab_dem->Exportable) $Doc->ExportCaption($this->fecha_trab_dem);
					if ($this->cod_ult_visit->Exportable) $Doc->ExportCaption($this->cod_ult_visit);
					if ($this->res_ult_vis->Exportable) $Doc->ExportCaption($this->res_ult_vis);
					if ($this->fecha_ult_visita->Exportable) $Doc->ExportCaption($this->fecha_ult_visita);
					if ($this->usu_asig_primer_trab->Exportable) $Doc->ExportCaption($this->usu_asig_primer_trab);
					if ($this->fecha_prim_visit->Exportable) $Doc->ExportCaption($this->fecha_prim_visit);
					if ($this->respuesta_pv->Exportable) $Doc->ExportCaption($this->respuesta_pv);
					if ($this->fecha_cap_primera_visita->Exportable) $Doc->ExportCaption($this->fecha_cap_primera_visita);
					if ($this->cod_contratista->Exportable) $Doc->ExportCaption($this->cod_contratista);
					if ($this->nom_cont->Exportable) $Doc->ExportCaption($this->nom_cont);
					if ($this->distrito->Exportable) $Doc->ExportCaption($this->distrito);
					if ($this->malla->Exportable) $Doc->ExportCaption($this->malla);
					if ($this->sector->Exportable) $Doc->ExportCaption($this->sector);
					if ($this->descr_estado_dem->Exportable) $Doc->ExportCaption($this->descr_estado_dem);
					if ($this->estrato->Exportable) $Doc->ExportCaption($this->estrato);
					if ($this->clase_dem->Exportable) $Doc->ExportCaption($this->clase_dem);
				} else {
					if ($this->origen_dem->Exportable) $Doc->ExportCaption($this->origen_dem);
					if ($this->tipo_cliente_dem->Exportable) $Doc->ExportCaption($this->tipo_cliente_dem);
					if ($this->fecha_llamada->Exportable) $Doc->ExportCaption($this->fecha_llamada);
					if ($this->cod_dem->Exportable) $Doc->ExportCaption($this->cod_dem);
					if ($this->poliza_dem->Exportable) $Doc->ExportCaption($this->poliza_dem);
					if ($this->usuario_captura->Exportable) $Doc->ExportCaption($this->usuario_captura);
					if ($this->campana_demanda->Exportable) $Doc->ExportCaption($this->campana_demanda);
					if ($this->chip_natural->Exportable) $Doc->ExportCaption($this->chip_natural);
					if ($this->estado_predio->Exportable) $Doc->ExportCaption($this->estado_predio);
					if ($this->tipo_predio->Exportable) $Doc->ExportCaption($this->tipo_predio);
					if ($this->uso->Exportable) $Doc->ExportCaption($this->uso);
					if ($this->mecado->Exportable) $Doc->ExportCaption($this->mecado);
					if ($this->nombre_cliente->Exportable) $Doc->ExportCaption($this->nombre_cliente);
					if ($this->num_doc->Exportable) $Doc->ExportCaption($this->num_doc);
					if ($this->direccion->Exportable) $Doc->ExportCaption($this->direccion);
					if ($this->municipio->Exportable) $Doc->ExportCaption($this->municipio);
					if ($this->telefono->Exportable) $Doc->ExportCaption($this->telefono);
					if ($this->cod_trabajo_original->Exportable) $Doc->ExportCaption($this->cod_trabajo_original);
					if ($this->fecha_trab_dem->Exportable) $Doc->ExportCaption($this->fecha_trab_dem);
					if ($this->cod_ult_visit->Exportable) $Doc->ExportCaption($this->cod_ult_visit);
					if ($this->res_ult_vis->Exportable) $Doc->ExportCaption($this->res_ult_vis);
					if ($this->fecha_ult_visita->Exportable) $Doc->ExportCaption($this->fecha_ult_visita);
					if ($this->usu_asig_primer_trab->Exportable) $Doc->ExportCaption($this->usu_asig_primer_trab);
					if ($this->fecha_prim_visit->Exportable) $Doc->ExportCaption($this->fecha_prim_visit);
					if ($this->respuesta_pv->Exportable) $Doc->ExportCaption($this->respuesta_pv);
					if ($this->fecha_cap_primera_visita->Exportable) $Doc->ExportCaption($this->fecha_cap_primera_visita);
					if ($this->cod_contratista->Exportable) $Doc->ExportCaption($this->cod_contratista);
					if ($this->nom_cont->Exportable) $Doc->ExportCaption($this->nom_cont);
					if ($this->distrito->Exportable) $Doc->ExportCaption($this->distrito);
					if ($this->malla->Exportable) $Doc->ExportCaption($this->malla);
					if ($this->sector->Exportable) $Doc->ExportCaption($this->sector);
					if ($this->descr_estado_dem->Exportable) $Doc->ExportCaption($this->descr_estado_dem);
					if ($this->estrato->Exportable) $Doc->ExportCaption($this->estrato);
					if ($this->clase_dem->Exportable) $Doc->ExportCaption($this->clase_dem);
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
						if ($this->origen_dem->Exportable) $Doc->ExportField($this->origen_dem);
						if ($this->tipo_cliente_dem->Exportable) $Doc->ExportField($this->tipo_cliente_dem);
						if ($this->fecha_llamada->Exportable) $Doc->ExportField($this->fecha_llamada);
						if ($this->cod_dem->Exportable) $Doc->ExportField($this->cod_dem);
						if ($this->poliza_dem->Exportable) $Doc->ExportField($this->poliza_dem);
						if ($this->usuario_captura->Exportable) $Doc->ExportField($this->usuario_captura);
						if ($this->campana_demanda->Exportable) $Doc->ExportField($this->campana_demanda);
						if ($this->chip_natural->Exportable) $Doc->ExportField($this->chip_natural);
						if ($this->estado_predio->Exportable) $Doc->ExportField($this->estado_predio);
						if ($this->tipo_predio->Exportable) $Doc->ExportField($this->tipo_predio);
						if ($this->uso->Exportable) $Doc->ExportField($this->uso);
						if ($this->mecado->Exportable) $Doc->ExportField($this->mecado);
						if ($this->nombre_cliente->Exportable) $Doc->ExportField($this->nombre_cliente);
						if ($this->num_doc->Exportable) $Doc->ExportField($this->num_doc);
						if ($this->direccion->Exportable) $Doc->ExportField($this->direccion);
						if ($this->municipio->Exportable) $Doc->ExportField($this->municipio);
						if ($this->telefono->Exportable) $Doc->ExportField($this->telefono);
						if ($this->cod_trabajo_original->Exportable) $Doc->ExportField($this->cod_trabajo_original);
						if ($this->fecha_trab_dem->Exportable) $Doc->ExportField($this->fecha_trab_dem);
						if ($this->cod_ult_visit->Exportable) $Doc->ExportField($this->cod_ult_visit);
						if ($this->res_ult_vis->Exportable) $Doc->ExportField($this->res_ult_vis);
						if ($this->fecha_ult_visita->Exportable) $Doc->ExportField($this->fecha_ult_visita);
						if ($this->usu_asig_primer_trab->Exportable) $Doc->ExportField($this->usu_asig_primer_trab);
						if ($this->fecha_prim_visit->Exportable) $Doc->ExportField($this->fecha_prim_visit);
						if ($this->respuesta_pv->Exportable) $Doc->ExportField($this->respuesta_pv);
						if ($this->fecha_cap_primera_visita->Exportable) $Doc->ExportField($this->fecha_cap_primera_visita);
						if ($this->cod_contratista->Exportable) $Doc->ExportField($this->cod_contratista);
						if ($this->nom_cont->Exportable) $Doc->ExportField($this->nom_cont);
						if ($this->distrito->Exportable) $Doc->ExportField($this->distrito);
						if ($this->malla->Exportable) $Doc->ExportField($this->malla);
						if ($this->sector->Exportable) $Doc->ExportField($this->sector);
						if ($this->descr_estado_dem->Exportable) $Doc->ExportField($this->descr_estado_dem);
						if ($this->estrato->Exportable) $Doc->ExportField($this->estrato);
						if ($this->clase_dem->Exportable) $Doc->ExportField($this->clase_dem);
					} else {
						if ($this->origen_dem->Exportable) $Doc->ExportField($this->origen_dem);
						if ($this->tipo_cliente_dem->Exportable) $Doc->ExportField($this->tipo_cliente_dem);
						if ($this->fecha_llamada->Exportable) $Doc->ExportField($this->fecha_llamada);
						if ($this->cod_dem->Exportable) $Doc->ExportField($this->cod_dem);
						if ($this->poliza_dem->Exportable) $Doc->ExportField($this->poliza_dem);
						if ($this->usuario_captura->Exportable) $Doc->ExportField($this->usuario_captura);
						if ($this->campana_demanda->Exportable) $Doc->ExportField($this->campana_demanda);
						if ($this->chip_natural->Exportable) $Doc->ExportField($this->chip_natural);
						if ($this->estado_predio->Exportable) $Doc->ExportField($this->estado_predio);
						if ($this->tipo_predio->Exportable) $Doc->ExportField($this->tipo_predio);
						if ($this->uso->Exportable) $Doc->ExportField($this->uso);
						if ($this->mecado->Exportable) $Doc->ExportField($this->mecado);
						if ($this->nombre_cliente->Exportable) $Doc->ExportField($this->nombre_cliente);
						if ($this->num_doc->Exportable) $Doc->ExportField($this->num_doc);
						if ($this->direccion->Exportable) $Doc->ExportField($this->direccion);
						if ($this->municipio->Exportable) $Doc->ExportField($this->municipio);
						if ($this->telefono->Exportable) $Doc->ExportField($this->telefono);
						if ($this->cod_trabajo_original->Exportable) $Doc->ExportField($this->cod_trabajo_original);
						if ($this->fecha_trab_dem->Exportable) $Doc->ExportField($this->fecha_trab_dem);
						if ($this->cod_ult_visit->Exportable) $Doc->ExportField($this->cod_ult_visit);
						if ($this->res_ult_vis->Exportable) $Doc->ExportField($this->res_ult_vis);
						if ($this->fecha_ult_visita->Exportable) $Doc->ExportField($this->fecha_ult_visita);
						if ($this->usu_asig_primer_trab->Exportable) $Doc->ExportField($this->usu_asig_primer_trab);
						if ($this->fecha_prim_visit->Exportable) $Doc->ExportField($this->fecha_prim_visit);
						if ($this->respuesta_pv->Exportable) $Doc->ExportField($this->respuesta_pv);
						if ($this->fecha_cap_primera_visita->Exportable) $Doc->ExportField($this->fecha_cap_primera_visita);
						if ($this->cod_contratista->Exportable) $Doc->ExportField($this->cod_contratista);
						if ($this->nom_cont->Exportable) $Doc->ExportField($this->nom_cont);
						if ($this->distrito->Exportable) $Doc->ExportField($this->distrito);
						if ($this->malla->Exportable) $Doc->ExportField($this->malla);
						if ($this->sector->Exportable) $Doc->ExportField($this->sector);
						if ($this->descr_estado_dem->Exportable) $Doc->ExportField($this->descr_estado_dem);
						if ($this->estrato->Exportable) $Doc->ExportField($this->estrato);
						if ($this->clase_dem->Exportable) $Doc->ExportField($this->clase_dem);
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
