<?php

// Global variable for table object
$ap_solicitud = NULL;

//
// Table class for ap_solicitud
//
class cap_solicitud extends cTable {
	var $id_sol;
	var $poliza_sol;
	var $demanda_sol;
	var $asesor_sol;
	var $archivos_sol;
	var $asignacion_sol;
	var $comis_gas_sol;
	var $comis_obra_sol;
	var $comis_fija_sol;
	var $cedula_sol;
	var $nombre_sol;
	var $direccion_pol_sol;
	var $direccion_nueva_sol;
	var $localidad_sol;
	var $barrio_sol;
	var $telefono1_sol;
	var $telefono2_sol;
	var $celular_sol;
	var $email_sol;
	var $servicio_sol;
	var $texto_sol;
	var $registra_sol;
	var $tipo_clientegn_sol;
	var $unidad_sol;
	var $fecha_reg_sol;
	var $obs_sol;
	var $empresa_sol;
	var $estado_sol;
	var $fecha_prevista_sol;
	var $user_preventa_sol;
	var $quincena_obra_sol;
	var $fecha_obra_sol;
	var $nombre_tecnico_sol;
	var $cod_tecnico_sol;
	var $lider_obra_sol;
	var $fecha_visita_comerc_sol;
	var $obs_estado_sol;
	var $forma_pagogn_sol;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'ap_solicitud';
		$this->TableName = 'ap_solicitud';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`ap_solicitud`";
		$this->DBID = 'DB';
		$this->ExportAll = FALSE;
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

