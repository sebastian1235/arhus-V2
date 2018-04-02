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

$ap_items_inv_list = NULL; // Initialize page object first

class cap_items_inv_list extends cap_items_inv {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{6A9AC718-A824-45A3-BED3-A95E91E6986D}";

	// Table name
	var $TableName = 'ap_items_inv';

	// Page object name
	var $PageObjName = 'ap_items_inv_list';

	// Grid form hidden field names
	var $FormName = 'fap_items_invlist';
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

		// Table object (ap_items_inv)
		if (!isset($GLOBALS["ap_items_inv"]) || get_class($GLOBALS["ap_items_inv"]) == "cap_items_inv") {
			$GLOBALS["ap_items_inv"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["ap_items_inv"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "ap_items_invadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "ap_items_invdelete.php";
		$this->MultiUpdateUrl = "ap_items_invupdate.php";

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption fap_items_invlistsrch";

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
			$this->Id_Item->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->Id_Item->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Get list of filters
	function GetFilterList() {
		global $UserProfile;

		// Load server side filters
		if (EW_SEARCH_FILTER_OPTION == "Server") {
			$sSavedFilterList = $UserProfile->GetSearchFilters(CurrentUserName(), "fap_items_invlistsrch");
		} else {
			$sSavedFilterList = "";
		}

		// Initialize
		$sFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->Id_Item->AdvancedSearch->ToJSON(), ","); // Field Id_Item
		$sFilterList = ew_Concat($sFilterList, $this->codigo_item->AdvancedSearch->ToJSON(), ","); // Field codigo_item
		$sFilterList = ew_Concat($sFilterList, $this->nombre_item->AdvancedSearch->ToJSON(), ","); // Field nombre_item
		$sFilterList = ew_Concat($sFilterList, $this->und_item->AdvancedSearch->ToJSON(), ","); // Field und_item
		$sFilterList = ew_Concat($sFilterList, $this->precio_item->AdvancedSearch->ToJSON(), ","); // Field precio_item
		$sFilterList = ew_Concat($sFilterList, $this->costo_item->AdvancedSearch->ToJSON(), ","); // Field costo_item
		$sFilterList = ew_Concat($sFilterList, $this->tipo_item->AdvancedSearch->ToJSON(), ","); // Field tipo_item
		$sFilterList = ew_Concat($sFilterList, $this->marca_item->AdvancedSearch->ToJSON(), ","); // Field marca_item
		$sFilterList = ew_Concat($sFilterList, $this->cod_marca_item->AdvancedSearch->ToJSON(), ","); // Field cod_marca_item
		$sFilterList = ew_Concat($sFilterList, $this->detalle_item->AdvancedSearch->ToJSON(), ","); // Field detalle_item
		$sFilterList = ew_Concat($sFilterList, $this->saldo_item->AdvancedSearch->ToJSON(), ","); // Field saldo_item
		$sFilterList = ew_Concat($sFilterList, $this->activo_item->AdvancedSearch->ToJSON(), ","); // Field activo_item
		$sFilterList = ew_Concat($sFilterList, $this->maneja_serial_item->AdvancedSearch->ToJSON(), ","); // Field maneja_serial_item
		$sFilterList = ew_Concat($sFilterList, $this->asignado_item->AdvancedSearch->ToJSON(), ","); // Field asignado_item
		$sFilterList = ew_Concat($sFilterList, $this->si_no_item->AdvancedSearch->ToJSON(), ","); // Field si_no_item
		$sFilterList = ew_Concat($sFilterList, $this->precio_old_item->AdvancedSearch->ToJSON(), ","); // Field precio_old_item
		$sFilterList = ew_Concat($sFilterList, $this->costo_old_item->AdvancedSearch->ToJSON(), ","); // Field costo_old_item
		$sFilterList = ew_Concat($sFilterList, $this->registra_item->AdvancedSearch->ToJSON(), ","); // Field registra_item
		$sFilterList = ew_Concat($sFilterList, $this->fecha_registro_item->AdvancedSearch->ToJSON(), ","); // Field fecha_registro_item
		$sFilterList = ew_Concat($sFilterList, $this->empresa_item->AdvancedSearch->ToJSON(), ","); // Field empresa_item
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
			$UserProfile->SetSearchFilters(CurrentUserName(), "fap_items_invlistsrch", $filters);
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

		// Field Id_Item
		$this->Id_Item->AdvancedSearch->SearchValue = @$filter["x_Id_Item"];
		$this->Id_Item->AdvancedSearch->SearchOperator = @$filter["z_Id_Item"];
		$this->Id_Item->AdvancedSearch->SearchCondition = @$filter["v_Id_Item"];
		$this->Id_Item->AdvancedSearch->SearchValue2 = @$filter["y_Id_Item"];
		$this->Id_Item->AdvancedSearch->SearchOperator2 = @$filter["w_Id_Item"];
		$this->Id_Item->AdvancedSearch->Save();

		// Field codigo_item
		$this->codigo_item->AdvancedSearch->SearchValue = @$filter["x_codigo_item"];
		$this->codigo_item->AdvancedSearch->SearchOperator = @$filter["z_codigo_item"];
		$this->codigo_item->AdvancedSearch->SearchCondition = @$filter["v_codigo_item"];
		$this->codigo_item->AdvancedSearch->SearchValue2 = @$filter["y_codigo_item"];
		$this->codigo_item->AdvancedSearch->SearchOperator2 = @$filter["w_codigo_item"];
		$this->codigo_item->AdvancedSearch->Save();

		// Field nombre_item
		$this->nombre_item->AdvancedSearch->SearchValue = @$filter["x_nombre_item"];
		$this->nombre_item->AdvancedSearch->SearchOperator = @$filter["z_nombre_item"];
		$this->nombre_item->AdvancedSearch->SearchCondition = @$filter["v_nombre_item"];
		$this->nombre_item->AdvancedSearch->SearchValue2 = @$filter["y_nombre_item"];
		$this->nombre_item->AdvancedSearch->SearchOperator2 = @$filter["w_nombre_item"];
		$this->nombre_item->AdvancedSearch->Save();

		// Field und_item
		$this->und_item->AdvancedSearch->SearchValue = @$filter["x_und_item"];
		$this->und_item->AdvancedSearch->SearchOperator = @$filter["z_und_item"];
		$this->und_item->AdvancedSearch->SearchCondition = @$filter["v_und_item"];
		$this->und_item->AdvancedSearch->SearchValue2 = @$filter["y_und_item"];
		$this->und_item->AdvancedSearch->SearchOperator2 = @$filter["w_und_item"];
		$this->und_item->AdvancedSearch->Save();

		// Field precio_item
		$this->precio_item->AdvancedSearch->SearchValue = @$filter["x_precio_item"];
		$this->precio_item->AdvancedSearch->SearchOperator = @$filter["z_precio_item"];
		$this->precio_item->AdvancedSearch->SearchCondition = @$filter["v_precio_item"];
		$this->precio_item->AdvancedSearch->SearchValue2 = @$filter["y_precio_item"];
		$this->precio_item->AdvancedSearch->SearchOperator2 = @$filter["w_precio_item"];
		$this->precio_item->AdvancedSearch->Save();

		// Field costo_item
		$this->costo_item->AdvancedSearch->SearchValue = @$filter["x_costo_item"];
		$this->costo_item->AdvancedSearch->SearchOperator = @$filter["z_costo_item"];
		$this->costo_item->AdvancedSearch->SearchCondition = @$filter["v_costo_item"];
		$this->costo_item->AdvancedSearch->SearchValue2 = @$filter["y_costo_item"];
		$this->costo_item->AdvancedSearch->SearchOperator2 = @$filter["w_costo_item"];
		$this->costo_item->AdvancedSearch->Save();

		// Field tipo_item
		$this->tipo_item->AdvancedSearch->SearchValue = @$filter["x_tipo_item"];
		$this->tipo_item->AdvancedSearch->SearchOperator = @$filter["z_tipo_item"];
		$this->tipo_item->AdvancedSearch->SearchCondition = @$filter["v_tipo_item"];
		$this->tipo_item->AdvancedSearch->SearchValue2 = @$filter["y_tipo_item"];
		$this->tipo_item->AdvancedSearch->SearchOperator2 = @$filter["w_tipo_item"];
		$this->tipo_item->AdvancedSearch->Save();

		// Field marca_item
		$this->marca_item->AdvancedSearch->SearchValue = @$filter["x_marca_item"];
		$this->marca_item->AdvancedSearch->SearchOperator = @$filter["z_marca_item"];
		$this->marca_item->AdvancedSearch->SearchCondition = @$filter["v_marca_item"];
		$this->marca_item->AdvancedSearch->SearchValue2 = @$filter["y_marca_item"];
		$this->marca_item->AdvancedSearch->SearchOperator2 = @$filter["w_marca_item"];
		$this->marca_item->AdvancedSearch->Save();

		// Field cod_marca_item
		$this->cod_marca_item->AdvancedSearch->SearchValue = @$filter["x_cod_marca_item"];
		$this->cod_marca_item->AdvancedSearch->SearchOperator = @$filter["z_cod_marca_item"];
		$this->cod_marca_item->AdvancedSearch->SearchCondition = @$filter["v_cod_marca_item"];
		$this->cod_marca_item->AdvancedSearch->SearchValue2 = @$filter["y_cod_marca_item"];
		$this->cod_marca_item->AdvancedSearch->SearchOperator2 = @$filter["w_cod_marca_item"];
		$this->cod_marca_item->AdvancedSearch->Save();

		// Field detalle_item
		$this->detalle_item->AdvancedSearch->SearchValue = @$filter["x_detalle_item"];
		$this->detalle_item->AdvancedSearch->SearchOperator = @$filter["z_detalle_item"];
		$this->detalle_item->AdvancedSearch->SearchCondition = @$filter["v_detalle_item"];
		$this->detalle_item->AdvancedSearch->SearchValue2 = @$filter["y_detalle_item"];
		$this->detalle_item->AdvancedSearch->SearchOperator2 = @$filter["w_detalle_item"];
		$this->detalle_item->AdvancedSearch->Save();

		// Field saldo_item
		$this->saldo_item->AdvancedSearch->SearchValue = @$filter["x_saldo_item"];
		$this->saldo_item->AdvancedSearch->SearchOperator = @$filter["z_saldo_item"];
		$this->saldo_item->AdvancedSearch->SearchCondition = @$filter["v_saldo_item"];
		$this->saldo_item->AdvancedSearch->SearchValue2 = @$filter["y_saldo_item"];
		$this->saldo_item->AdvancedSearch->SearchOperator2 = @$filter["w_saldo_item"];
		$this->saldo_item->AdvancedSearch->Save();

		// Field activo_item
		$this->activo_item->AdvancedSearch->SearchValue = @$filter["x_activo_item"];
		$this->activo_item->AdvancedSearch->SearchOperator = @$filter["z_activo_item"];
		$this->activo_item->AdvancedSearch->SearchCondition = @$filter["v_activo_item"];
		$this->activo_item->AdvancedSearch->SearchValue2 = @$filter["y_activo_item"];
		$this->activo_item->AdvancedSearch->SearchOperator2 = @$filter["w_activo_item"];
		$this->activo_item->AdvancedSearch->Save();

		// Field maneja_serial_item
		$this->maneja_serial_item->AdvancedSearch->SearchValue = @$filter["x_maneja_serial_item"];
		$this->maneja_serial_item->AdvancedSearch->SearchOperator = @$filter["z_maneja_serial_item"];
		$this->maneja_serial_item->AdvancedSearch->SearchCondition = @$filter["v_maneja_serial_item"];
		$this->maneja_serial_item->AdvancedSearch->SearchValue2 = @$filter["y_maneja_serial_item"];
		$this->maneja_serial_item->AdvancedSearch->SearchOperator2 = @$filter["w_maneja_serial_item"];
		$this->maneja_serial_item->AdvancedSearch->Save();

		// Field asignado_item
		$this->asignado_item->AdvancedSearch->SearchValue = @$filter["x_asignado_item"];
		$this->asignado_item->AdvancedSearch->SearchOperator = @$filter["z_asignado_item"];
		$this->asignado_item->AdvancedSearch->SearchCondition = @$filter["v_asignado_item"];
		$this->asignado_item->AdvancedSearch->SearchValue2 = @$filter["y_asignado_item"];
		$this->asignado_item->AdvancedSearch->SearchOperator2 = @$filter["w_asignado_item"];
		$this->asignado_item->AdvancedSearch->Save();

		// Field si_no_item
		$this->si_no_item->AdvancedSearch->SearchValue = @$filter["x_si_no_item"];
		$this->si_no_item->AdvancedSearch->SearchOperator = @$filter["z_si_no_item"];
		$this->si_no_item->AdvancedSearch->SearchCondition = @$filter["v_si_no_item"];
		$this->si_no_item->AdvancedSearch->SearchValue2 = @$filter["y_si_no_item"];
		$this->si_no_item->AdvancedSearch->SearchOperator2 = @$filter["w_si_no_item"];
		$this->si_no_item->AdvancedSearch->Save();

		// Field precio_old_item
		$this->precio_old_item->AdvancedSearch->SearchValue = @$filter["x_precio_old_item"];
		$this->precio_old_item->AdvancedSearch->SearchOperator = @$filter["z_precio_old_item"];
		$this->precio_old_item->AdvancedSearch->SearchCondition = @$filter["v_precio_old_item"];
		$this->precio_old_item->AdvancedSearch->SearchValue2 = @$filter["y_precio_old_item"];
		$this->precio_old_item->AdvancedSearch->SearchOperator2 = @$filter["w_precio_old_item"];
		$this->precio_old_item->AdvancedSearch->Save();

		// Field costo_old_item
		$this->costo_old_item->AdvancedSearch->SearchValue = @$filter["x_costo_old_item"];
		$this->costo_old_item->AdvancedSearch->SearchOperator = @$filter["z_costo_old_item"];
		$this->costo_old_item->AdvancedSearch->SearchCondition = @$filter["v_costo_old_item"];
		$this->costo_old_item->AdvancedSearch->SearchValue2 = @$filter["y_costo_old_item"];
		$this->costo_old_item->AdvancedSearch->SearchOperator2 = @$filter["w_costo_old_item"];
		$this->costo_old_item->AdvancedSearch->Save();

		// Field registra_item
		$this->registra_item->AdvancedSearch->SearchValue = @$filter["x_registra_item"];
		$this->registra_item->AdvancedSearch->SearchOperator = @$filter["z_registra_item"];
		$this->registra_item->AdvancedSearch->SearchCondition = @$filter["v_registra_item"];
		$this->registra_item->AdvancedSearch->SearchValue2 = @$filter["y_registra_item"];
		$this->registra_item->AdvancedSearch->SearchOperator2 = @$filter["w_registra_item"];
		$this->registra_item->AdvancedSearch->Save();

		// Field fecha_registro_item
		$this->fecha_registro_item->AdvancedSearch->SearchValue = @$filter["x_fecha_registro_item"];
		$this->fecha_registro_item->AdvancedSearch->SearchOperator = @$filter["z_fecha_registro_item"];
		$this->fecha_registro_item->AdvancedSearch->SearchCondition = @$filter["v_fecha_registro_item"];
		$this->fecha_registro_item->AdvancedSearch->SearchValue2 = @$filter["y_fecha_registro_item"];
		$this->fecha_registro_item->AdvancedSearch->SearchOperator2 = @$filter["w_fecha_registro_item"];
		$this->fecha_registro_item->AdvancedSearch->Save();

		// Field empresa_item
		$this->empresa_item->AdvancedSearch->SearchValue = @$filter["x_empresa_item"];
		$this->empresa_item->AdvancedSearch->SearchOperator = @$filter["z_empresa_item"];
		$this->empresa_item->AdvancedSearch->SearchCondition = @$filter["v_empresa_item"];
		$this->empresa_item->AdvancedSearch->SearchValue2 = @$filter["y_empresa_item"];
		$this->empresa_item->AdvancedSearch->SearchOperator2 = @$filter["w_empresa_item"];
		$this->empresa_item->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->codigo_item, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->nombre_item, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->marca_item, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->cod_marca_item, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->detalle_item, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->registra_item, $arKeywords, $type);
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
			$this->UpdateSort($this->Id_Item); // Id_Item
			$this->UpdateSort($this->codigo_item); // codigo_item
			$this->UpdateSort($this->nombre_item); // nombre_item
			$this->UpdateSort($this->und_item); // und_item
			$this->UpdateSort($this->precio_item); // precio_item
			$this->UpdateSort($this->costo_item); // costo_item
			$this->UpdateSort($this->tipo_item); // tipo_item
			$this->UpdateSort($this->marca_item); // marca_item
			$this->UpdateSort($this->cod_marca_item); // cod_marca_item
			$this->UpdateSort($this->detalle_item); // detalle_item
			$this->UpdateSort($this->saldo_item); // saldo_item
			$this->UpdateSort($this->activo_item); // activo_item
			$this->UpdateSort($this->maneja_serial_item); // maneja_serial_item
			$this->UpdateSort($this->asignado_item); // asignado_item
			$this->UpdateSort($this->si_no_item); // si_no_item
			$this->UpdateSort($this->precio_old_item); // precio_old_item
			$this->UpdateSort($this->costo_old_item); // costo_old_item
			$this->UpdateSort($this->registra_item); // registra_item
			$this->UpdateSort($this->fecha_registro_item); // fecha_registro_item
			$this->UpdateSort($this->empresa_item); // empresa_item
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
				$this->Id_Item->setSort("");
				$this->codigo_item->setSort("");
				$this->nombre_item->setSort("");
				$this->und_item->setSort("");
				$this->precio_item->setSort("");
				$this->costo_item->setSort("");
				$this->tipo_item->setSort("");
				$this->marca_item->setSort("");
				$this->cod_marca_item->setSort("");
				$this->detalle_item->setSort("");
				$this->saldo_item->setSort("");
				$this->activo_item->setSort("");
				$this->maneja_serial_item->setSort("");
				$this->asignado_item->setSort("");
				$this->si_no_item->setSort("");
				$this->precio_old_item->setSort("");
				$this->costo_old_item->setSort("");
				$this->registra_item->setSort("");
				$this->fecha_registro_item->setSort("");
				$this->empresa_item->setSort("");
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
		$item->OnLeft = FALSE;
		$item->Visible = FALSE;

		// "view"
		$item = &$this->ListOptions->Add("view");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanView();
		$item->OnLeft = FALSE;

		// "edit"
		$item = &$this->ListOptions->Add("edit");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanEdit();
		$item->OnLeft = FALSE;

		// "copy"
		$item = &$this->ListOptions->Add("copy");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanAdd();
		$item->OnLeft = FALSE;

		// List actions
		$item = &$this->ListOptions->Add("listactions");
		$item->CssStyle = "white-space: nowrap;";
		$item->OnLeft = FALSE;
		$item->Visible = FALSE;
		$item->ShowInButtonGroup = FALSE;
		$item->ShowInDropDown = FALSE;

		// "checkbox"
		$item = &$this->ListOptions->Add("checkbox");
		$item->Visible = $Security->CanDelete();
		$item->OnLeft = FALSE;
		$item->Header = "<input type=\"checkbox\" name=\"key\" id=\"key\" onclick=\"ew_SelectAllKey(this);\">";
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
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->Id_Item->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event);'>";
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

		// Add multi delete
		$item = &$option->Add("multidelete");
		$item->Body = "<a class=\"ewAction ewMultiDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" href=\"\" onclick=\"ew_SubmitAction(event,{f:document.fap_items_invlist,url:'" . $this->MultiDeleteUrl . "'});return false;\">" . $Language->Phrase("DeleteSelectedLink") . "</a>";
		$item->Visible = ($Security->CanDelete());

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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fap_items_invlistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fap_items_invlistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fap_items_invlist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fap_items_invlistsrch\">" . $Language->Phrase("SearchBtn") . "</button>";
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

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("Id_Item")) <> "")
			$this->Id_Item->CurrentValue = $this->getKey("Id_Item"); // Id_Item
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
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Set up export options
	function SetupExportOptions() {
		global $Language;

		// Printer friendly
		$item = &$this->ExportOptions->Add("print");
		$item->Body = "<a href=\"" . $this->ExportPrintUrl . "\" class=\"ewExportLink ewPrint\" title=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\">" . $Language->Phrase("PrinterFriendly") . "</a>";
		$item->Visible = FALSE;

		// Export to Excel
		$item = &$this->ExportOptions->Add("excel");
		$item->Body = "<a href=\"" . $this->ExportExcelUrl . "\" class=\"ewExportLink ewExcel\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\">" . $Language->Phrase("ExportToExcel") . "</a>";
		$item->Visible = FALSE;

		// Export to Word
		$item = &$this->ExportOptions->Add("word");
		$item->Body = "<a href=\"" . $this->ExportWordUrl . "\" class=\"ewExportLink ewWord\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\">" . $Language->Phrase("ExportToWord") . "</a>";
		$item->Visible = FALSE;

		// Export to Html
		$item = &$this->ExportOptions->Add("html");
		$item->Body = "<a href=\"" . $this->ExportHtmlUrl . "\" class=\"ewExportLink ewHtml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\">" . $Language->Phrase("ExportToHtml") . "</a>";
		$item->Visible = FALSE;

		// Export to Xml
		$item = &$this->ExportOptions->Add("xml");
		$item->Body = "<a href=\"" . $this->ExportXmlUrl . "\" class=\"ewExportLink ewXml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\">" . $Language->Phrase("ExportToXml") . "</a>";
		$item->Visible = FALSE;

		// Export to Csv
		$item = &$this->ExportOptions->Add("csv");
		$item->Body = "<a href=\"" . $this->ExportCsvUrl . "\" class=\"ewExportLink ewCsv\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\">" . $Language->Phrase("ExportToCsv") . "</a>";
		$item->Visible = FALSE;

		// Export to Pdf
		$item = &$this->ExportOptions->Add("pdf");
		$item->Body = "<a href=\"" . $this->ExportPdfUrl . "\" class=\"ewExportLink ewPdf\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\">" . $Language->Phrase("ExportToPDF") . "</a>";
		$item->Visible = FALSE;

		// Export to Email
		$item = &$this->ExportOptions->Add("email");
		$url = "";
		$item->Body = "<button id=\"emf_ap_items_inv\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_ap_items_inv',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fap_items_invlist,sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
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
if (!isset($ap_items_inv_list)) $ap_items_inv_list = new cap_items_inv_list();

// Page init
$ap_items_inv_list->Page_Init();

// Page main
$ap_items_inv_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$ap_items_inv_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($ap_items_inv->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fap_items_invlist = new ew_Form("fap_items_invlist", "list");
fap_items_invlist.FormKeyCountName = '<?php echo $ap_items_inv_list->FormKeyCountName ?>';

// Form_CustomValidate event
fap_items_invlist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fap_items_invlist.ValidateRequired = true;
<?php } else { ?>
fap_items_invlist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

var CurrentSearchForm = fap_items_invlistsrch = new ew_Form("fap_items_invlistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($ap_items_inv->Export == "") { ?>
<div class="ewToolbar">
<?php if ($ap_items_inv->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if ($ap_items_inv_list->TotalRecs > 0 && $ap_items_inv_list->ExportOptions->Visible()) { ?>
<?php $ap_items_inv_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($ap_items_inv_list->SearchOptions->Visible()) { ?>
<?php $ap_items_inv_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($ap_items_inv_list->FilterOptions->Visible()) { ?>
<?php $ap_items_inv_list->FilterOptions->Render("body") ?>
<?php } ?>
<?php if ($ap_items_inv->Export == "") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
	$bSelectLimit = $ap_items_inv_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($ap_items_inv_list->TotalRecs <= 0)
			$ap_items_inv_list->TotalRecs = $ap_items_inv->SelectRecordCount();
	} else {
		if (!$ap_items_inv_list->Recordset && ($ap_items_inv_list->Recordset = $ap_items_inv_list->LoadRecordset()))
			$ap_items_inv_list->TotalRecs = $ap_items_inv_list->Recordset->RecordCount();
	}
	$ap_items_inv_list->StartRec = 1;
	if ($ap_items_inv_list->DisplayRecs <= 0 || ($ap_items_inv->Export <> "" && $ap_items_inv->ExportAll)) // Display all records
		$ap_items_inv_list->DisplayRecs = $ap_items_inv_list->TotalRecs;
	if (!($ap_items_inv->Export <> "" && $ap_items_inv->ExportAll))
		$ap_items_inv_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$ap_items_inv_list->Recordset = $ap_items_inv_list->LoadRecordset($ap_items_inv_list->StartRec-1, $ap_items_inv_list->DisplayRecs);

	// Set no record found message
	if ($ap_items_inv->CurrentAction == "" && $ap_items_inv_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$ap_items_inv_list->setWarningMessage(ew_DeniedMsg());
		if ($ap_items_inv_list->SearchWhere == "0=101")
			$ap_items_inv_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$ap_items_inv_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$ap_items_inv_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($ap_items_inv->Export == "" && $ap_items_inv->CurrentAction == "") { ?>
<form name="fap_items_invlistsrch" id="fap_items_invlistsrch" class="form-inline ewForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($ap_items_inv_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fap_items_invlistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="ap_items_inv">
	<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($ap_items_inv_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($ap_items_inv_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $ap_items_inv_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($ap_items_inv_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($ap_items_inv_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($ap_items_inv_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($ap_items_inv_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
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
<?php $ap_items_inv_list->ShowPageHeader(); ?>
<?php
$ap_items_inv_list->ShowMessage();
?>
<?php if ($ap_items_inv_list->TotalRecs > 0 || $ap_items_inv->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid ap_items_inv">
<form name="fap_items_invlist" id="fap_items_invlist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($ap_items_inv_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $ap_items_inv_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="ap_items_inv">
<div id="gmp_ap_items_inv" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php if ($ap_items_inv_list->TotalRecs > 0) { ?>
<table id="tbl_ap_items_invlist" class="table ewTable">
<?php echo $ap_items_inv->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$ap_items_inv_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$ap_items_inv_list->RenderListOptions();

// Render list options (header, left)
$ap_items_inv_list->ListOptions->Render("header", "left");
?>
<?php if ($ap_items_inv->Id_Item->Visible) { // Id_Item ?>
	<?php if ($ap_items_inv->SortUrl($ap_items_inv->Id_Item) == "") { ?>
		<th data-name="Id_Item"><div id="elh_ap_items_inv_Id_Item" class="ap_items_inv_Id_Item"><div class="ewTableHeaderCaption"><?php echo $ap_items_inv->Id_Item->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Item"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $ap_items_inv->SortUrl($ap_items_inv->Id_Item) ?>',1);"><div id="elh_ap_items_inv_Id_Item" class="ap_items_inv_Id_Item">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $ap_items_inv->Id_Item->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($ap_items_inv->Id_Item->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($ap_items_inv->Id_Item->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($ap_items_inv->codigo_item->Visible) { // codigo_item ?>
	<?php if ($ap_items_inv->SortUrl($ap_items_inv->codigo_item) == "") { ?>
		<th data-name="codigo_item"><div id="elh_ap_items_inv_codigo_item" class="ap_items_inv_codigo_item"><div class="ewTableHeaderCaption"><?php echo $ap_items_inv->codigo_item->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="codigo_item"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $ap_items_inv->SortUrl($ap_items_inv->codigo_item) ?>',1);"><div id="elh_ap_items_inv_codigo_item" class="ap_items_inv_codigo_item">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $ap_items_inv->codigo_item->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($ap_items_inv->codigo_item->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($ap_items_inv->codigo_item->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($ap_items_inv->nombre_item->Visible) { // nombre_item ?>
	<?php if ($ap_items_inv->SortUrl($ap_items_inv->nombre_item) == "") { ?>
		<th data-name="nombre_item"><div id="elh_ap_items_inv_nombre_item" class="ap_items_inv_nombre_item"><div class="ewTableHeaderCaption"><?php echo $ap_items_inv->nombre_item->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nombre_item"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $ap_items_inv->SortUrl($ap_items_inv->nombre_item) ?>',1);"><div id="elh_ap_items_inv_nombre_item" class="ap_items_inv_nombre_item">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $ap_items_inv->nombre_item->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($ap_items_inv->nombre_item->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($ap_items_inv->nombre_item->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($ap_items_inv->und_item->Visible) { // und_item ?>
	<?php if ($ap_items_inv->SortUrl($ap_items_inv->und_item) == "") { ?>
		<th data-name="und_item"><div id="elh_ap_items_inv_und_item" class="ap_items_inv_und_item"><div class="ewTableHeaderCaption"><?php echo $ap_items_inv->und_item->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="und_item"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $ap_items_inv->SortUrl($ap_items_inv->und_item) ?>',1);"><div id="elh_ap_items_inv_und_item" class="ap_items_inv_und_item">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $ap_items_inv->und_item->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($ap_items_inv->und_item->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($ap_items_inv->und_item->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($ap_items_inv->precio_item->Visible) { // precio_item ?>
	<?php if ($ap_items_inv->SortUrl($ap_items_inv->precio_item) == "") { ?>
		<th data-name="precio_item"><div id="elh_ap_items_inv_precio_item" class="ap_items_inv_precio_item"><div class="ewTableHeaderCaption"><?php echo $ap_items_inv->precio_item->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="precio_item"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $ap_items_inv->SortUrl($ap_items_inv->precio_item) ?>',1);"><div id="elh_ap_items_inv_precio_item" class="ap_items_inv_precio_item">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $ap_items_inv->precio_item->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($ap_items_inv->precio_item->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($ap_items_inv->precio_item->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($ap_items_inv->costo_item->Visible) { // costo_item ?>
	<?php if ($ap_items_inv->SortUrl($ap_items_inv->costo_item) == "") { ?>
		<th data-name="costo_item"><div id="elh_ap_items_inv_costo_item" class="ap_items_inv_costo_item"><div class="ewTableHeaderCaption"><?php echo $ap_items_inv->costo_item->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="costo_item"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $ap_items_inv->SortUrl($ap_items_inv->costo_item) ?>',1);"><div id="elh_ap_items_inv_costo_item" class="ap_items_inv_costo_item">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $ap_items_inv->costo_item->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($ap_items_inv->costo_item->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($ap_items_inv->costo_item->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($ap_items_inv->tipo_item->Visible) { // tipo_item ?>
	<?php if ($ap_items_inv->SortUrl($ap_items_inv->tipo_item) == "") { ?>
		<th data-name="tipo_item"><div id="elh_ap_items_inv_tipo_item" class="ap_items_inv_tipo_item"><div class="ewTableHeaderCaption"><?php echo $ap_items_inv->tipo_item->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tipo_item"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $ap_items_inv->SortUrl($ap_items_inv->tipo_item) ?>',1);"><div id="elh_ap_items_inv_tipo_item" class="ap_items_inv_tipo_item">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $ap_items_inv->tipo_item->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($ap_items_inv->tipo_item->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($ap_items_inv->tipo_item->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($ap_items_inv->marca_item->Visible) { // marca_item ?>
	<?php if ($ap_items_inv->SortUrl($ap_items_inv->marca_item) == "") { ?>
		<th data-name="marca_item"><div id="elh_ap_items_inv_marca_item" class="ap_items_inv_marca_item"><div class="ewTableHeaderCaption"><?php echo $ap_items_inv->marca_item->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="marca_item"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $ap_items_inv->SortUrl($ap_items_inv->marca_item) ?>',1);"><div id="elh_ap_items_inv_marca_item" class="ap_items_inv_marca_item">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $ap_items_inv->marca_item->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($ap_items_inv->marca_item->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($ap_items_inv->marca_item->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($ap_items_inv->cod_marca_item->Visible) { // cod_marca_item ?>
	<?php if ($ap_items_inv->SortUrl($ap_items_inv->cod_marca_item) == "") { ?>
		<th data-name="cod_marca_item"><div id="elh_ap_items_inv_cod_marca_item" class="ap_items_inv_cod_marca_item"><div class="ewTableHeaderCaption"><?php echo $ap_items_inv->cod_marca_item->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="cod_marca_item"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $ap_items_inv->SortUrl($ap_items_inv->cod_marca_item) ?>',1);"><div id="elh_ap_items_inv_cod_marca_item" class="ap_items_inv_cod_marca_item">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $ap_items_inv->cod_marca_item->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($ap_items_inv->cod_marca_item->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($ap_items_inv->cod_marca_item->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($ap_items_inv->detalle_item->Visible) { // detalle_item ?>
	<?php if ($ap_items_inv->SortUrl($ap_items_inv->detalle_item) == "") { ?>
		<th data-name="detalle_item"><div id="elh_ap_items_inv_detalle_item" class="ap_items_inv_detalle_item"><div class="ewTableHeaderCaption"><?php echo $ap_items_inv->detalle_item->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="detalle_item"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $ap_items_inv->SortUrl($ap_items_inv->detalle_item) ?>',1);"><div id="elh_ap_items_inv_detalle_item" class="ap_items_inv_detalle_item">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $ap_items_inv->detalle_item->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($ap_items_inv->detalle_item->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($ap_items_inv->detalle_item->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($ap_items_inv->saldo_item->Visible) { // saldo_item ?>
	<?php if ($ap_items_inv->SortUrl($ap_items_inv->saldo_item) == "") { ?>
		<th data-name="saldo_item"><div id="elh_ap_items_inv_saldo_item" class="ap_items_inv_saldo_item"><div class="ewTableHeaderCaption"><?php echo $ap_items_inv->saldo_item->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="saldo_item"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $ap_items_inv->SortUrl($ap_items_inv->saldo_item) ?>',1);"><div id="elh_ap_items_inv_saldo_item" class="ap_items_inv_saldo_item">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $ap_items_inv->saldo_item->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($ap_items_inv->saldo_item->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($ap_items_inv->saldo_item->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($ap_items_inv->activo_item->Visible) { // activo_item ?>
	<?php if ($ap_items_inv->SortUrl($ap_items_inv->activo_item) == "") { ?>
		<th data-name="activo_item"><div id="elh_ap_items_inv_activo_item" class="ap_items_inv_activo_item"><div class="ewTableHeaderCaption"><?php echo $ap_items_inv->activo_item->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="activo_item"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $ap_items_inv->SortUrl($ap_items_inv->activo_item) ?>',1);"><div id="elh_ap_items_inv_activo_item" class="ap_items_inv_activo_item">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $ap_items_inv->activo_item->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($ap_items_inv->activo_item->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($ap_items_inv->activo_item->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($ap_items_inv->maneja_serial_item->Visible) { // maneja_serial_item ?>
	<?php if ($ap_items_inv->SortUrl($ap_items_inv->maneja_serial_item) == "") { ?>
		<th data-name="maneja_serial_item"><div id="elh_ap_items_inv_maneja_serial_item" class="ap_items_inv_maneja_serial_item"><div class="ewTableHeaderCaption"><?php echo $ap_items_inv->maneja_serial_item->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="maneja_serial_item"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $ap_items_inv->SortUrl($ap_items_inv->maneja_serial_item) ?>',1);"><div id="elh_ap_items_inv_maneja_serial_item" class="ap_items_inv_maneja_serial_item">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $ap_items_inv->maneja_serial_item->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($ap_items_inv->maneja_serial_item->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($ap_items_inv->maneja_serial_item->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($ap_items_inv->asignado_item->Visible) { // asignado_item ?>
	<?php if ($ap_items_inv->SortUrl($ap_items_inv->asignado_item) == "") { ?>
		<th data-name="asignado_item"><div id="elh_ap_items_inv_asignado_item" class="ap_items_inv_asignado_item"><div class="ewTableHeaderCaption"><?php echo $ap_items_inv->asignado_item->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="asignado_item"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $ap_items_inv->SortUrl($ap_items_inv->asignado_item) ?>',1);"><div id="elh_ap_items_inv_asignado_item" class="ap_items_inv_asignado_item">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $ap_items_inv->asignado_item->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($ap_items_inv->asignado_item->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($ap_items_inv->asignado_item->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($ap_items_inv->si_no_item->Visible) { // si_no_item ?>
	<?php if ($ap_items_inv->SortUrl($ap_items_inv->si_no_item) == "") { ?>
		<th data-name="si_no_item"><div id="elh_ap_items_inv_si_no_item" class="ap_items_inv_si_no_item"><div class="ewTableHeaderCaption"><?php echo $ap_items_inv->si_no_item->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="si_no_item"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $ap_items_inv->SortUrl($ap_items_inv->si_no_item) ?>',1);"><div id="elh_ap_items_inv_si_no_item" class="ap_items_inv_si_no_item">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $ap_items_inv->si_no_item->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($ap_items_inv->si_no_item->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($ap_items_inv->si_no_item->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($ap_items_inv->precio_old_item->Visible) { // precio_old_item ?>
	<?php if ($ap_items_inv->SortUrl($ap_items_inv->precio_old_item) == "") { ?>
		<th data-name="precio_old_item"><div id="elh_ap_items_inv_precio_old_item" class="ap_items_inv_precio_old_item"><div class="ewTableHeaderCaption"><?php echo $ap_items_inv->precio_old_item->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="precio_old_item"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $ap_items_inv->SortUrl($ap_items_inv->precio_old_item) ?>',1);"><div id="elh_ap_items_inv_precio_old_item" class="ap_items_inv_precio_old_item">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $ap_items_inv->precio_old_item->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($ap_items_inv->precio_old_item->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($ap_items_inv->precio_old_item->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($ap_items_inv->costo_old_item->Visible) { // costo_old_item ?>
	<?php if ($ap_items_inv->SortUrl($ap_items_inv->costo_old_item) == "") { ?>
		<th data-name="costo_old_item"><div id="elh_ap_items_inv_costo_old_item" class="ap_items_inv_costo_old_item"><div class="ewTableHeaderCaption"><?php echo $ap_items_inv->costo_old_item->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="costo_old_item"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $ap_items_inv->SortUrl($ap_items_inv->costo_old_item) ?>',1);"><div id="elh_ap_items_inv_costo_old_item" class="ap_items_inv_costo_old_item">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $ap_items_inv->costo_old_item->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($ap_items_inv->costo_old_item->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($ap_items_inv->costo_old_item->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($ap_items_inv->registra_item->Visible) { // registra_item ?>
	<?php if ($ap_items_inv->SortUrl($ap_items_inv->registra_item) == "") { ?>
		<th data-name="registra_item"><div id="elh_ap_items_inv_registra_item" class="ap_items_inv_registra_item"><div class="ewTableHeaderCaption"><?php echo $ap_items_inv->registra_item->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="registra_item"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $ap_items_inv->SortUrl($ap_items_inv->registra_item) ?>',1);"><div id="elh_ap_items_inv_registra_item" class="ap_items_inv_registra_item">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $ap_items_inv->registra_item->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($ap_items_inv->registra_item->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($ap_items_inv->registra_item->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($ap_items_inv->fecha_registro_item->Visible) { // fecha_registro_item ?>
	<?php if ($ap_items_inv->SortUrl($ap_items_inv->fecha_registro_item) == "") { ?>
		<th data-name="fecha_registro_item"><div id="elh_ap_items_inv_fecha_registro_item" class="ap_items_inv_fecha_registro_item"><div class="ewTableHeaderCaption"><?php echo $ap_items_inv->fecha_registro_item->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="fecha_registro_item"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $ap_items_inv->SortUrl($ap_items_inv->fecha_registro_item) ?>',1);"><div id="elh_ap_items_inv_fecha_registro_item" class="ap_items_inv_fecha_registro_item">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $ap_items_inv->fecha_registro_item->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($ap_items_inv->fecha_registro_item->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($ap_items_inv->fecha_registro_item->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($ap_items_inv->empresa_item->Visible) { // empresa_item ?>
	<?php if ($ap_items_inv->SortUrl($ap_items_inv->empresa_item) == "") { ?>
		<th data-name="empresa_item"><div id="elh_ap_items_inv_empresa_item" class="ap_items_inv_empresa_item"><div class="ewTableHeaderCaption"><?php echo $ap_items_inv->empresa_item->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="empresa_item"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $ap_items_inv->SortUrl($ap_items_inv->empresa_item) ?>',1);"><div id="elh_ap_items_inv_empresa_item" class="ap_items_inv_empresa_item">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $ap_items_inv->empresa_item->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($ap_items_inv->empresa_item->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($ap_items_inv->empresa_item->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$ap_items_inv_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($ap_items_inv->ExportAll && $ap_items_inv->Export <> "") {
	$ap_items_inv_list->StopRec = $ap_items_inv_list->TotalRecs;
} else {

	// Set the last record to display
	if ($ap_items_inv_list->TotalRecs > $ap_items_inv_list->StartRec + $ap_items_inv_list->DisplayRecs - 1)
		$ap_items_inv_list->StopRec = $ap_items_inv_list->StartRec + $ap_items_inv_list->DisplayRecs - 1;
	else
		$ap_items_inv_list->StopRec = $ap_items_inv_list->TotalRecs;
}
$ap_items_inv_list->RecCnt = $ap_items_inv_list->StartRec - 1;
if ($ap_items_inv_list->Recordset && !$ap_items_inv_list->Recordset->EOF) {
	$ap_items_inv_list->Recordset->MoveFirst();
	$bSelectLimit = $ap_items_inv_list->UseSelectLimit;
	if (!$bSelectLimit && $ap_items_inv_list->StartRec > 1)
		$ap_items_inv_list->Recordset->Move($ap_items_inv_list->StartRec - 1);
} elseif (!$ap_items_inv->AllowAddDeleteRow && $ap_items_inv_list->StopRec == 0) {
	$ap_items_inv_list->StopRec = $ap_items_inv->GridAddRowCount;
}

// Initialize aggregate
$ap_items_inv->RowType = EW_ROWTYPE_AGGREGATEINIT;
$ap_items_inv->ResetAttrs();
$ap_items_inv_list->RenderRow();
while ($ap_items_inv_list->RecCnt < $ap_items_inv_list->StopRec) {
	$ap_items_inv_list->RecCnt++;
	if (intval($ap_items_inv_list->RecCnt) >= intval($ap_items_inv_list->StartRec)) {
		$ap_items_inv_list->RowCnt++;

		// Set up key count
		$ap_items_inv_list->KeyCount = $ap_items_inv_list->RowIndex;

		// Init row class and style
		$ap_items_inv->ResetAttrs();
		$ap_items_inv->CssClass = "";
		if ($ap_items_inv->CurrentAction == "gridadd") {
		} else {
			$ap_items_inv_list->LoadRowValues($ap_items_inv_list->Recordset); // Load row values
		}
		$ap_items_inv->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$ap_items_inv->RowAttrs = array_merge($ap_items_inv->RowAttrs, array('data-rowindex'=>$ap_items_inv_list->RowCnt, 'id'=>'r' . $ap_items_inv_list->RowCnt . '_ap_items_inv', 'data-rowtype'=>$ap_items_inv->RowType));

		// Render row
		$ap_items_inv_list->RenderRow();

		// Render list options
		$ap_items_inv_list->RenderListOptions();
?>
	<tr<?php echo $ap_items_inv->RowAttributes() ?>>
<?php

// Render list options (body, left)
$ap_items_inv_list->ListOptions->Render("body", "left", $ap_items_inv_list->RowCnt);
?>
	<?php if ($ap_items_inv->Id_Item->Visible) { // Id_Item ?>
		<td data-name="Id_Item"<?php echo $ap_items_inv->Id_Item->CellAttributes() ?>>
<span id="el<?php echo $ap_items_inv_list->RowCnt ?>_ap_items_inv_Id_Item" class="ap_items_inv_Id_Item">
<span<?php echo $ap_items_inv->Id_Item->ViewAttributes() ?>>
<?php echo $ap_items_inv->Id_Item->ListViewValue() ?></span>
</span>
<a id="<?php echo $ap_items_inv_list->PageObjName . "_row_" . $ap_items_inv_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($ap_items_inv->codigo_item->Visible) { // codigo_item ?>
		<td data-name="codigo_item"<?php echo $ap_items_inv->codigo_item->CellAttributes() ?>>
<span id="el<?php echo $ap_items_inv_list->RowCnt ?>_ap_items_inv_codigo_item" class="ap_items_inv_codigo_item">
<span<?php echo $ap_items_inv->codigo_item->ViewAttributes() ?>>
<?php echo $ap_items_inv->codigo_item->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($ap_items_inv->nombre_item->Visible) { // nombre_item ?>
		<td data-name="nombre_item"<?php echo $ap_items_inv->nombre_item->CellAttributes() ?>>
<span id="el<?php echo $ap_items_inv_list->RowCnt ?>_ap_items_inv_nombre_item" class="ap_items_inv_nombre_item">
<span<?php echo $ap_items_inv->nombre_item->ViewAttributes() ?>>
<?php echo $ap_items_inv->nombre_item->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($ap_items_inv->und_item->Visible) { // und_item ?>
		<td data-name="und_item"<?php echo $ap_items_inv->und_item->CellAttributes() ?>>
<span id="el<?php echo $ap_items_inv_list->RowCnt ?>_ap_items_inv_und_item" class="ap_items_inv_und_item">
<span<?php echo $ap_items_inv->und_item->ViewAttributes() ?>>
<?php echo $ap_items_inv->und_item->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($ap_items_inv->precio_item->Visible) { // precio_item ?>
		<td data-name="precio_item"<?php echo $ap_items_inv->precio_item->CellAttributes() ?>>
<span id="el<?php echo $ap_items_inv_list->RowCnt ?>_ap_items_inv_precio_item" class="ap_items_inv_precio_item">
<span<?php echo $ap_items_inv->precio_item->ViewAttributes() ?>>
<?php echo $ap_items_inv->precio_item->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($ap_items_inv->costo_item->Visible) { // costo_item ?>
		<td data-name="costo_item"<?php echo $ap_items_inv->costo_item->CellAttributes() ?>>
<span id="el<?php echo $ap_items_inv_list->RowCnt ?>_ap_items_inv_costo_item" class="ap_items_inv_costo_item">
<span<?php echo $ap_items_inv->costo_item->ViewAttributes() ?>>
<?php echo $ap_items_inv->costo_item->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($ap_items_inv->tipo_item->Visible) { // tipo_item ?>
		<td data-name="tipo_item"<?php echo $ap_items_inv->tipo_item->CellAttributes() ?>>
<span id="el<?php echo $ap_items_inv_list->RowCnt ?>_ap_items_inv_tipo_item" class="ap_items_inv_tipo_item">
<span<?php echo $ap_items_inv->tipo_item->ViewAttributes() ?>>
<?php echo $ap_items_inv->tipo_item->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($ap_items_inv->marca_item->Visible) { // marca_item ?>
		<td data-name="marca_item"<?php echo $ap_items_inv->marca_item->CellAttributes() ?>>
<span id="el<?php echo $ap_items_inv_list->RowCnt ?>_ap_items_inv_marca_item" class="ap_items_inv_marca_item">
<span<?php echo $ap_items_inv->marca_item->ViewAttributes() ?>>
<?php echo $ap_items_inv->marca_item->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($ap_items_inv->cod_marca_item->Visible) { // cod_marca_item ?>
		<td data-name="cod_marca_item"<?php echo $ap_items_inv->cod_marca_item->CellAttributes() ?>>
<span id="el<?php echo $ap_items_inv_list->RowCnt ?>_ap_items_inv_cod_marca_item" class="ap_items_inv_cod_marca_item">
<span<?php echo $ap_items_inv->cod_marca_item->ViewAttributes() ?>>
<?php echo $ap_items_inv->cod_marca_item->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($ap_items_inv->detalle_item->Visible) { // detalle_item ?>
		<td data-name="detalle_item"<?php echo $ap_items_inv->detalle_item->CellAttributes() ?>>
<span id="el<?php echo $ap_items_inv_list->RowCnt ?>_ap_items_inv_detalle_item" class="ap_items_inv_detalle_item">
<span<?php echo $ap_items_inv->detalle_item->ViewAttributes() ?>>
<?php echo $ap_items_inv->detalle_item->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($ap_items_inv->saldo_item->Visible) { // saldo_item ?>
		<td data-name="saldo_item"<?php echo $ap_items_inv->saldo_item->CellAttributes() ?>>
<span id="el<?php echo $ap_items_inv_list->RowCnt ?>_ap_items_inv_saldo_item" class="ap_items_inv_saldo_item">
<span<?php echo $ap_items_inv->saldo_item->ViewAttributes() ?>>
<?php echo $ap_items_inv->saldo_item->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($ap_items_inv->activo_item->Visible) { // activo_item ?>
		<td data-name="activo_item"<?php echo $ap_items_inv->activo_item->CellAttributes() ?>>
<span id="el<?php echo $ap_items_inv_list->RowCnt ?>_ap_items_inv_activo_item" class="ap_items_inv_activo_item">
<span<?php echo $ap_items_inv->activo_item->ViewAttributes() ?>>
<?php echo $ap_items_inv->activo_item->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($ap_items_inv->maneja_serial_item->Visible) { // maneja_serial_item ?>
		<td data-name="maneja_serial_item"<?php echo $ap_items_inv->maneja_serial_item->CellAttributes() ?>>
<span id="el<?php echo $ap_items_inv_list->RowCnt ?>_ap_items_inv_maneja_serial_item" class="ap_items_inv_maneja_serial_item">
<span<?php echo $ap_items_inv->maneja_serial_item->ViewAttributes() ?>>
<?php echo $ap_items_inv->maneja_serial_item->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($ap_items_inv->asignado_item->Visible) { // asignado_item ?>
		<td data-name="asignado_item"<?php echo $ap_items_inv->asignado_item->CellAttributes() ?>>
<span id="el<?php echo $ap_items_inv_list->RowCnt ?>_ap_items_inv_asignado_item" class="ap_items_inv_asignado_item">
<span<?php echo $ap_items_inv->asignado_item->ViewAttributes() ?>>
<?php echo $ap_items_inv->asignado_item->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($ap_items_inv->si_no_item->Visible) { // si_no_item ?>
		<td data-name="si_no_item"<?php echo $ap_items_inv->si_no_item->CellAttributes() ?>>
<span id="el<?php echo $ap_items_inv_list->RowCnt ?>_ap_items_inv_si_no_item" class="ap_items_inv_si_no_item">
<span<?php echo $ap_items_inv->si_no_item->ViewAttributes() ?>>
<?php echo $ap_items_inv->si_no_item->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($ap_items_inv->precio_old_item->Visible) { // precio_old_item ?>
		<td data-name="precio_old_item"<?php echo $ap_items_inv->precio_old_item->CellAttributes() ?>>
<span id="el<?php echo $ap_items_inv_list->RowCnt ?>_ap_items_inv_precio_old_item" class="ap_items_inv_precio_old_item">
<span<?php echo $ap_items_inv->precio_old_item->ViewAttributes() ?>>
<?php echo $ap_items_inv->precio_old_item->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($ap_items_inv->costo_old_item->Visible) { // costo_old_item ?>
		<td data-name="costo_old_item"<?php echo $ap_items_inv->costo_old_item->CellAttributes() ?>>
<span id="el<?php echo $ap_items_inv_list->RowCnt ?>_ap_items_inv_costo_old_item" class="ap_items_inv_costo_old_item">
<span<?php echo $ap_items_inv->costo_old_item->ViewAttributes() ?>>
<?php echo $ap_items_inv->costo_old_item->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($ap_items_inv->registra_item->Visible) { // registra_item ?>
		<td data-name="registra_item"<?php echo $ap_items_inv->registra_item->CellAttributes() ?>>
<span id="el<?php echo $ap_items_inv_list->RowCnt ?>_ap_items_inv_registra_item" class="ap_items_inv_registra_item">
<span<?php echo $ap_items_inv->registra_item->ViewAttributes() ?>>
<?php echo $ap_items_inv->registra_item->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($ap_items_inv->fecha_registro_item->Visible) { // fecha_registro_item ?>
		<td data-name="fecha_registro_item"<?php echo $ap_items_inv->fecha_registro_item->CellAttributes() ?>>
<span id="el<?php echo $ap_items_inv_list->RowCnt ?>_ap_items_inv_fecha_registro_item" class="ap_items_inv_fecha_registro_item">
<span<?php echo $ap_items_inv->fecha_registro_item->ViewAttributes() ?>>
<?php echo $ap_items_inv->fecha_registro_item->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($ap_items_inv->empresa_item->Visible) { // empresa_item ?>
		<td data-name="empresa_item"<?php echo $ap_items_inv->empresa_item->CellAttributes() ?>>
<span id="el<?php echo $ap_items_inv_list->RowCnt ?>_ap_items_inv_empresa_item" class="ap_items_inv_empresa_item">
<span<?php echo $ap_items_inv->empresa_item->ViewAttributes() ?>>
<?php echo $ap_items_inv->empresa_item->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$ap_items_inv_list->ListOptions->Render("body", "right", $ap_items_inv_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($ap_items_inv->CurrentAction <> "gridadd")
		$ap_items_inv_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($ap_items_inv->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($ap_items_inv_list->Recordset)
	$ap_items_inv_list->Recordset->Close();
?>
<?php if ($ap_items_inv->Export == "") { ?>
<div class="panel-footer ewGridLowerPanel">
<?php if ($ap_items_inv->CurrentAction <> "gridadd" && $ap_items_inv->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($ap_items_inv_list->Pager)) $ap_items_inv_list->Pager = new cPrevNextPager($ap_items_inv_list->StartRec, $ap_items_inv_list->DisplayRecs, $ap_items_inv_list->TotalRecs) ?>
<?php if ($ap_items_inv_list->Pager->RecordCount > 0 && $ap_items_inv_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($ap_items_inv_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $ap_items_inv_list->PageUrl() ?>start=<?php echo $ap_items_inv_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($ap_items_inv_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $ap_items_inv_list->PageUrl() ?>start=<?php echo $ap_items_inv_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $ap_items_inv_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($ap_items_inv_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $ap_items_inv_list->PageUrl() ?>start=<?php echo $ap_items_inv_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($ap_items_inv_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $ap_items_inv_list->PageUrl() ?>start=<?php echo $ap_items_inv_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $ap_items_inv_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $ap_items_inv_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $ap_items_inv_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $ap_items_inv_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($ap_items_inv_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div>
<?php } ?>
<?php if ($ap_items_inv_list->TotalRecs == 0 && $ap_items_inv->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($ap_items_inv_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($ap_items_inv->Export == "") { ?>
<script type="text/javascript">
fap_items_invlistsrch.FilterList = <?php echo $ap_items_inv_list->GetFilterList() ?>;
fap_items_invlistsrch.Init();
fap_items_invlist.Init();
</script>
<?php } ?>
<?php
$ap_items_inv_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($ap_items_inv->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$ap_items_inv_list->Page_Terminate();
?>
