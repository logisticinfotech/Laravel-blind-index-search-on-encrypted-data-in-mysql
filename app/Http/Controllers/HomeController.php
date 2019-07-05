<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Yajra\Datatables\Datatables;
use App\User;
use ParagonIE\CipherSweet\BlindIndex;
use ParagonIE\CipherSweet\CipherSweet;
use ParagonIE\CipherSweet\EncryptedField;
use ParagonIE\CipherSweet\Backend\FIPSCrypto;
use ParagonIE\CipherSweet\KeyProvider\StringProvider;



class HomeController extends Controller
{
	public function __construct() {
		$provider = new StringProvider(
			'4e1c44f87b4cdf21808762970b356891db180a9dd9850e7baf2a79ff3ab8a2fc'
		);
		$engine = new CipherSweet($provider, new FIPSCrypto());

		$this->ssn = (new EncryptedField($engine, 'card', 'number'))
		// Add a blind index for the card number:
		->addBlindIndex(
			new BlindIndex(
				'card_number_index', 
				[],
				32
			)
		);
    }

	public function index()
	{
		return view('home');
	}

	public function getDatatable(Request $request)
    {
		$cardNumber = $request->get('card_number');

		$result = User::select([
			'id',
			'name',
			'email',
			'created_at'
		]);

		if(isset($cardNumber) && $cardNumber!=''){
			$indexes = $this->ssn->getAllBlindIndexes($cardNumber);

			$result = $result->where('card_number_index',$indexes['card_number_index']);
		}
		$result = $result->get();        
        return Datatables::of($result)->addIndexColumn()->make(true);
	}
	
	public function addUser(Request $request)
    {		
		list ($ciphertext, $indexes) = $this->ssn->prepareForStorage('369-52-4526');
		$res = User::create([
			'name' => 'Tom Cruiz',
			'email' => 'tom@gmail.com',
			'password' => bcrypt('123456'),
			'card_number' => $ciphertext,
			'card_number_index' => $indexes['card_number_index']
		]);
		if($res){
			echo "<pre>"; print_r('User added successfully....'); exit;
		} else {
			echo "<pre>"; print_r('Something went wrong, Try again!'); exit;
		}
		
	}
}
