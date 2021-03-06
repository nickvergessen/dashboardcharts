<?php declare(strict_types=1);


/**
 * Nextcloud - Dashboard Charting app
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Mark Partlett <mark@partlettconsulting.com.au>
 * @copyright 2019, Mark Partlett <mark@partlettconsulting.com.au>
 * @license GNU AGPL version 3 or any later version
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

namespace OCA\DashboardCharts\Widgets;

use OCP\Dashboard\Model\WidgetSetup;
use OCP\Dashboard\Model\WidgetTemplate;
use OCA\DashboardCharts\AppInfo\Application;
use OCA\DashboardCharts\Service\Widgets\Formio5\Formio5Service;
use OCP\AppFramework\QueryException;
use OCP\Dashboard\IDashboardWidget;
use OCP\Dashboard\Model\IWidgetRequest;
use OCP\Dashboard\Model\IWidgetConfig;
use OCP\AppFramework\Http\ContentSecurityPolicy;
use OCP\IL10N;


class Formio5Widget implements IDashboardWidget {

	const WIDGET_ID = 'Formio5';

       private $l10n;


	private $formio5Service;

	public function __construct( Formio5Service $formio5Service) {
          //      $this->l10n = $l10n;
                $this->Formio5Service = $formio5Service;
        }



	/**
	 * @return string
	 */
	public function getId(): string {
		return self::WIDGET_ID;
	}


	/**
	 * @return string
	 */
	public function getName(): string {
		return 'Form.io 5';
	}


	/**
	 * @return string
	 */
	public function getDescription(): string {
		return 'Formio'
			   . '..Display a Webform in a widget';
	}


	/**
	 * @return WidgetTemplate
	 */
	public function getWidgetTemplate(): WidgetTemplate {
		$template = new WidgetTemplate();
		$template->addCss('widgets/formio5')
		         ->addCss('widgets/font-awesome.min')
		         ->addCss('widgets/bootstrap.min')
		         ->addCss('widgets/formio.full.min')
				 ->addJs('widgets/Formio5')
				 ->addJs('widgets/formio.full.min')
				 ->setIcon('icon-formio')
				 ->setContent('widgets/Formio5')
                 ->setInitFunction('OCA.DashBoard.formio5.init');
			//	 ->setSettings(['name','title','checkbox',true,'placeholder'],['name2','title2','checkbox2',true,'placeholder2']);      	 
		return $template;
	}


	/**
	 * @return WidgetSetup
	 */
	public function getWidgetSetup(): WidgetSetup {
		$setup = new WidgetSetup();
		$setup->addSize(WidgetSetup::SIZE_TYPE_MIN, 2, 2)
			  ->addSize(WidgetSetup::SIZE_TYPE_MAX, 15, 15)
			  ->addSize(WidgetSetup::SIZE_TYPE_DEFAULT, 4, 4);
			  
		$setup->addMenuEntry('OCA.DashBoard.formio5.getFormio5Data', 'icon-refresh', 'Refresh');
		$setup->addDelayedJob('OCA.DashBoard.formio5.getFormio5Data', 3000);
		$setup->setPush('OCA.DashBoard.formio5.push');

		

		return $setup;
	}


	/**
	 * @param IWidgetConfig $settings
	 */
	public function loadWidget(IWidgetConfig $settings) {
	}


	/**
	 * @param IWidgetRequest $request
	 */
	public function requestWidget(IWidgetRequest $request) {
		if ($request->getRequest() === 'getFormio5Data') {
			$request->addResult('formio5', $this->Formio5Service->getFormio5Data());
			
	}
    }
}
