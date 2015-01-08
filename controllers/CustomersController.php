<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\customer\Customer;
use app\models\customer\CustomerRecord;
use app\models\customer\PhoneRecord;
use app\models\customer\Phone;

class CustomersController extends Controller
{
	
	public function actionIndex()
	{
		$records = $this->getRecordsAccordingToQuery();
		$this->render('index', compact($records));
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
		$this->render('add');
	}
}