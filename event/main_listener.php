<?php
/**
*
* @package phpBB Extension - Archcry Radio
* @copyright (c) 2013 phpBB Group
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace archcry\radio\event;

/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class main_listener implements EventSubscriberInterface
{
	static public function getSubscribedEvents()
	{
		return array(
			'core.user_setup'	=> 'load_language_on_setup',
			'core.page_header'	=> 'add_page_header_link',
		);
	}

	/* @var \phpbb\controller\helper */
	protected $helper;

	/* @var \phpbb\template\template */
	protected $template;
	
	/* phpBB rootpath */
	protected $root_path;
	
	/* phpBB config */
	protected $config;

	/**
	* Constructor
	*
	* @param \phpbb\controller\helper	$helper		Controller helper object
	* @param \phpbb\template			$template	Template object
	*/
	public function __construct(\phpbb\config\config $config, \phpbb\controller\helper $helper, \phpbb\template\template $template, $root_path)
	{
		$this->helper = $helper;
		$this->template = $template;
		$this->root_path = $root_path;
		$this->config = $config;
	}

	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'archcry/radio',
			'lang_set' => 'common',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}

	public function add_page_header_link($event)
	{
		$this->template->assign_vars(array(
			'EXT_GLOBAL_THEME_PATH' 	=> $root_path . '/ext/archcry/radio/styles/all/theme',
			'ARCHCRY_RADIO_WINAMP_URL'	=> $this->config['archcry_radio_winamp_url'],
			'ARCHCRY_RADIO_WMP_URL'		=> $this->config['archcry_radio_wmp_url'],
			'ARCHCRY_RADIO_REAL_URL'	=> $this->config['archcry_radio_real_url'],
			'ARCHCRY_RADIO_ITUNES_URL'	=> $this->config['archcry_radio_itunes_url']
		));
	}
}