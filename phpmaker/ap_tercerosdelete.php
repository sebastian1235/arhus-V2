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

$ap_terceros_delete = NULL; // Initialize page object first

class cap_terceros_delete extends cap_terceros {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{6A9AC718-A824-45A3-BED3-A95E91E6986D}";

	// Table name
	var $TableName = 'ap_terceros';

	// Page object name
	var $PageObjName = 'ap_terceros_delete';

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
			define("EW_PAGE_ID", 'delete', TRUE);

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
		if (!$Security->CanDelete()) {
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
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->Id_tercero->SetVisibility();
		$this->Id_tercero->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
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
			header("Location: " . $url);
		}
		exit();
	}
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $TotalRecs = 0;
	var $RecCnt;
	var $RecKeys = array();
	var $Recordset;
	var $StartRowCnt = 1;
	var $RowCnt = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("ap_terceroslist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in ap_terceros class, ap_tercerosinfo.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} elseif (@$_GET["a_delete"] == "1") {
			$this->CurrentAction = "D"; // Delete record directly
		} else {
			$this->CurrentAction = "I"; // Display record
		}
		if ($this->CurrentAction == "D") {
			$this->SendEmail = TRUE; // Send email on delete success
			if ($this->DeleteRows()) { // Delete rows
				if ($this->getSuccessMessage() == "")
					$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
				$this->Page_Terminate($this->getReturnUrl()); // Return to caller
			} else { // Delete failed
				$this->CurrentAction = "I"; // Display record
			}
		}
		if ($this->CurrentAction == "I") { // Load records for display
			if ($this->Recordset = $this->LoadRecordset())
				$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
			if ($this->TotalRecs <= 0) { // No record found, exit
				if ($this->Recordset)
					$this->Recordset->Close();
				$this->Page_Terminate("ap_terceroslist.php"); // Return to list
			}
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {

		// Load List page SQL
		$sSql = $this->SelectSQL();
		$conn = &$this->Connection();

		// Load recordset
		$dbtype = ew_GetConnectionType($this->DBID);
		if ($this->UseSelectLimit) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			if ($dbtype == "MSSQL") {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset, array("_hasOrderBy" => trim($this->getOrderBy()) || trim($this->getSessionOrderBy())));
			} else {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset);
			}
			$conn->raiseErrorFn = '';
		} else {
			$rs = ew_LoadRecordset($sSql, $conn);
		}

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
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

			// Id_tercero
			$this->Id_tercero->LinkCustomAttributes = "";
			$this->Id_tercero->HrefValue = "";
			$this->Id_tercero->TooltipValue = "";

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
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $Language, $Security;
		if (!$Security->CanDelete()) {
			$this->setFailureMessage($Language->Phrase("NoDeletePermission")); // No delete permission
			return FALSE;
		}
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;

		//} else {
		//	$this->LoadRowValues($rs); // Load row values

		}
		$rows = ($rs) ? $rs->GetRows() : array();
		$conn->BeginTrans();

		// Clone old rows
		$rsold = $rows;
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $this->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['Id_tercero'];
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
			$conn->CommitTrans(); // Commit the changes
		} else {
			$conn->RollbackTrans(); // Rollback changes
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("ap_terceroslist.php"), "", $this->TableVar, TRUE);
		$PageId = "delete";
		$Breadcrumb->Add("delete", $PageId, $url);
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
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($ap_terceros_delete)) $ap_terceros_delete = new cap_terceros_delete();

// Page init
$ap_terceros_delete->Page_Init();

// Page main
$ap_terceros_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$ap_terceros_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fap_tercerosdelete = new ew_Form("fap_tercerosdelete", "delete");

