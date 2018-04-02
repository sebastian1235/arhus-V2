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

$ap_solicitud_add = NULL; // Initialize page object first

class cap_solicitud_add extends cap_solicitud {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{6A9AC718-A824-45A3-BED3-A95E91E6986D}";

	// Table name
	var $TableName = 'ap_solicitud';

	// Page object name
	var $PageObjName = 'ap_solicitud_add';

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
			define("EW_PAGE_ID", 'add', TRUE);

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
		if (!$Security->CanAdd()) {
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
		$this->texto_sol->SetVisibility();
		$this->registra_sol->SetVisibility();
		$this->tipo_clientegn_sol->SetVisibility();
		$this->unidad_sol->SetVisibility();
		$this->fecha_reg_sol->SetVisibility();
		$this->obs_sol->SetVisibility();
		$this->empresa_sol->SetVisibility();
		$this->estado_sol->SetVisibility();
		$this->fecha_prevista_sol->SetVisibility();
		$this->user_preventa_sol->SetVisibility();
		$this->quincena_obra_sol->SetVisibility();
		$this->fecha_obra_sol->SetVisibility();
		$this->nombre_tecnico_sol->SetVisibility();
		$this->cod_tecnico_sol->SetVisibility();
		$this->lider_obra_sol->SetVisibility();
		$this->fecha_visita_comerc_sol->SetVisibility();
		$this->obs_estado_sol->SetVisibility();
		$this->forma_pagogn_sol->SetVisibility();

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
	var $FormClassName = "form-horizontal ewForm ewAddForm";
	var $IsModal = FALSE;
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $Priv = 0;
	var $OldRecordset;
	var $CopyRecord;

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

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
			$this->CopyRecord = $this->LoadOldRecord(); // Load old recordset
			$this->LoadFormValues(); // Load form values
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["id_sol"] != "") {
				$this->id_sol->setQueryStringValue($_GET["id_sol"]);
				$this->setKey("id_sol", $this->id_sol->CurrentValue); // Set up key
			} else {
				$this->setKey("id_sol", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if ($this->CopyRecord) {
				$this->CurrentAction = "C"; // Copy record
			} else {
				$this->CurrentAction = "I"; // Display blank record
			}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Validate form if post back
		if (@$_POST["a_add"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues(); // Restore form values
				$this->setFailureMessage($gsFormError);
			}
		} else {
			if ($this->CurrentAction == "I") // Load default values for blank record
				$this->LoadDefaultValues();
		}

		// Perform action based on action code
		switch ($this->CurrentAction) {
			case "I": // Blank record, no action required
				break;
			case "C": // Copy an existing record
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("ap_solicitudlist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "ap_solicitudlist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "ap_solicitudview.php")
						$sReturnUrl = $this->GetViewUrl(); // View page, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values
				}
		}

		// Render row based on row type
		$this->RowType = EW_ROWTYPE_ADD; // Render add type

		// Render row
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		$this->poliza_sol->CurrentValue = NULL;
		$this->poliza_sol->OldValue = $this->poliza_sol->CurrentValue;
		$this->demanda_sol->CurrentValue = 0;
		$this->asesor_sol->CurrentValue = NULL;
		$this->asesor_sol->OldValue = $this->asesor_sol->CurrentValue;
		$this->archivos_sol->CurrentValue = NULL;
		$this->archivos_sol->OldValue = $this->archivos_sol->CurrentValue;
		$this->asignacion_sol->CurrentValue = NULL;
		$this->asignacion_sol->OldValue = $this->asignacion_sol->CurrentValue;
		$this->cedula_sol->CurrentValue = NULL;
		$this->cedula_sol->OldValue = $this->cedula_sol->CurrentValue;
		$this->nombre_sol->CurrentValue = NULL;
		$this->nombre_sol->OldValue = $this->nombre_sol->CurrentValue;
		$this->direccion_pol_sol->CurrentValue = NULL;
		$this->direccion_pol_sol->OldValue = $this->direccion_pol_sol->CurrentValue;
		$this->direccion_nueva_sol->CurrentValue = NULL;
		$this->direccion_nueva_sol->OldValue = $this->direccion_nueva_sol->CurrentValue;
		$this->localidad_sol->CurrentValue = NULL;
		$this->localidad_sol->OldValue = $this->localidad_sol->CurrentValue;
		$this->barrio_sol->CurrentValue = NULL;
		$this->barrio_sol->OldValue = $this->barrio_sol->CurrentValue;
		$this->telefono1_sol->CurrentValue = NULL;
		$this->telefono1_sol->OldValue = $this->telefono1_sol->CurrentValue;
		$this->telefono2_sol->CurrentValue = NULL;
		$this->telefono2_sol->OldValue = $this->telefono2_sol->CurrentValue;
		$this->celular_sol->CurrentValue = NULL;
		$this->celular_sol->OldValue = $this->celular_sol->CurrentValue;
		$this->email_sol->CurrentValue = NULL;
		$this->email_sol->OldValue = $this->email_sol->CurrentValue;
		$this->servicio_sol->CurrentValue = NULL;
		$this->servicio_sol->OldValue = $this->servicio_sol->CurrentValue;
		$this->texto_sol->CurrentValue = "Inscripcion CI";
		$this->registra_sol->CurrentValue = NULL;
		$this->registra_sol->OldValue = $this->registra_sol->CurrentValue;
		$this->tipo_clientegn_sol->CurrentValue = NULL;
		$this->tipo_clientegn_sol->OldValue = $this->tipo_clientegn_sol->CurrentValue;
		$this->unidad_sol->CurrentValue = NULL;
		$this->unidad_sol->OldValue = $this->unidad_sol->CurrentValue;
		$this->fecha_reg_sol->CurrentValue = NULL;
		$this->fecha_reg_sol->OldValue = $this->fecha_reg_sol->CurrentValue;
		$this->obs_sol->CurrentValue = NULL;
		$this->obs_sol->OldValue = $this->obs_sol->CurrentValue;
		$this->empresa_sol->CurrentValue = NULL;
		$this->empresa_sol->OldValue = $this->empresa_sol->CurrentValue;
		$this->estado_sol->CurrentValue = NULL;
		$this->estado_sol->OldValue = $this->estado_sol->CurrentValue;
		$this->fecha_prevista_sol->CurrentValue = NULL;
		$this->fecha_prevista_sol->OldValue = $this->fecha_prevista_sol->CurrentValue;
		$this->user_preventa_sol->CurrentValue = NULL;
		$this->user_preventa_sol->OldValue = $this->user_preventa_sol->CurrentValue;
		$this->quincena_obra_sol->CurrentValue = NULL;
		$this->quincena_obra_sol->OldValue = $this->quincena_obra_sol->CurrentValue;
		$this->fecha_obra_sol->CurrentValue = NULL;
		$this->fecha_obra_sol->OldValue = $this->fecha_obra_sol->CurrentValue;
		$this->nombre_tecnico_sol->CurrentValue = NULL;
		$this->nombre_tecnico_sol->OldValue = $this->nombre_tecnico_sol->CurrentValue;
		$this->cod_tecnico_sol->CurrentValue = NULL;
		$this->cod_tecnico_sol->OldValue = $this->cod_tecnico_sol->CurrentValue;
		$this->lider_obra_sol->CurrentValue = NULL;
		$this->lider_obra_sol->OldValue = $this->lider_obra_sol->CurrentValue;
		$this->fecha_visita_comerc_sol->CurrentValue = NULL;
		$this->fecha_visita_comerc_sol->OldValue = $this->fecha_visita_comerc_sol->CurrentValue;
		$this->obs_estado_sol->CurrentValue = NULL;
		$this->obs_estado_sol->OldValue = $this->obs_estado_sol->CurrentValue;
		$this->forma_pagogn_sol->CurrentValue = NULL;
		$this->forma_pagogn_sol->OldValue = $this->forma_pagogn_sol->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
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
		if (!$this->texto_sol->FldIsDetailKey) {
			$this->texto_sol->setFormValue($objForm->GetValue("x_texto_sol"));
		}
		if (!$this->registra_sol->FldIsDetailKey) {
			$this->registra_sol->setFormValue($objForm->GetValue("x_registra_sol"));
		}
		if (!$this->tipo_clientegn_sol->FldIsDetailKey) {
			$this->tipo_clientegn_sol->setFormValue($objForm->GetValue("x_tipo_clientegn_sol"));
		}
		if (!$this->unidad_sol->FldIsDetailKey) {
			$this->unidad_sol->setFormValue($objForm->GetValue("x_unidad_sol"));
		}
		if (!$this->fecha_reg_sol->FldIsDetailKey) {
			$this->fecha_reg_sol->setFormValue($objForm->GetValue("x_fecha_reg_sol"));
			$this->fecha_reg_sol->CurrentValue = ew_UnFormatDateTime($this->fecha_reg_sol->CurrentValue, 0);
		}
		if (!$this->obs_sol->FldIsDetailKey) {
			$this->obs_sol->setFormValue($objForm->GetValue("x_obs_sol"));
		}
		if (!$this->empresa_sol->FldIsDetailKey) {
			$this->empresa_sol->setFormValue($objForm->GetValue("x_empresa_sol"));
		}
		if (!$this->estado_sol->FldIsDetailKey) {
			$this->estado_sol->setFormValue($objForm->GetValue("x_estado_sol"));
		}
		if (!$this->fecha_prevista_sol->FldIsDetailKey) {
			$this->fecha_prevista_sol->setFormValue($objForm->GetValue("x_fecha_prevista_sol"));
			$this->fecha_prevista_sol->CurrentValue = ew_UnFormatDateTime($this->fecha_prevista_sol->CurrentValue, 0);
		}
		if (!$this->user_preventa_sol->FldIsDetailKey) {
			$this->user_preventa_sol->setFormValue($objForm->GetValue("x_user_preventa_sol"));
		}
		if (!$this->quincena_obra_sol->FldIsDetailKey) {
			$this->quincena_obra_sol->setFormValue($objForm->GetValue("x_quincena_obra_sol"));
		}
		if (!$this->fecha_obra_sol->FldIsDetailKey) {
			$this->fecha_obra_sol->setFormValue($objForm->GetValue("x_fecha_obra_sol"));
			$this->fecha_obra_sol->CurrentValue = ew_UnFormatDateTime($this->fecha_obra_sol->CurrentValue, 0);
		}
		if (!$this->nombre_tecnico_sol->FldIsDetailKey) {
			$this->nombre_tecnico_sol->setFormValue($objForm->GetValue("x_nombre_tecnico_sol"));
		}
		if (!$this->cod_tecnico_sol->FldIsDetailKey) {
			$this->cod_tecnico_sol->setFormValue($objForm->GetValue("x_cod_tecnico_sol"));
		}
		if (!$this->lider_obra_sol->FldIsDetailKey) {
			$this->lider_obra_sol->setFormValue($objForm->GetValue("x_lider_obra_sol"));
		}
		if (!$this->fecha_visita_comerc_sol->FldIsDetailKey) {
			$this->fecha_visita_comerc_sol->setFormValue($objForm->GetValue("x_fecha_visita_comerc_sol"));
			$this->fecha_visita_comerc_sol->CurrentValue = ew_UnFormatDateTime($this->fecha_visita_comerc_sol->CurrentValue, 0);
		}
		if (!$this->obs_estado_sol->FldIsDetailKey) {
			$this->obs_estado_sol->setFormValue($objForm->GetValue("x_obs_estado_sol"));
		}
		if (!$this->forma_pagogn_sol->FldIsDetailKey) {
			$this->forma_pagogn_sol->setFormValue($objForm->GetValue("x_forma_pagogn_sol"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
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
		$this->texto_sol->CurrentValue = $this->texto_sol->FormValue;
		$this->registra_sol->CurrentValue = $this->registra_sol->FormValue;
		$this->tipo_clientegn_sol->CurrentValue = $this->tipo_clientegn_sol->FormValue;
		$this->unidad_sol->CurrentValue = $this->unidad_sol->FormValue;
		$this->fecha_reg_sol->CurrentValue = $this->fecha_reg_sol->FormValue;
		$this->fecha_reg_sol->CurrentValue = ew_UnFormatDateTime($this->fecha_reg_sol->CurrentValue, 0);
		$this->obs_sol->CurrentValue = $this->obs_sol->FormValue;
		$this->empresa_sol->CurrentValue = $this->empresa_sol->FormValue;
		$this->estado_sol->CurrentValue = $this->estado_sol->FormValue;
		$this->fecha_prevista_sol->CurrentValue = $this->fecha_prevista_sol->FormValue;
		$this->fecha_prevista_sol->CurrentValue = ew_UnFormatDateTime($this->fecha_prevista_sol->CurrentValue, 0);
		$this->user_preventa_sol->CurrentValue = $this->user_preventa_sol->FormValue;
		$this->quincena_obra_sol->CurrentValue = $this->quincena_obra_sol->FormValue;
		$this->fecha_obra_sol->CurrentValue = $this->fecha_obra_sol->FormValue;
		$this->fecha_obra_sol->CurrentValue = ew_UnFormatDateTime($this->fecha_obra_sol->CurrentValue, 0);
		$this->nombre_tecnico_sol->CurrentValue = $this->nombre_tecnico_sol->FormValue;
		$this->cod_tecnico_sol->CurrentValue = $this->cod_tecnico_sol->FormValue;
		$this->lider_obra_sol->CurrentValue = $this->lider_obra_sol->FormValue;
		$this->fecha_visita_comerc_sol->CurrentValue = $this->fecha_visita_comerc_sol->FormValue;
		$this->fecha_visita_comerc_sol->CurrentValue = ew_UnFormatDateTime($this->fecha_visita_comerc_sol->CurrentValue, 0);
		$this->obs_estado_sol->CurrentValue = $this->obs_estado_sol->FormValue;
		$this->forma_pagogn_sol->CurrentValue = $this->forma_pagogn_sol->FormValue;
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

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("id_sol")) <> "")
			$this->id_sol->CurrentValue = $this->getKey("id_sol"); // id_sol
		else
			$bValidKey = FALSE;

		// Load old recordset
		if ($bValidKey) {
			$this->CurrentFilter = $this->KeyFilter();
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$this->OldRecordset = ew_LoadRecordset($sSql, $conn);
			$this->LoadRowValues($this->OldRecordset); // Load row values
		} else {
			$this->OldRecordset = NULL;
		}
		return $bValidKey;
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
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

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

			// texto_sol
			$this->texto_sol->EditAttrs["class"] = "form-control";
			$this->texto_sol->EditCustomAttributes = "";
			$this->texto_sol->EditValue = ew_HtmlEncode($this->texto_sol->CurrentValue);
			$this->texto_sol->PlaceHolder = ew_RemoveHtml($this->texto_sol->FldCaption());

			// registra_sol
			$this->registra_sol->EditAttrs["class"] = "form-control";
			$this->registra_sol->EditCustomAttributes = "";
			$this->registra_sol->EditValue = ew_HtmlEncode($this->registra_sol->CurrentValue);
			$this->registra_sol->PlaceHolder = ew_RemoveHtml($this->registra_sol->FldCaption());

			// tipo_clientegn_sol
			$this->tipo_clientegn_sol->EditAttrs["class"] = "form-control";
			$this->tipo_clientegn_sol->EditCustomAttributes = "";
			$this->tipo_clientegn_sol->EditValue = ew_HtmlEncode($this->tipo_clientegn_sol->CurrentValue);
			$this->tipo_clientegn_sol->PlaceHolder = ew_RemoveHtml($this->tipo_clientegn_sol->FldCaption());

			// unidad_sol
			$this->unidad_sol->EditAttrs["class"] = "form-control";
			$this->unidad_sol->EditCustomAttributes = "";
			$this->unidad_sol->EditValue = ew_HtmlEncode($this->unidad_sol->CurrentValue);
			$this->unidad_sol->PlaceHolder = ew_RemoveHtml($this->unidad_sol->FldCaption());

			// fecha_reg_sol
			$this->fecha_reg_sol->EditAttrs["class"] = "form-control";
			$this->fecha_reg_sol->EditCustomAttributes = "";
			$this->fecha_reg_sol->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->fecha_reg_sol->CurrentValue, 8));
			$this->fecha_reg_sol->PlaceHolder = ew_RemoveHtml($this->fecha_reg_sol->FldCaption());

