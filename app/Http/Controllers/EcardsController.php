<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ecards;
use App\Helpers\Encrypt;
use DataTables;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class EcardsController extends Controller
{
    public function getEcard(Request $request)
    {
        $encrypt = new Encrypt;

        if($request->ajax()) {				
			$model = Ecards::orderBy('name', 'asc')->get();
		
            return Datatables::of($model)
			->editColumn('id', function ($model) use ($encrypt){
				return $encrypt->encrypt_decrypt($model->id, 'encrypt');
            })
			->editColumn('qrcode', function($model)
            {
                return view('qrcode', ['qrcodes' => $model->qrcode]);
            })
			->editColumn('action', function($model){
                $encrypt = new Encrypt;

                $encrypted = $encrypt->encrypt_decrypt($model->id, 'encrypt');
                return view('action', ['encrypted' => $encrypted]);
            })
			->make(true);
        }
    }

    public function addEcard()
    {
        $model = new Ecards();

        return view('addEcard', compact('model'));
    }

    public function storeEcard(Request $request)
    {
        $this->validate($request, [            
            'name' 	        => 'required',
            'occupation'    => 'required',
            'company'       => 'required',
            'email'         => 'required|unique:ecards',
            'mobile'        => 'required'
        ]);
		
		$encrypt = new Encrypt;
        $gender = $encrypt->encrypt_decrypt($request->gender, 'decrypt');
		
		$data = array(
            'name' 	        => $request->name,
            'occupation' 	=> $request->occupation,
            'company'       => $request->company,
            'email'         => $request->email,
            'mobile'        => $request->mobile,
            'website'       => $request->website ?? null,
            'qrcode'        => str_replace(' ','_', $request->email).'.svg',
        );
		$model = Ecards::create($data);
		$qrcodePath = public_path('qrcodes/' . str_replace(' ', '_', $request->email) . '.svg');
        QrCode::encoding('UTF-8')
            ->size(400)
            ->generate(
                "BEGIN:VCARD\nVERSION:3.0\nN:{$request->name}\nFN:{$request->name}\nTITLE:{$request->occupation}\nORG:{$request->company}\nURL:{$request->website}\nEMAIL;TYPE=work:{$request->email}\nTEL;TYPE=mobile:{$request->mobile}\nEND:VCARD",
                $qrcodePath
            );
    }

    public function show($id)
    {
        $encrypt = new Encrypt;

        $id_ecard = $encrypt->encrypt_decrypt($id, 'decrypt');

        $data_card = Ecards::where('id', $id_ecard)->first();

        $data['model'] = $data_card;
        return view('detailEcard', $data);
    }

    public function updateEcard(Request $request)
    {
        $this->validate($request, [            
            'name' 	        => 'required',
            'occupation'    => 'required',
            'company'       => 'required',
            'email'         => 'unique:ecards,email,' . $request->cardId . ',id' . ($request->email != $request->old_email ? '' : ',NULL'),
            'mobile'        => 'required'
        ]);

        $data = array(
            'name'          => $request->name,
            'occupation'    => $request->occupation,
            'company'       => $request->company,
            'email'         => $request->email,
            'mobile'        => $request->mobile,
            'website'       => $request->website ?? null,
            'qrcode'        => str_replace(' ','_', $request->email).'.svg'
        );

        Ecards::where('id', $request->cardId)->update($data);

        $qrcodePath = public_path('qrcodes/' . str_replace(' ', '_', $request->email) . '.svg');
        QrCode::encoding('UTF-8')
            ->size(400)
            ->generate(
                "BEGIN:VCARD\nVERSION:3.0\nN:{$request->name}\nFN:{$request->name}\nTITLE:{$request->occupation}\nORG:{$request->company}\nURL:{$request->website}\nEMAIL;TYPE=work:{$request->email}\nTEL;TYPE=mobile:{$request->mobile}\nEND:VCARD",
                $qrcodePath
            );
    }
}
