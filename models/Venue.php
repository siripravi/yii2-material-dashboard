<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "venue".
 *
 * @property integer $venue_id
 * @property string $ship_name
 * @property string $ship_add1
 * @property string $ship_add2
 * @property string $ship_city
 * @property string $ship_state
 * @property string $ship_zip
 * @property string $ship_phone1
 * @property string $ship_phone2
 * @property string $ship_email1
 * @property string $ship_details
 */
class Venue extends \yii\db\ActiveRecord
{
    public $full_address;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'venue';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ship_name', 'ship_add1', 'ship_add2', 'ship_city'], 'string', 'max' => 30],
            [['ship_state'], 'string', 'max' => 2],
            [['ship_zip'], 'string', 'max' => 6],
            [['ship_phone1', 'ship_phone2'], 'string', 'max' => 15],
            [['ship_email1'], 'string', 'max' => 45],
            [['ship_details'], 'string', 'max' => 255]
        ];
    }

    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'venue_id' => 'Venue  ID',
            'ship_name' => 'Ship  Name',
            'ship_add1' => 'Ship  Add1',
            'ship_add2' => 'Ship  Add2',
            'ship_city' => 'Ship  City',
            'ship_state' => 'Ship  State',
            'ship_zip' => 'Ship  Zip',
            'ship_phone1' => 'Ship  Phone1',
            'ship_phone2' => 'Ship  Phone2',
            'ship_email1' => 'Ship  Email1',
            'ship_details' => 'Ship  Details',
        ];
    }

    public function getFullAddress()
	{
		$address = '  
            <address><b>'. $this->ship_name.'</b><br>'.
            $this->ship_add1.'<br>' . $this->ship_add2 . ',' . 
			$this->ship_city . ',' . $this->ship_state . ' - ' . $this->ship_zip . '<br>
            <abbr title="Phone">P:</abbr>' . $this->ship_phone1
			. '<abbr title="Phone">P:</abbr>' . $this->ship_phone2 .
			'</address>';

		return $address;
	}
}