			// obs_sol
			$this->obs_sol->EditAttrs["class"] = "form-control";
			$this->obs_sol->EditCustomAttributes = "";
			$this->obs_sol->EditValue = ew_HtmlEncode($this->obs_sol->CurrentValue);
			$this->obs_sol->PlaceHolder = ew_RemoveHtml($this->obs_sol->FldCaption());

			// empresa_sol
			$this->empresa_sol->EditAttrs["class"] = "form-control";
			$this->empresa_sol->EditCustomAttributes = "";
			$this->empresa_sol->EditValue = ew_HtmlEncode($this->empresa_sol->CurrentValue);
			$this->empresa_sol->PlaceHolder = ew_RemoveHtml($this->empresa_sol->FldCaption());

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
			$this->fecha_prevista_sol->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->fecha_prevista_sol->CurrentValue, 8));
			$this->fecha_prevista_sol->PlaceHolder = ew_RemoveHtml($this->fecha_prevista_sol->FldCaption());

			// user_preventa_sol
			$this->user_preventa_sol->EditAttrs["class"] = "form-control";
			$this->user_preventa_sol->EditCustomAttributes = "";
			$this->user_preventa_sol->EditValue = ew_HtmlEncode($this->user_preventa_sol->CurrentValue);
			$this->user_preventa_sol->PlaceHolder = ew_RemoveHtml($this->user_preventa_sol->FldCaption());

			// quincena_obra_sol
			$this->quincena_obra_sol->EditAttrs["class"] = "form-control";
			$this->quincena_obra_sol->EditCustomAttributes = "";
			$this->quincena_obra_sol->EditValue = ew_HtmlEncode($this->quincena_obra_sol->CurrentValue);
			$this->quincena_obra_sol->PlaceHolder = ew_RemoveHtml($this->quincena_obra_sol->FldCaption());

			// fecha_obra_sol
			$this->fecha_obra_sol->EditAttrs["class"] = "form-control";
			$this->fecha_obra_sol->EditCustomAttributes = "";
			$this->fecha_obra_sol->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->fecha_obra_sol->CurrentValue, 8));
			$this->fecha_obra_sol->PlaceHolder = ew_RemoveHtml($this->fecha_obra_sol->FldCaption());

			// nombre_tecnico_sol
			$this->nombre_tecnico_sol->EditAttrs["class"] = "form-control";
			$this->nombre_tecnico_sol->EditCustomAttributes = "";
			$this->nombre_tecnico_sol->EditValue = ew_HtmlEncode($this->nombre_tecnico_sol->CurrentValue);
			$this->nombre_tecnico_sol->PlaceHolder = ew_RemoveHtml($this->nombre_tecnico_sol->FldCaption());

			// cod_tecnico_sol
			$this->cod_tecnico_sol->EditAttrs["class"] = "form-control";
			$this->cod_tecnico_sol->EditCustomAttributes = "";
			$this->cod_tecnico_sol->EditValue = ew_HtmlEncode($this->cod_tecnico_sol->CurrentValue);
			$this->cod_tecnico_sol->PlaceHolder = ew_RemoveHtml($this->cod_tecnico_sol->FldCaption());

			// lider_obra_sol
			$this->lider_obra_sol->EditAttrs["class"] = "form-control";
			$this->lider_obra_sol->EditCustomAttributes = "";
			$this->lider_obra_sol->EditValue = ew_HtmlEncode($this->lider_obra_sol->CurrentValue);
			$this->lider_obra_sol->PlaceHolder = ew_RemoveHtml($this->lider_obra_sol->FldCaption());

			// fecha_visita_comerc_sol
			$this->fecha_visita_comerc_sol->EditAttrs["class"] = "form-control";
			$this->fecha_visita_comerc_sol->EditCustomAttributes = "";
			$this->fecha_visita_comerc_sol->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->fecha_visita_comerc_sol->CurrentValue, 8));
			$this->fecha_visita_comerc_sol->PlaceHolder = ew_RemoveHtml($this->fecha_visita_comerc_sol->FldCaption());

			// obs_estado_sol
			$this->obs_estado_sol->EditAttrs["class"] = "form-control";
			$this->obs_estado_sol->EditCustomAttributes = "";
			$this->obs_estado_sol->EditValue = ew_HtmlEncode($this->obs_estado_sol->CurrentValue);
			$this->obs_estado_sol->PlaceHolder = ew_RemoveHtml($this->obs_estado_sol->FldCaption());

			// forma_pagogn_sol
			$this->forma_pagogn_sol->EditAttrs["class"] = "form-control";
			$this->forma_pagogn_sol->EditCustomAttributes = "";
			$this->forma_pagogn_sol->EditValue = ew_HtmlEncode($this->forma_pagogn_sol->CurrentValue);
			$this->forma_pagogn_sol->PlaceHolder = ew_RemoveHtml($this->forma_pagogn_sol->FldCaption());

			// Add refer script
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

			// texto_sol
			$this->texto_sol->LinkCustomAttributes = "";
			$this->texto_sol->HrefValue = "";

			// registra_sol
			$this->registra_sol->LinkCustomAttributes = "";
			$this->registra_sol->HrefValue = "";

			// tipo_clientegn_sol
			$this->tipo_clientegn_sol->LinkCustomAttributes = "";
			$this->tipo_clientegn_sol->HrefValue = "";

			// unidad_sol
			$this->unidad_sol->LinkCustomAttributes = "";
			$this->unidad_sol->HrefValue = "";

			// fecha_reg_sol
			$this->fecha_reg_sol->LinkCustomAttributes = "";
			$this->fecha_reg_sol->HrefValue = "";

			// obs_sol
			$this->obs_sol->LinkCustomAttributes = "";
			$this->obs_sol->HrefValue = "";

			// empresa_sol
			$this->empresa_sol->LinkCustomAttributes = "";
			$this->empresa_sol->HrefValue = "";

			// estado_sol
			$this->estado_sol->LinkCustomAttributes = "";
			$this->estado_sol->HrefValue = "";

			// fecha_prevista_sol
			$this->fecha_prevista_sol->LinkCustomAttributes = "";
			$this->fecha_prevista_sol->HrefValue = "";

			// user_preventa_sol
			$this->user_preventa_sol->LinkCustomAttributes = "";
			$this->user_preventa_sol->HrefValue = "";

			// quincena_obra_sol
			$this->quincena_obra_sol->LinkCustomAttributes = "";
			$this->quincena_obra_sol->HrefValue = "";

			// fecha_obra_sol
			$this->fecha_obra_sol->LinkCustomAttributes = "";
			$this->fecha_obra_sol->HrefValue = "";

			// nombre_tecnico_sol
			$this->nombre_tecnico_sol->LinkCustomAttributes = "";
			$this->nombre_tecnico_sol->HrefValue = "";

			// cod_tecnico_sol
			$this->cod_tecnico_sol->LinkCustomAttributes = "";
			$this->cod_tecnico_sol->HrefValue = "";

			// lider_obra_sol
			$this->lider_obra_sol->LinkCustomAttributes = "";
			$this->lider_obra_sol->HrefValue = "";

			// fecha_visita_comerc_sol
			$this->fecha_visita_comerc_sol->LinkCustomAttributes = "";
			$this->fecha_visita_comerc_sol->HrefValue = "";

			// obs_estado_sol
			$this->obs_estado_sol->LinkCustomAttributes = "";
			$this->obs_estado_sol->HrefValue = "";

			// forma_pagogn_sol
			$this->forma_pagogn_sol->LinkCustomAttributes = "";
			$this->forma_pagogn_sol->HrefValue = "";
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
		if (!ew_CheckInteger($this->tipo_clientegn_sol->FormValue)) {
			ew_AddMessage($gsFormError, $this->tipo_clientegn_sol->FldErrMsg());
		}
		if (!ew_CheckInteger($this->unidad_sol->FormValue)) {
			ew_AddMessage($gsFormError, $this->unidad_sol->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->fecha_reg_sol->FormValue)) {
			ew_AddMessage($gsFormError, $this->fecha_reg_sol->FldErrMsg());
		}
		if (!ew_CheckInteger($this->empresa_sol->FormValue)) {
			ew_AddMessage($gsFormError, $this->empresa_sol->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->fecha_prevista_sol->FormValue)) {
			ew_AddMessage($gsFormError, $this->fecha_prevista_sol->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->fecha_obra_sol->FormValue)) {
			ew_AddMessage($gsFormError, $this->fecha_obra_sol->FldErrMsg());
		}
		if (!ew_CheckInteger($this->cod_tecnico_sol->FormValue)) {
			ew_AddMessage($gsFormError, $this->cod_tecnico_sol->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->fecha_visita_comerc_sol->FormValue)) {
			ew_AddMessage($gsFormError, $this->fecha_visita_comerc_sol->FldErrMsg());
		}
		if (!ew_CheckInteger($this->forma_pagogn_sol->FormValue)) {
			ew_AddMessage($gsFormError, $this->forma_pagogn_sol->FldErrMsg());
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

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;
		$conn = &$this->Connection();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// poliza_sol
		$this->poliza_sol->SetDbValueDef($rsnew, $this->poliza_sol->CurrentValue, NULL, FALSE);

		// demanda_sol
		$this->demanda_sol->SetDbValueDef($rsnew, $this->demanda_sol->CurrentValue, NULL, strval($this->demanda_sol->CurrentValue) == "");

		// asesor_sol
		$this->asesor_sol->SetDbValueDef($rsnew, $this->asesor_sol->CurrentValue, NULL, FALSE);

		// archivos_sol
		$this->archivos_sol->SetDbValueDef($rsnew, $this->archivos_sol->CurrentValue, NULL, FALSE);

		// asignacion_sol
		$this->asignacion_sol->SetDbValueDef($rsnew, $this->asignacion_sol->CurrentValue, NULL, FALSE);

		// cedula_sol
		$this->cedula_sol->SetDbValueDef($rsnew, $this->cedula_sol->CurrentValue, NULL, FALSE);

		// nombre_sol
		$this->nombre_sol->SetDbValueDef($rsnew, $this->nombre_sol->CurrentValue, "", FALSE);

		// direccion_pol_sol
		$this->direccion_pol_sol->SetDbValueDef($rsnew, $this->direccion_pol_sol->CurrentValue, NULL, FALSE);

		// direccion_nueva_sol
		$this->direccion_nueva_sol->SetDbValueDef($rsnew, $this->direccion_nueva_sol->CurrentValue, NULL, FALSE);

		// localidad_sol
		$this->localidad_sol->SetDbValueDef($rsnew, $this->localidad_sol->CurrentValue, 0, FALSE);

		// barrio_sol
		$this->barrio_sol->SetDbValueDef($rsnew, $this->barrio_sol->CurrentValue, NULL, FALSE);

		// telefono1_sol
		$this->telefono1_sol->SetDbValueDef($rsnew, $this->telefono1_sol->CurrentValue, NULL, FALSE);

		// telefono2_sol
		$this->telefono2_sol->SetDbValueDef($rsnew, $this->telefono2_sol->CurrentValue, NULL, FALSE);

		// celular_sol
		$this->celular_sol->SetDbValueDef($rsnew, $this->celular_sol->CurrentValue, NULL, FALSE);

		// email_sol
		$this->email_sol->SetDbValueDef($rsnew, $this->email_sol->CurrentValue, NULL, FALSE);

		// servicio_sol
		$this->servicio_sol->SetDbValueDef($rsnew, $this->servicio_sol->CurrentValue, "", FALSE);

		// texto_sol
		$this->texto_sol->SetDbValueDef($rsnew, $this->texto_sol->CurrentValue, NULL, strval($this->texto_sol->CurrentValue) == "");

		// registra_sol
		$this->registra_sol->SetDbValueDef($rsnew, $this->registra_sol->CurrentValue, NULL, FALSE);

		// tipo_clientegn_sol
		$this->tipo_clientegn_sol->SetDbValueDef($rsnew, $this->tipo_clientegn_sol->CurrentValue, NULL, FALSE);

		// unidad_sol
		$this->unidad_sol->SetDbValueDef($rsnew, $this->unidad_sol->CurrentValue, NULL, FALSE);

		// fecha_reg_sol
		$this->fecha_reg_sol->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->fecha_reg_sol->CurrentValue, 0), NULL, FALSE);

		// obs_sol
		$this->obs_sol->SetDbValueDef($rsnew, $this->obs_sol->CurrentValue, NULL, FALSE);

		// empresa_sol
		$this->empresa_sol->SetDbValueDef($rsnew, $this->empresa_sol->CurrentValue, NULL, FALSE);

		// estado_sol
		$this->estado_sol->SetDbValueDef($rsnew, $this->estado_sol->CurrentValue, NULL, FALSE);

		// fecha_prevista_sol
		$this->fecha_prevista_sol->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->fecha_prevista_sol->CurrentValue, 0), NULL, FALSE);

		// user_preventa_sol
		$this->user_preventa_sol->SetDbValueDef($rsnew, $this->user_preventa_sol->CurrentValue, NULL, FALSE);

		// quincena_obra_sol
		$this->quincena_obra_sol->SetDbValueDef($rsnew, $this->quincena_obra_sol->CurrentValue, NULL, FALSE);

		// fecha_obra_sol
		$this->fecha_obra_sol->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->fecha_obra_sol->CurrentValue, 0), NULL, FALSE);

		// nombre_tecnico_sol
		$this->nombre_tecnico_sol->SetDbValueDef($rsnew, $this->nombre_tecnico_sol->CurrentValue, NULL, FALSE);

		// cod_tecnico_sol
		$this->cod_tecnico_sol->SetDbValueDef($rsnew, $this->cod_tecnico_sol->CurrentValue, NULL, FALSE);

		// lider_obra_sol
		$this->lider_obra_sol->SetDbValueDef($rsnew, $this->lider_obra_sol->CurrentValue, NULL, FALSE);

		// fecha_visita_comerc_sol
		$this->fecha_visita_comerc_sol->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->fecha_visita_comerc_sol->CurrentValue, 0), NULL, FALSE);

		// obs_estado_sol
		$this->obs_estado_sol->SetDbValueDef($rsnew, $this->obs_estado_sol->CurrentValue, NULL, FALSE);

		// forma_pagogn_sol
		$this->forma_pagogn_sol->SetDbValueDef($rsnew, $this->forma_pagogn_sol->CurrentValue, NULL, FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {

				// Get insert id if necessary
				$this->id_sol->setDbValue($conn->Insert_ID());
				$rsnew['id_sol'] = $this->id_sol->DbValue;
			}
		} else {
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("ap_solicitudlist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
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
if (!isset($ap_solicitud_add)) $ap_solicitud_add = new cap_solicitud_add();

// Page init
$ap_solicitud_add->Page_Init();

// Page main
$ap_solicitud_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$ap_solicitud_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fap_solicitudadd = new ew_Form("fap_solicitudadd", "add");

// Validate form
fap_solicitudadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_tipo_clientegn_sol");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ap_solicitud->tipo_clientegn_sol->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_unidad_sol");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ap_solicitud->unidad_sol->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_fecha_reg_sol");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ap_solicitud->fecha_reg_sol->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_empresa_sol");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ap_solicitud->empresa_sol->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_fecha_prevista_sol");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ap_solicitud->fecha_prevista_sol->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_fecha_obra_sol");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ap_solicitud->fecha_obra_sol->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_cod_tecnico_sol");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ap_solicitud->cod_tecnico_sol->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_fecha_visita_comerc_sol");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ap_solicitud->fecha_visita_comerc_sol->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_forma_pagogn_sol");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ap_solicitud->forma_pagogn_sol->FldErrMsg()) ?>");

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
fap_solicitudadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fap_solicitudadd.ValidateRequired = true;
<?php } else { ?>
fap_solicitudadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fap_solicitudadd.Lists["x_asesor_sol"] = {"LinkField":"x_Id_tercero","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre_tercero","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"ap_terceros"};
fap_solicitudadd.Lists["x_asignacion_sol"] = {"LinkField":"x_id_asignacion","Ajax":true,"AutoFill":false,"DisplayFields":["x_tipo_asignacion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"ap_asignacion"};
fap_solicitudadd.Lists["x_localidad_sol"] = {"LinkField":"x_id_loc","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre_loc","","",""],"ParentFields":[],"ChildFields":["x_barrio_sol"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"siax_localidad"};
fap_solicitudadd.Lists["x_barrio_sol"] = {"LinkField":"x_cod_sec","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre_sec","","",""],"ParentFields":["x_localidad_sol"],"ChildFields":[],"FilterFields":["x_localidad"],"Options":[],"Template":"","LinkTable":"siax_sectores"};
fap_solicitudadd.Lists["x_estado_sol"] = {"LinkField":"x_id_estado_preventa","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre_estado_preventa","x_detalle_estado_preventa","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"ap_estado_preventa"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$ap_solicitud_add->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $ap_solicitud_add->ShowPageHeader(); ?>
<?php
$ap_solicitud_add->ShowMessage();
?>
<form name="fap_solicitudadd" id="fap_solicitudadd" class="<?php echo $ap_solicitud_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($ap_solicitud_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $ap_solicitud_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="ap_solicitud">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($ap_solicitud_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
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
<?php if ($ap_solicitud->texto_sol->Visible) { // texto_sol ?>
	<div id="r_texto_sol" class="form-group">
		<label id="elh_ap_solicitud_texto_sol" for="x_texto_sol" class="col-sm-2 control-label ewLabel"><?php echo $ap_solicitud->texto_sol->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_solicitud->texto_sol->CellAttributes() ?>>
<span id="el_ap_solicitud_texto_sol">
<input type="text" data-table="ap_solicitud" data-field="x_texto_sol" name="x_texto_sol" id="x_texto_sol" size="30" maxlength="80" placeholder="<?php echo ew_HtmlEncode($ap_solicitud->texto_sol->getPlaceHolder()) ?>" value="<?php echo $ap_solicitud->texto_sol->EditValue ?>"<?php echo $ap_solicitud->texto_sol->EditAttributes() ?>>
</span>
<?php echo $ap_solicitud->texto_sol->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_solicitud->registra_sol->Visible) { // registra_sol ?>
	<div id="r_registra_sol" class="form-group">
		<label id="elh_ap_solicitud_registra_sol" for="x_registra_sol" class="col-sm-2 control-label ewLabel"><?php echo $ap_solicitud->registra_sol->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_solicitud->registra_sol->CellAttributes() ?>>
<span id="el_ap_solicitud_registra_sol">
<input type="text" data-table="ap_solicitud" data-field="x_registra_sol" name="x_registra_sol" id="x_registra_sol" size="30" maxlength="80" placeholder="<?php echo ew_HtmlEncode($ap_solicitud->registra_sol->getPlaceHolder()) ?>" value="<?php echo $ap_solicitud->registra_sol->EditValue ?>"<?php echo $ap_solicitud->registra_sol->EditAttributes() ?>>
</span>
<?php echo $ap_solicitud->registra_sol->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_solicitud->tipo_clientegn_sol->Visible) { // tipo_clientegn_sol ?>
	<div id="r_tipo_clientegn_sol" class="form-group">
		<label id="elh_ap_solicitud_tipo_clientegn_sol" for="x_tipo_clientegn_sol" class="col-sm-2 control-label ewLabel"><?php echo $ap_solicitud->tipo_clientegn_sol->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_solicitud->tipo_clientegn_sol->CellAttributes() ?>>
<span id="el_ap_solicitud_tipo_clientegn_sol">
<input type="text" data-table="ap_solicitud" data-field="x_tipo_clientegn_sol" name="x_tipo_clientegn_sol" id="x_tipo_clientegn_sol" size="30" placeholder="<?php echo ew_HtmlEncode($ap_solicitud->tipo_clientegn_sol->getPlaceHolder()) ?>" value="<?php echo $ap_solicitud->tipo_clientegn_sol->EditValue ?>"<?php echo $ap_solicitud->tipo_clientegn_sol->EditAttributes() ?>>
</span>
<?php echo $ap_solicitud->tipo_clientegn_sol->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_solicitud->unidad_sol->Visible) { // unidad_sol ?>
	<div id="r_unidad_sol" class="form-group">
		<label id="elh_ap_solicitud_unidad_sol" for="x_unidad_sol" class="col-sm-2 control-label ewLabel"><?php echo $ap_solicitud->unidad_sol->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_solicitud->unidad_sol->CellAttributes() ?>>
<span id="el_ap_solicitud_unidad_sol">
<input type="text" data-table="ap_solicitud" data-field="x_unidad_sol" name="x_unidad_sol" id="x_unidad_sol" size="30" placeholder="<?php echo ew_HtmlEncode($ap_solicitud->unidad_sol->getPlaceHolder()) ?>" value="<?php echo $ap_solicitud->unidad_sol->EditValue ?>"<?php echo $ap_solicitud->unidad_sol->EditAttributes() ?>>
</span>
<?php echo $ap_solicitud->unidad_sol->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_solicitud->fecha_reg_sol->Visible) { // fecha_reg_sol ?>
	<div id="r_fecha_reg_sol" class="form-group">
		<label id="elh_ap_solicitud_fecha_reg_sol" for="x_fecha_reg_sol" class="col-sm-2 control-label ewLabel"><?php echo $ap_solicitud->fecha_reg_sol->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_solicitud->fecha_reg_sol->CellAttributes() ?>>
<span id="el_ap_solicitud_fecha_reg_sol">
<input type="text" data-table="ap_solicitud" data-field="x_fecha_reg_sol" name="x_fecha_reg_sol" id="x_fecha_reg_sol" placeholder="<?php echo ew_HtmlEncode($ap_solicitud->fecha_reg_sol->getPlaceHolder()) ?>" value="<?php echo $ap_solicitud->fecha_reg_sol->EditValue ?>"<?php echo $ap_solicitud->fecha_reg_sol->EditAttributes() ?>>
</span>
<?php echo $ap_solicitud->fecha_reg_sol->CustomMsg ?></div></div>
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
<?php if ($ap_solicitud->empresa_sol->Visible) { // empresa_sol ?>
	<div id="r_empresa_sol" class="form-group">
		<label id="elh_ap_solicitud_empresa_sol" for="x_empresa_sol" class="col-sm-2 control-label ewLabel"><?php echo $ap_solicitud->empresa_sol->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_solicitud->empresa_sol->CellAttributes() ?>>
<span id="el_ap_solicitud_empresa_sol">
<input type="text" data-table="ap_solicitud" data-field="x_empresa_sol" name="x_empresa_sol" id="x_empresa_sol" size="30" placeholder="<?php echo ew_HtmlEncode($ap_solicitud->empresa_sol->getPlaceHolder()) ?>" value="<?php echo $ap_solicitud->empresa_sol->EditValue ?>"<?php echo $ap_solicitud->empresa_sol->EditAttributes() ?>>
</span>
<?php echo $ap_solicitud->empresa_sol->CustomMsg ?></div></div>
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
<input type="text" data-table="ap_solicitud" data-field="x_fecha_prevista_sol" name="x_fecha_prevista_sol" id="x_fecha_prevista_sol" placeholder="<?php echo ew_HtmlEncode($ap_solicitud->fecha_prevista_sol->getPlaceHolder()) ?>" value="<?php echo $ap_solicitud->fecha_prevista_sol->EditValue ?>"<?php echo $ap_solicitud->fecha_prevista_sol->EditAttributes() ?>>
</span>
<?php echo $ap_solicitud->fecha_prevista_sol->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_solicitud->user_preventa_sol->Visible) { // user_preventa_sol ?>
	<div id="r_user_preventa_sol" class="form-group">
		<label id="elh_ap_solicitud_user_preventa_sol" for="x_user_preventa_sol" class="col-sm-2 control-label ewLabel"><?php echo $ap_solicitud->user_preventa_sol->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_solicitud->user_preventa_sol->CellAttributes() ?>>
<span id="el_ap_solicitud_user_preventa_sol">
<input type="text" data-table="ap_solicitud" data-field="x_user_preventa_sol" name="x_user_preventa_sol" id="x_user_preventa_sol" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($ap_solicitud->user_preventa_sol->getPlaceHolder()) ?>" value="<?php echo $ap_solicitud->user_preventa_sol->EditValue ?>"<?php echo $ap_solicitud->user_preventa_sol->EditAttributes() ?>>
</span>
<?php echo $ap_solicitud->user_preventa_sol->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_solicitud->quincena_obra_sol->Visible) { // quincena_obra_sol ?>
	<div id="r_quincena_obra_sol" class="form-group">
		<label id="elh_ap_solicitud_quincena_obra_sol" for="x_quincena_obra_sol" class="col-sm-2 control-label ewLabel"><?php echo $ap_solicitud->quincena_obra_sol->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_solicitud->quincena_obra_sol->CellAttributes() ?>>
<span id="el_ap_solicitud_quincena_obra_sol">
<input type="text" data-table="ap_solicitud" data-field="x_quincena_obra_sol" name="x_quincena_obra_sol" id="x_quincena_obra_sol" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($ap_solicitud->quincena_obra_sol->getPlaceHolder()) ?>" value="<?php echo $ap_solicitud->quincena_obra_sol->EditValue ?>"<?php echo $ap_solicitud->quincena_obra_sol->EditAttributes() ?>>
</span>
<?php echo $ap_solicitud->quincena_obra_sol->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_solicitud->fecha_obra_sol->Visible) { // fecha_obra_sol ?>
	<div id="r_fecha_obra_sol" class="form-group">
		<label id="elh_ap_solicitud_fecha_obra_sol" for="x_fecha_obra_sol" class="col-sm-2 control-label ewLabel"><?php echo $ap_solicitud->fecha_obra_sol->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_solicitud->fecha_obra_sol->CellAttributes() ?>>
<span id="el_ap_solicitud_fecha_obra_sol">
<input type="text" data-table="ap_solicitud" data-field="x_fecha_obra_sol" name="x_fecha_obra_sol" id="x_fecha_obra_sol" placeholder="<?php echo ew_HtmlEncode($ap_solicitud->fecha_obra_sol->getPlaceHolder()) ?>" value="<?php echo $ap_solicitud->fecha_obra_sol->EditValue ?>"<?php echo $ap_solicitud->fecha_obra_sol->EditAttributes() ?>>
</span>
<?php echo $ap_solicitud->fecha_obra_sol->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_solicitud->nombre_tecnico_sol->Visible) { // nombre_tecnico_sol ?>
	<div id="r_nombre_tecnico_sol" class="form-group">
		<label id="elh_ap_solicitud_nombre_tecnico_sol" for="x_nombre_tecnico_sol" class="col-sm-2 control-label ewLabel"><?php echo $ap_solicitud->nombre_tecnico_sol->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_solicitud->nombre_tecnico_sol->CellAttributes() ?>>
<span id="el_ap_solicitud_nombre_tecnico_sol">
<input type="text" data-table="ap_solicitud" data-field="x_nombre_tecnico_sol" name="x_nombre_tecnico_sol" id="x_nombre_tecnico_sol" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($ap_solicitud->nombre_tecnico_sol->getPlaceHolder()) ?>" value="<?php echo $ap_solicitud->nombre_tecnico_sol->EditValue ?>"<?php echo $ap_solicitud->nombre_tecnico_sol->EditAttributes() ?>>
</span>
<?php echo $ap_solicitud->nombre_tecnico_sol->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_solicitud->cod_tecnico_sol->Visible) { // cod_tecnico_sol ?>
	<div id="r_cod_tecnico_sol" class="form-group">
		<label id="elh_ap_solicitud_cod_tecnico_sol" for="x_cod_tecnico_sol" class="col-sm-2 control-label ewLabel"><?php echo $ap_solicitud->cod_tecnico_sol->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_solicitud->cod_tecnico_sol->CellAttributes() ?>>
<span id="el_ap_solicitud_cod_tecnico_sol">
<input type="text" data-table="ap_solicitud" data-field="x_cod_tecnico_sol" name="x_cod_tecnico_sol" id="x_cod_tecnico_sol" size="30" placeholder="<?php echo ew_HtmlEncode($ap_solicitud->cod_tecnico_sol->getPlaceHolder()) ?>" value="<?php echo $ap_solicitud->cod_tecnico_sol->EditValue ?>"<?php echo $ap_solicitud->cod_tecnico_sol->EditAttributes() ?>>
</span>
<?php echo $ap_solicitud->cod_tecnico_sol->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_solicitud->lider_obra_sol->Visible) { // lider_obra_sol ?>
	<div id="r_lider_obra_sol" class="form-group">
		<label id="elh_ap_solicitud_lider_obra_sol" for="x_lider_obra_sol" class="col-sm-2 control-label ewLabel"><?php echo $ap_solicitud->lider_obra_sol->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_solicitud->lider_obra_sol->CellAttributes() ?>>
<span id="el_ap_solicitud_lider_obra_sol">
<input type="text" data-table="ap_solicitud" data-field="x_lider_obra_sol" name="x_lider_obra_sol" id="x_lider_obra_sol" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($ap_solicitud->lider_obra_sol->getPlaceHolder()) ?>" value="<?php echo $ap_solicitud->lider_obra_sol->EditValue ?>"<?php echo $ap_solicitud->lider_obra_sol->EditAttributes() ?>>
</span>
<?php echo $ap_solicitud->lider_obra_sol->CustomMsg ?></div></div>
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
<input type="text" data-table="ap_solicitud" data-field="x_obs_estado_sol" name="x_obs_estado_sol" id="x_obs_estado_sol" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($ap_solicitud->obs_estado_sol->getPlaceHolder()) ?>" value="<?php echo $ap_solicitud->obs_estado_sol->EditValue ?>"<?php echo $ap_solicitud->obs_estado_sol->EditAttributes() ?>>
</span>
<?php echo $ap_solicitud->obs_estado_sol->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_solicitud->forma_pagogn_sol->Visible) { // forma_pagogn_sol ?>
	<div id="r_forma_pagogn_sol" class="form-group">
		<label id="elh_ap_solicitud_forma_pagogn_sol" for="x_forma_pagogn_sol" class="col-sm-2 control-label ewLabel"><?php echo $ap_solicitud->forma_pagogn_sol->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_solicitud->forma_pagogn_sol->CellAttributes() ?>>
<span id="el_ap_solicitud_forma_pagogn_sol">
<input type="text" data-table="ap_solicitud" data-field="x_forma_pagogn_sol" name="x_forma_pagogn_sol" id="x_forma_pagogn_sol" size="30" placeholder="<?php echo ew_HtmlEncode($ap_solicitud->forma_pagogn_sol->getPlaceHolder()) ?>" value="<?php echo $ap_solicitud->forma_pagogn_sol->EditValue ?>"<?php echo $ap_solicitud->forma_pagogn_sol->EditAttributes() ?>>
</span>
<?php echo $ap_solicitud->forma_pagogn_sol->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$ap_solicitud_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $ap_solicitud_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fap_solicitudadd.Init();
</script>
<?php
$ap_solicitud_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$ap_solicitud_add->Page_Terminate();
?>
