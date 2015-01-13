<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\customer\Customer;
use app\models\customer\CustomerRecord;
use app\models\customer\PhoneRecord;
use app\models\customer\Phone;
use yii\data\ArrayDataProvider;

class CustomersController extends Controller
{
	
	public function actionIndex()
	{
		$records = $this->findRecordsByQuery();
		$this->render('index', compact('records'));
	}
	
	private function store(Customer $customer)
	{
		$cr = new CustomerRecord();
		$cr->name = $customer->name;
		$cr->birth_date = $customer->birth_date->format('Y-m-d');
		$cr->notes = $customer->notes;
		
		$cr->save();
		
		foreach ($customer->phones as $phone)
		{
			$pr = new PhoneRecord();
			$pr->number = $phone->number;
			$pr->customer_id = $cr->id;
			
			$pr->save();
		}
		
	}
	
	private function load(CustomerRecord $cr, PhoneRecord $pr, array $post)
	{
		return $cr->load($post) and $pr->load($post) and $cr->validate() and $pr->validate(['numbers']);
	}
	
	private function makeCustomer(CustomerRecord $cr,
								  PhoneRecord $pr)
	{
		$name = $cr->name;
		$birth_date = new \DateTime($cr->birth_date);
		
		$customer = new Customer($name, $birth_date);
		$customer->notes = $cr->notes;
		$customer->phones[] = new Phone($pr->number);
		
		return $customer;
	}
	
	public function actionAdd()
	{
		$customer = new CustomerRecord;
		$phone = new PhoneRecord;
		if($this->load($customer, $phone, $_POST))
		{
			$this->store($this->makeCustomer($customer, $phone));
			return $this->redirect('/customers');
		}
		return $this->render('add', compact('customer', 'phone'));
	}
	
	private function findRecordsByQuery()
	{
		$number = Yii::$app->request->get('phone_number');
		$records = $this->getRecordsByPhoneNumber($number);
		$dataprovider = $this->wrapIntoDataProvider($records);
		return $dataprovider;
	}
	
	private function wrapIntoDataProvider($data)
	{
		return new ArrayDataProvider([
				'allModels' => $data,
				'pagination' => false
		]);
	}
	
	private function getRecordsByPhoneNumber($number)
	{
		$pr = PhoneRecord::findOne(['number' => $number]);
		if (!$pr)
			return [];
		
		$cr = CustomerRecord::findOne($pr->customer_id);
		if(!$cr)
			return [];
		return [$this->makeCustomer($cr, $pr)];
	}
	
	public function actionQuery()
	{
		return $this->render('query');
	}
}