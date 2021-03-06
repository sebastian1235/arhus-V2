<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "siax_estado_givinfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$siax_estado_giv_add = NULL; // Initialize page object first

class csiax_estado_giv_add extends csiax_estado_giv {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{6A9AC718-A824-45A3-BED3-A95E91E6986D}";

	// Table name
	var $TableName = 'siax_estado_giv';

	// Page object name
	var $PageObjName = 'siax_estado_giv_add';

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

		// Table object (siax_estado_giv)
		if (!isset($GLOBALS["siax_estado_giv"]) || get_class($GLOBALS["siax_estado_giv"]) == "csiax_estado_giv") {
			$GLOBALS["siax_estado_giv"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["siax_estado_giv"];
		}

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'siax_estado_giv', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("siax_estado_givlist.php"));
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
		$this->nombre_estado_giv->SetVisibility();
		$this->para_factura_estado_giv->SetVisibility();
		$this->se_paga_comision_estado_giv->SetVisibility();
		$this->porcen_comis_estado_giv->SetVisibility();
		$this->paga_bono_estado_giv->SetVisibility();
		$this->porcen_bono_estado_giv->SetVisibility();
		$this->obs_estado_giv->SetVisibility();
		$this->envio_boffice_estado_giv->SetVisibility();

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
		global $EW_EXPORT, $siax_estado_giv;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($siax_estado_giv);
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
			if (@$_GET["id_estado_giv"] != "") {
				$this->id_estado_giv->setQueryStringValue($_GET["id_estado_giv"]);
				$this->setKey("id_estado_giv", $this->id_estado_giv->CurrentValue); // Set up key
			} else {
				$this->setKey("id_estado_giv", ""); // Clear key
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
					$this->Page_Terminate("siax_estado_givlist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "siax_estado_givlist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "siax_estado_givview.php")
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
		$this->nombre_estado_giv->CurrentValue = NULL;
		$this->nombre_estado_giv->OldValue = $this->nombre_estado_giv->CurrentValue;
		$this->para_factura_estado_giv->CurrentValue = 0;
		$this->se_paga_comision_estado_giv->CurrentValue = 0;
		$this->porcen_comis_estado_giv->CurrentValue = 0.00;
		$this->paga_bono_estado_giv->CurrentValue = 0;
		$this->porcen_bono_estado_giv->CurrentValue = 0.00;
		$this->obs_estado_giv->CurrentValue = NULL;
		$this->obs_estado_giv->OldValue = $this->obs_estado_giv->CurrentValue;
		$this->envio_boffice_estado_giv->CurrentValue = 0;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->nombre_estado_giv->FldIsDetailKey) {
			$this->nombre_estado_giv->setFormValue($objForm->GetValue("x_nombre_estado_giv"));
		}
		if (!$this->para_factura_estado_giv->FldIsDetailKey) {
			$this->para_factura_estado_giv->setFormValue($objForm->GetValue("x_para_factura_estado_giv"));
		}
		if (!$this->se_paga_comision_estado_giv->FldIsDetailKey) {
			$this->se_paga_comision_estado_giv->setFormValue($objForm->GetValue("x_se_paga_comision_estado_giv"));
		}
		if (!$this->porcen_comis_estado_giv->FldIsDetailKey) {
			$this->porcen_comis_estado_giv->setFormValue($objForm->GetValue("x_porcen_comis_estado_giv"));
		}
		if (!$this->paga_bono_estado_giv->FldIsDetailKey) {
			$this->paga_bono_estado_giv->setFormValue($objForm->GetValue("x_paga_bono_estado_giv"));
		}
		if (!$this->porcen_bono_estado_giv->FldIsDetailKey) {
			$this->porcen_bono_estado_giv->setFormValue($objForm->GetValue("x_porcen_bono_estado_giv"));
		}
		if (!$this->obs_estado_giv->FldIsDetailKey) {
			$this->obs_estado_giv->setFormValue($objForm->GetValue("x_obs_estado_giv"));
		}
		if (!$this->envio_boffice_estado_giv->FldIsDetailKey) {
			$this->envio_boffice_estado_giv->setFormValue($objForm->GetValue("x_envio_boffice_estado_giv"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->nombre_estado_giv->CurrentValue = $this->nombre_estado_giv->FormValue;
		$this->para_factura_estado_giv->CurrentValue = $this->para_factura_estado_giv->FormValue;
		$this->se_paga_comision_estado_giv->CurrentValue = $this->se_paga_comision_estado_giv->FormValue;
		$this->porcen_comis_estado_giv->CurrentValue = $this->porcen_comis_estado_giv->FormValue;
		$this->paga_bono_estado_giv->CurrentValue = $this->paga_bono_estado_giv->FormValue;
		$this->porcen_bono_estado_giv->CurrentValue = $this->porcen_bono_estado_giv->FormValue;
		$this->obs_estado_giv->CurrentValue = $this->obs_estado_giv->FormValue;
		$this->envio_boffice_estado_giv->CurrentValue = $this->envio_boffice_estado_giv->FormValue;
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
		$this->nombre_estado_giv->setDbValue($rs->fields('nombre_estado_giv'));
		$this->para_factura_estado_giv->setDbValue($rs->fields('para_factura_estado_giv'));
		$this->se_paga_comision_estado_giv->setDbValue($rs->fields('se_paga_comision_estado_giv'));
		$this->porcen_comis_estado_giv->setDbValue($rs->fields('porcen_comis_estado_giv'));
		$this->paga_bono_estado_giv->setDbValue($rs->fields('paga_bono_estado_giv'));
		$this->porcen_bono_estado_giv->setDbValue($rs->fields('porcen_bono_estado_giv'));
		$this->obs_estado_giv->setDbValue($rs->fields('obs_estado_giv'));
		$this->envio_boffice_estado_giv->setDbValue($rs->fields('envio_boffice_estado_giv'));
		$this->id_estado_giv->setDbValue($rs->fields('id_estado_giv'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->nombre_estado_giv->DbValue = $row['nombre_estado_giv'];
		$this->para_factura_estado_giv->DbValue = $row['para_factura_estado_giv'];
		$this->se_paga_comision_estado_giv->DbValue = $row['se_paga_comision_estado_giv'];
		$this->porcen_comis_estado_giv->DbValue = $row['porcen_comis_estado_giv'];
		$this->paga_bono_estado_giv->DbValue = $row['paga_bono_estado_giv'];
		$this->porcen_bono_estado_giv->DbValue = $row['porcen_bono_estado_giv'];
		$this->obs_estado_giv->DbValue = $row['obs_estado_giv'];
		$this->envio_boffice_estado_giv->DbValue = $row['envio_boffice_estado_giv'];
		$this->id_estado_giv->DbValue = $row['id_estado_giv'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("id_estado_giv")) <> "")
			$this->id_estado_giv->CurrentValue = $this->getKey("id_estado_giv"); // id_estado_giv
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

		if ($this->porcen_comis_estado_giv->FormValue == $this->porcen_comis_estado_giv->CurrentValue && is_numeric(ew_StrToFloat($this->porcen_comis_estado_giv->CurrentValue)))
			$this->porcen_comis_estado_giv->CurrentValue = ew_StrToFloat($this->porcen_comis_estado_giv->CurrentValue);

		// Convert decimal values if posted back
		if ($this->porcen_bono_estado_giv->FormValue == $this->porcen_bono_estado_giv->CurrentValue && is_numeric(ew_StrToFloat($this->porcen_bono_estado_giv->CurrentValue)))
			$this->porcen_bono_estado_giv->CurrentValue = ew_StrToFloat($this->porcen_bono_estado_giv->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// nombre_estado_giv
		// para_factura_estado_giv
		// se_paga_comision_estado_giv
		// porcen_comis_estado_giv
		// paga_bono_estado_giv
		// porcen_bono_estado_giv
		// obs_estado_giv
		// envio_boffice_estado_giv
		// id_estado_giv

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// nombre_estado_giv
		$this->nombre_estado_giv->ViewValue = $this->nombre_estado_giv->CurrentValue;
		$this->nombre_estado_giv->ViewCustomAttributes = "";

		// para_factura_estado_giv
		$this->para_factura_estado_giv->ViewValue = $this->para_factura_estado_giv->CurrentValue;
		$this->para_factura_estado_giv->ViewCustomAttributes = "";

		// se_paga_comision_estado_giv
		$this->se_paga_comision_estado_giv->ViewValue = $this->se_paga_comision_estado_giv->CurrentValue;
		$this->se_paga_comision_estado_giv->ViewCustomAttributes = "";

		// porcen_comis_estado_giv
		$this->porcen_comis_estado_giv->ViewValue = $this->porcen_comis_estado_giv->CurrentValue;
		$this->porcen_comis_estado_giv->ViewCustomAttributes = "";

		// paga_bono_estado_giv
		$this->paga_bono_estado_giv->ViewValue = $this->paga_bono_estado_giv->CurrentValue;
		$this->paga_bono_estado_giv->ViewCustomAttributes = "";

		// porcen_bono_estado_giv
		$this->porcen_bono_estado_giv->ViewValue = $this->porcen_bono_estado_giv->CurrentValue;
		$this->porcen_bono_estado_giv->ViewCustomAttributes = "";

		// obs_estado_giv
		$this->obs_estado_giv->ViewValue = $this->obs_estado_giv->CurrentValue;
		$this->obs_estado_giv->ViewCustomAttributes = "";

		// envio_boffice_estado_giv
		$this->envio_boffice_estado_giv->ViewValue = $this->envio_boffice_estado_giv->CurrentValue;
		$this->envio_boffice_estado_giv->ViewCustomAttributes = "";

		// id_estado_giv
		$this->id_estado_giv->ViewValue = $this->id_estado_giv->CurrentValue;
		$this->id_estado_giv->ViewCustomAttributes = "";

			// nombre_estado_giv
			$this->nombre_estado_giv->LinkCustomAttributes = "";
			$this->nombre_estado_giv->HrefValue = "";
			$this->nombre_estado_giv->TooltipValue = "";

			// para_factura_estado_giv
			$this->para_factura_estado_giv->LinkCustomAttributes = "";
			$this->para_factura_estado_giv->HrefValue = "";
			$this->para_factura_estado_giv->TooltipValue = "";

			// se_paga_comision_estado_giv
			$this->se_paga_comision_estado_giv->LinkCustomAttributes = "";
			$this->se_paga_comision_estado_giv->HrefValue = "";
			$this->se_paga_comision_estado_giv->TooltipValue = "";

			// porcen_comis_estado_giv
			$this->porcen_comis_estado_giv->LinkCustomAttributes = "";
			$this->porcen_comis_estado_giv->HrefValue = "";
			$this->porcen_comis_estado_giv->TooltipValue = "";

			// paga_bono_estado_giv
			$this->paga_bono_estado_giv->LinkCustomAttributes = "";
			$this->paga_bono_estado_giv->HrefValue = "";
			$this->paga_bono_estado_giv->TooltipValue = "";

			// porcen_bono_estado_giv
			$this->porcen_bono_estado_giv->LinkCustomAttributes = "";
			$this->porcen_bono_estado_giv->HrefValue = "";
			$this->porcen_bono_estado_giv->TooltipValue = "";

			// obs_estado_giv
			$this->obs_estado_giv->LinkCustomAttributes = "";
			$this->obs_estado_giv->HrefValue = "";
			$this->obs_estado_giv->TooltipValue = "";

			// envio_boffice_estado_giv
			$this->envio_boffice_estado_giv->LinkCustomAttributes = "";
			$this->envio_boffice_estado_giv->HrefValue = "";
			$this->envio_boffice_estado_giv->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// nombre_estado_giv
			$this->nombre_estado_giv->EditAttrs["class"] = "form-control";
			$this->nombre_estado_giv->EditCustomAttributes = "";
			$this->nombre_estado_giv->EditValue = ew_HtmlEncode($this->nombre_estado_giv->CurrentValue);
			$this->nombre_estado_giv->PlaceHolder = ew_RemoveHtml($this->nombre_estado_giv->FldCaption());

			// para_factura_estado_giv
			$this->para_factura_estado_giv->EditAttrs["class"] = "form-control";
			$this->para_factura_estado_giv->EditCustomAttributes = "";
			$this->para_factura_estado_giv->EditValue = ew_HtmlEncode($this->para_factura_estado_giv->CurrentValue);
			$this->para_factura_estado_giv->PlaceHolder = ew_RemoveHtml($this->para_factura_estado_giv->FldCaption());

			// se_paga_comision_estado_giv
			$this->se_paga_comision_estado_giv->EditAttrs["class"] = "form-control";
			$this->se_paga_comision_estado_giv->EditCustomAttributes = "";
			$this->se_paga_comision_estado_giv->EditValue = ew_HtmlEncode($this->se_paga_comision_estado_giv->CurrentValue);
			$this->se_paga_comision_estado_giv->PlaceHolder = ew_RemoveHtml($this->se_paga_comision_estado_giv->FldCaption());

			// porcen_comis_estado_giv
			$this->porcen_comis_estado_giv->EditAttrs["class"] = "form-control";
			$this->porcen_comis_estado_giv->EditCustomAttributes = "";
			$this->porcen_comis_estado_giv->EditValue = ew_HtmlEncode($this->porcen_comis_estado_giv->CurrentValue);
			$this->porcen_comis_estado_giv->PlaceHolder = ew_RemoveHtml($this->porcen_comis_estado_giv->FldCaption());
			if (strval($this->porcen_comis_estado_giv->EditValue) <> "" && is_numeric($this->porcen_comis_estado_giv->EditValue)) $this->porcen_comis_estado_giv->EditValue = ew_FormatNumber($this->porcen_comis_estado_giv->EditValue, -2, -1, -2, 0);

			// paga_bono_estado_giv
			$this->paga_bono_estado_giv->EditAttrs["class"] = "form-control";
			$this->paga_bono_estado_giv->EditCustomAttributes = "";
			$this->paga_bono_estado_giv->EditValue = ew_HtmlEncode($this->paga_bono_estado_giv->CurrentValue);
			$this->paga_bono_estado_giv->PlaceHolder = ew_RemoveHtml($this->paga_bono_estado_giv->FldCaption());

			// porcen_bono_estado_giv
			$this->porcen_bono_estado_giv->EditAttrs["class"] = "form-control";
			$this->porcen_bono_estado_giv->EditCustomAttributes = "";
			$this->porcen_bono_estado_giv->EditValue = ew_HtmlEncode($this->porcen_bono_estado_giv->CurrentValue);
			$this->porcen_bono_estado_giv->PlaceHolder = ew_RemoveHtml($this->porcen_bono_estado_giv->FldCaption());
			if (strval($this->porcen_bono_estado_giv->EditValue) <> "" && is_numeric($this->porcen_bono_estado_giv->EditValue)) $this->porcen_bono_estado_giv->EditValue = ew_FormatNumber($this->porcen_bono_estado_giv->EditValue, -2, -1, -2, 0);

			// obs_estado_giv
			$this->obs_estado_giv->EditAttrs["class"] = "form-control";
			$this->obs_estado_giv->EditCustomAttributes = "";
			$this->obs_estado_giv->EditValue = ew_HtmlEncode($this->obs_estado_giv->CurrentValue);
			$this->obs_estado_giv->PlaceHolder = ew_RemoveHtml($this->obs_estado_giv->FldCaption());

			// envio_boffice_estado_giv
			$this->envio_boffice_estado_giv->EditAttrs["class"] = "form-control";
			$this->envio_boffice_estado_giv->EditCustomAttributes = "";
			$this->envio_boffice_estado_giv->EditValue = ew_HtmlEncode($this->envio_boffice_estado_giv->CurrentValue);
			$this->envio_boffice_estado_giv->PlaceHolder = ew_RemoveHtml($this->envio_boffice_estado_giv->FldCaption());

			// Add refer script
			// nombre_estado_giv

			$this->nombre_estado_giv->LinkCustomAttributes = "";
			$this->nombre_estado_giv->HrefValue = "";

			// para_factura_estado_giv
			$this->para_factura_estado_giv->LinkCustomAttributes = "";
			$this->para_factura_estado_giv->HrefValue = "";

			// se_paga_comision_estado_giv
			$this->se_paga_comision_estado_giv->LinkCustomAttributes = "";
			$this->se_paga_comision_estado_giv->HrefValue = "";

			// porcen_comis_estado_giv
			$this->porcen_comis_estado_giv->LinkCustomAttributes = "";
			$this->porcen_comis_estado_giv->HrefValue = "";

			// paga_bono_estado_giv
			$this->paga_bono_estado_giv->LinkCustomAttributes = "";
			$this->paga_bono_estado_giv->HrefValue = "";

			// porcen_bono_estado_giv
			$this->porcen_bono_estado_giv->LinkCustomAttributes = "";
			$this->porcen_bono_estado_giv->HrefValue = "";

			// obs_estado_giv
			$this->obs_estado_giv->LinkCustomAttributes = "";
			$this->obs_estado_giv->HrefValue = "";

			// envio_boffice_estado_giv
			$this->envio_boffice_estado_giv->LinkCustomAttributes = "";
			$this->envio_boffice_estado_giv->HrefValue = "";
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
		if (!ew_CheckInteger($this->para_factura_estado_giv->FormValue)) {
			ew_AddMessage($gsFormError, $this->para_factura_estado_giv->FldErrMsg());
		}
		if (!ew_CheckInteger($this->se_paga_comision_estado_giv->FormValue)) {
			ew_AddMessage($gsFormError, $this->se_paga_comision_estado_giv->FldErrMsg());
		}
		if (!ew_CheckNumber($this->porcen_comis_estado_giv->FormValue)) {
			ew_AddMessage($gsFormError, $this->porcen_comis_estado_giv->FldErrMsg());
		}
		if (!ew_CheckInteger($this->paga_bono_estado_giv->FormValue)) {
			ew_AddMessage($gsFormError, $this->paga_bono_estado_giv->FldErrMsg());
		}
		if (!ew_CheckNumber($this->porcen_bono_estado_giv->FormValue)) {
			ew_AddMessage($gsFormError, $this->porcen_bono_estado_giv->FldErrMsg());
		}
		if (!ew_CheckInteger($this->envio_boffice_estado_giv->FormValue)) {
			ew_AddMessage($gsFormError, $this->envio_boffice_estado_giv->FldErrMsg());
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

		// nombre_estado_giv
		$this->nombre_estado_giv->SetDbValueDef($rsnew, $this->nombre_estado_giv->CurrentValue, NULL, FALSE);

		// para_factura_estado_giv
		$this->para_factura_estado_giv->SetDbValueDef($rsnew, $this->para_factura_estado_giv->CurrentValue, NULL, strval($this->para_factura_estado_giv->CurrentValue) == "");

		// se_paga_comision_estado_giv
		$this->se_paga_comision_estado_giv->SetDbValueDef($rsnew, $this->se_paga_comision_estado_giv->CurrentValue, NULL, strval($this->se_paga_comision_estado_giv->CurrentValue) == "");

		// porcen_comis_estado_giv
		$this->porcen_comis_estado_giv->SetDbValueDef($rsnew, $this->porcen_comis_estado_giv->CurrentValue, NULL, strval($this->porcen_comis_estado_giv->CurrentValue) == "");

		// paga_bono_estado_giv
		$this->paga_bono_estado_giv->SetDbValueDef($rsnew, $this->paga_bono_estado_giv->CurrentValue, NULL, strval($this->paga_bono_estado_giv->CurrentValue) == "");

		// porcen_bono_estado_giv
		$this->porcen_bono_estado_giv->SetDbValueDef($rsnew, $this->porcen_bono_estado_giv->CurrentValue, NULL, strval($this->porcen_bono_estado_giv->CurrentValue) == "");

		// obs_estado_giv
		$this->obs_estado_giv->SetDbValueDef($rsnew, $this->obs_estado_giv->CurrentValue, NULL, FALSE);

		// envio_boffice_estado_giv
		$this->envio_boffice_estado_giv->SetDbValueDef($rsnew, $this->envio_boffice_estado_giv->CurrentValue, NULL, strval($this->envio_boffice_estado_giv->CurrentValue) == "");

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {

				// Get insert id if necessary
				$this->id_estado_giv->setDbValue($conn->Insert_ID());
				$rsnew['id_estado_giv'] = $this->id_estado_giv->DbValue;
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("siax_estado_givlist.php"), "", $this->TableVar, TRUE);
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
if (!isset($siax_estado_giv_add)) $siax_estado_giv_add = new csiax_estado_giv_add();

// Page init
$siax_estado_giv_add->Page_Init();

// Page main
$siax_estado_giv_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$siax_estado_giv_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fsiax_estado_givadd = new ew_Form("fsiax_estado_givadd", "add");

// Validate form
fsiax_estado_givadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_para_factura_estado_giv");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($siax_estado_giv->para_factura_estado_giv->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_se_paga_comision_estado_giv");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($siax_estado_giv->se_paga_comision_estado_giv->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_porcen_comis_estado_giv");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($siax_estado_giv->porcen_comis_estado_giv->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_paga_bono_estado_giv");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($siax_estado_giv->paga_bono_estado_giv->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_porcen_bono_estado_giv");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($siax_estado_giv->porcen_bono_estado_giv->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_envio_boffice_estado_giv");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($siax_estado_giv->envio_boffice_estado_giv->FldErrMsg()) ?>");

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
fsiax_estado_givadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fsiax_estado_givadd.ValidateRequired = true;
<?php } else { ?>
fsiax_estado_givadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$siax_estado_giv_add->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $siax_estado_giv_add->ShowPageHeader(); ?>
<?php
$siax_estado_giv_add->ShowMessage();
?>
<form name="fsiax_estado_givadd" id="fsiax_estado_givadd" class="<?php echo $siax_estado_giv_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($siax_estado_giv_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $siax_estado_giv_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="siax_estado_giv">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($siax_estado_giv_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($siax_estado_giv->nombre_estado_giv->Visible) { // nombre_estado_giv ?>
	<div id="r_nombre_estado_giv" class="form-group">
		<label id="elh_siax_estado_giv_nombre_estado_giv" for="x_nombre_estado_giv" class="col-sm-2 control-label ewLabel"><?php echo $siax_estado_giv->nombre_estado_giv->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $siax_estado_giv->nombre_estado_giv->CellAttributes() ?>>
<span id="el_siax_estado_giv_nombre_estado_giv">
<input type="text" data-table="siax_estado_giv" data-field="x_nombre_estado_giv" name="x_nombre_estado_giv" id="x_nombre_estado_giv" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($siax_estado_giv->nombre_estado_giv->getPlaceHolder()) ?>" value="<?php echo $siax_estado_giv->nombre_estado_giv->EditValue ?>"<?php echo $siax_estado_giv->nombre_estado_giv->EditAttributes() ?>>
</span>
<?php echo $siax_estado_giv->nombre_estado_giv->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($siax_estado_giv->para_factura_estado_giv->Visible) { // para_factura_estado_giv ?>
	<div id="r_para_factura_estado_giv" class="form-group">
		<label id="elh_siax_estado_giv_para_factura_estado_giv" for="x_para_factura_estado_giv" class="col-sm-2 control-label ewLabel"><?php echo $siax_estado_giv->para_factura_estado_giv->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $siax_estado_giv->para_factura_estado_giv->CellAttributes() ?>>
<span id="el_siax_estado_giv_para_factura_estado_giv">
<input type="text" data-table="siax_estado_giv" data-field="x_para_factura_estado_giv" name="x_para_factura_estado_giv" id="x_para_factura_estado_giv" size="30" placeholder="<?php echo ew_HtmlEncode($siax_estado_giv->para_factura_estado_giv->getPlaceHolder()) ?>" value="<?php echo $siax_estado_giv->para_factura_estado_giv->EditValue ?>"<?php echo $siax_estado_giv->para_factura_estado_giv->EditAttributes() ?>>
</span>
<?php echo $siax_estado_giv->para_factura_estado_giv->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($siax_estado_giv->se_paga_comision_estado_giv->Visible) { // se_paga_comision_estado_giv ?>
	<div id="r_se_paga_comision_estado_giv" class="form-group">
		<label id="elh_siax_estado_giv_se_paga_comision_estado_giv" for="x_se_paga_comision_estado_giv" class="col-sm-2 control-label ewLabel"><?php echo $siax_estado_giv->se_paga_comision_estado_giv->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $siax_estado_giv->se_paga_comision_estado_giv->CellAttributes() ?>>
<span id="el_siax_estado_giv_se_paga_comision_estado_giv">
<input type="text" data-table="siax_estado_giv" data-field="x_se_paga_comision_estado_giv" name="x_se_paga_comision_estado_giv" id="x_se_paga_comision_estado_giv" size="30" placeholder="<?php echo ew_HtmlEncode($siax_estado_giv->se_paga_comision_estado_giv->getPlaceHolder()) ?>" value="<?php echo $siax_estado_giv->se_paga_comision_estado_giv->EditValue ?>"<?php echo $siax_estado_giv->se_paga_comision_estado_giv->EditAttributes() ?>>
</span>
<?php echo $siax_estado_giv->se_paga_comision_estado_giv->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($siax_estado_giv->porcen_comis_estado_giv->Visible) { // porcen_comis_estado_giv ?>
	<div id="r_porcen_comis_estado_giv" class="form-group">
		<label id="elh_siax_estado_giv_porcen_comis_estado_giv" for="x_porcen_comis_estado_giv" class="col-sm-2 control-label ewLabel"><?php echo $siax_estado_giv->porcen_comis_estado_giv->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $siax_estado_giv->porcen_comis_estado_giv->CellAttributes() ?>>
<span id="el_siax_estado_giv_porcen_comis_estado_giv">
<input type="text" data-table="siax_estado_giv" data-field="x_porcen_comis_estado_giv" name="x_porcen_comis_estado_giv" id="x_porcen_comis_estado_giv" size="30" placeholder="<?php echo ew_HtmlEncode($siax_estado_giv->porcen_comis_estado_giv->getPlaceHolder()) ?>" value="<?php echo $siax_estado_giv->porcen_comis_estado_giv->EditValue ?>"<?php echo $siax_estado_giv->porcen_comis_estado_giv->EditAttributes() ?>>
</span>
<?php echo $siax_estado_giv->porcen_comis_estado_giv->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($siax_estado_giv->paga_bono_estado_giv->Visible) { // paga_bono_estado_giv ?>
	<div id="r_paga_bono_estado_giv" class="form-group">
		<label id="elh_siax_estado_giv_paga_bono_estado_giv" for="x_paga_bono_estado_giv" class="col-sm-2 control-label ewLabel"><?php echo $siax_estado_giv->paga_bono_estado_giv->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $siax_estado_giv->paga_bono_estado_giv->CellAttributes() ?>>
<span id="el_siax_estado_giv_paga_bono_estado_giv">
<input type="text" data-table="siax_estado_giv" data-field="x_paga_bono_estado_giv" name="x_paga_bono_estado_giv" id="x_paga_bono_estado_giv" size="30" placeholder="<?php echo ew_HtmlEncode($siax_estado_giv->paga_bono_estado_giv->getPlaceHolder()) ?>" value="<?php echo $siax_estado_giv->paga_bono_estado_giv->EditValue ?>"<?php echo $siax_estado_giv->paga_bono_estado_giv->EditAttributes() ?>>
</span>
<?php echo $siax_estado_giv->paga_bono_estado_giv->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($siax_estado_giv->porcen_bono_estado_giv->Visible) { // porcen_bono_estado_giv ?>
	<div id="r_porcen_bono_estado_giv" class="form-group">
		<label id="elh_siax_estado_giv_porcen_bono_estado_giv" for="x_porcen_bono_estado_giv" class="col-sm-2 control-label ewLabel"><?php echo $siax_estado_giv->porcen_bono_estado_giv->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $siax_estado_giv->porcen_bono_estado_giv->CellAttributes() ?>>
<span id="el_siax_estado_giv_porcen_bono_estado_giv">
<input type="text" data-table="siax_estado_giv" data-field="x_porcen_bono_estado_giv" name="x_porcen_bono_estado_giv" id="x_porcen_bono_estado_giv" size="30" placeholder="<?php echo ew_HtmlEncode($siax_estado_giv->porcen_bono_estado_giv->getPlaceHolder()) ?>" value="<?php echo $siax_estado_giv->porcen_bono_estado_giv->EditValue ?>"<?php echo $siax_estado_giv->porcen_bono_estado_giv->EditAttributes() ?>>
</span>
<?php echo $siax_estado_giv->porcen_bono_estado_giv->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($siax_estado_giv->obs_estado_giv->Visible) { // obs_estado_giv ?>
	<div id="r_obs_estado_giv" class="form-group">
		<label id="elh_siax_estado_giv_obs_estado_giv" for="x_obs_estado_giv" class="col-sm-2 control-label ewLabel"><?php echo $siax_estado_giv->obs_estado_giv->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $siax_estado_giv->obs_estado_giv->CellAttributes() ?>>
<span id="el_siax_estado_giv_obs_estado_giv">
<textarea data-table="siax_estado_giv" data-field="x_obs_estado_giv" name="x_obs_estado_giv" id="x_obs_estado_giv" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($siax_estado_giv->obs_estado_giv->getPlaceHolder()) ?>"<?php echo $siax_estado_giv->obs_estado_giv->EditAttributes() ?>><?php echo $siax_estado_giv->obs_estado_giv->EditValue ?></textarea>
</span>
<?php echo $siax_estado_giv->obs_estado_giv->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($siax_estado_giv->envio_boffice_estado_giv->Visible) { // envio_boffice_estado_giv ?>
	<div id="r_envio_boffice_estado_giv" class="form-group">
		<label id="elh_siax_estado_giv_envio_boffice_estado_giv" for="x_envio_boffice_estado_giv" class="col-sm-2 control-label ewLabel"><?php echo $siax_estado_giv->envio_boffice_estado_giv->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $siax_estado_giv->envio_boffice_estado_giv->CellAttributes() ?>>
<span id="el_siax_estado_giv_envio_boffice_estado_giv">
<input type="text" data-table="siax_estado_giv" data-field="x_envio_boffice_estado_giv" name="x_envio_boffice_estado_giv" id="x_envio_boffice_estado_giv" size="30" placeholder="<?php echo ew_HtmlEncode($siax_estado_giv->envio_boffice_estado_giv->getPlaceHolder()) ?>" value="<?php echo $siax_estado_giv->envio_boffice_estado_giv->EditValue ?>"<?php echo $siax_estado_giv->envio_boffice_estado_giv->EditAttributes() ?>>
</span>
<?php echo $siax_estado_giv->envio_boffice_estado_giv->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$siax_estado_giv_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $siax_estado_giv_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fsiax_estado_givadd.Init();
</script>
<?php
$siax_estado_giv_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$siax_estado_giv_add->Page_Terminate();
?>
