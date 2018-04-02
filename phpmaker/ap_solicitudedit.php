<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "ap_solicitudinfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$ap_solicitud_edit = NULL; // Initialize page object first

class cap_solicitud_edit extends cap_solicitud {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{6A9AC718-A824-45A3-BED3-A95E91E6986D}";

	// Table name
	var $TableName = 'ap_solicitud';

	// Page object name
	var $PageObjName = 'ap_solicitud_edit';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		if ($this->UseTokenInUrl) $PageUrl .= "t=" . $this->TableVar . "&"; // Add page token
		return $PageUrl;
	}

	// Message
	function getMessage() {
		return @$_SESSION[EW_SESSION_MESSAGE];
	}

	function setMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_MESSAGE], $v);
	}

	function getFailureMessage() {
		return @$_SESSION[EW_SESSION_FAILURE_MESSAGE];
	}

	function setFailureMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_FAILURE_MESSAGE], $v);
	}

	function getSuccessMessage() {
		return @$_SESSION[EW_SESSION_SUCCESS_MESSAGE];
	}

	function setSuccessMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_SUCCESS_MESSAGE], $v);
	}

	function getWarningMessage() {
		return @$_SESSION[EW_SESSION_WARNING_MESSAGE];
	}

	function setWarningMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_WARNING_MESSAGE], $v);
	}

	// Methods to clear message
	function ClearMessage() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
	}

	function ClearFailureMessage() {
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
	}

	function ClearSuccessMessage() {
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
	}

	function ClearWarningMessage() {
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	function ClearMessages() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	// Show message
	function ShowMessage() {
		$hidden = FALSE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sMessage;
			$html .= "<div class=\"alert alert-info ewInfo\">" . $sMessage . "</div>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sWarningMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sWarningMessage;
			$html .= "<div class=\"alert alert-warning ewWarning\">" . $sWarningMessage . "</div>";
			$_SESSION[EW_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sSuccessMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sSuccessMessage . "</div>";
			$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sErrorMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sErrorMessage;
			$html .= "<div class=\"alert alert-danger ewError\">" . $sErrorMessage . "</div>";
			$_SESSION[EW_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo "<div class=\"ewMessageDialog\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div>";
	}
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") { // Header exists, display
			echo "<p>" . $sHeader . "</p>";
		}
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") { // Footer exists, display
			echo "<p>" . $sFooter . "</p>";
		}
	}

	// Validate page request
	function IsPageRequest() {
		global $objForm;
		if ($this->UseTokenInUrl) {
			if ($objForm)
				return ($this->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($this->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}
	var $Token = "";
	var $TokenTimeout = 0;
	var $CheckToken = EW_CHECK_TOKEN;
	var $CheckTokenFn = "ew_CheckToken";
	var $CreateTokenFn = "ew_CreateToken";

	// Valid Post
	function ValidPost() {
		if (!$this->CheckToken || !ew_IsHttpPost())
			return TRUE;
		if (!isset($_POST[EW_TOKEN_NAME]))
			return FALSE;
		$fn = $this->CheckTokenFn;
		if (is_callable($fn))
			return $fn($_POST[EW_TOKEN_NAME], $this->TokenTimeout);
		return FALSE;
	}

	// Create Token
	function CreateToken() {
		global $gsToken;
		if ($this->CheckToken) {
			$fn = $this->CreateTokenFn;
			if ($this->Token == "" && is_callable($fn)) // Create token
				$this->Token = $fn();
			$gsToken = $this->Token; // Save to global variable
		}
	}

	//
	// Page class constructor
	//
	function __construct() {
		global $conn, $Language;
		global $UserTable, $UserTableConn;
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = ew_SessionTimeoutTime();

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (ap_solicitud)
		if (!isset($GLOBALS["ap_solicitud"]) || get_class($GLOBALS["ap_solicitud"]) == "cap_solicitud") {
			$GLOBALS["ap_solicitud"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["ap_solicitud"];
		}

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'ap_solicitud', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect($this->DBID);

		// User table object (usuarios)
		if (!isset($UserTable)) {
			$UserTable = new cusuarios();
			$UserTableConn = Conn($UserTable->DBID);
		}
	}

	//
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// User profile
		$UserProfile = new cUserProfile();

		// Security
		$Security = new cAdvancedSecurity();
		if (IsPasswordExpired())
			$this->Page_Terminate(ew_GetUrl("changepwd.php"));
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loaded();
		if (!$Security->CanEdit()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("ap_solicitudlist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		if ($Security->IsLoggedIn()) {
			$Security->UserID_Loading();
			$Security->LoadUserID();
			$Security->UserID_Loaded();
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->id_sol->SetVisibility();
		$this->id_sol->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->poliza_sol->SetVisibility();
		$this->demanda_sol->SetVisibility();
		$this->asesor_sol->SetVisibility();
		$this->archivos_sol->SetVisibility();
		$this->asignacion_sol->SetVisibility();
		$this->cedula_sol->SetVisibility();
		$this->nombre_sol->SetVisibility();
		$this->direccion_pol_sol->SetVisibility();
		$this->direccion_nueva_sol->SetVisibility();
		$this->localidad_sol->SetVisibility();
		$this->barrio_sol->SetVisibility();
		$this->telefono1_sol->SetVisibility();
		$this->telefono2_sol->SetVisibility();
		$this->celular_sol->SetVisibility();
		$this->email_sol->SetVisibility();
		$this->servicio_sol->SetVisibility();
		$this->obs_sol->SetVisibility();
		$this->estado_sol->SetVisibility();
		$this->fecha_prevista_sol->SetVisibility();
		$this->fecha_visita_comerc_sol->SetVisibility();
		$this->obs_estado_sol->SetVisibility();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Check token
		if (!$this->ValidPost()) {
			echo $Language->Phrase("InvalidPostRequest");
			$this->Page_Terminate();
			exit();
		}

		// Process auto fill
		if (@$_POST["ajax"] == "autofill") {
			$results = $this->GetAutoFill(@$_POST["name"], @$_POST["q"]);
			if ($results) {

				// Clean output buffer
				if (!EW_DEBUG_ENABLED && ob_get_length())
					ob_end_clean();
				echo $results;
				$this->Page_Terminate();
				exit();
			}
		}

		// Create Token
		$this->CreateToken();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $gsExportFile, $gTmpImages;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export
		global $EW_EXPORT, $ap_solicitud;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($ap_solicitud);
				$doc->Text = $sContent;
				if ($this->Export == "email")
					echo $this->ExportEmail($doc->Text);
				else
					$doc->Export();
				ew_DeleteTmpImages(); // Delete temp images
				exit();
			}
		}
		$this->Page_Redirecting($url);

		 // Close connection
		ew_CloseConn();

		// Go to URL if specified
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();

			// Handle modal response
			if ($this->IsModal) {
				$row = array();
				$row["url"] = $url;
				echo ew_ArrayToJson(array($row));
			} else {
				header("Location: " . $url);
			}
		}
		exit();
	}
	var $FormClassName = "form-horizontal ewForm ewEditForm";
	var $IsModal = FALSE;
	var $DbMasterFilter;
	var $DbDetailFilter;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;
		global $gbSkipHeaderFooter;

		// Check modal
		$this->IsModal = (@$_GET["modal"] == "1" || @$_POST["modal"] == "1");
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;

		// Load key from QueryString
		if (@$_GET["id_sol"] <> "") {
			$this->id_sol->setQueryStringValue($_GET["id_sol"]);
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($this->id_sol->CurrentValue == "") {
			$this->Page_Terminate("ap_solicitudlist.php"); // Invalid key, return to list
		}

		// Validate form if post back
		if (@$_POST["a_edit"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = ""; // Form error, reset action
				$this->setFailureMessage($gsFormError);
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		}
		switch ($this->CurrentAction) {
			case "I": // Get a record to display
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("ap_solicitudlist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "ap_solicitudlist.php")
					$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} elseif ($this->getFailureMessage() == $Language->Phrase("NoRecord")) {
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Render the record
		$this->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$this->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$this->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $this->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$this->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->id_sol->FldIsDetailKey)
			$this->id_sol->setFormValue($objForm->GetValue("x_id_sol"));
		if (!$this->poliza_sol->FldIsDetailKey) {
			$this->poliza_sol->setFormValue($objForm->GetValue("x_poliza_sol"));
		}
		if (!$this->demanda_sol->FldIsDetailKey) {
			$this->demanda_sol->setFormValue($objForm->GetValue("x_demanda_sol"));
		}
		if (!$this->asesor_sol->FldIsDetailKey) {
			$this->asesor_sol->setFormValue($objForm->GetValue("x_asesor_sol"));
		}
		if (!$this->archivos_sol->FldIsDetailKey) {
			$this->archivos_sol->setFormValue($objForm->GetValue("x_archivos_sol"));
		}
		if (!$this->asignacion_sol->FldIsDetailKey) {
			$this->asignacion_sol->setFormValue($objForm->GetValue("x_asignacion_sol"));
		}
		if (!$this->cedula_sol->FldIsDetailKey) {
			$this->cedula_sol->setFormValue($objForm->GetValue("x_cedula_sol"));
		}
		if (!$this->nombre_sol->FldIsDetailKey) {
			$this->nombre_sol->setFormValue($objForm->GetValue("x_nombre_sol"));
		}
		if (!$this->direccion_pol_sol->FldIsDetailKey) {
			$this->direccion_pol_sol->setFormValue($objForm->GetValue("x_direccion_pol_sol"));
		}
		if (!$this->direccion_nueva_sol->FldIsDetailKey) {
			$this->direccion_nueva_sol->setFormValue($objForm->GetValue("x_direccion_nueva_sol"));
		}
		if (!$this->localidad_sol->FldIsDetailKey) {
			$this->localidad_sol->setFormValue($objForm->GetValue("x_localidad_sol"));
		}
		if (!$this->barrio_sol->FldIsDetailKey) {
			$this->barrio_sol->setFormValue($objForm->GetValue("x_barrio_sol"));
		}
		if (!$this->telefono1_sol->FldIsDetailKey) {
			$this->telefono1_sol->setFormValue($objForm->GetValue("x_telefono1_sol"));
		}
		if (!$this->telefono2_sol->FldIsDetailKey) {
			$this->telefono2_sol->setFormValue($objForm->GetValue("x_telefono2_sol"));
		}
		if (!$this->celular_sol->FldIsDetailKey) {
			$this->celular_sol->setFormValue($objForm->GetValue("x_celular_sol"));
		}
		if (!$this->email_sol->FldIsDetailKey) {
			$this->email_sol->setFormValue($objForm->GetValue("x_email_sol"));
		}
		if (!$this->servicio_sol->FldIsDetailKey) {
			$this->servicio_sol->setFormValue($objForm->GetValue("x_servicio_sol"));
		}
		if (!$this->obs_sol->FldIsDetailKey) {
			$this->obs_sol->setFormValue($objForm->GetValue("x_obs_sol"));
		}
		if (!$this->estado_sol->FldIsDetailKey) {
			$this->estado_sol->setFormValue($objForm->GetValue("x_estado_sol"));
		}
		if (!$this->fecha_prevista_sol->FldIsDetailKey) {
			$this->fecha_prevista_sol->setFormValue($objForm->GetValue("x_fecha_prevista_sol"));
			$this->fecha_prevista_sol->CurrentValue = ew_UnFormatDateTime($this->fecha_prevista_sol->CurrentValue, 0);
		}
		if (!$this->fecha_visita_comerc_sol->FldIsDetailKey) {
			$this->fecha_visita_comerc_sol->setFormValue($objForm->GetValue("x_fecha_visita_comerc_sol"));
			$this->fecha_visita_comerc_sol->CurrentValue = ew_UnFormatDateTime($this->fecha_visita_comerc_sol->CurrentValue, 0);
		}
		if (!$this->obs_estado_sol->FldIsDetailKey) {
			$this->obs_estado_sol->setFormValue($objForm->GetValue("x_obs_estado_sol"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->id_sol->CurrentValue = $this->id_sol->FormValue;
		$this->poliza_sol->CurrentValue = $this->poliza_sol->FormValue;
		$this->demanda_sol->CurrentValue = $this->demanda_sol->FormValue;
		$this->asesor_sol->CurrentValue = $this->asesor_sol->FormValue;
		$this->archivos_sol->CurrentValue = $this->archivos_sol->FormValue;
		$this->asignacion_sol->CurrentValue = $this->asignacion_sol->FormValue;
		$this->cedula_sol->CurrentValue = $this->cedula_sol->FormValue;
		$this->nombre_sol->CurrentValue = $this->nombre_sol->FormValue;
		$this->direccion_pol_sol->CurrentValue = $this->direccion_pol_sol->FormValue;
		$this->direccion_nueva_sol->CurrentValue = $this->direccion_nueva_sol->FormValue;
		$this->localidad_sol->CurrentValue = $this->localidad_sol->FormValue;
		$this->barrio_sol->CurrentValue = $this->barrio_sol->FormValue;
		$this->telefono1_sol->CurrentValue = $this->telefono1_sol->FormValue;
		$this->telefono2_sol->CurrentValue = $this->telefono2_sol->FormValue;
		$this->celular_sol->CurrentValue = $this->celular_sol->FormValue;
		$this->email_sol->CurrentValue = $this->email_sol->FormValue;
		$this->servicio_sol->CurrentValue = $this->servicio_sol->FormValue;
		$this->obs_sol->CurrentValue = $this->obs_sol->FormValue;
		$this->estado_sol->CurrentValue = $this->estado_sol->FormValue;
		$this->fecha_prevista_sol->CurrentValue = $this->fecha_prevista_sol->FormValue;
		$this->fecha_prevista_sol->CurrentValue = ew_UnFormatDateTime($this->fecha_prevista_sol->CurrentValue, 0);
		$this->fecha_visita_comerc_sol->CurrentValue = $this->fecha_visita_comerc_sol->FormValue;
		$this->fecha_visita_comerc_sol->CurrentValue = ew_UnFormatDateTime($this->fecha_visita_comerc_sol->CurrentValue, 0);
		$this->obs_estado_sol->CurrentValue = $this->obs_estado_sol->FormValue;
	}

	// Load row based on key values
	function LoadRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();

		// Call Row Selecting event
		$this->Row_Selecting($sFilter);

		// Load SQL based on filter
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql, $conn);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		if (!$rs || $rs->EOF) return;

		// Call Row Selected event
		$row = &$rs->fields;
		$this->Row_Selected($row);
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

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id_sol->DbValue = $row['id_sol'];
		$this->poliza_sol->DbValue = $row['poliza_sol'];
		$this->demanda_sol->DbValue = $row['demanda_sol'];
		$this->asesor_sol->DbValue = $row['asesor_sol'];
		$this->archivos_sol->DbValue = $row['archivos_sol'];
		$this->asignacion_sol->DbValue = $row['asignacion_sol'];
		$this->comis_gas_sol->DbValue = $row['comis_gas_sol'];
		$this->comis_obra_sol->DbValue = $row['comis_obra_sol'];
		$this->comis_fija_sol->DbValue = $row['comis_fija_sol'];
		$this->cedula_sol->DbValue = $row['cedula_sol'];
		$this->nombre_sol->DbValue = $row['nombre_sol'];
		$this->direccion_pol_sol->DbValue = $row['direccion_pol_sol'];
		$this->direccion_nueva_sol->DbValue = $row['direccion_nueva_sol'];
		$this->localidad_sol->DbValue = $row['localidad_sol'];
		$this->barrio_sol->DbValue = $row['barrio_sol'];
		$this->telefono1_sol->DbValue = $row['telefono1_sol'];
		$this->telefono2_sol->DbValue = $row['telefono2_sol'];
		$this->celular_sol->DbValue = $row['celular_sol'];
		$this->email_sol->DbValue = $row['email_sol'];
		$this->servicio_sol->DbValue = $row['servicio_sol'];
		$this->texto_sol->DbValue = $row['texto_sol'];
		$this->registra_sol->DbValue = $row['registra_sol'];
		$this->tipo_clientegn_sol->DbValue = $row['tipo_clientegn_sol'];
		$this->unidad_sol->DbValue = $row['unidad_sol'];
		$this->fecha_reg_sol->DbValue = $row['fecha_reg_sol'];
		$this->obs_sol->DbValue = $row['obs_sol'];
		$this->empresa_sol->DbValue = $row['empresa_sol'];
		$this->estado_sol->DbValue = $row['estado_sol'];
		$this->fecha_prevista_sol->DbValue = $row['fecha_prevista_sol'];
		$this->user_preventa_sol->DbValue = $row['user_preventa_sol'];
		$this->quincena_obra_sol->DbValue = $row['quincena_obra_sol'];
		$this->fecha_obra_sol->DbValue = $row['fecha_obra_sol'];
		$this->nombre_tecnico_sol->DbValue = $row['nombre_tecnico_sol'];
		$this->cod_tecnico_sol->DbValue = $row['cod_tecnico_sol'];
		$this->lider_obra_sol->DbValue = $row['lider_obra_sol'];
		$this->fecha_visita_comerc_sol->DbValue = $row['fecha_visita_comerc_sol'];
		$this->obs_estado_sol->DbValue = $row['obs_estado_sol'];
		$this->forma_pagogn_sol->DbValue = $row['forma_pagogn_sol'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Convert decimal values if posted back

		if ($this->poliza_sol->FormValue == $this->poliza_sol->CurrentValue && is_numeric(ew_StrToFloat($this->poliza_sol->CurrentValue)))
			$this->poliza_sol->CurrentValue = ew_StrToFloat($this->poliza_sol->CurrentValue);

		// Convert decimal values if posted back
		if ($this->demanda_sol->FormValue == $this->demanda_sol->CurrentValue && is_numeric(ew_StrToFloat($this->demanda_sol->CurrentValue)))
			$this->demanda_sol->CurrentValue = ew_StrToFloat($this->demanda_sol->CurrentValue);

		// Convert decimal values if posted back
		if ($this->cedula_sol->FormValue == $this->cedula_sol->CurrentValue && is_numeric(ew_StrToFloat($this->cedula_sol->CurrentValue)))
			$this->cedula_sol->CurrentValue = ew_StrToFloat($this->cedula_sol->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
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

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

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

		// obs_sol
		$this->obs_sol->ViewValue = $this->obs_sol->CurrentValue;
		$this->obs_sol->ViewCustomAttributes = "";

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

		// fecha_obra_sol
		$this->fecha_obra_sol->ViewValue = $this->fecha_obra_sol->CurrentValue;
		$this->fecha_obra_sol->ViewValue = ew_FormatDateTime($this->fecha_obra_sol->ViewValue, 0);
		$this->fecha_obra_sol->ViewCustomAttributes = "";

		// fecha_visita_comerc_sol
		$this->fecha_visita_comerc_sol->ViewValue = $this->fecha_visita_comerc_sol->CurrentValue;
		$this->fecha_visita_comerc_sol->ViewValue = ew_FormatDateTime($this->fecha_visita_comerc_sol->ViewValue, 0);
		$this->fecha_visita_comerc_sol->ViewCustomAttributes = "";

		// obs_estado_sol
		$this->obs_estado_sol->ViewValue = $this->obs_estado_sol->CurrentValue;
		$this->obs_estado_sol->ViewCustomAttributes = "";

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

			// obs_sol
			$this->obs_sol->LinkCustomAttributes = "";
			$this->obs_sol->HrefValue = "";
			$this->obs_sol->TooltipValue = "";

			// estado_sol
			$this->estado_sol->LinkCustomAttributes = "";
			$this->estado_sol->HrefValue = "";
			$this->estado_sol->TooltipValue = "";

			// fecha_prevista_sol
			$this->fecha_prevista_sol->LinkCustomAttributes = "";
			$this->fecha_prevista_sol->HrefValue = "";
			$this->fecha_prevista_sol->TooltipValue = "";

			// fecha_visita_comerc_sol
			$this->fecha_visita_comerc_sol->LinkCustomAttributes = "";
			$this->fecha_visita_comerc_sol->HrefValue = "";
			$this->fecha_visita_comerc_sol->TooltipValue = "";

			// obs_estado_sol
			$this->obs_estado_sol->LinkCustomAttributes = "";
			$this->obs_estado_sol->HrefValue = "";
			$this->obs_estado_sol->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// id_sol
			$this->id_sol->EditAttrs["class"] = "form-control";
			$this->id_sol->EditCustomAttributes = "";
			$this->id_sol->EditValue = $this->id_sol->CurrentValue;
			$this->id_sol->ViewCustomAttributes = "";

			// poliza_sol
			$this->poliza_sol->EditAttrs["class"] = "form-control";
			$this->poliza_sol->EditCustomAttributes = "";
			$this->poliza_sol->EditValue = ew_HtmlEncode($this->poliza_sol->CurrentValue);
			$this->poliza_sol->PlaceHolder = ew_RemoveHtml($this->poliza_sol->FldCaption());
			if (strval($this->poliza_sol->EditValue) <> "" && is_numeric($this->poliza_sol->EditValue)) $this->poliza_sol->EditValue = ew_FormatNumber($this->poliza_sol->EditValue, -2, -1, -2, 0);

			// demanda_sol
			$this->demanda_sol->EditAttrs["class"] = "form-control";
			$this->demanda_sol->EditCustomAttributes = "";
			$this->demanda_sol->EditValue = ew_HtmlEncode($this->demanda_sol->CurrentValue);
			$this->demanda_sol->PlaceHolder = ew_RemoveHtml($this->demanda_sol->FldCaption());
			if (strval($this->demanda_sol->EditValue) <> "" && is_numeric($this->demanda_sol->EditValue)) $this->demanda_sol->EditValue = ew_FormatNumber($this->demanda_sol->EditValue, -2, -1, -2, 0);

			// asesor_sol
			$this->asesor_sol->EditAttrs["class"] = "form-control";
			$this->asesor_sol->EditCustomAttributes = "";
			if (trim(strval($this->asesor_sol->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_tercero`" . ew_SearchString("=", $this->asesor_sol->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_tercero`, `nombre_tercero` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `ap_terceros`";
			$sWhereWrk = "";
			$this->asesor_sol->LookupFilters = array();
			$lookuptblfilter = "`tipo_tercero`=4";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->asesor_sol, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `nombre_tercero` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->asesor_sol->EditValue = $arwrk;

			// archivos_sol
			$this->archivos_sol->EditAttrs["class"] = "form-control";
			$this->archivos_sol->EditCustomAttributes = "";
			$this->archivos_sol->EditValue = ew_HtmlEncode($this->archivos_sol->CurrentValue);
			$this->archivos_sol->PlaceHolder = ew_RemoveHtml($this->archivos_sol->FldCaption());

			// asignacion_sol
			$this->asignacion_sol->EditAttrs["class"] = "form-control";
			$this->asignacion_sol->EditCustomAttributes = "";
			if (trim(strval($this->asignacion_sol->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id_asignacion`" . ew_SearchString("=", $this->asignacion_sol->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `id_asignacion`, `tipo_asignacion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `ap_asignacion`";
			$sWhereWrk = "";
			$this->asignacion_sol->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->asignacion_sol, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `tipo_asignacion` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->asignacion_sol->EditValue = $arwrk;

			// cedula_sol
			$this->cedula_sol->EditAttrs["class"] = "form-control";
			$this->cedula_sol->EditCustomAttributes = "";
			$this->cedula_sol->EditValue = ew_HtmlEncode($this->cedula_sol->CurrentValue);
			$this->cedula_sol->PlaceHolder = ew_RemoveHtml($this->cedula_sol->FldCaption());
			if (strval($this->cedula_sol->EditValue) <> "" && is_numeric($this->cedula_sol->EditValue)) $this->cedula_sol->EditValue = ew_FormatNumber($this->cedula_sol->EditValue, -2, -1, -2, 0);

			// nombre_sol
			$this->nombre_sol->EditAttrs["class"] = "form-control";
			$this->nombre_sol->EditCustomAttributes = "";
			$this->nombre_sol->EditValue = ew_HtmlEncode($this->nombre_sol->CurrentValue);
			$this->nombre_sol->PlaceHolder = ew_RemoveHtml($this->nombre_sol->FldCaption());

			// direccion_pol_sol
			$this->direccion_pol_sol->EditAttrs["class"] = "form-control";
			$this->direccion_pol_sol->EditCustomAttributes = "";
			$this->direccion_pol_sol->EditValue = ew_HtmlEncode($this->direccion_pol_sol->CurrentValue);
			$this->direccion_pol_sol->PlaceHolder = ew_RemoveHtml($this->direccion_pol_sol->FldCaption());

			// direccion_nueva_sol
			$this->direccion_nueva_sol->EditAttrs["class"] = "form-control";
			$this->direccion_nueva_sol->EditCustomAttributes = "";
			$this->direccion_nueva_sol->EditValue = ew_HtmlEncode($this->direccion_nueva_sol->CurrentValue);
			$this->direccion_nueva_sol->PlaceHolder = ew_RemoveHtml($this->direccion_nueva_sol->FldCaption());

			// localidad_sol
			$this->localidad_sol->EditAttrs["class"] = "form-control";
			$this->localidad_sol->EditCustomAttributes = "";
			if (trim(strval($this->localidad_sol->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id_loc`" . ew_SearchString("=", $this->localidad_sol->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `id_loc`, `nombre_loc` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `siax_localidad`";
			$sWhereWrk = "";
			$this->localidad_sol->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->localidad_sol, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `nombre_loc` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->localidad_sol->EditValue = $arwrk;

			// barrio_sol
			$this->barrio_sol->EditAttrs["class"] = "form-control";
			$this->barrio_sol->EditCustomAttributes = "";
			if (trim(strval($this->barrio_sol->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`cod_sec`" . ew_SearchString("=", $this->barrio_sol->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `cod_sec`, `nombre_sec` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `localidad` AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `siax_sectores`";
			$sWhereWrk = "";
			$this->barrio_sol->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->barrio_sol, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `nombre_sec` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->barrio_sol->EditValue = $arwrk;

			// telefono1_sol
			$this->telefono1_sol->EditAttrs["class"] = "form-control";
			$this->telefono1_sol->EditCustomAttributes = "";
			$this->telefono1_sol->EditValue = ew_HtmlEncode($this->telefono1_sol->CurrentValue);
			$this->telefono1_sol->PlaceHolder = ew_RemoveHtml($this->telefono1_sol->FldCaption());

			// telefono2_sol
			$this->telefono2_sol->EditAttrs["class"] = "form-control";
			$this->telefono2_sol->EditCustomAttributes = "";
			$this->telefono2_sol->EditValue = ew_HtmlEncode($this->telefono2_sol->CurrentValue);
			$this->telefono2_sol->PlaceHolder = ew_RemoveHtml($this->telefono2_sol->FldCaption());

			// celular_sol
			$this->celular_sol->EditAttrs["class"] = "form-control";
			$this->celular_sol->EditCustomAttributes = "";
			$this->celular_sol->EditValue = ew_HtmlEncode($this->celular_sol->CurrentValue);
			$this->celular_sol->PlaceHolder = ew_RemoveHtml($this->celular_sol->FldCaption());

			// email_sol
			$this->email_sol->EditAttrs["class"] = "form-control";
			$this->email_sol->EditCustomAttributes = "";
			$this->email_sol->EditValue = ew_HtmlEncode($this->email_sol->CurrentValue);
			$this->email_sol->PlaceHolder = ew_RemoveHtml($this->email_sol->FldCaption());

			// servicio_sol
			$this->servicio_sol->EditAttrs["class"] = "form-control";
			$this->servicio_sol->EditCustomAttributes = "";
			$this->servicio_sol->EditValue = ew_HtmlEncode($this->servicio_sol->CurrentValue);
			$this->servicio_sol->PlaceHolder = ew_RemoveHtml($this->servicio_sol->FldCaption());

			// obs_sol
			$this->obs_sol->EditAttrs["class"] = "form-control";
			$this->obs_sol->EditCustomAttributes = "";
			$this->obs_sol->EditValue = ew_HtmlEncode($this->obs_sol->CurrentValue);
			$this->obs_sol->PlaceHolder = ew_RemoveHtml($this->obs_sol->FldCaption());

			// estado_sol
			$this->estado_sol->EditAttrs["class"] = "form-control";
			$this->estado_sol->EditCustomAttributes = "";
			if (trim(strval($this->estado_sol->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id_estado_preventa`" . ew_SearchString("=", $this->estado_sol->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `id_estado_preventa`, `nombre_estado_preventa` AS `DispFld`, `detalle_estado_preventa` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `ap_estado_preventa`";
			$sWhereWrk = "";
			$this->estado_sol->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->estado_sol, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `nombre_estado_preventa` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->estado_sol->EditValue = $arwrk;

			// fecha_prevista_sol
			$this->fecha_prevista_sol->EditAttrs["class"] = "form-control";
			$this->fecha_prevista_sol->EditCustomAttributes = "";
			$this->fecha_prevista_sol->EditValue = $this->fecha_prevista_sol->CurrentValue;
			$this->fecha_prevista_sol->EditValue = ew_FormatDateTime($this->fecha_prevista_sol->EditValue, 0);
			$this->fecha_prevista_sol->ViewCustomAttributes = "";

			// fecha_visita_comerc_sol
			$this->fecha_visita_comerc_sol->EditAttrs["class"] = "form-control";
			$this->fecha_visita_comerc_sol->EditCustomAttributes = "";
			$this->fecha_visita_comerc_sol->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->fecha_visita_comerc_sol->CurrentValue, 8));
			$this->fecha_visita_comerc_sol->PlaceHolder = ew_RemoveHtml($this->fecha_visita_comerc_sol->FldCaption());

			// obs_estado_sol
			$this->obs_estado_sol->EditAttrs["class"] = "form-control";
			$this->obs_estado_sol->EditCustomAttributes = "";
			$this->obs_estado_sol->EditValue = $this->obs_estado_sol->CurrentValue;
			$this->obs_estado_sol->ViewCustomAttributes = "";

			// Edit refer script
			// id_sol

			$this->id_sol->LinkCustomAttributes = "";
			$this->id_sol->HrefValue = "";
			$this->id_sol->TooltipValue = "";

			// poliza_sol
			$this->poliza_sol->LinkCustomAttributes = "";
			$this->poliza_sol->HrefValue = "";

			// demanda_sol
			$this->demanda_sol->LinkCustomAttributes = "";
			$this->demanda_sol->HrefValue = "";

			// asesor_sol
			$this->asesor_sol->LinkCustomAttributes = "";
			$this->asesor_sol->HrefValue = "";

			// archivos_sol
			$this->archivos_sol->LinkCustomAttributes = "";
			$this->archivos_sol->HrefValue = "";

			// asignacion_sol
			$this->asignacion_sol->LinkCustomAttributes = "";
			$this->asignacion_sol->HrefValue = "";

			// cedula_sol
			$this->cedula_sol->LinkCustomAttributes = "";
			$this->cedula_sol->HrefValue = "";

			// nombre_sol
			$this->nombre_sol->LinkCustomAttributes = "";
			$this->nombre_sol->HrefValue = "";

			// direccion_pol_sol
			$this->direccion_pol_sol->LinkCustomAttributes = "";
			$this->direccion_pol_sol->HrefValue = "";

			// direccion_nueva_sol
			$this->direccion_nueva_sol->LinkCustomAttributes = "";
			$this->direccion_nueva_sol->HrefValue = "";

			// localidad_sol
			$this->localidad_sol->LinkCustomAttributes = "";
			$this->localidad_sol->HrefValue = "";

			// barrio_sol
			$this->barrio_sol->LinkCustomAttributes = "";
			$this->barrio_sol->HrefValue = "";

			// telefono1_sol
			$this->telefono1_sol->LinkCustomAttributes = "";
			$this->telefono1_sol->HrefValue = "";

			// telefono2_sol
			$this->telefono2_sol->LinkCustomAttributes = "";
			$this->telefono2_sol->HrefValue = "";

			// celular_sol
			$this->celular_sol->LinkCustomAttributes = "";
			$this->celular_sol->HrefValue = "";

			// email_sol
			$this->email_sol->LinkCustomAttributes = "";
			$this->email_sol->HrefValue = "";

			// servicio_sol
			$this->servicio_sol->LinkCustomAttributes = "";
			$this->servicio_sol->HrefValue = "";

			// obs_sol
			$this->obs_sol->LinkCustomAttributes = "";
			$this->obs_sol->HrefValue = "";

			// estado_sol
			$this->estado_sol->LinkCustomAttributes = "";
			$this->estado_sol->HrefValue = "";

			// fecha_prevista_sol
			$this->fecha_prevista_sol->LinkCustomAttributes = "";
			$this->fecha_prevista_sol->HrefValue = "";
			$this->fecha_prevista_sol->TooltipValue = "";

			// fecha_visita_comerc_sol
			$this->fecha_visita_comerc_sol->LinkCustomAttributes = "";
			$this->fecha_visita_comerc_sol->HrefValue = "";

			// obs_estado_sol
			$this->obs_estado_sol->LinkCustomAttributes = "";
			$this->obs_estado_sol->HrefValue = "";
			$this->obs_estado_sol->TooltipValue = "";
		}
		if ($this->RowType == EW_ROWTYPE_ADD ||
			$this->RowType == EW_ROWTYPE_EDIT ||
			$this->RowType == EW_ROWTYPE_SEARCH) { // Add / Edit / Search row
			$this->SetupFieldTitles();
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!ew_CheckNumber($this->poliza_sol->FormValue)) {
			ew_AddMessage($gsFormError, $this->poliza_sol->FldErrMsg());
		}
		if (!ew_CheckNumber($this->demanda_sol->FormValue)) {
			ew_AddMessage($gsFormError, $this->demanda_sol->FldErrMsg());
		}
		if (!ew_CheckInteger($this->archivos_sol->FormValue)) {
			ew_AddMessage($gsFormError, $this->archivos_sol->FldErrMsg());
		}
		if (!ew_CheckNumber($this->cedula_sol->FormValue)) {
			ew_AddMessage($gsFormError, $this->cedula_sol->FldErrMsg());
		}
		if (!$this->nombre_sol->FldIsDetailKey && !is_null($this->nombre_sol->FormValue) && $this->nombre_sol->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->nombre_sol->FldCaption(), $this->nombre_sol->ReqErrMsg));
		}
		if (!$this->localidad_sol->FldIsDetailKey && !is_null($this->localidad_sol->FormValue) && $this->localidad_sol->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->localidad_sol->FldCaption(), $this->localidad_sol->ReqErrMsg));
		}
		if (!$this->servicio_sol->FldIsDetailKey && !is_null($this->servicio_sol->FormValue) && $this->servicio_sol->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->servicio_sol->FldCaption(), $this->servicio_sol->ReqErrMsg));
		}
		if (!ew_CheckDateDef($this->fecha_visita_comerc_sol->FormValue)) {
			ew_AddMessage($gsFormError, $this->fecha_visita_comerc_sol->FldErrMsg());
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsFormError, $sFormCustomError);
		}
		return $ValidateForm;
	}

	// Update record based on key values
	function EditRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$conn = &$this->Connection();
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// poliza_sol
			$this->poliza_sol->SetDbValueDef($rsnew, $this->poliza_sol->CurrentValue, NULL, $this->poliza_sol->ReadOnly);

			// demanda_sol
			$this->demanda_sol->SetDbValueDef($rsnew, $this->demanda_sol->CurrentValue, NULL, $this->demanda_sol->ReadOnly);

			// asesor_sol
			$this->asesor_sol->SetDbValueDef($rsnew, $this->asesor_sol->CurrentValue, NULL, $this->asesor_sol->ReadOnly);

			// archivos_sol
			$this->archivos_sol->SetDbValueDef($rsnew, $this->archivos_sol->CurrentValue, NULL, $this->archivos_sol->ReadOnly);

			// asignacion_sol
			$this->asignacion_sol->SetDbValueDef($rsnew, $this->asignacion_sol->CurrentValue, NULL, $this->asignacion_sol->ReadOnly);

			// cedula_sol
			$this->cedula_sol->SetDbValueDef($rsnew, $this->cedula_sol->CurrentValue, NULL, $this->cedula_sol->ReadOnly);

			// nombre_sol
			$this->nombre_sol->SetDbValueDef($rsnew, $this->nombre_sol->CurrentValue, "", $this->nombre_sol->ReadOnly);

			// direccion_pol_sol
			$this->direccion_pol_sol->SetDbValueDef($rsnew, $this->direccion_pol_sol->CurrentValue, NULL, $this->direccion_pol_sol->ReadOnly);

			// direccion_nueva_sol
			$this->direccion_nueva_sol->SetDbValueDef($rsnew, $this->direccion_nueva_sol->CurrentValue, NULL, $this->direccion_nueva_sol->ReadOnly);

			// localidad_sol
			$this->localidad_sol->SetDbValueDef($rsnew, $this->localidad_sol->CurrentValue, 0, $this->localidad_sol->ReadOnly);

			// barrio_sol
			$this->barrio_sol->SetDbValueDef($rsnew, $this->barrio_sol->CurrentValue, NULL, $this->barrio_sol->ReadOnly);

			// telefono1_sol
			$this->telefono1_sol->SetDbValueDef($rsnew, $this->telefono1_sol->CurrentValue, NULL, $this->telefono1_sol->ReadOnly);

			// telefono2_sol
			$this->telefono2_sol->SetDbValueDef($rsnew, $this->telefono2_sol->CurrentValue, NULL, $this->telefono2_sol->ReadOnly);

			// celular_sol
			$this->celular_sol->SetDbValueDef($rsnew, $this->celular_sol->CurrentValue, NULL, $this->celular_sol->ReadOnly);

			// email_sol
			$this->email_sol->SetDbValueDef($rsnew, $this->email_sol->CurrentValue, NULL, $this->email_sol->ReadOnly);

			// servicio_sol
			$this->servicio_sol->SetDbValueDef($rsnew, $this->servicio_sol->CurrentValue, "", $this->servicio_sol->ReadOnly);

			// obs_sol
			$this->obs_sol->SetDbValueDef($rsnew, $this->obs_sol->CurrentValue, NULL, $this->obs_sol->ReadOnly);

			// estado_sol
			$this->estado_sol->SetDbValueDef($rsnew, $this->estado_sol->CurrentValue, NULL, $this->estado_sol->ReadOnly);

			// fecha_visita_comerc_sol
			$this->fecha_visita_comerc_sol->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->fecha_visita_comerc_sol->CurrentValue, 0), NULL, $this->fecha_visita_comerc_sol->ReadOnly);

			// Call Row Updating event
			$bUpdateRow = $this->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				if (count($rsnew) > 0)
					$EditRow = $this->Update($rsnew, "", $rsold);
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
				if ($EditRow) {
				}
			} else {
				if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

					// Use the message, do nothing
				} elseif ($this->CancelMessage <> "") {
					$this->setFailureMessage($this->CancelMessage);
					$this->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$this->Row_Updated($rsold, $rsnew);
		$rs->Close();
		return $EditRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("ap_solicitudlist.php"), "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_asesor_sol":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_tercero` AS `LinkFld`, `nombre_tercero` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ap_terceros`";
			$sWhereWrk = "";
			$this->asesor_sol->LookupFilters = array();
			$lookuptblfilter = "`tipo_tercero`=4";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_tercero` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->asesor_sol, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `nombre_tercero` ASC";
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_asignacion_sol":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id_asignacion` AS `LinkFld`, `tipo_asignacion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ap_asignacion`";
			$sWhereWrk = "";
			$this->asignacion_sol->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`id_asignacion` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->asignacion_sol, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `tipo_asignacion` ASC";
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_localidad_sol":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id_loc` AS `LinkFld`, `nombre_loc` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `siax_localidad`";
			$sWhereWrk = "";
			$this->localidad_sol->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`id_loc` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->localidad_sol, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `nombre_loc` ASC";
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_barrio_sol":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `cod_sec` AS `LinkFld`, `nombre_sec` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `siax_sectores`";
			$sWhereWrk = "{filter}";
			$this->barrio_sol->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`cod_sec` = {filter_value}", "t0" => "3", "fn0" => "", "f1" => "`localidad` IN ({filter_value})", "t1" => "3", "fn1" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->barrio_sol, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `nombre_sec` ASC";
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_estado_sol":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id_estado_preventa` AS `LinkFld`, `nombre_estado_preventa` AS `DispFld`, `detalle_estado_preventa` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ap_estado_preventa`";
			$sWhereWrk = "";
			$this->estado_sol->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`id_estado_preventa` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->estado_sol, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `nombre_estado_preventa` ASC";
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		}
	}

	// Setup AutoSuggest filters of a field
	function SetupAutoSuggestFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		}
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	// $type = ''|'success'|'failure'|'warning'
	function Message_Showing(&$msg, $type) {
		if ($type == 'success') {

			//$msg = "your success message";
		} elseif ($type == 'failure') {

			//$msg = "your failure message";
		} elseif ($type == 'warning') {

			//$msg = "your warning message";
		} else {

			//$msg = "your message";
		}
	}

	// Page Render event
	function Page_Render() {

		//echo "Page Render";
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($ap_solicitud_edit)) $ap_solicitud_edit = new cap_solicitud_edit();

// Page init
$ap_solicitud_edit->Page_Init();

// Page main
$ap_solicitud_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$ap_solicitud_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fap_solicitudedit = new ew_Form("fap_solicitudedit", "edit");

// Validate form
fap_solicitudedit.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
			elm = this.GetElements("x" + infix + "_poliza_sol");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ap_solicitud->poliza_sol->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_demanda_sol");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ap_solicitud->demanda_sol->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_archivos_sol");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ap_solicitud->archivos_sol->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_cedula_sol");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ap_solicitud->cedula_sol->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_nombre_sol");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ap_solicitud->nombre_sol->FldCaption(), $ap_solicitud->nombre_sol->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_localidad_sol");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ap_solicitud->localidad_sol->FldCaption(), $ap_solicitud->localidad_sol->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_servicio_sol");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ap_solicitud->servicio_sol->FldCaption(), $ap_solicitud->servicio_sol->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_fecha_visita_comerc_sol");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ap_solicitud->fecha_visita_comerc_sol->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}

	// Process detail forms
	var dfs = $fobj.find("input[name='detailpage']").get();
	for (var i = 0; i < dfs.length; i++) {
		var df = dfs[i], val = df.value;
		if (val && ewForms[val])
			if (!ewForms[val].Validate())
				return false;
	}
	return true;
}

