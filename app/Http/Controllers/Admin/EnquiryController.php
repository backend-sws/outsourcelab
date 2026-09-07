<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ContactEnquiry;

class EnquiryController extends Controller
{
    public function index()
    {
        $enquiries = ContactEnquiry::latest()->paginate(15);
        return view('admin.enquiries.index', compact('enquiries'));
    }

    public function show(int $id)
    {
        $enquiry = ContactEnquiry::findOrFail($id);
        if ($enquiry->status == 'Unread') {
            $enquiry->status = 'Read';
            $enquiry->save();
        }
        return view('admin.enquiries.show', compact('enquiry'));
    }
}
