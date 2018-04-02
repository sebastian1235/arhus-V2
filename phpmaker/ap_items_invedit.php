<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "ap_items_invinfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$ap_items_inv_edit = NULL; // Initialize page object first

class cap_items_inv_edit extends cap_items_inv {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{6A9AC718-A824-45A3-BED3-A95E91E6986D}";

	// Table name
	var $TableName = 'ap_items_inv';

	// Page object name
	var $PageObjName = 'ap_items_inv_edit';

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

		// Table object (ap_items_inv)
		if (!isset($GLOBALS["ap_items_inv"]) || get_class($GLOBALS["ap_items_inv"]) == "cap_items_inv") {
			$GLOBALS["ap_items_inv"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["ap_items_inv"];
		}

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'ap_items_inv', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("ap_items_invlist.php"));
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
		$this->Id_Item->SetVisibility();
		$this->Id_Item->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->codigo_item->SetVisibility();
		$this->nombre_item->SetVisibility();
		$this->und_item->SetVisibility();
		$this->precio_item->SetVisibility();
		$this->costo_item->SetVisibility();
		$this->tipo_item->SetVisibility();
		$this->marca_item->SetVisibility();
		$this->cod_marca_item->SetVisibility();
		$this->detalle_item->SetVisibility();
		$this->saldo_item->SetVisibility();
		$this->activo_item->SetVisibility();
		$this->maneja_serial_item->SetVisibility();
		$this->asignado_item->SetVisibility();
		$this->si_no_item->SetVisibility();
		$this->precio_old_item->SetVisibility();
		$this->costo_old_item->SetVisibility();
		$this->registra_item->SetVisibility();
		$this->fecha_registro_item->SetVisibility();
		$this->empresa_item->SetVisibility();

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
		global $EW_EXPORT, $ap_items_inv;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($ap_items_inv);
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
		if (@$_GET["Id_Item"] <> "") {
			$this->Id_Item->setQueryStringValue($_GET["Id_Item"]);
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
		if ($this->Id_Item->CurrentValue == "") {
			$this->Page_Terminate("ap_items_invlist.php"); // Invalid key, return to list
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
					$this->Page_Terminate("ap_items_invlist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "ap_items_invlist.php")
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
		if (!$this->Id_Item->FldIsDetailKey)
			$this->Id_Item->setFormValue($objForm->GetValue("x_Id_Item"));
		if (!$this->codigo_item->FldIsDetailKey) {
			$this->codigo_item->setFormValue($objForm->GetValue("x_codigo_item"));
		}
		if (!$this->nombre_item->FldIsDetailKey) {
			$this->nombre_item->setFormValue($objForm->GetValue("x_nombre_item"));
		}
		if (!$this->und_item->FldIsDetailKey) {
			$this->und_item->setFormValue($objForm->GetValue("x_und_item"));
		}
		if (!$this->precio_item->FldIsDetailKey) {
			$this->precio_item->setFormValue($objForm->GetValue("x_precio_item"));
		}
		if (!$this->costo_item->FldIsDetailKey) {
			$this->costo_item->setFormValue($objForm->GetValue("x_costo_item"));
		}
		if (!$this->tipo_item->FldIsDetailKey) {
			$this->tipo_item->setFormValue($objForm->GetValue("x_tipo_item"));
		}
		if (!$this->marca_item->FldIsDetailKey) {
			$this->marca_item->setFormValue($objForm->GetValue("x_marca_item"));
		}
		if (!$this->cod_marca_item->FldIsDetailKey) {
			$this->cod_marca_item->setFormValue($objForm->GetValue("x_cod_marca_item"));
		}
		if (!$this->detalle_item->FldIsDetailKey) {
			$this->detalle_item->setFormValue($objForm->GetValue("x_detalle_item"));
		}
		if (!$this->saldo_item->FldIsDetailKey) {
			$this->saldo_item->setFormValue($objForm->GetValue("x_saldo_item"));
		}
		if (!$this->activo_item->FldIsDetailKey) {
			$this->activo_item->setFormValue($objForm->GetValue("x_activo_item"));
		}
		if (!$this->maneja_serial_item->FldIsDetailKey) {
			$this->maneja_serial_item->setFormValue($objForm->GetValue("x_maneja_serial_item"));
		}
		if (!$this->asignado_item->FldIsDetailKey) {
			$this->asignado_item->setFormValue($objForm->GetValue("x_asignado_item"));
		}
		if (!$this->si_no_item->FldIsDetailKey) {
			$this->si_no_item->setFormValue($objForm->GetValue("x_si_no_item"));
		}
		if (!$this->precio_old_item->FldIsDetailKey) {
			$this->precio_old_item->setFormValue($objForm->GetValue("x_precio_old_item"));
		}
		if (!$this->costo_old_item->FldIsDetailKey) {
			$this->costo_old_item->setFormValue($objForm->GetValue("x_costo_old_item"));
		}
		if (!$this->registra_item->FldIsDetailKey) {
			$this->registra_item->setFormValue($objForm->GetValue("x_registra_item"));
		}
		if (!$this->fecha_registro_item->FldIsDetailKey) {
			$this->fecha_registro_item->setFormValue($objForm->GetValue("x_fecha_registro_item"));
			$this->fecha_registro_item->CurrentValue = ew_UnFormatDateTime($this->fecha_registro_item->CurrentValue, 0);
		}
		if (!$this->empresa_item->FldIsDetailKey) {
			$this->empresa_item->setFormValue($objForm->GetValue("x_empresa_item"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->Id_Item->CurrentValue = $this->Id_Item->FormValue;
		$this->codigo_item->CurrentValue = $this->codigo_item->FormValue;
		$this->nombre_item->CurrentValue = $this->nombre_item->FormValue;
		$this->und_item->CurrentValue = $this->und_item->FormValue;
		$this->precio_item->CurrentValue = $this->precio_item->FormValue;
		$this->costo_item->CurrentValue = $this->costo_item->FormValue;
		$this->tipo_item->CurrentValue = $this->tipo_item->FormValue;
		$this->marca_item->CurrentValue = $this->marca_item->FormValue;
		$this->cod_marca_item->CurrentValue = $this->cod_marca_item->FormValue;
		$this->detalle_item->CurrentValue = $this->detalle_item->FormValue;
		$this->saldo_item->CurrentValue = $this->saldo_item->FormValue;
		$this->activo_item->CurrentValue = $this->activo_item->FormValue;
		$this->maneja_serial_item->CurrentValue = $this->maneja_serial_item->FormValue;
		$this->asignado_item->CurrentValue = $this->asignado_item->FormValue;
		$this->si_no_item->CurrentValue = $this->si_no_item->FormValue;
		$this->precio_old_item->CurrentValue = $this->precio_old_item->FormValue;
		$this->costo_old_item->CurrentValue = $this->costo_old_item->FormValue;
		$this->registra_item->CurrentValue = $this->registra_item->FormValue;
		$this->fecha_registro_item->CurrentValue = $this->fecha_registro_item->FormValue;
		$this->fecha_registro_item->CurrentValue = ew_UnFormatDateTime($this->fecha_registro_item->CurrentValue, 0);
		$this->empresa_item->CurrentValue = $this->empresa_item->FormValue;
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

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->Id_Item->DbValue = $row['Id_Item'];
		$this->codigo_item->DbValue = $row['codigo_item'];
		$this->nombre_item->DbValue = $row['nombre_item'];
		$this->und_item->DbValue = $row['und_item'];
		$this->precio_item->DbValue = $row['precio_item'];
		$this->costo_item->DbValue = $row['costo_item'];
		$this->tipo_item->DbValue = $row['tipo_item'];
		$this->marca_item->DbValue = $row['marca_item'];
		$this->cod_marca_item->DbValue = $row['cod_marca_item'];
		$this->detalle_item->DbValue = $row['detalle_item'];
		$this->saldo_item->DbValue = $row['saldo_item'];
		$this->activo_item->DbValue = $row['activo_item'];
		$this->maneja_serial_item->DbValue = $row['maneja_serial_item'];
		$this->asignado_item->DbValue = $row['asignado_item'];
		$this->si_no_item->DbValue = $row['si_no_item'];
		$this->precio_old_item->DbValue = $row['precio_old_item'];
		$this->costo_old_item->DbValue = $row['costo_old_item'];
		$this->registra_item->DbValue = $row['registra_item'];
		$this->fecha_registro_item->DbValue = $row['fecha_registro_item'];
		$this->empresa_item->DbValue = $row['empresa_item'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Convert decimal values if posted back

		if ($this->precio_item->FormValue == $this->precio_item->CurrentValue && is_numeric(ew_StrToFloat($this->precio_item->CurrentValue)))
			$this->precio_item->CurrentValue = ew_StrToFloat($this->precio_item->CurrentValue);

		// Convert decimal values if posted back
		if ($this->costo_item->FormValue == $this->costo_item->CurrentValue && is_numeric(ew_StrToFloat($this->costo_item->CurrentValue)))
			$this->costo_item->CurrentValue = ew_StrToFloat($this->costo_item->CurrentValue);

		// Convert decimal values if posted back
		if ($this->saldo_item->FormValue == $this->saldo_item->CurrentValue && is_numeric(ew_StrToFloat($this->saldo_item->CurrentValue)))
			$this->saldo_item->CurrentValue = ew_StrToFloat($this->saldo_item->CurrentValue);

		// Convert decimal values if posted back
		if ($this->precio_old_item->FormValue == $this->precio_old_item->CurrentValue && is_numeric(ew_StrToFloat($this->precio_old_item->CurrentValue)))
			$this->precio_old_item->CurrentValue = ew_StrToFloat($this->precio_old_item->CurrentValue);

		// Convert decimal values if posted back
		if ($this->costo_old_item->FormValue == $this->costo_old_item->CurrentValue && is_numeric(ew_StrToFloat($this->costo_old_item->CurrentValue)))
			$this->costo_old_item->CurrentValue = ew_StrToFloat($this->costo_old_item->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
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

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

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
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// Id_Item
			$this->Id_Item->EditAttrs["class"] = "form-control";
			$this->Id_Item->EditCustomAttributes = "";
			$this->Id_Item->EditValue = $this->Id_Item->CurrentValue;
			$this->Id_Item->ViewCustomAttributes = "";

			// codigo_item
			$this->codigo_item->EditAttrs["class"] = "form-control";
			$this->codigo_item->EditCustomAttributes = "";
			$this->codigo_item->EditValue = ew_HtmlEncode($this->codigo_item->CurrentValue);
			$this->codigo_item->PlaceHolder = ew_RemoveHtml($this->codigo_item->FldCaption());

			// nombre_item
			$this->nombre_item->EditAttrs["class"] = "form-control";
			$this->nombre_item->EditCustomAttributes = "";
			$this->nombre_item->EditValue = ew_HtmlEncode($this->nombre_item->CurrentValue);
			$this->nombre_item->PlaceHolder = ew_RemoveHtml($this->nombre_item->FldCaption());

			// und_item
			$this->und_item->EditAttrs["class"] = "form-control";
			$this->und_item->EditCustomAttributes = "";
			$this->und_item->EditValue = ew_HtmlEncode($this->und_item->CurrentValue);
			$this->und_item->PlaceHolder = ew_RemoveHtml($this->und_item->FldCaption());

			// precio_item
			$this->precio_item->EditAttrs["class"] = "form-control";
			$this->precio_item->EditCustomAttributes = "";
			$this->precio_item->EditValue = ew_HtmlEncode($this->precio_item->CurrentValue);
			$this->precio_item->PlaceHolder = ew_RemoveHtml($this->precio_item->FldCaption());
			if (strval($this->precio_item->EditValue) <> "" && is_numeric($this->precio_item->EditValue)) $this->precio_item->EditValue = ew_FormatNumber($this->precio_item->EditValue, -2, -1, -2, 0);

			// costo_item
			$this->costo_item->EditAttrs["class"] = "form-control";
			$this->costo_item->EditCustomAttributes = "";
			$this->costo_item->EditValue = ew_HtmlEncode($this->costo_item->CurrentValue);
			$this->costo_item->PlaceHolder = ew_RemoveHtml($this->costo_item->FldCaption());
			if (strval($this->costo_item->EditValue) <> "" && is_numeric($this->costo_item->EditValue)) $this->costo_item->EditValue = ew_FormatNumber($this->costo_item->EditValue, -2, -1, -2, 0);

			// tipo_item
			$this->tipo_item->EditAttrs["class"] = "form-control";
			$this->tipo_item->EditCustomAttributes = "";
			$this->tipo_item->EditValue = ew_HtmlEncode($this->tipo_item->CurrentValue);
			$this->tipo_item->PlaceHolder = ew_RemoveHtml($this->tipo_item->FldCaption());

			// marca_item
			$this->marca_item->EditAttrs["class"] = "form-control";
			$this->marca_item->EditCustomAttributes = "";
			$this->marca_item->EditValue = ew_HtmlEncode($this->marca_item->CurrentValue);
			$this->marca_item->PlaceHolder = ew_RemoveHtml($this->marca_item->FldCaption());

			// cod_marca_item
			$this->cod_marca_item->EditAttrs["class"] = "form-control";
			$this->cod_marca_item->EditCustomAttributes = "";
			$this->cod_marca_item->EditValue = ew_HtmlEncode($this->cod_marca_item->CurrentValue);
			$this->cod_marca_item->PlaceHolder = ew_RemoveHtml($this->cod_marca_item->FldCaption());

			// detalle_item
			$this->detalle_item->EditAttrs["class"] = "form-control";
			$this->detalle_item->EditCustomAttributes = "";
			$this->detalle_item->EditValue = ew_HtmlEncode($this->detalle_item->CurrentValue);
			$this->detalle_item->PlaceHolder = ew_RemoveHtml($this->detalle_item->FldCaption());

			// saldo_item
			$this->saldo_item->EditAttrs["class"] = "form-control";
			$this->saldo_item->EditCustomAttributes = "";
			$this->saldo_item->EditValue = ew_HtmlEncode($this->saldo_item->CurrentValue);
			$this->saldo_item->PlaceHolder = ew_RemoveHtml($this->saldo_item->FldCaption());
			if (strval($this->saldo_item->EditValue) <> "" && is_numeric($this->saldo_item->EditValue)) $this->saldo_item->EditValue = ew_FormatNumber($this->saldo_item->EditValue, -2, -1, -2, 0);

			// activo_item
			$this->activo_item->EditAttrs["class"] = "form-control";
			$this->activo_item->EditCustomAttributes = "";
			$this->activo_item->EditValue = ew_HtmlEncode($this->activo_item->CurrentValue);
			$this->activo_item->PlaceHolder = ew_RemoveHtml($this->activo_item->FldCaption());

			// maneja_serial_item
			$this->maneja_serial_item->EditAttrs["class"] = "form-control";
			$this->maneja_serial_item->EditCustomAttributes = "";
			$this->maneja_serial_item->EditValue = ew_HtmlEncode($this->maneja_serial_item->CurrentValue);
			$this->maneja_serial_item->PlaceHolder = ew_RemoveHtml($this->maneja_serial_item->FldCaption());

			// asignado_item
			$this->asignado_item->EditAttrs["class"] = "form-control";
			$this->asignado_item->EditCustomAttributes = "";
			$this->asignado_item->EditValue = ew_HtmlEncode($this->asignado_item->CurrentValue);
			$this->asignado_item->PlaceHolder = ew_RemoveHtml($this->asignado_item->FldCaption());

			// si_no_item
			$this->si_no_item->EditAttrs["class"] = "form-control";
			$this->si_no_item->EditCustomAttributes = "";
			$this->si_no_item->EditValue = ew_HtmlEncode($this->si_no_item->CurrentValue);
			$this->si_no_item->PlaceHolder = ew_RemoveHtml($this->si_no_item->FldCaption());

			// precio_old_item
			$this->precio_old_item->EditAttrs["class"] = "form-control";
			$this->precio_old_item->EditCustomAttributes = "";
			$this->precio_old_item->EditValue = ew_HtmlEncode($this->precio_old_item->CurrentValue);
			$this->precio_old_item->PlaceHolder = ew_RemoveHtml($this->precio_old_item->FldCaption());
			if (strval($this->precio_old_item->EditValue) <> "" && is_numeric($this->precio_old_item->EditValue)) $this->precio_old_item->EditValue = ew_FormatNumber($this->precio_old_item->EditValue, -2, -1, -2, 0);

			// costo_old_item
			$this->costo_old_item->EditAttrs["class"] = "form-control";
			$this->costo_old_item->EditCustomAttributes = "";
			$this->costo_old_item->EditValue = ew_HtmlEncode($this->costo_old_item->CurrentValue);
			$this->costo_old_item->PlaceHolder = ew_RemoveHtml($this->costo_old_item->FldCaption());
			if (strval($this->costo_old_item->EditValue) <> "" && is_numeric($this->costo_old_item->EditValue)) $this->costo_old_item->EditValue = ew_FormatNumber($this->costo_old_item->EditValue, -2, -1, -2, 0);

			// registra_item
			$this->registra_item->EditAttrs["class"] = "form-control";
			$this->registra_item->EditCustomAttributes = "";
			$this->registra_item->EditValue = ew_HtmlEncode($this->registra_item->CurrentValue);
			$this->registra_item->PlaceHolder = ew_RemoveHtml($this->registra_item->FldCaption());

			// fecha_registro_item
			$this->fecha_registro_item->EditAttrs["class"] = "form-control";
			$this->fecha_registro_item->EditCustomAttributes = "";
			$this->fecha_registro_item->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->fecha_registro_item->CurrentValue, 8));
			$this->fecha_registro_item->PlaceHolder = ew_RemoveHtml($this->fecha_registro_item->FldCaption());

			// empresa_item
			$this->empresa_item->EditAttrs["class"] = "form-control";
			$this->empresa_item->EditCustomAttributes = "";
			$this->empresa_item->EditValue = ew_HtmlEncode($this->empresa_item->CurrentValue);
			$this->empresa_item->PlaceHolder = ew_RemoveHtml($this->empresa_item->FldCaption());

			// Edit refer script
			// Id_Item

			$this->Id_Item->LinkCustomAttributes = "";
			$this->Id_Item->HrefValue = "";

			// codigo_item
			$this->codigo_item->LinkCustomAttributes = "";
			$this->codigo_item->HrefValue = "";

			// nombre_item
			$this->nombre_item->LinkCustomAttributes = "";
			$this->nombre_item->HrefValue = "";

			// und_item
			$this->und_item->LinkCustomAttributes = "";
			$this->und_item->HrefValue = "";

			// precio_item
			$this->precio_item->LinkCustomAttributes = "";
			$this->precio_item->HrefValue = "";

			// costo_item
			$this->costo_item->LinkCustomAttributes = "";
			$this->costo_item->HrefValue = "";

			// tipo_item
			$this->tipo_item->LinkCustomAttributes = "";
			$this->tipo_item->HrefValue = "";

			// marca_item
			$this->marca_item->LinkCustomAttributes = "";
			$this->marca_item->HrefValue = "";

			// cod_marca_item
			$this->cod_marca_item->LinkCustomAttributes = "";
			$this->cod_marca_item->HrefValue = "";

			// detalle_item
			$this->detalle_item->LinkCustomAttributes = "";
			$this->detalle_item->HrefValue = "";

			// saldo_item
			$this->saldo_item->LinkCustomAttributes = "";
			$this->saldo_item->HrefValue = "";

			// activo_item
			$this->activo_item->LinkCustomAttributes = "";
			$this->activo_item->HrefValue = "";

			// maneja_serial_item
			$this->maneja_serial_item->LinkCustomAttributes = "";
			$this->maneja_serial_item->HrefValue = "";

			// asignado_item
			$this->asignado_item->LinkCustomAttributes = "";
			$this->asignado_item->HrefValue = "";

			// si_no_item
			$this->si_no_item->LinkCustomAttributes = "";
			$this->si_no_item->HrefValue = "";

			// precio_old_item
			$this->precio_old_item->LinkCustomAttributes = "";
			$this->precio_old_item->HrefValue = "";

			// costo_old_item
			$this->costo_old_item->LinkCustomAttributes = "";
			$this->costo_old_item->HrefValue = "";

			// registra_item
			$this->registra_item->LinkCustomAttributes = "";
			$this->registra_item->HrefValue = "";

			// fecha_registro_item
			$this->fecha_registro_item->LinkCustomAttributes = "";
			$this->fecha_registro_item->HrefValue = "";

			// empresa_item
			$this->empresa_item->LinkCustomAttributes = "";
			$this->empresa_item->HrefValue = "";
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
		if (!ew_CheckInteger($this->und_item->FormValue)) {
			ew_AddMessage($gsFormError, $this->und_item->FldErrMsg());
		}
		if (!ew_CheckNumber($this->precio_item->FormValue)) {
			ew_AddMessage($gsFormError, $this->precio_item->FldErrMsg());
		}
		if (!ew_CheckNumber($this->costo_item->FormValue)) {
			ew_AddMessage($gsFormError, $this->costo_item->FldErrMsg());
		}
		if (!ew_CheckInteger($this->tipo_item->FormValue)) {
			ew_AddMessage($gsFormError, $this->tipo_item->FldErrMsg());
		}
		if (!ew_CheckNumber($this->saldo_item->FormValue)) {
			ew_AddMessage($gsFormError, $this->saldo_item->FldErrMsg());
		}
		if (!ew_CheckInteger($this->activo_item->FormValue)) {
			ew_AddMessage($gsFormError, $this->activo_item->FldErrMsg());
		}
		if (!ew_CheckInteger($this->maneja_serial_item->FormValue)) {
			ew_AddMessage($gsFormError, $this->maneja_serial_item->FldErrMsg());
		}
		if (!ew_CheckInteger($this->asignado_item->FormValue)) {
			ew_AddMessage($gsFormError, $this->asignado_item->FldErrMsg());
		}
		if (!ew_CheckInteger($this->si_no_item->FormValue)) {
			ew_AddMessage($gsFormError, $this->si_no_item->FldErrMsg());
		}
		if (!ew_CheckNumber($this->precio_old_item->FormValue)) {
			ew_AddMessage($gsFormError, $this->precio_old_item->FldErrMsg());
		}
		if (!ew_CheckNumber($this->costo_old_item->FormValue)) {
			ew_AddMessage($gsFormError, $this->costo_old_item->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->fecha_registro_item->FormValue)) {
			ew_AddMessage($gsFormError, $this->fecha_registro_item->FldErrMsg());
		}
		if (!ew_CheckInteger($this->empresa_item->FormValue)) {
			ew_AddMessage($gsFormError, $this->empresa_item->FldErrMsg());
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
		if ($this->codigo_item->CurrentValue <> "") { // Check field with unique index
			$sFilterChk = "(`codigo_item` = '" . ew_AdjustSql($this->codigo_item->CurrentValue, $this->DBID) . "')";
			$sFilterChk .= " AND NOT (" . $sFilter . ")";
			$this->CurrentFilter = $sFilterChk;
			$sSqlChk = $this->SQL();
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$rsChk = $conn->Execute($sSqlChk);
			$conn->raiseErrorFn = '';
			if ($rsChk === FALSE) {
				return FALSE;
			} elseif (!$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", $this->codigo_item->FldCaption(), $Language->Phrase("DupIndex"));
				$sIdxErrMsg = str_replace("%v", $this->codigo_item->CurrentValue, $sIdxErrMsg);
				$this->setFailureMessage($sIdxErrMsg);
				$rsChk->Close();
				return FALSE;
			}
			$rsChk->Close();
		}
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

			// codigo_item
			$this->codigo_item->SetDbValueDef($rsnew, $this->codigo_item->CurrentValue, NULL, $this->codigo_item->ReadOnly);

			// nombre_item
			$this->nombre_item->SetDbValueDef($rsnew, $this->nombre_item->CurrentValue, NULL, $this->nombre_item->ReadOnly);

			// und_item
			$this->und_item->SetDbValueDef($rsnew, $this->und_item->CurrentValue, NULL, $this->und_item->ReadOnly);

			// precio_item
			$this->precio_item->SetDbValueDef($rsnew, $this->precio_item->CurrentValue, NULL, $this->precio_item->ReadOnly);

			// costo_item
			$this->costo_item->SetDbValueDef($rsnew, $this->costo_item->CurrentValue, NULL, $this->costo_item->ReadOnly);

			// tipo_item
			$this->tipo_item->SetDbValueDef($rsnew, $this->tipo_item->CurrentValue, NULL, $this->tipo_item->ReadOnly);

			// marca_item
			$this->marca_item->SetDbValueDef($rsnew, $this->marca_item->CurrentValue, NULL, $this->marca_item->ReadOnly);

			// cod_marca_item
			$this->cod_marca_item->SetDbValueDef($rsnew, $this->cod_marca_item->CurrentValue, NULL, $this->cod_marca_item->ReadOnly);

			// detalle_item
			$this->detalle_item->SetDbValueDef($rsnew, $this->detalle_item->CurrentValue, NULL, $this->detalle_item->ReadOnly);

			// saldo_item
			$this->saldo_item->SetDbValueDef($rsnew, $this->saldo_item->CurrentValue, NULL, $this->saldo_item->ReadOnly);

			// activo_item
			$this->activo_item->SetDbValueDef($rsnew, $this->activo_item->CurrentValue, NULL, $this->activo_item->ReadOnly);

			// maneja_serial_item
			$this->maneja_serial_item->SetDbValueDef($rsnew, $this->maneja_serial_item->CurrentValue, NULL, $this->maneja_serial_item->ReadOnly);

			// asignado_item
			$this->asignado_item->SetDbValueDef($rsnew, $this->asignado_item->CurrentValue, NULL, $this->asignado_item->ReadOnly);

			// si_no_item
			$this->si_no_item->SetDbValueDef($rsnew, $this->si_no_item->CurrentValue, NULL, $this->si_no_item->ReadOnly);

			// precio_old_item
			$this->precio_old_item->SetDbValueDef($rsnew, $this->precio_old_item->CurrentValue, NULL, $this->precio_old_item->ReadOnly);

			// costo_old_item
			$this->costo_old_item->SetDbValueDef($rsnew, $this->costo_old_item->CurrentValue, NULL, $this->costo_old_item->ReadOnly);

			// registra_item
			$this->registra_item->SetDbValueDef($rsnew, $this->registra_item->CurrentValue, NULL, $this->registra_item->ReadOnly);

			// fecha_registro_item
			$this->fecha_registro_item->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->fecha_registro_item->CurrentValue, 0), NULL, $this->fecha_registro_item->ReadOnly);

			// empresa_item
			$this->empresa_item->SetDbValueDef($rsnew, $this->empresa_item->CurrentValue, NULL, $this->empresa_item->ReadOnly);

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("ap_items_invlist.php"), "", $this->TableVar, TRUE);
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
if (!isset($ap_items_inv_edit)) $ap_items_inv_edit = new cap_items_inv_edit();

// Page init
$ap_items_inv_edit->Page_Init();

// Page main
$ap_items_inv_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$ap_items_inv_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fap_items_invedit = new ew_Form("fap_items_invedit", "edit");

// Validate form
fap_items_invedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_und_item");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ap_items_inv->und_item->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_precio_item");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ap_items_inv->precio_item->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_costo_item");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ap_items_inv->costo_item->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_tipo_item");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ap_items_inv->tipo_item->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_saldo_item");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ap_items_inv->saldo_item->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_activo_item");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ap_items_inv->activo_item->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_maneja_serial_item");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ap_items_inv->maneja_serial_item->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_asignado_item");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ap_items_inv->asignado_item->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_si_no_item");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ap_items_inv->si_no_item->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_precio_old_item");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ap_items_inv->precio_old_item->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_costo_old_item");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ap_items_inv->costo_old_item->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_fecha_registro_item");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ap_items_inv->fecha_registro_item->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_empresa_item");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ap_items_inv->empresa_item->FldErrMsg()) ?>");

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
fap_items_invedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fap_items_invedit.ValidateRequired = true;
<?php } else { ?>
fap_items_invedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$ap_items_inv_edit->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $ap_items_inv_edit->ShowPageHeader(); ?>
<?php
$ap_items_inv_edit->ShowMessage();
?>
<form name="fap_items_invedit" id="fap_items_invedit" class="<?php echo $ap_items_inv_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($ap_items_inv_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $ap_items_inv_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="ap_items_inv">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<?php if ($ap_items_inv_edit->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($ap_items_inv->Id_Item->Visible) { // Id_Item ?>
	<div id="r_Id_Item" class="form-group">
		<label id="elh_ap_items_inv_Id_Item" class="col-sm-2 control-label ewLabel"><?php echo $ap_items_inv->Id_Item->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_items_inv->Id_Item->CellAttributes() ?>>
<span id="el_ap_items_inv_Id_Item">
<span<?php echo $ap_items_inv->Id_Item->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $ap_items_inv->Id_Item->EditValue ?></p></span>
</span>
<input type="hidden" data-table="ap_items_inv" data-field="x_Id_Item" name="x_Id_Item" id="x_Id_Item" value="<?php echo ew_HtmlEncode($ap_items_inv->Id_Item->CurrentValue) ?>">
<?php echo $ap_items_inv->Id_Item->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_items_inv->codigo_item->Visible) { // codigo_item ?>
	<div id="r_codigo_item" class="form-group">
		<label id="elh_ap_items_inv_codigo_item" for="x_codigo_item" class="col-sm-2 control-label ewLabel"><?php echo $ap_items_inv->codigo_item->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_items_inv->codigo_item->CellAttributes() ?>>
<span id="el_ap_items_inv_codigo_item">
<input type="text" data-table="ap_items_inv" data-field="x_codigo_item" name="x_codigo_item" id="x_codigo_item" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($ap_items_inv->codigo_item->getPlaceHolder()) ?>" value="<?php echo $ap_items_inv->codigo_item->EditValue ?>"<?php echo $ap_items_inv->codigo_item->EditAttributes() ?>>
</span>
<?php echo $ap_items_inv->codigo_item->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_items_inv->nombre_item->Visible) { // nombre_item ?>
	<div id="r_nombre_item" class="form-group">
		<label id="elh_ap_items_inv_nombre_item" for="x_nombre_item" class="col-sm-2 control-label ewLabel"><?php echo $ap_items_inv->nombre_item->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_items_inv->nombre_item->CellAttributes() ?>>
<span id="el_ap_items_inv_nombre_item">
<input type="text" data-table="ap_items_inv" data-field="x_nombre_item" name="x_nombre_item" id="x_nombre_item" size="30" maxlength="150" placeholder="<?php echo ew_HtmlEncode($ap_items_inv->nombre_item->getPlaceHolder()) ?>" value="<?php echo $ap_items_inv->nombre_item->EditValue ?>"<?php echo $ap_items_inv->nombre_item->EditAttributes() ?>>
</span>
<?php echo $ap_items_inv->nombre_item->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_items_inv->und_item->Visible) { // und_item ?>
	<div id="r_und_item" class="form-group">
		<label id="elh_ap_items_inv_und_item" for="x_und_item" class="col-sm-2 control-label ewLabel"><?php echo $ap_items_inv->und_item->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_items_inv->und_item->CellAttributes() ?>>
<span id="el_ap_items_inv_und_item">
<input type="text" data-table="ap_items_inv" data-field="x_und_item" name="x_und_item" id="x_und_item" size="30" placeholder="<?php echo ew_HtmlEncode($ap_items_inv->und_item->getPlaceHolder()) ?>" value="<?php echo $ap_items_inv->und_item->EditValue ?>"<?php echo $ap_items_inv->und_item->EditAttributes() ?>>
</span>
<?php echo $ap_items_inv->und_item->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_items_inv->precio_item->Visible) { // precio_item ?>
	<div id="r_precio_item" class="form-group">
		<label id="elh_ap_items_inv_precio_item" for="x_precio_item" class="col-sm-2 control-label ewLabel"><?php echo $ap_items_inv->precio_item->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_items_inv->precio_item->CellAttributes() ?>>
<span id="el_ap_items_inv_precio_item">
<input type="text" data-table="ap_items_inv" data-field="x_precio_item" name="x_precio_item" id="x_precio_item" size="30" placeholder="<?php echo ew_HtmlEncode($ap_items_inv->precio_item->getPlaceHolder()) ?>" value="<?php echo $ap_items_inv->precio_item->EditValue ?>"<?php echo $ap_items_inv->precio_item->EditAttributes() ?>>
</span>
<?php echo $ap_items_inv->precio_item->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_items_inv->costo_item->Visible) { // costo_item ?>
	<div id="r_costo_item" class="form-group">
		<label id="elh_ap_items_inv_costo_item" for="x_costo_item" class="col-sm-2 control-label ewLabel"><?php echo $ap_items_inv->costo_item->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_items_inv->costo_item->CellAttributes() ?>>
<span id="el_ap_items_inv_costo_item">
<input type="text" data-table="ap_items_inv" data-field="x_costo_item" name="x_costo_item" id="x_costo_item" size="30" placeholder="<?php echo ew_HtmlEncode($ap_items_inv->costo_item->getPlaceHolder()) ?>" value="<?php echo $ap_items_inv->costo_item->EditValue ?>"<?php echo $ap_items_inv->costo_item->EditAttributes() ?>>
</span>
<?php echo $ap_items_inv->costo_item->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_items_inv->tipo_item->Visible) { // tipo_item ?>
	<div id="r_tipo_item" class="form-group">
		<label id="elh_ap_items_inv_tipo_item" for="x_tipo_item" class="col-sm-2 control-label ewLabel"><?php echo $ap_items_inv->tipo_item->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_items_inv->tipo_item->CellAttributes() ?>>
<span id="el_ap_items_inv_tipo_item">
<input type="text" data-table="ap_items_inv" data-field="x_tipo_item" name="x_tipo_item" id="x_tipo_item" size="30" placeholder="<?php echo ew_HtmlEncode($ap_items_inv->tipo_item->getPlaceHolder()) ?>" value="<?php echo $ap_items_inv->tipo_item->EditValue ?>"<?php echo $ap_items_inv->tipo_item->EditAttributes() ?>>
</span>
<?php echo $ap_items_inv->tipo_item->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_items_inv->marca_item->Visible) { // marca_item ?>
	<div id="r_marca_item" class="form-group">
		<label id="elh_ap_items_inv_marca_item" for="x_marca_item" class="col-sm-2 control-label ewLabel"><?php echo $ap_items_inv->marca_item->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_items_inv->marca_item->CellAttributes() ?>>
<span id="el_ap_items_inv_marca_item">
<input type="text" data-table="ap_items_inv" data-field="x_marca_item" name="x_marca_item" id="x_marca_item" size="30" maxlength="80" placeholder="<?php echo ew_HtmlEncode($ap_items_inv->marca_item->getPlaceHolder()) ?>" value="<?php echo $ap_items_inv->marca_item->EditValue ?>"<?php echo $ap_items_inv->marca_item->EditAttributes() ?>>
</span>
<?php echo $ap_items_inv->marca_item->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_items_inv->cod_marca_item->Visible) { // cod_marca_item ?>
	<div id="r_cod_marca_item" class="form-group">
		<label id="elh_ap_items_inv_cod_marca_item" for="x_cod_marca_item" class="col-sm-2 control-label ewLabel"><?php echo $ap_items_inv->cod_marca_item->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_items_inv->cod_marca_item->CellAttributes() ?>>
<span id="el_ap_items_inv_cod_marca_item">
<input type="text" data-table="ap_items_inv" data-field="x_cod_marca_item" name="x_cod_marca_item" id="x_cod_marca_item" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($ap_items_inv->cod_marca_item->getPlaceHolder()) ?>" value="<?php echo $ap_items_inv->cod_marca_item->EditValue ?>"<?php echo $ap_items_inv->cod_marca_item->EditAttributes() ?>>
</span>
<?php echo $ap_items_inv->cod_marca_item->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_items_inv->detalle_item->Visible) { // detalle_item ?>
	<div id="r_detalle_item" class="form-group">
		<label id="elh_ap_items_inv_detalle_item" for="x_detalle_item" class="col-sm-2 control-label ewLabel"><?php echo $ap_items_inv->detalle_item->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_items_inv->detalle_item->CellAttributes() ?>>
<span id="el_ap_items_inv_detalle_item">
<input type="text" data-table="ap_items_inv" data-field="x_detalle_item" name="x_detalle_item" id="x_detalle_item" size="30" maxlength="80" placeholder="<?php echo ew_HtmlEncode($ap_items_inv->detalle_item->getPlaceHolder()) ?>" value="<?php echo $ap_items_inv->detalle_item->EditValue ?>"<?php echo $ap_items_inv->detalle_item->EditAttributes() ?>>
</span>
<?php echo $ap_items_inv->detalle_item->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_items_inv->saldo_item->Visible) { // saldo_item ?>
	<div id="r_saldo_item" class="form-group">
		<label id="elh_ap_items_inv_saldo_item" for="x_saldo_item" class="col-sm-2 control-label ewLabel"><?php echo $ap_items_inv->saldo_item->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_items_inv->saldo_item->CellAttributes() ?>>
<span id="el_ap_items_inv_saldo_item">
<input type="text" data-table="ap_items_inv" data-field="x_saldo_item" name="x_saldo_item" id="x_saldo_item" size="30" placeholder="<?php echo ew_HtmlEncode($ap_items_inv->saldo_item->getPlaceHolder()) ?>" value="<?php echo $ap_items_inv->saldo_item->EditValue ?>"<?php echo $ap_items_inv->saldo_item->EditAttributes() ?>>
</span>
<?php echo $ap_items_inv->saldo_item->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_items_inv->activo_item->Visible) { // activo_item ?>
	<div id="r_activo_item" class="form-group">
		<label id="elh_ap_items_inv_activo_item" for="x_activo_item" class="col-sm-2 control-label ewLabel"><?php echo $ap_items_inv->activo_item->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_items_inv->activo_item->CellAttributes() ?>>
<span id="el_ap_items_inv_activo_item">
<input type="text" data-table="ap_items_inv" data-field="x_activo_item" name="x_activo_item" id="x_activo_item" size="30" placeholder="<?php echo ew_HtmlEncode($ap_items_inv->activo_item->getPlaceHolder()) ?>" value="<?php echo $ap_items_inv->activo_item->EditValue ?>"<?php echo $ap_items_inv->activo_item->EditAttributes() ?>>
</span>
<?php echo $ap_items_inv->activo_item->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_items_inv->maneja_serial_item->Visible) { // maneja_serial_item ?>
	<div id="r_maneja_serial_item" class="form-group">
		<label id="elh_ap_items_inv_maneja_serial_item" for="x_maneja_serial_item" class="col-sm-2 control-label ewLabel"><?php echo $ap_items_inv->maneja_serial_item->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_items_inv->maneja_serial_item->CellAttributes() ?>>
<span id="el_ap_items_inv_maneja_serial_item">
<input type="text" data-table="ap_items_inv" data-field="x_maneja_serial_item" name="x_maneja_serial_item" id="x_maneja_serial_item" size="30" placeholder="<?php echo ew_HtmlEncode($ap_items_inv->maneja_serial_item->getPlaceHolder()) ?>" value="<?php echo $ap_items_inv->maneja_serial_item->EditValue ?>"<?php echo $ap_items_inv->maneja_serial_item->EditAttributes() ?>>
</span>
<?php echo $ap_items_inv->maneja_serial_item->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_items_inv->asignado_item->Visible) { // asignado_item ?>
	<div id="r_asignado_item" class="form-group">
		<label id="elh_ap_items_inv_asignado_item" for="x_asignado_item" class="col-sm-2 control-label ewLabel"><?php echo $ap_items_inv->asignado_item->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_items_inv->asignado_item->CellAttributes() ?>>
<span id="el_ap_items_inv_asignado_item">
<input type="text" data-table="ap_items_inv" data-field="x_asignado_item" name="x_asignado_item" id="x_asignado_item" size="30" placeholder="<?php echo ew_HtmlEncode($ap_items_inv->asignado_item->getPlaceHolder()) ?>" value="<?php echo $ap_items_inv->asignado_item->EditValue ?>"<?php echo $ap_items_inv->asignado_item->EditAttributes() ?>>
</span>
<?php echo $ap_items_inv->asignado_item->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_items_inv->si_no_item->Visible) { // si_no_item ?>
	<div id="r_si_no_item" class="form-group">
		<label id="elh_ap_items_inv_si_no_item" for="x_si_no_item" class="col-sm-2 control-label ewLabel"><?php echo $ap_items_inv->si_no_item->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_items_inv->si_no_item->CellAttributes() ?>>
<span id="el_ap_items_inv_si_no_item">
<input type="text" data-table="ap_items_inv" data-field="x_si_no_item" name="x_si_no_item" id="x_si_no_item" size="30" placeholder="<?php echo ew_HtmlEncode($ap_items_inv->si_no_item->getPlaceHolder()) ?>" value="<?php echo $ap_items_inv->si_no_item->EditValue ?>"<?php echo $ap_items_inv->si_no_item->EditAttributes() ?>>
</span>
<?php echo $ap_items_inv->si_no_item->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_items_inv->precio_old_item->Visible) { // precio_old_item ?>
	<div id="r_precio_old_item" class="form-group">
		<label id="elh_ap_items_inv_precio_old_item" for="x_precio_old_item" class="col-sm-2 control-label ewLabel"><?php echo $ap_items_inv->precio_old_item->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_items_inv->precio_old_item->CellAttributes() ?>>
<span id="el_ap_items_inv_precio_old_item">
<input type="text" data-table="ap_items_inv" data-field="x_precio_old_item" name="x_precio_old_item" id="x_precio_old_item" size="30" placeholder="<?php echo ew_HtmlEncode($ap_items_inv->precio_old_item->getPlaceHolder()) ?>" value="<?php echo $ap_items_inv->precio_old_item->EditValue ?>"<?php echo $ap_items_inv->precio_old_item->EditAttributes() ?>>
</span>
<?php echo $ap_items_inv->precio_old_item->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_items_inv->costo_old_item->Visible) { // costo_old_item ?>
	<div id="r_costo_old_item" class="form-group">
		<label id="elh_ap_items_inv_costo_old_item" for="x_costo_old_item" class="col-sm-2 control-label ewLabel"><?php echo $ap_items_inv->costo_old_item->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_items_inv->costo_old_item->CellAttributes() ?>>
<span id="el_ap_items_inv_costo_old_item">
<input type="text" data-table="ap_items_inv" data-field="x_costo_old_item" name="x_costo_old_item" id="x_costo_old_item" size="30" placeholder="<?php echo ew_HtmlEncode($ap_items_inv->costo_old_item->getPlaceHolder()) ?>" value="<?php echo $ap_items_inv->costo_old_item->EditValue ?>"<?php echo $ap_items_inv->costo_old_item->EditAttributes() ?>>
</span>
<?php echo $ap_items_inv->costo_old_item->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_items_inv->registra_item->Visible) { // registra_item ?>
	<div id="r_registra_item" class="form-group">
		<label id="elh_ap_items_inv_registra_item" for="x_registra_item" class="col-sm-2 control-label ewLabel"><?php echo $ap_items_inv->registra_item->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_items_inv->registra_item->CellAttributes() ?>>
<span id="el_ap_items_inv_registra_item">
<input type="text" data-table="ap_items_inv" data-field="x_registra_item" name="x_registra_item" id="x_registra_item" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($ap_items_inv->registra_item->getPlaceHolder()) ?>" value="<?php echo $ap_items_inv->registra_item->EditValue ?>"<?php echo $ap_items_inv->registra_item->EditAttributes() ?>>
</span>
<?php echo $ap_items_inv->registra_item->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_items_inv->fecha_registro_item->Visible) { // fecha_registro_item ?>
	<div id="r_fecha_registro_item" class="form-group">
		<label id="elh_ap_items_inv_fecha_registro_item" for="x_fecha_registro_item" class="col-sm-2 control-label ewLabel"><?php echo $ap_items_inv->fecha_registro_item->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_items_inv->fecha_registro_item->CellAttributes() ?>>
<span id="el_ap_items_inv_fecha_registro_item">
<input type="text" data-table="ap_items_inv" data-field="x_fecha_registro_item" name="x_fecha_registro_item" id="x_fecha_registro_item" placeholder="<?php echo ew_HtmlEncode($ap_items_inv->fecha_registro_item->getPlaceHolder()) ?>" value="<?php echo $ap_items_inv->fecha_registro_item->EditValue ?>"<?php echo $ap_items_inv->fecha_registro_item->EditAttributes() ?>>
</span>
<?php echo $ap_items_inv->fecha_registro_item->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_items_inv->empresa_item->Visible) { // empresa_item ?>
	<div id="r_empresa_item" class="form-group">
		<label id="elh_ap_items_inv_empresa_item" for="x_empresa_item" class="col-sm-2 control-label ewLabel"><?php echo $ap_items_inv->empresa_item->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_items_inv->empresa_item->CellAttributes() ?>>
<span id="el_ap_items_inv_empresa_item">
<input type="text" data-table="ap_items_inv" data-field="x_empresa_item" name="x_empresa_item" id="x_empresa_item" size="30" placeholder="<?php echo ew_HtmlEncode($ap_items_inv->empresa_item->getPlaceHolder()) ?>" value="<?php echo $ap_items_inv->empresa_item->EditValue ?>"<?php echo $ap_items_inv->empresa_item->EditAttributes() ?>>
</span>
<?php echo $ap_items_inv->empresa_item->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$ap_items_inv_edit->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $ap_items_inv_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fap_items_invedit.Init();
</script>
<?php
$ap_items_inv_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$ap_items_inv_edit->Page_Terminate();
?>
