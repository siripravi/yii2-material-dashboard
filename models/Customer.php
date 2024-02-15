<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "customer".
 *
 * @property integer $CUSTOMER_NO
 * @property string $FIRST_NAME
 * @property string $LAST_NAME
 * @property string $ADDRESS1
 * @property string $ADDRESS2
 * @property string $CITY
 * @property string $STATE
 * @property string $ZIP
 * @property string $PHONE1
 * @property string $PHONE2
 * @property string $EMAIL1
 * @property string $EMAIL2
 * @property string $NOTES
 *
 * @property Invoice[] $invoices
 */
class Customer extends \yii\db\ActiveRecord
{
    public $full_address;
	public $contact;
	public $full_name;
	public $customer_name;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'customer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'address1', 'phone1', 'email1'], 'required'],
            [['first_name', 'last_name', 'address1', 'address2', 'city'], 'string', 'max' => 30],
            [['state'], 'string', 'max' => 2],
            [['zip'], 'string', 'max' => 6],
            [['phone1', 'phone2'], 'string', 'max' => 15],
            [['email1', 'email2'], 'string', 'max' => 45],
            [['notes'], 'string', 'max' => 255],
            [['customer_no', 'customer_name', 'first_name', 'last_name', 'address1', 'address2', 'city', 'state', 'zip', 'phone1', 'phone2', 'email1', 'email2', 'notes'],'safe','on'=>'search']
        ];
        
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'customer_no' => 'Customer',
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'address1' => 'address1',
			'address2' => 'address2',
			'city' => 'city',
			'state' => 'state',
			'zip' => 'zip',
			'phone1' => 'phone1',
			'phone2' => 'phone2',
			'email1' => 'email1',
			'email2' => 'email2',
			'notes' => 'Notes',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoices()
    {
        return $this->hasMany(Invoice::className(), ['CUSTOMER_NO' => 'CUSTOMER_NO']);
    }

     /**
     * @return \yii\db\ActiveQuery
     */
    public function getCards()
    {
        return $this->hasMany(CustomerCards::className(), ['customer_no' => 'customer_no']);
    }

    public function getFullName()
	{
		return $this->first_name . ' ' . $this->last_name;
	}

    /**
	 * Suggests a list of existing tags matching the specified keyword.
	 * @param string the keyword to be matched
	 * @param integer maximum number of tags to be returned
	 * @return array list of matching tag names
	 */
	public static function suggestTags($keyword, $limit = 20)
	{
		
		$tags = Customer::find()
		->andFilterWhere(['or',
			['LIKE','first_name',':keyword',[':keyword' => '%' . strtr($keyword, array('%' => '\%', '_' => '\_', '\\' => '\\\\')) . '%']],
			['LIKE','last_name',':keyword',[':keyword' => '%' . strtr($keyword, array('%' => '\%', '_' => '\_', '\\' => '\\\\')) . '%']]
			])			
			->limit($limit)           
			->all();
		
		$names = array();
		foreach ($tags as $tag) {
			$names[] = array(
				'id' => (int) $tag->customer_no,
				'text' => $tag->first_name . " " . $tag->last_name
			);
		}
		return $names;
	}

    protected function renderAddress($data, $row)
	{
		$address = '  
            <address>
            <strong>' . $data->address1 . '</strong><br>' . $data->address1 . ',' . $data->address2 . ' <br>' .
			$data->city . ',' . $data->state . ' ' . $data->zip . '<br>
            <abbr title="Phone">P:</abbr>' . $data->phone1
			. '<abbr title="Phone">P:</abbr>' . $data->phone2 .
			'</address>';

		return $address;
	}
	protected function renderContact($data, $row)
	{

		$contact =
			'<address>
          <strong>' . ucfirst($data->first_name) . ' ' . ucfirst($data->last_name) . '</strong><br>
          <a href="mailto:#">' . $data->email1 . '</a><br>
          <a href="mailto:#">' . $data->email2 . '</a>
        </address>';
		return $contact;
	}

	public function getUserName($id)
	{
		$user = User::findOne($id);
		if (!empty($user))
			return $user->username;
	}

	public function getFullAddress()
	{
		$address = '  
            <address><b>'. $this->fullName.'</b><br>'.
            $this->address1.',' . $this->address2 . ',' . ' <br>' .
			$this->city . ',' . $this->state . '- ' . $this->zip . '<br>
            <abbr title="Phone">P:</abbr>' . $this->phone1
			. '<abbr title="Phone">P:</abbr>' . $this->phone2 .
			'</address>';

		return $address;
	}
    
}
