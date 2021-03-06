<?php
/**
 *------------------------------------------------------------------------------
 *  iCagenda v3 by Jooml!C - Events Management Extension - Joomla! 2.5 / 3.x
 *------------------------------------------------------------------------------
 * @package     com_icagenda
 * @copyright   Copyright (c)2012-2013 Cyril Rezé, Jooml!C - All rights reserved
 *
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Cyril Rezé (Lyr!C)
 * @link        http://www.joomlic.com
 *
 * @version     3.1.9 2013-09-06
 * @since       2.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

//Système Installation/Mises à jour, composant iCagenda http://www.joomlic.com
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');

// Load translations
$language = JFactory::getLanguage();
$language->load('com_icagenda.sys', JPATH_ADMINISTRATOR, 'en-GB', true);
$language->load('com_icagenda.sys', JPATH_ADMINISTRATOR, null, true);


class com_icagendaInstallerScript
{
	/*
	 * $parent is the class calling this method.
	 * $type is the type of change (install, update or discover_install, not uninstall).
	 * preflight runs before anything else and while the extracted files are in the uploaded temp folder.
	 * If preflight returns false, Joomla will abort the update and undo everything already done.
	 */

	/** @var array Obsolete files and folders to remove from the iCagenda oldest releases*/
	private $icagendaRemoveFiles = array(
		'files'	=> array(
			'administrator/components/com_icagenda/add/js/timepiker.js',
			'components/com_icagenda/views/list/tmpl/search.php',
			'components/com_icagenda/views/list/tmpl/search.xml',
			'modules/mod_iccalendar/js/bottomcenter_function.js',
			'modules/mod_iccalendar/js/center_function.js',
			'modules/mod_iccalendar/js/left_function.js',
			'modules/mod_iccalendar/js/right_function.js',
			'modules/mod_iccalendar/js/topcenter_function.js',
			'components/com_icagenda/helpers/icmodcalendar.php',
		),
		'folders' => array(
			'modules/mod_iccalendar/tmpl',
			'components/com_icagenda/views/event',
			'components/com_icagenda/css',
//			'components/com_icagenda/models/fields',
		)
	);


	private function _removeObsoleteFilesAndFolders($icagendaRemoveFiles)
	{
		// Remove files
		jimport('joomla.filesystem.file');
		if(!empty($icagendaRemoveFiles['files'])) foreach($icagendaRemoveFiles['files'] as $file) {
			$f = JPATH_ROOT.'/'.$file;
			if(!JFile::exists($f)) continue;
			JFile::delete($f);
		}

		// Remove folders
		jimport('joomla.filesystem.file');
		if(!empty($icagendaRemoveFiles['folders'])) foreach($icagendaRemoveFiles['folders'] as $folder) {
			$f = JPATH_ROOT.'/'.$folder;
			if(!JFolder::exists($f)) continue;
			JFolder::delete($f);
		}
	}

	function preflight( $type, $parent ) {
		$jversion = new JVersion();

		// Installing component manifest file version
		$this->release = $parent->get( "manifest" )->version;

		// Manifest file minimum Joomla version
		$this->minimum_joomla_release = $parent->get( "manifest" )->attributes()->version;

		// Load translations
		$language = JFactory::getLanguage();
		$language->load('com_icagenda.sys', JPATH_ADMINISTRATOR, 'en-GB', true);
		$language->load('com_icagenda.sys', JPATH_ADMINISTRATOR, null, true);

		echo '<table><tr><td><img src="../administrator/components/com_icagenda/add/image/logo_icagenda.png" /></td><td width="10px"></td><td style="font-size: 20px"><b>' . JText::_('COM_ICAGENDA') . '&trade;<span style="font-size: 11px"> v '.$this->release.' </span></b><br /><span style="font-size: 16px; color:#555555;">' . JText::_('COM_ICAGENDA_XML_DESCRIPTION') . '</span><br /><br /><span style="font-size: 13px">&#8226; <b>' . JText::_('COM_ICAGENDA_FEATURES_LANGUAGES') . '</b> English <img src="../media/mod_languages/images/en.gif" height="10px"/> - French <img src="../media/mod_languages/images/fr.gif" height="10px"/> - Italian <img src="../media/mod_languages/images/it.gif" height="10px"/><br />'
		.'&#8226; <b>' . JText::_('COM_ICAGENDA_FEATURES_TRANSLATION_PACKS') . '</b> '
		.'Catalan <img src="../media/mod_languages/images/ca.gif" height="10px"/> - '
		.'Chinese (trad.) Taiwan <img src="../media/mod_languages/images/tw.gif" height="10px"/> - '
		.'Croatian <img src="../media/mod_languages/images/hr.gif" height="10px"/> - '
		.'Czech <img src="../media/mod_languages/images/cz.gif" height="10px"/> - '
		.'Dutch <img src="../media/mod_languages/images/nl.gif" height="10px"/> - '
		.'English/US <img src="../media/mod_languages/images/us.gif" height="10px"/> - '
		.'Finnish <img src="../media/mod_languages/images/fi.gif" height="10px"/> - '
		.'German <img src="../media/mod_languages/images/de.gif" height="10px"/> - '
		.'Greek <img src="../media/mod_languages/images/el.gif" height="10px"/> - '
		.'Latvian <img src="../media/mod_languages/images/lv.gif" height="10px"/> - '
		.'Norwegian <img src="../media/mod_languages/images/no.gif" height="10px"/> - '
		.'Polish <img src="../media/mod_languages/images/pl.gif" height="10px"/> - '
		.'Portuguese/Brasil <img src="../media/mod_languages/images/pt_br.gif" height="10px"/> - '
		.'Portuguese <img src="../media/mod_languages/images/pt.gif" height="10px"/> - '
		.'Russian <img src="../media/mod_languages/images/ru.gif" height="10px"/> - '
		.'Serbian (latin) <img src="../media/mod_languages/images/sr.gif" height="10px"/> - '
		.'Slovak <img src="../media/mod_languages/images/sk.gif" height="10px"/> - '
		.'Slovenian <img src="../media/mod_languages/images/sl.gif" height="10px"/> - '
		.'Spanish <img src="../media/mod_languages/images/es.gif" height="10px"/> - '
		.'Swedish <img src="../media/mod_languages/images/sv.gif" height="10px"/>'
		.'<br />&#8226; ' . JText::_('COM_ICAGENDA_FEATURES_BACKEND') . '<br />&#8226; ' . JText::_('COM_ICAGENDA_FEATURES_FRONTEND') . '<br /></span></td></tr></table><br /><br />';


		if ( $type == 'install' ) {
		echo '<span style="text-transform:uppercase; font-size: 14px"><b>' . JText::_('COM_ICAGENDA_WELCOME_1') . $this->release . '</span>';
		echo '<span style="text-transform:uppercase; font-size: 14px">' . JText::_('COM_ICAGENDA_WELCOME_2') . '</b></span>';
		echo '<span style="text-transform:uppercase; letter-spacing: 3px; font-size: 14px">' . JText::_('COM_ICAGENDA_WELCOME_3') . '</span>';

		}



		// Show the essential information at the install/update back-end
		echo '<br /><p style="font-size: 10px">' . JText::_('COM_ICAGENDA_INSTALL_THIS_RELEASE') . '<b> '.$this->release.'</b>';
		if ( $type == 'update' ) {
			echo '<br />'.JText::_('COM_ICAGENDA_INSTALL_CACHE_VERSION') . '<b> '.$this->getParam('version').'</b>';
		}
		echo '<br />'.JText::_('COM_ICAGENDA_INSTALL_MINIMUM_JOOMLA_VERSION') . '<b> '.$this->minimum_joomla_release.'</b>';
		echo '<br />'.JText::_('COM_ICAGENDA_INSTALL_CURRENT_JOOMLA_VERSION') . '<b> '.$jversion->getShortVersion().'</b><br /><br />';

		// abort if the current Joomla release is older
		if( version_compare( $jversion->getShortVersion(), $this->minimum_joomla_release, 'lt' ) ) {
			Jerror::raiseWarning(null, ' ' . JText::_('COM_ICAGENDA_INSTALL_ERROR_JOOMLA_VERSION') . ' '.$this->minimum_joomla_release);
			return false;
		}

		// abort if the component being installed is not newer than the currently installed version
		if ( $type == 'update' ) {
			echo '<span style="text-transform:uppercase; font-size: 14px"><b>' . JText::_('COM_ICAGENDA') . ' : ' . JText::_('COM_ICAGENDA_UPDATE') .' ' . $this->release . ' !</b></span><br><br>';
			echo '<div style="margin-left:10px"><span style="font-size: 16px; color:#555555;">'.JText::_('COM_ICAGENDA_VIDEO_GETTING_STARTED') . '</span>';
						$urlposter = '../media/com_icagenda/images/video_poster_icagenda.jpg';
					?>

					<div onclick="thevid=document.getElementById('thevideo'); thevid.style.display='block'; this.style.display='none'">
						<img style="cursor: pointer;" src="<?php echo $urlposter; ?>" alt=""  width="500px" />
					</div>

					<div id="thevideo" style="display: none;">
						<?php
							jimport('joomla.application.component.helper'); // Import component helper library
							$icagendaParams = JComponentHelper::getParams('com_icagenda');
							$icfolder = $icagendaParams->get('icsys');
						?>
						<iframe src="http://www.joomlic.com/_icagenda/<?php echo $icfolder; ?>/tutorial_video_install.html" frameborder="0" width="500px" height="340" scrolling="no"></iframe>

					</div>

					<div style="color:#333; margin-top: 5px; font-size: 0.8em;">
						© <?php echo date("Y"); ?> <?php echo JText::_('COM_ICAGENDA_VIDEO_TUTORIALS');?> - Giuseppe Bosco (giusebos) | <a href="http://www.newideasproject.com/" target="_blanck">www.newideasproject.com</a>
					</div>

					<div style="color:#333; margin-top: 5px; font-size: 0.8em; line-height:14px; height:30px;">
						<a href="http://www.youtube.com/user/iCagenda" target="_blanck"><img src='../media/com_icagenda/images/youtube_iCagenda.png' style='vertical-align:bottom;' /></a> : <a href="http://www.youtube.com/user/iCagenda" target="_blanck"><?php echo JText::_('COM_ICAGENDA_VIDEO_TUTORIALS');?></a>
					</div>
<br><br></div>
			<?php
			$oldRelease = $this->getParam('version');
			$rel = ' ' . $oldRelease . ' to ' . $this->release;
//			if ( version_compare( $this->release, $oldRelease, 'le' ) ) {
//				Jerror::raiseWarning(null, ' ' . JText::_('COM_ICAGENDA_INSTALL_INCORRECT_VERSION') . ' ' . $rel);
//				return false;
//			}

		}
		else { $rel = $this->release; }

//		echo '<span style="text-transform:uppercase; font-size: 8px">' . JText::_('COM_ICAGENDA_PREFLIGHT_') . ': ' . $type . $rel . ' | </span>';
	}

	/*
	 * $parent is the class calling this method.
	 * install runs after the database scripts are executed.
	 * If the extension is new, the install method is run.
	 * If install returns false, Joomla will abort the install and undo everything already done.
	 */
	function install( $parent ) {

		// Module install
		$db = JFactory::getDbo();
		$manifest = $parent->get("manifest");
		$parent = $parent->getParent();
		$source = $parent->getPath("source");
		$installer = new JInstaller();
		$installModules = array();
        // Proceed
		if (is_object($manifest->modules) && isset($manifest->modules->module))
		{
         foreach($manifest->modules->module as $module)
			{
				$attributes = $module->attributes();
				$mod = $source.'/'.$attributes['folder'].'/'.$attributes['module'];
				$installer->install($mod);
				$installModules[] =  $attributes['module'];
            }
        }

//		echo '<span style="text-transform:uppercase; font-size: 8px"><b>' . JText::_('COM_ICAGENDA_INSTALL') . $this->release . '</b> | </span>';
		// You can have the backend jump directly to the newly installed component configuration page
		// $parent->getParent()->setRedirectURL('index.php?option=com_democompupdate');

		// Get Joomla Images PATH setting
		$params = JComponentHelper::getParams('com_media');
		$image_path = $params->get('image_path');

		// Create Folder iCagenda in ROOT/IMAGES_PATH/icagenda
		$folder[0][0]	=	'icagenda/' ;
		$folder[0][1]	= 	JPATH_ROOT.'/'.$image_path.'/'.$folder[0][0];
		$folder[1][0]	=	'icagenda/files/';
		$folder[1][1]	= 	JPATH_ROOT.'/'.$image_path.'/'.$folder[1][0];
		$folder[2][0]	=	'icagenda/thumbs/';
		$folder[2][1]	= 	JPATH_ROOT.'/'.$image_path.'/'.$folder[2][0];
		$folder[3][0]	=	'icagenda/thumbs/system/';
		$folder[3][1]	= 	JPATH_ROOT.'/'.$image_path.'/'.$folder[3][0];
		$folder[4][0]	=	'icagenda/thumbs/themes/';
		$folder[4][1]	= 	JPATH_ROOT.'/'.$image_path.'/'.$folder[4][0];
		$folder[5][0]	=	'icagenda/thumbs/copy/';
		$folder[5][1]	= 	JPATH_ROOT.'/'.$image_path.'/'.$folder[5][0];


		$message = '<div><i>'.JText::_('COM_ICAGENDA_FOLDER_CREATION').'</i></div>';
		$error	 = array();
		foreach ($folder as $key => $value)
		{
			if (!JFolder::exists( $value[1]))
			{
				if (JFolder::create( $value[1], 0755 ))
				{

					$data = "<html>\n<body bgcolor=\"#FFFFFF\">\n</body>\n</html>";
					JFile::write($value[1]."/index.html", $data);
					$message .= '<div><b><span style="color:#009933">'.JText::_('COM_ICAGENDA_FOLDER').'</span> ' . $image_path.'/'.$value[0]
							   .' <span style="color:#009933">'.JText::_('COM_ICAGENDA_CREATED').'</span></b></div>';
					$error[] = 0;
				}
				else
				{
					$message .= '<div><b><span style="color:#CC0033">'.JText::_('COM_ICAGENDA_FOLDER').'</span> ' . $image_path.'/'.$value[0]
							   .' <span style="color:#CC0033">'.JText::_('COM_ICAGENDA_CREATION_FAILED').'</span></b> '.JText::_('COM_ICAGENDA_PLEASE_CREATE_MANUALLY').'</div>';
					$error[] = 1;
				}
			}
			else//Folder exist
			{
				$message .= '<div><b><span style="color:#009933">'.JText::_('COM_ICAGENDA_FOLDER').'</span> ' . $image_path.'/'.$value[0]
							   .' <span style="color:#009933">'.JText::_('COM_ICAGENDA_EXISTS').'</span></b></div>';
				$error[] = 0;
			}
		}
		echo $message;


	}

	/*
	 * $parent is the class calling this method.
	 * update runs after the database scripts are executed.
	 * If the extension exists, then the update method is run.
	 * If this returns false, Joomla will abort the update and undo everything already done.
	 */
	function update( $parent ) {

		// Module install
		$db = JFactory::getDbo();
		$manifest = $parent->get("manifest");
		$parent = $parent->getParent();
		$source = $parent->getPath("source");
		$installer = new JInstaller();
		$installModules = array();
        // Proceed
		if (is_object($manifest->modules) && isset($manifest->modules->module))
		{
         foreach($manifest->modules->module as $module)
			{
				$attributes = $module->attributes();
				$mod = $source.'/'.$attributes['folder'].'/'.$attributes['module'];
				$installer->install($mod);
				$installModules[] =  $attributes['module'];
            }
        }

//		echo '<span style="text-transform:uppercase; font-size: 8px">' . JText::_('COM_ICAGENDA_UPDATE') . $this->release . ' | </span>';
		// You can have the backend jump directly to the newly updated component configuration page
		// $parent->getParent()->setRedirectURL('index.php?option=com_democompupdate');

		// Get Joomla Images PATH setting
		$params = JComponentHelper::getParams('com_media');
		$image_path = $params->get('image_path');

		// Create Folder iCagenda in ROOT/IMAGES_PATH/icagenda
		$folder[0][0]	=	'icagenda/' ;
		$folder[0][1]	= 	JPATH_ROOT.'/'.$image_path.'/'.$folder[0][0];
		$folder[1][0]	=	'icagenda/files/';
		$folder[1][1]	= 	JPATH_ROOT.'/'.$image_path.'/'.$folder[1][0];
		$folder[2][0]	=	'icagenda/thumbs/';
		$folder[2][1]	= 	JPATH_ROOT.'/'.$image_path.'/'.$folder[2][0];
		$folder[3][0]	=	'icagenda/thumbs/system/';
		$folder[3][1]	= 	JPATH_ROOT.'/'.$image_path.'/'.$folder[3][0];
		$folder[4][0]	=	'icagenda/thumbs/themes/';
		$folder[4][1]	= 	JPATH_ROOT.'/'.$image_path.'/'.$folder[4][0];
		$folder[5][0]	=	'icagenda/thumbs/copy/';
		$folder[5][1]	= 	JPATH_ROOT.'/'.$image_path.'/'.$folder[5][0];


		$message = '<div><i>'.JText::_('COM_ICAGENDA_FOLDER_CREATION').'</i></div>';
		$error	 = array();
		foreach ($folder as $key => $value)
		{
			if (!JFolder::exists( $value[1]))
			{
				if (JFolder::create( $value[1], 0755 ))
				{

					$data = "<html>\n<body bgcolor=\"#FFFFFF\">\n</body>\n</html>";
					JFile::write($value[1]."/index.html", $data);
					$message .= '<div><b><span style="color:#009933">'.JText::_('COM_ICAGENDA_FOLDER').'</span> ' . $image_path.'/'.$value[0]
							   .' <span style="color:#009933">'.JText::_('COM_ICAGENDA_CREATED').'</span></b></div>';
					$error[] = 0;
				}
				else
				{
					$message .= '<div><b><span style="color:#CC0033">'.JText::_('COM_ICAGENDA_FOLDER').'</span> ' . $image_path.'/'.$value[0]
							   .' <span style="color:#CC0033">'.JText::_('COM_ICAGENDA_CREATION_FAILED').'</span></b> '.JText::_('COM_ICAGENDA_PLEASE_CREATE_MANUALLY').'</div>';
					$error[] = 1;
				}
			}
			else//Folder exist
			{
				$message .= '<div><b><span style="color:#009933">'.JText::_('COM_ICAGENDA_FOLDER').'</span> ' . $image_path.'/'.$value[0]
							   .' <span style="color:#009933">'.JText::_('COM_ICAGENDA_EXISTS').'</span></b></div>';
				$error[] = 0;
			}
		}
		echo $message;


	}

	/*
	 * $parent is the class calling this method.
	 * $type is the type of change (install, update or discover_install, not uninstall).
	 * postflight is run after the extension is registered in the database.
	 */
	function postflight( $type, $parent ) {

		// Remove obsolete files and folders
			$icagendaRemoveFiles = $this->icagendaRemoveFiles;

		$this->_removeObsoleteFilesAndFolders($icagendaRemoveFiles);



		// always create or modify these parameters
		$params['version'] = ' <b style="font-size:0.5em;">v ' . $this->release . '</b>';
		$params['release'] = $this->release;
		$params['author'] = 'JoomliC';
		$params['icsys'] = 'core';

		// define the following parameters only if it is an original install
		if ( $type == 'install' ) {
			$params['copy'] = '1';
			$params['atlist'] = '1';
			$params['atevent'] = '1';
			$params['atfloat'] = '2';
			$params['aticon'] = '2';
			$params['arrowtext'] = '1';
			$params['statutReg'] = '1';
			$params['maxRlist'] = '5';
			$params['navposition'] = '0';
			$params['targetLink'] = '1';
			$params['participantList'] = '1';
			$params['participantSlide'] = '1';
			$params['participantDisplay'] = '1';
			$params['fullListColumns'] = 'tiers';
			$params['regEmailUser'] = '1';
			$params['timeformat'] = '1';
			$params['ShortDescLimit'] = '100';
			$params['limitRegEmail'] = '1';
			$params['limitRegDate'] = '1';
			$params['phoneRequired'] = '2';
			$params['headerList'] = '1';
		}

		$oldRelease = $this->getParam('version');
		if ( version_compare( $oldRelease, '1.2.9', 'le' ) ) {
			$params['statutReg'] = '1';
			$params['maxRlist'] = '5';
			$params['navposition'] = '0';
			$params['targetLink'] = '1';
			$params['participantList'] = '1';
			$params['participantSlide'] = '1';
			$params['participantDisplay'] = '1';
			$params['fullListColumns'] = 'tiers';
			$params['regEmailUser'] = '1';
			$params['timeformat'] = '1';
		}

		if ( version_compare( $oldRelease, '2.0.6', 'le' ) ) {
			$params['navposition'] = '0';
			$params['targetLink'] = '1';
			$params['participantList'] = '1';
			$params['participantSlide'] = '1';
			$params['participantDisplay'] = '1';
			$params['fullListColumns'] = 'tiers';
			$params['regEmailUser'] = '1';
			$params['timeformat'] = '1';
		}

		if ( version_compare( $oldRelease, '2.1.1', 'le' ) ) {
			$params['limitRegEmail'] = '1';
			$params['limitRegDate'] = '1';
			$params['phoneRequired'] = '2';
			$params['headerList'] = '1';
		}

		if ( version_compare( $oldRelease, '3.0', 'le' ) ) {
			$params['bootstrapType'] = '1';
		}

		if ( version_compare( $oldRelease, '3.1.0', 'lt' ) ) {
			$params['emailRequired'] = '1';
		}

		// 3.0 RC
//		if ( version_compare( $oldRelease, '3.0.0 RC', 'le' ) ) {
			jimport('joomla.application.component.helper'); // Import component helper library
			$icagendaParams = JComponentHelper::getParams('com_icagenda');
			$extparticipantList = $icagendaParams->get('participantList');
			$extparticipantSlide = $icagendaParams->get('participantSlide');
			$extstatutReg = $icagendaParams->get('statutReg');
			$extlimitRegEmail = $icagendaParams->get('limitRegEmail');
			$extlimitRegDate = $icagendaParams->get('limitRegDate');
			$extphoneRequired = $icagendaParams->get('phoneRequired');
			$extregEmailUser = $icagendaParams->get('regEmailUser');

			if ($extparticipantList == '2') {
				$params['participantList'] = '0';
			}
			if ($extparticipantSlide == '2') {
				$params['participantSlide'] = '0';
			}
			if ($extstatutReg == '2') {
				$params['statutReg'] = '0';
			}
			if ($extlimitRegEmail == '2') {
				$params['limitRegEmail'] = '0';
			}
			if ($extlimitRegDate == '2') {
				$params['limitRegDate'] = '0';
			}
			if ($extphoneRequired == '2') {
				$params['phoneRequired'] = '0';
			}
			if ($extregEmailUser == '2') {
				$params['regEmailUser'] = '0';
			}
//		}
		// Controls - Update 3.1.1
		$emailRequired = $icagendaParams->get('emailRequired');
		if ($emailRequired == '') {
			$params['emailRequired'] = '1';
		}


		$this->setParams( $params );

//		echo '<span style="text-transform:uppercase; font-size: 8px">' . JText::_('COM_ICAGENDA_POSTFLIGHT') . ': ' . $type . ' to ' . $this->release . '</span>';
	}



	/*
	 * $parent is the class calling this method
	 * uninstall runs before any other action is taken (file removal or database processing).
	 */
	function uninstall( $parent ) {
		echo '<p>' . JText::_('COM_ICAGENDA_UNINSTALL') . '</p>';
	}




	/*
	 * get a variable from the manifest file (actually, from the manifest cache).
	 */
	function getParam( $name ) {
		$db = JFactory::getDbo();
		$db->setQuery('SELECT manifest_cache FROM #__extensions WHERE name = "icagenda"');
		$manifest = json_decode( $db->loadResult(), true );
		return $manifest[ $name ];
	}

	/*
	 * sets parameter values in the component's row of the extension table
	 */
	function setParams($param_array) {
		if ( count($param_array) > 0 ) {
			// read the existing component value(s)
			$db = JFactory::getDbo();
			$db->setQuery('SELECT params FROM #__extensions WHERE name = "icagenda"');
			$params = json_decode( $db->loadResult(), true );
			// add the new variable(s) to the existing one(s)
			foreach ( $param_array as $name => $value ) {
				$params[ (string) $name ] = (string) $value;
			}
			// store the combined new and existing values back as a JSON string
			$paramsString = json_encode( $params );
			$db->setQuery('UPDATE #__extensions SET params = ' .
				$db->quote( $paramsString ) .
				' WHERE name = "icagenda"' );
				$db->query();
		}
	}
}