// Form_CustomValidate event
fap_tercerosdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fap_tercerosdelete.ValidateRequired = true;
<?php } else { ?>
fap_tercerosdelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php $ap_terceros_delete->ShowPageHeader(); ?>
<?php
$ap_terceros_delete->ShowMessage();
?>
<form name="fap_tercerosdelete" id="fap_tercerosdelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($ap_terceros_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $ap_terceros_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="ap_terceros">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($ap_terceros_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable">
<?php echo $ap_terceros->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($ap_terceros->Id_tercero->Visible) { // Id_tercero ?>
		<th><span id="elh_ap_terceros_Id_tercero" class="ap_terceros_Id_tercero"><?php echo $ap_terceros->Id_tercero->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ap_terceros->nombre_tercero->Visible) { // nombre_tercero ?>
		<th><span id="elh_ap_terceros_nombre_tercero" class="ap_terceros_nombre_tercero"><?php echo $ap_terceros->nombre_tercero->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ap_terceros->direccion_tercero->Visible) { // direccion_tercero ?>
		<th><span id="elh_ap_terceros_direccion_tercero" class="ap_terceros_direccion_tercero"><?php echo $ap_terceros->direccion_tercero->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ap_terceros->telefono1_tercero->Visible) { // telefono1_tercero ?>
		<th><span id="elh_ap_terceros_telefono1_tercero" class="ap_terceros_telefono1_tercero"><?php echo $ap_terceros->telefono1_tercero->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ap_terceros->telefono2_tercero->Visible) { // telefono2_tercero ?>
		<th><span id="elh_ap_terceros_telefono2_tercero" class="ap_terceros_telefono2_tercero"><?php echo $ap_terceros->telefono2_tercero->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ap_terceros->fax_tercero->Visible) { // fax_tercero ?>
		<th><span id="elh_ap_terceros_fax_tercero" class="ap_terceros_fax_tercero"><?php echo $ap_terceros->fax_tercero->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ap_terceros->nit_tercero->Visible) { // nit_tercero ?>
		<th><span id="elh_ap_terceros_nit_tercero" class="ap_terceros_nit_tercero"><?php echo $ap_terceros->nit_tercero->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ap_terceros->tipo_tercero->Visible) { // tipo_tercero ?>
		<th><span id="elh_ap_terceros_tipo_tercero" class="ap_terceros_tipo_tercero"><?php echo $ap_terceros->tipo_tercero->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ap_terceros->e_mail_tercero->Visible) { // e_mail_tercero ?>
		<th><span id="elh_ap_terceros_e_mail_tercero" class="ap_terceros_e_mail_tercero"><?php echo $ap_terceros->e_mail_tercero->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ap_terceros->Contacto_tercero->Visible) { // Contacto_tercero ?>
		<th><span id="elh_ap_terceros_Contacto_tercero" class="ap_terceros_Contacto_tercero"><?php echo $ap_terceros->Contacto_tercero->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ap_terceros->gran_contrib_tercero->Visible) { // gran_contrib_tercero ?>
		<th><span id="elh_ap_terceros_gran_contrib_tercero" class="ap_terceros_gran_contrib_tercero"><?php echo $ap_terceros->gran_contrib_tercero->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ap_terceros->autoretenedor_tercero->Visible) { // autoretenedor_tercero ?>
		<th><span id="elh_ap_terceros_autoretenedor_tercero" class="ap_terceros_autoretenedor_tercero"><?php echo $ap_terceros->autoretenedor_tercero->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ap_terceros->activo_tercero->Visible) { // activo_tercero ?>
		<th><span id="elh_ap_terceros_activo_tercero" class="ap_terceros_activo_tercero"><?php echo $ap_terceros->activo_tercero->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ap_terceros->tercero__registrado_por->Visible) { // tercero_ registrado_por ?>
		<th><span id="elh_ap_terceros_tercero__registrado_por" class="ap_terceros_tercero__registrado_por"><?php echo $ap_terceros->tercero__registrado_por->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ap_terceros->reg_comun_tercero->Visible) { // reg_comun_tercero ?>
		<th><span id="elh_ap_terceros_reg_comun_tercero" class="ap_terceros_reg_comun_tercero"><?php echo $ap_terceros->reg_comun_tercero->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ap_terceros->responsable_materiales_tercero->Visible) { // responsable_materiales_tercero ?>
		<th><span id="elh_ap_terceros_responsable_materiales_tercero" class="ap_terceros_responsable_materiales_tercero"><?php echo $ap_terceros->responsable_materiales_tercero->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ap_terceros->grupo_nomina_tercero->Visible) { // grupo_nomina_tercero ?>
		<th><span id="elh_ap_terceros_grupo_nomina_tercero" class="ap_terceros_grupo_nomina_tercero"><?php echo $ap_terceros->grupo_nomina_tercero->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ap_terceros->tercero__lider_Obra->Visible) { // tercero_ lider_Obra ?>
		<th><span id="elh_ap_terceros_tercero__lider_Obra" class="ap_terceros_tercero__lider_Obra"><?php echo $ap_terceros->tercero__lider_Obra->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ap_terceros->tercero_nombre_lider->Visible) { // tercero_nombre_lider ?>
		<th><span id="elh_ap_terceros_tercero_nombre_lider" class="ap_terceros_tercero_nombre_lider"><?php echo $ap_terceros->tercero_nombre_lider->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ap_terceros->empresa_tercero->Visible) { // empresa_tercero ?>
		<th><span id="elh_ap_terceros_empresa_tercero" class="ap_terceros_empresa_tercero"><?php echo $ap_terceros->empresa_tercero->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$ap_terceros_delete->RecCnt = 0;
$i = 0;
while (!$ap_terceros_delete->Recordset->EOF) {
	$ap_terceros_delete->RecCnt++;
	$ap_terceros_delete->RowCnt++;

	// Set row properties
	$ap_terceros->ResetAttrs();
	$ap_terceros->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$ap_terceros_delete->LoadRowValues($ap_terceros_delete->Recordset);

	// Render row
	$ap_terceros_delete->RenderRow();
?>
	<tr<?php echo $ap_terceros->RowAttributes() ?>>
<?php if ($ap_terceros->Id_tercero->Visible) { // Id_tercero ?>
		<td<?php echo $ap_terceros->Id_tercero->CellAttributes() ?>>
<span id="el<?php echo $ap_terceros_delete->RowCnt ?>_ap_terceros_Id_tercero" class="ap_terceros_Id_tercero">
<span<?php echo $ap_terceros->Id_tercero->ViewAttributes() ?>>
<?php echo $ap_terceros->Id_tercero->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ap_terceros->nombre_tercero->Visible) { // nombre_tercero ?>
		<td<?php echo $ap_terceros->nombre_tercero->CellAttributes() ?>>
<span id="el<?php echo $ap_terceros_delete->RowCnt ?>_ap_terceros_nombre_tercero" class="ap_terceros_nombre_tercero">
<span<?php echo $ap_terceros->nombre_tercero->ViewAttributes() ?>>
<?php echo $ap_terceros->nombre_tercero->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ap_terceros->direccion_tercero->Visible) { // direccion_tercero ?>
		<td<?php echo $ap_terceros->direccion_tercero->CellAttributes() ?>>
<span id="el<?php echo $ap_terceros_delete->RowCnt ?>_ap_terceros_direccion_tercero" class="ap_terceros_direccion_tercero">
<span<?php echo $ap_terceros->direccion_tercero->ViewAttributes() ?>>
<?php echo $ap_terceros->direccion_tercero->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ap_terceros->telefono1_tercero->Visible) { // telefono1_tercero ?>
		<td<?php echo $ap_terceros->telefono1_tercero->CellAttributes() ?>>
<span id="el<?php echo $ap_terceros_delete->RowCnt ?>_ap_terceros_telefono1_tercero" class="ap_terceros_telefono1_tercero">
<span<?php echo $ap_terceros->telefono1_tercero->ViewAttributes() ?>>
<?php echo $ap_terceros->telefono1_tercero->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ap_terceros->telefono2_tercero->Visible) { // telefono2_tercero ?>
		<td<?php echo $ap_terceros->telefono2_tercero->CellAttributes() ?>>
<span id="el<?php echo $ap_terceros_delete->RowCnt ?>_ap_terceros_telefono2_tercero" class="ap_terceros_telefono2_tercero">
<span<?php echo $ap_terceros->telefono2_tercero->ViewAttributes() ?>>
<?php echo $ap_terceros->telefono2_tercero->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ap_terceros->fax_tercero->Visible) { // fax_tercero ?>
		<td<?php echo $ap_terceros->fax_tercero->CellAttributes() ?>>
<span id="el<?php echo $ap_terceros_delete->RowCnt ?>_ap_terceros_fax_tercero" class="ap_terceros_fax_tercero">
<span<?php echo $ap_terceros->fax_tercero->ViewAttributes() ?>>
<?php echo $ap_terceros->fax_tercero->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ap_terceros->nit_tercero->Visible) { // nit_tercero ?>
		<td<?php echo $ap_terceros->nit_tercero->CellAttributes() ?>>
<span id="el<?php echo $ap_terceros_delete->RowCnt ?>_ap_terceros_nit_tercero" class="ap_terceros_nit_tercero">
<span<?php echo $ap_terceros->nit_tercero->ViewAttributes() ?>>
<?php echo $ap_terceros->nit_tercero->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ap_terceros->tipo_tercero->Visible) { // tipo_tercero ?>
		<td<?php echo $ap_terceros->tipo_tercero->CellAttributes() ?>>
<span id="el<?php echo $ap_terceros_delete->RowCnt ?>_ap_terceros_tipo_tercero" class="ap_terceros_tipo_tercero">
<span<?php echo $ap_terceros->tipo_tercero->ViewAttributes() ?>>
<?php echo $ap_terceros->tipo_tercero->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ap_terceros->e_mail_tercero->Visible) { // e_mail_tercero ?>
		<td<?php echo $ap_terceros->e_mail_tercero->CellAttributes() ?>>
<span id="el<?php echo $ap_terceros_delete->RowCnt ?>_ap_terceros_e_mail_tercero" class="ap_terceros_e_mail_tercero">
<span<?php echo $ap_terceros->e_mail_tercero->ViewAttributes() ?>>
<?php echo $ap_terceros->e_mail_tercero->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ap_terceros->Contacto_tercero->Visible) { // Contacto_tercero ?>
		<td<?php echo $ap_terceros->Contacto_tercero->CellAttributes() ?>>
<span id="el<?php echo $ap_terceros_delete->RowCnt ?>_ap_terceros_Contacto_tercero" class="ap_terceros_Contacto_tercero">
<span<?php echo $ap_terceros->Contacto_tercero->ViewAttributes() ?>>
<?php echo $ap_terceros->Contacto_tercero->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ap_terceros->gran_contrib_tercero->Visible) { // gran_contrib_tercero ?>
		<td<?php echo $ap_terceros->gran_contrib_tercero->CellAttributes() ?>>
<span id="el<?php echo $ap_terceros_delete->RowCnt ?>_ap_terceros_gran_contrib_tercero" class="ap_terceros_gran_contrib_tercero">
<span<?php echo $ap_terceros->gran_contrib_tercero->ViewAttributes() ?>>
<?php echo $ap_terceros->gran_contrib_tercero->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ap_terceros->autoretenedor_tercero->Visible) { // autoretenedor_tercero ?>
		<td<?php echo $ap_terceros->autoretenedor_tercero->CellAttributes() ?>>
<span id="el<?php echo $ap_terceros_delete->RowCnt ?>_ap_terceros_autoretenedor_tercero" class="ap_terceros_autoretenedor_tercero">
<span<?php echo $ap_terceros->autoretenedor_tercero->ViewAttributes() ?>>
<?php echo $ap_terceros->autoretenedor_tercero->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ap_terceros->activo_tercero->Visible) { // activo_tercero ?>
		<td<?php echo $ap_terceros->activo_tercero->CellAttributes() ?>>
<span id="el<?php echo $ap_terceros_delete->RowCnt ?>_ap_terceros_activo_tercero" class="ap_terceros_activo_tercero">
<span<?php echo $ap_terceros->activo_tercero->ViewAttributes() ?>>
<?php echo $ap_terceros->activo_tercero->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ap_terceros->tercero__registrado_por->Visible) { // tercero_ registrado_por ?>
		<td<?php echo $ap_terceros->tercero__registrado_por->CellAttributes() ?>>
<span id="el<?php echo $ap_terceros_delete->RowCnt ?>_ap_terceros_tercero__registrado_por" class="ap_terceros_tercero__registrado_por">
<span<?php echo $ap_terceros->tercero__registrado_por->ViewAttributes() ?>>
<?php echo $ap_terceros->tercero__registrado_por->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ap_terceros->reg_comun_tercero->Visible) { // reg_comun_tercero ?>
		<td<?php echo $ap_terceros->reg_comun_tercero->CellAttributes() ?>>
<span id="el<?php echo $ap_terceros_delete->RowCnt ?>_ap_terceros_reg_comun_tercero" class="ap_terceros_reg_comun_tercero">
<span<?php echo $ap_terceros->reg_comun_tercero->ViewAttributes() ?>>
<?php echo $ap_terceros->reg_comun_tercero->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ap_terceros->responsable_materiales_tercero->Visible) { // responsable_materiales_tercero ?>
		<td<?php echo $ap_terceros->responsable_materiales_tercero->CellAttributes() ?>>
<span id="el<?php echo $ap_terceros_delete->RowCnt ?>_ap_terceros_responsable_materiales_tercero" class="ap_terceros_responsable_materiales_tercero">
<span<?php echo $ap_terceros->responsable_materiales_tercero->ViewAttributes() ?>>
<?php echo $ap_terceros->responsable_materiales_tercero->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ap_terceros->grupo_nomina_tercero->Visible) { // grupo_nomina_tercero ?>
		<td<?php echo $ap_terceros->grupo_nomina_tercero->CellAttributes() ?>>
<span id="el<?php echo $ap_terceros_delete->RowCnt ?>_ap_terceros_grupo_nomina_tercero" class="ap_terceros_grupo_nomina_tercero">
<span<?php echo $ap_terceros->grupo_nomina_tercero->ViewAttributes() ?>>
<?php echo $ap_terceros->grupo_nomina_tercero->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ap_terceros->tercero__lider_Obra->Visible) { // tercero_ lider_Obra ?>
		<td<?php echo $ap_terceros->tercero__lider_Obra->CellAttributes() ?>>
<span id="el<?php echo $ap_terceros_delete->RowCnt ?>_ap_terceros_tercero__lider_Obra" class="ap_terceros_tercero__lider_Obra">
<span<?php echo $ap_terceros->tercero__lider_Obra->ViewAttributes() ?>>
<?php echo $ap_terceros->tercero__lider_Obra->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ap_terceros->tercero_nombre_lider->Visible) { // tercero_nombre_lider ?>
		<td<?php echo $ap_terceros->tercero_nombre_lider->CellAttributes() ?>>
<span id="el<?php echo $ap_terceros_delete->RowCnt ?>_ap_terceros_tercero_nombre_lider" class="ap_terceros_tercero_nombre_lider">
<span<?php echo $ap_terceros->tercero_nombre_lider->ViewAttributes() ?>>
<?php echo $ap_terceros->tercero_nombre_lider->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ap_terceros->empresa_tercero->Visible) { // empresa_tercero ?>
		<td<?php echo $ap_terceros->empresa_tercero->CellAttributes() ?>>
<span id="el<?php echo $ap_terceros_delete->RowCnt ?>_ap_terceros_empresa_tercero" class="ap_terceros_empresa_tercero">
<span<?php echo $ap_terceros->empresa_tercero->ViewAttributes() ?>>
<?php echo $ap_terceros->empresa_tercero->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$ap_terceros_delete->Recordset->MoveNext();
}
$ap_terceros_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $ap_terceros_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fap_tercerosdelete.Init();
</script>
<?php
$ap_terceros_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$ap_terceros_delete->Page_Terminate();
?>
