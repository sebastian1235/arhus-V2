<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "ap_roles_usuariosinfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$ap_roles_usuarios_edit = NULL; // Initialize page object first

class cap_roles_usuarios_edit extends cap_roles_usuarios {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{6A9AC718-A824-45A3-BED3-A95E91E6986D}";

	// Table name
	var $TableName = 'ap_roles_usuarios';

	// Page object name
	var $PageObjName = 'ap_roles_usuarios_edit';

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

		// Table object (ap_roles_usuarios)
		if (!isset($GLOBALS["ap_roles_usuarios"]) || get_class($GLOBALS["ap_roles_usuarios"]) == "cap_roles_usuarios") {
			$GLOBALS["ap_roles_usuarios"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["ap_roles_usuarios"];
		}

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'ap_roles_usuarios', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("ap_roles_usuarioslist.php"));
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
		$this->Id_Rol->SetVisibility();
		$this->Id_Rol->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->grupo_Rol->SetVisibility();
		$this->formulario_Rol->SetVisibility();
		$this->abrir_Rol->SetVisibility();
		$this->agregar_Rol->SetVisibility();
		$this->editar_Rol->SetVisibility();
		$this->eliminar_Rol->SetVisibility();
		$this->mostrar_Rol->SetVisibility();
		$this->alias_Rol->SetVisibility();
		$this->empresa_Rol->SetVisibility();

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
		global $EW_EXPORT, $ap_roles_usuarios;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($ap_roles_usuarios);
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
		if (@$_GET["Id_Rol"] <> "") {
			$this->Id_Rol->setQueryStringValue($_GET["Id_Rol"]);
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
		if ($this->Id_Rol->CurrentValue == "") {
			$this->Page_Terminate("ap_roles_usuarioslist.php"); // Invalid key, return to list
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
					$this->Page_Terminate("ap_roles_usuarioslist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "ap_roles_usuarioslist.php")
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
		if (!$this->Id_Rol->FldIsDetailKey)
			$this->Id_Rol->setFormValue($objForm->GetValue("x_Id_Rol"));
		if (!$this->grupo_Rol->FldIsDetailKey) {
			$this->grupo_Rol->setFormValue($objForm->GetValue("x_grupo_Rol"));
		}
		if (!$this->formulario_Rol->FldIsDetailKey) {
			$this->formulario_Rol->setFormValue($objForm->GetValue("x_formulario_Rol"));
		}
		if (!$this->abrir_Rol->FldIsDetailKey) {
			$this->abrir_Rol->setFormValue($objForm->GetValue("x_abrir_Rol"));
		}
		if (!$this->agregar_Rol->FldIsDetailKey) {
			$this->agregar_Rol->setFormValue($objForm->GetValue("x_agregar_Rol"));
		}
		if (!$this->editar_Rol->FldIsDetailKey) {
			$this->editar_Rol->setFormValue($objForm->GetValue("x_editar_Rol"));
		}
		if (!$this->eliminar_Rol->FldIsDetailKey) {
			$this->eliminar_Rol->setFormValue($objForm->GetValue("x_eliminar_Rol"));
		}
		if (!$this->mostrar_Rol->FldIsDetailKey) {
			$this->mostrar_Rol->setFormValue($objForm->GetValue("x_mostrar_Rol"));
		}
		if (!$this->alias_Rol->FldIsDetailKey) {
			$this->alias_Rol->setFormValue($objForm->GetValue("x_alias_Rol"));
		}
		if (!$this->empresa_Rol->FldIsDetailKey) {
			$this->empresa_Rol->setFormValue($objForm->GetValue("x_empresa_Rol"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->Id_Rol->CurrentValue = $this->Id_Rol->FormValue;
		$this->grupo_Rol->CurrentValue = $this->grupo_Rol->FormValue;
		$this->formulario_Rol->CurrentValue = $this->formulario_Rol->FormValue;
		$this->abrir_Rol->CurrentValue = $this->abrir_Rol->FormValue;
		$this->agregar_Rol->CurrentValue = $this->agregar_Rol->FormValue;
		$this->editar_Rol->CurrentValue = $this->editar_Rol->FormValue;
		$this->eliminar_Rol->CurrentValue = $this->eliminar_Rol->FormValue;
		$this->mostrar_Rol->CurrentValue = $this->mostrar_Rol->FormValue;
		$this->alias_Rol->CurrentValue = $this->alias_Rol->FormValue;
		$this->empresa_Rol->CurrentValue = $this->empresa_Rol->FormValue;
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
		$this->Id_Rol->setDbValue($rs->fields('Id_Rol'));
		$this->grupo_Rol->setDbValue($rs->fields('grupo_Rol'));
		$this->formulario_Rol->setDbValue($rs->fields('formulario_Rol'));
		$this->abrir_Rol->setDbValue($rs->fields('abrir_Rol'));
		$this->agregar_Rol->setDbValue($rs->fields('agregar_Rol'));
		$this->editar_Rol->setDbValue($rs->fields('editar_Rol'));
		$this->eliminar_Rol->setDbValue($rs->fields('eliminar_Rol'));
		$this->mostrar_Rol->setDbValue($rs->fields('mostrar_Rol'));
		$this->alias_Rol->setDbValue($rs->fields('alias_Rol'));
		$this->empresa_Rol->setDbValue($rs->fields('empresa_Rol'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->Id_Rol->DbValue = $row['Id_Rol'];
		$this->grupo_Rol->DbValue = $row['grupo_Rol'];
		$this->formulario_Rol->DbValue = $row['formulario_Rol'];
		$this->abrir_Rol->DbValue = $row['abrir_Rol'];
		$this->agregar_Rol->DbValue = $row['agregar_Rol'];
		$this->editar_Rol->DbValue = $row['editar_Rol'];
		$this->eliminar_Rol->DbValue = $row['eliminar_Rol'];
		$this->mostrar_Rol->DbValue = $row['mostrar_Rol'];
		$this->alias_Rol->DbValue = $row['alias_Rol'];
		$this->empresa_Rol->DbValue = $row['empresa_Rol'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// Id_Rol
		// grupo_Rol
		// formulario_Rol
		// abrir_Rol
		// agregar_Rol
		// editar_Rol
		// eliminar_Rol
		// mostrar_Rol
		// alias_Rol
		// empresa_Rol

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Id_Rol
		$this->Id_Rol->ViewValue = $this->Id_Rol->CurrentValue;
		$this->Id_Rol->ViewCustomAttributes = "";

		// grupo_Rol
		$this->grupo_Rol->ViewValue = $this->grupo_Rol->CurrentValue;
		$this->grupo_Rol->ViewCustomAttributes = "";

		// formulario_Rol
		$this->formulario_Rol->ViewValue = $this->formulario_Rol->CurrentValue;
		$this->formulario_Rol->ViewCustomAttributes = "";

		// abrir_Rol
		$this->abrir_Rol->ViewValue = $this->abrir_Rol->CurrentValue;
		$this->abrir_Rol->ViewCustomAttributes = "";

		// agregar_Rol
		$this->agregar_Rol->ViewValue = $this->agregar_Rol->CurrentValue;
		$this->agregar_Rol->ViewCustomAttributes = "";

		// editar_Rol
		$this->editar_Rol->ViewValue = $this->editar_Rol->CurrentValue;
		$this->editar_Rol->ViewCustomAttributes = "";

		// eliminar_Rol
		$this->eliminar_Rol->ViewValue = $this->eliminar_Rol->CurrentValue;
		$this->eliminar_Rol->ViewCustomAttributes = "";

		// mostrar_Rol
		$this->mostrar_Rol->ViewValue = $this->mostrar_Rol->CurrentValue;
		$this->mostrar_Rol->ViewCustomAttributes = "";

		// alias_Rol
		$this->alias_Rol->ViewValue = $this->alias_Rol->CurrentValue;
		$this->alias_Rol->ViewCustomAttributes = "";

		// empresa_Rol
		$this->empresa_Rol->ViewValue = $this->empresa_Rol->CurrentValue;
		$this->empresa_Rol->ViewCustomAttributes = "";

			// Id_Rol
			$this->Id_Rol->LinkCustomAttributes = "";
			$this->Id_Rol->HrefValue = "";
			$this->Id_Rol->TooltipValue = "";

			// grupo_Rol
			$this->grupo_Rol->LinkCustomAttributes = "";
			$this->grupo_Rol->HrefValue = "";
			$this->grupo_Rol->TooltipValue = "";

			// formulario_Rol
			$this->formulario_Rol->LinkCustomAttributes = "";
			$this->formulario_Rol->HrefValue = "";
			$this->formulario_Rol->TooltipValue = "";

			// abrir_Rol
			$this->abrir_Rol->LinkCustomAttributes = "";
			$this->abrir_Rol->HrefValue = "";
			$this->abrir_Rol->TooltipValue = "";

			// agregar_Rol
			$this->agregar_Rol->LinkCustomAttributes = "";
			$this->agregar_Rol->HrefValue = "";
			$this->agregar_Rol->TooltipValue = "";

			// editar_Rol
			$this->editar_Rol->LinkCustomAttributes = "";
			$this->editar_Rol->HrefValue = "";
			$this->editar_Rol->TooltipValue = "";

			// eliminar_Rol
			$this->eliminar_Rol->LinkCustomAttributes = "";
			$this->eliminar_Rol->HrefValue = "";
			$this->eliminar_Rol->TooltipValue = "";

			// mostrar_Rol
			$this->mostrar_Rol->LinkCustomAttributes = "";
			$this->mostrar_Rol->HrefValue = "";
			$this->mostrar_Rol->TooltipValue = "";

			// alias_Rol
			$this->alias_Rol->LinkCustomAttributes = "";
			$this->alias_Rol->HrefValue = "";
			$this->alias_Rol->TooltipValue = "";

			// empresa_Rol
			$this->empresa_Rol->LinkCustomAttributes = "";
			$this->empresa_Rol->HrefValue = "";
			$this->empresa_Rol->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// Id_Rol
			$this->Id_Rol->EditAttrs["class"] = "form-control";
			$this->Id_Rol->EditCustomAttributes = "";
			$this->Id_Rol->EditValue = $this->Id_Rol->CurrentValue;
			$this->Id_Rol->ViewCustomAttributes = "";

			// grupo_Rol
			$this->grupo_Rol->EditAttrs["class"] = "form-control";
			$this->grupo_Rol->EditCustomAttributes = "";
			$this->grupo_Rol->EditValue = ew_HtmlEncode($this->grupo_Rol->CurrentValue);
			$this->grupo_Rol->PlaceHolder = ew_RemoveHtml($this->grupo_Rol->FldCaption());

			// formulario_Rol
			$this->formulario_Rol->EditAttrs["class"] = "form-control";
			$this->formulario_Rol->EditCustomAttributes = "";
			$this->formulario_Rol->EditValue = ew_HtmlEncode($this->formulario_Rol->CurrentValue);
			$this->formulario_Rol->PlaceHolder = ew_RemoveHtml($this->formulario_Rol->FldCaption());

			// abrir_Rol
			$this->abrir_Rol->EditAttrs["class"] = "form-control";
			$this->abrir_Rol->EditCustomAttributes = "";
			$this->abrir_Rol->EditValue = ew_HtmlEncode($this->abrir_Rol->CurrentValue);
			$this->abrir_Rol->PlaceHolder = ew_RemoveHtml($this->abrir_Rol->FldCaption());

			// agregar_Rol
			$this->agregar_Rol->EditAttrs["class"] = "form-control";
			$this->agregar_Rol->EditCustomAttributes = "";
			$this->agregar_Rol->EditValue = ew_HtmlEncode($this->agregar_Rol->CurrentValue);
			$this->agregar_Rol->PlaceHolder = ew_RemoveHtml($this->agregar_Rol->FldCaption());

			// editar_Rol
			$this->editar_Rol->EditAttrs["class"] = "form-control";
			$this->editar_Rol->EditCustomAttributes = "";
			$this->editar_Rol->EditValue = ew_HtmlEncode($this->editar_Rol->CurrentValue);
			$this->editar_Rol->PlaceHolder = ew_RemoveHtml($this->editar_Rol->FldCaption());

			// eliminar_Rol
			$this->eliminar_Rol->EditAttrs["class"] = "form-control";
			$this->eliminar_Rol->EditCustomAttributes = "";
			$this->eliminar_Rol->EditValue = ew_HtmlEncode($this->eliminar_Rol->CurrentValue);
			$this->eliminar_Rol->PlaceHolder = ew_RemoveHtml($this->eliminar_Rol->FldCaption());

			// mostrar_Rol
			$this->mostrar_Rol->EditAttrs["class"] = "form-control";
			$this->mostrar_Rol->EditCustomAttributes = "";
			$this->mostrar_Rol->EditValue = ew_HtmlEncode($this->mostrar_Rol->CurrentValue);
			$this->mostrar_Rol->PlaceHolder = ew_RemoveHtml($this->mostrar_Rol->FldCaption());

			// alias_Rol
			$this->alias_Rol->EditAttrs["class"] = "form-control";
			$this->alias_Rol->EditCustomAttributes = "";
			$this->alias_Rol->EditValue = ew_HtmlEncode($this->alias_Rol->CurrentValue);
			$this->alias_Rol->PlaceHolder = ew_RemoveHtml($this->alias_Rol->FldCaption());

			// empresa_Rol
			$this->empresa_Rol->EditAttrs["class"] = "form-control";
			$this->empresa_Rol->EditCustomAttributes = "";
			$this->empresa_Rol->EditValue = ew_HtmlEncode($this->empresa_Rol->CurrentValue);
			$this->empresa_Rol->PlaceHolder = ew_RemoveHtml($this->empresa_Rol->FldCaption());

			// Edit refer script
			// Id_Rol

			$this->Id_Rol->LinkCustomAttributes = "";
			$this->Id_Rol->HrefValue = "";

			// grupo_Rol
			$this->grupo_Rol->LinkCustomAttributes = "";
			$this->grupo_Rol->HrefValue = "";

			// formulario_Rol
			$this->formulario_Rol->LinkCustomAttributes = "";
			$this->formulario_Rol->HrefValue = "";

			// abrir_Rol
			$this->abrir_Rol->LinkCustomAttributes = "";
			$this->abrir_Rol->HrefValue = "";

			// agregar_Rol
			$this->agregar_Rol->LinkCustomAttributes = "";
			$this->agregar_Rol->HrefValue = "";

			// editar_Rol
			$this->editar_Rol->LinkCustomAttributes = "";
			$this->editar_Rol->HrefValue = "";

			// eliminar_Rol
			$this->eliminar_Rol->LinkCustomAttributes = "";
			$this->eliminar_Rol->HrefValue = "";

			// mostrar_Rol
			$this->mostrar_Rol->LinkCustomAttributes = "";
			$this->mostrar_Rol->HrefValue = "";

			// alias_Rol
			$this->alias_Rol->LinkCustomAttributes = "";
			$this->alias_Rol->HrefValue = "";

			// empresa_Rol
			$this->empresa_Rol->LinkCustomAttributes = "";
			$this->empresa_Rol->HrefValue = "";
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
		if (!ew_CheckInteger($this->grupo_Rol->FormValue)) {
			ew_AddMessage($gsFormError, $this->grupo_Rol->FldErrMsg());
		}
		if (!$this->formulario_Rol->FldIsDetailKey && !is_null($this->formulario_Rol->FormValue) && $this->formulario_Rol->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->formulario_Rol->FldCaption(), $this->formulario_Rol->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->abrir_Rol->FormValue)) {
			ew_AddMessage($gsFormError, $this->abrir_Rol->FldErrMsg());
		}
		if (!ew_CheckInteger($this->agregar_Rol->FormValue)) {
			ew_AddMessage($gsFormError, $this->agregar_Rol->FldErrMsg());
		}
		if (!ew_CheckInteger($this->editar_Rol->FormValue)) {
			ew_AddMessage($gsFormError, $this->editar_Rol->FldErrMsg());
		}
		if (!ew_CheckInteger($this->eliminar_Rol->FormValue)) {
			ew_AddMessage($gsFormError, $this->eliminar_Rol->FldErrMsg());
		}
		if (!ew_CheckInteger($this->mostrar_Rol->FormValue)) {
			ew_AddMessage($gsFormError, $this->mostrar_Rol->FldErrMsg());
		}
		if (!ew_CheckInteger($this->empresa_Rol->FormValue)) {
			ew_AddMessage($gsFormError, $this->empresa_Rol->FldErrMsg());
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

			// grupo_Rol
			$this->grupo_Rol->SetDbValueDef($rsnew, $this->grupo_Rol->CurrentValue, NULL, $this->grupo_Rol->ReadOnly);

			// formulario_Rol
			$this->formulario_Rol->SetDbValueDef($rsnew, $this->formulario_Rol->CurrentValue, "", $this->formulario_Rol->ReadOnly);

			// abrir_Rol
			$this->abrir_Rol->SetDbValueDef($rsnew, $this->abrir_Rol->CurrentValue, NULL, $this->abrir_Rol->ReadOnly);

			// agregar_Rol
			$this->agregar_Rol->SetDbValueDef($rsnew, $this->agregar_Rol->CurrentValue, NULL, $this->agregar_Rol->ReadOnly);

			// editar_Rol
			$this->editar_Rol->SetDbValueDef($rsnew, $this->editar_Rol->CurrentValue, NULL, $this->editar_Rol->ReadOnly);

			// eliminar_Rol
			$this->eliminar_Rol->SetDbValueDef($rsnew, $this->eliminar_Rol->CurrentValue, NULL, $this->eliminar_Rol->ReadOnly);

			// mostrar_Rol
			$this->mostrar_Rol->SetDbValueDef($rsnew, $this->mostrar_Rol->CurrentValue, NULL, $this->mostrar_Rol->ReadOnly);

			// alias_Rol
			$this->alias_Rol->SetDbValueDef($rsnew, $this->alias_Rol->CurrentValue, NULL, $this->alias_Rol->ReadOnly);

			// empresa_Rol
			$this->empresa_Rol->SetDbValueDef($rsnew, $this->empresa_Rol->CurrentValue, NULL, $this->empresa_Rol->ReadOnly);

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("ap_roles_usuarioslist.php"), "", $this->TableVar, TRUE);
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
if (!isset($ap_roles_usuarios_edit)) $ap_roles_usuarios_edit = new cap_roles_usuarios_edit();

// Page init
$ap_roles_usuarios_edit->Page_Init();

// Page main
$ap_roles_usuarios_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$ap_roles_usuarios_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fap_roles_usuariosedit = new ew_Form("fap_roles_usuariosedit", "edit");

// Validate form
fap_roles_usuariosedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_grupo_Rol");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ap_roles_usuarios->grupo_Rol->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_formulario_Rol");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ap_roles_usuarios->formulario_Rol->FldCaption(), $ap_roles_usuarios->formulario_Rol->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_abrir_Rol");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ap_roles_usuarios->abrir_Rol->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_agregar_Rol");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ap_roles_usuarios->agregar_Rol->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_editar_Rol");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ap_roles_usuarios->editar_Rol->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_eliminar_Rol");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ap_roles_usuarios->eliminar_Rol->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_mostrar_Rol");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ap_roles_usuarios->mostrar_Rol->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_empresa_Rol");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ap_roles_usuarios->empresa_Rol->FldErrMsg()) ?>");

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
fap_roles_usuariosedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fap_roles_usuariosedit.ValidateRequired = true;
<?php } else { ?>
fap_roles_usuariosedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$ap_roles_usuarios_edit->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $ap_roles_usuarios_edit->ShowPageHeader(); ?>
<?php
$ap_roles_usuarios_edit->ShowMessage();
?>
<form name="fap_roles_usuariosedit" id="fap_roles_usuariosedit" class="<?php echo $ap_roles_usuarios_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($ap_roles_usuarios_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $ap_roles_usuarios_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="ap_roles_usuarios">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<?php if ($ap_roles_usuarios_edit->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($ap_roles_usuarios->Id_Rol->Visible) { // Id_Rol ?>
	<div id="r_Id_Rol" class="form-group">
		<label id="elh_ap_roles_usuarios_Id_Rol" class="col-sm-2 control-label ewLabel"><?php echo $ap_roles_usuarios->Id_Rol->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_roles_usuarios->Id_Rol->CellAttributes() ?>>
<span id="el_ap_roles_usuarios_Id_Rol">
<span<?php echo $ap_roles_usuarios->Id_Rol->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $ap_roles_usuarios->Id_Rol->EditValue ?></p></span>
</span>
<input type="hidden" data-table="ap_roles_usuarios" data-field="x_Id_Rol" name="x_Id_Rol" id="x_Id_Rol" value="<?php echo ew_HtmlEncode($ap_roles_usuarios->Id_Rol->CurrentValue) ?>">
<?php echo $ap_roles_usuarios->Id_Rol->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_roles_usuarios->grupo_Rol->Visible) { // grupo_Rol ?>
	<div id="r_grupo_Rol" class="form-group">
		<label id="elh_ap_roles_usuarios_grupo_Rol" for="x_grupo_Rol" class="col-sm-2 control-label ewLabel"><?php echo $ap_roles_usuarios->grupo_Rol->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_roles_usuarios->grupo_Rol->CellAttributes() ?>>
<span id="el_ap_roles_usuarios_grupo_Rol">
<input type="text" data-table="ap_roles_usuarios" data-field="x_grupo_Rol" name="x_grupo_Rol" id="x_grupo_Rol" size="30" placeholder="<?php echo ew_HtmlEncode($ap_roles_usuarios->grupo_Rol->getPlaceHolder()) ?>" value="<?php echo $ap_roles_usuarios->grupo_Rol->EditValue ?>"<?php echo $ap_roles_usuarios->grupo_Rol->EditAttributes() ?>>
</span>
<?php echo $ap_roles_usuarios->grupo_Rol->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_roles_usuarios->formulario_Rol->Visible) { // formulario_Rol ?>
	<div id="r_formulario_Rol" class="form-group">
		<label id="elh_ap_roles_usuarios_formulario_Rol" for="x_formulario_Rol" class="col-sm-2 control-label ewLabel"><?php echo $ap_roles_usuarios->formulario_Rol->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $ap_roles_usuarios->formulario_Rol->CellAttributes() ?>>
<span id="el_ap_roles_usuarios_formulario_Rol">
<textarea data-table="ap_roles_usuarios" data-field="x_formulario_Rol" name="x_formulario_Rol" id="x_formulario_Rol" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($ap_roles_usuarios->formulario_Rol->getPlaceHolder()) ?>"<?php echo $ap_roles_usuarios->formulario_Rol->EditAttributes() ?>><?php echo $ap_roles_usuarios->formulario_Rol->EditValue ?></textarea>
</span>
<?php echo $ap_roles_usuarios->formulario_Rol->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_roles_usuarios->abrir_Rol->Visible) { // abrir_Rol ?>
	<div id="r_abrir_Rol" class="form-group">
		<label id="elh_ap_roles_usuarios_abrir_Rol" for="x_abrir_Rol" class="col-sm-2 control-label ewLabel"><?php echo $ap_roles_usuarios->abrir_Rol->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_roles_usuarios->abrir_Rol->CellAttributes() ?>>
<span id="el_ap_roles_usuarios_abrir_Rol">
<input type="text" data-table="ap_roles_usuarios" data-field="x_abrir_Rol" name="x_abrir_Rol" id="x_abrir_Rol" size="30" placeholder="<?php echo ew_HtmlEncode($ap_roles_usuarios->abrir_Rol->getPlaceHolder()) ?>" value="<?php echo $ap_roles_usuarios->abrir_Rol->EditValue ?>"<?php echo $ap_roles_usuarios->abrir_Rol->EditAttributes() ?>>
</span>
<?php echo $ap_roles_usuarios->abrir_Rol->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_roles_usuarios->agregar_Rol->Visible) { // agregar_Rol ?>
	<div id="r_agregar_Rol" class="form-group">
		<label id="elh_ap_roles_usuarios_agregar_Rol" for="x_agregar_Rol" class="col-sm-2 control-label ewLabel"><?php echo $ap_roles_usuarios->agregar_Rol->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_roles_usuarios->agregar_Rol->CellAttributes() ?>>
<span id="el_ap_roles_usuarios_agregar_Rol">
<input type="text" data-table="ap_roles_usuarios" data-field="x_agregar_Rol" name="x_agregar_Rol" id="x_agregar_Rol" size="30" placeholder="<?php echo ew_HtmlEncode($ap_roles_usuarios->agregar_Rol->getPlaceHolder()) ?>" value="<?php echo $ap_roles_usuarios->agregar_Rol->EditValue ?>"<?php echo $ap_roles_usuarios->agregar_Rol->EditAttributes() ?>>
</span>
<?php echo $ap_roles_usuarios->agregar_Rol->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_roles_usuarios->editar_Rol->Visible) { // editar_Rol ?>
	<div id="r_editar_Rol" class="form-group">
		<label id="elh_ap_roles_usuarios_editar_Rol" for="x_editar_Rol" class="col-sm-2 control-label ewLabel"><?php echo $ap_roles_usuarios->editar_Rol->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_roles_usuarios->editar_Rol->CellAttributes() ?>>
<span id="el_ap_roles_usuarios_editar_Rol">
<input type="text" data-table="ap_roles_usuarios" data-field="x_editar_Rol" name="x_editar_Rol" id="x_editar_Rol" size="30" placeholder="<?php echo ew_HtmlEncode($ap_roles_usuarios->editar_Rol->getPlaceHolder()) ?>" value="<?php echo $ap_roles_usuarios->editar_Rol->EditValue ?>"<?php echo $ap_roles_usuarios->editar_Rol->EditAttributes() ?>>
</span>
<?php echo $ap_roles_usuarios->editar_Rol->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_roles_usuarios->eliminar_Rol->Visible) { // eliminar_Rol ?>
	<div id="r_eliminar_Rol" class="form-group">
		<label id="elh_ap_roles_usuarios_eliminar_Rol" for="x_eliminar_Rol" class="col-sm-2 control-label ewLabel"><?php echo $ap_roles_usuarios->eliminar_Rol->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_roles_usuarios->eliminar_Rol->CellAttributes() ?>>
<span id="el_ap_roles_usuarios_eliminar_Rol">
<input type="text" data-table="ap_roles_usuarios" data-field="x_eliminar_Rol" name="x_eliminar_Rol" id="x_eliminar_Rol" size="30" placeholder="<?php echo ew_HtmlEncode($ap_roles_usuarios->eliminar_Rol->getPlaceHolder()) ?>" value="<?php echo $ap_roles_usuarios->eliminar_Rol->EditValue ?>"<?php echo $ap_roles_usuarios->eliminar_Rol->EditAttributes() ?>>
</span>
<?php echo $ap_roles_usuarios->eliminar_Rol->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_roles_usuarios->mostrar_Rol->Visible) { // mostrar_Rol ?>
	<div id="r_mostrar_Rol" class="form-group">
		<label id="elh_ap_roles_usuarios_mostrar_Rol" for="x_mostrar_Rol" class="col-sm-2 control-label ewLabel"><?php echo $ap_roles_usuarios->mostrar_Rol->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_roles_usuarios->mostrar_Rol->CellAttributes() ?>>
<span id="el_ap_roles_usuarios_mostrar_Rol">
<input type="text" data-table="ap_roles_usuarios" data-field="x_mostrar_Rol" name="x_mostrar_Rol" id="x_mostrar_Rol" size="30" placeholder="<?php echo ew_HtmlEncode($ap_roles_usuarios->mostrar_Rol->getPlaceHolder()) ?>" value="<?php echo $ap_roles_usuarios->mostrar_Rol->EditValue ?>"<?php echo $ap_roles_usuarios->mostrar_Rol->EditAttributes() ?>>
</span>
<?php echo $ap_roles_usuarios->mostrar_Rol->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_roles_usuarios->alias_Rol->Visible) { // alias_Rol ?>
	<div id="r_alias_Rol" class="form-group">
		<label id="elh_ap_roles_usuarios_alias_Rol" for="x_alias_Rol" class="col-sm-2 control-label ewLabel"><?php echo $ap_roles_usuarios->alias_Rol->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_roles_usuarios->alias_Rol->CellAttributes() ?>>
<span id="el_ap_roles_usuarios_alias_Rol">
<input type="text" data-table="ap_roles_usuarios" data-field="x_alias_Rol" name="x_alias_Rol" id="x_alias_Rol" size="30" maxlength="80" placeholder="<?php echo ew_HtmlEncode($ap_roles_usuarios->alias_Rol->getPlaceHolder()) ?>" value="<?php echo $ap_roles_usuarios->alias_Rol->EditValue ?>"<?php echo $ap_roles_usuarios->alias_Rol->EditAttributes() ?>>
</span>
<?php echo $ap_roles_usuarios->alias_Rol->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_roles_usuarios->empresa_Rol->Visible) { // empresa_Rol ?>
	<div id="r_empresa_Rol" class="form-group">
		<label id="elh_ap_roles_usuarios_empresa_Rol" for="x_empresa_Rol" class="col-sm-2 control-label ewLabel"><?php echo $ap_roles_usuarios->empresa_Rol->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_roles_usuarios->empresa_Rol->CellAttributes() ?>>
<span id="el_ap_roles_usuarios_empresa_Rol">
<input type="text" data-table="ap_roles_usuarios" data-field="x_empresa_Rol" name="x_empresa_Rol" id="x_empresa_Rol" size="30" placeholder="<?php echo ew_HtmlEncode($ap_roles_usuarios->empresa_Rol->getPlaceHolder()) ?>" value="<?php echo $ap_roles_usuarios->empresa_Rol->EditValue ?>"<?php echo $ap_roles_usuarios->empresa_Rol->EditAttributes() ?>>
</span>
<?php echo $ap_roles_usuarios->empresa_Rol->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$ap_roles_usuarios_edit->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $ap_roles_usuarios_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fap_roles_usuariosedit.Init();
</script>
<?php
$ap_roles_usuarios_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$ap_roles_usuarios_edit->Page_Terminate();
?>
