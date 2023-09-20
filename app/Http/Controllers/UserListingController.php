<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UserListingController\StoreRequest;
use App\Models\UserListing;
// use Inertia\Response;

class UserListingController extends Controller
{
    public function store(StoreRequest $request)
    {
        $validated_data = $request->validated();

        // $user_id = auth()->id();    //  TODO: Uncomment this when integrating in Web and Inertia
        $user_id = 2;

        try {

            foreach ($validated_data['listings'] as $listing_id) {

                $new_listing = new UserListing;
                $new_listing->user_id = $user_id;
                $new_listing->listing_id = $listing_id;
                $new_listing->save();
            }

        } catch (\Exception $e) {
           
            dd($e->getMessage());   // Do proper exception throwing
        }
        
       

        return 'Done';
    }
}
