<?php
/**
 * @package     com_appsconda
 * @version     1.0.0
 * @copyright   Copyright (C) 2023. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      AppsConda ApS <support@appsconda.com> - https://appsconda.com
 */

namespace Joomla\Component\Appsconda\Site\View\Mobileappapis;

// No direct access
defined('_JEXEC') or die;

use Exception;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Pagination\Pagination;

/**
 * Appsconda list view
 */
class HtmlView extends BaseHtmlView
{
	/**
	 * An array of items
	 *
	 * @var    array
	 * @since  1.6
	 */
	protected $items = [];

	/**
	 * The pagination object
	 *
	 * @var    Pagination
	 * @since  1.6
	 */
	protected $pagination;

	/**
	 * The model state
	 *
	 * @var    object
	 * @since  1.6
	 */
	protected $state;

	/**
	 * The component params
	 */
	protected $params;

	/**
	 * The ID of the item
	 */
    protected $item_id;

	/**
	 * Display the view
	 *
	 * @param null $tpl
	 *
	 * @throws \Exception
	 */
	public function display($tpl = null)
	{
        $app                = Factory::getApplication();

        // Load the component params
        $this->params       = $app->getParams('com_appsconda');

        // Get the menu item id
        $this->item_id      = $app->input->getInt('Itemid');
        
        $this->state		= $this->get('State');
        $this->items		= $this->get('Items');
        $this->pagination	= $this->get('Pagination');

        if (count($errors = $this->get('Errors')))
        {
            throw new Exception(implode("\n", $errors));
        }

        // Load the template header here to simplify the template
        $this->loadTemplateHeader();

        $this->_prepareDocument();

        parent::display($tpl);
	}

    /**
     * Prepares the document
     *
     * @return  void
     * @throws \Exception
     */
    protected function _prepareDocument()
    {
        $app = Factory::getApplication();
        if ($app === null) {
            return;
        }
        $menus = $app->getMenu();
        if ($menus === null) {
            return;
        }

        $menu = $menus->getActive();
        if ($menu)
        {
            $this->params->def('page_heading', $this->params->get('page_title', $menu->title));
        }
        else
        {
            $this->params->def('page_heading', Text::_('JGLOBAL_ARTICLES'));
        }

        $title = $this->params->get('page_title', '');

        if (empty($title))
        {
            $title = $app->get('sitename');
        }
        elseif ((int)$app->get('sitename_pagetitles', 0) === 1)
        {
            $title = Text::sprintf('JPAGETITLE', $app->get('sitename'), $title);
        }
        elseif ((int)$app->get('sitename_pagetitles', 0) === 2)
        {
            $title = Text::sprintf('JPAGETITLE', $title, $app->get('sitename'));
        }

        $this->document->setTitle($title);

        if ($this->params->get('menu-meta_description'))
        {
            $this->document->setDescription($this->params->get('menu-meta_description'));
        }

        if ($this->params->get('menu-meta_keywords'))
        {
            $this->document->setMetadata('keywords', $this->params->get('menu-meta_keywords'));
        }

        if ($this->params->get('robots'))
        {
            $this->document->setMetadata('robots', $this->params->get('robots'));
        }
    }

    /**
     * Load the template header data here to simplify the template
     */
    protected function loadTemplateHeader()
    {
        HTMLHelper::_('jquery.framework');

        $document = Factory::getDocument();
        if ($document === null) {
            return;
        }
        $document->addStyleSheet('components/com_appsconda/assets/css/appsconda.css');
        $document->addScript('components/com_appsconda/assets/js/list.js');
    }
}
