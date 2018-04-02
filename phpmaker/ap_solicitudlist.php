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

$ap_solicitud_list = NULL; // Initialize page object first

class cap_solicitud_list extends cap_solicitud {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{6A9AC718-A824-45A3-BED3-A95E91E6986D}";

	// Table name
	var $TableName = 'ap_solicitud';

	// Page object name
	var $PageObjName = 'ap_solicitud_list';

	// Grid form hidden field names
	var $FormName = 'fap_solicitudlist';
	var $FormActionName = 'k_action';
	var $FormKeyName = 'k_key';
	var $FormOldKeyName = 'k_oldkey';
	var $FormBlankRowName = 'k_blankrow';
	var $FormKeyCountName = 'key_count';

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

	// Page URLs
	var $AddUrl;
	var $EditUrl;
	var $CopyUrl;
	var $DeleteUrl;
	var $ViewUrl;
	var $ListUrl;

	// Export URLs
	var $ExportPrintUrl;
	var $ExportHtmlUrl;
	var $ExportExcelUrl;
	var $ExportWordUrl;
	var $ExportXmlUrl;
	var $ExportCsvUrl;
	var $ExportPdfUrl;

	// Custom export
	var $ExportExcelCustom = FALSE;
	var $ExportWordCustom = FALSE;
	var $ExportPdfCustom = FALSE;
	var $ExportEmailCustom = FALSE;

	// Update URLs
	var $InlineAddUrl;
	var $InlineCopyUrl;
	var $InlineEditUrl;
	var $GridAddUrl;
	var $GridEditUrl;
	var $MultiDeleteUrl;
	var $MultiUpdateUrl;

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

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "ap_solicitudadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "ap_solicituddelete.php";
		$this->MultiUpdateUrl = "ap_solicitudupdate.php";

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

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

		// List options
		$this->ListOptions = new cListOptions();
		$this->ListOptions->TableVar = $this->TableVar;

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['addedit'] = new cListOptions();
		$this->OtherOptions['addedit']->Tag = "div";
		$this->OtherOptions['addedit']->TagClassName = "ewAddEditOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "div";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "div";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";

		// Filter options
		$this->FilterOptions = new cListOptions();
		$this->FilterOptions->Tag = "div";
		$this->FilterOptions->TagClassName = "ewFilterOption fap_solicitudlistsrch";

		// List actions
		$this->ListActions = new cListActions();
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
		if (!$Security->CanList()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			$this->Page_Terminate(ew_GetUrl("index.php"));
		}
		if ($Security->IsLoggedIn()) {
			$Security->UserID_Loading();
			$Security->LoadUserID();
			$Security->UserID_Loaded();
		}

		// Get export parameters
		$custom = "";
		if (@$_GET["export"] <> "") {
			$this->Export = $_GET["export"];
			$custom = @$_GET["custom"];
		} elseif (@$_POST["export"] <> "") {
			$this->Export = $_POST["export"];
			$custom = @$_POST["custom"];
		} elseif (ew_IsHttpPost()) {
			if (@$_POST["exporttype"] <> "")
				$this->Export = $_POST["exporttype"];
			$custom = @$_POST["custom"];
		} else {
			$this->setExportReturnUrl(ew_CurrentUrl());
		}
		$gsExportFile = $this->TableVar; // Get export file, used in header

		// Get custom export parameters
		if ($this->Export <> "" && $custom <> "") {
			$this->CustomExport = $this->Export;
			$this->Export = "print";
		}
		$gsCustomExport = $this->CustomExport;
		$gsExport = $this->Export; // Get export parameter, used in header

		// Update Export URLs
		if (defined("EW_USE_PHPEXCEL"))
			$this->ExportExcelCustom = FALSE;
		if ($this->ExportExcelCustom)
			$this->ExportExcelUrl .= "&amp;custom=1";
		if (defined("EW_USE_PHPWORD"))
			$this->ExportWordCustom = FALSE;
		if ($this->ExportWordCustom)
			$this->ExportWordUrl .= "&amp;custom=1";
		if ($this->ExportPdfCustom)
			$this->ExportPdfUrl .= "&amp;custom=1";
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$this->GridAddRowCount = $gridaddcnt;

		// Set up list options
		$this->SetupListOptions();

		// Setup export options
		$this->SetupExportOptions();
		$this->id_sol->SetVisibility();
		$this->id_sol->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->poliza_sol->SetVisibility();
		$this->demanda_sol->SetVisibility();
		$this->asesor_sol->SetVisibility();
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
		$this->servicio_sol->SetVisibility();
		$this->obs_sol->SetVisibility();
		$this->estado_sol->SetVisibility();
		$this->fecha_prevista_sol->SetVisibility();
		$this->fecha_obra_sol->SetVisibility();
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

		// Setup other options
		$this->SetupOtherOptions();

		// Set up custom action (compatible with old version)
		foreach ($this->CustomActions as $name => $action)
			$this->ListActions->Add($name, $action);

