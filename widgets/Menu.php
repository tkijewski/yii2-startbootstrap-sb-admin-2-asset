<?php
namespace hoaaah\sbadmin2\widgets;

use Yii;
use yii\bootstrap4\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Html;

/**
 * Class Menu
 * Theme menu widget.
 * todo next visibility, linkOptions, headerSubMenu
 */

class Menu extends Widget
{
    
    public $activateParents = true;
    public $defaultIconHtml = '<i class="fa fa-circle-o"></i> ';
    // public $options = ['class' => 'sidebar-menu', 'data-widget' => 'tree'];

    /**
     * @var string is prefix that will be added to $item['icon'] if it exist.
     * By default uses for Font Awesome (http://fontawesome.io/)
     */
    public static $iconClassPrefix = 'fa fa-';

    private $noDefaultAction;
    private $noDefaultRoute;

    
    /**
     * @inheritdoc
     * Styles all labels of items on sidebar by AdminLTE
     */
    public $options;
    public $items;
    public $brand;
    
    public $ulClass = "navbar-nav bg-gradient-primary sidebar sidebar-dark accordion";
    public $ulId = "accordionSidebar";
    public $liClass = "nav-item";
    public $brandTemplate = '
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{url}">
            <div class="sidebar-brand-text mx-3">{appName}</div>
        </a>    
    ';
    public $defaultBrand = '
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{url}">
        <div class="sidebar-brand-icon rotate-n-15">
        <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">{appName}</div>
    </a>        
    ';
    public $activeClass = "active";
    public $labelTemplate = '<span>{label}</span>';
    public $dividerTemplate = '<hr class="sidebar-divider">';
    public $sidebarHeadingTemplate = '<div class="sidebar-heading">{label}</div>';
    public $menuTemplate = '<li class="{liClass}">{link}</li>';
    public $linkTemplate = '<a class="nav-link" href="{url}"><i class="{icon}"></i> <span>{label}</span></a>'; // not sure label use span or not
    public $iconDefault = "fas fa-circle";
    public $subMenuTemplate = '
        <li class="{liClass}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse{key}" aria-expanded="true" aria-controls="collapse{key}">
                <i class="{icon}"></i>
                <span>{label}</span>
            </a>
            <div id="collapse{key}" class="collapse" aria-labelledby="headingTwo" data-parent="#{ulId}">
                <div class="bg-white py-2 collapse-inner rounded">
                    {header}
                    {link}
                </div>
            </div>
        </li>
    ';
    public $subMenuHeaderTemplate = '<h6 class="collapse-header">{subMenuTitle}</h6>';
    public $subMenuLinkTemplate = '<a class="{subMenuClass}" href="{url}"><i class="{icon}"></i> {label}</a>';
    public $subMenuLinkClass = 'collapse-item';
    public $route;

    
    public function init() {
        parent::init();
        
        // change default value from options
        if($this->options['ulClass']) $this->ulClass = $this->options['ulClass'];
        if($this->options['ulId']) $this->ulId = $this->options['ulId'];

    }


    /**
     * Renders the menu.
     */
    public function run()
    {
        if ($this->route === null && Yii::$app->controller !== null) {
            $this->route = Yii::$app->controller->getRoute();
        }
        // if ($this->params === null) {
        //     $this->params = Yii::$app->request->getQueryParams();
        // }
        $posDefaultAction = strpos($this->route, Yii::$app->controller->action->id);
        if ($posDefaultAction) {
            $this->noDefaultAction = rtrim(substr($this->route, 0, $posDefaultAction), '/');
        } else {
            $this->noDefaultAction = false;
        }
        $posDefaultRoute = strpos($this->route, Yii::$app->controller->module->defaultRoute);
        if ($posDefaultRoute) {
            $this->noDefaultRoute = rtrim(substr($this->route, 0, $posDefaultRoute), '/');
        } else {
            $this->noDefaultRoute = false;
        }
        // $items = $this->normalizeItems($this->items, $hasActiveChild);
        // if (!empty($items)) {
        //     $options = $this->options;
        //     $tag = ArrayHelper::remove($options, 'tag', 'ul');

        //     echo Html::tag($tag, $this->renderItems($items), $options);
        // }


        // ---------bagian heru
        $return = $this->beginWidget();

        if(!$this->items) throw new Exception("This extensions need items param. Please provide it", 1);

        $return .= $this->renderBrand();
        
        foreach ($this->items as $key => $value) {
            if(!isset($value['items'])){
                $return .= $this->renderItem($value);
            }else{
                $return .= $this->renderItems($value, $key);
            }
        }

        $return .= $this->endWidget();

        return $return;
    }
    
