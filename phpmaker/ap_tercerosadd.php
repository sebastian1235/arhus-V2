<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "ap_tercerosinfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$ap_terceros_add = NULL; // Initialize page object first

class cap_terceros_add extends cap_terceros {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{6A9AC718-A824-45A3-BED3-A95E91E6986D}";

	// Table name
	var $TableName = 'ap_terceros';

	// Page object name
	var $PageObjName = 'ap_terceros_add';

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

		// Table object (ap_terceros)
		if (!isset($GLOBALS["ap_terceros"]) || get_class($GLOBALS["ap_terceros"]) == "cap_terceros") {
			$GLOBALS["ap_terceros"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["ap_terceros"];
		}

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'ap_terceros', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("ap_terceroslist.php"));
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
		$this->nombre_tercero->SetVisibility();
		$this->direccion_tercero->SetVisibility();
		$this->telefono1_tercero->SetVisibility();
		$this->telefono2_tercero->SetVisibility();
		$this->fax_tercero->SetVisibility();
		$this->nit_tercero->SetVisibility();
		$this->tipo_tercero->SetVisibility();
		$this->e_mail_tercero->SetVisibility();
		$this->Contacto_tercero->SetVisibility();
		$this->gran_contrib_tercero->SetVisibility();
		$this->autoretenedor_tercero->SetVisibility();
		$this->activo_tercero->SetVisibility();
		$this->tercero__registrado_por->SetVisibility();
		$this->reg_comun_tercero->SetVisibility();
		$this->responsable_materiales_tercero->SetVisibility();
		$this->grupo_nomina_tercero->SetVisibility();
		$this->tercero__lider_Obra->SetVisibility();
		$this->tercero_nombre_lider->SetVisibility();
		$this->empresa_tercero->SetVisibility();

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
		global $EW_EXPORT, $ap_terceros;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($ap_terceros);
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
			if (@$_GET["Id_tercero"] != "") {
				$this->Id_tercero->setQueryStringValue($_GET["Id_tercero"]);
				$this->setKey("Id_tercero", $this->Id_tercero->CurrentValue); // Set up key
			} else {
				$this->setKey("Id_tercero", ""); // Clear key
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
					$this->Page_Terminate("ap_terceroslist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "ap_terceroslist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "ap_tercerosview.php")
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
		$this->nombre_tercero->CurrentValue = NULL;
		$this->nombre_tercero->OldValue = $this->nombre_tercero->CurrentValue;
		$this->direccion_tercero->CurrentValue = NULL;
		$this->direccion_tercero->OldValue = $this->direccion_tercero->CurrentValue;
		$this->telefono1_tercero->CurrentValue = NULL;
		$this->telefono1_tercero->OldValue = $this->telefono1_tercero->CurrentValue;
		$this->telefono2_tercero->CurrentValue = NULL;
		$this->telefono2_tercero->OldValue = $this->telefono2_tercero->CurrentValue;
		$this->fax_tercero->CurrentValue = NULL;
		$this->fax_tercero->OldValue = $this->fax_tercero->CurrentValue;
		$this->nit_tercero->CurrentValue = NULL;
		$this->nit_tercero->OldValue = $this->nit_tercero->CurrentValue;
		$this->tipo_tercero->CurrentValue = 0;
		$this->e_mail_tercero->CurrentValue = NULL;
		$this->e_mail_tercero->OldValue = $this->e_mail_tercero->CurrentValue;
		$this->Contacto_tercero->CurrentValue = NULL;
		$this->Contacto_tercero->OldValue = $this->Contacto_tercero->CurrentValue;
		$this->gran_contrib_tercero->CurrentValue = NULL;
		$this->gran_contrib_tercero->OldValue = $this->gran_contrib_tercero->CurrentValue;
		$this->autoretenedor_tercero->CurrentValue = NULL;
		$this->autoretenedor_tercero->OldValue = $this->autoretenedor_tercero->CurrentValue;
		$this->activo_tercero->CurrentValue = NULL;
		$this->activo_tercero->OldValue = $this->activo_tercero->CurrentValue;
		$this->tercero__registrado_por->CurrentValue = NULL;
		$this->tercero__registrado_por->OldValue = $this->tercero__registrado_por->CurrentValue;
		$this->reg_comun_tercero->CurrentValue = 0;
		$this->responsable_materiales_tercero->CurrentValue = 0;
		$this->grupo_nomina_tercero->CurrentValue = NULL;
		$this->grupo_nomina_tercero->OldValue = $this->grupo_nomina_tercero->CurrentValue;
		$this->tercero__lider_Obra->CurrentValue = NULL;
		$this->tercero__lider_Obra->OldValue = $this->tercero__lider_Obra->CurrentValue;
		$this->tercero_nombre_lider->CurrentValue = NULL;
		$this->tercero_nombre_lider->OldValue = $this->tercero_nombre_lider->CurrentValue;
		$this->empresa_tercero->CurrentValue = NULL;
		$this->empresa_tercero->OldValue = $this->empresa_tercero->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->nombre_tercero->FldIsDetailKey) {
			$this->nombre_tercero->setFormValue($objForm->GetValue("x_nombre_tercero"));
		}
		if (!$this->direccion_tercero->FldIsDetailKey) {
			$this->direccion_tercero->setFormValue($objForm->GetValue("x_direccion_tercero"));
		}
		if (!$this->telefono1_tercero->FldIsDetailKey) {
			$this->telefono1_tercero->setFormValue($objForm->GetValue("x_telefono1_tercero"));
		}
		if (!$this->telefono2_tercero->FldIsDetailKey) {
			$this->telefono2_tercero->setFormValue($objForm->GetValue("x_telefono2_tercero"));
		}
		if (!$this->fax_tercero->FldIsDetailKey) {
			$this->fax_tercero->setFormValue($objForm->GetValue("x_fax_tercero"));
		}
		if (!$this->nit_tercero->FldIsDetailKey) {
			$this->nit_tercero->setFormValue($objForm->GetValue("x_nit_tercero"));
		}
		if (!$this->tipo_tercero->FldIsDetailKey) {
			$this->tipo_tercero->setFormValue($objForm->GetValue("x_tipo_tercero"));
		}
		if (!$this->e_mail_tercero->FldIsDetailKey) {
			$this->e_mail_tercero->setFormValue($objForm->GetValue("x_e_mail_tercero"));
		}
		if (!$this->Contacto_tercero->FldIsDetailKey) {
			$this->Contacto_tercero->setFormValue($objForm->GetValue("x_Contacto_tercero"));
		}
		if (!$this->gran_contrib_tercero->FldIsDetailKey) {
			$this->gran_contrib_tercero->setFormValue($objForm->GetValue("x_gran_contrib_tercero"));
		}
		if (!$this->autoretenedor_tercero->FldIsDetailKey) {
			$this->autoretenedor_tercero->setFormValue($objForm->GetValue("x_autoretenedor_tercero"));
		}
		if (!$this->activo_tercero->FldIsDetailKey) {
			$this->activo_tercero->setFormValue($objForm->GetValue("x_activo_tercero"));
		}
		if (!$this->tercero__registrado_por->FldIsDetailKey) {
			$this->tercero__registrado_por->setFormValue($objForm->GetValue("x_tercero__registrado_por"));
		}
		if (!$this->reg_comun_tercero->FldIsDetailKey) {
			$this->reg_comun_tercero->setFormValue($objForm->GetValue("x_reg_comun_tercero"));
		}
		if (!$this->responsable_materiales_tercero->FldIsDetailKey) {
			$this->responsable_materiales_tercero->setFormValue($objForm->GetValue("x_responsable_materiales_tercero"));
		}
		if (!$this->grupo_nomina_tercero->FldIsDetailKey) {
			$this->grupo_nomina_tercero->setFormValue($objForm->GetValue("x_grupo_nomina_tercero"));
		}
		if (!$this->tercero__lider_Obra->FldIsDetailKey) {
			$this->tercero__lider_Obra->setFormValue($objForm->GetValue("x_tercero__lider_Obra"));
		}
		if (!$this->tercero_nombre_lider->FldIsDetailKey) {
			$this->tercero_nombre_lider->setFormValue($objForm->GetValue("x_tercero_nombre_lider"));
		}
		if (!$this->empresa_tercero->FldIsDetailKey) {
			$this->empresa_tercero->setFormValue($objForm->GetValue("x_empresa_tercero"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->nombre_tercero->CurrentValue = $this->nombre_tercero->FormValue;
		$this->direccion_tercero->CurrentValue = $this->direccion_tercero->FormValue;
		$this->telefono1_tercero->CurrentValue = $this->telefono1_tercero->FormValue;
		$this->telefono2_tercero->CurrentValue = $this->telefono2_tercero->FormValue;
		$this->fax_tercero->CurrentValue = $this->fax_tercero->FormValue;
		$this->nit_tercero->CurrentValue = $this->nit_tercero->FormValue;
		$this->tipo_tercero->CurrentValue = $this->tipo_tercero->FormValue;
		$this->e_mail_tercero->CurrentValue = $this->e_mail_tercero->FormValue;
		$this->Contacto_tercero->CurrentValue = $this->Contacto_tercero->FormValue;
		$this->gran_contrib_tercero->CurrentValue = $this->gran_contrib_tercero->FormValue;
		$this->autoretenedor_tercero->CurrentValue = $this->autoretenedor_tercero->FormValue;
		$this->activo_tercero->CurrentValue = $this->activo_tercero->FormValue;
		$this->tercero__registrado_por->CurrentValue = $this->tercero__registrado_por->FormValue;
		$this->reg_comun_tercero->CurrentValue = $this->reg_comun_tercero->FormValue;
		$this->responsable_materiales_tercero->CurrentValue = $this->responsable_materiales_tercero->FormValue;
		$this->grupo_nomina_tercero->CurrentValue = $this->grupo_nomina_tercero->FormValue;
		$this->tercero__lider_Obra->CurrentValue = $this->tercero__lider_Obra->FormValue;
		$this->tercero_nombre_lider->CurrentValue = $this->tercero_nombre_lider->FormValue;
		$this->empresa_tercero->CurrentValue = $this->empresa_tercero->FormValue;
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

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->Id_tercero->DbValue = $row['Id_tercero'];
		$this->nombre_tercero->DbValue = $row['nombre_tercero'];
		$this->direccion_tercero->DbValue = $row['direccion_tercero'];
		$this->telefono1_tercero->DbValue = $row['telefono1_tercero'];
		$this->telefono2_tercero->DbValue = $row['telefono2_tercero'];
		$this->fax_tercero->DbValue = $row['fax_tercero'];
		$this->nit_tercero->DbValue = $row['nit_tercero'];
		$this->tipo_tercero->DbValue = $row['tipo_tercero'];
		$this->e_mail_tercero->DbValue = $row['e_mail_tercero'];
		$this->Contacto_tercero->DbValue = $row['Contacto_tercero'];
		$this->gran_contrib_tercero->DbValue = $row['gran_contrib_tercero'];
		$this->autoretenedor_tercero->DbValue = $row['autoretenedor_tercero'];
		$this->activo_tercero->DbValue = $row['activo_tercero'];
		$this->tercero__registrado_por->DbValue = $row['tercero_ registrado_por'];
		$this->reg_comun_tercero->DbValue = $row['reg_comun_tercero'];
		$this->responsable_materiales_tercero->DbValue = $row['responsable_materiales_tercero'];
		$this->grupo_nomina_tercero->DbValue = $row['grupo_nomina_tercero'];
		$this->tercero__lider_Obra->DbValue = $row['tercero_ lider_Obra'];
		$this->tercero_nombre_lider->DbValue = $row['tercero_nombre_lider'];
		$this->empresa_tercero->DbValue = $row['empresa_tercero'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("Id_tercero")) <> "")
			$this->Id_tercero->CurrentValue = $this->getKey("Id_tercero"); // Id_tercero
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
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
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

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

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
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// nombre_tercero
			$this->nombre_tercero->EditAttrs["class"] = "form-control";
			$this->nombre_tercero->EditCustomAttributes = "";
			$this->nombre_tercero->EditValue = ew_HtmlEncode($this->nombre_tercero->CurrentValue);
			$this->nombre_tercero->PlaceHolder = ew_RemoveHtml($this->nombre_tercero->FldCaption());

			// direccion_tercero
			$this->direccion_tercero->EditAttrs["class"] = "form-control";
			$this->direccion_tercero->EditCustomAttributes = "";
			$this->direccion_tercero->EditValue = ew_HtmlEncode($this->direccion_tercero->CurrentValue);
			$this->direccion_tercero->PlaceHolder = ew_RemoveHtml($this->direccion_tercero->FldCaption());

			// telefono1_tercero
			$this->telefono1_tercero->EditAttrs["class"] = "form-control";
			$this->telefono1_tercero->EditCustomAttributes = "";
			$this->telefono1_tercero->EditValue = ew_HtmlEncode($this->telefono1_tercero->CurrentValue);
			$this->telefono1_tercero->PlaceHolder = ew_RemoveHtml($this->telefono1_tercero->FldCaption());

			// telefono2_tercero
			$this->telefono2_tercero->EditAttrs["class"] = "form-control";
			$this->telefono2_tercero->EditCustomAttributes = "";
			$this->telefono2_tercero->EditValue = ew_HtmlEncode($this->telefono2_tercero->CurrentValue);
			$this->telefono2_tercero->PlaceHolder = ew_RemoveHtml($this->telefono2_tercero->FldCaption());

			// fax_tercero
			$this->fax_tercero->EditAttrs["class"] = "form-control";
			$this->fax_tercero->EditCustomAttributes = "";
			$this->fax_tercero->EditValue = ew_HtmlEncode($this->fax_tercero->CurrentValue);
			$this->fax_tercero->PlaceHolder = ew_RemoveHtml($this->fax_tercero->FldCaption());

			// nit_tercero
			$this->nit_tercero->EditAttrs["class"] = "form-control";
			$this->nit_tercero->EditCustomAttributes = "";
			$this->nit_tercero->EditValue = ew_HtmlEncode($this->nit_tercero->CurrentValue);
			$this->nit_tercero->PlaceHolder = ew_RemoveHtml($this->nit_tercero->FldCaption());

			// tipo_tercero
			$this->tipo_tercero->EditAttrs["class"] = "form-control";
			$this->tipo_tercero->EditCustomAttributes = "";
			$this->tipo_tercero->EditValue = ew_HtmlEncode($this->tipo_tercero->CurrentValue);
			$this->tipo_tercero->PlaceHolder = ew_RemoveHtml($this->tipo_tercero->FldCaption());

			// e_mail_tercero
			$this->e_mail_tercero->EditAttrs["class"] = "form-control";
			$this->e_mail_tercero->EditCustomAttributes = "";
			$this->e_mail_tercero->EditValue = ew_HtmlEncode($this->e_mail_tercero->CurrentValue);
			$this->e_mail_tercero->PlaceHolder = ew_RemoveHtml($this->e_mail_tercero->FldCaption());

			// Contacto_tercero
			$this->Contacto_tercero->EditAttrs["class"] = "form-control";
			$this->Contacto_tercero->EditCustomAttributes = "";
			$this->Contacto_tercero->EditValue = ew_HtmlEncode($this->Contacto_tercero->CurrentValue);
			$this->Contacto_tercero->PlaceHolder = ew_RemoveHtml($this->Contacto_tercero->FldCaption());

			// gran_contrib_tercero
			$this->gran_contrib_tercero->EditAttrs["class"] = "form-control";
			$this->gran_contrib_tercero->EditCustomAttributes = "";
			$this->gran_contrib_tercero->EditValue = ew_HtmlEncode($this->gran_contrib_tercero->CurrentValue);
			$this->gran_contrib_tercero->PlaceHolder = ew_RemoveHtml($this->gran_contrib_tercero->FldCaption());

			// autoretenedor_tercero
			$this->autoretenedor_tercero->EditAttrs["class"] = "form-control";
			$this->autoretenedor_tercero->EditCustomAttributes = "";
			$this->autoretenedor_tercero->EditValue = ew_HtmlEncode($this->autoretenedor_tercero->CurrentValue);
			$this->autoretenedor_tercero->PlaceHolder = ew_RemoveHtml($this->autoretenedor_tercero->FldCaption());

			// activo_tercero
			$this->activo_tercero->EditAttrs["class"] = "form-control";
			$this->activo_tercero->EditCustomAttributes = "";
			$this->activo_tercero->EditValue = ew_HtmlEncode($this->activo_tercero->CurrentValue);
			$this->activo_tercero->PlaceHolder = ew_RemoveHtml($this->activo_tercero->FldCaption());

			// tercero_ registrado_por
			$this->tercero__registrado_por->EditAttrs["class"] = "form-control";
			$this->tercero__registrado_por->EditCustomAttributes = "";
			$this->tercero__registrado_por->EditValue = ew_HtmlEncode($this->tercero__registrado_por->CurrentValue);
			$this->tercero__registrado_por->PlaceHolder = ew_RemoveHtml($this->tercero__registrado_por->FldCaption());

			// reg_comun_tercero
			$this->reg_comun_tercero->EditAttrs["class"] = "form-control";
			$this->reg_comun_tercero->EditCustomAttributes = "";
			$this->reg_comun_tercero->EditValue = ew_HtmlEncode($this->reg_comun_tercero->CurrentValue);
			$this->reg_comun_tercero->PlaceHolder = ew_RemoveHtml($this->reg_comun_tercero->FldCaption());

			// responsable_materiales_tercero
			$this->responsable_materiales_tercero->EditAttrs["class"] = "form-control";
			$this->responsable_materiales_tercero->EditCustomAttributes = "";
			$this->responsable_materiales_tercero->EditValue = ew_HtmlEncode($this->responsable_materiales_tercero->CurrentValue);
			$this->responsable_materiales_tercero->PlaceHolder = ew_RemoveHtml($this->responsable_materiales_tercero->FldCaption());

			// grupo_nomina_tercero
			$this->grupo_nomina_tercero->EditAttrs["class"] = "form-control";
			$this->grupo_nomina_tercero->EditCustomAttributes = "";
			$this->grupo_nomina_tercero->EditValue = ew_HtmlEncode($this->grupo_nomina_tercero->CurrentValue);
			$this->grupo_nomina_tercero->PlaceHolder = ew_RemoveHtml($this->grupo_nomina_tercero->FldCaption());

			// tercero_ lider_Obra
			$this->tercero__lider_Obra->EditAttrs["class"] = "form-control";
			$this->tercero__lider_Obra->EditCustomAttributes = "";
			$this->tercero__lider_Obra->EditValue = ew_HtmlEncode($this->tercero__lider_Obra->CurrentValue);
			$this->tercero__lider_Obra->PlaceHolder = ew_RemoveHtml($this->tercero__lider_Obra->FldCaption());

			// tercero_nombre_lider
			$this->tercero_nombre_lider->EditAttrs["class"] = "form-control";
			$this->tercero_nombre_lider->EditCustomAttributes = "";
			$this->tercero_nombre_lider->EditValue = ew_HtmlEncode($this->tercero_nombre_lider->CurrentValue);
			$this->tercero_nombre_lider->PlaceHolder = ew_RemoveHtml($this->tercero_nombre_lider->FldCaption());

			// empresa_tercero
			$this->empresa_tercero->EditAttrs["class"] = "form-control";
			$this->empresa_tercero->EditCustomAttributes = "";
			$this->empresa_tercero->EditValue = ew_HtmlEncode($this->empresa_tercero->CurrentValue);
			$this->empresa_tercero->PlaceHolder = ew_RemoveHtml($this->empresa_tercero->FldCaption());

			// Add refer script
			// nombre_tercero

			$this->nombre_tercero->LinkCustomAttributes = "";
			$this->nombre_tercero->HrefValue = "";

			// direccion_tercero
			$this->direccion_tercero->LinkCustomAttributes = "";
			$this->direccion_tercero->HrefValue = "";

			// telefono1_tercero
			$this->telefono1_tercero->LinkCustomAttributes = "";
			$this->telefono1_tercero->HrefValue = "";

			// telefono2_tercero
			$this->telefono2_tercero->LinkCustomAttributes = "";
			$this->telefono2_tercero->HrefValue = "";

			// fax_tercero
			$this->fax_tercero->LinkCustomAttributes = "";
			$this->fax_tercero->HrefValue = "";

			// nit_tercero
			$this->nit_tercero->LinkCustomAttributes = "";
			$this->nit_tercero->HrefValue = "";

			// tipo_tercero
			$this->tipo_tercero->LinkCustomAttributes = "";
			$this->tipo_tercero->HrefValue = "";

			// e_mail_tercero
			$this->e_mail_tercero->LinkCustomAttributes = "";
			$this->e_mail_tercero->HrefValue = "";

			// Contacto_tercero
			$this->Contacto_tercero->LinkCustomAttributes = "";
			$this->Contacto_tercero->HrefValue = "";

			// gran_contrib_tercero
			$this->gran_contrib_tercero->LinkCustomAttributes = "";
			$this->gran_contrib_tercero->HrefValue = "";

			// autoretenedor_tercero
			$this->autoretenedor_tercero->LinkCustomAttributes = "";
			$this->autoretenedor_tercero->HrefValue = "";

			// activo_tercero
			$this->activo_tercero->LinkCustomAttributes = "";
			$this->activo_tercero->HrefValue = "";

			// tercero_ registrado_por
			$this->tercero__registrado_por->LinkCustomAttributes = "";
			$this->tercero__registrado_por->HrefValue = "";

			// reg_comun_tercero
			$this->reg_comun_tercero->LinkCustomAttributes = "";
			$this->reg_comun_tercero->HrefValue = "";

			// responsable_materiales_tercero
			$this->responsable_materiales_tercero->LinkCustomAttributes = "";
			$this->responsable_materiales_tercero->HrefValue = "";

			// grupo_nomina_tercero
			$this->grupo_nomina_tercero->LinkCustomAttributes = "";
			$this->grupo_nomina_tercero->HrefValue = "";

			// tercero_ lider_Obra
			$this->tercero__lider_Obra->LinkCustomAttributes = "";
			$this->tercero__lider_Obra->HrefValue = "";

			// tercero_nombre_lider
			$this->tercero_nombre_lider->LinkCustomAttributes = "";
			$this->tercero_nombre_lider->HrefValue = "";

			// empresa_tercero
			$this->empresa_tercero->LinkCustomAttributes = "";
			$this->empresa_tercero->HrefValue = "";
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
		if (!ew_CheckInteger($this->tipo_tercero->FormValue)) {
			ew_AddMessage($gsFormError, $this->tipo_tercero->FldErrMsg());
		}
		if (!ew_CheckInteger($this->gran_contrib_tercero->FormValue)) {
			ew_AddMessage($gsFormError, $this->gran_contrib_tercero->FldErrMsg());
		}
		if (!ew_CheckInteger($this->autoretenedor_tercero->FormValue)) {
			ew_AddMessage($gsFormError, $this->autoretenedor_tercero->FldErrMsg());
		}
		if (!ew_CheckInteger($this->activo_tercero->FormValue)) {
			ew_AddMessage($gsFormError, $this->activo_tercero->FldErrMsg());
		}
		if (!ew_CheckInteger($this->reg_comun_tercero->FormValue)) {
			ew_AddMessage($gsFormError, $this->reg_comun_tercero->FldErrMsg());
		}
		if (!ew_CheckInteger($this->responsable_materiales_tercero->FormValue)) {
			ew_AddMessage($gsFormError, $this->responsable_materiales_tercero->FldErrMsg());
		}
		if (!ew_CheckInteger($this->grupo_nomina_tercero->FormValue)) {
			ew_AddMessage($gsFormError, $this->grupo_nomina_tercero->FldErrMsg());
		}
		if (!ew_CheckInteger($this->tercero__lider_Obra->FormValue)) {
			ew_AddMessage($gsFormError, $this->tercero__lider_Obra->FldErrMsg());
		}
		if (!ew_CheckInteger($this->empresa_tercero->FormValue)) {
			ew_AddMessage($gsFormError, $this->empresa_tercero->FldErrMsg());
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

		// nombre_tercero
		$this->nombre_tercero->SetDbValueDef($rsnew, $this->nombre_tercero->CurrentValue, NULL, FALSE);

		// direccion_tercero
		$this->direccion_tercero->SetDbValueDef($rsnew, $this->direccion_tercero->CurrentValue, NULL, FALSE);

		// telefono1_tercero
		$this->telefono1_tercero->SetDbValueDef($rsnew, $this->telefono1_tercero->CurrentValue, NULL, FALSE);

		// telefono2_tercero
		$this->telefono2_tercero->SetDbValueDef($rsnew, $this->telefono2_tercero->CurrentValue, NULL, FALSE);

		// fax_tercero
		$this->fax_tercero->SetDbValueDef($rsnew, $this->fax_tercero->CurrentValue, NULL, FALSE);

		// nit_tercero
		$this->nit_tercero->SetDbValueDef($rsnew, $this->nit_tercero->CurrentValue, NULL, FALSE);

		// tipo_tercero
		$this->tipo_tercero->SetDbValueDef($rsnew, $this->tipo_tercero->CurrentValue, NULL, strval($this->tipo_tercero->CurrentValue) == "");

		// e_mail_tercero
		$this->e_mail_tercero->SetDbValueDef($rsnew, $this->e_mail_tercero->CurrentValue, NULL, FALSE);

		// Contacto_tercero
		$this->Contacto_tercero->SetDbValueDef($rsnew, $this->Contacto_tercero->CurrentValue, NULL, FALSE);

		// gran_contrib_tercero
		$this->gran_contrib_tercero->SetDbValueDef($rsnew, $this->gran_contrib_tercero->CurrentValue, NULL, FALSE);

		// autoretenedor_tercero
		$this->autoretenedor_tercero->SetDbValueDef($rsnew, $this->autoretenedor_tercero->CurrentValue, NULL, FALSE);

		// activo_tercero
		$this->activo_tercero->SetDbValueDef($rsnew, $this->activo_tercero->CurrentValue, NULL, FALSE);

		// tercero_ registrado_por
		$this->tercero__registrado_por->SetDbValueDef($rsnew, $this->tercero__registrado_por->CurrentValue, NULL, FALSE);

		// reg_comun_tercero
		$this->reg_comun_tercero->SetDbValueDef($rsnew, $this->reg_comun_tercero->CurrentValue, NULL, strval($this->reg_comun_tercero->CurrentValue) == "");

		// responsable_materiales_tercero
		$this->responsable_materiales_tercero->SetDbValueDef($rsnew, $this->responsable_materiales_tercero->CurrentValue, NULL, strval($this->responsable_materiales_tercero->CurrentValue) == "");

		// grupo_nomina_tercero
		$this->grupo_nomina_tercero->SetDbValueDef($rsnew, $this->grupo_nomina_tercero->CurrentValue, NULL, FALSE);

		// tercero_ lider_Obra
		$this->tercero__lider_Obra->SetDbValueDef($rsnew, $this->tercero__lider_Obra->CurrentValue, NULL, FALSE);

		// tercero_nombre_lider
		$this->tercero_nombre_lider->SetDbValueDef($rsnew, $this->tercero_nombre_lider->CurrentValue, NULL, FALSE);

		// empresa_tercero
		$this->empresa_tercero->SetDbValueDef($rsnew, $this->empresa_tercero->CurrentValue, NULL, FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {

				// Get insert id if necessary
				$this->Id_tercero->setDbValue($conn->Insert_ID());
				$rsnew['Id_tercero'] = $this->Id_tercero->DbValue;
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("ap_terceroslist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
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
if (!isset($ap_terceros_add)) $ap_terceros_add = new cap_terceros_add();

// Page init
$ap_terceros_add->Page_Init();

// Page main
$ap_terceros_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$ap_terceros_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fap_tercerosadd = new ew_Form("fap_tercerosadd", "add");

// Validate form
fap_tercerosadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_tipo_tercero");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ap_terceros->tipo_tercero->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_gran_contrib_tercero");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ap_terceros->gran_contrib_tercero->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_autoretenedor_tercero");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ap_terceros->autoretenedor_tercero->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_activo_tercero");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ap_terceros->activo_tercero->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_reg_comun_tercero");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ap_terceros->reg_comun_tercero->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_responsable_materiales_tercero");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ap_terceros->responsable_materiales_tercero->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_grupo_nomina_tercero");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ap_terceros->grupo_nomina_tercero->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_tercero__lider_Obra");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ap_terceros->tercero__lider_Obra->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_empresa_tercero");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ap_terceros->empresa_tercero->FldErrMsg()) ?>");

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
fap_tercerosadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fap_tercerosadd.ValidateRequired = true;
<?php } else { ?>
fap_tercerosadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$ap_terceros_add->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $ap_terceros_add->ShowPageHeader(); ?>
<?php
$ap_terceros_add->ShowMessage();
?>
<form name="fap_tercerosadd" id="fap_tercerosadd" class="<?php echo $ap_terceros_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($ap_terceros_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $ap_terceros_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="ap_terceros">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($ap_terceros_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($ap_terceros->nombre_tercero->Visible) { // nombre_tercero ?>
	<div id="r_nombre_tercero" class="form-group">
		<label id="elh_ap_terceros_nombre_tercero" for="x_nombre_tercero" class="col-sm-2 control-label ewLabel"><?php echo $ap_terceros->nombre_tercero->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_terceros->nombre_tercero->CellAttributes() ?>>
<span id="el_ap_terceros_nombre_tercero">
<input type="text" data-table="ap_terceros" data-field="x_nombre_tercero" name="x_nombre_tercero" id="x_nombre_tercero" size="30" maxlength="80" placeholder="<?php echo ew_HtmlEncode($ap_terceros->nombre_tercero->getPlaceHolder()) ?>" value="<?php echo $ap_terceros->nombre_tercero->EditValue ?>"<?php echo $ap_terceros->nombre_tercero->EditAttributes() ?>>
</span>
<?php echo $ap_terceros->nombre_tercero->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_terceros->direccion_tercero->Visible) { // direccion_tercero ?>
	<div id="r_direccion_tercero" class="form-group">
		<label id="elh_ap_terceros_direccion_tercero" for="x_direccion_tercero" class="col-sm-2 control-label ewLabel"><?php echo $ap_terceros->direccion_tercero->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_terceros->direccion_tercero->CellAttributes() ?>>
<span id="el_ap_terceros_direccion_tercero">
<input type="text" data-table="ap_terceros" data-field="x_direccion_tercero" name="x_direccion_tercero" id="x_direccion_tercero" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($ap_terceros->direccion_tercero->getPlaceHolder()) ?>" value="<?php echo $ap_terceros->direccion_tercero->EditValue ?>"<?php echo $ap_terceros->direccion_tercero->EditAttributes() ?>>
</span>
<?php echo $ap_terceros->direccion_tercero->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_terceros->telefono1_tercero->Visible) { // telefono1_tercero ?>
	<div id="r_telefono1_tercero" class="form-group">
		<label id="elh_ap_terceros_telefono1_tercero" for="x_telefono1_tercero" class="col-sm-2 control-label ewLabel"><?php echo $ap_terceros->telefono1_tercero->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_terceros->telefono1_tercero->CellAttributes() ?>>
<span id="el_ap_terceros_telefono1_tercero">
<input type="text" data-table="ap_terceros" data-field="x_telefono1_tercero" name="x_telefono1_tercero" id="x_telefono1_tercero" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($ap_terceros->telefono1_tercero->getPlaceHolder()) ?>" value="<?php echo $ap_terceros->telefono1_tercero->EditValue ?>"<?php echo $ap_terceros->telefono1_tercero->EditAttributes() ?>>
</span>
<?php echo $ap_terceros->telefono1_tercero->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_terceros->telefono2_tercero->Visible) { // telefono2_tercero ?>
	<div id="r_telefono2_tercero" class="form-group">
		<label id="elh_ap_terceros_telefono2_tercero" for="x_telefono2_tercero" class="col-sm-2 control-label ewLabel"><?php echo $ap_terceros->telefono2_tercero->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_terceros->telefono2_tercero->CellAttributes() ?>>
<span id="el_ap_terceros_telefono2_tercero">
<input type="text" data-table="ap_terceros" data-field="x_telefono2_tercero" name="x_telefono2_tercero" id="x_telefono2_tercero" size="30" maxlength="80" placeholder="<?php echo ew_HtmlEncode($ap_terceros->telefono2_tercero->getPlaceHolder()) ?>" value="<?php echo $ap_terceros->telefono2_tercero->EditValue ?>"<?php echo $ap_terceros->telefono2_tercero->EditAttributes() ?>>
</span>
<?php echo $ap_terceros->telefono2_tercero->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_terceros->fax_tercero->Visible) { // fax_tercero ?>
	<div id="r_fax_tercero" class="form-group">
		<label id="elh_ap_terceros_fax_tercero" for="x_fax_tercero" class="col-sm-2 control-label ewLabel"><?php echo $ap_terceros->fax_tercero->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_terceros->fax_tercero->CellAttributes() ?>>
<span id="el_ap_terceros_fax_tercero">
<input type="text" data-table="ap_terceros" data-field="x_fax_tercero" name="x_fax_tercero" id="x_fax_tercero" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($ap_terceros->fax_tercero->getPlaceHolder()) ?>" value="<?php echo $ap_terceros->fax_tercero->EditValue ?>"<?php echo $ap_terceros->fax_tercero->EditAttributes() ?>>
</span>
<?php echo $ap_terceros->fax_tercero->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_terceros->nit_tercero->Visible) { // nit_tercero ?>
	<div id="r_nit_tercero" class="form-group">
		<label id="elh_ap_terceros_nit_tercero" for="x_nit_tercero" class="col-sm-2 control-label ewLabel"><?php echo $ap_terceros->nit_tercero->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_terceros->nit_tercero->CellAttributes() ?>>
<span id="el_ap_terceros_nit_tercero">
<input type="text" data-table="ap_terceros" data-field="x_nit_tercero" name="x_nit_tercero" id="x_nit_tercero" size="30" maxlength="80" placeholder="<?php echo ew_HtmlEncode($ap_terceros->nit_tercero->getPlaceHolder()) ?>" value="<?php echo $ap_terceros->nit_tercero->EditValue ?>"<?php echo $ap_terceros->nit_tercero->EditAttributes() ?>>
</span>
<?php echo $ap_terceros->nit_tercero->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_terceros->tipo_tercero->Visible) { // tipo_tercero ?>
	<div id="r_tipo_tercero" class="form-group">
		<label id="elh_ap_terceros_tipo_tercero" for="x_tipo_tercero" class="col-sm-2 control-label ewLabel"><?php echo $ap_terceros->tipo_tercero->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_terceros->tipo_tercero->CellAttributes() ?>>
<span id="el_ap_terceros_tipo_tercero">
<input type="text" data-table="ap_terceros" data-field="x_tipo_tercero" name="x_tipo_tercero" id="x_tipo_tercero" size="30" placeholder="<?php echo ew_HtmlEncode($ap_terceros->tipo_tercero->getPlaceHolder()) ?>" value="<?php echo $ap_terceros->tipo_tercero->EditValue ?>"<?php echo $ap_terceros->tipo_tercero->EditAttributes() ?>>
</span>
<?php echo $ap_terceros->tipo_tercero->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_terceros->e_mail_tercero->Visible) { // e_mail_tercero ?>
	<div id="r_e_mail_tercero" class="form-group">
		<label id="elh_ap_terceros_e_mail_tercero" for="x_e_mail_tercero" class="col-sm-2 control-label ewLabel"><?php echo $ap_terceros->e_mail_tercero->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_terceros->e_mail_tercero->CellAttributes() ?>>
<span id="el_ap_terceros_e_mail_tercero">
<input type="text" data-table="ap_terceros" data-field="x_e_mail_tercero" name="x_e_mail_tercero" id="x_e_mail_tercero" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($ap_terceros->e_mail_tercero->getPlaceHolder()) ?>" value="<?php echo $ap_terceros->e_mail_tercero->EditValue ?>"<?php echo $ap_terceros->e_mail_tercero->EditAttributes() ?>>
</span>
<?php echo $ap_terceros->e_mail_tercero->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_terceros->Contacto_tercero->Visible) { // Contacto_tercero ?>
	<div id="r_Contacto_tercero" class="form-group">
		<label id="elh_ap_terceros_Contacto_tercero" for="x_Contacto_tercero" class="col-sm-2 control-label ewLabel"><?php echo $ap_terceros->Contacto_tercero->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_terceros->Contacto_tercero->CellAttributes() ?>>
<span id="el_ap_terceros_Contacto_tercero">
<input type="text" data-table="ap_terceros" data-field="x_Contacto_tercero" name="x_Contacto_tercero" id="x_Contacto_tercero" size="30" maxlength="80" placeholder="<?php echo ew_HtmlEncode($ap_terceros->Contacto_tercero->getPlaceHolder()) ?>" value="<?php echo $ap_terceros->Contacto_tercero->EditValue ?>"<?php echo $ap_terceros->Contacto_tercero->EditAttributes() ?>>
</span>
<?php echo $ap_terceros->Contacto_tercero->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_terceros->gran_contrib_tercero->Visible) { // gran_contrib_tercero ?>
	<div id="r_gran_contrib_tercero" class="form-group">
		<label id="elh_ap_terceros_gran_contrib_tercero" for="x_gran_contrib_tercero" class="col-sm-2 control-label ewLabel"><?php echo $ap_terceros->gran_contrib_tercero->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_terceros->gran_contrib_tercero->CellAttributes() ?>>
<span id="el_ap_terceros_gran_contrib_tercero">
<input type="text" data-table="ap_terceros" data-field="x_gran_contrib_tercero" name="x_gran_contrib_tercero" id="x_gran_contrib_tercero" size="30" placeholder="<?php echo ew_HtmlEncode($ap_terceros->gran_contrib_tercero->getPlaceHolder()) ?>" value="<?php echo $ap_terceros->gran_contrib_tercero->EditValue ?>"<?php echo $ap_terceros->gran_contrib_tercero->EditAttributes() ?>>
</span>
<?php echo $ap_terceros->gran_contrib_tercero->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_terceros->autoretenedor_tercero->Visible) { // autoretenedor_tercero ?>
	<div id="r_autoretenedor_tercero" class="form-group">
		<label id="elh_ap_terceros_autoretenedor_tercero" for="x_autoretenedor_tercero" class="col-sm-2 control-label ewLabel"><?php echo $ap_terceros->autoretenedor_tercero->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_terceros->autoretenedor_tercero->CellAttributes() ?>>
<span id="el_ap_terceros_autoretenedor_tercero">
<input type="text" data-table="ap_terceros" data-field="x_autoretenedor_tercero" name="x_autoretenedor_tercero" id="x_autoretenedor_tercero" size="30" placeholder="<?php echo ew_HtmlEncode($ap_terceros->autoretenedor_tercero->getPlaceHolder()) ?>" value="<?php echo $ap_terceros->autoretenedor_tercero->EditValue ?>"<?php echo $ap_terceros->autoretenedor_tercero->EditAttributes() ?>>
</span>
<?php echo $ap_terceros->autoretenedor_tercero->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_terceros->activo_tercero->Visible) { // activo_tercero ?>
	<div id="r_activo_tercero" class="form-group">
		<label id="elh_ap_terceros_activo_tercero" for="x_activo_tercero" class="col-sm-2 control-label ewLabel"><?php echo $ap_terceros->activo_tercero->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_terceros->activo_tercero->CellAttributes() ?>>
<span id="el_ap_terceros_activo_tercero">
<input type="text" data-table="ap_terceros" data-field="x_activo_tercero" name="x_activo_tercero" id="x_activo_tercero" size="30" placeholder="<?php echo ew_HtmlEncode($ap_terceros->activo_tercero->getPlaceHolder()) ?>" value="<?php echo $ap_terceros->activo_tercero->EditValue ?>"<?php echo $ap_terceros->activo_tercero->EditAttributes() ?>>
</span>
<?php echo $ap_terceros->activo_tercero->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_terceros->tercero__registrado_por->Visible) { // tercero_ registrado_por ?>
	<div id="r_tercero__registrado_por" class="form-group">
		<label id="elh_ap_terceros_tercero__registrado_por" for="x_tercero__registrado_por" class="col-sm-2 control-label ewLabel"><?php echo $ap_terceros->tercero__registrado_por->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_terceros->tercero__registrado_por->CellAttributes() ?>>
<span id="el_ap_terceros_tercero__registrado_por">
<input type="text" data-table="ap_terceros" data-field="x_tercero__registrado_por" name="x_tercero__registrado_por" id="x_tercero__registrado_por" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($ap_terceros->tercero__registrado_por->getPlaceHolder()) ?>" value="<?php echo $ap_terceros->tercero__registrado_por->EditValue ?>"<?php echo $ap_terceros->tercero__registrado_por->EditAttributes() ?>>
</span>
<?php echo $ap_terceros->tercero__registrado_por->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_terceros->reg_comun_tercero->Visible) { // reg_comun_tercero ?>
	<div id="r_reg_comun_tercero" class="form-group">
		<label id="elh_ap_terceros_reg_comun_tercero" for="x_reg_comun_tercero" class="col-sm-2 control-label ewLabel"><?php echo $ap_terceros->reg_comun_tercero->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_terceros->reg_comun_tercero->CellAttributes() ?>>
<span id="el_ap_terceros_reg_comun_tercero">
<input type="text" data-table="ap_terceros" data-field="x_reg_comun_tercero" name="x_reg_comun_tercero" id="x_reg_comun_tercero" size="30" placeholder="<?php echo ew_HtmlEncode($ap_terceros->reg_comun_tercero->getPlaceHolder()) ?>" value="<?php echo $ap_terceros->reg_comun_tercero->EditValue ?>"<?php echo $ap_terceros->reg_comun_tercero->EditAttributes() ?>>
</span>
<?php echo $ap_terceros->reg_comun_tercero->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_terceros->responsable_materiales_tercero->Visible) { // responsable_materiales_tercero ?>
	<div id="r_responsable_materiales_tercero" class="form-group">
		<label id="elh_ap_terceros_responsable_materiales_tercero" for="x_responsable_materiales_tercero" class="col-sm-2 control-label ewLabel"><?php echo $ap_terceros->responsable_materiales_tercero->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_terceros->responsable_materiales_tercero->CellAttributes() ?>>
<span id="el_ap_terceros_responsable_materiales_tercero">
<input type="text" data-table="ap_terceros" data-field="x_responsable_materiales_tercero" name="x_responsable_materiales_tercero" id="x_responsable_materiales_tercero" size="30" placeholder="<?php echo ew_HtmlEncode($ap_terceros->responsable_materiales_tercero->getPlaceHolder()) ?>" value="<?php echo $ap_terceros->responsable_materiales_tercero->EditValue ?>"<?php echo $ap_terceros->responsable_materiales_tercero->EditAttributes() ?>>
</span>
<?php echo $ap_terceros->responsable_materiales_tercero->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_terceros->grupo_nomina_tercero->Visible) { // grupo_nomina_tercero ?>
	<div id="r_grupo_nomina_tercero" class="form-group">
		<label id="elh_ap_terceros_grupo_nomina_tercero" for="x_grupo_nomina_tercero" class="col-sm-2 control-label ewLabel"><?php echo $ap_terceros->grupo_nomina_tercero->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_terceros->grupo_nomina_tercero->CellAttributes() ?>>
<span id="el_ap_terceros_grupo_nomina_tercero">
<input type="text" data-table="ap_terceros" data-field="x_grupo_nomina_tercero" name="x_grupo_nomina_tercero" id="x_grupo_nomina_tercero" size="30" placeholder="<?php echo ew_HtmlEncode($ap_terceros->grupo_nomina_tercero->getPlaceHolder()) ?>" value="<?php echo $ap_terceros->grupo_nomina_tercero->EditValue ?>"<?php echo $ap_terceros->grupo_nomina_tercero->EditAttributes() ?>>
</span>
<?php echo $ap_terceros->grupo_nomina_tercero->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_terceros->tercero__lider_Obra->Visible) { // tercero_ lider_Obra ?>
	<div id="r_tercero__lider_Obra" class="form-group">
		<label id="elh_ap_terceros_tercero__lider_Obra" for="x_tercero__lider_Obra" class="col-sm-2 control-label ewLabel"><?php echo $ap_terceros->tercero__lider_Obra->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_terceros->tercero__lider_Obra->CellAttributes() ?>>
<span id="el_ap_terceros_tercero__lider_Obra">
<input type="text" data-table="ap_terceros" data-field="x_tercero__lider_Obra" name="x_tercero__lider_Obra" id="x_tercero__lider_Obra" size="30" placeholder="<?php echo ew_HtmlEncode($ap_terceros->tercero__lider_Obra->getPlaceHolder()) ?>" value="<?php echo $ap_terceros->tercero__lider_Obra->EditValue ?>"<?php echo $ap_terceros->tercero__lider_Obra->EditAttributes() ?>>
</span>
<?php echo $ap_terceros->tercero__lider_Obra->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_terceros->tercero_nombre_lider->Visible) { // tercero_nombre_lider ?>
	<div id="r_tercero_nombre_lider" class="form-group">
		<label id="elh_ap_terceros_tercero_nombre_lider" for="x_tercero_nombre_lider" class="col-sm-2 control-label ewLabel"><?php echo $ap_terceros->tercero_nombre_lider->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_terceros->tercero_nombre_lider->CellAttributes() ?>>
<span id="el_ap_terceros_tercero_nombre_lider">
<input type="text" data-table="ap_terceros" data-field="x_tercero_nombre_lider" name="x_tercero_nombre_lider" id="x_tercero_nombre_lider" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($ap_terceros->tercero_nombre_lider->getPlaceHolder()) ?>" value="<?php echo $ap_terceros->tercero_nombre_lider->EditValue ?>"<?php echo $ap_terceros->tercero_nombre_lider->EditAttributes() ?>>
</span>
<?php echo $ap_terceros->tercero_nombre_lider->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_terceros->empresa_tercero->Visible) { // empresa_tercero ?>
	<div id="r_empresa_tercero" class="form-group">
		<label id="elh_ap_terceros_empresa_tercero" for="x_empresa_tercero" class="col-sm-2 control-label ewLabel"><?php echo $ap_terceros->empresa_tercero->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_terceros->empresa_tercero->CellAttributes() ?>>
<span id="el_ap_terceros_empresa_tercero">
<input type="text" data-table="ap_terceros" data-field="x_empresa_tercero" name="x_empresa_tercero" id="x_empresa_tercero" size="30" placeholder="<?php echo ew_HtmlEncode($ap_terceros->empresa_tercero->getPlaceHolder()) ?>" value="<?php echo $ap_terceros->empresa_tercero->EditValue ?>"<?php echo $ap_terceros->empresa_tercero->EditAttributes() ?>>
</span>
<?php echo $ap_terceros->empresa_tercero->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$ap_terceros_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $ap_terceros_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fap_tercerosadd.Init();
</script>
<?php
$ap_terceros_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$ap_terceros_add->Page_Terminate();
?>
