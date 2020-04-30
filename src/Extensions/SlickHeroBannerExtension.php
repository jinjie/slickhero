<?php

/**
 * SlickHeroBannerExtension
 *
 * @package SwiftDevLabs\SlickHero\Extensions
 * @author Kong Jin Jie <jinjie@swiftdev.sg>
 */

namespace SwiftDevLabs\SlickHero\Extensions;

use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use SilverStripe\Forms\ToggleCompositeField;
use SilverStripe\ORM\DataExtension;
use SilverStripe\View\Requirements;
use SwiftDevLabs\SlickHero\Models\Banner;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

class SlickHeroBannerExtension extends DataExtension
{
    private static $db = [
        'UseDefaultTheme' => 'Boolean',
    ];

    private static $has_many = [
        'Banners' => Banner::class,
    ];

    private static $cascade_deletes = [
        'Banners',
    ];

    private static $defaults = [
        'UseDefaultTheme' => true,
    ];

    public function updateCMSFields(FieldList $fields)
    {
        $fields->removeByName('UseDefaultTheme');

        $fields->addFieldsToTab(
            'Root.Banners',
            [
                GridField::create(
                    'Banners',
                    'Banners',
                    $this->owner->Banners(),
                    GridFieldConfig_RecordEditor::create()
                        ->addComponent(new GridFieldOrderableRows())
                ),
                ToggleCompositeField::create(
                    'Settings',
                    _t('SlickHero.Settings', 'Settings'),
                    [
                        CheckboxField::create('UseDefaultTheme')
                            ->setDescription('Check to use the default slick-theme.css'),
                    ]
                )
            ]
        );
    }

    public function getSlickHero()
    {
        Requirements::javascript('silverstripe/admin: thirdparty/jquery/jquery.min.js');
        Requirements::javascript('jinjie/slickhero: client/slickjs/slick.min.js');

        Requirements::css('jinjie/slickhero: client/slickjs/slick.css');

        if ($this->owner->UseDefaultTheme) {
            Requirements::css('jinjie/slickhero: client/slickjs/slick-theme.css');
        }

        Requirements::customScript(
            $this->owner->renderWith('SwiftDevLabs\\SlickHero\\Script')
        );

        return $this->owner->renderWith('SwiftDevLabs\\SlickHero\\SlickHero');
    }

    /**
     * Override to manually override options for slick
     * See https://kenwheeler.github.io/slick/
     * @return [type] [description]
     */
    public function getSlickOptions()
    {
        $options = [
            'arrows' => true,
            'dots'   => true,
        ];

        $this->owner->extend('updateSlickOptions', $options);

        return json_encode($options, JSON_UNESCAPED_SLASHES);
    }
}