    /**
     * Checks whether a menu item is active.
     * This is done by checking if [[route]] and [[params]] match that specified in the `url` option of the menu item.
     * When the `url` option of a menu item is specified in terms of an array, its first element is treated
     * as the route for the item and the rest of the elements are the associated parameters.
     * Only when its route and parameters match [[route]] and [[params]], respectively, will a menu item
     * be considered active.
     * @param array $item the menu item to be checked
     * @return boolean whether the menu item is active
     * I take this function from Menu Widget from https://github.com/dmstr/yii2-adminlte-asset
     */
    protected function isItemActive($item)
    {
        if (isset($item['url']) && is_array($item['url']) && isset($item['url'][0])) {
            $route = $item['url'][0];
            if ($route[0] !== '/' && Yii::$app->controller) {
                $route = ltrim(Yii::$app->controller->module->getUniqueId() . '/' . $route, '/');
            }
            $route = ltrim($route, '/');
            if ($route != $this->route && $route !== $this->noDefaultRoute && $route !== $this->noDefaultAction) {
                return false;
            }
            unset($item['url']['#']);
            if (count($item['url']) > 1) {
                foreach (array_splice($item['url'], 1) as $name => $value) {
                    if ($value !== null && (!isset($this->params[$name]) || $this->params[$name] != $value)) {
                        return false;
                    }
                }
            }
            return true;
        }
        return false;
    }

    protected function beginWidget(){
        $return = "<ul class=\"{$this->ulClass}\" id=\"{$this->ulId}\">";
        return $return;
    }

    protected function endWidget(){
        return "</ul>";
    }

    /**
     * followed by $this->dividerTemplate
     */
    protected function renderBrand(){
        if(!$this->brand){
            return strtr($this->defaultBrand, ['{url}' => Url::to(['/'], true), '{appName}' => Yii::$app->name]).$this->dividerTemplate;
        }

        $brand = $this->brand;
        $url = Url::to($brand['url'] ?? ['/'], true );
        $appName = $brand['content'] ?? Yii::$app->name;

        return strtr($this->brandTemplate, ['{url}' => $url, '{appName}' => $appName]).$this->dividerTemplate;
    }

    protected function renderItem($item){
        if($this->setVisibility($item) === false) return '';

        if(!isset($item['type'])) $item['type'] = 'menu';

        if($item['type'] === 'divider') return $this->dividerTemplate;

        if($item['type'] === 'sidebar') return strtr($this->sidebarHeadingTemplate, '{label}', $item['label']);

        if($item['type'] === 'menu')
        {
            // generate link
            $url = Url::to($item['url'], true);
            $label = $item['label'];
            $icon = $item['icon'] ?? $this->iconDefault;
            $link = strtr($this->linkTemplate, ['{url}' => $url, '{label}' => $label, '{icon}' => $icon]);

            // generate nav-item
            $liClass = $this->liClass;
            // if($this->isItemActive($item)) $liClass .= " {$this->activeClass}";
            
            return strtr($this->menuTemplate, ['{liClass}' => $liClass, '{link}' => $link]);
        }
    }

    protected function renderItems($items, $key){
        if($this->setVisibility($items) === false) return '';

        // return $key."</br>";
        $label = $items['label'];
        $ulId = $this->ulId;
        $subMenuTitle = $items['subMenuTitle'] ?? '';
        $header = $subMenuTitle;
        if(isset($items['subMenuTitle'])) $header = strtr($this->subMenuHeaderTemplate, '{subMenuTitle}', $subMenuTitle);
        $icon = $items['icon'] ?? $this->iconDefault;

        $link = '';

        foreach ($items['items'] as $item) {
            $link .= $this->renderSubItem($item);
        }

        return strtr($this->subMenuTemplate, ['{liClass}' => $this->liClass, '{key}' => $key, '{label}' => $label, 
            '{ulId}' => $ulId, '{header}' => $header, '{link}' => $link, '{icon}' => $icon]);
    }

    protected function renderSubItem($item){
        $subMenuClass = $this->subMenuLinkClass;
        $url = Url::to($item['url'], false);
        $icon = $item['icon'] ?? $this->iconDefault;
        $label = $item['label'];
        // if($this->isItemActive($item)) $subMenuClass .= " {$this->activeClass}";

        if(!$this->setVisibility($item)) return '';

        return strtr($this->subMenuLinkTemplate, ['{subMenuClass}' => $subMenuClass, '{url}' => $url, '{icon}' => $icon, '{label}' => $label]);
    }

    protected function setVisibility($item){
        return $item['visible'] ?? true;
    }

}
