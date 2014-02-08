<?php

	/**
	 * @package iframe_panel
	 */

	require_once TOOLKIT . '/class.entrymanager.php';
	require_once TOOLKIT . '/class.sectionmanager.php';

	/**
	 * Add an iframe to the dashboard.
	 */
	class Extension_Iframe_Panel extends Extension {
		/**
		 * Extension information.
		 */
		public function about() {
			return array(
				'name'			=> 'Iframe Panel',
				'version'		=> '1.0',
				'release-date'	=> '2013-09-28',
				'author'		=> array(
					'name'			=> 'Aonghus Storey',
					'website'		=> 'http://clririshleftarchive.com/',
					'email'			=> 'aonghusstorey@gmail.com'
				),
				'description'	=> 'Add an iframe to the dashboard, without pulling or caching its contents.'
			);
		}

		/**
		 * Subscribe to Dashboard and Symphony delegates.
		 */
		public function getSubscribedDelegates() {
			return array(
				/*array(
					'page'		=> '/backend/',
					'delegate'	=> 'InitaliseAdminPageHead',
					'callback'	=> 'dashboardAppendAssets'
				),*/
				array(
					'page'		=> '/backend/',
					'delegate'	=> 'DashboardPanelOptions',
					'callback'	=> 'dashboardPanelOptions'
				),
				array(
					'page'		=> '/backend/',
					'delegate'	=> 'DashboardPanelRender',
					'callback'	=> 'dashboardPanelRender'
				),
				array(
					'page'		=> '/backend/',
					'delegate'	=> 'DashboardPanelTypes',
					'callback'	=> 'dashboardPanelTypes'
				)
			);
		}

		/**
		 * Generate the panel options view.
		 *
		 * @param array $context
		 */
		public function dashboardPanelOptions($context) {
			
			$config = $context['existing_config'];
		
			if ($context['type'] != 'iframe_panel') return;
				
				$fieldset = new XMLElement('fieldset', NULL, array('class' => 'settings'));
				$fieldset->appendChild(new XMLElement('legend', __('Iframe Panel')));
				
				$label = Widget::Label(__('Page URL'), Widget::Input('config[url]', $config['url']));
				$fieldset->appendChild($label);
								
				$label = Widget::Label(__('Height'), Widget::Input('config[height]', (string)(int)$config['height']));
				$fieldset->appendChild($label);

				$context['form'] = $fieldset;

		}

		/**
		 * Generate the panel view.
		 *
		 * @param array $context
		 */
		public function dashboardPanelRender($context) {
			if ($context['type'] != 'iframe_panel') return;
			$config = $context['config'];

				$source = $config['url'];
				$height = $config['height'];
				$frame = '<iframe src="'.$source.'"  width="100%" height="'.$height.'" scrolling="no" frameborder="0" marginheight="0" marginwidth="0"></iframe>';
				
				$context['panel']->appendChild(new XMLElement('div',$frame));
				

		}
		
		/**
		 * Let the Dashboard know that our panel type exists.
		 *
		 * @param array $context
		 */
		public function dashboardPanelTypes($context) {
			$context['types']['iframe_panel'] = __('Iframe Panel');
		}
	}
?>