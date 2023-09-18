<?php
/**
 * @package     com_appsconda
 * @version     1.0.0
 * @copyright   Copyright (C) 2023. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author     AppsConda ApS <support@appsconda.com> - https://appsconda.com
 */

namespace Joomla\Component\Appsconda\Site\View\Notificationqueue;

// No direct access
defined('_JEXEC') or die;

use Exception;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Pagination\Pagination;
use Joomla\Registry\Registry;

/**
 * Appsconda detail view
 */
class HtmlView extends BaseHtmlView
{
    /**
     * The active item
     *
     * @var    object
     * @since  1.5
     */
    protected $item;

    /**
     * The pagination object
     *
     * @var    ?Pagination
     * @since  1.6
     */
    protected $pagination;

    /**
     * The form object
     *
     * @var    object
     * @since  1.5
     */
    protected $form;

    /**
     * The model state
     *
     * @var    object
     * @since  1.5
     */
    protected $state;

    /**
     * The component params
     *
     * @var    Registry
     * @since  1.5
     */
    protected $params;

	/**
	 * @throws Exception
	 */
    public function display($tpl = null): void
    {
		$app	= Factory::getApplication();
        $user	= Factory::getUser();

        $this->form 				= $this->get('Form');
        $this->state 				= $this->get('State');
        $this->item 				= $this->get('Item');
        $this->pagination           = $this->get('pagination');

        $this->params 				= $app->getParams('com_appsconda');

        if (count($errors = $this->get('Errors'))) {
            throw new Exception(implode("\n", $errors));
        }

        $this->setupDocument();

        parent::display($tpl);
    }

    /**
     * @return  void
     *
     * @throws \Exception
     * @since   1.6
     */
    protected function setupDocument(): void
    {
        HTMLHelper::_('jquery.framework');

        $document = Factory::getDocument();
        $app   = Factory::getApplication();

        if ($document === null) {
            return;
        }
        $document->addStyleSheet('components/com_appsconda/assets/css/appsconda.css');
        $document->addScript('components/com_appsconda/assets/js/detail.js');

        if ($app === null) {
            return;
        }

        $menus = $app->getMenu();
        if ($menus === null) {
            return;
        }
        $menu = $menus->getActive();

        if ($menu) {
            $this->params->def('page_heading', $this->params->get('page_title', $menu->title));
        } else {
            $this->params->def('page_heading', Text::_('COM_APPSCONDA_DEFAULT_PAGE_TITLE'));
        }

        $title = $this->params->get('page_title', '');

        if (empty($title)) {
            $title = $app->get('sitename');
        } elseif ((int)$app->get('sitename_pagetitles', 0) === 1) {
            $title = Text::sprintf('JPAGETITLE', $app->get('sitename'), $title);
        } elseif ((int)$app->get('sitename_pagetitles', 0) === 2) {
            $title = Text::sprintf('JPAGETITLE', $title, $app->get('sitename'));
        }

        $this->document->setTitle($title);

        if ($this->params->get('menu-meta_description')) {
            $this->document->setDescription($this->params->get('menu-meta_description'));
        }

        if ($this->params->get('menu-meta_keywords')) {
            $this->document->setMetadata('keywords', $this->params->get('menu-meta_keywords'));
        }

        if ($this->params->get('robots')) {
            $this->document->setMetadata('robots', $this->params->get('robots'));
        }
    }
}
