<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;


use Illuminate\Http\Request;
use App\Models\Listing;

class ListingController extends Controller
{
    public function index() {
       return view('listings.index', [
            'listings' => Listing::latest()->filter(request(['tag', 'search']))
            ->paginate(6)
        ]);
    }
   
    public function show(Listing $listing) {
        return view('listings.show', [
            'listing' => $listing
         ]);
    }

    //show create form
    public function create() {
       return view('listings.create');
    }
      // store listing data
    public function store(Request $request) {
    
        $formFields= $request->validate([
            'user_id' => 'required',
            'title' => 'required',
            'company' => ['required', Rule::unique('listings', 'company')],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required', 
            'description' => 'required'
        ]);

        if($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        //echo "<pre>"; print_r($formFields);exit;

        $formFields['user_id']= auth()->id();

        Listing::create($formFields);

        return redirect('/')->with('message', 'Listing created successfully!');
    }

    public function edit(Listing $listing) {
        return view('listings.edit', ['listing' => $listing]);

    }
      
      //update Listing Data
    public function update(Request $request, Listing $listing) {

        // Make sure logged in user is owner
        if($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized Action');
        }
    
    $formFields= $request->validate([
        'title' => 'required',
        'company' => ['required'], 
        'location' => 'required',
        'website' => 'required',
        'email' => ['required', 'email'],
        'tags' => 'required', 
        'description' => 'required'
    ]);

    if($request->hasFile('logo')) {
        $formFields['logo'] = $request->file('logo')->store('logos', 'public');
    }

    $listing->update($formFields);

    return back()->with('message', 'Listing updated successfully!');

    }

    //delete Listing
    public function destroy(Listing $listing) {
        
        // Make sure logged in user is owner
        if($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized Action');
        }
        
        $listing->delete();
        return redirect('/')->with('message', 'Listing Deleted successfully');
    }
      //manage listing
    public function manage()
    {
        return view('listings.manage', ['listings' =>auth()->user()->listings()->get()]);
    }
}
