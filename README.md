yii2-startbootstrap-sb-admin-2-asset
=====================================
This packages contans an Asset Bundle of [Startbootstrap SB Admin 2](https://github.com/BlackrockDigital/startbootstrap-sb-admin-2) for Yii2.

[Startbootstrap SB Admin 2](https://github.com/BlackrockDigital/startbootstrap-sb-admin-2) is a responsive [Bootstrap 4](http://getbootstrap.com/) created by [Start Bootstrap](http://startbootstrap.com/).

## Preview

[![SB Admin 2 Preview](https://startbootstrap.com/assets/img/screenshots/themes/sb-admin-2.png)](https://blackrockdigital.github.io/startbootstrap-sb-admin-2/)

**[Launch Live Preview](https://blackrockdigital.github.io/startbootstrap-sb-admin-2/)**

Start Bootstrap was created by and is maintained by **[David Miller](http://davidmiller.io/)**, Owner of [Blackrock Digital](http://blackrockdigital.io/).

* https://twitter.com/davidmillerskt
* https://github.com/davidtmiller

Start Bootstrap is based on the [Bootstrap](http://getbootstrap.com/) framework created by [Mark Otto](https://twitter.com/mdo) and [Jacob Thorton](https://twitter.com/fat).

Requirement
------------

This Asset Bundle need Bootstrap 4. Since Yii2 used Bootstrap 3 by default, you must install and change every Bootstrap 3 Asset to Bootstrap 4. You can read this tutorial to migrate to Yii2 Bootstrap 4 :

* English : [How to use a Bootstrap 4 theme with Yii2](https://medium.com/@jsnook_58598/how-to-use-a-bootstrap-4-theme-with-yii2-974a6dcca986)
* Bahasa Indonesia : [Pemrograman Web dengan Yii2 - Menggunakan Bootstrap 4](https://www.belajararief.com/index.php/tulisan/tekno/yii2-series/219-pemrograman-web-dengan-yii2-menggunakan-bootstrap-4)

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
composer require hoaaah/yii2-startbootstrap-sb-admin-2-asset:dev-master
```

or add

```
"hoaaah/yii2-startbootstrap-sb-admin-2-asset": "*"
```

to the require section of your `composer.json` file.


Usage
-----

You can see views-examples folder for example use of this library

Menu Widget
-----

You can use Menu widget in your sidebar. This widget optimize for Startbootstrap SB-Admin 2 template.
This widget, like SB-Admin 2, only support 2 level menu.

You can see example use of this widget in [views-exampale/views/layout/sidebar.php](https://github.com/hoaaah/yii2-startbootstrap-sb-admin-2-asset/blob/master/views-examples/views/layouts/sidebar.php).
```php
use hoaaah\sbadmin2\widgets\Menu;
echo Menu::widget([
    'options' => [
        'ulClass' => "navbar-nav bg-gradient-primary sidebar sidebar-dark accordion",
        'ulId' => "accordionSidebar"
    ], //  optional
    'brand' => [
        'url' => ['/'],
        'content' => <<<HTML
            <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
            </div>
            <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>        
HTML
    ],
    'items' => [
        [
            'label' => 'Menu 1',
            'url' => ['/menu1'], //  Array format of Url to, will be not used if have an items
            'icon' => 'fas fa-fw fa-tachometer-alt', // optional, default to "fa fa-circle-o
            'visible' => true, // optional, default to true
            // 'options' => [
            //     'liClass' => 'nav-item',
            // ] // optional
        ],
        [
            'type' => 'divider', // divider or sidebar, if not set then link menu
            // 'label' => '', // if sidebar we will set this, if divider then no
        ],
        [
            'label' => 'Menu 2',
            // 'icon' => 'fa fa-menu', // optional, default to "fa fa-circle-o
            'visible' => true, // optional, default to true
            // 'subMenuTitle' => 'Menu 2 Item', // optional only when have submenutitle, if not exist will not have subMenuTitle
            'items' => [
                [
                    'label' => 'Menu 2 Sub 1',
                    'url' => ['/menu21'], //  Array format of Url to, will be not used if have an items
                ],
                [
                    'label' => 'Menu 2 Sub 2',
                    'url' => ['/menu22'], //  Array format of Url to, will be not used if have an items
                ],
            ]
        ],

        [
            'label' => 'Menu 3',
            'visible' => true, // optional, default to true
            // 'subMenuTitle' => 'Menu 3 Item', // optional only when have submenutitle, if not exist will not have subMenuTitle
            'items' => [
                [
                    'label' => 'Menu 3 Sub 1',
                    'url' => ['/menu21'], //  Array format of Url to, will be not used if have an items
                ],
                [
                    'label' => 'Menu 3 Sub 2',
                    'url' => ['/menu22'], //  Array format of Url to, will be not used if have an items
                    'linkOptions' => [
                       'onClick' => 'alert("This is onClick")',
                    ]
                ],
            ]
        ],
    ]
]);
```
As you can see in above example, this Widget consist of two primary method.

Method | Explanation
-------|------------
`options` | **Optional** method. in this metod you will set any costumization of this Menu widget. It consist of `ulClass` method and `ulId` method
-- `ulClass` | Set your `<ul>` class of this menu. default to "navbar-nav bg-gradient-primary sidebar sidebar-dark accordion"
-- `ulId` | Set your `<ul>` id of this menu. default to "accordionSidebar"
`items` | **Required** method. You must set this method in your widget. You can set `items` inside this method and it will create sub-menu items. Items and Sub Menu Item method use the same method, except for `type` method.
-- `type` | **Optional** parameter, there are 3 category in this params. They are **menu, divider, and sidebar**. Default value of this params are **menu**
-- `label` | **Required** parameter. This param will give label to your menu
-- `icon` | **Optional** parameter. Will use font-awesome icon, so the value of this param will use fa class. Default to `fas fa-circle`
-- `url` | **Required** parameter. Use Array value, like array on `\yii\helpers\Url::to($array)`. If there are `items` parameter set, `url` will be ignored
-- `visible` | **Optional** paremeter. Determined the visibility of menu. Value of `visible` are boolean. Default to `true`
-- `linkOptions` | **Optional** paremeter. This param use array, give any options param to `a` tag, such as `onClick` or other options in link.

Card Widget
-----

You can use card widget. This widget will create bootstrap card, optimize for this template

Example use of card are like below code
```php
use hoaaah\sbadmin2\widgets\Card;
echo Card::widget([
    'type' => 'cardBorder',
    'label' => 'Label',
    'sLabel' => '1000',
    'icon' => 'fas fa-calendar',
    'options' => [
        'colSizeClass' => 'col-md-3',
        'borderColor' => 'primary',
    ]
]);
```
As you can see in above example, this Widget consist of some method.

Method | Explanation
-------|------------
`type` | **Optional** method. In this method you set type of your card. This widget support this type of card: `cardBorder`, ..... Default value of type is `cardBorder`
`label` | **Required** method. In this method you set primary label of your card
`sLabel` | **Required** method. In this method you set secondary label of your card
`icon` | **Required** method. In this method you set icon of your card
`options` | **options** method. Set options, available options are `colSizeClass`, `borderColor`
-- `colSizeClass` | Set your col-size, value of this method are bootstrap col-size
-- `borderColor` | Set your borderColor, value of this method are bootstrap color



## TODO

Todo Widget
- [x] Menu
- [x] CardBorder
- [x] CardBox
- [ ] HeaderMenu
- [ ] HeaderColor based on Params
- [ ] Etc




## Creator

This asset wrapper was created by and is maintained by **[hoaaah](http://belajararief.com/)**.

* https://twitter.com/hoaaah
* https://github.com/hoaaah