		// Show checkbox column if multiple action
		foreach ($this->ListActions->Items as $listaction) {
			if ($listaction->Select == EW_ACTION_MULTIPLE && $listaction->Allow) {
				$this->ListOptions->Items["checkbox"]->Visible = TRUE;
				break;
			}
		}
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
			header("Location: " . $url);
		}
		exit();
	}

	// Class variables
	var $ListOptions; // List options
	var $ExportOptions; // Export options
	var $SearchOptions; // Search options
	var $OtherOptions = array(); // Other options
	var $FilterOptions; // Filter options
	var $ListActions; // List actions
	var $SelectedCount = 0;
	var $SelectedIndex = 0;
	var $DisplayRecs = 15;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $Pager;
	var $DefaultSearchWhere = ""; // Default search WHERE clause
	var $SearchWhere = ""; // Search WHERE clause
	var $RecCnt = 0; // Record count
	var $EditRowCnt;
	var $StartRowCnt = 1;
	var $RowCnt = 0;
	var $Attrs = array(); // Row attributes and cell attributes
	var $RowIndex = 0; // Row index
	var $KeyCount = 0; // Key count
	var $RowAction = ""; // Row action
	var $RowOldKey = ""; // Row old key (for copy)
	var $RecPerRow = 0;
	var $MultiColumnClass;
	var $MultiColumnEditClass = "col-sm-12";
	var $MultiColumnCnt = 12;
	var $MultiColumnEditCnt = 12;
	var $GridCnt = 0;
	var $ColCnt = 0;
	var $DbMasterFilter = ""; // Master filter
	var $DbDetailFilter = ""; // Detail filter
	var $MasterRecordExists;	
	var $MultiSelectKey;
	var $Command;
	var $RestoreSearch = FALSE;
	var $DetailPages;
	var $Recordset;
	var $OldRecordset;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $gsSearchError, $Security;

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";

		// Get command
		$this->Command = strtolower(@$_GET["cmd"]);
		if ($this->IsPageRequest()) { // Validate request

			// Process list action first
			if ($this->ProcessListAction()) // Ajax request
				$this->Page_Terminate();

			// Handle reset command
			$this->ResetCmd();

			// Set up Breadcrumb
			if ($this->Export == "")
				$this->SetupBreadcrumb();

			// Hide list options
			if ($this->Export <> "") {
				$this->ListOptions->HideAllOptions(array("sequence"));
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			} elseif ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
				$this->ListOptions->HideAllOptions();
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			}

			// Hide options
			if ($this->Export <> "" || $this->CurrentAction <> "") {
				$this->ExportOptions->HideAllOptions();
				$this->FilterOptions->HideAllOptions();
			}

			// Hide other options
			if ($this->Export <> "") {
				foreach ($this->OtherOptions as &$option)
					$option->HideAllOptions();
			}

			// Get default search criteria
			ew_AddFilter($this->DefaultSearchWhere, $this->BasicSearchWhere(TRUE));

			// Get basic search values
			$this->LoadBasicSearchValues();

			// Process filter list
			$this->ProcessFilterList();

			// Restore search parms from Session if not searching / reset / export
			if (($this->Export <> "" || $this->Command <> "search" && $this->Command <> "reset" && $this->Command <> "resetall") && $this->CheckSearchParms())
				$this->RestoreSearchParms();

			// Call Recordset SearchValidated event
			$this->Recordset_SearchValidated();

			// Set up sorting order
			$this->SetUpSortOrder();

			// Get basic search criteria
			if ($gsSearchError == "")
				$sSrchBasic = $this->BasicSearchWhere();
		}

		// Restore display records
		if ($this->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $this->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 15; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Load search default if no existing search criteria
		if (!$this->CheckSearchParms()) {

			// Load basic search from default
			$this->BasicSearch->LoadDefault();
			if ($this->BasicSearch->Keyword != "")
				$sSrchBasic = $this->BasicSearchWhere();
		}

		// Build search criteria
		ew_AddFilter($this->SearchWhere, $sSrchAdvanced);
		ew_AddFilter($this->SearchWhere, $sSrchBasic);

		// Call Recordset_Searching event
		$this->Recordset_Searching($this->SearchWhere);

		// Save search criteria
		if ($this->Command == "search" && !$this->RestoreSearch) {
			$this->setSearchWhere($this->SearchWhere); // Save to Session
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} else {
			$this->SearchWhere = $this->getSearchWhere();
		}

		// Build filter
		$sFilter = "";
		if (!$Security->CanList())
			$sFilter = "(0=1)"; // Filter all records
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Set up filter in session
		$this->setSessionWhere($sFilter);
		$this->CurrentFilter = "";

		// Export selected records
		if ($this->Export <> "")
			$this->CurrentFilter = $this->BuildExportSelectedFilter();

		// Load record count first
		if (!$this->IsAddOrEdit()) {
			$bSelectLimit = $this->UseSelectLimit;
			if ($bSelectLimit) {
				$this->TotalRecs = $this->SelectRecordCount();
			} else {
				if ($this->Recordset = $this->LoadRecordset())
					$this->TotalRecs = $this->Recordset->RecordCount();
			}
		}

		// Search options
		$this->SetupSearchOptions();
	}

	// Build filter for all keys
	function BuildKeyFilter() {
		global $objForm;
		$sWrkFilter = "";

		// Update row index and get row key
		$rowindex = 1;
		$objForm->Index = $rowindex;
		$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		while ($sThisKey <> "") {
			if ($this->SetupKeyValues($sThisKey)) {
				$sFilter = $this->KeyFilter();
				if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
				$sWrkFilter .= $sFilter;
			} else {
				$sWrkFilter = "0=1";
				break;
			}

			// Update row index and get row key
			$rowindex++; // Next row
			$objForm->Index = $rowindex;
			$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		}
		return $sWrkFilter;
	}

	// Set up key values
	function SetupKeyValues($key) {
		$arrKeyFlds = explode($GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"], $key);
		if (count($arrKeyFlds) >= 1) {
			$this->id_sol->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->id_sol->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Get list of filters
	function GetFilterList() {
		global $UserProfile;

		// Load server side filters
		if (EW_SEARCH_FILTER_OPTION == "Server") {
			$sSavedFilterList = $UserProfile->GetSearchFilters(CurrentUserName(), "fap_solicitudlistsrch");
		} else {
			$sSavedFilterList = "";
		}

		// Initialize
		$sFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->id_sol->AdvancedSearch->ToJSON(), ","); // Field id_sol
		$sFilterList = ew_Concat($sFilterList, $this->poliza_sol->AdvancedSearch->ToJSON(), ","); // Field poliza_sol
		$sFilterList = ew_Concat($sFilterList, $this->demanda_sol->AdvancedSearch->ToJSON(), ","); // Field demanda_sol
		$sFilterList = ew_Concat($sFilterList, $this->asesor_sol->AdvancedSearch->ToJSON(), ","); // Field asesor_sol
		$sFilterList = ew_Concat($sFilterList, $this->archivos_sol->AdvancedSearch->ToJSON(), ","); // Field archivos_sol
		$sFilterList = ew_Concat($sFilterList, $this->asignacion_sol->AdvancedSearch->ToJSON(), ","); // Field asignacion_sol
		$sFilterList = ew_Concat($sFilterList, $this->cedula_sol->AdvancedSearch->ToJSON(), ","); // Field cedula_sol
		$sFilterList = ew_Concat($sFilterList, $this->nombre_sol->AdvancedSearch->ToJSON(), ","); // Field nombre_sol
		$sFilterList = ew_Concat($sFilterList, $this->direccion_pol_sol->AdvancedSearch->ToJSON(), ","); // Field direccion_pol_sol
		$sFilterList = ew_Concat($sFilterList, $this->direccion_nueva_sol->AdvancedSearch->ToJSON(), ","); // Field direccion_nueva_sol
		$sFilterList = ew_Concat($sFilterList, $this->localidad_sol->AdvancedSearch->ToJSON(), ","); // Field localidad_sol
		$sFilterList = ew_Concat($sFilterList, $this->barrio_sol->AdvancedSearch->ToJSON(), ","); // Field barrio_sol
		$sFilterList = ew_Concat($sFilterList, $this->telefono1_sol->AdvancedSearch->ToJSON(), ","); // Field telefono1_sol
		$sFilterList = ew_Concat($sFilterList, $this->telefono2_sol->AdvancedSearch->ToJSON(), ","); // Field telefono2_sol
		$sFilterList = ew_Concat($sFilterList, $this->celular_sol->AdvancedSearch->ToJSON(), ","); // Field celular_sol
		$sFilterList = ew_Concat($sFilterList, $this->email_sol->AdvancedSearch->ToJSON(), ","); // Field email_sol
		$sFilterList = ew_Concat($sFilterList, $this->servicio_sol->AdvancedSearch->ToJSON(), ","); // Field servicio_sol
		$sFilterList = ew_Concat($sFilterList, $this->texto_sol->AdvancedSearch->ToJSON(), ","); // Field texto_sol
		$sFilterList = ew_Concat($sFilterList, $this->registra_sol->AdvancedSearch->ToJSON(), ","); // Field registra_sol
		$sFilterList = ew_Concat($sFilterList, $this->tipo_clientegn_sol->AdvancedSearch->ToJSON(), ","); // Field tipo_clientegn_sol
		$sFilterList = ew_Concat($sFilterList, $this->unidad_sol->AdvancedSearch->ToJSON(), ","); // Field unidad_sol
		$sFilterList = ew_Concat($sFilterList, $this->fecha_reg_sol->AdvancedSearch->ToJSON(), ","); // Field fecha_reg_sol
		$sFilterList = ew_Concat($sFilterList, $this->obs_sol->AdvancedSearch->ToJSON(), ","); // Field obs_sol
		$sFilterList = ew_Concat($sFilterList, $this->empresa_sol->AdvancedSearch->ToJSON(), ","); // Field empresa_sol
		$sFilterList = ew_Concat($sFilterList, $this->estado_sol->AdvancedSearch->ToJSON(), ","); // Field estado_sol
		$sFilterList = ew_Concat($sFilterList, $this->fecha_prevista_sol->AdvancedSearch->ToJSON(), ","); // Field fecha_prevista_sol
		$sFilterList = ew_Concat($sFilterList, $this->user_preventa_sol->AdvancedSearch->ToJSON(), ","); // Field user_preventa_sol
		$sFilterList = ew_Concat($sFilterList, $this->quincena_obra_sol->AdvancedSearch->ToJSON(), ","); // Field quincena_obra_sol
		$sFilterList = ew_Concat($sFilterList, $this->fecha_obra_sol->AdvancedSearch->ToJSON(), ","); // Field fecha_obra_sol
		$sFilterList = ew_Concat($sFilterList, $this->nombre_tecnico_sol->AdvancedSearch->ToJSON(), ","); // Field nombre_tecnico_sol
		$sFilterList = ew_Concat($sFilterList, $this->cod_tecnico_sol->AdvancedSearch->ToJSON(), ","); // Field cod_tecnico_sol
		$sFilterList = ew_Concat($sFilterList, $this->lider_obra_sol->AdvancedSearch->ToJSON(), ","); // Field lider_obra_sol
		$sFilterList = ew_Concat($sFilterList, $this->fecha_visita_comerc_sol->AdvancedSearch->ToJSON(), ","); // Field fecha_visita_comerc_sol
		$sFilterList = ew_Concat($sFilterList, $this->obs_estado_sol->AdvancedSearch->ToJSON(), ","); // Field obs_estado_sol
		$sFilterList = ew_Concat($sFilterList, $this->forma_pagogn_sol->AdvancedSearch->ToJSON(), ","); // Field forma_pagogn_sol
		if ($this->BasicSearch->Keyword <> "") {
			$sWrk = "\"" . EW_TABLE_BASIC_SEARCH . "\":\"" . ew_JsEncode2($this->BasicSearch->Keyword) . "\",\"" . EW_TABLE_BASIC_SEARCH_TYPE . "\":\"" . ew_JsEncode2($this->BasicSearch->Type) . "\"";
			$sFilterList = ew_Concat($sFilterList, $sWrk, ",");
		}
		$sFilterList = preg_replace('/,$/', "", $sFilterList);

		// Return filter list in json
		if ($sFilterList <> "")
			$sFilterList = "\"data\":{" . $sFilterList . "}";
		if ($sSavedFilterList <> "") {
			if ($sFilterList <> "")
				$sFilterList .= ",";
			$sFilterList .= "\"filters\":" . $sSavedFilterList;
		}
		return ($sFilterList <> "") ? "{" . $sFilterList . "}" : "null";
	}

	// Process filter list
	function ProcessFilterList() {
		global $UserProfile;
		if (@$_POST["cmd"] == "savefilters") {
			$filters = ew_StripSlashes(@$_POST["filters"]);
			$UserProfile->SetSearchFilters(CurrentUserName(), "fap_solicitudlistsrch", $filters);
		} elseif (@$_POST["cmd"] == "resetfilter") {
			$this->RestoreFilterList();
		}
	}

	// Restore list of filters
	function RestoreFilterList() {

		// Return if not reset filter
		if (@$_POST["cmd"] <> "resetfilter")
			return FALSE;
		$filter = json_decode(ew_StripSlashes(@$_POST["filter"]), TRUE);
		$this->Command = "search";

		// Field id_sol
		$this->id_sol->AdvancedSearch->SearchValue = @$filter["x_id_sol"];
		$this->id_sol->AdvancedSearch->SearchOperator = @$filter["z_id_sol"];
		$this->id_sol->AdvancedSearch->SearchCondition = @$filter["v_id_sol"];
		$this->id_sol->AdvancedSearch->SearchValue2 = @$filter["y_id_sol"];
		$this->id_sol->AdvancedSearch->SearchOperator2 = @$filter["w_id_sol"];
		$this->id_sol->AdvancedSearch->Save();

		// Field poliza_sol
		$this->poliza_sol->AdvancedSearch->SearchValue = @$filter["x_poliza_sol"];
		$this->poliza_sol->AdvancedSearch->SearchOperator = @$filter["z_poliza_sol"];
		$this->poliza_sol->AdvancedSearch->SearchCondition = @$filter["v_poliza_sol"];
		$this->poliza_sol->AdvancedSearch->SearchValue2 = @$filter["y_poliza_sol"];
		$this->poliza_sol->AdvancedSearch->SearchOperator2 = @$filter["w_poliza_sol"];
		$this->poliza_sol->AdvancedSearch->Save();

		// Field demanda_sol
		$this->demanda_sol->AdvancedSearch->SearchValue = @$filter["x_demanda_sol"];
		$this->demanda_sol->AdvancedSearch->SearchOperator = @$filter["z_demanda_sol"];
		$this->demanda_sol->AdvancedSearch->SearchCondition = @$filter["v_demanda_sol"];
		$this->demanda_sol->AdvancedSearch->SearchValue2 = @$filter["y_demanda_sol"];
		$this->demanda_sol->AdvancedSearch->SearchOperator2 = @$filter["w_demanda_sol"];
		$this->demanda_sol->AdvancedSearch->Save();

		// Field asesor_sol
		$this->asesor_sol->AdvancedSearch->SearchValue = @$filter["x_asesor_sol"];
		$this->asesor_sol->AdvancedSearch->SearchOperator = @$filter["z_asesor_sol"];
		$this->asesor_sol->AdvancedSearch->SearchCondition = @$filter["v_asesor_sol"];
		$this->asesor_sol->AdvancedSearch->SearchValue2 = @$filter["y_asesor_sol"];
		$this->asesor_sol->AdvancedSearch->SearchOperator2 = @$filter["w_asesor_sol"];
		$this->asesor_sol->AdvancedSearch->Save();

		// Field archivos_sol
		$this->archivos_sol->AdvancedSearch->SearchValue = @$filter["x_archivos_sol"];
		$this->archivos_sol->AdvancedSearch->SearchOperator = @$filter["z_archivos_sol"];
		$this->archivos_sol->AdvancedSearch->SearchCondition = @$filter["v_archivos_sol"];
		$this->archivos_sol->AdvancedSearch->SearchValue2 = @$filter["y_archivos_sol"];
		$this->archivos_sol->AdvancedSearch->SearchOperator2 = @$filter["w_archivos_sol"];
		$this->archivos_sol->AdvancedSearch->Save();

		// Field asignacion_sol
		$this->asignacion_sol->AdvancedSearch->SearchValue = @$filter["x_asignacion_sol"];
		$this->asignacion_sol->AdvancedSearch->SearchOperator = @$filter["z_asignacion_sol"];
		$this->asignacion_sol->AdvancedSearch->SearchCondition = @$filter["v_asignacion_sol"];
		$this->asignacion_sol->AdvancedSearch->SearchValue2 = @$filter["y_asignacion_sol"];
		$this->asignacion_sol->AdvancedSearch->SearchOperator2 = @$filter["w_asignacion_sol"];
		$this->asignacion_sol->AdvancedSearch->Save();

		// Field cedula_sol
		$this->cedula_sol->AdvancedSearch->SearchValue = @$filter["x_cedula_sol"];
		$this->cedula_sol->AdvancedSearch->SearchOperator = @$filter["z_cedula_sol"];
		$this->cedula_sol->AdvancedSearch->SearchCondition = @$filter["v_cedula_sol"];
		$this->cedula_sol->AdvancedSearch->SearchValue2 = @$filter["y_cedula_sol"];
		$this->cedula_sol->AdvancedSearch->SearchOperator2 = @$filter["w_cedula_sol"];
		$this->cedula_sol->AdvancedSearch->Save();

		// Field nombre_sol
		$this->nombre_sol->AdvancedSearch->SearchValue = @$filter["x_nombre_sol"];
		$this->nombre_sol->AdvancedSearch->SearchOperator = @$filter["z_nombre_sol"];
		$this->nombre_sol->AdvancedSearch->SearchCondition = @$filter["v_nombre_sol"];
		$this->nombre_sol->AdvancedSearch->SearchValue2 = @$filter["y_nombre_sol"];
		$this->nombre_sol->AdvancedSearch->SearchOperator2 = @$filter["w_nombre_sol"];
		$this->nombre_sol->AdvancedSearch->Save();

		// Field direccion_pol_sol
		$this->direccion_pol_sol->AdvancedSearch->SearchValue = @$filter["x_direccion_pol_sol"];
		$this->direccion_pol_sol->AdvancedSearch->SearchOperator = @$filter["z_direccion_pol_sol"];
		$this->direccion_pol_sol->AdvancedSearch->SearchCondition = @$filter["v_direccion_pol_sol"];
		$this->direccion_pol_sol->AdvancedSearch->SearchValue2 = @$filter["y_direccion_pol_sol"];
		$this->direccion_pol_sol->AdvancedSearch->SearchOperator2 = @$filter["w_direccion_pol_sol"];
		$this->direccion_pol_sol->AdvancedSearch->Save();

		// Field direccion_nueva_sol
		$this->direccion_nueva_sol->AdvancedSearch->SearchValue = @$filter["x_direccion_nueva_sol"];
		$this->direccion_nueva_sol->AdvancedSearch->SearchOperator = @$filter["z_direccion_nueva_sol"];
		$this->direccion_nueva_sol->AdvancedSearch->SearchCondition = @$filter["v_direccion_nueva_sol"];
		$this->direccion_nueva_sol->AdvancedSearch->SearchValue2 = @$filter["y_direccion_nueva_sol"];
		$this->direccion_nueva_sol->AdvancedSearch->SearchOperator2 = @$filter["w_direccion_nueva_sol"];
		$this->direccion_nueva_sol->AdvancedSearch->Save();

		// Field localidad_sol
		$this->localidad_sol->AdvancedSearch->SearchValue = @$filter["x_localidad_sol"];
		$this->localidad_sol->AdvancedSearch->SearchOperator = @$filter["z_localidad_sol"];
		$this->localidad_sol->AdvancedSearch->SearchCondition = @$filter["v_localidad_sol"];
		$this->localidad_sol->AdvancedSearch->SearchValue2 = @$filter["y_localidad_sol"];
		$this->localidad_sol->AdvancedSearch->SearchOperator2 = @$filter["w_localidad_sol"];
		$this->localidad_sol->AdvancedSearch->Save();

		// Field barrio_sol
		$this->barrio_sol->AdvancedSearch->SearchValue = @$filter["x_barrio_sol"];
		$this->barrio_sol->AdvancedSearch->SearchOperator = @$filter["z_barrio_sol"];
		$this->barrio_sol->AdvancedSearch->SearchCondition = @$filter["v_barrio_sol"];
		$this->barrio_sol->AdvancedSearch->SearchValue2 = @$filter["y_barrio_sol"];
		$this->barrio_sol->AdvancedSearch->SearchOperator2 = @$filter["w_barrio_sol"];
		$this->barrio_sol->AdvancedSearch->Save();

		// Field telefono1_sol
		$this->telefono1_sol->AdvancedSearch->SearchValue = @$filter["x_telefono1_sol"];
		$this->telefono1_sol->AdvancedSearch->SearchOperator = @$filter["z_telefono1_sol"];
		$this->telefono1_sol->AdvancedSearch->SearchCondition = @$filter["v_telefono1_sol"];
		$this->telefono1_sol->AdvancedSearch->SearchValue2 = @$filter["y_telefono1_sol"];
		$this->telefono1_sol->AdvancedSearch->SearchOperator2 = @$filter["w_telefono1_sol"];
		$this->telefono1_sol->AdvancedSearch->Save();

		// Field telefono2_sol
		$this->telefono2_sol->AdvancedSearch->SearchValue = @$filter["x_telefono2_sol"];
		$this->telefono2_sol->AdvancedSearch->SearchOperator = @$filter["z_telefono2_sol"];
		$this->telefono2_sol->AdvancedSearch->SearchCondition = @$filter["v_telefono2_sol"];
		$this->telefono2_sol->AdvancedSearch->SearchValue2 = @$filter["y_telefono2_sol"];
		$this->telefono2_sol->AdvancedSearch->SearchOperator2 = @$filter["w_telefono2_sol"];
		$this->telefono2_sol->AdvancedSearch->Save();

		// Field celular_sol
		$this->celular_sol->AdvancedSearch->SearchValue = @$filter["x_celular_sol"];
		$this->celular_sol->AdvancedSearch->SearchOperator = @$filter["z_celular_sol"];
		$this->celular_sol->AdvancedSearch->SearchCondition = @$filter["v_celular_sol"];
		$this->celular_sol->AdvancedSearch->SearchValue2 = @$filter["y_celular_sol"];
		$this->celular_sol->AdvancedSearch->SearchOperator2 = @$filter["w_celular_sol"];
		$this->celular_sol->AdvancedSearch->Save();

		// Field email_sol
		$this->email_sol->AdvancedSearch->SearchValue = @$filter["x_email_sol"];
		$this->email_sol->AdvancedSearch->SearchOperator = @$filter["z_email_sol"];
		$this->email_sol->AdvancedSearch->SearchCondition = @$filter["v_email_sol"];
		$this->email_sol->AdvancedSearch->SearchValue2 = @$filter["y_email_sol"];
		$this->email_sol->AdvancedSearch->SearchOperator2 = @$filter["w_email_sol"];
		$this->email_sol->AdvancedSearch->Save();

		// Field servicio_sol
		$this->servicio_sol->AdvancedSearch->SearchValue = @$filter["x_servicio_sol"];
		$this->servicio_sol->AdvancedSearch->SearchOperator = @$filter["z_servicio_sol"];
		$this->servicio_sol->AdvancedSearch->SearchCondition = @$filter["v_servicio_sol"];
		$this->servicio_sol->AdvancedSearch->SearchValue2 = @$filter["y_servicio_sol"];
		$this->servicio_sol->AdvancedSearch->SearchOperator2 = @$filter["w_servicio_sol"];
		$this->servicio_sol->AdvancedSearch->Save();

		// Field texto_sol
		$this->texto_sol->AdvancedSearch->SearchValue = @$filter["x_texto_sol"];
		$this->texto_sol->AdvancedSearch->SearchOperator = @$filter["z_texto_sol"];
		$this->texto_sol->AdvancedSearch->SearchCondition = @$filter["v_texto_sol"];
		$this->texto_sol->AdvancedSearch->SearchValue2 = @$filter["y_texto_sol"];
		$this->texto_sol->AdvancedSearch->SearchOperator2 = @$filter["w_texto_sol"];
		$this->texto_sol->AdvancedSearch->Save();

		// Field registra_sol
		$this->registra_sol->AdvancedSearch->SearchValue = @$filter["x_registra_sol"];
		$this->registra_sol->AdvancedSearch->SearchOperator = @$filter["z_registra_sol"];
		$this->registra_sol->AdvancedSearch->SearchCondition = @$filter["v_registra_sol"];
		$this->registra_sol->AdvancedSearch->SearchValue2 = @$filter["y_registra_sol"];
		$this->registra_sol->AdvancedSearch->SearchOperator2 = @$filter["w_registra_sol"];
		$this->registra_sol->AdvancedSearch->Save();

		// Field tipo_clientegn_sol
		$this->tipo_clientegn_sol->AdvancedSearch->SearchValue = @$filter["x_tipo_clientegn_sol"];
		$this->tipo_clientegn_sol->AdvancedSearch->SearchOperator = @$filter["z_tipo_clientegn_sol"];
		$this->tipo_clientegn_sol->AdvancedSearch->SearchCondition = @$filter["v_tipo_clientegn_sol"];
		$this->tipo_clientegn_sol->AdvancedSearch->SearchValue2 = @$filter["y_tipo_clientegn_sol"];
		$this->tipo_clientegn_sol->AdvancedSearch->SearchOperator2 = @$filter["w_tipo_clientegn_sol"];
		$this->tipo_clientegn_sol->AdvancedSearch->Save();

		// Field unidad_sol
		$this->unidad_sol->AdvancedSearch->SearchValue = @$filter["x_unidad_sol"];
		$this->unidad_sol->AdvancedSearch->SearchOperator = @$filter["z_unidad_sol"];
		$this->unidad_sol->AdvancedSearch->SearchCondition = @$filter["v_unidad_sol"];
		$this->unidad_sol->AdvancedSearch->SearchValue2 = @$filter["y_unidad_sol"];
		$this->unidad_sol->AdvancedSearch->SearchOperator2 = @$filter["w_unidad_sol"];
		$this->unidad_sol->AdvancedSearch->Save();

		// Field fecha_reg_sol
		$this->fecha_reg_sol->AdvancedSearch->SearchValue = @$filter["x_fecha_reg_sol"];
		$this->fecha_reg_sol->AdvancedSearch->SearchOperator = @$filter["z_fecha_reg_sol"];
		$this->fecha_reg_sol->AdvancedSearch->SearchCondition = @$filter["v_fecha_reg_sol"];
		$this->fecha_reg_sol->AdvancedSearch->SearchValue2 = @$filter["y_fecha_reg_sol"];
		$this->fecha_reg_sol->AdvancedSearch->SearchOperator2 = @$filter["w_fecha_reg_sol"];
		$this->fecha_reg_sol->AdvancedSearch->Save();

		// Field obs_sol
		$this->obs_sol->AdvancedSearch->SearchValue = @$filter["x_obs_sol"];
		$this->obs_sol->AdvancedSearch->SearchOperator = @$filter["z_obs_sol"];
		$this->obs_sol->AdvancedSearch->SearchCondition = @$filter["v_obs_sol"];
		$this->obs_sol->AdvancedSearch->SearchValue2 = @$filter["y_obs_sol"];
		$this->obs_sol->AdvancedSearch->SearchOperator2 = @$filter["w_obs_sol"];
		$this->obs_sol->AdvancedSearch->Save();

		// Field empresa_sol
		$this->empresa_sol->AdvancedSearch->SearchValue = @$filter["x_empresa_sol"];
		$this->empresa_sol->AdvancedSearch->SearchOperator = @$filter["z_empresa_sol"];
		$this->empresa_sol->AdvancedSearch->SearchCondition = @$filter["v_empresa_sol"];
		$this->empresa_sol->AdvancedSearch->SearchValue2 = @$filter["y_empresa_sol"];
		$this->empresa_sol->AdvancedSearch->SearchOperator2 = @$filter["w_empresa_sol"];
		$this->empresa_sol->AdvancedSearch->Save();

		// Field estado_sol
		$this->estado_sol->AdvancedSearch->SearchValue = @$filter["x_estado_sol"];
		$this->estado_sol->AdvancedSearch->SearchOperator = @$filter["z_estado_sol"];
		$this->estado_sol->AdvancedSearch->SearchCondition = @$filter["v_estado_sol"];
		$this->estado_sol->AdvancedSearch->SearchValue2 = @$filter["y_estado_sol"];
		$this->estado_sol->AdvancedSearch->SearchOperator2 = @$filter["w_estado_sol"];
		$this->estado_sol->AdvancedSearch->Save();

		// Field fecha_prevista_sol
		$this->fecha_prevista_sol->AdvancedSearch->SearchValue = @$filter["x_fecha_prevista_sol"];
		$this->fecha_prevista_sol->AdvancedSearch->SearchOperator = @$filter["z_fecha_prevista_sol"];
		$this->fecha_prevista_sol->AdvancedSearch->SearchCondition = @$filter["v_fecha_prevista_sol"];
		$this->fecha_prevista_sol->AdvancedSearch->SearchValue2 = @$filter["y_fecha_prevista_sol"];
		$this->fecha_prevista_sol->AdvancedSearch->SearchOperator2 = @$filter["w_fecha_prevista_sol"];
		$this->fecha_prevista_sol->AdvancedSearch->Save();

		// Field user_preventa_sol
		$this->user_preventa_sol->AdvancedSearch->SearchValue = @$filter["x_user_preventa_sol"];
		$this->user_preventa_sol->AdvancedSearch->SearchOperator = @$filter["z_user_preventa_sol"];
		$this->user_preventa_sol->AdvancedSearch->SearchCondition = @$filter["v_user_preventa_sol"];
		$this->user_preventa_sol->AdvancedSearch->SearchValue2 = @$filter["y_user_preventa_sol"];
		$this->user_preventa_sol->AdvancedSearch->SearchOperator2 = @$filter["w_user_preventa_sol"];
		$this->user_preventa_sol->AdvancedSearch->Save();

		// Field quincena_obra_sol
		$this->quincena_obra_sol->AdvancedSearch->SearchValue = @$filter["x_quincena_obra_sol"];
		$this->quincena_obra_sol->AdvancedSearch->SearchOperator = @$filter["z_quincena_obra_sol"];
		$this->quincena_obra_sol->AdvancedSearch->SearchCondition = @$filter["v_quincena_obra_sol"];
		$this->quincena_obra_sol->AdvancedSearch->SearchValue2 = @$filter["y_quincena_obra_sol"];
		$this->quincena_obra_sol->AdvancedSearch->SearchOperator2 = @$filter["w_quincena_obra_sol"];
		$this->quincena_obra_sol->AdvancedSearch->Save();

		// Field fecha_obra_sol
		$this->fecha_obra_sol->AdvancedSearch->SearchValue = @$filter["x_fecha_obra_sol"];
		$this->fecha_obra_sol->AdvancedSearch->SearchOperator = @$filter["z_fecha_obra_sol"];
		$this->fecha_obra_sol->AdvancedSearch->SearchCondition = @$filter["v_fecha_obra_sol"];
		$this->fecha_obra_sol->AdvancedSearch->SearchValue2 = @$filter["y_fecha_obra_sol"];
		$this->fecha_obra_sol->AdvancedSearch->SearchOperator2 = @$filter["w_fecha_obra_sol"];
		$this->fecha_obra_sol->AdvancedSearch->Save();

		// Field nombre_tecnico_sol
		$this->nombre_tecnico_sol->AdvancedSearch->SearchValue = @$filter["x_nombre_tecnico_sol"];
		$this->nombre_tecnico_sol->AdvancedSearch->SearchOperator = @$filter["z_nombre_tecnico_sol"];
		$this->nombre_tecnico_sol->AdvancedSearch->SearchCondition = @$filter["v_nombre_tecnico_sol"];
		$this->nombre_tecnico_sol->AdvancedSearch->SearchValue2 = @$filter["y_nombre_tecnico_sol"];
		$this->nombre_tecnico_sol->AdvancedSearch->SearchOperator2 = @$filter["w_nombre_tecnico_sol"];
		$this->nombre_tecnico_sol->AdvancedSearch->Save();

		// Field cod_tecnico_sol
		$this->cod_tecnico_sol->AdvancedSearch->SearchValue = @$filter["x_cod_tecnico_sol"];
		$this->cod_tecnico_sol->AdvancedSearch->SearchOperator = @$filter["z_cod_tecnico_sol"];
		$this->cod_tecnico_sol->AdvancedSearch->SearchCondition = @$filter["v_cod_tecnico_sol"];
		$this->cod_tecnico_sol->AdvancedSearch->SearchValue2 = @$filter["y_cod_tecnico_sol"];
		$this->cod_tecnico_sol->AdvancedSearch->SearchOperator2 = @$filter["w_cod_tecnico_sol"];
		$this->cod_tecnico_sol->AdvancedSearch->Save();

		// Field lider_obra_sol
		$this->lider_obra_sol->AdvancedSearch->SearchValue = @$filter["x_lider_obra_sol"];
		$this->lider_obra_sol->AdvancedSearch->SearchOperator = @$filter["z_lider_obra_sol"];
		$this->lider_obra_sol->AdvancedSearch->SearchCondition = @$filter["v_lider_obra_sol"];
		$this->lider_obra_sol->AdvancedSearch->SearchValue2 = @$filter["y_lider_obra_sol"];
		$this->lider_obra_sol->AdvancedSearch->SearchOperator2 = @$filter["w_lider_obra_sol"];
		$this->lider_obra_sol->AdvancedSearch->Save();

		// Field fecha_visita_comerc_sol
		$this->fecha_visita_comerc_sol->AdvancedSearch->SearchValue = @$filter["x_fecha_visita_comerc_sol"];
		$this->fecha_visita_comerc_sol->AdvancedSearch->SearchOperator = @$filter["z_fecha_visita_comerc_sol"];
		$this->fecha_visita_comerc_sol->AdvancedSearch->SearchCondition = @$filter["v_fecha_visita_comerc_sol"];
		$this->fecha_visita_comerc_sol->AdvancedSearch->SearchValue2 = @$filter["y_fecha_visita_comerc_sol"];
		$this->fecha_visita_comerc_sol->AdvancedSearch->SearchOperator2 = @$filter["w_fecha_visita_comerc_sol"];
		$this->fecha_visita_comerc_sol->AdvancedSearch->Save();

		// Field obs_estado_sol
		$this->obs_estado_sol->AdvancedSearch->SearchValue = @$filter["x_obs_estado_sol"];
		$this->obs_estado_sol->AdvancedSearch->SearchOperator = @$filter["z_obs_estado_sol"];
		$this->obs_estado_sol->AdvancedSearch->SearchCondition = @$filter["v_obs_estado_sol"];
		$this->obs_estado_sol->AdvancedSearch->SearchValue2 = @$filter["y_obs_estado_sol"];
		$this->obs_estado_sol->AdvancedSearch->SearchOperator2 = @$filter["w_obs_estado_sol"];
		$this->obs_estado_sol->AdvancedSearch->Save();

		// Field forma_pagogn_sol
		$this->forma_pagogn_sol->AdvancedSearch->SearchValue = @$filter["x_forma_pagogn_sol"];
		$this->forma_pagogn_sol->AdvancedSearch->SearchOperator = @$filter["z_forma_pagogn_sol"];
		$this->forma_pagogn_sol->AdvancedSearch->SearchCondition = @$filter["v_forma_pagogn_sol"];
		$this->forma_pagogn_sol->AdvancedSearch->SearchValue2 = @$filter["y_forma_pagogn_sol"];
		$this->forma_pagogn_sol->AdvancedSearch->SearchOperator2 = @$filter["w_forma_pagogn_sol"];
		$this->forma_pagogn_sol->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->nombre_sol, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->direccion_pol_sol, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->direccion_nueva_sol, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->telefono1_sol, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->telefono2_sol, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->celular_sol, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->email_sol, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->servicio_sol, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->registra_sol, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->obs_sol, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->user_preventa_sol, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->quincena_obra_sol, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->nombre_tecnico_sol, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->lider_obra_sol, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->obs_estado_sol, $arKeywords, $type);
		return $sWhere;
	}

	// Build basic search SQL
	function BuildBasicSearchSql(&$Where, &$Fld, $arKeywords, $type) {
		$sDefCond = ($type == "OR") ? "OR" : "AND";
		$arSQL = array(); // Array for SQL parts
		$arCond = array(); // Array for search conditions
		$cnt = count($arKeywords);
		$j = 0; // Number of SQL parts
		for ($i = 0; $i < $cnt; $i++) {
			$Keyword = $arKeywords[$i];
			$Keyword = trim($Keyword);
			if (EW_BASIC_SEARCH_IGNORE_PATTERN <> "") {
				$Keyword = preg_replace(EW_BASIC_SEARCH_IGNORE_PATTERN, "\\", $Keyword);
				$ar = explode("\\", $Keyword);
			} else {
				$ar = array($Keyword);
			}
			foreach ($ar as $Keyword) {
				if ($Keyword <> "") {
					$sWrk = "";
					if ($Keyword == "OR" && $type == "") {
						if ($j > 0)
							$arCond[$j-1] = "OR";
					} elseif ($Keyword == EW_NULL_VALUE) {
						$sWrk = $Fld->FldExpression . " IS NULL";
					} elseif ($Keyword == EW_NOT_NULL_VALUE) {
						$sWrk = $Fld->FldExpression . " IS NOT NULL";
					} elseif ($Fld->FldIsVirtual && $Fld->FldVirtualSearch) {
						$sWrk = $Fld->FldVirtualExpression . ew_Like(ew_QuotedValue("%" . $Keyword . "%", EW_DATATYPE_STRING, $this->DBID), $this->DBID);
					} elseif ($Fld->FldDataType != EW_DATATYPE_NUMBER || is_numeric($Keyword)) {
						$sWrk = $Fld->FldBasicSearchExpression . ew_Like(ew_QuotedValue("%" . $Keyword . "%", EW_DATATYPE_STRING, $this->DBID), $this->DBID);
					}
					if ($sWrk <> "") {
						$arSQL[$j] = $sWrk;
						$arCond[$j] = $sDefCond;
						$j += 1;
					}
				}
			}
		}
		$cnt = count($arSQL);
		$bQuoted = FALSE;
		$sSql = "";
		if ($cnt > 0) {
			for ($i = 0; $i < $cnt-1; $i++) {
				if ($arCond[$i] == "OR") {
					if (!$bQuoted) $sSql .= "(";
					$bQuoted = TRUE;
				}
				$sSql .= $arSQL[$i];
				if ($bQuoted && $arCond[$i] <> "OR") {
					$sSql .= ")";
					$bQuoted = FALSE;
				}
				$sSql .= " " . $arCond[$i] . " ";
			}
			$sSql .= $arSQL[$cnt-1];
			if ($bQuoted)
				$sSql .= ")";
		}
		if ($sSql <> "") {
			if ($Where <> "") $Where .= " OR ";
			$Where .=  "(" . $sSql . ")";
		}
	}

	// Return basic search WHERE clause based on search keyword and type
	function BasicSearchWhere($Default = FALSE) {
		global $Security;
		$sSearchStr = "";
		if (!$Security->CanSearch()) return "";
		$sSearchKeyword = ($Default) ? $this->BasicSearch->KeywordDefault : $this->BasicSearch->Keyword;
		$sSearchType = ($Default) ? $this->BasicSearch->TypeDefault : $this->BasicSearch->Type;
		if ($sSearchKeyword <> "") {
			$sSearch = trim($sSearchKeyword);
			if ($sSearchType <> "=") {
				$ar = array();

				// Match quoted keywords (i.e.: "...")
				if (preg_match_all('/"([^"]*)"/i', $sSearch, $matches, PREG_SET_ORDER)) {
					foreach ($matches as $match) {
						$p = strpos($sSearch, $match[0]);
						$str = substr($sSearch, 0, $p);
						$sSearch = substr($sSearch, $p + strlen($match[0]));
						if (strlen(trim($str)) > 0)
							$ar = array_merge($ar, explode(" ", trim($str)));
						$ar[] = $match[1]; // Save quoted keyword
					}
				}

				// Match individual keywords
				if (strlen(trim($sSearch)) > 0)
					$ar = array_merge($ar, explode(" ", trim($sSearch)));

				// Search keyword in any fields
				if (($sSearchType == "OR" || $sSearchType == "AND") && $this->BasicSearch->BasicSearchAnyFields) {
					foreach ($ar as $sKeyword) {
						if ($sKeyword <> "") {
							if ($sSearchStr <> "") $sSearchStr .= " " . $sSearchType . " ";
							$sSearchStr .= "(" . $this->BasicSearchSQL(array($sKeyword), $sSearchType) . ")";
						}
					}
				} else {
					$sSearchStr = $this->BasicSearchSQL($ar, $sSearchType);
				}
			} else {
				$sSearchStr = $this->BasicSearchSQL(array($sSearch), $sSearchType);
			}
			if (!$Default) $this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->BasicSearch->setKeyword($sSearchKeyword);
			$this->BasicSearch->setType($sSearchType);
		}
		return $sSearchStr;
	}

	// Check if search parm exists
	function CheckSearchParms() {

		// Check basic search
		if ($this->BasicSearch->IssetSession())
			return TRUE;
		return FALSE;
	}

	// Clear all search parameters
	function ResetSearchParms() {

		// Clear search WHERE clause
		$this->SearchWhere = "";
		$this->setSearchWhere($this->SearchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();
	}

	// Load advanced search default values
	function LoadAdvancedSearchDefault() {
		return FALSE;
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		$this->BasicSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->id_sol); // id_sol
			$this->UpdateSort($this->poliza_sol); // poliza_sol
			$this->UpdateSort($this->demanda_sol); // demanda_sol
			$this->UpdateSort($this->asesor_sol); // asesor_sol
			$this->UpdateSort($this->asignacion_sol); // asignacion_sol
			$this->UpdateSort($this->cedula_sol); // cedula_sol
			$this->UpdateSort($this->nombre_sol); // nombre_sol
			$this->UpdateSort($this->direccion_pol_sol); // direccion_pol_sol
			$this->UpdateSort($this->direccion_nueva_sol); // direccion_nueva_sol
			$this->UpdateSort($this->localidad_sol); // localidad_sol
			$this->UpdateSort($this->barrio_sol); // barrio_sol
			$this->UpdateSort($this->telefono1_sol); // telefono1_sol
			$this->UpdateSort($this->telefono2_sol); // telefono2_sol
			$this->UpdateSort($this->celular_sol); // celular_sol
			$this->UpdateSort($this->servicio_sol); // servicio_sol
			$this->UpdateSort($this->obs_sol); // obs_sol
			$this->UpdateSort($this->estado_sol); // estado_sol
			$this->UpdateSort($this->fecha_prevista_sol); // fecha_prevista_sol
			$this->UpdateSort($this->fecha_obra_sol); // fecha_obra_sol
			$this->UpdateSort($this->fecha_visita_comerc_sol); // fecha_visita_comerc_sol
			$this->UpdateSort($this->obs_estado_sol); // obs_estado_sol
			$this->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		$sOrderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($this->getSqlOrderBy() <> "") {
				$sOrderBy = $this->getSqlOrderBy();
				$this->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command
	// - cmd=reset (Reset search parameters)
	// - cmd=resetall (Reset search and master/detail parameters)
	// - cmd=resetsort (Reset sort parameters)
	function ResetCmd() {

		// Check if reset command
		if (substr($this->Command,0,5) == "reset") {

			// Reset search criteria
			if ($this->Command == "reset" || $this->Command == "resetall")
				$this->ResetSearchParms();

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->id_sol->setSort("");
				$this->poliza_sol->setSort("");
				$this->demanda_sol->setSort("");
				$this->asesor_sol->setSort("");
				$this->asignacion_sol->setSort("");
				$this->cedula_sol->setSort("");
				$this->nombre_sol->setSort("");
				$this->direccion_pol_sol->setSort("");
				$this->direccion_nueva_sol->setSort("");
				$this->localidad_sol->setSort("");
				$this->barrio_sol->setSort("");
				$this->telefono1_sol->setSort("");
				$this->telefono2_sol->setSort("");
				$this->celular_sol->setSort("");
				$this->servicio_sol->setSort("");
				$this->obs_sol->setSort("");
				$this->estado_sol->setSort("");
				$this->fecha_prevista_sol->setSort("");
				$this->fecha_obra_sol->setSort("");
				$this->fecha_visita_comerc_sol->setSort("");
				$this->obs_estado_sol->setSort("");
			}

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language;

		// Add group option item
		$item = &$this->ListOptions->Add($this->ListOptions->GroupOptionName);
		$item->Body = "";
		$item->OnLeft = TRUE;
		$item->Visible = FALSE;

		// "view"
		$item = &$this->ListOptions->Add("view");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanView();
		$item->OnLeft = TRUE;

		// "edit"
		$item = &$this->ListOptions->Add("edit");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanEdit();
		$item->OnLeft = TRUE;

		// "copy"
		$item = &$this->ListOptions->Add("copy");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanAdd();
		$item->OnLeft = TRUE;

		// "delete"
		$item = &$this->ListOptions->Add("delete");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanDelete();
		$item->OnLeft = TRUE;

		// List actions
		$item = &$this->ListOptions->Add("listactions");
		$item->CssStyle = "white-space: nowrap;";
		$item->OnLeft = TRUE;
		$item->Visible = FALSE;
		$item->ShowInButtonGroup = FALSE;
		$item->ShowInDropDown = FALSE;

		// "checkbox"
		$item = &$this->ListOptions->Add("checkbox");
		$item->Visible = TRUE;
		$item->OnLeft = TRUE;
		$item->Header = "<input type=\"checkbox\" name=\"key\" id=\"key\" onclick=\"ew_SelectAllKey(this);\">";
		$item->MoveTo(0);
		$item->ShowInDropDown = FALSE;
		$item->ShowInButtonGroup = FALSE;

		// Drop down button for ListOptions
		$this->ListOptions->UseImageAndText = TRUE;
		$this->ListOptions->UseDropDownButton = FALSE;
		$this->ListOptions->DropDownButtonPhrase = $Language->Phrase("ButtonListOptions");
		$this->ListOptions->UseButtonGroup = TRUE;
		if ($this->ListOptions->UseButtonGroup && ew_IsMobile())
			$this->ListOptions->UseDropDownButton = TRUE;
		$this->ListOptions->ButtonClass = "btn-sm"; // Class for button group

		// Call ListOptions_Load event
		$this->ListOptions_Load();
		$this->SetupListOptionsExt();
		$item = &$this->ListOptions->GetItem($this->ListOptions->GroupOptionName);
		$item->Visible = $this->ListOptions->GroupOptionVisible();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $objForm;
		$this->ListOptions->LoadDefault();

		// "view"
		$oListOpt = &$this->ListOptions->Items["view"];
		$viewcaption = ew_HtmlTitle($Language->Phrase("ViewLink"));
		if ($Security->CanView()) {
			$oListOpt->Body = "<a class=\"ewRowLink ewView\" title=\"" . $viewcaption . "\" data-caption=\"" . $viewcaption . "\" href=\"" . ew_HtmlEncode($this->ViewUrl) . "\">" . $Language->Phrase("ViewLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		$editcaption = ew_HtmlTitle($Language->Phrase("EditLink"));
		if ($Security->CanEdit()) {
			$oListOpt->Body = "<a class=\"ewRowLink ewEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("EditLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "copy"
		$oListOpt = &$this->ListOptions->Items["copy"];
		$copycaption = ew_HtmlTitle($Language->Phrase("CopyLink"));
		if ($Security->CanAdd()) {
			$oListOpt->Body = "<a class=\"ewRowLink ewCopy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"" . ew_HtmlEncode($this->CopyUrl) . "\">" . $Language->Phrase("CopyLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "delete"
		$oListOpt = &$this->ListOptions->Items["delete"];
		if ($Security->CanDelete())
			$oListOpt->Body = "<a class=\"ewRowLink ewDelete\"" . "" . " title=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" href=\"" . ew_HtmlEncode($this->DeleteUrl) . "\">" . $Language->Phrase("DeleteLink") . "</a>";
		else
			$oListOpt->Body = "";

		// Set up list action buttons
		$oListOpt = &$this->ListOptions->GetItem("listactions");
		if ($oListOpt && $this->Export == "" && $this->CurrentAction == "") {
			$body = "";
			$links = array();
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_SINGLE && $listaction->Allow) {
					$action = $listaction->Action;
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode(str_replace(" ewIcon", "", $listaction->Icon)) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\"></span> " : "";
					$links[] = "<li><a class=\"ewAction ewListAction\" data-action=\"" . ew_HtmlEncode($action) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({key:" . $this->KeyToJson() . "}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . $listaction->Caption . "</a></li>";
					if (count($links) == 1) // Single button
						$body = "<a class=\"ewAction ewListAction\" data-action=\"" . ew_HtmlEncode($action) . "\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({key:" . $this->KeyToJson() . "}," . $listaction->ToJson(TRUE) . "));return false;\">" . $Language->Phrase("ListActionButton") . "</a>";
				}
			}
			if (count($links) > 1) { // More than one buttons, use dropdown
				$body = "<button class=\"dropdown-toggle btn btn-default btn-sm ewActions\" title=\"" . ew_HtmlTitle($Language->Phrase("ListActionButton")) . "\" data-toggle=\"dropdown\">" . $Language->Phrase("ListActionButton") . "<b class=\"caret\"></b></button>";
				$content = "";
				foreach ($links as $link)
					$content .= "<li>" . $link . "</li>";
				$body .= "<ul class=\"dropdown-menu" . ($oListOpt->OnLeft ? "" : " dropdown-menu-right") . "\">". $content . "</ul>";
				$body = "<div class=\"btn-group\">" . $body . "</div>";
			}
			if (count($links) > 0) {
				$oListOpt->Body = $body;
				$oListOpt->Visible = TRUE;
			}
		}

		// "checkbox"
		$oListOpt = &$this->ListOptions->Items["checkbox"];
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->id_sol->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event);'>";
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = $options["addedit"];

		// Add
		$item = &$option->Add("add");
		$addcaption = ew_HtmlTitle($Language->Phrase("AddLink"));
		$item->Body = "<a class=\"ewAddEdit ewAdd\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("AddLink") . "</a>";
		$item->Visible = ($this->AddUrl <> "" && $Security->CanAdd());
		$option = $options["action"];

		// Set up options default
		foreach ($options as &$option) {
			$option->UseImageAndText = TRUE;
			$option->UseDropDownButton = FALSE;
			$option->UseButtonGroup = TRUE;
			$option->ButtonClass = "btn-sm"; // Class for button group
			$item = &$option->Add($option->GroupOptionName);
			$item->Body = "";
			$item->Visible = FALSE;
		}
		$options["addedit"]->DropDownButtonPhrase = $Language->Phrase("ButtonAddEdit");
		$options["detail"]->DropDownButtonPhrase = $Language->Phrase("ButtonDetails");
		$options["action"]->DropDownButtonPhrase = $Language->Phrase("ButtonActions");

		// Filter button
		$item = &$this->FilterOptions->Add("savecurrentfilter");
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fap_solicitudlistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fap_solicitudlistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
		$item->Visible = TRUE;
		$this->FilterOptions->UseDropDownButton = TRUE;
		$this->FilterOptions->UseButtonGroup = !$this->FilterOptions->UseDropDownButton;
		$this->FilterOptions->DropDownButtonPhrase = $Language->Phrase("Filters");

		// Add group option item
		$item = &$this->FilterOptions->Add($this->FilterOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
	}

	// Render other options
	function RenderOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
			$option = &$options["action"];

			// Set up list action buttons
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_MULTIPLE) {
					$item = &$option->Add("custom_" . $listaction->Action);
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode($listaction->Icon) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\"></span> " : $caption;
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fap_solicitudlist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
					$item->Visible = $listaction->Allow;
				}
			}

			// Hide grid edit and other options
			if ($this->TotalRecs <= 0) {
				$option = &$options["addedit"];
				$item = &$option->GetItem("gridedit");
				if ($item) $item->Visible = FALSE;
				$option = &$options["action"];
				$option->HideAllOptions();
			}
	}

	// Process list action
	function ProcessListAction() {
		global $Language, $Security;
		$userlist = "";
		$user = "";
		$sFilter = $this->GetKeyFilter();
		$UserAction = @$_POST["useraction"];
		if ($sFilter <> "" && $UserAction <> "") {

			// Check permission first
			$ActionCaption = $UserAction;
			if (array_key_exists($UserAction, $this->ListActions->Items)) {
				$ActionCaption = $this->ListActions->Items[$UserAction]->Caption;
				if (!$this->ListActions->Items[$UserAction]->Allow) {
					$errmsg = str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionNotAllowed"));
					if (@$_POST["ajax"] == $UserAction) // Ajax
						echo "<p class=\"text-danger\">" . $errmsg . "</p>";
					else
						$this->setFailureMessage($errmsg);
					return FALSE;
				}
			}
			$this->CurrentFilter = $sFilter;
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$rs = $conn->Execute($sSql);
			$conn->raiseErrorFn = '';
			$this->CurrentAction = $UserAction;

			// Call row action event
			if ($rs && !$rs->EOF) {
				$conn->BeginTrans();
				$this->SelectedCount = $rs->RecordCount();
				$this->SelectedIndex = 0;
				while (!$rs->EOF) {
					$this->SelectedIndex++;
					$row = $rs->fields;
					$Processed = $this->Row_CustomAction($UserAction, $row);
					if (!$Processed) break;
					$rs->MoveNext();
				}
				if ($Processed) {
					$conn->CommitTrans(); // Commit the changes
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage(str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionCompleted"))); // Set up success message
				} else {
					$conn->RollbackTrans(); // Rollback changes

					// Set up error message
					if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

						// Use the message, do nothing
					} elseif ($this->CancelMessage <> "") {
						$this->setFailureMessage($this->CancelMessage);
						$this->CancelMessage = "";
					} else {
						$this->setFailureMessage(str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionFailed")));
					}
				}
			}
			if ($rs)
				$rs->Close();
			$this->CurrentAction = ""; // Clear action
			if (@$_POST["ajax"] == $UserAction) { // Ajax
				if ($this->getSuccessMessage() <> "") {
					echo "<p class=\"text-success\">" . $this->getSuccessMessage() . "</p>";
					$this->ClearSuccessMessage(); // Clear message
				}
				if ($this->getFailureMessage() <> "") {
					echo "<p class=\"text-danger\">" . $this->getFailureMessage() . "</p>";
					$this->ClearFailureMessage(); // Clear message
				}
				return TRUE;
			}
		}
		return FALSE; // Not ajax request
	}

	// Set up search options
	function SetupSearchOptions() {
		global $Language;
		$this->SearchOptions = new cListOptions();
		$this->SearchOptions->Tag = "div";
		$this->SearchOptions->TagClassName = "ewSearchOption";

		// Search button
		$item = &$this->SearchOptions->Add("searchtoggle");
		$SearchToggleClass = ($this->SearchWhere <> "") ? " active" : " active";
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fap_solicitudlistsrch\">" . $Language->Phrase("SearchBtn") . "</button>";
		$item->Visible = TRUE;

		// Show all button
		$item = &$this->SearchOptions->Add("showall");
		$item->Body = "<a class=\"btn btn-default ewShowAll\" title=\"" . $Language->Phrase("ShowAll") . "\" data-caption=\"" . $Language->Phrase("ShowAll") . "\" href=\"" . $this->PageUrl() . "cmd=reset\">" . $Language->Phrase("ShowAllBtn") . "</a>";
		$item->Visible = ($this->SearchWhere <> $this->DefaultSearchWhere && $this->SearchWhere <> "0=101");

		// Button group for search
		$this->SearchOptions->UseDropDownButton = FALSE;
		$this->SearchOptions->UseImageAndText = TRUE;
		$this->SearchOptions->UseButtonGroup = TRUE;
		$this->SearchOptions->DropDownButtonPhrase = $Language->Phrase("ButtonSearch");

		// Add group option item
		$item = &$this->SearchOptions->Add($this->SearchOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Hide search options
		if ($this->Export <> "" || $this->CurrentAction <> "")
			$this->SearchOptions->HideAllOptions();
		global $Security;
		if (!$Security->CanSearch()) {
			$this->SearchOptions->HideAllOptions();
			$this->FilterOptions->HideAllOptions();
		}
	}

	function SetupListOptionsExt() {
		global $Security, $Language;
	}

	function RenderListOptionsExt() {
		global $Security, $Language;
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

	// Load basic search values
	function LoadBasicSearchValues() {
		$this->BasicSearch->Keyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		if ($this->BasicSearch->Keyword <> "") $this->Command = "search";
		$this->BasicSearch->Type = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
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
		$this->ViewUrl = $this->GetViewUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->InlineEditUrl = $this->GetInlineEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->InlineCopyUrl = $this->GetInlineCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();

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

			// fecha_obra_sol
			$this->fecha_obra_sol->LinkCustomAttributes = "";
			$this->fecha_obra_sol->HrefValue = "";
			$this->fecha_obra_sol->TooltipValue = "";

			// fecha_visita_comerc_sol
			$this->fecha_visita_comerc_sol->LinkCustomAttributes = "";
			$this->fecha_visita_comerc_sol->HrefValue = "";
			$this->fecha_visita_comerc_sol->TooltipValue = "";

			// obs_estado_sol
			$this->obs_estado_sol->LinkCustomAttributes = "";
			$this->obs_estado_sol->HrefValue = "";
			$this->obs_estado_sol->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Build export filter for selected records
	function BuildExportSelectedFilter() {
		global $Language;
		$sWrkFilter = "";
		if ($this->Export <> "") {
			$sWrkFilter = $this->GetKeyFilter();
		}
		return $sWrkFilter;
	}

	// Set up export options
	function SetupExportOptions() {
		global $Language;

		// Printer friendly
		$item = &$this->ExportOptions->Add("print");
		$item->Body = "<a class=\"ewExportLink ewPrint\" title=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\" onclick=\"ew_Export(document.fap_solicitudlist,'" . ew_CurrentPage() . "','print',false,true);\">" . $Language->Phrase("PrinterFriendly") . "</a>";
		$item->Visible = FALSE;

		// Export to Excel
		$item = &$this->ExportOptions->Add("excel");
		$item->Body = "<a class=\"ewExportLink ewExcel\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\" onclick=\"ew_Export(document.fap_solicitudlist,'" . ew_CurrentPage() . "','excel',false,true);\">" . $Language->Phrase("ExportToExcel") . "</a>";
		$item->Visible = FALSE;

		// Export to Word
		$item = &$this->ExportOptions->Add("word");
		$item->Body = "<a class=\"ewExportLink ewWord\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\" onclick=\"ew_Export(document.fap_solicitudlist,'" . ew_CurrentPage() . "','word',false,true);\">" . $Language->Phrase("ExportToWord") . "</a>";
		$item->Visible = FALSE;

		// Export to Html
		$item = &$this->ExportOptions->Add("html");
		$item->Body = "<a class=\"ewExportLink ewHtml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\" onclick=\"ew_Export(document.fap_solicitudlist,'" . ew_CurrentPage() . "','html',false,true);\">" . $Language->Phrase("ExportToHtml") . "</a>";
		$item->Visible = FALSE;

		// Export to Xml
		$item = &$this->ExportOptions->Add("xml");
		$item->Body = "<a class=\"ewExportLink ewXml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\" onclick=\"ew_Export(document.fap_solicitudlist,'" . ew_CurrentPage() . "','xml',false,true);\">" . $Language->Phrase("ExportToXml") . "</a>";
		$item->Visible = FALSE;

		// Export to Csv
		$item = &$this->ExportOptions->Add("csv");
		$item->Body = "<a class=\"ewExportLink ewCsv\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\" onclick=\"ew_Export(document.fap_solicitudlist,'" . ew_CurrentPage() . "','csv',false,true);\">" . $Language->Phrase("ExportToCsv") . "</a>";
		$item->Visible = FALSE;

		// Export to Pdf
		$item = &$this->ExportOptions->Add("pdf");
		$item->Body = "<a class=\"ewExportLink ewPdf\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\" onclick=\"ew_Export(document.fap_solicitudlist,'" . ew_CurrentPage() . "','pdf',false,true);\">" . $Language->Phrase("ExportToPDF") . "</a>";
		$item->Visible = FALSE;

		// Export to Email
		$item = &$this->ExportOptions->Add("email");
		$url = "";
		$item->Body = "<button id=\"emf_ap_solicitud\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_ap_solicitud',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fap_solicitudlist,sel:true" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
		$item->Visible = FALSE;

		// Drop down button for export
		$this->ExportOptions->UseButtonGroup = TRUE;
		$this->ExportOptions->UseImageAndText = TRUE;
		$this->ExportOptions->UseDropDownButton = FALSE;
		if ($this->ExportOptions->UseButtonGroup && ew_IsMobile())
			$this->ExportOptions->UseDropDownButton = TRUE;
		$this->ExportOptions->DropDownButtonPhrase = $Language->Phrase("ButtonExport");

		// Add group option item
		$item = &$this->ExportOptions->Add($this->ExportOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
		$Breadcrumb->Add("list", $this->TableVar, $url, "", $this->TableVar, TRUE);
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

	// ListOptions Load event
	function ListOptions_Load() {

		// Example:
		//$opt = &$this->ListOptions->Add("new");
		//$opt->Header = "xxx";
		//$opt->OnLeft = TRUE; // Link on left
		//$opt->MoveTo(0); // Move to first column

	}

	// ListOptions Rendered event
	function ListOptions_Rendered() {

		// Example: 
		//$this->ListOptions->Items["new"]->Body = "xxx";

	}

	// Row Custom Action event
	function Row_CustomAction($action, $row) {

		// Return FALSE to abort
		return TRUE;
	}

	// Page Exporting event
	// $this->ExportDoc = export document object
	function Page_Exporting() {

		//$this->ExportDoc->Text = "my header"; // Export header
		//return FALSE; // Return FALSE to skip default export and use Row_Export event

		return TRUE; // Return TRUE to use default export and skip Row_Export event
	}

	// Row Export event
	// $this->ExportDoc = export document object
	function Row_Export($rs) {

		//$this->ExportDoc->Text .= "my content"; // Build HTML with field value: $rs["MyField"] or $this->MyField->ViewValue
	}

	// Page Exported event
	// $this->ExportDoc = export document object
	function Page_Exported() {

		//$this->ExportDoc->Text .= "my footer"; // Export footer
		//echo $this->ExportDoc->Text;

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($ap_solicitud_list)) $ap_solicitud_list = new cap_solicitud_list();

// Page init
$ap_solicitud_list->Page_Init();

// Page main
$ap_solicitud_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$ap_solicitud_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($ap_solicitud->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fap_solicitudlist = new ew_Form("fap_solicitudlist", "list");
fap_solicitudlist.FormKeyCountName = '<?php echo $ap_solicitud_list->FormKeyCountName ?>';

// Form_CustomValidate event
fap_solicitudlist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fap_solicitudlist.ValidateRequired = true;
<?php } else { ?>
fap_solicitudlist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fap_solicitudlist.Lists["x_asesor_sol"] = {"LinkField":"x_Id_tercero","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre_tercero","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"ap_terceros"};
fap_solicitudlist.Lists["x_asignacion_sol"] = {"LinkField":"x_id_asignacion","Ajax":true,"AutoFill":false,"DisplayFields":["x_tipo_asignacion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"ap_asignacion"};
fap_solicitudlist.Lists["x_localidad_sol"] = {"LinkField":"x_id_loc","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre_loc","","",""],"ParentFields":[],"ChildFields":["x_barrio_sol"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"siax_localidad"};
fap_solicitudlist.Lists["x_barrio_sol"] = {"LinkField":"x_cod_sec","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre_sec","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"siax_sectores"};
fap_solicitudlist.Lists["x_estado_sol"] = {"LinkField":"x_id_estado_preventa","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre_estado_preventa","x_detalle_estado_preventa","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"ap_estado_preventa"};

// Form object for search
var CurrentSearchForm = fap_solicitudlistsrch = new ew_Form("fap_solicitudlistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($ap_solicitud->Export == "") { ?>
<div class="ewToolbar">
<?php if ($ap_solicitud->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if ($ap_solicitud_list->TotalRecs > 0 && $ap_solicitud_list->ExportOptions->Visible()) { ?>
<?php $ap_solicitud_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($ap_solicitud_list->SearchOptions->Visible()) { ?>
<?php $ap_solicitud_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($ap_solicitud_list->FilterOptions->Visible()) { ?>
<?php $ap_solicitud_list->FilterOptions->Render("body") ?>
<?php } ?>
<?php if ($ap_solicitud->Export == "") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
	$bSelectLimit = $ap_solicitud_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($ap_solicitud_list->TotalRecs <= 0)
			$ap_solicitud_list->TotalRecs = $ap_solicitud->SelectRecordCount();
	} else {
		if (!$ap_solicitud_list->Recordset && ($ap_solicitud_list->Recordset = $ap_solicitud_list->LoadRecordset()))
			$ap_solicitud_list->TotalRecs = $ap_solicitud_list->Recordset->RecordCount();
	}
	$ap_solicitud_list->StartRec = 1;
	if ($ap_solicitud_list->DisplayRecs <= 0 || ($ap_solicitud->Export <> "" && $ap_solicitud->ExportAll)) // Display all records
		$ap_solicitud_list->DisplayRecs = $ap_solicitud_list->TotalRecs;
	if (!($ap_solicitud->Export <> "" && $ap_solicitud->ExportAll))
		$ap_solicitud_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$ap_solicitud_list->Recordset = $ap_solicitud_list->LoadRecordset($ap_solicitud_list->StartRec-1, $ap_solicitud_list->DisplayRecs);

	// Set no record found message
	if ($ap_solicitud->CurrentAction == "" && $ap_solicitud_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$ap_solicitud_list->setWarningMessage(ew_DeniedMsg());
		if ($ap_solicitud_list->SearchWhere == "0=101")
			$ap_solicitud_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$ap_solicitud_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$ap_solicitud_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($ap_solicitud->Export == "" && $ap_solicitud->CurrentAction == "") { ?>
<form name="fap_solicitudlistsrch" id="fap_solicitudlistsrch" class="form-inline ewForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($ap_solicitud_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fap_solicitudlistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="ap_solicitud">
	<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($ap_solicitud_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($ap_solicitud_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $ap_solicitud_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($ap_solicitud_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($ap_solicitud_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($ap_solicitud_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($ap_solicitud_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
		</ul>
	<button class="btn btn-primary ewButton" name="btnsubmit" id="btnsubmit" type="submit"><?php echo $Language->Phrase("QuickSearchBtn") ?></button>
	</div>
	</div>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $ap_solicitud_list->ShowPageHeader(); ?>
<?php
$ap_solicitud_list->ShowMessage();
?>
<?php if ($ap_solicitud_list->TotalRecs > 0 || $ap_solicitud->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid ap_solicitud">
<?php if ($ap_solicitud->Export == "") { ?>
<div class="panel-heading ewGridUpperPanel">
<?php if ($ap_solicitud->CurrentAction <> "gridadd" && $ap_solicitud->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($ap_solicitud_list->Pager)) $ap_solicitud_list->Pager = new cPrevNextPager($ap_solicitud_list->StartRec, $ap_solicitud_list->DisplayRecs, $ap_solicitud_list->TotalRecs) ?>
<?php if ($ap_solicitud_list->Pager->RecordCount > 0 && $ap_solicitud_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($ap_solicitud_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $ap_solicitud_list->PageUrl() ?>start=<?php echo $ap_solicitud_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($ap_solicitud_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $ap_solicitud_list->PageUrl() ?>start=<?php echo $ap_solicitud_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $ap_solicitud_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($ap_solicitud_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $ap_solicitud_list->PageUrl() ?>start=<?php echo $ap_solicitud_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($ap_solicitud_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $ap_solicitud_list->PageUrl() ?>start=<?php echo $ap_solicitud_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $ap_solicitud_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $ap_solicitud_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $ap_solicitud_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $ap_solicitud_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($ap_solicitud_list->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fap_solicitudlist" id="fap_solicitudlist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($ap_solicitud_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $ap_solicitud_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="ap_solicitud">
<input type="hidden" name="exporttype" id="exporttype" value="">
<div id="gmp_ap_solicitud" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php if ($ap_solicitud_list->TotalRecs > 0) { ?>
<table id="tbl_ap_solicitudlist" class="table ewTable">
<?php echo $ap_solicitud->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$ap_solicitud_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$ap_solicitud_list->RenderListOptions();

// Render list options (header, left)
$ap_solicitud_list->ListOptions->Render("header", "left");
?>
<?php if ($ap_solicitud->id_sol->Visible) { // id_sol ?>
	<?php if ($ap_solicitud->SortUrl($ap_solicitud->id_sol) == "") { ?>
		<th data-name="id_sol"><div id="elh_ap_solicitud_id_sol" class="ap_solicitud_id_sol"><div class="ewTableHeaderCaption"><?php echo $ap_solicitud->id_sol->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="id_sol"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $ap_solicitud->SortUrl($ap_solicitud->id_sol) ?>',1);"><div id="elh_ap_solicitud_id_sol" class="ap_solicitud_id_sol">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $ap_solicitud->id_sol->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($ap_solicitud->id_sol->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($ap_solicitud->id_sol->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($ap_solicitud->poliza_sol->Visible) { // poliza_sol ?>
	<?php if ($ap_solicitud->SortUrl($ap_solicitud->poliza_sol) == "") { ?>
		<th data-name="poliza_sol"><div id="elh_ap_solicitud_poliza_sol" class="ap_solicitud_poliza_sol"><div class="ewTableHeaderCaption"><?php echo $ap_solicitud->poliza_sol->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="poliza_sol"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $ap_solicitud->SortUrl($ap_solicitud->poliza_sol) ?>',1);"><div id="elh_ap_solicitud_poliza_sol" class="ap_solicitud_poliza_sol">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $ap_solicitud->poliza_sol->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($ap_solicitud->poliza_sol->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($ap_solicitud->poliza_sol->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($ap_solicitud->demanda_sol->Visible) { // demanda_sol ?>
	<?php if ($ap_solicitud->SortUrl($ap_solicitud->demanda_sol) == "") { ?>
		<th data-name="demanda_sol"><div id="elh_ap_solicitud_demanda_sol" class="ap_solicitud_demanda_sol"><div class="ewTableHeaderCaption"><?php echo $ap_solicitud->demanda_sol->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="demanda_sol"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $ap_solicitud->SortUrl($ap_solicitud->demanda_sol) ?>',1);"><div id="elh_ap_solicitud_demanda_sol" class="ap_solicitud_demanda_sol">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $ap_solicitud->demanda_sol->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($ap_solicitud->demanda_sol->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($ap_solicitud->demanda_sol->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($ap_solicitud->asesor_sol->Visible) { // asesor_sol ?>
	<?php if ($ap_solicitud->SortUrl($ap_solicitud->asesor_sol) == "") { ?>
		<th data-name="asesor_sol"><div id="elh_ap_solicitud_asesor_sol" class="ap_solicitud_asesor_sol"><div class="ewTableHeaderCaption"><?php echo $ap_solicitud->asesor_sol->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="asesor_sol"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $ap_solicitud->SortUrl($ap_solicitud->asesor_sol) ?>',1);"><div id="elh_ap_solicitud_asesor_sol" class="ap_solicitud_asesor_sol">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $ap_solicitud->asesor_sol->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($ap_solicitud->asesor_sol->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($ap_solicitud->asesor_sol->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($ap_solicitud->asignacion_sol->Visible) { // asignacion_sol ?>
	<?php if ($ap_solicitud->SortUrl($ap_solicitud->asignacion_sol) == "") { ?>
		<th data-name="asignacion_sol"><div id="elh_ap_solicitud_asignacion_sol" class="ap_solicitud_asignacion_sol"><div class="ewTableHeaderCaption"><?php echo $ap_solicitud->asignacion_sol->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="asignacion_sol"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $ap_solicitud->SortUrl($ap_solicitud->asignacion_sol) ?>',1);"><div id="elh_ap_solicitud_asignacion_sol" class="ap_solicitud_asignacion_sol">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $ap_solicitud->asignacion_sol->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($ap_solicitud->asignacion_sol->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($ap_solicitud->asignacion_sol->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($ap_solicitud->cedula_sol->Visible) { // cedula_sol ?>
	<?php if ($ap_solicitud->SortUrl($ap_solicitud->cedula_sol) == "") { ?>
		<th data-name="cedula_sol"><div id="elh_ap_solicitud_cedula_sol" class="ap_solicitud_cedula_sol"><div class="ewTableHeaderCaption"><?php echo $ap_solicitud->cedula_sol->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="cedula_sol"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $ap_solicitud->SortUrl($ap_solicitud->cedula_sol) ?>',1);"><div id="elh_ap_solicitud_cedula_sol" class="ap_solicitud_cedula_sol">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $ap_solicitud->cedula_sol->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($ap_solicitud->cedula_sol->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($ap_solicitud->cedula_sol->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($ap_solicitud->nombre_sol->Visible) { // nombre_sol ?>
	<?php if ($ap_solicitud->SortUrl($ap_solicitud->nombre_sol) == "") { ?>
		<th data-name="nombre_sol"><div id="elh_ap_solicitud_nombre_sol" class="ap_solicitud_nombre_sol"><div class="ewTableHeaderCaption"><?php echo $ap_solicitud->nombre_sol->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nombre_sol"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $ap_solicitud->SortUrl($ap_solicitud->nombre_sol) ?>',1);"><div id="elh_ap_solicitud_nombre_sol" class="ap_solicitud_nombre_sol">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $ap_solicitud->nombre_sol->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($ap_solicitud->nombre_sol->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($ap_solicitud->nombre_sol->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($ap_solicitud->direccion_pol_sol->Visible) { // direccion_pol_sol ?>
	<?php if ($ap_solicitud->SortUrl($ap_solicitud->direccion_pol_sol) == "") { ?>
		<th data-name="direccion_pol_sol"><div id="elh_ap_solicitud_direccion_pol_sol" class="ap_solicitud_direccion_pol_sol"><div class="ewTableHeaderCaption"><?php echo $ap_solicitud->direccion_pol_sol->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="direccion_pol_sol"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $ap_solicitud->SortUrl($ap_solicitud->direccion_pol_sol) ?>',1);"><div id="elh_ap_solicitud_direccion_pol_sol" class="ap_solicitud_direccion_pol_sol">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $ap_solicitud->direccion_pol_sol->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($ap_solicitud->direccion_pol_sol->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($ap_solicitud->direccion_pol_sol->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($ap_solicitud->direccion_nueva_sol->Visible) { // direccion_nueva_sol ?>
	<?php if ($ap_solicitud->SortUrl($ap_solicitud->direccion_nueva_sol) == "") { ?>
		<th data-name="direccion_nueva_sol"><div id="elh_ap_solicitud_direccion_nueva_sol" class="ap_solicitud_direccion_nueva_sol"><div class="ewTableHeaderCaption"><?php echo $ap_solicitud->direccion_nueva_sol->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="direccion_nueva_sol"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $ap_solicitud->SortUrl($ap_solicitud->direccion_nueva_sol) ?>',1);"><div id="elh_ap_solicitud_direccion_nueva_sol" class="ap_solicitud_direccion_nueva_sol">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $ap_solicitud->direccion_nueva_sol->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($ap_solicitud->direccion_nueva_sol->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($ap_solicitud->direccion_nueva_sol->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($ap_solicitud->localidad_sol->Visible) { // localidad_sol ?>
	<?php if ($ap_solicitud->SortUrl($ap_solicitud->localidad_sol) == "") { ?>
		<th data-name="localidad_sol"><div id="elh_ap_solicitud_localidad_sol" class="ap_solicitud_localidad_sol"><div class="ewTableHeaderCaption"><?php echo $ap_solicitud->localidad_sol->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="localidad_sol"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $ap_solicitud->SortUrl($ap_solicitud->localidad_sol) ?>',1);"><div id="elh_ap_solicitud_localidad_sol" class="ap_solicitud_localidad_sol">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $ap_solicitud->localidad_sol->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($ap_solicitud->localidad_sol->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($ap_solicitud->localidad_sol->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($ap_solicitud->barrio_sol->Visible) { // barrio_sol ?>
	<?php if ($ap_solicitud->SortUrl($ap_solicitud->barrio_sol) == "") { ?>
		<th data-name="barrio_sol"><div id="elh_ap_solicitud_barrio_sol" class="ap_solicitud_barrio_sol"><div class="ewTableHeaderCaption"><?php echo $ap_solicitud->barrio_sol->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="barrio_sol"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $ap_solicitud->SortUrl($ap_solicitud->barrio_sol) ?>',1);"><div id="elh_ap_solicitud_barrio_sol" class="ap_solicitud_barrio_sol">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $ap_solicitud->barrio_sol->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($ap_solicitud->barrio_sol->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($ap_solicitud->barrio_sol->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($ap_solicitud->telefono1_sol->Visible) { // telefono1_sol ?>
	<?php if ($ap_solicitud->SortUrl($ap_solicitud->telefono1_sol) == "") { ?>
		<th data-name="telefono1_sol"><div id="elh_ap_solicitud_telefono1_sol" class="ap_solicitud_telefono1_sol"><div class="ewTableHeaderCaption"><?php echo $ap_solicitud->telefono1_sol->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="telefono1_sol"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $ap_solicitud->SortUrl($ap_solicitud->telefono1_sol) ?>',1);"><div id="elh_ap_solicitud_telefono1_sol" class="ap_solicitud_telefono1_sol">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $ap_solicitud->telefono1_sol->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($ap_solicitud->telefono1_sol->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($ap_solicitud->telefono1_sol->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($ap_solicitud->telefono2_sol->Visible) { // telefono2_sol ?>
	<?php if ($ap_solicitud->SortUrl($ap_solicitud->telefono2_sol) == "") { ?>
		<th data-name="telefono2_sol"><div id="elh_ap_solicitud_telefono2_sol" class="ap_solicitud_telefono2_sol"><div class="ewTableHeaderCaption"><?php echo $ap_solicitud->telefono2_sol->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="telefono2_sol"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $ap_solicitud->SortUrl($ap_solicitud->telefono2_sol) ?>',1);"><div id="elh_ap_solicitud_telefono2_sol" class="ap_solicitud_telefono2_sol">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $ap_solicitud->telefono2_sol->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($ap_solicitud->telefono2_sol->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($ap_solicitud->telefono2_sol->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($ap_solicitud->celular_sol->Visible) { // celular_sol ?>
	<?php if ($ap_solicitud->SortUrl($ap_solicitud->celular_sol) == "") { ?>
		<th data-name="celular_sol"><div id="elh_ap_solicitud_celular_sol" class="ap_solicitud_celular_sol"><div class="ewTableHeaderCaption"><?php echo $ap_solicitud->celular_sol->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="celular_sol"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $ap_solicitud->SortUrl($ap_solicitud->celular_sol) ?>',1);"><div id="elh_ap_solicitud_celular_sol" class="ap_solicitud_celular_sol">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $ap_solicitud->celular_sol->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($ap_solicitud->celular_sol->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($ap_solicitud->celular_sol->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($ap_solicitud->servicio_sol->Visible) { // servicio_sol ?>
	<?php if ($ap_solicitud->SortUrl($ap_solicitud->servicio_sol) == "") { ?>
		<th data-name="servicio_sol"><div id="elh_ap_solicitud_servicio_sol" class="ap_solicitud_servicio_sol"><div class="ewTableHeaderCaption"><?php echo $ap_solicitud->servicio_sol->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="servicio_sol"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $ap_solicitud->SortUrl($ap_solicitud->servicio_sol) ?>',1);"><div id="elh_ap_solicitud_servicio_sol" class="ap_solicitud_servicio_sol">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $ap_solicitud->servicio_sol->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($ap_solicitud->servicio_sol->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($ap_solicitud->servicio_sol->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($ap_solicitud->obs_sol->Visible) { // obs_sol ?>
	<?php if ($ap_solicitud->SortUrl($ap_solicitud->obs_sol) == "") { ?>
		<th data-name="obs_sol"><div id="elh_ap_solicitud_obs_sol" class="ap_solicitud_obs_sol"><div class="ewTableHeaderCaption"><?php echo $ap_solicitud->obs_sol->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="obs_sol"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $ap_solicitud->SortUrl($ap_solicitud->obs_sol) ?>',1);"><div id="elh_ap_solicitud_obs_sol" class="ap_solicitud_obs_sol">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $ap_solicitud->obs_sol->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($ap_solicitud->obs_sol->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($ap_solicitud->obs_sol->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($ap_solicitud->estado_sol->Visible) { // estado_sol ?>
	<?php if ($ap_solicitud->SortUrl($ap_solicitud->estado_sol) == "") { ?>
		<th data-name="estado_sol"><div id="elh_ap_solicitud_estado_sol" class="ap_solicitud_estado_sol"><div class="ewTableHeaderCaption"><?php echo $ap_solicitud->estado_sol->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="estado_sol"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $ap_solicitud->SortUrl($ap_solicitud->estado_sol) ?>',1);"><div id="elh_ap_solicitud_estado_sol" class="ap_solicitud_estado_sol">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $ap_solicitud->estado_sol->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($ap_solicitud->estado_sol->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($ap_solicitud->estado_sol->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($ap_solicitud->fecha_prevista_sol->Visible) { // fecha_prevista_sol ?>
	<?php if ($ap_solicitud->SortUrl($ap_solicitud->fecha_prevista_sol) == "") { ?>
		<th data-name="fecha_prevista_sol"><div id="elh_ap_solicitud_fecha_prevista_sol" class="ap_solicitud_fecha_prevista_sol"><div class="ewTableHeaderCaption"><?php echo $ap_solicitud->fecha_prevista_sol->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="fecha_prevista_sol"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $ap_solicitud->SortUrl($ap_solicitud->fecha_prevista_sol) ?>',1);"><div id="elh_ap_solicitud_fecha_prevista_sol" class="ap_solicitud_fecha_prevista_sol">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $ap_solicitud->fecha_prevista_sol->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($ap_solicitud->fecha_prevista_sol->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($ap_solicitud->fecha_prevista_sol->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($ap_solicitud->fecha_obra_sol->Visible) { // fecha_obra_sol ?>
	<?php if ($ap_solicitud->SortUrl($ap_solicitud->fecha_obra_sol) == "") { ?>
		<th data-name="fecha_obra_sol"><div id="elh_ap_solicitud_fecha_obra_sol" class="ap_solicitud_fecha_obra_sol"><div class="ewTableHeaderCaption"><?php echo $ap_solicitud->fecha_obra_sol->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="fecha_obra_sol"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $ap_solicitud->SortUrl($ap_solicitud->fecha_obra_sol) ?>',1);"><div id="elh_ap_solicitud_fecha_obra_sol" class="ap_solicitud_fecha_obra_sol">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $ap_solicitud->fecha_obra_sol->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($ap_solicitud->fecha_obra_sol->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($ap_solicitud->fecha_obra_sol->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($ap_solicitud->fecha_visita_comerc_sol->Visible) { // fecha_visita_comerc_sol ?>
	<?php if ($ap_solicitud->SortUrl($ap_solicitud->fecha_visita_comerc_sol) == "") { ?>
		<th data-name="fecha_visita_comerc_sol"><div id="elh_ap_solicitud_fecha_visita_comerc_sol" class="ap_solicitud_fecha_visita_comerc_sol"><div class="ewTableHeaderCaption"><?php echo $ap_solicitud->fecha_visita_comerc_sol->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="fecha_visita_comerc_sol"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $ap_solicitud->SortUrl($ap_solicitud->fecha_visita_comerc_sol) ?>',1);"><div id="elh_ap_solicitud_fecha_visita_comerc_sol" class="ap_solicitud_fecha_visita_comerc_sol">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $ap_solicitud->fecha_visita_comerc_sol->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($ap_solicitud->fecha_visita_comerc_sol->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($ap_solicitud->fecha_visita_comerc_sol->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($ap_solicitud->obs_estado_sol->Visible) { // obs_estado_sol ?>
	<?php if ($ap_solicitud->SortUrl($ap_solicitud->obs_estado_sol) == "") { ?>
		<th data-name="obs_estado_sol"><div id="elh_ap_solicitud_obs_estado_sol" class="ap_solicitud_obs_estado_sol"><div class="ewTableHeaderCaption"><?php echo $ap_solicitud->obs_estado_sol->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="obs_estado_sol"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $ap_solicitud->SortUrl($ap_solicitud->obs_estado_sol) ?>',1);"><div id="elh_ap_solicitud_obs_estado_sol" class="ap_solicitud_obs_estado_sol">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $ap_solicitud->obs_estado_sol->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($ap_solicitud->obs_estado_sol->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($ap_solicitud->obs_estado_sol->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$ap_solicitud_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($ap_solicitud->ExportAll && $ap_solicitud->Export <> "") {
	$ap_solicitud_list->StopRec = $ap_solicitud_list->TotalRecs;
} else {

	// Set the last record to display
	if ($ap_solicitud_list->TotalRecs > $ap_solicitud_list->StartRec + $ap_solicitud_list->DisplayRecs - 1)
		$ap_solicitud_list->StopRec = $ap_solicitud_list->StartRec + $ap_solicitud_list->DisplayRecs - 1;
	else
		$ap_solicitud_list->StopRec = $ap_solicitud_list->TotalRecs;
}
$ap_solicitud_list->RecCnt = $ap_solicitud_list->StartRec - 1;
if ($ap_solicitud_list->Recordset && !$ap_solicitud_list->Recordset->EOF) {
	$ap_solicitud_list->Recordset->MoveFirst();
	$bSelectLimit = $ap_solicitud_list->UseSelectLimit;
	if (!$bSelectLimit && $ap_solicitud_list->StartRec > 1)
		$ap_solicitud_list->Recordset->Move($ap_solicitud_list->StartRec - 1);
} elseif (!$ap_solicitud->AllowAddDeleteRow && $ap_solicitud_list->StopRec == 0) {
	$ap_solicitud_list->StopRec = $ap_solicitud->GridAddRowCount;
}

// Initialize aggregate
$ap_solicitud->RowType = EW_ROWTYPE_AGGREGATEINIT;
$ap_solicitud->ResetAttrs();
$ap_solicitud_list->RenderRow();
while ($ap_solicitud_list->RecCnt < $ap_solicitud_list->StopRec) {
	$ap_solicitud_list->RecCnt++;
	if (intval($ap_solicitud_list->RecCnt) >= intval($ap_solicitud_list->StartRec)) {
		$ap_solicitud_list->RowCnt++;

		// Set up key count
		$ap_solicitud_list->KeyCount = $ap_solicitud_list->RowIndex;

		// Init row class and style
		$ap_solicitud->ResetAttrs();
		$ap_solicitud->CssClass = "";
		if ($ap_solicitud->CurrentAction == "gridadd") {
		} else {
			$ap_solicitud_list->LoadRowValues($ap_solicitud_list->Recordset); // Load row values
		}
		$ap_solicitud->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$ap_solicitud->RowAttrs = array_merge($ap_solicitud->RowAttrs, array('data-rowindex'=>$ap_solicitud_list->RowCnt, 'id'=>'r' . $ap_solicitud_list->RowCnt . '_ap_solicitud', 'data-rowtype'=>$ap_solicitud->RowType));

		// Render row
		$ap_solicitud_list->RenderRow();

		// Render list options
		$ap_solicitud_list->RenderListOptions();
?>
	<tr<?php echo $ap_solicitud->RowAttributes() ?>>
<?php

// Render list options (body, left)
$ap_solicitud_list->ListOptions->Render("body", "left", $ap_solicitud_list->RowCnt);
?>
	<?php if ($ap_solicitud->id_sol->Visible) { // id_sol ?>
		<td data-name="id_sol"<?php echo $ap_solicitud->id_sol->CellAttributes() ?>>
<span id="el<?php echo $ap_solicitud_list->RowCnt ?>_ap_solicitud_id_sol" class="ap_solicitud_id_sol">
<span<?php echo $ap_solicitud->id_sol->ViewAttributes() ?>>
<?php echo $ap_solicitud->id_sol->ListViewValue() ?></span>
</span>
<a id="<?php echo $ap_solicitud_list->PageObjName . "_row_" . $ap_solicitud_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($ap_solicitud->poliza_sol->Visible) { // poliza_sol ?>
		<td data-name="poliza_sol"<?php echo $ap_solicitud->poliza_sol->CellAttributes() ?>>
<span id="el<?php echo $ap_solicitud_list->RowCnt ?>_ap_solicitud_poliza_sol" class="ap_solicitud_poliza_sol">
<span<?php echo $ap_solicitud->poliza_sol->ViewAttributes() ?>>
<?php echo $ap_solicitud->poliza_sol->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($ap_solicitud->demanda_sol->Visible) { // demanda_sol ?>
		<td data-name="demanda_sol"<?php echo $ap_solicitud->demanda_sol->CellAttributes() ?>>
<span id="el<?php echo $ap_solicitud_list->RowCnt ?>_ap_solicitud_demanda_sol" class="ap_solicitud_demanda_sol">
<span<?php echo $ap_solicitud->demanda_sol->ViewAttributes() ?>>
<?php echo $ap_solicitud->demanda_sol->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($ap_solicitud->asesor_sol->Visible) { // asesor_sol ?>
		<td data-name="asesor_sol"<?php echo $ap_solicitud->asesor_sol->CellAttributes() ?>>
<span id="el<?php echo $ap_solicitud_list->RowCnt ?>_ap_solicitud_asesor_sol" class="ap_solicitud_asesor_sol">
<span<?php echo $ap_solicitud->asesor_sol->ViewAttributes() ?>>
<?php echo $ap_solicitud->asesor_sol->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($ap_solicitud->asignacion_sol->Visible) { // asignacion_sol ?>
		<td data-name="asignacion_sol"<?php echo $ap_solicitud->asignacion_sol->CellAttributes() ?>>
<span id="el<?php echo $ap_solicitud_list->RowCnt ?>_ap_solicitud_asignacion_sol" class="ap_solicitud_asignacion_sol">
<span<?php echo $ap_solicitud->asignacion_sol->ViewAttributes() ?>>
<?php echo $ap_solicitud->asignacion_sol->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($ap_solicitud->cedula_sol->Visible) { // cedula_sol ?>
		<td data-name="cedula_sol"<?php echo $ap_solicitud->cedula_sol->CellAttributes() ?>>
<span id="el<?php echo $ap_solicitud_list->RowCnt ?>_ap_solicitud_cedula_sol" class="ap_solicitud_cedula_sol">
<span<?php echo $ap_solicitud->cedula_sol->ViewAttributes() ?>>
<?php echo $ap_solicitud->cedula_sol->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($ap_solicitud->nombre_sol->Visible) { // nombre_sol ?>
		<td data-name="nombre_sol"<?php echo $ap_solicitud->nombre_sol->CellAttributes() ?>>
<span id="el<?php echo $ap_solicitud_list->RowCnt ?>_ap_solicitud_nombre_sol" class="ap_solicitud_nombre_sol">
<span<?php echo $ap_solicitud->nombre_sol->ViewAttributes() ?>>
<?php echo $ap_solicitud->nombre_sol->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($ap_solicitud->direccion_pol_sol->Visible) { // direccion_pol_sol ?>
		<td data-name="direccion_pol_sol"<?php echo $ap_solicitud->direccion_pol_sol->CellAttributes() ?>>
<span id="el<?php echo $ap_solicitud_list->RowCnt ?>_ap_solicitud_direccion_pol_sol" class="ap_solicitud_direccion_pol_sol">
<span<?php echo $ap_solicitud->direccion_pol_sol->ViewAttributes() ?>>
<?php echo $ap_solicitud->direccion_pol_sol->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($ap_solicitud->direccion_nueva_sol->Visible) { // direccion_nueva_sol ?>
		<td data-name="direccion_nueva_sol"<?php echo $ap_solicitud->direccion_nueva_sol->CellAttributes() ?>>
<span id="el<?php echo $ap_solicitud_list->RowCnt ?>_ap_solicitud_direccion_nueva_sol" class="ap_solicitud_direccion_nueva_sol">
<span<?php echo $ap_solicitud->direccion_nueva_sol->ViewAttributes() ?>>
<?php echo $ap_solicitud->direccion_nueva_sol->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($ap_solicitud->localidad_sol->Visible) { // localidad_sol ?>
		<td data-name="localidad_sol"<?php echo $ap_solicitud->localidad_sol->CellAttributes() ?>>
<span id="el<?php echo $ap_solicitud_list->RowCnt ?>_ap_solicitud_localidad_sol" class="ap_solicitud_localidad_sol">
<span<?php echo $ap_solicitud->localidad_sol->ViewAttributes() ?>>
<?php echo $ap_solicitud->localidad_sol->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($ap_solicitud->barrio_sol->Visible) { // barrio_sol ?>
		<td data-name="barrio_sol"<?php echo $ap_solicitud->barrio_sol->CellAttributes() ?>>
<span id="el<?php echo $ap_solicitud_list->RowCnt ?>_ap_solicitud_barrio_sol" class="ap_solicitud_barrio_sol">
<span<?php echo $ap_solicitud->barrio_sol->ViewAttributes() ?>>
<?php echo $ap_solicitud->barrio_sol->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($ap_solicitud->telefono1_sol->Visible) { // telefono1_sol ?>
		<td data-name="telefono1_sol"<?php echo $ap_solicitud->telefono1_sol->CellAttributes() ?>>
<span id="el<?php echo $ap_solicitud_list->RowCnt ?>_ap_solicitud_telefono1_sol" class="ap_solicitud_telefono1_sol">
<span<?php echo $ap_solicitud->telefono1_sol->ViewAttributes() ?>>
<?php echo $ap_solicitud->telefono1_sol->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($ap_solicitud->telefono2_sol->Visible) { // telefono2_sol ?>
		<td data-name="telefono2_sol"<?php echo $ap_solicitud->telefono2_sol->CellAttributes() ?>>
<span id="el<?php echo $ap_solicitud_list->RowCnt ?>_ap_solicitud_telefono2_sol" class="ap_solicitud_telefono2_sol">
<span<?php echo $ap_solicitud->telefono2_sol->ViewAttributes() ?>>
<?php echo $ap_solicitud->telefono2_sol->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($ap_solicitud->celular_sol->Visible) { // celular_sol ?>
		<td data-name="celular_sol"<?php echo $ap_solicitud->celular_sol->CellAttributes() ?>>
<span id="el<?php echo $ap_solicitud_list->RowCnt ?>_ap_solicitud_celular_sol" class="ap_solicitud_celular_sol">
<span<?php echo $ap_solicitud->celular_sol->ViewAttributes() ?>>
<?php echo $ap_solicitud->celular_sol->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($ap_solicitud->servicio_sol->Visible) { // servicio_sol ?>
		<td data-name="servicio_sol"<?php echo $ap_solicitud->servicio_sol->CellAttributes() ?>>
<span id="el<?php echo $ap_solicitud_list->RowCnt ?>_ap_solicitud_servicio_sol" class="ap_solicitud_servicio_sol">
<span<?php echo $ap_solicitud->servicio_sol->ViewAttributes() ?>>
<?php echo $ap_solicitud->servicio_sol->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($ap_solicitud->obs_sol->Visible) { // obs_sol ?>
		<td data-name="obs_sol"<?php echo $ap_solicitud->obs_sol->CellAttributes() ?>>
<span id="el<?php echo $ap_solicitud_list->RowCnt ?>_ap_solicitud_obs_sol" class="ap_solicitud_obs_sol">
<span<?php echo $ap_solicitud->obs_sol->ViewAttributes() ?>>
<?php echo $ap_solicitud->obs_sol->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($ap_solicitud->estado_sol->Visible) { // estado_sol ?>
		<td data-name="estado_sol"<?php echo $ap_solicitud->estado_sol->CellAttributes() ?>>
<span id="el<?php echo $ap_solicitud_list->RowCnt ?>_ap_solicitud_estado_sol" class="ap_solicitud_estado_sol">
<span<?php echo $ap_solicitud->estado_sol->ViewAttributes() ?>>
<?php echo $ap_solicitud->estado_sol->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($ap_solicitud->fecha_prevista_sol->Visible) { // fecha_prevista_sol ?>
		<td data-name="fecha_prevista_sol"<?php echo $ap_solicitud->fecha_prevista_sol->CellAttributes() ?>>
<span id="el<?php echo $ap_solicitud_list->RowCnt ?>_ap_solicitud_fecha_prevista_sol" class="ap_solicitud_fecha_prevista_sol">
<span<?php echo $ap_solicitud->fecha_prevista_sol->ViewAttributes() ?>>
<?php echo $ap_solicitud->fecha_prevista_sol->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($ap_solicitud->fecha_obra_sol->Visible) { // fecha_obra_sol ?>
		<td data-name="fecha_obra_sol"<?php echo $ap_solicitud->fecha_obra_sol->CellAttributes() ?>>
<span id="el<?php echo $ap_solicitud_list->RowCnt ?>_ap_solicitud_fecha_obra_sol" class="ap_solicitud_fecha_obra_sol">
<span<?php echo $ap_solicitud->fecha_obra_sol->ViewAttributes() ?>>
<?php echo $ap_solicitud->fecha_obra_sol->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($ap_solicitud->fecha_visita_comerc_sol->Visible) { // fecha_visita_comerc_sol ?>
		<td data-name="fecha_visita_comerc_sol"<?php echo $ap_solicitud->fecha_visita_comerc_sol->CellAttributes() ?>>
<span id="el<?php echo $ap_solicitud_list->RowCnt ?>_ap_solicitud_fecha_visita_comerc_sol" class="ap_solicitud_fecha_visita_comerc_sol">
<span<?php echo $ap_solicitud->fecha_visita_comerc_sol->ViewAttributes() ?>>
<?php echo $ap_solicitud->fecha_visita_comerc_sol->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($ap_solicitud->obs_estado_sol->Visible) { // obs_estado_sol ?>
		<td data-name="obs_estado_sol"<?php echo $ap_solicitud->obs_estado_sol->CellAttributes() ?>>
<span id="el<?php echo $ap_solicitud_list->RowCnt ?>_ap_solicitud_obs_estado_sol" class="ap_solicitud_obs_estado_sol">
<span<?php echo $ap_solicitud->obs_estado_sol->ViewAttributes() ?>>
<?php echo $ap_solicitud->obs_estado_sol->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$ap_solicitud_list->ListOptions->Render("body", "right", $ap_solicitud_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($ap_solicitud->CurrentAction <> "gridadd")
		$ap_solicitud_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($ap_solicitud->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($ap_solicitud_list->Recordset)
	$ap_solicitud_list->Recordset->Close();
?>
<?php if ($ap_solicitud->Export == "") { ?>
<div class="panel-footer ewGridLowerPanel">
<?php if ($ap_solicitud->CurrentAction <> "gridadd" && $ap_solicitud->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($ap_solicitud_list->Pager)) $ap_solicitud_list->Pager = new cPrevNextPager($ap_solicitud_list->StartRec, $ap_solicitud_list->DisplayRecs, $ap_solicitud_list->TotalRecs) ?>
<?php if ($ap_solicitud_list->Pager->RecordCount > 0 && $ap_solicitud_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($ap_solicitud_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $ap_solicitud_list->PageUrl() ?>start=<?php echo $ap_solicitud_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($ap_solicitud_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $ap_solicitud_list->PageUrl() ?>start=<?php echo $ap_solicitud_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $ap_solicitud_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($ap_solicitud_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $ap_solicitud_list->PageUrl() ?>start=<?php echo $ap_solicitud_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($ap_solicitud_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $ap_solicitud_list->PageUrl() ?>start=<?php echo $ap_solicitud_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $ap_solicitud_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $ap_solicitud_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $ap_solicitud_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $ap_solicitud_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($ap_solicitud_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div>
<?php } ?>
<?php if ($ap_solicitud_list->TotalRecs == 0 && $ap_solicitud->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($ap_solicitud_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($ap_solicitud->Export == "") { ?>
<script type="text/javascript">
fap_solicitudlistsrch.FilterList = <?php echo $ap_solicitud_list->GetFilterList() ?>;
fap_solicitudlistsrch.Init();
fap_solicitudlist.Init();
</script>
<?php } ?>
<?php
$ap_solicitud_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($ap_solicitud->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$ap_solicitud_list->Page_Terminate();
?>