// Form_CustomValidate event
fap_solicitudedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fap_solicitudedit.ValidateRequired = true;
<?php } else { ?>
fap_solicitudedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fap_solicitudedit.Lists["x_asesor_sol"] = {"LinkField":"x_Id_tercero","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre_tercero","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"ap_terceros"};
fap_solicitudedit.Lists["x_asignacion_sol"] = {"LinkField":"x_id_asignacion","Ajax":true,"AutoFill":false,"DisplayFields":["x_tipo_asignacion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"ap_asignacion"};
fap_solicitudedit.Lists["x_localidad_sol"] = {"LinkField":"x_id_loc","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre_loc","","",""],"ParentFields":[],"ChildFields":["x_barrio_sol"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"siax_localidad"};
fap_solicitudedit.Lists["x_barrio_sol"] = {"LinkField":"x_cod_sec","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre_sec","","",""],"ParentFields":["x_localidad_sol"],"ChildFields":[],"FilterFields":["x_localidad"],"Options":[],"Template":"","LinkTable":"siax_sectores"};
fap_solicitudedit.Lists["x_estado_sol"] = {"LinkField":"x_id_estado_preventa","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre_estado_preventa","x_detalle_estado_preventa","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"ap_estado_preventa"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$ap_solicitud_edit->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $ap_solicitud_edit->ShowPageHeader(); ?>
<?php
$ap_solicitud_edit->ShowMessage();
?>
<form name="fap_solicitudedit" id="fap_solicitudedit" class="<?php echo $ap_solicitud_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($ap_solicitud_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $ap_solicitud_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="ap_solicitud">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<?php if ($ap_solicitud_edit->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($ap_solicitud->id_sol->Visible) { // id_sol ?>
	<div id="r_id_sol" class="form-group">
		<label id="elh_ap_solicitud_id_sol" class="col-sm-2 control-label ewLabel"><?php echo $ap_solicitud->id_sol->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_solicitud->id_sol->CellAttributes() ?>>
<span id="el_ap_solicitud_id_sol">
<span<?php echo $ap_solicitud->id_sol->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $ap_solicitud->id_sol->EditValue ?></p></span>
</span>
<input type="hidden" data-table="ap_solicitud" data-field="x_id_sol" name="x_id_sol" id="x_id_sol" value="<?php echo ew_HtmlEncode($ap_solicitud->id_sol->CurrentValue) ?>">
<?php echo $ap_solicitud->id_sol->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_solicitud->poliza_sol->Visible) { // poliza_sol ?>
	<div id="r_poliza_sol" class="form-group">
		<label id="elh_ap_solicitud_poliza_sol" for="x_poliza_sol" class="col-sm-2 control-label ewLabel"><?php echo $ap_solicitud->poliza_sol->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_solicitud->poliza_sol->CellAttributes() ?>>
<span id="el_ap_solicitud_poliza_sol">
<input type="text" data-table="ap_solicitud" data-field="x_poliza_sol" name="x_poliza_sol" id="x_poliza_sol" size="30" placeholder="<?php echo ew_HtmlEncode($ap_solicitud->poliza_sol->getPlaceHolder()) ?>" value="<?php echo $ap_solicitud->poliza_sol->EditValue ?>"<?php echo $ap_solicitud->poliza_sol->EditAttributes() ?>>
</span>
<?php echo $ap_solicitud->poliza_sol->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_solicitud->demanda_sol->Visible) { // demanda_sol ?>
	<div id="r_demanda_sol" class="form-group">
		<label id="elh_ap_solicitud_demanda_sol" for="x_demanda_sol" class="col-sm-2 control-label ewLabel"><?php echo $ap_solicitud->demanda_sol->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_solicitud->demanda_sol->CellAttributes() ?>>
<span id="el_ap_solicitud_demanda_sol">
<input type="text" data-table="ap_solicitud" data-field="x_demanda_sol" name="x_demanda_sol" id="x_demanda_sol" size="30" placeholder="<?php echo ew_HtmlEncode($ap_solicitud->demanda_sol->getPlaceHolder()) ?>" value="<?php echo $ap_solicitud->demanda_sol->EditValue ?>"<?php echo $ap_solicitud->demanda_sol->EditAttributes() ?>>
</span>
<?php echo $ap_solicitud->demanda_sol->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_solicitud->asesor_sol->Visible) { // asesor_sol ?>
	<div id="r_asesor_sol" class="form-group">
		<label id="elh_ap_solicitud_asesor_sol" for="x_asesor_sol" class="col-sm-2 control-label ewLabel"><?php echo $ap_solicitud->asesor_sol->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_solicitud->asesor_sol->CellAttributes() ?>>
<span id="el_ap_solicitud_asesor_sol">
<select data-table="ap_solicitud" data-field="x_asesor_sol" data-value-separator="<?php echo $ap_solicitud->asesor_sol->DisplayValueSeparatorAttribute() ?>" id="x_asesor_sol" name="x_asesor_sol"<?php echo $ap_solicitud->asesor_sol->EditAttributes() ?>>
<?php echo $ap_solicitud->asesor_sol->SelectOptionListHtml("x_asesor_sol") ?>
</select>
<input type="hidden" name="s_x_asesor_sol" id="s_x_asesor_sol" value="<?php echo $ap_solicitud->asesor_sol->LookupFilterQuery() ?>">
</span>
<?php echo $ap_solicitud->asesor_sol->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_solicitud->archivos_sol->Visible) { // archivos_sol ?>
	<div id="r_archivos_sol" class="form-group">
		<label id="elh_ap_solicitud_archivos_sol" for="x_archivos_sol" class="col-sm-2 control-label ewLabel"><?php echo $ap_solicitud->archivos_sol->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_solicitud->archivos_sol->CellAttributes() ?>>
<span id="el_ap_solicitud_archivos_sol">
<input type="text" data-table="ap_solicitud" data-field="x_archivos_sol" name="x_archivos_sol" id="x_archivos_sol" size="30" placeholder="<?php echo ew_HtmlEncode($ap_solicitud->archivos_sol->getPlaceHolder()) ?>" value="<?php echo $ap_solicitud->archivos_sol->EditValue ?>"<?php echo $ap_solicitud->archivos_sol->EditAttributes() ?>>
</span>
<?php echo $ap_solicitud->archivos_sol->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_solicitud->asignacion_sol->Visible) { // asignacion_sol ?>
	<div id="r_asignacion_sol" class="form-group">
		<label id="elh_ap_solicitud_asignacion_sol" for="x_asignacion_sol" class="col-sm-2 control-label ewLabel"><?php echo $ap_solicitud->asignacion_sol->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_solicitud->asignacion_sol->CellAttributes() ?>>
<span id="el_ap_solicitud_asignacion_sol">
<select data-table="ap_solicitud" data-field="x_asignacion_sol" data-value-separator="<?php echo $ap_solicitud->asignacion_sol->DisplayValueSeparatorAttribute() ?>" id="x_asignacion_sol" name="x_asignacion_sol"<?php echo $ap_solicitud->asignacion_sol->EditAttributes() ?>>
<?php echo $ap_solicitud->asignacion_sol->SelectOptionListHtml("x_asignacion_sol") ?>
</select>
<input type="hidden" name="s_x_asignacion_sol" id="s_x_asignacion_sol" value="<?php echo $ap_solicitud->asignacion_sol->LookupFilterQuery() ?>">
</span>
<?php echo $ap_solicitud->asignacion_sol->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_solicitud->cedula_sol->Visible) { // cedula_sol ?>
	<div id="r_cedula_sol" class="form-group">
		<label id="elh_ap_solicitud_cedula_sol" for="x_cedula_sol" class="col-sm-2 control-label ewLabel"><?php echo $ap_solicitud->cedula_sol->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_solicitud->cedula_sol->CellAttributes() ?>>
<span id="el_ap_solicitud_cedula_sol">
<input type="text" data-table="ap_solicitud" data-field="x_cedula_sol" name="x_cedula_sol" id="x_cedula_sol" size="30" placeholder="<?php echo ew_HtmlEncode($ap_solicitud->cedula_sol->getPlaceHolder()) ?>" value="<?php echo $ap_solicitud->cedula_sol->EditValue ?>"<?php echo $ap_solicitud->cedula_sol->EditAttributes() ?>>
</span>
<?php echo $ap_solicitud->cedula_sol->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_solicitud->nombre_sol->Visible) { // nombre_sol ?>
	<div id="r_nombre_sol" class="form-group">
		<label id="elh_ap_solicitud_nombre_sol" for="x_nombre_sol" class="col-sm-2 control-label ewLabel"><?php echo $ap_solicitud->nombre_sol->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $ap_solicitud->nombre_sol->CellAttributes() ?>>
<span id="el_ap_solicitud_nombre_sol">
<input type="text" data-table="ap_solicitud" data-field="x_nombre_sol" name="x_nombre_sol" id="x_nombre_sol" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($ap_solicitud->nombre_sol->getPlaceHolder()) ?>" value="<?php echo $ap_solicitud->nombre_sol->EditValue ?>"<?php echo $ap_solicitud->nombre_sol->EditAttributes() ?>>
</span>
<?php echo $ap_solicitud->nombre_sol->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_solicitud->direccion_pol_sol->Visible) { // direccion_pol_sol ?>
	<div id="r_direccion_pol_sol" class="form-group">
		<label id="elh_ap_solicitud_direccion_pol_sol" for="x_direccion_pol_sol" class="col-sm-2 control-label ewLabel"><?php echo $ap_solicitud->direccion_pol_sol->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_solicitud->direccion_pol_sol->CellAttributes() ?>>
<span id="el_ap_solicitud_direccion_pol_sol">
<input type="text" data-table="ap_solicitud" data-field="x_direccion_pol_sol" name="x_direccion_pol_sol" id="x_direccion_pol_sol" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($ap_solicitud->direccion_pol_sol->getPlaceHolder()) ?>" value="<?php echo $ap_solicitud->direccion_pol_sol->EditValue ?>"<?php echo $ap_solicitud->direccion_pol_sol->EditAttributes() ?>>
</span>
<?php echo $ap_solicitud->direccion_pol_sol->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_solicitud->direccion_nueva_sol->Visible) { // direccion_nueva_sol ?>
	<div id="r_direccion_nueva_sol" class="form-group">
		<label id="elh_ap_solicitud_direccion_nueva_sol" for="x_direccion_nueva_sol" class="col-sm-2 control-label ewLabel"><?php echo $ap_solicitud->direccion_nueva_sol->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_solicitud->direccion_nueva_sol->CellAttributes() ?>>
<span id="el_ap_solicitud_direccion_nueva_sol">
<input type="text" data-table="ap_solicitud" data-field="x_direccion_nueva_sol" name="x_direccion_nueva_sol" id="x_direccion_nueva_sol" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($ap_solicitud->direccion_nueva_sol->getPlaceHolder()) ?>" value="<?php echo $ap_solicitud->direccion_nueva_sol->EditValue ?>"<?php echo $ap_solicitud->direccion_nueva_sol->EditAttributes() ?>>
</span>
<?php echo $ap_solicitud->direccion_nueva_sol->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_solicitud->localidad_sol->Visible) { // localidad_sol ?>
	<div id="r_localidad_sol" class="form-group">
		<label id="elh_ap_solicitud_localidad_sol" for="x_localidad_sol" class="col-sm-2 control-label ewLabel"><?php echo $ap_solicitud->localidad_sol->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $ap_solicitud->localidad_sol->CellAttributes() ?>>
<span id="el_ap_solicitud_localidad_sol">
<?php $ap_solicitud->localidad_sol->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$ap_solicitud->localidad_sol->EditAttrs["onchange"]; ?>
<select data-table="ap_solicitud" data-field="x_localidad_sol" data-value-separator="<?php echo $ap_solicitud->localidad_sol->DisplayValueSeparatorAttribute() ?>" id="x_localidad_sol" name="x_localidad_sol"<?php echo $ap_solicitud->localidad_sol->EditAttributes() ?>>
<?php echo $ap_solicitud->localidad_sol->SelectOptionListHtml("x_localidad_sol") ?>
</select>
<input type="hidden" name="s_x_localidad_sol" id="s_x_localidad_sol" value="<?php echo $ap_solicitud->localidad_sol->LookupFilterQuery() ?>">
</span>
<?php echo $ap_solicitud->localidad_sol->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_solicitud->barrio_sol->Visible) { // barrio_sol ?>
	<div id="r_barrio_sol" class="form-group">
		<label id="elh_ap_solicitud_barrio_sol" for="x_barrio_sol" class="col-sm-2 control-label ewLabel"><?php echo $ap_solicitud->barrio_sol->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_solicitud->barrio_sol->CellAttributes() ?>>
<span id="el_ap_solicitud_barrio_sol">
<select data-table="ap_solicitud" data-field="x_barrio_sol" data-value-separator="<?php echo $ap_solicitud->barrio_sol->DisplayValueSeparatorAttribute() ?>" id="x_barrio_sol" name="x_barrio_sol"<?php echo $ap_solicitud->barrio_sol->EditAttributes() ?>>
<?php echo $ap_solicitud->barrio_sol->SelectOptionListHtml("x_barrio_sol") ?>
</select>
<input type="hidden" name="s_x_barrio_sol" id="s_x_barrio_sol" value="<?php echo $ap_solicitud->barrio_sol->LookupFilterQuery() ?>">
</span>
<?php echo $ap_solicitud->barrio_sol->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_solicitud->telefono1_sol->Visible) { // telefono1_sol ?>
	<div id="r_telefono1_sol" class="form-group">
		<label id="elh_ap_solicitud_telefono1_sol" for="x_telefono1_sol" class="col-sm-2 control-label ewLabel"><?php echo $ap_solicitud->telefono1_sol->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_solicitud->telefono1_sol->CellAttributes() ?>>
<span id="el_ap_solicitud_telefono1_sol">
<input type="text" data-table="ap_solicitud" data-field="x_telefono1_sol" name="x_telefono1_sol" id="x_telefono1_sol" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($ap_solicitud->telefono1_sol->getPlaceHolder()) ?>" value="<?php echo $ap_solicitud->telefono1_sol->EditValue ?>"<?php echo $ap_solicitud->telefono1_sol->EditAttributes() ?>>
</span>
<?php echo $ap_solicitud->telefono1_sol->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_solicitud->telefono2_sol->Visible) { // telefono2_sol ?>
	<div id="r_telefono2_sol" class="form-group">
		<label id="elh_ap_solicitud_telefono2_sol" for="x_telefono2_sol" class="col-sm-2 control-label ewLabel"><?php echo $ap_solicitud->telefono2_sol->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_solicitud->telefono2_sol->CellAttributes() ?>>
<span id="el_ap_solicitud_telefono2_sol">
<input type="text" data-table="ap_solicitud" data-field="x_telefono2_sol" name="x_telefono2_sol" id="x_telefono2_sol" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($ap_solicitud->telefono2_sol->getPlaceHolder()) ?>" value="<?php echo $ap_solicitud->telefono2_sol->EditValue ?>"<?php echo $ap_solicitud->telefono2_sol->EditAttributes() ?>>
</span>
<?php echo $ap_solicitud->telefono2_sol->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_solicitud->celular_sol->Visible) { // celular_sol ?>
	<div id="r_celular_sol" class="form-group">
		<label id="elh_ap_solicitud_celular_sol" for="x_celular_sol" class="col-sm-2 control-label ewLabel"><?php echo $ap_solicitud->celular_sol->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_solicitud->celular_sol->CellAttributes() ?>>
<span id="el_ap_solicitud_celular_sol">
<input type="text" data-table="ap_solicitud" data-field="x_celular_sol" name="x_celular_sol" id="x_celular_sol" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($ap_solicitud->celular_sol->getPlaceHolder()) ?>" value="<?php echo $ap_solicitud->celular_sol->EditValue ?>"<?php echo $ap_solicitud->celular_sol->EditAttributes() ?>>
</span>
<?php echo $ap_solicitud->celular_sol->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_solicitud->email_sol->Visible) { // email_sol ?>
	<div id="r_email_sol" class="form-group">
		<label id="elh_ap_solicitud_email_sol" for="x_email_sol" class="col-sm-2 control-label ewLabel"><?php echo $ap_solicitud->email_sol->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_solicitud->email_sol->CellAttributes() ?>>
<span id="el_ap_solicitud_email_sol">
<input type="text" data-table="ap_solicitud" data-field="x_email_sol" name="x_email_sol" id="x_email_sol" size="30" maxlength="80" placeholder="<?php echo ew_HtmlEncode($ap_solicitud->email_sol->getPlaceHolder()) ?>" value="<?php echo $ap_solicitud->email_sol->EditValue ?>"<?php echo $ap_solicitud->email_sol->EditAttributes() ?>>
</span>
<?php echo $ap_solicitud->email_sol->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_solicitud->servicio_sol->Visible) { // servicio_sol ?>
	<div id="r_servicio_sol" class="form-group">
		<label id="elh_ap_solicitud_servicio_sol" for="x_servicio_sol" class="col-sm-2 control-label ewLabel"><?php echo $ap_solicitud->servicio_sol->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $ap_solicitud->servicio_sol->CellAttributes() ?>>
<span id="el_ap_solicitud_servicio_sol">
<input type="text" data-table="ap_solicitud" data-field="x_servicio_sol" name="x_servicio_sol" id="x_servicio_sol" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($ap_solicitud->servicio_sol->getPlaceHolder()) ?>" value="<?php echo $ap_solicitud->servicio_sol->EditValue ?>"<?php echo $ap_solicitud->servicio_sol->EditAttributes() ?>>
</span>
<?php echo $ap_solicitud->servicio_sol->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_solicitud->obs_sol->Visible) { // obs_sol ?>
	<div id="r_obs_sol" class="form-group">
		<label id="elh_ap_solicitud_obs_sol" for="x_obs_sol" class="col-sm-2 control-label ewLabel"><?php echo $ap_solicitud->obs_sol->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_solicitud->obs_sol->CellAttributes() ?>>
<span id="el_ap_solicitud_obs_sol">
<input type="text" data-table="ap_solicitud" data-field="x_obs_sol" name="x_obs_sol" id="x_obs_sol" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($ap_solicitud->obs_sol->getPlaceHolder()) ?>" value="<?php echo $ap_solicitud->obs_sol->EditValue ?>"<?php echo $ap_solicitud->obs_sol->EditAttributes() ?>>
</span>
<?php echo $ap_solicitud->obs_sol->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_solicitud->estado_sol->Visible) { // estado_sol ?>
	<div id="r_estado_sol" class="form-group">
		<label id="elh_ap_solicitud_estado_sol" for="x_estado_sol" class="col-sm-2 control-label ewLabel"><?php echo $ap_solicitud->estado_sol->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_solicitud->estado_sol->CellAttributes() ?>>
<span id="el_ap_solicitud_estado_sol">
<select data-table="ap_solicitud" data-field="x_estado_sol" data-value-separator="<?php echo $ap_solicitud->estado_sol->DisplayValueSeparatorAttribute() ?>" id="x_estado_sol" name="x_estado_sol"<?php echo $ap_solicitud->estado_sol->EditAttributes() ?>>
<?php echo $ap_solicitud->estado_sol->SelectOptionListHtml("x_estado_sol") ?>
</select>
<input type="hidden" name="s_x_estado_sol" id="s_x_estado_sol" value="<?php echo $ap_solicitud->estado_sol->LookupFilterQuery() ?>">
</span>
<?php echo $ap_solicitud->estado_sol->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_solicitud->fecha_prevista_sol->Visible) { // fecha_prevista_sol ?>
	<div id="r_fecha_prevista_sol" class="form-group">
		<label id="elh_ap_solicitud_fecha_prevista_sol" for="x_fecha_prevista_sol" class="col-sm-2 control-label ewLabel"><?php echo $ap_solicitud->fecha_prevista_sol->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_solicitud->fecha_prevista_sol->CellAttributes() ?>>
<span id="el_ap_solicitud_fecha_prevista_sol">
<span<?php echo $ap_solicitud->fecha_prevista_sol->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $ap_solicitud->fecha_prevista_sol->EditValue ?></p></span>
</span>
<input type="hidden" data-table="ap_solicitud" data-field="x_fecha_prevista_sol" name="x_fecha_prevista_sol" id="x_fecha_prevista_sol" value="<?php echo ew_HtmlEncode($ap_solicitud->fecha_prevista_sol->CurrentValue) ?>">
<?php echo $ap_solicitud->fecha_prevista_sol->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_solicitud->fecha_visita_comerc_sol->Visible) { // fecha_visita_comerc_sol ?>
	<div id="r_fecha_visita_comerc_sol" class="form-group">
		<label id="elh_ap_solicitud_fecha_visita_comerc_sol" for="x_fecha_visita_comerc_sol" class="col-sm-2 control-label ewLabel"><?php echo $ap_solicitud->fecha_visita_comerc_sol->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_solicitud->fecha_visita_comerc_sol->CellAttributes() ?>>
<span id="el_ap_solicitud_fecha_visita_comerc_sol">
<input type="text" data-table="ap_solicitud" data-field="x_fecha_visita_comerc_sol" name="x_fecha_visita_comerc_sol" id="x_fecha_visita_comerc_sol" placeholder="<?php echo ew_HtmlEncode($ap_solicitud->fecha_visita_comerc_sol->getPlaceHolder()) ?>" value="<?php echo $ap_solicitud->fecha_visita_comerc_sol->EditValue ?>"<?php echo $ap_solicitud->fecha_visita_comerc_sol->EditAttributes() ?>>
</span>
<?php echo $ap_solicitud->fecha_visita_comerc_sol->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_solicitud->obs_estado_sol->Visible) { // obs_estado_sol ?>
	<div id="r_obs_estado_sol" class="form-group">
		<label id="elh_ap_solicitud_obs_estado_sol" for="x_obs_estado_sol" class="col-sm-2 control-label ewLabel"><?php echo $ap_solicitud->obs_estado_sol->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_solicitud->obs_estado_sol->CellAttributes() ?>>
<span id="el_ap_solicitud_obs_estado_sol">
<span<?php echo $ap_solicitud->obs_estado_sol->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $ap_solicitud->obs_estado_sol->EditValue ?></p></span>
</span>
<input type="hidden" data-table="ap_solicitud" data-field="x_obs_estado_sol" name="x_obs_estado_sol" id="x_obs_estado_sol" value="<?php echo ew_HtmlEncode($ap_solicitud->obs_estado_sol->CurrentValue) ?>">
<?php echo $ap_solicitud->obs_estado_sol->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$ap_solicitud_edit->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $ap_solicitud_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fap_solicitudedit.Init();
</script>
<?php
$ap_solicitud_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$ap_solicitud_edit->Page_Terminate();
?>
