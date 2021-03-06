<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "ap_detalle_ventainfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$ap_detalle_venta_edit = NULL; // Initialize page object first

class cap_detalle_venta_edit extends cap_detalle_venta {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{6A9AC718-A824-45A3-BED3-A95E91E6986D}";

	// Table name
	var $TableName = 'ap_detalle_venta';

	// Page object name
	var $PageObjName = 'ap_detalle_venta_edit';

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

		// Table object (ap_detalle_venta)
		if (!isset($GLOBALS["ap_detalle_venta"]) || get_class($GLOBALS["ap_detalle_venta"]) == "cap_detalle_venta") {
			$GLOBALS["ap_detalle_venta"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["ap_detalle_venta"];
		}

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'ap_detalle_venta', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("ap_detalle_ventalist.php"));
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
		$this->id_det_venta->SetVisibility();
		$this->id_det_venta->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->venta_det_venta->SetVisibility();
		$this->codigo_det_venta->SetVisibility();
		$this->descripcion_det_venta->SetVisibility();
		$this->precio_det_venta->SetVisibility();
		$this->cantidad_det_venta->SetVisibility();
		$this->total_det_venta->SetVisibility();
		$this->tipo_det_venta->SetVisibility();
		$this->empresa_det_venta->SetVisibility();

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
		global $EW_EXPORT, $ap_detalle_venta;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($ap_detalle_venta);
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
		if (@$_GET["id_det_venta"] <> "") {
			$this->id_det_venta->setQueryStringValue($_GET["id_det_venta"]);
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
		if ($this->id_det_venta->CurrentValue == "") {
			$this->Page_Terminate("ap_detalle_ventalist.php"); // Invalid key, return to list
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
					$this->Page_Terminate("ap_detalle_ventalist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "ap_detalle_ventalist.php")
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
		if (!$this->id_det_venta->FldIsDetailKey)
			$this->id_det_venta->setFormValue($objForm->GetValue("x_id_det_venta"));
		if (!$this->venta_det_venta->FldIsDetailKey) {
			$this->venta_det_venta->setFormValue($objForm->GetValue("x_venta_det_venta"));
		}
		if (!$this->codigo_det_venta->FldIsDetailKey) {
			$this->codigo_det_venta->setFormValue($objForm->GetValue("x_codigo_det_venta"));
		}
		if (!$this->descripcion_det_venta->FldIsDetailKey) {
			$this->descripcion_det_venta->setFormValue($objForm->GetValue("x_descripcion_det_venta"));
		}
		if (!$this->precio_det_venta->FldIsDetailKey) {
			$this->precio_det_venta->setFormValue($objForm->GetValue("x_precio_det_venta"));
		}
		if (!$this->cantidad_det_venta->FldIsDetailKey) {
			$this->cantidad_det_venta->setFormValue($objForm->GetValue("x_cantidad_det_venta"));
		}
		if (!$this->total_det_venta->FldIsDetailKey) {
			$this->total_det_venta->setFormValue($objForm->GetValue("x_total_det_venta"));
		}
		if (!$this->tipo_det_venta->FldIsDetailKey) {
			$this->tipo_det_venta->setFormValue($objForm->GetValue("x_tipo_det_venta"));
		}
		if (!$this->empresa_det_venta->FldIsDetailKey) {
			$this->empresa_det_venta->setFormValue($objForm->GetValue("x_empresa_det_venta"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->id_det_venta->CurrentValue = $this->id_det_venta->FormValue;
		$this->venta_det_venta->CurrentValue = $this->venta_det_venta->FormValue;
		$this->codigo_det_venta->CurrentValue = $this->codigo_det_venta->FormValue;
		$this->descripcion_det_venta->CurrentValue = $this->descripcion_det_venta->FormValue;
		$this->precio_det_venta->CurrentValue = $this->precio_det_venta->FormValue;
		$this->cantidad_det_venta->CurrentValue = $this->cantidad_det_venta->FormValue;
		$this->total_det_venta->CurrentValue = $this->total_det_venta->FormValue;
		$this->tipo_det_venta->CurrentValue = $this->tipo_det_venta->FormValue;
		$this->empresa_det_venta->CurrentValue = $this->empresa_det_venta->FormValue;
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
		$this->id_det_venta->setDbValue($rs->fields('id_det_venta'));
		$this->venta_det_venta->setDbValue($rs->fields('venta_det_venta'));
		$this->codigo_det_venta->setDbValue($rs->fields('codigo_det_venta'));
		$this->descripcion_det_venta->setDbValue($rs->fields('descripcion_det_venta'));
		$this->precio_det_venta->setDbValue($rs->fields('precio_det_venta'));
		$this->cantidad_det_venta->setDbValue($rs->fields('cantidad_det_venta'));
		$this->total_det_venta->setDbValue($rs->fields('total_det_venta'));
		$this->tipo_det_venta->setDbValue($rs->fields('tipo_det_venta'));
		$this->empresa_det_venta->setDbValue($rs->fields('empresa_det_venta'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id_det_venta->DbValue = $row['id_det_venta'];
		$this->venta_det_venta->DbValue = $row['venta_det_venta'];
		$this->codigo_det_venta->DbValue = $row['codigo_det_venta'];
		$this->descripcion_det_venta->DbValue = $row['descripcion_det_venta'];
		$this->precio_det_venta->DbValue = $row['precio_det_venta'];
		$this->cantidad_det_venta->DbValue = $row['cantidad_det_venta'];
		$this->total_det_venta->DbValue = $row['total_det_venta'];
		$this->tipo_det_venta->DbValue = $row['tipo_det_venta'];
		$this->empresa_det_venta->DbValue = $row['empresa_det_venta'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Convert decimal values if posted back

		if ($this->precio_det_venta->FormValue == $this->precio_det_venta->CurrentValue && is_numeric(ew_StrToFloat($this->precio_det_venta->CurrentValue)))
			$this->precio_det_venta->CurrentValue = ew_StrToFloat($this->precio_det_venta->CurrentValue);

		// Convert decimal values if posted back
		if ($this->cantidad_det_venta->FormValue == $this->cantidad_det_venta->CurrentValue && is_numeric(ew_StrToFloat($this->cantidad_det_venta->CurrentValue)))
			$this->cantidad_det_venta->CurrentValue = ew_StrToFloat($this->cantidad_det_venta->CurrentValue);

		// Convert decimal values if posted back
		if ($this->total_det_venta->FormValue == $this->total_det_venta->CurrentValue && is_numeric(ew_StrToFloat($this->total_det_venta->CurrentValue)))
			$this->total_det_venta->CurrentValue = ew_StrToFloat($this->total_det_venta->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// id_det_venta
		// venta_det_venta
		// codigo_det_venta
		// descripcion_det_venta
		// precio_det_venta
		// cantidad_det_venta
		// total_det_venta
		// tipo_det_venta
		// empresa_det_venta

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id_det_venta
		$this->id_det_venta->ViewValue = $this->id_det_venta->CurrentValue;
		$this->id_det_venta->ViewCustomAttributes = "";

		// venta_det_venta
		$this->venta_det_venta->ViewValue = $this->venta_det_venta->CurrentValue;
		$this->venta_det_venta->ViewCustomAttributes = "";

		// codigo_det_venta
		$this->codigo_det_venta->ViewValue = $this->codigo_det_venta->CurrentValue;
		$this->codigo_det_venta->ViewCustomAttributes = "";

		// descripcion_det_venta
		$this->descripcion_det_venta->ViewValue = $this->descripcion_det_venta->CurrentValue;
		$this->descripcion_det_venta->ViewCustomAttributes = "";

		// precio_det_venta
		$this->precio_det_venta->ViewValue = $this->precio_det_venta->CurrentValue;
		$this->precio_det_venta->ViewCustomAttributes = "";

		// cantidad_det_venta
		$this->cantidad_det_venta->ViewValue = $this->cantidad_det_venta->CurrentValue;
		$this->cantidad_det_venta->ViewCustomAttributes = "";

		// total_det_venta
		$this->total_det_venta->ViewValue = $this->total_det_venta->CurrentValue;
		$this->total_det_venta->ViewCustomAttributes = "";

		// tipo_det_venta
		$this->tipo_det_venta->ViewValue = $this->tipo_det_venta->CurrentValue;
		$this->tipo_det_venta->ViewCustomAttributes = "";

		// empresa_det_venta
		$this->empresa_det_venta->ViewValue = $this->empresa_det_venta->CurrentValue;
		$this->empresa_det_venta->ViewCustomAttributes = "";

			// id_det_venta
			$this->id_det_venta->LinkCustomAttributes = "";
			$this->id_det_venta->HrefValue = "";
			$this->id_det_venta->TooltipValue = "";

			// venta_det_venta
			$this->venta_det_venta->LinkCustomAttributes = "";
			$this->venta_det_venta->HrefValue = "";
			$this->venta_det_venta->TooltipValue = "";

			// codigo_det_venta
			$this->codigo_det_venta->LinkCustomAttributes = "";
			$this->codigo_det_venta->HrefValue = "";
			$this->codigo_det_venta->TooltipValue = "";

			// descripcion_det_venta
			$this->descripcion_det_venta->LinkCustomAttributes = "";
			$this->descripcion_det_venta->HrefValue = "";
			$this->descripcion_det_venta->TooltipValue = "";

			// precio_det_venta
			$this->precio_det_venta->LinkCustomAttributes = "";
			$this->precio_det_venta->HrefValue = "";
			$this->precio_det_venta->TooltipValue = "";

			// cantidad_det_venta
			$this->cantidad_det_venta->LinkCustomAttributes = "";
			$this->cantidad_det_venta->HrefValue = "";
			$this->cantidad_det_venta->TooltipValue = "";

			// total_det_venta
			$this->total_det_venta->LinkCustomAttributes = "";
			$this->total_det_venta->HrefValue = "";
			$this->total_det_venta->TooltipValue = "";

			// tipo_det_venta
			$this->tipo_det_venta->LinkCustomAttributes = "";
			$this->tipo_det_venta->HrefValue = "";
			$this->tipo_det_venta->TooltipValue = "";

			// empresa_det_venta
			$this->empresa_det_venta->LinkCustomAttributes = "";
			$this->empresa_det_venta->HrefValue = "";
			$this->empresa_det_venta->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// id_det_venta
			$this->id_det_venta->EditAttrs["class"] = "form-control";
			$this->id_det_venta->EditCustomAttributes = "";
			$this->id_det_venta->EditValue = $this->id_det_venta->CurrentValue;
			$this->id_det_venta->ViewCustomAttributes = "";

			// venta_det_venta
			$this->venta_det_venta->EditAttrs["class"] = "form-control";
			$this->venta_det_venta->EditCustomAttributes = "";
			$this->venta_det_venta->EditValue = ew_HtmlEncode($this->venta_det_venta->CurrentValue);
			$this->venta_det_venta->PlaceHolder = ew_RemoveHtml($this->venta_det_venta->FldCaption());

			// codigo_det_venta
			$this->codigo_det_venta->EditAttrs["class"] = "form-control";
			$this->codigo_det_venta->EditCustomAttributes = "";
			$this->codigo_det_venta->EditValue = ew_HtmlEncode($this->codigo_det_venta->CurrentValue);
			$this->codigo_det_venta->PlaceHolder = ew_RemoveHtml($this->codigo_det_venta->FldCaption());

			// descripcion_det_venta
			$this->descripcion_det_venta->EditAttrs["class"] = "form-control";
			$this->descripcion_det_venta->EditCustomAttributes = "";
			$this->descripcion_det_venta->EditValue = ew_HtmlEncode($this->descripcion_det_venta->CurrentValue);
			$this->descripcion_det_venta->PlaceHolder = ew_RemoveHtml($this->descripcion_det_venta->FldCaption());

			// precio_det_venta
			$this->precio_det_venta->EditAttrs["class"] = "form-control";
			$this->precio_det_venta->EditCustomAttributes = "";
			$this->precio_det_venta->EditValue = ew_HtmlEncode($this->precio_det_venta->CurrentValue);
			$this->precio_det_venta->PlaceHolder = ew_RemoveHtml($this->precio_det_venta->FldCaption());
			if (strval($this->precio_det_venta->EditValue) <> "" && is_numeric($this->precio_det_venta->EditValue)) $this->precio_det_venta->EditValue = ew_FormatNumber($this->precio_det_venta->EditValue, -2, -1, -2, 0);

			// cantidad_det_venta
			$this->cantidad_det_venta->EditAttrs["class"] = "form-control";
			$this->cantidad_det_venta->EditCustomAttributes = "";
			$this->cantidad_det_venta->EditValue = ew_HtmlEncode($this->cantidad_det_venta->CurrentValue);
			$this->cantidad_det_venta->PlaceHolder = ew_RemoveHtml($this->cantidad_det_venta->FldCaption());
			if (strval($this->cantidad_det_venta->EditValue) <> "" && is_numeric($this->cantidad_det_venta->EditValue)) $this->cantidad_det_venta->EditValue = ew_FormatNumber($this->cantidad_det_venta->EditValue, -2, -1, -2, 0);

			// total_det_venta
			$this->total_det_venta->EditAttrs["class"] = "form-control";
			$this->total_det_venta->EditCustomAttributes = "";
			$this->total_det_venta->EditValue = ew_HtmlEncode($this->total_det_venta->CurrentValue);
			$this->total_det_venta->PlaceHolder = ew_RemoveHtml($this->total_det_venta->FldCaption());
			if (strval($this->total_det_venta->EditValue) <> "" && is_numeric($this->total_det_venta->EditValue)) $this->total_det_venta->EditValue = ew_FormatNumber($this->total_det_venta->EditValue, -2, -1, -2, 0);

			// tipo_det_venta
			$this->tipo_det_venta->EditAttrs["class"] = "form-control";
			$this->tipo_det_venta->EditCustomAttributes = "";
			$this->tipo_det_venta->EditValue = ew_HtmlEncode($this->tipo_det_venta->CurrentValue);
			$this->tipo_det_venta->PlaceHolder = ew_RemoveHtml($this->tipo_det_venta->FldCaption());

			// empresa_det_venta
			$this->empresa_det_venta->EditAttrs["class"] = "form-control";
			$this->empresa_det_venta->EditCustomAttributes = "";
			$this->empresa_det_venta->EditValue = ew_HtmlEncode($this->empresa_det_venta->CurrentValue);
			$this->empresa_det_venta->PlaceHolder = ew_RemoveHtml($this->empresa_det_venta->FldCaption());

			// Edit refer script
			// id_det_venta

			$this->id_det_venta->LinkCustomAttributes = "";
			$this->id_det_venta->HrefValue = "";

			// venta_det_venta
			$this->venta_det_venta->LinkCustomAttributes = "";
			$this->venta_det_venta->HrefValue = "";

			// codigo_det_venta
			$this->codigo_det_venta->LinkCustomAttributes = "";
			$this->codigo_det_venta->HrefValue = "";

			// descripcion_det_venta
			$this->descripcion_det_venta->LinkCustomAttributes = "";
			$this->descripcion_det_venta->HrefValue = "";

			// precio_det_venta
			$this->precio_det_venta->LinkCustomAttributes = "";
			$this->precio_det_venta->HrefValue = "";

			// cantidad_det_venta
			$this->cantidad_det_venta->LinkCustomAttributes = "";
			$this->cantidad_det_venta->HrefValue = "";

			// total_det_venta
			$this->total_det_venta->LinkCustomAttributes = "";
			$this->total_det_venta->HrefValue = "";

			// tipo_det_venta
			$this->tipo_det_venta->LinkCustomAttributes = "";
			$this->tipo_det_venta->HrefValue = "";

			// empresa_det_venta
			$this->empresa_det_venta->LinkCustomAttributes = "";
			$this->empresa_det_venta->HrefValue = "";
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
		if (!ew_CheckInteger($this->venta_det_venta->FormValue)) {
			ew_AddMessage($gsFormError, $this->venta_det_venta->FldErrMsg());
		}
		if (!ew_CheckInteger($this->codigo_det_venta->FormValue)) {
			ew_AddMessage($gsFormError, $this->codigo_det_venta->FldErrMsg());
		}
		if (!ew_CheckNumber($this->precio_det_venta->FormValue)) {
			ew_AddMessage($gsFormError, $this->precio_det_venta->FldErrMsg());
		}
		if (!ew_CheckNumber($this->cantidad_det_venta->FormValue)) {
			ew_AddMessage($gsFormError, $this->cantidad_det_venta->FldErrMsg());
		}
		if (!ew_CheckNumber($this->total_det_venta->FormValue)) {
			ew_AddMessage($gsFormError, $this->total_det_venta->FldErrMsg());
		}
		if (!ew_CheckInteger($this->tipo_det_venta->FormValue)) {
			ew_AddMessage($gsFormError, $this->tipo_det_venta->FldErrMsg());
		}
		if (!ew_CheckInteger($this->empresa_det_venta->FormValue)) {
			ew_AddMessage($gsFormError, $this->empresa_det_venta->FldErrMsg());
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

			// venta_det_venta
			$this->venta_det_venta->SetDbValueDef($rsnew, $this->venta_det_venta->CurrentValue, NULL, $this->venta_det_venta->ReadOnly);

			// codigo_det_venta
			$this->codigo_det_venta->SetDbValueDef($rsnew, $this->codigo_det_venta->CurrentValue, NULL, $this->codigo_det_venta->ReadOnly);

			// descripcion_det_venta
			$this->descripcion_det_venta->SetDbValueDef($rsnew, $this->descripcion_det_venta->CurrentValue, NULL, $this->descripcion_det_venta->ReadOnly);

			// precio_det_venta
			$this->precio_det_venta->SetDbValueDef($rsnew, $this->precio_det_venta->CurrentValue, NULL, $this->precio_det_venta->ReadOnly);

			// cantidad_det_venta
			$this->cantidad_det_venta->SetDbValueDef($rsnew, $this->cantidad_det_venta->CurrentValue, NULL, $this->cantidad_det_venta->ReadOnly);

			// total_det_venta
			$this->total_det_venta->SetDbValueDef($rsnew, $this->total_det_venta->CurrentValue, NULL, $this->total_det_venta->ReadOnly);

			// tipo_det_venta
			$this->tipo_det_venta->SetDbValueDef($rsnew, $this->tipo_det_venta->CurrentValue, NULL, $this->tipo_det_venta->ReadOnly);

			// empresa_det_venta
			$this->empresa_det_venta->SetDbValueDef($rsnew, $this->empresa_det_venta->CurrentValue, NULL, $this->empresa_det_venta->ReadOnly);

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("ap_detalle_ventalist.php"), "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
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
if (!isset($ap_detalle_venta_edit)) $ap_detalle_venta_edit = new cap_detalle_venta_edit();

// Page init
$ap_detalle_venta_edit->Page_Init();

// Page main
$ap_detalle_venta_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$ap_detalle_venta_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fap_detalle_ventaedit = new ew_Form("fap_detalle_ventaedit", "edit");

// Validate form
fap_detalle_ventaedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_venta_det_venta");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ap_detalle_venta->venta_det_venta->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_codigo_det_venta");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ap_detalle_venta->codigo_det_venta->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_precio_det_venta");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ap_detalle_venta->precio_det_venta->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_cantidad_det_venta");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ap_detalle_venta->cantidad_det_venta->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_total_det_venta");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ap_detalle_venta->total_det_venta->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_tipo_det_venta");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ap_detalle_venta->tipo_det_venta->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_empresa_det_venta");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ap_detalle_venta->empresa_det_venta->FldErrMsg()) ?>");

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
fap_detalle_ventaedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fap_detalle_ventaedit.ValidateRequired = true;
<?php } else { ?>
fap_detalle_ventaedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$ap_detalle_venta_edit->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $ap_detalle_venta_edit->ShowPageHeader(); ?>
<?php
$ap_detalle_venta_edit->ShowMessage();
?>
<form name="fap_detalle_ventaedit" id="fap_detalle_ventaedit" class="<?php echo $ap_detalle_venta_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($ap_detalle_venta_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $ap_detalle_venta_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="ap_detalle_venta">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<?php if ($ap_detalle_venta_edit->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($ap_detalle_venta->id_det_venta->Visible) { // id_det_venta ?>
	<div id="r_id_det_venta" class="form-group">
		<label id="elh_ap_detalle_venta_id_det_venta" class="col-sm-2 control-label ewLabel"><?php echo $ap_detalle_venta->id_det_venta->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_detalle_venta->id_det_venta->CellAttributes() ?>>
<span id="el_ap_detalle_venta_id_det_venta">
<span<?php echo $ap_detalle_venta->id_det_venta->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $ap_detalle_venta->id_det_venta->EditValue ?></p></span>
</span>
<input type="hidden" data-table="ap_detalle_venta" data-field="x_id_det_venta" name="x_id_det_venta" id="x_id_det_venta" value="<?php echo ew_HtmlEncode($ap_detalle_venta->id_det_venta->CurrentValue) ?>">
<?php echo $ap_detalle_venta->id_det_venta->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_detalle_venta->venta_det_venta->Visible) { // venta_det_venta ?>
	<div id="r_venta_det_venta" class="form-group">
		<label id="elh_ap_detalle_venta_venta_det_venta" for="x_venta_det_venta" class="col-sm-2 control-label ewLabel"><?php echo $ap_detalle_venta->venta_det_venta->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_detalle_venta->venta_det_venta->CellAttributes() ?>>
<span id="el_ap_detalle_venta_venta_det_venta">
<input type="text" data-table="ap_detalle_venta" data-field="x_venta_det_venta" name="x_venta_det_venta" id="x_venta_det_venta" size="30" placeholder="<?php echo ew_HtmlEncode($ap_detalle_venta->venta_det_venta->getPlaceHolder()) ?>" value="<?php echo $ap_detalle_venta->venta_det_venta->EditValue ?>"<?php echo $ap_detalle_venta->venta_det_venta->EditAttributes() ?>>
</span>
<?php echo $ap_detalle_venta->venta_det_venta->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_detalle_venta->codigo_det_venta->Visible) { // codigo_det_venta ?>
	<div id="r_codigo_det_venta" class="form-group">
		<label id="elh_ap_detalle_venta_codigo_det_venta" for="x_codigo_det_venta" class="col-sm-2 control-label ewLabel"><?php echo $ap_detalle_venta->codigo_det_venta->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_detalle_venta->codigo_det_venta->CellAttributes() ?>>
<span id="el_ap_detalle_venta_codigo_det_venta">
<input type="text" data-table="ap_detalle_venta" data-field="x_codigo_det_venta" name="x_codigo_det_venta" id="x_codigo_det_venta" size="30" placeholder="<?php echo ew_HtmlEncode($ap_detalle_venta->codigo_det_venta->getPlaceHolder()) ?>" value="<?php echo $ap_detalle_venta->codigo_det_venta->EditValue ?>"<?php echo $ap_detalle_venta->codigo_det_venta->EditAttributes() ?>>
</span>
<?php echo $ap_detalle_venta->codigo_det_venta->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_detalle_venta->descripcion_det_venta->Visible) { // descripcion_det_venta ?>
	<div id="r_descripcion_det_venta" class="form-group">
		<label id="elh_ap_detalle_venta_descripcion_det_venta" for="x_descripcion_det_venta" class="col-sm-2 control-label ewLabel"><?php echo $ap_detalle_venta->descripcion_det_venta->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_detalle_venta->descripcion_det_venta->CellAttributes() ?>>
<span id="el_ap_detalle_venta_descripcion_det_venta">
<input type="text" data-table="ap_detalle_venta" data-field="x_descripcion_det_venta" name="x_descripcion_det_venta" id="x_descripcion_det_venta" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($ap_detalle_venta->descripcion_det_venta->getPlaceHolder()) ?>" value="<?php echo $ap_detalle_venta->descripcion_det_venta->EditValue ?>"<?php echo $ap_detalle_venta->descripcion_det_venta->EditAttributes() ?>>
</span>
<?php echo $ap_detalle_venta->descripcion_det_venta->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_detalle_venta->precio_det_venta->Visible) { // precio_det_venta ?>
	<div id="r_precio_det_venta" class="form-group">
		<label id="elh_ap_detalle_venta_precio_det_venta" for="x_precio_det_venta" class="col-sm-2 control-label ewLabel"><?php echo $ap_detalle_venta->precio_det_venta->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_detalle_venta->precio_det_venta->CellAttributes() ?>>
<span id="el_ap_detalle_venta_precio_det_venta">
<input type="text" data-table="ap_detalle_venta" data-field="x_precio_det_venta" name="x_precio_det_venta" id="x_precio_det_venta" size="30" placeholder="<?php echo ew_HtmlEncode($ap_detalle_venta->precio_det_venta->getPlaceHolder()) ?>" value="<?php echo $ap_detalle_venta->precio_det_venta->EditValue ?>"<?php echo $ap_detalle_venta->precio_det_venta->EditAttributes() ?>>
</span>
<?php echo $ap_detalle_venta->precio_det_venta->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_detalle_venta->cantidad_det_venta->Visible) { // cantidad_det_venta ?>
	<div id="r_cantidad_det_venta" class="form-group">
		<label id="elh_ap_detalle_venta_cantidad_det_venta" for="x_cantidad_det_venta" class="col-sm-2 control-label ewLabel"><?php echo $ap_detalle_venta->cantidad_det_venta->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_detalle_venta->cantidad_det_venta->CellAttributes() ?>>
<span id="el_ap_detalle_venta_cantidad_det_venta">
<input type="text" data-table="ap_detalle_venta" data-field="x_cantidad_det_venta" name="x_cantidad_det_venta" id="x_cantidad_det_venta" size="30" placeholder="<?php echo ew_HtmlEncode($ap_detalle_venta->cantidad_det_venta->getPlaceHolder()) ?>" value="<?php echo $ap_detalle_venta->cantidad_det_venta->EditValue ?>"<?php echo $ap_detalle_venta->cantidad_det_venta->EditAttributes() ?>>
</span>
<?php echo $ap_detalle_venta->cantidad_det_venta->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_detalle_venta->total_det_venta->Visible) { // total_det_venta ?>
	<div id="r_total_det_venta" class="form-group">
		<label id="elh_ap_detalle_venta_total_det_venta" for="x_total_det_venta" class="col-sm-2 control-label ewLabel"><?php echo $ap_detalle_venta->total_det_venta->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_detalle_venta->total_det_venta->CellAttributes() ?>>
<span id="el_ap_detalle_venta_total_det_venta">
<input type="text" data-table="ap_detalle_venta" data-field="x_total_det_venta" name="x_total_det_venta" id="x_total_det_venta" size="30" placeholder="<?php echo ew_HtmlEncode($ap_detalle_venta->total_det_venta->getPlaceHolder()) ?>" value="<?php echo $ap_detalle_venta->total_det_venta->EditValue ?>"<?php echo $ap_detalle_venta->total_det_venta->EditAttributes() ?>>
</span>
<?php echo $ap_detalle_venta->total_det_venta->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_detalle_venta->tipo_det_venta->Visible) { // tipo_det_venta ?>
	<div id="r_tipo_det_venta" class="form-group">
		<label id="elh_ap_detalle_venta_tipo_det_venta" for="x_tipo_det_venta" class="col-sm-2 control-label ewLabel"><?php echo $ap_detalle_venta->tipo_det_venta->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_detalle_venta->tipo_det_venta->CellAttributes() ?>>
<span id="el_ap_detalle_venta_tipo_det_venta">
<input type="text" data-table="ap_detalle_venta" data-field="x_tipo_det_venta" name="x_tipo_det_venta" id="x_tipo_det_venta" size="30" placeholder="<?php echo ew_HtmlEncode($ap_detalle_venta->tipo_det_venta->getPlaceHolder()) ?>" value="<?php echo $ap_detalle_venta->tipo_det_venta->EditValue ?>"<?php echo $ap_detalle_venta->tipo_det_venta->EditAttributes() ?>>
</span>
<?php echo $ap_detalle_venta->tipo_det_venta->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_detalle_venta->empresa_det_venta->Visible) { // empresa_det_venta ?>
	<div id="r_empresa_det_venta" class="form-group">
		<label id="elh_ap_detalle_venta_empresa_det_venta" for="x_empresa_det_venta" class="col-sm-2 control-label ewLabel"><?php echo $ap_detalle_venta->empresa_det_venta->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_detalle_venta->empresa_det_venta->CellAttributes() ?>>
<span id="el_ap_detalle_venta_empresa_det_venta">
<input type="text" data-table="ap_detalle_venta" data-field="x_empresa_det_venta" name="x_empresa_det_venta" id="x_empresa_det_venta" size="30" placeholder="<?php echo ew_HtmlEncode($ap_detalle_venta->empresa_det_venta->getPlaceHolder()) ?>" value="<?php echo $ap_detalle_venta->empresa_det_venta->EditValue ?>"<?php echo $ap_detalle_venta->empresa_det_venta->EditAttributes() ?>>
</span>
<?php echo $ap_detalle_venta->empresa_det_venta->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$ap_detalle_venta_edit->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $ap_detalle_venta_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fap_detalle_ventaedit.Init();
</script>
<?php
$ap_detalle_venta_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$ap_detalle_venta_edit->Page_Terminate();
?>
