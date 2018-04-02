<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$usuarios_add = NULL; // Initialize page object first

class cusuarios_add extends cusuarios {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{6A9AC718-A824-45A3-BED3-A95E91E6986D}";

	// Table name
	var $TableName = 'usuarios';

	// Page object name
	var $PageObjName = 'usuarios_add';

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

		// Table object (usuarios)
		if (!isset($GLOBALS["usuarios"]) || get_class($GLOBALS["usuarios"]) == "cusuarios") {
			$GLOBALS["usuarios"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["usuarios"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'usuarios', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("usuarioslist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		if ($Security->IsLoggedIn()) {
			$Security->UserID_Loading();
			$Security->LoadUserID();
			$Security->UserID_Loaded();
			if (strval($Security->CurrentUserID()) == "") {
				$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
				$this->Page_Terminate(ew_GetUrl("usuarioslist.php"));
			}
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->usuario->SetVisibility();
		$this->password->SetVisibility();
		$this->_email->SetVisibility();
		$this->photo->SetVisibility();
		$this->rol->SetVisibility();
		$this->intentos->SetVisibility();
		$this->Activo->SetVisibility();
		$this->Perfil->SetVisibility();

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
		global $EW_EXPORT, $usuarios;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($usuarios);
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
			if (@$_GET["id"] != "") {
				$this->id->setQueryStringValue($_GET["id"]);
				$this->setKey("id", $this->id->CurrentValue); // Set up key
			} else {
				$this->setKey("id", ""); // Clear key
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
					$this->Page_Terminate("usuarioslist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "usuarioslist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "usuariosview.php")
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
		$this->usuario->CurrentValue = NULL;
		$this->usuario->OldValue = $this->usuario->CurrentValue;
		$this->password->CurrentValue = NULL;
		$this->password->OldValue = $this->password->CurrentValue;
		$this->_email->CurrentValue = NULL;
		$this->_email->OldValue = $this->_email->CurrentValue;
		$this->photo->CurrentValue = NULL;
		$this->photo->OldValue = $this->photo->CurrentValue;
		$this->rol->CurrentValue = NULL;
		$this->rol->OldValue = $this->rol->CurrentValue;
		$this->intentos->CurrentValue = NULL;
		$this->intentos->OldValue = $this->intentos->CurrentValue;
		$this->Activo->CurrentValue = NULL;
		$this->Activo->OldValue = $this->Activo->CurrentValue;
		$this->Perfil->CurrentValue = NULL;
		$this->Perfil->OldValue = $this->Perfil->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->usuario->FldIsDetailKey) {
			$this->usuario->setFormValue($objForm->GetValue("x_usuario"));
		}
		if (!$this->password->FldIsDetailKey) {
			$this->password->setFormValue($objForm->GetValue("x_password"));
		}
		if (!$this->_email->FldIsDetailKey) {
			$this->_email->setFormValue($objForm->GetValue("x__email"));
		}
		if (!$this->photo->FldIsDetailKey) {
			$this->photo->setFormValue($objForm->GetValue("x_photo"));
		}
		if (!$this->rol->FldIsDetailKey) {
			$this->rol->setFormValue($objForm->GetValue("x_rol"));
		}
		if (!$this->intentos->FldIsDetailKey) {
			$this->intentos->setFormValue($objForm->GetValue("x_intentos"));
		}
		if (!$this->Activo->FldIsDetailKey) {
			$this->Activo->setFormValue($objForm->GetValue("x_Activo"));
		}
		if (!$this->Perfil->FldIsDetailKey) {
			$this->Perfil->setFormValue($objForm->GetValue("x_Perfil"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->usuario->CurrentValue = $this->usuario->FormValue;
		$this->password->CurrentValue = $this->password->FormValue;
		$this->_email->CurrentValue = $this->_email->FormValue;
		$this->photo->CurrentValue = $this->photo->FormValue;
		$this->rol->CurrentValue = $this->rol->FormValue;
		$this->intentos->CurrentValue = $this->intentos->FormValue;
		$this->Activo->CurrentValue = $this->Activo->FormValue;
		$this->Perfil->CurrentValue = $this->Perfil->FormValue;
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

		// Check if valid user id
		if ($res) {
			$res = $this->ShowOptionLink('add');
			if (!$res) {
				$sUserIdMsg = ew_DeniedMsg();
				$this->setFailureMessage($sUserIdMsg);
			}
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		if (!$rs || $rs->EOF) return;

		// Call Row Selected event
		$row = &$rs->fields;
		$this->Row_Selected($row);
		$this->id->setDbValue($rs->fields('id'));
		$this->usuario->setDbValue($rs->fields('usuario'));
		$this->password->setDbValue($rs->fields('password'));
		$this->_email->setDbValue($rs->fields('email'));
		$this->photo->setDbValue($rs->fields('photo'));
		$this->rol->setDbValue($rs->fields('rol'));
		$this->intentos->setDbValue($rs->fields('intentos'));
		$this->Activo->setDbValue($rs->fields('Activo'));
		$this->Perfil->setDbValue($rs->fields('Perfil'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->usuario->DbValue = $row['usuario'];
		$this->password->DbValue = $row['password'];
		$this->_email->DbValue = $row['email'];
		$this->photo->DbValue = $row['photo'];
		$this->rol->DbValue = $row['rol'];
		$this->intentos->DbValue = $row['intentos'];
		$this->Activo->DbValue = $row['Activo'];
		$this->Perfil->DbValue = $row['Perfil'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("id")) <> "")
			$this->id->CurrentValue = $this->getKey("id"); // id
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
		// id
		// usuario
		// password
		// email
		// photo
		// rol
		// intentos
		// Activo
		// Perfil

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// usuario
		$this->usuario->ViewValue = $this->usuario->CurrentValue;
		$this->usuario->ViewCustomAttributes = "";

		// password
		$this->password->ViewValue = $this->password->CurrentValue;
		$this->password->ViewCustomAttributes = "";

		// email
		$this->_email->ViewValue = $this->_email->CurrentValue;
		$this->_email->ViewCustomAttributes = "";

		// photo
		$this->photo->ViewValue = $this->photo->CurrentValue;
		$this->photo->ViewCustomAttributes = "";

		// rol
		if ($Security->CanAdmin()) { // System admin
		if (strval($this->rol->CurrentValue) <> "") {
			$this->rol->ViewValue = $this->rol->OptionCaption($this->rol->CurrentValue);
		} else {
			$this->rol->ViewValue = NULL;
		}
		} else {
			$this->rol->ViewValue = $Language->Phrase("PasswordMask");
		}
		$this->rol->ViewCustomAttributes = "";

		// intentos
		$this->intentos->ViewValue = $this->intentos->CurrentValue;
		$this->intentos->ViewCustomAttributes = "";

		// Activo
		$this->Activo->ViewValue = $this->Activo->CurrentValue;
		$this->Activo->ViewCustomAttributes = "";

		// Perfil
		$this->Perfil->ViewValue = $this->Perfil->CurrentValue;
		$this->Perfil->ViewCustomAttributes = "";

			// usuario
			$this->usuario->LinkCustomAttributes = "";
			$this->usuario->HrefValue = "";
			$this->usuario->TooltipValue = "";

			// password
			$this->password->LinkCustomAttributes = "";
			$this->password->HrefValue = "";
			$this->password->TooltipValue = "";

			// email
			$this->_email->LinkCustomAttributes = "";
			$this->_email->HrefValue = "";
			$this->_email->TooltipValue = "";

			// photo
			$this->photo->LinkCustomAttributes = "";
			$this->photo->HrefValue = "";
			$this->photo->TooltipValue = "";

			// rol
			$this->rol->LinkCustomAttributes = "";
			$this->rol->HrefValue = "";
			$this->rol->TooltipValue = "";

			// intentos
			$this->intentos->LinkCustomAttributes = "";
			$this->intentos->HrefValue = "";
			$this->intentos->TooltipValue = "";

			// Activo
			$this->Activo->LinkCustomAttributes = "";
			$this->Activo->HrefValue = "";
			$this->Activo->TooltipValue = "";

			// Perfil
			$this->Perfil->LinkCustomAttributes = "";
			$this->Perfil->HrefValue = "";
			$this->Perfil->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// usuario
			$this->usuario->EditAttrs["class"] = "form-control";
			$this->usuario->EditCustomAttributes = "";
			$this->usuario->EditValue = ew_HtmlEncode($this->usuario->CurrentValue);
			$this->usuario->PlaceHolder = ew_RemoveHtml($this->usuario->FldCaption());

			// password
			$this->password->EditAttrs["class"] = "form-control ewPasswordStrength";
			$this->password->EditCustomAttributes = "";
			$this->password->EditValue = ew_HtmlEncode($this->password->CurrentValue);
			$this->password->PlaceHolder = ew_RemoveHtml($this->password->FldCaption());

			// email
			$this->_email->EditAttrs["class"] = "form-control";
			$this->_email->EditCustomAttributes = "";
			$this->_email->EditValue = ew_HtmlEncode($this->_email->CurrentValue);
			$this->_email->PlaceHolder = ew_RemoveHtml($this->_email->FldCaption());

			// photo
			$this->photo->EditAttrs["class"] = "form-control";
			$this->photo->EditCustomAttributes = "";
			$this->photo->EditValue = ew_HtmlEncode($this->photo->CurrentValue);
			$this->photo->PlaceHolder = ew_RemoveHtml($this->photo->FldCaption());

			// rol
			$this->rol->EditAttrs["class"] = "form-control";
			$this->rol->EditCustomAttributes = "";
			if (!$Security->IsAdmin() && $Security->IsLoggedIn()) { // Non system admin
			$sFilterWrk = "";
			$sFilterWrk = $GLOBALS["usuarios"]->AddParentUserIDFilter("", "");
			$sSqlWrk = "SELECT `id`, `id` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `usuarios`";
			$sWhereWrk = "";
			$this->rol->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->rol, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->rol->EditValue = $arwrk;
			} elseif (!$Security->CanAdmin()) { // System admin
				$this->rol->EditValue = $Language->Phrase("PasswordMask");
			} else {
			$this->rol->EditValue = $this->rol->Options(TRUE);
			}

			// intentos
			$this->intentos->EditAttrs["class"] = "form-control";
			$this->intentos->EditCustomAttributes = "";
			$this->intentos->EditValue = ew_HtmlEncode($this->intentos->CurrentValue);
			$this->intentos->PlaceHolder = ew_RemoveHtml($this->intentos->FldCaption());

			// Activo
			$this->Activo->EditAttrs["class"] = "form-control";
			$this->Activo->EditCustomAttributes = "";
			$this->Activo->EditValue = ew_HtmlEncode($this->Activo->CurrentValue);
			$this->Activo->PlaceHolder = ew_RemoveHtml($this->Activo->FldCaption());

			// Perfil
			$this->Perfil->EditAttrs["class"] = "form-control";
			$this->Perfil->EditCustomAttributes = "";
			$this->Perfil->EditValue = ew_HtmlEncode($this->Perfil->CurrentValue);
			$this->Perfil->PlaceHolder = ew_RemoveHtml($this->Perfil->FldCaption());

			// Add refer script
			// usuario

			$this->usuario->LinkCustomAttributes = "";
			$this->usuario->HrefValue = "";

			// password
			$this->password->LinkCustomAttributes = "";
			$this->password->HrefValue = "";

			// email
			$this->_email->LinkCustomAttributes = "";
			$this->_email->HrefValue = "";

			// photo
			$this->photo->LinkCustomAttributes = "";
			$this->photo->HrefValue = "";

			// rol
			$this->rol->LinkCustomAttributes = "";
			$this->rol->HrefValue = "";

			// intentos
			$this->intentos->LinkCustomAttributes = "";
			$this->intentos->HrefValue = "";

			// Activo
			$this->Activo->LinkCustomAttributes = "";
			$this->Activo->HrefValue = "";

			// Perfil
			$this->Perfil->LinkCustomAttributes = "";
			$this->Perfil->HrefValue = "";
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
		if (!$this->usuario->FldIsDetailKey && !is_null($this->usuario->FormValue) && $this->usuario->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->usuario->FldCaption(), $this->usuario->ReqErrMsg));
		}
		if (!$this->password->FldIsDetailKey && !is_null($this->password->FormValue) && $this->password->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->password->FldCaption(), $this->password->ReqErrMsg));
		}
		if (!$this->_email->FldIsDetailKey && !is_null($this->_email->FormValue) && $this->_email->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->_email->FldCaption(), $this->_email->ReqErrMsg));
		}
		if (!$this->photo->FldIsDetailKey && !is_null($this->photo->FormValue) && $this->photo->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->photo->FldCaption(), $this->photo->ReqErrMsg));
		}
		if (!$this->rol->FldIsDetailKey && !is_null($this->rol->FormValue) && $this->rol->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->rol->FldCaption(), $this->rol->ReqErrMsg));
		}
		if (!$this->intentos->FldIsDetailKey && !is_null($this->intentos->FormValue) && $this->intentos->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->intentos->FldCaption(), $this->intentos->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->intentos->FormValue)) {
			ew_AddMessage($gsFormError, $this->intentos->FldErrMsg());
		}
		if (!$this->Activo->FldIsDetailKey && !is_null($this->Activo->FormValue) && $this->Activo->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Activo->FldCaption(), $this->Activo->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->Activo->FormValue)) {
			ew_AddMessage($gsFormError, $this->Activo->FldErrMsg());
		}
		if (!$this->Perfil->FldIsDetailKey && !is_null($this->Perfil->FormValue) && $this->Perfil->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Perfil->FldCaption(), $this->Perfil->ReqErrMsg));
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

		// Check if valid User ID
		$bValidUser = FALSE;
		if ($Security->CurrentUserID() <> "" && !ew_Empty($this->id->CurrentValue) && !$Security->IsAdmin()) { // Non system admin
			$bValidUser = $Security->IsValidUserID($this->id->CurrentValue);
			if (!$bValidUser) {
				$sUserIdMsg = str_replace("%c", CurrentUserID(), $Language->Phrase("UnAuthorizedUserID"));
				$sUserIdMsg = str_replace("%u", $this->id->CurrentValue, $sUserIdMsg);
				$this->setFailureMessage($sUserIdMsg);
				return FALSE;
			}
		}

		// Check if valid parent user id
		$bValidParentUser = FALSE;
		if ($Security->CurrentUserID() <> "" && !ew_Empty($this->rol->CurrentValue) && !$Security->IsAdmin()) { // Non system admin
			$bValidParentUser = $Security->IsValidUserID($this->rol->CurrentValue);
			if (!$bValidParentUser) {
				$sParentUserIdMsg = str_replace("%c", CurrentUserID(), $Language->Phrase("UnAuthorizedParentUserID"));
				$sParentUserIdMsg = str_replace("%p", $this->rol->CurrentValue, $sParentUserIdMsg);
				$this->setFailureMessage($sParentUserIdMsg);
				return FALSE;
			}
		}
		$conn = &$this->Connection();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// usuario
		$this->usuario->SetDbValueDef($rsnew, $this->usuario->CurrentValue, "", FALSE);

		// password
		$this->password->SetDbValueDef($rsnew, $this->password->CurrentValue, "", FALSE);

		// email
		$this->_email->SetDbValueDef($rsnew, $this->_email->CurrentValue, "", FALSE);

		// photo
		$this->photo->SetDbValueDef($rsnew, $this->photo->CurrentValue, "", FALSE);

		// rol
		if ($Security->CanAdmin()) { // System admin
		$this->rol->SetDbValueDef($rsnew, $this->rol->CurrentValue, 0, FALSE);
		}

		// intentos
		$this->intentos->SetDbValueDef($rsnew, $this->intentos->CurrentValue, 0, FALSE);

		// Activo
		$this->Activo->SetDbValueDef($rsnew, $this->Activo->CurrentValue, 0, FALSE);

		// Perfil
		$this->Perfil->SetDbValueDef($rsnew, $this->Perfil->CurrentValue, "", FALSE);

		// id
		// Call Row Inserting event

		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {

				// Get insert id if necessary
				$this->id->setDbValue($conn->Insert_ID());
				$rsnew['id'] = $this->id->DbValue;
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

	// Show link optionally based on User ID
	function ShowOptionLink($id = "") {
		global $Security;
		if ($Security->IsLoggedIn() && !$Security->IsAdmin() && !$this->UserIDAllow($id))
			return $Security->IsValidUserID($this->id->CurrentValue);
		return TRUE;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("usuarioslist.php"), "", $this->TableVar, TRUE);
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
if (!isset($usuarios_add)) $usuarios_add = new cusuarios_add();

// Page init
$usuarios_add->Page_Init();

// Page main
$usuarios_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$usuarios_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fusuariosadd = new ew_Form("fusuariosadd", "add");

// Validate form
fusuariosadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_usuario");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $usuarios->usuario->FldCaption(), $usuarios->usuario->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_password");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $usuarios->password->FldCaption(), $usuarios->password->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "__email");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $usuarios->_email->FldCaption(), $usuarios->_email->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_photo");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $usuarios->photo->FldCaption(), $usuarios->photo->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_rol");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $usuarios->rol->FldCaption(), $usuarios->rol->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_intentos");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $usuarios->intentos->FldCaption(), $usuarios->intentos->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_intentos");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($usuarios->intentos->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Activo");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $usuarios->Activo->FldCaption(), $usuarios->Activo->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Activo");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($usuarios->Activo->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Perfil");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $usuarios->Perfil->FldCaption(), $usuarios->Perfil->ReqErrMsg)) ?>");

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
fusuariosadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fusuariosadd.ValidateRequired = true;
<?php } else { ?>
fusuariosadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fusuariosadd.Lists["x_rol"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fusuariosadd.Lists["x_rol"].Options = <?php echo json_encode($usuarios->rol->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$usuarios_add->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $usuarios_add->ShowPageHeader(); ?>
<?php
$usuarios_add->ShowMessage();
?>
<form name="fusuariosadd" id="fusuariosadd" class="<?php echo $usuarios_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($usuarios_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $usuarios_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="usuarios">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($usuarios_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<!-- Fields to prevent google autofill -->
<input class="hidden" type="text" name="<?php echo ew_Encrypt(ew_Random()) ?>">
<input class="hidden" type="password" name="<?php echo ew_Encrypt(ew_Random()) ?>">
<div>
<?php if ($usuarios->usuario->Visible) { // usuario ?>
	<div id="r_usuario" class="form-group">
		<label id="elh_usuarios_usuario" for="x_usuario" class="col-sm-2 control-label ewLabel"><?php echo $usuarios->usuario->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $usuarios->usuario->CellAttributes() ?>>
<span id="el_usuarios_usuario">
<input type="text" data-table="usuarios" data-field="x_usuario" name="x_usuario" id="x_usuario" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($usuarios->usuario->getPlaceHolder()) ?>" value="<?php echo $usuarios->usuario->EditValue ?>"<?php echo $usuarios->usuario->EditAttributes() ?>>
</span>
<?php echo $usuarios->usuario->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($usuarios->password->Visible) { // password ?>
	<div id="r_password" class="form-group">
		<label id="elh_usuarios_password" for="x_password" class="col-sm-2 control-label ewLabel"><?php echo $usuarios->password->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $usuarios->password->CellAttributes() ?>>
<span id="el_usuarios_password">
<textarea data-table="usuarios" data-field="x_password" name="x_password" id="x_password" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($usuarios->password->getPlaceHolder()) ?>"<?php echo $usuarios->password->EditAttributes() ?>><?php echo $usuarios->password->EditValue ?></textarea>
</span>
<?php echo $usuarios->password->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($usuarios->_email->Visible) { // email ?>
	<div id="r__email" class="form-group">
		<label id="elh_usuarios__email" for="x__email" class="col-sm-2 control-label ewLabel"><?php echo $usuarios->_email->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $usuarios->_email->CellAttributes() ?>>
<span id="el_usuarios__email">
<textarea data-table="usuarios" data-field="x__email" name="x__email" id="x__email" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($usuarios->_email->getPlaceHolder()) ?>"<?php echo $usuarios->_email->EditAttributes() ?>><?php echo $usuarios->_email->EditValue ?></textarea>
</span>
<?php echo $usuarios->_email->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($usuarios->photo->Visible) { // photo ?>
	<div id="r_photo" class="form-group">
		<label id="elh_usuarios_photo" for="x_photo" class="col-sm-2 control-label ewLabel"><?php echo $usuarios->photo->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $usuarios->photo->CellAttributes() ?>>
<span id="el_usuarios_photo">
<textarea data-table="usuarios" data-field="x_photo" name="x_photo" id="x_photo" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($usuarios->photo->getPlaceHolder()) ?>"<?php echo $usuarios->photo->EditAttributes() ?>><?php echo $usuarios->photo->EditValue ?></textarea>
</span>
<?php echo $usuarios->photo->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($usuarios->rol->Visible) { // rol ?>
	<div id="r_rol" class="form-group">
		<label id="elh_usuarios_rol" for="x_rol" class="col-sm-2 control-label ewLabel"><?php echo $usuarios->rol->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $usuarios->rol->CellAttributes() ?>>
<?php if (!$Security->IsAdmin() && $Security->IsLoggedIn()) { // Non system admin ?>
<span id="el_usuarios_rol">
<select data-table="usuarios" data-field="x_rol" data-value-separator="<?php echo $usuarios->rol->DisplayValueSeparatorAttribute() ?>" id="x_rol" name="x_rol"<?php echo $usuarios->rol->EditAttributes() ?>>
<?php echo $usuarios->rol->SelectOptionListHtml("x_rol") ?>
</select>
</span>
<?php } elseif (!$Security->IsAdmin() && $Security->IsLoggedIn()) { // Non system admin ?>
<span id="el_usuarios_rol">
<p class="form-control-static"><?php echo $usuarios->rol->EditValue ?></p>
</span>
<?php } else { ?>
<span id="el_usuarios_rol">
<select data-table="usuarios" data-field="x_rol" data-value-separator="<?php echo $usuarios->rol->DisplayValueSeparatorAttribute() ?>" id="x_rol" name="x_rol"<?php echo $usuarios->rol->EditAttributes() ?>>
<?php echo $usuarios->rol->SelectOptionListHtml("x_rol") ?>
</select>
</span>
<?php } ?>
<?php echo $usuarios->rol->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($usuarios->intentos->Visible) { // intentos ?>
	<div id="r_intentos" class="form-group">
		<label id="elh_usuarios_intentos" for="x_intentos" class="col-sm-2 control-label ewLabel"><?php echo $usuarios->intentos->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $usuarios->intentos->CellAttributes() ?>>
<span id="el_usuarios_intentos">
<input type="text" data-table="usuarios" data-field="x_intentos" name="x_intentos" id="x_intentos" size="30" placeholder="<?php echo ew_HtmlEncode($usuarios->intentos->getPlaceHolder()) ?>" value="<?php echo $usuarios->intentos->EditValue ?>"<?php echo $usuarios->intentos->EditAttributes() ?>>
</span>
<?php echo $usuarios->intentos->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($usuarios->Activo->Visible) { // Activo ?>
	<div id="r_Activo" class="form-group">
		<label id="elh_usuarios_Activo" for="x_Activo" class="col-sm-2 control-label ewLabel"><?php echo $usuarios->Activo->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $usuarios->Activo->CellAttributes() ?>>
<span id="el_usuarios_Activo">
<input type="text" data-table="usuarios" data-field="x_Activo" name="x_Activo" id="x_Activo" size="30" placeholder="<?php echo ew_HtmlEncode($usuarios->Activo->getPlaceHolder()) ?>" value="<?php echo $usuarios->Activo->EditValue ?>"<?php echo $usuarios->Activo->EditAttributes() ?>>
</span>
<?php echo $usuarios->Activo->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($usuarios->Perfil->Visible) { // Perfil ?>
	<div id="r_Perfil" class="form-group">
		<label id="elh_usuarios_Perfil" for="x_Perfil" class="col-sm-2 control-label ewLabel"><?php echo $usuarios->Perfil->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $usuarios->Perfil->CellAttributes() ?>>
<span id="el_usuarios_Perfil">
<textarea data-table="usuarios" data-field="x_Perfil" name="x_Perfil" id="x_Perfil" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($usuarios->Perfil->getPlaceHolder()) ?>"<?php echo $usuarios->Perfil->EditAttributes() ?>><?php echo $usuarios->Perfil->EditValue ?></textarea>
</span>
<?php echo $usuarios->Perfil->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$usuarios_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $usuarios_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fusuariosadd.Init();
</script>
<?php
$usuarios_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$usuarios_add->Page_Terminate();
?>
