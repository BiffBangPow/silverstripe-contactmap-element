<?php

namespace BiffBangPow\Element\Extension;

use BiffBangPow\Element\Model\ContactLocation;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use SilverStripe\Forms\HeaderField;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataExtension;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;


class ContactMapElementConfigExtension extends DataExtension
{
    private static $db = [
        'MapsProvider' => 'Varchar',
        'GoogleKey' => 'Varchar',
        'GoogleSecret' => 'Varchar'
    ];

    private $maps_providers = [
        'osm' => 'OpenStreetMap',
        'google' => 'Google Maps'
    ];

    public function updateCMSFields(FieldList $fields)
    {
        parent::updateCMSFields($fields);
        $grid = GridField::create('ContactLocations', 'ContactLocations', ContactLocation::get(),
            GridFieldConfig_RecordEditor::create()->addComponent(new GridFieldOrderableRows()));

        $fields->addFieldsToTab('Root.ContactLocations', [
            $grid,
            LiteralField::create('rule', '<hr>'),
            HeaderField::create('Maps Configuration'),
            DropdownField::create('MapsProvider', 'Maps Provider', $this->maps_providers)
                ->setEmptyString('Please select one:'),
            TextField::create('GoogleKey', 'Google Maps API key')
                ->setDescription('Your key needs to have the static maps API enabled.  It is important that you restrict your API key to the required domains / functions!')
                ->displayIf('MapsProvider')->isEqualTo('google')->end(),
        ]);
    }
}
