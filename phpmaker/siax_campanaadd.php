<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "siax_campanainfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$siax_campana_add = NULL; // Initialize page object first

class csiax_campana_add extends csiax_campana {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{6A9AC718-A824-45A3-BED3-A95E91E6986D}";

	// Table name
	var $TableName = 'siax_campana';

	// Page object name
	var $PageObjName = 'siax_campana_add';

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

		// Table object (siax_campana)
		if (!isset($GLOBALS["siax_campana"]) || get_class($GLOBALS["siax_campana"]) == "csiax_campana") {
			$GLOBALS["siax_campana"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["siax_campana"];
		}

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'siax_campana', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("siax_campanalist.php"));
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
		$this->nombre_campana->SetVisibility();
		$this->descuente_campana->SetVisibility();
		$this->desc_financ_campana->SetVisibility();
		$this->plazo_max_campana->SetVisibility();
		$this->detalle_campana->SetVisibility();
		$this->aplicacion_campana->SetVisibility();
		$this->desde_campana->SetVisibility();
		$this->hasta_campana->SetVisibility();
		$this->vigente_campana->SetVisibility();
		$this->tasa_campana->SetVisibility();
		$this->descuento_fijo_campana->SetVisibility();
		$this->manto_max_campana->SetVisibility();
		$this->condiciones_campana->SetVisibility();

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
		global $EW_EXPORT, $siax_campana;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($siax_campana);
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
			if (@$_GET["id_campana"] != "") {
				$this->id_campana->setQueryStringValue($_GET["id_campana"]);
				$this->setKey("id_campana", $this->id_campana->CurrentValue); // Set up key
			} else {
				$this->setKey("id_campana", ""); // Clear key
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
					$this->Page_Terminate("siax_campanalist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "siax_campanalist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "siax_campanaview.php")
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
		$this->nombre_campana->CurrentValue = NULL;
		$this->nombre_campana->OldValue = $this->nombre_campana->CurrentValue;
		$this->descuente_campana->CurrentValue = 0.000000;
		$this->desc_financ_campana->CurrentValue = 0.000000;
		$this->plazo_max_campana->CurrentValue = NULL;
		$this->plazo_max_campana->OldValue = $this->plazo_max_campana->CurrentValue;
		$this->detalle_campana->CurrentValue = NULL;
		$this->detalle_campana->OldValue = $this->detalle_campana->CurrentValue;
		$this->aplicacion_campana->CurrentValue = NULL;
		$this->aplicacion_campana->OldValue = $this->aplicacion_campana->CurrentValue;
		$this->desde_campana->CurrentValue = NULL;
		$this->desde_campana->OldValue = $this->desde_campana->CurrentValue;
		$this->hasta_campana->CurrentValue = NULL;
		$this->hasta_campana->OldValue = $this->hasta_campana->CurrentValue;
		$this->vigente_campana->CurrentValue = 1;
		$this->tasa_campana->CurrentValue = 0.000000;
		$this->descuento_fijo_campana->CurrentValue = 0.0000;
		$this->manto_max_campana->CurrentValue = NULL;
		$this->manto_max_campana->OldValue = $this->manto_max_campana->CurrentValue;
		$this->condiciones_campana->CurrentValue = NULL;
		$this->condiciones_campana->OldValue = $this->condiciones_campana->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->nombre_campana->FldIsDetailKey) {
			$this->nombre_campana->setFormValue($objForm->GetValue("x_nombre_campana"));
		}
		if (!$this->descuente_campana->FldIsDetailKey) {
			$this->descuente_campana->setFormValue($objForm->GetValue("x_descuente_campana"));
		}
		if (!$this->desc_financ_campana->FldIsDetailKey) {
			$this->desc_financ_campana->setFormValue($objForm->GetValue("x_desc_financ_campana"));
		}
		if (!$this->plazo_max_campana->FldIsDetailKey) {
			$this->plazo_max_campana->setFormValue($objForm->GetValue("x_plazo_max_campana"));
		}
		if (!$this->detalle_campana->FldIsDetailKey) {
			$this->detalle_campana->setFormValue($objForm->GetValue("x_detalle_campana"));
		}
		if (!$this->aplicacion_campana->FldIsDetailKey) {
			$this->aplicacion_campana->setFormValue($objForm->GetValue("x_aplicacion_campana"));
		}
		if (!$this->desde_campana->FldIsDetailKey) {
			$this->desde_campana->setFormValue($objForm->GetValue("x_desde_campana"));
			$this->desde_campana->CurrentValue = ew_UnFormatDateTime($this->desde_campana->CurrentValue, 0);
		}
		if (!$this->hasta_campana->FldIsDetailKey) {
			$this->hasta_campana->setFormValue($objForm->GetValue("x_hasta_campana"));
			$this->hasta_campana->CurrentValue = ew_UnFormatDateTime($this->hasta_campana->CurrentValue, 0);
		}
		if (!$this->vigente_campana->FldIsDetailKey) {
			$this->vigente_campana->setFormValue($objForm->GetValue("x_vigente_campana"));
		}
		if (!$this->tasa_campana->FldIsDetailKey) {
			$this->tasa_campana->setFormValue($objForm->GetValue("x_tasa_campana"));
		}
		if (!$this->descuento_fijo_campana->FldIsDetailKey) {
			$this->descuento_fijo_campana->setFormValue($objForm->GetValue("x_descuento_fijo_campana"));
		}
		if (!$this->manto_max_campana->FldIsDetailKey) {
			$this->manto_max_campana->setFormValue($objForm->GetValue("x_manto_max_campana"));
		}
		if (!$this->condiciones_campana->FldIsDetailKey) {
			$this->condiciones_campana->setFormValue($objForm->GetValue("x_condiciones_campana"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->nombre_campana->CurrentValue = $this->nombre_campana->FormValue;
		$this->descuente_campana->CurrentValue = $this->descuente_campana->FormValue;
		$this->desc_financ_campana->CurrentValue = $this->desc_financ_campana->FormValue;
		$this->plazo_max_campana->CurrentValue = $this->plazo_max_campana->FormValue;
		$this->detalle_campana->CurrentValue = $this->detalle_campana->FormValue;
		$this->aplicacion_campana->CurrentValue = $this->aplicacion_campana->FormValue;
		$this->desde_campana->CurrentValue = $this->desde_campana->FormValue;
		$this->desde_campana->CurrentValue = ew_UnFormatDateTime($this->desde_campana->CurrentValue, 0);
		$this->hasta_campana->CurrentValue = $this->hasta_campana->FormValue;
		$this->hasta_campana->CurrentValue = ew_UnFormatDateTime($this->hasta_campana->CurrentValue, 0);
		$this->vigente_campana->CurrentValue = $this->vigente_campana->FormValue;
		$this->tasa_campana->CurrentValue = $this->tasa_campana->FormValue;
		$this->descuento_fijo_campana->CurrentValue = $this->descuento_fijo_campana->FormValue;
		$this->manto_max_campana->CurrentValue = $this->manto_max_campana->FormValue;
		$this->condiciones_campana->CurrentValue = $this->condiciones_campana->FormValue;
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

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id_campana->DbValue = $row['id_campana'];
		$this->nombre_campana->DbValue = $row['nombre_campana'];
		$this->descuente_campana->DbValue = $row['descuente_campana'];
		$this->desc_financ_campana->DbValue = $row['desc_financ_campana'];
		$this->plazo_max_campana->DbValue = $row['plazo_max_campana'];
		$this->detalle_campana->DbValue = $row['detalle_campana'];
		$this->aplicacion_campana->DbValue = $row['aplicacion_campana'];
		$this->desde_campana->DbValue = $row['desde_campana'];
		$this->hasta_campana->DbValue = $row['hasta_campana'];
		$this->vigente_campana->DbValue = $row['vigente_campana'];
		$this->tasa_campana->DbValue = $row['tasa_campana'];
		$this->descuento_fijo_campana->DbValue = $row['descuento_fijo_campana'];
		$this->manto_max_campana->DbValue = $row['manto_max_campana'];
		$this->condiciones_campana->DbValue = $row['condiciones_campana'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("id_campana")) <> "")
			$this->id_campana->CurrentValue = $this->getKey("id_campana"); // id_campana
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

		if ($this->descuente_campana->FormValue == $this->descuente_campana->CurrentValue && is_numeric(ew_StrToFloat($this->descuente_campana->CurrentValue)))
			$this->descuente_campana->CurrentValue = ew_StrToFloat($this->descuente_campana->CurrentValue);

		// Convert decimal values if posted back
		if ($this->desc_financ_campana->FormValue == $this->desc_financ_campana->CurrentValue && is_numeric(ew_StrToFloat($this->desc_financ_campana->CurrentValue)))
			$this->desc_financ_campana->CurrentValue = ew_StrToFloat($this->desc_financ_campana->CurrentValue);

		// Convert decimal values if posted back
		if ($this->tasa_campana->FormValue == $this->tasa_campana->CurrentValue && is_numeric(ew_StrToFloat($this->tasa_campana->CurrentValue)))
			$this->tasa_campana->CurrentValue = ew_StrToFloat($this->tasa_campana->CurrentValue);

		// Convert decimal values if posted back
		if ($this->descuento_fijo_campana->FormValue == $this->descuento_fijo_campana->CurrentValue && is_numeric(ew_StrToFloat($this->descuento_fijo_campana->CurrentValue)))
			$this->descuento_fijo_campana->CurrentValue = ew_StrToFloat($this->descuento_fijo_campana->CurrentValue);

		// Convert decimal values if posted back
		if ($this->manto_max_campana->FormValue == $this->manto_max_campana->CurrentValue && is_numeric(ew_StrToFloat($this->manto_max_campana->CurrentValue)))
			$this->manto_max_campana->CurrentValue = ew_StrToFloat($this->manto_max_campana->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
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

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

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
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// nombre_campana
			$this->nombre_campana->EditAttrs["class"] = "form-control";
			$this->nombre_campana->EditCustomAttributes = "";
			$this->nombre_campana->EditValue = ew_HtmlEncode($this->nombre_campana->CurrentValue);
			$this->nombre_campana->PlaceHolder = ew_RemoveHtml($this->nombre_campana->FldCaption());

			// descuente_campana
			$this->descuente_campana->EditAttrs["class"] = "form-control";
			$this->descuente_campana->EditCustomAttributes = "";
			$this->descuente_campana->EditValue = ew_HtmlEncode($this->descuente_campana->CurrentValue);
			$this->descuente_campana->PlaceHolder = ew_RemoveHtml($this->descuente_campana->FldCaption());
			if (strval($this->descuente_campana->EditValue) <> "" && is_numeric($this->descuente_campana->EditValue)) $this->descuente_campana->EditValue = ew_FormatNumber($this->descuente_campana->EditValue, -2, -1, -2, 0);

			// desc_financ_campana
			$this->desc_financ_campana->EditAttrs["class"] = "form-control";
			$this->desc_financ_campana->EditCustomAttributes = "";
			$this->desc_financ_campana->EditValue = ew_HtmlEncode($this->desc_financ_campana->CurrentValue);
			$this->desc_financ_campana->PlaceHolder = ew_RemoveHtml($this->desc_financ_campana->FldCaption());
			if (strval($this->desc_financ_campana->EditValue) <> "" && is_numeric($this->desc_financ_campana->EditValue)) $this->desc_financ_campana->EditValue = ew_FormatNumber($this->desc_financ_campana->EditValue, -2, -1, -2, 0);

			// plazo_max_campana
			$this->plazo_max_campana->EditAttrs["class"] = "form-control";
			$this->plazo_max_campana->EditCustomAttributes = "";
			$this->plazo_max_campana->EditValue = ew_HtmlEncode($this->plazo_max_campana->CurrentValue);
			$this->plazo_max_campana->PlaceHolder = ew_RemoveHtml($this->plazo_max_campana->FldCaption());

			// detalle_campana
			$this->detalle_campana->EditAttrs["class"] = "form-control";
			$this->detalle_campana->EditCustomAttributes = "";
			$this->detalle_campana->EditValue = ew_HtmlEncode($this->detalle_campana->CurrentValue);
			$this->detalle_campana->PlaceHolder = ew_RemoveHtml($this->detalle_campana->FldCaption());

			// aplicacion_campana
			$this->aplicacion_campana->EditAttrs["class"] = "form-control";
			$this->aplicacion_campana->EditCustomAttributes = "";
			$this->aplicacion_campana->EditValue = ew_HtmlEncode($this->aplicacion_campana->CurrentValue);
			$this->aplicacion_campana->PlaceHolder = ew_RemoveHtml($this->aplicacion_campana->FldCaption());

			// desde_campana
			$this->desde_campana->EditAttrs["class"] = "form-control";
			$this->desde_campana->EditCustomAttributes = "";
			$this->desde_campana->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->desde_campana->CurrentValue, 8));
			$this->desde_campana->PlaceHolder = ew_RemoveHtml($this->desde_campana->FldCaption());

			// hasta_campana
			$this->hasta_campana->EditAttrs["class"] = "form-control";
			$this->hasta_campana->EditCustomAttributes = "";
			$this->hasta_campana->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->hasta_campana->CurrentValue, 8));
			$this->hasta_campana->PlaceHolder = ew_RemoveHtml($this->hasta_campana->FldCaption());

			// vigente_campana
			$this->vigente_campana->EditAttrs["class"] = "form-control";
			$this->vigente_campana->EditCustomAttributes = "";
			$this->vigente_campana->EditValue = ew_HtmlEncode($this->vigente_campana->CurrentValue);
			$this->vigente_campana->PlaceHolder = ew_RemoveHtml($this->vigente_campana->FldCaption());

			// tasa_campana
			$this->tasa_campana->EditAttrs["class"] = "form-control";
			$this->tasa_campana->EditCustomAttributes = "";
			$this->tasa_campana->EditValue = ew_HtmlEncode($this->tasa_campana->CurrentValue);
			$this->tasa_campana->PlaceHolder = ew_RemoveHtml($this->tasa_campana->FldCaption());
			if (strval($this->tasa_campana->EditValue) <> "" && is_numeric($this->tasa_campana->EditValue)) $this->tasa_campana->EditValue = ew_FormatNumber($this->tasa_campana->EditValue, -2, -1, -2, 0);

			// descuento_fijo_campana
			$this->descuento_fijo_campana->EditAttrs["class"] = "form-control";
			$this->descuento_fijo_campana->EditCustomAttributes = "";
			$this->descuento_fijo_campana->EditValue = ew_HtmlEncode($this->descuento_fijo_campana->CurrentValue);
			$this->descuento_fijo_campana->PlaceHolder = ew_RemoveHtml($this->descuento_fijo_campana->FldCaption());
			if (strval($this->descuento_fijo_campana->EditValue) <> "" && is_numeric($this->descuento_fijo_campana->EditValue)) $this->descuento_fijo_campana->EditValue = ew_FormatNumber($this->descuento_fijo_campana->EditValue, -2, -1, -2, 0);

			// manto_max_campana
			$this->manto_max_campana->EditAttrs["class"] = "form-control";
			$this->manto_max_campana->EditCustomAttributes = "";
			$this->manto_max_campana->EditValue = ew_HtmlEncode($this->manto_max_campana->CurrentValue);
			$this->manto_max_campana->PlaceHolder = ew_RemoveHtml($this->manto_max_campana->FldCaption());
			if (strval($this->manto_max_campana->EditValue) <> "" && is_numeric($this->manto_max_campana->EditValue)) $this->manto_max_campana->EditValue = ew_FormatNumber($this->manto_max_campana->EditValue, -2, -1, -2, 0);

			// condiciones_campana
			$this->condiciones_campana->EditAttrs["class"] = "form-control";
			$this->condiciones_campana->EditCustomAttributes = "";
			$this->condiciones_campana->EditValue = ew_HtmlEncode($this->condiciones_campana->CurrentValue);
			$this->condiciones_campana->PlaceHolder = ew_RemoveHtml($this->condiciones_campana->FldCaption());

			// Add refer script
			// nombre_campana

			$this->nombre_campana->LinkCustomAttributes = "";
			$this->nombre_campana->HrefValue = "";

			// descuente_campana
			$this->descuente_campana->LinkCustomAttributes = "";
			$this->descuente_campana->HrefValue = "";

			// desc_financ_campana
			$this->desc_financ_campana->LinkCustomAttributes = "";
			$this->desc_financ_campana->HrefValue = "";

			// plazo_max_campana
			$this->plazo_max_campana->LinkCustomAttributes = "";
			$this->plazo_max_campana->HrefValue = "";

			// detalle_campana
			$this->detalle_campana->LinkCustomAttributes = "";
			$this->detalle_campana->HrefValue = "";

			// aplicacion_campana
			$this->aplicacion_campana->LinkCustomAttributes = "";
			$this->aplicacion_campana->HrefValue = "";

			// desde_campana
			$this->desde_campana->LinkCustomAttributes = "";
			$this->desde_campana->HrefValue = "";

			// hasta_campana
			$this->hasta_campana->LinkCustomAttributes = "";
			$this->hasta_campana->HrefValue = "";

			// vigente_campana
			$this->vigente_campana->LinkCustomAttributes = "";
			$this->vigente_campana->HrefValue = "";

			// tasa_campana
			$this->tasa_campana->LinkCustomAttributes = "";
			$this->tasa_campana->HrefValue = "";

			// descuento_fijo_campana
			$this->descuento_fijo_campana->LinkCustomAttributes = "";
			$this->descuento_fijo_campana->HrefValue = "";

			// manto_max_campana
			$this->manto_max_campana->LinkCustomAttributes = "";
			$this->manto_max_campana->HrefValue = "";

			// condiciones_campana
			$this->condiciones_campana->LinkCustomAttributes = "";
			$this->condiciones_campana->HrefValue = "";
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
		if (!$this->nombre_campana->FldIsDetailKey && !is_null($this->nombre_campana->FormValue) && $this->nombre_campana->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->nombre_campana->FldCaption(), $this->nombre_campana->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->descuente_campana->FormValue)) {
			ew_AddMessage($gsFormError, $this->descuente_campana->FldErrMsg());
		}
		if (!ew_CheckNumber($this->desc_financ_campana->FormValue)) {
			ew_AddMessage($gsFormError, $this->desc_financ_campana->FldErrMsg());
		}
		if (!ew_CheckInteger($this->plazo_max_campana->FormValue)) {
			ew_AddMessage($gsFormError, $this->plazo_max_campana->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->desde_campana->FormValue)) {
			ew_AddMessage($gsFormError, $this->desde_campana->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->hasta_campana->FormValue)) {
			ew_AddMessage($gsFormError, $this->hasta_campana->FldErrMsg());
		}
		if (!ew_CheckInteger($this->vigente_campana->FormValue)) {
			ew_AddMessage($gsFormError, $this->vigente_campana->FldErrMsg());
		}
		if (!ew_CheckNumber($this->tasa_campana->FormValue)) {
			ew_AddMessage($gsFormError, $this->tasa_campana->FldErrMsg());
		}
		if (!ew_CheckNumber($this->descuento_fijo_campana->FormValue)) {
			ew_AddMessage($gsFormError, $this->descuento_fijo_campana->FldErrMsg());
		}
		if (!ew_CheckNumber($this->manto_max_campana->FormValue)) {
			ew_AddMessage($gsFormError, $this->manto_max_campana->FldErrMsg());
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

		// nombre_campana
		$this->nombre_campana->SetDbValueDef($rsnew, $this->nombre_campana->CurrentValue, "", FALSE);

		// descuente_campana
		$this->descuente_campana->SetDbValueDef($rsnew, $this->descuente_campana->CurrentValue, NULL, strval($this->descuente_campana->CurrentValue) == "");

		// desc_financ_campana
		$this->desc_financ_campana->SetDbValueDef($rsnew, $this->desc_financ_campana->CurrentValue, NULL, strval($this->desc_financ_campana->CurrentValue) == "");

		// plazo_max_campana
		$this->plazo_max_campana->SetDbValueDef($rsnew, $this->plazo_max_campana->CurrentValue, NULL, FALSE);

		// detalle_campana
		$this->detalle_campana->SetDbValueDef($rsnew, $this->detalle_campana->CurrentValue, NULL, FALSE);

		// aplicacion_campana
		$this->aplicacion_campana->SetDbValueDef($rsnew, $this->aplicacion_campana->CurrentValue, NULL, FALSE);

		// desde_campana
		$this->desde_campana->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->desde_campana->CurrentValue, 0), NULL, FALSE);

		// hasta_campana
		$this->hasta_campana->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->hasta_campana->CurrentValue, 0), NULL, FALSE);

		// vigente_campana
		$this->vigente_campana->SetDbValueDef($rsnew, $this->vigente_campana->CurrentValue, NULL, strval($this->vigente_campana->CurrentValue) == "");

		// tasa_campana
		$this->tasa_campana->SetDbValueDef($rsnew, $this->tasa_campana->CurrentValue, NULL, strval($this->tasa_campana->CurrentValue) == "");

		// descuento_fijo_campana
		$this->descuento_fijo_campana->SetDbValueDef($rsnew, $this->descuento_fijo_campana->CurrentValue, NULL, strval($this->descuento_fijo_campana->CurrentValue) == "");

		// manto_max_campana
		$this->manto_max_campana->SetDbValueDef($rsnew, $this->manto_max_campana->CurrentValue, NULL, FALSE);

		// condiciones_campana
		$this->condiciones_campana->SetDbValueDef($rsnew, $this->condiciones_campana->CurrentValue, NULL, FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {

				// Get insert id if necessary
				$this->id_campana->setDbValue($conn->Insert_ID());
				$rsnew['id_campana'] = $this->id_campana->DbValue;
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("siax_campanalist.php"), "", $this->TableVar, TRUE);
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
if (!isset($siax_campana_add)) $siax_campana_add = new csiax_campana_add();

// Page init
$siax_campana_add->Page_Init();

// Page main
$siax_campana_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$siax_campana_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fsiax_campanaadd = new ew_Form("fsiax_campanaadd", "add");

// Validate form
fsiax_campanaadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_nombre_campana");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $siax_campana->nombre_campana->FldCaption(), $siax_campana->nombre_campana->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_descuente_campana");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($siax_campana->descuente_campana->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_desc_financ_campana");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($siax_campana->desc_financ_campana->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_plazo_max_campana");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($siax_campana->plazo_max_campana->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_desde_campana");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($siax_campana->desde_campana->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_hasta_campana");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($siax_campana->hasta_campana->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_vigente_campana");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($siax_campana->vigente_campana->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_tasa_campana");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($siax_campana->tasa_campana->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_descuento_fijo_campana");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($siax_campana->descuento_fijo_campana->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_manto_max_campana");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($siax_campana->manto_max_campana->FldErrMsg()) ?>");

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
fsiax_campanaadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fsiax_campanaadd.ValidateRequired = true;
<?php } else { ?>
fsiax_campanaadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$siax_campana_add->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $siax_campana_add->ShowPageHeader(); ?>
<?php
$siax_campana_add->ShowMessage();
?>
<form name="fsiax_campanaadd" id="fsiax_campanaadd" class="<?php echo $siax_campana_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($siax_campana_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $siax_campana_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="siax_campana">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($siax_campana_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($siax_campana->nombre_campana->Visible) { // nombre_campana ?>
	<div id="r_nombre_campana" class="form-group">
		<label id="elh_siax_campana_nombre_campana" for="x_nombre_campana" class="col-sm-2 control-label ewLabel"><?php echo $siax_campana->nombre_campana->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $siax_campana->nombre_campana->CellAttributes() ?>>
<span id="el_siax_campana_nombre_campana">
<input type="text" data-table="siax_campana" data-field="x_nombre_campana" name="x_nombre_campana" id="x_nombre_campana" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($siax_campana->nombre_campana->getPlaceHolder()) ?>" value="<?php echo $siax_campana->nombre_campana->EditValue ?>"<?php echo $siax_campana->nombre_campana->EditAttributes() ?>>
</span>
<?php echo $siax_campana->nombre_campana->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($siax_campana->descuente_campana->Visible) { // descuente_campana ?>
	<div id="r_descuente_campana" class="form-group">
		<label id="elh_siax_campana_descuente_campana" for="x_descuente_campana" class="col-sm-2 control-label ewLabel"><?php echo $siax_campana->descuente_campana->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $siax_campana->descuente_campana->CellAttributes() ?>>
<span id="el_siax_campana_descuente_campana">
<input type="text" data-table="siax_campana" data-field="x_descuente_campana" name="x_descuente_campana" id="x_descuente_campana" size="30" placeholder="<?php echo ew_HtmlEncode($siax_campana->descuente_campana->getPlaceHolder()) ?>" value="<?php echo $siax_campana->descuente_campana->EditValue ?>"<?php echo $siax_campana->descuente_campana->EditAttributes() ?>>
</span>
<?php echo $siax_campana->descuente_campana->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($siax_campana->desc_financ_campana->Visible) { // desc_financ_campana ?>
	<div id="r_desc_financ_campana" class="form-group">
		<label id="elh_siax_campana_desc_financ_campana" for="x_desc_financ_campana" class="col-sm-2 control-label ewLabel"><?php echo $siax_campana->desc_financ_campana->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $siax_campana->desc_financ_campana->CellAttributes() ?>>
<span id="el_siax_campana_desc_financ_campana">
<input type="text" data-table="siax_campana" data-field="x_desc_financ_campana" name="x_desc_financ_campana" id="x_desc_financ_campana" size="30" placeholder="<?php echo ew_HtmlEncode($siax_campana->desc_financ_campana->getPlaceHolder()) ?>" value="<?php echo $siax_campana->desc_financ_campana->EditValue ?>"<?php echo $siax_campana->desc_financ_campana->EditAttributes() ?>>
</span>
<?php echo $siax_campana->desc_financ_campana->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($siax_campana->plazo_max_campana->Visible) { // plazo_max_campana ?>
	<div id="r_plazo_max_campana" class="form-group">
		<label id="elh_siax_campana_plazo_max_campana" for="x_plazo_max_campana" class="col-sm-2 control-label ewLabel"><?php echo $siax_campana->plazo_max_campana->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $siax_campana->plazo_max_campana->CellAttributes() ?>>
<span id="el_siax_campana_plazo_max_campana">
<input type="text" data-table="siax_campana" data-field="x_plazo_max_campana" name="x_plazo_max_campana" id="x_plazo_max_campana" size="30" placeholder="<?php echo ew_HtmlEncode($siax_campana->plazo_max_campana->getPlaceHolder()) ?>" value="<?php echo $siax_campana->plazo_max_campana->EditValue ?>"<?php echo $siax_campana->plazo_max_campana->EditAttributes() ?>>
</span>
<?php echo $siax_campana->plazo_max_campana->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($siax_campana->detalle_campana->Visible) { // detalle_campana ?>
	<div id="r_detalle_campana" class="form-group">
		<label id="elh_siax_campana_detalle_campana" for="x_detalle_campana" class="col-sm-2 control-label ewLabel"><?php echo $siax_campana->detalle_campana->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $siax_campana->detalle_campana->CellAttributes() ?>>
<span id="el_siax_campana_detalle_campana">
<textarea data-table="siax_campana" data-field="x_detalle_campana" name="x_detalle_campana" id="x_detalle_campana" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($siax_campana->detalle_campana->getPlaceHolder()) ?>"<?php echo $siax_campana->detalle_campana->EditAttributes() ?>><?php echo $siax_campana->detalle_campana->EditValue ?></textarea>
</span>
<?php echo $siax_campana->detalle_campana->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($siax_campana->aplicacion_campana->Visible) { // aplicacion_campana ?>
	<div id="r_aplicacion_campana" class="form-group">
		<label id="elh_siax_campana_aplicacion_campana" for="x_aplicacion_campana" class="col-sm-2 control-label ewLabel"><?php echo $siax_campana->aplicacion_campana->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $siax_campana->aplicacion_campana->CellAttributes() ?>>
<span id="el_siax_campana_aplicacion_campana">
<textarea data-table="siax_campana" data-field="x_aplicacion_campana" name="x_aplicacion_campana" id="x_aplicacion_campana" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($siax_campana->aplicacion_campana->getPlaceHolder()) ?>"<?php echo $siax_campana->aplicacion_campana->EditAttributes() ?>><?php echo $siax_campana->aplicacion_campana->EditValue ?></textarea>
</span>
<?php echo $siax_campana->aplicacion_campana->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($siax_campana->desde_campana->Visible) { // desde_campana ?>
	<div id="r_desde_campana" class="form-group">
		<label id="elh_siax_campana_desde_campana" for="x_desde_campana" class="col-sm-2 control-label ewLabel"><?php echo $siax_campana->desde_campana->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $siax_campana->desde_campana->CellAttributes() ?>>
<span id="el_siax_campana_desde_campana">
<input type="text" data-table="siax_campana" data-field="x_desde_campana" name="x_desde_campana" id="x_desde_campana" placeholder="<?php echo ew_HtmlEncode($siax_campana->desde_campana->getPlaceHolder()) ?>" value="<?php echo $siax_campana->desde_campana->EditValue ?>"<?php echo $siax_campana->desde_campana->EditAttributes() ?>>
</span>
<?php echo $siax_campana->desde_campana->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($siax_campana->hasta_campana->Visible) { // hasta_campana ?>
	<div id="r_hasta_campana" class="form-group">
		<label id="elh_siax_campana_hasta_campana" for="x_hasta_campana" class="col-sm-2 control-label ewLabel"><?php echo $siax_campana->hasta_campana->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $siax_campana->hasta_campana->CellAttributes() ?>>
<span id="el_siax_campana_hasta_campana">
<input type="text" data-table="siax_campana" data-field="x_hasta_campana" name="x_hasta_campana" id="x_hasta_campana" placeholder="<?php echo ew_HtmlEncode($siax_campana->hasta_campana->getPlaceHolder()) ?>" value="<?php echo $siax_campana->hasta_campana->EditValue ?>"<?php echo $siax_campana->hasta_campana->EditAttributes() ?>>
</span>
<?php echo $siax_campana->hasta_campana->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($siax_campana->vigente_campana->Visible) { // vigente_campana ?>
	<div id="r_vigente_campana" class="form-group">
		<label id="elh_siax_campana_vigente_campana" for="x_vigente_campana" class="col-sm-2 control-label ewLabel"><?php echo $siax_campana->vigente_campana->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $siax_campana->vigente_campana->CellAttributes() ?>>
<span id="el_siax_campana_vigente_campana">
<input type="text" data-table="siax_campana" data-field="x_vigente_campana" name="x_vigente_campana" id="x_vigente_campana" size="30" placeholder="<?php echo ew_HtmlEncode($siax_campana->vigente_campana->getPlaceHolder()) ?>" value="<?php echo $siax_campana->vigente_campana->EditValue ?>"<?php echo $siax_campana->vigente_campana->EditAttributes() ?>>
</span>
<?php echo $siax_campana->vigente_campana->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($siax_campana->tasa_campana->Visible) { // tasa_campana ?>
	<div id="r_tasa_campana" class="form-group">
		<label id="elh_siax_campana_tasa_campana" for="x_tasa_campana" class="col-sm-2 control-label ewLabel"><?php echo $siax_campana->tasa_campana->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $siax_campana->tasa_campana->CellAttributes() ?>>
<span id="el_siax_campana_tasa_campana">
<input type="text" data-table="siax_campana" data-field="x_tasa_campana" name="x_tasa_campana" id="x_tasa_campana" size="30" placeholder="<?php echo ew_HtmlEncode($siax_campana->tasa_campana->getPlaceHolder()) ?>" value="<?php echo $siax_campana->tasa_campana->EditValue ?>"<?php echo $siax_campana->tasa_campana->EditAttributes() ?>>
</span>
<?php echo $siax_campana->tasa_campana->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($siax_campana->descuento_fijo_campana->Visible) { // descuento_fijo_campana ?>
	<div id="r_descuento_fijo_campana" class="form-group">
		<label id="elh_siax_campana_descuento_fijo_campana" for="x_descuento_fijo_campana" class="col-sm-2 control-label ewLabel"><?php echo $siax_campana->descuento_fijo_campana->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $siax_campana->descuento_fijo_campana->CellAttributes() ?>>
<span id="el_siax_campana_descuento_fijo_campana">
<input type="text" data-table="siax_campana" data-field="x_descuento_fijo_campana" name="x_descuento_fijo_campana" id="x_descuento_fijo_campana" size="30" placeholder="<?php echo ew_HtmlEncode($siax_campana->descuento_fijo_campana->getPlaceHolder()) ?>" value="<?php echo $siax_campana->descuento_fijo_campana->EditValue ?>"<?php echo $siax_campana->descuento_fijo_campana->EditAttributes() ?>>
</span>
<?php echo $siax_campana->descuento_fijo_campana->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($siax_campana->manto_max_campana->Visible) { // manto_max_campana ?>
	<div id="r_manto_max_campana" class="form-group">
		<label id="elh_siax_campana_manto_max_campana" for="x_manto_max_campana" class="col-sm-2 control-label ewLabel"><?php echo $siax_campana->manto_max_campana->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $siax_campana->manto_max_campana->CellAttributes() ?>>
<span id="el_siax_campana_manto_max_campana">
<input type="text" data-table="siax_campana" data-field="x_manto_max_campana" name="x_manto_max_campana" id="x_manto_max_campana" size="30" placeholder="<?php echo ew_HtmlEncode($siax_campana->manto_max_campana->getPlaceHolder()) ?>" value="<?php echo $siax_campana->manto_max_campana->EditValue ?>"<?php echo $siax_campana->manto_max_campana->EditAttributes() ?>>
</span>
<?php echo $siax_campana->manto_max_campana->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($siax_campana->condiciones_campana->Visible) { // condiciones_campana ?>
	<div id="r_condiciones_campana" class="form-group">
		<label id="elh_siax_campana_condiciones_campana" for="x_condiciones_campana" class="col-sm-2 control-label ewLabel"><?php echo $siax_campana->condiciones_campana->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $siax_campana->condiciones_campana->CellAttributes() ?>>
<span id="el_siax_campana_condiciones_campana">
<textarea data-table="siax_campana" data-field="x_condiciones_campana" name="x_condiciones_campana" id="x_condiciones_campana" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($siax_campana->condiciones_campana->getPlaceHolder()) ?>"<?php echo $siax_campana->condiciones_campana->EditAttributes() ?>><?php echo $siax_campana->condiciones_campana->EditValue ?></textarea>
</span>
<?php echo $siax_campana->condiciones_campana->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$siax_campana_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $siax_campana_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fsiax_campanaadd.Init();
</script>
<?php
$siax_campana_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$siax_campana_add->Page_Terminate();
?>
