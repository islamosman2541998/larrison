<?php


namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\Site\ContactUSRequest;
use Illuminate\Http\Request;
use App\Models\Contactus;
use Illuminate\Support\Facades\Auth;

class ContactUsController extends Controller
{

    public function index()
    {
        return view('site.pages.contact-us');
    }

    public function store(ContactUSRequest $request)
    {
      
      $data = $request->getSanitized();

        Contactus::create($data);

        // Editable from: Dashboard > Settings > Page sections > Contact page
        return redirect()->back()->with('success', page_text('contact.form.success'));
    }
}