		// id_sol
		$this->id_sol = new cField('ap_solicitud', 'ap_solicitud', 'x_id_sol', 'id_sol', '`id_sol`', '`id_sol`', 3, -1, FALSE, '`id_sol`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->id_sol->Sortable = TRUE; // Allow sort
		$this->id_sol->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id_sol'] = &$this->id_sol;

		// poliza_sol
		$this->poliza_sol = new cField('ap_solicitud', 'ap_solicitud', 'x_poliza_sol', 'poliza_sol', '`poliza_sol`', '`poliza_sol`', 5, -1, FALSE, '`poliza_sol`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->poliza_sol->Sortable = TRUE; // Allow sort
		$this->poliza_sol->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['poliza_sol'] = &$this->poliza_sol;

		// demanda_sol
		$this->demanda_sol = new cField('ap_solicitud', 'ap_solicitud', 'x_demanda_sol', 'demanda_sol', '`demanda_sol`', '`demanda_sol`', 131, -1, FALSE, '`demanda_sol`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->demanda_sol->Sortable = TRUE; // Allow sort
		$this->demanda_sol->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['demanda_sol'] = &$this->demanda_sol;

		// asesor_sol
		$this->asesor_sol = new cField('ap_solicitud', 'ap_solicitud', 'x_asesor_sol', 'asesor_sol', '`asesor_sol`', '`asesor_sol`', 3, -1, FALSE, '`asesor_sol`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->asesor_sol->Sortable = TRUE; // Allow sort
		$this->asesor_sol->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->asesor_sol->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->asesor_sol->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['asesor_sol'] = &$this->asesor_sol;

		// archivos_sol
		$this->archivos_sol = new cField('ap_solicitud', 'ap_solicitud', 'x_archivos_sol', 'archivos_sol', '`archivos_sol`', '`archivos_sol`', 3, -1, FALSE, '`archivos_sol`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->archivos_sol->Sortable = FALSE; // Allow sort
		$this->archivos_sol->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['archivos_sol'] = &$this->archivos_sol;

		// asignacion_sol
		$this->asignacion_sol = new cField('ap_solicitud', 'ap_solicitud', 'x_asignacion_sol', 'asignacion_sol', '`asignacion_sol`', '`asignacion_sol`', 3, -1, FALSE, '`asignacion_sol`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->asignacion_sol->Sortable = TRUE; // Allow sort
		$this->asignacion_sol->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->asignacion_sol->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->asignacion_sol->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['asignacion_sol'] = &$this->asignacion_sol;

		// comis_gas_sol
		$this->comis_gas_sol = new cField('ap_solicitud', 'ap_solicitud', 'x_comis_gas_sol', 'comis_gas_sol', '`comis_gas_sol`', '`comis_gas_sol`', 131, -1, FALSE, '`comis_gas_sol`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->comis_gas_sol->Sortable = FALSE; // Allow sort
		$this->comis_gas_sol->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['comis_gas_sol'] = &$this->comis_gas_sol;

		// comis_obra_sol
		$this->comis_obra_sol = new cField('ap_solicitud', 'ap_solicitud', 'x_comis_obra_sol', 'comis_obra_sol', '`comis_obra_sol`', '`comis_obra_sol`', 131, -1, FALSE, '`comis_obra_sol`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->comis_obra_sol->Sortable = FALSE; // Allow sort
		$this->comis_obra_sol->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['comis_obra_sol'] = &$this->comis_obra_sol;

		// comis_fija_sol
		$this->comis_fija_sol = new cField('ap_solicitud', 'ap_solicitud', 'x_comis_fija_sol', 'comis_fija_sol', '`comis_fija_sol`', '`comis_fija_sol`', 131, -1, FALSE, '`comis_fija_sol`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->comis_fija_sol->Sortable = FALSE; // Allow sort
		$this->comis_fija_sol->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['comis_fija_sol'] = &$this->comis_fija_sol;

		// cedula_sol
		$this->cedula_sol = new cField('ap_solicitud', 'ap_solicitud', 'x_cedula_sol', 'cedula_sol', '`cedula_sol`', '`cedula_sol`', 5, -1, FALSE, '`cedula_sol`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->cedula_sol->Sortable = TRUE; // Allow sort
		$this->cedula_sol->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['cedula_sol'] = &$this->cedula_sol;

		// nombre_sol
		$this->nombre_sol = new cField('ap_solicitud', 'ap_solicitud', 'x_nombre_sol', 'nombre_sol', '`nombre_sol`', '`nombre_sol`', 200, -1, FALSE, '`nombre_sol`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nombre_sol->Sortable = TRUE; // Allow sort
		$this->fields['nombre_sol'] = &$this->nombre_sol;

		// direccion_pol_sol
		$this->direccion_pol_sol = new cField('ap_solicitud', 'ap_solicitud', 'x_direccion_pol_sol', 'direccion_pol_sol', '`direccion_pol_sol`', '`direccion_pol_sol`', 200, -1, FALSE, '`direccion_pol_sol`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->direccion_pol_sol->Sortable = TRUE; // Allow sort
		$this->fields['direccion_pol_sol'] = &$this->direccion_pol_sol;

		// direccion_nueva_sol
		$this->direccion_nueva_sol = new cField('ap_solicitud', 'ap_solicitud', 'x_direccion_nueva_sol', 'direccion_nueva_sol', '`direccion_nueva_sol`', '`direccion_nueva_sol`', 200, -1, FALSE, '`direccion_nueva_sol`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->direccion_nueva_sol->Sortable = TRUE; // Allow sort
		$this->fields['direccion_nueva_sol'] = &$this->direccion_nueva_sol;

		// localidad_sol
		$this->localidad_sol = new cField('ap_solicitud', 'ap_solicitud', 'x_localidad_sol', 'localidad_sol', '`localidad_sol`', '`localidad_sol`', 3, -1, FALSE, '`localidad_sol`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->localidad_sol->Sortable = TRUE; // Allow sort
		$this->localidad_sol->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->localidad_sol->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->localidad_sol->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['localidad_sol'] = &$this->localidad_sol;

		// barrio_sol
		$this->barrio_sol = new cField('ap_solicitud', 'ap_solicitud', 'x_barrio_sol', 'barrio_sol', '`barrio_sol`', '`barrio_sol`', 3, -1, FALSE, '`barrio_sol`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->barrio_sol->Sortable = TRUE; // Allow sort
		$this->barrio_sol->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->barrio_sol->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->barrio_sol->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['barrio_sol'] = &$this->barrio_sol;

		// telefono1_sol
		$this->telefono1_sol = new cField('ap_solicitud', 'ap_solicitud', 'x_telefono1_sol', 'telefono1_sol', '`telefono1_sol`', '`telefono1_sol`', 200, -1, FALSE, '`telefono1_sol`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->telefono1_sol->Sortable = TRUE; // Allow sort
		$this->fields['telefono1_sol'] = &$this->telefono1_sol;

		// telefono2_sol
		$this->telefono2_sol = new cField('ap_solicitud', 'ap_solicitud', 'x_telefono2_sol', 'telefono2_sol', '`telefono2_sol`', '`telefono2_sol`', 200, -1, FALSE, '`telefono2_sol`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->telefono2_sol->Sortable = TRUE; // Allow sort
		$this->fields['telefono2_sol'] = &$this->telefono2_sol;

		// celular_sol
		$this->celular_sol = new cField('ap_solicitud', 'ap_solicitud', 'x_celular_sol', 'celular_sol', '`celular_sol`', '`celular_sol`', 200, -1, FALSE, '`celular_sol`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->celular_sol->Sortable = TRUE; // Allow sort
		$this->fields['celular_sol'] = &$this->celular_sol;

		// email_sol
		$this->email_sol = new cField('ap_solicitud', 'ap_solicitud', 'x_email_sol', 'email_sol', '`email_sol`', '`email_sol`', 200, -1, FALSE, '`email_sol`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->email_sol->Sortable = FALSE; // Allow sort
		$this->fields['email_sol'] = &$this->email_sol;

		// servicio_sol
		$this->servicio_sol = new cField('ap_solicitud', 'ap_solicitud', 'x_servicio_sol', 'servicio_sol', '`servicio_sol`', '`servicio_sol`', 200, -1, FALSE, '`servicio_sol`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->servicio_sol->Sortable = TRUE; // Allow sort
		$this->fields['servicio_sol'] = &$this->servicio_sol;

		// texto_sol
		$this->texto_sol = new cField('ap_solicitud', 'ap_solicitud', 'x_texto_sol', 'texto_sol', '`texto_sol`', '`texto_sol`', 200, -1, FALSE, '`texto_sol`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->texto_sol->Sortable = FALSE; // Allow sort
		$this->fields['texto_sol'] = &$this->texto_sol;

		// registra_sol
		$this->registra_sol = new cField('ap_solicitud', 'ap_solicitud', 'x_registra_sol', 'registra_sol', '`registra_sol`', '`registra_sol`', 200, -1, FALSE, '`registra_sol`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->registra_sol->Sortable = FALSE; // Allow sort
		$this->fields['registra_sol'] = &$this->registra_sol;

		// tipo_clientegn_sol
		$this->tipo_clientegn_sol = new cField('ap_solicitud', 'ap_solicitud', 'x_tipo_clientegn_sol', 'tipo_clientegn_sol', '`tipo_clientegn_sol`', '`tipo_clientegn_sol`', 3, -1, FALSE, '`tipo_clientegn_sol`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tipo_clientegn_sol->Sortable = FALSE; // Allow sort
		$this->tipo_clientegn_sol->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['tipo_clientegn_sol'] = &$this->tipo_clientegn_sol;

		// unidad_sol
		$this->unidad_sol = new cField('ap_solicitud', 'ap_solicitud', 'x_unidad_sol', 'unidad_sol', '`unidad_sol`', '`unidad_sol`', 3, -1, FALSE, '`unidad_sol`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->unidad_sol->Sortable = FALSE; // Allow sort
		$this->unidad_sol->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['unidad_sol'] = &$this->unidad_sol;

		// fecha_reg_sol
		$this->fecha_reg_sol = new cField('ap_solicitud', 'ap_solicitud', 'x_fecha_reg_sol', 'fecha_reg_sol', '`fecha_reg_sol`', 'DATE_FORMAT(`fecha_reg_sol`, \'%Y/%m/%d\')', 135, 0, FALSE, '`fecha_reg_sol`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fecha_reg_sol->Sortable = FALSE; // Allow sort
		$this->fecha_reg_sol->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['fecha_reg_sol'] = &$this->fecha_reg_sol;

		// obs_sol
		$this->obs_sol = new cField('ap_solicitud', 'ap_solicitud', 'x_obs_sol', 'obs_sol', '`obs_sol`', '`obs_sol`', 200, -1, FALSE, '`obs_sol`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->obs_sol->Sortable = TRUE; // Allow sort
		$this->fields['obs_sol'] = &$this->obs_sol;

		// empresa_sol
		$this->empresa_sol = new cField('ap_solicitud', 'ap_solicitud', 'x_empresa_sol', 'empresa_sol', '`empresa_sol`', '`empresa_sol`', 3, -1, FALSE, '`empresa_sol`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->empresa_sol->Sortable = FALSE; // Allow sort
		$this->empresa_sol->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['empresa_sol'] = &$this->empresa_sol;

		// estado_sol
		$this->estado_sol = new cField('ap_solicitud', 'ap_solicitud', 'x_estado_sol', 'estado_sol', '`estado_sol`', '`estado_sol`', 3, -1, FALSE, '`estado_sol`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->estado_sol->Sortable = TRUE; // Allow sort
		$this->estado_sol->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->estado_sol->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->estado_sol->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['estado_sol'] = &$this->estado_sol;

		// fecha_prevista_sol
		$this->fecha_prevista_sol = new cField('ap_solicitud', 'ap_solicitud', 'x_fecha_prevista_sol', 'fecha_prevista_sol', '`fecha_prevista_sol`', 'DATE_FORMAT(`fecha_prevista_sol`, \'%Y/%m/%d\')', 135, 0, FALSE, '`fecha_prevista_sol`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fecha_prevista_sol->Sortable = TRUE; // Allow sort
		$this->fecha_prevista_sol->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['fecha_prevista_sol'] = &$this->fecha_prevista_sol;

		// user_preventa_sol
		$this->user_preventa_sol = new cField('ap_solicitud', 'ap_solicitud', 'x_user_preventa_sol', 'user_preventa_sol', '`user_preventa_sol`', '`user_preventa_sol`', 200, -1, FALSE, '`user_preventa_sol`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->user_preventa_sol->Sortable = FALSE; // Allow sort
		$this->fields['user_preventa_sol'] = &$this->user_preventa_sol;

		// quincena_obra_sol
		$this->quincena_obra_sol = new cField('ap_solicitud', 'ap_solicitud', 'x_quincena_obra_sol', 'quincena_obra_sol', '`quincena_obra_sol`', '`quincena_obra_sol`', 200, -1, FALSE, '`quincena_obra_sol`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->quincena_obra_sol->Sortable = FALSE; // Allow sort
		$this->fields['quincena_obra_sol'] = &$this->quincena_obra_sol;

		// fecha_obra_sol
		$this->fecha_obra_sol = new cField('ap_solicitud', 'ap_solicitud', 'x_fecha_obra_sol', 'fecha_obra_sol', '`fecha_obra_sol`', 'DATE_FORMAT(`fecha_obra_sol`, \'%Y/%m/%d\')', 135, 0, FALSE, '`fecha_obra_sol`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fecha_obra_sol->Sortable = TRUE; // Allow sort
		$this->fecha_obra_sol->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['fecha_obra_sol'] = &$this->fecha_obra_sol;

		// nombre_tecnico_sol
		$this->nombre_tecnico_sol = new cField('ap_solicitud', 'ap_solicitud', 'x_nombre_tecnico_sol', 'nombre_tecnico_sol', '`nombre_tecnico_sol`', '`nombre_tecnico_sol`', 200, -1, FALSE, '`nombre_tecnico_sol`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nombre_tecnico_sol->Sortable = FALSE; // Allow sort
		$this->fields['nombre_tecnico_sol'] = &$this->nombre_tecnico_sol;

		// cod_tecnico_sol
		$this->cod_tecnico_sol = new cField('ap_solicitud', 'ap_solicitud', 'x_cod_tecnico_sol', 'cod_tecnico_sol', '`cod_tecnico_sol`', '`cod_tecnico_sol`', 3, -1, FALSE, '`cod_tecnico_sol`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->cod_tecnico_sol->Sortable = FALSE; // Allow sort
		$this->cod_tecnico_sol->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['cod_tecnico_sol'] = &$this->cod_tecnico_sol;

		// lider_obra_sol
		$this->lider_obra_sol = new cField('ap_solicitud', 'ap_solicitud', 'x_lider_obra_sol', 'lider_obra_sol', '`lider_obra_sol`', '`lider_obra_sol`', 200, -1, FALSE, '`lider_obra_sol`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->lider_obra_sol->Sortable = FALSE; // Allow sort
		$this->fields['lider_obra_sol'] = &$this->lider_obra_sol;

		// fecha_visita_comerc_sol
		$this->fecha_visita_comerc_sol = new cField('ap_solicitud', 'ap_solicitud', 'x_fecha_visita_comerc_sol', 'fecha_visita_comerc_sol', '`fecha_visita_comerc_sol`', 'DATE_FORMAT(`fecha_visita_comerc_sol`, \'%Y/%m/%d\')', 135, 0, FALSE, '`fecha_visita_comerc_sol`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fecha_visita_comerc_sol->Sortable = TRUE; // Allow sort
		$this->fecha_visita_comerc_sol->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['fecha_visita_comerc_sol'] = &$this->fecha_visita_comerc_sol;

		// obs_estado_sol
		$this->obs_estado_sol = new cField('ap_solicitud', 'ap_solicitud', 'x_obs_estado_sol', 'obs_estado_sol', '`obs_estado_sol`', '`obs_estado_sol`', 200, -1, FALSE, '`obs_estado_sol`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->obs_estado_sol->Sortable = TRUE; // Allow sort
		$this->fields['obs_estado_sol'] = &$this->obs_estado_sol;

		// forma_pagogn_sol
		$this->forma_pagogn_sol = new cField('ap_solicitud', 'ap_solicitud', 'x_forma_pagogn_sol', 'forma_pagogn_sol', '`forma_pagogn_sol`', '`forma_pagogn_sol`', 3, -1, FALSE, '`forma_pagogn_sol`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->forma_pagogn_sol->Sortable = FALSE; // Allow sort
		$this->forma_pagogn_sol->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['forma_pagogn_sol'] = &$this->forma_pagogn_sol;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`ap_solicitud`";
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
			if (array_key_exists('id_sol', $rs))
				ew_AddFilter($where, ew_QuotedName('id_sol', $this->DBID) . '=' . ew_QuotedValue($rs['id_sol'], $this->id_sol->FldDataType, $this->DBID));
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
		return "`id_sol` = @id_sol@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->id_sol->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@id_sol@", ew_AdjustSql($this->id_sol->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "ap_solicitudlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "ap_solicitudlist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("ap_solicitudview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("ap_solicitudview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "ap_solicitudadd.php?" . $this->UrlParm($parm);
		else
			$url = "ap_solicitudadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("ap_solicitudedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("ap_solicitudadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("ap_solicituddelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "id_sol:" . ew_VarToJson($this->id_sol->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->id_sol->CurrentValue)) {
			$sUrl .= "id_sol=" . urlencode($this->id_sol->CurrentValue);
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
			if ($isPost && isset($_POST["id_sol"]))
				$arKeys[] = ew_StripSlashes($_POST["id_sol"]);
			elseif (isset($_GET["id_sol"]))
				$arKeys[] = ew_StripSlashes($_GET["id_sol"]);
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
			$this->id_sol->CurrentValue = $key;
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
		$this->id_sol->setDbValue($rs->fields('id_sol'));
		$this->poliza_sol->setDbValue($rs->fields('poliza_sol'));
		$this->demanda_sol->setDbValue($rs->fields('demanda_sol'));
		$this->asesor_sol->setDbValue($rs->fields('asesor_sol'));
		$this->archivos_sol->setDbValue($rs->fields('archivos_sol'));
		$this->asignacion_sol->setDbValue($rs->fields('asignacion_sol'));
		$this->comis_gas_sol->setDbValue($rs->fields('comis_gas_sol'));
		$this->comis_obra_sol->setDbValue($rs->fields('comis_obra_sol'));
		$this->comis_fija_sol->setDbValue($rs->fields('comis_fija_sol'));
		$this->cedula_sol->setDbValue($rs->fields('cedula_sol'));
		$this->nombre_sol->setDbValue($rs->fields('nombre_sol'));
		$this->direccion_pol_sol->setDbValue($rs->fields('direccion_pol_sol'));
		$this->direccion_nueva_sol->setDbValue($rs->fields('direccion_nueva_sol'));
		$this->localidad_sol->setDbValue($rs->fields('localidad_sol'));
		$this->barrio_sol->setDbValue($rs->fields('barrio_sol'));
		$this->telefono1_sol->setDbValue($rs->fields('telefono1_sol'));
		$this->telefono2_sol->setDbValue($rs->fields('telefono2_sol'));
		$this->celular_sol->setDbValue($rs->fields('celular_sol'));
		$this->email_sol->setDbValue($rs->fields('email_sol'));
		$this->servicio_sol->setDbValue($rs->fields('servicio_sol'));
		$this->texto_sol->setDbValue($rs->fields('texto_sol'));
		$this->registra_sol->setDbValue($rs->fields('registra_sol'));
		$this->tipo_clientegn_sol->setDbValue($rs->fields('tipo_clientegn_sol'));
		$this->unidad_sol->setDbValue($rs->fields('unidad_sol'));
		$this->fecha_reg_sol->setDbValue($rs->fields('fecha_reg_sol'));
		$this->obs_sol->setDbValue($rs->fields('obs_sol'));
		$this->empresa_sol->setDbValue($rs->fields('empresa_sol'));
		$this->estado_sol->setDbValue($rs->fields('estado_sol'));
		$this->fecha_prevista_sol->setDbValue($rs->fields('fecha_prevista_sol'));
		$this->user_preventa_sol->setDbValue($rs->fields('user_preventa_sol'));
		$this->quincena_obra_sol->setDbValue($rs->fields('quincena_obra_sol'));
		$this->fecha_obra_sol->setDbValue($rs->fields('fecha_obra_sol'));
		$this->nombre_tecnico_sol->setDbValue($rs->fields('nombre_tecnico_sol'));
		$this->cod_tecnico_sol->setDbValue($rs->fields('cod_tecnico_sol'));
		$this->lider_obra_sol->setDbValue($rs->fields('lider_obra_sol'));
		$this->fecha_visita_comerc_sol->setDbValue($rs->fields('fecha_visita_comerc_sol'));
		$this->obs_estado_sol->setDbValue($rs->fields('obs_estado_sol'));
		$this->forma_pagogn_sol->setDbValue($rs->fields('forma_pagogn_sol'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// id_sol
		// poliza_sol
		// demanda_sol
		// asesor_sol
		// archivos_sol
		// asignacion_sol
		// comis_gas_sol
		// comis_obra_sol
		// comis_fija_sol
		// cedula_sol
		// nombre_sol
		// direccion_pol_sol
		// direccion_nueva_sol
		// localidad_sol
		// barrio_sol
		// telefono1_sol
		// telefono2_sol
		// celular_sol
		// email_sol
		// servicio_sol
		// texto_sol
		// registra_sol
		// tipo_clientegn_sol
		// unidad_sol
		// fecha_reg_sol
		// obs_sol
		// empresa_sol
		// estado_sol
		// fecha_prevista_sol
		// user_preventa_sol
		// quincena_obra_sol
		// fecha_obra_sol
		// nombre_tecnico_sol
		// cod_tecnico_sol
		// lider_obra_sol
		// fecha_visita_comerc_sol
		// obs_estado_sol
		// forma_pagogn_sol
		// id_sol

		$this->id_sol->ViewValue = $this->id_sol->CurrentValue;
		$this->id_sol->ViewCustomAttributes = "";

		// poliza_sol
		$this->poliza_sol->ViewValue = $this->poliza_sol->CurrentValue;
		$this->poliza_sol->ViewCustomAttributes = "";

		// demanda_sol
		$this->demanda_sol->ViewValue = $this->demanda_sol->CurrentValue;
		$this->demanda_sol->ViewCustomAttributes = "";

		// asesor_sol
		if (strval($this->asesor_sol->CurrentValue) <> "") {
			$sFilterWrk = "`Id_tercero`" . ew_SearchString("=", $this->asesor_sol->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_tercero`, `nombre_tercero` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ap_terceros`";
		$sWhereWrk = "";
		$this->asesor_sol->LookupFilters = array();
		$lookuptblfilter = "`tipo_tercero`=4";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->asesor_sol, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `nombre_tercero` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->asesor_sol->ViewValue = $this->asesor_sol->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->asesor_sol->ViewValue = $this->asesor_sol->CurrentValue;
			}
		} else {
			$this->asesor_sol->ViewValue = NULL;
		}
		$this->asesor_sol->ViewCustomAttributes = "";

		// archivos_sol
		$this->archivos_sol->ViewValue = $this->archivos_sol->CurrentValue;
		$this->archivos_sol->ViewCustomAttributes = "";

		// asignacion_sol
		if (strval($this->asignacion_sol->CurrentValue) <> "") {
			$sFilterWrk = "`id_asignacion`" . ew_SearchString("=", $this->asignacion_sol->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id_asignacion`, `tipo_asignacion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ap_asignacion`";
		$sWhereWrk = "";
		$this->asignacion_sol->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->asignacion_sol, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `tipo_asignacion` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->asignacion_sol->ViewValue = $this->asignacion_sol->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->asignacion_sol->ViewValue = $this->asignacion_sol->CurrentValue;
			}
		} else {
			$this->asignacion_sol->ViewValue = NULL;
		}
		$this->asignacion_sol->ViewCustomAttributes = "";

		// comis_gas_sol
		$this->comis_gas_sol->ViewValue = $this->comis_gas_sol->CurrentValue;
		$this->comis_gas_sol->ViewCustomAttributes = "";

		// comis_obra_sol
		$this->comis_obra_sol->ViewValue = $this->comis_obra_sol->CurrentValue;
		$this->comis_obra_sol->ViewCustomAttributes = "";

		// comis_fija_sol
		$this->comis_fija_sol->ViewValue = $this->comis_fija_sol->CurrentValue;
		$this->comis_fija_sol->ViewCustomAttributes = "";

		// cedula_sol
		$this->cedula_sol->ViewValue = $this->cedula_sol->CurrentValue;
		$this->cedula_sol->ViewCustomAttributes = "";

		// nombre_sol
		$this->nombre_sol->ViewValue = $this->nombre_sol->CurrentValue;
		$this->nombre_sol->ViewCustomAttributes = "";

		// direccion_pol_sol
		$this->direccion_pol_sol->ViewValue = $this->direccion_pol_sol->CurrentValue;
		$this->direccion_pol_sol->ViewCustomAttributes = "";

		// direccion_nueva_sol
		$this->direccion_nueva_sol->ViewValue = $this->direccion_nueva_sol->CurrentValue;
		$this->direccion_nueva_sol->ViewCustomAttributes = "";

		// localidad_sol
		if (strval($this->localidad_sol->CurrentValue) <> "") {
			$sFilterWrk = "`id_loc`" . ew_SearchString("=", $this->localidad_sol->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id_loc`, `nombre_loc` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `siax_localidad`";
		$sWhereWrk = "";
		$this->localidad_sol->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->localidad_sol, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `nombre_loc` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->localidad_sol->ViewValue = $this->localidad_sol->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->localidad_sol->ViewValue = $this->localidad_sol->CurrentValue;
			}
		} else {
			$this->localidad_sol->ViewValue = NULL;
		}
		$this->localidad_sol->ViewCustomAttributes = "";

		// barrio_sol
		if (strval($this->barrio_sol->CurrentValue) <> "") {
			$sFilterWrk = "`cod_sec`" . ew_SearchString("=", $this->barrio_sol->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `cod_sec`, `nombre_sec` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `siax_sectores`";
		$sWhereWrk = "";
		$this->barrio_sol->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->barrio_sol, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `nombre_sec` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->barrio_sol->ViewValue = $this->barrio_sol->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->barrio_sol->ViewValue = $this->barrio_sol->CurrentValue;
			}
		} else {
			$this->barrio_sol->ViewValue = NULL;
		}
		$this->barrio_sol->ViewCustomAttributes = "";

		// telefono1_sol
		$this->telefono1_sol->ViewValue = $this->telefono1_sol->CurrentValue;
		$this->telefono1_sol->ViewCustomAttributes = "";

		// telefono2_sol
		$this->telefono2_sol->ViewValue = $this->telefono2_sol->CurrentValue;
		$this->telefono2_sol->ViewCustomAttributes = "";

		// celular_sol
		$this->celular_sol->ViewValue = $this->celular_sol->CurrentValue;
		$this->celular_sol->ViewCustomAttributes = "";

		// email_sol
		$this->email_sol->ViewValue = $this->email_sol->CurrentValue;
		$this->email_sol->ViewCustomAttributes = "";

		// servicio_sol
		$this->servicio_sol->ViewValue = $this->servicio_sol->CurrentValue;
		$this->servicio_sol->ViewCustomAttributes = "";

		// texto_sol
		$this->texto_sol->ViewValue = $this->texto_sol->CurrentValue;
		$this->texto_sol->ViewCustomAttributes = "";

		// registra_sol
		$this->registra_sol->ViewValue = $this->registra_sol->CurrentValue;
		$this->registra_sol->ViewCustomAttributes = "";

		// tipo_clientegn_sol
		$this->tipo_clientegn_sol->ViewValue = $this->tipo_clientegn_sol->CurrentValue;
		$this->tipo_clientegn_sol->ViewCustomAttributes = "";

		// unidad_sol
		$this->unidad_sol->ViewValue = $this->unidad_sol->CurrentValue;
		$this->unidad_sol->ViewCustomAttributes = "";

		// fecha_reg_sol
		$this->fecha_reg_sol->ViewValue = $this->fecha_reg_sol->CurrentValue;
		$this->fecha_reg_sol->ViewValue = ew_FormatDateTime($this->fecha_reg_sol->ViewValue, 0);
		$this->fecha_reg_sol->ViewCustomAttributes = "";

		// obs_sol
		$this->obs_sol->ViewValue = $this->obs_sol->CurrentValue;
		$this->obs_sol->ViewCustomAttributes = "";

		// empresa_sol
		$this->empresa_sol->ViewValue = $this->empresa_sol->CurrentValue;
		$this->empresa_sol->ViewCustomAttributes = "";

		// estado_sol
		if (strval($this->estado_sol->CurrentValue) <> "") {
			$sFilterWrk = "`id_estado_preventa`" . ew_SearchString("=", $this->estado_sol->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id_estado_preventa`, `nombre_estado_preventa` AS `DispFld`, `detalle_estado_preventa` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ap_estado_preventa`";
		$sWhereWrk = "";
		$this->estado_sol->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->estado_sol, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `nombre_estado_preventa` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->estado_sol->ViewValue = $this->estado_sol->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->estado_sol->ViewValue = $this->estado_sol->CurrentValue;
			}
		} else {
			$this->estado_sol->ViewValue = NULL;
		}
		$this->estado_sol->ViewCustomAttributes = "";

		// fecha_prevista_sol
		$this->fecha_prevista_sol->ViewValue = $this->fecha_prevista_sol->CurrentValue;
		$this->fecha_prevista_sol->ViewValue = ew_FormatDateTime($this->fecha_prevista_sol->ViewValue, 0);
		$this->fecha_prevista_sol->ViewCustomAttributes = "";

		// user_preventa_sol
		$this->user_preventa_sol->ViewValue = $this->user_preventa_sol->CurrentValue;
		$this->user_preventa_sol->ViewCustomAttributes = "";

		// quincena_obra_sol
		$this->quincena_obra_sol->ViewValue = $this->quincena_obra_sol->CurrentValue;
		$this->quincena_obra_sol->ViewCustomAttributes = "";

		// fecha_obra_sol
		$this->fecha_obra_sol->ViewValue = $this->fecha_obra_sol->CurrentValue;
		$this->fecha_obra_sol->ViewValue = ew_FormatDateTime($this->fecha_obra_sol->ViewValue, 0);
		$this->fecha_obra_sol->ViewCustomAttributes = "";

		// nombre_tecnico_sol
		$this->nombre_tecnico_sol->ViewValue = $this->nombre_tecnico_sol->CurrentValue;
		$this->nombre_tecnico_sol->ViewCustomAttributes = "";

		// cod_tecnico_sol
		$this->cod_tecnico_sol->ViewValue = $this->cod_tecnico_sol->CurrentValue;
		$this->cod_tecnico_sol->ViewCustomAttributes = "";

		// lider_obra_sol
		$this->lider_obra_sol->ViewValue = $this->lider_obra_sol->CurrentValue;
		$this->lider_obra_sol->ViewCustomAttributes = "";

		// fecha_visita_comerc_sol
		$this->fecha_visita_comerc_sol->ViewValue = $this->fecha_visita_comerc_sol->CurrentValue;
		$this->fecha_visita_comerc_sol->ViewValue = ew_FormatDateTime($this->fecha_visita_comerc_sol->ViewValue, 0);
		$this->fecha_visita_comerc_sol->ViewCustomAttributes = "";

		// obs_estado_sol
		$this->obs_estado_sol->ViewValue = $this->obs_estado_sol->CurrentValue;
		$this->obs_estado_sol->ViewCustomAttributes = "";

		// forma_pagogn_sol
		$this->forma_pagogn_sol->ViewValue = $this->forma_pagogn_sol->CurrentValue;
		$this->forma_pagogn_sol->ViewCustomAttributes = "";

		// id_sol
		$this->id_sol->LinkCustomAttributes = "";
		$this->id_sol->HrefValue = "";
		$this->id_sol->TooltipValue = "";

		// poliza_sol
		$this->poliza_sol->LinkCustomAttributes = "";
		$this->poliza_sol->HrefValue = "";
		$this->poliza_sol->TooltipValue = "";

		// demanda_sol
		$this->demanda_sol->LinkCustomAttributes = "";
		$this->demanda_sol->HrefValue = "";
		$this->demanda_sol->TooltipValue = "";

		// asesor_sol
		$this->asesor_sol->LinkCustomAttributes = "";
		$this->asesor_sol->HrefValue = "";
		$this->asesor_sol->TooltipValue = "";

		// archivos_sol
		$this->archivos_sol->LinkCustomAttributes = "";
		$this->archivos_sol->HrefValue = "";
		$this->archivos_sol->TooltipValue = "";

		// asignacion_sol
		$this->asignacion_sol->LinkCustomAttributes = "";
		$this->asignacion_sol->HrefValue = "";
		$this->asignacion_sol->TooltipValue = "";

		// comis_gas_sol
		$this->comis_gas_sol->LinkCustomAttributes = "";
		$this->comis_gas_sol->HrefValue = "";
		$this->comis_gas_sol->TooltipValue = "";

		// comis_obra_sol
		$this->comis_obra_sol->LinkCustomAttributes = "";
		$this->comis_obra_sol->HrefValue = "";
		$this->comis_obra_sol->TooltipValue = "";

		// comis_fija_sol
		$this->comis_fija_sol->LinkCustomAttributes = "";
		$this->comis_fija_sol->HrefValue = "";
		$this->comis_fija_sol->TooltipValue = "";

		// cedula_sol
		$this->cedula_sol->LinkCustomAttributes = "";
		$this->cedula_sol->HrefValue = "";
		$this->cedula_sol->TooltipValue = "";

		// nombre_sol
		$this->nombre_sol->LinkCustomAttributes = "";
		$this->nombre_sol->HrefValue = "";
		$this->nombre_sol->TooltipValue = "";

		// direccion_pol_sol
		$this->direccion_pol_sol->LinkCustomAttributes = "";
		$this->direccion_pol_sol->HrefValue = "";
		$this->direccion_pol_sol->TooltipValue = "";

		// direccion_nueva_sol
		$this->direccion_nueva_sol->LinkCustomAttributes = "";
		$this->direccion_nueva_sol->HrefValue = "";
		$this->direccion_nueva_sol->TooltipValue = "";

		// localidad_sol
		$this->localidad_sol->LinkCustomAttributes = "";
		$this->localidad_sol->HrefValue = "";
		$this->localidad_sol->TooltipValue = "";

		// barrio_sol
		$this->barrio_sol->LinkCustomAttributes = "";
		$this->barrio_sol->HrefValue = "";
		$this->barrio_sol->TooltipValue = "";

		// telefono1_sol
		$this->telefono1_sol->LinkCustomAttributes = "";
		$this->telefono1_sol->HrefValue = "";
		$this->telefono1_sol->TooltipValue = "";

		// telefono2_sol
		$this->telefono2_sol->LinkCustomAttributes = "";
		$this->telefono2_sol->HrefValue = "";
		$this->telefono2_sol->TooltipValue = "";

		// celular_sol
		$this->celular_sol->LinkCustomAttributes = "";
		$this->celular_sol->HrefValue = "";
		$this->celular_sol->TooltipValue = "";

		// email_sol
		$this->email_sol->LinkCustomAttributes = "";
		$this->email_sol->HrefValue = "";
		$this->email_sol->TooltipValue = "";

		// servicio_sol
		$this->servicio_sol->LinkCustomAttributes = "";
		$this->servicio_sol->HrefValue = "";
		$this->servicio_sol->TooltipValue = "";

		// texto_sol
		$this->texto_sol->LinkCustomAttributes = "";
		$this->texto_sol->HrefValue = "";
		$this->texto_sol->TooltipValue = "";

		// registra_sol
		$this->registra_sol->LinkCustomAttributes = "";
		$this->registra_sol->HrefValue = "";
		$this->registra_sol->TooltipValue = "";

		// tipo_clientegn_sol
		$this->tipo_clientegn_sol->LinkCustomAttributes = "";
		$this->tipo_clientegn_sol->HrefValue = "";
		$this->tipo_clientegn_sol->TooltipValue = "";

		// unidad_sol
		$this->unidad_sol->LinkCustomAttributes = "";
		$this->unidad_sol->HrefValue = "";
		$this->unidad_sol->TooltipValue = "";

		// fecha_reg_sol
		$this->fecha_reg_sol->LinkCustomAttributes = "";
		$this->fecha_reg_sol->HrefValue = "";
		$this->fecha_reg_sol->TooltipValue = "";

		// obs_sol
		$this->obs_sol->LinkCustomAttributes = "";
		$this->obs_sol->HrefValue = "";
		$this->obs_sol->TooltipValue = "";

		// empresa_sol
		$this->empresa_sol->LinkCustomAttributes = "";
		$this->empresa_sol->HrefValue = "";
		$this->empresa_sol->TooltipValue = "";

		// estado_sol
		$this->estado_sol->LinkCustomAttributes = "";
		$this->estado_sol->HrefValue = "";
		$this->estado_sol->TooltipValue = "";

		// fecha_prevista_sol
		$this->fecha_prevista_sol->LinkCustomAttributes = "";
		$this->fecha_prevista_sol->HrefValue = "";
		$this->fecha_prevista_sol->TooltipValue = "";

		// user_preventa_sol
		$this->user_preventa_sol->LinkCustomAttributes = "";
		$this->user_preventa_sol->HrefValue = "";
		$this->user_preventa_sol->TooltipValue = "";

		// quincena_obra_sol
		$this->quincena_obra_sol->LinkCustomAttributes = "";
		$this->quincena_obra_sol->HrefValue = "";
		$this->quincena_obra_sol->TooltipValue = "";

		// fecha_obra_sol
		$this->fecha_obra_sol->LinkCustomAttributes = "";
		$this->fecha_obra_sol->HrefValue = "";
		$this->fecha_obra_sol->TooltipValue = "";

		// nombre_tecnico_sol
		$this->nombre_tecnico_sol->LinkCustomAttributes = "";
		$this->nombre_tecnico_sol->HrefValue = "";
		$this->nombre_tecnico_sol->TooltipValue = "";

		// cod_tecnico_sol
		$this->cod_tecnico_sol->LinkCustomAttributes = "";
		$this->cod_tecnico_sol->HrefValue = "";
		$this->cod_tecnico_sol->TooltipValue = "";

		// lider_obra_sol
		$this->lider_obra_sol->LinkCustomAttributes = "";
		$this->lider_obra_sol->HrefValue = "";
		$this->lider_obra_sol->TooltipValue = "";

		// fecha_visita_comerc_sol
		$this->fecha_visita_comerc_sol->LinkCustomAttributes = "";
		$this->fecha_visita_comerc_sol->HrefValue = "";
		$this->fecha_visita_comerc_sol->TooltipValue = "";

		// obs_estado_sol
		$this->obs_estado_sol->LinkCustomAttributes = "";
		$this->obs_estado_sol->HrefValue = "";
		$this->obs_estado_sol->TooltipValue = "";

		// forma_pagogn_sol
		$this->forma_pagogn_sol->LinkCustomAttributes = "";
		$this->forma_pagogn_sol->HrefValue = "";
		$this->forma_pagogn_sol->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// id_sol
		$this->id_sol->EditAttrs["class"] = "form-control";
		$this->id_sol->EditCustomAttributes = "";
		$this->id_sol->EditValue = $this->id_sol->CurrentValue;
		$this->id_sol->ViewCustomAttributes = "";

		// poliza_sol
		$this->poliza_sol->EditAttrs["class"] = "form-control";
		$this->poliza_sol->EditCustomAttributes = "";
		$this->poliza_sol->EditValue = $this->poliza_sol->CurrentValue;
		$this->poliza_sol->PlaceHolder = ew_RemoveHtml($this->poliza_sol->FldCaption());
		if (strval($this->poliza_sol->EditValue) <> "" && is_numeric($this->poliza_sol->EditValue)) $this->poliza_sol->EditValue = ew_FormatNumber($this->poliza_sol->EditValue, -2, -1, -2, 0);

		// demanda_sol
		$this->demanda_sol->EditAttrs["class"] = "form-control";
		$this->demanda_sol->EditCustomAttributes = "";
		$this->demanda_sol->EditValue = $this->demanda_sol->CurrentValue;
		$this->demanda_sol->PlaceHolder = ew_RemoveHtml($this->demanda_sol->FldCaption());
		if (strval($this->demanda_sol->EditValue) <> "" && is_numeric($this->demanda_sol->EditValue)) $this->demanda_sol->EditValue = ew_FormatNumber($this->demanda_sol->EditValue, -2, -1, -2, 0);

		// asesor_sol
		$this->asesor_sol->EditAttrs["class"] = "form-control";
		$this->asesor_sol->EditCustomAttributes = "";

		// archivos_sol
		$this->archivos_sol->EditAttrs["class"] = "form-control";
		$this->archivos_sol->EditCustomAttributes = "";
		$this->archivos_sol->EditValue = $this->archivos_sol->CurrentValue;
		$this->archivos_sol->PlaceHolder = ew_RemoveHtml($this->archivos_sol->FldCaption());

		// asignacion_sol
		$this->asignacion_sol->EditAttrs["class"] = "form-control";
		$this->asignacion_sol->EditCustomAttributes = "";

		// comis_gas_sol
		$this->comis_gas_sol->EditAttrs["class"] = "form-control";
		$this->comis_gas_sol->EditCustomAttributes = "";
		$this->comis_gas_sol->EditValue = $this->comis_gas_sol->CurrentValue;
		$this->comis_gas_sol->PlaceHolder = ew_RemoveHtml($this->comis_gas_sol->FldCaption());
		if (strval($this->comis_gas_sol->EditValue) <> "" && is_numeric($this->comis_gas_sol->EditValue)) $this->comis_gas_sol->EditValue = ew_FormatNumber($this->comis_gas_sol->EditValue, -2, -1, -2, 0);

		// comis_obra_sol
		$this->comis_obra_sol->EditAttrs["class"] = "form-control";
		$this->comis_obra_sol->EditCustomAttributes = "";
		$this->comis_obra_sol->EditValue = $this->comis_obra_sol->CurrentValue;
		$this->comis_obra_sol->PlaceHolder = ew_RemoveHtml($this->comis_obra_sol->FldCaption());
		if (strval($this->comis_obra_sol->EditValue) <> "" && is_numeric($this->comis_obra_sol->EditValue)) $this->comis_obra_sol->EditValue = ew_FormatNumber($this->comis_obra_sol->EditValue, -2, -1, -2, 0);

		// comis_fija_sol
		$this->comis_fija_sol->EditAttrs["class"] = "form-control";
		$this->comis_fija_sol->EditCustomAttributes = "";
		$this->comis_fija_sol->EditValue = $this->comis_fija_sol->CurrentValue;
		$this->comis_fija_sol->PlaceHolder = ew_RemoveHtml($this->comis_fija_sol->FldCaption());
		if (strval($this->comis_fija_sol->EditValue) <> "" && is_numeric($this->comis_fija_sol->EditValue)) $this->comis_fija_sol->EditValue = ew_FormatNumber($this->comis_fija_sol->EditValue, -2, -1, -2, 0);

		// cedula_sol
		$this->cedula_sol->EditAttrs["class"] = "form-control";
		$this->cedula_sol->EditCustomAttributes = "";
		$this->cedula_sol->EditValue = $this->cedula_sol->CurrentValue;
		$this->cedula_sol->PlaceHolder = ew_RemoveHtml($this->cedula_sol->FldCaption());
		if (strval($this->cedula_sol->EditValue) <> "" && is_numeric($this->cedula_sol->EditValue)) $this->cedula_sol->EditValue = ew_FormatNumber($this->cedula_sol->EditValue, -2, -1, -2, 0);

		// nombre_sol
		$this->nombre_sol->EditAttrs["class"] = "form-control";
		$this->nombre_sol->EditCustomAttributes = "";
		$this->nombre_sol->EditValue = $this->nombre_sol->CurrentValue;
		$this->nombre_sol->PlaceHolder = ew_RemoveHtml($this->nombre_sol->FldCaption());

		// direccion_pol_sol
		$this->direccion_pol_sol->EditAttrs["class"] = "form-control";
		$this->direccion_pol_sol->EditCustomAttributes = "";
		$this->direccion_pol_sol->EditValue = $this->direccion_pol_sol->CurrentValue;
		$this->direccion_pol_sol->PlaceHolder = ew_RemoveHtml($this->direccion_pol_sol->FldCaption());

		// direccion_nueva_sol
		$this->direccion_nueva_sol->EditAttrs["class"] = "form-control";
		$this->direccion_nueva_sol->EditCustomAttributes = "";
		$this->direccion_nueva_sol->EditValue = $this->direccion_nueva_sol->CurrentValue;
		$this->direccion_nueva_sol->PlaceHolder = ew_RemoveHtml($this->direccion_nueva_sol->FldCaption());

		// localidad_sol
		$this->localidad_sol->EditAttrs["class"] = "form-control";
		$this->localidad_sol->EditCustomAttributes = "";

		// barrio_sol
		$this->barrio_sol->EditAttrs["class"] = "form-control";
		$this->barrio_sol->EditCustomAttributes = "";

		// telefono1_sol
		$this->telefono1_sol->EditAttrs["class"] = "form-control";
		$this->telefono1_sol->EditCustomAttributes = "";
		$this->telefono1_sol->EditValue = $this->telefono1_sol->CurrentValue;
		$this->telefono1_sol->PlaceHolder = ew_RemoveHtml($this->telefono1_sol->FldCaption());

		// telefono2_sol
		$this->telefono2_sol->EditAttrs["class"] = "form-control";
		$this->telefono2_sol->EditCustomAttributes = "";
		$this->telefono2_sol->EditValue = $this->telefono2_sol->CurrentValue;
		$this->telefono2_sol->PlaceHolder = ew_RemoveHtml($this->telefono2_sol->FldCaption());

		// celular_sol
		$this->celular_sol->EditAttrs["class"] = "form-control";
		$this->celular_sol->EditCustomAttributes = "";
		$this->celular_sol->EditValue = $this->celular_sol->CurrentValue;
		$this->celular_sol->PlaceHolder = ew_RemoveHtml($this->celular_sol->FldCaption());

		// email_sol
		$this->email_sol->EditAttrs["class"] = "form-control";
		$this->email_sol->EditCustomAttributes = "";
		$this->email_sol->EditValue = $this->email_sol->CurrentValue;
		$this->email_sol->PlaceHolder = ew_RemoveHtml($this->email_sol->FldCaption());

		// servicio_sol
		$this->servicio_sol->EditAttrs["class"] = "form-control";
		$this->servicio_sol->EditCustomAttributes = "";
		$this->servicio_sol->EditValue = $this->servicio_sol->CurrentValue;
		$this->servicio_sol->PlaceHolder = ew_RemoveHtml($this->servicio_sol->FldCaption());

		// texto_sol
		$this->texto_sol->EditAttrs["class"] = "form-control";
		$this->texto_sol->EditCustomAttributes = "";
		$this->texto_sol->EditValue = $this->texto_sol->CurrentValue;
		$this->texto_sol->PlaceHolder = ew_RemoveHtml($this->texto_sol->FldCaption());

		// registra_sol
		$this->registra_sol->EditAttrs["class"] = "form-control";
		$this->registra_sol->EditCustomAttributes = "";
		$this->registra_sol->EditValue = $this->registra_sol->CurrentValue;
		$this->registra_sol->PlaceHolder = ew_RemoveHtml($this->registra_sol->FldCaption());

		// tipo_clientegn_sol
		$this->tipo_clientegn_sol->EditAttrs["class"] = "form-control";
		$this->tipo_clientegn_sol->EditCustomAttributes = "";
		$this->tipo_clientegn_sol->EditValue = $this->tipo_clientegn_sol->CurrentValue;
		$this->tipo_clientegn_sol->PlaceHolder = ew_RemoveHtml($this->tipo_clientegn_sol->FldCaption());

		// unidad_sol
		$this->unidad_sol->EditAttrs["class"] = "form-control";
		$this->unidad_sol->EditCustomAttributes = "";
		$this->unidad_sol->EditValue = $this->unidad_sol->CurrentValue;
		$this->unidad_sol->PlaceHolder = ew_RemoveHtml($this->unidad_sol->FldCaption());

		// fecha_reg_sol
		$this->fecha_reg_sol->EditAttrs["class"] = "form-control";
		$this->fecha_reg_sol->EditCustomAttributes = "";
		$this->fecha_reg_sol->EditValue = ew_FormatDateTime($this->fecha_reg_sol->CurrentValue, 8);
		$this->fecha_reg_sol->PlaceHolder = ew_RemoveHtml($this->fecha_reg_sol->FldCaption());

		// obs_sol
		$this->obs_sol->EditAttrs["class"] = "form-control";
		$this->obs_sol->EditCustomAttributes = "";
		$this->obs_sol->EditValue = $this->obs_sol->CurrentValue;
		$this->obs_sol->PlaceHolder = ew_RemoveHtml($this->obs_sol->FldCaption());

		// empresa_sol
		$this->empresa_sol->EditAttrs["class"] = "form-control";
		$this->empresa_sol->EditCustomAttributes = "";
		$this->empresa_sol->EditValue = $this->empresa_sol->CurrentValue;
		$this->empresa_sol->PlaceHolder = ew_RemoveHtml($this->empresa_sol->FldCaption());

		// estado_sol
		$this->estado_sol->EditAttrs["class"] = "form-control";
		$this->estado_sol->EditCustomAttributes = "";

		// fecha_prevista_sol
		$this->fecha_prevista_sol->EditAttrs["class"] = "form-control";
		$this->fecha_prevista_sol->EditCustomAttributes = "";
		$this->fecha_prevista_sol->EditValue = $this->fecha_prevista_sol->CurrentValue;
		$this->fecha_prevista_sol->EditValue = ew_FormatDateTime($this->fecha_prevista_sol->EditValue, 0);
		$this->fecha_prevista_sol->ViewCustomAttributes = "";

		// user_preventa_sol
		$this->user_preventa_sol->EditAttrs["class"] = "form-control";
		$this->user_preventa_sol->EditCustomAttributes = "";
		$this->user_preventa_sol->EditValue = $this->user_preventa_sol->CurrentValue;
		$this->user_preventa_sol->PlaceHolder = ew_RemoveHtml($this->user_preventa_sol->FldCaption());

		// quincena_obra_sol
		$this->quincena_obra_sol->EditAttrs["class"] = "form-control";
		$this->quincena_obra_sol->EditCustomAttributes = "";
		$this->quincena_obra_sol->EditValue = $this->quincena_obra_sol->CurrentValue;
		$this->quincena_obra_sol->PlaceHolder = ew_RemoveHtml($this->quincena_obra_sol->FldCaption());

		// fecha_obra_sol
		$this->fecha_obra_sol->EditAttrs["class"] = "form-control";
		$this->fecha_obra_sol->EditCustomAttributes = "";
		$this->fecha_obra_sol->EditValue = ew_FormatDateTime($this->fecha_obra_sol->CurrentValue, 8);
		$this->fecha_obra_sol->PlaceHolder = ew_RemoveHtml($this->fecha_obra_sol->FldCaption());

		// nombre_tecnico_sol
		$this->nombre_tecnico_sol->EditAttrs["class"] = "form-control";
		$this->nombre_tecnico_sol->EditCustomAttributes = "";
		$this->nombre_tecnico_sol->EditValue = $this->nombre_tecnico_sol->CurrentValue;
		$this->nombre_tecnico_sol->PlaceHolder = ew_RemoveHtml($this->nombre_tecnico_sol->FldCaption());

		// cod_tecnico_sol
		$this->cod_tecnico_sol->EditAttrs["class"] = "form-control";
		$this->cod_tecnico_sol->EditCustomAttributes = "";
		$this->cod_tecnico_sol->EditValue = $this->cod_tecnico_sol->CurrentValue;
		$this->cod_tecnico_sol->PlaceHolder = ew_RemoveHtml($this->cod_tecnico_sol->FldCaption());

		// lider_obra_sol
		$this->lider_obra_sol->EditAttrs["class"] = "form-control";
		$this->lider_obra_sol->EditCustomAttributes = "";
		$this->lider_obra_sol->EditValue = $this->lider_obra_sol->CurrentValue;
		$this->lider_obra_sol->PlaceHolder = ew_RemoveHtml($this->lider_obra_sol->FldCaption());

		// fecha_visita_comerc_sol
		$this->fecha_visita_comerc_sol->EditAttrs["class"] = "form-control";
		$this->fecha_visita_comerc_sol->EditCustomAttributes = "";
		$this->fecha_visita_comerc_sol->EditValue = ew_FormatDateTime($this->fecha_visita_comerc_sol->CurrentValue, 8);
		$this->fecha_visita_comerc_sol->PlaceHolder = ew_RemoveHtml($this->fecha_visita_comerc_sol->FldCaption());

		// obs_estado_sol
		$this->obs_estado_sol->EditAttrs["class"] = "form-control";
		$this->obs_estado_sol->EditCustomAttributes = "";
		$this->obs_estado_sol->EditValue = $this->obs_estado_sol->CurrentValue;
		$this->obs_estado_sol->ViewCustomAttributes = "";

		// forma_pagogn_sol
		$this->forma_pagogn_sol->EditAttrs["class"] = "form-control";
		$this->forma_pagogn_sol->EditCustomAttributes = "";
		$this->forma_pagogn_sol->EditValue = $this->forma_pagogn_sol->CurrentValue;
		$this->forma_pagogn_sol->PlaceHolder = ew_RemoveHtml($this->forma_pagogn_sol->FldCaption());

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
					if ($this->id_sol->Exportable) $Doc->ExportCaption($this->id_sol);
					if ($this->poliza_sol->Exportable) $Doc->ExportCaption($this->poliza_sol);
					if ($this->demanda_sol->Exportable) $Doc->ExportCaption($this->demanda_sol);
					if ($this->asesor_sol->Exportable) $Doc->ExportCaption($this->asesor_sol);
					if ($this->asignacion_sol->Exportable) $Doc->ExportCaption($this->asignacion_sol);
					if ($this->cedula_sol->Exportable) $Doc->ExportCaption($this->cedula_sol);
					if ($this->nombre_sol->Exportable) $Doc->ExportCaption($this->nombre_sol);
					if ($this->direccion_pol_sol->Exportable) $Doc->ExportCaption($this->direccion_pol_sol);
					if ($this->direccion_nueva_sol->Exportable) $Doc->ExportCaption($this->direccion_nueva_sol);
					if ($this->localidad_sol->Exportable) $Doc->ExportCaption($this->localidad_sol);
					if ($this->barrio_sol->Exportable) $Doc->ExportCaption($this->barrio_sol);
					if ($this->telefono1_sol->Exportable) $Doc->ExportCaption($this->telefono1_sol);
					if ($this->telefono2_sol->Exportable) $Doc->ExportCaption($this->telefono2_sol);
					if ($this->celular_sol->Exportable) $Doc->ExportCaption($this->celular_sol);
					if ($this->servicio_sol->Exportable) $Doc->ExportCaption($this->servicio_sol);
					if ($this->obs_sol->Exportable) $Doc->ExportCaption($this->obs_sol);
					if ($this->estado_sol->Exportable) $Doc->ExportCaption($this->estado_sol);
					if ($this->fecha_prevista_sol->Exportable) $Doc->ExportCaption($this->fecha_prevista_sol);
					if ($this->fecha_obra_sol->Exportable) $Doc->ExportCaption($this->fecha_obra_sol);
					if ($this->fecha_visita_comerc_sol->Exportable) $Doc->ExportCaption($this->fecha_visita_comerc_sol);
					if ($this->obs_estado_sol->Exportable) $Doc->ExportCaption($this->obs_estado_sol);
				} else {
					if ($this->id_sol->Exportable) $Doc->ExportCaption($this->id_sol);
					if ($this->poliza_sol->Exportable) $Doc->ExportCaption($this->poliza_sol);
					if ($this->demanda_sol->Exportable) $Doc->ExportCaption($this->demanda_sol);
					if ($this->asesor_sol->Exportable) $Doc->ExportCaption($this->asesor_sol);
					if ($this->archivos_sol->Exportable) $Doc->ExportCaption($this->archivos_sol);
					if ($this->asignacion_sol->Exportable) $Doc->ExportCaption($this->asignacion_sol);
					if ($this->cedula_sol->Exportable) $Doc->ExportCaption($this->cedula_sol);
					if ($this->nombre_sol->Exportable) $Doc->ExportCaption($this->nombre_sol);
					if ($this->direccion_pol_sol->Exportable) $Doc->ExportCaption($this->direccion_pol_sol);
					if ($this->direccion_nueva_sol->Exportable) $Doc->ExportCaption($this->direccion_nueva_sol);
					if ($this->localidad_sol->Exportable) $Doc->ExportCaption($this->localidad_sol);
					if ($this->barrio_sol->Exportable) $Doc->ExportCaption($this->barrio_sol);
					if ($this->telefono1_sol->Exportable) $Doc->ExportCaption($this->telefono1_sol);
					if ($this->telefono2_sol->Exportable) $Doc->ExportCaption($this->telefono2_sol);
					if ($this->celular_sol->Exportable) $Doc->ExportCaption($this->celular_sol);
					if ($this->email_sol->Exportable) $Doc->ExportCaption($this->email_sol);
					if ($this->servicio_sol->Exportable) $Doc->ExportCaption($this->servicio_sol);
					if ($this->obs_sol->Exportable) $Doc->ExportCaption($this->obs_sol);
					if ($this->estado_sol->Exportable) $Doc->ExportCaption($this->estado_sol);
					if ($this->fecha_prevista_sol->Exportable) $Doc->ExportCaption($this->fecha_prevista_sol);
					if ($this->fecha_obra_sol->Exportable) $Doc->ExportCaption($this->fecha_obra_sol);
					if ($this->fecha_visita_comerc_sol->Exportable) $Doc->ExportCaption($this->fecha_visita_comerc_sol);
					if ($this->obs_estado_sol->Exportable) $Doc->ExportCaption($this->obs_estado_sol);
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
						if ($this->id_sol->Exportable) $Doc->ExportField($this->id_sol);
						if ($this->poliza_sol->Exportable) $Doc->ExportField($this->poliza_sol);
						if ($this->demanda_sol->Exportable) $Doc->ExportField($this->demanda_sol);
						if ($this->asesor_sol->Exportable) $Doc->ExportField($this->asesor_sol);
						if ($this->asignacion_sol->Exportable) $Doc->ExportField($this->asignacion_sol);
						if ($this->cedula_sol->Exportable) $Doc->ExportField($this->cedula_sol);
						if ($this->nombre_sol->Exportable) $Doc->ExportField($this->nombre_sol);
						if ($this->direccion_pol_sol->Exportable) $Doc->ExportField($this->direccion_pol_sol);
						if ($this->direccion_nueva_sol->Exportable) $Doc->ExportField($this->direccion_nueva_sol);
						if ($this->localidad_sol->Exportable) $Doc->ExportField($this->localidad_sol);
						if ($this->barrio_sol->Exportable) $Doc->ExportField($this->barrio_sol);
						if ($this->telefono1_sol->Exportable) $Doc->ExportField($this->telefono1_sol);
						if ($this->telefono2_sol->Exportable) $Doc->ExportField($this->telefono2_sol);
						if ($this->celular_sol->Exportable) $Doc->ExportField($this->celular_sol);
						if ($this->servicio_sol->Exportable) $Doc->ExportField($this->servicio_sol);
						if ($this->obs_sol->Exportable) $Doc->ExportField($this->obs_sol);
						if ($this->estado_sol->Exportable) $Doc->ExportField($this->estado_sol);
						if ($this->fecha_prevista_sol->Exportable) $Doc->ExportField($this->fecha_prevista_sol);
						if ($this->fecha_obra_sol->Exportable) $Doc->ExportField($this->fecha_obra_sol);
						if ($this->fecha_visita_comerc_sol->Exportable) $Doc->ExportField($this->fecha_visita_comerc_sol);
						if ($this->obs_estado_sol->Exportable) $Doc->ExportField($this->obs_estado_sol);
					} else {
						if ($this->id_sol->Exportable) $Doc->ExportField($this->id_sol);
						if ($this->poliza_sol->Exportable) $Doc->ExportField($this->poliza_sol);
						if ($this->demanda_sol->Exportable) $Doc->ExportField($this->demanda_sol);
						if ($this->asesor_sol->Exportable) $Doc->ExportField($this->asesor_sol);
						if ($this->archivos_sol->Exportable) $Doc->ExportField($this->archivos_sol);
						if ($this->asignacion_sol->Exportable) $Doc->ExportField($this->asignacion_sol);
						if ($this->cedula_sol->Exportable) $Doc->ExportField($this->cedula_sol);
						if ($this->nombre_sol->Exportable) $Doc->ExportField($this->nombre_sol);
						if ($this->direccion_pol_sol->Exportable) $Doc->ExportField($this->direccion_pol_sol);
						if ($this->direccion_nueva_sol->Exportable) $Doc->ExportField($this->direccion_nueva_sol);
						if ($this->localidad_sol->Exportable) $Doc->ExportField($this->localidad_sol);
						if ($this->barrio_sol->Exportable) $Doc->ExportField($this->barrio_sol);
						if ($this->telefono1_sol->Exportable) $Doc->ExportField($this->telefono1_sol);
						if ($this->telefono2_sol->Exportable) $Doc->ExportField($this->telefono2_sol);
						if ($this->celular_sol->Exportable) $Doc->ExportField($this->celular_sol);
						if ($this->email_sol->Exportable) $Doc->ExportField($this->email_sol);
						if ($this->servicio_sol->Exportable) $Doc->ExportField($this->servicio_sol);
						if ($this->obs_sol->Exportable) $Doc->ExportField($this->obs_sol);
						if ($this->estado_sol->Exportable) $Doc->ExportField($this->estado_sol);
						if ($this->fecha_prevista_sol->Exportable) $Doc->ExportField($this->fecha_prevista_sol);
						if ($this->fecha_obra_sol->Exportable) $Doc->ExportField($this->fecha_obra_sol);
						if ($this->fecha_visita_comerc_sol->Exportable) $Doc->ExportField($this->fecha_visita_comerc_sol);
						if ($this->obs_estado_sol->Exportable) $Doc->ExportField($this->obs_estado_sol);
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
