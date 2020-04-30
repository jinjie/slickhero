<?php

/**
 * Banner
 *
 * @package SwiftDevLabs\SlickHero\Models
 * @author Kong Jin Jie <jinjie@swiftdev.sg>
 */

namespace SwiftDevLabs\SlickHero\Models;

use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\Image;
use SilverStripe\Core\Config\Configurable;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\ORM\DataObject;

class Banner extends DataObject
{
    private static $table_name = 'SlickHero_Banner';

    private static $folder_name = 'Slick Hero Banners';

    private static $db = [
        'Title'       => 'Varchar(300)',
        'Description' => 'Text',
        'Sort'        => 'Int',
    ];

    private static $has_one = [
        'Image' => Image::class,
        'Parent' => DataObject::class
    ];

    private static $owns = [
        'Image',
    ];

    private static $summary_fields = [
        'Thumbnail',
        'Title',
        'Description',
    ];

    private static $thumbnail_width  = 100;
    private static $thumbnail_height = 100;

    private static $default_sort = 'Sort';

    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function ($fields) {
            $fields->addFieldsToTab(
                'Root.Main',
                [
                    UploadField::create('Image', _t('SlickHero.Image', 'Image'))
                        ->setFolderName($this->config()->get('folder_name'))
                        ->setAllowedFileCategories('image'),
                    TextField::create('Title', _t('SlickHero.Title', 'Title')),
                    TextareaField::create('Description', _t('SlickHero.Description', 'Description')),
                ]
            );
        });

        $fields = parent::getCMSFields();

        $fields->removeByName('Sort');

        return $fields;
    }

    public function getThumbnail()
    {
        return $this->Image()->Pad(
            $this->config()->get('thumbnail_width'),
            $this->config()->get('thumbnail_height')
        );
    }

    public function onBeforeWrite()
    {
        parent::onBeforeWrite();

        if (! $this->Sort) {
            $this->Sort = self::get()->max('Sort') + 1;
        }
    }
}
